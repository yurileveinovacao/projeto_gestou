<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

$processamento = uniqidReal();
// $descricao_recibo = $_SESSION['descricao'];
$origem = $_SESSION['nomepdf'];

$cnpj_completo = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj_completo)));

$erro_1 = '../../erro/erro_1'; //erro generico
$erro_3 = '../../erro/erro_3'; //erro arquivo anexado

$nomearquivo = '../../uploads/' . $raiz_cnpj . '.pdf';

//echo $_SESSION["text_vis"];
$text_vis = str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i", str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I", $_SESSION["text_vis"]))))));

// Atribuição da variavel base
$json_base = json_decode($text_vis);

// Variavel utilizada em página como parametro para listar quando o registro inicia
$folha_func = 0;
$folha_func2 = 0;

// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {
    // echo "<br>Página:" . $key->page . "<br>";

    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;
        $text =  $var_text;
        // Exibição da variavel texto gobal em loop
        // echo "<br>Valores Registro:" . $var_text . "<br>";

        if (preg_match('/Fonte Pagadora Pessoa Juridica/i', $text)) {
            // Atribui a página atual como começo para o registro
            $pagina_inicio = $page_number;

            // Variavel de parametro para o loop de registro de funcionario 
            $folha_func = $folha_func + 1;
        }

        if (preg_match('/Responsavel pelas Informacoes/i', $text)) {
            // Ao encontrar novamente o CNPJ, a variavel recebe o numero da página atual -1, apontando a pagina anterior como final para o registro
            $pagina_fim = $page_number;

            // Variavel de parametro para o loop de registro de funcionario 
            $folha_func2 = $folha_func2 + 1;
        }

        // Identificar CNPJ
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $text)) {
            $cnpj_encontrado = str_replace(".", "", str_replace("/", "", str_replace("-", "", $text)));

            if ($cnpj_encontrado == $cnpj_completo) {
                // echo "<br>CNPJ:" . $cnpj_encontrado . "<br>";
                $cnpj = $cnpj_encontrado;
            } else {
                // echo "CNPJ DIFERENTE:" . $cnpj_encontrado;
            }
        }

        // Identificar CPF
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $text)) {
            if ($encontra_cpf == 0) {
                $cpf = $text;
                $cpf = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cpf)));
                $cpf = preg_replace("/[^0-9]/i", "", $cpf);
                // echo "<br>CPF:" . $cpf . "<br>";
                $encontra_cpf = 1;
            }
        }

        // Identificar Exercício de
        if (preg_match('/EXERCICIO:|Exercicio\sde\s[0-9]{4}/i', $text)) {
            // $exercicio = $text;
            preg_match('/[0-9]{4}/i', $text, $exercicio);
            $anoexe = $exercicio[0];
            // echo "<br>Exercício de:" . $exercicio[0] . "<br>";
        }

        // Identificar Ano-calendário de
        if (preg_match('/ANO-CALENDARIO:|Ano-calendario\sde\s[0-9]{4}/i', $text)) {
            // $exercicio = $text;
            preg_match('/[0-9]{4}/i', $text, $anocalendario);

            $anocal = $anocalendario[0];

            // echo "<br>Ano-calendário de:" . $anocalendario[0] . "<br>";
        }
    }

    // Ao encontrar novamente o CNPJ entra nessa opçao para salvar o arquivo e realizar update
    if (($folha_func >= 1) and ($folha_func2 >= 1)) {

        if ($cnpj == $cnpj_completo) {

            //SELECT PARA VERIFICAR CADASTRO DE USUARIO
            $tabela_usu = 'public."GESUSU"';
            foreach (selectGESUSU_LAYOUT_id_cpf($tabela_usu, $cpf, $id_emp_default) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];
            }

            if (!empty($id_usu)) {

                $encontrou_registros = 1;
                $regarq = $regarq + 1;

                //     //-------------------------------------------------------------------------
                //CRIAR ID_VALIDADOR
                $val1 = uniqid();
                $val2 = uniqidReal();
                $validador = $raiz_cnpj . $val1 . $val2;
                $validador = $validador;
                //-------------------------------------------------------------------------
                $arquivo = $validador . '.pdf';
                //---------------------------------------------------------------------------------------------------------------------------------------------------------------
                $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';
                $situac = 0;
                //-------------------------------------------------------------------------

                // echo '$pageNo=========='.$pageNo.'---<br>';
                // echo '$tabela===========' . $tabela . '---<br>';
                // echo '$id_emp_default===' . $id_emp_default . '---<br>';
                // echo '$anocal===========' . $anocal . '---<br>';
                // echo '$anoexe===========' . $anoexe . '---<br>';
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
                // echo '$arquivo==========' . $arquivo . '---<br><br>';

                try {
                    $insert_tabela1 = insertGESIRR_arquivo(
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
                        $arquivo
                    );

                    $id_irr = $insert_tabela1['pk'];
                } catch (PDOException $erro) {
                    die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                }

                // // ---------------------------------------------------------------------------------------------------------------------------------------------------------------

                // initiate FPDI
                $pdf = new FPDI();

                // For para adicionar as páginas de registros encontrados em 1 PDF só
                for ($i = $pagina_inicio; $i <= $pagina_fim; $i++) {
                    $pdf->AddPage("P"); //P = RETRATO, L = PAISAGEM
                    $pdf->setSourceFile($nomearquivo);
                    $tplIdx = $pdf->importPage($i);
                    $pdf->useTemplate($tplIdx);
                    // echo "<br>Páginas a gravar:" . $i . "<br>";
                }

                $pdf->Output('F', '../../../upload/beneficios/irrf/' . $raiz_cnpj . '/' . $validador . '.pdf');
            } else {

                $regarq = $regarq + 1;
            }
        } else {
            ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
            // echo "<br>ELSE<br>";
        }

        // Limpa as váriaveis utilizadas para fazer a busca nas strings
        unset($encontra_cnpj);
        unset($encontra_cpf);
        unset($folha_func);
        unset($folha_func2);
    }

    // echo "<br>----------------------------------------- FIM PAG -----------------------------------------<br>";
}

if ($encontrou_registros == 1) {
    // echo "Total encontrado:" . $regarq;
    updateGES_regarq($tabela, $regarq, $processamento);
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
