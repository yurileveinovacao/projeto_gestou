-- FEA-006: Menu Indicadores > Turnover (idempotente)
-- Categoria pai "Indicadores" (estagio=1) + item "Turnover" (estagio=2)
-- tipo='admin', desabilitado por padrão (permissões criadas automaticamente pela tela de Permissão)
-- id_mnu é NOT NULL sem sequence — app gerencia IDs; aqui usamos MAX(id_mnu)+1 como fallback.

-- Categoria pai
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Indicadores', 'fas fa-chart-bar', '', 'collapseIndicadores', '11', 36, 1, 'Indicadores', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM public."GESMNU"
  WHERE descri = 'Indicadores' AND nivel = '11' AND tipo = 'admin'
);

-- Item filho Turnover (nivel = 11.1 = filho de Indicadores)
-- link='index' redireciona ao dashboard onde o card+modal do Turnover fica
INSERT INTO public."GESMNU" (id_mnu, descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT COALESCE((SELECT MAX(id_mnu) FROM public."GESMNU"), 0) + 1,
       'Turnover', '', 'index', '', '11.1', 37, 2, 'Indicadores -> Turnover', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM public."GESMNU"
  WHERE descri = 'Turnover' AND nivel = '11.1' AND tipo = 'admin'
);
