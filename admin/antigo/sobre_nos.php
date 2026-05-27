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

    <title>GESTOU PORTAL - Sobre nós</title>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputimg.min.js"></script>

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
                            <h6 class="m-0 font-weight-bold text-primary">Sobre nós</h6>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">
                                <!-- <form class="" action="empresa.php" method="POST" enctype="multipart/form-data"> -->
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <label for="input-b1">Imagem</label>
                                            <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".png,.jpg,.jpeg">
                                            <sup class="textalign-right mt-sm-4">Proporção 4:3 (800 x 600px)</sup>
                                        </div>
                                        <label for="inputTextarea" class="mt-sm-3">Texto Opcional</label>
                                        <textarea class="form-control" id="inputTextarea" name="inputTextarea" style="height: 150px; resize: none" placeholder="Texto sobre a Empresa..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="button" id="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>

                                        <?php

                                        foreach (selectGESSOB($id_emp_default) as $resultados_modal) {

                                            $texto_banco_modal = $resultados_modal['sob_texto'];
                                            $caminho_banco_modal = $resultados_modal['sob_imagem'];
                                        }


                                        if (($texto_banco_modal == NULL) and ($caminho_banco_modal == NULL)) {

                                        ?>

                                            <button disabled type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button>

                                        <?php

                                        } else {

                                        ?>

                                            <button type="button" class="btn btn-organograma btn-icon-split-organograma visualizar_modal"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button>

                                        <?php

                                        }

                                        ?>

                                    </div>
                                </div>
                                <!-- </form> -->
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div id="Vizualizar" class="modal fade" tabindex="-1" aria-labelledby="Visualizar" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Visualizar">Sobre nós</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="visuTela" class="col-md-12">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<!-- SWEET ALERT -->
<link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
<!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
<script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $("#btn-submit").click(function() {
            var btn_submit = 1;
            var fd = new FormData();
            var files = $('#input-b1')[0].files[0];
            var texto = $('#inputTextarea').val();
            fd.append('btn_submit', btn_submit);
            fd.append('file', files);
            fd.append('texto', texto);

            if (btn_submit !== '') {

                $.post({
                    url: 'controller/sobre_nos_post.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response == 1) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                title: 'Sucesso!',
                                text: 'Informação cadastrada com sucesso!',
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // window.location.reload();
                                    location.href = "sobre_nos";
                                }
                            });

                            // location.href = "layout/euro_40183722.php";

                        }
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
                                    location.href = "sobre_nos";
                                }
                            });

                            // location.href = "layout/euro_40183722.php";

                        }
                        if (response == 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                title: 'Atenção!',
                                text: 'Preencha ao menos um campo para salvar!'
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

        $(document).on('click', '#btn-excluir', function() {

            $('#Vizualizar').modal('hide');

            var btn_excluir = 1;

            //verificar se há calor nas variaveis
            if (btn_excluir !== '') {
                var dados = {
                    btn_excluir: btn_excluir
                };
                $.post('controller/sobre_nos_post.php', dados, function(retorna) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        title: 'Sucesso!',
                        text: 'Informação excluida com sucesso!',
                        closeOnClickOutside: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // window.location.reload();
                            location.href = "sobre_nos";
                        }
                    });

                });

            }

        });

    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.visualizar_modal', function() {
            var abrir_modal = 1;

            if (abrir_modal !== '') {
                var dados = {
                    abrir_modal: abrir_modal
                };
                $.post('controller/sobre_nos_post.php', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuTela").html(retorna);
                    $('#Vizualizar').modal('show');

                    // $(document).on('hidden.bs.modal', '#visuModal', function() {

                    //     window.location.reload();

                    // });

                });
            }
        });
    });
</script>