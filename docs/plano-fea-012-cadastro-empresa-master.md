# FEA-012 — Cadastro manual de empresa no /master/

**Status:** rascunho de plano (aguardando aprovação)
**Data:** 2026-05-22
**Esforço estimado:** 1-2 dias
**Dependências:** nenhuma (independente da FEA-009/RPA)

---

## 1. Contexto e motivação

As últimas empresas do Gestou foram cadastradas via SQL direto no banco, deixando campos NULL e gerando problemas reativos resolvidos depois.

**Causa raiz mapeada nesta sessão:**

- O `/master/tabela_empresas.php` (página "Permissão > Empresas") **não tem porta de entrada manual** para cadastrar uma empresa nova. Os únicos botões são:
  - "Adicionar Grupo" (cria nova empresa já vinculada a um grupo via `insertGESEMP_NOVA_GRUPO`)
  - "Adicionar Filial" (cria filial de uma matriz existente)
  - "Voltar"
- O fluxo de aprovação de leads (`aprovacao.php` → `alterar_aprovacao.php`) continua funcionando para empresas que chegam pelo auto-registro da landing page (`/createaccount/`).
- Existe um `cadastro_empresa.php` legado, **mas está órfão** (só era linkado pelo `tabela_empresas_antigo.php`) e o controller dele tem bugs estruturais:
  - Lê `$_POST['cnpj']` mas o form envia `name="CNPJ"` (uppercase) → validação falha silenciosamente
  - Lê `$_POST['resp_rh']` e `$_POST['resp_ouvidoria']` que **não existem no form**
  - Usa `$datinc`, `$datatu`, `$id_mas_default` sem nunca declarar
  - Cria diretórios via `mkdir` em `../upload/...` — em prod o bucket é gcsfuse, falha silenciosamente
  - Cobre só 3 abas (~20 campos), sem `id_emp_grupo`, gestores, limites, integrações completas

Por isso o operador foi pelo SQL.

---

## 2. Objetivo

Disponibilizar uma porta de entrada manual no `/master/` para cadastrar empresa nova com:

- Cobertura **completa** dos campos (35+) numa única tela
- Opção de **criar grupo novo** ou **vincular a grupo existente** no momento do cadastro
- Reaproveitamento da UI já estável de `alterar_empresa.php` (5 abas)
- Sem regressão no fluxo de aprovação de leads

---

## 3. Estratégia: reusar `alterar_empresa.php` em modo "novo"

Em vez de consertar o `cadastro_empresa.php` legado (que não cobre nem 60% dos campos), **adicionar modo "novo" ao `alterar_empresa.php`**, que já cobre os 5 grupos (Identificação, Endereço, Integração, Gestor, Limites) e tem submit via AJAX já funcionando com validações da FEA-010.

### Vantagens
- Uma única fonte da verdade para cadastro e edição
- Aproveita 100% do código já estável
- Elimina dupla manutenção (legado + atual)
- Reduz superfície de bug

### Trade-off
- O controller `alterar_empresa_post.php` (497 linhas) precisa de um branch novo para suportar INSERT
- Alguns campos hoje `disabled` em modo edição (CNPJ, tipo M/F) precisam ficar editáveis no modo novo

---

## 4. Escopo

### 4.1 Botão "Incluir Empresa" em `tabela_empresas.php`

- Adicionar botão entre "Adicionar Grupo" e "Adicionar Filial" na seção `.button-tabela` (linha ~96)
- Sempre habilitado (não depende de seleção, diferente dos botões Grupo/Filial)
- Aponta para `alterar_empresa?al=novo`
- Ícone `fas fa-plus-circle` mantendo padrão visual

### 4.2 `alterar_empresa.php` em modo "novo"

- Detectar `$_GET['al'] === 'novo'` no topo do arquivo
- Setar `$_SESSION["tabela_empresas"]["id_emp_editar"] = null` e flag de modo (`$_SESSION["alterar_empresa"]["modo"] = "novo"`)
- Inicializar todas as variáveis exibidas no form com defaults vazios em vez de buscar via `select_VW_EMPRESAMASTER`
- Habilitar campos hoje `disabled`:
  - CNPJ (input `<input id="CNPJ" disabled>` na linha 247 — remover atributo em modo novo)
  - Tipo M/F (`<select id="tipo" disabled>` na linha 252 — remover atributo em modo novo)
- Esconder aba Gestor (não faz sentido cadastrar líderes em empresa que ainda não existe)
- Mostrar aba Limites com defaults editáveis (`limite_lideres=2`, `limite_admins_ativos=NULL/vazio`)
- Campos `id_emp_h/p/i`, `tipo_h/p/i`, `lay_h/p/i` ficam **opcionais** no insert (sem atributo `required`) — admin completa configuração de integração depois, na edição

