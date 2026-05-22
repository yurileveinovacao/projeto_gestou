# FEA-009 — Módulo RPA (Recibo de Pagamento Autônomo) — MVP

**Status:** rascunho de plano (aguardando aprovação)
**Data:** 2026-05-22
**Esforço estimado:** 2-3 semanas (6 fases)
**Dependências:**
- FEA-010 (Líder RH) — ENTREGUE em 2026-05-21 ✅
- FEA-013 (centralizar menus padrão) — **recomendado entregar antes** ⏳
**Cliente piloto:** TRYP Hotel Ribeirão Preto (Jéssica)

---

## 1. Contexto e motivação

Implementar gestão digital completa do fluxo de RPA (Recibo de Pagamento Autônomo) para serviços pontuais de prestadores autônomos (art. 442-B CLT). Substitui o controle atual em **Word + Excel + papel** da cliente Jéssica (TRYP Hotel).

**Material de referência da TRYP:**
- `Autorização de RPA.pdf` — modelo de autorização de serviço
- `Modelo Contrato RPA.docx` — minuta de contrato 442-B
- `RPA.MARÇO.xlsx` — planilha mensal pra contabilidade (formato exato a ser exportado)

**Decisões fechadas com Jéssica em 2026-05-19:**
- Gross-up de 12,36% fixo (INSS retido)
- PIX obrigatório no cadastro do autônomo
- Aprovação dentro do app desde o MVP (sem fluxo offline)
- Aceite digital tipo holerite (sem ClickSign jurídico — fica para FEA-009c)
- Alerta de risco CLT amarelo no 3º dia, bloqueio no 4º dia (`>3 diárias/mês`)
- Contabilidade cuida de DIRF/SEFIP por fora — não é responsabilidade do sistema

**Decisões fechadas com Yuri em 2026-05-22 (esta sessão):**
- **Empresa sem Líder RH cadastrado**: RPA é cadastrado normalmente em status `rascunho`, fica em fila até alguém ser promovido a Líder. **Não bloqueia o trabalho do admin.**
- **Email do autônomo**: campo **obrigatório** em GESAUT (`NOT NULL`). Sem email, o autônomo não consegue receber link de aceite digital — admin cobra o email no cadastro. Pros legados sem email, Yuri/cliente coleta no primeiro contato. **SMS fica fora do MVP** (sem infra contratada).
- **Débito técnico nº 1** (centralizar menus padrão) vira **FEA-013 separada** e idealmente é entregue antes desta.

---

## 2. Estrutura geral

A FEA-009 é dividida em **6 fases sequenciais** com pontos de validação intermediária. Cada fase é independente o suficiente para ser deployada em prod separadamente (sem quebrar o que já existe), facilitando rollback.

| Fase | Conteúdo | Esforço | Deployável? |
|---|---|---|---|
| 1 | Schema (3 migrations) + menus + DAL básica | 3-4 dias | Sim (sem UI ainda) |
| 2 | Cadastro de autônomos (CRUD GESAUT) | 2-3 dias | Sim (admin já cadastra autônomos, sem RPA ainda) |
| 3 | Cadastro de RPA + cálculo INSS + validação CLT + 3 PDFs | 3-4 dias | Sim (RPAs em rascunho/autorizado, sem aprovação no app ainda) |
| 4 | Aprovação no app (notif + tela rpa_aprovar) | 2-3 dias | Sim (fluxo completo até `autorizado`) |
| 5 | Aceite digital pelo autônomo (token email + tela) | 2 dias | Sim (fluxo até `assinado`) |
| 6 | Status financeiro + export Excel + config admin + dashboard | 2-3 dias | MVP fechado |

Fora deste MVP (FEAs futuras):
- **FEA-009b** — Fase 2 UX: notificação push, dashboard de pagamentos refinado, filtros avançados
- **FEA-009c** — Assinatura eletrônica jurídica (ClickSign/D4Sign) com certificação ICP-Brasil

---

## 3. Fase 1 — Schema, menus e DAL básica

### 3.1 Migration `scripts/migrations/create_gesaut.sql`

Tabela de autônomos (separada de GESUSU porque não são CLT, não têm benefícios, ciclo de vida diferente):

