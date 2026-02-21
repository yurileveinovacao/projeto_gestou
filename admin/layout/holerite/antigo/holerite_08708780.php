<?php

require '../../restrito.php';
require_once '../../conexao.php';
require_once '../../util.php';
require_once '../../iuds_pdo.php';

$id_emp_default = $_SESSION['id_emp_default'];
$today = date('Y-m-d H:i:s');
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = $_SESSION['descricao'];

$val3 = uniqidReal();
$processamento = $val3;

$origem = $_SESSION['nomepdf'];
$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO.pdf
foreach (select_id_emp_Layout($id_emp_default) as $select_CNPJ_GESEMP) {

    //CNPJ SEM FORMATACAO
    $cnpj_sem_formatacao = $select_CNPJ_GESEMP['cnpj'];
}

//RECUPERANDO RAIZ CNPJ
$raiz1 = str_replace('.', '', $cnpj_sem_formatacao);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Include Composer autoloader if not already done.
include '../../vendor_ler_pdf/autoload.php';
//Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../../uploads/' . $raiz4 . '.pdf');
$text = $pdf->getText();
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//echo '$text='.$text.'<br>';
//echo '----------------------------------------'.'<br>'.'<br>';

//CONTAGEM REGISTROS PDF
$html = $text;
$needle = substr($text, 0, 18);
$lastPos = 0;
$count = 0;
$positions = [];
//  Ativa Echo quando = 1
$showEcho = 0;
// Ativa Banco de Dados quando = 1
$showBD = 1;

