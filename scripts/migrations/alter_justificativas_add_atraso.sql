-- Adiciona o tipo 'atraso' ao CHECK constraint de public.justificativas.
-- Permite que colaboradores justifiquem atraso na entrada (hora + mensagem + anexo opcional).

ALTER TABLE public.justificativas
    DROP CONSTRAINT IF EXISTS justificativas_tipo_check;

ALTER TABLE public.justificativas
    ADD CONSTRAINT justificativas_tipo_check
    CHECK (tipo::text = ANY (ARRAY[
        'ausencia_ponto'::character varying::text,
        'falta'::character varying::text,
        'falta_atestado'::character varying::text,
        'atraso'::character varying::text
    ]));
