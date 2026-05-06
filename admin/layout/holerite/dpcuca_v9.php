<?php

require_once '../../restrito.php'; //permissão acesso pagina
require_once '../../iuds_pdo.php'; //persistencia
require_once '../../util.php'; //fonte de variaveis
require_once '../vendor_fpdi/autoload.php'; //chamada da biblioteca do FPDI

use setasign\Fpdi\Fpdi;

// Layout DPCUCA v9 — identificação por matrícula (cod_integracao) em vez de CPF.
// Usado quando o PDF de holerite não traz CPF (apenas PIS), como o relatório DPCUCA atual.

//VARIAVEIS DE CONTROLE
$desativaInsercao = 0; //0 ativa - 1 desativa
$exibeVarTexto = 0; //0 nao exibe - 1 exibe
$exibeRegistros = 0; //0 nao exibe - 1 exibe

//Atribuição de variaveis
$cnpjCompleto = $cnpj_completo;
$idEmpDefault = $id_emp_default;
$dataInclusao = $datinc;

$encLiquidoP1 = 0;
$encLiquidoP2 = 0;
$contagem_Matricula = 0;
$contagMatriculaPag = 0;
$matriculaConsultada = null;
$valorLiquido = null;
$encDois_Matriculas = null;
$achoucompete = 0;
$concat_matricula = '';
$concat_pagina_ini = '';
$concat_pagina_fim = '';
$concat_valor_liquido = '';

$descricao_recibo = $_SESSION['descricao'];
$origem = $_SESSION['nomepdf'];

$erro_1 = '../../erro/erro_1';
$erro_3 = '../../erro/erro_3';

$cnpjCompleto = remover_nao_numericos_v9($cnpjCompleto);
$processamento = gerar_id_unico_v9();
$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

$jsonBase = json_decode($_SESSION["text_vis"]);

foreach ($jsonBase->analyzeResult->readResults as $key) {

    $page_number = $key->page;

    // buffer das últimas linhas — usado para localizar a matrícula 2 linhas antes de "PIS:"
    $linhas_buffer = [];

    foreach ($key->lines as $key2) {

        $var_text = str_replace(
            ['Ó', 'ó', 'Ç', 'Õ', '(', 'ç', 'õ', 'í', 'á', 'Á', 'Í', 'ê', 'Ê', 'R.G.:'],
            ['O', 'o', 'C', 'O', '', 'c', 'o', 'i', 'a', 'A', 'I', 'e', 'E', 'R.G.:'],
            $key2->text
        );

        if ($exibeVarTexto != 0) {
            echo "<br>Valores Registro:" . $var_text . "<br>";
        }

        if ($achoucompete == 0) {
            if (preg_match('/[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/i', $var_text)) {
                $competencia = $var_text;
                $achoucompete = 1;
            }
        }

        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            $cnpj = remover_nao_numericos_v9($var_text);
            if ($cnpj == $cnpjCompleto) {
                $cnpj_consulta = $cnpj;
            }
        }

        if ($cnpj_consulta == $cnpjCompleto) {
            $retorno_cnpj = 1;

            // Identifica matrícula via âncora "PIS:" — matrícula está 2 linhas antes (matrícula, nome, PIS).
            if (preg_match('/^PIS[:.]/i', trim($var_text))) {
                $line_count = count($linhas_buffer);
                $matricula_candidata = $line_count >= 2 ? trim($linhas_buffer[$line_count - 2]) : '';
                if ($matricula_candidata !== '' && preg_match('/^[0-9]{4,6}$/', $matricula_candidata)) {
                    $matricula = $matricula_candidata;

                    if ($matricula != $matriculaConsultada) {
                        $encLiquidoP1 = 1;
                        $matriculaConsultada = $matricula;
                        $contagem_Matricula++;
                        $contagMatriculaPag++;
                        $pagina_ini = $page_number;
                        $concat_matricula .= "||" . $matriculaConsultada;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;

                        if ($contagMatriculaPag > 1) {
                            $encDois_Matriculas = 1;
                        }
                    } else {
                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                    }
                    $regarq = $contagem_Matricula;
                }
            }

            if ($encLiquidoP2 == 1 && $encLiquidoP1 == 1) {
                $valorLiquido = $var_text;
                $valorLiquido_consulta = str_replace("*", "", $var_text);
                if ($valorLiquido_consulta != "") {
                    $concat_valor_liquido .= "||" . $valorLiquido;
                    unset($encLiquidoP1);
                }
                unset($encLiquidoP2);
            }

            if (preg_match('/Vr. Liquido/i', $var_text)) {
                if ($encLiquidoP1 == 1) {
                    $encLiquidoP2 = 1;
                } else {
                    $encLiquidoP2 = 0;
                }
            }

            if (preg_match('/A TRANSPORTAR/i', $var_text)) {
                $complemento = 1;
            }
        }

        $linhas_buffer[] = $var_text;
        if (count($linhas_buffer) > 5) {
            array_shift($linhas_buffer);
        }
    }

    if (empty($complemento) && !empty($pagina_fim)) {
        $concat_pagina_fim .= "||" . $pagina_fim;
    }

    $tipo_pagina = empty($pagina_espelhada) ? "Página Única" : "Página Espelhada";

    unset($cnpj_consulta, $contagMatriculaPag, $pagina_ini, $pagina_fim, $complemento);
    $contagMatriculaPag = 0;
}

