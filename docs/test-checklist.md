# Checklist de Testes — Gestou GCP Migration

Checklist completo de testes por módulo para validar a migração do Gestou para GCP.
Cada item deve ser testado manualmente no ambiente de staging antes do go-live.

**Legenda:** ⬜ Não testado | ✅ Passou | ❌ Falhou

---

## 1. Site Público (raiz/)

### 1.1 Páginas Estáticas
- [ ] Homepage (`index.php`) carrega sem erros PHP
- [ ] FAQ (`faq.php`) exibe perguntas e respostas
- [ ] Política de Privacidade (`politica_privacidade.php`) acessível
- [ ] Nenhum link aponta para `gestou.com.br` (todos usam caminhos relativos ou `$app_url`)

### 1.2 Formulários de Contato
- [ ] Formulário "Fale Conosco" (`contato.php`) envia email
- [ ] Email de contato chega com dados do visitante (nome, email, mensagem)
- [ ] Formulário "Agende uma Demonstração" (`agende_demonstracao.php`) envia email
- [ ] Email de demo chega com dados do interessado
- [ ] Remetente dos emails é `$contact_email` (via `config/app.php`)

### 1.3 Validação e Downloads
- [ ] `validar_login.php` redireciona para o login correto (admin/app/master)
- [ ] `validar_restrito.php` redireciona usuário não autenticado para login
- [ ] `validar_sair.php` faz logout e redireciona
- [ ] `validar_download.php` valida permissão antes de servir arquivo
- [ ] `validar_download_arquivo.php` serve arquivo corretamente (Content-Type, Content-Disposition)
- [ ] `validar_impressao.php` redireciona para visualização de impressão
- [ ] `validar_gera_qrcode_holerite.php` gera QR code com URL `$app_url` (não hardcoded)
- [ ] `download.php` serve arquivos públicos

---

## 2. Admin (Painel RH)

### 2.1 Autenticação e Sessão
- [ ] Login com email válido + senha correta → redirect para `/admin/index.php`
- [ ] Login com email inexistente → mensagem de erro
- [ ] Login com senha incorreta → mensagem de erro
- [ ] Acesso a página restrita sem sessão → redirect para `/admin/login.php`
- [ ] Sessão persiste entre page refreshes (PostgreSQL session handler)
- [ ] Sessão expira após período de inatividade (GC funciona)
- [ ] Logout (`/admin/sair.php`) destrói sessão e redireciona para login
- [ ] Reset de senha: email enviado com link válido (`esqueci_email.php`)
- [ ] Reset de senha: nova senha funciona após confirmação (`esqueci_email_senha_alterada.php`)

### 2.2 Dashboard e Navegação
- [ ] Dashboard (`index.php`) carrega com dados da empresa logada
- [ ] Menu lateral (`menu_lateral.php`) exibe opções corretas
- [ ] Barra superior (`barra_superior.php`) mostra nome do usuário
- [ ] Navegação entre seções funciona sem erros

### 2.3 CRUD de Colaboradores
- [ ] Listagem de colaboradores (`colaboradores.php`) exibe dados paginados
- [ ] Filtros por departamento, situação e busca funcionam
- [ ] Cadastrar novo colaborador (`cadastrar_colaborador.php`) — todos os campos obrigatórios
- [ ] Validação de CPF duplicado ao cadastrar
- [ ] Editar colaborador (`alterar_colaborador.php`) — salva alterações corretamente
- [ ] Visualizar colaborador (`visualizar_colaborador.php`) — exibe todos os dados
- [ ] Excluir colaborador (soft delete) — não aparece mais na listagem ativa
- [ ] Ativar/desativar colaborador via controller

### 2.4 Upload de Fotos e Documentos
- [ ] Upload de foto do colaborador via croppie editor (`croppie_colaborador.php`)
- [ ] Foto salva em `upload/colaboradores/{CNPJ}/` (ou GCS se STORAGE_DRIVER=gcs)
- [ ] Upload de documento de cadastro (PDF)
- [ ] Documento salvo em `upload/cadastro/{CNPJ}/`
- [ ] Upload de comprovante de benefício (PDF, imagem)
- [ ] Benefício salvo em `upload/beneficios/{RAIZ_CNPJ}/{CPF}/`
- [ ] Exclusão de arquivo remove do storage corretamente
- [ ] Erro de upload (arquivo muito grande, tipo inválido) retorna mensagem clara

