# FEA-013 — Centralizar lista de "menus padrão" de novos admins

**Status:** aprovado após auditoria minuciosa em 2026-05-24 — pronto para execução
**Data:** 2026-05-22 (plano), 2026-05-24 (revisão + aprovação)
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

Criar uma **constante PHP** (`const`, não variável global) em `config/permissions.php`.

**Por que `const` em vez de variável global (padrão dos outros configs)?**

Os configs existentes (`database.php`, `mail.php`, `app.php`) usam variáveis globais (`$pdo`, `$conn`, `$app_url`) ou funções (`configureMailer`). Para a lista de menus, prefiro `const`:

- Variável global precisaria de `global $menus_padrao;` dentro de cada função que usa — burocracia
- `const` resolve em compile-time, é imutável e acessível em **qualquer escopo** (inclusive dentro de `updateGESMPR_menus`)
- `const` em arquivo top-level funciona em PHP 7.4 (suporta arrays desde 5.6)
- Não é "config de ambiente" — é constante de domínio. `const` é o tipo correto

**Por que constante PHP e não tabela `GESMNU_PADRAO`?**
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

| # | Arquivo | Nível | Path do require | Alteração |
|---|---|---|---|---|
| 1 | `master/adicionar_permissao.php:33` | 1 | `__DIR__.'/../config/permissions.php'` | substituir `$menus_padrao = [...]` por `require_once + uso de MENUS_PADRAO_NOVOS_ADMINS` |
| 2 | `master/alterar_usuario.php:1133` | 1 | `__DIR__.'/../config/permissions.php'` | substituir `$menus_padrao_acesso = [...]` por `require_once + uso da constante` |
| 3 | `master/controller/adicionar_novo_usuario_post.php:111` | 2 | `__DIR__.'/../../config/permissions.php'` | substituir array literal embutido pela constante |
| 4 | `master/iuds_pdo.php` (`updateGESMPR_menus`, linha 5730) | 1 | `__DIR__.'/../config/permissions.php'` | reescrever para construir VALUES dinamicamente a partir da constante. **Preservar** `ON CONFLICT (id_usa, id_emp, id_mnu) DO NOTHING` e `situac=1` hardcoded |
| 5 | `admin/iuds_pdo.php` (`updateGESMPR_menus`, linha 11555) | 1 | `__DIR__.'/../config/permissions.php'` | idem ao item 4 |

**Padrão de construção dinâmica do VALUES** (itens 4 e 5):

```php
require_once __DIR__.'/../config/permissions.php';

function updateGESMPR_menus($id_usa, $id_emp, $datatu) {
    global $pdo;

    // Monta VALUES dinamicamente a partir da constante
    $valores = [];
    foreach (MENUS_PADRAO_NOVOS_ADMINS as $id_mnu) {
        $valores[] = "(:id_usa, :id_emp, $id_mnu, :datatu, 1)";
    }
    $query = 'INSERT INTO public."GESMPR" (id_usa, id_emp, id_mnu, datatu, situac)
              VALUES ' . implode(',', $valores) . '
              ON CONFLICT (id_usa, id_emp, id_mnu) DO NOTHING';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}
```

`$id_mnu` é inteiro de fonte confiável (constante hardcoded no código), pode ser interpolado direto na string sem risco de injection. Os 3 params dinâmicos (`id_usa`, `id_emp`, `datatu`) continuam via bindParam.

### 4.3 Comportamento preservado — pontos sutis

- **`ON CONFLICT DO NOTHING`** mantido em ambas as funções. **Não atualiza** `situac` se já existe registro com `id_mnu` na mesma `(id_usa, id_emp)`. Refactor **não "ativa"** menus já desabilitados (situac=0) no banco — é o comportamento atual, esperado pelo Yuri.
- **Ordem dos IDs** muda ligeiramente nos itens 4 e 5 (de "ordem histórica" 1-7,16,8-13,20,23,21,22,37,15,17,31-33,57,58 → ordem crescente da constante). Sem impacto: INSERT é insensível à ordem e ON CONFLICT garante idempotência.
- **`situac=1`** hardcoded continua aplicado a todos os 26 IDs (idêntico ao atual).
- **Assinatura `updateGESMPR_menus($id_usa, $id_emp, $datatu)`** preservada — 3 call sites externos não precisam mudar (ver seção 4.4).

### 4.4 Call sites da função (não alteram, mas catalogados)

`updateGESMPR_menus` é chamada em 3 lugares **fora** das duas definições. Assinatura preservada → zero impacto:

- `admin/cadastro_usuario.php:774` — admin cria usuário novo na empresa atual (FEA-010)
- `master/controller/alterar_aprovacao_post.php:268` — quando uma empresa é aprovada
- `master/controller/usuarios_master_post.php:514` — **chamada comentada**, ignorar

### 4.5 Documentar

- `docs/pendencias.md` — débito técnico nº 1 já redirecionado para esta FEA (commit anterior). Após entrega, podemos remover o item de vez (decisão pós-deploy).
- Comentário no topo de `config/permissions.php` lembrando que a constante deve ser atualizada quando novas telas forem adicionadas ao kit padrão
- `CLAUDE.md` seção "Configs centralizados (config/)": adicionar linha do `permissions.php`

---

## 5. Não-escopo

- Tabela `GESMNU_PADRAO` em PostgreSQL (avaliar só se vier necessidade de configurar por tenant)
- Mudar a interface de `updateGESMPR_menus` (continua recebendo `$id_usa, $id_emp, $datatu`)
- Tocar nos menus específicos do **Líder RH** (`upsertGESMPR_lider_menus` com id_mnu 34+36 — função separada, escopo diferente)
- Reorganizar nomenclatura de funções (DAL continua igual)
- **Lista `$menus_suporte` em `master/controller/alterar_aprovacao_post.php:278`** (24 IDs, faltam 57 e 58) — descoberta na auditoria de 2026-05-24. **Semântica diferente**: define o que usuários internos da Leve (Yuri id=1, suporte id=39) ganham acesso quando uma empresa é aprovada (não é o "kit do admin do cliente"). Pode virar futura constante `MENUS_SUPORTE_INTERNO_LEVE` em FEA dedicada — não urgente, não bloqueia FEA-009

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

| Risco | Status após auditoria 2026-05-24 |
|---|---|
| Algum dos 5 pontos hoje tem um id_mnu **diferente** dos outros 4 (deriva) | ✅ **Verificado**: 5 listas idênticas em conteúdo (26 IDs), diferença só de ordem (sem impacto) |
| Função `updateGESMPR_menus` atual usa `INSERT ... VALUES (...),(...),(...)` batch com 26 linhas — performático. Loop pode ficar mais lento | ✅ **Mitigado**: padrão de implementação (seção 4.2) constrói `VALUES (...),(...),(...)` dinamicamente em uma string e executa em 1 prepared statement (mesma performance) |
| `require_once` em arquivos de `master/controller/` precisa ajustar path relativo | ✅ **Confirmado**: 1 nível pra `master/`, `master/iuds_pdo.php`, `admin/iuds_pdo.php`; 2 níveis pra `master/controller/` |
| Existe outro lugar com lista similar de menus não mapeado | ⚠️ **Achado**: 6º lugar (`$menus_suporte` em `alterar_aprovacao_post:278`) mas com semântica diferente — fora do escopo (ver seção 5) |
| Refactor pode "ativar" menus desabilitados (`situac=0`) por engano | ✅ **Comportamento preservado**: `ON CONFLICT DO NOTHING` mantido — refactor não toca em registros existentes |

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
