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
// FILTRO
if (isset($_POST['btn_filtrar'])) {

    try {

        $_SESSION['lotes_filtro_situac'] = $_POST['tipo'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}