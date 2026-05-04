<?php
/**
 * FEA-003: Cron endpoint para verificar experiências vencendo e enviar emails.
 * Chamado diariamente pelo GCP Cloud Scheduler às 08:00 BRT.
 * Protegido por token secreto (env var CRON_SECRET).
 *
 * Uso: GET /admin/cron_check_experiencias.php?token=<CRON_SECRET>
 */

// Autenticação por token
$cron_secret = getenv('CRON_SECRET');
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($cron_secret) || $token !== $cron_secret) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// Dependências
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/iuds_pdo.php';
require_once __DIR__ . '/../config/mail.php';
require_once __DIR__ . '/../config/app.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor_envio_email/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: application/json');

$log = [];
$emails_enviados = 0;
$erros = 0;

// Buscar todas as empresas ativas com admin
$empresas = selectGESEMP_ativas_com_admin();

foreach ($empresas as $empresa) {
    if (!is_array($empresa) || empty($empresa['id_emp'])) {
        continue;
    }

    $id_emp = $empresa['id_emp'];
    $email_admin = $empresa['email_admin'];
    $nome_empresa = $empresa['nome'];

    if (empty($email_admin)) {
        $log[] = "Empresa {$nome_empresa} (id_emp={$id_emp}): sem email de admin, pulando.";
        continue;
    }

    // Buscar colaboradores com experiência vencendo em até 7 dias
    $alertas = selectGESUSU_experiencia_alerta($id_emp);

    if (empty($alertas)) {
        continue;
    }

    // Montar e enviar email
    foreach ($alertas as $alerta) {
        $nome_colab = $alerta['nome'];
        $tipo = $alerta['tipo_alerta']; // valor de dias dinâmico (dias_exp_1 ou dias_exp_2 da empresa)
        $dias_restantes = intval($alerta['dias_restantes']);
        $data_admissao = (new DateTime($alerta['dataadmissao']))->format('d/m/Y');

        if ($tipo == $alerta['dias_exp_1']) {
            $data_vencimento = (new DateTime($alerta['vencimento_fase1']))->format('d/m/Y');
        } else {
            $data_vencimento = (new DateTime($alerta['vencimento_fase2']))->format('d/m/Y');
        }

        try {
            $mail = new PHPMailer(true);
            configureMailer($mail);

            $mail->addAddress($email_admin);
            $mail->isHTML(true);
            $mail->Subject = "Gestou - Vencimento de experiencia: {$nome_colab}";
            $mail->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background-color: #4A0E8F; padding: 20px; text-align: center;">
                        <h2 style="color: #FFD700; margin: 0;">GESTOU</h2>
                    </div>
                    <div style="padding: 20px; border: 1px solid #e3e6f0;">
                        <h3 style="color: #333;">Alerta de Vencimento de Experiencia</h3>
                        <p>O periodo de experiencia de <strong>' . htmlspecialchars($nome_colab) . '</strong> esta proximo do vencimento.</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 15px 0;">
                            <tr style="background-color: #f8f9fc;">
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Colaborador</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;">' . htmlspecialchars($nome_colab) . '</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Empresa</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;">' . htmlspecialchars($nome_empresa) . '</td>
                            </tr>
                            <tr style="background-color: #f8f9fc;">
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Data de Admissao</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;">' . $data_admissao . '</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Tipo</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;">Experiencia ' . $tipo . ' dias</td>
                            </tr>
                            <tr style="background-color: #f8f9fc;">
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Data de Vencimento</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;">' . $data_vencimento . '</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #e3e6f0;"><strong>Dias Restantes</strong></td>
                                <td style="padding: 10px; border: 1px solid #e3e6f0; color: ' . ($dias_restantes <= 2 ? '#e74a3b' : '#f6c23e') . '; font-weight: bold;">' . $dias_restantes . ' dia(s)</td>
                            </tr>
                        </table>
                        <p style="color: #666; font-size: 12px;">Acesse o sistema para tomar as providencias necessarias.</p>
                    </div>
                    <div style="background-color: #f8f9fc; padding: 10px; text-align: center; font-size: 11px; color: #999;">
                        Este e um email automatico enviado pelo sistema Gestou.
                    </div>
                </div>';

            $mail->send();
            $emails_enviados++;
            $log[] = "OK: {$nome_colab} ({$tipo}d, {$dias_restantes} dias restantes) -> {$email_admin}";

        } catch (Exception $e) {
            $erros++;
            $log[] = "ERRO: {$nome_colab} -> {$email_admin}: {$e->getMessage()}";
        }
    }
}

echo json_encode([
    'status' => 'completed',
    'date' => date('Y-m-d H:i:s'),
    'emails_enviados' => $emails_enviados,
    'erros' => $erros,
    'log' => $log
], JSON_PRETTY_PRINT);
