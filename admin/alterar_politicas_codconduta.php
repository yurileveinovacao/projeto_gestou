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
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Alterar política e código de conduta</title>

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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Políticas e Código de Conduta</h6>
                        </div>
                        <div class="card-body">

                            <?php

                            $id_pol = $_SESSION["politica_editar"];

                            if (!empty($id_pol)) {

                            ?>

                                <div class="col-md-12 mb-5">
                                    <div class="mb-3">

                                        <?php

                                        foreach (selectGESPOL($id_pol) as $linha) {

                                            if (!empty($linha)) {

                                        ?>

                                                <label for="titulo-update" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Título referente a Política ou Cód. Conduta.">Título <i class="fas fa-info-circle"></i></label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="titulo-update" value="<?php echo $linha["nome"] ?>" name="titulo-update" minlength="2" required></input>

                                                <label for="input-b1">Anexar</label>
                                                <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF">

                                        <?php

                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="textalign-right">
                                        <button type="button" id="btn-update" class="btn btn-organograma btn-icon-split-organograma" politica="<?php echo $id_pol; ?>"><i class="fas fa-save mr-sm-2"></i> Atualizar</button>
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>
                                </div>

                            <?php

                            } else {

                                echo "<script>
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Info',
                                    title: 'Atenção!',
                                    text: 'Não é possivel editar a política!',
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = 'politicas_codconduta';
                                    }
                                });
                                </script>";
                            }

                            ?>

                        </div>
                    </div>

                </div>

            </div>

            <!-- End of Main Content -->

            <?php

            include_once 'footer.php';

            ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

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
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $(document).ready(function() {
        $("#btn-update").click(function() {
            var btn_update = 1;
            var politica_update = $(this).attr("politica");
            var fd = new FormData();
            var files = $('#input-b1')[0].files[0];
            var titulo_update = $('#titulo-update').val();
            fd.append('btn_update', btn_update);
            fd.append('file', files);
            fd.append('titulo_update', titulo_update);
            fd.append('politica_update', politica_update);

            // alert(btn_update);
            // alert(politica_update);
            // alert(files);
            // alert(titulo_update);

            if ((btn_update !== '') && (politica_update !== '')) {

                $.post({
                    url: 'controller/politicas_codconduta_post.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response == 2) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                title: 'Sucesso!',
                                text: 'Informação atualizada com sucesso!',
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.reload();
                                    location.href = "politicas_codconduta";
                                }
                            });

                        }
                        if (response == 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                title: 'Atenção!',
                                text: 'Preencha os campos para salvar!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.reload();
                                }
                            });
                        }
                    },
                });

            }

        });

    });

    $(document).ready(function() {
        $('#btn-voltar').click(function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {
                var dados = {
                    btn_voltar: btn_voltar
                };
                $.post('controller/politicas_codconduta_post.php', dados, function(retorna) {

                    location.href = "politicas_codconduta";

                });
            }

        })
    });
</script>