```sql
CREATE TABLE public."GESAUT" (
    id_aut SERIAL PRIMARY KEY,
    id_emp INT NOT NULL REFERENCES "GESEMP"(id_emp),
    nome VARCHAR(200) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    rg VARCHAR(20),
    data_nasc DATE,
    etnia VARCHAR(30),
    endereco TEXT,
    cep VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    uf CHAR(2),
    email VARCHAR(200) NOT NULL,  -- obrigatório (decisão 2026-05-22): aceite digital depende disso
    pix VARCHAR(100) NOT NULL,
    ativo SMALLINT DEFAULT 1,
    datinc TIMESTAMP DEFAULT NOW(),
    id_usa_inc INT,
    datatu TIMESTAMP,
    id_usa_atu INT,
    UNIQUE (id_emp, cpf)
);
CREATE INDEX idx_gesaut_emp_ativo ON "GESAUT"(id_emp, ativo);
```

### 3.2 Migration `scripts/migrations/create_gesrpa.sql`

Tabela de RPAs (cada linha = um pagamento autorizado):

```sql
CREATE TABLE public."GESRPA" (
    id_rpa SERIAL PRIMARY KEY,
    id_emp INT NOT NULL REFERENCES "GESEMP"(id_emp),
    id_aut INT NOT NULL REFERENCES "GESAUT"(id_aut),
    id_dep INT REFERENCES "GESDEP"(id_dep),
    cargo VARCHAR(100),
    data_servico DATE NOT NULL,
    hora_ini TIME,
    hora_fim TIME,
    diarias INT DEFAULT 1,
    valor_liquido NUMERIC(10,2) NOT NULL,
    perc_imposto NUMERIC(5,2) DEFAULT 12.36,
    valor_bruto NUMERIC(10,2) NOT NULL,
    valor_inss NUMERIC(10,2) NOT NULL,
    justificativa TEXT,
    status VARCHAR(20) DEFAULT 'rascunho'
        CHECK (status IN ('rascunho','autorizado','assinado','enviado_fin','pago','cancelado')),
    autorizado_por INT REFERENCES "GESUSA"(id_usa),
    data_autorizacao TIMESTAMP,
    assinado_por INT REFERENCES "GESAUT"(id_aut),
    ip_assinatura VARCHAR(45),
    data_assinatura TIMESTAMP,
    data_envio_fin DATE,
    data_pgto DATE,
    motivo_cancelamento TEXT,
    contrato_pdf_path VARCHAR(500),
    recibo_pdf_path VARCHAR(500),
    autorizacao_pdf_path VARCHAR(500),
    datinc TIMESTAMP DEFAULT NOW(),
    id_usa_inc INT,
    datatu TIMESTAMP,
    id_usa_atu INT
);
CREATE INDEX idx_gesrpa_emp_status ON "GESRPA"(id_emp, status);
CREATE INDEX idx_gesrpa_aut_data ON "GESRPA"(id_aut, data_servico);
```

### 3.3 Migration `scripts/migrations/create_gesrpacfg.sql`

Tabela de configuração por empresa (textos e padrões editáveis em admin/dados_cadastrais.php):

```sql
CREATE TABLE public."GESRPACFG" (
    id_emp INT PRIMARY KEY REFERENCES "GESEMP"(id_emp),
    valor_liquido_padrao NUMERIC(10,2) DEFAULT 150.00,
    perc_imposto_padrao NUMERIC(5,2) DEFAULT 12.36,
    texto_autorizacao_html TEXT,
    texto_contrato_html TEXT,
    texto_recibo_html TEXT,
    limite_dias_alerta INT DEFAULT 3,
    limite_dias_bloqueio INT DEFAULT 4,
    datinc TIMESTAMP DEFAULT NOW(),
    datatu TIMESTAMP,
    id_usa_atu INT
);
```

Seed dos 3 textos (`texto_*_html`) baseado nos modelos da Jéssica (PDF/DOCX convertidos para HTML básico). Seed feito via script `scripts/migrations/seed_gesrpacfg_tryp.sql` para a empresa da TRYP especificamente; outras empresas pegam os defaults vazios e configuram em `/admin/dados_cadastrais.php` aba RPA.

### 3.4 Migration de menus

