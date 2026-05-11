# scripts/archive/

Scripts da migração Kinghost → GCP, já executados durante a Fase 6 (cutover em 2026-04-24).
Mantidos pra auditoria e referência caso seja necessário repetir parte do processo.

| Arquivo | O que faz | Quando rodou |
|---|---|---|
| `migrate-database.sh` | Dump PG13 Kinghost → restore Cloud SQL PG17 (com flags pra contornar timeout do Kinghost) | 2026-04-24 |
| `migrate-uploads.sh` | Sincronia local → GCS bucket `gestou-uploads-489010` (9.7 GB / 52.710 arquivos) | 2026-04-24 |
| `validate-migration.sh` | Conferência de contagem de linhas pós-restore | 2026-04-24 |
| `test-smtp.php` | Teste rápido de SMTP usado pra investigar timeout Kinghost vindo do Cloud Run | 2026-04-24~28 |

**Não execute mais.** Configurações (hosts, credenciais Kinghost) estão obsoletas — Kinghost será descomissionado.
