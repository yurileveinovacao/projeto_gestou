-- FEA-008: Adiciona "Templates" como sub-item de Documentos (GESMNU)
-- Pai: Documentos (id_mnu=11, nivel='3')
-- Slot: nivel='3.3', ordem=16 (após Importação=3.1/14 e Histórico=3.2/15)

-- 1) Insere o item em GESMNU (idempotente)
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Templates', 'fas fa-file-alt', 'templates_documentos', '',
       '3.3', 16, 2, 'Documentos -> Templates', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM public."GESMNU"
    WHERE descri = 'Templates' AND nivel = '3.3' AND tipo = 'admin'
);

-- 2) Backfill de GESMPR: quem hoje vê Documentos (id_mnu=11, situac=1) passa a ver Templates
INSERT INTO public."GESMPR" (id_usa, id_emp, id_mnu, datatu, situac)
SELECT src.id_usa, src.id_emp, tgt.id_mnu, NOW(), 1
FROM public."GESMPR" src
CROSS JOIN (
    SELECT id_mnu FROM public."GESMNU"
    WHERE descri = 'Templates' AND nivel = '3.3' AND tipo = 'admin'
    LIMIT 1
) tgt
WHERE src.id_mnu = 11
  AND src.situac = 1
  AND NOT EXISTS (
      SELECT 1 FROM public."GESMPR" dst
      WHERE dst.id_usa = src.id_usa
        AND dst.id_emp = src.id_emp
        AND dst.id_mnu = tgt.id_mnu
  );