`scripts/migrations/insert_menu_rpa.sql`:
- Verifica/cria a categoria `'Folha'` em GESMNU (se não existir)
- Insere `'Autônomos'` (id_mnu auto) e `'RPA'` (id_mnu auto)
- Anota os IDs gerados (X, Y)
- **Pós-FEA-013**: adiciona X e Y na constante `MENUS_PADRAO_NOVOS_ADMINS` em `config/permissions.php`. Se a FEA-013 não estiver pronta ainda, atualizar os 5 lugares hardcoded (caso emergencial)
- `INSERT INTO GESMPR ... ON CONFLICT` pra liberar acesso aos usuários existentes

### 3.5 DAL base em `admin/iuds_pdo.php`

Funções novas:
- `insertGESAUT`, `updateGESAUT`, `selectGESAUT`, `selectGESAUT_lista($id_emp, $ativo)`
- `insertGESRPA`, `updateGESRPA_status($id_rpa, $novo_status, $extras)`, `selectGESRPA($id_rpa)`, `selectGESRPA_lista($id_emp, $mes, $ano, $status_filtro)`
- `selectGESRPA_diarias_mes($id_aut, $mes, $ano)` — conta diárias para validação CLT
- `selectGESRPACFG($id_emp)`, `upsertGESRPACFG($id_emp, $campos)`
- `selectGESUSA_responsaveis_aprovacao($id_emp, $id_dep)` — Líderes RH + admins do setor. Reaproveita padrão de `selectGESUSA_lideres_ativos:11402` (JOIN GESGES, filtro `id_tus<>1`)

### 3.6 Validação Fase 1

- Migrations rodam sem erro em local (Docker + Cloud SQL Proxy)
- Tabelas existem com colunas/constraints corretos
- Seed da TRYP popula GESRPACFG
- Menus aparecem em `/admin/` para usuários com permissão
- Functions retornam dados consistentes em queries simples

**Deploy intermediário ok?** Sim — schema novo, menus visíveis (vazios), funções DAL não chamadas por UI ainda.

---

## 4. Fase 2 — Cadastro de autônomos

### 4.1 Telas

- **`admin/autonomos.php`** — listagem com colunas: nome, CPF, PIX, ativo, total de diárias no mês corrente. Busca por nome/CPF. Filtro ativo/inativo. Botão "Novo autônomo".
- **`admin/autonomo_incluir.php`** — form com campos: nome (req), CPF (req, máscara, validação dígito), RG, data nasc, etnia (select), endereço completo, email (**req**), PIX (req).
- **`admin/autonomo_alterar.php`** — mesmo form, modo edição. Inclui toggle ativo/inativo.

### 4.2 Controllers

- `admin/controller/autonomo_incluir_post.php` — valida CPF (formato + unicidade `id_emp + cpf`), email (formato), PIX (não vazio). Chama `insertGESAUT`.
- `admin/controller/autonomo_alterar_post.php` — chama `updateGESAUT`.
- `admin/controller/autonomo_toggle_ativo_post.php` — flip do `ativo` (1↔0).

### 4.3 Validações funcionais

- CPF deve ter 11 dígitos válidos (algoritmo padrão)
- CPF único por empresa (constraint UNIQUE no banco + check antes do insert pra UX melhor)
- Email obrigatório com formato válido
- PIX obrigatório (sem validação de formato — pode ser CPF, email, telefone, chave aleatória)

**Deploy intermediário ok?** Sim — admin já cadastra autônomos, ainda sem fluxo de RPA.

---

## 5. Fase 3 — Cadastro de RPA + cálculo + PDFs

### 5.1 Tela `admin/rpas.php`

- Listagem por mês (default: mês corrente) com filtros: status, setor (id_dep), busca por nome do autônomo
- Colunas: data serviço, autônomo, setor, justificativa, valor bruto, status (badge colorido), ações
- Badge por status: rascunho (cinza), autorizado (azul), assinado (verde-claro), enviado_fin (amarelo), pago (verde), cancelado (vermelho)
- Botão "Novo RPA"

### 5.2 Tela `admin/rpa_incluir.php`

