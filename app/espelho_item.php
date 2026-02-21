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

                        $_SESSION["id_pon1_espelho"] = $_REQUEST["vw"];
                        $id_pon1 = $_SESSION["id_pon1_espelho"];

                        update_GESPON1_situac_visualizar($raiz_cnpj, $id_pon1);

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
                                    <li class="breadcrumb-item h4"><a href="espelho_ponto"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                                    <li class="breadcrumb-item active h4" aria-current="page">Itens Espelho Ponto</li>
                                </ol>

                            </div>
                            <!-- FIM DIV ICONE VOLTAR -->

                            <?php

                            foreach (select_GESPON1_item($raiz_cnpj, $id_emp_default, $id_pon1) as $espelho_ponto) {

                                $periodo = $espelho_ponto['periodo'];
                                $btotal = $espelho_ponto['btotal'];
                                $bsaldo = $espelho_ponto['bsaldo'];
                                $arquivo = $espelho_ponto['arquivo'];
                                $tipo_valor_total = substr($btotal, 0, 1);
                                $tipo_valor_saldo = substr($bsaldo, 0, 1);

                            ?>

                                <?php

                                if ((empty($btotal)) or (empty($bsaldo))) {

                                ?>

                                    <div class="row">

                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <a href="../upload/beneficios/ponto/<?php echo $raiz_cnpj . "/" . $arquivo; ?>" download="Espelho Ponto <?php echo $nome_usuario_default . " " . $periodo; ?>">
                                                    <button class="btn btn-compartilhar width-100 mb-3" onclick="onClickDownload()">
                                                        <span class="icon mr-1">
                                                            <i class="fas fa-download"></i>
                                                        </span>
                                                        <span class="text font-weight-bold">DOWNLOAD</span>
                                                    </button></a>

                                                <button class="btn btn-compartilhar width-100 mb-3" id="compartilhar" arquivo="../upload/beneficios/ponto/<?php echo $raiz_cnpj . "/" . $arquivo; ?>" nome="Espelho Ponto <?php echo $nome_usuario_default . " " . $periodo; ?>" onClick="share(); onClickShare()">
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

                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Total Mês</h6><br>
                                                <?php if ($tipo_valor_total != "-") { ?><h5 class="m-0 font-weight-bold text-primary"><?php } ?>
                                                    <?php if ($tipo_valor_total == "-") { ?><h5 class="m-0 font-weight-bold text-danger"><?php } ?>
                                                        <?php echo $btotal; ?></h5>
                                            </div>
                                        </div>

                                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Saldo</h6><br>
                                                <?php if ($tipo_valor_saldo != "-") { ?><h5 class="m-0 font-weight-bold text-primary"><?php } ?>
                                                    <?php if ($tipo_valor_saldo == "-") { ?><h5 class="m-0 font-weight-bold text-danger"><?php } ?>
                                                        <?php echo $bsaldo; ?></h5>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM DIV ROW -->

                                    <div class="row">

                                        <div class="card shadow mb-2 width-100">
                                            <!-- HEADER TOTAL PROVENTOS -->
                                            <div class="d-block card-header py-3 collapsed">
                                                <a href="espelho_impressao_baixar.php" download="">
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

</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>

<script type="text/javascript">
    function onClickDownload() {
        Android.onClickDownload();
    }
</script>
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

        var arquivo = document.getElementById("compartilhar").getAttribute("arquivo");
        var nome = document.getElementById("compartilhar").getAttribute("nome");

        const response = await fetch(arquivo);
        const blob = await response.blob();
        const filesArray = [
            new File(
                [blob],
                arquivo, {
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