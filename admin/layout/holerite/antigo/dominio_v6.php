<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

$contagem_cpf = 0;
$desativa_insert = 1; //0 ativa - 1 desativa
$exibe_var_text = 0; //0 nao exibe - 1 exibe 
$exibe_registros = 0; //0 nao exibe - 1 exibe

// Variavel que recebe a descricao da importacao
$descricao_recibo = $_SESSION['descricao'];

// Variavel que recebe o nome do PDF
$origem = $_SESSION['nomepdf'];

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

// Variavel CNPJ completo com replace (somente numeros)
$cnpj_completo = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj_completo)));

// Variavel que cria o id_processamento
$processamento = uniqidReal();

// Variavel que recebe o arquivo e seu caminho
$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

// Atribuição da variavel base
//$json_base = json_decode($_SESSION["text_vis"]);


// Converte o JSON em um objeto PHP
$json_base = json_decode($_SESSION["text_vis"]);

// Converte o JSON em um array associativo
$data = json_decode($_SESSION["text_vis"], true);

// foreach ($data["analyzeResult"]["readResults"][0]["lines"] as $line) {
//     echo $line["text"] . "<br>";
// }


// foreach ($data["analyzeResult"]["readResults"][0]["lines"] as $line) {
//     echo "Texto: " . $line["text"] . "<br>";
//     foreach ($line as $key => $value) {
//         echo "Chave: " . $key . ", Valor: " . $value . "<br>";
//     }
//     echo "<br>";
// }



// foreach ($json_base->analyzeResult->readResults as $key) {
//     // Foreach para realizar o loop do conteudo de cada pagina
//     foreach ($key->lines as $key2) {
//         // Atribuição de variavel texto global
//         $var_text = $key2->text;
//         // Exibição da variavel texto gobal em loop
//         echo "<br>Valores Registro:" . $var_text . "<br>";
//     }
// }


// Variáveis para armazenar os dados desejados
$cnpj = '';
$funcionario = '';
$nome = '';
$mes = '';
$ano = '';
$valor_liquido = '';

// Itera sobre as linhas do recibo de pagamento
foreach ($data["analyzeResult"]["readResults"][0]["lines"] as $line) {
    $text = $line["text"];

    // Verifica se o texto contém o CNPJ
    if (preg_match('/\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}/', $text, $matches)) {
        $cnpj = $matches[0];
    }

    // Verifica se o texto contém o código do funcionário
    if (preg_match('/^\d{2}$/', $text)) {
        $funcionario = $text;
    }

    // Verifica se o texto contém o nome do funcionário
    if (preg_match('/^[A-Z\s]+$/i', $text)) {
        $nome = $text;
    }

    // Verifica se o texto contém o mês e ano do pagamento
    if (preg_match('/\b(?:JAN|FEV|MAR|ABR|MAI|JUN|JUL|AGO|SET|OUT|NOV|DEZ)\b.*\d{4}\b/', $text)) {
        $mes_ano = explode(' ', $text);
        $mes = $mes_ano[0];
        $ano = $mes_ano[1];
    }

    // Verifica se o texto contém o valor líquido do pagamento
    if (strpos($text, 'Valor Líquido') !== false) {
        $valor_liquido = trim(str_replace('Valor Líquido', '', $text));
    }
}

// Imprime os dados separados
echo "CNPJ: " . $cnpj . "<br>";
echo "Funcionário: " . $funcionario . "<br>";
echo "Nome: " . $nome . "<br>";
echo "Mês: " . $mes . "<br>";
echo "Ano: " . $ano . "<br>";
echo "Valor Líquido: " . $valor_liquido . "<br>";



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

function FormatToDecimal($string)
{
    //$valor = number_format(str_replace(",", ".", str_replace(".", "", $string)), 2, ".", ""); // CAUSOU PROBLEMA COM REGIONAIS DAS MAQUINAS
    $valor = str_replace(",", ".", str_replace(".", "", $string));
    return $valor;
}