Form com:
- Autônomo (autocomplete consultando `selectGESAUT_lista` da empresa)
- Setor (select GESDEP)
- Data do serviço (date input)
- Horário (hora_ini, hora_fim — opcionais)
- Cargo (texto livre)
- Valor líquido (default `GESRPACFG.valor_liquido_padrao`)
- % imposto (default `GESRPACFG.perc_imposto_padrao` = 12,36 — read-only no MVP)
- Justificativa (textarea)
- **Cálculo em JS na hora**:
  - `valor_bruto = valor_liquido * (1 + perc_imposto/100)` — exemplo: 150 → 150 * 1,1236 = 168,54
  - `valor_inss = valor_bruto * (perc_imposto / (100 + perc_imposto))` — neste exemplo, 168,54 - 150 = 18,54
  - Exibe os 3 valores em tempo real
- Botões: "Salvar como rascunho" / "Salvar e enviar para aprovação"

### 5.3 Validação de risco CLT

Antes de salvar (no controller `rpa_incluir_post.php`):

```php
$diarias = selectGESRPA_diarias_mes($id_aut, $mes, $ano);
$cfg = selectGESRPACFG($id_emp);

if ($diarias >= $cfg['limite_dias_bloqueio']) {
    // bloqueia
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Autônomo já atingiu ' . $diarias . ' diárias no mês. Limite de bloqueio: ' . $cfg['limite_dias_bloqueio'] . '. Cadastre como CLT.'
    ]);
    exit;
}
if ($diarias >= $cfg['limite_dias_alerta']) {
    // alerta amarelo — frontend exibe modal de confirmação antes de POSTar
    // (validação dupla: client+server)
}
```

### 5.4 Geração dos 3 PDFs

Verificar antes qual biblioteca já está no projeto (mPDF/Dompdf/PHPWord). Sequência:

- `admin/util/gerarPDFAutorizacao($id_rpa)` → PDF baseado em `texto_autorizacao_html` com placeholders substituídos (`{nome_autonomo}`, `{cpf}`, `{data_servico}`, `{cargo}`, `{valor_bruto}`, etc.)
- `admin/util/gerarPDFContrato($id_rpa)` → PDF baseado em `texto_contrato_html`
- `admin/util/gerarPDFRecibo($id_rpa)` → PDF baseado em `texto_recibo_html`, **discriminando 3 linhas**:
  - Valor bruto: R$ X
  - INSS retido (12,36%): R$ Y
  - Valor líquido pago: R$ Z

Salvos em `upload/rpa/{cnpj_raiz}/{ano-mes}/{id_rpa}_{tipo}.pdf` (autorizacao, contrato, recibo). Path persistido em `GESRPA.{tipo}_pdf_path`.

### 5.5 Validação Fase 3

- Cadastrar RPA com autônomo válido salva em GESRPA com status `rascunho` ou `autorizado` (se admin tem permissão de auto-autorizar — a definir; provavelmente botão "Enviar pra aprovação" salva como `rascunho` e o fluxo da Fase 4 muda pra `autorizado`)
- 4ª diária no mês bloqueia com mensagem clara
- 3ª diária mostra aviso e pede confirmação
- 3 PDFs são gerados, salvos no bucket, paths em GESRPA preenchidos
- PDFs abrem corretamente (verificar nos 3 navegadores comuns)

---

## 6. Fase 4 — Aprovação no app

### 6.1 Identificação dos aprovadores

Função `selectGESUSA_responsaveis_aprovacao($id_emp, $id_dep)`:
- Líderes RH da empresa (`GESGES.gestor=1 AND GESUSA.situac=1 AND id_tus<>1`)
- Mais admins vinculados ao setor `$id_dep` (se já existir alguma estrutura de "admin do setor")
- Retorna `[{id_usa, nome, email}, ...]`

### 6.2 Notificação

Ao mudar RPA para `aguardando_aprovacao` (ou continuar como `rascunho` se quem cadastrou tem permissão de auto-autorizar — a decidir):
- Email para cada aprovador com link `https://gestou.com.br/app/rpa_aprovar?id={id_rpa}&token={hash}`
- Notificação in-app no `/app/` (estrutura GESNOT existente)
- **Push notification** fica para FEA-009b (fora deste MVP)

### 6.3 Tela `app/rpa_aprovar.php`

