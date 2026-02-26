# Ralph Agent Instructions — Gestou Migration

Você é um agente autônomo migrando o sistema Gestou para GCP.

## Sua Tarefa

1. Leia o PRD em `prd.json` na raiz do projeto
2. Leia o progress log em `progress.txt` (leia a seção Codebase Patterns primeiro)
3. Confirme que está na branch `migration/gcp`. Se não, crie a partir de main.
4. Pegue a user story de **maior prioridade** onde `passes: false`
5. Implemente APENAS essa story
6. Rode os comandos de verificação dos acceptance criteria
7. Se TODOS os criteria passam, faça commit: `feat: [Story ID] - [Story Title]`
8. Atualize prd.json marcando `passes: true` na story completa
9. Atualize progress.txt com o log da iteração
10. Se descobriu algo útil, adicione na seção Codebase Patterns do progress.txt

## Projeto

Sistema de RH/folha multi-tenant. PHP 7.4 puro (SEM framework), PostgreSQL 17, Apache.

## Estrutura
```
/              → Site público
/admin/        → Painel RH (158 PHP, iuds_pdo.php = 10.750 linhas)
/app/          → Portal colaborador (76 PHP)
/master/       → Super-admin (51 PHP)
/createemployee/ → Cadastro via token
/createaccount/  → Auto-registro
/config/       → Configs centralizados (criados por você)
```

## Regras ABSOLUTAS

- NUNCA altere arquivos em vendor/ ou vendor_* (dependências externas)
- NUNCA altere arquivos em admin/layout/ (83 templates de OCR)
- NUNCA altere .gitignore para remover vendor/ (eles ficam fora do git)
- Use __DIR__ para paths em require (ex: `require __DIR__.'/../config/database.php'`)
- PHP 7.4 — sem union types, sem match(), sem named arguments, sem readonly
- Commits semânticos: feat:, refactor:, fix:, docs:

## Formato do Progress Log

APPEND ao progress.txt (nunca substituir, sempre adicionar ao final):
```
## [Data/Hora] - [Story ID] - [Story Title]
- O que foi implementado
- Arquivos criados/alterados
- Comandos de verificação rodados e resultados
- **Learnings:**
  - Padrões descobertos
  - Gotchas encontrados
---
```

## Consolidar Padrões

Se descobrir algo reutilizável, adicione na seção `## Codebase Patterns` no TOPO do progress.txt.

## Stop Condition

Após completar uma story, verifique se TODAS as stories têm `passes: true`.
Se TODAS completas, responda com:
<promise>COMPLETE</promise>

Se ainda há stories com `passes: false`, encerre normalmente.

## Importante

- Trabalhe em UMA story por iteração
- Faça commit com frequência
- Leia Codebase Patterns antes de começar
- Consulte PRD.md para contexto detalhado se necessário
