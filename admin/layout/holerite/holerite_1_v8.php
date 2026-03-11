<?php

require_once '../../restrito.php'; //permissão acesso pagina
require_once '../../iuds_pdo.php'; //persistencia
require_once '../../util.php'; //fonte de variaveis 
require_once '../vendor_fpdi/autoload.php'; //chamada da biblioteca do FPDI

use setasign\Fpdi\Fpdi;

//VARIAVEIS DE CONTROLE
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

$encLiquidoP0 = 0;
$encLiquidoP1 = 0;
$encLiquidoP2 = 0;
$contagem_Cpf = 0;
$contagCpfPag = 0;
$codIntegraca = null;
$cpfConsultas = null;
$valorLiquido = null;
$encDois_Cpfs = null;
$encontra_competencia_date = 0;
$competencia_date1 = '';

// Variavel que recebe a descricao da importacao
$descricaoRecibo = $_SESSION['descricao'];

// Variavel que recebe o nome do PDF
$origem = $_SESSION['nomepdf'];

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

// Variavel CNPJ completo com replace em caracteres não numericos
$cnpjCompleto = remover_nao_numericos($cnpjCompleto);

// Variavel que cria o id_processamento
$processamento = gerar_id_unico();

// Variavel que recebe o arquivo e seu caminho
$nomeArquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

// Atribuição da variavel base
$jsonBase = json_decode($_SESSION["text_vis"]);

