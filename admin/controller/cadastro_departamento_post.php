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

// AÇÃO NO BOTÃO SALVAR
if (isset($_POST['btn_submit'])) {

    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);

    if ($nomeValido) {

        try {
            // Atribui valor as Variáveis
            $nome_update = $_POST['nome_update'];
            $situac = 1;

            // Formata as Variáveis
            $nome = formatarValor('UPPER', $nome_update);

            /*
            // Exibe as Variáveis
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            echo 'Nome: ' . $nome . '<br>';
            echo 'Situação: ' . $situac . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa Inc: ' . $id_usa_default . '<br>';
            echo 'ID Usa Atu: ' . $id_usa_default . '<br>';
            */

            // Executa Comandos no Banco
            // INSERT Tabela GESDEP
            insertGESDEP(
                $id_emp_default,
                $nome,
                $situac,
                $datinc,
                $datatu,
                $id_usa_default,
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
            break;
    }
}
