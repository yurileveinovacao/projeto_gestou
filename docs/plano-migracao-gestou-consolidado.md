# Gestou — Plano de Migração GCP (Consolidado)

**Última atualização:** 05/03/2026
**Responsável:** Yuri (Leve Inovação Estratégica)

---

## Arquitetura Final

```
Usuário → gestou.leveinovacao.com.br (Cloudflare DNS, proxy OFF)
       → ghs.googlehosted.com (Cloud Run domain mapping)
       → Cloud Run gen2 (us-central1, PHP 7.4 + Apache, porta 8080)
       → Cloud SQL PostgreSQL 17 (via Unix socket /cloudsql/)
       → GCS FUSE (uploads montados em /var/www/html/upload/)
       → Google Vision API (OCR de holerites, pontos, IRRF)
       → smtp.gmail.com (envio de email via app password)
```

**Projeto GCP:** gestou-489010
**Bucket:** gs://gestou-uploads-489010
**Secrets:** db-password, smtp-password, google-vision-api-key
**Service Account:** 469696711631-compute@developer.gserviceaccount.com

---

## Status Geral

| Fase | Status | Progresso |
|------|--------|-----------|
| Fase 1 — Validação Local | ✅ Completa | 15/15 |
| Fase 2 — Infraestrutura GCP | ✅ Completa | 9/9 |
| Fase 3 — Migração de Dados | ✅ Completa | 8/8 |
| Fase 4A — Deploy | ✅ Completa | 10/10 |
| **Fase 4B — Compatibilidade OCR Templates** | **🔧 Em andamento** | **1/16** |
| **Fase 5 — App Android TWA** | **⬜ Pendente** | **0/21** |
| **Fase 6 — Cutover** | **⬜ Pendente** | **0/13** |

---

## Fase 1 — Validação Local ✅

Todas as 15 tarefas concluídas. Ralph Loop executou 12 stories em 11 iterações, 196 arquivos alterados, zero erros.

## Fase 2 — Infraestrutura GCP ✅

Todos os 9 recursos provisionados em us-central1 (migrado de southamerica-east1).

## Fase 3 — Migração de Dados ✅

Banco restaurado (307 tabelas), uploads sincronizados (43k arquivos, 8.5GB), healthcheck OK.

## Fase 4A — Deploy ✅

Deploy no Cloud Run, domain mapping, SSL, login nos 3 módulos, email SMTP, OCR com Google Vision, GCS FUSE funcionando.

---

## Fase 4B — Compatibilidade OCR Templates com Google Vision

### Contexto

A migração de Azure Computer Vision para Google Cloud Vision alterou a ordem de retorno do texto OCR. No Azure, o texto vinha em ordem visual (esquerda→direita, cima→baixo). No Google Vision, campos como "EXERCÍCIO: 2026" podem vir em linhas separadas e antes de outros campos como CNPJ.

### Problemas identificados

1. **Detecção de ano/competência** — código busca o ano APÓS o CNPJ, mas Google Vision retorna o ano ANTES
2. **Falta mkdir** — diretórios dinâmicos por CNPJ não existem no GCS FUSE

### Templates afetados

**IRRF (3 em uso + 1 inativo):**

| Template | Em uso | Status |
|----------|--------|--------|
| dirf_v4.php | ✅ | ✅ Corrigido |
| dirf2_v4.php | ✅ | ⬜ Pendente |
| dirf_v5.php | ✅ | ⬜ Pendente |
| dirf_v4_ignora_cnpj.php | ❌ | ⬜ Baixa prioridade |

**Holerite (14 em uso):** acedata_v8, contimatic_v8, contimatic_v9, dominio_v8, dominio_v8_i, dominio_v8_mg, dominio_v9, dominio_v9_mr, dominio_v9_s, dpcuca_v8, folhamatic_v9, folhamatic_v10, holerite_1_v8, photeus_v8, totvs_rm_v8

**Ponto (5 em uso):** ponto_1_v7, pontosecullum_p_v7, pontosecullum_v7, saturno_v1, tangerino_v7

### Tarefas

| # | Tarefa | Estimativa |
|---|--------|------------|
| 1 | Analisar e corrigir dirf2_v4.php (ano + mkdir) | 1h |
| 2 | Analisar e corrigir dirf_v5.php (ano + mkdir) | 1h |
| 3 | Testar IRRF dirf2_v4 com PDF real | 30min |
| 4 | Testar IRRF dirf_v5 com PDF real | 30min |
| 5 | Analisar padrão de competência nos holerites (template modelo) | 1h |
| 6 | Aplicar fix de detecção nos 14 templates de holerite | 3h |
| 7 | Aplicar mkdir nos 14 templates de holerite | 1h |
| 8 | Testar holerite com PDF real (mín. 2 templates diferentes) | 1h |
| 9 | Analisar padrão de período nos pontos (template modelo) | 1h |
| 10 | Aplicar fix de detecção nos 5 templates de ponto | 1h |
| 11 | Aplicar mkdir nos 5 templates de ponto | 30min |
| 12 | Testar ponto com PDF real (mín. 1 template) | 30min |
| 13 | Rebuild e deploy Docker | 15min |
| 14 | Commit e push das alterações | 15min |
| 15 | Atualizar documentação | 30min |
| 16 | Validação final — importar 1 de cada tipo (holerite + ponto + IRRF) | 1h |

**Estimativa total: ~10-12h**

---

## Fase 5 — App Android TWA

### Contexto

O app antigo era um WebView wrapper (5.1MB, package `br.com.gestou`) apontando para `www.gestou.com.br/app/login`. Foi removido da Play Store, sem código fonte. A nova abordagem usa TWA (Trusted Web Activity), que carrega o site via Chrome nativo — performance superior, atualizações instantâneas, sem WebView.

### Pré-requisitos

| Requisito | Status |
|-----------|--------|
| HTTPS | ✅ Cloud Run SSL |
| Web App Manifest | ⬜ Precisa criar |
| Service Worker | ⬜ Precisa criar |
| Digital Asset Links | ⬜ Precisa criar |
| Lighthouse Score ≥ 80 | ⬜ Precisa verificar |
| Conta Google Play Console | ⬜ Precisa criar |

### Tarefas

**Track A — Conta Play Console (iniciar imediatamente, 3-5 dias úteis):**

| # | Tarefa | Estimativa |
|---|--------|------------|
| 1 | Solicitar número D-U-N-S (Dun & Bradstreet) | 5 dias úteis |
| 2 | Criar conta organizacional no Play Console (US$ 25) | 1h |
| 3 | Verificar identidade e organização | 1-2 dias |
| 4 | Configurar perfil do desenvolvedor | 30min |

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
| 05/03 | TWA em vez de WebView wrapper | Google recomenda, performance superior, sem código nativo |

---

## Estimativa de custos GCP (mensal)

| Serviço | Custo estimado |
|---------|---------------|
| Cloud SQL (db-f1-micro, 10GB) | ~US$ 8-12 |
| Cloud Run (min 0, max 3, 1GB, gen2) | ~US$ 0-25 |
| Cloud Storage (~10GB) | ~US$ 0.25 |
| VPC Connector | ~US$ 10-15 |
| Vision API (~500 págs/mês) | ~US$ 0.75 |
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
