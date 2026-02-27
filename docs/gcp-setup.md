# Setup GCP - Gestou

Guia completo para provisionar a infraestrutura do Gestou no Google Cloud Platform.

## Pre-requisitos

- [Google Cloud SDK (gcloud CLI)](https://cloud.google.com/sdk/docs/install) instalado
- Conta GCP com billing habilitado
- Acesso de Owner ou Editor no projeto

## 1. Configuracao inicial

```bash
# Definir variaveis do projeto
export PROJECT_ID="gestou-prod"
export REGION="southamerica-east1"
export ZONE="southamerica-east1-a"
export DB_INSTANCE="gestou-db"
export DB_NAME="gestou"
export DB_USER="gestou_app"
export BUCKET_NAME="gestou-uploads"
export REPO_NAME="gestou-repo"
export SERVICE_NAME="gestou-web"
export VPC_CONNECTOR="gestou-vpc-connector"
export DOMAIN="gestou.leveinovacao.com.br"

# Criar projeto (ou usar existente)
gcloud projects create $PROJECT_ID --name="Gestou" 2>/dev/null || echo "Projeto ja existe"

# Selecionar projeto
gcloud config set project $PROJECT_ID
gcloud config set compute/region $REGION
gcloud config set compute/zone $ZONE
```

## 2. Habilitar APIs

```bash
gcloud services enable \
  sqladmin.googleapis.com \
  run.googleapis.com \
  artifactregistry.googleapis.com \
  secretmanager.googleapis.com \
  vpcaccess.googleapis.com \
  storage.googleapis.com \
  vision.googleapis.com \
  compute.googleapis.com \
  cloudbuild.googleapis.com
```

## 3. Criar Cloud SQL (PostgreSQL 17)

```bash
# Criar instancia Cloud SQL
gcloud sql instances create $DB_INSTANCE \
  --database-version=POSTGRES_17 \
  --tier=db-f1-micro \
  --region=$REGION \
  --storage-type=SSD \
  --storage-size=10GB \
  --storage-auto-increase \
  --backup-start-time=03:00 \
  --availability-type=zonal \
  --no-assign-ip \
  --network=default

# Criar banco de dados
gcloud sql databases create $DB_NAME \
  --instance=$DB_INSTANCE

# Criar usuario
# IMPORTANTE: substitua SENHA_SEGURA por uma senha forte
gcloud sql users create $DB_USER \
  --instance=$DB_INSTANCE \
  --password="SENHA_SEGURA"

# Obter IP privado da instancia (anotar para Secret Manager)
gcloud sql instances describe $DB_INSTANCE \
  --format="value(ipAddresses[0].ipAddress)"
```

### Criar tabela de sessoes

Conecte ao banco via Cloud SQL Proxy ou pelo console e execute:

```sql
-- Criar tabela de sessoes PHP (ver config/schema/sessions.sql)
CREATE TABLE IF NOT EXISTS php_sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT NOT NULL DEFAULT '',
    last_access TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_php_sessions_last_access
    ON php_sessions (last_access);
```

## 4. Criar bucket Cloud Storage

```bash
# Criar bucket para uploads
gcloud storage buckets create gs://$BUCKET_NAME \
  --location=$REGION \
  --default-storage-class=STANDARD \
  --uniform-bucket-level-access

# Configurar CORS para acesso via browser (uploads de imagens/documentos)
cat > /tmp/cors.json << 'EOF'
[
  {
    "origin": ["https://gestou.leveinovacao.com.br"],
    "method": ["GET", "PUT", "POST"],
    "responseHeader": ["Content-Type"],
    "maxAgeSeconds": 3600
  }
]
EOF

gcloud storage buckets update gs://$BUCKET_NAME --cors-file=/tmp/cors.json

# Tornar objetos publicos para leitura (uploads acessados via URL)
gcloud storage buckets add-iam-policy-binding gs://$BUCKET_NAME \
  --member=allUsers \
  --role=roles/storage.objectViewer
```

## 5. Criar Artifact Registry

```bash
# Criar repositorio Docker
gcloud artifacts repositories create $REPO_NAME \
  --repository-format=docker \
  --location=$REGION \
  --description="Imagens Docker do Gestou"

# Configurar autenticacao Docker
gcloud auth configure-docker ${REGION}-docker.pkg.dev
```

## 6. Configurar Secret Manager

```bash
# Criar secrets para cada variavel sensivel
# IMPORTANTE: substitua os valores abaixo pelos valores reais

# Banco de dados
echo -n "IP_PRIVADO_CLOUD_SQL" | gcloud secrets create db-host --data-file=-
echo -n "5432" | gcloud secrets create db-port --data-file=-
echo -n "$DB_NAME" | gcloud secrets create db-name --data-file=-
echo -n "$DB_USER" | gcloud secrets create db-user --data-file=-
echo -n "SENHA_SEGURA" | gcloud secrets create db-pass --data-file=-

# SMTP (Google Workspace relay)
echo -n "smtp-relay.gmail.com" | gcloud secrets create smtp-host --data-file=-
echo -n "587" | gcloud secrets create smtp-port --data-file=-
echo -n "contato@leveinovacao.com.br" | gcloud secrets create smtp-user --data-file=-
echo -n "SENHA_SMTP" | gcloud secrets create smtp-pass --data-file=-
echo -n "contato@leveinovacao.com.br" | gcloud secrets create smtp-from --data-file=-
echo -n "GESTOU" | gcloud secrets create smtp-from-name --data-file=-

# App
echo -n "https://gestou.leveinovacao.com.br" | gcloud secrets create app-url --data-file=-
echo -n "contato@leveinovacao.com.br" | gcloud secrets create contact-email --data-file=-

# Storage
echo -n "gcs" | gcloud secrets create storage-driver --data-file=-
echo -n "$BUCKET_NAME" | gcloud secrets create gcs-bucket --data-file=-

# Google Vision API
echo -n "SUA_API_KEY_VISION" | gcloud secrets create google-vision-api-key --data-file=-

# Conceder acesso ao Cloud Run service account
export SA_EMAIL=$(gcloud iam service-accounts list \
  --filter="displayName:Compute Engine default" \
  --format="value(email)")

for SECRET in db-host db-port db-name db-user db-pass \
  smtp-host smtp-port smtp-user smtp-pass smtp-from smtp-from-name \
  app-url contact-email storage-driver gcs-bucket google-vision-api-key; do
  gcloud secrets add-iam-policy-binding $SECRET \
    --member="serviceAccount:$SA_EMAIL" \
    --role="roles/secretManager.secretAccessor"
done
```

## 7. Criar VPC Connector

Necessario para o Cloud Run acessar o Cloud SQL via IP privado.

```bash
gcloud compute networks vpc-access connectors create $VPC_CONNECTOR \
  --region=$REGION \
  --network=default \
  --range=10.8.0.0/28 \
  --min-instances=2 \
  --max-instances=3 \
  --machine-type=f1-micro
```

## 8. Build e push da imagem Docker

```bash
# Build da imagem
docker build -t ${REGION}-docker.pkg.dev/${PROJECT_ID}/${REPO_NAME}/${SERVICE_NAME}:latest .

# Push para Artifact Registry
docker push ${REGION}-docker.pkg.dev/${PROJECT_ID}/${REPO_NAME}/${SERVICE_NAME}:latest
```

### Build via Cloud Build (alternativa)

```bash
gcloud builds submit \
  --tag ${REGION}-docker.pkg.dev/${PROJECT_ID}/${REPO_NAME}/${SERVICE_NAME}:latest
```

## 9. Deploy no Cloud Run

```bash
gcloud run deploy $SERVICE_NAME \
  --image=${REGION}-docker.pkg.dev/${PROJECT_ID}/${REPO_NAME}/${SERVICE_NAME}:latest \
  --region=$REGION \
  --platform=managed \
  --port=8080 \
  --memory=1Gi \
  --cpu=1 \
  --min-instances=0 \
  --max-instances=3 \
  --timeout=300 \
  --vpc-connector=$VPC_CONNECTOR \
  --allow-unauthenticated \
  --set-secrets="\
DB_HOST=db-host:latest,\
DB_PORT=db-port:latest,\
DB_NAME=db-name:latest,\
DB_USER=db-user:latest,\
DB_PASS=db-pass:latest,\
SMTP_HOST=smtp-host:latest,\
SMTP_PORT=smtp-port:latest,\
SMTP_USER=smtp-user:latest,\
SMTP_PASS=smtp-pass:latest,\
SMTP_FROM=smtp-from:latest,\
SMTP_FROM_NAME=smtp-from-name:latest,\
APP_URL=app-url:latest,\
CONTACT_EMAIL=contact-email:latest,\
STORAGE_DRIVER=storage-driver:latest,\
GCS_BUCKET=gcs-bucket:latest,\
GOOGLE_VISION_API_KEY=google-vision-api-key:latest"

# Verificar URL do servico
gcloud run services describe $SERVICE_NAME \
  --region=$REGION \
  --format="value(status.url)"
```

## 10. Mapear dominio gestou.leveinovacao.com.br

### Opcao A: Mapeamento direto no Cloud Run

```bash
# Mapear dominio customizado
gcloud run domain-mappings create \
  --service=$SERVICE_NAME \
  --domain=$DOMAIN \
  --region=$REGION
```

Apos o comando, configure os registros DNS conforme indicado:

```
TIPO    NOME                              VALOR
CNAME   gestou.leveinovacao.com.br        ghs.googlehosted.com.
```

### Opcao B: Via Load Balancer (mais controle)

```bash
# Criar NEG serverless
gcloud compute network-endpoint-groups create gestou-neg \
  --region=$REGION \
  --network-endpoint-type=serverless \
  --cloud-run-service=$SERVICE_NAME

# Criar backend service
gcloud compute backend-services create gestou-backend \
  --global \
  --load-balancing-scheme=EXTERNAL_MANAGED

gcloud compute backend-services add-backend gestou-backend \
  --global \
  --network-endpoint-group=gestou-neg \
  --network-endpoint-group-region=$REGION

# Criar URL map
gcloud compute url-maps create gestou-urlmap \
  --default-service=gestou-backend

# Criar certificado SSL gerenciado
gcloud compute ssl-certificates create gestou-cert \
  --domains=$DOMAIN \
  --global

# Criar HTTPS proxy
gcloud compute target-https-proxies create gestou-https-proxy \
  --url-map=gestou-urlmap \
  --ssl-certificates=gestou-cert

# Criar forwarding rule
gcloud compute forwarding-rules create gestou-https-rule \
  --global \
  --target-https-proxy=gestou-https-proxy \
  --ports=443

# Obter IP do load balancer (configurar no DNS)
gcloud compute forwarding-rules describe gestou-https-rule \
  --global \
  --format="value(IPAddress)"
```

Configure o registro DNS:

```
TIPO    NOME                              VALOR
A       gestou.leveinovacao.com.br        IP_DO_LOAD_BALANCER
```

### Verificar certificado SSL

```bash
# Acompanhar provisionamento do certificado (pode levar ate 24h)
gcloud compute ssl-certificates describe gestou-cert \
  --global \
  --format="value(managed.status)"
```

## 11. Permissoes do Service Account

O service account do Cloud Run precisa de acesso ao Cloud Storage:

```bash
# Conceder acesso ao bucket de uploads
gcloud storage buckets add-iam-policy-binding gs://$BUCKET_NAME \
  --member="serviceAccount:$SA_EMAIL" \
  --role="roles/storage.objectAdmin"
```

## Estimativa de custos

Estimativa mensal para o ambiente de producao (regiao southamerica-east1):

| Servico | Configuracao | Custo estimado/mes |
|---------|-------------|-------------------|
| Cloud SQL | db-f1-micro, 10GB SSD, PostgreSQL 17 | ~US$ 10-15 |
| Cloud Run | min 0, max 3, 1GB RAM, 1 vCPU | ~US$ 0-25 (pay per use) |
| Cloud Storage | ~10GB uploads, Standard class | ~US$ 0.50-1 |
| Artifact Registry | ~1GB imagens Docker | ~US$ 0.10 |
| Secret Manager | 16 secrets, ~1000 acessos/dia | ~US$ 0.10 |
| VPC Connector | f1-micro, 2-3 instancias | ~US$ 15-20 |
| Cloud Vision API | ~500 paginas OCR/mes | ~US$ 0.75 |
| Load Balancer (opcional) | Forwarding rule + processamento | ~US$ 20-25 |
| **Total (sem LB)** | | **~US$ 25-60/mes** |
| **Total (com LB)** | | **~US$ 45-85/mes** |

### Notas sobre custos

- **Cloud Run** com min-instances=0 nao gera custo quando ocioso (cold start de ~3-5s)
- **Cloud SQL** db-f1-micro e a instancia mais barata; considere db-g1-small (~US$ 25/mes) para melhor performance
- **Cloud Storage** cobra por armazenamento + operacoes; uploads de holerites/documentos sao pequenos
- **VPC Connector** e o item de custo fixo mais significativo; necessario para acesso privado ao Cloud SQL
- **Vision API** cobra US$ 1.50/1000 paginas para TEXT_DETECTION; considere usar FILE_ANNOTATION para PDFs (preco pode variar)
- Custos de rede (egress) sao adicionais mas geralmente baixos para aplicacoes web

### Otimizacoes de custo

- Use **Cloud SQL Auth Proxy** como sidecar no Cloud Run em vez de VPC Connector para eliminar custo fixo do connector (~US$ 15-20/mes)
- Configure **alertas de billing** para evitar surpresas: `gcloud billing budgets create`
- Revise a politica de **lifecycle** do bucket para mover uploads antigos para Nearline/Coldline
- Considere **committed use discounts** para Cloud SQL se o uso for estavel
