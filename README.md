# Gestou

Sistema de RH/folha multi-tenant — automação de Departamento Pessoal: holerite digital,
aceite eletrônico, gestão documental, ponto, IRRF, justificativas, observações de RH.

**Status:** em produção em [gestou.com.br](https://gestou.com.br) desde 2026-04-24.

## Stack

- **PHP 7.4** puro (sem framework) sobre Apache 2.4
- **PostgreSQL 17** (Cloud SQL)
- **Google Cloud Platform** — Cloud Run (gen2), Cloud SQL, GCS bucket via gcsfuse, Artifact Registry, Secret Manager
- **Azure Computer Vision** pra OCR de holerite/IRRF/ponto
- **PWA + TWA** pro app Android (em fase final de publicação)

## Setup local

Pré-requisitos: Docker, gcloud CLI autenticado em `gestou-489010`.

```bash
# 1. Subir Cloud SQL Proxy pra apontar pro banco de produção
./cloud-sql-proxy --port 5434 gestou-489010:us-central1:gestou-db &

# 2. Build e run via Docker (mesma imagem do Cloud Run)
docker build -t gestou-local .
docker run --rm -p 8080:8080 \
  -e DB_HOST=host.docker.internal -e DB_PORT=5434 \
  -e DB_USER=gestou -e DB_NAME=gestou \
  -e DB_PASS="$(gcloud secrets versions access latest --secret=db-password --project=gestou-489010)" \
  gestou-local

# 3. Acesse http://localhost:8080
```

Para testar fluxos que precisam dos uploads no GCS, defina `STORAGE_DRIVER=gcs` e `GCS_BUCKET=gestou-uploads-489010`.

## Estrutura

| Pasta | O que tem |
|---|---|
| `/` (raiz) | Site público (landing, contato, validar holerite) |
| `admin/` | Painel RH (158 PHP, `iuds_pdo.php` é o DAL principal — 11k linhas) |
| `app/` | Portal do colaborador (76 PHP) — também é a base do PWA |
| `master/` | Super-admin (51 PHP) — cadastro de menus, permissões, empresas |
| `createemployee/`, `createaccount/` | Onboarding via token + auto-registro |
| `config/` | Configs centralizados — database, mail, session, storage |
| `scripts/migrations/` | Scripts SQL idempotentes pra alterações de schema |
| `docs/` | Plano de migração, gcp-setup, test-checklist, log histórico |

## Convenções

- **Commits semânticos**: `feat:`, `fix:`, `refactor:`, `docs:`, `chore:`
- **PHP 7.4** — sem union types, match(), named arguments, readonly
- **Sem framework** — qualquer dependência em `vendor/` ou `vendor_*/` (NÃO mexer)
- **Multi-tenant por CNPJ** — várias tabelas têm sufixo `_<cnpj>` (ex: `GESIM1_44178441` = imagens da empresa X)
- **Branch principal**: `migration/gcp` (será mergeada pra `main` em breve)

## Deploy

Manual, sem CI/CD configurado. Comando completo na [seção Deploy do CLAUDE.md](CLAUDE.md#deploy-processo-manual). Resumo:

```bash
docker build -t us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest .
docker push us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest
gcloud run services update gestou --project=gestou-489010 --region=us-central1 \
  --image=us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest
```

## Documentação adicional

| Arquivo | Pra que serve |
|---|---|
| [`CLAUDE.md`](CLAUDE.md) | Instruções operacionais: arquitetura, configs, deploy, convenções (também usado por agentes Claude) |
| [`progress.txt`](progress.txt) | Log cronológico de entregas — referência pra "o que foi feito quando" |
| [`prd.json`](prd.json) | PRD cumulativo com MIG-001~012 (migração) e FEA-001~007 (features novas) |
| [`docs/plano-migracao-gestou-consolidado.md`](docs/plano-migracao-gestou-consolidado.md) | Plano histórico das 6 fases da migração GCP |
| [`docs/test-checklist.md`](docs/test-checklist.md) | Checklist de testes manuais usado pré-cutover |

## Contato

Time: [contato@leveinovacao.com.br](mailto:contato@leveinovacao.com.br) — Leve Inovação Estratégica.