- Acessada via link do email ou pelo dashboard do app
- Exibe: dados do RPA, autônomo, setor, valores discriminados, 3 PDFs (preview ou download)
- Botões: "Aprovar" / "Recusar"
- **Aprovar**: muda status para `autorizado`, grava `autorizado_por = id_usa_logado`, `data_autorizacao = NOW()`
- **Recusar**: pede justificativa, muda status para `cancelado`, grava `motivo_cancelamento` e `data_autorizacao` (timestamp da decisão)

### 6.4 Empresa sem Líder RH

Decisão tomada em 2026-05-22 (Yuri): **RPA fica em status `rascunho` até alguém ser promovido**. Não bloqueia o cadastro, não auto-aprova. Quando o Líder for promovido via `/master/`, ele vê a fila pendente automaticamente.

Implementação: nenhuma lógica especial — se `selectGESUSA_responsaveis_aprovacao` retorna vazio, simplesmente nenhum email é enviado e o RPA continua em fila até alguém apropriado existir.

### 6.5 Validação Fase 4

- Cadastrar RPA → Líder RH recebe email + notif in-app
- Aprovar → RPA muda pra `autorizado`, registros corretos em GESRPA
- Recusar → status `cancelado` com motivo
- Empresa sem Líder → RPA fica em `rascunho`, sem email enviado, sem erro

---

## 7. Fase 5 — Aceite digital pelo autônomo

### 7.1 Disparo do convite

Ao mudar RPA para `autorizado`:
- Email para `GESAUT.email` com link `https://gestou.com.br/app/rpa_aceite?token={hash}`
- Token = hash do `id_rpa + id_aut + secret`. Validade 7 dias (configurável)

### 7.2 Tela `app/rpa_aceite.php`

- **Não requer login** (autônomo não tem conta no sistema)
- Autônomo entra com CPF (validação dupla: CPF do GESAUT linkado ao RPA do token)
- Exibe: dados do RPA, valores discriminados, 3 PDFs pra leitura
- Botão "Aceitar e assinar"
- Ao aceitar: muda status para `assinado`, grava `assinado_por = id_aut`, `ip_assinatura = $_SERVER['REMOTE_ADDR']`, `data_assinatura = NOW()`

### 7.3 Sem SMS no MVP

Confirmado em 2026-05-22: aceite só via email. Autônomo sem email não consegue ser pago via RPA digital. Admin precisa cadastrar email.

### 7.4 Validação Fase 5

- Após aprovação, autônomo recebe email
- Link abre tela de aceite, mostra dados corretos
- Aceitar muda status para `assinado` com registros completos
- Token expirado retorna mensagem clara
- CPF errado retorna erro (não revelando se o RPA existe ou não, por segurança)

---

## 8. Fase 6 — Status financeiro + export Excel + config + dashboard

### 8.1 Botões de status no admin (em `admin/rpas.php` e `admin/rpa_alterar.php`)

- **"Enviar para financeiro"** (disponível quando status = `assinado`): grava `data_envio_fin = NOW()`, status = `enviado_fin`
- **"Marcar como pago"** (disponível quando status = `enviado_fin`): pede `data_pgto`, grava status = `pago`
- **"Cancelar"** (disponível em qualquer status exceto `pago`): pede motivo, grava `motivo_cancelamento`, status = `cancelado`

### 8.2 Export Excel mensal

`admin/rpa_export_excel.php` — gera XLSX no formato exato da planilha `RPA.MARÇO.xlsx` da Jéssica:

| Coluna | Origem |
|---|---|
| envio financeiro | `data_envio_fin` |
| data início | `data_servico` |
| data fim | `data_servico` (mesmo dia no MVP) |
| diárias | `diarias` |
| valor | `valor_liquido` |
| valor c/ imp. | `valor_bruto` |
| HRS | `hora_fim - hora_ini` formatado |
| nome | `GESAUT.nome` |
| cargo | `GESRPA.cargo` |
| setor | `GESDEP.nome` |
| data pgto | `data_pgto` |
| justificativa | `justificativa` |
| assinado | "Sim" se status >= `assinado` else "Não" |
| endereço | `GESAUT.endereco` |
| CPF | `GESAUT.cpf` |
| RG | `GESAUT.rg` |
| nascimento | `GESAUT.data_nasc` |
| etnia | `GESAUT.etnia` |