// Foreach para realizar o loop das páginas
foreach ($jsonBase->analyzeResult->readResults as $key) {

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

        // Exibição da variavel texto gobal em loop
        if ($exibeVarTexto  != 0) {
            echo "<br>Valores Registro:" . $var_text . "<br>";
        }

        //LOCALIZAR COMPETENCIA
        if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}\s*[a-zA-Z]\s*[0-9]{2}\/[0-9]{2}\/[0-9]{4}/i', $var_text)) {
            $competencia = $var_text;
        } else if ($encontra_competencia_date >= 1 && $encontra_competencia_date <= 5) {
            if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $var_text, $date_match)) {
                $competencia = $competencia_date1 . " a " . $date_match[0];
                $encontra_competencia_date = 0;
            } else {
                $encontra_competencia_date++;
            }
        } else if (empty($competencia) && preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $var_text, $date_match)) {
            $competencia_date1 = $date_match[0];
            $encontra_competencia_date = 1;
        }

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{14}/i', $var_text)) {
            preg_match('/[0-9]{14}/', $var_text, $cnpj_match);
            $cnpj = $cnpj_match[0];
            if ($cnpj == $cnpjCompleto) {
                $cnpj_consulta = $cnpj;
            }
        }

        if ($cnpj_consulta == $cnpjCompleto) {
            $retorno_cnpj = 1;

            if ($encontra_codintegracao >= 1 && $encontra_codintegracao <= 5) {
                // Encontra 000000 na string
                //if (preg_match('/[0-9]{6}/i', $var_text)) {
                if (preg_match('/[0-9]{6}\s(\w+\s)+/i', $var_text)) {
                    $regex = '/\d+/i';
                    preg_match($regex, $var_text, $resposta);
                    $cpf = $resposta[0];
                    $cpf = remover_nao_numericos($cpf);

                    if ($cpf != $cpf_consulta) {
                        $encLiquidoP0 = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                        $cpf_consulta = $cpf;
                        $contagem_Cpf++;
                        $contagCpfPag++;
                        $pagina_ini = $page_number;
                        $concat_cpf .= "||" . $cpf_consulta;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;

                        if ($contagCpfPag > 1) {
                            $dois_cpfs = 1;
                            // echo "2 CPFS diferentes por pagina";
                        }
                        // echo "<br>CPF cont page:" . $dois_cpfs . "<br>";
                    } else {
                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                        // echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $cpf_consulta . "<br>";
                    }
                    $regarq =   $contagem_Cpf;
                    unset($encontra_codintegracao);
                } else {
                    $encontra_codintegracao++;
                }
            }
            //ENCONTROU VALOR LIQUIDO/////////////////////////////////////////////////////////////////////////////////////////
            if ($encLiquidoP1 == 1 && $encLiquidoP0 == 1) {
                $valorLiquido = $var_text;
                $valor_liquido_consulta = str_replace("*", "", $var_text);
                if ($valor_liquido_consulta !== "") {
                    $concat_valor_liquido .= "||" . $valorLiquido;
                    //echo "<br>VALOR LIQUIDO:" . $valorLiquido . "<br>";
                    unset($encLiquidoP0);
                }
                unset($encLiquidoP1);
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Identificar Filial
            if (preg_match('/[0-9]{14}/i', $var_text)) {
                $encontra_filial = 1;
                $encontra_codintegracao = 1;
            }
            // Verifica e identifica o valor liquido
            if (preg_match('/Valor Liquido/i', $var_text)) {
                $encLiquidoP1 = 1;
            }
            // Verifica e identifica o valor liquido
            if (preg_match('/A TRANSPORTAR/i', $var_text)) {
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

    unset($encLiquidoP0, $encLiquidoP1);
}

if ($exibeRegistros != 0) {
    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de CPF na Pagina:" . $contagem_Cpf . "<br>";
    echo "<br>CPF concatenados:" . $concat_cpf . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "<br>Page FINAL:" . $pagina_fim . "<br>";
}

if (empty($dois_cpfs)) {
    if (!empty($retorno_cnpj)) {
        for ($i = 1; $i <= $contagem_Cpf; $i++) {
            $cpf_array = explode('||', $concat_cpf);
            $cod_integracao = trim($cpf_array[$i]);

            $valorLiquido = formatar_decimal(trim(explode('||', $concat_valor_liquido)[$i]));
            $pagina_ini = trim(explode('||', $concat_pagina_ini)[$i]);
            $pagina_fim = trim(explode('||', $concat_pagina_fim)[$i]);

            $tabela_usu = 'public."GESUSU"';
            $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

            //CRIAR ID_VALIDADOR
            $validador = $raiz_cnpj . uniqid() . gerar_id_unico();
            $arquivo = $validador . '.pdf';

            $situac = 1;

            foreach (selectGESUSU_LAYOUT_id_cod($tabela_usu, $cod_integracao, $idEmpDefault) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];

                if ($exibeRegistros != 0) {
                    echo '<br>';
                    echo '$ID_USU ===========' . $id_usu . '<br>';
                    echo '$COD_INTEGRACAO ===' . $cod_integracao . '<br>';
                    echo '$ID_EMP_DEFAULT ===' . $idEmpDefault . '<br>';
                }
                try {
                    if ($select_tabela != 0) {

                        // initiate FPDI
                        if ($desativaInsercao  == 0) {
                            $pdf = new FPDI();

                            for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {
                                if ($desativaInsercao  == 0) {
                                    $pdf->AddPage(); //P = RETRATO, L = PAISAGEM
                                    $pdf->setSourceFile($nomeArquivo);
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
                                $insertTabela1 = insertGESIM1_arquivo_regarq(
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
                                    $descricaoRecibo,
                                    $validador,
                                    $processamento,
                                    $origem,
                                    $arquivo,
                                    $regarq
                                );
                                $id_im1 = $insertTabela1['pk'];
                            } catch (PDOException $erro) {
                                $_SESSION["erro_importação"] = '1 - ' . $erro;
                                header('Location: ' . $erro_1);
                                die();
                            }
                        }
                        if ($exibeRegistros != 0) {
                            echo "Cod.Integração:" . $cod_integracao . "<br>";
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
                            echo "<br--------------<NÃO LOCALIZADO--------------<br>";
                            echo "Cod.Integração:" . $cod_integracao . "<br>";
                            echo "DATA:" . $dataInclusao . "<br>";
                            echo "ORGIGEM:" . $origem . "<br>";
                            echo "DESCRICAO:" . $descricaoRecibo . "<br>";
                            echo "ID_PROCESSAMENTO:" . $processamento . "<br>";
                            echo "ID_EMP:" . $idEmpDefault . "<br>";
                            echo "REGARQ:" . $regarq . "<br>";
                            echo "Pagina:" . $pagina_ini . "<br>";
                        }

                        if ($desativaInsercao  == 0) {
                            try {
                                $tipo = 'Matricula/Cód. Integração';
                                $insert_tabela2 = insertGESIM_LOG(
                                    $idEmpDefault,
                                    $cod_integracao, // IDENTIFICADOR
                                    $tipo, // TIPO DE IDENTIFICADOR
                                    $descricaoRecibo, // DESCRIÇÃO IMPORTAÇÃO
                                    $origem, // ARQUIVO DE ORIGEM
                                    $processamento, // LOTE PROCESSAMENTO
                                    $regarq, // PÁGINAS POR ARQUIVO
                                    $pagina_ini, // PÁGINA INCONSISTÊNCIA
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
                } catch (\setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException $e) {
                    $errorMessage = 'Não foi possível processar o documento PDF: ' . $e->getMessage();
                    $_SESSION["erro_importação"] = $errorMessage;
                    header('Location: ' . $erro_1);
                    die($errorMessage);
                }

                // Limpar o array $select_tabela
                unset($select_tabela);
            }
        }
        if ($desativaInsercao  == 0) {
            echo "<script language=javascript>
            location.href = '../../lotes_processados';
            </script>";
        }
    } else {
        if ($desativaInsercao  == 0) {
            $_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!';
            header('Location: ' . $erro_1);
            exit();
        }
    }
} else {
    if ($desativaInsercao  == 0) {
        $_SESSION['erro_importação'] = 'O arquivo selecionado está apresentando mais de um colaborador por página!';
        header('Location: ' . $erro_1);
        exit();
    }
}

function gerar_id_unico($length = 13)
{
    // O uniqid fornece 13 caracteres, mas você pode ajustá-lo às suas necessidades..
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception('nenhuma função aleatória criptograficamente segura disponível');
    }
    return substr(bin2hex($bytes), 0, $length);
}

function remover_nao_numericos($str)
{
    return preg_replace('/\D/', '', $str);
}

function formatar_decimal($string)
{
    return str_replace(",", ".", str_replace(".", "", $string));
}
