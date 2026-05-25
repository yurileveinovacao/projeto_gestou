<?php
// FEA-009 Fase 5 — Streaming público de PDF do RPA via token (pra leitura antes do aceite)
// SEM login. Apenas valida que o token é válido e que o tipo é permitido.

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../admin/iuds_pdo.php';

$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$tipo  = $_GET['tipo'] ?? '';

if ($token === '' || strlen($token) !== 64 || !ctype_xdigit($token)) {
    http_response_code(400);
    echo 'Link inválido.';
    exit;
}
if (!in_array($tipo, ['autorizacao', 'contrato', 'recibo', 'evidencia'], true)) {
    http_response_code(400);
    echo 'Tipo inválido.';
    exit;
}

$arr = selectGESRPA_by_token($token);
if (!is_array($arr) || !isset($arr[0]['id_rpa'])) {
    http_response_code(404);
    echo 'Link inválido ou expirado.';
    exit;
}
$rpa = $arr[0];

if (!empty($rpa['token_validade']) && strtotime($rpa['token_validade']) < time()) {
    http_response_code(410);
    echo 'Link expirado.';
    exit;
}

$col = $tipo . '_pdf_path';
$rel_path = $rpa[$col] ?? '';
if (!$rel_path) {
    http_response_code(404);
    echo 'PDF ainda não disponível para este RPA.';
    exit;
}

$full = __DIR__ . '/../' . $rel_path;
if (!file_exists($full)) {
    http_response_code(404);
    echo 'Arquivo não encontrado.';
    exit;
}

$nome = 'RPA' . str_pad((int) $rpa['id_rpa'], 5, '0', STR_PAD_LEFT) . '_' . $tipo . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $nome . '"');
header('Content-Length: ' . filesize($full));
header('Cache-Control: private, max-age=0, must-revalidate');
readfile($full);
exit;