### 2.5 OCR — Holerite
- [ ] Upload de PDF holerite em `vision_computer.php`
- [ ] PDF é enviado para Google Vision API (config/ocr.php)
- [ ] Resposta OCR convertida para formato Azure (analyzeResult.readResults)
- [ ] Template correto selecionado em `admin/layout/holerite/`
- [ ] Linhas do holerite exibidas corretamente (nome, salário, descontos)
- [ ] Palavras individuais acessíveis nos templates (words[].text)
- [ ] PDF de múltiplas páginas processado corretamente (batching de 5 páginas)

### 2.6 OCR — IRRF
- [ ] Upload de PDF IRRF em `controller/vision_computer_irrf_post.php`
- [ ] OCR processa e retorna resultado
- [ ] Template correto selecionado em `admin/layout/irrf/`
- [ ] Dados do IRRF exibidos corretamente (rendimentos, imposto retido)

### 2.7 OCR — Ponto
- [ ] Upload de espelho de ponto
- [ ] Template correto selecionado em `admin/layout/ponto/`
- [ ] Horários de entrada/saída exibidos corretamente

### 2.8 OCR — Validações Gerais
- [ ] Nenhuma credencial Azure no código (grep `Ocp-Apim-Subscription-Key` = zero)
- [ ] Nenhuma URL Azure no código (grep `cognitiveservices.azure.com` = zero)
- [ ] Nenhum `sleep(10)` nos arquivos de OCR
- [ ] `GOOGLE_VISION_API_KEY` lido de variável de ambiente
- [ ] Erro de API (key inválida, timeout) tratado com mensagem clara
- [ ] Nenhum template em `admin/layout/` foi alterado pela migração

### 2.9 Emails (12 arquivos)
- [ ] Email de ajuda (`email_ajuda.php`) enviado corretamente
- [ ] Email de aprovação de foto (`email_aprovacao_foto.php`) contém link com `$app_url`
- [ ] Email de aviso de importação (`email_aviso_importacao.php`) lista colaboradores
- [ ] Email de benefícios (`email_beneficios.php`) contém descrição
- [ ] Email de colaborador aprovado (`email_colaborador_aprovado.php`) confirma criação
- [ ] Email de mural de avisos (`email_mural_avisos.php`) com conteúdo formatado
- [ ] Email de notificações (`email_notificacoes.php`) com assunto e corpo
- [ ] Email de ouvidoria (`email_ouvidoria.php`) responde com feedback
- [ ] Email de relatório de recibo (`email_relatorio_recibo_pagamento.php`) com dados do período
- [ ] Email de solicitações (`email_solicitacoes.php`) com status atualizado
- [ ] Todos os emails usam SMTP centralizado (`config/mail.php`)
- [ ] Nenhum SMTP hardcoded (grep `smtp.kinghost.net` = zero)
- [ ] Nenhuma senha SMTP hardcoded (grep `Certificado@256` = zero)

### 2.10 Relatórios
- [ ] Menu de relatórios (`relatorio.php`) lista opções disponíveis
- [ ] Relatório por departamento (`relatorio_departamento.php`) exibe dados agrupados
- [ ] Download PDF relatório departamento (`relatorio_departamento_baixar.php`) gera arquivo válido
- [ ] Relatório por setor (`relatorio_funcionario_setor.php`) com filtros
- [ ] Download PDF relatório setor funciona
- [ ] Relatório por função (`relatorio_funcionario_funcao.php`) com contagem
- [ ] Download PDF relatório função funciona
- [ ] Relatório de recibos (`relatorio_recibo_pagamento.php`) filtra por período
- [ ] Download PDF relatório recibos funciona
- [ ] Relatório com zero resultados exibe mensagem adequada
- [ ] URLs nos relatórios usam `$app_url` (não hardcoded)

### 2.11 Configurações
- [ ] Editar dados do usuário admin (`alterar_usuario.php`) — nome, email
- [ ] Editar departamento (`alterar_departamento.php`) — nome, descrição
- [ ] Editar contatos úteis (`alterar_contatos_uteis.php`) — telefone, email

