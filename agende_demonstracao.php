<?php
if((isset($_POST["nome"])) and (isset($_POST["email"])) and 
(isset($_POST["celular"])) and (isset($_POST["assunto"])) and (isset($_POST["mensagem"]))){
    
    $nome = $_POST["nome"];
    $razao_social = $_POST["razao_social"];
    $email = $_POST["email"];
    $celular = $_POST["celular"];
    $assunto = $_POST["assunto"];
    $sistema_folha = $_POST["sistema_folha"];
    $mensagem = $_POST["mensagem"];

    require_once "envia_email_agende_demonstracao.php";

    $retorno = '';

    $retorno .= $erro;

    //retorno da função
    echo $retorno;

}
