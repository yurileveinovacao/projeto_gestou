<?php

require '../../restrito.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

$nomepdf = $_FILES['uploadPDF']['name'];
$temp = $_FILES['uploadPDF']['tmp_name'];
$tamanho = $_FILES['uploadPDF']['size'];
$tipopdf = $_FILES['uploadPDF']['type'];
$erro = $_FILES['uploadPDF']['error'];

$ext = pathinfo($nomepdf, PATHINFO_EXTENSION);
$ext = strtolower($ext);

$origem = $_SESSION['nomepdf'];
$descricao_recibo = $_SESSION['descricao'];
$diretorio = '../../uploads/' . $raiz_cnpj . '.pdf';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Include Composer autoloader if not already done.
include '../../vendor_ler_pdf/autoload.php';
//Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../../uploads/' . $raiz_cnpj . '.pdf');
$text = $pdf->getText();
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONTAGEM REGISTROS PDF

$text = preg_replace('/\d{4}\s\-\d{2}/', '9999-99', $text); //AJUSTE CNPJ PDF

//echo 'Text: '.$text.'<br/>'.'<br/>';

$id_usa = $id_usa_default;
$today = "'" . date('Y-m-d H:i:s') . "'";


$val3 = uniqidReal();
$processamento = $val3;

$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONTAGEM REGISTROS PDF
$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';
$countpages = count_pages($nomearquivo);
//echo 'Contagem Paginas: '.$countpages.'<br /><br />';

$html = $text;
$pattern = '/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i'; //expressao regular cnpj
preg_match($pattern, $html, $match);
if (!empty($match)) {
    $CNPJ = $match[0];
} else {
    $CNPJ = '';
}
$needle = $CNPJ;

//echo '$CNPJ='.$CNPJ.'<br>';
//echo '$cnpj_completo='.$cnpj_completo.'<br>';

$lastPos = 0;
$count = 0;
$positions = [];

