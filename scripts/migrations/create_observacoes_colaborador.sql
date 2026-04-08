-- FEA-004: Observações do colaborador
CREATE TABLE IF NOT EXISTS observacoes_colaborador (
  id SERIAL PRIMARY KEY,
  colaborador_id INTEGER NOT NULL,
  cnpj_empresa VARCHAR(20) NOT NULL,
  categoria_id INTEGER REFERENCES categorias_observacao(id) ON DELETE SET NULL,
  descricao TEXT NOT NULL,
  data_observacao DATE NOT NULL DEFAULT CURRENT_DATE,
  criado_em TIMESTAMP DEFAULT NOW(),
  criado_por INTEGER
);
