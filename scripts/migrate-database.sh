#!/usr/bin/env bash
# =============================================================================
# migrate-database.sh — Migração do banco PostgreSQL para Cloud SQL (GCP)
#
# Restaura um dump PostgreSQL (formato custom) no Cloud SQL via Cloud SQL Proxy.
# Também garante que a tabela php_sessions existe no destino.
#
# Uso:
#   ./scripts/migrate-database.sh /caminho/para/dump_gestou.backup
#
# Pré-requisitos:
#   - cloud-sql-proxy binário disponível no PATH ou diretório atual
#   - gcloud autenticado (gcloud auth login + gcloud auth application-default login)
#   - Docker instalado (usa container postgres:17 para pg_restore compatível)
#
# Variáveis de ambiente (opcionais, têm defaults):
#   DB_USER       — Usuário do Cloud SQL (default: gestou)
#   DB_NAME       — Nome do banco (default: gestou)
#   DB_PASS       — Senha do banco (obrigatória)
#   PROXY_PORT    — Porta local do proxy (default: 5434)
#   CLOUD_SQL_INSTANCE — Connection name (default: gestou-489010:us-central1:gestou-db)
# =============================================================================

set -euo pipefail

# ---------------------------------------------------------------------------
# Cores para output
# ---------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# ---------------------------------------------------------------------------
# Configuração
# ---------------------------------------------------------------------------
DUMP_FILE="${1:?Uso: $0 /caminho/para/dump.backup}"
DB_USER="${DB_USER:-gestou}"
DB_NAME="${DB_NAME:-gestou}"
DB_PASS="${DB_PASS:?Defina DB_PASS com a senha do Cloud SQL}"
PROXY_PORT="${PROXY_PORT:-5434}"
CLOUD_SQL_INSTANCE="${CLOUD_SQL_INSTANCE:-gestou-489010:us-central1:gestou-db}"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SESSIONS_SQL="${SCRIPT_DIR}/../config/schema/sessions.sql"

echo -e "${YELLOW}=== Migração de Banco de Dados — Gestou ===${NC}"
echo ""

# ---------------------------------------------------------------------------
# Passo 1: Verificar pré-requisitos
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/5] Verificando pré-requisitos...${NC}"

if [ ! -f "${DUMP_FILE}" ]; then
    echo -e "${RED}ERRO: Arquivo ${DUMP_FILE} não encontrado.${NC}"
    exit 1
fi

DUMP_SIZE=$(du -h "${DUMP_FILE}" | cut -f1)
echo -e "  Dump: ${DUMP_FILE} (${DUMP_SIZE})"

# Localizar cloud-sql-proxy
PROXY_BIN=""
if command -v cloud-sql-proxy &> /dev/null; then
    PROXY_BIN="cloud-sql-proxy"
elif [ -f "./cloud-sql-proxy" ]; then
    PROXY_BIN="./cloud-sql-proxy"
else
    echo -e "${RED}ERRO: cloud-sql-proxy não encontrado.${NC}"
    echo "  Baixe de: https://cloud.google.com/sql/docs/postgres/sql-proxy"
    exit 1
fi

if ! command -v docker &> /dev/null; then
    echo -e "${RED}ERRO: docker não encontrado.${NC}"
    exit 1
fi

echo -e "${GREEN}  Tudo OK.${NC}"

# ---------------------------------------------------------------------------
# Passo 2: Iniciar Cloud SQL Proxy
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/5] Iniciando Cloud SQL Proxy...${NC}"
echo "  Instância: ${CLOUD_SQL_INSTANCE}"
echo "  Porta local: ${PROXY_PORT}"

${PROXY_BIN} --port ${PROXY_PORT} ${CLOUD_SQL_INSTANCE} &
PROXY_PID=$!

# Aguardar proxy iniciar
sleep 5

