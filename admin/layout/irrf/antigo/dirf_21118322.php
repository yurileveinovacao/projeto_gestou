<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

// echo $_SESSION["text_vis"];

$processamento = uniqidReal();
// $descricao_recibo = $_SESSION['descricao'];
$origem = $_SESSION['nomepdf'];

$cnpj_completo = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj_completo)));

$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

// Atribuição da variavel base
$json_base = json_decode($_SESSION["text_vis"]);

// echo $_SESSION["text_vis"];

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
        // echo "<br>Valores Registro:" . $var_text . "<br>";

        // Atribuicao de variavel somente quando o registro for impar
        $text =  $var_text;

        // Identificar CNPJ
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $text)) {
            $cnpj = $text;
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj)));
            // echo "<br>CNPJ:" . $cnpj . "<br>";
        }

        // Identificar CPF
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $text)) {
            $cpf = $text;
            $cpf = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cpf)));
            // echo "<br>CPF:" . $cpf . "<br>";
        }

        // Identificar Exercício de
        if (preg_match('/Exercício\sde\s[0-9]{4}/i', $text)) {
            // $exercicio = $text;
            preg_match('/[0-9]{4}/i', $text, $exercicio);

            $anoexe = $exercicio[0];

            // echo "<br>Exercício de:" . $exercicio[0] . "<br>";
        }

        // Identificar Ano-calendário de
        if (preg_match('/Ano-calendário\sde\s[0-9]{4}/i', $text)) {
            // $exercicio = $text;
            preg_match('/[0-9]{4}/i', $text, $anocalendario);

            $anocal = $anocalendario[0];

            // echo "<br>Ano-calendário de:" . $anocalendario[0] . "<br>";
        }

        // // Identificar competencia
        // if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}\s[a-z A-Z]\s[0-9]{2}\/[0-9]{2}\/[0-9]{4}/i', $text)) {
        //     $competencia = $text;

        //     echo "<br>Competência:" . $competencia . "<br>";
        // }

        // // Identificar código do usuario e nome
        // if (preg_match('/[0-9]{6}\s(\w+\s)+/i', $text)) {

        //     preg_match('/[0-9]{6}/i', $text, $codusu);
        //     // preg_match('/([a-z]+\s)+/i', $text, $nomeusu);

        //     echo "<br>Cód. Usuario:" . $codusu[0] . "<br>";
        //     // echo "<br>Nomeusu:" . $nomeusu[0] . "<br>";

        //     $cod_integracao = $codusu[0];
        // }
        //}
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

        // echo "tabela: " . $tabela . "<br>";
        // echo "cod_integracao: " . $cod_integracao . "<br>";
        // echo "id_emp_default: " . $id_emp_default . "<br>";


        if (!empty($id_usu)) {

            $encontrou_registros = 1;
            $regarq = $regarq + 1;

            //     //echo 'Leu Página=' . $pageNo . '<br><br>';
            //     //-------------------------------------------------------------------------
            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            //-------------------------------------------------------------------------
            $arquivo = $validador . '.pdf';
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';
            $situac = 0;
            //-------------------------------------------------------------------------

            // //  echo '$pageNo=========='.$pageNo.'---<br>';
            // echo '$tabela===========' . $tabela . '---<br>';
            // echo '$id_emp_default===' . $id_emp_default . '---<br>';
            // echo '$competencia======' . $competencia . '---<br>';
            // echo '$nome=============' . $nome . '---<br>';
            // echo '$cargo============' . $cargo . '---<br>';
            // echo '$situac===========' . $situac . '---<br>';
            // echo '$id_usu===========' . $id_usu . '---<br>';
            // echo '$datinc===========' . $datinc . '---<br>';
            // echo '$id_usa===========' . $id_usa . '---<br>';
            // echo '$descricao_recibo=' . $descricao_recibo . '---<br>';
            // echo '$validador========' . $validador . '---<br>';
            // echo '$processamento====' . $processamento . '---<br>';
            // echo '$origem===========' . $origem . '---<br>';
            // echo '$arquivo==========' . $arquivo . '---<br>';

            try {
                $insert_tabela1 = insertGESIRR_arquivo(
                    $tabela,
                    $anoexe,
                    $anocal,
                    $situac,
                    $id_usu,
                    $id_emp_default,
                    $datinc,
                    $processamento,
                    $id_usa_default,
                    $origem,
                    $arquivo
                );

                $id_irr = $insert_tabela1['pk'];
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

            $pdf->Output('F', '../../../upload/beneficios/irrf/' . $raiz_cnpj . '/' . $validador . '.pdf');
        } else {

            $regarq = $regarq + 1;
        }
    } else {
        ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
        // echo "else<br>";
    }

    // echo "<br>----------------------------------------------------------<br>";
}

if ($encontrou_registros == 1) {

    // echo "Total encontrado:" . $regarq;
    updateGES_regarq($tabela, $regarq, $processamento);
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
