-- FEA-009: Cria categoria "Folha" + sub-itens "Autônomos" e "RPA" em GESMNU
-- Posição: nivel='4' (gap histórico livre — nenhum tipo de menu usava este nível)
-- Ordens 22, 23, 24 (espaço livre entre Painel RH ord=16-21 e Permissão ord=33)
-- Backfill RESTRITO ao grupo da Jéssica: SE HOTEIS (id_emp=107) e SE SERVICOS (id_emp=106) — decisão Yuri 2026-05-24
-- IMPORTANTE: pós deploy desta migration, ADICIONAR os novos id_mnu (Autônomos e RPA)
-- na constante MENUS_PADRAO_NOVOS_ADMINS em config/permissions.php (FEA-013)

-- 1) Categoria "Folha" (nivel 4, sem link — apenas agrupador)
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Folha', 'fas fa-file-invoice-dollar', '', '',
       '4', 22, 2, 'Folha', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM public."GESMNU"
    WHERE descri = 'Folha' AND nivel = '4' AND tipo = 'admin'
);

-- 2) Sub-item "Autônomos" (nivel 4.1, link autonomos)
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Autônomos', 'fas fa-user-tie', 'autonomos', '',
       '4.1', 23, 2, 'Folha -> Autônomos', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM public."GESMNU"
    WHERE descri = 'Autônomos' AND nivel = '4.1' AND tipo = 'admin'
);

-- 3) Sub-item "RPA" (nivel 4.2, link rpas)
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'RPA', 'fas fa-receipt', 'rpas', '',
       '4.2', 24, 2, 'Folha -> RPA', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM public."GESMNU"
    WHERE descri = 'RPA' AND nivel = '4.2' AND tipo = 'admin'
);

-- 4) Backfill GESMPR: libera "Folha", "Autônomos" e "RPA" APENAS pra usuários do
--    grupo da Jéssica (SE HOTEIS=107 e SE SERVICOS=106) que hoje veem "Painel RH"
--    (id_mnu=20, situac=1). Outras empresas só ganham acesso quando admin master
--    liberar pela /master/.
INSERT INTO public."GESMPR" (id_usa, id_emp, id_mnu, datatu, situac)
SELECT src.id_usa, src.id_emp, tgt.id_mnu, NOW(), 1
FROM public."GESMPR" src
CROSS JOIN (
    SELECT id_mnu FROM public."GESMNU"
    WHERE tipo = 'admin' AND nivel IN ('4', '4.1', '4.2')
) tgt
WHERE src.id_mnu = 20             -- Painel RH: marcador de admin completo
  AND src.situac = 1
  AND src.id_emp IN (106, 107)    -- SE SERVICOS + SE HOTEIS (grupo da Jéssica)
  AND NOT EXISTS (
      SELECT 1 FROM public."GESMPR" dst
      WHERE dst.id_usa = src.id_usa
        AND dst.id_emp = src.id_emp
        AND dst.id_mnu = tgt.id_mnu
  );
