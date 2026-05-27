# FEA-009 — Roteiro de Teste do Módulo RPA

**Versão:** 1.0 — 2026-05-26
**Escopo:** validação manual ponta-a-ponta do MVP do módulo RPA (Recibo de Pagamento Autônomo) antes do release.
**Tempo estimado:** ~45 minutos por testador (com fluxo completo).

---

## 0. Pré-requisitos

### Acesso necessário

- [ ] Conta admin no `/admin/` da empresa que vai testar (SE HOTEIS = 107 ou SE SERVICOS = 106)
- [ ] **Promoção a Líder RH** na empresa (necessária para aprovar RPAs):
  - Acessar `/master/alterar_usuario2` (apenas usuários internos da Leve)
  - Buscar pelo seu usuário, marcar como Líder RH na empresa de teste, salvar
  - Sair e logar de novo no `/admin/` para a sessão pegar a nova flag
- [ ] Pelo menos 1 colaborador ativo na empresa (qualquer um, só pra popular o ambiente)
- [ ] Caixa de email pessoal acessível (para testar recebimento do email de aceite — só em prod)

### Saber os limites configurados

- [ ] Acessar `/admin/dados_cadastrais` → aba **RPA**
- Anotar: valor padrão, % imposto, alerta (default 3 diárias), bloqueio (default 4 diárias)

---

## 1. Cadastro de Autônomo

### 1.1 Cadastro manual

- [ ] `/admin/autonomos.php`
- [ ] Clicar **"Novo autônomo"**
- [ ] Preencher: Nome, CPF (válido — ex `111.444.777-35`), e-mail real, PIX, endereço opcional
- [ ] Clicar **Salvar**
- [ ] **Esperado:** SweetAlert "Autônomo cadastrado!" e redireciona pra lista com o novo autônomo

### 1.2 Validação de CPF

- [ ] Tentar cadastrar novo autônomo com CPF `000.000.000-00` (inválido — dígitos repetidos)
- [ ] **Esperado:** botão "Salvar" não submete, mensagem "CPF inválido" no campo

### 1.3 Validação de CPF duplicado

- [ ] Tentar cadastrar novo autônomo com o **mesmo CPF** do passo 1.1
- [ ] **Esperado:** SweetAlert "CPF já cadastrado" (warning amarelo)

### 1.4 Validação de email obrigatório

- [ ] Tentar cadastrar autônomo sem email
- [ ] **Esperado:** botão não submete, campo email destacado com erro

### 1.5 Edição com alerta de RPAs anteriores

(Faça depois do passo 5)

- [ ] Lista de autônomos → clicar **lápis (Editar)** no autônomo que já tem RPA aprovado
- [ ] **Esperado:** alerta amarelo no topo "Este autônomo tem N RPA(s) anterior(es). Alterações não afetam documentos já emitidos/assinados."
- [ ] Mudar o email e clicar Salvar
- [ ] **Esperado:** modal de confirmação "Confirma alteração?" mostrando o campo alterado e a quantidade de RPAs anteriores

### 1.6 Toggle ativo/inativo

- [ ] Na lista, clicar no **toggle verde/vermelho** ao lado de um autônomo
- [ ] **Esperado:** SweetAlert de confirmação, e após confirmar o autônomo some da lista de Ativos (mas continua em Inativos / Todos)

---

## 2. Export e Import CSV

### 2.1 Export CSV

- [ ] Lista de autônomos → clicar **"Exportar (CSV)"**
- [ ] **Esperado:** download de `autonomos_{empresa}_{YYYY-MM-DD}.csv`
- [ ] Abrir em Excel/Calc e verificar que tem cabeçalho `nome;cpf;rg;data_nasc;etnia;endereco;cep;bairro;cidade;uf;email;pix;ativo` + 1 linha por autônomo

### 2.2 Import CSV — caso feliz

- [ ] Criar um CSV de teste com 3 autônomos novos (CPFs diferentes dos já cadastrados):

