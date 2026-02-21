<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

$contagem_cpf = 0;
$desativa_insert = 0; //0 ativa - 1 desativa
$exibe_var_text = 0; //0 nao exibe - 1 exibe 
$exibe_registros = 0; //0 nao exibe - 1 exibe

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

$encontra_vlrliquido = 0;
$contagem_cpf = 0;
$contagem_cpf_pagina = 0;
$busca_por_cpf = 0;


// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {

    //echo "<br>Página:" . $key->page . "<br>";

    // Variavel que recebe o numero da página atual
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;
        $var_text = str_replace("R.G.:", "R.G.:", str_replace("Ó", "O", str_replace("ó", "o", str_replace("Ç", "C", str_replace("Õ", "O", str_replace("(", "", str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i", str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I", str_replace("ê", "e", str_replace("Ê", "E", $var_text))))))))))))));

        //////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($exibe_var_text  != 0) {
            echo "<br>Valores Registro:" . $var_text . "<br>";
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////

        // Identificar Periodo de
        if (preg_match('/DE\s[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}\sATÉ\s[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/i', $var_text)) {
            $periodo = $var_text;
            // echo "<br>PERIODO:" . $periodo . "<br>";
        }

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $var_text)));
            $cnpj = limpar_texto($cnpj);

            if ($cnpj == $cnpj_completo) {
                $cnpj_consulta = $cnpj;
            }

            // echo "<br>CNPJ:" . $cnpj . "<br>";
            $nro_registro = $nro_registro + 1;

            // echo ' $nro_registro=='. $nro_registro.'<br>';
        }

        if ($cnpj_consulta == $cnpj_completo) {
            $retorno_cnpj = 1;
            if ($encontra_cpf == 1) {

                //echo 'ENTROU BUSCA POR CPF'.'<br>';

                if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text)) {
                    $regex = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i';
                    preg_match($regex, $var_text, $resposta);
                    $pis = $resposta[0];
                    $pis = limpar_texto($pis);

                    if ($pis != $pis_consulta) {

                        $encontra_valor_liquido = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                        $pis_consulta = $pis;
                        $contagem_cpf++;
                        $contagem_cpf_pagina++;

                        $pagina_ini = $page_number;

                        $concat_cpf = $concat_cpf . "||" . $pis_consulta;
                        $concat_pagina_ini = $concat_pagina_ini . "||" . $pagina_ini;

                        $pagina_fim = $page_number;

                        if ($contagem_cpf_pagina > 1) {
                            $dois_cpfs = 1;

                            // echo "2 CPFS diferentes por pagina";
                        }

                        // echo "<br>CPF cont page:" . $dois_cpfs . "<br>";
                    } else {
                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                        //echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $pis_consulta . "<br>";
                    }
                    $regarq =   $contagem_cpf;
                }
                unset($encontra_cpf);
            }

            if ($encontra_pis == 1) {

                //echo 'ENTROU BUSCA POR PIS'.'<br>';

                //REGEX PIS
                if (preg_match('/\b[0-9]{1,11}\b/', $var_text)) {

                    $regex = '/\b[0-9]{10}([0-9]|[1-9][0-9]|(1[0-9]{2})|(2[0-7][0-9])|(28[0-7]))\b/';
                    preg_match($regex, $var_text, $resposta);
                    $pis = $resposta[0];
                    $pis = limpar_texto($pis);

                    if ($pis != $pis_consulta) {

                        $encontra_valor_liquido = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                        $pis_consulta = $pis;
                        $contagem_cpf++;
                        $contagem_cpf_pagina++;

                        $pagina_ini = $page_number;

                        $concat_cpf = $concat_cpf . "||" . $pis_consulta;
                        $concat_pagina_ini = $concat_pagina_ini . "||" . $pagina_ini;

                        $pagina_fim = $page_number;

                        if ($contagem_cpf_pagina > 1) {
                            $dois_cpfs = 1;
                            // echo "2 CPFS diferentes por pagina";
                        }
                        // echo "<br>CPF cont page:" . $dois_cpfs . "<br>";
                    } else {
                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                        // echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $pis_consulta . "<br>";
                    }
                    $regarq =   $contagem_cpf;

                    //echo '$regarq=== '.$regarq .'<br>';

                }
                unset($encontra_pis);
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/CPF/i', $var_text)) {
                $encontra_cpf = 1;
                $busca_por_cpf = 1;
            }

            if (preg_match('/PIS/i', $var_text)) {
                $encontra_pis = 1;
                $busca_por_pis = 1;
            }
        }
    }

    if (!empty($pagina_fim)) {
        $concat_pagina_fim = $concat_pagina_fim . "||" . $pagina_fim;
    }

    if (empty($pagina_espelhada)) {
        $tipo_pagina = "Página Unica";
    } else {
        $tipo_pagina = "Página Espelhada";
    }
    unset($cnpj_consulta);
    unset($contagem_cpf_pagina);
    unset($pagina_ini);
    unset($pagina_fim);
    unset($complemento);
    
}


if ($exibe_registros != 0) {
    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de CPF na Pagina:" . $contagem_cpf . "<br>";
    echo "<br>PIS concatenados:" . $concat_cpf . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "<br>Page FINAL:" . $pagina_fim . "<br>";
    echo "Periodo:" . $periodo . "<br>";
}

