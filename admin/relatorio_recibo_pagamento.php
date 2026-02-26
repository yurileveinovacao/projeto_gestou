<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

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
    <link href="img/logo/logo.ico" rel="icon">
    <title>GESTOU PORTAL - RELATÓRIO PAGAMENTO</title>

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

    $id_processamento_relatorio = $_SESSION["id_processamento_relatorio"];
    $raiz_cnpj_relatorio = $_SESSION["raiz_cnpj_relatorio"];

    foreach (select_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj_relatorio, $id_processamento_relatorio) as $info_holerite) {

        $logo = $info_holerite["logo_empresa"];
        $empresa = $info_holerite["empresa"];
        $cnpj = $info_holerite["cnpj"];
        $endereco_empresa = $info_holerite["endereco_empresa"];
        $numero_empresa = $info_holerite["numero_empresa"];
        $bairro_empresa = $info_holerite["bairro_empresa"];
        $complemento_empresa = $info_holerite["complemento_empresa"];
        $cep_empresa = $info_holerite["cep_empresa"];
        $telefone_empresa = $info_holerite["telefone_empresa"];
        $cidade_empresa = $info_holerite["cidade_empresa"];
        $uf_empresa = $info_holerite["uf_empresa"];
        $competencia = $info_holerite["competencia"];
      
    }

    ?>

    <div id="body">

        <div id="content">

            <!-- DIV DA PÁGINA -->
            <div class="page" style="font-size: 9pt">

                <!-- HEADER DO HOLERITE -->
                <table style="width: 100%;" class="header">
                    <tr>
                        <td class="text-left" style="width: 30%;">
                            <img src="../upload/empresa/<?php echo $logo; ?>" height="100" style="background-color: #FFF;border: none;border-radius: 50% !important;"></img>
                        </td>
                        <td class="text-center" style="width: 40%;">
                            <h3 class="mb-0">RELATORIO RECIBO DE PAGAMENTO <br> <?php echo $competencia; ?></h3>
                        </td>
                        <td class="text-right" style="width: 30%;">
                            <img src="img/icone_gestou.png" height="50"></img>
                        </td>
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
                        <td><span class="titulo-descricao">TELEFONE:</span><br> <strong><?php if (!empty($telefone_empresa)) {
                                                                                            echo $telefone = '(' . substr($telefone_empresa, 0, 3) . ') ' . substr($telefone_empresa, 3, 4) 
                                                                                            . '-' . substr($telefone_empresa, 7);
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
                        <td><span class="titulo-descricao">CEP:</span><br> <strong><?php echo $cep = substr($cep_empresa, 0, 5) . '-' . substr($cep_empresa, 5, 3); ?></strong></td>
                    </tr>
                </table>

                <table class="width-100 titulo-holerite">
                    <tr>
                        <td class="fs-10"><strong>RELATORIO</strong></td>
                    </tr>
                </table>
                <table class="itens-holerite" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="bl-table bb-table" width="40%">FUNCIONARIO</th>
                            <th class="bl-table bb-table" width="15%">CPF</th>
                            <th class="bl-table bb-table" width="30%">CARGO</th>
                            <th class="bl-table br-table bb-table" style="min-width: 15%;width: 15%;">VALOR LIQUIDO</th>
                            <!-- <th class="bl-table br-table bb-table" style="min-width: 18%;width: 18%;">DESCONTOS</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $teste_total = 0;

                        foreach (select_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj_relatorio, $id_processamento_relatorio) as $desc_holerite) {

                            $nome_funcionario = $desc_holerite["nome"];
                            $cpf_funcionario = $desc_holerite["cpf"];
                            $cargo_funcionario = $desc_holerite["cargo"];
                            $valor_liquido = $desc_holerite["vlr_liquido"];

                            $teste_total = $teste_total + $valor_liquido;


                        ?>

                            <tr>
                                <td class="bl-table text-left"><?php echo $nome_funcionario; ?></td>
                                <td class="bl-table text-center"><?php echo $cpf_funcionario; ?></td>
                                <td class="bl-table text-left"><?php echo $cargo_funcionario; ?></td>
                                <td class="bl-table text-right br-table"><?php echo $valor_liquido; ?></td>
                                <!-- <td class="bl-table br-table text-right?php echo $desconto; ?></td> -->
                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class=""></td>
                            <td colspan="1" class="bb-table bl-table br-table text-right">TOTAL LÍQUIDO: <br>
                                <span class="fs-15 fw-900"><?php echo $teste_total; ?></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>

</body>

</html>
