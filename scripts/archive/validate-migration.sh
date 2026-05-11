#!/usr/bin/env bash
# =============================================================================
# validate-migration.sh — Validação pós-migração do banco de dados
#
# Testa a conexão ao Cloud SQL, verifica tabelas do Gestou,
# conta registros e valida configurações.
#
# Uso (via Cloud SQL Proxy):
#   DB_PASS="senha" ./scripts/validate-migration.sh
#
# Ou com proxy já rodando na porta 5434:
#   DB_HOST=127.0.0.1 DB_PORT=5434 DB_PASS="senha" ./scripts/validate-migration.sh
#
# Variáveis de ambiente:
#   DB_HOST  — Host do banco (default: 127.0.0.1)
#   DB_PORT  — Porta (default: 5434, assumindo Cloud SQL Proxy)
#   DB_NAME  — Nome do banco (default: gestou)
#   DB_USER  — Usuário (default: gestou)
#   DB_PASS  — Senha (obrigatória)
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
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-5434}"
DB_NAME="${DB_NAME:-gestou}"
DB_USER="${DB_USER:-gestou}"
DB_PASS="${DB_PASS:?Defina DB_PASS}"

TESTS_PASSED=0
TESTS_FAILED=0

echo -e "${YELLOW}=== Validação Pós-Migração — Gestou ===${NC}"
echo "  Host: ${DB_HOST}:${DB_PORT}"
echo "  Banco: ${DB_NAME}"
echo ""

# ---------------------------------------------------------------------------
# Função para executar queries via Docker (postgres:17 compatível)
# ---------------------------------------------------------------------------
run_query() {
    docker run --rm --network host \
        -e PGPASSWORD="${DB_PASS}" \
        postgres:17 \
        psql -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USER}" -d "${DB_NAME}" \
        -t -A -c "$1" 2>/dev/null
}

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
# Teste 1: Conexão ao banco
# ---------------------------------------------------------------------------
echo -e "${YELLOW}[1/5] Testando conexão...${NC}"

if run_query "SELECT 1;" &> /dev/null; then
    echo -e "  ${GREEN}✓${NC} Conexão ao banco bem-sucedida"
    TESTS_PASSED=$((TESTS_PASSED + 1))
else
    echo -e "  ${RED}✗${NC} Falha na conexão"
    TESTS_FAILED=$((TESTS_FAILED + 1))
    echo -e "${RED}ERRO FATAL: Abortando.${NC}"
    echo ""
    echo "Verifique se o Cloud SQL Proxy está rodando:"
    echo "  ./cloud-sql-proxy --port ${DB_PORT} gestou-489010:us-central1:gestou-db &"
    exit 1
fi

# ---------------------------------------------------------------------------
# Teste 2: Tabelas principais do Gestou
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[2/5] Verificando tabelas principais...${NC}"

# Tabelas do schema do Gestou (nomes reais em MAIÚSCULAS)
EXPECTED_TABLES=(
    "GESEMP"         # Empresas
    "GESUSU"         # Usuários/Colaboradores
    "GESACE"         # Acessos
    "GESACP"         # Acessos (complementar)
    "GESDEP"         # Departamentos
    "GESDCOL"        # Documentos de colaboradores
    "GESMAS"         # Master (super admin)
    "GESCHA"         # Chamados
    "GESCON"         # Configurações
    "GESJOB"         # Jobs/Background tasks
    "GESLAY"         # Layouts de OCR
    "GESNOT"         # Notificações
    "php_sessions"   # Sessões PHP (criada na migração)
)

for table in "${EXPECTED_TABLES[@]}"; do
    EXISTS=$(run_query "SELECT CASE WHEN EXISTS (SELECT FROM information_schema.tables WHERE table_name = '${table}') THEN 'sim' ELSE 'nao' END;")
    check_result "Tabela '${table}'" "${EXISTS}" "sim"
done

TOTAL_TABLES=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE';")
echo -e "  ${GREEN}→${NC} Total de tabelas: ${TOTAL_TABLES}"

# ---------------------------------------------------------------------------
# Teste 3: Contagem de registros
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[3/5] Contagem de registros...${NC}"

for TABLE in GESEMP GESUSU GESMAS GESCHA GESDEP; do
    COUNT=$(run_query "SELECT COUNT(*) FROM \"${TABLE}\";" 2>/dev/null || echo "erro")
    if [ "${COUNT}" != "erro" ]; then
        echo -e "  ${GREEN}→${NC} ${TABLE}: ${COUNT} registros"
    else
        echo -e "  ${YELLOW}→${NC} ${TABLE}: não acessível"
    fi
done

# ---------------------------------------------------------------------------
# Teste 4: Tabelas dinâmicas (por empresa/CNPJ)
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[4/5] Verificando tabelas dinâmicas...${NC}"

GESIM1_COUNT=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_name LIKE 'GESIM1_%';")
GESIM2_COUNT=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_name LIKE 'GESIM2_%';")
GESPON_COUNT=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_name LIKE 'GESPON%';")
GESIRR_COUNT=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_name LIKE 'GESIRR%';")
GESREC_COUNT=$(run_query "SELECT COUNT(*) FROM information_schema.tables WHERE table_name LIKE 'GESREC%';")

echo -e "  GESIM1_* (holerites): ${GESIM1_COUNT} tabelas"
echo -e "  GESIM2_* (holerites v2): ${GESIM2_COUNT} tabelas"
echo -e "  GESPON_* (pontos): ${GESPON_COUNT} tabelas"
echo -e "  GESIRR_* (IRRF): ${GESIRR_COUNT} tabelas"
echo -e "  GESREC_* (recibos): ${GESREC_COUNT} tabelas"

# ---------------------------------------------------------------------------
# Teste 5: Configurações do PostgreSQL
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}[5/5] Configurações do PostgreSQL...${NC}"

PG_VERSION=$(run_query "SELECT version();" | head -1)
ENCODING=$(run_query "SELECT pg_encoding_to_char(encoding) FROM pg_database WHERE datname='${DB_NAME}';")

echo -e "  ${GREEN}→${NC} Versão: ${PG_VERSION}"
echo -e "  ${GREEN}→${NC} Encoding: ${ENCODING}"

# ---------------------------------------------------------------------------
# Resumo
# ---------------------------------------------------------------------------
echo ""
echo -e "${YELLOW}=== Resumo ===${NC}"
echo -e "  Passaram: ${GREEN}${TESTS_PASSED}${NC}"
echo -e "  Falharam: ${RED}${TESTS_FAILED}${NC}"
echo -e "  Tabelas total: ${TOTAL_TABLES}"

if [ ${TESTS_FAILED} -eq 0 ]; then
    echo ""
    echo -e "${GREEN}Todos os testes passaram!${NC}"
    exit 0
else
    echo ""
    echo -e "${RED}Há testes falhando. Verifique acima.${NC}"
    exit 1
fi
