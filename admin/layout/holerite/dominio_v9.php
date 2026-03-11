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
$encLiquidoP2 = 0;
$contagem_Cpf = 0;
$contagCpfPag = 0;
$codIntegraca = null;
$cpfConsultas = null;
$valorLiquido = null;
$encDois_Cpfs = null;
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

    $prev_text = '';

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
            } elseif (preg_match('/\b(Janeiro|Fevereiro|Marco|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro) de \d{4}\b/i', $var_text, $m_comp)) {
                $competencia = $m_comp[0];
            } elseif ($competenciaEmLinhas == 0 && preg_match('/\b(Janeiro|Fevereiro|Marco|Abril|Maio|Junho|Julho|Agosto|Setembro|Outubro|Novembro|Dezembro)/i', $var_text, $m_comp2)) {
                $competencia = $m_comp2[1] . " ";
                $competenciaEmLinhas = 1;
            }
        }

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/', $var_text, $cnpj_match);
            $cnpj = remover_nao_numericos($cnpj_match[0]);
            if ($cnpj == $cnpjCompleto) {
                $cnpj_consulta = $cnpj;
            }
        }


        if ($cnpj_consulta == $cnpjCompleto) {
            $retorno_cnpj = 1;

            if ($encontra_cod_integracao >= 1 && $encontra_cod_integracao <= 5) {

                // Se a linha seguinte ao "Codigo" é "Descricao", era header da tabela, não do funcionário
                if (preg_match('/^Descri/i', $var_text)) {
                    $encontra_cod_integracao = 0;
                } elseif (preg_match('/\d+/i', $var_text, $resposta)) {
                    $cpf = $resposta[0];
                    $cpf = remover_nao_numericos($cpf);

                    if ($cpf != $cpfConsultas) {
                        $encLiquidoP2 = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                        $cpfConsultas = $cpf;
                        $contagem_Cpf++;
                        $contagCpfPag++;
                        $pagina_ini = $page_number;
                        $concat_cpf .= "||" . $cpfConsultas;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;

                        $valorliq = 0;
                        $forcavalor = 0;

                        if ($contagCpfPag > 1) {
                            $encDois_Cpfs = 1;
                            // echo "2 CPFS diferentes por pagina";
                        }
                        // echo "<br>CPF cont page:" . $encDois_Cpfs . "<br>";
                    } else {

                        if ($valorliq == 1) {

                            $encLiquidoP2 = 1;
                            unset($valorliq);
                        }

                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                        // echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $cpfConsultas . "<br>";
                    }
                    $regarq =   $contagem_Cpf;
                    unset($encontra_cod_integracao);
                } else {
                    $encontra_cod_integracao++;
                }
            }

            // Identificar Código do funcionário (standalone, não como parte do cabeçalho da tabela)
            // Google Vision separa "Código" como header de coluna em linha própria
            if (preg_match('/^Codigo$/i', $var_text)) {
                $encontra_cod_integracao = 1;
            }

            // Rastrear último valor monetário visto (para detecção via Faixa IRRF)
            if (preg_match('/(\d[\d\.]*,\d{2})/', $var_text)) {
                $last_monetary = $var_text;
            }

            // Detectar valor líquido: o valor monetário imediatamente antes de "Faixa IRRF"
            // Mais robusto que "Valor Liquido" header, que no Google Vision pode ficar separado do valor
            if (preg_match('/Faixa IRRF/i', $var_text) && !empty($cpfConsultas) && !empty($last_monetary)) {
                $concat_valor_liquido = $concat_valor_liquido . "||" . $last_monetary;
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/(A )?TRANSPORTAR/i', $var_text)) {
                $complemento = 1;
            }
        }
    }

    // verificação de empty($complemento) com a condição !empty($pagina_fim)
    if (empty($complemento) && !empty($pagina_fim)) {
        $concat_pagina_fim .= "||" . $pagina_fim;
    }

    // Tipo de Página Única" ou "Página Espelhada 
    $tipo_pagina = empty($pagina_espelhada) ? "Página Única" : "Página Espelhada";

    // Reset variveis
    unset($cnpj_consulta, $contagCpfPag, $pagina_ini, $pagina_fim, $complemento);
    unset($encLiquidoP2, $encLiquidoP1);
}

if ($exibeRegistros != 0) {
    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de CPF na Pagina:" . $contagem_Cpf . "<br>";
    echo "<br>CPF concatenados:" . $concat_cpf . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "<br>Page FINAL:" . $pagina_fim . "<br>";
    echo "Competencia:" . $competencia . "<br>";
}

if (empty($encDois_Cpfs)) {
    if (!empty($retorno_cnpj)) {
        for ($i = 1; $i <= $contagem_Cpf; $i++) {

            $cpf_array = explode('||', $concat_cpf);
            $codIntegraca = trim($cpf_array[$i]);

            $valorLiquido = formatar_decimal(trim(explode('||', $concat_valor_liquido)[$i]));
            $pagina_ini = trim(explode('||', $concat_pagina_ini)[$i]);
            $pagina_fim = trim(explode('||', $concat_pagina_fim)[$i]);

            $tabela_usu = 'public."GESUSU"';
            $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

            //CRIAR ID_VALIDADOR
            $validador = $raiz_cnpj . uniqid() . gerar_id_unico();
            $arquivo = $validador . '.pdf';

            $situac = 1;

            foreach (selectGESUSU_LAYOUT_id_cod($tabela_usu, $codIntegraca, $idEmpDefault) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];

                if ($exibeRegistros != 0) {
                    echo '$id_usu ===' . $id_usu . '<br>';
                    echo '$codIntegraca ===' . $codIntegraca . '<br>';
                    echo '$idEmpDefault ===' . $idEmpDefault . '<br>';
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
                                    $valorLiquido, //$vlr_liquido
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
                            echo "<br>Cod Integração:" . $codIntegraca . "<br>";
                            echo "Nome:" . $nome . "<br>";
                            echo "Valor Liquido:" . $valorLiquido . "<br>";
                            echo "Pagina INI:" . $pagina_ini . "<br>";
                            echo "Pagina FIM:" . $pagina_fim . "<br>";
                            echo "Competencia:" . $competencia . "<br>";
                            echo "CPF's por arquivo:" . $regarq . "<br>";
                        }
                    } else {
                        // echo "Nenhum resultado encontrado para o Cod. de Integração.".$cpf.".<br>";
                        if ($exibeRegistros != 0) {
                            echo "<br>Cod Integração:" . $codIntegraca . "<br>";
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
                                $tipo = 'COD_INTEGRACAO';
                                $insert_tabela2 = insertGESIM_LOG(
                                    $idEmpDefault,
                                    $codIntegraca, //IDENTIFICADOR
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
