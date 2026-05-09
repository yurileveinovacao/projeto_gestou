<?php

require '../restrito.php';
require_once '../iuds_pdo.php';

header('Content-Type: application/json; charset=utf-8');

$id_usa = isset($_POST['id_usa']) ? (int) $_POST['id_usa'] : 0;

if ($id_usa <= 0) {
    echo json_encode(['empresas' => []]);
    exit;
}

$empresas = [];
foreach (selectGESEMP_emp_selecionadas($id_usa) as $linha) {
    if (!is_array($linha) || empty($linha['id_emp'])) {
        continue;
    }
    $empresas[] = [
        'id_emp' => (int) $linha['id_emp'],
        'nome'   => trim($linha['nomefantasia'] ?? $linha['NOMEFANTASIA'] ?? ''),
    ];
}

echo json_encode(['empresas' => $empresas]);
