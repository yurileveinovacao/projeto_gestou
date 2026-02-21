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

// AÇÃO NA MUDANÇA DE SITUAÇÃO
if (isset($_POST['btn_situac'])) {

    try {

        // Atribui valor as Variáveis
        $id_dep = $_POST['id_dep_update'];
        $situac_update = $_POST['situac_update'];


        // Formata as Variáveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe as Variáveis
        echo 'ID Dep: ' . $id_dep . '<br>';
        echo 'Situac_update: ' . $situac_update . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Master: ' . $id_usa_default . '<br>';
        */

        // Executa os comandos no Banco
        // UPDATE Tabela GESDEP
        updateGESDEP_situac($situac, $datatu, $id_usa_default, $id_dep);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// AÇÃO NO EDITAR
if (isset($_POST['id_dep'])) {

    // ATRIBUIÇÃO DO POST EM VARIAVEL DE SESSION
    $_SESSION["id_dep_alterar"] = $_POST['id_dep'];
}

// AÇÃO NO EXCLUIR
if (isset($_POST['btn_exc']) and !empty($_POST['ids'])) {

    try {

        // Atribui valor as Variáveis
        $ids = $_POST['ids'];

        /*
        // Exibe as Variáveis
        $ids_exibir = implode(',', $ids);
        echo 'Ids: ' . $ids_exibir . '<br>';
        */

        deleteGESDEP_in($ids);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT INCLUIR
if (isset($_POST['btn_submit'])) {

    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);

    if ($nomeValido) {

        try {

            // Atribui valor as Variáveis
            $nome_update = $_POST['nome_update'];
            $situac = 1;

            // Formata as Variáveis
            $nome = formatarValor('UPPER', $nome_update);

            /*
            // Exibe as Variáveis
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            echo 'Nome: ' . $nome . '<br>';
            echo 'Situação: ' . $situac . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa Inc: ' . $id_usa_default . '<br>';
            echo 'ID Usa Atu: ' . $id_usa_default . '<br>';
            */

            // Executa Comandos no Banco
            // INSERT Tabela GESDEP
            insertGESDEP(
                $id_emp_default,
                $nome,
                $situac,
                $datinc,
                $datatu,
                $id_usa_default,
                $id_usa_default
            );

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}
