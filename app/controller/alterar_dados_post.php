<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_app.php";

require_once '../util.php';

require '../restrito.php';

/**
 * 
 * Funções no Click
 * 
 */
if (isset($_POST['btn_submit'])) {

    // Validar os valores recebidos do formulário
    $emailValido = validarValor('REGEX', $_POST['email'], '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
    $telefoneValido = validarValor('*', $_POST['telefone'], 16);
    $celularValido = validarValor('*', $_POST['celular'], 16);
    $numeroValido = validarValor('*', $_POST['numero'], 1);
    $enderecoValido = validarValor('*', $_POST['endereco'], 3);
    $bairroValido = validarValor('*', $_POST['bairro'], 3);
    $complementoValido = validarValor('*', $_POST['complemento'], 3);
    $cidadeValido = validarValor('REQUIRED', $_POST['endereco'], 1);
    $cepValido = validarValor('VALID', $_POST['cep'], 9);

    // Verificar se todos os valores são válidos
    if ($emailValido && $telefoneValido && $celularValido && $enderecoValido && $numeroValido && $bairroValido && $complementoValido && $cidadeValido && $cepValido) {

        try {
            // Atribuir os valores recebidos a variáveis
            $email_update = $_POST['email'];
            $telefone_update = $_POST['telefone'];
            $celular_update = $_POST['celular'];
            $endereco_update = $_POST['endereco'];
            $numero_update = $_POST['numero'];
            $bairro_update = $_POST['bairro'];
            $complemento_update = $_POST['complemento'];
            $cidade_update = $_POST['cidade'];
            $cep_update = $_POST['cep'];

            // Formatar os valores atribuídos
            $email = formatarValor('LOWER', $email_update);
            $telefone = formatarValor('NUM', $telefone_update);
            $celular = formatarValor('NUM', $celular_update);
            $endereco = formatarValor('UPPER', $endereco_update);
            $numero = formatarValor('UPPER', $numero_update);
            $bairro = formatarValor('UPPER', $bairro_update);
            $complemento = formatarValor('UPPER', $complemento_update);
            $cidade = formatarValor('*', $cidade_update);
            $cep = formatarValor("NUM", $cep_update);

            /*
            // Exibir os valores recebidos e formatados
            echo 'Email: ' . $email_update . '<br>';
            echo 'Email Formatado: ' . $email . '<br>';
            echo 'Telefone: ' . $telefone_update . '<br>';
            echo 'Telefone Formatado: ' . $telefone . '<br>';
            echo 'Celular: ' . $celular_update . '<br>';
            echo 'Celular Formatado: ' . $celular . '<br>';
            echo 'Endereço: ' . $endereco_update . '<br>';
            echo 'Endereço Formatado: ' . $endereco . '<br>';
            echo 'Bairro: ' . $bairro_update . '<br>';
            echo 'Bairro Formatado: ' . $bairro . '<br>';
            echo 'Complemento: ' . $complemento_update . '<br>';
            echo 'Complemento Formatado: ' . $complemento . '<br>';
            echo 'Cidade: ' . $cidade_update . '<br>';
            echo 'Cidade Formatado: ' . $cidade . '<br>';
            echo 'CEP: ' . $cep_update . '<br>';
            echo 'CEP Formatado: ' . $cep . '<br>';
            */

            // Chamar a função para atualizar os dados no banco de dados
            updateGESUSU(
                $id_usu_default,
                $email,
                $telefone,
                $celular,
                $endereco,
                $numero,
                $bairro,
                $complemento,
                $cidade,
                $cep
            );

            // Sucesso
            echo 1;
        } catch (PDOException $erro) {

            // Exibir mensagem de erro do banco de dados
            echo $erro->getMessage();
        }
    } else {

        // Pelo menos um valor não é válido
        echo 0;
    }
}
