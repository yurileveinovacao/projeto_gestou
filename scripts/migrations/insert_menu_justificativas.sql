-- FEA-005: Mover "Justificativas" para a hierarquia do Painel RH (GESMNU)
-- Pai: Painel RH (id_mnu=20, nivel='6')
-- Slot escolhido: nivel='6.6', ordem=22 (entre Treinamentos e Relatórios)

-- 1) Insere o item em GESMNU (idempotente)
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Justificativas', 'fas fa-file-signature', 'justificativas', '',
       '6.6', 22, 2, 'Painel RH -> Justificativas', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM public."GESMNU"
    WHERE descri = 'Justificativas' AND nivel = '6.6' AND tipo = 'admin'
);

-- 2) Backfill de GESMPR: quem hoje vê Painel RH (id_mnu=20, situac=1) passa a ver Justificativas
INSERT INTO public."GESMPR" (id_usa, id_emp, id_mnu, datatu, situac)
SELECT src.id_usa, src.id_emp, tgt.id_mnu, NOW(), 1
FROM public."GESMPR" src
CROSS JOIN (
    SELECT id_mnu FROM public."GESMNU"
    WHERE descri = 'Justificativas' AND nivel = '6.6' AND tipo = 'admin'
    LIMIT 1
) tgt
WHERE src.id_mnu = 20
  AND src.situac = 1
  AND NOT EXISTS (
      SELECT 1 FROM public."GESMPR" dst
      WHERE dst.id_usa = src.id_usa
        AND dst.id_emp = src.id_emp
        AND dst.id_mnu = tgt.id_mnu
  );
