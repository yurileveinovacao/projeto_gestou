<?php

require_once '../../restrito.php'; //permissão acesso pagina
require_once '../../iuds_pdo.php'; //persistencia
require_once '../../util.php'; //fonte de variaveis 
require_once '../vendor_fpdi/autoload.php'; //chamada da biblioteca do FPDI

use setasign\Fpdi\Fpdi;

$desativaInsercao = 0; //0 ativa - 1 desativa
$exibeVarTexto = 0; //0 nao exibe - 1 exibe 
$exibeRegistros = 0; //0 nao exibe - 1 exibe

//Variavies estao vindo do util.php/////////////////////////////////////////////////////////////////////
//$raiz_cnpj
//$cnpj_completo 
//$id_emp_default
//$id_usa_default
//$datinc
//datatu 
//$id_usa

//Atribuição de variaveis//////////////////////////////////////////////////////////////////////////////
$cnpjCompleto = $cnpj_completo;
$idEmpDefault = $id_emp_default;
$dataInclusao = $datinc;

$encLiquidoP1 = 0;
$contagem_Cpf = 0;
$contagCpfPag = 0;
$codIntegraca = null;
$cpfConsultas = null;
$valorLiquido = null;
$encDois_Cpfs = null;
$encontra_cpf_nextline = 0;
$competenciaEmLinhas = 0;

// Variavel que recebe a descricao da importacao
$descricao_recibo = $_SESSION['descricao'];

// Variavel que recebe o nome do PDF
$origem = $_SESSION['nomepdf'];

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

// Variavel CNPJ completo com replace (somente numeros)
$cnpjCompleto =  remover_nao_numericos($cnpjCompleto);

// Variavel que cria o id_processamento
$processamento = gerar_id_unico();

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
        $var_text = str_replace(
            ['Ó', 'ó', 'Ç', 'Õ', '(', 'ç', 'õ', 'í', 'á', 'Á', 'Í', 'ê', 'Ê', 'R.G.:'],
            ['O', 'o', 'C', 'O', '', 'c', 'o', 'i', 'a', 'A', 'I', 'e', 'E', 'R.G.:'],
            $key2->text
        );
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // Exibição da variavel texto gobal em loop
        if ($exibeVarTexto  != 0) {
            echo "<br>Valores Registro:" . $var_text . "<br>";
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////

        //LOCALIZAR COMPETENCIA (só busca se ainda não encontrou uma completa com ano)
        if (!preg_match('/\d{4}/', $competencia)) {
            if ($competenciaEmLinhas >= 1 && $competenciaEmLinhas <= 5) {
                if (preg_match('/\b(\d{4})\b/', $var_text, $m_ano)) {
                    $competencia .= $m_ano[1];
                    $competenciaEmLinhas = 0;
                } else {
                    $competenciaEmLinhas++;
                }
            } elseif (preg_match('/(Janeiro|Fevereiro|Marco|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)\/\d{4}/i', $var_text, $matches)) {
                $competencia = $matches[0];
            } elseif ($competenciaEmLinhas == 0 && preg_match('/(Janeiro|Fevereiro|Marco|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)/i', $var_text, $m_comp2)) {
                $competencia = $m_comp2[1] . " ";
                $competenciaEmLinhas = 1;
            }
        }

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {

            preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/', $var_text, $cnpj_match);
            $cnpj = remover_nao_numericos($cnpj_match[0]);

            if ($cnpj == $cnpjCompleto) {

                $retorno_cnpj = 1;
                $cnpj_consulta = $cnpj;
            }
        }

        // Flag CPF next-line
        if ($encontra_cpf_nextline >= 1 && $encontra_cpf_nextline <= 5) {
            if (preg_match('/(\d{3}\.){2}\d{3}\-\d{2}/i', $var_text, $match)) {
                $cpf = remover_nao_numericos($match[0]);
                $encontra_cpf_nextline = 0;
                $cpf_anterior = $cpf_anterior <> $cpf ? 1 : 2;
                if ($cpf_anterior == 1) {
                    if (!empty($cpf)) {
                        $concat_cpf = $concat_cpf . "||" . $cpf;
                        $contagem_Cpf++;
                        $pagina_ini = $page_number;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;
                        $concat_pagina_fim .= "||" . $pagina_fim;
                    }
                } else if ($cpf_anterior == 2) {
                    if (!empty($cpf)) {
                        $concat_cpf = $concat_cpf . "||" . $cpf;
                        $contagem_Cpf++;
                        $pagina_ini = $pagina_ini;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;
                        $concat_pagina_fim .= "||" . $pagina_fim;
                    }
                }
            } else {
                $encontra_cpf_nextline++;
            }
        }

        // IDENTIFICA OS CPFs E CONCATENA
        if (preg_match('/(CPF:)/i', $var_text)) {

            $cpf = preg_match('/(\d{3}\.){2}\d{3}\-\d{2}/i', $var_text, $match) ? remover_nao_numericos($match[0]) : '';

            if (empty($cpf)) {
                $encontra_cpf_nextline = 1;
            } else {
                $cpf_anterior = $cpf_anterior <> $cpf ? 1 : 2;

                if ($cpf_anterior == 1) { // PAGINAS COM CPFS DIFERENTES

                    if (!empty($cpf)) {

                        $concat_cpf = $concat_cpf . "||" . $cpf;
                        $contagem_Cpf++;
                        $pagina_ini = $page_number;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;
                        $concat_pagina_fim .= "||" . $pagina_fim;
                    }
                } else if ($cpf_anterior == 2) { // PAGINAS COM CPFS IGUAIS

                    if (!empty($cpf)) {

                        $concat_cpf = $concat_cpf . "||" . $cpf;
                        $contagem_Cpf++;
                        $pagina_ini = $pagina_ini;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;
                        $concat_pagina_fim .= "||" . $pagina_fim;
                    }
                }
            }

        }

        // echo "var_text = $var_text";

        // Verifica e identifica o valor liquido
        $encLiquidoP1 = preg_match('/LIQUIDO........R/i', $var_text) ? 1 : $encLiquidoP1;

        if ($encLiquidoP1 && preg_match('/^(\d+\.)?\d+\,\d{2}$/i', $var_text)) {

            $valorLiquido = $var_text;
            $valorLiquido_consulta = str_replace("*", "", $var_text);

            // echo "<br>valorLiquido = $valorLiquido <br>";

            if ($valorLiquido_consulta != "") {

                $concat_valor_liquido = $concat_valor_liquido . "||" . $valorLiquido;

                if ($exibeVarTexto  != 0) {
                    echo "<br>VALOR LIQUIDO:" . $valorLiquido . "<br>";
                }

                unset($encLiquidoP1);
            } else {

                $valorliq = 1;
                unset($encLiquidoP1);
            }
        }
    }

    $regarq = $contagem_Cpf;

    $cpf_anterior = $cpf;

    // Tipo de Página Única" ou "Página Espelhada 
    $tipo_pagina = empty($pagina_espelhada) ? "Página Única" : "Página Espelhada";

    // Reset variveis
    unset($cnpj_consulta, $contagCpfPag);
}