---

## 3. App (Portal do Colaborador)

### 3.1 Autenticação — Login por CPF
- [ ] Login com CPF válido + senha correta → acesso concedido
- [ ] Login com CPF inexistente → mensagem de erro
- [ ] Login com CPF válido + senha incorreta → mensagem de erro

### 3.2 Autenticação — Login por Email
- [ ] Login com email válido + senha correta → acesso concedido
- [ ] Login com email inexistente → mensagem de erro
- [ ] Login com email válido + senha incorreta → mensagem de erro

### 3.3 Autenticação — Login por Telefone
- [ ] Login com telefone válido + senha correta → acesso concedido
- [ ] Login com telefone inexistente → mensagem de erro
- [ ] Login com telefone válido + senha incorreta → mensagem de erro

### 3.4 Autenticação — Geral
- [ ] Acesso a página restrita sem sessão → redirect para `/app/login.php`
- [ ] Sessão persiste entre page refreshes (PostgreSQL session handler)
- [ ] Logout (`/app/sair.php`) destrói sessão e redireciona

### 3.5 Reset de Senha
- [ ] "Esqueci minha senha" (`esqueci_senha.php`) exibe formulário
- [ ] Email de reset enviado com código/link válido
- [ ] Validação de código (`esqueci_valida_codigo.php`) aceita código correto
- [ ] Troca de senha (`esqueci_troca_senha.php`) salva nova senha
- [ ] Nova senha funciona no login imediatamente
- [ ] Email de confirmação de troca de senha enviado (`esqueci_email_senha_alterada.php`)

### 3.6 Dados Pessoais
- [ ] "Meus Dados" (`meus_dados.php`) exibe informações atualizadas
- [ ] Editar dados (`alterar_dados.php`) — telefone, email
- [ ] Alterações salvas corretamente no banco
- [ ] Upload/alteração de foto de perfil funciona

### 3.7 Holerites e Recibos
- [ ] Listagem de holerites (`holerite.php`) exibe meses disponíveis
- [ ] Detalhe do holerite (`holerite_item.php`) mostra linhas de vencimentos e descontos
- [ ] QR code do holerite (`gera_qrcode_holerite.php`) contém URL com `$app_url`
- [ ] Impressão do holerite (`recibo_impressao.php`) com layout formatado
- [ ] Recibos diversos (`recibo_diverso.php`) listados corretamente

### 3.8 Espelho de Ponto
- [ ] Listagem de espelhos (`espelho_ponto.php`) exibe meses
- [ ] Detalhe do espelho (`espelho_item.php`) mostra entrada/saída por dia
- [ ] Impressão do espelho (`espelho_impressao.php`) com layout correto
- [ ] Download do espelho (`espelho_impressao_baixar.php`) gera PDF

### 3.9 Imposto de Renda
- [ ] Listagem de IR (`imposto_renda.php`) exibe anos disponíveis
- [ ] Detalhe do IR (`imposto_item.php`) mostra rendimentos e retenções
- [ ] Impressão do IR (`imposto_impressao.php`) com layout correto
- [ ] Informe de rendimento (`informe_rendimento.php`) gerado corretamente

### 3.10 Benefícios
- [ ] Listagem de benefícios disponíveis (`beneficios.php`)
- [ ] Aceitar benefício (`aceite_beneficios.php`) atualiza status
- [ ] Recusar benefício registra rejeição
- [ ] Email de benefício enviado ao aceitar

### 3.11 Comunicação com RH
- [ ] "Fale com o RH" (`fale_rh.php`) permite enviar dúvida
- [ ] Dúvida enviada gera protocolo
- [ ] Histórico de atendimento (`atendimento.php`) lista interações
- [ ] Ouvidoria (`ouvidoria.php`) permite enviar feedback
- [ ] Incluir ouvidoria (`ouvidoria_incluir.php`) registra no banco
- [ ] Email de ouvidoria enviado (`email_ouvidoria.php`)

