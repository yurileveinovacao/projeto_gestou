<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

$desativa_insert = 0;

// Verifica se o botão de edição foi acionado via POST
if (isset($_POST["btn_add"])) {

    try {
        // Obtém o ID do usuário a partir da sessão usando o token enviado via POST
        $id_usa = $_SESSION["adicionar_usuario"]["tokens"][$_POST["token"]]["id_usa"];

        // Atribuição de id_emps a partir da sessão
        $id_emp = $_SESSION["tabela_empresas"]["id_emp_matriz"];
        $id_emp_filial = $_SESSION["adicionar_filial"]["id_emp_filial"];
        $id_emp_novagrupo = $_SESSION["adicionar_novagrupo"]["id_emp_novagrupo"];
        $tipo_id_emp = $_SESSION["tabela_empresas"]["tipo_id_emp"];

        $id_emp_update = $tipo_id_emp == "FILIAL" ? $id_emp_filial : $id_emp_novagrupo;

        // Verifica se o ID do usuário não está vazio
        if (!empty($id_usa)) {
            // Variáveis para inserção em tabelas vinculadas
            $tabvin1 = "GESEMP";
            $id_tab1 = $id_emp_update;
            $tabvin2 = "GESUSA";
            $id_tab2 = $id_usa;
            $situac = 1;

            if ($desativa_insert == 0) {

                // Insere na tabela de vínculos GESVIN1
                insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2);

                // // Insere na tabela de vínculos GESVIN2
                // insertGESVI2($id_emp_update);

                // Seleciona os menus existentes para o usuário
                $menus = selectGESMPR($id_usa, $id_emp);

                // Insere os menus para o usuário
                foreach ($menus as $linha) {
                    if (!empty($linha)) {
                        $id_mnu = $linha["id_mnu"];
                        insertGESMPR($id_usa, $id_emp_update, $id_mnu, $datatu, $situac);
                    }
                }
            }

            // Define mensagem de sucesso
            $mensagem = 'Usuário adicionado com sucesso!';
            $retorna = array(
                'status' => 'sucesso',
                'mensagem' => $mensagem
            );
        } else {
            // Define mensagem de erro caso não consiga obter o ID do usuário
            $mensagem = 'Ocorreu um erro ao obter o valor da situação da empresa.';
            $retorna = array(
                'status' => 'erro',
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Captura e trata exceções PDO
        $mensagem = $erro->getMessage();
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia a resposta em formato JSON
    echo json_encode($retorna);
}
