<?php

require '../restrito.php';
require_once __DIR__.'/../../../config/database.php';
require_once '../util.php';

$id_emp_default = $_SESSION['id_emp_default'];
$today = date('Y-m-d H:i:s');
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = $_SESSION['descricao'];
$val3 = uniqidReal();
$processamento = $val3;
$origem = $_SESSION['nomepdf'];

//ERRO
$erro_1 = '../erro/erro_1'; //erro generico
$erro_3 = '../erro/erro_3'; //erro arquivo anexado

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO.pdf
foreach (select_id_emp_Layout($id_emp_default) as $select_cnpj) {

    $bd_cnpj = $select_cnpj['cnpj'];
}
//RECUPERANDO RAIZ CNPJ
$busca_cnpj = $bd_cnpj;
$raiz1 = str_replace('.', '', $bd_cnpj);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Inclua o autoloader do Composer se ainda não tiver feito isso.
include '../vendor_ler_pdf/autoload.php';
//Analise o arquivo pdf e construa os objetos necessários.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../uploads/' . $raiz4 . '.pdf');
$text = $pdf->getText();
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONTAGEM REGISTROS PDF

$text = preg_replace('/\s/', ' ', $text);

$html = $text;
$needle = substr($text, 0, 30);
$lastPos = 0;
$count = 0;
$positions = [];
//  Ativa Echo quando = 1
$showEcho = 0;
// Ativa Banco de Dados quando = 1
$showBD = 1;

while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
    $positions[] = $lastPos;
    $lastPos = $lastPos + strlen($needle);
    $count = $count + 1;
}

//echo 'Text: '.$text.'<br /><br />';
//echo 'Contagem: '.$count.'<br /><br />';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// $empresa = '';
// $competencia = '';
$regrex = 'DADOS DO EMPREGADOR ';

//echo '$needle='.$needle.'<br>';

