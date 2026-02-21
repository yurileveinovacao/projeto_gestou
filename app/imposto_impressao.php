<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once 'conexao.php';

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

        .fs-8 {

            font-size: 8pt !important;

        }

        .fs-7 {

            font-size: 7pt !important;
            padding: 2px;
            line-height: 1.2;

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

        .mt-10px {

            margin-top: 10px;

        }

        @page {
            margin: 30px;
        }
    </style>

</head>

<body>

    <?php

    $id_irr = $_SESSION["id_irr_imposto"];

    foreach (select_GESIRR_dados($raiz_cnpj, $id_irr) as $info_imposto) {

        $anoexe = $info_imposto["anoexe"];
        $anocal = $info_imposto["anocal"];
        $empresa = $info_imposto["empresa"];
        $nome_arquivo_banco = $info_imposto["nome_arquivo"];
        $cnpj = $info_imposto["cnpj"];
        $cpf = $info_imposto["cpf"];
        $nome = $info_imposto["nome"];
        $natren = $info_imposto["natren"];
        $ren_3_1 = $info_imposto["ren_3_1"];
        $ren_3_2 = $info_imposto["ren_3_2"];
        $ren_3_3 = $info_imposto["ren_3_3"];
        $ren_3_4 = $info_imposto["ren_3_4"];
        $ren_3_5 = $info_imposto["ren_3_5"];
        $ren_4_1 = $info_imposto["ren_4_1"];
        $ren_4_2 = $info_imposto["ren_4_2"];
        $ren_4_3 = $info_imposto["ren_4_3"];
        $ren_4_4 = $info_imposto["ren_4_4"];
        $ren_4_5 = $info_imposto["ren_4_5"];
        $ren_4_6 = $info_imposto["ren_4_6"];
        $ren_4_7 = $info_imposto["ren_4_7"];
        $ren_5_1 = $info_imposto["ren_5_1"];
        $ren_5_2 = $info_imposto["ren_5_2"];
        $ren_5_3 = $info_imposto["ren_5_3"];
        $numpro = $info_imposto["numpro"];
        $quames = $info_imposto["quames"];
        $natren_6_1 = $info_imposto["natren_6_1"];
        $ren_6_1 = $info_imposto["ren_6_1"];
        $ren_6_2 = $info_imposto["ren_6_2"];
        $ren_6_3 = $info_imposto["ren_6_3"];
        $ren_6_4 = $info_imposto["ren_6_4"];
        $ren_6_5 = $info_imposto["ren_6_5"];
        $ren_6_6 = $info_imposto["ren_6_6"];
        $infcom = $info_imposto["infcom"];
        $desc_4_7 = $info_imposto["desc_4_7"];
        $nome_8_1 = $info_imposto["nome_8_1"];
        $data_8_1 = new DateTime($info_imposto["data_8_1"]);

        // $dataadmis = new DateTime($info_espelho["dataadmissao"]);

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
                        <td class="text-left" style="width: 50%;">
                            <img src="img/logo/logo_gestou_escrita_amarelo.png" width="150"></img>
                        </td>
                        <!-- <td class="text-center" style="width: 33.33%;">
                            <h3 class="mb-0">CARTÃO DE PONTOS <br> ?php echo $periodo; ?></h3>
                        </td> -->
                        <td class="text-right" style="width: 50%; vertical-align: bottom;">
                            <h3 class="mb-0">https://www.gestou.com.br<br>
                            </h3>
                        </td>
                    </tr>
                </table>

                <!-- HEADER DO IMPOSTO DE RENDA -->
                <table class="width-100" style="border-spacing: 0px;">
                    <tr>
                        <td class="text-left bt-table bb-table bl-table" style="width: 7.5%;">
                            <img src="img/logo/icone_republica_federativa_brasil.png" height="75"></img>
                        </td>
                        <td class="text-center bt-table bb-table br-table" style="width: 42.5%;">
                            <span style="line-height: 1.5;">
                                MINISTÉRIO DA ECONOMIA<br>
                                Secretaria Especial da Receita Federal do Brasil<br>
                                Imposto sobre a Renda da Pessoa Física<br>
                                Exercício de <?php echo $anoexe; ?>
                            </span>
                        </td>
                        <td class="text-center bt-table br-table bb-table" style="width: 50%;">
                            <span style="line-height: 1.5;">
                                Comprovante de Rendimentos Pagos e de<br>
                                Imposto sobre a Renda Retido na Fonte<br><br>
                                Ano-calendário de <?php echo $anocal; ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- 1 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10" colspan="2">1. Fonte Pagadora Pessoa Jurídica</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 33.33%">
                            <span class="fs-7">CNPJ</span>
                        </td>
                        <td class="br-table bt-table" style="width: 66.66%">
                            <span class="fs-7">Nome Empresarial</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table br-table text-center" style="width: 33.33%">
                            <span><?php echo $cnpj; ?></span>
                        </td>
                        <td class="bb-table br-table " style="width: 66.66%">
                            <span><?php echo $empresa; ?></span>
                        </td>
                    </tr>
                </table>
                <!-- 2 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10" colspan="2">2. Pessoa Física Beneficiária dos Rendimentos</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 33.33%">
                            <span class="fs-7">CPF</span>
                        </td>
                        <td class="br-table bt-table" style="width: 66.66%">
                            <span class="fs-7">Nome Completo</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table br-table text-center" style="width: 33.33%">
                            <span><?php echo Mask("###.###.###-##", $cpf); ?></span>
                        </td>
                        <td class="bb-table br-table " style="width: 66.66%">
                            <span><?php echo $nome; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table br-table" colspan="2"><span class="fs-7">Natureza do Rendimento</span></td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table br-table" colspan="2"><span class="fs-7"><?php echo $natren; ?></span></td>
                    </tr>
                </table>
                <!-- 3 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10" style="width: 80%;">3. Rendimentos Tributáveis, Deduções e Imposto sobre a Renda Retido da Fonte</td>
                        <td class="fs-10 text-right" style="width: 20%;">Valores em reais</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">1. Total dos rendimentos (inclusive férias)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_3_1; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">2. Contribuição previdenciária oficial</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_3_2; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">3. Contribuição a entidades de previdência complementar, pública ou privada, e a fundos de aposentadoria programada individual (Fapi)(preencher também o quadro 7)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_3_3; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">4. Pensão alimentícia (preencher também o quadro 7)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_3_4; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">5. Imposto sobre a renda retido na fonte</span>
                        </td>
                        <td class="bb-table br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_3_5; ?></span>
                        </td>
                    </tr>
                </table>
                <!-- 4 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10" style="width: 80%;">4. Rendimentos Tributáveis, Deduções e Impostos sobre a Renda Retido da Fonte</td>
                        <td class="fs-10 text-right" style="width: 20%;">Valores em reais</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">1. Parcele isenta dos proventos de aposentadoria, reserva remunerada, reforma e pensão (65 anos ou mais)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_1; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">2. Diárias e ajuda de custo</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_2; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">3. Pensão e proventos de aposentadoria ou reforma por moléstia grave; proventos de aposentadoria ou reforma por acidente em serviço</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_3; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">4. Lucros e dividendos, apurados a partir de 1996, pagos por pessoa jurídica (lucro real, presumido ou arbitrado)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_4; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">5. Valores pagos ao titular ou sócio da microempresa ou empresa de pequeno porte, exceto pro labore, aluguéis ou serviços prestados</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_5; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">6. Indenizações por recisão de contrato de trabalho, inclusive a título de PDV e por acidente de trabalho</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_6; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">7. Outros: <?php echo $desc_4_7; ?></span>
                        </td>
                        <td class="bb-table br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_4_7; ?></span>
                        </td>
                    </tr>
                </table>
                <!-- 5 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10" style="width: 80%;">5. Rendimentos Sujeitos à Tributação Exclusiva (rendimento líquido)</td>
                        <td class="fs-10 text-right" style="width: 20%;">Valores em reais</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">1. Décimo terceiro salário</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_5_1; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">2. Imposto sobre a renda retido na fonte sobre 13° salário</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_5_2; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">3. Outros</span>
                        </td>
                        <td class="bb-table br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_5_3; ?></span>
                        </td>
                    </tr>
                </table>
                <!-- 6 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;margin-bottom: 10px">
                    <tr>
                        <td class="fs-10" colspan="4">6. Rendimentos Recebidos Acumuladamente - Art. 12-A da Lei n° 7.713, de 1988 (sujeitos à tributação exclusiva)</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 55%;">
                            <span class="fs-7">6.1 Número do processo: <?php echo $numpro; ?></span>
                        </td>
                        <td class="br-table bt-table text-left" style="width: 15%">
                            <span class="fs-7">Quantidade de meses</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 10%">
                            <span class="fs-7"><?php echo $quames; ?></span>
                        </td>
                        <td style="width: 20%">
                            <span class="fs-7"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table bt-table" style="width: 55%;">
                            <span class="fs-7">Natureza do rendimento: <?php echo $natren_6_1; ?></span>
                        </td>
                        <td class="bb-table bt-table text-right" style="width: 15%">
                            <span class="fs-7"></span>
                        </td>
                        <td class="bb-table bt-table br-table text-right" style="width: 10%">
                            <span class="fs-7"></span>
                        </td>
                        <td class="text-right" style="width: 20%">
                            <span class="fs-10">Valores em reais</span>
                        </td>
                    </tr>
                </table>
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">1. Total dos rendimentos tributáveis (inclusive férias e décimo terceiro salário)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_1; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">2. Exclusão: Despesas com a ação judicial</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_2; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">3. Dedução: Contribuição previdenciária oficial</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_3; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">4. Dedução: Pensão alimentícia (preencher também o quadro 7)</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_4; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">5. Imposto sobre a renda retido na fonte</span>
                        </td>
                        <td class="br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_5; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table bt-table br-table" style="width: 80%;">
                            <span class="fs-7">6. Revendimentos isentos de pensão, proventos de aposentadoria ou reforma por moléstia grave ou aposentadoria ou reforma por acidente em serviço</span>
                        </td>
                        <td class="bb-table br-table bt-table text-right" style="width: 20%">
                            <span class="fs-7"><?php echo $ren_6_6; ?></span>
                        </td>
                    </tr>
                </table>
                <!-- 7 -->
                <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10">7. Informações Complementares</td>
                    </tr>
                    <tr>
                        <td style="border:#000 solid 1px; padding: 2px; height: 150px"><span class="fs-7"><?php echo $infcom; ?></span></td>
                    </tr>
                </table>
                <!-- 7 -->
                <table class="width-100" style="border-spacing: 0px; margin-top: 6px;">
                    <tr>
                        <td class="fs-10">8. Responsável pelas informações</td>
                    </tr>
                    <tr>
                        <td class="bl-table bt-table br-table" style="width: 40%">
                            <span class="fs-7">Nome</span>
                        </td>
                        <td class="br-table bt-table" style="width: 20%">
                            <span class="fs-7">Data</span>
                        </td>
                        <td class="br-table bt-table" style="width: 40%">
                            <span class="fs-7">Assinatura</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bb-table bl-table br-table text-center" style="width: 40%">
                            <span class="fs-7"><?php echo $nome_8_1; ?></span>
                        </td>
                        <td class="bb-table br-table " style="width: 20%">
                            <span class="fs-7"><?php if (!empty($info_imposto["data_8_1"])) {
                                                    echo $data_8_1->format("d/m/Y");
                                                } else {
                                                };  ?></span>
                        </td>
                        <td class="bb-table br-table " style="width: 40%">
                            <span class="fs-7"></span>
                        </td>
                    </tr>
                </table>
                <!-- <table class="width-100 mt-10px" style="border-spacing: 0px;">
                    <tr>
                        <td class="fs-10"><hr></td>
                    </tr>
                </table> -->


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