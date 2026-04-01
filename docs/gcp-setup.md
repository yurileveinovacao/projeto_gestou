# Setup GCP - Gestou

Guia completo para provisionar a infraestrutura do Gestou no Google Cloud Platform.
Baseado na migração executada em março/2026.

## Arquitetura atual

```
Usuário → gestou.leveinovacao.com.br (Cloudflare DNS)
       → ghs.googlehosted.com (Cloud Run domain mapping)
       → Cloud Run (us-central1, PHP 7.4 + Apache)
       → Cloud SQL PostgreSQL 17 (via Unix socket /cloudsql/)
       → Cloud Storage (uploads, gs://gestou-uploads-489010)
```

## Dados do projeto

| Recurso | Valor |
|---------|-------|
| Projeto GCP | `gestou-489010` |
| Região | `us-central1` |
| Cloud SQL | `gestou-db` (db-f1-micro, PostgreSQL 17) |
| Bucket | `gs://gestou-uploads-489010` |
| Artifact Registry | `gestou-repo` (us-central1) |
| VPC Connector | `gestou-connector` (us-central1) |
| Domínio | `gestou.leveinovacao.com.br` |
| DNS | Cloudflare (CNAME → ghs.googlehosted.com, proxy OFF) |
| Secrets | `db-password`, `smtp-password`, `azure-vision-endpoint`, `azure-vision-key` |
| Service Account | `469696711631-compute@developer.gserviceaccount.com` |

## Pré-requisitos

