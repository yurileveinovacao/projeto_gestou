<?php

// ===================================================================================
// TEMPLATE: dirf_v4_ignora_cnpj
// BASEADO EM: dirf_v4.php
// DIFERENÇA: Ignora a validação de CNPJ do PDF contra o CNPJ da empresa logada.
//            Útil para empresas do mesmo grupo econômico que possuem CNPJs diferentes
//            mas compartilham o mesmo cadastro de funcionários no sistema.
//            A validação de CPF do funcionário contra a tabela GESUSU continua ativa.
// ===================================================================================

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

// Variavel que cria o id_processamento
$processamento = uniqidReal();

// Variavel que recebe o arquivo e seu caminho
$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

// Atribuição da variavel base
$json_base = json_decode($_SESSION["text_vis"]);

$contagem_cpf = 0;

// Flag para indicar que encontrou um CNPJ qualquer no PDF (sem validar qual)
$retorno_cnpj = 0;

// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {
    $encontra_anoexe = 0; //inicio variavel verificar anoexercicio
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;
        $var_text = str_replace("R.G.:", "R.G.:", str_replace("Ó", "O", str_replace("ó", "o", str_replace("Ç", "C", str_replace("Õ", "O", str_replace("(", "", str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i", str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I", str_replace("ê", "e", str_replace("Ê", "E", $var_text))))))))))))));

        // Detecção antecipada do ano (Google Vision retorna ano antes do CNPJ)
        if ($encontra_anoexe == 0) {
            // Formato 1: 'Exercicio de 2023' numa linha só
            if (preg_match('/Exercicio\s+de\s+(20[0-9]{2})/i', $var_text, $match_exe)) {
                $anoexe = $match_exe[1];
                $anocal = $anoexe - 1;
                $encontra_anoexe = 1;
            }
            // Formato 2: 'EXERCICIO:' numa linha, '2026' na próxima
            if (preg_match('/EXERCICIO:/i', $var_text)) {
                $encontra_exercicio_label = 1;
            }
            if (isset($encontra_exercicio_label) && $encontra_exercicio_label == 1 && preg_match('/^20[0-9]{2}$/', trim($var_text))) {
                $anoexe = trim($var_text);
                $anocal = $anoexe - 1;
                $encontra_anoexe = 1;
                $encontra_exercicio_label = 0;
            }
        }

        if (preg_match('/Responsavel pelas Informacoes|RESPONSAVEL PELAS INFORMACOES/i', $var_text)) {
            $pagina_fim = $page_number;
        }

        // Identificar CNPJ no PDF (apenas para saber que é um documento válido, sem comparar)
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            $retorno_cnpj = 1;
        }

        // Ao encontrar qualquer CNPJ, já processa o conteúdo da página
        if ($retorno_cnpj == 1) {

            if ($encontra_anoexe == 0) {
                if (preg_match('/20[0-9]{2}|Exercicio\sde\s[0-9]{4}/i', $var_text)) {
                    preg_match('/[0-9]{4}/i', $var_text, $exercicio);
                    $anoexe = $exercicio[0];
                    $anocal = $exercicio[0] - 1;
                    $encontra_anoexe = 1;
                }
            }

            if (empty($encontra_cpf)) {

                if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text)) {

                    $regex = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i';
                    preg_match($regex, $var_text, $resposta);
                    $cpf = $resposta[0];
                    $cpf = limpar_texto($cpf);

                    if ($cpf != $cpf_consulta) {

                        $cpf_consulta = $cpf;
                        $contagem_cpf++;
                        $encontra_cpf = 1;

                        $pagina_ini = $page_number;

                        $concat_cpf = $concat_cpf . "||" . $cpf_consulta;
                        $concat_pagina_ini = $concat_pagina_ini . "||" . $pagina_ini;
                    }

                    $regarq = $contagem_cpf;
                }
            }
        }
    }

    if (empty($complemento)) {
        if (!empty($pagina_fim)) {
            $concat_pagina_fim = $concat_pagina_fim . "||" . $pagina_fim;
        }
    }

    if (empty($pagina_espelhada)) {
        $tipo_pagina = "Página Unica";
    } else {
        $tipo_pagina = "Página Espelhada";
    }

    unset($encontra_cpf);
    unset($pagina_ini);
    unset($pagina_fim);
    unset($complemento);
}


if (!empty($retorno_cnpj)) {

    for ($i = 1; $i <= $contagem_cpf; $i++) {

        $cpf_array = explode('||', $concat_cpf);
        $cpf = trim($cpf_array[$i]);

        $pagina_ini_array = explode('||', $concat_pagina_ini);
        $pagina_ini = trim($pagina_ini_array[$i]);

        $pagina_fim_array = explode('||', $concat_pagina_fim);
        $pagina_fim = trim($pagina_fim_array[$i]);

        $tabela_usu = 'public."GESUSU"';
        $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

        //CRIAR ID_VALIDADOR
        $val1 = uniqid();
        $val2 = uniqidReal();
        $validador = $raiz_cnpj . $val1 . $val2;
        $validador = $validador;
        $arquivo = $validador . '.pdf';
        $situac = 0;

        foreach (selectGESUSU_LAYOUT_id_cpf($tabela_usu, $cpf, $id_emp_default) as $select_tabela) {
            $id_usu = $select_tabela['id_usu'];
            $nome = $select_tabela['nome'];
            $cargo = $select_tabela['funcao'];

            if ($select_tabela != 0) {

                //CRIAR ID_VALIDADOR
                $val1 = uniqid();
                $val2 = uniqidReal();
                $validador = $raiz_cnpj . $val1 . $val2;
                $validador = $validador;
                //-------------------------------------------------------------------------
                $arquivo = $validador . '.pdf';
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';
                $situac = 1;
                //-------------------------------------------------------------------------

                try {
                    $insert_tabela1 = insertGESIRR_arquivo_regarq(
                        $tabela,
                        $anoexe,
                        $anocal,
                        $situac,
                        $id_usu,
                        $id_emp_default,
                        $datinc,
                        $processamento,
                        $id_usa_default,
                        $origem,
                        $arquivo,
                        $regarq
                    );

                    $id_irr = $insert_tabela1['pk'];
                } catch (PDOException $erro) {
                    die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                }

                // initiate FPDI
                $pdf = new FPDI();

                for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {

                    $pdf->AddPage(); //P = RETRATO, L = PAISAGEM
                    $pdf->setSourceFile($nomearquivo);
                    $tplIdx = $pdf->importPage($pagina_loop);
                    $pdf->useTemplate($tplIdx);
                }

                $dirPath = "../../../upload/beneficios/irrf/" . $raiz_cnpj;
                if (!is_dir($dirPath)) { mkdir($dirPath, 0777, true); }
                // Salvamento do arquivo em diretorio
                $pdf->Output('F', '../../../upload/beneficios/irrf/' . $raiz_cnpj . '/' . $validador . '.pdf');
            } else {
                //echo "CPF não existe";
            }
        }
    }

    echo "<script language=javascript>
    location.href = '../../lotes_processados';
    </script>";
} else {

    ($_SESSION['erro_importação'] = 'Não foi possível identificar um CNPJ válido no arquivo!') . (header('Location:' . $erro_1));
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

function buscaExercicio($f_exercicio)
{
    preg_match('/[0-9]{4}/i', $f_exercicio, $f_localizado);
    $f_anoexe = $f_localizado[0];

    return $f_anoexe;
}

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}
