<?php
// FEA-009 Fase 5 — Processa aceite digital do autônomo (Opção B)
// SEM login. Valida CPF + token, registra IP/user-agent/timestamp, gera PDF de evidência.

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../admin/iuds_pdo.php';
require_once __DIR__ . '/../../admin/helpers/rpa_pdf.php';

header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$token = trim($_POST['token'] ?? '');
$cpf   = preg_replace('/\D/', '', $_POST['cpf'] ?? '');

if ($token === '' || strlen($token) !== 64 || !ctype_xdigit($token)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Token inválido.']);
    exit;
}
if (strlen($cpf) !== 11) {
    echo json_encode(['status' => 'cpf_invalido', 'mensagem' => 'CPF inválido.']);
    exit;
}

try {
    $arr = selectGESRPA_by_token($token);
    if (!is_array($arr) || !isset($arr[0]['id_rpa'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Link inválido ou já utilizado.']);
        exit;
    }
    $r = $arr[0];

    // Validações de estado
    if (!empty($r['token_validade']) && strtotime($r['token_validade']) < time()) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Link expirado.']);
        exit;
    }
    if ($r['status'] !== 'autorizado') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'RPA não está em estado de aceite (status: ' . $r['status'] . ').']);
        exit;
    }

    // CPF deve bater (não revela se RPA existe, só "não confere")
    $cpf_cadastrado = preg_replace('/\D/', '', $r['autonomo_cpf']);
    if ($cpf !== $cpf_cadastrado) {
        echo json_encode(['status' => 'cpf_invalido', 'mensagem' => 'CPF não confere com o cadastro.']);
        exit;
    }

    $id_rpa = (int) $r['id_rpa'];
    $id_emp = (int) $r['id_emp'];
    $id_aut = (int) $r['id_aut'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
    $data_aceite = date('Y-m-d H:i:s');

    // Atualiza GESRPA → assinado
    updateGESRPA_status($id_rpa, $id_emp, 'assinado', null, [
        'assinado_por'          => $id_aut,
        'ip_assinatura'         => $ip,
        'user_agent_assinatura' => $ua,
    ]);

    // Invalida o token (uso único)
    invalidarTokenAceiteRPA($id_rpa, $id_emp);

    // Gera PDF de evidência (não-blocking — se falhar, aceite já está gravado)
    try {
        gerarPDFEvidenciaRPA($id_rpa, $id_emp, $token, $ip, $ua, $data_aceite);
    } catch (Exception $pdfErr) {
        error_log("[FEA-009] Falha gerando PDF de evidência do RPA $id_rpa: " . $pdfErr->getMessage());
    }

    echo json_encode([
        'status' => 'sucesso',
        'nome'   => $r['autonomo_nome'],
        'data_assinatura' => date('d/m/Y H:i:s'),
    ]);
} catch (Exception $e) {
    error_log('[FEA-009] Erro fatal no aceite: ' . $e->getMessage());
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro interno. Tente novamente em instantes.']);
}
