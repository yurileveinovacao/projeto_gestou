<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";


/**
 * 
 * Funções no Click
 * 
 */

// Ação no click Alterar
if (isset($_POST['btn_alterar'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);
    $descricaoValido = validarValor('VALID', $_POST['descricao_update'], 3);
    $tel1Valido = validarValor('*', $_POST['tel1_update'], 1);
    $tel2Valido = validarValor('*', $_POST['tel2_update'], 1);
    $tel3Valido = validarValor('*', $_POST['tel3_update'], 1);
    $emailValido = validarValor('REGEX', $_POST['email_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $websiteValido = validarValor('*', $_POST['website_update'], 3);

    // Se os valores forem validados continua com o update
    if ($nomeValido && $descricaoValido && $tel1Valido && $tel2Valido && $tel3Valido && $emailValido && $websiteValido) {

        try {

            // Atribui valor das Variáveis
            $nome_update = $_POST['nome_update'];
            $descricao_update = $_POST['descricao_update'];
            $tel1_update = $_POST['tel1_update'];
            $tel2_update = $_POST['tel2_update'];
            $tel3_update = $_POST['tel3_update'];
            $email_update = $_POST['email_update'];
            $website = $_POST['website_update'];
            $id_cto = $_SESSION['editar_id_cto'];

            // Formata as variáveis
            $nome = formatarValor('UPPER', $nome_update);
            $descricao = formatarValor('UPPER', $descricao_update);
            $tel1 = formatarValor('NUM', $tel1_update);
            $tel2 = formatarValor('NUM', $tel2_update);
            $tel3 = formatarValor('NUM', $tel3_update);
            $email = formatarValor('LOWER', $email_update);


            /*           
            // Retorna as Variáveis
            echo 'Nome: ' . $nome . '<br>';
            echo 'Descricao: ' . $descricao . '<br>';
            echo 'Telefone 1: ' . $tel1 . '<br>';
            echo 'Telefone 2: ' . $tel2 . '<br>';
            echo 'Telefone 3: ' . $tel3 . '<br>';
            echo 'E-mail: ' . $email . '<br>';
            echo 'Website: ' . $website . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'Id Usa Default: ' . $id_usa_default . '<br>';
            echo 'Id Cto: ' . $id_cto . '<br>';
            */

            updateGESCTO_campos(
                $nome,
                $descricao,
                $tel1,
                $tel2,
                $tel3,
                $email,
                $website,
                $datatu,
                $id_usa_default,
                $id_cto
            );

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}


// Ação no click do Voltar
if (isset($_POST['btn_voltar'])) {

    unset($_SESSION['editar_id_cto']);
}