-- FEA-006: Menu Indicadores > Turnover
-- Categoria pai "Indicadores" (estagio=1) + item "Turnover" (estagio=2)
-- tipo='admin', desabilitado por padrão (permissões criadas automaticamente pela tela de Permissão)

-- Categoria pai
INSERT INTO public."GESMNU" (descri, icone, link, target, nivel, ordem, estagio, tipo)
VALUES ('Indicadores', 'fas fa-chart-bar', '', 'collapseIndicadores', '11', 36, 1, 'admin');

-- Item filho Turnover (nivel = 11.1 = filho de Indicadores)
INSERT INTO public."GESMNU" (descri, icone, link, target, nivel, ordem, estagio, tipo)
VALUES ('Turnover', '', 'indicadores_turnover', '', '11.1', 37, 2, 'admin');
