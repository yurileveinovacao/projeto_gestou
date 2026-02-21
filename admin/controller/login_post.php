<?php

//ARQUIVO DE UTILITÁRIOS REFERENTE A PÁGINA DE LOGIN
require_once "../util_login.php";

// Verificação das variáveis
if (isset($_POST["btn_submit"])) {

    // Chama a função para validar os POSTs
    $emailValido = validarValor('REGEX', $_POST['email'], '/^([\w.\'+-]+@([\w-]+\.)+[\w-]{2,4})?$/');

    // Se os valores forem validados continua com o update
    if ($emailValido) {

        // Atribui valor das Variáveis
        $email = $_POST['email']; //REQUIRED
        $senha = $_POST['senha']; //REQUIRED

        // Select na VIEW que possui os dados do usuário
        foreach (selectVW_ADMIN_GACESSO($email) as $linha) {

            // Verifica se foi encontrado o usuário no banco e que não esteja em análise
            if (!empty($linha)) {

                // Atribuição das variaveis do usuário no banco
                $email_banco = $linha["email"];
                $senha_banco = $linha["senha"];
                $situac_banco = $linha["situac"];
                $situac_senha_banco = $linha["situac_senha"];
                $id_usa_banco = $linha["id_usa"];
            } else {

                // Informação para apontar que o usuário está em analise
                $usuario_analise = 1;
            }
        }

        // Verifica se o usuario analise está vazio, fazendo assim, o direcionamento para o sistema
        if (empty($usuario_analise)) {

            // Se a situac do usuário está ativo
            if ($situac_banco == 1) {

                // Se a senha digitada for a mesma cadastrada na base para o usuário ele realiza os processos
                if (password_verify($senha, $senha_banco)) {

                    // Se a situac_senha for == 1, direciona para a troca de senha
                    if ($situac_senha_banco == 1) {

                        session_start();

                        // Todas as opções validadas
                        $_SESSION['id_usa'] = $id_usa_banco;
                        $_SESSION['email'] = $email_banco;

                        // Retorno de sucesso
                        $retorno = 1;
                        echo json_encode($retorno);
                    } else {

                        // Altere a sua senha para realizar o login
                        $retorno = 4;
                        echo json_encode($retorno);
                    }
                } else {

                    // Senha incorreta
                    $retorno = 3;
                    echo json_encode($retorno);
                }
            } else {

                // Usuário inativo
                $retorno = 2;
                echo json_encode($retorno);
            }
        } else {

            // Usuário em analise
            $retorno = 5;
            echo json_encode($retorno);
        }
    } else {

        // Email inválido ou informação não preenchida
        $retorno = 0;
        echo json_encode($retorno);
    }
}
