<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "HOST: " . getenv('SMTP_HOST') . "\n";
echo "PASS: " . (getenv('SMTP_PASS') ? 'SET' : 'EMPTY') . "\n";
require __DIR__ . '/../admin/vendor_envio_email/autoload.php';
require __DIR__ . '/../config/mail.php';
$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
try {
    configureMailer($mail);
    $mail->addAddress('rafael@leveinovacao.com.br');
    $mail->isHTML(true);
    $mail->Subject = 'Teste SMTP Gestou';
    $mail->Body = 'Teste do Cloud Run';
    $mail->send();
    echo "SUCESSO\n";
} catch (\Exception $e) {
    echo "ERRO: " . $mail->ErrorInfo . "\n";
}
