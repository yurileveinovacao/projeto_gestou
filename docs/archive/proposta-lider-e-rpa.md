# Líder RH + Módulo RPA — Escopo final

**Data:** 2026-05-19 (escopo original) · **Atualizado:** 2026-05-22 (reconciliação pós-entrega da FEA-010) · **Status:** FEA-010 entregue · FEA-009 pronta pra implementação

---

## Contexto

A Jéssica (TRYP Hotel Ribeirão Preto) entregou material sobre o **fluxo de RPA** do hotel — formulário de autorização, modelo de contrato e planilha de controle mensal. Para implementar isso no Gestou, surgiu uma lacuna anterior: o RPA pressupõe um **responsável que autoriza** o serviço, e hoje o Gestou não tem hierarquia entre admins. Por isso entregamos primeiro o alicerce (FEA-010), depois o módulo RPA (FEA-009) em cima dele.

---

## FEA-010 — Líder RH (pré-requisito)

**Problema:** Hoje qualquer admin enxerga e mexe em tudo da empresa. Para criar/desativar usuários do painel é preciso acionar o time interno via `/master/`. Não há registro de quem criou cada usuário.

**Solução (entregue 2026-05-21):**
- Papel único novo: **Líder RH** (`GESGES.gestor=1`, **por empresa** — modelo final escolhido na implementação), sem setorização — enxerga a empresa inteira como os admins de hoje
- ⚠️ `GESUSA.gestor` (coluna no usuário) **NÃO** é a fonte da verdade. Virou coluna zumbi após a entrega — ver [`memory/gesusa_gestor_zumbi.md`](../.claude/projects/-media-rafo-dados-IA-gestou-www-www/memory/gesusa_gestor_zumbi.md). Toda query nova de "quem é Líder RH" deve consultar `GESGES.gestor=1` filtrando por `id_emp`
- A diferença está na **gestão de usuários:** Líder RH pode criar, editar, ativar e desativar admins direto no `/admin/`, sem precisar do master
- **Master vira uso interno Leve** (suporte/manutenção). Deixa de ser ferramenta exposta ao cliente
- Cada usuário registra **quem o criou, alterou e desativou** (auditoria completa)
- Estrutura preparada para **limitar admins ativos por empresa** no futuro (precificação por tier) — campo já existe, sem teto agora
- **Internos da Leve (`GESTUS.id_tus=1` = ADMIN)** não contam nos contadores de Líderes/admins ativos e não são listados em fluxos funcionais (hotfix `b0d433c`)

**Decisões fechadas:**

| Tema | Decisão |
|------|---------|
| Quantidade de Líderes/empresa | **2 por padrão**, configurável pelo master por empresa |
| Promover admin a Líder | Líder pode, respeitando o limite. Tela mostra "X de Y Líderes ativos" |
| Desativar Líder | Líder pode, **mas o sistema bloqueia se sobrar 0 ativos** |
| Permissões de admin criado pelo Líder | Reutiliza a lista hardcoded atual (26 menus padrão) — mesma usada hoje pelo master |
| Limite total de admins/empresa | `NULL` (sem teto) agora. Campo `GESEMP.limite_admins_ativos` já criado pra precificação futura |
| Auditoria | Criado por + alterado por + desativado por (com timestamps) |

**Aproveitamento do que já existe:**
- `GESGES.gestor` (bool por empresa, já presente no schema) virou a flag de Líder RH
- `admin/cadastro_usuario.php` e `admin/tabela_usuarios.php` já existem — receberam regra de acesso e novas colunas
- Função `updateGESMPR_menus()` já cria admin com a lista padrão — reutilizada (com cópia adicional em `admin/iuds_pdo.php` — ver débito técnico)

**O que é novo:**
- `GESUSA.id_usa_inc` — admin que criou este usuário
- `GESUSA.id_usa_desativado` + `GESUSA.data_desativacao` — auditoria de desativação
- `GESEMP.limite_lideres` (default 2) — controlado pelo master
- `GESEMP.limite_admins_ativos` (default NULL) — preparado pra tier
- Regra de acesso: telas de gestão de usuários no `/admin/` só liberam para `GESGES.gestor=1` na empresa atual
- Validação: bloqueia desativação se sobrar 0 Líderes ativos
- Validação: bloqueia promoção a Líder se atingiu `limite_lideres`
- Coluna "Criado por" + filtro "ativos/inativos" na listagem
- Backfill de Líderes em produção é **manual** via `/master/` (Yuri, conforme alinhar com cada gestor)

**Esforço estimado:** ~3-5 dias

---

## FEA-009 — Módulo RPA

**Problema:** O hotel controla autônomos em Word + Excel + papel. Sem rastro digital, sem padronização entre líderes, retrabalho mensal pro RH.

### Decisões fechadas (Jéssica)

| Tema | Decisão |
|------|---------|
| **Imposto** | Gross-up fixo de **12,36% sobre o valor líquido** (INSS). Ex.: R$ 150 → bruto R$ 168,54 (INSS R$ 18,54). **O recibo gerado precisa discriminar o INSS em linha separada** |
| **Pagamento** | **Sempre PIX** — campo PIX obrigatório no cadastro do autônomo |
| **Limite legal** | "Acima de 3 dias é ilegal" → **amarelo no 3º dia (atenção)**, **vermelho/bloqueio no 4º** |
| **Aprovação no app** | **Desde o MVP** — fluxo digital pelo app do responsável |
| **Assinatura do autônomo** | Reutiliza o mecanismo de **aceite do holerite** (`id_usu_aceite`, `ip_aceite`, `data_aceite`) — sem ClickSign/D4Sign por ora |
| **DIRF/SEFIP** | Contabilidade cuida por fora. Gestou só faz **controle interno + export Excel mensal** |

