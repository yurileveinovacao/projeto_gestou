# FEA-011 — Plano de implementação · Download em lote de documentos (ZIP)

**Data:** 2026-05-22 · **Estimativa:** 1-2 dias · **Dependências:** nenhuma (independente da FEA-009)

---

## Objetivo

Permitir que o RH baixe múltiplos documentos de um colaborador em um único ZIP, direto da aba "Documentos" em `/admin/alterar_colaborador`. Substitui o download um-a-um atual.

**Não-objetivos:**
- Download de múltiplos colaboradores numa só operação
- Download da empresa inteira
- Envio por email / agendamento
- ZIP criptografado
- Download em lote no `/app/` (portal do colaborador) — pode virar FEA-011b se houver demanda

---

## Contexto técnico

### Fontes de documentos (já consolidadas em `select_DOCUMENTOS`)

Função existente em `admin/iuds_pdo.php:11187`. Faz UNION de 6 fontes:

| Tipo (campo `tipo`) | Tabela | Coluna arquivo | Path no bucket |
|---|---|---|---|
| Holerite | `GESIM1_{raiz_cnpj}` | `arquivo` | `upload/beneficios/holerite/{raiz_cnpj}/{arquivo}` |
| IRRF | `GESIRR_{raiz_cnpj}` | `arquivo` | `upload/beneficios/irrf/{raiz_cnpj}/{arquivo}` |
| Ponto | `GESPON1_{raiz_cnpj}` | `arquivo` | `upload/beneficios/ponto/{raiz_cnpj}/{arquivo}` (a confirmar) |
| Diversos | `GESREC_{raiz_cnpj}` | `arquivo` | `upload/beneficios/recibo/{raiz_cnpj}/{arquivo}` (a confirmar) |
| Documento | `GESDCOL` | `arquivo` | `upload/cadastro/{arquivo}` (a confirmar) |
| Atestado | `justificativas` | `arquivo_path` | path completo (já vem resolvido) |

> Storage: bucket `gestou-uploads-489010` montado via gcsfuse em `/var/www/html/upload`. Acesso transparente como filesystem.

### Segurança que já existe (e vamos reusar)

Em `admin/alterar_colaborador.php` linha 971-977, cada linha da tabela já gera um **token** por arquivo guardado em `$_SESSION['alterar_colaborador']['token'][$token]`:

```php
$_SESSION['alterar_colaborador']['token'][$token]['codigo']
$_SESSION['alterar_colaborador']['token'][$token]['arquivo']
$_SESSION['alterar_colaborador']['token'][$token]['descricao']
$_SESSION['alterar_colaborador']['token'][$token]['competencia']
$_SESSION['alterar_colaborador']['token'][$token]['tipo']
```

O endpoint do ZIP **só aceita tokens da sessão atual** — impossibilita IDOR (Insecure Direct Object Reference). Reaproveitamento direto, zero código novo de segurança.

---

## Plano em 6 passos

### 1. Helper de resolução de path (~1h)

Criar em `admin/iuds_pdo.php` (perto de `select_DOCUMENTOS`):

```php
function resolveDocumentoPath($tipo, $arquivo, $raiz_cnpj)
{
    // Retorna absolute path no FS (gcsfuse) ou null se tipo desconhecido.
    $base = __DIR__ . '/../upload';
    switch ($tipo) {
        case 'Holerite': return $base . '/beneficios/holerite/' . $raiz_cnpj . '/' . $arquivo;
        case 'IRRF':     return $base . '/beneficios/irrf/' . $raiz_cnpj . '/' . $arquivo;
        case 'Ponto':    return $base . '/beneficios/ponto/' . $raiz_cnpj . '/' . $arquivo;
        case 'Diversos': return $base . '/beneficios/recibo/' . $raiz_cnpj . '/' . $arquivo;
        case 'Documento':return $base . '/cadastro/' . $arquivo;
        case 'Atestado': // arquivo_path já é caminho completo relativo a /var/www/html
            return __DIR__ . '/../' . ltrim($arquivo, '/');
        default: return null;
    }
}
```

**Validar paths reais antes de codar:** rodar `grep -rn "upload/" admin/documentos_colaborador.php app/espelho_ponto.php app/recibo_diverso.php app/documentos_diversos_item.php` pra confirmar as 4 convenções "a confirmar" da tabela acima.

