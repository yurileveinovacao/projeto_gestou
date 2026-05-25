<?php
// FEA-009 Fase 6 — Marcar RPA como pago (status: enviado_fin → pago)
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

$id_rpa = (int) ($_POST['id_rpa'] ?? 0);
$data_pgto = $_POST['data_pgto'] ?? '';

if ($id_rpa <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_pgto)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Data de pagamento inválida.']);
    exit;
}

try {
    $rpa = selectGESRPA($id_rpa, $id_emp_default);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA não encontrado.']);
        exit;
    }
    if ($rpa[0]['status'] !== 'enviado_fin') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Só é possível marcar como pago quando o RPA está enviado pro financeiro (atual: ' . $rpa[0]['status'] . ').']);
        exit;
    }

    updateGESRPA_status($id_rpa, $id_emp_default, 'pago', $id_usa_default, [
        'data_pgto' => $data_pgto,
    ]);
    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