```csv
nome;cpf;rg;data_nasc;etnia;endereco;cep;bairro;cidade;uf;email;pix;ativo
MARIA SILVA;111.111.111-11;;;;;;;;;maria@teste.com;maria@teste.com;1
JOAO SANTOS;222.222.222-22;;;;;;;;;joao@teste.com;joao@teste.com;1
PEDRO COSTA;333.333.333-33;;;;;;;;;pedro@teste.com;pedro@teste.com;1
```

> **Atenção:** use CPFs **válidos** (calcule via gerador ou use CPFs reais de teste). Os exemplos acima são inválidos e vão aparecer como erro — ótimo pra testar 2.3.

- [ ] Lista → **"Importar (CSV)"** → upload do arquivo → **Analisar arquivo**
- [ ] **Esperado:** preview mostrando 3 linhas com status (verde/vermelho/amarelo)
- [ ] Se tudo válido, clicar **"Confirmar importação"**
- [ ] **Esperado:** SweetAlert "Importação concluída! N autônomos importados." e redireciona pra lista

### 2.3 Import CSV — validações

- [ ] Upload de CSV com erros (CPF inválido, email mal formatado, PIX vazio, CPF duplicado)
- [ ] **Esperado no preview:**
  - Linhas válidas em **verde**
  - CPF duplicado em **amarelo** (será pulado)
  - Linhas com erro em **vermelho** com o motivo
- [ ] Botão "Confirmar importação" mostra contador apenas das linhas válidas
- [ ] Se houver apenas duplicados e inválidos (0 válidos), botão fica desabilitado

### 2.4 Import CSV — cabeçalho errado

- [ ] Upload de CSV sem o cabeçalho correto (ex: faltando coluna `pix`)
- [ ] **Esperado:** SweetAlert "Cabeçalho inválido. Falta: pix"

---

## 3. Cadastro de RPA + Cálculo + PDFs

### 3.1 Form com cálculo automático

- [ ] `/admin/rpas.php` → **"Novo RPA"**
- [ ] Selecionar autônomo (autocomplete)
- [ ] Preencher cargo, setor, data
- [ ] Mudar **Valor LÍQUIDO** pra `200`
- [ ] **Esperado em tempo real (sem submit):**
  - INSS retido: **R$ 24,72**
  - Valor BRUTO: **R$ 224,72**

### 3.2 Aviso de diárias do autônomo

- [ ] Selecionar autônomo
- [ ] **Esperado:** abaixo do select aparece "Autônomo tem N diárias no mês atual."

### 3.3 Alerta CLT (3 diárias)

- [ ] Cadastrar 3 RPAs para o mesmo autônomo no mesmo mês (1 diária cada — ou ajustar o campo Diárias)
- [ ] No 3º RPA, ao selecionar o autônomo, ver aviso **amarelo** "Atenção: autônomo terá 3 diárias no mês"
- [ ] Tentar salvar
- [ ] **Esperado:** SweetAlert "Próximo do limite CLT — Deseja prosseguir mesmo assim?" com Sim/Cancelar
- [ ] Clicar **Sim** → RPA salvo

### 3.4 Bloqueio CLT (4 diárias)

- [ ] Tentar cadastrar 4º RPA para o mesmo autônomo no mesmo mês
- [ ] Ao selecionar autônomo, aviso **vermelho** "Bloqueado: autônomo já tem 3 diárias no mês"
- [ ] Tentar salvar mesmo assim
- [ ] **Esperado:** SweetAlert "Limite CLT atingido" (vermelho) com botão único de "OK" — RPA NÃO é salvo

### 3.5 Visualização do RPA + PDFs

- [ ] Após cadastrar com sucesso → tela `rpa_alterar.php?al=X`
- [ ] **Esperado:**
  - Status badge cinza "Rascunho"
  - Dados do autônomo (nome, CPF, email, PIX)
  - Dados do serviço (cargo, setor, data, diárias)
  - Tabela de valores (bruto, INSS, líquido)
  - Trilha: "Criado: DD/MM/AAAA HH:MM"
  - 3 botões de PDF: **Autorização de Pagamento**, **Contrato (Art. 442-B)**, **Recibo de Pagamento**
- [ ] Clicar em cada PDF → abre em nova aba
- [ ] **Esperado:**
  - Autorização: empresa, prestador, valores discriminados, autorização do financeiro
  - Contrato: 6 cláusulas (objeto, execução, remuneração, sem vínculo, encargos, foro), assinaturas no rodapé
  - Recibo: tabela de valores destacada, declaração de quitação

