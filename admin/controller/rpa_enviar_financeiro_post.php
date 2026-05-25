<?php
// FEA-009 Fase 6 — Enviar RPA para o financeiro (status: assinado → enviado_fin)
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

$id_rpa = (int) ($_POST['id_rpa'] ?? 0);
if ($id_rpa <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}

try {
    $rpa = selectGESRPA($id_rpa, $id_emp_default);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA não encontrado.']);
        exit;
    }
    if ($rpa[0]['status'] !== 'assinado') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Só é possível enviar pro financeiro quando o RPA está assinado (atual: ' . $rpa[0]['status'] . ').']);
        exit;
    }

    updateGESRPA_status($id_rpa, $id_emp_default, 'enviado_fin', $id_usa_default, [
        'data_envio_fin' => date('Y-m-d'),
    ]);
    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
