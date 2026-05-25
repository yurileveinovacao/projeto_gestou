<?php
// FEA-009 Fase 2 — toggle ativo/inativo do autônomo
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

if (!isset($_POST['id_aut'], $_POST['novo_ativo'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Parâmetros faltando.']);
    exit;
}

$id_aut = (int) $_POST['id_aut'];
$novo_ativo = (int) $_POST['novo_ativo'];

if (!in_array($novo_ativo, [0, 1], true)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Valor inválido para situação.']);
    exit;
}

try {
    // Multi-tenant: confirma que o autônomo pertence à empresa da sessão
    $existe = selectGESAUT($id_aut, $id_emp_default);
    if (!is_array($existe) || !isset($existe[0]['id_aut'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Autônomo não encontrado.']);
        exit;
    }

    toggleGESAUT_ativo($id_aut, $id_emp_default, $novo_ativo, $id_usa_default);
    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
