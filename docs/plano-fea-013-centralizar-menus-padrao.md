# FEA-013 — Centralizar lista de "menus padrão" de novos admins

**Status:** rascunho de plano (aguardando aprovação)
**Data:** 2026-05-22
**Esforço estimado:** ~½ dia (3-4 horas)
**Dependências:** nenhuma
**Bloqueia:** FEA-009 (RPA) — sem centralizar, os 2 menus novos (Folha > Autônomos, Folha > RPA) precisariam ser editados em 5 lugares com risco de esquecer um

---

## 1. Contexto

O array de **26 IDs de menu** que define o conjunto de telas liberadas por padrão para qualquer admin recém-criado está **hardcoded em 5 lugares diferentes**:

| # | Arquivo | Linha | Forma |
|---|---|---|---|
| 1 | `master/adicionar_permissao.php` | 33 | `$menus_padrao = [1, 2, 3, 4, ...]` (sincronização de permissões faltantes) |
| 2 | `master/alterar_usuario.php` | 1133 | `$menus_padrao_acesso = [1, 2, 3, 4, ...]` (vinculação de empresa nova ao usuário) |
| 3 | `master/controller/adicionar_novo_usuario_post.php` | 111 | array literal embutido (criação direta de novo usuário) |
| 4 | `master/iuds_pdo.php` | 5730 — função `updateGESMPR_menus` | `VALUES (...)` em INSERT batch com 26 linhas |
| 5 | `admin/iuds_pdo.php` | 11555 — função `updateGESMPR_menus` (réplica) | idem ao item 4 (adicionada na FEA-010 para o admin poder vincular empresa nova) |

**Já houve esquecimento histórico:** commit `311c2a7` corrigiu o `id_mnu=58` que tinha sido esquecido em um dos pontos durante a FEA-008.

**Próximo risco real:** a FEA-009 (RPA) vai adicionar 2 novos menus (Folha > Autônomos e Folha > RPA). Sem centralizar, são 5 edições x 2 menus = 10 pontos manuais com risco de inconsistência.

---

## 2. Objetivo

Substituir os 5 pontos hardcoded por **uma única fonte da verdade** que todos consultem, mantendo comportamento idêntico.

---

## 3. Estratégia

Criar uma constante PHP em `config/permissions.php` (segue o padrão de `config/database.php`, `config/mail.php`, `config/storage.php` já presentes).

**Por que constante PHP e não tabela GESMNU_PADRAO?**
- Refactor mínimo, zero risco de migração
- Lista evolui junto com o código (cada FEA que adiciona menu também edita a constante — visível no diff)
- Tabela traria custo de migration + leitura no banco em todo cadastro de admin, sem ganho real
- Caso futuro queira-se tornar configurável por tenant, abre-se uma FEA específica depois

---

## 4. Escopo

### 4.1 Criar `config/permissions.php`

Arquivo novo com:

```php
<?php
/**
 * Lista de id_mnu liberados por padrão para qualquer admin recém-criado.
 *
 * Quando uma FEA adiciona uma nova tela cujo acesso deve fazer parte do
 * "kit básico" de admins, adicione o id_mnu correspondente aqui.
 */
const MENUS_PADRAO_NOVOS_ADMINS = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
    15, 16, 17, 20, 21, 22, 23, 31, 32, 33, 37, 57, 58,
];
```

Sem outras funções — apenas a constante. Mantém-se simples.

### 4.2 Refatorar os 5 pontos

| # | Arquivo | Alteração |
|---|---|---|
| 1 | `master/adicionar_permissao.php:33` | substituir `$menus_padrao = [...]` por `require_once __DIR__.'/../config/permissions.php';` e usar `MENUS_PADRAO_NOVOS_ADMINS` |
| 2 | `master/alterar_usuario.php:1133` | substituir `$menus_padrao_acesso = [...]` por `require_once + uso da constante` |
| 3 | `master/controller/adicionar_novo_usuario_post.php:111` | substituir array literal embutido pela constante |
| 4 | `master/iuds_pdo.php` (`updateGESMPR_menus`) | reescrever para construir VALUES dinamicamente a partir da constante (vai virar `foreach (MENUS_PADRAO_NOVOS_ADMINS as $id_mnu) { ... }` com `executeMany` ou loop de prepared statements). Comportamento idêntico ao INSERT batch atual. |
| 5 | `admin/iuds_pdo.php` (`updateGESMPR_menus`) | idem ao item 4 |

### 4.3 Documentar

- Atualizar `docs/pendencias.md` removendo o item "Débito técnico nº 1" e referenciando esta FEA na seção de "concluídos" (se houver) ou simplesmente removendo
- Atualizar comentário no topo de `config/permissions.php` lembrando que a constante deve ser atualizada quando novas telas forem adicionadas
- Inclusão em CLAUDE.md (seção "Configs centralizados (config/)"): adicionar linha do `permissions.php`

---

## 5. Não-escopo