### 3.12 Informações da Empresa
- [ ] Dados da empresa (`empresa.php`) exibem CNPJ, razão social
- [ ] "Sobre a empresa" (`empresa_sobre.php`) com descrição
- [ ] Missão, Visão e Valores (`empresa_mis_vis_val.php`) acessíveis
- [ ] Organograma (`empresa_organograma.php`) renderiza
- [ ] Contatos da equipe (`contatos_equipe.php`) listam nome, email, ramal

### 3.13 Documentos
- [ ] Documentos compartilhados (`documentos.php`) listados
- [ ] Documentos diversos (`documentos_diversos.php`) acessíveis
- [ ] Download de documento funciona

### 3.14 QR Code
- [ ] QR code de sessão (`gera_qrcode.php`) gerado com `$app_url`
- [ ] QR code de holerite contém link válido para validação

---

## 4. Master (Super-Admin)

### 4.1 Autenticação
- [ ] Login com email super-admin + senha → acesso concedido
- [ ] Login com credenciais inválidas → mensagem de erro
- [ ] Acesso restrito a super-admins (usuários comuns não entram)
- [ ] Sessão persiste (PostgreSQL session handler)
- [ ] Logout (`/master/sair.php`) destrói sessão e redireciona

### 4.2 Gestão de Empresas
- [ ] Listagem de empresas (`tabela_empresas.php`) exibe todas cadastradas
- [ ] Cadastrar nova empresa (`cadastro_empresa.php`) — CNPJ, razão social, endereço
- [ ] Validação de CNPJ único ao cadastrar
- [ ] Editar empresa (`alterar_empresa.php`) — salva alterações
- [ ] Upload de logo da empresa (`croppie_empresa.php`)
- [ ] Logo salva em `upload/empresa/` (ou GCS)

### 4.3 Gestão de Usuários Admin
- [ ] Listagem de usuários (`tabela_usuarios.php`) por empresa
- [ ] Cadastrar novo usuário admin (`cadastro_usuario.php`) — email, senha, empresa
- [ ] Validação de email único
- [ ] Editar usuário (`alterar_usuario.php`) — nome, empresa, permissões
- [ ] Adicionar acesso (`adicionar_usuario.php`) — vincular a outra empresa
- [ ] Email com token enviado para novo usuário (`email_token.php`)

### 4.4 Gestão de Super-Admins
- [ ] Listagem de super-admins (`usuarios_master.php`)
- [ ] Cadastrar novo super-admin (`cadastro_usuario_master.php`)
- [ ] Editar super-admin (`alterar_usuario_master.php`)
- [ ] Permissões de super-admin (`usuarios_master_permissao.php`)

### 4.5 Permissões
- [ ] Tabela de permissões (`tabela_permissao.php`) exibe módulos acessíveis
- [ ] Adicionar permissão (`adicionar_permissao.php`) vincula usuário a módulo
- [ ] Remover permissão revoga acesso ao módulo
- [ ] Permissões persistem após logout/login

### 4.6 Menus e Documentação
- [ ] Listagem de menus (`tabela_menus.php`) do sistema
- [ ] Cadastrar novo menu (`cadastro_menu.php`) — título, URL, ícone
- [ ] Cadastrar documentação (`cadastro_documentacao.php`)
- [ ] Editar documentação (`alterar_doc.php`)

### 4.7 Aprovação e Chamados
- [ ] Aprovação de empresa (`aprovacao.php`) — upload de documento, validação
- [ ] Email de aprovação enviado com token (`email_token.php`)
- [ ] Sistema de chamados (`chamado.php`) — listar, visualizar
- [ ] Responder chamado (`email_resposta_chamado.php`) — email enviado ao solicitante

### 4.8 Serviços em Background
- [ ] Job de email de aniversário (`services/email_aniversario.php`) — envia para aniversariantes do dia
- [ ] Email de aniversário contém mensagem personalizada com nome e empresa
- [ ] Serviço de envio (`services/envio_email_aniversario.php`) processa fila

---

## 5. CreateEmployee (Cadastro via Token)

