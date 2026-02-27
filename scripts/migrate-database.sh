#!/usr/bin/env bash
# =============================================================================
# migrate-database.sh — Migração do banco PostgreSQL para Cloud SQL (GCP)
#
# Faz pg_dump do banco de origem e pg_restore no Cloud SQL de destino.
# Também garante que a tabela php_sessions existe no destino.
#
# Uso:
#   ./scripts/migrate-database.sh
#
# Variáveis de ambiente necessárias:
#   SOURCE_DB_HOST, SOURCE_DB_PORT, SOURCE_DB_NAME, SOURCE_DB_USER, SOURCE_DB_PASS
#   TARGET_DB_HOST, TARGET_DB_PORT, TARGET_DB_NAME, TARGET_DB_USER, TARGET_DB_PASS
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
# Configuração do banco de ORIGEM (hosting atual)
# ---------------------------------------------------------------------------
SOURCE_DB_HOST="${SOURCE_DB_HOST:?Defina SOURCE_DB_HOST}"
SOURCE_DB_PORT="${SOURCE_DB_PORT:-5432}"
SOURCE_DB_NAME="${SOURCE_DB_NAME:?Defina SOURCE_DB_NAME}"
SOURCE_DB_USER="${SOURCE_DB_USER:?Defina SOURCE_DB_USER}"
SOURCE_DB_PASS="${SOURCE_DB_PASS:?Defina SOURCE_DB_PASS}"

# ---------------------------------------------------------------------------
# Configuração do banco de DESTINO (Cloud SQL)
# ---------------------------------------------------------------------------
TARGET_DB_HOST="${TARGET_DB_HOST:?Defina TARGET_DB_HOST}"
TARGET_DB_PORT="${TARGET_DB_PORT:-5432}"
TARGET_DB_NAME="${TARGET_DB_NAME:?Defina TARGET_DB_NAME}"
TARGET_DB_USER="${TARGET_DB_USER:?Defina TARGET_DB_USER}"
TARGET_DB_PASS="${TARGET_DB_PASS:?Defina TARGET_DB_PASS}"

# ---------------------------------------------------------------------------
# Diretório para armazenar o dump temporário
# ---------------------------------------------------------------------------
DUMP_DIR="${DUMP_DIR:-/tmp}"
DUMP_FILE="${DUMP_DIR}/gestou_dump_$(date +%Y%m%d_%H%M%S).sql"

# ---------------------------------------------------------------------------
# Caminho para o schema de sessões
# ---------------------------------------------------------------------------
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SESSIONS_SQL="${SCRIPT_DIR}/../config/schema/sessions.sql"

echo -e "${YELLOW}=== Migração de Banco de Dados — Gestou ===${NC}"
echo ""

# ---------------------------------------------------------------------------
# Passo 1: Verificar ferramentas necessárias
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/5] Verificando ferramentas...${NC}"

for cmd in pg_dump pg_restore psql; do
    if ! command -v "$cmd" &> /dev/null; then
        echo -e "${RED}ERRO: $cmd não encontrado. Instale o PostgreSQL client.${NC}"
        exit 1
    fi
done

echo -e "${GREEN}  pg_dump, pg_restore e psql disponíveis.${NC}"

# ---------------------------------------------------------------------------
# Passo 2: Exportar dump do banco de origem
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/5] Exportando dump do banco de origem...${NC}"
echo "  Host: ${SOURCE_DB_HOST}:${SOURCE_DB_PORT}"
echo "  Banco: ${SOURCE_DB_NAME}"
echo "  Dump: ${DUMP_FILE}"

PGPASSWORD="${SOURCE_DB_PASS}" pg_dump \
    -h "${SOURCE_DB_HOST}" \
    -p "${SOURCE_DB_PORT}" \
    -U "${SOURCE_DB_USER}" \
    -d "${SOURCE_DB_NAME}" \
    --no-owner \
    --no-privileges \
    --clean \
    --if-exists \
    -F p \
    -f "${DUMP_FILE}"

DUMP_SIZE=$(du -h "${DUMP_FILE}" | cut -f1)
echo -e "${GREEN}  Dump concluído (${DUMP_SIZE}).${NC}"

# ---------------------------------------------------------------------------
# Passo 3: Criar banco de destino (se não existir)
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/5] Preparando banco de destino...${NC}"
echo "  Host: ${TARGET_DB_HOST}:${TARGET_DB_PORT}"
echo "  Banco: ${TARGET_DB_NAME}"

# Tenta criar o banco; ignora erro se já existir
PGPASSWORD="${TARGET_DB_PASS}" psql \
    -h "${TARGET_DB_HOST}" \
    -p "${TARGET_DB_PORT}" \
    -U "${TARGET_DB_USER}" \
    -d "postgres" \
    -c "CREATE DATABASE ${TARGET_DB_NAME};" 2>/dev/null || true

echo -e "${GREEN}  Banco de destino pronto.${NC}"

# ---------------------------------------------------------------------------
# Passo 4: Restaurar dump no destino
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[4/5] Restaurando dump no banco de destino...${NC}"

PGPASSWORD="${TARGET_DB_PASS}" psql \
    -h "${TARGET_DB_HOST}" \
    -p "${TARGET_DB_PORT}" \
    -U "${TARGET_DB_USER}" \
    -d "${TARGET_DB_NAME}" \
    -f "${DUMP_FILE}" \
    --single-transaction \
    2>&1 | tail -5

echo -e "${GREEN}  Restauração concluída.${NC}"

# ---------------------------------------------------------------------------
# Passo 5: Criar tabela php_sessions (necessária para Cloud Run)
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[5/5] Criando tabela php_sessions...${NC}"

if [ -f "${SESSIONS_SQL}" ]; then
    PGPASSWORD="${TARGET_DB_PASS}" psql \
        -h "${TARGET_DB_HOST}" \
        -p "${TARGET_DB_PORT}" \
        -U "${TARGET_DB_USER}" \
        -d "${TARGET_DB_NAME}" \
        -f "${SESSIONS_SQL}"
    echo -e "${GREEN}  Tabela php_sessions criada/verificada.${NC}"
else
    echo -e "${RED}  AVISO: ${SESSIONS_SQL} não encontrado. Crie a tabela manualmente.${NC}"
fi

# ---------------------------------------------------------------------------
# Resumo final
# ---------------------------------------------------------------------------
echo ""
echo -e "${GREEN}=== Migração concluída com sucesso ===${NC}"
echo "  Dump salvo em: ${DUMP_FILE}"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Execute scripts/validate-migration.sh para verificar a integridade"
echo "  2. Execute scripts/migrate-uploads.sh para migrar os arquivos"
echo "  3. Teste o healthcheck: curl http://SEU_DOMINIO/scripts/healthcheck.php"
