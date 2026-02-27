<?php
// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Carregar o autoloader do composer
require 'vendor_envio_email/autoload.php';
require_once __DIR__.'/../config/mail.php';
require_once "iuds_app.php";
// Instância da classe
$mail = new PHPMailer(true);
try {

    configureMailer($mail);
    // Define o destinatário
    $mail->addAddress($email_resp_rh, $nome_resp_rh);
    // Conteúdo da mensagem
    $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    $mail->Subject = 'Reset Senha GESTOU APP';
    $mail->Body    = "Olá <b>$nome_resp_rh</b>,<br>
                    O usuário <b>$nome</b>, CPF: <b>$cpf</b> solicitou o reset de senha, porem ele ainda não possui e-mail cadastrado.<br> 
                    Poderia verificar?";
    $mail->AltBody = '';
    // Enviar
    $mail->send();
} catch (Exception $e) {

    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
