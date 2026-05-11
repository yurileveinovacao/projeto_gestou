# scripts/migrations/archive/

Migrações de schema já aplicadas no Cloud SQL de produção (`gestou-489010:us-central1:gestou-db`).
Os arquivos ficam aqui como registro do que o schema vivo recebeu.

| Arquivo | FEA | O que faz | Aplicado em |
|---|---|---|---|
| `create_categorias_observacao.sql` | FEA-004 | Cria tabela `categorias_observacao` (global) | 2026-04-08 |
| `create_observacoes_colaborador.sql` | FEA-004 | Cria tabela `observacoes_colaborador` (global) | 2026-04-08 |
| `create_justificativas.sql` | FEA-005 | Cria tabela `justificativas` (global) | 2026-04-08 |
| `insert_menu_justificativas.sql` | FEA-005 | INSERT em GESMNU/GESMPR — item "Justificativas" filho de "Painel RH" + backfill de 261 permissões | 2026-04-24 |
| `insert_menu_turnover.sql` | FEA-006 | INSERT em GESMNU/GESMPR — categoria "Indicadores" + item "Turnover" (desabilitado por padrão) | 2026-04-13 |
| `add_dias_experiencia_gesemp.sql` | FEA-007 | ALTER TABLE GESEMP — colunas `dias_exp_1` (default 45) e `dias_exp_2` (default 90), idempotente | 2026-04-29 |

**Idempotência**: todos foram escritos com `CREATE TABLE IF NOT EXISTS` / `ADD COLUMN IF NOT EXISTS` / `ON CONFLICT DO NOTHING`, então rodar de novo não quebra. Mesmo assim, **não execute em produção sem necessidade** — as tabelas já existem.

Pra novas migrações de schema, criar arquivos diretamente em `scripts/migrations/` (a pasta acima).
