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

// AÇÃO PARA MUDAR A SITUAÇÃO
if (isset($_POST['btn_situac'])) {

    try {
        // Recebe as variáveis
        $situac_update = $_POST['btn_situac'];
        $id_usa = $_POST['id_usa'];

        // Formata as Variaveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe as Variáveis
        echo 'Situac: ' . $situac . '<br>';
        echo 'ID Usa: ' . $id_usa . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Master: ' . $id_mas_default . '<br>';
        */

        // Update no Banco - Tabela GESUSA
        updateGESUSA_SITUAC($situac, $id_usa, $datatu, $id_mas_default);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// AÇÃO NO CLICK DO BOTÃO EDITAR
if (isset($_POST['btn_editar'])) {

    // Variável para listar os dados do usuário na página alterar_usuário.php
    $_SESSION['editar_id_usa'] = $_POST['btn_editar'];
}



/**
 * 
 * FUNCTIONS
 * 
 */

function validarValor($case, $valor, $parametro)
{

    switch ($case) {

            // Valida se o valor preenche o requisito minimo de caracteres
        case 'VALID':
            if (!empty($valor)) {
                return strlen($valor) >= $parametro;
            }
            break;

            // Valida se o valor combina com o parametro (regex)
        case 'REGEX':
            if (!empty($valor)) {

                return preg_match($parametro, $valor);
            } else {

                return true;
            }
            break;

            // Valida se o campo preencher os requisitos minimo de caracteres ou se estiver vazio
        default:
            if (!empty($valor)) {

                return strlen($valor) >= $parametro;
            } else {

                return true;
            }
            break;
    }
}

// Formatar valor da Variaveis
function formatarValor($case, $valor)
{

    switch ($case) {

        case 'UPPER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtoupper($valor, 'UTF-8');
            }
            break;

        case 'LOWER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtolower($valor, 'UTF-8');
            }
            break;

        case 'NUM':
            if (empty($valor)) {

                return NULL;
            } else {

                return preg_replace('/\D+/', '', $valor);
            }
            break;

        case 'SITUAC':
            if ($valor == 1) {

                return 0;
            } else {

                return 1;
            }
            break;

        default:
            if (empty($valor) or $valor == 0) {

                return NULL;
            }
    }
}