if (empty($dois_cpfs)) {
    if (!empty($retorno_cnpj)) {
        for ($i = 1; $i <= $contagem_cpf; $i++) {

            $pis_array = explode('||', $concat_cpf);
            $pis = trim($pis_array[$i]);

            $pagina_ini_array = explode('||', $concat_pagina_ini);
            $pagina_ini = trim($pagina_ini_array[$i]);

            $pagina_fim_array = explode('||', $concat_pagina_fim);
            $pagina_fim = trim($pagina_fim_array[$i]);

            $tabela_usu = 'public."GESUSU"';
            $tabela_gespon1 = 'public."GESPON1_' . $raiz_cnpj . '"';

            if ($busca_por_cpf == 1) {
                $tabela_busca = "selectGESUSU_LAYOUT_id_cpf";
            } else {
                $tabela_busca = "selectGESUSU_LAYOUT_id_pis";
            }

            //CRIAR ID_VALIDADOR
            $val1 = uniqid();
            $val2 = uniqidReal();
            $validador = $raiz_cnpj . $val1 . $val2;
            $validador = $validador;
            $arquivo = $validador . '.pdf';
            $situac = 0;

            foreach ($tabela_busca($tabela_usu, $pis, $id_emp_default) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];

                if ($select_tabela != 0) {

                    // initiate FPDI
                    if ($desativa_insert  == 0) {
                        $pdf = new FPDI();
                    }
                    if ($desativa_insert == 0) {
                        for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {

                            $pdf->AddPage("L"); //P = RETRATO, L = PAISAGEM
                            $pdf->setSourceFile($nomearquivo);
                            $tplIdx = $pdf->importPage($pagina_loop);
                            $pdf->useTemplate($tplIdx);

                            // echo "Paginas a gravar:" . $pagina_loop . "<br>";
                        }
                    }
                    // Salvamento do arquivo em diretorio 
                    if ($desativa_insert  == 0) {
                        $pdf->Output('F', '../../../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $validador . '.pdf');
                    }

                    if ($desativa_insert  == 0) {
                        try {
                            // Insert na tabela
                            $insert_tabela1 = insertGESPON1_secullum(
                                $tabela_gespon1,
                                $id_emp_default,
                                NULL, //PIS
                                $id_usu,
                                $periodo,
                                $datinc,
                                NULL, //BTOTAL
                                NULL, //BSALDO
                                $processamento,
                                $id_usa_default,
                                $origem,
                                $arquivo,
                                $regarq
                            );

                            $id_pon1 = $insert_tabela1['pk'];
                        } catch (PDOException $erro) {
                            die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    }

                    if ($exibe_registros != 0) {
                        echo "<br>PIS:" . $pis . "<br>";
                        echo "Nome:" . $nome . "<br>";
                        echo "Pagina INI:" . $pagina_ini . "<br>";
                        echo "Pagina FIM:" . $pagina_fim . "<br>";
                        echo "Periodo:" . $periodo . "<br>";
                        echo "PIS's por arquivo:" . $regarq . "<br>";
                    }
                } else {
                    // echo "Nenhum resultado encontrado para o Cod. de Integração.".$pis.".<br>";
                    if ($exibe_registros != 0) {
                        echo "<br>PIS:" . $pis . "<br>";
                        echo "DATA:" . $datinc . "<br>";
                        echo "ORGIGEM:" . $origem . "<br>";
                        echo "DESCRICAO:" . $descricao_recibo . "<br>";
                        echo "ID_PROCESSAMENTO:" . $processamento . "<br>";
                        echo "ID_EMP:" . $id_emp_default . "<br>";
                        echo "REGARQ:" . $regarq . "<br>";
                        echo "Pagina:" . $pagina_ini . "<br>";
                    }

                    if ($desativa_insert  == 0) {
                        try {

                            if ($busca_por_cpf == 1) {
                                $tipo = 'CPF';
                            } else {
                                $tipo = 'PIS';
                            }

                            $insert_tabela2 = insertGESPON_LOG(

                                $id_emp_default,
                                $pis, //IDENTIFICADOR
                                $tipo, //TIPO DE INDENTIFICADOR
                                $descricao_recibo, //DESCRIÇAO IMPORTAÇAO
                                $origem, //ARQUIVO DE ORIGEM
                                $processamento, //LOTE PROCESSAMENTO
                                $regarq, //PAGINAS POR ARQUIVO
                                $pagina_ini, //PAGINA INCONSISTENCIA
                                $datinc
                            );

                            $id_ponlog = $insert_tabela2['pk'];
                        } catch (PDOException $erro) {
                            die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                        }
                    }
                }
            }
        }

        if ($desativa_insert  == 0) {
            echo "<script language=javascript>
        location.href = '../../lotes_processados';
        </script>";
        }
    } else {
        if ($desativa_insert  == 0) {
            ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
        }
    }
} else {
    if ($desativa_insert  == 0) {
        ($_SESSION['erro_importação'] = 'O arquivo selecionado esta apresentando mais de um colaborador por pagina!') . (header('Location:' . $erro_1));
    }
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
