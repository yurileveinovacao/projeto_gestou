<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

$desativaInsercao = 0; //0 ativa - 1 desativa
$exibeVarTexto = 0; //0 nao exibe - 1 exibe 
$exibeRegistros = 0; //0 nao exibe - 1 exibe

$encontra_vlr_liquido = 0;
$contagemCpf = 0;
$contagemCpfPagina = 0;

// Variavel que recebe a descricao da importacao
$descricaoRecibo = $_SESSION['descricao'];

// Variavel que recebe o nome do PDF
$origem = $_SESSION['nomepdf'];

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

//Variavel CNPJ completo com replace em caracteres não numericos
$cnpjCompleto = preg_replace('/\D/', '', $cnpjCompleto);

// Variavel que cria o id_processamento
$processamento = uniqidReal();

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
        if (preg_match('/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+\/\d{4}/i', $var_text)) {
            $competencia = $var_text;
        }

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{14}/i', $var_text)) {
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $var_text)));
            $cnpj = limpar_texto($cnpj);

            if ($cnpj == $cnpjCompleto) {
                $cnpj_consulta = $cnpj;
            }
        }

        if ($cnpj_consulta == $cnpjCompleto) {
            $retorno_cnpj = 1;

            if ($encontra_codintegracao == 1) {
            // Encontra 000000 na string
            if (preg_match('/[0-9]{6}/i', $var_text)) {

                $regex = '/\d+/i';
                preg_match($regex, $var_text, $resposta);

                $cpf = $resposta[0];
                $cpf = limpar_texto($cpf);

                if ($cpf != $cpf_consulta) {

                    $encontra_valor_liquido = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                    $cpf_consulta = $cpf;
                    $contagemCpf++;
                    $contagemCpfPagina++;
                    $pagina_ini = $page_number;
                    $concat_cpf = $concat_cpf . "||" . $cpf_consulta;
                    $concat_pagina_ini = $concat_pagina_ini . "||" . $pagina_ini;
                    $pagina_fim = $page_number;

                    if ($contagemCpfPagina > 1) {
                        $dois_cpfs = 1;
                        // echo "2 CPFS diferentes por pagina";
                    }
                    // echo "<br>CPF cont page:" . $dois_cpfs . "<br>";
                } else {
                    $pagina_fim = $page_number;
                    $pagina_espelhada = 1;
                    // echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $cpf_consulta . "<br>";
                }
                $regarq =   $contagemCpf;
                unset($encontra_codintegracao);
            }
        }
            //ENCONTROU VALOR LIQUIDO/////////////////////////////////////////////////////////////////////////////////////////
            if ($encontra_vlrliquido_p2 == 1) {
                if ($encontra_valor_liquido == 1) {
                    $valor_liquido = $var_text;
                    $valor_liquido_consulta = str_replace("*", "", $var_text);
                    if ($valor_liquido_consulta != "") {
                        $concat_valor_liquido = $concat_valor_liquido . "||" . $valor_liquido;
                        //echo "<br>VALOR LIQUIDO:" . $valor_liquido . "<br>";
                        unset($encontra_valor_liquido);
                    }
                }
                unset($encontra_vlrliquido_p2);
            }

            if ($encontra_vlr_liquido == 1) {
                $encontra_vlrliquido_p2 = 1;
                unset($encontra_vlr_liquido);
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Identificar Filial
            if (preg_match('/Matricula/i', $var_text)) {
                $encontra_filial = 1;
                $encontra_codintegracao = 1;
              
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/LIQUIDO A RECEBER/i', $var_text)) {
                $encontra_vlr_liquido = 1;
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/A TRANSPORTAR/i', $var_text)) {
                $complemento = 1;
            }
        }
    }

    if (empty($complemento)) {
        if (!empty($pagina_fim)) {
            $concat_pagina_fim = $concat_pagina_fim . "||" . $pagina_fim;
        }
    } else {
    }

    if (empty($pagina_espelhada)) {
        $tipo_pagina = "Página Unica";
    } else {
        $tipo_pagina = "Página Espelhada";
    }
    unset($cnpj_consulta);
    unset($contagemCpfPagina);
    unset($pagina_ini);
    unset($pagina_fim);
    unset($complemento);
}

