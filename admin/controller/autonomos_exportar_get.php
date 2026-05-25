<?php
// FEA-009 Fase 2 — Export CSV dos autônomos da empresa atual
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

// Carrega lista completa (ativos + inativos pra um snapshot fiel)
$lista = selectGESAUT_lista($id_emp_default, 'todos');

// Carrega dados completos via SELECT *
global $pdo;
$stmt = $pdo->prepare('SELECT nome, cpf, rg, data_nasc, etnia, endereco, cep, bairro, cidade, uf, email, pix, ativo
                       FROM public."GESAUT" WHERE id_emp =:id_emp ORDER BY nome');
$stmt->execute([':id_emp' => $id_emp_default]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nome do arquivo: autonomos_{empresa}_{YYYY-MM-DD}.csv
$nome_empresa = isset($_SESSION['nome_emp']) ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $_SESSION['nome_emp']) : 'empresa';
$filename = 'autonomos_' . $nome_empresa . '_' . date('Y-m-d') . '.csv';

// Cabeçalhos HTTP
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');

// BOM UTF-8 pra Excel abrir corretamente
echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');

// Cabeçalho de colunas (separador ; pra compatibilidade Excel pt-BR)
fputcsv($out, ['nome', 'cpf', 'rg', 'data_nasc', 'etnia', 'endereco', 'cep', 'bairro', 'cidade', 'uf', 'email', 'pix', 'ativo'], ';');

foreach ($rows as $r) {
    fputcsv($out, [
        $r['nome'],
        $r['cpf'],
        $r['rg'] ?? '',
        $r['data_nasc'] ?? '',
        $r['etnia'] ?? '',
        $r['endereco'] ?? '',
        $r['cep'] ?? '',
        $r['bairro'] ?? '',
        $r['cidade'] ?? '',
        $r['uf'] ?? '',
        $r['email'],
        $r['pix'],
        $r['ativo'],
    ], ';');
}

fclose($out);
exit;
