# Gestou — Instruções do Projeto

## Projeto

Sistema de RH/folha multi-tenant. PHP 7.4 puro (SEM framework), PostgreSQL 17, Apache.
Hospedado no GCP (Cloud Run + Cloud SQL).

## Estrutura
```
/              → Site público
/admin/        → Painel RH (158 PHP, iuds_pdo.php = 10.750 linhas)
/app/          → Portal colaborador (76 PHP)
/master/       → Super-admin (51 PHP)
/createemployee/ → Cadastro via token
/createaccount/  → Auto-registro
/config/       → Configs centralizados (database, email, storage, urls, session)
/docs/         → Documentação viva (pendencias.md) + archive/ histórico
/scripts/      → Utilitários e migrações de schema (scripts/migrations/) — archive/ guarda migração GCP concluída
```

## Arquitetura de Produção

| Componente | Valor |
|-----------|-------|
| Projeto GCP | gestou-489010 |
| Região | us-central1 |
| Cloud Run Service | gestou (gen2, porta 8080, 2Gi RAM, 0-3 instâncias) |
| Cloud SQL Instance | gestou-489010:us-central1:gestou-db (PostgreSQL 17, db-f1-micro) |
| GCS Bucket | gs://gestou-uploads-489010 |
| Artifact Registry | us-central1-docker.pkg.dev/gestou-489010/gestou-repo |
| VPC Connector | gestou-connector |
| Domain | gestou.com.br + www.gestou.com.br → ghs.googlehosted.com (A/CNAME, Cloudflare proxy OFF). `gestou.leveinovacao.com.br` mantido como staging. |
| Service Account | 469696711631-compute@developer.gserviceaccount.com |
| Secrets (Secret Manager) | db-password, smtp-password, azure-vision-endpoint, azure-vision-key, maintenance-bypass-token, cron-secret |
| SMTP | smtp.gmail.com:587 (contato@leveinovacao.com.br) |

## Regras ABSOLUTAS

- NUNCA altere arquivos em vendor/ ou vendor_* (dependências externas)
- NUNCA altere .gitignore para remover vendor/ (eles ficam fora do git)
- Use __DIR__ para paths em require (ex: `require __DIR__.'/../config/database.php'`)
- PHP 7.4 — sem union types, sem match(), sem named arguments, sem readonly
- Commits semânticos: feat:, refactor:, fix:, docs:, chore:

## Templates OCR (admin/layout/)

- 83 templates de OCR (holerite/irrf/ponto) — usam formato Azure Computer Vision (analyzeResult.readResults[n].lines[m].text)
- OCR via Azure Computer Vision API (envio binário octet-stream), chamado diretamente em admin/vision_computer.php e admin/controller/vision_computer_irrf_post.php
- Templates foram revertidos para estado original compatível com Azure após testes com Google Vision
- Referência de fixes aplicados: progress.txt (seção Fase 4B)

## Configs centralizados (config/)

| Arquivo | Função | Env vars |
|---------|--------|----------|
| `database.php` | Conexões pg_connect (legado) e PDO. Exporta `$conn` e `$pdo` | DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS |
| `mail.php` | Configura PHPMailer SMTP. Função `configureMailer(&$mail)` | SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS, SMTP_FROM, SMTP_FROM_NAME |
| `storage.php` | Abstração local/GCS. Funções: storageUpload/Delete/Url/Exists | STORAGE_DRIVER (`local`\|`gcs`), GCS_BUCKET |
| `app.php` | URL base e email de contato | APP_URL, CONTACT_EMAIL |
| `session.php` | Sessões em PostgreSQL (tabela `php_sessions`). Requer database.php | (nenhuma própria — usa DB_*) |
| `ocr.php` | ⚠️ Legado (Google Vision) — NÃO USADO. OCR agora é Azure, direto nos controllers | — |
| `permissions.php` | Constante `MENUS_PADRAO_NOVOS_ADMINS` (26 id_mnu liberados a admins recém-criados). Adicione novos IDs aqui quando uma FEA incluir tela no kit básico | — |

## Timezones