### 4.3 `id_emp_grupo` — select dinâmico com opção "criar novo"

Hoje o input é texto livre que aceita só dígitos (`alterar_empresa.php:519`). No modo novo, substituir por **3 opções**:

1. **Sem grupo** (`<option value="">` — default)
2. **Vincular a grupo existente** → select carregado com empresas `tipo='M'` (matrizes) que poderiam ser cabeça do grupo. Opções: `<option value="{id_emp}">{nome_fantasia} ({cnpj})</option>`
3. **Criar novo grupo (esta empresa será a matriz)** → flag no payload. Após o INSERT da empresa, executa `UPDATE GESEMP SET id_emp_grupo = id_emp WHERE id_emp = <novo>` (auto-referência).

Em modo edição, manter o input atual (sem regressão).

### 4.4 `controller/alterar_empresa_post.php` — branch INSERT no `btn_adicionar`

Estrutura atual do branch `btn_adicionar` (linha 247–471):
- Lê `$id_emp` da sessão
- Se vazio → retorna erro
- Senão → faz UPDATE em GESEMP + GESLAY + limites

Nova estrutura:
- Lê `$id_emp` e `$modo` da sessão
- Se `$modo === "novo"`:
  1. Validar CNPJ (formato + unicidade via select de checagem)
  2. Validar `tipo ∈ {M, F}`
  3. Chamar `insertGESEMP_MASTER` (função já existe, cobre 25 campos)
  4. Capturar o novo `id_emp` do retorno (`$insertGESEMP_MASTER['pk']`)
  5. `insertGESLAY($id_emp, 'VIS', 'VIS', 'VIS')` se valores não foram informados; senão usar valores do form
  6. `updateGESEMP_limites($id_emp, $limite_lideres, $limite_admins_ativos, $datatu, $id_usa)` com defaults se omitidos
  7. Se "criar novo grupo": `UPDATE GESEMP SET id_emp_grupo = id_emp WHERE id_emp = $id_emp` (auto-FK)
  8. `upsertGESMPR_lider_menus($id_emp, ...)` — alinhar com padrão FEA-010
  9. Setar `$_SESSION["tabela_empresas"]["id_emp_editar"] = $id_emp` e limpar `$_SESSION["alterar_empresa"]["modo"]`
  10. Retornar JSON `{status: "sucesso", mensagem: "Empresa criada", id_emp: $id_emp}`
- Senão (modo edição): comportamento atual (UPDATE)

### 4.5 `alterar_empresa.js` — tratamento pós-insert

Após resposta `{status: "sucesso", id_emp: X}` em modo novo:
- Mostrar toast "Empresa criada! Configure gestores na aba Gestor."
- Recarregar página com `window.location.href = "alterar_empresa?al=" + id_emp` (modo edição completo)
- Aba Gestor aparece, demais campos já preenchidos

---

## 5. Não-escopo

- Correção de empresas já cadastradas com campos NULL (fica para FEA futura ou script de manutenção dedicado)
- Refatorar o fluxo de aprovação de leads (`aprovacao.php` + `alterar_aprovacao.php`)
- Deletar `cadastro_empresa.php`, `cadastro_empresa_post.php` e `tabela_empresas_antigo.php` (cleanup posterior, sem urgência)
- Cadastro em massa / importação por CSV
- Validação de CNPJ via API externa (Receita Federal etc.) — só formato + unicidade local

---

## 6. Validações funcionais

| Campo | Regra | Onde |
|---|---|---|
| `nome` | obrigatório, ≥ 3 chars | client + server |
| `nomefantasia` | obrigatório, ≥ 3 chars | client + server |
| `cnpj` | obrigatório, formato `XX.XXX.XXX/XXXX-XX`, único na GESEMP | client + server |
| `tipo` | obrigatório, ∈ {M, F} | client + server |
| `id_mun` (estado+cidade) | obrigatório | client + server |
| `id_per_imp`, `id_per_ace` | obrigatórios | client + server |
| `limite_lideres` | ≥ 1, default 2 | server |
| `limite_admins_ativos` | ≥ 1 ou NULL | server |
| `id_emp_h/p/i`, `tipo_h/p/i`, `lay_h/p/i` | **opcionais** no insert (vs. obrigatórios no update) | server |
| `id_emp_grupo` | NULL, id existente, ou flag "novo grupo" | server |

---

## 7. Riscos e pontos abertos

