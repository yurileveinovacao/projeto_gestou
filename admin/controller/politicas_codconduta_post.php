<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";

if (((isset($_POST["titulo"])) and (isset($_FILES))) and (isset($_POST["btn_submit"]))) {

    try {

        $titulo = mb_strtoupper($_POST["titulo"], 'UTF-8');
        $situac = 1;
        $nomeimg = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $tamanho = $_FILES['file']['size'];
        $tipoimg = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];
        $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

        if (!empty($titulo) and (!empty($tamanho))) {

            foreach (selectGESPOL_id_emp($id_emp_default) as $resultados1) {

                $caminho_banco = $resultados1['anexo'];
                $titulo_banco = $resultados1['nome'];
            }

            //renomear o nome da imagem
            $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . "." . $ext;
            //$novo_nomeimg= 'teste'.'.'.$extensao;

            //Comando para mover o arquivo para a pasta
            $mover = move_uploaded_file($temp, '../../upload/empresa/politicas/' . $novo_nomeimg);

            $insertGESPOL = insertGESPOL($id_emp_default, $titulo, $novo_nomeimg, $situac, $datinc, $datatu, $id_usa_default, $id_usa_default);

            $id_pol = $insertGESPOL['pk'];

            foreach (selectGESUSU_usuario($id_emp_default) as $select_gesusu) {

                if (!empty($select_gesusu)) {

                    $id_usu = $select_gesusu['id_usu'];

                    insertGESPUL($id_usu, $id_pol, $datinc);
                }
            }

            $retorno = 1;
            echo json_encode($retorno);
        } else {

            $retorno = 0;
            echo json_encode($retorno);
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if ((isset($_POST['btn_editar'])) and (isset($_POST['politica_editar']))) {

    try {

        $_SESSION["politica_editar"] = $_POST['politica_editar'];
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (((isset($_POST["titulo_update"])) and (isset($_FILES))) and ((isset($_POST["btn_update"])) and (isset($_POST["politica_update"])))) {

    try {

        $id_pol_update = $_POST["politica_update"];
        $titulo = mb_strtoupper($_POST["titulo_update"], 'UTF-8');
        $nomeimg = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $tamanho = $_FILES['file']['size'];
        $tipoimg = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];
        $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

        if (!empty($titulo) and (!empty($tamanho))) {

            foreach (selectGESPOL($id_pol_update) as $politica_update) {

                $caminho_banco = $politica_update['anexo'];
                $titulo_banco = $politica_update['nome'];

                if (empty($tamanho)) {

                    $novo_nomeimg = $caminho_banco;
                } else {

                    if (empty($titulo)) {

                        $titulo = $titulo_banco;
                    }

                    if (!empty($caminho_banco)) {
                        unlink('../../upload/empresa/politicas/' . $caminho_banco . '');
                    }

                    //renomear o nome da imagem
                    $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . "." . $ext;
                    //$novo_nomeimg= 'teste'.'.'.$extensao;

                    //Comando para mover o arquivo para a pasta
                    $mover = move_uploaded_file($temp, '../../upload/empresa/politicas/' . $novo_nomeimg);
                }

                updateGESPOL_titulo_anexo($id_emp_default, $titulo, $novo_nomeimg, $id_pol_update, $datatu, $id_usa_default);

                unset($_SESSION["politica_editar"]);

                $retorno = 2;
                echo json_encode($retorno);
            }
        } else {

            $retorno = 0;
            echo json_encode($retorno);
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_voltar'])) {

    try {

        unset($_SESSION["politica_editar"]);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if ((isset($_POST["abrir_modal"])) and (isset($_POST["politica"]))) {

    if ($_POST["abrir_modal"] == 1) {

        try {

            $politica = $_POST["politica"];

            foreach (selectGESPOL($politica) as $caminho_view) {

                $caminho_view_arquivo = $caminho_view['anexo'];
            }

            $retorno = '';

            if (empty($caminho_view_arquivo)) {
            } else {

                $retorno .= '<object data="../../upload/empresa/politicas/' . $caminho_view_arquivo . '" type="application/pdf" width="100%" height="100%"></object>';
            }

            //retorno da função
            echo $retorno;
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    }
}

if ((isset($_POST['btn_excluir'])) and (isset($_POST['selecionados']))) {
    try {

        $selecionados = $_POST["selecionados"];

        foreach ($selecionados as $valores) {

            $id_pol = intval($valores);

            foreach (selectGESPOL($id_pol) as $caminho_excluir) {

                $caminho_banco_excluir = $caminho_excluir['anexo'];

                if (!empty($caminho_banco_excluir)) {
                    unlink('../../upload/empresa/politicas/' . $caminho_banco_excluir . '');
                }

                deleteGESPOL($id_pol);
            }
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if ((isset($_POST['btn_situac'])) and (isset($_POST['politica_situac']))) {
    try {

        $id_pol_ativo = $_POST["politica_situac"];

        foreach (selectGESPOL($id_pol_ativo) as $caminho_ativo) {

            $caminho_ativo_situac = $caminho_ativo['situac'];

            if ($caminho_ativo_situac == 0) {

                $situac = 1;

                updateGESPOL_situac($id_emp_default, $situac, $id_pol_ativo, $datatu, $id_usa_default);
            } else {

                $situac = 0;

                updateGESPOL_situac($id_emp_default, $situac, $id_pol_ativo, $datatu, $id_usa_default);
            }
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

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
