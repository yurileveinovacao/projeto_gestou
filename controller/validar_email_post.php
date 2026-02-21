<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

// Coleta o valor do token, consulta e realiza o update na base
if (isset($_POST["parametro"])) {

    // Atribuição do token a variavel
    $parametro = $_POST["parametro"];

    // Itera sobre o resultado da função selectGESUSA($parametro) e atribui cada elemento à variável $select_token
    foreach (selectGESUSA($parametro) as $select_token) {

        // Verifica se $select_token não está vazio
        if (!empty($select_token)) {

            // Atribui o valor do campo "id_usa" de $select_token à variável $id_usa
            $id_usa = $select_token["id_usa"];
            $id_emp_acess = $select_token["id_emp_acess"];

            // Chama a função updateGESEMP passando o valor de $id_emp_acess como parâmetro
            updateGESEMP($id_emp_acess);

            // Chama a função updateGESUSA passando o valor de $id_usa como parâmetro
            updateGESUSA($id_usa);
        }
    }

    $retorno = '';

    if (!empty($id_usa)) {

        $retorno .= '<h1>O e-mail foi validado e sua empresa está apta a utilizar o <span class="fonte-texto-gestou">GESTOU</span></h1>';
        $retorno .= '<h2>Obrigado por validar o e-mail.</h2>';
        $retorno .= '<a href="https://www.gestou.com.br/admin/login"><button type="button" id="login" name="login" style="border: none;" class="text-center text-lg-start btn-get-started"><span class="fonte-texto-gestou" style="font-size: x-large;">LOGIN</span></button></a>';
    } else {

        $retorno .= '<h1>Não é possível validar o e-mail, o token expirou ou não existe!</h1>';
        $retorno .= '<h2>Entre em contato com o <span class="fonte-texto-gestou">SUPORTE</span> para gerar um novo link.</h2>';
        $retorno .= '<a href="https://www.gestou.com.br/admin/login"><button type="button" id="login" name="login" style="border: none;" class="text-center text-lg-start btn-get-started"><span class="fonte-texto-gestou" style="font-size: x-large;">LOGIN</span></button></a>';
    }

    echo $retorno;
}
