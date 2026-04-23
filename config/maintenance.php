<?php
/**
 * Modo manutenção — ativado via env MAINTENANCE_MODE=1.
 * Bypass via ?bypass=<token> (token em env MAINTENANCE_BYPASS_TOKEN) ou cookie gestou_maint_bypass.
 * Healthcheck (/scripts/healthcheck.php) nunca é bloqueado.
 */

function checkMaintenanceMode()
{
    if (getenv('MAINTENANCE_MODE') !== '1') {
        return;
    }

    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    if (strpos($uri, '/healthcheck') !== false) {
        return;
    }

    $token = getenv('MAINTENANCE_BYPASS_TOKEN');

    if ($token !== false && $token !== '') {
        if (isset($_GET['bypass']) && is_string($_GET['bypass']) && hash_equals($token, $_GET['bypass'])) {
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
            setcookie('gestou_maint_bypass', $token, array(
                'expires'  => time() + 86400,
                'path'     => '/',
                'httponly' => true,
                'secure'   => $secure,
                'samesite' => 'Lax',
            ));
            return;
        }

        if (isset($_COOKIE['gestou_maint_bypass'])
            && is_string($_COOKIE['gestou_maint_bypass'])
            && hash_equals($token, $_COOKIE['gestou_maint_bypass'])) {
            return;
        }
    }

    http_response_code(503);
    header('Retry-After: 3600');
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate');

    $file = __DIR__ . '/../maintenance.html';
    if (is_readable($file)) {
        readfile($file);
    } else {
        echo '<!doctype html><meta charset="utf-8"><title>Em manutenção</title>';
        echo '<h1>Gestou — Em manutenção</h1><p>Voltamos em breve.</p>';
    }
    exit;
}