- **PHP** (Cloud Run): `America/Sao_Paulo` (UTC-3) — setado em todos `util.php`/`util2.php`. Campos `datinc`/`datatu` e similares ficam em BRT.
- **PostgreSQL** (Cloud SQL): `America/Sao_Paulo` — flag `timezone` aplicada na instância. `NOW()`/`CURRENT_TIMESTAMP` retornam BRT, alinhado com o PHP.
- **Logs Apache / Cloud Run / Cloud Logging**: **UTC** (não há como mudar facilmente). Ao correlacionar `datinc` (BRT) com timestamp de log Cloud Run (UTC), aplicar `+3h` ao BRT pra obter UTC.

## Deploy (processo manual)

```bash
# Build e push
docker build -t us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest .
docker push us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest

# Deploy no Cloud Run (comando completo)
gcloud run deploy gestou \
  --image=us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest \
  --region=us-central1 \
  --platform=managed \
  --port=8080 \
  --memory=2Gi \
  --min-instances=0 \
  --max-instances=3 \
  --vpc-connector=gestou-connector \
  --add-cloudsql-instances=gestou-489010:us-central1:gestou-db \
  --set-env-vars="DB_HOST=/cloudsql/gestou-489010:us-central1:gestou-db,DB_PORT=5432,DB_NAME=gestou,DB_USER=gestou,APP_URL=https://gestou.com.br,SMTP_HOST=smtp.gmail.com,SMTP_PORT=587,SMTP_USER=contato@leveinovacao.com.br,SMTP_FROM=contato@leveinovacao.com.br,SMTP_FROM_NAME=GESTOU,STORAGE_DRIVER=local,CONTACT_EMAIL=contato@leveinovacao.com.br,MAINTENANCE_MODE=0" \
  --set-secrets="DB_PASS=db-password:latest,SMTP_PASS=smtp-password:latest,AZURE_VISION_ENDPOINT=azure-vision-endpoint:latest,AZURE_VISION_KEY=azure-vision-key:latest,MAINTENANCE_BYPASS_TOKEN=maintenance-bypass-token:latest" \
  --allow-unauthenticated
```

**Notas**:
- Uploads (bucket `gestou-uploads-489010`) montados em `/var/www/html/upload` via gcsfuse CSI (ver volume mount no service). Apache serve e PHP grava transparente, sem usar `storage.php`.
- `MAINTENANCE_MODE=1` + `MAINTENANCE_BYPASS_TOKEN` ativam a página de manutenção (com bypass via `?bypass=<token>` → cookie 24h).
- Email SMTP: usando Gmail (`contato@leveinovacao.com.br`) como fallback. Migração pra `@gestou.com.br` em aberto — ver `docs/pendencias.md`.

## Acesso ao Banco (Cloud SQL)

```
Instância: gestou-489010:us-central1:gestou-db (PostgreSQL 17, db-f1-micro)
Banco: gestou | Usuário: gestou | Senha: Secret Manager → db-password
Socket (Cloud Run): /cloudsql/gestou-489010:us-central1:gestou-db
```

Acesso local via proxy:
```bash
./cloud-sql-proxy --port 5434 gestou-489010:us-central1:gestou-db &
psql -h 127.0.0.1 -p 5434 -U gestou -d gestou
```

## Status

Em produção em https://gestou.com.br desde 2026-04-24 (cutover GCP concluído).
Fase 7 (FEA-001 a FEA-007) entregue. **Pendências em aberto vivem no OKR** (projeto `gestou-2026`) — consulte via `claude-okr call GET '/api/agent/tasks?projectToken=gestou-2026&status=PENDING'`.

## Referência

