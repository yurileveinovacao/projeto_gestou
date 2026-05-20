-- FEA-010: Limites de admins por empresa
--
-- limite_lideres: teto de Líderes RH ativos (gestor=1, situac=1) que cada empresa pode ter.
--                 Default 2 — controlado pelo master via /master/alterar_empresa.php.
-- limite_admins_ativos: teto opcional de admins ativos totais (qualquer gestor) — NULL = sem teto.
--                       Preparado para precificação por tier futura.
--
-- Idempotente. Backfill automático via DEFAULTs (toda empresa existente fica 2 / NULL).

ALTER TABLE public."GESEMP"
    ADD COLUMN IF NOT EXISTS limite_lideres INTEGER NOT NULL DEFAULT 2,
    ADD COLUMN IF NOT EXISTS limite_admins_ativos INTEGER NULL;
