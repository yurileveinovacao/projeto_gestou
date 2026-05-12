-- FEA-008: Templates de documentos para envio em lote (avisos/informativos)
-- Tabela global com id_emp (segue padrão das FEAs recentes: justificativas, observacoes_colaborador)

CREATE TABLE IF NOT EXISTS public."GESDOCTPL" (
    id_tpl            SERIAL PRIMARY KEY,
    id_emp            INTEGER NOT NULL,
    nome              VARCHAR(200) NOT NULL,
    titulo_documento  VARCHAR(200) NOT NULL,
    conteudo_html     TEXT NOT NULL,
    ativo             SMALLINT NOT NULL DEFAULT 1,
    datinc            TIMESTAMP NOT NULL DEFAULT NOW(),
    id_usa_inc        INTEGER,
    datatu            TIMESTAMP,
    id_usa_atu        INTEGER
);

CREATE INDEX IF NOT EXISTS idx_gesdoctpl_emp ON public."GESDOCTPL"(id_emp, ativo);
