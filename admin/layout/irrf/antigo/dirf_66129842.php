<?php

require '../../restrito.php';
require_once __DIR__.'/../../../../config/database.php';
require_once '../../util.php';

$id_emp_default = $_SESSION['id_emp_default'];
$today = "'".date('Y-m-d H:i:s')."'";
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = "'".$_SESSION['descricao']."'";

$val3 = uniqidReal();
$processamento = "'".$val3."'";

$origem = "'".$_SESSION['nomepdf']."'";

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO.pdf
$sql = 'SELECT cnpj from public."GESEMP" where id_emp='.$id_emp_default.'';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);
//RECUPERANDO RAIZ CNPJ
$busca_cnpj = $linha['cnpj'];
$raiz1 = str_replace('.', '', $linha['cnpj']);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
//-------------------------------------------------------------------------
//CRIANDO NOME TABELA
$raiz_cnpj = $raiz4;
$tabela1 = 'public."GESIRR_'.$raiz_cnpj.'"';
$tabela4 = 'public."GESUSU"';
//-------------------------------------------------------------------------
// Inclua o autoloader do Composer se ainda não tiver feito isso.
     include '../../vendor_ler_pdf/autoload.php';
//Analise o arquivo pdf e construa os objetos necessários.
     $parser = new \Smalot\PdfParser\Parser();
     $pdf = $parser->parseFile('../../uploads/'.$raiz4.'.pdf');
     $text = $pdf->getText();
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
// echo '<br>$text :' . $text;
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONTAGEM REGISTROS PDF
$html = $text;
     $needle = substr($text, 0, 36);
     $lastPos = 0;
     $count = 0;
     $positions = [];

     while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
         $positions[] = $lastPos;
         $lastPos = $lastPos + strlen($needle);
         $count = $count + 1;
     }
//echo 'Contagem: '.$count.'<br /><br />';
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
for ($ix = 1; $ix <= $count; ++$ix):
       $var = explode($needle, $text)[$ix];

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//verificar CNPJ na variavel
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
$pos = strpos($var, $busca_cnpj);

// echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';
// echo '<br>Registro: '.$ix;
// echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';

