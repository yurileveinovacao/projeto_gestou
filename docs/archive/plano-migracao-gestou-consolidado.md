# Gestou — Plano de Migração GCP (Consolidado)

**Última atualização:** 01/04/2026
**Responsável:** Yuri (Leve Inovação Estratégica)

---

## Arquitetura Final

```
Usuário → gestou.leveinovacao.com.br (Cloudflare DNS, proxy OFF)
       → ghs.googlehosted.com (Cloud Run domain mapping)
       → Cloud Run gen2 (us-central1, PHP 7.4 + Apache, porta 8080)
       → Cloud SQL PostgreSQL 17 (via Unix socket /cloudsql/)
       → GCS FUSE (uploads montados em /var/www/html/upload/)
       → Azure Computer Vision API (OCR de holerites, pontos, IRRF)
       → smtp.gmail.com (envio de email via app password)
```

**Projeto GCP:** gestou-489010
**Bucket:** gs://gestou-uploads-489010
**Secrets:** db-password, smtp-password, azure-vision-endpoint, azure-vision-key
**Service Account:** 469696711631-compute@developer.gserviceaccount.com

---

## Status Geral

| Fase | Status | Progresso |
|------|--------|-----------|
| Fase 1 — Validação Local | ✅ Completa | 15/15 |
| Fase 2 — Infraestrutura GCP | ✅ Completa | 9/9 |
| Fase 3 — Migração de Dados | ✅ Completa | 8/8 |
| Fase 4A — Deploy | ✅ Completa | 10/10 |
| Fase 4B — Compatibilidade OCR Templates | ✅ Completa | 16/16 |
| **Fase 5 — App Android TWA** | **🔧 Em andamento** | **16/21** (D-U-N-S liberado 2026-05-04 — sessão dedicada pendente p/ Play Console) |
| **Fase 6 — Cutover** | **✅ Completa** | **13/13** (concluído em 2026-04-24) |

---

## Fase 1 — Validação Local ✅

Todas as 15 tarefas concluídas. Ralph Loop executou 12 stories em 11 iterações, 196 arquivos alterados, zero erros.

## Fase 2 — Infraestrutura GCP ✅

Todos os 9 recursos provisionados em us-central1 (migrado de southamerica-east1).

## Fase 3 — Migração de Dados ✅

Banco restaurado (307 tabelas), uploads sincronizados (43k arquivos, 8.5GB), healthcheck OK.

## Fase 4A — Deploy ✅

Deploy no Cloud Run, domain mapping, SSL, login nos 3 módulos, email SMTP, OCR com Azure Computer Vision, GCS FUSE funcionando.

---

## Fase 4B — OCR Templates ✅

Inicialmente adaptados para Google Vision (23 templates corrigidos, ~20 commits). Posteriormente revertidos para Azure Computer Vision (2026-03-30) devido a problemas crônicos de ordenação de texto no Google Vision.

### Decisão final: Azure Computer Vision

- Google Vision retornava texto em ordem aleatória a cada chamada, exigindo ajustes complexos
- Azure já funcionava corretamente com os templates originais
- Validação: 64/64 valores idênticos ao sistema de produção — **0 divergências**
- Templates revertidos para estado original (compatível Azure)
- Custo Azure: ~$0.50/mês para ~500 páginas (S1: $1/1000 transações)

---

## Fase 5 — App Android TWA

### Contexto

O app antigo era um WebView wrapper (5.1MB, package `br.com.gestou`) apontando para `www.gestou.com.br/app/login`. Foi removido da Play Store, sem código fonte. A nova abordagem usa TWA (Trusted Web Activity), que carrega o site via Chrome nativo — performance superior, atualizações instantâneas, sem WebView.

### Pré-requisitos

| Requisito | Status |
|-----------|--------|
| HTTPS | ✅ Cloud Run SSL |
| Web App Manifest | ✅ Criado |
| Service Worker | ✅ Criado |
| Digital Asset Links | ✅ Criado e validado |
| Lighthouse Score ≥ 80 | ✅ Score 100 |
| Conta Google Play Console | ⬜ Pendente |