- [ ] URL com token válido redireciona para formulário (`index.php`)
- [ ] URL com token inválido ou expirado → mensagem de erro
- [ ] Formulário exibe campos obrigatórios (nome, CPF, email, etc.)
- [ ] Validação de CPF único ao submeter
- [ ] Validação de email único ao submeter
- [ ] Submissão (`controller/createemployee_post.php`) cria colaborador no banco
- [ ] Colaborador criado aparece na listagem do admin
- [ ] Email de boas-vindas enviado ao novo colaborador

---

## 6. CreateAccount (Auto-Registro)

- [ ] Formulário de auto-registro (`index.php`) acessível
- [ ] Campos obrigatórios validados (CNPJ, email, nome)
- [ ] Validação de CNPJ — empresa deve existir no sistema
- [ ] Validação de email único
- [ ] Submissão (`controller/createaccount_post.php`) cria conta
- [ ] Email de confirmação enviado
- [ ] Novo usuário consegue fazer login após registro
- [ ] Dados salvos corretamente no banco

---

## 7. Testes Transversais (Cross-Module)

### 7.1 Sessões (PostgreSQL)
- [ ] Tabela `php_sessions` criada no banco (via `config/schema/sessions.sql`)
- [ ] Login em qualquer módulo cria registro na tabela `php_sessions`
- [ ] Sessão persiste entre requests (dados em `$_SESSION` mantidos)
- [ ] Logout remove sessão da tabela
- [ ] Sessão expira após inatividade — GC remove registros antigos
- [ ] Múltiplas sessões simultâneas (diferentes navegadores) funcionam independentemente
- [ ] `PgSessionHandler` registrado ANTES de `session_start()` em todos os restrito.php

### 7.2 Uploads e Storage
- [ ] `STORAGE_DRIVER=local`: upload salva no filesystem local
- [ ] `STORAGE_DRIVER=local`: `storageUrl()` retorna path relativo (`/upload/...`)
- [ ] `STORAGE_DRIVER=local`: `storageDelete()` remove arquivo do disco
- [ ] `STORAGE_DRIVER=local`: `storageExists()` verifica existência no disco
- [ ] `STORAGE_DRIVER=gcs`: upload envia para Google Cloud Storage
- [ ] `STORAGE_DRIVER=gcs`: `storageUrl()` retorna URL pública do GCS
- [ ] `STORAGE_DRIVER=gcs`: `storageDelete()` remove do bucket
- [ ] `STORAGE_DRIVER=gcs`: `storageExists()` verifica existência no bucket
- [ ] `GCS_BUCKET` lido de variável de ambiente
- [ ] Diretórios de upload criados automaticamente (mkdir recursivo)

### 7.3 Emails (SMTP)
- [ ] Todos os 24 arquivos de email usam `configureMailer($mail)` centralizado
- [ ] `SMTP_HOST` lido de getenv (default: `smtp-relay.gmail.com`)
- [ ] `SMTP_PORT` lido de getenv (default: `587`)
- [ ] `SMTP_USER` e `SMTP_PASS` lidos de getenv
- [ ] `SMTP_FROM` lido de getenv (default: `contato@leveinovacao.com.br`)
- [ ] `SMTP_FROM_NAME` lido de getenv (default: `GESTOU`)
- [ ] Nenhuma credencial SMTP hardcoded no código (excluindo vendor/)
- [ ] Links em emails usam `$app_url` concatenado com path
- [ ] Email com HTML renderiza corretamente (tabelas, estilos inline)
- [ ] Falha de envio SMTP logada (não erro silencioso)

### 7.4 Conexão ao Banco de Dados
- [ ] `$pdo` (PDO) conecta e executa queries
- [ ] `$conn` (pg_connect) conecta e executa queries
- [ ] Variáveis `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` lidas de getenv
- [ ] Fallback para valores padrão de desenvolvimento funciona
- [ ] Prepared statements previnem SQL injection
- [ ] Erro de conexão tratado com mensagem genérica (sem expor credenciais)

### 7.5 URLs e Redirects
- [ ] Nenhuma referência hardcoded a `gestou.com.br` no código PHP (excluindo vendor/)
- [ ] Redirects usam caminhos relativos (`/admin/login`, `/app/login`, `/master/login`)
- [ ] Links em emails e QR codes usam `$app_url` de `config/app.php`
- [ ] `APP_URL` lido de getenv (default: `https://gestou.leveinovacao.com.br`)
- [ ] `$app_url` funciona com e sem trailing slash

