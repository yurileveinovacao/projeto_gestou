-- FEA-010: Líder RH (papel com autonomia de gestão de admins)
--
-- Reaproveita GESUSA.gestor (já existente, default 0) como flag de "é Líder RH".
-- Acrescenta auditoria de criação/desativação ao admin.
--
-- Idempotente. Não altera valores existentes de `gestor` — backfill manual via /admin/.

ALTER TABLE public."GESUSA"
    ADD COLUMN IF NOT EXISTS id_usa_inc INTEGER NULL,
    ADD COLUMN IF NOT EXISTS id_usa_desativado INTEGER NULL,
    ADD COLUMN IF NOT EXISTS data_desativacao TIMESTAMP NULL;
