<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<?php

if (!empty($_SESSION['text_ocr'])) {
    unset($_SESSION['text_ocr']);
}

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

    <title>GESTOU PORTAL - Holerite</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Require Tesseract OCR -->
    <link href='vendor_ocr/css/offcanvas.css' rel='stylesheet' type='text/css' />
    <link href='vendor_ocr/css/main.css' rel='stylesheet' type='text/css' />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once 'menu_lateral.php';

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once 'barra_superior.php';

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- Card Shadow -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Holerite</h6>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">

                                <?php

                                foreach (selectGESEMP_layouts($id_emp_default) as $layout_banco) {

                                    $layout_holerite = $layout_banco["layout"];
                                }
                                ?>

                                <div id='uploadFileContentCard' class="card-body p-2">
                                    <div class='row'>
                                        <div class='col-md-9 mr-0'>
                                            <label>Arquivo:</label>
                                            <div id='uploadPDFBtn' layout_empresa="<?php echo $layout_holerite; ?>" title="Iniciar importação" class="div-ocr">
                                                <form id="form_id_arquivo" action="layout/<?php echo $layout_holerite; ?>" method="POST" enctype="multipart/form-data">
                                                    <input id='uploadPDF' name="uploadPDF" type='file' accept='.pdf,.PDF' />
                                                    <button type="submit" id="btn-enviar-arquivo" name="btn-enviar-arquivo" class="d-none"></button>
                                                </form>
                                                <div id='page-preview' class='small border text-center'></div>
                                            </div>
                                            <small><strong>Extração de texto da página</strong></small>
                                            <div class="progress">
                                                <div id="ocrPageProgress" class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <span id='pageLoadingSignal'>
                                                        <!-- <span class="spinner-border spinner-border-sm mr-2"></span> -->
                                                        Processando página <span id='currentPageNo'>?</span>&nbsp;/&nbsp;<span id="totalPages">?</span>&nbsp;-&nbsp;
                                                    </span>
                                                    <span id='ocrPageProgressStatus'></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-3 mr-0'>
                                            <div class="row">
                                                <div class='col-md-12'>
                                                    <label>Páginas processadas: </label>
                                                    <small id='processedPages' class='border small width-100'></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='row d-none'>
                                    <div class='col-md-12'>
                                        <div id='controllerCard' class="card rounded-0">
                                            <div class="card-body p-0">
                                                <textarea id='inputText' class="form-control rounded-0 m-0 border-0"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="textalign-right">
                                        <!-- <button id='uploadPDFBtn' type='button' class='btn btn-organograma btn-icon-split-organograma'><i class="fas fa-upload"></i> Enviar <input id='uploadPDF' type='file' accept='.pdf,.PDF' /></button> -->
                                        <!-- <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-upload"></i> Enviar</button> -->
                                        <button type="button" id="btn-voltar" name="btn-voltar" data-toggle="tooltip" title="Voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button>
                                        <button type="button" id="btn-cancelar" name="btn-cancelar" data-toggle="tooltip" title="Cancelar importação" class="btn btn-organograma btn-icon-split-organograma d-none"><i class="fas fa-ban"></i> Cancelar</button>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- End of Footer -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Require Tesseract OCR -->
<script src='vendor_ocr/js/polyfill.js'></script>
<script src='vendor_ocr/js/ie10-viewport-bug-workaround.js'></script>
<!-- <script src='vendor_ocr/js/bootstrap-native-v4.js'></script> -->
<script src='vendor_ocr/js/tesseract/tesseract.min.js'></script>
<script src='vendor_ocr/js/pdf/pdf.min.js'></script>
<script src='vendor_ocr/js/articulate.js'></script>
<script src='vendor_ocr/js/main.js'></script>

<!-- SWEET ALERT -->
<link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
<!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
<script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

<script>
    //BTN VOLTAR
    $(document).ready(function() {

        $(document).on('click', '#btn-voltar', function() {

            window.location.href = "importacao";

        });

    });

    //BTN CANCELAR
    $(document).ready(function() {

        $(document).on('click', '#btn-cancelar', function() {

            Swal.fire({
                title: 'Atenção!',
                text: 'Deseja cancelar a importação?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, cancelar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "recibo_pagamento_ocr";
                }
            });

        });

    });
</script>

<?php

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS 
if ((isset($_POST["text_ocr"])) and (isset($_POST["nome_arquivo_ocr"]))) {

    // VÁRIAVEL PARA LISTAR OS DADOS DA DOCUMENTAÇÃO NA PÁGINA ARTIGO
    $_SESSION["text_ocr"] = $_POST["text_ocr"];
    $_SESSION["nome_arquivo_ocr"] = $_POST["nome_arquivo_ocr"];
}

?>