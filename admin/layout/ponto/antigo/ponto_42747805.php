<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

// echo $_SESSION["text_vis"];

$processamento = uniqidReal();
$today = "'".date('Y-m-d H:i:s')."'";
$origem = $_SESSION['nomepdf'];

$cnpj_completo = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj_completo)));

$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

// Atribuição da variavel base
$json_base = json_decode($_SESSION["text_vis"]);




//echo $_SESSION["text_vis"];

// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {
    // echo "Página:" . $key->page . "<br>";

    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;

        // Verifica e identifica o CODEMP, caso enconte numera o registro
        // if (preg_match('/[0-9]{5}/i', $var_text)) {
        //     $nro_registro = $nro_registro + 1;
        // }

        // // If para interpretar somente os registros impares
        // if ($nro_registro % 2 != 0) {
        // } else {

        // Exibição da variavel texto gobal em loop
        //echo "<br>Valores Registro:" . $var_text . "<br>";


        // Identificar CNPJ
        //if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $text)) {
        if (preg_match('/[0-9]{14}/i', $var_text)) {
            $cnpj = $var_text;
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj)));
            $cnpj = preg_replace("/[^0-9]/i", "", $cnpj);
            //echo "<br>CNPJ:" . $cnpj . "<br>";
        }

        // Identificar CPF
        //if (preg_match('/CPF/i', $text)) {
        if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text)) { //expressao regular cpf
            $cpf = $var_text;
            $cpf = preg_replace("/[^0-9]/i", "", $cpf);
            //echo "<br>CPF:" . $cpf . "<br>";
        }

        //Localiza Periodo
        if (strlen($periodo) < 20) {
            if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/i', $var_text)) {
                $encontra_periodo = 1;
            }
        }
        if ($encontra_periodo == 1) {
            $periodo = $periodo . $var_text . " ";
        }
        if (preg_match('/[^0-9]\s[0-9]{2}\/[0-9]{2}\/[0-9]{4}/i', $periodo)) {
            unset($encontra_periodo);
        }

    
    }

    if ($cnpj == $cnpj_completo) {
        // echo "Cnpj ok<br><br>";
        //SELECT PARA VERIFICAR CADASTRO DE USUARIO
        $tabela = 'public."GESUSU"';
        foreach (selectGESUSU_LAYOUT_id_cpf($tabela, $cpf, $id_emp_default) as $select_tabela) {
            $id_usu = $select_tabela['id_usu'];
            $nome = $select_tabela['nome'];
            $cargo = $select_tabela['funcao'];
        }

        if (!empty($id_usu)) {
            //-------------------------------------------------------------------------
            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            //-------------------------------------------------------------------------
            $arquivo = $validador . '.pdf';
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $tabela = 'public."GESPON1_' . $raiz_cnpj . '"';
            $situac = 0;
            //-------------------------------------------------------------------------

            // echo '$page_number======' . $page_number . '---<br>';
            // echo '$cnpj=============' . $cnpj . '---<br>';
            // echo '$tabela===========' . $tabela . '---<br>';
            // echo '$processamento====' . $processamento . '<br>';
            // echo '$validador========' . $validador . '<br>';
            // echo '$id_usu===========' . $id_usu . '<br>';
            // echo '$id_emp_default===' . $id_emp_default . '<br>';
            // echo '$cpf==============' . $cpf . '<br>';
            // echo '$origem===========' . $origem . '---<br>';
            // echo '$periodo==========' . $periodo . '<br>';
            // echo '$arquivo==========' . $arquivo . '---<br>';
            // echo '---------------------------------------------------------------------------------------------------------------<br>';



            try {
                $insert_tabela1 = insertGESPON1_tangerino(
                    $tabela,
                    $id_emp_default,
                    NULL,//PIS
                    $id_usu,
                    $periodo,
                    $today,
                    NULL,//BTOTAL
                    NULL,//BSALDO
                    $processamento,
                    $id_usa,
                    $origem,
                    $arquivo
                );

                $id_pon1 = $insert_tabela1['pk'];
            } catch (PDOException $erro) {
                die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
            }
            // ---------------------------------------------------------------------------------------------------------------------------------------------------------------
            
            // initiate FPDI
            $pdf = new FPDI();
            // add a page
            $pdf->AddPage();
            // set the source file
            $pdf->setSourceFile($nomearquivo);
            // import page 1

            $tplIdx = $pdf->importPage($page_number);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplIdx);

            $pdf->Output('F', '../../../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $validador . '.pdf');

            
        }
    } else {
          ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
    }

    // echo "<br>----------------------------------------------------------<br>";
}

echo "<script language=javascript>
         location.href = '../../lotes_processados';
         </script>";

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

// function count_pages($pdfname)
// {
//     $pdftext = file_get_contents($pdfname);
//     $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

//     return $num;
// }