if ($CNPJ != $cnpj_completo) { //compara CNPJ ARQUIVO COM CNPJ DEFAULT
    ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
} else {

    if (strlen($html) == 0) {
        ($_SESSION['erro_importação'] = 'Não existem registros no arquivo selecionado!') . (header('Location:' . $erro_1));
    } else {
        while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
            $count = $count + 1;
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $pageNo = 1;
        //echo '$count='.$count.'<br>';
        for ($i = 1; $i <= $count; ++$i) {
            $var = explode('Office', $text)[$i];

            //echo '//---------------------------------------------------------------------------------------------------------------------------------------------------------------' . '</br>';

            if ($i % 2 == 0) {
                // echo 'Numero Par';
            } else {

                //            echo '$var='.$var.'<br>';

                //COMPETENCIA-----------------------------------
                $vcompetenciap1 = strpos($var, 'Recibo'); //Posiçao inicial 
                $vcompetenciap2 = strpos($var, 'Data'); //Posiçao Inicial Data Credito
                $v24_33 = substr($var, $vcompetenciap1, $vcompetenciap2 - $vcompetenciap1);

                $search = 'JUNHO';
                if (preg_match("/{$search}/i", $v24_33)) {
                    $v4_1_0 = strpos($v24_33, 'J');
                    $v4_1 = substr($v24_33, $v4_1_0 - 1);
                }
                $search = 'JULHO';
                if (preg_match("/{$search}/i", $v24_33)) {
                    $v4_1_0 = strpos($v24_33, 'J');
                    $v4_1 = substr($v24_33, $v4_1_0 - 1);
                }

                $v4_2 = strpos($v4_1, $CNPJ);
                $v4_1 = substr($v4_1, 0,  $v4_2);
                $competencia = trim($v4_1);


                //CODIGO INTEGRAÇAO-----------------------------------
                $texto = $var;
                $pattern = '/\d{6}\s/'; //expressao regular [000000 - ]
                preg_match($pattern, $texto, $match);
                //echo $match[0].'<br>';

                $cod_integracao = trim($match[0]);
                //echo '$cod_integracao='.$cod_integracao.'<br>'.'<br>';

                //------------------------------------------------------------------------
                //SELECT PARA VERIFICAR CADASTRO DE USUARIO
                $tabela = 'public."GESUSU"';
                foreach (selectGESUSU_LAYOUT_id_cod($tabela, $cod_integracao, $id_emp_default) as $select_tabela) {
                    $id_usu = $select_tabela['id_usu'];
                    $nome = $select_tabela['nome'];
                    $cargo = $select_tabela['funcao'];
                }

                if (!empty($id_usu)) {
                    //echo 'Leu Página=' . $pageNo . '<br><br>';
                    //-------------------------------------------------------------------------
                    //CRIAR ID_VALIDADOR
                    $val1 = uniqid();
                    $val2 = uniqidReal();
                    $validador = $raiz_cnpj . $val1 . $val2;
                    $validador = $validador;
                    //-------------------------------------------------------------------------
                    $arquivo = $validador . '.pdf';
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    $tabela = 'public."GESIM1_' . $raiz_cnpj . '"';
                    $situac = 1;
                    //-------------------------------------------------------------------------

                    //  echo '$pageNo=========='.$pageNo.'---<br>';
                    //  echo '$tabela==========='.$tabela.'---<br>';
                    //  echo '$id_emp_default==='.$id_emp_default.'---<br>';
                    //  echo '$competencia======'.$competencia.'---<br>';
                    //  echo '$nome============='.$nome.'---<br>';
                    //  echo '$cargo============'.$cargo.'---<br>';
                    //  echo '$situac==========='.$situac.'---<br>';
                    //  echo '$id_usu==========='.$id_usu.'---<br>';
                    //  echo '$datinc==========='.$datinc.'---<br>';
                    //  echo '$id_usa==========='.$id_usa.'---<br>';
                    //  echo '$descricao_recibo='.$descricao_recibo.'---<br>';
                    //  echo '$validador========'.$validador.'---<br>';
                    //  echo '$processamento===='.$processamento.'---<br>';
                    //  echo '$origem==========='.$origem.'---<br>';
                    //  echo '$arquivo=========='.$arquivo.'---<br>';

                    try {
                        $insert_tabela1 = insertGESIM1_arquivo(
                            $tabela,
                            $id_emp_default,
                            $competencia,
                            NULL, //$rg
                            NULL, //$cpf
                            $nome,
                            $cargo,
                            NULL, //$data_credito
                            NULL, //$vlr_vencimento
                            NULL, //$vlr_desconto
                            NULL, //$vlr_liquido
                            NULL, //$faixa_irrf
                            NULL, //$vlr_basesalario
                            NULL, //$vlr_baseinss
                            NULL, //$vlr_basefgts
                            NULL, //$vlr_baseirrf
                            NULL, //$vlr_baseir
                            NULL, //$vlr_fgts
                            $situac,
                            $id_usu,
                            $datinc,
                            $id_usa,
                            $descricao_recibo,
                            $validador,
                            $processamento,
                            $origem, //$origem,
                            $arquivo
                        );

                        $id_im1 = $insert_tabela1['pk'];
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

                    $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');
                }

                $pageNo++; //incrementa numero da pagina

            }

            echo "<script language=javascript>
         location.href = '../../lotes_processados';
         </script>";
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    }
}
function inverteData($data)
{
    $parteData = explode('/', $data);
    $dataInvertida = $parteData[2] . '-' . $parteData[1] . '-' . $parteData[0];

    return $dataInvertida;
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

function count_pages($pdfname)
{
    $pdftext = file_get_contents($pdfname);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

    return $num;
}

function limpar_texto($str)
{
    return preg_replace('/[^0-9]/', '', $str);
}


function mb_strrev($str)
{
    $r = '';
    for ($i = mb_strlen($str); $i >= 0; $i--) {
        $r .= mb_substr($str, $i, 1);
    }
    return $r;
}
