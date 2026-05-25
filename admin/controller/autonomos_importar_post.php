<?php
// FEA-009 Fase 2 — Import CSV de autônomos
// Suporta 2 ações: 'preview' (valida e retorna por linha) e 'confirmar' (insere em massa).
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

const RPA_IMPORT_MAX_LINHAS = 500;
const RPA_IMPORT_MAX_BYTES  = 1024 * 1024; // 1MB

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

function ler_csv($path) {
    $rows = [];
    if (($h = fopen($path, 'r')) === false) return false;
    // Trata BOM UTF-8
    $bom = fread($h, 3);
    if ($bom !== "\xEF\xBB\xBF") rewind($h);
    // Tenta detectar separador (; ou ,) na primeira linha
    $first = fgets($h);
    if ($first === false) { fclose($h); return $rows; }
    $sep = (substr_count($first, ';') >= substr_count($first, ',')) ? ';' : ',';
    rewind($h);
    if ($bom === "\xEF\xBB\xBF") fread($h, 3); // pula BOM novamente
    while (($cols = fgetcsv($h, 0, $sep)) !== false) {
        $rows[] = $cols;
    }
    fclose($h);
    return $rows;
}

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Falha no upload.']);
    exit;
}
if ($_FILES['arquivo']['size'] > RPA_IMPORT_MAX_BYTES) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Arquivo muito grande (máx 1MB).']);
    exit;
}

$acao = $_POST['acao'] ?? 'preview';
$rows = ler_csv($_FILES['arquivo']['tmp_name']);
if ($rows === false || count($rows) < 2) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não foi possível ler o CSV ou está vazio.']);
    exit;
}

// Valida cabeçalho
$header_esperado = ['nome','cpf','rg','data_nasc','etnia','endereco','cep','bairro','cidade','uf','email','pix','ativo'];
$header = array_map(function ($s) { return strtolower(trim($s)); }, $rows[0]);
$missing = array_diff($header_esperado, $header);
if (!empty($missing)) {
    echo json_encode(['status' => 'erro',
        'mensagem' => 'Cabeçalho inválido. Falta: ' . implode(', ', $missing) . '. Esperado: ' . implode(';', $header_esperado)]);
    exit;
}
$idx = array_flip($header);

$data_rows = array_slice($rows, 1);
if (count($data_rows) > RPA_IMPORT_MAX_LINHAS) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Máximo ' . RPA_IMPORT_MAX_LINHAS . ' linhas por arquivo.']);
    exit;
}

// Pré-carrega CPFs já existentes pra detecção rápida de duplicados
global $pdo;
$stmt = $pdo->prepare('SELECT cpf FROM public."GESAUT" WHERE id_emp =:id_emp');
$stmt->execute([':id_emp' => $id_emp_default]);
$cpfs_existentes = array_flip(array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'cpf'));

$linhas = [];
$cpfs_no_arquivo = [];  // pra detectar duplicatas dentro do próprio CSV

foreach ($data_rows as $i => $cols) {
    $linha_num = $i + 2; // +1 cabeçalho, +1 base-1
    if (count($cols) < count($header_esperado)) {
        // preenche colunas faltantes com vazio
        $cols = array_pad($cols, count($header_esperado), '');
    }
    $nome  = trim($cols[$idx['nome']]  ?? '');
    $cpf   = preg_replace('/\D/', '', $cols[$idx['cpf']] ?? '');
    $email = trim($cols[$idx['email']] ?? '');
    $pix   = trim($cols[$idx['pix']]   ?? '');

    $reg = [
        'linha' => $linha_num,
        'nome'  => $nome,
        'cpf'   => $cpf,
        'email' => $email,
        'pix'   => $pix,
    ];

    // Pula linhas totalmente vazias silenciosamente (final do arquivo)
    if ($nome === '' && $cpf === '' && $email === '' && $pix === '') continue;

    // Validações em ordem
    $erros = [];
    if (mb_strlen($nome) < 3)                        $erros[] = 'nome muito curto';
    if (!rpa_validar_cpf($cpf))                      $erros[] = 'CPF inválido';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))  $erros[] = 'e-mail inválido';
    if ($pix === '')                                 $erros[] = 'PIX vazio';

    if (!empty($erros)) {
        $reg['status'] = 'invalido';
        $reg['motivo'] = implode('; ', $erros);
    } elseif (isset($cpfs_existentes[$cpf])) {
        $reg['status'] = 'duplicado';
        $reg['motivo'] = 'CPF já cadastrado nesta empresa';
    } elseif (isset($cpfs_no_arquivo[$cpf])) {
        $reg['status'] = 'duplicado';
        $reg['motivo'] = 'CPF duplicado no próprio arquivo (linha ' . $cpfs_no_arquivo[$cpf] . ')';
    } else {
        $reg['status'] = 'valido';
        $reg['motivo'] = '';
        $cpfs_no_arquivo[$cpf] = $linha_num;
        // Guarda dados completos pro insert (no modo confirmar)
        $reg['_dados'] = [
            'nome'      => mb_strtoupper($nome, 'UTF-8'),
            'cpf'       => $cpf,
            'email'     => $email,
            'pix'       => $pix,
            'rg'        => trim($cols[$idx['rg']] ?? '') ?: null,
            'data_nasc' => trim($cols[$idx['data_nasc']] ?? '') ?: null,
            'etnia'     => trim($cols[$idx['etnia']] ?? '') ?: null,
            'endereco'  => trim($cols[$idx['endereco']] ?? '') !== '' ? mb_strtoupper(trim($cols[$idx['endereco']]), 'UTF-8') : null,
            'cep'       => preg_replace('/\D/', '', $cols[$idx['cep']] ?? '') ?: null,
            'bairro'    => trim($cols[$idx['bairro']] ?? '') !== '' ? mb_strtoupper(trim($cols[$idx['bairro']]), 'UTF-8') : null,
            'cidade'    => trim($cols[$idx['cidade']] ?? '') !== '' ? mb_strtoupper(trim($cols[$idx['cidade']]), 'UTF-8') : null,
            'uf'        => trim($cols[$idx['uf']] ?? '') ?: null,
        ];
    }

    $linhas[] = $reg;
}

if ($acao === 'preview') {
    // Remove dados internos antes de retornar
    $resposta = array_map(function ($l) { unset($l['_dados']); return $l; }, $linhas);
    echo json_encode(['status' => 'sucesso', 'linhas' => $resposta]);
    exit;
}

// $acao === 'confirmar' — INSERT em massa
$validos = array_filter($linhas, function ($l) { return $l['status'] === 'valido'; });
$inseridos = 0;
foreach ($validos as $l) {
    $d = $l['_dados'];
    insertGESAUT($id_emp_default, $d['nome'], $d['cpf'], $d['email'], $d['pix'], $d['rg'], $d['data_nasc'], $d['etnia'],
                 $d['endereco'], $d['cep'], $d['bairro'], $d['cidade'], $d['uf'], $id_usa_default);
    $inseridos++;
}
echo json_encode(['status' => 'sucesso', 'inseridos' => $inseridos]);