if (!empty($needle)) {
    if ($needle == $cnpj_sem_formatacao) {
        while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
            $count = $count + 1;
        }
        if ($showEcho == 1) {
            echo 'Contagem: ' . $count . '<br /><br />';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        for ($ix = 1; $ix <= $count; ++$ix) :
            $var = explode($needle, $text)[$ix];
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $v0 = strpos($var, '08.708.780/0001-30'); //Achar Folha 1 e 2
            $v0_1 = substr($var, $v0 + 30, 1);
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $var = str_replace('582733410116', '---(1)---', $var);
            $var = str_replace('CNPJ/CPF:', '---(2)---', $var);
            $var = str_replace('FOLHA', '---(3)---', $var);
            $var = str_replace('ADMISSÃO', '---(4)---', $var);
            $var = str_replace('J.FREITAS', '---(5)---', $var);
            $var = str_replace('PAGAMENTO', '---(6)---', $var);

            if ($showEcho == 1) {
                echo ' $var=' . $var . '<br>' . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------NOME DO COLABORADOR:
            $nome_1 = 1;
            $nome_2 = strpos($var, '---(1)---');
            $string_1_v = substr($var, $nome_1, $nome_2 - 1);
            $texto = $string_1_v;
            $pattern = '/[0-9]{1}/i'; //expressao regular localiza 1 numero
            preg_match($pattern, $texto, $match);
            if (!empty($match)) {
                $nome_v1_1 = $match[0];
            } else {
                $nome_v1_1 = '';
            }
            $nome_3 = strpos($string_1_v, $nome_v1_1);
            $nome_vv = substr($string_1_v, 0, $nome_3 - 1);
            if ($showEcho == 2) {
                echo '---NOME:' . $nome_vv . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------CODIGO DO COLABORADOR:
            if ($showEcho == 1) {
                echo '2=' . $nome_vv . '</br>';
            }

            $string_2_v = substr($string_1_v, $nome_3);
            $string_2_1_v = str_replace(' ', '|', $string_2_v);
            $codigo_p_2 = strpos($string_2_1_v, '|');
            $codigo_v = substr($string_2_1_v, 0, $codigo_p_2);

            if ($showEcho == 1) {
                echo '4=' . $string_2_v . '</br>';
            }

            $texto = $string_2_v;
            $pattern = '/[A-Z]{1}/i'; //expressao regular localiza 1 letra
            preg_match($pattern, $texto, $match);
            if (!empty($match)) {
                $string_2_vv = $match[0];
            } else {
                $string_2_vv = '';
            }
            $string_2_vv_2 = strpos($string_2_v, $string_2_vv);
            $string_3_vv = rtrim(substr($string_2_v, 0, $string_2_vv_2));

            if ($showEcho == 1) {
                echo 'string_3_vv===' . $string_3_vv . '</br>';
            }
            $totais_1 = preg_replace('/\s/', '|', $string_3_vv);

            for ($x = 0; $x <= 1; ++$x) {
                $totais_2 = explode('|', $totais_1)[$x];
                if (!empty($totais_2)) {
                    if ($x == 0) {
                        $v15_5 = $totais_2;
                        $v15_4 = ltrim(str_replace('.', '', $v15_5));
                        $v15_5 = ltrim(str_replace(',', '.', $v15_4));
                        $v15_6 = is_numeric($v15_5) ? true : false;
                        if ($v15_6 == 1) {
                            $codigo_v = $v15_5;
                        } else {
                            $codigo_v = '';
                        }
                    }
                } else {
                    $codigo_v = NULL;
                }
            }
            if ($showEcho == 1) {
                echo '<br>---CODIGO:' . $codigo_v . '<br>';
            }

            //------------------------------------------------------------------------
            //---------------------------------------------------COMPETENCIA:
            $competencia_v = substr($string_2_1_v, $codigo_p_2 + 1, 100);
            $texto = $competencia_v;
            $pattern = '/[A-Z]{1}/i'; //expressao regular localiza 1 letra
            preg_match($pattern, $texto, $match);
            if (!empty($match)) {
                $competencia_v1_1 = $match[0];
            } else {
                $competencia_v1_1 = '';
            }
            $competencia_v1_2 = strpos($competencia_v, $competencia_v1_1);
            $competencia_vv = rtrim(substr($competencia_v, $competencia_v1_2, 100));
            if ($showEcho == 1) {
                echo '---COMPETENCIA:' . $competencia_vv . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------FUNÇÃO:
            $funcao_1 = strpos($var, '---(1)---');
            $funcao_2 = strpos($var, '---(2)---');
            $funcao_v = substr($var, $funcao_1, ($funcao_2 - $funcao_1));
            $funcao_v = str_replace('---(1)---', '', $funcao_v);
            $funcao_v = trim(str_replace('---(2)---', '', $funcao_v));

            if ($showEcho == 1) {
                echo '---FUNÇAO:' . $funcao_v . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------CBO:
            $cbo_1 = strpos($var, '---(3)---');
            $cbo_2 = strpos($var, '---(4)---');
            $cbo_v = substr($var, $cbo_1 + 10, ($cbo_2 - $cbo_1) - 15);
            if ($showEcho == 1) {
                echo '---CBO:' . $cbo_v . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------ADMISSAO:
            $admissao_1 = strpos($var, '---(4)---');
            $admissao_2 = strpos($var, '---(5)---');
            $admissao_v = substr($var, $admissao_1 + 10, ($admissao_2 - $admissao_1) - 11);
            if ($showEcho == 1) {
                echo '---ADMISSÃO:' . $admissao_v . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------CNPJ:
            $CNPJ = substr($text, 0, 18); //trecho reduzido
            if ($showEcho == 1) {
                echo '---CNPJ:' . $CNPJ . '<br>';
                echo '---------------------------------------------------------------------------------------------------------------------------------------------------------------<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //-------------------------------------------------TOTAL DE VENCTOS:
            //-------------------------------------------------TOTAL DE DESCTOS:
            //-------------------------------------------------VALOR LÍQUIDO =>:
            $var_1 = strpos($var, '---(6)---');
            $var_2 = strpos($var, 'TOTAL DE VENCTOS');
            $var_3 = substr($var, $var_1 + 11, ($var_2 - $var_1) - 11);

            $var_3 = 'X' . $var_3;

            $texto1 = strrev($var_3);
            $pattern = '/\s\d{2}\,\d{1}/'; //expressao regular localiza ' 0,00'
            preg_match($pattern, $texto1, $match);
            if (!empty($match)) {
                $var_2 = $match[0];
            } else {
                $var_2 = '';
            }
            $var_6 = strpos($texto1, $var_2);
            $var_7 = substr($texto1, $var_6 + 1, 1000);

            $texto = ($var_7);
            $pattern = '/[A-Z]{1}/i'; //expressao regular localiza 1 letra
            preg_match($pattern, $texto, $match);
            if (!empty($match)) {
                $var_4 = $match[0];
            } else {
                $var_4 = '';
            }

            //$texto = str_replace('(%)', '', $texto);

            //echo '$texto='.$texto.'<br>';

            $var_5 = strpos($texto, $var_4);
            $var_6_v = substr($texto, 0, $var_5);
            $var_6_v = preg_replace("/\s/", '|', strrev($var_6_v));
            $var_6_v = str_replace('|||||', '|', $var_6_v);
            $var_6_v = str_replace('|||', '|', $var_6_v);
            //  $var_6_v = preg_replace( '/|||/',  '|' , $var_6_v);
            // $var_6_v = preg_replace( '/||/',  '|' , $var_6_v);
            $var_6_v = str_replace('||', '|', $var_6_v);

            $var_6_v = preg_replace('/(%)/',  '', $var_6_v);

            $parte = explode('|', $var_6_v);

            //echo '--------------------------------------------'.'<br>';
            //echo '$var_6_v='.$var_6_v.'<br>';
            //echo '--------------------------------------------'.'<br>';            

            // echo '$parte[7]'.$parte[7].'<br>';
            // echo '$parte[6]'.$parte[6].'<br>';
            // echo '$parte[5]'.$parte[5].'<br>';
            // echo '$parte[4]'.$parte[4].'<br>';
            // echo '$parte[3]'.$parte[3].'<br>';
            // echo '$parte[2]'.$parte[2].'<br>';
            // echo '$parte[1]'.$parte[1].'<br>';


            if (strlen($parte[7]) != 0) {
                $vTVENCIMENTO_ORI = $parte[5];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[5]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[6];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[6]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[7]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                if ($showEcho == 1) {
                    echo '---VLIQUIDO:' . $vVLIQUIDO . '<br/>';
                }
            } elseif (strlen($parte[6]) != 0) {
                $vTVENCIMENTO_ORI = $parte[4];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[4]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[5];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[5]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[6]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                if ($showEcho == 1) {
                    echo '---VLIQUIDO:' . $vVLIQUIDO . '<br/>';
                }
            } elseif (strlen($parte[5]) != 0) {
                $vTVENCIMENTO_ORI = $parte[3];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[3]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[4];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[4]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[5]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                if ($showEcho == 1) {
                    echo '---VLIQUIDO:' . $vVLIQUIDO . '<br/>';
                }
            } elseif (strlen($parte[4]) != 0) {
                $vTVENCIMENTO_ORI = $parte[2];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[2]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[3];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[3]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[4]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                if ($showEcho == 1) {
                    echo '---VLIQUIDO:' . $vVLIQUIDO . '<br/>';
                }
            } elseif (strlen($parte[3]) != 0) {
                $vTVENCIMENTO_ORI = $parte[1];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[1]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[2];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[2]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[3]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                // echo '---VLIQUIDO:'.$vVLIQUIDO.'<br/>';
            } elseif (strlen($parte[2]) != 0) {
                $vTVENCIMENTO_ORI = $parte[0];
                $vTVENCIMENTO = ltrim(str_replace('.', '', $parte[0]));
                $vTVENCIMENTO = ltrim(str_replace(',', '.', $vTVENCIMENTO));
                $vNUMERIC = is_numeric($vTVENCIMENTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTVENCIMENTO = $vTVENCIMENTO;
                } else {
                    $vTVENCIMENTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TVENCIMENTO:' . $vTVENCIMENTO . '<br/>';
                }

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vTDESCONTO_ORI = $parte[1];
                $vTDESCONTO = ltrim(str_replace('.', '', $parte[1]));
                $vTDESCONTO = ltrim(str_replace(',', '.', $vTDESCONTO));
                $vNUMERIC = is_numeric($vTDESCONTO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vTDESCONTO = $vTDESCONTO;
                } else {
                    $vTDESCONTO = '';
                }
                if ($showEcho == 1) {
                    echo '---TDESCONTO:' . $vTDESCONTO . '<br/>';
                }
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $vVLIQUIDO = ltrim(str_replace('.', '', $parte[2]));
                $vVLIQUIDO = ltrim(str_replace(',', '.', $vVLIQUIDO));
                $vNUMERIC = is_numeric($vVLIQUIDO) ? true : false;
                if ($vNUMERIC == 1) {
                    $vVLIQUIDO = $vVLIQUIDO;
                } else {
                    $vVLIQUIDO = '';
                }
                if ($showEcho == 1) {
                    echo '---VLIQUIDO:' . $vVLIQUIDO . '<br/>';
                }
            }
            if ($showEcho == 1) {
                echo '---------------------------------------------------------------------------------------------------------------------------------------------------------------<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //-------------------------------------------------SALARIO BASE, SAL. CONTR. INSS, BASE CÁLC. FGTS, FGTS DO MÊS, BASE CÁLC. IRRF, FAIXA IRRF
            //echo ' $var='.$var.'<br>'.'<br>';
            $var = str_replace('(%)', '', $var);
            $var_c1 = strpos($var, '=>');
            $var_c3 = substr($var, $var_c1, 10000);
            $var_c3 = str_replace('-', '', $var_c3);
            $var_c3 = str_replace('=>', '', $var_c3);
            $var_c3 = ltrim($var_c3);
            $var_c3 = str_replace('ASSINATURA DATA', '', $var_c3);
            $var_c3 = str_replace('________/________/________', '', $var_c3);
            $var_c3 = str_replace('IRRF FAIXA IRRF', '', $var_c3);
            $var_c3 = str_replace('FGTS FGTS DO MÊS BASE CÁLC.', '', $var_c3);
            $var_c3 = str_replace('SALÁRIO BASE SAL. CONTR. INSS BASE CÁLC.', '', $var_c3);
            $var_c3 = preg_replace("/\s/", '|', $var_c3);
            $var_c3 = str_replace('||||||||||', '|', $var_c3);
            $var_c3 = str_replace('||', '', $var_c3);

            $base_valores = explode('|', $var_c3);

            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vSAL_BASE = ltrim(str_replace('.', '', $base_valores[0]));
            $vSAL_BASE = ltrim(str_replace(',', '.', $vSAL_BASE));
            $vNUMERIC = is_numeric($vSAL_BASE) ? true : false;
            if ($vNUMERIC == 1) {
                $vSAL_BASE = $vSAL_BASE;
            } else {
                $vSAL_BASE = '';
            }
            if ($showEcho == 1) {
                echo '---SALARIO_BASE:' . $vSAL_BASE . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vSAL_CONTRIBUICAO = ltrim(str_replace('.', '', $base_valores[1]));
            $vSAL_CONTRIBUICAO = ltrim(str_replace(',', '.', $vSAL_CONTRIBUICAO));
            $vNUMERIC = is_numeric($vSAL_CONTRIBUICAO) ? true : false;
            if ($vNUMERIC == 1) {
                $vSAL_CONTRIBUICAO = $vSAL_CONTRIBUICAO;
            } else {
                $vSAL_CONTRIBUICAO = '';
            }
            if ($showEcho == 1) {
                echo '---SAL_CONTR_INSS:' . $vSAL_CONTRIBUICAO . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vBASE_FGTS = ltrim(str_replace('.', '', $base_valores[2]));
            $vBASE_FGTS = ltrim(str_replace(',', '.', $vBASE_FGTS));
            $vNUMERIC = is_numeric($vBASE_FGTS) ? true : false;
            if ($vNUMERIC == 1) {
                $vBASE_FGTS = $vBASE_FGTS;
            } else {
                $vBASE_FGTS = '';
            }
            if ($showEcho == 1) {
                echo '---BASE_CALC_FGTS:' . $vBASE_FGTS . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vFGTS_MES = ltrim(str_replace('.', '', $base_valores[3]));
            $vFGTS_MES = ltrim(str_replace(',', '.', $vFGTS_MES));
            $vNUMERIC = is_numeric($vFGTS_MES) ? true : false;
            if ($vNUMERIC == 1) {
                $vFGTS_MES = $vFGTS_MES;
            } else {
                $vFGTS_MES = '';
            }
            if ($showEcho == 1) {
                echo '---FGTS DO MÊS:' . $vFGTS_MES . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vBASE_IRRF = ltrim(str_replace('.', '', $base_valores[4]));
            $vBASE_IRRF = ltrim(str_replace(',', '.', $vBASE_IRRF));
            $vNUMERIC = is_numeric($vBASE_IRRF) ? true : false;
            if ($vNUMERIC == 1) {
                $vBASE_IRRF = $vBASE_IRRF;
            } else {
                $vBASE_IRRF = '';
            }
            if ($showEcho == 1) {
                echo '---BASE CÁLC. IRRF:' . $vBASE_IRRF . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $vFAIXA_IRRF = ltrim(str_replace('.', '', $base_valores[5]));
            $vFAIXA_IRRF = ltrim(str_replace(',', '.', $vFAIXA_IRRF));
            $vNUMERIC = is_numeric($vFAIXA_IRRF) ? true : false;
            if ($vNUMERIC == 1) {
                $vFAIXA_IRRF = $vFAIXA_IRRF;
            } else {
                $vFAIXA_IRRF = '';
            }
            if ($showEcho == 1) {
                echo '---FAIXA IRRF:' . $vFAIXA_IRRF . '<br/>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            if ($showEcho == 1) {
                echo '---------------------------------------------------------------------------------------------------------------------------------------------------------------<br>';
                echo '---------------------------------------------------------------------------------------------------------------------------------------------------------------<br>' . '<br>';
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            $cod_integracao = $codigo_v;
            $situac = 0;
            $situac_politica = 0;
            $id_dep = 0;
            $cep = 00000000;
            $dependentes = 0;
            $cnpj = $CNPJ;
            $competencia = $competencia_vv;
            $rg = NULL;
            $cpf = NULL;
            $nome = $nome_vv;
            $cargo = $funcao_v;
            $data_credito = NULL;
            $vlr_vencimento = $vTVENCIMENTO;
            $vlr_desconto = $vTDESCONTO;
            $vlr_liquido = $vVLIQUIDO;

            $vlr_basesalario = $vSAL_BASE;
            $vlr_baseinss = $vSAL_CONTRIBUICAO;
            $vlr_basefgts = $vBASE_FGTS;
            $vlr_fgts = $vFGTS_MES;
            $vlr_baseirrf = $vBASE_IRRF;
            $faixa_irrf = $vFAIXA_IRRF;
            $vlr_baseir = '';

            if ($vlr_vencimento == '') {
                $vlr_vencimento = 0.00;
            }
            if ($vlr_desconto == '') {
                $vlr_desconto = 0.00;
            }
            if ($vlr_liquido == '') {
                $vlr_liquido = 0.00;
            }
            if ($faixa_irrf == '') {
                $faixa_irrf = 0.00;
            }
            if ($vlr_basesalario == '') {
                $vlr_basesalario = 0.00;
            }
            if ($vlr_baseinss == '') {
                $vlr_baseinss = 0.00;
            }
            if ($vlr_basefgts == '') {
                $vlr_basefgts = 0.00;
            }
            if ($vlr_baseirrf == '') {
                $vlr_baseirrf = 0.00;
            }
            if ($vlr_baseir == '') {
                $vlr_baseir = 0.00;
            }
            if ($vlr_fgts == '') {
                $vlr_fgts = 0.00;
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //------------------------------------------------------------------------
            foreach (select_id_emp_Layout($id_emp_default) as $select_CNPJ_GESEMP) {

                //CNPJ SEM FORMATACAO
                $cnpj_sem_formatacao2 = $select_CNPJ_GESEMP['cnpj'];
            }


            //RECUPERANDO RAIZ CNPJ
            $raiz1 = str_replace('.', '', $cnpj_sem_formatacao2);
            $raiz2 = str_replace('-', '', $raiz1);
            $raiz3 = str_replace('/', '', $raiz2);
            $raiz4 = substr($raiz3, 0, 8);
            //-------------------------------------------------------------------------
            //CRIANDO NOME TABELA
            $raiz_cnpj = $raiz4;
            $tabela1 = 'public."GESIM1_' . $raiz_cnpj . '"';
            $tabela2 = 'public."GESIM2_' . $raiz_cnpj . '"';
            $tabela3 = 'public."GESEVE"';
            $tabela4 = 'public."GESUSU"';
            //-------------------------------------------------------------------------
            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            //-------------------------------------------------------------------------

            if ($showEcho == 1) {
                echo '$CNPJ======== ' . $CNPJ . '</br>';
                echo '$select_CNPJ_GESEMP[cnpj]= ' . $cnpj_sem_formatacao2 . '</br>';
            }

            //INSERT TABELA 1
            if ($cnpj == $cnpj_sem_formatacao) {

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                if (empty($cod_integracao)) {

                    foreach (selectGESUSU_LAYOUT_NOME($tabela4, $nome, $id_emp_default) as $select_GESUSU) {

                        $id_usu = $select_GESUSU['id_usu'];
                        $cod_integracao = $select_GESUSU['cod_integracao'];
                    }
                } else {
                    //SELECT PARA VERIFICAR CADASTRO DE USUARIO
                    foreach (selectGESUSU_LAYOUT_id_cod($tabela4, $cod_integracao, $id_emp_default) as $select_GESUSU) {

                        $id_usu = $select_GESUSU['id_usu'];
                    }
                }

                if ($showEcho == 1) {
                    echo '<br><br>$select_GESUSU[id_usu]= ' . $id_usu;
                    echo '<br><br>$cod_integracao= ' . $cod_integracao . '<br>';
                }

                if (empty($id_usu)) {
                    //echo '<br>---ENTROU NO ELSE---------------------------------------'.'</br>'.'</br>';
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    //$senha = 123;
                    //$senha = "'".password_hash($senha, PASSWORD_DEFAULT)."'";
                    $senha = '$2y$10$Iipf8SP78Bt1iC1zyNLKcOtWYqto/gHQavJm3WmjJJxwoJHrt/K.e';
                    $id_mun = 11061;
                    //$DateAndTime = "'".date('Y-d-m h:i:s', time())."'";
                    $id_emp_ant = 0;
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    if ($showBD == 1) {
                        try {

                            $insert_tabela4 = insertGESUSU_acedata(
                                $tabela4,
                                $nome,
                                NULL,
                                $senha,
                                $today,
                                $situac,
                                $rg,
                                $id_mun,
                                $cargo,
                                $id_emp_default,
                                $id_emp_ant,
                                $today,
                                $id_usa,
                                $id_dep,
                                $cep,
                                $dependentes,
                                $situac_politica,
                                $cod_integracao
                            );

                            $id_usu = $insert_tabela4['pk'];
                        } catch (PDOException $erro) {

                            die(($_SESSION['erro_importação'] = $erro) . (header('Location:' . $erro_1)));
                        }
                    }
                }

                if ($showEcho == 1) {
                    echo '<br>---INICIO INSERT TABELA1---------------------------------------' . '</br>' . '</br>';

                    echo '1=' . $id_emp_default . '</br>';
                    echo '2=' . $competencia . '</br>';
                    echo '3=' . $nome . '</br>';
                    echo '4=' . $cargo . '</br>';
                    echo '5=' . $vlr_vencimento . '</br>';
                    echo '6=' . $vlr_desconto . '</br>';
                    echo '7=' . $vlr_liquido . '</br>';
                    echo '8=' . $faixa_irrf . '</br>';
                    echo '9=' . $vlr_basesalario . '</br>';
                    echo '10=' . $vlr_baseinss . '</br>';
                    echo '11=' . $vlr_basefgts . '</br>';
                    echo '12=' . $vlr_baseirrf . '</br>';
                    echo '13=' . $vlr_baseir . '</br>';
                    echo '14=' . $vlr_fgts . '</br>';
                    echo '15=' . $situac . '</br>';
                    echo '16=' . $id_usu . '</br>';
                    echo '17=' . $today . '</br>';
                    echo '18=' . $id_usa . '</br>';
                    echo '19=' . $descricao_recibo . '</br>';
                    echo '20=' . $validador . '</br>';
                    echo '21=' . $processamento . '</br>';
                    echo '22=' . $origem . '</br>';
                }

                if ($showBD == 1) {
                    try {

                        $insert_tabela1 = insertGESIM1_acedata(
                            $tabela1,
                            $id_emp_default,
                            $competencia,
                            NULL,
                            NULL,
                            $nome,
                            $cargo,
                            NULL,
                            $vlr_vencimento,
                            $vlr_desconto,
                            $vlr_liquido,
                            $faixa_irrf,
                            $vlr_basesalario,
                            $vlr_baseinss,
                            $vlr_basefgts,
                            $vlr_baseirrf,
                            $vlr_baseir,
                            $vlr_fgts,
                            $situac,
                            $id_usu,
                            $today,
                            $id_usa,
                            $descricao_recibo,
                            $validador,
                            $processamento,
                            $origem
                        );

                        $id_im1 = $insert_tabela1['pk'];
                    } catch (PDOException $erro) {

                        die(($_SESSION['erro_importação'] = '0 - ' . $erro) . (header('Location:' . $erro_1)));
                    }

                    if ($showEcho == 1) {
                        echo '<br>---FIM INSERT TABELA1---------------------------------------' . '</br>' . '</br>';
                    }
                }
                //----------------------------------EVENTOS--------------------------------------------------------------------------------------------------------------------//

                if ($showEcho == 1) {
                echo '<br>---$var:'.$var . '</br>' . '</br>';
                }

                $var_1 = strpos($var, '---(6)---');
                $var_2 = strpos($var, 'TOTAL DE VENCTOS');
                $var_3 = substr($var, $var_1, ($var_2 - $var_1));
                $var_3 = str_replace('---(6)---', '', $var_3);
                $var_3 = str_replace('TOTAL DE VENCTOS', '', $var_3);
                $var_3 = preg_replace('/\s+/',  ' ', $var_3);
                
                
                //TRATA DIFERENÇA EM VALOR VENCIMENTO E VALOR DESCONTO 
                if($vTVENCIMENTO_ORI != $vTDESCONTO_ORI){
                $var_4_p2 = strpos($var_3, $vTVENCIMENTO_ORI . ' ' . $vTDESCONTO_ORI);
                }else{
                    $var_4_p2 = strpos($var_3, 'BCO:');
                }

                $var_55 = substr($var_3, 0, $var_4_p2);
                



                if ($showEcho == 5) {

                    echo '$var_3===' . $var_3 .  '</br>';
                    echo 'V---' . $vTVENCIMENTO_ORI .  '</br>';
                    echo 'D---' . $vTDESCONTO_ORI .  '</br>';
                    echo '3---' . $vTVENCIMENTO_ORI . ' ' . $vTDESCONTO_ORI .  '</br>';
                    echo 'D---' . $vTDESCONTO_ORI .  '</br>';
                    echo 'var_4_p2---' . $var_4_p2 . '</br>';

                    echo 'EVENTOS var_55=' . $var_55 . '</br>';
                }

                //----------------------------------------------------------------------------------------------------------------------------------------------------------------//
                $texto = $var_55;
                $v11_5_9 = $var_55;
                $pattern = '/[0-9]{1},[0-9]{3}/'; //0,000

                preg_match_all($pattern, $texto, $matches);
                if (!empty($matches)) {
                    foreach ($matches[0] as $match) {
                        //echo '$match='.$match.'</br>';
                        $v11_5_9 = preg_replace('[' . $match . ']', substr($match, 0, 4) . ' ' . substr($match, 4, 5), $v11_5_9);
                    }
                }
                $var_55 = $v11_5_9;

                //----------------------------------------------------------------------------------------------------------------------------------------------------------------//
                $texto = $var_55;
                $v11_5_9 = $var_55;
                $pattern = '/[A-ZÀ-Ú]{1}[0-9]{1}\.[0-9]{3}\,[0-9]{2}\s/'; //L0.000,00

                preg_match_all($pattern, $texto, $matches);
                if (!empty($matches)) {
                    foreach ($matches[0] as $match) {
                        //echo '$match='.$match.'</br>';
                        $v11_5_9 = preg_replace('[' . $match . ']', substr($match, 0, 1) . ' ' . substr($match, 1, 8) . ' ', $v11_5_9);
                    }
                }
                $var_55 = $v11_5_9;

                if ($showEcho == 2) {
                    echo 'EVENTOS=====' . $var_55 . '</br>';
                }

                //----------------------------------------------------------------------------------------------------------------------------------------------------------------//

                $texto = $var_55;
                $v11_5_9 = $var_55;
                $pattern = '/[^\D]\s\d+\s/';

                preg_match_all($pattern, $texto, $matches);

                if (!empty($matches)) {
                    foreach ($matches[0] as $match) {
                        $v11_5_9 = preg_replace('[' . $match . ']', substr($match, 0, 1) . '|' . substr($match, 1, 6) . ' ', $v11_5_9);
                    }
                }

                if ($showEcho == 5) {
                    echo '-------------------------------------------' . '<br>';
                    echo '<br>$v11_5_9 = ' . $v11_5_9 . '<br>';
                    echo '-------------------------------------------' . '<br>';
                }

                //VERIFICA SE OS VALORIES DE VENCIMENTO E DESCONTO TOTAIS SAO IGUAIS E APLICA AJUSTE
                if($vTVENCIMENTO_ORI == $vTDESCONTO_ORI){
                    $pattern = '/\,\d{2}\s/'; //expressao regular
                    preg_match($pattern, $v11_5_9, $match);
                    $vtexto3 = strpos($v11_5_9, $match[0]); //Posiçao Inicio Evento
                    $v11_5_9 = substr($v11_5_9, 0,$vtexto3+3);
                    //echo '<br>$v11_5_9 = ' . $v11_5_9 . '<br>';
                    }
                
                $parte = explode('|', $v11_5_9);


                if ($showEcho == 5) {

                    echo '<br><br>Parte = ';
                    print_r($parte);
                    echo '<br><br>';
                }

                $count_eventos = 0;
                foreach ($parte as $i => $key) {
                    $i > 0;


                   

                    if (strlen($parte[$i]) != 0) {
                        $pattern0 = '/\s/i'; //expressao regular localiza 1 espaço

                        preg_match($pattern0, $parte[$i], $match0);
                        if (!empty($match0)) {
                            $var_evento0 = ($match0[0]);
                        } else {
                            $var_evento0 = '';
                        }

                        $texto3 = preg_replace('/\s/', '|', ltrim($parte[$i])) . '</br>';
                        $texto3 = str_replace('||', '|', $texto3);
                        $texto3 = str_replace('|||', '|', $texto3);
                        $texto3 = str_replace('|||||', '|', $texto3);
                        $texto3 = str_replace('||||||', '|', $texto3);

                        if ($showEcho == 1) {
                            echo 'Texto 3: ' . $texto3;
                        }


                        $EVENTO_CODIGO = substr(ltrim($parte[$i]), 0, strpos($texto3, '|')); //VARIAVEL CODIGO
                        $var_evento0_SCOD = substr(ltrim($parte[$i]), strpos($texto3, '|') + 1); //VARIAVEL SEM O CODIGO
                        $texto5 = preg_replace('/\s/', '|', ltrim(substr(strrev($var_evento0_SCOD), 0, 13)));


                        if ($showEcho == 5) {

                            echo 'SUBSTR VAR EVENTO=' . substr(strrev($var_evento0_SCOD), 0, 13) . '</br>';
                            echo 'VARIAVEL SEM O CODIGO=' . $var_evento0_SCOD . '</br>';
                            echo 'TEXTO5=' . $texto5 . '</br>';
                        }

                        $parte1 = explode('|', trim($texto5));

                        // echo 'TEXTO5=' . $texto5 . '</br>';
                        // echo '$parte1[0]='.$parte1[0].'<br>';

                        if (strlen($parte1[0]) != 0) {
                            // echo '----------EVENTO VALOR-------'.'<br>';
                            $EVENTO_VALOR = strrev(ltrim($parte1[0]));
                            strlen($EVENTO_VALOR); //tamanho campo valor

                            $url = strrev($var_evento0_SCOD);
                            $url = explode(ltrim($parte1[0]), $url);

                            $texto = $url[1];
                            $url2 = $url[1];

                            //echo 'strrev($url2)=='.strrev($url2). '</br>';

                            $pattern = '/\d{2},\d{2}|\d{2},\d{1}/'; //expressao regular 00.
                            preg_match_all($pattern, $texto, $matches);
                            if (!empty($matches)) {
                                foreach ($matches[0] as $match) {
                                    $url2 = preg_replace('[' . $match . ']', substr($match, 0, 2) . '.' . substr($match, 3, 2) . '|', $url2);
                                }
                            }

                            
                            $parte2 = explode('|', strrev($url2));

                            //echo   '$parte2[0]==='.$parte2[0].'<br>'; 

                            if (strlen($parte2[0]) != 0) {
                                // echo 'entrou evento nome----------------------'.'<br>';   
                                $EVENTO_NOME = ltrim($parte2[0]);
                            }

                            if (strlen($parte2[1]) != 0) {
                                $EVENTO_REFERENCIA = ltrim($parte2[1]);
                            }
                        }

                        // -EVENTO OK----------------------------------------------------------------------------------------------
                        if ($showEcho == 5) {
                            echo '<br>CODIGO========:' . $EVENTO_CODIGO . '</br>';
                            echo 'NOME EVENTO:==:' . $EVENTO_NOME . '</br>';
                            echo 'REFERENCIA====:' . $EVENTO_REFERENCIA . '</br>';
                        }

                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                        $EVENTO_VALOR = ltrim(str_replace('.', '', $EVENTO_VALOR));
                        $EVENTO_VALOR = ltrim(str_replace(',', '.', $EVENTO_VALOR));
                        $vNUMERIC = is_numeric($EVENTO_VALOR) ? true : false;
                        if ($vNUMERIC == 1) {
                            $EVENTO_VALOR = $EVENTO_VALOR;
                        } else {
                            $EVENTO_VALOR = '0';
                        }
                        if ($showEcho == 5) {
                            echo 'VALOR=========:' . $EVENTO_VALOR . '</br>';
                        }

                        //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

                        $codevento = trim($EVENTO_CODIGO);
                        $nomeevento = $EVENTO_NOME;
                        $tipo = 'P';
                        $qtdevento = $EVENTO_REFERENCIA;
                        $vlrevento = $EVENTO_VALOR;

                        if ($qtdevento == '') {
                            $qtdevento = 0.00;
                        }
                        if ($vlrevento == '') {
                            $vlrevento = 0;
                        }

                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------



                        //RECUPERANDO SE EVENTO ESTA CADASTRADO
                        foreach (selectGESEVE_acedata($tabela3, $id_emp_default, $codevento) as $select_GESEVE) {

                            $id_eve = $select_GESEVE['id_eve'];
                            $codevento_tabela = $select_GESEVE['codevento'];
                            $nomeevento_tabela = $select_GESEVE['nome'];
                        }

                        if ($codevento_tabela != $codevento) {

                            if ($showEcho == 1) {
                                echo '<br><br>Entrou no if cadasto eventos<br><br>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
                            }
                            if ($showBD == 1) {
                                //CADASTRAR EVENTO
                                try {

                                    $insert_tabela3 = insertGESEVE_acedata(
                                        $tabela3,
                                        $tipo,
                                        $codevento,
                                        $nomeevento,
                                        $id_emp_default,
                                        $datinc,
                                        $datatu,
                                        $id_usa_inc,
                                        $id_usa_atu
                                    );

                                    $id_eve = $insert_tabela3['pk'];
                                } catch (PDOException $erro) {

                                    die(($_SESSION['erro_importação'] = '1-' . $erro) . (header('Location:' . $erro_1)));
                                }
                            }
                        } else {
                            if ($showEcho == 1) {
                                $teste = $nomeevento_tabela;
                                echo '$EVENTO_NOME=' . $EVENTO_NOME . '</br>';
                                echo '$teste=' . $teste . '</br>';
                                echo '//----------------------------------' . '</br>';
                            }

                            if (trim($nomeevento) != trim($nomeevento_tabela)) {
                                //ALTERAR NOME EVENTO

                                if ($showEcho == 1) {
                                    echo '$nomeevento=' . $nomeevento . '</br>';
                                    echo '$id_usa=' . $id_usa . '</br>';
                                    echo '$id_eve=' . $id_eve . '</br>';
                                    echo '$today=' . $today . '</br>';
                                    echo '$nomeevento=' . $nomeevento . '</br>';
                                    echo '//----------------------------------' . '</br>';

                                    echo '<br><br>Entrou no else<br><br>';
                                }

                                if ($showBD == 1) {
                                    try {

                                        updateGESEVE_acedata(
                                            $tabela3,
                                            $nomeevento,
                                            $today,
                                            $id_usa,
                                            $id_eve
                                        );
                                    } catch (PDOException $erro) {

                                        die(($_SESSION['erro_importação'] = '2-' . $erro) . (header('Location:' . $erro_1)));
                                    }
                                }
                            }
                        }

                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                        if ($showEcho == 5) {
                            echo  '<br>Tabela2==' . $tabela2;
                            echo  '<br>codevento==' . $codevento;
                            echo  '<br>nomeevento=' . $nomeevento;
                            echo  '<br>Quantidade=' . $qtdevento;
                            echo  '<br>vlrevento==' . $vlrevento;
                            echo  '<br>id_im1==' . $id_im1;
                            echo  '<br>id_eve==' . $id_eve;
                            echo  '<br>today==' . $today . '<br/>';
                        }

                        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

                        if (!empty($id_eve)) {

                            if ($showBD == 1) {
                                try {

                                    insertGESIM2_LAYOUT(
                                        $tabela2,
                                        $codevento,
                                        $nomeevento,
                                        $qtdevento,
                                        $vlrevento,
                                        $id_im1,
                                        $id_eve,
                                        $today
                                    );
                                } catch (PDOException $erro) {

                                    die(($_SESSION['erro_importação'] = '3-' . $erro) . (header('Location:' . $erro_1)));
                                }
                            }
                        }
                        //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                        unset($EVENTO_CODIGO);
                        unset($EVENTO_NOME);
                        unset($EVENTO_REFERENCIA);
                        unset($EVENTO_VALOR);

                        if ($showEcho == 1) {
                            echo '<br><br><br>//--------------------------------------------------------------------------------------------------------//' . '</br>';
                        }
                    }
                }

                if ($showEcho == 1) {
                    echo '//------------------------------------------------------------------------FIM--------------------------------------------------------------------------------------------------------------//' . '</br></br></br>';
                }
            }

        endfor;

        //if ($v_cnpj == 0) {
        //ALTERA SITUAC PARA (9) QUANDO EXISTE MAIS DE UMA PAGINA PARA O HOLERITE

        ///    $query5 = 'UPDATE '.$tabela1.'  SET situac =  9 WHERE id_im1 in (SELECT id_im1 FROM '.$tabela1.'  where vlr_liquido = 0 and vlr_vencimento=0 and vlr_desconto=0);';
        //pg_query($conn, $query5)
        //or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
        ///    error_reporting(0);
        ///    pg_query($conn, $query5)
        ///    or die(header('Location:'.$erro_1));

        ///    $query6 = ' UPDATE '.$tabela2.' set id_im1=  id_im1+1 where id_im1 in (SELECT id_im1  FROM '.$tabela1.'   where situac=9 and id_processamento = '.$processamento.'  );';
        //pg_query($conn, $query6)
        //or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        ///    error_reporting(0);
        ///    pg_query($conn, $query6)
        ///    or die(header('Location:'.$erro_1));

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

        if ($showEcho == 0) {
            echo "<script language=javascript>
            location.href = '../../lotes_processados';
            </script>";
        }
    } else {
        $_SESSION['erro_importação'] = 'O arquivo importado não corresponde a empresa selecionada!';

        echo "<script language=javascript>
        location.href = '" . $erro_1 . "';
        </script>";
    }
} else {
    $_SESSION['erro_importação'] = 'O arquivo importado não é válido!';

    echo "<script language=javascript>
    location.href = '" . $erro_1 . "';
    </script>";
}
//}

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
