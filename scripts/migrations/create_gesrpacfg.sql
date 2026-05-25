-- FEA-009: Configuração de RPA por empresa
-- Editável em /admin/dados_cadastrais.php aba "RPA" (Fase 6 do plano)
-- Texto HTML editável → renderizado em PDF via Dompdf com placeholders substituídos
-- Defaults: valor_liquido=150, perc_imposto=12.36, alerta=3 diárias, bloqueio=4
-- (textos em branco no default; admin preenche pela UI ou via seed inicial)

CREATE TABLE IF NOT EXISTS public."GESRPACFG" (
    id_emp                  INTEGER PRIMARY KEY,
    valor_liquido_padrao    NUMERIC(10,2) NOT NULL DEFAULT 150.00,
    perc_imposto_padrao     NUMERIC(5,2)  NOT NULL DEFAULT 12.36,
    texto_autorizacao_html  TEXT,
    texto_contrato_html     TEXT,
    texto_recibo_html       TEXT,
    limite_dias_alerta      INTEGER NOT NULL DEFAULT 3,
    limite_dias_bloqueio    INTEGER NOT NULL DEFAULT 4,
    datinc                  TIMESTAMP NOT NULL DEFAULT NOW(),
    datatu                  TIMESTAMP,
    id_usa_atu              INTEGER
);
