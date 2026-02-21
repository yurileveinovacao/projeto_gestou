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

//  Ação do Botão Voltar
if (isset($_POST['btn_voltar'])) {

    // Apaga o valor da variavel de sessão id_dep_alterar
    unset($_SESSION['id_dep_alterar']);
}

// AÇÃO DO BOTÃO SALVAR
if (isset($_POST['btn_submit'])) {

    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);

    if ($nomeValido) {

        try {

            // Atribui valor as Variáveis
            $nome_update = $_POST['nome_update'];
            $id_dep = $_POST['id_dep'];

            // Formata as Variáveis
            $nome = formatarValor('UPPER', $nome_update);

            /*
            // Exibe as Variáveis
            echo 'ID Dep: ' . $id_dep . '<br>';
            echo 'Nome: ' . $nome . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa Atu: ' . $id_usa_default . '<br>';
            */

            // Executa Comandos no Banco
            // UPDATE Tabela GESDEP
            updateGESDEP_nome(
                $nome,
                $datatu,
                $id_usa_default,
                $id_dep
            );

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}