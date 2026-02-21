<?php 

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

if (isset($_POST['id_eve_excluir'])) {
    try {

        $id_eve = $_POST['id_eve_excluir'];

        switch (deleteGESEVE_in($id_eve)) {
            case 1: //delete executado

                $retorno = 1;

                echo $retorno;

                break;
            case 23503: //erro fk

                $retorno = 2;

                echo $retorno;

                break;
            default:

            $retorno = 3;

                echo $retorno;

        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>