### Reconciliação com a FEA-010 (entregue 2026-05-21)

Itens revistos depois que o modelo final do Líder RH ficou pronto em produção:

| Item | Como ficou |
|------|------------|
| **Quem aprova RPA** | Líder RH da empresa (`GESGES.gestor=1` + `id_emp` da sessão) OU admin com `id_dep` igual ao setor do RPA. Sempre filtrar `id_tus IS NULL OR id_tus <> 1` para excluir internos da Leve. Reaproveitar/estender `selectGESUSA_lideres_ativos` (`admin/iuds_pdo.php:11402`) |
| **Filtro `id_tus<>1`** | Padrão obrigatório em toda query funcional (notificações, dashboards "RPAs pendentes", listas de responsáveis). Internos da Leve nunca aparecem em fluxo operacional |
| **Lista de menus padrão** | Hardcoded em **5 lugares** agora (não 4). Os novos `id_mnu` "Folha > Autônomos" e "Folha > RPA" precisam entrar em todos. Se visíveis ao Líder, entrar também em `upsertGESMPR_lider_menus`. Vale antecipar a centralização (débito técnico nº 1 em `docs/pendencias.md`) antes de codificar a FEA-009 |
| **Empresa sem Líder RH no rollout** | Backfill é manual, então existirão empresas sem Líder no início do MVP. **Decisão (default proposto):** permitir cadastro de RPA, aprovação fica em fila até alguém ser promovido. Alternativas: bloquear cadastro / fallback liberando qualquer admin. **A confirmar com Jéssica.** |
| **Aceite digital do autônomo** | Token via **email apenas** — não há infra de SMS contratada. Risco: autônomo sem email cadastrado. **A confirmar com Jéssica** se algum autônomo da TRYP não tem email |
| **Config do RPA** | Fica em `/admin/dados_cadastrais.php` (não no `/master/`) — alinhado com decisão da FEA-010 de master virar uso interno |
| **Auditoria nas novas tabelas** | GESAUT/GESRPA/GESRPACFG seguem o padrão da FEA-010 (`id_usa_inc`, `id_usa_atu`, `datinc`, `datatu`). Avaliar `id_usa_desativado` em GESAUT se a Jéssica quiser rastrear quem inativou autônomos |

### Solução (MVP)

- **Cadastro de autônomos** separado de `GESUSU` (não são CLT): nome, CPF, RG, etnia, nascimento, endereço, **PIX obrigatório**
- **Lançamento por serviço:** responsável autoriza, autônomo, setor (`GESDEP`), data, horário, valor líquido (default empresa), justificativa
- **Cálculo automático:** valor bruto = líquido × 1,1236 / INSS = bruto − líquido
- **3 PDFs gerados:** autorização, contrato (art. 442-B CLT) e recibo — **com INSS discriminado**
- **Fluxo de status:** rascunho → autorizado (pelo líder no app) → assinado (aceite do autônomo no app) → enviado financeiro → pago
- **Alertas de risco CLT:** contador de diárias/mês por autônomo, com amarelo no 3º e bloqueio no 4º
- **Export Excel mensal** no formato da planilha atual da Jéssica
- **Configuração por empresa:** valor padrão (R$ 150), % de impostos (12,36%), templates editáveis dos 3 documentos
- **Permissão de menu:** "Folha > RPA" + "Folha > Autônomos" via `GESMNU/GESMPR`

### Roadmap em fases

| Fase | Escopo | Esforço |
|------|--------|---------|
| **MVP (Fase 1)** | Cadastro autônomos + lançamento + aprovação no app + 3 PDFs (INSS discriminado) + aceite digital + alerta CLT + export Excel + permissão de menu | **2-3 sem** (cresceu de 1-2 porque aprovação no app entrou no MVP) |
| **Fase 2** | Refinamentos de UX, notificações push, dashboards de pagamentos pendentes | 1 sem |
| **Fase 3** | Integração de assinatura eletrônica jurídica (ClickSign/D4Sign) — opcional, sob demanda | 1 sem |

---

## Roadmap consolidado

```
FEA-010 (Líder RH, 3-5 dias)
   └─→ FEA-009 MVP (RPA Fase 1, 2-3 semanas)
          └─→ FEA-009 Fase 2 (1 semana)
                 └─→ FEA-009 Fase 3 (1 semana, opcional)
```

**Total estimado:** ~4-6 semanas até MVP do RPA em produção.

---

## Débito técnico identificado (não bloqueia)

A lista de "menus padrão" para criação de admins está **hardcoded em 5 lugares** (atualizado pós-FEA-010):

- `master/adicionar_permissao.php:33`
- `master/alterar_usuario.php:1082`
- `master/controller/adicionar_novo_usuario_post.php:111`
- `master/iuds_pdo.php` — função `updateGESMPR_menus`
- `admin/iuds_pdo.php` — função `updateGESMPR_menus` (cópia adicionada pela FEA-010)

Toda FEA nova que cria tela precisa atualizar os 5. Vale centralizar em constante única (`config/permissions.php`) ou tabela (`GESMNU_PADRAO`) num refactor curto **antes** da FEA-009 — registrado em `docs/pendencias.md`.

---

## Referências

- `Autorização de RPA.pdf` — formulário do responsável (TRYP)
- `Modelo Contrato RPA.docx` — contrato art. 442-B CLT (R$ 168,54 bruto / R$ 150 líquido)
- `RPA.MARÇO.xlsx` — planilha de controle mensal (aba RPA + aba Novos Extras)
- Commit `311c2a7` — última atualização da lista de menus padrão (adicionou id_mnu=58 do FEA-008)
- `docs/pendencias.md` — débito técnico da centralização da lista de menus padrão
- `prd.json` — FEA-010 e FEA-009 com acceptance criteria detalhado
