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

        // If para interpretar somente os registros impares
        if ($nro_registro % 2 != 0) {
        } else {

            // Atribuicao de variavel somente quando o registro for impar
            $text =  $var_text;

            // Caso encontre o valor liquido, ele atribui valor da proxima casa para formar a o valor liquido
            if ($encontra_valorliquido == 1) {

                $valor_liquido = FormatToDecimal($var_text);

                unset($encontra_valorliquido);
            }

            // Identificar CNPJ
            if (preg_match('/[0-9]{14}/i', $text)) {
                $cnpj = $text;
                $cnpj = limpar_texto($cnpj);
            }

            // Identificar competencia
            if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}\s[a-z A-Z]\s[0-9]{2}\/[0-9]{2}\/[0-9]{4}/i', $text)) {
                $competencia = $text;
            }

            // Identificar código do usuario e nome
            if (preg_match('/[0-9]{6}\s(\w+\s)+/i', $text)) {

                preg_match('/[0-9]{6}/i', $text, $codusu);

                $cod_integracao = $codusu[0];

                $cod_integracao = limpar_texto($cod_integracao);
            }

            // Identificar Valor Líquido
            if (preg_match('/Valor Líquido/i', $text)) {

                $encontra_valorliquido = 1;
            }
        }
    }

    // IF para o CNPJ encontrado igual ao cadastrado para a empresa
    if ($cnpj == $cnpj_completo) {

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
                    $valor_liquido, //$vlr_liquido
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

        // Zerar Valor Liquido
        unset($valor_liquido);
    } else {

        // ELSE caso o CNPJ for diferente do cadastrado na base
        ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
    }
}

// Redirecionamento para a página de lotes apos concluir todo o loop
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

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}
function FormatToDecimal($string)
{
    $valor = number_format(str_replace(",", ".", str_replace(".", "", $string)), 2, ".", "");
    return $valor;
}