if ($exibeRegistros != 0) {
    echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
    echo "<br>Contagem de CPF na Pagina:" . $contagemCpf . "<br>";
    echo "<br>CPF concatenados:" . $concat_cpf . "<br>";
    echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
    echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
    echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
    echo "<br>Page FINAL:" . $pagina_fim . "<br>";
}

if (empty($dois_cpfs)) {
    if (!empty($retorno_cnpj)) {
        for ($i = 1; $i <= $contagemCpf; $i++) {
            $cpf_array = explode('||', $concat_cpf);
            $cod_integracao = trim($cpf_array[$i]);

            $valor_liquido = FormatToDecimal(trim(explode('||', $concat_valor_liquido)[$i]));
            $pagina_ini = trim(explode('||', $concat_pagina_ini)[$i]);
            $pagina_fim = trim(explode('||', $concat_pagina_fim)[$i]);

            $tabela_usu = 'public."GESUSU"';
            $tabela_gesim1 = 'public."GESIM1_' . $raiz_cnpj . '"';

            //CRIAR ID_VALIDADOR
            $validador = $raiz_cnpj . uniqid() . uniqidReal();
            $arquivo = $validador . '.pdf';

            $situac = 1;

            foreach (selectGESUSU_LAYOUT_id_cod($tabela_usu, $cod_integracao, $id_emp_default) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];

                if ($exibeRegistros != 0) {
                    echo '$id_usu ===' . $id_usu . '<br>';
                    echo '$cod_integracao ===' . $cod_integracao . '<br>';
                    echo '$id_emp_default ===' . $id_emp_default . '<br>';
                }

                if (!empty($id_usu)) {
                    if ($select_tabela != 0) {
                        if ($desativaInsercao  == 0) {

                            try {
                                $insertTabela1 = insertGESIM1_arquivo_regarq(
                                    $tabela_gesim1,
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
                            echo "<br>CPF:" . $cpf . "<br>";
                            echo "Nome:" . $nome . "<br>";
                            echo "Valor Liquido:" . $valor_liquido . "<br>";
                            echo "Pagina INI:" . $pagina_ini . "<br>";
                            echo "Pagina FIM:" . $pagina_fim . "<br>";
                            echo "Competencia:" . $competencia . "<br>";
                            echo "CPF's por arquivo:" . $regarq . "<br>";
                        }

                        // initiate FPDI
                        if ($desativaInsercao  == 0) {
                            $pdf = new FPDI();
                        }
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
                            $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');
                        }
                    } else {
                        // echo "Nenhum resultado encontrado para o Cod. de Integração.".$cpf.".<br>";
                        if ($exibeRegistros != 0) {
                            echo "<br>CPF:" . $cpf . "<br>";
                            echo "DATA:" . $datinc . "<br>";
                            echo "ORGIGEM:" . $origem . "<br>";
                            echo "DESCRICAO:" . $descricaoRecibo . "<br>";
                            echo "ID_PROCESSAMENTO:" . $processamento . "<br>";
                            echo "ID_EMP:" . $id_emp_default . "<br>";
                            echo "REGARQ:" . $regarq . "<br>";
                            echo "Pagina:" . $pagina_ini . "<br>";
                        }

                        if ($desativaInsercao  == 0) {
                            try {
                                $tipo = 'Matricula/Cód. Integração';
                                $insert_tabela2 = insertGESIM_LOG(
                                    $id_emp_default,
                                    $cpf, // IDENTIFICADOR
                                    $tipo, // TIPO DE IDENTIFICADOR
                                    $descricaoRecibo, // DESCRIÇÃO IMPORTAÇÃO
                                    $origem, // ARQUIVO DE ORIGEM
                                    $processamento, // LOTE PROCESSAMENTO
                                    $regarq, // PÁGINAS POR ARQUIVO
                                    $pagina_ini, // PÁGINA INCONSISTÊNCIA
                                    $datinc
                                );

                                $id_imlog = $insert_tabela2['pk'];
                            } catch (PDOException $erro) {
                                $_SESSION["erro_importação"] = '1 - ' . $erro;
                                header('Location: ' . $erro_1);
                                die();
                            }
                        }
                    }
                } else {
                    //echo "USUARIO ativo com CPF preenchido não existe";
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
    $valor = str_replace(",", ".", str_replace(".", "", $string));
    return $valor;
}
