<?php
// FEA-009 Fase 5 — Reenvia email de aceite ao autônomo (gera token novo, invalida o anterior)
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";
require_once "../helpers/rpa_aceite_email.php";

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
    if ($rpa[0]['status'] !== 'autorizado') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Só é possível reenviar quando o status é "autorizado" (atual: ' . $rpa[0]['status'] . ').']);
        exit;
    }

    // Invalida token anterior + gera novo via enviarEmailAceiteAutonomo
    invalidarTokenAceiteRPA($id_rpa, $id_emp_default);
    $res = enviarEmailAceiteAutonomo($id_rpa, $id_emp_default);

    if (!empty($res['enviado'])) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Email reenviado para ' . $rpa[0]['autonomo_email']]);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Token gerado mas falha no envio: ' . ($res['erro'] ?? 'erro desconhecido')]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
