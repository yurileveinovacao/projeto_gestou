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

    $id_validador = $_SESSION["id_validador_holerite"];


    foreach (select_DADOS_EMPRESA_FUNCIONARIO_HOLERITE($raiz_cnpj, $id_validador) as $info_holerite) {

        $logo = $info_holerite["logo_empresa"];
        $competencia = $info_holerite["competencia"];
        $nome_arquivo_banco = $info_holerite["nome_arquivo"];
        $id_usu = $info_holerite["id_usu"];
        $nome = $info_holerite["nome"];
        $cpf = $info_holerite["cpf"];
        $datanasc = new DateTime($info_holerite["datanascimento"]);
        $rg = $info_holerite["rg"];
        $ctps = $info_holerite["ctps"];
        $pis = $info_holerite["pis"];
        $endereco = $info_holerite["endereco"];
        $bairro = $info_holerite["bairro"];
        $numero = $info_holerite["numero"];
        $uf_usuario = $info_holerite["uf_usuario"];
        $cidade_usuario = $info_holerite["cidade_usuario"];
        $cep_usuario = $info_holerite["cep_usuario"];
        $empresa = $info_holerite["empresa"];
        $cnpj = $info_holerite["cnpj"];
        $telefone = $info_holerite["telefone_empresa"];
        $endereco_empresa = $info_holerite["endereco_empresa"];
        $bairro_empresa = $info_holerite["bairro_empresa"];
        $numero_empresa = $info_holerite["numero_empresa"];
        $uf_empresa = $info_holerite["uf_empresa"];
        $cidade_empresa = $info_holerite["cidade_empresa"];
        $cep_empresa = $info_holerite["cep_empresa"];
        $departamento = $info_holerite["departamento"];
        $funcao = $info_holerite["funcao"];
        $dataadmis = new DateTime($info_holerite["dataadmissao"]);
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
                            <h3 class="mb-0">RECIBO DE PAGAMENTO <br> <?php echo $competencia; ?></h3>
                        </td>
                        <td class="text-right" style="width: 33.33%;">
                            <h3 class="mb-0">CHAPA <?php echo $id_usu; ?></h3>
                        </td>
                    </tr>
                </table>

                <!-- DADOS PESSOAIS -->
                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS PESSOAIS</strong></td>
                    </tr>
                </table>
                <table style="width: 100%; margin-bottom: 0.5em">
                    <tr>
                        <td><span class="titulo-descricao">NOME:</span> <br> <strong><?php echo $nome; ?></strong></td>
                        <td><span class="titulo-descricao">CPF:</span><br> <strong><?php echo Mask("###.###.###-##", $cpf); ?></strong></td>
                        <td><span class="titulo-descricao">DATA NASCIMENTO:</span><br> <strong><?php echo $datanasc->format("d/m/Y"); ?></strong></td>
                    </tr>
                    <tr>
                        <td><span class="titulo-descricao">RG:</span><br> <strong><?php if (!empty($rg)) {
                                                                                        echo $rg;
                                                                                    } else {
                                                                                        echo '&nbsp;';
                                                                                    }; ?></strong></td>
                        <td><span class="titulo-descricao">CTPS:</span><br> <strong><?php if (!empty($ctps)) {
                                                                                        echo $ctps;
                                                                                    } else {
                                                                                        echo '&nbsp;';
                                                                                    }; ?></strong></td>
                        <td><span class="titulo-descricao">PIS:</span><br> <strong><?php if (!empty($pis)) {
                                                                                        echo $pis;
                                                                                    } else {
                                                                                        echo '&nbsp;';
                                                                                    }; ?></strong></td>
                    </tr>
                    <tr>
                        <td><span class="titulo-descricao">LOGRADOURO:</span><br> <strong><?php echo $endereco; ?></strong></td>
                        <td><span class="titulo-descricao">BAIRRO:</span><br> <strong><?php echo $bairro; ?></strong></td>
                        <td><span class="titulo-descricao">NUMERO:</span><br> <strong><?php if (!empty($numero)) {
                                                                                            echo $numero;
                                                                                        } else {
                                                                                            echo '&nbsp;';
                                                                                        }; ?></strong></td>
                    </tr>
                    <tr>
                        <td><span class="titulo-descricao">ESTADO:</span><br> <strong><?php echo $uf_usuario; ?></strong></td>
                        <td><span class="titulo-descricao">CIDADE:</span><br> <strong><?php echo $cidade_usuario; ?></strong></td>
                        <td><span class="titulo-descricao">CEP:</span><br> <strong><?php echo Mask("#####-###", $cep_usuario) ?></strong></td>
                    </tr>
                </table>

                <!-- DADOS DA EMPRESA -->
                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS DA EMPRESA</strong></td>
                    </tr>
                </table>
                <table style="width: 100%; margin-bottom: 0.5em">
                    <tr>
                        <td><span class="titulo-descricao">RAZÃO SOCIAL:</span> <br> <strong><?php echo $empresa; ?></strong></td>
                        <td><span class="titulo-descricao">CNPJ:</span><br> <strong><?php echo $cnpj; ?></strong></td>
                        <td><span class="titulo-descricao">TELEFONE:</span><br> <strong><?php if (!empty($telefone)) {
                                                                                            echo Mask("(###)####-####", $telefone);
                                                                                        } else {
                                                                                            echo '&nbsp;';
                                                                                        }; ?></strong></td>
                    </tr>
                    <tr>
                        <td><span class="titulo-descricao">LOGRADOURO:</span><br> <strong><?php echo $endereco_empresa; ?></strong></td>
                        <td><span class="titulo-descricao">BAIRRO:</span><br> <strong><?php echo $bairro_empresa; ?></strong></td>
                        <td><span class="titulo-descricao">NÚMERO:</span><br> <strong> <?php echo $numero_empresa; ?> </strong></td>
                    </tr>
                    <!-- <tr>
                        <td><span class="titulo-descricao">COMPLEMENTO:</span><br> &nbsp; </td>
                    </tr> -->
                    <tr>
                        <td><span class="titulo-descricao">ESTADO:</span><br> <strong><?php echo $uf_empresa; ?></strong></td>
                        <td><span class="titulo-descricao">CIDADE:</span><br> <strong><?php echo $cidade_empresa; ?></strong></td>
                        <td><span class="titulo-descricao">CEP:</span><br> <strong><?php echo Mask("#####-###", $cep_empresa) ?></strong></td>
                    </tr>
                </table>

                <!-- DADOS CONTRATUAIS -->
                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>DADOS CONTRATUAIS</strong></td>
                    </tr>
                </table>
                <table style="width: 100%; margin-bottom: 0.5em">
                    <tr>
                        <td><span class="titulo-descricao">DEPARTAMENTO:</span> <br> <strong><?php echo $departamento; ?></strong></td>
                        <td><span class="titulo-descricao">FUNÇÃO:</span><br> <strong><?php if (!empty($funcao)) {
                                                                                            echo $funcao;
                                                                                        } else {
                                                                                            echo '&nbsp;';
                                                                                        }; ?></strong></td>
                        <td><span class="titulo-descricao">DATA ADMISSÃO:</span><br> <strong><?php echo $dataadmis->format("d/m/Y"); ?></strong></td>
                    </tr>
                    <!-- <tr>
                        <td><span class="titulo-descricao">LOGRADOURO:</span><br> <strong>RODOVIA SP-350</strong></td>
                        <td><span class="titulo-descricao">BAIRRO:</span><br> <strong>ZONA RURAL</strong></td>
                        <td><span class="titulo-descricao">NÚMERO:</span><br> <strong> &nbsp; </strong></td>
                    </tr> -->
                    <!-- <tr>
                        <td><span class="titulo-descricao">COMPLEMENTO:</span><br> &nbsp; </td>
                    </tr> -->
                    <!-- <tr>
                        <td><span class="titulo-descricao">ESTADO:</span><br> <strong>SÃO PAULO</strong></td>
                        <td><span class="titulo-descricao">CIDADE:</span><br> <strong>SÃO JOSÉ DO RIO PARDO</strong></td>
                        <td><span class="titulo-descricao">CEP:</span><br> <strong>13720-000</strong></td>
                    </tr> -->
                </table>

                <!-- ITENS HOLERITE -->
                <!-- <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 0.5em; font-size: 8pt;">
                    <tr>
                        <td>Model: <strong>Franklin</strong></td>
                        <td>Elevation: <strong>B</strong></td>
                        <td>Size: <strong>1160 Cu. Ft.</strong></td>
                        <td>Style: <strong>Reciprocating</strong></td>
                    </tr>
                </table> -->

                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>EVENTOS</strong></td>
                    </tr>
                </table>
                <table class="itens-holerite" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="bl-table bb-table" width="10%">EVENTO</th>
                            <th class="bl-table bb-table">DESCRIÇÃO</th>
                            <th class="bl-table bb-table" width="10%">REF.</th>
                            <th class="bl-table bb-table" style="min-width: 18%;width: 18%;">PROVENTOS</th>
                            <th class="bl-table br-table bb-table" style="min-width: 18%;width: 18%;">DESCONTOS</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        foreach (select_EVENTOS_HOLERITE($raiz_cnpj, $id_validador) as $eve_holerite) {

                            $id_eve = $eve_holerite["codevento"];
                            $nome_eve = $eve_holerite["nome"];
                            $quantidade = $eve_holerite["quantidade"];
                            $vencimento = $eve_holerite["vencimento"];
                            $desconto = $eve_holerite["desconto"];

                        ?>

                            <tr>
                                <td class="bl-table text-left"><?php echo $id_eve; ?></td>
                                <td class="bl-table text-left"><?php echo $nome_eve; ?></td>
                                <td class="bl-table text-right"><?php echo $quantidade; ?></td>
                                <td class="bl-table text-right"><?php echo $vencimento; ?></td>
                                <td class="bl-table br-table text-right"><?php echo $desconto; ?></td>
                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="bt-table"></td>
                            <td colspan="1" class="bb-table bt-table bl-table text-right">TOTAL PROVENTOS:<br>
                                <?php foreach (select_PROV($raiz_cnpj, $id_validador) as $prov_holerite) {
                                    $proventos = $prov_holerite["vlr"];
                                } ?>
                                <span class="fs-15 fw-900">+ <?php echo $proventos; ?></span>
                            </td>
                            <td class="bb-table bt-table bl-table br-table text-right">TOTAL DESCONTOS:<br>
                                <?php foreach (select_DESC($raiz_cnpj, $id_validador) as $desc_holerite) {
                                    $descontos = $desc_holerite["vlr"];
                                } ?>
                                <span class="fs-15 fw-900">- <?php echo $descontos; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class=""></td>
                            <td colspan="2" class="bb-table bl-table br-table text-right">TOTAL LÍQUIDO <span class="titulo-descricao">(A RECEBER)</span>: <br>
                                <span class="fs-15 fw-900">= <?php echo $liquido = $proventos - $descontos; ?></span>
                            </td>
                        </tr>
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
                        <td><?php include_once "gera_qrcode_holerite.php"; ?></td>
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
                <table class="width-100" style="border-top: 1px solid black; padding-top: 0.5em; margin-top: 0.5em;">
                    <tr>
                        <td>CÓDIGO DE VALIDAÇÃO:</td>
                        <td> &nbsp; </td>
                        <td class="text-right"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php include "gera_qrcode_holerite.php" ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo $id_validador; ?></strong></td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                    </tr>
                    <tr>
                        <td>A autenticidade deste comprovante pode ser confirmada pelo site <?= $app_url ?>/validar ou pelo QR Code ao lado.</td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
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