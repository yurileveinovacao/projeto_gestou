<?php

//Faz o START da Sessão
session_start();

require_once __DIR__.'/../config/database.php';
require_once 'iuds_app.php';

$id_usu = $_SESSION['id_usu_app'];

foreach (VW_APP_EMPACESS($id_usu) as $linha) {
    $_SESSION['id_emp_default_app'] = $linha['id_emp'];

    $_SESSION['id_emp_default_h_app'] = $linha['id_emp_h'];
    $_SESSION['id_emp_default_p_app'] = $linha['id_emp_p'];
    $_SESSION['id_emp_default_i_app'] = $linha['id_emp_i'];
    $_SESSION["nome_usuario_default"] = $linha["nome_usuario"];
    $_SESSION["id_dep_default"] = $linha["id_dep"];
    $_SESSION["agrdep_default"] = $linha["agrdep"];
    $_SESSION["bloqueado_default"] = $linha["bloqueado"];
    $_SESSION["situac_default"] = $linha["situac"];
}

//ATRIBUIÇÃO DE VARIAVEIS BASEADAS NA SESSÃO DO USUÁRIO
$id_emp_default = $_SESSION['id_emp_default_app'];
$id_usu_default = $_SESSION['id_usu_app'];
$nome_usuario_default = $_SESSION['nome_usuario_default'];
$id_dep_default = $_SESSION['id_dep_default'];
$agrdep_default = $_SESSION['agrdep_default'];
$bloqueado_default = $_SESSION['bloqueado_default'];
$situac_default = $_SESSION['situac_default'];

$id_emp_h_default = $_SESSION['id_emp_default_h_app'];
$id_emp_p_default = $_SESSION['id_emp_default_p_app'];
$id_emp_i_default = $_SESSION['id_emp_default_i_app'];

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
//ATRIBUINDO A DATA
$datinc = date('Y-m-d H:i:s');
$datatu = date('Y-m-d H:i:s');

foreach (buscaRaizCNPJ($id_emp_default) as $resultado_raiz) {
    $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
}

//IP DA REDE

$ip = $_SERVER['REMOTE_ADDR'];

// function uniqidReal($lenght)
// {
//     // uniqid gives 13 chars, but you could adjust it to your needs.
//     if (function_exists('random_bytes')) {
//         $bytes = random_bytes(ceil($lenght / 2));
//     } elseif (function_exists('openssl_random_pseudo_bytes')) {
//         $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
//     } else {
//         throw new Exception('no cryptographically secure random function available');
//     }

//     return substr(bin2hex($bytes), 0, $lenght);

//     //chamar funçao uniqid() e uniqidReal()
// //echo uniqid(), uniqidReal(), PHP_EOL;
// }


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
