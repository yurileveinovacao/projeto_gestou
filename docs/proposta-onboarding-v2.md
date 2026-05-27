# 🚀 Onboarding Comercial Gestou v2 — Proposta

**Versão:** 1.0 · **Data:** 2026-05-27 · **Autor:** Rafa (com base na reunião 1:1 Rafa/Yuri de 2026-05-25)

> 📋 Este documento tem uma versão para compartilhar em `~/Downloads/onboarding-gestou-v2-apresentacao.md`. Esta cópia versionada vive no repo pra rastreabilidade.

---

## 🎯 Por que estamos fazendo isso

Vamos **ligar campanhas de Ads** pra Gestou. Antes disso, a esteira comercial precisa estar pronta — hoje ela:

- Depende de aprovação manual no `/master/` (gargalo)
- Não captura pagamento (lead aprovado entra sem pagar, cobrança é manual)
- Não tem mecanismo de recuperação de leads que abandonaram o cadastro
- Não tem pipeline visível pro time comercial

A meta é virar isso num **fluxo self-service profissional**, no padrão de SaaS B2B sério (Stripe Checkout, Conta Azul, Omie), preparando a operação pra escalar.

---

## 💡 A pergunta-chave: cadastro antes ou depois do pagamento?

**Decidimos: cadastro mínimo ANTES, pagamento DEPOIS.**

Esse é o padrão de mercado em SaaS B2B sério. As razões:

| Argumento | Por quê |
|---|---|
| **Recuperação de abandono** | Sem email gravado antes do gateway, qualquer fechamento de aba = lead perdido. O time comercial não tem como ligar pra recuperar. |
| **Antifraude** | Separar "criar conta" de "criar cobrança" permite validar CNPJ (BrasilAPI), aplicar captcha e rate-limit antes de gerar charge no Asaas. |
| **LGPD** | O ato de criar conta embute consentimento documentado (checkbox de Termos + base legal). Sem isso, qualquer email de recuperação é violação. |
| **Conversão** | Cada campo extra antes do gateway custa ~7% de conversão. Mas zero cadastro = zero recuperação. O equilíbrio é cadastro enxuto (4-5 campos), pagamento depois. |

---

## 🗺️ A esteira proposta

```
STEP 1 — CADASTRO MÍNIMO (Nome, CNPJ+BrasilAPI, Email, Telefone, Senha, LGPD)
              ↓ lead já está no banco. mesmo que feche, recuperamos.
STEP 2 — CONFIRMAÇÃO DE EMAIL + ESCOLHA DE PLANO (1 CNPJ ou grupo?)
              ↓
STEP 3 — CHECKOUT ASAAS (PIX default, Cartão recorrente, Boleto sob demanda)
              ↓
WEBHOOK → ATIVAÇÃO AUTOMÁTICA (primeiro user = Líder RH, email de boas-vindas)
              ↓
STEP 4 — WIZARD PÓS-PAGAMENTO (endereço fiscal, foto, primeiros colabs)
```

Detalhes do diagrama visual completo: `~/Downloads/onboarding-gestou-v2-apresentacao.md`.

---

## 🔁 Recuperação de abandono

Cron job que varre leads parados:

| Tempo | Ação |
|---|---|
| 1h | Email #1 — "Você está a 1 clique de começar" |
| 24h | Email #2 |
| 72h | Email #3 — janela dourada |
| 7 dias | SDR humano (lead aparece na lista do master) |
| 30 dias | Arquivar (LGPD: hash do email pra evitar reenvio) |

E `/master/pipeline_leads.php` mostra tudo em kanban/tabela com filtros e ações.

---

## 💰 Modelo de cobrança — mudança no contrato

| | Atual (SE Hotéis, set/2025) | Proposto |
|---|---|---|
| Por colaborador | R$ 6,00/mês | (embutido no fixo) |
| Por CNPJ | R$ 49,90/mês | (embutido no fixo) |
| Setup | R$ 500 único | Mantém |
| Reajuste | IGP-M anual | **Δ ≥ 15-20% no headcount** |

⚠️ **Contrato precisa de revisão jurídica** — Cláusula 5ª é incompatível com modelo fixo.

---

## 🗂️ Roadmap em sub-FEAs

| # | Entrega | Esforço | Depende |
|---|---|---|---|
| **FEA-014** | Schema base — máquina de estados, GESCOB, backfill, limpeza grupos | 1d | — |
| **FEA-015** | Esteira pública 2-step + validação email + lookup CNPJ | 3-4d | 014 |
| **FEA-016** | Integração Asaas (Customer + Subscription + Webhook) | 3-5d | 014, 015 |
| **FEA-017** | Recovery de abandono + Pipeline no master | 2d | 014, 015 |
| **FEA-018** | Cadastro direto no master (substitui FEA-012) | 1-2d | 015 |
| **FEA-019** | Wizard pós-pagamento | 2d | 016 |
| **FEA-020** | Revisão do contrato (jurídico) | Externo | — (paralelo) |

**Total técnico: 13-17 dias úteis.**

---

## 🤔 Decisões pendentes (10 itens em `prd.json`)

### 🔴 Bloqueantes
1. **% gatilho de reajuste** — 15 ou 20%
2. **Modelo de preço** — fixo único vs. planos escalonados
3. **Trial** — sem / 7d com cartão / 14d sem cartão (rec: **sem**)
4. **Formas de pagamento** — só PIX / PIX+Cartão / +Boleto (rec: **PIX+Cartão**)
8. **CNPJs múltiplos no checkout** — todos vs. só principal (rec: **só principal**)

### 🟡 Importantes (paralelo OK)
5. NFS-e — adiar / NFe.io / eNotas (rec: **adiar**)
6. Endereço fiscal — checkout vs. pós-pagamento (rec: **pós**)
7. Setup R$500 — junto / separado / eliminar (rec: **junto**)
9. Aprovação manual continua? — sim/não (rec: **sim, pra indicação**)
10. Quem revisa contrato — Yuri sozinho / Rafa minuta primeiro

---

## 🚦 Sinal verde

Pra começar amanhã (2026-05-28):

- [ ] Respostas em 1, 2, 3, 4, 8
- [ ] Conta sandbox Asaas
- [ ] OK pra substituir FEA-012 pela FEA-018
- [ ] OK pra arquivar `cadastro_empresa.php` legado

---

## 🎁 Bônus técnico

Dívidas resolvidas naturalmente:

- Limpeza de grupos órfãos (você pediu na reunião)
- Endpoint `validar_email` finalmente implementado (token existe há tempos sem uso)
- Single source of truth pro cadastro (checkout público = master interno)
- UNIQUE em CNPJ
- Auditoria de funil completa

---

## 📚 Referências

- `prd.json` — PRD técnico detalhado
- `docs/archive/prd-original.json` — PRD histórico arquivado
- `Brain/02_Logs/2026-05-26.md` — log da sessão de levantamento
- Transcrição reunião 2026-05-25 (`~/Downloads/One a One (Rafa_Yuri)...`)
- Contrato SE Hotéis (`~/Downloads/CONTRATO GESTOU - SE HOTEIS.docx`)
