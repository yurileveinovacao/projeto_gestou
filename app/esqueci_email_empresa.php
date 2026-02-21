<?php
// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Carregar o autoloader do composer
require 'vendor_envio_email/autoload.php';
require_once "iuds_app.php";
// Instância da classe
$mail = new PHPMailer(true);
try {

    // Configurações do servidor
    $mail->isSMTP();        //Devine o uso de SMTP no envio
    $mail->SMTPAuth = true; //Habilita a autenticação SMTP
    $mail->CharSet = "UTF-8";
    $mail->Username   = 'suporte@gestou.com.br';
    $mail->Password   = 'Certificado@256';
    // Criptografia do envio SSL também é aceito
    $mail->SMTPSecure = 'tls';
    // Informações específicadas pelo Google
    $mail->Host = 'smtp.kinghost.net';
    $mail->Port = 587;
    // Define o remetente
    $mail->setFrom('suporte@gestou.com.br', 'GESTOU');
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
