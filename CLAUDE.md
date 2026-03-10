# Gestou — Instruções do Projeto

## Projeto

Sistema de RH/folha multi-tenant. PHP 7.4 puro (SEM framework), PostgreSQL 17, Apache.
Hospedado no GCP (Cloud Run + Cloud SQL).

## Estrutura
```
/              → Site público
/admin/        → Painel RH (158 PHP, iuds_pdo.php = 10.750 linhas)
/app/          → Portal colaborador (76 PHP)
/master/       → Super-admin (51 PHP)
/createemployee/ → Cadastro via token
/createaccount/  → Auto-registro
/config/       → Configs centralizados (database, email, storage, urls, session)
/docs/         → Documentação e planos
/scripts/      → Scripts de migração e utilitários
```

## Regras ABSOLUTAS

- NUNCA altere arquivos em vendor/ ou vendor_* (dependências externas)
- NUNCA altere .gitignore para remover vendor/ (eles ficam fora do git)
- Use __DIR__ para paths em require (ex: `require __DIR__.'/../config/database.php'`)
- PHP 7.4 — sem union types, sem match(), sem named arguments, sem readonly
- Commits semânticos: feat:, refactor:, fix:, docs:, chore:

## Templates OCR (admin/layout/)

- 83 templates de OCR (holerite/irrf/ponto) — alterar APENAS quando necessário para compatibilidade com Google Vision
- Problemas conhecidos: Google Vision retorna texto em ordem diferente do Azure (ano antes do CNPJ, campos em linhas separadas)
- Ao corrigir templates: adicionar detecção antecipada de ano + mkdir dinâmico para GCS FUSE
- Referência de fixes aplicados: progress.txt (seção Fase 4B)

## Deploy (processo manual)

```bash
# Build da imagem Docker
docker build -t us-central1-docker.pkg.dev/gestou-489010/gestou/gestou:latest .

# Push para Artifact Registry
docker push us-central1-docker.pkg.dev/gestou-489010/gestou/gestou:latest

# Deploy no Cloud Run
gcloud run deploy gestou \
  --image us-central1-docker.pkg.dev/gestou-489010/gestou/gestou:latest \
  --region us-central1
```

## Status Atual

**Fase 4B — Compatibilidade OCR Templates** (em andamento, 1/16 tarefas)
- IRRF: 3 templates corrigidos (dirf_v4, dirf2_v4, dirf_v5), faltam holerites e pontos
- Próximo: analisar e corrigir 14 templates de holerite + 5 de ponto

## Referência

- `progress.txt` — log ativo de progresso (Fase 4B+) e Codebase Patterns
- `docs/plano-migracao-gestou-consolidado.md` — plano completo das Fases 4B-6
- `prd.json` — PRD original da migração GCP (12 stories, 100% concluído)
- `docs/progress-prd-original.txt` — log histórico detalhado das 12 stories do PRD