if ($pos != false) {
    // echo '<br>Pagina='.substr($var, -3, -1);
    // echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';

    $v335 = strpos($var, 'Responsável'); //Inicio
    $v335_1 = substr($var, $v335, 500);

    if (strpos($v335_1, 'Responsável') !== false) {
        $vResponsavel_0 = strpos($v335_1, 'Nome'); //Inicio
        $vResponsavel_2 = strpos($v335_1, 'Data'); //Final
        $vResponsavel = substr($v335_1, $vResponsavel_0 + 4, $vResponsavel_2 - 37);
        $vdata = substr($v335_1, $vResponsavel_2 + 4, 10);
    } else {
        $v335_1 = '';
        $vResponsavel = '';
        $vdata = '01/01/2000';
    }
    // echo '<br<br>var----'.$var.'<br>';
    // echo  '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';
    //-----------------------------------------------------INICIO CNPJ
    $pos1 = substr($var, $pos);
    $cnpj = substr($pos1, 0, 18);
    $hor_seg = substr($pos1, 19, 24);
    //----------------------------------------------------EXERCICIO
    $v24 = strpos($var, 'Exercício'); //Inicio
    $v24_1 = substr($var, $v24 + 14, 4);
    $v24_4 = rtrim(ltrim($v24_1));
    //----------------------------------------------------ANO CALENDARIO
    $v224 = strpos($var, 'Ano-calendário'); //Inicio
    $v224_1 = substr($var, $v224 + 19, 4);
    $v224_4 = rtrim(ltrim($v224_1));
    //----------------------------------------------------CPF
    $v225 = strpos($var, 'CPF'); //Inicio
    $v225_1 = substr($var, $v225 + 19, 14);
    $vcpf = rtrim(ltrim($v225_1));
    //----------------------------------------------------Natureza do Rendimento
    $v226 = strpos($var, 'Natureza'); //Inicio
    $v226_1 = substr($var, $v226 + 22, 200);
    $v226_2 = strpos($v226_1, '3. '); //Final
    $v226_3 = rtrim(ltrim(substr($v226_1, 0, $v226_2)));
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //----------------------------------------------------3. Rendimentos Tributáveis
    $vR25 = strpos($var, 'Tributáveis'); //Inicio
    $vR25_0 = substr($var, $vR25 + 83, 500);
    $vR25_1 = strpos($vR25_0, 'Isentos '); //Final
    $vgrupo3 = rtrim(ltrim(substr($vR25_0, 0, $vR25_1 - 15)));
    // echo '<br>GRUPO 3............:'.$vgrupo3;
    // echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';

    $vgrupo3_n = str_replace('. ', '.||', $vgrupo3);
    unset($new_arr); //Limpando Array
    $arr = explode('||', $vgrupo3_n);
    foreach ($arr as $value2) {
        $new_arr[] = trim($value2);
    }
    //----------------------------------------------------4. Rendimentos Isentos e Não Tributáveis
    $vR26 = strpos($var, 'Isentos'); //Inicio
    $vR26_0 = substr($var, $vR26, 900);
    $vR26_1 = strpos($vR26_0, 'Exclusiva'); //Final

    $vgrupo4 = rtrim(ltrim(substr($var, $vR26, $vR26_1)));
    $vgrupo4_n = str_replace('. ', '.||', $vgrupo4);
    unset($new_arr4); //Limpando Array
    $arr = explode('||', $vgrupo4_n);
    foreach ($arr as $value4) {
        $new_arr4[] = trim($value4);
    }

    if (preg_match('/[A-Z]{1}/', substr(rtrim(ltrim(substr($new_arr4[7], 8, -2))), 0, 1))) {
        // echo '<br>Entrou if';

        $vR56 = strpos($var, 'Isentos'); //Inicio
        // echo '<br>4.7='.rtrim(ltrim(substr($new_arr4[7], 8, -2)));

        $vgrupo4_7_n = preg_replace('/\s+/', '|', rtrim(ltrim(substr($new_arr4[7], 8, -2))));
        $arr4_7 = explode('|', $vgrupo4_7_n);
        foreach ($arr4_7 as $valuen4_7) {
            $new_arr4_7[] = trim($valuen4_7);
            $result = count($new_arr4_7);
        }

        $desc_4_7 = str_replace(rtrim(ltrim($new_arr4_7[$result - 1])), '', rtrim(ltrim(substr($new_arr4[7], 8, -2))));

        $n4_7 = rtrim(ltrim($new_arr4_7[$result - 1]));

        unset($new_arr4_7);
        unset($arr4_7);
        unset($valuen4_7);
        unset($result);
    } else {
        $n4_7 = rtrim(ltrim(substr($new_arr4[7], 8, -2)));
    }

    //----------------------------------------------------5. Rendimentos Sujeitos à Tributação Exclusiva (rendimento líquido)
    $vR27 = strpos($var, 'Sujeitos'); //Inicio
    $vR27_0 = substr($var, $vR27, 900);
    $vR27_1 = strpos($vR27_0, 'Recebidos'); //Final
    $vgrupo5 = rtrim(ltrim(substr($var, $vR27, $vR27_1)));
    $vgrupo5_n = str_replace('. ', '.||', $vgrupo5);
    unset($new_arr5); //Limpando Array
    $arr = explode('||', $vgrupo5_n);
    foreach ($arr as $value5) {
        $new_arr5[] = trim($value5);
    }

    //----------------------------------------------------6. Rendimentos Recebidos Acumuladamente - Art. 12-A da Lei nº 7.713, de 1988 (sujeitos à tributação exclusiva)
    $vR28 = strpos($var, 'processo:'); //Inicio
    $vR28_0 = substr($var, $vR28, 900);
    $vR28_1 = strpos($vR28_0, '7. '); //Final
    $vgrupo6 = rtrim(ltrim(substr($var, $vR28, $vR28_1)));
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $vR28_2 = strpos($vgrupo6, ':'); //Inicio
    $vR28_3 = substr($vgrupo6, $vR28_2, 100);
    $vR28_4 = strpos($vgrupo6, 'Quantidade'); //Final
    $vnprocesso = rtrim(ltrim(substr($vgrupo6, $vR28_2, $vR28_4)));

    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $vR29_2 = strpos($vgrupo6, 'rendimento:'); //Inicio
    $vR29_3 = substr($vgrupo6, $vR29_2, 100);
    $vR29_4 = strpos($vR29_3, '1. '); //Final
    $vnrendimento = rtrim(ltrim(substr($vgrupo6, $vR29_2, $vR29_4)));

    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $vR28_5 = strpos($vgrupo6, 'meses '); //Inicio
    $vR28_6 = substr($vgrupo6, $vR28_5, 100);
    $vR28_7 = strpos($vR28_6, 'Natureza '); //Final
    $vqmeses = rtrim(ltrim(substr($vgrupo6, $vR28_5, $vR28_7)));
    if ($vqmeses == ''){
        $vqmeses = '0.00';
    }
    

    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $vR30_5 = strpos($vgrupo6, 'acidente'); //Inicio
    $vR30_6 = substr($vgrupo6, $vR30_5, 100);
    $vgrupo6_0 = rtrim(ltrim(substr($vgrupo6, $vR30_5 + 19, 100)));
    $vgrupo6_n = preg_replace("/\s+/", '||', $vgrupo6_0);

    unset($new_arr6); //Limpando Array
    $arr = explode('||', $vgrupo6_n);
    foreach ($arr as $value6) {
        $new_arr6[] = trim($value6);
    }

    //----------------------------------------------------7. Informações Complementares
    //echo '<br> $var: ' . $var;
    $vR35 = strpos($var, 'Informações '); //Inicio
    //echo '<br> vR35: ' . $vR35;
    //echo '<br>';
    $vR35_0 = substr($var, $vR35 + 28, 1900);
    //echo '<br> $vR35_0: ' . $vR35_0;
    //echo '<br>';
    $vR35_1 = strpos($vR35_0, 'Pág.'); //Final
    //echo '<br> $vR35_1: ' . $vR35_1;
    //echo '<br>';
    $vgrupo7 = rtrim(ltrim(substr($vR35_0, 0, $vR35_1)));
    //echo '<br> $vgrupo7: ' . rtrim(ltrim(substr($vR35_0, 0, $vR35_1))) . '<br>';
    //echo '<br>';

    $vR37 = strpos($vgrupo7, '8. '); //Inicio
    //echo '<br> $vR37: ' . $vR37 . '<br>';
    //echo '<br>';

    if (strlen($vR37) == 0) {
        $vgrupo7_n = $vgrupo7;
    } else {
        $vR38_1 = strpos($vgrupo7, '8. '); //Final
        $vgrupo7_n = rtrim(ltrim(substr($vgrupo7, 0, $vR38_1)));
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //CRIANDO NOME TABELA
    $raiz_cnpj = $raiz4;
    $tabela1 = 'public."GESIRR_'.$raiz_cnpj.'"';
    $tabela4 = 'public."GESUSU"';
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //INSERT TABELA 1
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------
    //SELECT PARA VERIFICAR CADASTRO DE USUARIO

    $vcpf = "'".str_replace(' ', '', str_replace('-', '', str_replace('.', '', $vcpf)))."'";
    $sql_u = 'SELECT id_usu from '.$tabela4.' where cpf='.$vcpf.' ';
    $res_u = pg_exec($conn, $sql_u);
    $linha_u = pg_fetch_assoc($res_u);

    if (!empty($linha_u['id_usu'])) {
        $id_usu = $linha_u['id_usu'];

        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $nexercicio = "'".$v24_4."'";
        $nanocalendario = "'".$v224_4."'";
        $ncpf = $vcpf;
        $nnatureza = "'".$v226_3."'";

        unset($vcpf);
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $n3_1 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr[1], 41, -2)))))."'";
        $n3_2 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr[2], 38, -2)))))."'";
        $n3_3 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr[3], 163, -2)))))."'";
        $n3_4 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr[4], 51, -2)))))."'";
        $n3_5 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr[5], 37, 15)))))."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $n4_1 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[1], 102, -2)))))."'";
        $n4_2 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[2], 25, -2)))))."'";
        $n4_3 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[3], 131, -2)))))."'";
        $n4_4 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[4], 111, -2)))))."'";
        $n4_5 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[5], 131, -2)))))."'";
        $n4_6 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr4[6], 107, -2)))))."'";
        $n4_7 = "'".str_replace(',', '.', str_replace('.', '', $n4_7))."'";
        $n4_7_descricao = "'".$desc_4_7."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------
        $n5_1 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr5[1], 25, -2)))))."'";
        $n5_2 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr5[2], 57, -2)))))."'";
        $n5_3 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($new_arr5[3], 7, -2)))))."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------';
        //echo '<br>';
        //echo '$vnprocesso : ' . $vnprocesso;
        //echo '<br>';
        $n6_1_nprocesso = "'".rtrim(ltrim(substr($vnprocesso, 13, -16)))."'";
        $n6_1_nqtdmeses = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim(substr($vqmeses, 44)))))."'";
        $n6_1_natrendimento = "'".rtrim(ltrim(substr($vnrendimento, 11, -16)))."'";
        $n6_1 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[0]))))."'";
        $n6_2 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[1]))))."'";
        $n6_3 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[2]))))."'";
        $n6_4 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[3]))))."'";
        $n6_5 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[4]))))."'";
        $n6_6 = "'".str_replace(',', '.', str_replace('.', '', rtrim(ltrim($new_arr6[5]))))."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------';
        $n7 = "'".$vgrupo7_n."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------';
        $nnome_responsavel = "'".$vResponsavel."'";
        $ndata = "'".inverteData($vdata)."'";
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------';
        // echo '<br>$id_usu============='.$id_usu;
        // echo '<br>$nexercicio========='.$nexercicio;
        // echo '<br>$nanocalendario====='.$nanocalendario;
        // echo '<br>$ncpf==============='.$ncpf;
        // echo '<br>$nnatureza=========='.$nnatureza;
        // echo '<br>$n3_1==============='.$n3_1;
        // echo '<br>$n3_2==============='.$n3_2;
        // echo '<br>$n3_3==============='.$n3_3;
        // echo '<br>$n3_4==============='.$n3_4;
        // echo '<br>$n3_5==============='.$n3_5;
        // echo '<br>$n4_1==============='.$n4_1;
        // echo '<br>$n4_2==============='.$n4_2;
        // echo '<br>$n4_3==============='.$n4_3;
        // echo '<br>$n4_4==============='.$n4_4;
        // echo '<br>$n4_5==============='.$n4_5;
        // echo '<br>$n4_6==============='.$n4_6;
        // echo '<br>$n4_7==============='.$n4_7;
        // echo '<br>$n4_7_descricao====='.$n4_7_descricao;
        // echo '<br>$n5_1==============='.$n5_1;
        // echo '<br>$n5_2==============='.$n5_2;
        // echo '<br>$n5_3==============='.$n5_3;
        // echo '<br>$n6_1_nprocesso====='.$n6_1_nprocesso;
         if(strlen($n6_1_nqtdmeses) ==2){
            $n6_1_nqtdmeses = '\'0.00\'';
         }
         //echo '<br>$n6_1_nqtdmeses====='.$n6_1_nqtdmeses;
         //echo '<br>$n6_1_natrendimento='.$n6_1_natrendimento;
         
         if(strlen($n6_1) ==2){
            $n6_1 = '\'0.00\'';
         }
         //echo '<br>$n6_1==============='.$n6_1;
         
         if(strlen($n6_2) ==2){
            $n6_2 = '\'0.00\'';
         }
         //echo '<br>$n6_2==============='.$n6_2;
         
         if(strlen($n6_3) ==2){
            $n6_3 = '\'0.00\'';
         }
         //echo '<br>$n6_3==============='.$n6_3;
         
         if(strlen($n6_4) ==2){
            $n6_4 = '\'0.00\'';
         }
         //echo '<br>$n6_4==============='.$n6_4;
         
         if(strlen($n6_5) ==2){
            $n6_5 = '\'0.00\'';
         }         
         //echo '<br>$n6_5==============='.$n6_5;
         
         if(strlen($n6_6) ==2){
            $n6_6 = '\'0.00\'';
         }         
         //echo '<br>$n6_6==============='.$n6_6;

         
        if(strlen($n7) == 2){
            $n7 = '\'\'';
        }
         //echo '<br>$n7================='.$n7;
         //echo '<br>$nnome_responsavel=='.$nnome_responsavel;
         //echo '<br>$ndata=============='.$ndata;
         //echo '<br>$today=============='.$today;
        //---------------------------------------------------------------------------------------------------------------------------------------------------------------';

        $query = 'INSERT INTO '.$tabela1.' (    
        anoexe,anocal,cpf,natren    ,ren_3_1    ,ren_3_2    ,ren_3_3    ,ren_3_4    ,ren_3_5    ,ren_4_1    ,ren_4_2    ,ren_4_3    ,ren_4_4    ,ren_4_5
        ,ren_4_6    ,ren_4_7    ,desc_4_7    ,ren_5_1    ,ren_5_2    ,ren_5_3    ,numpro    ,quames    ,natren_6_1    ,ren_6_1    ,ren_6_2    ,ren_6_3
        ,ren_6_4    ,ren_6_5    ,ren_6_6    ,infcom    ,nome_8_1    ,data_8_1    ,id_usu, id_emp, datinc, id_processamento, id_usa_inc, origem        )
        VALUES ('.$nexercicio.','.$nanocalendario.','.$ncpf.','.$nnatureza.'
        ,'.$n3_1.' ,'.$n3_2.' ,'.$n3_3.' ,'.$n3_4.' ,'.$n3_5.' ,'.$n4_1.' ,'.$n4_2.' ,'.$n4_3.' ,'.$n4_4.' ,'.$n4_5.' ,'.$n4_6.' ,'.$n4_7.'
        ,'.$n4_7_descricao.' ,'.$n5_1.' ,'.$n5_2.' ,'.$n5_3.' ,'.$n6_1_nprocesso.' ,'.$n6_1_nqtdmeses.' ,'.$n6_1_natrendimento.' ,'.$n6_1.'
        ,'.$n6_2.' ,'.$n6_3.' ,'.$n6_4.' ,'.$n6_5.' ,'.$n6_6.' ,'.$n7.' ,'.$nnome_responsavel.' ,'.$ndata.'
        ,'.$id_usu.','.$id_emp_default.' ,'.$today.','.$processamento.','.$id_usa.','.$origem.') RETURNING id_irr as pk;';
        //echo '<br>';
        //echo 'Insert: ' . $query ;
        //echo '<br><br>';
        $id_irr = pg_fetch_result(pg_query($conn, $query), 0, 'pk')
         or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
    //--------------------------------------------------------------------------------------------------------------------------------------------------
    } else {
        // echo '<br>Pagina='.substr($var, -3, -1);
        // echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';

        $v334 = strpos($var, 'Responsável'); //Inicio
        $v334_1 = substr($var, $v334, 500);

        $vResponsavel_0 = strpos($v334_1, 'Nome'); //Inicio
        $vResponsavel_2 = strpos($v334_1, 'Data'); //Final
        $vResponsavel = substr($v334_1, $vResponsavel_0 + 4, $vResponsavel_2 - 37);
        $vdata = substr($v334_1, $vResponsavel_2 + 4, 10);
    }
} else {
    // echo '<br>Pagina='.substr($var, -3, -1);
    // echo '<br>---------------------------------------------------------------------------------------------------------------------------------------------------------------';

    //---------------------------------------------informações complementares quanto estão na pagina 2
    $posicaoIni_Inf_Comp = strpos($var, '7. '); //Inicio
    //echo '<br>$posicaoIni_Inf_Comp : ' . $posicaoIni_Inf_Comp ; 
    if($posicaoIni_Inf_Comp != ''){
        $posicaoFim_Inf_Comp = strpos($var, '8. '); //Final
    //    echo '<br>$posicaoFim_Inf_Comp : ' . $posicaoFim_Inf_Comp ; 
        $v_Inf_Comp = '\''.substr($var, $posicaoIni_Inf_Comp + 32, $posicaoFim_Inf_Comp - $posicaoIni_Inf_Comp - 32) . '\'';
    //    echo '<br>----------------------------------------------<br>';
    //    echo '$v_Inf_Comp: ' . $v_Inf_Comp;
    //    echo '<br>----------------------------------------------<br>';
    
        $query_Inf_Comp  = 'UPDATE '.$tabela1.'  SET infcom = '.$v_Inf_Comp. '  WHERE id_irr =  '.$id_irr.' ;';
        pg_query($conn, $query_Inf_Comp)
        or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
    }else{
    //    echo '<br>$posicaoIn_Inf_Comp não localizado na pg 2, bloco if não executou ' ;
    }

    //---------------------------------------------informações complementares quanto estão na pagina 2

    $v335 = strpos($var, 'Responsável'); //Inicio
    $v335_1 = substr($var, $v335, 500);

    if (strpos($v335_1, 'Responsável') !== false) {
        $vResponsavel_0 = strpos($v335_1, 'Nome'); //Inicio
        $vResponsavel_2 = strpos($v335_1, 'Data'); //Final
        $vResponsavel = substr($v335_1, $vResponsavel_0 + 4, $vResponsavel_2 - 37);
        $vdata = substr($v335_1, $vResponsavel_2 + 4, 10);
    } else {
        $v335_1 = '';
        $vResponsavel = '';

        $vdata = '01/01/2000';
    }

    $nnome_responsavel = "'".$vResponsavel."'";
    $ndata = "'".inverteData($vdata)."'";

    $query5 = 'UPDATE '.$tabela1.'  SET nome_8_1 = '.$nnome_responsavel.'  ,data_8_1 = '.$ndata.'  WHERE id_irr =  '.$id_irr.' ;';
    pg_query($conn, $query5)
    or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
}
endfor;

echo "<script language=javascript>
 location.href = '../../lotes_processados';
</script>";

function inverteData($data)
{
    $parteData = explode('/', $data);
    $dataInvertida = $parteData[2].'-'.$parteData[1].'-'.$parteData[0];

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
