<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";


/**
 * 
 * Funções no Click
 * 
 */

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS 
if ((isset($_POST["linkdirect"])) && (isset($_POST["codigo_rel"]))) {

    // VÁRIAVEL PARA ALIMENTAR A PÁGINA DE RELATÓRIOS
    $_SESSION["codigo_rel"] = $_POST["codigo_rel"];
}

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS 
if (isset($_POST["situac_filtro"])) {

    // VÁRIAVEL PARA ALIMENTAR A PÁGINA DE RELATÓRIOS
    $_SESSION["situac_filtro"] = $_POST["situac_filtro"];
}

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS 
if (isset($_POST["unset_situac_filtro"])) {

    // UNSET DA VARIÁVEL
    unset($_SESSION["situac_filtro"]);
}

// POST REALIZADO PARA LIMPAR A VÁRIAVEL DE SESSÃO
if (isset($_POST["unset_codigo_rel"])) {

    // UNSET DA VARIÁVEL
    unset($_SESSION["codigo_rel"]);
}
