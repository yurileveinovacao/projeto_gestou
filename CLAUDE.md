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
/docs/         → Documentação e planos
/scripts/      → Scripts de migração e utilitários
```

## Arquitetura de Produção

| Componente | Valor |
|-----------|-------|
| Projeto GCP | gestou-489010 |
| Região | us-central1 |
| Cloud Run Service | gestou (gen2, porta 8080, 1Gi RAM, 0-3 instâncias) |
| Cloud SQL Instance | gestou-489010:us-central1:gestou-db (PostgreSQL 17, db-f1-micro) |
| GCS Bucket | gs://gestou-uploads-489010 |
| Artifact Registry | us-central1-docker.pkg.dev/gestou-489010/gestou-repo |
| VPC Connector | gestou-connector |
| Domain | gestou.leveinovacao.com.br → ghs.googlehosted.com (CNAME, Cloudflare proxy OFF) |
| Service Account | 469696711631-compute@developer.gserviceaccount.com |
| Secrets (Secret Manager) | db-password, smtp-password, google-vision-api-key |
| SMTP | smtp.gmail.com:587 (contato@leveinovacao.com.br) |

## Regras ABSOLUTAS

- NUNCA altere arquivos em vendor/ ou vendor_* (dependências externas)
- NUNCA altere .gitignore para remover vendor/ (eles ficam fora do git)
- Use __DIR__ para paths em require (ex: `require __DIR__.'/../config/database.php'`)
- PHP 7.4 — sem union types, sem match(), sem named arguments, sem readonly
- Commits semânticos: feat:, refactor:, fix:, docs:, chore:

## Templates OCR (admin/layout/)

- 83 templates de OCR (holerite/irrf/ponto) — alterar APENAS quando necessário para compatibilidade com Google Vision
- Problemas conhecidos: Google Vision retorna texto em ordem diferente do Azure (ano antes do CNPJ, campos em linhas separadas)
- Ao corrigir templates: adicionar detecção antecipada de ano + mkdir dinâmico para GCS FUSE
- Referência de fixes aplicados: progress.txt (seção Fase 4B)

## Configs centralizados (config/)

| Arquivo | Função | Env vars |
|---------|--------|----------|
| `database.php` | Conexões pg_connect (legado) e PDO. Exporta `$conn` e `$pdo` | DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS |
| `mail.php` | Configura PHPMailer SMTP. Função `configureMailer(&$mail)` | SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS, SMTP_FROM, SMTP_FROM_NAME |
| `storage.php` | Abstração local/GCS. Funções: storageUpload/Delete/Url/Exists | STORAGE_DRIVER (`local`\|`gcs`), GCS_BUCKET |
| `app.php` | URL base e email de contato | APP_URL, CONTACT_EMAIL |
| `session.php` | Sessões em PostgreSQL (tabela `php_sessions`). Requer database.php | (nenhuma própria — usa DB_*) |
| `ocr.php` | Google Vision OCR com conversão para formato Azure | GOOGLE_VISION_API_KEY |

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
  --memory=1Gi \
  --min-instances=0 \
  --max-instances=3 \
  --vpc-connector=gestou-connector \
  --add-cloudsql-instances=gestou-489010:us-central1:gestou-db \
  --set-env-vars="DB_HOST=/cloudsql/gestou-489010:us-central1:gestou-db,DB_PORT=5432,DB_NAME=gestou,DB_USER=gestou,APP_URL=https://gestou.leveinovacao.com.br,SMTP_HOST=smtp.gmail.com,SMTP_PORT=587,SMTP_USER=contato@leveinovacao.com.br,SMTP_FROM=contato@leveinovacao.com.br,SMTP_FROM_NAME=GESTOU,STORAGE_DRIVER=local,CONTACT_EMAIL=contato@leveinovacao.com.br" \
  --set-secrets="DB_PASS=db-password:latest,SMTP_PASS=smtp-password:latest,GOOGLE_VISION_API_KEY=google-vision-api-key:latest" \
  --allow-unauthenticated
```

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

## Status Atual

**Fase 5 — App Android TWA** (em andamento, 15/21 tarefas)
- Track A: Conta Play Console (D-U-N-S, cadastro) — **pendente do cliente** (0/6)
- Track B: PWA — **completo** (7/7) — Lighthouse score 100, deploy feito
- Track C: Build TWA — **completo** (8/8) — APK assinado, assetlinks validado, teste OK no emulador

## Referência

- `progress.txt` — log ativo de progresso (Fase 4B+) e Codebase Patterns
- `docs/plano-migracao-gestou-consolidado.md` — plano completo das Fases 4B-6
- `prd.json` — PRD original da migração GCP (12 stories, 100% concluído)
- `docs/progress-prd-original.txt` — log histórico detalhado das 12 stories do PRD