# Verificar se proxy está rodando
if ! kill -0 ${PROXY_PID} 2>/dev/null; then
    echo -e "${RED}ERRO: Cloud SQL Proxy falhou ao iniciar.${NC}"
    echo "  Verifique se gcloud está autenticado:"
    echo "    gcloud auth login"
    echo "    gcloud auth application-default login"
    exit 1
fi

echo -e "${GREEN}  Proxy iniciado (PID: ${PROXY_PID}).${NC}"

# Cleanup: matar proxy ao sair
trap "kill ${PROXY_PID} 2>/dev/null; echo '  Proxy encerrado.'" EXIT

# ---------------------------------------------------------------------------
# Passo 3: Restaurar dump via pg_restore (container Docker)
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/5] Restaurando dump no Cloud SQL...${NC}"
echo "  Usando container postgres:17 para compatibilidade de versão."

DUMP_DIR=$(dirname "${DUMP_FILE}")
DUMP_BASENAME=$(basename "${DUMP_FILE}")

docker run --rm --network host \
    -v "${DUMP_DIR}:/data" \
    -e PGPASSWORD="${DB_PASS}" \
    postgres:17 \
    pg_restore \
        -h 127.0.0.1 \
        -p ${PROXY_PORT} \
        -U ${DB_USER} \
        -d ${DB_NAME} \
        --no-owner \
        --no-privileges \
        "/data/${DUMP_BASENAME}"

echo -e "${GREEN}  Restauração concluída.${NC}"

# ---------------------------------------------------------------------------
# Passo 4: Criar tabela php_sessions
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[4/5] Criando tabela php_sessions...${NC}"

docker run --rm --network host \
    -e PGPASSWORD="${DB_PASS}" \
    postgres:17 \
    psql -h 127.0.0.1 -p ${PROXY_PORT} -U ${DB_USER} -d ${DB_NAME} \
    -c "CREATE TABLE IF NOT EXISTS php_sessions (id VARCHAR(128) PRIMARY KEY, data TEXT NOT NULL DEFAULT '', last_access TIMESTAMP NOT NULL DEFAULT NOW()); CREATE INDEX IF NOT EXISTS idx_php_sessions_last_access ON php_sessions(last_access);"

echo -e "${GREEN}  Tabela php_sessions criada/verificada.${NC}"

# ---------------------------------------------------------------------------
# Passo 5: Validação rápida
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[5/5] Validando migração...${NC}"

TABLE_COUNT=$(docker run --rm --network host \
    -e PGPASSWORD="${DB_PASS}" \
    postgres:17 \
    psql -h 127.0.0.1 -p ${PROXY_PORT} -U ${DB_USER} -d ${DB_NAME} \
    -t -A -c "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='public';")

echo -e "  Total de tabelas: ${TABLE_COUNT}"

# Verificar tabelas-chave do Gestou
for TABLE in GESEMP GESUSU GESACE GESACP php_sessions; do
    EXISTS=$(docker run --rm --network host \
        -e PGPASSWORD="${DB_PASS}" \
        postgres:17 \
        psql -h 127.0.0.1 -p ${PROXY_PORT} -U ${DB_USER} -d ${DB_NAME} \
        -t -A -c "SELECT CASE WHEN EXISTS (SELECT FROM information_schema.tables WHERE table_name='${TABLE}') THEN 'sim' ELSE 'nao' END;")
    if [ "${EXISTS}" = "sim" ]; then
        echo -e "  ${GREEN}✓${NC} ${TABLE} existe"
    else
        echo -e "  ${RED}✗${NC} ${TABLE} NÃO encontrada"
    fi
done

# ---------------------------------------------------------------------------
# Resumo
# ---------------------------------------------------------------------------
echo ""
echo -e "${GREEN}=== Migração concluída com sucesso ===${NC}"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Sincronizar uploads: gcloud storage rsync ./upload/ gs://gestou-uploads-489010/upload/ --recursive"
echo "  2. Testar healthcheck: curl https://gestou.leveinovacao.com.br/scripts/healthcheck.php"
