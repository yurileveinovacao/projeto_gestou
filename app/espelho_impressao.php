<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';
require_once __DIR__.'/../config/app.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Gestou - APP</title>

    <style>
        @page {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        body {

            font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            height: 100%;

        }

        .width-100 {

            width: 100%;

        }

        .text-left {

            text-align: left !important;

        }

        .text-center {

            text-align: center !important;

        }

        .text-right {

            text-align: right !important;

        }

        .mb-0 {

            margin-bottom: 0;

        }

        .titulo-descricao {

            font-size: 8pt !important;

        }

        .fs-10 {

            font-size: 9pt !important;

        }

        .titulo-holerite {

            border: 1px solid #000;
            margin-top: 0.5em;
            font-size: 8pt;
            background-color: #D3D3D3;

        }

        .bg-gray {

            background-color: #D3D3D3;

        }

        .itens-holerite {

            border-spacing: 0px;

        }

        thead th {

            border-spacing: 0px;
            text-align: center;

        }

        .itens-holerite tbody td {

            border-spacing: 0px;

        }

        .itens-holerite tfoot td {

            border-spacing: 0px;
            border-top: none;

        }

        .itens-holerite tbody {

            border-bottom: 1px solid #000;
            border-spacing: 0px;

        }

        .bb-table {

            border-bottom: 1px solid #000;

        }

        .bt-table {

            border-top: 1px solid #000;

        }

        .bl-table {

            border-left: 1px solid #000;

        }

        .br-table {

            border-right: 1px solid #000;

        }

        .fs-15 {

            font-size: 15pt;

        }

        .fw-900 {

            font-weight: 900;

        }
    </style>

</head>

<body>

    <?php

    $id_pon1 = $_SESSION["id_pon1_espelho"];


    foreach (select_GESPON_dados($raiz_cnpj, $id_pon1) as $info_espelho) {

        $periodo = $info_espelho["periodo"];
        $nome_arquivo_banco = $info_espelho["nome_arquivo"];
        $logo = $info_espelho["logo_empresa"];
        $empresa = $info_espelho["empresa"];
        $cnpj = $info_espelho["cnpj"];

        $nome = $info_espelho["nome"];
        $pis = $info_espelho["pis"];
        $dataadmis = new DateTime($info_espelho["dataadmissao"]);

        // $id_usu = $info_holerite["id_usu"];
        // $nome = $info_holerite["nome"];
        // $cpf = $info_holerite["cpf"];
        // $datanasc = new DateTime($info_holerite["datanascimento"]);
        // $rg = $info_holerite["rg"];
        // $ctps = $info_holerite["ctps"];
        // $pis = $info_holerite["pis"];
        // $endereco = $info_holerite["endereco"];
        // $bairro = $info_holerite["bairro"];
        // $numero = $info_holerite["numero"];
        // $uf_usuario = $info_holerite["uf_usuario"];
        // $cidade_usuario = $info_holerite["cidade_usuario"];
        // $cep_usuario = $info_holerite["cep_usuario"];


        // $departamento = $info_holerite["departamento"];
        // $funcao = $info_holerite["funcao"];
        // $dataadmis = new DateTime($info_holerite["dataadmissao"]);
    }

    // <?php if (!empty($competencia)) {
    //     echo $competencia;
    // } else {
    //     echo '&nbsp;';
    // }; >
    ?>

    <div id="body">

        <div id="content">

            <!-- DIV DA PÁGINA -->
            <div class="page" style="font-size: 9pt">

                <!-- HEADER DO HOLERITE -->
                <table style="width: 100%;" class="header">
                    <tr>
                        <td class="text-left" style="width: 33.33%;">
                            <img src="../upload/empresa/<?php echo $logo; ?>" height="100"></img>
                        </td>
                        <td class="text-center" style="width: 33.33%;">
                            <h3 class="mb-0">CARTÃO DE PONTOS <br> <?php echo $periodo; ?></h3>
                        </td>
                        <td class="text-right" style="width: 33.33%;">
                            <h3 class="mb-0">EMITIDO DIA <br>
                                <?php
                                //DEFININDO TIMEZONE - DATA E HORA
                                date_default_timezone_set('America/Sao_Paulo');
                                $data = date('d/m/Y');
                                $time = date('H:i:s');
                                echo $datatual = date("d/m/Y H:i:s");
                                ?>
                            </h3>
                        </td>
                    </tr>
                </table>

                <!-- DADOS PESSOAIS -->
                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS EMPRESA</strong></td>
                    </tr>
                </table>
                <table style="width: 100%; margin-bottom: 0.5em">
                    <tr>
                        <td><span class="titulo-descricao">NOME:</span> <br> <strong><?php echo $empresa; ?></strong></td>
                        <td><span class="titulo-descricao">CNPJ:</span><br> <strong><?php echo $cnpj; ?></strong></td>
                    </tr>
                </table>

                <!-- DADOS DA EMPRESA -->
                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS FUNCIONÁRIO</strong></td>
                    </tr>
                </table>
                <table style="width: 100%; margin-bottom: 0.5em">
                    <tr>
                        <td><span class="titulo-descricao">NOME:</span> <br> <strong><?php echo $nome; ?></strong></td>
                        <td><span class="titulo-descricao">PIS:</span><br> <strong><?php echo $pis; ?></strong></td>
                        <td><span class="titulo-descricao">DATA ADMISSÃO:</span><br> <strong><?php echo $dataadmis->format("d/m/Y"); ?></strong></td>
                    </tr>
                </table>

                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>EVENTOS</strong></td>
                    </tr>
                </table>
                <table class="itens-holerite" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="bl-table bb-table" style="width: 13%;">DATA</th>
                            <th class="bl-table bb-table" style="width: 11%;">ENT.1</th>
                            <th class="bl-table bb-table" style="width: 11%;">SAI.1</th>
                            <th class="bl-table bb-table" style="width: 11%;">ENT.2</th>
                            <th class="bl-table bb-table" style="width: 11%;">SAI.2</th>
                            <th class="bl-table bb-table" style="width: 11%;">ENT.3</th>
                            <th class="bl-table bb-table" style="width: 11%;">SAI.3</th>
                            <th class="bl-table bb-table" style="width: 11%;">TOTAL</th>
                            <th class="bl-table br-table bb-table" style="width: 11%;">SALDO</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        foreach (select_GESPON_dados($raiz_cnpj, $id_pon1) as $valores_pontos) {

                            $data_ponto = new DateTime($valores_pontos["data"]);
                            $ent1 = $valores_pontos["ent1"];
                            $sai1 = $valores_pontos["sai1"];
                            $ent2 = $valores_pontos["ent2"];
                            $sai2 = $valores_pontos["sai2"];
                            $ent3 = $valores_pontos["ent3"];
                            $sai3 = $valores_pontos["sai3"];
                            $btotal = $valores_pontos["btotal"];
                            $bsaldo = $valores_pontos["bsaldo"];

                        ?>

                            <tr>
                                <td class="bl-table bb-table text-center"><?php echo $data_ponto->format("d/m/Y");; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $ent1; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $sai1; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $ent2; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $sai2; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $ent3; ?></td>
                                <td class="bl-table bb-table text-center"><?php echo $sai3; ?></td>
                                <td class="bl-table bb-table text-right"><?php echo $btotal; ?></td>
                                <td class="bl-table bb-table br-table text-right"><?php echo $bsaldo; ?></td>
                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>
                    <tfoot>

                        <?php

                        foreach (select_GESPON1_item($raiz_cnpj, $id_emp_default, $id_pon1) as $espelho_ponto) {

                            $btotal = $espelho_ponto['btotal'];
                            $bsaldo = $espelho_ponto['bsaldo'];
                            // $tipo_valor_total = substr($btotal, 0, 1);
                            // $tipo_valor_saldo = substr($bsaldo, 0, 1);

                        }

                        ?>
                        <tr>
                            <td colspan="7" class=""></td>
                            <td colspan="1" class="bb-table bl-table text-right">TOTAL:<br>
                                <span class="fs-15 fw-900"><?php echo $btotal ?></span>
                            </td>
                            <td class="bb-table bl-table br-table text-right">SALDO:<br>
                                <span class="fs-15 fw-900"><?php echo $bsaldo; ?></span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="3" class=""></td>
                            <td colspan="2" class="bb-table bl-table br-table text-right">TOTAL LÍQUIDO <span class="titulo-descricao">(A RECEBER)</span>: <br>
                                <span class="fs-15 fw-900">= ?php echo $liquido = $proventos - $descontos; ?></span>
                            </td>
                        </tr> -->
                    </tfoot>
                </table>
                <!-- <table class="width-100" style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">
                    <tr>
                        <td>CÓDIGO DE VALIDAÇÃO:</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-top: 0em;"><h2 style="margin-bottom: 0px">DND0M9DN2ND8BDV528VQBPDAPA8D</h2></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="white-space: normal">
                        A autenticidade deste comprovante pode ser confirmada pelo site <?= $app_url ?>/validar ou pelo QR Code ao lado.
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">ACCEPTED THIS
                            <span class="written_field" style="padding-left: 4em"> </span>
                            DAY OF <span class="written_field" style="padding-left: 8em;"> </span>,
                            20<span class="written_field" style="padding-left: 4em"> </span>.
                        </td>
                        <td colspan="2" style="padding-left: 1em;">TWIN PEAKS SUPPLY LTD.<br><br>
                            PER:
                            <span class="written_field" style="padding-left: 2.5in"> </span>
                        </td>
                    </tr>
                </table> -->

                <!-- DADOS PESSOAIS -->
                <!-- <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS PESSOAIS</strong></td>
                    </tr>
                </table> -->
                <!-- <table class="width-100" style="border-top: 1px solid black; padding-top: 0.5em; margin-top: 0.5em;">
                    <tr>
                        <td>CÓDIGO DE VALIDAÇÃO:</td>
                        <td> &nbsp; </td>
                        <td class="text-right"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ?php include "gera_qrcode_holerite.php" ?></td>
                    </tr>
                    <tr>
                        <td><strong>?php echo $id_validador; ?></strong></td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                    </tr>
                    <tr>
                        <td>A autenticidade deste comprovante pode ser confirmada pelo site <?= $app_url ?>/validar ou pelo QR Code ao lado.</td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                    </tr>
                </table> -->

                <table style="width: 100%;">
                    <tr>
                        <td class="text-center" style="width: 33.33%;">
                            <h3 class="mb-0">(*) - Batida lançada manualmente</h3>
                        </td>
                        <td class="text-center" style="width: 33.33%;">
                            <h3 class="mb-0">(¨) - Abono Parcial</h3>
                        </td>
                        <td class="text-center" style="width: 33.33%;">
                            <h3 class="mb-0">(^) - Pré Assinalado</h3>
                        </td>
                    </tr>
                </table>

            </div>

        </div>
    </div>

</body>

</html>

<?php

function Mask($mask, $str)
{

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}

?>