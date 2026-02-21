<?php

require '../restrito.php';
require_once '../conexao.php';
require_once '../util.php';

$id_emp_default = $_SESSION['id_emp_default'];
$today = "'".date('Y-m-d H:i:s')."'";
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = "'".$_SESSION['descricao']."'";

$val3 = uniqidReal();
$processamento = "'".$val3."'";

$origem = "'".$_SESSION['nomepdf']."'";

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO.pdf
$sql = 'SELECT cnpj,nome from public."GESEMP" where id_emp='.$id_emp_default.'';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//RECUPERANDO RAIZ CNPJ
$raiz1 = str_replace('.', '', $linha['cnpj']);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
//GUARDAR NOME DA EMPRESA
$nomeEmpresa = $linha['nome'];

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// Include Composer autoloader if not already done.
include '../vendor_ler_pdf/autoload.php';
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('../uploads/'.$raiz4.'.pdf');
$text = $pdf->getText();
//echo '### Variavel $text leitura PDF inicio ### ' . $text . '<br>';
//echo '### Variavel $text leitura PDF fim ### <br><br>';
//---------------------------------------------------------------------------------------------------------------------------------------------------------------

//CONTAGEM REGISTROS PDF - BUSCA POR CNPJ QUE ESTÁ NO INICIO DO ARQUIVO LIDO
$html = $text;
$needle = substr($text, 0, 18);
//echo 'Valor variável $needle:' . $needle . '<br>';
$lastPos = 0;
$count = 0;
$positions = [];

//INICIO WHILE_1
while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
    $positions[] = $lastPos;
    $lastPos = $lastPos + strlen($needle);
    $count = $count + 1;
}
//FIM WHILE_1

//echo 'Contagem de envelopes: ' . $count . '<br><br>';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
$empresa = '';
$competencia = '';

