# Pendências em Aberto

Documento vivo. Lista o que ficou em aberto após o cutover (2026-04-24) e o que está esperando
sessão dedicada / terceiros. Itens concluídos saem daqui — histórico fica no `progress.txt`.

Última atualização: 2026-05-11.

---

## Operacional (pós-cutover)

### 1. Cloud Scheduler — FEA-003 (alertas de experiência por email)
**Status:** secret `cron-secret` e env `CRON_SECRET` já configurados no Cloud Run (revisão 113).
Falta apenas criar o job.

```bash
gcloud scheduler jobs create http cron-check-experiencias \
  --schedule="0 8 * * *" \
  --time-zone=America/Sao_Paulo \
  --uri="https://gestou.com.br/admin/cron_check_experiencias.php?token=<CRON_SECRET>" \
  --http-method=GET \
  --project=gestou-489010 \
  --location=us-central1
```

Substituir `<CRON_SECRET>` pelo valor do secret:
`gcloud secrets versions access latest --secret=cron-secret --project=gestou-489010`

### 2. SMTP do domínio `@gestou.com.br`
Hoje o `FROM` é `contato@leveinovacao.com.br` (Gmail) — fallback temporário.
Kinghost SMTP dá timeout vindo do Cloud Run (testado em 2026-04-24).
**Ação:** investigar Google Workspace pro domínio `gestou.com.br` e devolver o `FROM`
pra `suporte@gestou.com.br` ou similar.

### 3. Rotação de credenciais Kinghost expostas no chat
Durante a migração, senhas de DB, FTP e SMTP do Kinghost circularam.
**Ação:** rotacionar enquanto o Kinghost ainda está ativo. Chave 2 do Azure Vision já foi rotacionada.

### 4. Logo — variantes restantes
`img/gestou-logo.png` já foi atualizada (2026-05-01). Faltam:
`logo_gestou_escrita_branco.png`, `icone_gestou.png` e outras variantes — aguardando entrega do cliente.

### 5. Monitorar primeiro upload real de holerite/IRRF/ponto
Até 2026-04-29 o bucket `gestou-uploads-489010` recebeu só 12 arquivos pós-cutover
(notificações RH + mural + fotos de aprovação) — nenhum holerite/IRRF/ponto.
Fluxo crítico ainda **não exercitado**. Acompanhar quando alguém fechar folha.

### 6. Descomissionar servidor Kinghost
Após período estável de monitoramento e rotação das credenciais.

---

## Fase 5 — App Android (TWA)

**Track A — Play Console** (5/6 etapas pendentes)

D-U-N-S Number liberado em 2026-05-04. Falta sessão dedicada pra:
1. Criar conta Play Console (com D-U-N-S)
2. Preencher listing (descrição curta/longa, categoria, contato)
3. Upload do APK assinado (já existe — Track C concluído)
4. Screenshots e assets visuais
5. Política de privacidade publicada
6. Submeter pra revisão

Tracks B (PWA) e C (build TWA) já concluídos.

---

## Backlog — aguardando planejamento

| Item | Situação |
|---|---|
| **RPA** — Recibo de Pagamento Autônomo | Documentos recebidos da Jéssica — aguarda sessão de detalhamento |
| **IA 1 — Compliance** (Ponto vs. Convenção + Relatórios vs. Holerite) | Documentos recebidos — aguarda sessão dedicada |
| **IA 2 — Suporte Bia** (landing + plataforma) | Aguarda sessão dedicada |
| **Recrutamento e Seleção** | Baixa prioridade — próxima fase |

---

## Referências

- Histórico da migração: [`docs/archive/`](archive/)
- Log cronológico de entregas: [`../progress.txt`](../progress.txt)
- PRD cumulativo (MIG + FEA): [`../prd.json`](../prd.json)
- Instruções operacionais: [`../CLAUDE.md`](../CLAUDE.md)
