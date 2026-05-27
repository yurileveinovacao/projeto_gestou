-- FEA-014: Schema base do onboarding self-service (Asaas + máquina de estados nova)
--
-- Prepara o banco para a esteira comercial v2 (cadastro público → checkout Asaas → ativação automática).
-- Adiciona colunas de billing em GESEMP, cria tabela GESCOB pra histórico de cobranças com idempotência
-- de webhook, faz backfill de grupos órfãos (pedido do Yuri na 1:1 de 2026-05-25) e audita CNPJ duplicado.
--
-- Decisões de Yuri (2026-05-27):
--   DEC-01 = reajuste por gatilho 15% headcount
--   DEC-02 = preço fixo único (com promoções flexíveis)
--   DEC-04 = só cartão de crédito no MVP
--   DEC-07 = setup R$500 cobrado junto da 1ª mensalidade
--   DEC-09 = aprovação manual mantida pra clientes por indicação
--
-- Estados novos de GESEMP.analise (legados 1..4 preservados — DEC-09):
--   0  = rascunho (conta criada via /createaccount/, sem checkout iniciado)
--   1  = pendente (LEGADO — aprovação manual via /master/)
--   2  = liberado (LEGADO — empresa ativa contratada por indicação)
--   3  = reprovado (LEGADO)
--   4  = bloqueado (LEGADO)
--   5  = checkout_iniciado (Customer + Subscription criados no Asaas)
--   6  = pagamento_pendente (Payment.CREATED, aguardando confirmação)
--   7  = pagamento_falhou (cartão recusado / expirado)
--   8  = ativo (Payment.CONFIRMED, acesso liberado pela esteira self-service)
--   9  = past_due (recorrência vencida, em dunning)
--   10 = suspenso (dunning esgotado)
--   11 = cancelado / churned
--
-- IMPORTANTE: empresas legadas (45 em prod, todas com analise=0 e situac=0|1) NÃO são alteradas.
-- A distinção entre legado e esteira nova é feita pela coluna NOVA `origem`:
--   origem='legacy'        → 45 empresas pré-esteira (DEFAULT, preservadas intactas)
--   origem='self_service'  → leads vindos por /createaccount/ (esteira pública v2)
--   origem='master'        → cadastrados direto pelo /master/ (indicações, DEC-09)
--
-- Por que coluna `origem` em vez de migrar `analise`: dry-check em prod (2026-05-27) revelou que
-- todas as 45 empresas existentes estão com analise=0 (a coluna nunca foi populada além disso).
-- O operacional usa GESEMP.situac pra decidir "ativa". O controller/iuds_pdo.php:47
-- (updateGESEMP) faz UPDATE SET analise=0 WHERE analise=2 — migrar legadas pra analise=2
-- ativaria essa transição inesperadamente. Coluna origem isola riscos.
--
-- Idempotente. Pode rodar várias vezes sem efeito colateral.

BEGIN;

-- ============================================================================
-- 1. Colunas de billing em GESEMP (7 novas)
-- ============================================================================

ALTER TABLE public."GESEMP"
    ADD COLUMN IF NOT EXISTS origem                 VARCHAR(20)   NOT NULL DEFAULT 'legacy',
    ADD COLUMN IF NOT EXISTS asaas_customer_id      VARCHAR(40),
    ADD COLUMN IF NOT EXISTS asaas_subscription_id  VARCHAR(40),
    ADD COLUMN IF NOT EXISTS preco_fixo_mensal      NUMERIC(10,2),
    ADD COLUMN IF NOT EXISTS qtd_colab_contratada   INTEGER,
    ADD COLUMN IF NOT EXISTS data_contratacao       DATE,
    ADD COLUMN IF NOT EXISTS data_ativacao          TIMESTAMP,
    ADD COLUMN IF NOT EXISTS data_proxima_revisao   DATE;

COMMENT ON COLUMN public."GESEMP".origem                IS 'FEA-014: origem do cadastro. Valores: legacy (pré-esteira, 45 empresas atuais), self_service (esteira pública v2 — /createaccount/), master (cadastro pelo /master/, ex: indicações DEC-09). DEFAULT legacy preserva todas as empresas existentes intactas. Esteira nova distingue leads novos vs legados sem precisar mexer em GESEMP.analise das empresas pré-esteira.';
COMMENT ON COLUMN public."GESEMP".asaas_customer_id     IS 'FEA-014: ID do Customer no Asaas (1:1 com a empresa).';
COMMENT ON COLUMN public."GESEMP".asaas_subscription_id IS 'FEA-014: ID da Subscription mensal recorrente no Asaas.';
COMMENT ON COLUMN public."GESEMP".preco_fixo_mensal     IS 'FEA-014/DEC-02: valor mensal fixo contratado. Promoções aplicadas em GESCOB.';
COMMENT ON COLUMN public."GESEMP".qtd_colab_contratada  IS 'FEA-014/DEC-01: baseline de headcount no ato da contratação. Reajuste dispara quando atual desvia ≥ 15%.';
COMMENT ON COLUMN public."GESEMP".data_contratacao      IS 'FEA-014: data do aceite eletrônico no checkout (não confundir com data_ativacao).';
COMMENT ON COLUMN public."GESEMP".data_ativacao         IS 'FEA-014: data/hora do PAYMENT_CONFIRMED — quando o acesso foi liberado.';
COMMENT ON COLUMN public."GESEMP".data_proxima_revisao  IS 'FEA-014: data agendada da revisão anual (IGP-M + verificação do gatilho de 15%).';

