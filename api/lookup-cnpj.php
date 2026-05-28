<?php

// FEA-015: proxy server-side pra BrasilAPI de consulta de CNPJ.
// Usado pelo /createaccount/ pra auto-preencher razão social no cadastro.
// Server-side (não browser) pra evitar CORS e centralizar tratamento de erro/rate-limit.

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Só GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'erro' => 'Método não permitido']);
    exit;
}

// Sanitiza: mantém só dígitos
$cnpj = preg_replace('/\D/', '', $_GET['cnpj'] ?? '');

if (strlen($cnpj) !== 14) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'erro' => 'CNPJ deve ter 14 dígitos']);
    exit;
}

$ch = curl_init("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
curl_setopt($ch, CURLOPT_USERAGENT, 'Gestou/1.0 (+https://gestou.com.br)');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$body = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err  = curl_errno($ch);
curl_close($ch);

// Falha de rede / timeout
if ($err !== 0 || $body === false) {
    http_response_code(503);
    echo json_encode(['ok' => false, 'erro' => 'Serviço de consulta indisponível. Preencha manualmente.']);
    exit;
}

// CNPJ não encontrado
if ($http === 404) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'erro' => 'CNPJ não encontrado na Receita.']);
    exit;
}

if ($http !== 200) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'erro' => 'Resposta inesperada da consulta. Preencha manualmente.']);
    exit;
}

$dados = json_decode($body, true);
if (!is_array($dados)) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'erro' => 'Resposta inválida da consulta.']);
    exit;
}

// Normaliza só o que o cadastro usa
echo json_encode([
    'ok'             => true,
    'cnpj'           => $cnpj,
    'razao_social'   => $dados['razao_social']    ?? '',
    'nome_fantasia'  => $dados['nome_fantasia']   ?? '',
    'situacao'       => $dados['descricao_situacao_cadastral'] ?? '',
    'uf'             => $dados['uf']               ?? '',
    'municipio'      => $dados['municipio']        ?? '',
]);