- **OKR** (`gestou-2026`) — fonte da verdade pra pendências e tarefas em andamento (via plugin `claude-okr` ou <https://okr.leveinovacao.com.br>)
- [`docs/pendencias.md`](docs/pendencias.md) — pointer pro OKR + registro de itens descartados (não-tarefas)
- [`progress.txt`](progress.txt) — log cronológico de entregas (vivo)
- [`prd.json`](prd.json) — PRD do épico Onboarding Comercial v2 (FEA-014..020). PRD histórico (MIG + FEA-001..013) em `docs/archive/prd-original.json`
- [`docs/proposta-onboarding-v2.md`](docs/proposta-onboarding-v2.md) — apresentação do épico atual
- [`docs/archive/`](docs/archive/) — documentação histórica da migração Kinghost → GCP + PRD original arquivado
- [`scripts/migrations/archive/`](scripts/migrations/archive/) — migrações de schema já aplicadas (FEA-004~007)
- [`Brain/`](Brain/) — cofre Obsidian versionado para logs técnicos de sessão (ver protocolo abaixo)

## Logs de sessão (Brain/)

A pasta `Brain/` é um cofre Obsidian. Estrutura:
- `Brain/02_Logs/YYYY-MM-DD.md` — log técnico diário da sessão. Múltiplas sessões no mesmo dia separam por `---` e incrementam `## Sessão N: <título>`. Sufixo `-slug` quando há vários logs no mesmo dia (ex: `2026-05-21-ocr-azure.md`).

**Não substitui** `progress.txt`, `docs/pendencias.md` ou `prd.json` — esses continuam vivos. Os logs em `Brain/02_Logs/` capturam o **detalhe técnico** de cada sessão (causa raiz, comandos, decisões) que normalmente se perde após o commit.

### Protocolo Proativo de Finalização de Sessão

Ao detectar que uma tarefa (feature, fix, refactor, deploy) foi concluída e validada, você DEVE:

1. **Propor encerramento**: "Tarefa concluída. Posso registrar a sessão em `Brain/02_Logs/YYYY-MM-DD.md` agora?"
2. **Se autorizado**, gravar (Write tool) usando frontmatter YAML + estrutura:
   ```markdown
   ---
   date: YYYY-MM-DD
   projeto: Gestou
   tipo: log-tecnico
   tags: [<área>, <tipo>, <domínio>]
   ---

   # Log Técnico — YYYY-MM-DD

   ## Sessão N: <título curto>

   ### Problema / Contexto
   <o que motivou a tarefa>

   ### Diagnóstico (quando aplicável)
   - **Causa raiz**: <análise>
   - **Código afetado**: `caminho/arquivo.php:linha`

   ### Ações Executadas
   1. <passo 1>
   2. <passo 2>

   ### Arquivos Modificados
   - `admin/file.php`
   - `app/other.php`

   ### Commits
   - `<hash>` <mensagem>

   ### Validação
   - <testes, deploy, screenshots>

   ### Pendências
   - <itens em aberto; se for crítico, espelhar em `docs/pendencias.md`>
   ```

   Se já houver log do dia, **acrescente** uma nova `## Sessão N+1` ao fim em vez de sobrescrever.

3. **Atualizar quando relevante**:
   - `progress.txt` se a sessão fechou uma fase ou entrega macro
   - `docs/pendencias.md` se restou item em aberto que precisa de outra sessão
   - `prd.json` se uma FEA/MIG foi entregue

4. **Higiene de contexto**: depois do log, recomende `/compact` se a conversa estiver longa.

5. **Higiene de arquivos locais**: após gravar o log no Brain (que já preserva contexto), **apague os artefatos transitórios de validação** acumulados na raiz do projeto. Esses arquivos serviram pra inspeção da sessão, o essencial já foi capturado no log/commit, e ficar no working tree só inflate a saída do `git status` e ocupa espaço local. Apagar:

   - **Screenshots/prints na raiz**: `rm -f /media/rafo/dados/IA/gestou/www/www/*.png` (preserva PNGs legítimos em `img/`, `admin/img/`, `app/img/` etc. — o glob `*.png` só pega a raiz)
   - **Sessões do Playwright MCP**: `rm -rf /media/rafo/dados/IA/gestou/www/www/.playwright-mcp/` (console logs, page snapshots)
   - **Pastas locais de screenshots**: `rm -rf .screenshots/ screenshots/` (se existirem)

   Já existe rede de proteção no `.gitignore` (`/*.png`, `.playwright-mcp/`, `screenshots/`, `.screenshots/`) que impede commit acidental — esse passo é só pra liberar disco e manter o working tree limpo. Se o usuário pediu pra preservar algum print específico (raro), pergunte antes de apagar.

**Tags por área (use combinação)**: `php`, `postgres`, `apache`, `frontend`, `backend`, `gcp`, `cloud-run`, `cloud-sql`, `gcs`, `ocr`, `azure-vision`, `smtp`, `auth`, `multi-tenant`, `session`, `migration`, `schema`, `payment`, `infra`, `docs`, `fix`, `feature`, `refactor`, `prd`, `fea`, `mig`.

**O que NÃO salvar**:
- Sessões triviais (só leitura, perguntas rápidas sem entrega)
- Comandos triviais (`ls`, `git status`, `cat`)
- Tentativas falhadas intermediárias se o resultado final foi alcançado por outro caminho
- Transcrição completa — capture o essencial
