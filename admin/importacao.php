<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Importação</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- INICIO PAGE WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once 'barra_superior.php'; ?>

                <!-- SELECT DOS LAYOUTS DA EMPRESA -->
                <?php

                foreach (selectGESUSU_ativos($id_emp_default) as $usuarios_ativos) {

                    $count_ativos = $usuarios_ativos["conta"];
                }

                foreach (selectGESEMP_layouts($id_emp_default) as $layout_banco) {

                    $layout_holerite = $layout_banco["layout"];
                    $layout_ponto = $layout_banco["layout_ponto"];
                    $layout_irrf = $layout_banco["layout_irrf"];
                    $gvc = $layout_banco["gvc"];
                    $fpd = $layout_banco["fpd"];
                    $lay_h = $layout_banco["lay_h"];
                    $lay_p = $layout_banco["lay_p"];
                    $lay_i = $layout_banco["lay_i"];
                }

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-xl-6 col-md-6 mb-4">

                            <?php

                            if (empty($layout_holerite)) {

                            ?>

                                <a class="text-decoration-none" style="cursor: pointer;" onclick="sem_acesso();">

                                    <?php

                                } else {

                                    if ($gvc == "SIM") {

                                    ?>

                                        <a class="text-decoration-none" href="recibo_pagamento_gvc">

                                        <?php

                                    } elseif ($fpd == "SIM") {

                                        ?>

                                            <a class="text-decoration-none" href="recibo_pagamento_fpd">

                                                <?php

                                            } else {

                                                switch ($lay_h) {

                                                    case "PAR":

                                                ?>

                                                        <a class="text-decoration-none" href="recibo_pagamento">

                                                        <?php

                                                        break;

                                                    case "OCR":

                                                        ?>

                                                            <a class="text-decoration-none" href="recibo_pagamento_ocr">

                                                            <?php

                                                            break;

                                                        case "VIS":

                                                            ?>

                                                                <a class="text-decoration-none" href="recibo_pagamento_vis">

                                                    <?php

                                                            break;
                                                    }
                                                }
                                            }

                                                    ?>
                                                    <div class="card border-left-primary shadow h-100 padd-3">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center p-5">
                                                                <div class="col mr-2">
                                                                    <!-- <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Earnings (Monthly)</div> -->
                                                                    <div class="h4 mb-0 font-weight-bold text-gray-800">HOLERITE</div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-invoice-dollar fa-3x text-success"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                </a>
                        </div>

                        <div class="col-xl-6 col-md-6 mb-4">
                            <?php
                            if (empty($layout_ponto)) {
                            ?>
                                <a class="text-decoration-none" style="cursor: pointer;" onclick="sem_acesso();">
                                    <?php
                                } else {
                                    switch ($lay_p) {
                                        case "PAR":
                                    ?>
                                            <a class="text-decoration-none" href="ponto">
                                            <?php
                                            break;
                                        case "OCR":
                                            ?>
                                                <a class="text-decoration-none" href="ponto_ocr">
                                                <?php
                                                break;
                                            case "VIS":
                                                ?>
                                                    <a class="text-decoration-none" href="ponto">
                                            <?php
                                                break;
                                        }
                                    }
                                            ?>

                                            <div class="card border-left-primary shadow h-100 padd-3">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center p-5">
                                                        <div class="col mr-2">
                                                            <!-- <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Earnings (Monthly)</div> -->
                                                            <div class="h4 mb-0 font-weight-bold text-gray-800">ESPELHO DE PONTO</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-user-clock fa-3x text-success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    </a>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-xl-6 col-md-6 mb-4">
                            <?php
                            if (empty($layout_irrf)) {
                            ?>
                                <a class="text-decoration-none" style="cursor: pointer;" onclick="sem_acesso();">

                                    <?php

                                } else {
                                    switch ($lay_i) {
                                        case "PAR":
                                    ?>
                                            <a class="text-decoration-none" href="irrf">
                                            <?php
                                            break;
                                        case "OCR":
                                            ?>
                                                <a class="text-decoration-none" href="irrf_ocr">
                                                <?php
                                                break;
                                            case "VIS":
                                                ?>
                                                    <a class="text-decoration-none" href="irrf">
                                            <?php
                                                break;
                                        }
                                    }

                                            ?>

                                            <div class="card border-left-primary shadow h-100 padd-3">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center p-5">
                                                        <div class="col mr-2">
                                                            <!-- <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Earnings (Monthly)</div> -->
                                                            <div class="h4 mb-0 font-weight-bold text-gray-800">INFORME DE RENDIMENTOS</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-file-alt fa-3x text-success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    </a>
                        </div>

                        <div class="col-xl-6 col-md-6 mb-4">
                            <?php if ($count_ativos <= 0) { ?>

                                <a class="text-decoration-none" style="cursor: pointer;" onclick="sem_colaboradores_ativos();">

                                <?php } else {

                                ?>

                                    <a class="text-decoration-none" href="documentos_diversos">

                                    <?php

                                }

                                    ?>

                                    <div class="card border-left-primary shadow h-100 padd-3">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center p-5">
                                                <div class="col mr-2">
                                                    <!-- <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Earnings (Monthly)</div> -->
                                                    <div class="h4 mb-0 font-weight-bold text-gray-800">DOCUMENTOS DIVERSOS</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-file fa-3x text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- FOOTER -->
        <?php include_once 'footer.php'; ?>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM PAGE WRAPPER -->

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>
<script>
    function sem_acesso() {
        Swal.fire({
            icon: "warning",
            title: "Warning",
            title: 'Atenção!',
            text: 'Não existe layout cadastrado para essa funcionalidade!'
        });
    }

    function sem_colaboradores_ativos() {
        Swal.fire({
            icon: "warning",
            title: "Warning",
            title: 'Atenção!',
            text: 'Não existem colaboradores ativos na empresa!'
        });
    }
</script>