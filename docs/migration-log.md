# Log de Migração — Gestou para GCP

Data: Março/2026
Responsável: Yuri (Leve Inovação) + Claude AI

## Resumo

Migração do Gestou (SaaS de gestão de DP/holerites) do hosting externo para Google Cloud Platform.
- **12 stories** executadas via Ralph Loop (automação com Claude Code)
- **11 iterações**, zero erros
- **196 arquivos** alterados, 3.703 inserções, 777 deleções

## Bugs encontrados e corrigidos

### 1. Redirect loops nos .htaccess (4 arquivos)

**Problema:** Os arquivos `.htaccess` na raiz, admin/, app/ e master/ continham regras de redirect hardcoded para `gestou.com.br` e `www.gestou.com.br`. No Docker local (localhost:8080), isso causava `ERR_TOO_MANY_REDIRECTS`.

**Arquivos afetados:**
- `.htaccess`
- `admin/.htaccess`
- `app/.htaccess`
- `master/.htaccess`

**Fix:** Removidas as regras de redirect de domínio, mantendo apenas o rewrite de extensão .php:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}\.php -f
RewriteRule ^(.*)$ $1.php
```

**Commit:** `fix: remover redirects hardcoded de gestou.com.br nos .htaccess`

---

### 2. Session persistence failure (19 arquivos)

**Problema:** O Ralph Loop adicionou `PgSessionHandler` nos 3 `restrito.php` (admin, app, master), mas 19 outros arquivos chamavam `session_start()` sem carregar o handler. Resultado: login POST escrevia a sessão no filesystem (handler padrão), mas `restrito.php` lia do PostgreSQL (vazio), causando redirect infinito para login.

**Arquivos afetados:**
- `validar_sair.php`, `consulta_registro.php`
- `admin/sair.php`, `admin/esqueci_senha.php`, `admin/esqueci_valida_codigo.php`, `admin/esqueci_troca_senha.php`, `admin/antigo/login.php`, `admin/controller/login_post.php`
- `app/sair.php`, `app/login.php`, `app/util.php`, `app/esqueci_troca_senha.php`, `app/validar_login.php`, `app/controller/esqueci_valida_codigo_post.php`, `app/controller/esqueci_troca_senha_post.php`, `app/controller/esqueci_senha_post.php`
- `master/sair.php`, `master/login.php`

**Fix:** Adicionado `require_once __DIR__.'/../config/session.php';` antes de cada `session_start()` em todos os 19 arquivos.

**Commit:** `fix: incluir PgSessionHandler em todos os session_start() fora do restrito.php`

---

### 3. Logout causando "headers already sent" (3 arquivos)

**Problema:** Os arquivos `sair.php` (admin, app, master) iniciavam com `<!DOCTYPE html>` (HTML), e o `require_once config/session.php` + `session_start()` estavam na linha 14, após o HTML já ter sido enviado. Resultado: PHP warnings de "Cannot change save handler when headers already sent".

**Arquivos afetados:**
- `admin/sair.php`
- `app/sair.php`
- `master/sair.php`

**Fix:** Movido o bloco PHP para a linha 1, antes de qualquer HTML, com `exit` para impedir processamento do HTML restante:
```php
<?php require_once __DIR__."/../config/session.php"; session_start(); session_destroy(); header("Location: /admin/login"); exit; ?>
```

**Commit:** `fix: mover session_start para antes do HTML nos sair.php`

---

### 4. Cloud Run sem permissão para Cloud SQL (infra)

**Problema:** O service account padrão do Cloud Run não tinha role `cloudsql.client`, necessária para conectar via Unix socket.

**Fix:**
```bash
gcloud projects add-iam-policy-binding gestou-489010 \
  --member="serviceAccount:469696711631-compute@developer.gserviceaccount.com" \
  --role="roles/cloudsql.client"
```

---

### 5. Cloud Run sem permissão para Secret Manager (infra)

**Problema:** O service account não conseguia ler os secrets.

**Fix:**
```bash
gcloud secrets add-iam-policy-binding db-password \
  --member="serviceAccount:469696711631-compute@developer.gserviceaccount.com" \
  --role="roles/secretmanager.secretAccessor"
