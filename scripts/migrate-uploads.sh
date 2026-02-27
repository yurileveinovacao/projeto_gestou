#!/usr/bin/env bash
# =============================================================================
# migrate-uploads.sh — Migração de uploads para Google Cloud Storage
#
# Sincroniza os diretórios de upload do servidor de origem para um bucket GCS.
# Usa gsutil rsync para copiar apenas arquivos novos/alterados.
#
# Uso:
#   ./scripts/migrate-uploads.sh
#
# Variáveis de ambiente necessárias:
#   GCS_BUCKET — Nome do bucket GCS (ex: gestou-uploads)
#
# Opcionais:
#   UPLOADS_SOURCE_DIR — Caminho dos uploads no servidor (default: /var/www/html)
#   DRY_RUN — Se "true", apenas mostra o que seria copiado (default: false)
# =============================================================================

set -euo pipefail

# ---------------------------------------------------------------------------
# Cores para output
# ---------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# ---------------------------------------------------------------------------
# Configuração
# ---------------------------------------------------------------------------
GCS_BUCKET="${GCS_BUCKET:?Defina GCS_BUCKET (ex: gestou-uploads)}"
UPLOADS_SOURCE_DIR="${UPLOADS_SOURCE_DIR:-/var/www/html}"
DRY_RUN="${DRY_RUN:-false}"

# Flags do gsutil rsync
GSUTIL_FLAGS="-r"  # Recursivo
if [ "${DRY_RUN}" = "true" ]; then
    GSUTIL_FLAGS="${GSUTIL_FLAGS} -n"  # Dry-run: apenas mostra o que seria copiado
fi

echo -e "${YELLOW}=== Migração de Uploads — Gestou ===${NC}"
echo ""

# ---------------------------------------------------------------------------
# Passo 1: Verificar ferramentas necessárias
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/4] Verificando ferramentas...${NC}"

if ! command -v gsutil &> /dev/null; then
    echo -e "${RED}ERRO: gsutil não encontrado. Instale o Google Cloud SDK.${NC}"
    echo "  https://cloud.google.com/sdk/docs/install"
    exit 1
fi

echo -e "${GREEN}  gsutil disponível.${NC}"

# ---------------------------------------------------------------------------
# Passo 2: Verificar acesso ao bucket
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/4] Verificando acesso ao bucket...${NC}"
echo "  Bucket: gs://${GCS_BUCKET}"

if ! gsutil ls "gs://${GCS_BUCKET}" &> /dev/null; then
    echo -e "${RED}ERRO: Não foi possível acessar gs://${GCS_BUCKET}${NC}"
    echo "  Verifique se o bucket existe e se você tem permissão."
    exit 1
fi

echo -e "${GREEN}  Bucket acessível.${NC}"

if [ "${DRY_RUN}" = "true" ]; then
    echo -e "${YELLOW}  MODO DRY-RUN: nenhum arquivo será copiado.${NC}"
fi

# ---------------------------------------------------------------------------
# Passo 3: Sincronizar diretórios de upload
#
# Estrutura de uploads:
#   upload/          → Uploads de colaboradores (fotos, docs) — ~8.7GB
#   admin/uploads/   → Uploads do painel admin — ~36MB
#   master/upload/   → Uploads do super-admin
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/4] Sincronizando diretórios de upload...${NC}"

# Array de diretórios de upload com seus destinos no bucket
declare -a UPLOAD_DIRS=(
    "upload:upload"
    "admin/uploads:admin/uploads"
    "master/upload:master/upload"
)

TOTAL_FILES=0
TOTAL_ERRORS=0

for mapping in "${UPLOAD_DIRS[@]}"; do
    # Separar origem:destino
    LOCAL_DIR="${mapping%%:*}"
    GCS_PATH="${mapping##*:}"
    FULL_LOCAL_PATH="${UPLOADS_SOURCE_DIR}/${LOCAL_DIR}"

    echo ""
    echo -e "  ${YELLOW}→ ${LOCAL_DIR}/${NC}"

    # Verificar se o diretório existe
    if [ ! -d "${FULL_LOCAL_PATH}" ]; then
        echo -e "  ${YELLOW}  AVISO: ${FULL_LOCAL_PATH} não encontrado, pulando.${NC}"
        continue
    fi

    # Contar arquivos para estimativa
    FILE_COUNT=$(find "${FULL_LOCAL_PATH}" -type f 2>/dev/null | wc -l)
    DIR_SIZE=$(du -sh "${FULL_LOCAL_PATH}" 2>/dev/null | cut -f1)
    echo "    Arquivos: ${FILE_COUNT}, Tamanho: ${DIR_SIZE}"

    # Executar gsutil rsync
    if gsutil ${GSUTIL_FLAGS} rsync \
        "${FULL_LOCAL_PATH}" \
        "gs://${GCS_BUCKET}/${GCS_PATH}" 2>&1; then
        echo -e "    ${GREEN}Sincronizado.${NC}"
        TOTAL_FILES=$((TOTAL_FILES + FILE_COUNT))
    else
        echo -e "    ${RED}ERRO ao sincronizar ${LOCAL_DIR}${NC}"
        TOTAL_ERRORS=$((TOTAL_ERRORS + 1))
    fi
done

# ---------------------------------------------------------------------------
# Passo 4: Resumo final
# ---------------------------------------------------------------------------
echo ""
echo -e "${GREEN}=== Migração de uploads concluída ===${NC}"
echo "  Arquivos processados: ~${TOTAL_FILES}"
echo "  Erros: ${TOTAL_ERRORS}"
echo "  Bucket: gs://${GCS_BUCKET}"

if [ "${DRY_RUN}" = "true" ]; then
    echo ""
    echo -e "${YELLOW}  Este foi um DRY-RUN. Para executar de verdade:${NC}"
    echo "    DRY_RUN=false ./scripts/migrate-uploads.sh"
fi

if [ ${TOTAL_ERRORS} -gt 0 ]; then
    echo ""
    echo -e "${RED}  ATENÇÃO: Houve erros durante a sincronização.${NC}"
    echo "  Verifique os logs acima e re-execute o script (gsutil rsync é idempotente)."
    exit 1
fi

echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Verifique os arquivos no bucket: gsutil ls gs://${GCS_BUCKET}/"
echo "  2. Configure STORAGE_DRIVER=gcs e GCS_BUCKET=${GCS_BUCKET} na aplicação"
echo "  3. Teste o acesso aos uploads pela aplicação"