if ($exibeRegistros != 0) {
    echo "<br><br>/ **************************************************************************** / <br>";

    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de CPF na Pagina:" . $contagem_Cpf . "<br>";
    echo "<br>CPF concatenados:" . $concat_cpf . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "<br>Page FINAL:" . $pagina_fim . "<br>";
    echo "<br>Competencia:" . $competencia . "<br>";

    echo "<br> / **************************************************************************** /";
}

if (empty($encDois_Cpfs)) {
    if (!empty($retorno_cnpj)) {
        for ($i = 1; $i <= $contagem_Cpf; $i++) {

            $cpf_array = explode('||', $concat_cpf);
            $cpf_select = trim($cpf_array[$i]);

            $valorLiquido = formatar_decimal(trim(explode('||', $concat_valor_liquido)[$i]));
            $pagina_ini = trim(explode('||', $concat_pagina_ini)[$i]);
            $pagina_fim = trim(explode('||', $concat_pagina_fim)[$i]);

            $tabela_usu = 'public."GESUSU"';
            $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

            //CRIAR ID_VALIDADOR
            $validador = $raiz_cnpj . uniqid() . gerar_id_unico();
            $arquivo = $validador . '.pdf';

            $situac = 1;

            foreach (selectGESUSU_LAYOUT_id_cpf($tabela_usu, $cpf_select, $idEmpDefault) as $select_tabela) {

                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];

                if ($exibeRegistros != 0) {
                    echo "<br><br>id_usu === $id_usu<br>";
                    echo "cpf === $cpf_select<br>";
                    echo "idEmpDefault === $idEmpDefault<br>";
                }

                try {
                    if ($select_tabela != 0) {
                        if ($desativaInsercao  == 0) {

                            // initiate FPDI
                            $pdf = new FPDI();

                            for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {
                                if ($desativaInsercao  == 0) {
                                    $pdf->AddPage(); //P = RETRATO, L = PAISAGEM
                                    $pdf->setSourceFile($nomearquivo);
                                    $tplIdx = $pdf->importPage($pagina_loop);
                                    $pdf->useTemplate($tplIdx);
                                }
                                // echo "Paginas a gravar:" . $pagina_loop . "<br>";
                            }

                            // Salvamento do arquivo em diretorio
                            if ($desativaInsercao  == 0) {
                                $output_dir = '../../../upload/beneficios/holerite/' . $raiz_cnpj;
                                if (!is_dir($output_dir)) { mkdir($output_dir, 0777, true); }
                                $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');
                            }
                        }

                        if ($desativaInsercao  == 0) {
                            try {
                                $insert_tabela1 = insertGESIM1_arquivo_regarq(
                                    $tabela_gesim1,
                                    $idEmpDefault,
                                    $competencia,
                                    NULL, //$rg
                                    NULL, //$cpf
                                    $nome,
                                    $cargo,
                                    NULL, //$data_credito
                                    NULL, //$vlr_vencimento
                                    NULL, //$vlr_desconto
                                    ($valorLiquido !== '' ? $valorLiquido : NULL), //$vlr_liquido
                                    NULL, //$faixa_irrf
                                    NULL, //$vlr_basesalario
                                    NULL, //$vlr_baseinss
                                    NULL, //$vlr_basefgts
                                    NULL, //$vlr_baseirrf
                                    NULL, //$vlr_baseir
                                    NULL, //$vlr_fgts
                                    $situac,
                                    $id_usu,
                                    $dataInclusao,
                                    $id_usa,
                                    $descricao_recibo,
                                    $validador,
                                    $processamento,
                                    $origem,
                                    $arquivo,
                                    $regarq
                                );

                                $id_im1 = $insert_tabela1['pk'];
                            } catch (PDOException $erro) {
                                die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                            }
                        }
                        if ($exibeRegistros != 0) {

                            echo "<br><br>Tabela: $tabela_gesim1<br>";
                            echo "Id Emp: $idEmpDefault<br>";
                            echo "Competencia: $competencia<br>";
                            echo "Nome: $nome<br>";
                            echo "Cargo: $cargo<br>";
                            echo "Valor Liquido: $valorLiquido<br>";
                            echo "Situac: $situac<br>";
                            echo "Id Usu: $id_usu<br>";
                            echo "Datinc: $dataInclusao<br>";
                            echo "Id Usa: $id_usa<br>";
                            echo "Descricao: $descricao_recibo<br>";
                            echo "Validador: $validador<br>";
                            echo "Processamento: $processamento<br>";
                            echo "Origem: $origem<br>";
                            echo "Arquivo: $arquivo<br>";
                            echo "Regarq: $regarq<br>";
                        }
                    } else {
                        // echo "Nenhum resultado encontrado para o CPF: [$cpf_select]<br>";
                        if ($exibeRegistros != 0) {
                            echo "<br>CPF:" . $cpf_select . "<br>";
                            echo "DATA:" . $dataInclusao . "<br>";
                            echo "ORGIGEM:" . $origem . "<br>";
                            echo "DESCRICAO:" . $descricao_recibo . "<br>";
                            echo "ID_PROCESSAMENTO:" . $processamento . "<br>";
                            echo "ID_EMP:" . $idEmpDefault . "<br>";
                            echo "REGARQ:" . $regarq . "<br>";
                            echo "Pagina:" . $pagina_ini . "<br>";
                        }

                        if ($desativaInsercao  == 0) {
                            try {
                                $tipo = 'CPF';
                                $insert_tabela2 = insertGESIM_LOG(
                                    $idEmpDefault,
                                    $cpf_select, //IDENTIFICADOR
                                    $tipo, //TIPO DE INDENTIFICADOR
                                    $descricao_recibo, //DESCRIÇAO IMPORTAÇAO
                                    $origem, //ARQUIVO DE ORIGEM
                                    $processamento, //LOTE PROCESSAMENTO
                                    $regarq, //PAGINAS POR ARQUIVO
                                    $pagina_ini, //PAGINA INCONSISTENCIA
                                    $dataInclusao
                                );

                                $id_imlog = $insert_tabela2['pk'];
                            } catch (PDOException $erro) {
                                $_SESSION["erro_importação"] = '1 - ' . $erro;
                                header('Location: ' . $erro_1);
                                die();
                            }
                        }
                    }
                } catch (setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException $e) {
                    $errorMessage = 'Não foi possível processar o documento PDF: ' . $e->getMessage();
                    $_SESSION["erro_importação"] = $errorMessage;
                    header('Location: ' . $erro_1);
                    die($errorMessage);
                }
            }
        }
        if ($desativaInsercao  == 0) {
            echo "<script language=javascript>
            location.href = '../../lotes_processados';
            </script>";
        }
    } else {
        if ($desativaInsercao  == 0) {
            ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
        }
    }
} else {
    if ($desativaInsercao  == 0) {
        ($_SESSION['erro_importação'] = 'O arquivo selecionado esta apresentando mais de um colaborador por pagina!') . (header('Location:' . $erro_1));
    }
}

function gerar_id_unico($lenght = 13)
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

function remover_nao_numericos($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

function formatar_decimal($string)
{
    //$valor = number_format(str_replace(",", ".", str_replace(".", "", $string)), 2, ".", ""); // CAUSOU PROBLEMA COM REGIONAIS DAS MAQUINAS
    $valor = str_replace(",", ".", str_replace(".", "", $string));
    return $valor;
}
