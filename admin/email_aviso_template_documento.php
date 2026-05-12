<?php
// FEA-008: Email de notificação ao colaborador quando recebe um documento gerado a partir de template.
// Variáveis esperadas (locais do chamador):
//   $email_destinatario  (string) — email do colaborador
//   $nome_destinatario   (string) — nome do colaborador
//   $titulo_documento    (string) — título exibido no portal
//   $nome_empresa        (string) — nome da empresa

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__.'/vendor_envio_email/autoload.php';
require_once __DIR__.'/../config/mail.php';

$mail_tpl = new PHPMailer(true);
try {
    configureMailer($mail_tpl);

    $mail_tpl->AddEmbeddedImage(__DIR__.'/../img/images_email/icone.png', 'icone');

    $titulo_safe   = htmlspecialchars($titulo_documento, ENT_QUOTES, 'UTF-8');
    $nome_safe     = htmlspecialchars($nome_destinatario, ENT_QUOTES, 'UTF-8');
    $empresa_safe  = htmlspecialchars($nome_empresa, ENT_QUOTES, 'UTF-8');

    $mail_tpl->addAddress($email_destinatario, $nome_destinatario);
    $mail_tpl->isHTML(true);
    $mail_tpl->Subject = 'Novo documento disponível: '.$titulo_documento;
    $mail_tpl->Body = '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;background:#fafafa;margin:0;padding:0;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#fafafa;padding:30px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
<tr><td align="center" style="padding:24px 20px 8px 20px;"><img src="cid:icone" alt="GESTOU" width="120"></td></tr>
<tr><td style="padding:8px 30px 0 30px;color:#333;font-size:16px;">
<p style="margin:0 0 14px 0;">Olá, <strong>'.$nome_safe.'</strong>.</p>
<p style="margin:0 0 14px 0;">A empresa <strong>'.$empresa_safe.'</strong> disponibilizou um novo documento na sua área do colaborador:</p>
<p style="margin:18px 0;text-align:center;">
<span style="display:inline-block;background:#f0f4ff;border:1px solid #c5d4ff;padding:12px 18px;border-radius:4px;color:#1d3a8a;font-weight:bold;">'.$titulo_safe.'</span>
</p>
<p style="margin:0 0 14px 0;">Acesse o portal Gestou para visualizar e dar o aceite.</p>
</td></tr>
<tr><td align="center" style="padding:18px 30px 26px 30px;color:#666;font-size:12px;border-top:1px solid #eee;margin-top:20px;">
GESTOU © '.date('Y').' - Todos os direitos reservados.
</td></tr>
</table>
</td></tr>
</table>
</body></html>';
    $mail_tpl->AltBody = "Olá, $nome_destinatario. Você recebeu um novo documento da empresa $nome_empresa: \"$titulo_documento\". Acesse o portal Gestou para visualizar.";
    $mail_tpl->send();
} catch (Exception $e) {
    // Falha de email não interrompe o envio do lote — log silencioso
    error_log('FEA-008 email falhou para '.$email_destinatario.': '.$mail_tpl->ErrorInfo);
}