### 2. UI da aba Documentos (~2h)

Em `admin/alterar_colaborador.php` (linhas 932-1011):

- Adicionar coluna `<th>` no thead **antes** de "Descrição": checkbox "selecionar todos"
- Adicionar `<td>` em cada linha do `<tbody class="recibos">`: `<input type="checkbox" class="doc-check" value="<?php echo $token; ?>">`
- Adicionar botão ao lado do "Incluir" (linha 935):
  ```html
  <button type="button" id="baixar_zip" class="btn btn-outline-primary mr-2" disabled>
      <i class="fas fa-file-archive mr-sm-2"></i>
      Baixar selecionados (<span id="zip-count">0</span>)
  </button>
  ```
- JS no final do arquivo:
  - Checkbox "selecionar todos" marca/desmarca todos os `.doc-check`
  - Cada mudança recalcula contador e habilita/desabilita botão
  - Click no botão: monta `<form>` POST oculto com `tokens[]` e submete pra `controller/documentos_zip_post.php` (não AJAX — é download binário)

### 3. Endpoint do ZIP (~3h)

Criar `admin/controller/documentos_zip_post.php`:

```php
<?php
require __DIR__.'/../../config/database.php';
require __DIR__.'/../../config/session.php';
require __DIR__.'/../iuds_pdo.php';

set_time_limit(180);
ini_set('memory_limit', '512M');

// Auth — replica padrão das outras telas do /admin/
if (empty($_SESSION['id_usa_default']) || empty($_SESSION['id_emp_default'])) {
    http_response_code(401); exit;
}

$id_emp = (int) $_SESSION['id_emp_default'];
$id_usa = (int) $_SESSION['id_usa_default'];
$tokens = $_POST['tokens'] ?? [];

if (!is_array($tokens) || count($tokens) === 0) {
    http_response_code(400);
    echo json_encode(['erro' => 'Nenhum documento selecionado.']);
    exit;
}

// Limites
const MAX_ARQUIVOS = 200;
const MAX_BYTES = 500 * 1024 * 1024;

if (count($tokens) > MAX_ARQUIVOS) {
    http_response_code(413);
    echo json_encode(['erro' => 'Limite excedido', 'max_arquivos' => MAX_ARQUIVOS, 'atual' => count($tokens)]);
    exit;
}

// Resolver paths via tokens da sessão
$raiz_cnpj = $_SESSION['raiz_cnpj_default'] ?? null; // confirmar nome real da sessão
$arquivos = [];
$total_bytes = 0;

foreach ($tokens as $token) {
    if (empty($_SESSION['alterar_colaborador']['token'][$token])) {
        http_response_code(400);
        echo json_encode(['erro' => 'Token inválido.']);
        exit;
    }
    $meta = $_SESSION['alterar_colaborador']['token'][$token];
    $path = resolveDocumentoPath($meta['tipo'], $meta['arquivo'], $raiz_cnpj);
    if (!$path || !file_exists($path)) continue; // ignora ausente
    $size = filesize($path);
    $total_bytes += $size;
    if ($total_bytes > MAX_BYTES) {
        http_response_code(413);
        echo json_encode(['erro' => 'Tamanho total excedido (>500MB)', 'atual_mb' => round($total_bytes/1024/1024, 1)]);
        exit;
    }
    $arquivos[] = ['path' => $path, 'meta' => $meta];
}

if (count($arquivos) === 0) {
    http_response_code(404);
    echo json_encode(['erro' => 'Nenhum arquivo encontrado.']);
    exit;
}

// Nome do colaborador pro filename do ZIP
$nome_colab = selectGESUSU_nome($id_usu) ?? 'colaborador'; // função existente
$nome_sanit = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nome_colab);
$zip_name = $nome_sanit . '_documentos_' . date('Y-m-d') . '.zip';

// Gerar ZIP em arquivo temp
$tmp = tempnam(sys_get_temp_dir(), 'docs_zip_');
try {
    $zip = new ZipArchive();
    if ($zip->open($tmp, ZipArchive::OVERWRITE) !== true) {
        throw new RuntimeException('Não foi possível criar o ZIP');
    }
    foreach ($arquivos as $i => $f) {
        $meta = $f['meta'];
        $internal = sprintf(
            '%s_%s_%s.pdf',
            preg_replace('/[^a-zA-Z0-9_-]/', '_', $meta['competencia']),
            preg_replace('/[^a-zA-Z0-9_-]/', '_', $meta['tipo']),
            preg_replace('/[^a-zA-Z0-9_-]/', '_', $meta['descricao'])
        );
        $zip->addFile($f['path'], $internal);
    }
    $zip->close();

    error_log(sprintf(
        '[FEA-011] zip gerado id_emp=%d id_usa=%d qtd=%d bytes=%d',
        $id_emp, $id_usa, count($arquivos), $total_bytes
    ));

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zip_name . '"');
    header('Content-Length: ' . filesize($tmp));
    readfile($tmp);
} finally {
    @unlink($tmp);
}
```

