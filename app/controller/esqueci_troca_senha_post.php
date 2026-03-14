<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_app.php";

/**
 * 
 * Funções no Click
 * 
 */
if (isset($_POST['btn_submit'])) {

    try {

        $senha = $_POST['senha'];
        $confirm = $_POST['confirm'];
        $cpf = variavel_sessao_recuperacao_senha();
        // echo 'Senha: ' . $senha . '<br>';
        // echo 'Confirm: ' . $confirm . '<br>';

        if ($senha === $confirm) {

            foreach (consulta_cpf($cpf) as $consulta_cpf) {

                $nome = $consulta_cpf['nome'];
                $email = $consulta_cpf['email'];
            }

            $nova_senha = password_hash($senha, PASSWORD_DEFAULT);

            update_senha_GESUSU($nova_senha, $cpf);

            envio_email_senha($email, $nome, $senha);

            unset_sesseion();

            apresentar_mensagem(1);
        } else {

            apresentar_mensagem(0);
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}


/**
 * 
 * Funções
 * 
 */

function variavel_sessao_recuperacao_senha()
{
    // Inicia a sessão para recuperação de senha
    global $pdo;
    session_name("troca_senha");
    require_once __DIR__."/../../config/session.php"; session_start();

    return $_SESSION["troca_senha_cpf"];
}

function apresentar_mensagem($codigo)
{
    // Apresenta uma mensagem na tela de acordo com o código recebido
    // 0 = Senhas não coincidem
    // 1 = Senha Atualizada

    echo $codigo;
}

function envio_email_senha($email, $nome, $senha)
{
    require "../esqueci_email_senha_alterada.php";
}

function unset_sesseion()
{
    unset($_SESSION["troca_senha_cpf"]);
    unset($_SESSION["cod_liberado"]);
}