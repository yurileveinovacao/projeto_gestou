<?php

require '../restrito.php';
require_once '../conexao.php';
require_once '../util.php';
require_once '../iuds_pdo.php';

$id_emp_default = $_SESSION['id_emp_default'];
$today = date('Y-m-d H:i:s');
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = $_SESSION['descricao'];

$val3 = uniqidReal();
$processamento = $val3;

$origem = $_SESSION['nomepdf'];
$erro_1 = '../erro/erro_1'; //erro generico
$erro_3 = '../erro/erro_3'; //erro arquivo anexado

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO.pdf
foreach (select_id_emp_Layout($id_emp_default) as $select_gesemp) {

    $cpnj_gesemp = $select_gesemp['cnpj'];
}

//RECUPERANDO RAIZ CNPJ
$raiz1 = str_replace('.', '', $cpnj_gesemp);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Include Composer autoloader if not already done.
include '../vendor_ler_pdf/autoload.php';
//Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../uploads/' . $raiz4 . '.pdf');
$text = $pdf->getText();
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONTAGEM REGISTROS PDF
$html = $text;
$needle = substr($text, 0, 30);
$lastPos = 0;
$count = 0;
$positions = [];
//  Ativa Echo quando = 1
$showEcho = 0;
// Ativa Banco de Dados quando = 1
$showBD = 1;

