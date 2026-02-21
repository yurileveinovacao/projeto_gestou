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

    //echo "<br>Página:" . $key->page . "<br>";

    // Variavel que recebe o numero da página atual
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;
        $var_text = str_replace("Ç", "C", str_replace("Õ", "O", str_replace("(", "", str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i", str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I", $var_text)))))))));

        // Exibição da variavel texto gobal em loop
        // echo "<br>Valores Registro:" . $var_text . "<br>";

        // Verifica e identifica o CODEMP, caso enconte numera o registro
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $var_text)));
            $cnpj = limpar_texto($cnpj);
            //echo "<br>CNPJ:" . $cnpj . "<br>";
            $nro_registro = $nro_registro + 1;
        }


        if (preg_match('/CPF:/i', $var_text)) {
            preg_match('/[0-9]{11}/i', $var_text, $vcpf);
            //echo "<br>CPF:" . $vcpf[0] . "<br>";
            $cpf = $vcpf[0];
        }


        // Atribuicao de variavel somente quando o registro for impar
        $text =  $var_text;

        // If para interpretar somente os registros impares
        if ($nro_registro % 2 != 0) {
            // Caso encontre o texto valor liquido a váriavel recebe a proxima string com o valor liquido real
            if ($encontra_vlrliquido == 1) {
                if (preg_match('/[0-9]+/i', $text)) {
                    $valor_liquido = FormatToDecimal($var_text);
                } else {
                    $encontra_vlrliquido_outro = 1;
                }
                unset($encontra_vlrliquido);
            }
            // Identificar competencia
            if (preg_match('/VALOR LIQUIDO/i', $text)) {
                $encontra_vlrliquido = 1;
            }
        } else {
            if (preg_match('/de Pagamento de Salario/i', $text)) {
                if (preg_match('/Demonstrativo /i', $text)) {
                    $pula_importacao = 1;
                }
            }


            if ($encontra_cod_integracao == 1) {
                if (preg_match('/[0-9]+/i', $text)) {
                    preg_match('/[0-9]+/i', $text, $codusu);
                    $cod_integracao = $codusu[0];
                    //echo "<br>COD. INTEGRACAO:" . $cod_integracao . "<br>";
                    unset($encontra_cod_integracao);
                }
            }

            // Identificar código do usuario e nome
            if (preg_match('/FOLHA/i', $text)) {
                $encontra_cod_integracao = 1;
            }

            //---------------------------------------------------------------------------------------------------------------------------------------------------------------
            // Identificar competencia
            if (preg_match('/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+\S\/\d{4}/i', $text)) {
                $competencia = $var_text;
                //echo "<br>COMPETENCIA:" . $competencia . "<br>";
            }

            if ($encontra_vlrliquido_outro == 1) {
                // Caso encontre o texto valor liquido a váriavel recebe a proxima string com o valor liquido real
                if ($encontra_vlrliquido == 1) {
                    if (preg_match('/[0-9]+/i', $text)) {
                        $valor_liquido = FormatToDecimal($var_text);
                    }
                    unset($encontra_vlrliquido_outro);
                    unset($encontra_vlrliquido);
                }

                // Identificar competencia
                if (preg_match('/VALOR LIQUIDO/i', $text)) {
                    $encontra_vlrliquido = 1;
                }
            }
        }
    }

    // echo '$cnpj===================' . $cnpj . '---<br>';
    // echo '$cnpj_completo==========' . $cnpj_completo . '---<br>';

    // IF para o CNPJ encontrado igual ao cadastrado para a empresa
    if ($cnpj == $cnpj_completo) {

        //SELECT PARA VERIFICAR CADASTRO DE USUARIO
        $tabela = 'public."GESUSU"';
        foreach (selectGESUSU_LAYOUT_id_cod($tabela, $cod_integracao, $id_emp_default) as $select_tabela) {
            $id_usu = $select_tabela['id_usu'];
            $nome = $select_tabela['nome'];
            $cargo = $select_tabela['funcao'];
        }

        if (!empty($id_usu)) {
            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            $arquivo = $validador . '.pdf';
            $tabela = 'public."GESIM1_' . $raiz_cnpj . '"';
            $situac = 1;


            if ($pula_importacao != 1) {


                // echo '$page_number======' . $page_number . '---<br>';
                // echo '$tabela===========' . $tabela . '---<br>';
                // echo '$id_emp_default===' . $id_emp_default . '---<br>';
                // echo '$competencia======' . $competencia . '---<br>';
                // echo '$valor_liquido====' . $valor_liquido . '---<br>';
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
                // echo '$arquivo==========' . $arquivo . '---<br><br><br>';

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

                $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');


                $nro_registro = 0; //zera variavel da verificaçao de registros na mesma pagina
            }
        }

        // Zerar CodIntegracao
        unset($cod_integracao);
        // Zerar Competência
        unset($competencia);
        // Zerar Valor Liquido
        unset($valor_liquido);
        // Zerar Pula importação
        unset($pula_importacao);
    } else {
        ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
    }
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

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

function FormatToDecimal($string)
{
    $valor = number_format(str_replace(",", ".", str_replace(".", "", $string)), 2, ".", "");
    return $valor;
}
