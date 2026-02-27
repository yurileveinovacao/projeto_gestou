<?php
/**
 * Configuração centralizada de email SMTP.
 * Lê variáveis de ambiente com fallbacks para desenvolvimento.
 */

/**
 * Configura uma instância PHPMailer com as credenciais SMTP centralizadas.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $mail Instância do PHPMailer (passada por referência)
 */
function configureMailer(&$mail)
{
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';

    $mail->Host       = getenv('SMTP_HOST') ?: 'smtp-relay.gmail.com';
    $mail->Port       = getenv('SMTP_PORT') ?: 587;
    $mail->Username   = getenv('SMTP_USER') ?: '';
    $mail->Password   = getenv('SMTP_PASS') ?: '';
    $mail->SMTPSecure = 'tls';

    $from     = getenv('SMTP_FROM') ?: 'contato@leveinovacao.com.br';
    $fromName = getenv('SMTP_FROM_NAME') ?: 'GESTOU';

    $mail->setFrom($from, $fromName);
}
