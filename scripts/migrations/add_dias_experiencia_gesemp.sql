-- FEA-002 / FEA-003: dias de experiência personalizados por empresa.
-- Por padrão 45 (final da 1ª fase) + 90 (final da prorrogação / total CLT).
-- Empresas podem ajustar via admin/dados_cadastrais.php.
-- Validação no app: 1 <= dias_exp_1 <= dias_exp_2 <= 90.
-- Quando dias_exp_1 == dias_exp_2, considera-se "fase única" (sem prorrogação).
ALTER TABLE public."GESEMP"
  ADD COLUMN IF NOT EXISTS dias_exp_1 INTEGER NOT NULL DEFAULT 45,
  ADD COLUMN IF NOT EXISTS dias_exp_2 INTEGER NOT NULL DEFAULT 90;