Lib: usar a mesma já presente no projeto pra outros exports Excel (verificar PhpSpreadsheet ou similar).

### 8.3 Config no admin/dados_cadastrais

Nova aba **"RPA"** com:
- Input `valor_liquido_padrao`
- Input `perc_imposto_padrao` (read-only no MVP — fixo 12,36; só exibido)
- Editor HTML (textarea simples ou TinyMCE se já estiver no projeto) para os 3 textos: autorização, contrato, recibo
- Inputs `limite_dias_alerta` e `limite_dias_bloqueio`
- Salva via `upsertGESRPACFG($id_emp, $campos)` (INSERT ON CONFLICT DO UPDATE)

### 8.4 Cards no dashboard

Em `admin/index.php` (para usuários com permissão à tela RPA):
- Card "RPAs pendentes de aprovação" — count de RPAs `rascunho` da empresa
- Card "RPAs aguardando pagamento" — count de `enviado_fin`
- Cards levam pra listagem filtrada

### 8.5 Permissões

Os 2 menus novos (Folha > Autônomos, Folha > RPA) já estão em GESMNU/GESMPR desde Fase 1. Por padrão, Líder RH + admins comuns têm acesso. Master decide caso a caso.

### 8.6 Validação Fase 6 (MVP fechado)

- Fluxo end-to-end: cadastrar autônomo → cadastrar RPA → aprovar no app → autônomo aceita por email → enviar financeiro → marcar como pago
- Export Excel sai com formato idêntico à planilha da Jéssica (validar visualmente)
- Config em admin/dados_cadastrais persiste e impacta cálculos de novos RPAs
- Cards no dashboard atualizam contadores corretamente
- Multi-tenant: empresa A não vê dados da empresa B em nenhuma tela

---

## 9. Critérios de aceite (consolidados)

- [ ] 3 migrations rodam sem erro em prod (GESAUT, GESRPA, GESRPACFG)
- [ ] 2 menus (Folha > Autônomos, Folha > RPA) criados em GESMNU e liberados em GESMPR
- [ ] Constante `MENUS_PADRAO_NOVOS_ADMINS` da FEA-013 atualizada com os 2 novos id_mnu (ou os 5 lugares hardcoded como fallback se FEA-013 atrasar)
- [ ] CRUD de autônomos funcional (lista, incluir, alterar, ativar/desativar)
- [ ] Email obrigatório em GESAUT — bloqueia cadastro sem email
- [ ] CPF único por empresa
- [ ] Cadastro de RPA com cálculo automático de bruto + INSS
- [ ] Validação CLT: alerta no 3º dia, bloqueio no 4º
- [ ] 3 PDFs gerados (autorização, contrato, recibo) com valores discriminados
- [ ] PDFs salvos em `upload/rpa/{cnpj}/{ano-mes}/{id_rpa}_{tipo}.pdf` no bucket
- [ ] Notificação por email para Líder RH (+ admin do setor se aplicável) ao cadastrar RPA
- [ ] Empresa sem Líder RH: RPA fica em rascunho sem erro, sem email
- [ ] Tela `app/rpa_aprovar.php` permite aprovar/recusar com registros corretos
- [ ] Email de aceite enviado ao autônomo após aprovação
- [ ] Tela `app/rpa_aceite.php` valida CPF + token, registra IP + timestamp ao aceitar
- [ ] Botões "Enviar financeiro", "Marcar pago" e "Cancelar" funcionam com a máquina de estados
- [ ] Export Excel mensal com layout idêntico ao `RPA.MARÇO.xlsx` da Jéssica
- [ ] Aba RPA em `admin/dados_cadastrais.php` persiste configs
- [ ] Cards no dashboard atualizam contadores
- [ ] Todos os queries filtram por `id_emp` da sessão (multi-tenant)
- [ ] Validação local end-to-end ANTES de cada deploy de fase
- [ ] Validação em prod ao final de cada fase com Jéssica (smoke test)

---

## 10. Arquivos previstos para alteração

### Schema
- `scripts/migrations/create_gesaut.sql` (novo)
- `scripts/migrations/create_gesrpa.sql` (novo)
- `scripts/migrations/create_gesrpacfg.sql` (novo)
- `scripts/migrations/seed_gesrpacfg_tryp.sql` (novo)
- `scripts/migrations/insert_menu_rpa.sql` (novo)

