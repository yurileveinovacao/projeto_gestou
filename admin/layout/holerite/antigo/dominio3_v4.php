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


// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {
    //echo "<br>Página:" . $key->page . "<br>";

    // Variavel que recebe o numero da página atual
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;
        $var_text =  str_replace("R.G.:", "R.G.:", str_replace("Ó", "O", str_replace("ó", "o", str_replace("Ç", "C", str_replace("Õ", "O", str_replace("(", "", str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i", str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I", str_replace("ê", "e", str_replace("Ê", "E", $var_text))))))))))))));

        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // Exibição da variavel texto gobal em loop
        if ($exibe_var_text  != 0) {
            echo "<br>Valores Registro:" . $var_text . "<br>";
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////

        // Verifica e identifica o CNPJ, caso enconte numera o registro
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $var_text)));
            $cnpj = limpar_texto($cnpj);

            if ($cnpj == $cnpj_completo) {
                $cnpj_consulta = $cnpj;
            }
            // echo "<br>CNPJ:" . $cnpj . "<br>";
            // $nro_registro = $nro_registro + 1;
        }


        if ($cnpj_consulta == $cnpj_completo) {
            $retorno_cnpj = 1;
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Caso encontre a mensalista, ele atribui valor da proxima casa para formar a competencia
            if ($encontra_mensalista == 1) {
                $competencia = $var_text;
                if (preg_match('/\w+\s\w+\s[0-9]{4}/i', $competencia)) {
                    $competencia = trim($competencia);
                    unset($encontra_mensalista);
                } else {
                    //caso entre no else ele vai percorrer até achar 4 digitos numericos
                    $competencia2 = $competencia2  . " " . trim($competencia);
                    if (preg_match('/2[0-9]{3}/i', $competencia)) {
                        $competencia = ltrim($competencia2);
                        unset($encontra_mensalista);
                    }
                }
                //echo "<br>COMPETENCIA:" . $competencia . "<br>";
            }
            // Identificar Mensalista
            if (preg_match('/Mensalista/i', $var_text)) {
                $encontra_mensalista = 1;
                unset($competencia2);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Caso encontre a filial, ele atribui valor da proxima casa para formar o cod usuario
            if ($encontra_filial == 1) {
                $codusu = $var_text;
                $cod_integracao = limpar_texto($codusu);
                unset($encontra_filial);

                //echo "cod_integracao:" . $cod_integracao . "<br>";

                //SELECT PARA VERIFICAR CADASTRO DE USUARIO
                $tabela = 'public."GESUSU"';
                foreach (selectGESUSU_LAYOUT_id_cod($tabela, $cod_integracao, $id_emp_default) as $select_tabela) {
                    if ($select_tabela != 0) {
                        $id_usu = $select_tabela['id_usu'];
                        $nome = $select_tabela['nome'];
                        $cargo = $select_tabela['funcao'];
                        $cpf_formatado = $select_tabela['cpf_formatado'];
                    } else {
                        $cpf_formatado = '999.999.999-99';
                    }
                    // echo "cod_integracao:" . $cod_integracao . "<br>";
                    // echo "cpf_formatado:" . $cpf_formatado . "<br>";
                }
            }
            // Identificar Filial
            if (preg_match('/Filial/i', $var_text)) {
                $encontra_filial = 1;
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // Verifica e identifica o CPF
            //if (preg_match('/CPF:/i', $var_text)) {


            if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $cpf_formatado)) {

                $regex = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i';
                preg_match($regex, $cpf_formatado, $resposta);
                $cpf = $resposta[0];
                $cpf = limpar_texto($cpf);

                // echo '$cpf==========' . $cpf . '<br>';
                // echo '$cpf_consulta===' . $cpf_consulta . '<br>';

                if ($cpf != $cpf_consulta) {

                    $encontra_valor_liquido = 1; //SEMPRE QUE ACHAR O CPF VAI BUSCAR O VALOR LIQUIDO DO CPF ENCONTRADO
                    $cpf_consulta = $cpf;
                    $contagem_cpf++;
                    $contagem_cpf_pagina++;

                    $pagina_ini = $page_number;

                    $concat_cpf = $concat_cpf . "||" . $cpf_consulta;
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
                    // echo "<br>CPF IGUAL O DO REGISTRO ANTERIOR:" . $cpf_consulta . "<br>";
                }
                $regarq =   $contagem_cpf;
            }

            if ($encontra_vlrliquido == 1) {
                if ($encontra_valor_liquido == 1) {
                    $valor_liquido = $var_text;
                    $concat_valor_liquido = $concat_valor_liquido . "||" . $valor_liquido;
                    //echo "<br>VALOR LIQUIDO:" . $valor_liquido . "<br>";
                    unset($encontra_valor_liquido);
                }
                unset($encontra_vlrliquido);
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/Valor Liquido/i', $var_text)) {
                $encontra_vlrliquido = 1;
            }

            // Verifica e identifica o valor liquido
            if (preg_match('/A TRANSPORTAR/i', $var_text)) {
                $complemento = 1;
            }
        }
    }

    if (empty($complemento)) {
        // $pagina_fim = $page_number;
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
    unset($contagem_cpf_pagina);
    unset($pagina_ini);
    unset($pagina_fim);
    unset($complemento);
}

