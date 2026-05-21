-- FEA-010: renomear item do menu lateral de "Usuários" para "Usuários Admin"
-- para diferenciar de "Colaboradores" (que também são "usuários" do app).
-- id_mnu=36 corresponde a tabela_usuarios. Idempotente.

UPDATE public."GESMNU"
   SET descri = 'Usuários Admin'
 WHERE id_mnu = 36;