//INICIO FOR PRINCIPAL
for ($cont1_i = 1; $cont1_i <= $count; ++$cont1_i) {
    //echo '################### INICIO FOR PRINCIPAL ################## valor de $cont1_i: ' . $cont1_i;
    //echo '<br>';
    //Gerar variável quebrando por $needle (CNPJ)
    $var = explode($needle, $text)[$cont1_i];
    $var1 = strpos($needle.$var, '.');
    //$var = substr($var, $var1 - 2);
    $var = substr($needle.$var, $var1 - 2);

    //echo '<br>$var-------'.$var.'--------<br>';

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    $v0 = strpos($var, 'Data de Crédito:'); //Achar Folha 1 e 2
    $v0_1 = substr($var, $v0 + 30, 1);
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //CPF
    $texto = $var;
    $pattern = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i'; //expressao regular cpf
    preg_match($pattern, $texto, $match);
    if (!empty($match)) {
        $v1_1 = $match[0];
    } else {
        $v1_1 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //RG
    $v24 = strpos($var, 'RG:'); //Inicio RG
    $vCTPS = strpos($var, 'CTPS'); //Inicio CTPS
    $v24_1 = substr($var, $v24 + 4, $vCTPS - $v24 - 5);
    $v24_2 = strpos($v24_1, 'TP:'); //Final RG
    $v24_3 = substr($v24_1, 0, $v24_2);
    $v24_4 = ltrim($v24_3);
    //echo '<br>-------'.$v24_4.'--------<br>';

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Competencia
    $v4 = strpos($var, 'Data de crédito:');
    $v4_1 = substr($var, $v4 + 17, 30);
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
    //CNPJ
    $v9_2 = strpos($var, 'Descontos'); //Inicio
    $v9 = strpos($var, 'Data de Crédito:'); //Fim
    $v9_3 = substr($var, 0, 18); //trecho reduzido

    //echo '<br>$v9_3---------------------------' . $v9_3 . '<br>';

    $texto = $v9_3;
    $pattern = '/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i'; //expressao regular cnpj

    preg_match($pattern, $texto, $match);
    if (!empty($match)) {
        $v9_4 = $match[0];
        //echo '$v9_4---------------' . $v9_4 . '<br>';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Total Descontos
    $v15 = strpos($var, 'Total de Descontos');
    $posicaoInicioBanco = strpos($var, 'Banco');
    $v15_1 = substr($var, $v15 + 19, $posicaoInicioBanco - $v15 + 19);
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
    //Total vencimentos
    $v16 = strpos($var, 'Total de Vencimentos');
    $v16_1 = strpos($var, 'Total de Descontos');
    $v16_2 = substr($var, $v16 + 21, $v16_1 - $v16);
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
    //Total liquido
    $v6 = strpos($var, 'TOTAL LIQUIDO');
    $posicaoInicialSalarioBase = strpos($var, 'Salário Base'); //Salario base
    $v6_1 = substr($var, $v6 + 14, $posicaoInicialSalarioBase - $v6);
    $v6_2 = strpos($v6_1, ',');
    $v6_3 = substr($var, $v6 + 14, $v6_2 + 3);
    $v6_4 = str_replace('.', '', $v6_3);
    $v6_6 = ltrim(str_replace(',', '.', $v6_4));
    $v6_7 = is_numeric($v6_6) ? true : false;
    if ($v6_7 == 1) {
        $v6_6 = $v6_6;
    } else {
        $v6_6 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Faixa IRRF
    $v18 = strpos($var, 'Faixa IRRF');
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
    //Base Cálc. IR. S/Fer. MP927
    $v17 = strpos($var, 'Base Cálc. S/Fer. MP927');
    $posicaoInicialDeclaro = strpos($var, 'DECLARO TER');
    $v17_1 = substr($var, $v17 + 25, $posicaoInicialDeclaro - $v17 - 25);
    $v17_2 = strpos($v17_1, ',');
    $v17_3 = substr($v17_1, 0, $v17_2);
    $v17_4 = str_replace('.', '', $v17_3);
    $v17_5 = substr($v17_1, $v17_2, 3);
    $v17_6 = str_replace(',', '.', $v17_5);
    $v17_7 = ltrim($v17_4.$v17_6);
    $v17_8 = is_numeric($v17_7) ? true : false;
    if ($v17_8 == 1) {
        $v17_7 = $v17_7;
    } else {
        $v17_7 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sal.Contr.INSS
    $v19 = strpos($var, 'Sal. Cont. INSS');
    $posicaoInicialBaseFGTS = strpos($var, 'Base para FGTS');
    $v19_1 = substr($var, $v19 + 16, $posicaoInicialBaseFGTS - $v19 - 16);
    $v19_2 = strpos($v19_1, ',');
    $v19_3 = substr($v19_1, 0, $v19_2);
    $v19_4 = substr($v19_1, $v19_2, 3);
    $v19_5 = str_replace(',', '.', $v19_4);
    $v19_6 = str_replace('.', '', $v19_3);
    $v19_7 = ltrim($v19_6.$v19_5);
    $v19_8 = is_numeric($v19_7) ? true : false;
    if ($v19_8 == 1) {
        $v19_7 = $v19_7;
    } else {
        $v19_7 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Base Calc. FGTS
    $posicaoInicialFGTSmes = strpos($var, 'FGTS do mês');
    $v20 = substr($var, $posicaoInicialBaseFGTS + 15, $posicaoInicialFGTSmes - $posicaoInicialBaseFGTS - 15);
    $v20_1 = strpos($v20, ',');
    $v20_2 = substr($v20, 0, $v20_1);
    $v20_3 = str_replace('.', '', $v20_2);
    $v20_4 = substr($v20, $v20_1, 3);
    $v20_5 = str_replace(',', '.', $v20_4);
    $v20_7 = ltrim($v20_3.$v20_5);
    $v20_8 = is_numeric($v20_7) ? true : false;
    if ($v20_8 == 1) {
        $v20_7 = $v20_7;
    } else {
        $v20_7 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //F.G.T.S. do Mês
    $v21 = strpos($var, 'FGTS do mês');
    $posicaoInicialBaseIRRF = strpos($var, 'Base Cál IRRF');
    $v21_1 = substr($var, $v21 + 13, $posicaoInicialBaseIRRF - $v21 - 13);
    $v21_2 = strpos($v21_1, ',');
    $v21_3 = substr($v21_1, 0, $v21_2);
    $v21_4 = str_replace('.', '', $v21_3);
    $v21_5 = substr($v21_1, $v21_2, 3);
    $v21_6 = str_replace(',', '.', $v21_5);
    $v21_7 = ltrim($v21_3.$v21_6);
    $v21_8 = is_numeric($v21_7) ? true : false;
    if ($v21_8 == 1) {
        $v21_7 = $v21_7;
    } else {
        $v21_7 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Base Cálc. IRRF
    $v22 = strpos($var, 'Base Cál IRRF');
    $posicaoInicialFaixaIRRF = strpos($var, 'Faixa IRRF');
    $v22_1 = substr($var, $v22 + 15, $posicaoInicialFaixaIRRF - $v22 - 15);
    $v22_2 = strpos($v22_1, ',');
    $v22_3 = substr($v22_1, 0, $v22_2);
    $v22_4 = str_replace('.', '', $v22_3);
    $v22_5 = substr($v22_1, $v22_2, 3);
    $v22_6 = str_replace(',', '.', $v22_5);
    $v22_7 = ltrim($v22_4.$v22_6);
    $v22_8 = is_numeric($v22_7) ? true : false;
    if ($v22_8 == 1) {
        $v22_7 = $v22_7;
    } else {
        $v22_7 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Salario Base
    $posicaoInicioSalContINSS = strpos($var, 'Sal. Cont. INSS');
    $v23 = substr($var, $posicaoInicialSalarioBase + 14, $posicaoInicioSalContINSS - $posicaoInicialSalarioBase - 14);
    $v23_1 = strpos($v23, ',');
    $v23_2 = substr($v23, 0, $v23_1);
    $v23_3 = ltrim(str_replace('.', '', $v23_2));
    $v23_4 = substr($v23, $v23_1, 3);
    $v23_5 = ltrim(str_replace(',', '.', $v23_4));
    $v23_6 = $v23_3.$v23_5;
    $v23_7 = is_numeric($v23_6) ? true : false;
    if ($v23_7 == 1) {
        $v23_6 = $v23_6;
    } else {
        $v23_6 = '';
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //CARGO
    $v12 = strpos($var, 'CARGO:');
    $v12_1 = substr($var, $v12 + 6, 100);
    $v12_2 = strpos($v12_1, 'Salário Base');
    $v12_3 = ltrim(substr($v12_1, 0, $v12_2));

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //VERIFICAÇÃO PARA PAGINA 1 E PAGINA 2
    if ($v0_1 == '1') {
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //data credito
        $v3 = strpos($var, 'Data de Crédito:');

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //Nome
        $texto = $var;
        $pattern = '/\d{6}\s\-\s/'; //expressao regular [000000 - ]

        preg_match($pattern, $texto, $match);
        echo $match[0].'<br>';

        $v5_1_1 = strpos($var, $match[0]); //Inicio Nome
        $v5_1_2 = substr($var, $v5_1_1 + 9);

        $texto = $v5_1_2;
        $pattern = '/\s\d{1}/'; //expressao regular proximo [ 0 ]
        preg_match($pattern, $texto, $match);
        //echo $match[0].'<br>';

        $v5_1_3 = strpos($v5_1_2, $match[0]); //Fim Nome
        $v5_1_4 = substr($v5_1_2, 0, $v5_1_3);
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Apresentar variaveis
    $cnpj = "'".$v9_4."'";
    //echo '$cnpj-----------' . $cnpj . '<br>';
    $competencia = "'".$v4_2."'";
    //echo '$competencia----------' . $competencia . '<br>';
    $rg = "'".$v24_1."'";
    //echo '$rg--------' . $rg . '<br>';
    $cpf = "'".str_replace(' ', '', str_replace('-', '', str_replace('.', '', $v1_1)))."'";
    //echo '$cpf----------' . $cpf . '<br>';
    $posicaoInicioNome = strpos($var, 'Nome do funcionário');
    $posicaoFinalNome = strpos($var, 'Código');
    $v5_1_4 = substr($var, $posicaoInicioNome + 21, $posicaoFinalNome - $posicaoInicioNome - 21);
    $nome = "'".$v5_1_4."'";
    //echo '$nome---------------' . $nome . '<br>';
    $posicaoInicioCargo = strpos($var, 'Cargo:');
    $posicaoFinalCargo = strpos($var, 'TOTAL LIQUIDO');
    $v12_3 = substr($var, $posicaoInicioCargo + 7, $posicaoFinalCargo - $posicaoInicioCargo - 8);
    $cargo = "'".$v12_3."'";
    //echo '$cargo---------------' . $cargo . '<br>';
    $posicaoInicioDataCredito = strpos($var, 'Data de crédito:');
    $data_credito = "'".inverteData(substr($var, $posicaoInicioDataCredito + 18, 10))."'";
    //echo '$data_credito---------------' . $data_credito . '<br>';
    $vlr_vencimento = "'".$v15_5."'";
    //echo '$vlr_vencimento---------------' . $vlr_vencimento . '<br>';
    $vlr_desconto = "'".$v16_6."'";
    //echo '$vlr_desconto---------------' . $vlr_desconto . '<br>';
    $vlr_liquido = "'".$v6_6."'";
    //echo '$vlr_liquido---------------' . $vlr_liquido . '<br>';
    $faixa_irrf = "'".$v18_6."'";
    //echo '$faixa_irrf---------------' . $faixa_irrf . '<br>';
    $vlr_basesalario = "'".$v23_6."'";
    //echo '$vlr_basesalario---------------' . $vlr_basesalario . '<br>';
    $vlr_baseinss = "'".$v19_7."'";
    //echo '$vlr_baseinss------------------' . $vlr_baseinss . '<br>';
    $vlr_basefgts = "'".$v20_7."'";
    //echo '$vlr_basefgts------------------' . $vlr_basefgts . '<br>';
    $vlr_baseirrf = "'".$v22_7."'";
    //echo '$vlr_baseirrf------------------' . $vlr_baseirrf . '<br>';
    $vlr_baseir = "'".$v17_7."'";
    //echo '$vlr_baseir------------------' . $vlr_baseir . '<br>';
    $vlr_fgts = "'".$v21_7."'";
    //echo '$vlr_fgts------------------' . $vlr_fgts . '<br>';
    $situac = 0;
    $situac_politica = 0;
    $id_dep = 0;
    $cep = "'00000000'";
    $dependentes = "'0'";

    if ($vlr_vencimento == "''") {
        $vlr_vencimento = "'0.00'";
    }

    if ($vlr_desconto == "''") {
        $vlr_desconto = "'0.00'";
    }

    if ($vlr_liquido == "''") {
        $vlr_liquido = "'0.00'";
    }

    if ($faixa_irrf == "''") {
        $faixa_irrf = "'0.00'";
    }
    if ($vlr_basesalario == "''") {
        $vlr_basesalario = "'0.00'";
    }

    if ($vlr_baseinss == "''") {
        $vlr_baseinss = "'0.00'";
    }
    if ($vlr_basefgts == "''") {
        $vlr_basefgts = "'0.00'";
    }

    if ($vlr_baseirrf == "''") {
        $vlr_baseirrf = "'0.00'";
    }

    if ($vlr_baseir == "''") {
        $vlr_baseir = "'0.00'";
    }

    if ($vlr_fgts == "''") {
        $vlr_fgts = "'0.00'";
    }

    //------------------------------------------------------------------------
    $sql = 'SELECT cnpj from public."GESEMP" where id_emp='.$id_emp_default.'';
    $res = pg_exec($conn, $sql);
    $linha = pg_fetch_assoc($res);

    //RECUPERANDO RAIZ CNPJ
    $raiz1 = str_replace('.', '', $linha['cnpj']);
    $raiz2 = str_replace('-', '', $raiz1);
    $raiz3 = str_replace('/', '', $raiz2);
    $raiz4 = substr($raiz3, 0, 8);

    //-------------------------------------------------------------------------
    //VARIAVEIS PARA NOMES TABELAS
    $raiz_cnpj = $raiz4;
    $tabela1 = 'public."GESIM1_'.$raiz_cnpj.'"';
    $tabela2 = 'public."GESIM2_'.$raiz_cnpj.'"';
    $tabela3 = 'public."GESEVE"';
    $tabela4 = 'public."GESUSU"';

    //-------------------------------------------------------------------------
    //CRIAR ID_VALIDADOR
    $val1 = uniqid();
    $val2 = uniqidReal();
    $validador = $raiz_cnpj.$val1.$val2;
    $validador = "'".$validador."'";

    //-------------------------------------------------------------------------
    //INICIO INSERT TABELA 1
    if ($v9_4 == $linha['cnpj']) {
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //SELECT PARA VERIFICAR CADASTRO DE USUARIO
        $sql_u = 'SELECT id_usu from '.$tabela4.' where cpf='.$cpf.'';
        //echo $sql_u . '<br>';
        $res_u = pg_exec($conn, $sql_u);
        $linha_u = pg_fetch_assoc($res_u);

        if (!empty($linha_u['id_usu'])) {
            //echo '<br>---ENTROU NO IF DO SELECT PARA VERIFICAR CADASTRO DE USUARIO---------------------------------------';
            $id_usu = $linha_u['id_usu'];
        } else {
            //echo '<br>---ENTROU NO ELSE DO SELECT PARA VERIFICAR CADASTRO DE USUARIO---------------------------------------';
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //$senha = 123;
            //$senha = "'".password_hash($senha, PASSWORD_DEFAULT)."'";
            $senha = "'".'$2y$10$Iipf8SP78Bt1iC1zyNLKcOtWYqto/gHQavJm3WmjJJxwoJHrt/K.e'."'";
            $id_mun = "'11061'";
            //$DateAndTime = "'".date('Y-d-m h:i:s', time())."'";
            $id_emp_ant = 0;
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //echo '<br>';

            // echo '<br>1='.$nome;
            // echo '<br>2='.$cpf;
            // echo '<br>3='.$senha;
            // echo '<br>4='.$today;
            // echo '<br>5='.$situac;
            // echo '<br>6='.$rg;
            // echo '<br>7='.$id_mun;
            // echo '<br>8='.$cargo;
            // echo '<br>9='.$id_emp_default;
            // echo '<br>10='.$id_emp_ant;
            // echo '<br>11='.$today;
            // echo '<br>12='.$id_usa;
            // echo '<br>13='.$id_dep;
            // echo '<br>14='.$cep;
            // echo '<br>15='.$dependentes;
            // echo '<br>16='.$situac_politica;

            if (strlen($cpf) > 5) {
                $query_i = 'INSERT INTO '.$tabela4.' (nome, cpf, senha, datinc, situac, rg, id_mun, funcao, id_emp, id_emp_ant,datatu,id_usa_inc,id_dep,cep,dependentes,situac_politica)
                VALUES ('.$nome.','.$cpf.','.$senha.','.$today.','.$situac.','.$rg.','.$id_mun.','.$cargo.','.$id_emp_default.','.$id_emp_ant.','.$today.','.$id_usa.','.$id_dep.','.$cep.','.$dependentes.','.$situac_politica.')  RETURNING id_usu as pk;';
                //echo '<br>';
                //echo $query_i;
                $id_usu = pg_fetch_result(pg_query($conn, $query_i), 0, 'pk')
                or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
            } else {
                $query_i = 'INSERT INTO '.$tabela4.' (nome, cpf, senha, datinc, situac, rg, id_mun, funcao, id_emp, id_emp_ant,datatu,id_usa_inc,id_dep,cep,dependentes,situac_politica)
                VALUES ('.$nome.',NULL, '.$senha.','.$today.','.$situac.','.$rg.','.$id_mun.','.$cargo.','.$id_emp_default.','.$id_emp_ant.','.$today.','.$id_usa.','.$id_dep.','.$cep.','.$dependentes.','.$situac_politica.')  RETURNING id_usu as pk;';
                //echo $query_i;
                $id_usu = pg_fetch_result(pg_query($conn, $query_i), 0, 'pk')
                or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
            }
        }
        //echo '<br>';
        if (strlen($cpf) > 5) {
            $query = 'INSERT INTO '.$tabela1.' (id_emp,competencia,rg,cpf,nome,cargo,data_credito,vlr_vencimento,vlr_desconto,vlr_liquido,faixa_irrf,vlr_basesalario,vlr_baseinss,vlr_basefgts,vlr_baseirrf,vlr_baseir,vlr_fgts,situac,id_usu,datinc,id_usa_inc,descricao,id_validador,id_processamento,origem)
         VALUES ('.$id_emp_default.','.$competencia.','.$rg.','.$cpf.','.$nome.','.$cargo.','.$data_credito.','.$vlr_vencimento.','.$vlr_desconto.','.$vlr_liquido.','.$faixa_irrf.','.$vlr_basesalario.','.$vlr_baseinss.','.$vlr_basefgts.','.$vlr_baseirrf.','.$vlr_baseir.','.$vlr_fgts.','.$situac.','.$id_usu.','.$today.','.$id_usa.','.$descricao_recibo.','.$validador.','.$processamento.','.$origem.');';
        } else {
            $query = 'INSERT INTO '.$tabela1.' (id_emp,competencia,rg,cpf,nome,cargo,data_credito,vlr_vencimento,vlr_desconto,vlr_liquido,faixa_irrf,vlr_basesalario,vlr_baseinss,vlr_basefgts,vlr_baseirrf,vlr_baseir,vlr_fgts,situac,id_usu,datinc,id_usa_inc,descricao,id_validador,id_processamento,origem)
         VALUES ('.$id_emp_default.','.$competencia.','.$rg.',NULL,'.$nome.','.$cargo.','.$data_credito.','.$vlr_vencimento.','.$vlr_desconto.','.$vlr_liquido.','.$faixa_irrf.','.$vlr_basesalario.','.$vlr_baseinss.','.$vlr_basefgts.','.$vlr_baseirrf.','.$vlr_baseir.','.$vlr_fgts.','.$situac.','.$id_usu.','.$today.','.$id_usa.','.$descricao_recibo.','.$validador.','.$processamento.','.$origem.');';
        }

        //echo '<br>';
        //echo $query;
        //echo '<br>';

        pg_query($conn, $query)
        or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $sql = 'SELECT id_im1 from '.$tabela1.' where situac=0 and cpf='.$cpf.' order by id_im1 desc';
        $res = pg_exec($conn, $sql);
        $linha = pg_fetch_assoc($res);

        //----------------------------------EVENTOS--------------------------------------------------------------------------------------------------------------------//
        $v112 = strpos($var, 'C.B.O.') + 12; //Inicio Eventos
        $v111 = strpos($var, 'Pagamento de 13º Salário'); //Inicio Eventos 13º Salario

        if ($v111 != '') {
            $v11 = $v111;
        } else {
            $v11 = $v112;
        }

        $v11_0 = substr($var, $v11);
        $posicaoInicialRG = strpos($v11_0, 'RG:');
        $v11_0_1 = substr($v11_0, 0, $posicaoInicialRG);
        $texto = $v11_0_1;

        //echo '<br>$texto ANTES=' . $texto . '<br>';

        //########################## inicio ######################################

        //localizo todas ocorrencias que possuem o texto 0000
        preg_match_all('/\s\d{4}\s/', $texto, $matches);

        //Declarar array para guardar os numeros dos eventos para serem procurados depois
        $eventos1 = [];

        //Declarar array para guardar a posição do evento
        $posicaoEvento = [];

        //Contador
        $cont2_i = 1;

        //Posicao array
        $ultimaPosicao = 1;

        //Percorrer o array para recuperar os valores encontrados pela busca usando pattern e aguarda-los no array $eventos1
        //echo '<br> percorrer array para recuperar valores encontrados pelo pattern <br>';
        foreach ($matches[0] as $value) {
            $eventos1[$cont2_i] = trim(PHP_EOL.$value);
            //echo '$eventos1 = ' . $eventos1[$cont2_i] . '<br>';
            ++$cont2_i;
        }

        //Total de eventos localizados
        $total = count($eventos1);

        //Percorrer array $eventos1 para localizar as suas posições dentro da string
        //echo '<br>';
        //echo '<br>';
        //echo 'INICIO FOR PARA LOCALIZAR POSIÇOES DENTRO DA STRING <br>';
        //echo '<br>';
        //echo '<br>';
        //FIM FOR PARA LOCALIZAR POSIÇOES DENTRO DA STRING
        $novoTexto = $texto;
        for ($cont3_i = 1; $cont3_i <= $total; ++$cont3_i) {
            //echo 'Percorrer array $eventos1 para localizar as suas posições dentro da string = ';
            //echo strpos($novoTexto,$eventos1[$cont3_i]);
            //echo '<br>';
            $posicaoEvento[$cont3_i] = strpos($novoTexto, $eventos1[$cont3_i]);
            $novoTexto = substr_replace($novoTexto,'XXXX',$posicaoEvento[$cont3_i],4); // adicionei esta linha para contornar o problema quando existe o mesmo codevento dentro do envelope
            //echo '<br>';
            //echo '$posicaoEvento[$cont3_i] = ' . $posicaoEvento[$cont3_i];
            //echo '<br>';
        }
        //FIM FOR PARA LOCALIZAR POSIÇOES DENTRO DA STRING

        //Variaveis para armazenamento de valores
        $codEvento = '';
        $descricaoEvento = '';
        $tamanhoString = strlen($text);
        $valorReferencia = '';
        $valorEvento = '';

        //INICIO FOR PARA IMPRIMIR O RANGE DE POSIÇOES QUE SERÃO ANALIZADAS PELO SCRIPT
        for ($cont4_i = 1; $cont4_i <= $total; ++$cont4_i) {
            //Imprimir as posições inicial e final
            if ($posicaoEvento[$cont4_i + 1] != null) {
                //echo 'entrei no IF Imprimir as posições inicial e final <br>';
                //echo 'Posicão inicial : ' . $posicaoEvento[$cont4_i] . ' - até - ' . $posicaoEvento[$cont4_i + 1];
                //echo '<br>';
            } else {
                //echo 'entrei no ELSE Imprimir as posições inicial e final <br>';
                //echo 'Posicão inicial : ' . $posicaoEvento[$cont4_i] . ' - até - ' . $tamanhoString;
                //echo '<br>';
            }

            //verifico se a posição inicial é 1
            if ($cont4_i == 1) {
                //echo 'entrei no IF $cont4_i <br>';
                //echo '<br>';
                $varTexto = trim(substr($texto, $ultimaPosicao, $posicaoEvento[$cont4_i + 1] - 1));
                //echo '<br>$varTexto--' . $varTexto;
                //echo '<br>';
                $varTexto1 = substr($varTexto, 5);
                //echo '$varTexto1--'. $varTexto1;
                //echo '<br>';

                //INICIO FOR PARA PERCORRER A STRING $VARTEXTO1 QUE POSSUI O NOME EVENTO, REFERENCIA E VALOR
                for ($cont5_i = 0; $cont5_i <= strlen($varTexto1); ++$cont5_i) {
                    //echo substr($varTexto1,$cont5_i,1); //imprime seperadamente cada caractere da string
                    if (substr($varTexto1, $cont5_i, 1) == ',') {
                        //echo '$var1 ----' . $var1;
                        //echo '<br>';
                        $codEvento = substr($varTexto, 0, 4);
                        //echo '$codEvento = ' . $codEvento;
                        //echo '<br>';
                        //echo 'Posição da virgula = ' . strpos($varTexto1,',');
                        $valorReferencia = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') - 2, 5)));
                        //echo '<br>';
                        //echo '$valorReferencia =' . $valorReferencia;
                        //echo '<br>';
                        $descricaoEvento = substr($varTexto1, 0, strpos($varTexto1, ',') - 2);
                        //echo '$descricaoEvento =' . $descricaoEvento;
                        //echo '<br>';
                        $valorEvento = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') + 4, strlen($varTexto1))));
                        //echo '$valorEvento =' . $valorEvento;
                    }
                    //echo '<br>';
                }
                //FINAL FOR PARA PERCORRER A STRING $VARTEXTO1 QUE POSSUI O NOME EVENTO, REFERENCIA E VALOR
            } else {
                //echo 'entrei no ELSE $cont4_i <br>';
                //verifico se a ultima posição é null, se não for, incremento  a posição, se for troco a ultima posicao para o tamanho da string
                //echo 'verificando variaveis <br>';
                //echo 'vardump : ';
                //var_dump($ultimaPosicao);

                //echo '$texto : ';
                //echo $texto;
                //echo '<br>';

                if ($posicaoEvento[$cont4_i + 1] != null) {
                    //echo 'entrei no IF $posicaoEvento <br>';
                    $varTexto = trim(substr($texto, $ultimaPosicao, ($posicaoEvento[$cont4_i + 1] - $ultimaPosicao)));
                    //echo '$varTexto--' . $varTexto;
                    $varTexto1 = substr($varTexto, 5);
                    //echo '<br>';
                    for ($cont6_i = 0; $cont6_i <= strlen($varTexto1); ++$cont6_i) {
                        //echo 'entrei no for $cont6_i e executei a passagem: ' . $cont6_i . '<br>';
                        if (substr($varTexto1, $cont6_i, 1) == ',') {
                            //echo 'entrei no if $varTexto1 que procura a virgula<br>';
                            $codEvento = substr($varTexto, 0, 4);
                            $valorReferencia = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') - 2, 5)));
                            $descricaoEvento = substr($varTexto1, 0, strpos($varTexto1, ',') - 2);
                            $valorEvento = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') + 4, strlen($varTexto1))));
                        }
                    }
                    //echo '<br>';
                    //echo '#################' . '<br>';
                    //echo '$codEvento : ' .  $codEvento . '<br>';
                    //echo '$valorReferencia : ' .  $valorReferencia . '<br>';
                    //echo '$descricaoEvento : ' .  $descricaoEvento . '<br>';
                    //echo '$valorEvento : ' .  $valorEvento . '<br>';
                    //echo '#################';
                    //echo '<br>';
                } else {
                    //echo 'entrei no ELSE $posicaoEvento <br>';
                    //Troco a ultima posicao para o tamanho da string
                    //echo '<br>';
                    $varTexto = trim(substr($texto, $ultimaPosicao, $tamanhoString));
                    //echo '$var--' . $varTexto;
                    $varTexto1 = substr($varTexto, 5);
                    for ($cont7_i = 0; $cont7_i <= strlen($varTexto1); ++$cont7_i) {
                        if (substr($varTexto1, $cont7_i, 1) == ',') {
                            $codEvento = substr($varTexto, 0, 4);
                            $valorReferencia = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') - 2, 5)));
                            $descricaoEvento = substr($varTexto1, 0, strpos($varTexto1, ',') - 2);
                            $valorEvento = str_replace(',', '.', str_replace('.', '', substr($varTexto1, strpos($varTexto1, ',') + 4, strlen($varTexto1))));
                        }
                    }
                    //echo '<br>';
                }
            }

            //echo '#####################<br>';
            //echo 'substr($varTexto) :' . $varTexto . '<br>';
            //echo '#####################';

            $codEvento = $eventos1[$cont4_i];
            //echo '<br>------INICIO Dados extraidos-------<br>';
            //echo '$codEvento-----------:' . $codEvento . '<br>';
            //echo '$valorReferencia-----------:' . $valorReferencia . '<br>';
            //echo '$descricaoEvento-----------:' . $descricaoEvento . '<br>';
            //echo '$valorEvento-----------:' . $valorEvento . '<br>';
            //echo '$posicaoEvento --------:' . $posicaoEvento[$cont4_i + 1] . '<br>';
            
            //echo '<br>';
            $ultimaPosicao = $posicaoEvento[$cont4_i + 1];
            //echo '$posicaoEvento --------:' . $ultimaPosicao;
            //echo '<br>';
            //echo '------FIM Dados extraidos-------<br>';
            //########################## fim ######################################

            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            $id_im1 = trim($linha['id_im1']);
            //$codevento = "'".trim($match[0])."'";
            $codevento = "'".trim($codEvento)."'";
            $nomeevento = "'".trim($descricaoEvento)."'";
            $qtdevento = "'".trim($valorReferencia)."'";
            $vlrevento = "'".trim($valorEvento)."'";
            $tipo = "'P'";
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //$qtdevento = preg_replace('/[^0-9,.]/', '', $qtdevento);
            //$vlrevento = preg_replace('/[^0-9,.]/', '', $vlrevento);

            if ($qtdevento == '') {
                $qtdevento = "'0.00'";
            }
            if ($qtdevento == "''") {
                $qtdevento = "'0.00'";
            }
            if ($vlrevento == "''") {
                $vlrevento = "'0'";
            }
            if ($vlrevento == '') {
                $vlrevento = "'0'";
            }
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //RECUPERANDO SE EVENTO ESTA CADASTRADO
            $sql2 = 'SELECT id_eve,codevento,nome from '.$tabela3.' where id_emp='.$id_emp_default.' and codevento='.$codevento.'';

            //echo 'RECUPERANDO SE EVENTO ESTA CADASTRADO <br>';
            //echo '<br>' . $sql2 . '<br>';

            $res3 = pg_exec($conn, $sql2);
            $linha2 = pg_fetch_assoc($res3);
            $id_eve = $linha2['id_eve'];

            //echo '<br> $codevento = ' . str_replace("'", '', $codevento) . '<br>';
            //echo '<br> $linha2 = ' . $linha2['codevento'];

            if ($linha2['codevento'] != str_replace("'", '', $codevento)) {
                //echo 'entrei no if cadastrar evento <br>';
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                //CADASTRAR EVENTO
                //echo 'cadastrar evento <br>';
                //echo '$nomeevento :' . $nomeevento;
                //echo '<br>';
                $query3 = 'INSERT INTO '.$tabela3.' (tipo,codevento,nome,id_emp,datinc,datatu,id_usa_inc,id_usa_atu)
                    VALUES ('.$tipo.','.$codevento.','.$nomeevento.','.$id_emp_default.','.$today.','.$today.','.$id_usa.','.$id_usa.') RETURNING id_eve as pk_eve;';
                $id_eve = pg_fetch_result(pg_query($conn, $query3), 0, 'pk_eve')
                    or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
            //echo '<br>';
            //echo $query3;
            } else {
                //echo '<br>entrei no else cadastrar evento <br>';
                if ($nomeevento != $linha2['nome']) {
                    //echo 'entrei no if $nomeevento != nome <br>';
                    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                    //ALTERAR NOME EVENTO
                    $query4 = 'UPDATE '.$tabela3.'  SET nome =  '.$nomeevento.',  datatu =  '.$today.',  id_usa_atu =  '.$id_usa.' WHERE id_eve='.$id_eve.'';
                    pg_query($conn, $query4)
                    or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
                    //echo '<br> $query4 <br>';
                    //echo $query4;
                }
            }

            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            //echo  '<br>codevento=='.$codevento;
            //echo  '<br>nomeevento='.$nomeevento;
            //echo  '<br>Quantidade='.$qtdevento;
            //echo  '<br>vlrevento=='.$vlrevento;
            //echo  '<br>id_im1=='.$id_im1;
            //echo  '<br>id_eve=='.$id_eve;
            //echo  '<br>today=='.$today;
            //echo  '<br>';
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            // $res2 = pg_exec($conn, $sql);
            //echo '<br>';
            $query2 = 'INSERT INTO '.$tabela2.' (codevento,nome,quantidade,valor,id_im1,id_eve,datinc)
                 VALUES ('.$codevento.','.$nomeevento.','.$qtdevento.','.$vlrevento.','.$id_im1.','.$id_eve.','.$today.');';
            //echo '<br>'; // removi o comentario aqui
            //echo $query2; // removi o comentario aqui
            //echo '<br>';
            pg_query($conn, $query2)
            or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
            //---------------------------------------------------------------------------------------------------------------------------------------------------------------

            //echo '<br>*******verifica incremento posicao************<br>';
            //echo '$ultimaPosicao - ' . $ultimaPosicao . '<br>';
            //echo '$posicaoEvento[$cont4_i + 1] - ' . $posicaoEvento[$cont4_i + 1] . '<br>';
            //echo '<br>*******alterei ultima posicao************<br>';

            //Altero a ultima posição para ler o proximo registro
            $ultimaPosicao = $posicaoEvento[$cont4_i + 1].'<br>';
            //echo '$cont4_i : ' . $cont4_i . '<br>';
            //var_dump($cont4_i);
            //echo '$ultimaPosicao - ' . $ultimaPosicao . '<br>';
        }
        //FINAL FOR PARA IMPRIMIR O RANGE DE POSIÇOES QUE SERÃO ANALIZADAS PELO SCRIPT

        //echo '<br>';
        //echo 'Listagem eventos encontrados, total: ' . $total . '<br><br>';

        for ($cont8_i = 1; $cont8_i <= $total; ++$cont8_i) {
            //echo '<br>';
            //echo '$eventos1 = ' . $eventos1[$cont8_i];
            //echo '<br>';
        }

        $v_cnpj = 0;
    }
    //FIM IF INSERT TABELA 1
    else {
        $v_cnpj = 1;
    }
}
//FIM FOR PRINCIPAL

//ALTERA SITUAC PARA (9) QUANDO EXISTE MAIS DE UMA PAGINA PARA O HOLERITE
if ($v_cnpj == 0) {
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    // $query5 = 'UPDATE '.$tabela1.'  SET situac =  9 WHERE id_im1 in (SELECT id_im1 FROM '.$tabela1.'  where vlr_liquido = 0 and vlr_vencimento=0 and vlr_desconto=0);';
    // pg_query($conn, $query5)
    //  or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');

    // $query6 = ' UPDATE '.$tabela2.' set id_im1=  id_im1+1 where id_im1 in (SELECT id_im1  FROM '.$tabela1.'   where situac=9 and id_processamento = '.$processamento.'  );';
    // pg_query($conn, $query6)
    // or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------

    echo "<script language=javascript>
           location.href = '../lotes_processados';
        </script>";
} else {
    echo "<script language=javascript>
            alert('ARQUIVO ANEXADO NÃO PERTENCE A ESSA EMPRESA!!');
            location.href = '../recibo_pagamento';
        </script>";
}

//FUNCAO INVERTEDATA
function inverteData($data)
{
    $parteData = explode('/', $data);
    $dataInvertida = $parteData[2].'-'.$parteData[1].'-'.$parteData[0];

    return $dataInvertida;
}

//FUNCAO UNIQIDREAL
function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception(
            'no cryptographically secure random function available'
        );
    }

    return substr(bin2hex($bytes), 0, $lenght);
}