CREATE INDEX IF NOT EXISTS idx_gesemp_origem ON public."GESEMP" (origem);

-- ============================================================================
-- 2. Tabela GESCOB — histórico de cobranças
-- ============================================================================
-- Idempotência do webhook é garantida por UNIQUE em asaas_payment_id.
-- raw_payload (JSONB) guarda o último webhook recebido pra auditoria.

CREATE TABLE IF NOT EXISTS public."GESCOB" (
    id_cob                 SERIAL        PRIMARY KEY,
    id_emp                 INTEGER       NOT NULL REFERENCES public."GESEMP"(id_emp),
    asaas_payment_id       VARCHAR(40)   NOT NULL UNIQUE,
    asaas_subscription_id  VARCHAR(40),
    tipo                   VARCHAR(20)   NOT NULL,  -- 'setup', 'mensalidade', 'avulsa', 'estorno'
    valor                  NUMERIC(10,2) NOT NULL,
    forma_pag              VARCHAR(20)   NOT NULL,  -- 'CREDIT_CARD' (MVP — DEC-04). PIX/BOLETO ficam pra Fase 2.
    status                 VARCHAR(30)   NOT NULL,  -- espelho do Asaas: PENDING, CONFIRMED, OVERDUE, REFUNDED, CHARGEBACK_REQUESTED
    vencimento             DATE,
    data_pag               TIMESTAMP,
    desconto_aplicado      NUMERIC(10,2) DEFAULT 0,  -- DEC-02: 50% off promocional vai aqui
    raw_payload            JSONB,
    datinc                 TIMESTAMP     NOT NULL DEFAULT NOW(),
    datatu                 TIMESTAMP     NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_gescob_id_emp        ON public."GESCOB" (id_emp);
CREATE INDEX IF NOT EXISTS idx_gescob_status        ON public."GESCOB" (status);
CREATE INDEX IF NOT EXISTS idx_gescob_subscription  ON public."GESCOB" (asaas_subscription_id);
CREATE INDEX IF NOT EXISTS idx_gescob_vencimento    ON public."GESCOB" (vencimento) WHERE status IN ('PENDING','OVERDUE');

COMMENT ON TABLE  public."GESCOB" IS 'FEA-014: histórico de cobranças via Asaas. Idempotência por asaas_payment_id.';
COMMENT ON COLUMN public."GESCOB".tipo              IS 'setup | mensalidade | avulsa | estorno.';
COMMENT ON COLUMN public."GESCOB".forma_pag         IS 'CREDIT_CARD no MVP (DEC-04). Adicionar PIX/BOLETO se vier Fase 2.';
COMMENT ON COLUMN public."GESCOB".raw_payload       IS 'Último webhook do Asaas recebido (auditoria + replay de eventos).';
COMMENT ON COLUMN public."GESCOB".desconto_aplicado IS 'Desconto promocional (DEC-02): ex. 50% off nos 3 primeiros meses, isenção do setup.';

-- ============================================================================
-- 3. Backfill: grupos órfãos
-- ============================================================================
-- Yuri pediu na reunião 1:1 de 2026-05-25: toda empresa MASTER (tipo='M') deve apontar pra si mesma
-- como cabeça do próprio grupo. Hoje algumas têm id_emp_grupo NULL, o que quebra queries de "todas as
-- empresas do grupo X".

UPDATE public."GESEMP"
SET id_emp_grupo = id_emp,
    datatu       = NOW()
WHERE id_emp_grupo IS NULL
  AND tipo = 'M';

-- ============================================================================
-- 4. Auditoria de CNPJ duplicado
-- ============================================================================
-- O prd.json original sugeria UNIQUE em cnpj, mas a aplicação valida unicidade só em camada de app
-- (master/iuds_pdo.php:selectGESEMP_APROVACAO_cnpj). Pode haver duplicatas históricas.
-- ESTA MIGRATION SÓ AUDITA. UNIQUE constraint fica pra migration posterior, depois de:
--   (a) confirmar zero duplicatas em prod;
--   (b) decidir se filiais com mesmo CNPJ raiz precisam de modelo diferente (subdomínio?).

DO $$
DECLARE
    dup_count INTEGER;
    dup_list  TEXT;
BEGIN
    SELECT COUNT(*),
           string_agg(cnpj || ' (' || c || 'x)', ', ' ORDER BY c DESC)
      INTO dup_count, dup_list
      FROM (
          SELECT cnpj, COUNT(*) AS c
            FROM public."GESEMP"
           WHERE cnpj IS NOT NULL AND TRIM(cnpj) <> ''
           GROUP BY cnpj
          HAVING COUNT(*) > 1
      ) d;

    IF dup_count > 0 THEN
        RAISE NOTICE 'AUDITORIA CNPJ: % grupo(s) com duplicatas: %', dup_count, dup_list;
        RAISE NOTICE 'AUDITORIA CNPJ: UNIQUE constraint NÃO foi criada. Resolver duplicatas antes da próxima migration.';
    ELSE
        RAISE NOTICE 'AUDITORIA CNPJ: zero duplicatas. Próxima migration pode criar UNIQUE em (cnpj) com segurança.';
    END IF;
END $$;

COMMIT;

-- ============================================================================
-- Pós-aplicação — passos manuais
-- ============================================================================
-- 1. Conferir output do RAISE NOTICE de auditoria (logs da execução)
-- 2. Atualizar prd.json marcando schema_changes da FEA-014 como aplicadas
-- 3. Marcar FEA-014 como COMPLETED no OKR
-- 4. Próxima FEA: 015 (esteira pública 2-step)
