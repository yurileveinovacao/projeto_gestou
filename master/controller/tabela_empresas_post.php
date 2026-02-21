
<?php
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// if (isset($_REQUEST['de'])) {
//     try {

//         $situac = 0;
//         $id_emp = $_REQUEST["de"];
//         $id_usa_atu = $_SESSION['id_usa'];

//         // echo '$situac : ' .  $situac .'<br>' . '$datatu : ' . $datatu .'<br>' . '$id_usa_atu : ' . $id_usa_atu .'<br>' . '$id_emp : ' . $id_emp ;

//         updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

//         echo "<script language=javascript>
//         location.href = 'tabela_empresas';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

// if (isset($_REQUEST['ha'])) {
//     try {
//         $situac = 1;
//         $id_emp = $_REQUEST["ha"];
//         $id_usa_atu = $_SESSION['id_usa'];

//         // echo '$situac : ' .  $situac .'<br>' . '$datatu : ' . $datatu .'<br>' . '$id_usa_atu : ' . $id_usa_atu .'<br>' . '$id_emp : ' . $id_emp ;

//         updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

//         echo "<script language=javascript>
//         location.href = 'tabela_empresas';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// if (isset($_REQUEST['btn-excluir'])) {
//     try {

//         $id_emp_master;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_emp_master = $id_emp_master . $va . ',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_emp = substr($id_emp_master, 0, -1);
//             $resultArr = explode(',', $id_emp);

//             switch (deleteGESEMP_in($resultArr)) {
//                 case 1: //delete executado
//                     echo "<script language=javascript>
//                     alert('Registro(s) excluido com sucesso!');
//                     location.href='tabela_empresas';
//                     </script>";
//                     break;
//                 case 23503: //erro fk
//                     echo "<script language=javascript>
//                     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
//                     location.href='tabela_empresas';
//                     </script>";
//                     break;
//                 default:
//                     echo "<script language=javascript>
//                     alert('Erro desconhecido, consultar tabela de códigos!');
//                     location.href='tabela_empresas';
//                     </script>";
//             }
//         } else {
//         }
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

$desativa_insert = 0;

