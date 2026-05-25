<?php
// FEA-009 Fase 2 — Atualização de autônomo
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

function rpa_validar_cpf($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);
    if (strlen($cpf) !== 11) return false;
    if (preg_match('/^(\d)\1{10}$/', $cpf)) return false;
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

try {
    $id_aut    = (int) ($_POST['id_aut'] ?? 0);
    $nome      = trim($_POST['nome'] ?? '');
    $cpf       = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $pix       = trim($_POST['pix'] ?? '');
    $rg        = trim($_POST['rg'] ?? '');
    $data_nasc = $_POST['data_nasc'] ?? '';
    $etnia     = trim($_POST['etnia'] ?? '');
    $endereco  = trim($_POST['endereco'] ?? '');
    $cep       = preg_replace('/\D/', '', $_POST['cep'] ?? '');
    $bairro    = trim($_POST['bairro'] ?? '');
    $cidade    = trim($_POST['cidade'] ?? '');
    $uf        = trim($_POST['uf'] ?? '');

    if ($id_aut <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
        exit;
    }

    // Multi-tenant: verifica que o autônomo pertence à empresa da sessão
    $existe = selectGESAUT($id_aut, $id_emp_default);
    if (!is_array($existe) || !isset($existe[0]['id_aut'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Autônomo não encontrado nesta empresa.']);
        exit;
    }

    if (mb_strlen($nome) < 3) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Nome obrigatório (mínimo 3 caracteres).']);
        exit;
    }
    if (!rpa_validar_cpf($cpf)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'CPF inválido.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'E-mail inválido.']);
        exit;
    }
    if (empty($pix)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Chave PIX obrigatória.']);
        exit;
    }
    if (selectGESAUT_cpf_exists($id_emp_default, $cpf, $id_aut)) {
        echo json_encode(['status' => 'cpf_duplicado', 'mensagem' => 'Este CPF já está em uso por outro autônomo desta empresa.']);
        exit;
    }

    // Normalização
    $nome     = mb_strtoupper($nome, 'UTF-8');
    $endereco = $endereco !== '' ? mb_strtoupper($endereco, 'UTF-8') : null;
    $bairro   = $bairro   !== '' ? mb_strtoupper($bairro,   'UTF-8') : null;
    $cidade   = $cidade   !== '' ? mb_strtoupper($cidade,   'UTF-8') : null;
    $rg       = $rg       !== '' ? $rg : null;
    $data_nasc = $data_nasc !== '' ? $data_nasc : null;
    $etnia    = $etnia    !== '' ? $etnia : null;
    $cep      = $cep      !== '' ? $cep   : null;
    $uf       = $uf       !== '' ? $uf    : null;

    updateGESAUT($id_aut, $id_emp_default, $nome, $cpf, $email, $pix, $rg, $data_nasc, $etnia,
                 $endereco, $cep, $bairro, $cidade, $uf, $id_usa_default);

    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
