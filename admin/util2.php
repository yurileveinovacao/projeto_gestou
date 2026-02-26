<?php

//Faz a requisição da Sessão
require 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'iuds_pdo.php';

$id_usa = $_SESSION['id_usa'];

$sql = 'SELECT  id_emp,tipo,cnpj from public."VW_ADMIN_EMPACESS" where id_emp_default=id_emp and id_usa=' . $id_usa . '';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);

$_SESSION['id_emp_default'] = $linha['id_emp'];
$_SESSION['tipo'] = $linha['tipo'];
$_SESSION['cnpj_completo'] = $linha['cnpj'];

//ATRIBUIÇÃO DE VARIAVEIS BASEADAS NA SESSÃO DO USUÁRIO
$id_emp_default = $_SESSION['id_emp_default'];
$id_usa_default = $_SESSION['id_usa'];

$tipo_empresa = $_SESSION['tipo'];
$cnpj_completo = $_SESSION['cnpj_completo'];

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
$mes = date('m');
//ATRIBUINDO A DATA
$datinc = date('Y-m-d H:i:s');
$datatu = date('Y-m-d H:i:s');

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = 'https://www.gestou.com.br/admin/erro/erro_1'; //erro generico
$erro_3 = 'https://www.gestou.com.br/admin/erro/erro_3'; //erro arquivo anexado

foreach (buscaRaizCNPJ($id_emp_default) as $resultado_raiz) {
    $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
}

$id_usa_situac = $_SESSION['id_usa'];

foreach (selectVW_ADMIN_GACESSO_situac($id_usa_situac) as $situac_usa) {
    if ($situac_usa['situac'] == 0) {
        echo "<script language=javascript>
        alert('Seu usuário está inativo!');
        location.href = 'https://www.gestou.com.br/admin/login';
        </script>";
    }
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
                return strlen(trim($valor)) >= $parametro;
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
            if ((!empty($valor)) or ($valor == 0 and $valor != NULL)) {

                return true;
            }
            break;

            // Valida se as Datas são igauis ou se o valor é maior que o parametro
        case 'COMPARAR_DATA':

            $valorFormat = formatarValor('DATE', $valor);
            $parametroFormat = formatarValor('DATE', $parametro);

            if (strtotime($valorFormat) >= strtotime($parametroFormat)) {

                return true;
            }
            break;

            // Valida se o campo preencher os requisitos minimo de caracteres ou se estiver vazio
        default:
            if (!empty(trim($valor))) {

                return strlen(trim($valor)) >= $parametro;
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