### 7.6 OCR (Google Cloud Vision)
- [ ] `GOOGLE_VISION_API_KEY` lido de variável de ambiente
- [ ] Nenhuma credencial Azure no código (excluindo vendor/)
- [ ] Formato de resposta compatível com 83 templates em `admin/layout/`
- [ ] Estrutura: `analyzeResult.readResults[n].page`, `.lines[m].text`, `.words[w].text`
- [ ] Batching automático para PDFs com mais de 5 páginas
- [ ] Erro de API tratado sem expor chave

### 7.7 Configuração Centralizada
- [ ] `config/database.php` — conexão ao banco (PDO + pg_connect)
- [ ] `config/mail.php` — configuração SMTP (configureMailer)
- [ ] `config/app.php` — URL base e email de contato
- [ ] `config/session.php` — handler de sessão PostgreSQL
- [ ] `config/storage.php` — abstração de storage (local/GCS)
- [ ] `config/ocr.php` — wrapper Google Cloud Vision
- [ ] Todos os configs leem variáveis de ambiente com fallbacks sensatos

---

## 8. Docker e Deploy

### 8.1 Docker Build
- [ ] `docker build .` completa sem erros
- [ ] Imagem baseada em `php:7.4-apache`
- [ ] Extensões PHP instaladas: pgsql, pdo_pgsql, gd, curl, zip, intl, mbstring
- [ ] Apache com `mod_rewrite` habilitado e `AllowOverride All`
- [ ] Porta 8080 configurada (requisito Cloud Run)
- [ ] Código copiado para `/var/www/html/`
- [ ] Vendors copiados corretamente
- [ ] Diretórios de upload criados com permissões `www-data`

### 8.2 Docker Compose (Dev Local)
- [ ] `docker-compose up` inicia serviços web + db
- [ ] PostgreSQL 17 inicia e aceita conexões
- [ ] Tabela `php_sessions` criada automaticamente (via init script)
- [ ] Aplicação web conecta ao banco via `DB_HOST=db`
- [ ] Variáveis de ambiente carregadas no PHP
- [ ] Volume de dados PostgreSQL persiste entre restarts
- [ ] Código montado como volume (hot reload em dev)

### 8.3 Healthcheck
- [ ] `scripts/healthcheck.php` retorna HTTP 200 quando banco está acessível
- [ ] `scripts/healthcheck.php` retorna HTTP 500 quando banco está inacessível
- [ ] Resposta JSON contém: status, timestamp, php_version

### 8.4 Scripts de Migração
- [ ] `scripts/migrate-database.sh` — pg_dump + pg_restore funciona
- [ ] `scripts/migrate-uploads.sh` — gsutil rsync sincroniza uploads para GCS
- [ ] `scripts/validate-migration.sh` — validação pós-migração passa
- [ ] Todos os scripts são executáveis (`chmod +x`)

---

## 9. Segurança

- [ ] Nenhuma senha ou chave de API hardcoded no código (excluindo vendor/)
- [ ] `config/database.php` no `.gitignore` (não vai para o repositório)
- [ ] Credenciais antigas removidas: `smtp.kinghost.net`, `suporte@gestou.com.br`, `Certificado@256`
- [ ] Chave Azure Vision removida do código
- [ ] Todas as credenciais vêm de variáveis de ambiente ou Secret Manager
- [ ] Sessões armazenadas no banco (não no filesystem)
- [ ] Prepared statements usados para queries com input do usuário

---

## Notas de Execução

1. **Ambiente de teste:** Executar todos os testes em ambiente de staging com Docker Compose antes do deploy em Cloud Run
2. **Dados de teste:** Usar dump do banco de produção sanitizado (sem dados pessoais reais)
3. **Ordem de execução:** Testar na ordem: Site → Admin → App → Master → CreateEmployee → CreateAccount → Transversais → Docker
4. **Regressão:** Após corrigir qualquer falha, re-executar toda a seção afetada
5. **OCR:** Testar com PDFs reais de holerite, IRRF e ponto — os templates são sensíveis ao formato
6. **Emails:** Usar Mailtrap ou similar para capturar emails em staging
