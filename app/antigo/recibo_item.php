<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../../config/database.php';

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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once 'menu_lateral.php';

        ?>
        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <?php

                try {
                    //REQUEST DA PÁGINA ANTERIOR
                    if (isset($_REQUEST['vw'])) {
                        $_SESSION['id_validador_recibo'] = $_REQUEST['vw'];
                        $id_validador = $_SESSION['id_validador_recibo'];

                        update_situac_visualizar($raiz_cnpj, $id_validador); ?>

                        <!-- MENU SUPERIOR -->
                        <?php

                        include_once 'menu_superior.php'; ?>
                        <!-- FIM MENU SUPERIOR -->

                        <!-- DIV CONTAINER FLUID-->
                        <div class="container-fluid" id="container-wrapper">

                            <!-- DIV ICONE VOLTAR -->
                            <div class="iconedireita mb-1 user-select-none">

                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item h4"><a href="recibo_pagamento"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                                    <li class="breadcrumb-item active h4" aria-current="page">Itens Recibo</li>
                                </ol>

                            </div>
                            <!-- FIM DIV ICONE VOLTAR -->

                            <?php

                            $_SESSION['id_validador_holerite'] = $_SESSION['id_validador_recibo'];

                            foreach (select_GESIM1_id_validador($raiz_cnpj, $id_validador, $id_emp_default, $id_usu_default) as $situacao_recibo) {
                                $situac = $situacao_recibo['situac'];
                                $descricao = $situacao_recibo['descricao'];
                                $competencia = $situacao_recibo['competencia'];
                                $motrep = $situacao_recibo['motrep'];
                                $resprep = $situacao_recibo['resprep'];
                            }

                            ?>

                            <?php

                            // Verifica se existe o arquivo no banco
                            foreach (selectGESIM1_arquivo($raiz_cnpj, $id_validador) as $return_banco) {

                                $arquivo_banco = $return_banco["arquivo"];
                                $competencia_banco = $return_banco["competencia"];
                            }

                            if (!empty($arquivo_banco)) {

                            ?>

                                <!-- DIV ROW -->
                                <div class="row mb-1">

                                    <div class="card shadow mb-2 width-100">
                                        <!-- HEADER TOTAL PROVENTOS -->
                                        <div class="d-block card-header py-3 collapsed">

                                            <a href="../upload/beneficios/holerite/<?php echo $raiz_cnpj; ?>/<?php echo $arquivo_banco; ?>" download="">
                                                <button class="btn btn-compartilhar width-100 mb-3">
                                                    <span class="icon mr-1">
                                                        <i class="fas fa-download"></i>
                                                    </span>
                                                    <span class="text font-weight-bold">DOWNLOAD</span>
                                                </button>
                                            </a>

                                            <button id="compartilhar_arquivo" class="btn btn-compartilhar width-100 mb-3" nome="Holerite <?php echo $competencia_banco; ?>" origem="../upload/beneficios/holerite/<?php echo $raiz_cnpj; ?>/<?php echo $arquivo_banco; ?>" onClick="compartilharArquivo(); onClickShare()">
                                                <span class="icon mr-1">
                                                    <i class="fas fa-share-alt"></i>
                                                </span>
                                                <span class="text font-weight-bold">COMPARTILHAR</span>
                                            </button>

                                            <?php

                                            foreach (selectMENSAGENS_HOLERITE($raiz_cnpj, $id_validador) as $mensagens_banco) {

                                                $imagem_usu = $mensagens_banco["imagem"];
                                                $logo_empresa = $mensagens_banco["logo"];
                                            }

                                            ?>

                                            <div class="row">
                                                <div class="col-md-12 p-0 mb-3">

                                                    <?php

                                                    $retorno = '';

                                                    if ($motrep) {

                                                        $retorno .= '<div class="row mb-2">';


                                                        $retorno .= '<div class="col-md-12">';

                                                        $retorno .= '<div>';
                                                        $retorno .= '<div class="w-100 d-flex"><img src="../upload/cadastro/' . $imagem_usu . '" class="img-responsive img-thumbnail content-xy-center imagem-usuario-msg"></img></div>';
                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';


                                                        $retorno .= '</div>';

                                                        $retorno .= '<div class="row mb-2">';

                                                        $retorno .= '<div class="col-md-5 mr-auto d-flex">';

                                                        $retorno .= '<div class="content-xy-center">';
                                                        $retorno .= '<div class="w-100 balao-secondary">' . $motrep . '</div>';
                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';
                                                    }

                                                    if ($resprep) {

                                                        $retorno .= '<div class="row mb-2">';

                                                        $retorno .= '<div class="col-md-12">';

                                                        $retorno .= '<div>';
                                                        $retorno .= '<div class="w-100 d-flex"><img src="../upload/empresa/' . $logo_empresa . '" class="img-responsive img-thumbnail content-xy-center imagem-empresa-msg"></img></div>';
                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';



                                                        $retorno .= '</div>';

                                                        $retorno .= '<div class="row mb-2">';

                                                        $retorno .= '<div class="col-md-5 ml-auto d-flex">';

                                                        $retorno .= '<div class="content-xy-center ml-auto">';
                                                        $retorno .= '<div class="w-100 balao-success">' . $resprep . '</div>';
                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';

                                                        $retorno .= '</div>';
                                                    }

                                                    //retorno da função
                                                    echo $retorno;

                                                    ?>

                                                </div>
                                            </div>

                                            <?php

                                            if ($situac == 2) {

                                            ?>

                                                <form action="recibo_item" method="POST">
                                                    <button type="submit" name="btn-aprovar" onclick="return confirm('Tem certeza que deseja aprovar esse recibo?'); return false;" class="btn btn-aprovar width-100">
                                                        <span class="icon mr-1">
                                                            <i class="fas fa-check-circle"></i>
                                                        </span>
                                                        <span class="text font-weight-bold">APROVAR</span>
                                                    </button>
                                                </form>

                                            <?php

                                            }

                                            ?>

                                        </div>
                                    </div>

                                </div>

                                <?php

                                if (($situac == 2) and (empty($motrep)) and (empty($resprep))) {

                                ?>

                                    <div class="row">

                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3">

                                                <h6 class="m-0 text-gray-800 text-center">Não concordando com os valores apresentados, clique em reprovar e envie sua justificativa.</h6>

                                                </a>
                                                <!-- CARD TOTAL PROVENTOS -->
                                                <div class="collapse show" id="reprovar">
                                                    <div class="card-body">

                                                        <div class="row">

                                                            <h6 class="m-0 text-gray-800 width-100">Justificativa:</h6>

                                                            <form class="width-100" action="recibo_item" method="POST">

                                                                <textarea id="motrep" name="motrep" class="form-control mb-3" style="max-height: 150px; height: 150px; resize: none;" minlength="10" maxlength="200" required></textarea>

                                                                <button type="submit" id="btn-reprovar" name="btn-reprovar" disabled onclick="return confirm('Tem certeza que deseja reprovar esse recibo?'); return false;" class="btn btn-reprovar width-100">
                                                                    <span class="icon mr-1">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">REPROVAR</span>
                                                                </button>
                                                                <!-- name="btn-aprovar" onclick="return confirm('Tem certeza que deseja deletar esse recibo?'); return false;" -->
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                <?php

                                }

                                ?>

                                <?php

                                if ($situac != 2) {

                                ?>
                                    <div class="row text-center mb-2">

                                        <h6 class="ttext-center" style="margin: auto;">Código de Validação:</h6>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <div class="row text-center mb-2">

                                        <h6 class="font-weight-bold text-gray-800 text-center" style="margin: auto;"><?php echo $id_validador; ?></h6>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <div class="row text-center">

                                        <h6 class="text-center" style="margin: auto;">A autenticidade deste comprovante pode ser confirmada pelo site <a href="https://www.gestou.com.br/validar">https://gestou.com.br/validar</a> ou pelo QR Code abaixo</h6>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <div class="row text-center">

                                        <?php include_once 'gera_qrcode_holerite.php'; ?>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                <?php

                                }

                                ?>

                                <?php

                            } else {


                                foreach (select_PROV($raiz_cnpj, $id_validador) as $valor_prov) {
                                    $proventos = $valor_prov['vlr']; ?>

                                    <!-- DIV ROW -->
                                    <div class="row mb-1">

                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <a href="#totalproventos" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="totalproventos">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Total Proventos</h6><br>
                                                <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus"></i> &nbsp;R$
                                                    <?php echo $proventos; ?></h5>
                                            </a>
                                            <!-- CARD TOTAL PROVENTOS -->
                                            <div class="collapse" id="totalproventos">
                                                <div class="card-body">

                                                    <?php

                                                    foreach (select_EVE_PROV($raiz_cnpj, $id_validador) as $valor_eve_prov) {
                                                        $nome_eve_prov = $valor_eve_prov['nome'];
                                                        $valor_eve_prov = $valor_eve_prov['valor']; ?>

                                                        <div class="row">
                                                            <div class="coluna-card-itens-esquerda">
                                                                <?php echo $nome_eve_prov; ?>
                                                            </div>
                                                            <div class="coluna-card-itens-direita text-align-right">
                                                                R$ <?php echo $valor_eve_prov; ?>
                                                            </div>
                                                        </div>

                                                    <?php

                                                    }

                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                    <?php

                                }

                                    ?>

                                    <?php

                                    foreach (select_DESC($raiz_cnpj, $id_validador) as $valor_desc) {
                                        $descontos = $valor_desc['vlr']; ?>

                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <a href="#totaldescontos" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="totaldescontos">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Total Descontos</h6><br>
                                                <h5 class="m-0 font-weight-bold text-danger"><i class="fas fa-minus"></i> &nbsp;R$
                                                    <?php echo $descontos; ?></h5>
                                            </a>
                                            <!-- CARD TOTAL PROVENTOS -->
                                            <div class="collapse" id="totaldescontos">
                                                <div class="card-body">

                                                    <?php

                                                    foreach (select_EVE_DESC($raiz_cnpj, $id_validador) as $valor_eve_desc) {
                                                        $nome_eve_desc = $valor_eve_desc['nome'];
                                                        $valor_eve_desc = $valor_eve_desc['valor']; ?>

                                                        <div class="row">
                                                            <div class="coluna-card-itens-esquerda">
                                                                <?php echo $nome_eve_desc; ?>
                                                            </div>
                                                            <div class="coluna-card-itens-direita text-align-right">
                                                                R$ <?php echo $valor_eve_desc; ?>
                                                            </div>
                                                        </div>

                                                    <?php

                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    <?php

                                    }

                                    ?>


                                    <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                    <div class="card shadow mb-2 width-100">
                                        <!-- HEADER TOTAL PROVENTOS -->
                                        <div class="d-block card-header py-3 collapsed">
                                            <h6 class="m-0 font-weight-bold text-gray-800">Total Líquido <span class="text-small">(a
                                                    receber)</span></h6><br>
                                            <h5 class="m-0 font-weight-bold text-success"><i class="fas fa-equals"></i> &nbsp;R$
                                                <?php echo $total = $proventos - $descontos; ?></h5>
                                        </div>
                                    </div>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <div class="row">
                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL Mensagens -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <h6 class="m-0 font-weight-bold text-gray-800 mb-2">Questionamento: </h6>
                                                    </div>

                                                    <?php

                                                    foreach (selectMENSAGENS_HOLERITE($raiz_cnpj, $id_validador) as $mensagens_banco) {

                                                        $imagem_usu = $mensagens_banco["imagem"];
                                                        $logo_empresa = $mensagens_banco["logo"];
                                                    }

                                                    ?>

                                                    <div class="row">
                                                        <div class="col-md-12 p-0 mb-3">

                                                            <?php

                                                            $retorno = '';

                                                            if ($motrep) {

                                                                $retorno .= '<div class="row mb-2">';


                                                                $retorno .= '<div class="col-md-12">';

                                                                $retorno .= '<div>';
                                                                $retorno .= '<div class="w-100 d-flex"><img src="../upload/cadastro/' . $imagem_usu . '" class="img-responsive img-thumbnail content-xy-center imagem-usuario-msg"></img></div>';
                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';


                                                                $retorno .= '</div>';

                                                                $retorno .= '<div class="row mb-2">';

                                                                $retorno .= '<div class="col-md-5 mr-auto d-flex">';

                                                                $retorno .= '<div class="content-xy-center">';
                                                                $retorno .= '<div class="w-100 balao-secondary">' . $motrep . '</div>';
                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';
                                                            }

                                                            if ($resprep) {

                                                                $retorno .= '<div class="row mb-2">';

                                                                $retorno .= '<div class="col-md-12">';

                                                                $retorno .= '<div>';
                                                                $retorno .= '<div class="w-100 d-flex"><img src="../upload/empresa/' . $logo_empresa . '" class="img-responsive img-thumbnail content-xy-center imagem-empresa-msg"></img></div>';
                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';



                                                                $retorno .= '</div>';

                                                                $retorno .= '<div class="row mb-2">';

                                                                $retorno .= '<div class="col-md-5 ml-auto d-flex">';

                                                                $retorno .= '<div class="content-xy-center ml-auto">';
                                                                $retorno .= '<div class="w-100 balao-success">' . $resprep . '</div>';
                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';

                                                                $retorno .= '</div>';
                                                            }

                                                            //retorno da função
                                                            echo $retorno;

                                                            ?>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <?php

                                    if ($situac != 4) {

                                    ?>

                                        <div class="row">

                                            <div class="card shadow mb-2 width-100">
                                                <!-- HEADER TOTAL PROVENTOS -->
                                                <div class="d-block card-header py-3 collapsed">

                                                    <?php

                                                    if ($situac == 3) {

                                                    ?>

                                                        <a href="recibo_impressao_baixar.php" download="">
                                                            <button class="btn btn-compartilhar width-100 mb-3">
                                                                <span class="icon mr-1">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">DOWNLOAD</span>
                                                            </button>
                                                        </a>

                                                        <button class="btn btn-compartilhar width-100 mb-3" onClick="share(); onClickShare()">
                                                            <span class="icon mr-1">
                                                                <i class="fas fa-share-alt"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">COMPARTILHAR</span>
                                                        </button>

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <button class="btn btn-compartilhar width-100 mb-3" data-toggle="tooltip" data-placement="bottom" title="Ação Inativa de momento" disabled>
                                                            <span class="icon mr-1">
                                                                <i class="fas fa-download"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">DOWNLOAD</span>
                                                        </button>

                                                        <button class="btn btn-compartilhar width-100 mb-3" onClick="showAndroidToast()" data-toggle="tooltip" data-placement="bottom" title="Ação Inativa de momento" disabled>
                                                            <span class="icon mr-1">
                                                                <i class="fas fa-share-alt"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">COMPARTILHAR</span>
                                                        </button>

                                                    <?php

                                                    }

                                                    ?>

                                                    <?php

                                                    if ($situac == 2) {

                                                    ?>

                                                        <form action="recibo_item" method="POST">
                                                            <button type="submit" name="btn-aprovar" onclick="return confirm('Tem certeza que deseja aprovar esse recibo?'); return false;" class="btn btn-aprovar width-100">
                                                                <span class="icon mr-1">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">APROVAR</span>
                                                            </button>
                                                        </form>

                                                    <?php

                                                    }

                                                    ?>

                                                </div>

                                            </div>

                                        </div>
                                        <!-- FIM DIV ROW -->

                                        <?php

                                        if (($situac == 2) and (empty($motrep)) and (empty($resprep))) {

                                        ?>

                                            <div class="row">

                                                <div class="card shadow mb-2 width-100">
                                                    <!-- HEADER TOTAL PROVENTOS -->
                                                    <div class="d-block card-header py-3">

                                                        <h6 class="m-0 text-gray-800 text-center">Não concordando com os valores apresentados, clique em reprovar e envie sua justificativa.</h6>

                                                        </a>
                                                        <!-- CARD TOTAL PROVENTOS -->
                                                        <div class="collapse show" id="reprovar">
                                                            <div class="card-body">

                                                                <div class="row">

                                                                    <h6 class="m-0 text-gray-800 width-100">Justificativa:</h6>

                                                                    <form class="width-100" action="recibo_item" method="POST">

                                                                        <textarea id="motrep" name="motrep" class="form-control mb-3" style="max-height: 150px; height: 150px; resize: none;" minlength="10" maxlength="200" required></textarea>

                                                                        <button type="submit" id="btn-reprovar" name="btn-reprovar" disabled onclick="return confirm('Tem certeza que deseja reprovar esse recibo?'); return false;" class="btn btn-reprovar width-100">
                                                                            <span class="icon mr-1">
                                                                                <i class="fas fa-times-circle"></i>
                                                                            </span>
                                                                            <span class="text font-weight-bold">REPROVAR</span>
                                                                        </button>
                                                                        <!-- name="btn-aprovar" onclick="return confirm('Tem certeza que deseja deletar esse recibo?'); return false;" -->
                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- FIM DIV ROW -->

                                        <?php

                                        }

                                        ?>

                                        <?php

                                        if ($situac != 2) {

                                        ?>
                                            <div class="row text-center mb-2">

                                                <h6 class="ttext-center" style="margin: auto;">Código de Validação:</h6>

                                            </div>
                                            <!-- FIM DIV ROW -->

                                            <div class="row text-center mb-2">

                                                <h6 class="font-weight-bold text-gray-800 text-center" style="margin: auto;"><?php echo $id_validador; ?></h6>

                                            </div>
                                            <!-- FIM DIV ROW -->

                                            <div class="row text-center">

                                                <h6 class="text-center" style="margin: auto;">A autenticidade deste comprovante pode ser confirmada pelo site <a href="https://www.gestou.com.br/validar">https://gestou.com.br/validar</a> ou pelo QR Code abaixo</h6>

                                            </div>
                                            <!-- FIM DIV ROW -->

                                            <div class="row text-center">

                                                <?php include_once 'gera_qrcode_holerite.php'; ?>

                                            </div>
                                            <!-- FIM DIV ROW -->

                                        <?php

                                        }

                                        ?>

                                <?php

                                    }
                                }

                                ?>

                                <!-- 
                                <a href="javascript:void(0)" onclick="ok.performClick();">
                                <img width="25" height="25" src="https://ayltoninacio.com.br/img/s/21w50.jpg" alt="">
                            </a>

                            <input type="button" value="Say hello" onClick="showAndroidToast()" /> -->


                        </div>
                        <!-- FIM DIV CONTAINER FLUID -->

                <?php
                    }
                } catch (PDOException $erro) {
                    echo $erro->getMessage();
                }

                ?>

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- FIM FOOTER -->

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>
    <!-- FIM DIV WRAPPER -->

    <!-- <script type="text/javascript">
        function onClickDownload() {
            Android.onClickDownload();
        }
    </script> -->
    <script>
        async function share() {

            // if (confirm("holerite")) {

            // if (navigator.share !== undefined) {
            // 	navigator.share({
            // 		title: 'O título da sua página',
            // 		text: 'Um texto de resumo',
            // 		url: 'http://lfpservicos.com.br/',
            // 	})
            // 	.then(() => console.log('Successful share'))
            // 	.catch((error) => console.log('Error sharing', error));
            // }

            const response = await fetch('recibo_impressao_baixar.php');
            const blob = await response.blob();
            const filesArray = [
                new File(
                    [blob],
                    'holerite.pdf', {
                        type: "application/pdf"
                    }
                )
            ];
            const shareData = {
                files: filesArray,
            };
            navigator.share(shareData);
            // } else {

            //     return false;

            // }
        }

        async function compartilharArquivo() {

            // if (confirm("holerite")) {

            // if (navigator.share !== undefined) {
            // 	navigator.share({
            // 		title: 'O título da sua página',
            // 		text: 'Um texto de resumo',
            // 		url: 'http://lfpservicos.com.br/',
            // 	})
            // 	.then(() => console.log('Successful share'))
            // 	.catch((error) => console.log('Error sharing', error));
            // }

            var origem = $("#compartilhar_arquivo").attr("origem");
            var nome = $("#compartilhar_arquivo").attr("nome");

            const response = await fetch(origem);
            const blob = await response.blob();
            const filesArray = [
                new File(
                    [blob],
                    'holerite.pdf', {
                        type: "application/pdf"
                    }
                )
            ];
            const shareData = {
                files: filesArray,
                title: nome,
                text: nome
            };
            navigator.share(shareData);
            // } else {

            //     return false;

            // }
        }
    </script>

    <script type="text/javascript">
        function onClickShare() {
            Android.onClickShare();
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>

<!-- HABILITAR BOTÃO REPROVAR APOS DIGITAR 10 CARACTERES -->
<script>
    $(document).ready(function() {
        $('#motrep').on('input', function() {
            $('#btn-reprovar').prop('disabled', $(this).val().length < 10);
        });
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<?php

//APROVAR RECIBO
try {
    // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['btn-aprovar'])) {
        $status = 3;
        $id_validador = $_SESSION['id_validador_recibo'];

        // echo var_dump($status) . "status:" . $status . "<br>";
        // echo var_dump($id_validador) . "id_validador:" . $id_validador . "<br>";

        updateGESIM1_aprovar($raiz_cnpj, $status, $id_validador, $id_usu_default, $ip, $datatu);

        echo "<script language=javascript>
			alert('Recibo de pagamento aprovado!');
			location.href = 'recibo_item?vw=" . $_SESSION['id_validador_recibo'] . "';
			</script>";
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

//REPROVAR RECIBO
try {
    // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['btn-reprovar'])) {
        $motrep = $_POST['motrep'];
        $status = 4;
        $id_validador = $_SESSION['id_validador_recibo'];

        // echo var_dump($status) . "status:" . $status . "<br>";
        // echo var_dump($motrep) . "motrep:" . $motrep . "<br>";
        // echo var_dump($id_validador) . "id_validador:" . $id_validador . "<br>";

        updateGESIM1_reprovar($raiz_cnpj, $status, $motrep, $id_validador, $id_usu_default, $ip, $datatu);

        echo "<script language=javascript>
			alert('Recibo de pagamento reprovado!');
			location.href = 'recibo_pagamento';
			</script>";

        unset($_SESSION['id_validador_recibo']);
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

?>