if (strlen($html) == 0) {
    ($_SESSION['erro_importação'] = 'Não existem registros no arquivo selecionado!') . (header('Location:' . $erro_1));
} else {
    while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
        $positions[] = $lastPos;
        $lastPos = $lastPos + strlen($needle);
        $count = $count + 1;
    }

    if ($showEcho == 1) {
        echo 'Contagem: ' . $count . '<br /><br />';
    }
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    $empresa = '';
    $competencia = '';
    $regrex = 'Office Folha de Pagamento ';

    for ($i = 1; $i <= $count; ++$i) :
        $var = explode($needle, $text)[$i];
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v0 = strpos($var, 'Data do Crédito:'); //Achar Folha 1 e 2
        $v0_1 = substr($var, $v0 + 30, 1);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //----------------------------------------------------CPF
        $texto = $var;
        $pattern = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i'; //expressao regular cpf
        preg_match($pattern, $texto, $match);
        if (!empty($match)) {
            $v1_1 = $match[0];
        } else {
            $v1_1 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //----------------------------------------------------R.G.:
        $v24 = strpos($var, 'R.G.:'); //Inicio RG
        $v24_1 = substr($var, $v24 + 5, 30);
        $v24_2 = strpos($v24_1, 'T.P.:'); //Final RG
        $v24_3 = substr($v24_1, 0, $v24_2);
        $v24_4 = ltrim($v24_3);
        //echo '<br>-------'.$v24_4.'--------<br>';
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v4 = strpos($var, 'Data do Crédito:'); //competencia
        $v4_1 = substr($var, $v4 - 17, 30);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------

        $search = 'JAN';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'J');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'FEV';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'F');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'MAR';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'M');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'ABRIL';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'A');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'MAIO';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'M');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'JUN';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'J');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'JUL';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'J');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'AGO';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'A');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'SET';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'S');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'OUT';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'O');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'NOV';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'N');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        $search = 'DEZ';
        if (preg_match("/{$search}/i", $v4_1)) {
            $v4_1_0 = strpos($v4_1, 'D');
            $v4_1 = substr($v4_1, $v4_1_0 - 1);
        }

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v4_1_1 = strpos($v4_1, '/');
        $v4_1_2 = substr($v4_1, 0, $v4_1_1 + 5);
        $v4_1_3 = strpos($v4_1_2, ' ');
        $v4_1_4 = substr($v4_1_2, $v4_1_3 + 1, $v4_1_1 + 5);
        $v4_2 = ltrim($v4_1_4);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //------------------------------------------------CNPJ
        $v9_2 = strpos($var, 'Descontos'); //Inicio
        $v9 = strpos($var, 'Data do Crédito:'); //Fim
        $v9_3 = substr($var, $v9_2 + 17, $v9 - ($v9_2 + 17)); //trecho reduzido
        $texto = $v9_3;
        $pattern = '/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i'; //expressao regular cnpj
        preg_match($pattern, $texto, $match);
        if (!empty($match)) {
            $v9_4 = $match[0];
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v15 = strpos($var, 'Total de Descontos'); //Total Vencimentos
        $v15_1 = substr($var, $v15 + 19, 14);
        $v15_2 = strpos($v15_1, ',');
        $v15_3 = substr($v15_1, 0, $v15_2 + 3);
        $v15_4 = ltrim(str_replace('.', '', $v15_3));
        $v15_5 = ltrim(str_replace(',', '.', $v15_4));
        $v15_6 = is_numeric($v15_5) ? true : false;
        if ($v15_6 == 1) {
            $v15_5 = $v15_5;
        } else {
            $v15_5 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v16 = substr($var, $v15 + 19, 25); //Total Descontos
        $v16_1 = strpos($v16, ',');
        $v16_2 = substr($v16, $v16_1 + 3, 25);
        $v16_3 = strpos($v16_2, ',');
        $v16_4 = substr($v16_2, 0, $v16_3 + 3);
        $v16_5 = ltrim(str_replace('.', '', $v16_4));
        $v16_6 = ltrim(str_replace(',', '.', $v16_5));
        $v16_7 = is_numeric($v16_6) ? true : false;
        if ($v16_7 == 1) {
            $v16_6 = $v16_6;
        } else {
            $v16_6 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        
        
        $v6 = strpos($var, 'TOTAL LÍQUIDO'); //TOTAL LÍQUIDO
        $v6_1 = substr($var, $v6 + 15, 10);
        $v6_2 = strpos($v6_1, ',');
        $v6_3 = substr($var, $v6 + 15, $v6_2 + 3);
        $v6_4 = str_replace('.', '', $v6_3);
        $v6_6 = ltrim(str_replace(',', '.', $v6_4));
        $v6_7 = is_numeric($v6_6) ? true : false;
        if ($v6_7 == 1) {
            $v6_6 = $v6_6;
        } else {
            $v6_6 = '';
        }

        //echo 'var==='.$var.'<br>';
        //echo 'v6_6==='.$v6_6.'<br>';

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v18 = strpos($var, 'Faixa IRRF'); //Faixa IRRF
        $v18_1 = substr($var, $v18 + 11);
        $v18_2 = strpos($v18_1, ',');
        $v18_3 = substr($v18_1, 0, $v18_2 + 3);
        $v18_6 = ltrim(str_replace(',', '.', $v18_3));
        $v18_7 = is_numeric($v18_6) ? true : false;
        if ($v18_7 == 1) {
            $v18_6 = $v18_6;
        } else {
            $v18_6 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v17 = strpos($var, 'Base Cálc. IR. S/Fer. MP927'); //Base Cálc. IR. S/Fer. MP927
        $v17_1 = substr($var, $v17 + 28);
        $v17_2 = strpos($v17_1, ',');
        $v17_3 = substr($v17_1, 0, $v17_2 + 3);
        $v17_4 = ltrim(str_replace('.', '', $v17_3));
        $v17_7 = ltrim(str_replace(',', '.', $v17_4));
        $v17_8 = is_numeric($v17_7) ? true : false;
        if ($v17_8 == 1) {
            $v17_7 = $v17_7;
        } else {
            $v17_7 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v19 = strpos($var, 'Faixa IRRF'); //Sal.Contr.INSS
        $v19_1 = substr($var, $v19 + 11);
        $v19_2 = strpos($v19_1, ',');
        $v19_3 = substr($v19_1, $v19_2 + 4);
        $v19_4 = strpos($v19_3, ',');
        $v19_5 = substr($v19_3, 0, $v19_4 + 3);
        $v19_6 = str_replace('.', '', $v19_5);
        $v19_7 = ltrim(str_replace(',', '.', $v19_6));
        $v19_8 = is_numeric($v19_7) ? true : false;
        if ($v19_8 == 1) {
            $v19_7 = $v19_7;
        } else {
            $v19_7 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v20 = substr($v19_3, 0, $v19_4 + 60); //Base Calc. FGTS
        $v20_1 = strpos($v20, ',');
        $v20_2 = substr($v20, $v20_1 + 4, 30);
        $v20_3 = strpos($v20_2, ',');
        $v20_4 = substr($v20_2, 0, $v20_3 + 3);
        $v20_5 = str_replace('.', '', $v20_4);
        $v20_7 = ltrim(str_replace(',', '.', $v20_5));
        $v20_8 = is_numeric($v20_7) ? true : false;
        if ($v20_8 == 1) {
            $v20_7 = $v20_7;
        } else {
            $v20_7 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v21 = substr($v20, $v20_1 + 4, 60); //F.G.T.S. do Mês
        $v21_1 = strpos($v21, ',');
        $v21_2 = substr($v21, $v21_1 + 4, 60);
        $v21_3 = strpos($v21_2, ',');
        $v21_4 = substr($v21_2, 0, $v21_3 + 3);
        $v21_5 = str_replace('.', '', $v21_4);
        $v21_7 = ltrim(str_replace(',', '.', $v21_5));
        $v21_8 = is_numeric($v21_7) ? true : false;
        if ($v21_8 == 1) {
            $v21_7 = $v21_7;
        } else {
            $v21_7 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v22 = substr($v21_2, $v21_3 + 4, 60); //Base Cálc. IRRF
        $v22_1 = strpos($v22, ',');
        $v22_3 = substr($v22, 0, $v22_1 + 3);
        $v22_4 = str_replace('.', '', $v22_3);
        $v22_7 = ltrim(str_replace(',', '.', $v22_4));
        $v22_8 = is_numeric($v22_7) ? true : false;
        if ($v22_8 == 1) {
            $v22_7 = $v22_7;
        } else {
            $v22_7 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v23 = substr($v22, 0, $v22_1 + 60); //Salario Base
        $v23_1 = strpos($v23, ',');
        $v23_2 = substr($v23, $v23_1 + 4, 60);
        $v23_3 = strpos($v23_2, ',');
        $v23_4 = substr($v23_2, 0, $v23_3 + 3);
        $v23_5 = str_replace('.', '', $v23_4);
        $v23_6 = ltrim(str_replace(',', '.', $v23_5));
        $v23_7 = is_numeric($v23_6) ? true : false;
        if ($v23_7 == 1) {
            $v23_6 = $v23_6;
        } else {
            $v23_6 = '';
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $v12 = strpos($var, 'CARGO:'); //CARGO
        $v12_1 = substr($var, $v12 + 6, 100);
        $v12_2 = strpos($v12_1, 'Salário Base');
        $v12_3 = ltrim(substr($v12_1, 0, $v12_2));
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($v0_1 == '1') { //VERIFICAÇÃO PARA PAGINA 1 E PAGINA 2
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $v3 = strpos($var, 'Data do Crédito:'); //data credito
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------Nome
            $texto = $var;
            $pattern = '/\d{6}\s\-\s/'; //expressao regular [000000 - ]
            preg_match($pattern, $texto, $match);
            //echo $match[0].'<br>';

            $v5_1_1 = strpos($var, $match[0]); //Inicio Nome
            $v5_1_2 = substr($var, $v5_1_1 + 9);

            $texto = $v5_1_2;
            $pattern = '/\s\d{1}/'; //expressao regular proximo [ 0 ]
            preg_match($pattern, $texto, $match);
            //echo $match[0].'<br>';

            $v5_1_3 = strpos($v5_1_2, $match[0]); //Fim Nome
            $v5_1_4 = substr($v5_1_2, 0, $v5_1_3);
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        } else {
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $cnpj = $v9_4;
        $competencia = $v4_2;
        $rg = $v24_4;
        $cpf = str_replace(' ', '', str_replace('-', '', str_replace('.', '', $v1_1)));

        $nome = $v5_1_4;
        $cargo = $v12_3;
        $data_credito = inverteData(substr($var, $v3 + 18, 10));

        $vlr_vencimento = $v15_5;
        $vlr_desconto = $v16_6;
        $vlr_liquido = $v6_6;
        $faixa_irrf = $v18_6;
        $vlr_basesalario = $v23_6;
        $vlr_baseinss = $v19_7;
        $vlr_basefgts = $v20_7;
        $vlr_baseirrf = $v22_7;
        $vlr_baseir = $v17_7;
        $vlr_fgts = $v21_7;
        $situac = 0;
        $situac_politica = 0;
        $id_dep = 0;
        $cep = 00000000;
        $dependentes = 0;

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

        //------------------------------------------------------------------------
        //RECUPERANDO RAIZ CNPJ
        $raiz1 = str_replace('.', '', $cpnj_gesemp);
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

        //INSERT TABELA 1
        if ($cnpj == $cpnj_gesemp) {

            if ($showBD == 1) {

                // echo '<br><br>Id_emp: ' . $id_emp_default . '<br><br>';
                // echo 'cpf: ' . $cpf . '<br><br>';
                // echo 'rg: ' . $rg . '<br><br>';
                // echo 'nome: ' . $nome . '<br><br>';
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                //SELECT PARA VERIFICAR CADASTRO DE USUARIO
                foreach (selectGESUSU_LAYOUT_id_cpf_rg($tabela4, $cpf, $rg, $id_emp_default) as $select_tabela4) {
                    $id_usu = $select_tabela4['id_usu'];
                }

                // echo 'id_usu: ' . $id_usu . '<br><br>';

                if (empty($id_usu)) {
                    //echo '<br>---ENTROU NO ELSE---------------------------------------';
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    $senha = '$2y$10$Iipf8SP78Bt1iC1zyNLKcOtWYqto/gHQavJm3WmjJJxwoJHrt/K.e';
                    $id_mun = 11061;
                    //$DateAndTime = "'".date('Y-d-m h:i:s', time())."'";
                    $id_emp_ant = 0;
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    if (strlen($cpf) > 5) {

                        try {

                            $insert_tabela4 = insertGESUSU_folhamatic(
                                $tabela4,
                                $nome,
                                $cpf,
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
                                $situac_politica
                            );

                            $id_usu = $insert_tabela4['pk'];
                        } catch (PDOException $erro) {

                            die(($_SESSION['erro_importação'] = '01 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    } else {

                        try {

                            $insert_tabela4 = insertGESUSU_folhamatic(
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
                                $situac_politica
                            );

                            $id_usu = $insert_tabela4['pk'];
                        } catch (PDOException $erro) {

                            die(($_SESSION['erro_importação'] = '02 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    }
                }

                if (strlen($cpf) > 5) {

                    try {

                        $insert_tabela1 = insertGESIM1_folhamatic(
                            $tabela1,
                            $id_emp_default,
                            $competencia,
                            $rg,
                            $cpf,
                            $nome,
                            $cargo,
                            $data_credito,
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

                        die(($_SESSION['erro_importação'] = '03 - ' . $erro) . (header('Location:' . $erro_1)));
                    }
                } else {

                    try {

                        $select_tabela1 = insertGESIM1_folhamatic(
                            $tabela1,
                            $id_emp_default,
                            $competencia,
                            $rg,
                            NULL,
                            $nome,
                            $cargo,
                            $data_credito,
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

                        die(($_SESSION['erro_importação'] = '04 - ' . $erro) . (header('Location:' . $erro_1)));
                    }
                }
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            }
            //----------------------------------EVENTOS--------------------------------------------------------------------------------------------------------------------//
            $v112 = strpos($var, 'Pagamento de Salário'); //Inicio Eventos
            $v111 = strpos($var, 'Pagamento de 13º Salário'); //Inicio Eventos 13º Salario

            if ($v111 != '') {
                $v11 = $v111;
            } else {
                $v11 = $v112;
            }

            $v11_0 = substr($var, $v11);
            $texto = $v11_0;

            if ($showEcho == 1) {

                echo '<br>$texto ANTES=' . $texto . '<br><br>';
            }

            //-----------------------------------------------------------------------
            //-----------------------------------------------------------------------
            $pattern2 = '/\d{4}\/\d{4}\/\d{4}\s/'; //expressao regular [0000/0000/0000 ]
            preg_match($pattern2, $texto, $match2);

            if ((isset($match2[0]) == true) and ($match2[0] != null)) {
                $V11_0_1 = strpos($texto, $match2[0]); //Posiçao Inicio Evento
                $v11_19 = substr($texto, $V11_0_1 + 15);
                $texto = $v11_19;

                if ($showEcho == 1) {
                    echo '<br><br>$texto DEPOIS=' . $texto;
                }
            } else {

                if ($showEcho == 1) {
                    echo '<br>nao achou--------------';
                }
            }
            //-----------------------------------------------------------------------
            //-----------------------------------------------------------------------

            $pattern = '/\s[A-ZÀ-Ú]{1}[^a-z]{1}[A-ZÀ-Ú]{1}/'; //expressao regular  [ 2 Maiusculas ou 1 maiuscula + 1 Diferente Maiuscula + 1 maiuscula]
            preg_match($pattern, $texto, $match);
            // echo '<br>INICIO----'.($match[0]).'----<br><br>';
            $V11_0_1 = strpos($texto, $match[0]); //Posiçao Inicio Evento
            $v11_1 = substr($var, $v11 + 14);
            $V11_2 = strpos($texto, 'ASSINATURA'); //Posiçao Fim Eventos
            $v11_3 = substr($texto, $V11_0_1, $V11_2);

            // echo '<br>----FINAL='.$v11_3.'----<br>';

            //----------------------------------------------------------------------------------------------------------------------------------------------------------------//
            $texto = $v11_3;
            $v11_5_9 = $v11_3;
            $pattern = '/\d{1},\d{4}/'; //expressao regular .0000
            preg_match_all($pattern, $texto, $matches);
            if (!empty($matches)) {
                foreach ($matches[0] as $match) {
                    $v11_5_9 = preg_replace('[' . $match . ']', substr($match, 0, 1) . '.' . substr($match, 2, 4) . '|', $v11_5_9);
                }
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            $html1p = $v11_5_9;
            $v11_5_11 = $v11_5_9;
            $needle1p = ',';
            $lastPos1p = 0;
            $positions1p = [];
            $fim = 22;
            while (($lastPos1p = strpos($html1p, $needle1p, $lastPos1p)) !== false) {
                $positions1p[] = $lastPos1p;
                $lastPos1p = $lastPos1p + strlen($needle1p);
            }
            for ($xp = 0; $xp < sizeof($positions1p); ++$xp) { //percorre matriz e substitui por nova string
                if (strpos(substr($v11_5_9, $positions1p[$xp], 20), '|') == 0) {
                    $v11_5_11 = str_replace(substr($v11_5_9, $positions1p[$xp], $fim), substr($v11_5_9, $positions1p[$xp], 3) . '|' . substr($v11_5_9, $positions1p[$xp] + 3, $fim - 3), $v11_5_11) . '<br>';
                    //echo $v11_5_11.'-----------<br>';
                    $fim = $fim + 1;
                }
            }
            ///////////////////////////////////////encontra todas ocorrencias de |
            $html1 = $v11_5_11;
            $needle1 = '|';
            $lastPos1 = 0;
            $positions1 = [];

            while (($lastPos1 = strpos($html1, $needle1, $lastPos1)) !== false) {
                $positions1[] = $lastPos1 + 3;
                $lastPos1 = $lastPos1 + strlen($needle1);
            }
            // Encontra posiçoes da ,
            foreach ($positions1 as $value) {
                //echo $value.'<br />';
            }

            $y = 0;
            for ($x = 0; $x < sizeof($positions1); ++$x) {
                $result = substr($html1, $y, $positions1[$x] - $y); //posição inicial = 0, comprimento = $value
                $y = $positions1[$x];

                $texto1 = trim($result);
                $pattern = '/\s\d{4}\s/'; //expressao regular proximo [ 0000 ]
                preg_match($pattern, $texto1, $match);

                $texto2 = str_replace(trim($match[0]), '|', $texto1);
                $v29_2 = strpos($texto2, '|');
                $v29_3 = substr($texto2, 0, $v29_2);
                $texto3 = str_replace(trim($v29_3), '', $texto2);

                $v29_4 = strpos($texto3, ',');
                $v29_5 = substr($texto3, 0, $v29_4 + 4);
                $texto4 = str_replace(trim($v29_5), '', $texto3);

                $texto5 = str_replace('|', '', $texto4);
                $texto6 = str_replace('|', '', $v29_5);
                $texto6 = str_replace('.', '', $texto6);
                $texto6 = str_replace(',', '.', $texto6);

                //---------------------------------------------------------------------------------------------------------------------------------------------------------------

                $codevento = trim($match[0]);
                $nomeevento = trim($v29_3);
                $qtdevento = trim($texto5);
                $vlrevento = trim($texto6);
                $tipo = 'P';
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $qtdevento = preg_replace('/[^0-9,.]/', '', $qtdevento);
                $vlrevento = preg_replace('/[^0-9,.]/', '', $vlrevento);

                if ($qtdevento == '') {
                    $qtdevento = 0.00;
                }
                if ($vlrevento == '') {
                    $vlrevento = 0;
                }
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                if ($showBD == 1) {
                    //RECUPERANDO SE EVENTO ESTA CADASTRADO
                    foreach (selectGESEVE_folhamatic($tabela3, $id_emp_default, $codevento) as $select_tabela3) {

                        $id_eve = $select_tabela3['id_eve'];
                        $codtabela = $select_tabela3['codevento'];
                        $nometabela = $select_tabela3['nome'];
                    }

                    if ($codtabela != $codevento) {
                        //CADASTRAR EVENTO
                        try {

                            $insert_tabela3 = insertGESEVE_folhamatic(
                                $tabela3,
                                $tipo,
                                $codevento,
                                $nomeevento,
                                $id_emp_default,
                                $today,
                                $today,
                                $id_usa,
                                $id_usa
                            );

                            $id_eve = $insert_tabela3['pk'];
                        } catch (PDOException $erro) {

                            die(($_SESSION['erro_importação'] = '05 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    } else {
                        if ($nomeevento != $nometabela) {
                            //ALTERAR NOME EVENTO
                            try {

                                updateGESEVE_folhamatic(
                                    $tabela3,
                                    $nomeevento,
                                    $today,
                                    $id_usa,
                                    $id_eve
                                );
                            } catch (PDOException $erro) {

                                die(($_SESSION['erro_importação'] = '06 - ' . $erro) . (header('Location:' . $erro_1)));
                            }
                        }
                    }
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    if ($showEcho == 1) {
                        echo '<br><br>Valores a importar em GESIM2: <br>';
                        echo  '<br>codevento==' . $codevento;
                        echo  '<br>nomeevento=' . $nomeevento;
                        echo  '<br>Quantidade=' . $qtdevento;
                        echo  '<br>vlrevento==' . $vlrevento;
                        echo  '<br>Nome Funcionario==' . $nome;
                        echo  '<br>id_im1==' . $id_im1;
                        echo  '<br>RG==' . $rg;
                        echo  '<br>CPF==' . $cpf;
                        echo  '<br>id_eve==' . $id_eve;
                        echo  '<br>today==' . $today;
                        echo '<br><br>';
                    }

                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------

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

                        die(($_SESSION['erro_importação'] = '07 - ' . $erro) . (header('Location:' . $erro_1)));
                    }
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                }
            }

            $v_cnpj = 0;
        } else {
            $v_cnpj = 1;
        }

    endfor;

    if ($v_cnpj == 0) {
        //ALTERA SITUAC PARA (9) QUANDO EXISTE MAIS DE UMA PAGINA PARA O HOLERITE
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        try {

            updateGESIM1_folhamatic($tabela1);
        } catch (PDOException $erro) {

            die(($_SESSION['erro_importação'] = '08 - ' . $erro) . (header('Location:' . $erro_1)));
        }



        try {

            updateGESIM2_folhamatic($tabela2, $tabela1, $processamento);
        } catch (PDOException $erro) {

            die(($_SESSION['erro_importação'] = '09 - ' . $erro) . (header('Location:' . $erro_1)));
        }
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($showEcho == 0) {
            echo "<script language=javascript>
            location.href = '../lotes_processados';
            </script>";
        }
    } else {
        echo "<script language=javascript>
    location.href = '" . $erro_3 . "';
    </script>";
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
