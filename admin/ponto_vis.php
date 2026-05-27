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

    <title>GESTOU PORTAL - Espelho de Ponto</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="vendor/kartik-v/bootstrap-fileinput/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/locales/LANG.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                            <h6 class="m-0 font-weight-bold text-primary">Espelho de Ponto</h6>
                        </div>
                        <div class="card-body">

                            <?php

                            foreach (selectGESEMP_layouts($id_emp_default) as $layout_banco) {

                                $layout_ponto = $layout_banco["layout_ponto"];
                            }
                            ?>

                            <div class="col-md-12">

                                <!-- <form action="direcionador" method="POST" enctype="multipart/form-data"> -->

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <!-- <label for="descricao" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Salário, Adiantamento, 1º parcela do 13º Salário.">Descrição
                                            <i class="fas fa-info-circle"></i></label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Insira uma descrição..." required></input>  -->
                                        <div class="row mt-sm-2">
                                            <label for="input-b1">Arquivo</label>
                                            <input id="input-b1" name="input-b1" type="file" class="file" layout="<?php echo $layout_ponto; ?>" data-browse-on-zone-click="true" accept=".pdf,.txt" required>
                                            <!-- <sup class="textalign-right mt-sm-4">Proporção 4:3 (800 x 600px)</sup> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="button" id="btn-submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-upload"></i> Enviar</button>
                                        <a href="importacao"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar importação" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>
                                        <!-- </form> -->



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
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#btn-submit").click(function() {
            var fd = new FormData();
            var files = $('#input-b1')[0].files[0];
            var descricao = $('#descricao').val();
            var layout = $('#input-b1').attr("layout");
            fd.append('file', files);
            fd.append('descricao', descricao);

            Swal.fire({
                icon: 'info',
                title: 'Info',
                title: 'Aguarde!',
                text: 'O arquivo está sendo importado...',
                buttons: false,
                closeOnClickOutside: false,
                allowOutsideClick: false,
                timer: 100000,
                onOpen: () => {
                    swal.showLoading();
                }
                //icon: "success"
            });


            $.ajax({
                url: 'vision_computer.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response != 0) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            title: 'Sucesso!',
                            text: 'O arquivo foi importado!',
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "layout/" + layout;
                            }
                        });

                        // location.href = "layout/euro_40183722.php";

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            title: 'Erro!',
                            text: 'O arquivo não foi importado!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                },
            });
        });
    });
</script>