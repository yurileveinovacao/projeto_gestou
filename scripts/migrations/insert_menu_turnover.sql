-- FEA-006: Menu Indicadores > Turnover (idempotente)
-- Categoria pai "Indicadores" (estagio=1) + item "Turnover" (estagio=2)
-- tipo='admin', desabilitado por padrão (permissões criadas automaticamente pela tela de Permissão)

-- Categoria pai
INSERT INTO public."GESMNU" (descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT 'Indicadores', 'fas fa-chart-bar', '', 'collapseIndicadores', '11', 36, 1, 'Indicadores', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM public."GESMNU"
  WHERE descri = 'Indicadores' AND nivel = '11' AND tipo = 'admin'
);

-- Item filho Turnover (nivel = 11.1 = filho de Indicadores)
-- link='index' redireciona ao dashboard onde o card+modal do Turnover fica
INSERT INTO public."GESMNU" (descri, icone, link, target, nivel, ordem, estagio, caminho, tipo)
SELECT 'Turnover', '', 'index', '', '11.1', 37, 2, 'Indicadores -> Turnover', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM public."GESMNU"
  WHERE descri = 'Turnover' AND nivel = '11.1' AND tipo = 'admin'
);
