<?php
// FEA-009 Fase 3 — Streaming seguro de PDF do RPA
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util.php";

$id_rpa = isset($_GET['id_rpa']) ? (int) $_GET['id_rpa'] : 0;
$tipo   = $_GET['tipo'] ?? '';

if ($id_rpa <= 0 || !in_array($tipo, ['autorizacao','contrato','recibo','evidencia'], true)) {
    http_response_code(400);
    echo 'Parâmetros inválidos.';
    exit;
}

$rpa = selectGESRPA($id_rpa, $id_emp_default);
if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
    http_response_code(404);
    echo 'RPA não encontrado.';
    exit;
}

$col = $tipo . '_pdf_path';
$rel_path = $rpa[0][$col] ?? '';
if (!$rel_path) {
    http_response_code(404);
    echo 'PDF ainda não foi gerado para este RPA.';
    exit;
}

$full = __DIR__ . '/../../' . $rel_path;
if (!file_exists($full)) {
    http_response_code(404);
    echo 'Arquivo não encontrado no servidor.';
    exit;
}

$nome_download = 'RPA' . str_pad($id_rpa, 5, '0', STR_PAD_LEFT) . '_' . $tipo . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $nome_download . '"');
header('Content-Length: ' . filesize($full));
header('Cache-Control: private, max-age=0, must-revalidate');
readfile($full);
exit;
