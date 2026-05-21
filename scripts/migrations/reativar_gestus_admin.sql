-- FEA-010: Reativa o tipo ADMIN (id_tus=1) em GESTUS.
--
-- Histórico: o tipo estava com situac=0, fazendo selectGESTUS filtrá-lo do
-- select de "Tipo Usuário" no /master/cadastro_usuario. Sem isso, master não
-- consegue cadastrar contas internas pela UI — só via SQL direto.
-- Agora que a listagem do /admin/ já filtra id_tus=1 (Líder RH não vê internos),
-- liberar o tipo no master é seguro.
--
-- Idempotente. Sem efeito se já estiver ativo.

UPDATE public."GESTUS"
   SET situac = 1
 WHERE id_tus = 1 AND situac = 0;
