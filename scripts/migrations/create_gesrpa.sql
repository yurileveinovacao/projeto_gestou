-- FEA-009: Recibos de Pagamento Autônomo (1 linha = 1 pagamento autorizado)
-- Máquina de estados: rascunho → autorizado → assinado → enviado_fin → pago
-- (cancelado pode ocorrer em qualquer ponto exceto pago)
-- Snapshot de evidência do aceite digital: ip + user_agent + timestamp + PDF anexo
-- (decisão Yuri 2026-05-24: Opção B — assinatura eletrônica simples robusta)

CREATE TABLE IF NOT EXISTS public."GESRPA" (
    id_rpa                  SERIAL PRIMARY KEY,
    id_emp                  INTEGER NOT NULL,
    id_aut                  INTEGER NOT NULL,
    id_dep                  INTEGER,
    cargo                   VARCHAR(100),
    data_servico            DATE    NOT NULL,
    hora_ini                TIME,
    hora_fim                TIME,
    diarias                 INTEGER DEFAULT 1,
    valor_liquido           NUMERIC(10,2) NOT NULL,
    perc_imposto            NUMERIC(5,2)  NOT NULL DEFAULT 12.36,
    valor_bruto             NUMERIC(10,2) NOT NULL,
    valor_inss              NUMERIC(10,2) NOT NULL,
    justificativa           TEXT,
    status                  VARCHAR(20) NOT NULL DEFAULT 'rascunho'
                            CHECK (status IN ('rascunho','autorizado','assinado','enviado_fin','pago','cancelado')),
    -- Aprovação pelo Líder RH (ou admin do setor)
    autorizado_por          INTEGER,
    data_autorizacao        TIMESTAMP,
    -- Aceite digital pelo autônomo (Opção B)
    assinado_por            INTEGER,
    ip_assinatura           VARCHAR(45),
    user_agent_assinatura   TEXT,
    data_assinatura         TIMESTAMP,
    -- Status financeiro
    data_envio_fin          DATE,
    data_pgto               DATE,
    motivo_cancelamento     TEXT,
    -- PDFs gerados
    autorizacao_pdf_path    VARCHAR(500),
    contrato_pdf_path       VARCHAR(500),
    recibo_pdf_path         VARCHAR(500),
    evidencia_pdf_path      VARCHAR(500),
    -- Auditoria
    datinc                  TIMESTAMP NOT NULL DEFAULT NOW(),
    id_usa_inc              INTEGER,
    datatu                  TIMESTAMP,
    id_usa_atu              INTEGER,
    -- FKs
    CONSTRAINT fk_gesrpa_aut FOREIGN KEY (id_aut) REFERENCES public."GESAUT"(id_aut)
);

CREATE INDEX IF NOT EXISTS idx_gesrpa_emp_status      ON public."GESRPA"(id_emp, status);
CREATE INDEX IF NOT EXISTS idx_gesrpa_aut_data        ON public."GESRPA"(id_aut, data_servico);
CREATE INDEX IF NOT EXISTS idx_gesrpa_emp_data_servico ON public."GESRPA"(id_emp, data_servico);