### 3.6 Cancelar RPA em rascunho

- [ ] Na tela do RPA → clicar **"Cancelar RPA"** (vermelho)
- [ ] **Esperado:** modal pedindo motivo (mínimo 5 chars), e após confirmar status vira "Cancelado" com motivo na trilha

---

## 4. Aprovação por Líder RH

### 4.1 Pré-requisito

- [ ] Usuário logado é Líder RH (passo 0)
- [ ] Há ao menos 1 RPA em status "Rascunho"

### 4.2 Aprovar

- [ ] Abrir o RPA em rascunho → na tela há botões **verde "Aprovar"** + **amarelo "Recusar"**
- [ ] Clicar **Aprovar**
- [ ] SweetAlert "Aprovar este RPA?" → confirmar
- [ ] **Esperado:**
  - Status vira "Autorizado" (badge azul)
  - Trilha agora tem "Autorizado em: DD/MM/AAAA HH:MM (id_usa X)"
  - Botão "Aprovar/Recusar" some, aparece **"Reenviar email de aceite"** (azul info)
  - Email enviado pro autônomo (verificar caixa em prod — em local SMTP não está configurado)

### 4.3 Recusar

- [ ] Em outro RPA em rascunho, clicar **Recusar**
- [ ] **Esperado:** modal pedindo motivo (mínimo 5 chars)
- [ ] Preencher motivo e confirmar
- [ ] **Esperado:** status vira "Cancelado" com prefixo "[Recusado pelo Líder RH] {motivo}"

### 4.4 Visualização sem ser Líder

- [ ] Logar como admin comum (sem ser Líder)
- [ ] Abrir RPA em rascunho
- [ ] **Esperado:** sem botões Aprovar/Recusar. Mensagem azul "Este RPA aguarda aprovação de um Líder RH. Você (admin comum) só pode visualizar."

---

## 5. Aceite Digital pelo Autônomo (Opção B)

### 5.1 Recebimento do email (PROD apenas)

- [ ] Cadastrar autônomo com **seu email pessoal**
- [ ] Cadastrar RPA pra esse autônomo
- [ ] Aprovar como Líder RH
- [ ] **Esperado em prod:** chega email "[GESTOU] Aceite digital do seu RPA — {empresa}" com botão "Acessar e aceitar RPA"
- [ ] **Em local:** email não é enviado; pegar o token via SQL:
  ```bash
  docker exec www-db-1 psql -U gestou -d gestou -c \
    "SELECT id_rpa, token_aceite FROM public.\"GESRPA\" WHERE status='autorizado' AND token_aceite IS NOT NULL ORDER BY id_rpa DESC LIMIT 5;"
  ```
  E abrir manualmente: `http://localhost:8080/app/rpa_aceite.php?token={TOKEN}`

### 5.2 Tela de aceite

- [ ] Abrir o link em aba anônima (simular que é o autônomo, sem login)
- [ ] **Esperado:**
  - Título "Aceite Digital — RPA"
  - Dados do RPA (empresa, autônomo, serviço, data)
  - **Valor líquido em destaque verde grande** (R$ 150,00 por padrão)
  - Bruto + INSS retido em letra menor
  - 3 botões de PDF clicáveis (abrem em nova aba)
  - Campo "Confirme seu CPF"
  - Checkbox de **termo de uso**
  - Botão "Aceitar e assinar digitalmente" **desabilitado** até marcar termo

### 5.3 Termo obrigatório

- [ ] Tentar clicar "Aceitar" sem marcar o termo
- [ ] **Esperado:** botão fica desabilitado (cinza)
- [ ] Marcar termo → botão fica verde

### 5.4 CPF errado

- [ ] Marcar termo, preencher CPF **errado**, clicar Aceitar
- [ ] Confirmar modal de confirmação dupla
- [ ] **Esperado:** SweetAlert vermelho "CPF não confere com o cadastro"

### 5.5 Aceite com sucesso

