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
    <title>Gestou - APP</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once "menu_lateral.php";

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

                        $_SESSION["id_irr_imposto"] = $_REQUEST["vw"];
                        $id_irr = $_SESSION["id_irr_imposto"];

                        update_GESIRR_situac_visualizar($raiz_cnpj, $id_irr);

                ?>

                        <!-- MENU SUPERIOR -->
                        <?php

                        include_once "menu_superior.php";

                        ?>
                        <!-- FIM MENU SUPERIOR -->

                        <!-- DIV CONTAINER FLUID-->
                        <div class="container-fluid" id="container-wrapper">

                            <!-- DIV ICONE VOLTAR -->
                            <div class="iconedireita mb-1 user-select-none">

                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item h4"><a href="imposto_renda"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                                    <li class="breadcrumb-item active h4" aria-current="page">Itens Imposto de Renda</li>
                                </ol>

                            </div>
                            <!-- FIM DIV ICONE VOLTAR -->

                            <?php

                            // Verifica se existe o arquivo no banco
                            foreach (selectGESIRR_arquivo($raiz_cnpj, $id_irr) as $return_banco) {

                                $arquivo_banco = $return_banco["arquivo"];
                                $competencia_banco = $return_banco["anoexe"];
                            }

                            if (!empty($arquivo_banco)) {

                            ?>

                                <!-- DIV ROW -->
                                <div class="row mb-1">

                                    <div class="card shadow mb-2 width-100">
                                        <!-- HEADER TOTAL PROVENTOS -->
                                        <div class="d-block card-header py-3 collapsed">

                                            <a href="../upload/beneficios/irrf/<?php echo $raiz_cnpj; ?>/<?php echo $arquivo_banco; ?>" download="">
                                                <button class="btn btn-compartilhar width-100 mb-3">
                                                    <span class="icon mr-1">
                                                        <i class="fas fa-download"></i>
                                                    </span>
                                                    <span class="text font-weight-bold">DOWNLOAD</span>
                                                </button>
                                            </a>

                                            <button id="compartilhar_arquivo" class="btn btn-compartilhar width-100 mb-3" nome="Informe de Rendimentos <?php echo $competencia_banco; ?>" origem="../upload/beneficios/irrf/<?php echo $raiz_cnpj; ?>/<?php echo $arquivo_banco; ?>" onClick="compartilharArquivo(); onClickShare()">
                                                <span class="icon mr-1">
                                                    <i class="fas fa-share-alt"></i>
                                                </span>
                                                <span class="text font-weight-bold">COMPARTILHAR</span>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            <?php

                            } else {

                            ?>

                                <!-- DIV ROW -->
                                <div class="row mb-1">

                                    <?php

                                    foreach (select_GESIRR_item($raiz_cnpj, $id_emp_default, $id_irr) as $imposto_renda) {

                                        $id_irr = $imposto_renda['id_irr'];
                                        $situac = $imposto_renda['situac'];
                                        $anocal = $imposto_renda['anocal'];
                                        $anoexe = $imposto_renda['anoexe'];

                                    ?>

                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Exercício</h6><br>
                                                <h5 class="m-0 font-weight-bold text-primary">
                                                    <?php echo $anoexe; ?>
                                                </h5>

                                                <hr style="margin-top: 1rem;margin-bottom: 1rem;">

                                                <h6 class="m-0 font-weight-bold text-gray-800">Ano Calendário</h6><br>
                                                <h5 class="m-0 font-weight-bold text-primary">
                                                    <?php echo $anocal; ?>
                                                </h5>
                                            </div>
                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>
                                <!-- FIM DIV ROW -->

                                <div class="row">

                                    <div class="card shadow mb-2 width-100">
                                        <!-- HEADER TOTAL PROVENTOS -->
                                        <div class="d-block card-header py-3 collapsed">
                                            <a href="imposto_impressao_baixar.php" download="">
                                                <button class="btn btn-compartilhar width-100 mb-3" onclick="onClickDownload()">
                                                    <span class="icon mr-1">
                                                        <i class="fas fa-download"></i>
                                                    </span>
                                                    <span class="text font-weight-bold">DOWNLOAD</span>
                                                </button></a>

                                            <button class="btn btn-compartilhar width-100 mb-3" onClick="share(); onClickShare()">
                                                <span class="icon mr-1">
                                                    <i class="fas fa-share-alt"></i>
                                                </span>
                                                <span class="text font-weight-bold">COMPARTILHAR</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            <?php

                            }

                            ?>

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

            include_once "footer.php";

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

    <script>
        // async function share() {

        //     // if (confirm("holerite")) {

        //     // if (navigator.share !== undefined) {
        //     // 	navigator.share({
        //     // 		title: 'O título da sua página',
        //     // 		text: 'Um texto de resumo',
        //     // 		url: 'http://lfpservicos.com.br/',
        //     // 	})
        //     // 	.then(() => console.log('Successful share'))
        //     // 	.catch((error) => console.log('Error sharing', error));
        //     // }

        //     const response = await fetch('recibo_impressao_baixar.php');
        //     const blob = await response.blob();
        //     const filesArray = [
        //         new File(
        //             [blob],
        //             'holerite.pdf', {
        //                 type: "application/pdf"
        //             }
        //         )
        //     ];
        //     const shareData = {
        //         files: filesArray,
        //     };
        //     navigator.share(shareData);
        //     // } else {

        //     //     return false;

        //     // }
        // }

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
                    'Imposto de Renda.pdf', {
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

<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>