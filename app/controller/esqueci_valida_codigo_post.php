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

        $codigo = $_POST['codigo'];
        $cpf = variavel_sessao_recuperacao_senha();

        // echo 'Código - ' . $codigo . '<br>';
        // echo 'CPF - ' . $cpf . '<br>';

        foreach (consulta_cpf($cpf) as $consulta_contrasenha) {

            $nome = $consulta_contrasenha["nome"];
            $contrasenha_banco = $consulta_contrasenha["contrasenha"];

            if (empty($consulta_contrasenha)) {

                apresentar_mensagem(0);
            } else {

                if (password_verify($codigo, $contrasenha_banco)) {

                    definir_variavel_cod($codigo);

                    apresentar_mensagem(1);
                } else {

                    apresentar_mensagem(2);
                }
            }
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
    session_name("troca_senha");
    require_once __DIR__."/../../config/session.php"; session_start();

    return $_SESSION["troca_senha_cpf"];
}

function apresentar_mensagem($codigo)
{
    // Apresenta uma mensagem na tela de acordo com o código recebido
    // 0 = CPF não preenchido
    // 1 = Código correto
    // 2 = Código Invalido

    echo $codigo;
}

function definir_variavel_cod($codigo) 
{
    $_SESSION['cod_liberado'] = $codigo;
}