<?php
/**
 * healthcheck.php — Endpoint de verificação de saúde da aplicação
 *
 * Testa a conexão ao banco de dados PostgreSQL.
 * Retorna HTTP 200 se tudo OK, HTTP 500 se houver falha.
 *
 * Uso:
 *   curl http://SEU_DOMINIO/scripts/healthcheck.php
 *
 * Cloud Run usa este endpoint para determinar se a instância está saudável.
 */

header('Content-Type: application/json');

$checks = array(
    'database' => false,
    'timestamp' => date('Y-m-d H:i:s T'),
    'php_version' => PHP_VERSION
);

$errors = array();

// ---------------------------------------------------------------------------
// Teste 1: Conexão ao banco de dados via PDO
// ---------------------------------------------------------------------------
try {
    require __DIR__ . '/../config/database.php';

    // Testar conexão PDO com uma query simples
    $stmt = $pdo->query('SELECT 1');
    if ($stmt !== false) {
        $checks['database'] = true;
    }
} catch (Exception $e) {
    $errors[] = 'Database: ' . $e->getMessage();
}

// ---------------------------------------------------------------------------
// Teste 2: Conexão pg_connect (se disponível)
// ---------------------------------------------------------------------------
if (isset($conn) && $conn) {
    $result = pg_query($conn, 'SELECT 1');
    if ($result !== false) {
        $checks['pg_connect'] = true;
        pg_free_result($result);
    } else {
        $checks['pg_connect'] = false;
        $errors[] = 'pg_connect: query failed';
    }
} else {
    $checks['pg_connect'] = false;
    $errors[] = 'pg_connect: connection not available';
}

// ---------------------------------------------------------------------------
// Resultado final
// ---------------------------------------------------------------------------
$all_ok = $checks['database'];

if ($all_ok) {
    http_response_code(200);
    $checks['status'] = 'healthy';
} else {
    http_response_code(500);
    $checks['status'] = 'unhealthy';
    $checks['errors'] = $errors;
}

echo json_encode($checks, JSON_PRETTY_PRINT);
