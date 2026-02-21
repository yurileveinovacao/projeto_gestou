<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

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
$json_base = json_decode($_SESSION["text_vis"]);

// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {

    // Variavel que recebe o numero da página atual
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;

        // Verifica e identifica o CODEMP, caso enconte numera o registro
        if (preg_match('/[0-9]{5}/i', $var_text)) {

            $nro_registro = $nro_registro + 1;
        }

        // Exibição da variavel texto gobal em loop
        //echo "<br>Valores Registro:" . $var_text . "<br>";

        // Atribuicao de variavel somente quando o registro for impar
        $text =  $var_text;

        // Identificar CNPJ
        if (preg_match('/[0-9]{14}/i', $text)) {
            $cnpj = limpar_texto($text);
        }

        // Identificar competencia
        if (preg_match('/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+\/\d{4}/i', $text)) {
            $competencia = $text;
        }

        // Caso encontre a matricula, ele atribui valor das proximas duas casas para formar o cod usuario
        if ($encontra_matricula == 1) {

            $monta_codusu = $monta_codusu . $var_text;

            // Apos gerar a $monta_codusu, realiza o preg_match para verificar se a string tem : e 6 digitos, realizando o replace correspondentes ao codusu
            if (preg_match('/:[0-9]{6}/i', $monta_codusu)) {

                $codusu = str_replace(":", "", $monta_codusu);
                $cod_integracao = limpar_texto($codusu);

                unset($encontra_matricula);
            }
        }

        // Caso encontre o texto valor liquido a váriavel recebe a proxima string com o valor liquido real
        if ($encontra_vlrliquido == 1) {
            $liquido_a_receber = FormatToDecimal($var_text);
            unset($encontra_vlrliquido);
        }

        // Identificar o texto Matricula
        $text = str_replace("Matrícula", "Matricula", $text);
        if (preg_match('/Matricula/i', $text)) {

            if (preg_match('/:\s[0-9]{6}/i', $text)) {
                $codusu = str_replace(":", "", $text);
                $cod_integracao = limpar_texto($codusu);

                unset($encontra_matricula);
            } else {
                $encontra_matricula = 1;
            }
        }

        // Identificar o texto LÍQUIDO A RECEBER :
        $text = str_replace("LÍQUIDO", "LIQUIDO", $text);
        $text = str_replace("999 LIQUIDO A RECEBER", "999 LIQ. A RECEBER", $text);
        if (preg_match('/LIQUIDO A RECEBER/i', $text)) {
            $encontra_vlrliquido = 1;
        }
    }

    // IF para o CNPJ encontrado igual ao cadastrado para a empresa
    if ($cnpj == $cnpj_completo) {

        $entrou_if_cnpj = 1;

        //SELECT PARA VERIFICAR CADASTRO DE USUARIO
        $tabela = 'public."GESUSU"';
        foreach (selectGESUSU_LAYOUT_id_cod($tabela, $cod_integracao, $id_emp_default) as $select_tabela) {
            $id_usu = $select_tabela['id_usu'];
            $nome = $select_tabela['nome'];
            $cargo = $select_tabela['funcao'];
        }



        // Caso encontre o ID_USU no banco
        if (!empty($id_usu)) {

            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            $arquivo = $validador . '.pdf';
            $tabela = 'public."GESIM1_' . $raiz_cnpj . '"';
            $situac = 0;

            try {

                // Insert na tabela
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
                    $liquido_a_receber, //$vlr_liquido
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

            // Salvamento do arquivo em diretorio 
            $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');
        }
    }

    // Zerar CodUsuario
    unset($monta_codusu);
    // Zerar Liquido a Receber
    unset($codusu);
    // Zerar Liquido a Receber
    unset($liquido_a_receber);
}

if ($entrou_if_cnpj == 1) {

    // Redirecionamento para a página de lotes apos concluir todo o loop
    echo "<script language=javascript>
             location.href = '../../lotes_processados';
             </script>";
} else {

    // ELSE caso o CNPJ for diferente do cadastrado na base
    ($_SESSION['erro_importação'] = 'O arquivo selecionado não possui dados correspondentes a essa empresa!') . (header('Location:' . $erro_1));
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


function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}
function FormatToDecimal($string)
{
    $valor = number_format(str_replace(",", ".", str_replace(".", "", $string)), 2, ".", "");
    return $valor;
}