### 4. JS de erro amigável (~1h)

Em vez de form POST puro, usar `fetch()` num primeiro request HEAD pra checar limites (opcional) ou apenas tratar erro HTTP 413/400 no submit:

```js
// alternativa simples: form submit normal; o navegador baixa o ZIP
// se vier erro HTTP, exibir mensagem do response JSON
```

Decisão: **manter form submit puro** por simplicidade. Se exceder limite, response 413 abre o JSON no navegador — feio mas não bloqueia. Pra UX melhor, adicionar `fetch` POST que: (a) recebe JSON de erro → toast; (b) recebe blob → cria link e clica programaticamente. Avaliar na implementação se o esforço vale +30min.

### 5. Validação manual em prod-like (~2h)

Cenários a testar:
- Colaborador com 1 documento → ZIP com 1 arquivo
- Colaborador com 60 documentos (holerites + IRRF) → ZIP completo, <30s
- Seleção parcial (5 de 60) → só os 5
- "Selecionar todos" → todos marcados, botão habilitado
- Desmarcar tudo → botão desabilitado
- Tentar baixar sem selecionar nada → botão disabled, sem request
- Forçar 201 tokens via DevTools → erro 413 amigável
- Token forjado (não existe na sessão) → erro 400
- Arquivo deletado do bucket mas registro existe no DB → ignora silenciosamente (skip), ZIP só com o que existe
- Nome do colaborador com caracteres especiais (ç, á, /) → filename sanitizado

### 6. Deploy (~30min)

- Build local: `docker build -t us-central1-docker.pkg.dev/gestou-489010/gestou-repo/gestou:latest .`
- Push: `docker push ...`
- Deploy: comando padrão de `CLAUDE.md` (não há env vars ou secrets novos)
- Smoke test em `https://gestou.com.br/admin/alterar_colaborador?id_fun=<algum>` → aba Documentos → baixar 2 docs

---

## Pontos abertos (decidir no início da sessão)

| # | Ponto | Default sugerido |
|---|---|---|
| 1 | Confirmar paths reais de Ponto, Diversos, Documento, Atestado | Validar via grep antes de codar |
| 2 | Nome da sessão de `raiz_cnpj` (pode ser `raiz_cnpj_default` ou outro) | Conferir em `alterar_colaborador.php` |
| 3 | Fetch+toast vs form submit puro | Form simples no MVP, melhorar UX numa Fase 2 se cliente pedir |
| 4 | Aplicar também no portal `/app/` do colaborador? | **Não no MVP** — só `/admin/`. Se cliente pedir depois, vira FEA-011b |
| 5 | Aplicar nas abas Cursos/Exames também? | **Não no MVP** — escopo só Documentos |

---

## Débito técnico evitado

A função `resolveDocumentoPath` centraliza o mapeamento tipo → path. Hoje esse mapeamento está espalhado em 6+ telas (`holerite_item.php`, `recibo_impressao.php`, `documentos_colaborador.php`, `visualizar_irrf_arquivo.php`, etc.). **Não vamos refatorar essas telas agora** — só criar a função e usar no novo endpoint. Migração futura fica opcional.

---

## Referências

- `admin/alterar_colaborador.php:932-1011` — aba Documentos
- `admin/iuds_pdo.php:11187` — função `select_DOCUMENTOS`
- `app/holerite_item.php:119` — exemplo de convenção de path
- `admin/visualizar_irrf_arquivo.php:39` — convenção IRRF
- `prd.json` FEA-011 — acceptance criteria
- `CLAUDE.md` — processo de deploy
