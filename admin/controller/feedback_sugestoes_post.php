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

// AÇÃO VISUALIZAR/RESPONDER/CANCELAR MENSAGEM
if (isset($_POST["id_ouv_mensagem"])) {

    // Atribui valor a Variável
    $id_ouv_mensagem_update = $_POST["id_ouv_mensagem"];

    // Formatar as Variáveis
    $id_ouv_mensagem = formatarValor('NUM', $id_ouv_mensagem_update);

    /*
    // Exibe as Variáveis
    echo 'ID Ouv Mensagem: ' . $id_ouv_mensagem;
    */

    // Executa comandos no Banco
    // UPDATE Tabela GESOUV
    update_GESOUV_situac_visualizar($id_ouv_mensagem);
}

// AÇÃO ABRIR MODAL
if (isset($_POST['abrir_modal'])) {

    try {

        // Atribui valor as Variáveis
        $modal = $_POST['abrir_modal'];
        $id_ouv = $_POST['id_ouv'];

        foreach (selectGESOUV_modal($id_ouv) as $linha) {

            $situac = $linha['situac'];
        }

        if ($situac == 0) {

            // Executa os processos
            if ($modal == 'Visualizar') {

                echo '#' . $modal . $id_ouv;
            } else {

                echo '#' . $modal;
            }

            $_SESSION['id_ouv_modal'] = $id_ouv;
        } else {

            // Executa os processos
            if ($modal == 'Visualizar') {

                echo '#' . $modal . $id_ouv;
            } else {

                echo 0;
            }
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// AÇÃO FECHAR MODAL
if (isset($_POST['close_modal'])) {

    if (isset($_SESSION['id_ouv_modal'])) {

        // Apaga a variável de sessão id_ouv_modal
        unset($_SESSION['id_ouv_modal']);
    }
}

// AÇÃO SUBMIT RESPOSTA
if (isset($_POST['btn_submit_resp'])) {

    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 1);

    if ($mensagemValido) {

        try {

            // Atribui valor as Variáveis
            $id_ouv = $_SESSION['id_ouv_modal'];
            $mensagem_update = $_POST['mensagem'];
            $situac = 1;

            // Formata Variáveis
            $mensagem = formatarValor('UPPER', $mensagem_update);
            unset($_SESSION['id_ouv_modal']);

            /*
            // Exibe Variáveis
            echo 'ID Ouv: ' . $id_ouv . '<br>';
            echo 'Situação: ' . $situac . '<br>';
            echo 'Mensagem: ' . $mensagem . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            */

            // Executa comandos no Banco
            // UPDATE Tabela GESOUV
            updateGESOUV_resposta(
                $id_ouv,
                $situac,
                $mensagem,
                $datatu,
                $id_usa_default
            );

            foreach (select_ENVIO_EMAIL_OUVIDORIA($id_ouv, $id_emp_default) as $email_ouvidoria) {
                $nome_email = $email_ouvidoria["nome_envio"];
                $email_email = $email_ouvidoria["email_envio"];

                require "../email_ouvidoria.php";

                // echo 'Nome_email: ' . $nome_email . '<br>';
                // echo 'Email: ' . $email_email . '<br>';
            }

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// AÇÃO SALVAR CANCELAR
if (isset($_POST['btn_submit_cancel'])) {

    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 1);

    if ($mensagemValido) {

        try {

            // Atribui valor as Variáveis
            $id_ouv = $_SESSION['id_ouv_modal'];
            $mensagem_update = $_POST['mensagem'];
            $situac = 2;

            // Formata Variáveis
            $mensagem = formatarValor('UPPER', $mensagem_update);
            unset($_SESSION['id_ouv_modal']);

            /*
            // Exibe Variáveis
            echo 'ID Ouv: ' . $id_ouv . '<br>';
            echo 'Situação: ' . $situac . '<br>';
            echo 'Mensagem: ' . $mensagem . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            */

            // Executa comandos no Banco
            // UPDATE Tabela GESOUV
            updateGESOUV_resposta(
                $id_ouv,
                $situac,
                $mensagem,
                $datatu,
                $id_usa_default
            );

            foreach (select_ENVIO_EMAIL_OUVIDORIA($id_ouv, $id_emp_default) as $email_ouvidoria) {
                $nome_email = $email_ouvidoria["nome_envio"];
                $email_email = $email_ouvidoria["email_envio"];

                require "../email_ouvidoria.php";

                // echo 'Nome_email: ' . $nome_email . '<br>';
                // echo 'Email: ' . $email_email . '<br>';
            }

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// FILTRO
if (isset($_POST['btn_filtro'])) {

    try {

        $_SESSION['feedback_filtro_situac'] = $_POST['feedback_filtro_situac'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}