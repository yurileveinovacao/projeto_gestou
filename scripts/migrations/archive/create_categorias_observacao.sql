-- FEA-004: Categorias de observação por empresa
CREATE TABLE IF NOT EXISTS categorias_observacao (
  id SERIAL PRIMARY KEY,
  cnpj_empresa VARCHAR(20) NOT NULL,
  nome VARCHAR(100) NOT NULL,
  ativo BOOLEAN DEFAULT TRUE,
  criado_em TIMESTAMP DEFAULT NOW()
);