- [ ] Marcar termo, preencher CPF **correto** (do autônomo)
- [ ] Clicar **"Aceitar e assinar digitalmente"**
- [ ] **Esperado:** modal "Confirma o aceite?" com texto "Você está prestes a assinar digitalmente este RPA. Esta ação é registrada e auditável (IP, navegador, horário) e não pode ser desfeita"
- [ ] Confirmar
- [ ] **Esperado:** tela "Aceite registrado! Obrigado, {nome}!" com data/hora e mensagem "A empresa será notificada para liberar o pagamento"

### 5.6 Trilha pós-aceite (no admin)

- [ ] Voltar ao `/admin/rpa_alterar.php?al={id}` desse RPA
- [ ] **Esperado:**
  - Status agora é "Assinado pelo autônomo" (badge info)
  - Trilha tem **"Assinado em: DD/MM/AAAA HH:MM — IP {ip}"** (ícone de assinatura)
  - Apareceu botão amarelo **"Enviar para financeiro"**

### 5.7 Token reutilizado deve falhar

- [ ] Tentar abrir novamente `http://localhost:8080/app/rpa_aceite.php?token={mesmo TOKEN do passo 5.1}`
- [ ] **Esperado:** "Link inválido, já utilizado ou expirado. Solicite à empresa um novo link de aceite."

### 5.8 Reenviar email de aceite

- [ ] No RPA em status "Autorizado", clicar **"Reenviar email de aceite"** (botão azul)
- [ ] SweetAlert "Reenviar email de aceite?" → confirmar
- [ ] **Esperado:** novo token é gerado (o antigo é invalidado). Em prod o autônomo recebe novo email; em local pegar o novo via SQL e usar o link novo

### 5.9 PDF de evidência

- [ ] Após aceite, na tela do RPA, deve haver **4 botões de PDF** (autorização, contrato, recibo + **evidência**)
- [ ] *Nota: na Fase 5 atual a evidência é gerada mas não aparece no admin (só no upload). Ver pendência abaixo.*
- [ ] Validar via shell:
  ```bash
  docker exec www-web-1 ls -la /var/www/html/upload/rpa/{cnpj_raiz}/{ano-mes}/{id_rpa}_evidencia.pdf
  ```
- [ ] Abrir o PDF e validar que mostra:
  - "EVIDÊNCIA DE ACEITE DIGITAL" em destaque vermelho
  - Declaração formal com data, autônomo, CPF, IP, navegador
  - Texto referenciando Lei 14.063/2020

---

## 6. Status financeiro

### 6.1 Enviar para financeiro

- [ ] RPA com status "Assinado pelo autônomo" → clicar **"Enviar para financeiro"** (amarelo)
- [ ] Confirmar modal
- [ ] **Esperado:** status vira "Enviado para financeiro" + trilha tem "Enviado p/ financeiro: DD/MM/AAAA"
- [ ] Aparece botão verde **"Marcar como pago"**

### 6.2 Marcar como pago

- [ ] Clicar **"Marcar como pago"**
- [ ] Modal pede data do pagamento (default hoje)
- [ ] Confirmar
- [ ] **Esperado:** status vira "Pago" (badge verde), trilha tem "Pago em: DD/MM/AAAA" com ícone $
- [ ] Botões de ação somem (estado final)

### 6.3 RPA pago não pode ser cancelado

- [ ] No RPA em status "Pago", confirmar que botão "Cancelar RPA" não aparece (estado final)

---

## 7. Export Excel mensal

- [ ] Lista de RPAs (`/admin/rpas.php`) — escolher mês/ano
- [ ] Clicar **"Exportar Excel (mês)"**
- [ ] **Esperado:** download de `RPAs_{MES_NOME}_{ANO}.xlsx`
- [ ] Abrir e validar:
  - Cabeçalho azul com 18 colunas: Envio Financeiro, Data Início, Data Fim, Diárias, Valor Líquido, Valor c/ Imposto, Horas, Nome, Cargo, Setor, Data Pgto, Justificativa, Assinado (Sim/Não), Endereço, CPF, RG, Nascimento, Etnia
  - 1 linha por RPA do mês
  - Resumo no rodapé: Total RPAs, Total Bruto, Total Líquido

---

## 8. Dashboard — Cards de RPA

