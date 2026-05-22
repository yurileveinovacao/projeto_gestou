<?php
// FEA-011 — Download em lote de documentos do colaborador (ZIP)
// Recebe POST { tokens: [...] } com tokens previamente gerados em alterar_colaborador.php.
// Valida tokens contra $_SESSION, monta ZIP em arquivo temp e streama.

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

set_time_limit(180);
ini_set('memory_limit', '512M');

const MAX_ARQUIVOS = 200;
const MAX_BYTES = 500 * 1024 * 1024; // 500 MB

function jsonErro($code, $msg, $extra = [])
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['erro' => $msg], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_SESSION['id_usa']) || empty($_SESSION['id_emp_default'])) {
    jsonErro(401, 'Sessão expirada.');
}

$id_emp = (int) $_SESSION['id_emp_default'];
$id_usa = (int) $_SESSION['id_usa'];

$tokens = isset($_POST['tokens']) && is_array($_POST['tokens']) ? $_POST['tokens'] : [];
if (count($tokens) === 0) {
    jsonErro(400, 'Nenhum documento selecionado.');
}
if (count($tokens) > MAX_ARQUIVOS) {
    jsonErro(413, 'Limite excedido. Selecione no máximo ' . MAX_ARQUIVOS . ' arquivos.', [
        'max_arquivos' => MAX_ARQUIVOS,
        'qtd_selecionada' => count($tokens),
    ]);
}

$session_tokens = isset($_SESSION['alterar_colaborador']['token']) ? $_SESSION['alterar_colaborador']['token'] : [];
$colab_cpf = isset($_SESSION['alterar_colaborador']['colab_cpf']) ? $_SESSION['alterar_colaborador']['colab_cpf'] : '';
$colab_nome = isset($_SESSION['alterar_colaborador']['colab_nome']) ? $_SESSION['alterar_colaborador']['colab_nome'] : 'colaborador';

$arquivos = [];
$total_bytes = 0;
$nomes_usados = [];

foreach ($tokens as $token) {
    if (!is_string($token) || empty($session_tokens[$token])) {
        jsonErro(400, 'Token inválido ou expirado.');
    }
    $meta = $session_tokens[$token];
    $path = resolveDocumentoPath($meta['tipo'], $meta['arquivo'], $raiz_cnpj, $colab_cpf);
    if (!$path || !file_exists($path)) {
        // Ignora arquivo ausente — pode ter sido removido. Continua com o resto.
        continue;
    }
    $size = filesize($path);
    if ($size === false) {
        continue;
    }
    $total_bytes += $size;
    if ($total_bytes > MAX_BYTES) {
        jsonErro(413, 'Tamanho total excedido (limite 500MB). Selecione menos arquivos.', [
            'max_mb' => 500,
            'atual_mb' => round($total_bytes / 1024 / 1024, 1),
        ]);
    }
    $arquivos[] = ['path' => $path, 'meta' => $meta, 'size' => $size];
}

if (count($arquivos) === 0) {
    jsonErro(404, 'Nenhum arquivo encontrado no storage.');
}

$nome_sanit = preg_replace('/[^a-zA-Z0-9_-]/', '_', $colab_nome);
$nome_sanit = trim($nome_sanit, '_');
if ($nome_sanit === '') {
    $nome_sanit = 'colaborador';
}
$zip_name = $nome_sanit . '_documentos_' . date('Y-m-d') . '.zip';

$tmp = tempnam(sys_get_temp_dir(), 'docs_zip_');
$ok = false;

try {
    $zip = new ZipArchive();
    if ($zip->open($tmp, ZipArchive::OVERWRITE) !== true) {
        jsonErro(500, 'Falha ao criar o ZIP.');
    }

    foreach ($arquivos as $f) {
        $meta = $f['meta'];
        $base = sprintf(
            '%s_%s_%s',
            preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $meta['competencia']),
            preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $meta['tipo']),
            preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $meta['descricao'])
        );
        $base = trim($base, '_');
        if ($base === '') {
            $base = 'documento';
        }
        $ext = strtolower(pathinfo($f['path'], PATHINFO_EXTENSION));
        if ($ext === '') {
            $ext = 'pdf';
        }
        // Evita colisão de nomes idênticos no ZIP
        $nome_interno = $base . '.' . $ext;
        $suffix = 1;
        while (isset($nomes_usados[$nome_interno])) {
            $suffix++;
            $nome_interno = $base . '_' . $suffix . '.' . $ext;
        }
        $nomes_usados[$nome_interno] = true;
        $zip->addFile($f['path'], $nome_interno);
    }
    $zip->close();
    $ok = true;

    error_log(sprintf(
        '[FEA-011] zip gerado id_emp=%d id_usa=%d colab=%s qtd=%d bytes=%d',
        $id_emp, $id_usa, $nome_sanit, count($arquivos), $total_bytes
    ));

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zip_name . '"');
    header('Content-Length: ' . filesize($tmp));
    header('Cache-Control: no-store');
    readfile($tmp);
} finally {
    if (file_exists($tmp)) {
        @unlink($tmp);
    }
}
