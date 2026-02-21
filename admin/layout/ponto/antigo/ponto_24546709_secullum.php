<?php

require '../../restrito.php';
require_once '../vendor_fpdi/autoload.php';
require_once '../../util.php';

use setasign\Fpdi\Fpdi;

$id_emp_default = $_SESSION['id_emp_default'];

$processamento = uniqidReal();
$today = "'" . date('Y-m-d H:i:s') . "'";
$id_usa = $_SESSION['id_usa'];


$origem = $_SESSION['nomepdf'];


//Nome arquivo
$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';
$countpages = count_pages($nomearquivo);
//echo 'Paginas='.$countpages.'<br>';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Include Composer autoloader if not already done.
include '../../vendor_ler_pdf/autoload.php';
//Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../../uploads/' . $raiz_cnpj . '.pdf');
$text = $pdf->getText();
//echo $text.'<br>';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------CNPJ
$texto1 = $text;
$pattern1 = '/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i'; //expressao regular cnpj
preg_match_all($pattern1, $texto1, $matches1);
if (!empty($matches1)) {
    foreach ($matches1[0] as $match1) {
        // echo 'CNPJ='.$match1.'<br>';
    }
}
//----------------------------------------------------CPF
// $texto2 = $text;
// $pattern2 = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i'; //expressao regular cpf
// preg_match_all($pattern2, $texto2, $matches2);
// if (!empty($matches2)) {
//     foreach ($matches2[0] as $match2) {
//          // echo 'CPF='.$match2.'<br>';
//     }
// }
//----------------------------------------------------PIS
$texto2 = $text;
$pattern2 = '/[0-9]{11}/i'; //expressao regular PIS
preg_match_all($pattern2, $texto2, $matches2);
if (!empty($matches2)) {
    foreach ($matches2[0] as $match2) {
        // echo 'PIS='.$match2.'<br>';
    }
}


$c = array_merge($matches1, $matches2);

//----------------------------------------------------PERIODO

$pos = strpos($text, 'DE');
$v24 = $pos; //INICIO
$v24_1 = substr($text, $v24 + 3, 26);
$v24_4 = rtrim(ltrim($v24_1));
$periodo = $v24_4;

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

for ($pageNo = 1; $pageNo <= $countpages; ++$pageNo) {
    //-----------------------------------------------------
    if (substr(str_replace('.', '', $c[0][$pageNo - 1]), 0, 8) == $raiz_cnpj) {

        $pis = $c[1][$pageNo - 1];
        $cpf = 99999999999;

        //SELECT PARA VERIFICAR CADASTRO DE USUARIO
        $tabela4 = 'public."GESUSU"';
        foreach (selectGESUSU_LAYOUT_id_cpf_rg_pis($tabela4, $id_emp_default, $cpf, $rg, $pis) as $select_tabela4) {
            $id_usu = $select_tabela4['id_usu'];
            $pis = $select_tabela4['pis'];
        }

        //-------------------------------------------------------------------------
        //CRIAR ID_VALIDADOR
        $val1 = uniqid();
        $val2 = uniqidReal();
        $validador = $raiz_cnpj . $val1 . $val2;
        $validador = $validador;
        //-------------------------------------------------------------------------

        // echo '$processamento='.$processamento.'<br>';
        // echo '$validador='.$validador.'<br>';
        // echo '$id_usu='.$id_usu.'<br>';
        // echo '$id_emp_default='.$id_emp_default.'<br>';
        // echo '$pis='.$pis.'<br>';
        // echo '$origem='.$origem.'<br>';
        // echo '$periodo='.$periodo.'<br>';
        // echo '$text='.$text.'<br>';


        $arquivo = $validador . '.pdf';
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $tabela1 = 'public."GESPON1_' . $raiz_cnpj . '"';
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

        try {
            $insert_tabela1 = insertGESPON1_tangerino(
                $tabela1,
                $id_emp_default,
                $pis, //PIS
                $id_usu,
                $periodo,
                $today,
                NULL, //BTOTAL
                NULL, //BSALDO
                $processamento,
                $id_usa,
                $origem,
                $arquivo
            );

            $id_pon1 = $insert_tabela1['pk'];
        } catch (PDOException $erro) {
            die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

        // initiate FPDI
        $pdf = new FPDI();
        // add a page
        $pdf->AddPage();
        // set the source file
        $pdf->setSourceFile($nomearquivo);
        // import page 1
        $tplIdx = $pdf->importPage($pageNo);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx);

        $pdf->Output('F', '../../../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $validador . '.pdf');
    }
}


echo "<script language=javascript>
location.href = '../../lotes_processados';
</script>";


function count_pages($pdfname)
{
    $pdftext = file_get_contents($pdfname);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

    return $num;
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

function isPIS($pis)
{
    $pis = preg_replace('/[^0-9]/', '', $pis);
    $digito = 0;
    for ($i = 0, $x = 3; $i <= 10; $i++, $x--) {
        $x = ($x < 2) ? 9 : $x;
        $digito += $pis[$i] * $x;
    }
    $calculo = (($digito % 11) < 2) ? 0 : 11 - ($digito % 11);
    if ($calculo <>  $pis[10]) {
        return false;
    }
    return true;
}
