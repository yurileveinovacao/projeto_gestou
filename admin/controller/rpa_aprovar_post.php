<?php
// FEA-009 Fase 4 — Aprovar ou recusar RPA pelo Líder RH
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";
require_once "../helpers/rpa_aceite_email.php";

header('Content-Type: application/json');

$id_rpa = (int) ($_POST['id_rpa'] ?? 0);
$acao   = $_POST['acao'] ?? '';
$motivo = trim($_POST['motivo'] ?? '');

if ($id_rpa <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
    exit;
}
if (!in_array($acao, ['aprovar', 'recusar'], true)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
    exit;
}

try {
    // Multi-tenant + RPA deve estar em rascunho
    $rpa = selectGESRPA($id_rpa, $id_emp_default);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA não encontrado.']);
        exit;
    }
    if ($rpa[0]['status'] !== 'rascunho') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Este RPA não está mais em rascunho (status atual: ' . $rpa[0]['status'] . ').']);
        exit;
    }

    // Quem está aprovando precisa ser Líder RH da empresa
    if (!checkLiderRH($id_usa_default, $id_emp_default)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Apenas Líder RH pode aprovar/recusar RPAs.']);
        exit;
    }

    if ($acao === 'aprovar') {
        updateGESRPA_status($id_rpa, $id_emp_default, 'autorizado', $id_usa_default, [
            'autorizado_por' => $id_usa_default,
        ]);
        // FEA-009 Fase 5: dispara email com token de aceite (não-blocking)
        try {
            enviarEmailAceiteAutonomo($id_rpa, $id_emp_default);
        } catch (Exception $emailErr) {
            error_log('[FEA-009] Falha enviando email de aceite do RPA ' . $id_rpa . ': ' . $emailErr->getMessage());
        }
        echo json_encode(['status' => 'sucesso', 'novo_status' => 'autorizado']);
        exit;
    }

    // Recusar
    if (mb_strlen($motivo) < 5) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Informe um motivo de recusa (mínimo 5 caracteres).']);
        exit;
    }
    updateGESRPA_status($id_rpa, $id_emp_default, 'cancelado', $id_usa_default, [
        'autorizado_por'      => $id_usa_default,
        'motivo_cancelamento' => '[Recusado pelo Líder RH] ' . $motivo,
    ]);
    echo json_encode(['status' => 'sucesso', 'novo_status' => 'cancelado']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
