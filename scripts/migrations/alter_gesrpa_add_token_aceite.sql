-- FEA-009 Fase 5: token de aceite digital do autônomo (Opção B)
-- token_aceite: hash SHA-256 (64 chars hex) gerado quando RPA vira 'autorizado'
-- token_validade: timestamp de expiração (default 7 dias após geração)
-- token_invalidado_em: marca timestamp quando admin reenvia (gera novo token e invalida o anterior)

ALTER TABLE public."GESRPA"
    ADD COLUMN IF NOT EXISTS token_aceite VARCHAR(64),
    ADD COLUMN IF NOT EXISTS token_validade TIMESTAMP,
    ADD COLUMN IF NOT EXISTS token_invalidado_em TIMESTAMP;

CREATE INDEX IF NOT EXISTS idx_gesrpa_token_aceite ON public."GESRPA"(token_aceite) WHERE token_aceite IS NOT NULL;