### Tarefas

**Track A — Conta Play Console (sessão dedicada pendente):**

| # | Tarefa | Status |
|---|--------|--------|
| 1 | Solicitar número D-U-N-S (Dun & Bradstreet) | ✅ Liberado em 2026-05-04 |
| 2 | Criar conta organizacional no Play Console (US$ 25) | ⬜ Pendente |
| 3 | Verificar identidade e organização | ⬜ Pendente |
| 4 | Configurar perfil do desenvolvedor | ⬜ Pendente |

**Track B — PWA (desenvolvimento, ~2 dias):**

| # | Tarefa | Estimativa |
|---|--------|------------|
| 5 | Criar ícones do app (192x192, 512x512, maskable) | 1h |
| 6 | Criar manifest.json | 30min |
| 7 | Criar service worker (sw.js) | 1h |
| 8 | Criar página offline (offline.html) | 30min |
| 9 | Adicionar meta tags e registrar SW nos templates do /app/ | 1h |
| 10 | Rebuild imagem Docker e redeploy Cloud Run | 15min |
| 11 | Testar Lighthouse score ≥ 80 | 30min |
| 12 | Testar instalação PWA pelo navegador mobile | 30min |

**Track C — Build TWA e Publicação (após A e B, ~2 dias):**

| # | Tarefa | Estimativa |
|---|--------|------------|
| 13 | Gerar keystore de assinatura | 15min |
| 14 | Build TWA com Bubblewrap/PWABuilder | 1h |
| 15 | Criar .well-known/assetlinks.json | 30min |
| 16 | Redeploy Cloud Run com assetlinks | 15min |
| 17 | Validar Digital Asset Links | 15min |
| 18 | Testar APK no celular | 30min |
| 19 | Criar assets da Store (feature graphic, screenshots) | 2h |
| 20 | Escrever descrições e configurar listing | 1h |
| 21 | Upload AAB, teste interno e promover para produção | 1-3 dias |

### Especificações técnicas

**manifest.json:**
```json
{
  "name": "Gestou - Holerite Digital",
  "short_name": "Gestou",
  "start_url": "/app/login",
  "scope": "/app/",
  "display": "standalone",
  "background_color": "#4A0E8F",
  "theme_color": "#4A0E8F",
  "lang": "pt-BR",
  "icons": [
    { "src": "/app/icons/icon-192x192.png", "sizes": "192x192", "type": "image/png" },
    { "src": "/app/icons/icon-512x512.png", "sizes": "512x512", "type": "image/png" },
    { "src": "/app/icons/icon-maskable-512x512.png", "sizes": "512x512", "type": "image/png", "purpose": "maskable" }
  ]
}
```

**assetlinks.json** (em `/.well-known/`):
```json
[{
  "relation": ["delegate_permission/common.handle_all_urls"],
  "target": {
    "namespace": "android_app",
    "package_name": "br.com.gestou",
    "sha256_cert_fingerprints": ["SHA256_DO_KEYSTORE"]
  }
}]
```

**Store Listing:**
- Título: "Gestou - Holerite Digital" (30 chars)
- Descrição curta: "Acesse holerites, documentos e informações do DP pelo celular." (63 chars)
- Classificação: 13+
- Política de privacidade: https://gestou.leveinovacao.com.br/politica_privacidade

### Custos

| Item | Custo | Recorrência |
|------|-------|-------------|
| Google Play Console | US$ 25 (~R$ 150) | Único |
| D-U-N-S, Bubblewrap, SSL | Gratuito | — |

### Vantagens TWA vs WebView (app antigo)

| Aspecto | WebView (antigo) | TWA (novo) |
|---------|-----------------|------------|
| Renderização | WebView (desatualizado) | Chrome nativo |
| Atualizações | Novo APK | Instantâneo via site |
| OAuth/Login | Pode bloquear | Funciona normal |
| Tamanho | ~5MB | ~1-2MB |
| Push Notifications | Nativo obrigatório | Web Push API |

**Estimativa total: ~7-12 dias úteis (Tracks A e B em paralelo)**

---

