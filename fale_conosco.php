<?php
if((isset($_POST["nome"])) and (isset($_POST["email"]))and (isset($_POST["assunto"])) and (isset($_POST["mensagem"]))){
    
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $assunto = $_POST["assunto"];
    $mensagem = $_POST["mensagem"];

    require_once "envia_email_fale_conosco.php";

    $retorno = '';

    $retorno .= $erro;

    //retorno da função
    echo $retorno;

}
