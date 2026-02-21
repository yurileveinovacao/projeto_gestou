<?php

require_once '../../restrito.php';
require_once '../../iuds_pdo.php';
require_once '../../util.php';
require_once '../vendor_fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

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

// Variavel utilizada em página como parametro para listar quando o registro inicia
$folha_func = 0;

// Atribuição da variavel base

//AJUSTE VARIAVEL POSIÇAO INDESEJADA
$_SESSION["text_vis"] = str_replace("Período:", "Periodo:", str_replace("ADMISSÃO:", "PIS/PASEP:", $_SESSION["text_vis"]));
$json_base = json_decode($_SESSION["text_vis"]);


// Foreach para realizar o loop das páginas
foreach ($json_base->analyzeResult->readResults as $key) {

    //echo "<br><br>Página:" . $key->page . "<br>";

    // Variavel que recebe o numero da página atual
    $page_number = $key->page;

    // Foreach para realizar o loop do conteudo de cada pagina
    foreach ($key->lines as $key2) {

        // Atribuição de variavel texto global
        $var_text = $key2->text;

        // Atribuicao de variavel somente quando o registro for impar
        $text =  $var_text;

        // Exibição da variavel texto gobal em loop
        //echo "<br>Valores Registro:" . $var_text . "<br>";

        // Identificar CNPJ
        if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $text)) {
            $cnpj = $text;
            $cnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj)));
            $cnpj = preg_replace("/[^0-9]/i", "", $cnpj);
            // echo "<br>cnpj:" . $cnpj . "<br>";

            // Atribui a página atual como começo para o registro
            $pagina_inicio = $page_number;

            // Variavel de parametro para o loop de registro de funcionario 
            $folha_func = $folha_func + 1;
        }

        if ($encontra_pis == 1) {
            if (preg_match('/[0-9]{11}/i', $text)) {
                $pis = $text;
                $pis = preg_replace("/[^0-9]/i", "", $pis);
                //echo "<br>PIS:" . $pis . "<br>";
                unset($encontra_pis);
            }
        }


        if ($encontra_periodo == 1) {
            $periodo = $text;
            $periodo = str_replace("Periodo:", "", $periodo);
            $periodo = trim($periodo);
            unset($encontra_periodo);
        }


        // Identificar PIS
        if (preg_match('/PIS\/?PASEP/i', $text)) {
            $encontra_pis = 1;
        }


        // Identificar PERIODO
        if (preg_match('/CARTÃO\sPONTO/i', $text)) {
            $encontra_periodo = 1;
        }
    }

    // Ao encontrar novamente o CNPJ, a variavel recebe o numero da página atual -1, apontando a pagina anterior como final para o registro
    $pagina_fim = $page_number;

    // Ao encontrar novamente o CNPJ entra nessa opçao para salvar o arquivo e realizar update
    if ($folha_func >= 1) {

        // IF para o CNPJ encontrado igual ao cadastrado para a empresa
        if ($cnpj == $cnpj_completo) {

            //SELECT PARA VERIFICAR CADASTRO DE USUARIO
            $tabela_usu = 'public."GESUSU"';
            foreach (selectGESUSU_LAYOUT_id_pis($tabela_usu, $pis, $id_emp_default) as $select_tabela) {
                $id_usu = $select_tabela['id_usu'];
                $nome = $select_tabela['nome'];
                $cargo = $select_tabela['funcao'];
            }

            // Caso encontre o ID_USU no banco
            if (!empty($id_usu)) {

                $encontrou_registros = 1;
                $regarq = $regarq + 1;

                //CRIAR ID_VALIDADOR
                $val1 = uniqid();
                $val2 = uniqidReal();
                $validador = $raiz_cnpj . $val1 . $val2;
                $validador = $validador;
                $arquivo = $validador . '.pdf';
                $tabela = 'public."GESPON1_' . $raiz_cnpj . '"';
                $situac = 0;

                try {

                    // Insert na tabela
                    $insert_tabela1 = insertGESPON1_tangerino(
                        $tabela,
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
                        $arquivo
                    );

                    $id_pon1 = $insert_tabela1['pk'];
                } catch (PDOException $erro) {
                    die(($_SESSION["erro_importação"] = '1 - ' . $erro) . (header('Location:' . $erro_1)));
                }
            } else {

                $regarq = $regarq + 1;
            }
        } else {

            // ELSE caso o CNPJ for diferente do cadastrado na base
            ($_SESSION['erro_importação'] = 'O arquivo selecionado não corresponde a essa empresa!') . (header('Location:' . $erro_1));
        }

        // initiate FPDI
        $pdf = new FPDI();

        // For para adicionar as páginas de registros encontrados em 1 PDF só
        for ($i = $pagina_inicio; $i <= $pagina_fim; $i++) {
            $pdf->AddPage("P"); //P = RETRATO, L = PAISAGEM
            $pdf->setSourceFile($nomearquivo);
            $tplIdx = $pdf->importPage($i);
            $pdf->useTemplate($tplIdx);
        }

        // Salvamento do arquivo em diretorio 
        $pdf->Output('F', '../../../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $validador . '.pdf');

        // Limpa a váriavel de parametro IF
        unset($folha_func);
    }
}

if ($encontrou_registros == 1) {

    // echo "Total encontrado:" . $regarq;
    updateGES_regarq($tabela, $regarq, $processamento);
}

//Redirecionamento para a página de lotes apos concluir todo o loop
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
