-- FEA-009: Cadastro de Autônomos (prestadores art. 442-B CLT)
-- Separado de GESUSU (que é pra CLT) porque autônomos não têm benefícios,
-- ciclo de vida diferente, e podem nunca ter login no sistema.
-- Email é NOT NULL (decisão Yuri 2026-05-22): aceite digital depende disso.

CREATE TABLE IF NOT EXISTS public."GESAUT" (
    id_aut       SERIAL PRIMARY KEY,
    id_emp       INTEGER NOT NULL,
    nome         VARCHAR(200) NOT NULL,
    cpf          VARCHAR(14)  NOT NULL,
    rg           VARCHAR(20),
    data_nasc    DATE,
    etnia        VARCHAR(30),
    endereco     TEXT,
    cep          VARCHAR(10),
    bairro       VARCHAR(100),
    cidade       VARCHAR(100),
    uf           CHAR(2),
    email        VARCHAR(200) NOT NULL,
    pix          VARCHAR(100) NOT NULL,
    ativo        SMALLINT     NOT NULL DEFAULT 1,
    datinc       TIMESTAMP    NOT NULL DEFAULT NOW(),
    id_usa_inc   INTEGER,
    datatu       TIMESTAMP,
    id_usa_atu   INTEGER,
    CONSTRAINT gesaut_cpf_unico_por_empresa UNIQUE (id_emp, cpf)
);

CREATE INDEX IF NOT EXISTS idx_gesaut_emp_ativo ON public."GESAUT"(id_emp, ativo);
