<?php
// FEA-009 Fase 3 — Cancela um RPA (status → cancelado, grava motivo)
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

$id_rpa = (int) ($_POST['id_rpa'] ?? 0);
$motivo = trim($_POST['motivo'] ?? '');

if ($id_rpa <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}
if (mb_strlen($motivo) < 5) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Informe um motivo (mínimo 5 caracteres).']);
    exit;
}

try {
    $rpa = selectGESRPA($id_rpa, $id_emp_default);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA não encontrado.']);
        exit;
    }
    if ($rpa[0]['status'] === 'pago') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA já pago não pode ser cancelado.']);
        exit;
    }
    if ($rpa[0]['status'] === 'cancelado') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA já está cancelado.']);
        exit;
    }

    updateGESRPA_status($id_rpa, $id_emp_default, 'cancelado', $id_usa_default, [
        'motivo_cancelamento' => $motivo,
    ]);

    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