```

---

### 6. Org policy bloqueando allUsers (infra)

**Problema:** A organização do Google Workspace bloqueia binding de `allUsers` no IAM, impedindo o `--allow-unauthenticated` via CLI.

**Fix:** Liberado manualmente via Console GCP → Cloud Run → gestou → Segurança → Permitir acesso público.

## Decisões de arquitetura

### Região: us-central1 (não southamerica-east1)

**Motivo:** Domain mapping direto no Cloud Run não é suportado em `southamerica-east1`. A alternativa (Load Balancer) custaria +$18-25/mês. Como o Gestou tem baixo volume de acessos, a latência adicional (~100-150ms) é aceitável.

### Conexão DB: Unix socket (não IP público)

**Motivo:** Conexão via IP público requer whitelist ou SSL client cert. O Cloud SQL connector (via `--add-cloudsql-instances`) cria um socket Unix automático e seguro, sem configuração extra.

**DB_HOST no Cloud Run:** `/cloudsql/gestou-489010:us-central1:gestou-db`

### DNS: Cloudflare CNAME (proxy OFF)

**Configuração:**
| Tipo | Nome | Destino | Proxy |
|------|------|---------|-------|
| CNAME | gestou | ghs.googlehosted.com | OFF |

**Importante:** O proxy do Cloudflare (nuvem laranja) DEVE estar desativado. Se ativado, o Google não consegue provisionar o certificado SSL.

### Sessões: PostgreSQL (não filesystem)

**Motivo:** Cloud Run é stateless — containers são efêmeros. Sessões em filesystem se perdem quando o container escala ou reinicia. A classe `PgSessionHandler` em `config/session.php` armazena sessões na tabela `php_sessions` do PostgreSQL.

### OCR: Google Vision API (não Azure)

**Motivo:** Migração para GCP elimina dependência do Azure. A função `convertGoogleToAzureFormat()` em `config/ocr.php` converte o formato de resposta do Google Vision para o formato Azure, mantendo compatibilidade com os 83 templates de layout em `admin/layout/`.

## Estrutura de arquivos criados

```
config/
  database.php          — Conexão PostgreSQL (pg_connect + PDO)
  mail.php              — Configuração SMTP via env vars
  app.php               — APP_URL e CONTACT_EMAIL
  session.php           — PgSessionHandler (sessões no PostgreSQL)
  storage.php           — Abstração local/GCS para uploads
  ocr.php               — Google Vision API com conversão para formato Azure
  schema/sessions.sql   — DDL da tabela php_sessions

docs/
  gcp-setup.md          — Guia completo de provisionamento GCP
  test-checklist.md     — Checklist com 420+ itens de teste

scripts/
  migrate-database.sh   — Migração do banco via Cloud SQL Proxy
  migrate-uploads.sh    — Sincronização de uploads para GCS
  validate-migration.sh — Validação pós-migração
  healthcheck.php       — Endpoint de health check (HTTP 200/500)

Dockerfile              — PHP 7.4 + Apache, porta 8080
docker-compose.yml      — Ambiente local (web + db)
.dockerignore           — Exclusões do build Docker
```

## Cronologia

| Data | Evento |
|------|--------|
| 01/03 | Ralph Loop: 12 stories executadas (11 iterações, 0 erros) |
| 01/03 | Docker local: build, restore do banco, fix .htaccess |
| 01/03 | Fix session persistence (19 arquivos) |
| 02/03 | Validação local: login Admin/App/Master OK |
| 02/03 | Fix logout (3 arquivos sair.php) |
| 02/03 | Infra GCP southamerica-east1 criada |
| 02/03 | Migração: dump restaurado no Cloud SQL, imagem publicada |
| 02/03 | Deploy Cloud Run + domain mapping falhou (southamerica-east1) |
| 03/03 | Decisão: migrar para us-central1 |
| 03/03 | Infra GCP us-central1 recriada completa |
| 03/03 | Domain mapping OK, SSL provisionado |
| 04/03 | SMTP configurado (Google Workspace app password) |
| 04/03 | gestou.leveinovacao.com.br no ar, healthcheck OK |
| 04/03 | Uploads sincronizados (8.5GB, 43k arquivos) |
| 04/03 | Validação: 307 tabelas, dados íntegros |
