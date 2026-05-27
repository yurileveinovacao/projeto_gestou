# Pendências em Aberto

**Fonte da verdade**: as pendências em aberto vivem no **OKR** (projeto `gestou-2026`).
Este arquivo deixou de ser o tracker — passou a ser só um pointer.

## Como consultar

- **Via CLI** (plugin OKR oficial):
  ```bash
  claude-okr call GET '/api/agent/tasks?projectToken=gestou-2026&status=PENDING'
  ```
- **Via web**: <https://okr.leveinovacao.com.br>

## Por que mudou

Manter as pendências em arquivo Markdown gerava drift (entregas saíam de produção e o doc ficava com info errada — ex.: FEA-009 e FEA-011 entregues há semanas mas ainda listadas como "aguardando MVP"). O OKR é a fonte ativa: toda nova tarefa entra lá com descrição rica, status real e responsável atribuído.

## Itens que **NÃO viraram tarefas** (decisões registradas para não voltarem)

| Item antigo | Por quê não virou tarefa |
|---|---|
| Rotação de credenciais Kinghost | Yuri decidiu em 2026-05-27 que não será feita por nós. |
| Descomissionar servidor Kinghost | Quem descomissiona é o lado Kinghost/cliente, não nós. |
| Monitorar 1º upload de holerite/IRRF/ponto em prod | Passivo (acompanhamento, não tarefa). |
| Recrutamento e Seleção | Placeholder vago. Quando for priorizado, criamos tarefa com escopo real. |
| Migração SMTP `@gestou.com.br` | Yuri descartou em 2026-05-21 — Gmail Leve fica como está. |

## Referências relacionadas

- [`../progress.txt`](../progress.txt) — log cronológico de entregas (continua vivo)
- [`../prd.json`](../prd.json) — PRD do épico Onboarding Comercial v2 (FEA-014..020)
- [`./proposta-onboarding-v2.md`](./proposta-onboarding-v2.md) — apresentação do épico
- [`./archive/`](./archive/) — docs históricos da migração e o PRD original arquivado
