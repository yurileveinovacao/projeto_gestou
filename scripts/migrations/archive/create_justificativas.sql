CREATE TABLE IF NOT EXISTS justificativas (
  id SERIAL PRIMARY KEY,
  colaborador_id INTEGER NOT NULL,
  cnpj_empresa VARCHAR(20) NOT NULL,
  tipo VARCHAR(30) NOT NULL CHECK (tipo IN ('ausencia_ponto','falta','falta_atestado')),
  status VARCHAR(20) NOT NULL DEFAULT 'pendente' CHECK (status IN ('pendente','aprovada','reprovada')),
  data_ocorrencia DATE NOT NULL,
  hora_ocorrencia TIME NULL,
  mensagem TEXT NULL,
  arquivo_path VARCHAR(500) NULL,
  resposta_admin TEXT NULL,
  criado_em TIMESTAMP DEFAULT NOW(),
  respondido_em TIMESTAMP NULL,
  respondido_por INTEGER NULL
);