| Risco | Mitigação |
|---|---|
| `id_emp_grupo` hoje é texto livre — passar a select pode confundir admins que já decoraram IDs | Manter input livre em modo edição; select é só no modo novo |
| Diretórios de upload (`upload/beneficios/holerite/{raiz_cnpj}`...) — em prod com gcsfuse, `mkdir` falha silenciosamente | Não criar diretórios proativamente; deixar para o primeiro upload |
| `id_usa_atu` em GESEMP precisa de mapeamento master→GESUSA (bug pré-existente já mitigado no `btn_adicionar` da FEA-010 com `selectGESUSA_id_usa_by_master`) | Reaproveitar o mesmo padrão no branch INSERT |
| CNPJ duplicado: hoje não há índice UNIQUE em GESEMP.cnpj | Validar manualmente via `SELECT COUNT(*) FROM GESEMP WHERE cnpj = ?` antes do insert. Avaliar adicionar UNIQUE numa migration depois |
| Empresa "primeira do grupo" antes do INSERT: `id_emp_grupo` precisa do próprio `id_emp` que ainda não existe | Fazer INSERT primeiro com `id_emp_grupo = NULL`, depois UPDATE com auto-FK |

---

## 8. Sequência de entrega

1. **Auditoria do banco** (~15 min): rodar query no Cloud SQL listando empresas com `id_emp_grupo IS NOT NULL` para entender o padrão atual de uso (auto-FK ou aponta para matriz distinta?)
2. **Backend — branch INSERT** (~3 h): modificar `alterar_empresa_post.php` no bloco `btn_adicionar`
3. **Frontend — modo novo** (~2-3 h): modificar `alterar_empresa.php` para detectar `?al=novo`, habilitar CNPJ/tipo, esconder aba Gestor, substituir input `id_emp_grupo` por select em modo novo
4. **Frontend — botão "Incluir Empresa"** (~30 min): editar `tabela_empresas.php`
5. **JS — redirect pós-insert** (~30 min): editar `alterar_empresa.js`
6. **Validação local** (~1 h): cadastrar empresa nova, verificar GESEMP/GESLAY/GESMPR populados, testar "criar novo grupo" + "vincular a existente" + "sem grupo"
7. **Deploy** (~10 min): build + push + Cloud Run

---

## 9. Critérios de aceite

- [ ] Botão "Incluir Empresa" visível em `tabela_empresas.php`
- [ ] Clique abre `alterar_empresa.php` com form vazio, CNPJ e tipo editáveis, aba Gestor escondida
- [ ] Submit cria registro em GESEMP com todos os campos preenchidos do form (nenhum NULL surpresa)
- [ ] GESLAY criado com valores VIS por padrão ou conforme form
- [ ] Limites aplicados (limite_lideres=2 default, limite_admins_ativos=NULL default)
- [ ] Opção "criar novo grupo" gera empresa com `id_emp_grupo = id_emp` (auto-FK)
- [ ] Opção "vincular a grupo existente" gera empresa com `id_emp_grupo = X` (id existente)
- [ ] Opção "sem grupo" gera empresa com `id_emp_grupo = NULL`
- [ ] Após sucesso, página recarrega em modo edição (`?al={id}`) e aba Gestor passa a aparecer
- [ ] CNPJ duplicado é rejeitado com mensagem clara
- [ ] Fluxo de aprovação de lead (`aprovacao` → `alterar_aprovacao`) continua funcionando sem regressão
- [ ] `cadastro_empresa.php` legado continua acessível (não removido) mas órfão como hoje

---

## 10. Arquivos previstos para alteração

- `master/tabela_empresas.php` — botão "Incluir Empresa"
- `master/alterar_empresa.php` — detecção de modo novo, habilitação de campos, select de grupo
- `master/controller/alterar_empresa_post.php` — branch INSERT no `btn_adicionar`
- `master/scripts/alterar_empresa.js` — redirect pós-insert
- `master/iuds_pdo.php` — função `selectGESEMP_cnpj_exists($cnpj)` (verificação de unicidade), `selectGESEMP_matrizes_grupo()` (carrega select de grupos disponíveis)
- `prd.json` — entrada FEA-012
- `docs/plano-fea-012-cadastro-empresa-master.md` — versão final deste plano (caso aprovado)
- `docs/pendencias.md` — registrar cleanup pendente do `cadastro_empresa.php` legado

---

## 11. Observações

- **Esta FEA não bloqueia a FEA-009 (RPA)**. Se aprovada, pode ser entregue antes ou em paralelo
- O `cadastro_empresa.php` legado permanece intocado — fica como dead code documentado em `docs/pendencias.md` para cleanup futuro
- Não há nova tabela nem migration de schema neste plano