// Verifica se o botão de edição foi acionado via POST
if (isset($_POST["btn_edit"])) {

    // Obtém o ID da empresa da sessão com base no token enviado via POST
    $id_emp = $_SESSION["tabela_empresas"]["tokens"][$_POST["token"]]["id_emp"];

    if (!empty($id_emp) or $id_emp == 0) {

        // Define o ID da empresa na sessão para uso posterior na página de visualização de clientes
        $_SESSION["tabela_empresas"]["id_emp_editar"] = $id_emp;

        // Define o status como 'sucesso'
        $status = 'sucesso';

        // Constrói um array de retorno com o status
        $retorna = array(
            'status' => $status
        );
    } else {

        // Define o status como 'erro' quando o ID da empresa está vazio
        $status = 'erro';

        // Constrói um array de retorno com o status
        $retorna = array(
            'status' => $status
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_situac"])) {

    try {
        // Obtém o ID da empresa da sessão com base no token enviado via POST
        $id_emp = $_SESSION["tabela_empresas"]["tokens"][$_POST["token"]]["id_emp"];

        // Verifica se o ID da empresa não está vazio ou é 0 - EMPRESA PADRÃO
        if (!empty($id_emp) or $id_emp == 0) {

            // Verifica se o campo 'situac_status' foi enviado via POST
            if (isset($_POST["situac_status"])) {

                // Obtém o valor de 'situac_status'
                $situac = $_POST["situac_status"];

                // Obtém o valor de 'id_usas'
                $id_usa_atu = $_SESSION['id_usa'];

                // Define a mensagem com base no status da situação
                $situac_msg = $situac ? '<b>Ativada</b>' : '<b>Inativada</b>';

                if ($desativa_insert == 0) {

                    // Atualiza o status da empresa no banco de dados
                    updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);
                }

                // Define o status e a mensagem de sucesso
                $status = "sucesso";
                $mensagem = "A empresa foi " . $situac_msg . " com sucesso.";

                // Constrói um array de retorno com o status e a mensagem
                $retorna = array(
                    'status' => $status,
                    'mensagem' => $mensagem
                );
            } else {
                // Define o status como 'erro' quando não foi possível obter o valor de 'situac_status'
                $status = "erro";
                $mensagem = "Ocorreu um erro ao obter o valor da situação da empresa.";

                // Constrói um array de retorno com o status e a mensagem de erro
                $retorna = array(
                    'status' => $status,
                    'mensagem' => $mensagem
                );
            }
        } else {
            // Define o status como 'erro' quando o ID da empresa está vazio
            $status = 'erro';
            $mensagem = 'Ocorreu um erro ao enviar os dados.';

            // Constrói um array de retorno com o status e a mensagem de erro
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Em caso de exceção PDO, captura a mensagem de erro
        $mensagem = $erro->getMessage();

        // Define o status como 'erro' e a mensagem de erro
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_grupo"])) {

    try {
        // Obtém o ID da empresa da sessão com base no token enviado via POST
        $id_emp = $_SESSION["tabela_empresas"]["tokens"][$_POST["token"][0]]["id_emp"];
        $_SESSION["tabela_empresas"]["tipo_id_emp"] = "NOVAGRUPO";

        // Verifica se o ID da empresa não está vazio ou é 0 - EMPRESA PADRÃO
        if (!empty($id_emp) or $id_emp == 0) {

            // Itera sobre os resultados da consulta da função select_VIEW_FCFO_APROVAR_codcfo
            foreach (selectGESEMP_TIPO($id_emp) as $linha) {

                $tipo = $linha['tipo'];
            }

            switch ($tipo) {

                case "M":

                    // Define o ID da empresa na sessão para uso posterior na página de visualização de clientes
                    $_SESSION["tabela_empresas"]["id_emp_matriz"] = $id_emp;

                    // Em caso de exceção PDO, captura a mensagem de erro
                    $mensagem = 'Não é possível adicionar uma empresa no grupo a partir de outra filial.';

                    // Define o status como 'erro' e a mensagem de erro
                    $retorna = array(
                        'status' => 'sucesso'
                    );

                    break;

                default:

                    // Em caso de exceção PDO, captura a mensagem de erro
                    $mensagem = 'Não é possível adicionar uma empresa no grupo a partir de outra filial.';

                    // Define o status como 'erro' e a mensagem de erro
                    $retorna = array(
                        'status' => 'erro',
                        'mensagem' => $mensagem
                    );

                    break;
            }
        } else {
            // Define o status como 'erro' quando o ID da empresa está vazio
            $status = 'erro';
            $mensagem = 'Ocorreu um erro ao enviar os dados.';

            // Constrói um array de retorno com o status e a mensagem de erro
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Em caso de exceção PDO, captura a mensagem de erro
        $mensagem = $erro->getMessage();

        // Define o status como 'erro' e a mensagem de erro
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_filial"])) {

    try {
        // Obtém o ID da empresa da sessão com base no token enviado via POST
        $id_emp = $_SESSION["tabela_empresas"]["tokens"][$_POST["token"][0]]["id_emp"];
        $_SESSION["tabela_empresas"]["tipo_id_emp"] = "FILIAL";

        // Verifica se o ID da empresa não está vazio ou é 0 - EMPRESA PADRÃO
        if (!empty($id_emp) or $id_emp == 0) {

            // Itera sobre os resultados da consulta da função select_VIEW_FCFO_APROVAR_codcfo
            foreach (selectGESEMP_TIPO($id_emp) as $linha) {

                $tipo = $linha['tipo'];
            }

            switch ($tipo) {

                case "M":

                    // Define o ID da empresa na sessão para uso posterior na página de visualização de clientes
                    $_SESSION["tabela_empresas"]["id_emp_matriz"] = $id_emp;

                    // Em caso de exceção PDO, captura a mensagem de erro
                    $mensagem = 'Não é possível adicionar uma filial a partir de outra filial.';

                    // Define o status como 'erro' e a mensagem de erro
                    $retorna = array(
                        'status' => 'sucesso'
                    );

                    break;

                default:

                    // Em caso de exceção PDO, captura a mensagem de erro
                    $mensagem = 'Não é possível adicionar uma filial a partir de outra filial.';

                    // Define o status como 'erro' e a mensagem de erro
                    $retorna = array(
                        'status' => 'erro',
                        'mensagem' => $mensagem
                    );

                    break;
            }
        } else {
            // Define o status como 'erro' quando o ID da empresa está vazio
            $status = 'erro';
            $mensagem = 'Ocorreu um erro ao enviar os dados.';

            // Constrói um array de retorno com o status e a mensagem de erro
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Em caso de exceção PDO, captura a mensagem de erro
        $mensagem = $erro->getMessage();

        // Define o status como 'erro' e a mensagem de erro
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

?>