### DAL
- `admin/iuds_pdo.php` — novas funções GESAUT/GESRPA/GESRPACFG (~15 funções)
- `app/iuds_pdo.php` — funções de leitura para o app (aprovar, aceitar)

### Admin (telas)
- `admin/autonomos.php`, `admin/autonomo_incluir.php`, `admin/autonomo_alterar.php` (novos)
- `admin/controller/autonomo_*_post.php` (3 novos)
- `admin/rpas.php`, `admin/rpa_incluir.php`, `admin/rpa_alterar.php` (novos)
- `admin/controller/rpa_*_post.php` (4-5 novos, um por ação)
- `admin/rpa_export_excel.php` (novo)
- `admin/dados_cadastrais.php` — nova aba RPA
- `admin/controller/rpa_config_post.php` (novo)
- `admin/index.php` — cards no dashboard
- `admin/util/gerarPDFAutorizacao.php`, `admin/util/gerarPDFContrato.php`, `admin/util/gerarPDFRecibo.php` (novos)

### App (autônomo + aprovador)
- `app/rpa_aprovar.php`, `app/rpa_aceite.php` (novos)
- `app/controller/rpa_aprovar_post.php`, `app/controller/rpa_aceite_post.php` (novos)

### Config e docs
- `config/permissions.php` (atualizado pela FEA-013, depois recebe 2 novos id_mnu)
- `prd.json` (FEA-009 marcada como entregue quando fechar)
- `docs/pendencias.md` (se restarem itens)

---

## 11. Riscos e mitigações

| Risco | Mitigação |
|---|---|
| Lib de PDF não está no projeto | Verificar antes (Fase 1): mPDF/Dompdf/PHPWord. Se nenhuma, adicionar via composer no `admin/vendor_*` |
| Cálculo de INSS gross-up errado | Testar com casos da planilha da Jéssica antes de fechar Fase 3 |
| Token de aceite sem expiração permite uso indevido | Implementar TTL de 7 dias + invalidação ao aceitar |
| Cliente sem email para autônomo | Decisão já tomada: email obrigatório. Yuri/cliente coleta antes de cadastrar |
| 2 menus novos em 5 lugares (sem FEA-013) | Atacar FEA-013 primeiro. Se atrasar, fazer as 5 edições com checklist explícito |
| Export Excel não bate com formato da Jéssica | Validar visualmente com a Jéssica entre Fase 6 e fechamento |
| Empresa sem Líder no rollout (vários clientes além da TRYP) | Cobertura pelo default (fica em rascunho). Documentar no manual: "promova ao menos 1 Líder antes de usar RPA" |

---

## 12. Sequência de entrega

Cada fase termina com deploy intermediário pra reduzir risco de big-bang no fim.

1. **FEA-013 primeiro** (½ dia) — centraliza menus padrão
2. **Fase 1 — Schema + DAL** (3-4 dias) → deploy intermediário
3. **Fase 2 — Cadastro de autônomos** (2-3 dias) → deploy intermediário
4. **Fase 3 — Cadastro de RPA + PDFs** (3-4 dias) → deploy intermediário
5. **Fase 4 — Aprovação no app** (2-3 dias) → deploy intermediário
6. **Fase 5 — Aceite digital** (2 dias) → deploy intermediário
7. **Fase 6 — Status + export + config + dashboard** (2-3 dias) → MVP fechado
8. **Validação final com Jéssica** (1 dia) — fluxo end-to-end em prod com dados reais

Total: ~3 semanas (com folga pra ajustes em cada fase)

---

## 13. Observações

- **A FEA-009 é o último item grande do roadmap pré-Play Console**. Após entrega, focar em FEA-009b (refinements) e Fase 5 do roadmap geral (Google Play)
- O MVP **NÃO** inclui assinatura jurídica ICP-Brasil. O aceite digital é "tipo holerite" (registro de IP + timestamp), suficiente operacionalmente mas não substitui contrato formal. FEA-009c trata disso quando o cliente precisar
- Cada fase fechada pode ser usada em produção (não-blocking) — facilita feedback contínuo da Jéssica
