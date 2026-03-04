#!/usr/bin/env bash
# =============================================================================
# migrate-uploads.sh — Migração de uploads para Google Cloud Storage
#
# Sincroniza os diretórios de upload para o bucket GCS.
# Usa gcloud storage rsync para copiar apenas arquivos novos/alterados.
#
# Uso:
#   ./scripts/migrate-uploads.sh [UPLOADS_DIR]
#
# Argumentos:
#   UPLOADS_DIR — Caminho local da pasta upload/ (default: ./upload)
#
# Variáveis de ambiente (opcionais):
#   GCS_BUCKET  — Nome do bucket (default: gestou-uploads-489010)
#   DRY_RUN     — Se "true", apenas mostra o que seria copiado
# =============================================================================

set -euo pipefail

# ---------------------------------------------------------------------------
# Cores
# ---------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# ---------------------------------------------------------------------------
# Configuração
# ---------------------------------------------------------------------------
UPLOADS_DIR="${1:-./upload}"
GCS_BUCKET="${GCS_BUCKET:-gestou-uploads-489010}"
DRY_RUN="${DRY_RUN:-false}"

echo -e "${YELLOW}=== Migração de Uploads — Gestou ===${NC}"
echo ""

# ---------------------------------------------------------------------------
# Passo 1: Verificar pré-requisitos
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/3] Verificando pré-requisitos...${NC}"

if ! command -v gcloud &> /dev/null; then
    echo -e "${RED}ERRO: gcloud não encontrado. Instale o Google Cloud SDK.${NC}"
    exit 1
fi

if [ ! -d "${UPLOADS_DIR}" ]; then
    echo -e "${RED}ERRO: Diretório ${UPLOADS_DIR} não encontrado.${NC}"
    exit 1
fi

# Verificar acesso ao bucket
if ! gcloud storage ls "gs://${GCS_BUCKET}" &> /dev/null; then
    echo -e "${RED}ERRO: Não foi possível acessar gs://${GCS_BUCKET}${NC}"
    exit 1
fi

# Contar arquivos e tamanho
FILE_COUNT=$(find "${UPLOADS_DIR}" -type f 2>/dev/null | wc -l)
DIR_SIZE=$(du -sh "${UPLOADS_DIR}" 2>/dev/null | cut -f1)

echo -e "  Origem: ${UPLOADS_DIR}"
echo -e "  Destino: gs://${GCS_BUCKET}/upload/"
echo -e "  Arquivos: ${FILE_COUNT}"
echo -e "  Tamanho: ${DIR_SIZE}"
echo -e "${GREEN}  OK.${NC}"

if [ "${DRY_RUN}" = "true" ]; then
    echo -e "${YELLOW}  MODO DRY-RUN: nenhum arquivo será copiado.${NC}"
fi

# ---------------------------------------------------------------------------
# Passo 2: Sincronizar
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/3] Sincronizando uploads...${NC}"

if [ "${DRY_RUN}" = "true" ]; then
    gcloud storage rsync "${UPLOADS_DIR}" "gs://${GCS_BUCKET}/upload/" --recursive --dry-run
else
    gcloud storage rsync "${UPLOADS_DIR}" "gs://${GCS_BUCKET}/upload/" --recursive
fi

echo -e "${GREEN}  Sincronização concluída.${NC}"

# ---------------------------------------------------------------------------
# Passo 3: Validação
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/3] Validando...${NC}"

BUCKET_COUNT=$(gcloud storage ls "gs://${GCS_BUCKET}/upload/" --recursive 2>/dev/null | wc -l)

echo -e "  Arquivos locais: ${FILE_COUNT}"
echo -e "  Objetos no bucket: ${BUCKET_COUNT} (inclui pastas)"

# ---------------------------------------------------------------------------
# Resumo
# ---------------------------------------------------------------------------
echo ""
echo -e "${GREEN}=== Upload concluído ===${NC}"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Verificar: gcloud storage ls gs://${GCS_BUCKET}/upload/ | head -20"
echo "  2. Para usar GCS na app, configure STORAGE_DRIVER=gcs no Cloud Run"
