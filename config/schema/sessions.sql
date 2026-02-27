-- Tabela para armazenamento de sessões PHP via PostgreSQL
-- Necessária para ambientes stateless (Cloud Run)
CREATE TABLE IF NOT EXISTS php_sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT NOT NULL DEFAULT '',
    last_access TIMESTAMP NOT NULL DEFAULT NOW()
);

-- Índice para garbage collection (limpar sessões expiradas)
CREATE INDEX IF NOT EXISTS idx_php_sessions_last_access ON php_sessions (last_access);