- [Google Cloud SDK (gcloud CLI)](https://cloud.google.com/sdk/docs/install) instalado
- Conta GCP com billing habilitado
- Acesso de Owner ou Editor no projeto
- Docker instalado (para build de imagens)

## 1. Configuração inicial

```bash
# Selecionar projeto
gcloud config set project gestou-489010

# Autenticar (se necessário)
gcloud auth login
gcloud auth application-default login
```

## 2. Habilitar APIs

```bash
gcloud services enable \
  run.googleapis.com \
  sqladmin.googleapis.com \
  storage.googleapis.com \
  # vision.googleapis.com \ # Removido — OCR agora usa Azure Computer Vision
  secretmanager.googleapis.com \
  artifactregistry.googleapis.com \
  vpcaccess.googleapis.com \
  compute.googleapis.com
```

## 3. Cloud SQL (PostgreSQL 17)

```bash
# Criar instância
gcloud sql instances create gestou-db \
  --database-version=POSTGRES_17 \
  --tier=db-f1-micro \
  --region=us-central1 \
  --storage-type=SSD \
  --storage-size=10GB \
  --availability-type=zonal \
  --edition=enterprise

# Criar banco de dados
gcloud sql databases create gestou --instance=gestou-db

# Criar usuário (gerar senha segura)
NEW_PASS=$(openssl rand -base64 24)
echo "ANOTE A SENHA: $NEW_PASS"
gcloud sql users create gestou --instance=gestou-db --password="$NEW_PASS"
```

### Conexão ao banco

O Cloud Run conecta ao Cloud SQL via **Unix socket** (não IP público):
- Socket path: `/cloudsql/gestou-489010:us-central1:gestou-db`
- Configurado via `--add-cloudsql-instances` no deploy

Para acesso local (manutenção, dumps), use o **Cloud SQL Auth Proxy**:

```bash
# Baixar proxy
curl -o cloud-sql-proxy https://storage.googleapis.com/cloud-sql-connectors/cloud-sql-proxy/v2.14.3/cloud-sql-proxy.linux.amd64
chmod +x cloud-sql-proxy

# Iniciar proxy (porta local 5434)
./cloud-sql-proxy --port 5434 gestou-489010:us-central1:gestou-db &

# Conectar via psql
docker run --rm --network host -e PGPASSWORD="SENHA" postgres:17 \
  psql -h 127.0.0.1 -p 5434 -U gestou -d gestou
```

### Tabela de sessões

```sql
CREATE TABLE IF NOT EXISTS php_sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT NOT NULL DEFAULT '',
    last_access TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_php_sessions_last_access
    ON php_sessions (last_access);
```

## 4. Cloud Storage

```bash
gcloud storage buckets create gs://gestou-uploads-489010 --location=us-central1
```

## 5. Artifact Registry

```bash
gcloud artifacts repositories create gestou-repo \
  --repository-format=docker \
  --location=us-central1 \
  --description="Gestou Docker images"

gcloud auth configure-docker us-central1-docker.pkg.dev
```

## 6. Secret Manager

```bash
# Senha do banco
echo -n "SENHA_DB" | gcloud secrets create db-password --data-file=-

# Senha SMTP (senha de app do Google Workspace)
echo -n "SENHA_SMTP" | gcloud secrets create smtp-password --data-file=-

# Azure Computer Vision (OCR)
echo -n "https://testegestou.cognitiveservices.azure.com" | gcloud secrets create azure-vision-endpoint --data-file=-
echo -n "CHAVE_AZURE" | gcloud secrets create azure-vision-key --data-file=-

# Dar permissão ao service account do Cloud Run
for SECRET in db-password smtp-password azure-vision-endpoint azure-vision-key; do
  gcloud secrets add-iam-policy-binding $SECRET \
    --member="serviceAccount:469696711631-compute@developer.gserviceaccount.com" \
    --role="roles/secretmanager.secretAccessor"
done
```

## 7. VPC Connector

```bash
gcloud compute networks vpc-access connectors create gestou-connector \
  --region=us-central1 \
  --range=10.8.0.0/28
```

## 8. Permissões IAM

```bash
# Cloud SQL client (necessário para Unix socket)
gcloud projects add-iam-policy-binding gestou-489010 \
  --member="serviceAccount:469696711631-compute@developer.gserviceaccount.com" \
  --role="roles/cloudsql.client"
```

## 9. Build e push da imagem Docker

```bash
docker build -t us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:v1 .
docker push us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:v1
```

## 10. Deploy no Cloud Run

```bash
gcloud run deploy gestou \
  --image=us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:v1 \
  --region=us-central1 \
  --platform=managed \
  --port=8080 \
  --memory=1Gi \
  --min-instances=0 \
  --max-instances=3 \
  --vpc-connector=gestou-connector \
  --add-cloudsql-instances=gestou-489010:us-central1:gestou-db \
  --set-env-vars="DB_HOST=/cloudsql/gestou-489010:us-central1:gestou-db,DB_PORT=5432,DB_NAME=gestou,DB_USER=gestou,APP_URL=https://gestou.leveinovacao.com.br,SMTP_HOST=smtp-relay.gmail.com,SMTP_PORT=587,SMTP_USER=contato@leveinovacao.com.br,SMTP_FROM=contato@leveinovacao.com.br,SMTP_FROM_NAME=GESTOU,STORAGE_DRIVER=local,CONTACT_EMAIL=contato@leveinovacao.com.br" \
  --set-secrets="DB_PASS=db-password:latest,SMTP_PASS=smtp-password:latest,AZURE_VISION_ENDPOINT=azure-vision-endpoint:latest,AZURE_VISION_KEY=azure-vision-key:latest" \
  --allow-unauthenticated
```

> **Nota:** Se a org policy bloquear `--allow-unauthenticated`, libere manualmente
> no console: Cloud Run → gestou → Segurança → Permitir acesso público.

## 11. Domain mapping e DNS

```bash
# Mapear domínio (funciona em us-central1, NÃO funciona em southamerica-east1)
gcloud beta run domain-mappings create \
  --service=gestou \
  --domain=gestou.leveinovacao.com.br \
  --region=us-central1
```

### Configuração DNS (Cloudflare)

| Tipo | Nome | Destino | Proxy |
|------|------|---------|-------|
| CNAME | gestou | ghs.googlehosted.com | **OFF** (somente DNS, nuvem cinza) |

> **Importante:** O proxy do Cloudflare (nuvem laranja) deve estar **desativado**
> para que o Google consiga provisionar o certificado SSL.

O certificado SSL é provisionado automaticamente pelo Google (pode levar até 15 min).

Verificar status:

```bash
gcloud beta run domain-mappings describe \
  --domain=gestou.leveinovacao.com.br \
  --region=us-central1
```

## Estimativa de custos (us-central1)

| Serviço | Configuração | Custo estimado/mês |
|---------|-------------|-------------------|
| Cloud SQL | db-f1-micro, 10GB SSD, PostgreSQL 17 | ~US$ 8-12 |
| Cloud Run | min 0, max 3, 1GB RAM | ~US$ 0-20 (pay per use) |
| Cloud Storage | ~10GB uploads | ~US$ 0.25 |
| Artifact Registry | ~500MB imagens | ~US$ 0.05 |
| Secret Manager | 2 secrets | ~US$ 0.06 |
| VPC Connector | 2-3 instâncias e2-micro | ~US$ 10-15 |
| Azure Computer Vision | ~500 páginas/mês (S1) | ~US$ 0.50 |
| **Total** | | **~US$ 20-50/mês** |

### Notas

- Cloud Run com min-instances=0 não gera custo quando ocioso (cold start ~3-5s)
- us-central1 é ~20% mais barato que southamerica-east1
- Latência adicional de ~100-150ms para usuários no Brasil (aceitável para o volume de uso)

## Decisões de arquitetura

| Decisão | Escolha | Motivo |
|---------|---------|--------|
| Região | us-central1 | Domain mapping não funciona em southamerica-east1; Load Balancer custaria +$20/mês |
| Conexão DB | Unix socket via Cloud SQL connector | IP público requer whitelist; socket é automático e seguro |
| DNS | Cloudflare CNAME | Já utilizado para leveinovacao.com.br |
| Sessões | PostgreSQL (PgSessionHandler) | Cloud Run é stateless; sessões em filesystem se perdem no restart |
| OCR | Azure Computer Vision API | Retorno ao Azure após Google Vision apresentar ordenação aleatória de texto; 64/64 valores corretos |
