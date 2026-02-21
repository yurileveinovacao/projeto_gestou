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
// SUBMIT
if (isset($_POST['btn_submit'])) {

    $nomeValido = validarValor('VALID', $_POST['funcionario'], 1);
    $descricaoValido = validarValor('VALID', $_POST['descricao'], 3);
    $anexoValido = validarValor('VALID', $_FILES['file']['size'], 1);

    if ($nomeValido && $descricaoValido && $anexoValido) {

        try {

            // Atribui as Variáveis
            $id_usu = $_POST['funcionario'];
            $descricao_update = $_POST['descricao'];
            $anexo_size = $_FILES['file']['size'];
            $anexo_nome = $_FILES['file']['name'];
            $anexo_temp_name = $_FILES['file']['tmp_name'];
            $anexo_type = $_FILES['file']['type'];
            $anexo_erro = $_FILES['file']['error'];

            // Formata Variáveis
            $descricao = formatarValor('UPPER', $descricao_update);
            $ext = pathinfo($anexo_nome, PATHINFO_EXTENSION);

            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;

            $origem = $anexo_nome;

            $id_processamento = uniqidReal();

            //renomear o nome da imagem
            $novo_anexo_nome = $raiz_cnpj . '_' . $id_processamento . '_recibodiversos.' . $ext;

            /*
            // Exibe Variáveis
            echo 'ID Usu: ' . $id_usu . '<br>';
            echo 'Descrição: ' . $descricao . '<br>';
            echo 'Anexo Size: ' . $anexo_size . '<br>';
            echo 'Anexo Nome: ' . $anexo_nome . '<br>';
            echo 'Anexo Extensão: ' . $ext . '<br>';
            echo 'Anexo Temp Nome: ' . $anexo_temp_name . '<br>';
            echo 'Anexo Tipo: ' . $anexo_type . '<br>';
            echo 'Anexo Erro: ' . $anexo_erro . '<br>';
            echo 'Validador: ' . $validador . '<br>';
            echo 'ID Processamento: ' . $id_processamento . '<br>';
            echo 'Novo Nome Anexo: ' . $novo_anexo_nome . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            */

            if ($anexo_size > 100000000) {

                echo 2;
                exit;
            }

            if (file_exists('../../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '')) {

                //Comando para mover o arquivo para a pasta
                $mover = move_uploaded_file($anexo_temp_name, '../../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $novo_anexo_nome);
            } else {

                mkdir('../../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/', 0777, true);

                //Comando para mover o arquivo para a pasta
                $mover = move_uploaded_file($anexo_temp_name, '../../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $novo_anexo_nome);
            }

            // Executa Comandos no Banco
            // INSERT Tabela GESREC
            insertGESREC(
                $raiz_cnpj,
                $id_emp_default,
                $id_usu,
                $origem,
                $novo_anexo_nome,
                $id_processamento,
                $validador,
                $descricao,
                $datinc,
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






/**
 * 
 * 
 * FUNÇÃO
 * 
 */
function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists('random_bytes')) {

        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {

        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {

        throw new Exception('no cryptographically secure random function available');
    }

    return substr(bin2hex($bytes), 0, $lenght);
}
