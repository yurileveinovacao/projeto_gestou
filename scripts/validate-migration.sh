#!/usr/bin/env bash
# =============================================================================
# validate-migration.sh — Validação pós-migração do banco de dados
#
# Testa a conexão ao banco de destino, verifica se as tabelas existem,
# valida as views e conta registros nas tabelas principais.
#
# Uso:
#   ./scripts/validate-migration.sh
#
# Variáveis de ambiente necessárias:
#   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
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
# Configuração do banco (destino — Cloud SQL)
# ---------------------------------------------------------------------------
DB_HOST="${DB_HOST:?Defina DB_HOST}"
DB_PORT="${DB_PORT:-5432}"
DB_NAME="${DB_NAME:?Defina DB_NAME}"
DB_USER="${DB_USER:?Defina DB_USER}"
DB_PASS="${DB_PASS:?Defina DB_PASS}"

# Contadores de validação
TESTS_PASSED=0
TESTS_FAILED=0

echo -e "${YELLOW}=== Validação Pós-Migração — Gestou ===${NC}"
echo "  Host: ${DB_HOST}:${DB_PORT}"
echo "  Banco: ${DB_NAME}"
echo ""

# ---------------------------------------------------------------------------
# Função auxiliar para executar queries
# ---------------------------------------------------------------------------
run_query() {
    PGPASSWORD="${DB_PASS}" psql \
        -h "${DB_HOST}" \
        -p "${DB_PORT}" \
        -U "${DB_USER}" \
        -d "${DB_NAME}" \
        -t -A \
        -c "$1" 2>/dev/null
}

# ---------------------------------------------------------------------------
# Função auxiliar para reportar resultado de um teste
# ---------------------------------------------------------------------------
check_result() {
    local description="$1"
    local result="$2"
    local expected="$3"

    if [ "${result}" = "${expected}" ]; then
        echo -e "  ${GREEN}✓${NC} ${description}"
        TESTS_PASSED=$((TESTS_PASSED + 1))
    else
        echo -e "  ${RED}✗${NC} ${description} (esperado: ${expected}, obtido: ${result})"
        TESTS_FAILED=$((TESTS_FAILED + 1))
    fi
}

# ---------------------------------------------------------------------------
# Teste 1: Conexão ao banco de dados
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/5] Testando conexão ao banco...${NC}"

if PGPASSWORD="${DB_PASS}" psql \
    -h "${DB_HOST}" \
    -p "${DB_PORT}" \
    -U "${DB_USER}" \
    -d "${DB_NAME}" \
    -c "SELECT 1;" &> /dev/null; then
    echo -e "  ${GREEN}✓${NC} Conexão ao banco bem-sucedida"
    TESTS_PASSED=$((TESTS_PASSED + 1))
else
    echo -e "  ${RED}✗${NC} Falha na conexão ao banco"
    TESTS_FAILED=$((TESTS_FAILED + 1))
    echo -e "${RED}ERRO FATAL: Não foi possível conectar ao banco. Abortando.${NC}"
    exit 1
fi

# ---------------------------------------------------------------------------
# Teste 2: Verificar tabelas principais
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/5] Verificando tabelas principais...${NC}"

# Lista de tabelas que devem existir (tabelas comuns em sistemas RH/folha)
EXPECTED_TABLES=(
    "empresa"
    "colaborador"
    "php_sessions"
)

for table in "${EXPECTED_TABLES[@]}"; do
    EXISTS=$(run_query "SELECT CASE WHEN EXISTS (SELECT FROM information_schema.tables WHERE table_name = '${table}') THEN 'yes' ELSE 'no' END;")
    check_result "Tabela '${table}' existe" "${EXISTS}" "yes"
done

# Contar total de tabelas
TOTAL_TABLES=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE';")
echo -e "  ${GREEN}→${NC} Total de tabelas: ${TOTAL_TABLES}"

# ---------------------------------------------------------------------------
# Teste 3: Verificar views
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/5] Verificando views...${NC}"

TOTAL_VIEWS=$(run_query "SELECT COUNT(*) FROM information_schema.views WHERE table_schema = 'public';")
echo -e "  ${GREEN}→${NC} Total de views: ${TOTAL_VIEWS}"

# Listar views existentes
if [ "${TOTAL_VIEWS}" -gt 0 ] 2>/dev/null; then
    echo "  Views encontradas:"
    run_query "SELECT '    - ' || table_name FROM information_schema.views WHERE table_schema = 'public' ORDER BY table_name;" | head -20
fi

# ---------------------------------------------------------------------------
# Teste 4: Verificar contagem de registros em tabelas-chave
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[4/5] Verificando contagem de registros...${NC}"

# Tabelas para contar registros (existem apenas se o banco tem dados)
COUNT_TABLES=("empresa" "colaborador")

for table in "${COUNT_TABLES[@]}"; do
    EXISTS=$(run_query "SELECT CASE WHEN EXISTS (SELECT FROM information_schema.tables WHERE table_name = '${table}') THEN 'yes' ELSE 'no' END;")
    if [ "${EXISTS}" = "yes" ]; then
        COUNT=$(run_query "SELECT COUNT(*) FROM ${table};")
        echo -e "  ${GREEN}→${NC} ${table}: ${COUNT} registros"
    else
        echo -e "  ${YELLOW}→${NC} ${table}: tabela não encontrada (pode não existir neste banco)"
    fi
done

# ---------------------------------------------------------------------------
# Teste 5: Verificar extensões e configurações
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[5/5] Verificando configurações do PostgreSQL...${NC}"

# Versão do PostgreSQL
PG_VERSION=$(run_query "SELECT version();")
echo -e "  ${GREEN}→${NC} Versão: ${PG_VERSION}"

# Encoding
ENCODING=$(run_query "SELECT pg_encoding_to_char(encoding) FROM pg_database WHERE datname = '${DB_NAME}';")
echo -e "  ${GREEN}→${NC} Encoding: ${ENCODING}"

# Timezone
TIMEZONE=$(run_query "SHOW timezone;")
echo -e "  ${GREEN}→${NC} Timezone: ${TIMEZONE}"

# ---------------------------------------------------------------------------
# Resumo final
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}=== Resumo da Validação ===${NC}"
echo -e "  Testes passaram: ${GREEN}${TESTS_PASSED}${NC}"
echo -e "  Testes falharam: ${RED}${TESTS_FAILED}${NC}"

if [ ${TESTS_FAILED} -eq 0 ]; then
    echo ""
    echo -e "${GREEN}Todos os testes passaram! O banco está pronto para uso.${NC}"
    exit 0
else
    echo ""
    echo -e "${RED}Há testes falhando. Verifique os problemas acima antes de prosseguir.${NC}"
    exit 1
fi