### 8.1 Card "RPAs pendentes de aprovação"

- [ ] Garantir ao menos 1 RPA em status "Rascunho"
- [ ] Ir para `/admin/index` (dashboard)
- [ ] No carousel superior, clicar **Next** (seta direita) até encontrar
- [ ] **Esperado:** card amarelo "RPAS PENDENTES DE APROVAÇÃO: N" com ícone clipboard
- [ ] Clicar no card → leva pra `rpas.php?status=rascunho`

### 8.2 Card "RPAs aguardando pagamento"

- [ ] Garantir ao menos 1 RPA em status "Enviado para financeiro"
- [ ] No carousel, encontrar card azul info "RPAS AGUARDANDO PAGAMENTO: N" com ícone $
- [ ] Clicar → leva pra `rpas.php?status=enviado_fin`

### 8.3 Cards somem quando contagem = 0

- [ ] Concluir todos os RPAs (cancelar ou marcar como pago)
- [ ] Recarregar dashboard
- [ ] **Esperado:** os 2 cards de RPA não aparecem (renderização condicional `> 0`)

---

## 9. Configuração de RPA por empresa

- [ ] `/admin/dados_cadastrais` → aba **RPA**
- [ ] **Esperado:**
  - Valor líquido padrão (editável)
  - INSS % (readonly, fixo 12,36)
  - Alerta CLT (default 3, editável)
  - Bloqueio CLT (default 4, editável)
  - Lista de placeholders disponíveis em código
  - 3 textareas: Autorização, Contrato, Recibo (vazias = usa default do sistema)
- [ ] Mudar Valor padrão pra 200 e Alerta pra 2
- [ ] Clicar **"Salvar configurações RPA"**
- [ ] **Esperado:** SweetAlert "Configurações salvas"
- [ ] Cadastrar novo RPA → form vem com valor 200 e alerta a partir de 2 diárias

### 9.1 Customizar template

- [ ] Aba RPA → preencher textarea **Recibo** com HTML de teste:
  ```html
  <p>TESTE DE TEMPLATE — Recibo customizado para {nome_autonomo}, CPF {cpf}. Valor: R$ {valor_liquido}.</p>
  ```
- [ ] Salvar
- [ ] Cadastrar novo RPA com esse autônomo
- [ ] Baixar o PDF "Recibo de Pagamento"
- [ ] **Esperado:** PDF usa o template customizado (em vez do default)
- [ ] Limpar o textarea e salvar de novo → volta a usar o default

---

## Pendências e bugs conhecidos (a tratar antes do release final)

- [ ] **Sidebar não mostra o item "Folha"** mesmo com permissões corretas. Usuário precisa acessar via URL direta. (Investigar `menu_lateral.php`)
- [ ] **PDF de evidência** é gerado mas a tela `rpa_alterar.php` não tem botão dedicado pra ele — só aparece via shell. Adicionar 4º botão.
- [ ] **Permissão da pasta `upload/rpa`** em ambiente novo: a primeira escrita feita por CLI cria como `root`, e Apache `www-data` não consegue escrever depois. Em prod (gcsfuse) esse problema não acontece — bucket é montado já com permissão correta.
- [ ] **Email não envia em local** (esperado — SMTP só configurado em prod). Testar fluxo de email completo direto em prod com um RPA de teste.

---

## Cleanup pós-teste

```sql
-- Remover RPAs e autônomos criados durante o teste (ajuste os IDs)
DELETE FROM public."GESRPA"  WHERE id_emp=107 AND cargo LIKE 'TESTE%';
DELETE FROM public."GESAUT"  WHERE id_emp=107 AND nome LIKE 'TESTE%';
DELETE FROM public."GESAUT"  WHERE id_emp=107 AND email IN ('maria@teste.com','joao@teste.com','pedro@teste.com');
```

---

## Reporte de resultados

Ao terminar o teste, registrar em [docs/pendencias.md](./pendencias.md) ou abrir issue:
- ❌ Erros encontrados (descrição + screenshot + passos pra reproduzir)
- ⚠️ Comportamentos inesperados (não bloqueiam mas merecem ajuste)
- 💡 Sugestões de melhoria
- ✅ Cenários OK