// echo "<br>Tipo de página:" . $tipo_pagina . "<br>";
// echo "<br>Contagem de CPF na Pagina:" . $contagem_cpf . "<br>";
// echo "<br>CPF concatenados:" . $concat_cpf . "<br>";
// echo "<br>Valor Liquido concatenados:" . $concat_valor_liquido . "<br>";
// echo "<br>Page INI:" . $concat_pagina_ini . "<br>";
// echo "<br>Page FIM:" . $concat_pagina_fim . "<br>";
// echo "<br>Page FINAL:" . $pagina_fim . "<br>";

if (empty($dois_cpfs)) {

    if (!empty($retorno_cnpj)) {

        for ($i = 1; $i <= $contagem_cpf; $i++) {

            $cpf_array = explode('||', $concat_cpf);
            $cpf = trim($cpf_array[$i]);

            $valor_liquido_array = explode('||', $concat_valor_liquido);
            $valor_liquido = trim($valor_liquido_array[$i]);
            $valor_liquido = FormatToDecimal($valor_liquido);

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
                    if ($desativa_insert  == 0) {
                        try {
                            $insert_tabela1 = insertGESIM1_arquivo_regarq(
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
                    if ($exibe_registros != 0) {
                        echo "<br>CPF:" . $cpf . "<br>";
                        echo "Nome:" . $nome . "<br>";
                        echo "Valor Liquido:" . $valor_liquido . "<br>";
                        echo "Pagina INI:" . $pagina_ini . "<br>";
                        echo "Pagina FIM:" . $pagina_fim . "<br>";
                        echo "Competencia:" . $competencia . "<br>";
                        echo "CPF's por arquivo:" . $regarq . "<br>";
                    }

                    // initiate FPDI
                    if ($desativa_insert  == 0) {
                        $pdf = new FPDI();
                    }

                    for ($pagina_loop = $pagina_ini; $pagina_loop <= $pagina_fim; $pagina_loop++) {
                        if ($desativa_insert  == 0) {
                            $pdf->AddPage(); //P = RETRATO, L = PAISAGEM
                            $pdf->setSourceFile($nomearquivo);
                            $tplIdx = $pdf->importPage($pagina_loop);
                            $pdf->useTemplate($tplIdx);
                        }
                        //echo "Paginas a gravar:" . $pagina_loop . "<br>";
                    }

                    // Salvamento do arquivo em diretorio 
                    if ($desativa_insert  == 0) {
                        $pdf->Output('F', '../../../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $validador . '.pdf');
                    }
                } else {
                    //echo "CPF não existe";
                }
            }
        }
        if ($desativa_insert  == 0) {
            echo "<script language=javascript>
            location.href = '../../lotes_processados';
            </script>";
        }
    } else {

        ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
        // echo "ELSE CNPJ DIFERENTE EMPRESA";
    }
} else {

    ($_SESSION['erro_importação'] = 'O arquivo selecionado esta apresentando mais de um colaborador por pagina!') . (header('Location:' . $erro_1));
    // echo "MAIS DE 1 COLABORADOR POR PAG";
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