if ($exibeRegistros != 0) {
    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de Matriculas:" . $contagem_Matricula . "<br>";
    echo "<br>Matriculas concatenadas:" . $concat_matricula . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "Competencia:" . $competencia . "<br>";
}

// Fix do silêncio: avisa o usuário quando o arquivo não conseguiu ser interpretado.
if (empty($retorno_cnpj)) {
    if ($desativaInsercao == 0) {
        $_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!';
        header('Location: ' . $erro_1);
        exit();
    }
}

if (!empty($encDois_Matriculas)) {
    if ($desativaInsercao == 0) {
        $_SESSION['erro_importação'] = 'O arquivo selecionado está apresentando mais de um colaborador por página!';
        header('Location: ' . $erro_1);
        exit();
    }
}

if ($contagem_Matricula == 0) {
    if ($desativaInsercao == 0) {
        $_SESSION['erro_importação'] = 'Nenhuma matrícula foi localizada no arquivo. Verifique se o relatório está no formato esperado (DPCUCA com matrícula visível).';
        header('Location: ' . $erro_1);
        exit();
    }
}

for ($i = 1; $i <= $contagem_Matricula; $i++) {
    $matricula_array = explode('||', $concat_matricula);
    $matricula = trim($matricula_array[$i]);

    $valorLiquido = formatar_decimal_v9(trim(explode('||', $concat_valor_liquido)[$i]));
    $pagina_ini = trim(explode('||', $concat_pagina_ini)[$i]);
    $pagina_fim = trim(explode('||', $concat_pagina_fim)[$i]);

    $tabela_usu = 'public."GESUSU"';
    $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

    $validador = $raiz_cnpj . uniqid() . gerar_id_unico_v9();
    $arquivo = $validador . '.pdf';

    $situac = 1;

    // Busca por cod_integracao mantendo o valor textual (preserva zeros à esquerda).
    $select_tabela_resultset = selectGESUSU_id_cod_str_v9($tabela_usu, $matricula, $idEmpDefault);

    foreach ($select_tabela_resultset as $select_tabela) {
        $id_usu = isset($select_tabela['id_usu']) ? $select_tabela['id_usu'] : null;
        $nome = isset($select_tabela['nome']) ? $select_tabela['nome'] : null;
        $cargo = isset($select_tabela['funcao']) ? $select_tabela['funcao'] : null;

        if ($exibeRegistros != 0) {
            echo '$id_usu ===' . $id_usu . '<br>';
            echo '$matricula ===' . $matricula . '<br>';
            echo '$idEmpDefault ===' . $idEmpDefault . '<br>';
        }

        try {
            if ($select_tabela != 0) {
                if ($desativaInsercao == 0) {

                    $pdf = new FPDI();

                    for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {
                        $pdf->AddPage();
                        $pdf->setSourceFile($nomearquivo);
                        $tplIdx = $pdf->importPage($pagina_loop);
                        $pdf->useTemplate($tplIdx);
                    }

                    $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');

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
                            $valorLiquido,
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
                        $_SESSION["erro_importação"] = '1 - ' . $erro;
                        header('Location: ' . $erro_1);
                        die();
                    }
                }
            } else {
                if ($desativaInsercao == 0) {
                    try {
                        $tipo = 'MATRICULA';
                        $insert_tabela2 = insertGESIM_LOG(
                            $idEmpDefault,
                            $matricula,
                            $tipo,
                            $descricao_recibo,
                            $origem,
                            $processamento,
                            $regarq,
                            $pagina_ini,
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

        unset($select_tabela);
    }
}

if ($desativaInsercao == 0) {
    echo "<script language=javascript>
            location.href = '../../lotes_processados';
            </script>";
}

function gerar_id_unico_v9($length = 13)
{
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception('nenhuma função aleatória criptograficamente segura disponível');
    }
    return substr(bin2hex($bytes), 0, $length);
}

function remover_nao_numericos_v9($str)
{
    return preg_replace('/\D/', '', $str);
}

function formatar_decimal_v9($string)
{
    return str_replace(",", ".", str_replace(".", "", $string));
}

// Variante de selectGESUSU_LAYOUT_id_cod que usa PARAM_STR — preserva zeros à esquerda
// na coluna cod_integracao (ex.: matrícula "00053" não pode virar inteiro 53).
function selectGESUSU_id_cod_str_v9($tabela, $cod_integracao, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome, funcao, cpf FROM ' . $tabela . ' WHERE cod_integracao=:cod_integracao AND id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}