## Fase 6 — Cutover

### Tarefas

| # | Tarefa | Prazo sugerido |
|---|--------|----------------|
| 1 | Congelar alterações no servidor antigo | D-1 |
| 2 | Fazer dump final do banco de produção | D-1 |
| 3 | Importar dump final no Cloud SQL | D-1 |
| 4 | Sincronização final de uploads para GCS | D-1 |
| 5 | Testar todos os fluxos críticos em produção | D-Day |
| 6 | Configurar redirect gestou.com.br → gestou.leveinovacao.com.br | D-Day |
| 7 | Atualizar download.php com link da Play Store | D-Day |
| 8 | Remover APK antigo de downloads/ | D-Day |
| 9 | Monitorar logs do Cloud Run (primeiras 48h) | D+1 a D+2 |
| 10 | Validar custos GCP vs estimativa | D+7 |
| 11 | Descomissionar servidor antigo (após 30 dias) | D+30 |
| 12 | Commit e push final | D-Day |
| 13 | Comunicar clientes sobre novo domínio/app | D-Day |

---

## Decisões técnicas

| Data | Decisão | Motivo |
|------|---------|--------|
| 03/03 | us-central1 em vez de southamerica-east1 | Domain mapping não suportado em SAE1 |
| 03/03 | Unix socket em vez de IP público | Segurança + simplicidade |
| 04/03 | smtp.gmail.com em vez de smtp-relay.gmail.com | Relay requer IP fixo, Cloud Run tem IP dinâmico |
| 04/03 | Remover img/images_email do .dockerignore | PHPMailer AddEmbeddedImage precisa dos arquivos |
| 05/03 | GCS FUSE (gen2) em vez de STORAGE_DRIVER=gcs | Zero mudança de código, caminhos existentes funcionam |
| 05/03 | mkdir dinâmico nos templates | GCS FUSE não tem diretórios pré-criados |
| 05/03 | Detecção antecipada de ano nos templates | Google Vision retorna texto em ordem diferente do Azure |
| 30/03 | Retorno ao Azure Computer Vision | Google Vision com ordenação aleatória; Azure 64/64 valores corretos |
| 05/03 | TWA em vez de WebView wrapper | Google recomenda, performance superior, sem código nativo |
| 23/03 | memory_limit=512M + Cloud Run 2GB RAM | PDFs grandes (69+ págs) estouravam 128MB; 5 workers × 512MB exigem 2GB |
| 23/03 | log_errors=stderr + display_errors=Off | Erros PHP agora visíveis nos logs do Cloud Run |

---

## Estimativa de custos GCP (mensal)

| Serviço | Custo estimado |
|---------|---------------|
| Cloud SQL (db-f1-micro, 10GB) | ~US$ 8-12 |
| Cloud Run (min 0, max 3, 2GB, gen2) | ~US$ 0-35 |
| Cloud Storage (~10GB) | ~US$ 0.25 |
| VPC Connector | ~US$ 10-15 |
| Azure Computer Vision (~500 págs/mês) | ~US$ 0.50 |
| Secret Manager + Artifact Registry | ~US$ 0.15 |
| **Total** | **~US$ 20-55/mês** |

---

## Bugs corrigidos durante migração

1. **Redirect loops .htaccess** — 4 arquivos com redirect hardcoded para gestou.com.br
2. **Session persistence** — 19 arquivos sem PgSessionHandler
3. **Logout headers already sent** — 3 arquivos sair.php com HTML antes de session_start
4. **Cloud SQL permissão** — role cloudsql.client no service account
5. **Secret Manager permissão** — role secretmanager.secretAccessor
6. **Org policy allUsers** — liberado via console
7. **SMTP host** — smtp-relay.gmail.com → smtp.gmail.com (IP dinâmico)
8. **Imagens email no Docker** — .dockerignore excluía img/images_email/
9. **GCS FUSE permissão** — role storage.objectAdmin no bucket
10. **IRRF mkdir** — diretório por CNPJ não existia no GCS FUSE
11. **IRRF ano exercício** — Google Vision retorna ano antes do CNPJ