for ($ix = 1; $ix <= $count; ++$ix) :
    $var = explode($needle, $text)[$ix];

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //verificar CNPJ na variavel
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    $pos = strpos($var, $busca_cnpj);

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    // echo '<br>var=='.$var.'<br>';
    // echo '<br>pos=='.$pos.'<br>';
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------

    if ($pos === false) {
        // echo '<br>Não encontrado';
    } else {
        // echo '<br>Encontrado';

        if ($showEcho == 1) {
            echo '<br<br>var----' . $var . '<br><br><br>';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //-----------------------------------------------------INICIO CNPJ
        $pos1 = substr($var, $pos);
        // echo '<br<br>pos1----'.$pos1;
        $cnpj = substr($pos1, 0, 18);
        $hor_seg = substr($pos1, 19, 24);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //----------------------------------------------------PERIODO
        $v24 = $pos + 19; //INICIO
        $v24_1 = substr($var, $v24 + 2, 12);
        $v24_4 = rtrim(ltrim($v24_1));

        $v244 = strpos($var, 'Folha');
        $v24_2 = substr($var, $v244 - 12, 12); //FINAL

        //$v24_2 = substr($var, $v24 + 16, 12); //FINAL
        $v24_3 = rtrim(ltrim($v24_2));
        $v24_4 = $v24_4 . ' ATÉ ' . $v24_3;

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //----------------------------------------------------CPF
        $v4 = strpos($var, 'CPF:');
        $v4_1_2 = substr($var, $v4 + 5, 19);
        $texto = $v4_1_2;
        $pattern = '/[0-9]{11}/i'; //expressao regular CPF
        preg_match($pattern, $texto, $match);
        if (!empty($match)) {
            $vcpf = $match[0];
        } else {
            $vcpf = '';
        }
        /*
     //----------------------------------------------------PIS
     $v4 = strpos($var, $busca_cnpj);
     $v4_1_2 = substr($var, $v4 + 18, 200);
     $texto = $v4_1_2;
     $pattern = '/[0-9]{11}/i'; //expressao regular pis
     preg_match($pattern, $texto, $match);
     if (!empty($match)) {
         $vpis = $match[0];
     } else {
         $vpis = '';
     }
    */
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //-------ABONO
        $v56 = strpos($var, 'Itinere:');
        $v56_1_2 = substr($var, $v56 + 40, 20);
        $v56_1_2 = preg_replace("/\s/", '|', ($v56_1_2));
        $v56_1_2 = str_replace('|||||', '|', $v56_1_2);
        $v56_1_2 = str_replace('||', '|', $v56_1_2);

        $parte = explode('|', $v56_1_2);
        if (strlen($parte[1]) != 0) {
            $vabono = $parte[1];
        }
        //-----------------
        //-------TOTAL
        //$v5 = strpos($var, 'cartão.');
        $v5 = strpos($var, '01:Tipo');
        $v5_1_2 = substr($var, $v5 + 22, 20);
        $v5_1_2 = preg_replace("/\s/", '|', ($v5_1_2));
        $v5_1_2 = str_replace('|||||', '|', $v5_1_2);
        $v5_1_2 = str_replace('||', '|', $v5_1_2);
        //echo '2-$v5_1_2==='.$v5_1_2.'</br>';
        $parte = explode('|', $v5_1_2);
        if (strlen($parte[1]) != 0) {
            $vtotal = $parte[1];
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //-------FALTAS EM HORAS E SALDO

        $v66 = strpos($var, 'Faltas em Horas:');
        $v66_1_2 = trim(substr($var, $v66 + 16, 40));

        //echo '<br>v66_1_2.:'.$v66_1_2;

        $v66_1_2 = preg_replace("/\s/", '|', ($v66_1_2));
        $v66_1_2 = str_replace('|||||', '|', $v66_1_2);
        $v66_1_2 = str_replace('||', '|', $v66_1_2);

        if ($showEcho == 1) {

            echo '<br><br>v66_1_2 = ' . $v66_1_2;
        }

        $parte = explode('|', $v66_1_2);
        // if (strlen($parte[1]) != 0) {
        //     $vfaltasH = $parte[1];
        // }

        $vfaltasH = 0;
        if (strlen($parte[0]) != 0) {
            $vsaldo = $parte[0];
        } else {

            $vsaldo = NULL;
        }

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

        unset($new_arr); //Limpando Array
        $arr = explode(' ', $vv5_1_3);
        foreach ($arr as $value) {
            $new_arr[] = trim($value);
        }

        // echo '<br>CONTAGEM ARRAY='.count($new_arr);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($showEcho == 1) {
            echo '<br>----------------------------------------------------------------------------------------------------------------------------------------------------------';
            echo '<br>PERIODO.:' . $v24_4;
            echo '<br>CNPJ....:' . $cnpj;
            echo '<br>ID_EMP..:' . $id_emp_default;
            echo '<br>CPF.....:' . $vcpf;
            echo '<br>vabono.:' . $vabono;
            echo '<br>vtotal.:' . $vtotal;
            echo '<br>faltaH.:' . $vfaltasH;
            echo '<br>vsaldo.:' . $vsaldo . '<br>' . '<br>';
            echo '<br>----------------------------------------------------------------------------------------------------------------------------------------------------------<br><br>';
        }

        $cpf = $vcpf;
        $periodo = $v24_4;
        $btotal = $vtotal;
        $bsaldo = $vsaldo;
        $ano = substr($periodo, 6, 4);

        //-------------------------------------------------------------------------
        //CRIANDO NOME TABELA
        $raiz_cnpj = $raiz4;
        $tabela1 = 'public."GESPON1_' . $raiz_cnpj . '"';
        $tabela2 = 'public."GESPON2_' . $raiz_cnpj . '"';
        $tabela4 = 'public."GESUSU"';
        //-------------------------------------------------------------------------
        //INSERT TABELA 1
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //SELECT PARA VERIFICAR CADASTRO DE USUARIO

        // $sql_u = 'SELECT id_usu from ' . $tabela4 . ' where cpf=' . $cpf . ' ';
        // $res_u = pg_exec($conn, $sql_u);
        // $linha_u = pg_fetch_assoc($res_u);

        foreach (selectGESUSU_LAYOUT_id_cpf($tabela4, $cpf) as $select_tabela4) {

            $id_usu = $select_tabela4['id_usu'];
        }

        if (empty($id_usu)) {
            $id_usu = '';
        }

        if (strlen($btotal) < 3) {
            $btotal = '00:00';
        }
        if (strlen($bsaldo) < 3) {
            $bsaldo = '00:00';
        }

        if (strlen($id_usu) != 0) {

            if ($showBD == 1) {

                try {

                    $insert_tabela1 = insertGESPON1_tangerino(
                        $tabela1,
                        $id_emp_default,
                        NULL,
                        $id_usu,
                        $periodo,
                        $today,
                        $btotal,
                        $bsaldo,
                        $processamento,
                        $id_usa,
                        $origem
                    );

                    $id_pon1 = $insert_tabela1['pk'];
                } catch (PDOException $erro) {

                    die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                }
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            $v245 = strpos($var, 'Admissão:'); //Inicio BATIDAS
            $v255 = strpos($var, 'Total:'); //FINAL BATIDAS
            $v245_1 = substr($var, $v245 + 29, ($v255 - $v245) - 21);
            $v245_1 = str_replace('(m)', '', $v245_1); //remove marcaçao alteração manual

            $batidas = ltrim($v245_1);

            if ($showEcho == 1) {
                echo 'BATIDAS=' . ltrim($v245_1) . '<br>' . '<br>';
            }

            // $start = new \DateTime(inverteData(substr($v24_4, 0, 10)));
            // $end = new \DateTime(inverteData(substr($v24_4, 16, 10)));

            //echo 'START='.substr($v24_4, 0, 10).'<br>';
            //echo 'END==='.substr($v24_4, 16, 10).'<br>';

            // $start = new \DateTime('2021-12-01');
            // $end = new \DateTime('2021-12-31');
            // $periodArr = new \DatePeriod($start, new \DateInterval('P1D'), $end);

            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            $textoX = $batidas;
            $batidas_edit = $batidas;
            $patternX = '/[0-9]{2}\:?[0-9]{2}\s?[0-9]{2}\:?[0-9]{2}\s\|\s?[0-9]{2}\:?[0-9]{2}\s?[0-9]{2}\:?[0-9]{2}\s\|\s/im'; //expressao regular

            preg_match_all($patternX, $textoX, $matchX);
            if (!empty($matchX)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontos = $matchX[0][$i];
                    if (!empty($pontos)) {
                        //echo  $pontos.'<br>';
                        $batidas_edit = str_replace($pontos, '&' . rtrim($pontos) . '|', $batidas_edit);
                    }
                }
            }
            //----------------------------------------------------------------------------------
            $textoZ = $batidas_edit;
            $batidas_edit = $batidas_edit;
            $patternZ = '/\s[0-9]{2}\:?[0-9]{2}\s[0-9]{2}\:?[0-9]{2}\s\|\s[0-9]{2}\:?[0-9]{2}\s\|/im'; //expressao regular

            preg_match_all($patternZ, $textoZ, $matchZ);
            if (!empty($matchZ)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontosZ = $matchZ[0][$i];
                    if (!empty($pontosZ)) {
                        // echo  $pontosY.'<br>';
                        $batidas_edit = str_replace($pontosZ, '&' . ltrim(rtrim($pontosZ)) . '|', $batidas_edit);
                    }
                }
            } else {
            }
            //----------------------------------------------------------------------------------
            $textoY = $batidas_edit;
            $batidas_edit = $batidas_edit;
            $patternY = '/[0-9]{2}\:?[0-9]{2}\s\|\s?[A-Z]{3}/im'; //expressao regular

            preg_match_all($patternY, $textoY, $matchY);
            if (!empty($matchY)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontosY = $matchY[0][$i];
                    if (!empty($pontosY)) {
                        // echo  $pontosY.'<br>';
                        $batidas_edit = str_replace($pontosY, '&' . rtrim($pontosY), $batidas_edit);
                    }
                }
            } else {
            }
            //----------------------------------------------------------------------------------

            //----------------------------------------------------------------------------------
            $textoW = $batidas_edit;
            $batidas_edit = $batidas_edit;
            $patternW = '/\s[^A-Z]{1}\s[A-Z]{7}\s/im'; //expressao regular ' - domingo '

            preg_match_all($patternW, $textoW, $matchW);
            if (!empty($matchW)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontosW = $matchW[0][$i];
                    if (!empty($pontosW)) {
                        // echo  $pontosW.'<br>';
                        $batidas_edit = str_replace($pontosW, '&' . ltrim($pontosW), $batidas_edit);
                    }
                }
            }

            if ($showEcho == 1) {
                echo '<br><br>batidas_edit - ' . $batidas_edit . '<br><br>';
            }

            //----------------------------------------------------------------------------------
            $textoA = $batidas_edit;
            $batidas_edit = $batidas_edit;
            $patternA = '/\&\d{2}\:\d{2}\&\|\s+\D{6,7}/'; //expressao regular ' &00:00& '

            preg_match_all($patternA, $textoA, $matchA);
            if (!empty($matchA)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontosA = $matchA[0][$i];
                    if (!empty($pontosA)) {
                        // echo  $pontosW.'<br>';
                        $trexoA = explode('|', trim($pontosA));



                        $batidas_edit = str_replace($pontosA, substr(trim($trexoA[0]), 0, -1) . '|' . $trexoA[1], $batidas_edit);
                    }
                }
            }

            //----------------------------------------------------------------------------------
            $batidas_edit = str_replace('HOME OFFICE', '&HOME', $batidas_edit);
            $batidas_edit = str_replace('FALTA NAO JUSTIFICADA', '&FALTA', $batidas_edit);
            $batidas_edit = str_replace('FERIADO', '&FERIADO', $batidas_edit);
            $batidas_edit = str_replace('FÉRIAS', '&FÉRIAS', $batidas_edit);
            $batidas_edit = str_replace('-feira', '', $batidas_edit);

            // $batidas_edit = str_replace('-', '----', $batidas_edit);

            $batidas_edit = preg_replace("/\s/", '|', $batidas_edit);
            $batidas_edit = str_replace('|||||', '|', $batidas_edit);
            $batidas_edit = str_replace('||', '|', $batidas_edit);
            $batidas_edit = preg_replace("/\|\|/", '|', $batidas_edit);
            $batidas_edit = preg_replace('/\|\-\|(sabado)/im', '|&-|sabado', $batidas_edit);

            //----------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------
            $textoV = $batidas_edit;
            $batidas_edit = $batidas_edit;
            $patternV = '/[0-9]{2}\:?[0-9]{2}\|\&[0-9]{2}\:?[0-9]{2}\|?[A-Z]{3}/im'; //expressao regular

            preg_match_all($patternV, $textoV, $matchV);
            if (!empty($matchV)) {
                for ($i = 0; $i < 31; ++$i) {
                    $pontosV = $matchV[0][$i];
                    if (!empty($pontosV)) {
                        $batidas_edit_depois = str_replace('&', '', $pontosV);
                        $batidas_edit = str_replace($pontosV, '&' . rtrim($batidas_edit_depois), $batidas_edit);
                    }
                }
            } else {
            }
            //----------------------------------------------------------------------------------
            //----------------------------------------------------------------------------------

            if ($showEcho == 1) {
                echo 'BATIDAS=====' . $batidas_edit . '<br>' . '<br>';
            }

            $parte_batidas = explode('&', $batidas_edit);
            for ($i = 0; $i < 31; ++$i) {
                if (!empty($parte_batidas[$i])) {

                    if ($showEcho == 1) {
                        echo 'LINHA=====' . $parte_batidas[$i] . '<br>';
                    }

                    unset($new_arr3); //Limpando Array

                    //---------------------------------------------------------------------------
                    $arr3 = explode('|', $parte_batidas[$i]);
                    foreach ($arr3 as $value3) {
                        $new_arr3[] = trim($value3);
                    }

                    $pos0 = $new_arr3[0];
                    $pos1 = $new_arr3[1];
                    $pos2 = $new_arr3[2];
                    $pos3 = $new_arr3[3];
                    $pos4 = $new_arr3[4];
                    $pos5 = $new_arr3[5];
                    $pos6 = $new_arr3[6];
                    $pos7 = $new_arr3[7];
                    $pos8 = $new_arr3[8];
                    $pos9 = $new_arr3[9];
                    $pos10 = $new_arr3[10];

                    if ($new_arr3[1] == 'domingo' || $new_arr3[1] == 'sabado' || $new_arr3[1] == 'sexta' || $new_arr3[1] == 'quinta' || $new_arr3[1] == 'quarta' || $new_arr3[1] == 'terça' || $new_arr3[1] == 'segunda') {
                        $pos0 = $new_arr3[0];
                        $pos1 = '';
                        $pos2 = '';
                        $pos3 = '';
                        $pos4 = $new_arr3[1];
                        $pos5 = $new_arr3[2];
                        $pos6 = '';
                        $pos7 = $new_arr3[3];
                        $pos8 = '';
                        $pos9 = '';
                        $pos10 = '';
                    }

                    if ($new_arr3[1] == 'domingo' || $new_arr3[1] == 'sabado' || $new_arr3[1] == 'sexta' || $new_arr3[1] == 'quinta' || $new_arr3[1] == 'quarta' || $new_arr3[1] == 'terça' || $new_arr3[1] == 'segunda') {
                        if (count($new_arr3) == 5) {

                            $pos0 = $new_arr3[3];
                            $pos1 = $new_arr3[4];
                            $pos2 = '';
                            $pos3 = '';
                            $pos4 = $new_arr3[1];
                            $pos5 = '';
                            $pos6 = '';
                            $pos7 = $new_arr3[2];
                            $pos8 = '';
                            $pos9 = '';
                            $pos10 = '';
                        }
                    }

                    if ($new_arr3[2] == 'domingo' || $new_arr3[2] == 'sabado' || $new_arr3[2] == 'sexta' || $new_arr3[2] == 'quinta' || $new_arr3[2] == 'quarta' || $new_arr3[2] == 'terça' || $new_arr3[2] == 'segunda') {
                        $pos0 = $new_arr3[0];
                        $pos1 = $new_arr3[1];
                        $pos2 = '';
                        $pos3 = '';
                        $pos4 = $new_arr3[2];
                        $pos5 = $new_arr3[3];
                        $pos6 = $new_arr3[4];
                        $pos7 = $new_arr3[5];
                        $pos8 = $new_arr3[6];
                        $pos9 = $new_arr3[7];
                        $pos10 = $new_arr3[8];
                    }

                    if ($new_arr3[2] == 'domingo' || $new_arr3[2] == 'sabado' || $new_arr3[2] == 'sexta' || $new_arr3[2] == 'quinta' || $new_arr3[2] == 'quarta' || $new_arr3[2] == 'terça' || $new_arr3[2] == 'segunda') {
                        if (count($new_arr3) > 4) {

                            $pos0 = $new_arr3[0];
                            $pos1 = $new_arr3[1];
                            $pos2 = '';
                            $pos3 = '';
                            $pos4 = $new_arr3[2];
                            $pos5 = $new_arr3[4];
                            $pos6 = '';
                            $pos7 = $new_arr3[3];
                            $pos8 = $new_arr3[5];
                            $pos9 = '';
                            $pos10 = '';
                        }
                    }

                    if ($new_arr3[3] == 'domingo' || $new_arr3[3] == 'sabado' || $new_arr3[3] == 'sexta' || $new_arr3[3] == 'quinta' || $new_arr3[3] == 'quarta' || $new_arr3[3] == 'terça' || $new_arr3[3] == 'segunda') {
                        $pos0 = $new_arr3[0];
                        $pos1 = $new_arr3[1];
                        $pos2 = $new_arr3[2];
                        $pos3 = '';
                        $pos4 = $new_arr3[3];
                        $pos5 = $new_arr3[4];
                        $pos6 = $new_arr3[5];
                        $pos7 = $new_arr3[6];
                        $pos8 = $new_arr3[7];
                        $pos9 = $new_arr3[8];
                        $pos10 = $new_arr3[9];
                    }

                    if ($new_arr3[4] == 'domingo' || $new_arr3[4] == 'sabado' || $new_arr3[4] == 'sexta' || $new_arr3[4] == 'quinta' || $new_arr3[4] == 'quarta' || $new_arr3[4] == 'terça' || $new_arr3[4] == 'segunda') {
                        if (count($new_arr3) == 10) {
                            $pos0 = $new_arr3[0];
                            $pos1 = $new_arr3[1];
                            $pos2 = $new_arr3[2];
                            $pos3 = $new_arr3[3];
                            $pos4 = $new_arr3[4];
                            $pos5 = $new_arr3[8];
                            $pos6 = $new_arr3[5];
                            $pos7 = $new_arr3[6];
                            $pos8 = $new_arr3[7];
                            $pos9 = '';
                            $pos10 = '';
                        }
                    }

                    if ($new_arr3[4] == 'domingo' || $new_arr3[4] == 'sabado' || $new_arr3[4] == 'sexta' || $new_arr3[4] == 'quinta' || $new_arr3[4] == 'quarta' || $new_arr3[4] == 'terça' || $new_arr3[4] == 'segunda') {
                        if (count($new_arr3) == 9) {
                            $pos0 = $new_arr3[0];
                            $pos1 = $new_arr3[1];
                            $pos2 = $new_arr3[2];
                            $pos3 = $new_arr3[3];
                            $pos4 = $new_arr3[4];
                            $pos5 = $new_arr3[7];
                            $pos6 = $new_arr3[5];
                            $pos7 = $new_arr3[6];
                            $pos8 = '';
                            $pos9 = '';
                            $pos10 = '';
                        }
                    }

                    if (preg_match('/[0-9]{2}\/[0-9]{2}/i', $pos2)) {
                        $pos10 = $pos5;
                        $pos9 = $pos4;
                        $pos8 = $pos3;
                        $pos7 = $pos2;
                        $pos6 = '';
                        $pos5 = '';
                        $pos4 = '';
                        $pos3 = '';
                        $pos2 = '';
                    }

                    if (preg_match('/[0-9]{2}\/[0-9]{2}/i', $pos3)) {
                        $pos10 = $pos6;
                        $pos9 = $pos5;
                        $pos8 = $pos4;
                        $pos7 = $pos3;
                        $pos6 = '';
                        $pos5 = '';
                        $pos4 = '';
                        $pos3 = '';
                    }

                    if (preg_match('/[0-9]{2}\/[0-9]{2}/i', $pos4)) {
                        $pos10 = $pos7;
                        $pos9 = $pos6;
                        $pos8 = $pos5;
                        $pos7 = $pos4;
                        $pos6 = '';
                        $pos5 = '';
                        $pos4 = '';
                    }

                    if (preg_match('/[0-9]{2}\/[0-9]{2}/i', $pos5)) {
                        $pos10 = $pos8;
                        $pos9 = $pos7;
                        $pos8 = $pos6;
                        $pos7 = $pos5;
                        $pos6 = '';
                        $pos5 = '';
                    }
                    if (preg_match('/[0-9]{2}\/[0-9]{2}/i', $pos6)) {
                        $pos10 = $pos9;
                        $pos9 = $pos8;
                        $pos8 = $pos7;
                        $pos7 = $pos6;
                        $pos6 = '';
                    }

                    if ($pos0 == 'HOME' || $pos0 == 'FERIADO') {
                        $pos10 = $pos5;
                        $pos5 = '';
                        $pos8 = '';
                    }
                    if ($pos0 == 'FALTA') {
                        $pos6 = $pos5;
                        $pos5 = '';
                    }

                    //---------------------------------------------------------------------------
                    if ($showEcho == 1) {
                        echo 'ENT1=====' . $pos0 . '<br>';
                        echo 'SAI1=====' . $pos1 . '<br>';
                        echo 'ENT2=====' . $pos2 . '<br>';
                        echo 'SAI2=====' . $pos3 . '<br>';
                        echo 'DIAS=====' . $pos4 . '<br>';
                        echo 'TRAB=====' . $pos5 . '<br>';
                        echo 'ABON=====' . $pos10 . '<br>';
                        echo 'PREV=====' . $pos6 . '<br>';
                        echo 'DATA=====' . inverteData($pos7 . '/' . $ano) . '<br>';
                        echo 'BSAL=====' . $pos8 . '<br>';
                        echo '-----------------------------------------------------------------------------------------------' . '<br>';
                    }

                    $data = inverteData($pos7 . '/' . $ano);
                    //echo 'DATA INVERTIDA...:'.$data.'<br>';

                    $ent1 = $pos0;
                    $sai1 = $pos1;
                    $ent2 = $pos2;
                    $sai2 = $pos3;
                    //$ent3 = "'".$new_arr2[4]."'";
                    //$sai3 = "'".$new_arr2[5]."'";
                    $bsaldo = $pos8;

                    //---------------------------------------------------------------------------

                    //INICIO INSERT GESPON2_ ULTIMI DIA MES
                    if (strlen($ent1) < 1) {
                        $ent1 = '';
                    }
                    if (strlen($sai1) < 1) {
                        $sai1 = '';
                    }
                    if (strlen($ent2) < 1) {
                        $ent2 = '';
                    }
                    if (strlen($sai2) < 1) {
                        $sai2 = '';
                    }
                    if (strlen($ent3) < 1) {
                        $ent3 = '';
                    }
                    if (strlen($sai3) < 1) {
                        $sai3 = '';
                    }
                    if (strlen($btotal) < 1) {
                        $btotal = '';
                    }
                    if (strlen($bsaldo) < 1) {
                        $bsaldo = '';
                    }

                    if ($showBD == 1) {

                        try {

                            insertGESPON2_tangerino(
                                $tabela2,
                                $id_pon1,
                                $data,
                                $ent1,
                                $sai1,
                                $ent2,
                                $sai2,
                                $ent3,
                                $sai3,
                                $bsaldo,
                                $today
                            );
                        } catch (PDOException $erro) {

                            die(($_SESSION["erro_importação"] = '2 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    }
                }
            }

            //----------------------------------------------------------------------------------------------------------------------------------------------------
        }
        //----------------------------------------------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------------------------------------------
    }
endfor;

if ($showEcho == 0) {
    echo "<script language=javascript>
    location.href = '../lotes_processados';
    </script>";
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
