-- FEA-008: Adiciona suporte a templates tipo .docx (upload pronto, sem edição no sistema)
-- tipo: 'html' (criado no TinyMCE) ou 'docx' (upload de arquivo Word)
-- arquivo_docx: nome do arquivo .docx em upload/templates/{raiz_cnpj}/ (somente quando tipo='docx')

ALTER TABLE public."GESDOCTPL"
    ADD COLUMN IF NOT EXISTS tipo VARCHAR(10) NOT NULL DEFAULT 'html',
    ADD COLUMN IF NOT EXISTS arquivo_docx VARCHAR(255);

-- Restringe valores válidos do tipo (idempotente: dropa antes pra permitir reaplicação)
ALTER TABLE public."GESDOCTPL" DROP CONSTRAINT IF EXISTS gesdoctpl_tipo_check;
ALTER TABLE public."GESDOCTPL" ADD CONSTRAINT gesdoctpl_tipo_check CHECK (tipo IN ('html', 'docx'));