- Tabela `GESMNU_PADRAO` em PostgreSQL (avaliar só se vier necessidade de configurar por tenant)
- Mudar a interface de `updateGESMPR_menus` (continua recebendo `$id_usa, $id_emp, $datatu`)
- Tocar nos menus específicos do **Líder RH** (`upsertGESMPR_lider_menus` com id_mnu 34+36 — função separada, escopo diferente)
- Reorganizar nomenclatura de funções (DAL continua igual)

---

## 6. Validação funcional

Cenários a testar localmente:

1. **Criar admin novo via `/master/adicionar_novo_usuario`** → verificar GESMPR populado com os mesmos 26 menus + `situac=1`. Comparar contagem com o estado atual (`SELECT COUNT(*) FROM GESMPR WHERE id_usa=X AND id_emp=Y`).
2. **Vincular admin existente a nova empresa via `/master/alterar_usuario`** → verificar GESMPR populado com 26 menus na nova empresa
3. **Rodar `adicionar_permissao` para usuário com algum menu faltando** → sincroniza só os faltantes (não duplica)
4. **Vincular nova empresa via fluxo de admin (FEA-010)** → admin consegue dar acesso e GESMPR fica certo

Critério de sucesso: **diff zero** no banco entre cenários "antes" e "depois" do refactor.

---

## 7. Riscos

| Risco | Mitigação |
|---|---|
| Algum dos 5 pontos hoje tem um id_mnu **diferente** dos outros 4 (deriva) | Rodar grep antes do refactor, comparar as 5 listas. Se houver divergência, anotar e perguntar ao Yuri qual é a "verdade" antes de uniformizar |
| Função `updateGESMPR_menus` atual usa `INSERT ... VALUES (...),(...),(...)` batch com 26 linhas — performático. Loop pode ficar mais lento | Construir dinamicamente o `VALUES (...),(...),(...)` em PHP a partir da constante: `implode(',', array_map(...))`. Resultado: 1 prepared statement com mesmo número de bindings |
| `require_once` em arquivos de `master/controller/` precisa ajustar path relativo | Padrão já existente no projeto: `require_once __DIR__.'/../../config/permissions.php'` |

---

## 8. Sequência de entrega

1. **Auditoria** (~20 min): grep dos 5 lugares, comparar listas, confirmar se há divergência
2. **Criar `config/permissions.php`** (~10 min)
3. **Refactor dos 5 pontos** (~1h30):
   - 3 arquivos com `$menus_padrao = [...]` viram `require + constante`
   - 2 funções `updateGESMPR_menus` (master + admin) reescritas com VALUES dinâmico
4. **Validação local** (~1h): cenários 1-4 da seção 6
5. **Atualizar docs** (~15 min): `pendencias.md`, `CLAUDE.md`
6. **Commit + deploy** (~15 min)

Total: ~3-4 horas

---

## 9. Critérios de aceite

- [ ] Arquivo `config/permissions.php` criado com constante `MENUS_PADRAO_NOVOS_ADMINS`
- [ ] `master/adicionar_permissao.php`, `master/alterar_usuario.php` e `master/controller/adicionar_novo_usuario_post.php` consomem a constante (não há mais array literal local)
- [ ] `master/iuds_pdo.php::updateGESMPR_menus` e `admin/iuds_pdo.php::updateGESMPR_menus` constroem o INSERT dinamicamente a partir da constante
- [ ] Cadastrar admin novo gera os mesmos 26 registros em GESMPR de antes do refactor (diff zero)
- [ ] Vincular admin a nova empresa gera os mesmos 26 registros de antes
- [ ] Item "Débito técnico nº 1" removido de `docs/pendencias.md`
- [ ] `config/permissions.php` referenciado em `CLAUDE.md` (seção "Configs centralizados")
- [ ] Deploy em prod sem regressão (smoke test: criar 1 admin de teste, verificar acesso)

---

## 10. Arquivos previstos para alteração

- `config/permissions.php` — **novo**
- `master/adicionar_permissao.php` — substituir `$menus_padrao`
- `master/alterar_usuario.php` — substituir `$menus_padrao_acesso`
- `master/controller/adicionar_novo_usuario_post.php` — substituir array literal
- `master/iuds_pdo.php` — refatorar `updateGESMPR_menus`
- `admin/iuds_pdo.php` — refatorar `updateGESMPR_menus`
- `docs/pendencias.md` — remover débito técnico nº 1
- `CLAUDE.md` — adicionar `permissions.php` na tabela de configs
- `prd.json` — entrada FEA-013

---

## 11. Observações

- **Esta FEA destrava a FEA-009 (RPA)**. Recomendado entregar antes para evitar repetir o problema com os 2 menus novos (Folha > Autônomos, Folha > RPA)
- O id_mnu **34** (relatórios) e **36** (admins) **NÃO entram** nesta constante — eles são exclusivos do Líder RH e ficam em `upsertGESMPR_lider_menus`, função separada
- Esforço pequeno, refactor isolado, baixo risco. Bom candidato para uma sessão única
