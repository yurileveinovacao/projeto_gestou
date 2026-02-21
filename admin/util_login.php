<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once 'conexao_pdo.php';

//SELECT VW_ADMIN_GACESSO - revisado em 22/01/2022 09:14
function selectVW_ADMIN_GACESSO($email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_ADMIN_GACESSO" WHERE email=:email and analise<>1 and situac = 1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

/**
 * 
 * Funções de POST
 * 
 */

//  Valida o valor
function validarValor($case, $valor, $parametro)
{

    switch ($case) {

            // Valida se o valor preenche o requisito minimo de caracteres
        case 'VALID':
            if (!empty(trim($valor))) {
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

            // Valida se o valor combina com o parametro (regex)
        case 'REGEX_REQUIRED':
            if (!empty($valor)) {

                return preg_match($parametro, $valor);
            }
            break;

            // Valida se o valor não estiver vazio ou for igual a 0
        case 'REQUIRED':
            if (!empty($valor) or $valor == 0) {

                return true;
            }
            break;

            // Valida se Valor é igual Parametro
        case 'COMPARAR_DATA':

            $valorFormat = formatarValor('DATE', $valor);
            $parametroFormat = formatarValor('DATE', $parametro);

            if (strtotime($valorFormat) >= strtotime($parametroFormat)) {

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


// Formata o valor 
function formatarValor($campo, $valor)
{

    // Case verificando o valor do campo da Função
    switch ($campo) {

            // Formatação somente numeros
        case "NUM";

            if (!empty($valor)) {

                return preg_replace('/\D+/', '', $valor);
            } else {

                return NULL;
            }

            break;

            // Formatação data padrao Banco de dados
        case "DATE";

            if (!empty($valor)) {

                return implode('-', array_reverse(explode('/', $valor)));
            } else {

                return NULL;
            }

            break;

            // Formatação caracteres maiusculos
        case "UPPER";

            if (!empty($valor)) {

                return mb_strtoupper($valor, 'UTF-8');
            } else {

                return NULL;
            }

            break;

            // Formatação caracteres minusculos
        case "LOWER";

            if (!empty($valor)) {

                return mb_strtolower($valor, 'UTF-8');
            } else {

                return NULL;
            }

            break;

            // Formatação checkbox não preenchido
        case "CHECKBOX";

            if ($valor == "false") {

                return 0;
            } else {

                return 1;
            }

            break;

            // Formatação situação ATIVO/INATIVO
        case 'SITUAC':
            if ($valor == 1) {

                return 0;
            } else {

                return 1;
            }
            break;

            // Formatação dinheiro
        case "VALOR_DECIMAL";

            if (!empty($valor)) {

                $valorSemMoeda = preg_replace('/[^\d\,]/', '', $valor);
                return str_replace(',', ".", $valorSemMoeda);
            } else {

                return NULL;
            }

            break;

            // Formatação padrao post
        default:

            if ((!empty($valor)) or ($valor == 0)) {

                return $valor;
            } else {

                return NULL;
            }

            break;
    }
}
