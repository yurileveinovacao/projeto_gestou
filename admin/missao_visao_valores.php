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

    <title>GESTOU PORTAL - Missão, Visão e Valores</title>

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
    <link href="vendor/kartik-v/bootstrap-fileinput/css/missao_fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" /> -->

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
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- Custom tinnyMCE-->
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        tinyMCE.init({
            selector: "#text_update",
            height: 350,
            menubar: false,
            language_url: 'tinymce/langs/pt_BR.js',
            plugins: 'autolink link image emoticons charmap insertdatetime wordcount',
            toolbar1: 'insertfile undo redo | numlist bullist hr bold italic underline forecolor | outdent indent',
            // toolbar2: 'fullscreen code preview print searchreplace wordcount | ltr rtl visualchars | formatselect | blockquote quicklink | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            insertdatetime_formats: ['%d/%m/%Y', '%Y-%m-%d', '%d-%m-%Y', '%D', '%I:%M:%S %p', '%H:%M:%S', '%d/%m/%Y - %H:%M:%S']
        });
    </script>

</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <!-- CARD HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Missão, Visão e Valores</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <?php foreach (selectGESSOB($id_emp_default) as $resultados_modal) {
                            $texto_missao_modal = $resultados_modal['mis_texto'];
                            $caminho_missao_modal = $resultados_modal['mis_imagem'];
                            $texto_visao_modal = $resultados_modal['vis_texto'];
                            $caminho_visao_modal = $resultados_modal['vis_imagem'];
                            $texto_valores_modal = $resultados_modal['val_texto'];
                            $caminho_valores_modal = $resultados_modal['val_imagem'];
                            $datatu = $resultados_modal['datatu'];
                        }

                        ?>

                        <!-- INICIO COL-MD-12 -->
                        <div class="col-md-12">

                            <!-- INICIO TAB CONTENT -->
                            <div class="tab-content" id="nav-tabContent">

                                <div class="card-deck" style="height: 70vh;">

                                    <!-- Missão -->
                                    <div class="card" style="overflow: hidden; position: relative; max-height: 70vh;">
                                        <div style="height: 50%; padding: 16px 16px 16px 16px; display: flex; justify-content: center; align-items: center;">
                                            <?php if (!empty($caminho_missao_modal)) { ?>

                                                <img class="card-img-top abrir-img" src="../upload/empresa/<?php echo $caminho_missao_modal; ?>" alt="Missão" style="max-height: 100%; max-width: auto; object-fit: contain;">
                                            <?php } else { ?>
                                                <img class="card-img-top" src="../upload/empresa/missao_default.png" alt="Valores" style="max-height: 70%; max-width: auto; object-fit: contain; opacity: 0.2;">
                                            <?php } ?>
                                        </div>

                                        <div class="card-body" style="height: 50%;">
                                            <div style="overflow-y: auto; scrollbar-width: thin; height: 100%;">
                                                <?php echo $texto_missao_modal; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="div-acoes" style="text-align: right">
                                                <button type="button" class="btn btn-primary visualizar-imagem" tipo="img-missao" title="Imagem">
                                                    <i class="fas fa-file-image"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary visualizar-texto" tipo="text-missao" title="Texto">
                                                    <i class="fas fa-font"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Visão -->
                                    <div class="card" style="overflow: hidden; position: relative; max-height: 70vh;">
                                        <div style="height: 50%; padding: 16px 16px 16px 16px; display: flex; justify-content: center; align-items: center;">
                                            <?php if (!empty($caminho_visao_modal)) { ?>
                                                <img class="card-img-top abrir-img" src="../upload/empresa/<?php echo $caminho_visao_modal; ?>" alt="Visão" style="max-height: 100%; max-width: auto; object-fit: contain;">
                                            <?php } else { ?>
                                                <img class="card-img-top" src="../upload/empresa/visao_default.png" alt="Valores" style="max-height: 70%; max-width: auto; object-fit: contain; opacity: 0.3;">
                                            <?php } ?>
                                        </div>
                                        <div class="card-body" style="height: 50%;">
                                            <div style="overflow-y: auto; scrollbar-width: thin; height: 100%;">
                                                <?php echo $texto_visao_modal; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="div-acoes" style="text-align: right">
                                                <button type="button" class="btn btn-primary visualizar-imagem" tipo="img-visao" title="Imagem">
                                                    <i class="fas fa-file-image"></i>
                                                </button>

                                                <button type="button" class="btn btn-primary visualizar-texto" tipo="text-visao" title="Texto">
                                                    <i class="fas fa-font"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Valores -->
                                    <div class="card" style="overflow: hidden; position: relative; max-height: 70vh;">
                                        <div style="height: 50%; padding: 16px 16px 16px 16px; display: flex; justify-content: center; align-items: center;">
                                            <?php if (!empty($caminho_valores_modal)) { ?>
                                                <img class="card-img-top abrir-img" src="../upload/empresa/<?php echo $caminho_valores_modal; ?>" alt="Valores" style="max-height: 100%; max-width: auto; object-fit: contain;">
                                            <?php } else { ?>
                                                <img class="card-img-top" src="../upload/empresa/valores_default.png" alt="Valores" style="max-height: 70%; max-width: auto; object-fit: contain; opacity: 0.3;">
                                            <?php } ?>
                                        </div>
                                        <div class="card-body" style="height: 50%;">
                                            <div style="overflow-y: auto; scrollbar-width: thin; height: 100%;">
                                                <?php echo $texto_valores_modal; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="div-acoes" style="text-align: right">
                                                <div class="div-acoes" style="text-align: right">
                                                    <button type="button" class="btn btn-primary visualizar-imagem" tipo="img-valor" title="Imagem">
                                                        <i class="fas fa-file-image"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-primary visualizar-texto" tipo="text-valor" title="Texto">
                                                        <i class="fas fa-font"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer" style="margin-top: 5px; text-align: right; border-bottom: 1px solid #e3e6f0; border-left: 1px solid #e3e6f0; border-right: 1px solid #e3e6f0;">
                                    <small class="text-muted">Atualizado em <?php $data = new DateTime($datatu);
                                                                            echo $data->format("d/m/Y H:m:s"); ?></small>
                                </div>

                            </div>
                            <!-- FIM TAB CONTENT -->

                        </div>
                        <!-- FIM COL-MD-12 -->

                    </div>
                    <!-- FIM CARD BODY -->

                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->


        <!-- --------------------------------------------------------------------------------------------------- -->
        <!--                                         INICIO MODAIS                                               -->
        <!-- --------------------------------------------------------------------------------------------------- -->


        <!-- MODAL IMAGEM -->
        <div id="modal-imagem" class="modal fade" tabindex="-1" aria-labelledby="modal-imagem" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 100vh;">
                <div class="modal-content" style="overflow-y: auto; width: 100%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title-img"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id='form-img'>
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="textalign-center">
                                <div id="modal-img" style="padding-bottom: 16px;">
                                </div>
                                <div class="row" style="width: auto;">
                                    <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".jpg,.JPG,.jpeg,.JPEG,.png,.PNG">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn-submit-img" class="btn btn-organograma btn-icon-split-organograma">
                                <i class="fas fa-save"></i> Salvar
                            </button>

                            <button type="button" id="btn-exc-img" class="btn btn-organograma btn-icon-split-organograma">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL TEXTO -->
        <div id="modal-texto" class="modal fade" tabindex="-1" aria-labelledby="modal-texto" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 100vh;">
                <div class="modal-content" style="overflow-y: auto; width: 100%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title-texto"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id='form-text'>
                        <div class="modal-body" id="modal-texto-body" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                            <textarea class="form-control" id="text_update" style="height: 150px; resize: none"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn-submit-text" class="btn btn-organograma btn-icon-split-organograma">
                                <i class="fas fa-save"></i> Salvar
                            </button>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL VISUALIZAR IMAGEM -->
        <div id="modal-visualizar-imagem" class="modal fade" tabindex="-1" aria-labelledby="modal-visualizar-imagem" aria-hidden="true" style="background-color: transparent; border: none; box-shadow: none;">
            <div class="modal-dialog modal-dialog-centered" style="display: flex; align-items: center; justify-content: center; max-height: 100vh;">
                <div class="modal-content" style="width: auto; border: none; box-shadow: none;">
                    <div class="modal-body" id="modal-body-visu-img" style="max-height: 100vh; overflow-y: auto; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <!-- Conteúdo da imagem aqui -->
                    </div>
                </div>
            </div>
        </div>


        <!-- --------------------------------------------------------------------------------------------------- -->
        <!--                                          FIM MODAIS                                                 -->
        <!-- --------------------------------------------------------------------------------------------------- -->


        <!-- FOOTER -->
        <?php include_once "footer.php" ?>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

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

</body>

</html>

<!-- AÇÕES NO CLICK -->
<script>
    // VISUALIZAR IMAGEM
    $(function() {
        $(document).on('click', '.abrir-img', function() {

            var visu_img = 1;
            var tipo = $(this).attr('alt');

            if (visu_img !== '') {

                var dados = {
                    tipo: tipo,

                    visu_img: visu_img
                };

                $.post('controller/missao_visao_valores_post.php', dados, function(retorno) {

                    //Carregar o conteudo para o usuário
                    $("#modal-body-visu-img").html(retorno);
                    $('#modal-visualizar-imagem').modal('show');
                });
            }
        });
    });

    // ALTERAR IMAGEM
    $(function() {
        $(document).on('click', '.visualizar-imagem', function() {

            var visualizar_img = 1;
            var tipo = $(this).attr('tipo');

            switch (tipo) {

                case 'img-missao':
                    $('#modal-title-img').text('Missão');
                    break;

                case 'img-visao':
                    $('#modal-title-img').text('Visão');
                    break;

                case 'img-valor':
                    $('#modal-title-img').text('Valores');
                    break;
            }

            $('#btn-submit-img').attr('tipo', tipo);
            $('#btn-exc-img').attr('tipo', tipo);


            if (visualizar_img !== '') {

                var dados = {
                    tipo: tipo,

                    visualizar_img: visualizar_img
                };

                $.post('controller/missao_visao_valores_post.php', dados, function(retorno) {

                    //Carregar o conteudo para o usuário
                    $("#modal-img").html(retorno);
                    $('#modal-imagem').modal('show');


                });
            }
        });
    });

    // ALTERAR TEXTO
    $(function() {
        $(document).on('click', '.visualizar-texto', function() {

            var visu_texto = 1;
            var tipo = $(this).attr('tipo');
            var modal_title = $('#modal-title-texto');

            switch (tipo) {

                case 'text-missao':
                    modal_title.text('Missão');
                    break;

                case 'text-visao':
                    modal_title.text('Visão');
                    break;

                case 'text-valor':
                    modal_title.text('Valores');
                    break;
            }

            $('#btn-submit-text').attr('tipo', tipo);
            $('#btn-exc-text').attr('tipo', tipo);

            if (visu_texto !== '') {

                var dados = {
                    tipo: tipo,

                    visu_texto: visu_texto
                };

                $.post('controller/missao_visao_valores_post.php', dados, function(retorno) {

                    //Carregar o conteudo para o usuário
                    $('#modal-texto').modal('show');

                    // Acesse o editor do TinyMCE
                    var editor = tinymce.get('text_update');

                    // Defina o conteúdo do campo
                    var novoConteudo = retorno;
                    editor.setContent(novoConteudo);

                });
            }
        });
    });

    // SALVAR IMAGEM
    $(function() {
        $('#form-img').submit(function(e) {
            e.preventDefault(); // impede o envio do formulário por padrão

            var btn_submit_img = 1;
            var tipo = $('#btn-submit-img').attr('tipo');

            if (btn_submit_img !== '') {

                // cria um objeto FormData com os valores do formulário
                var formData = new FormData(this);
                formData.append('btn_submit_img', btn_submit_img);
                formData.append('tipo', tipo);

                $.post({
                    url: 'controller/missao_visao_valores_post.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(retorno) {

                        switch (retorno) {

                            // Se o retorno for igual a 0, Imagem não preenchida
                            case '0':
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atenção!',
                                    text: 'Selecione uma imagem para concluir a ação!',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close();
                                    }
                                });
                                break;

                                // Se o retorno for igual a 1, Imagem inserida com sucesso
                            case '1':
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    text: 'Imagem cadastrada com sucesso!',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                break;

                                // Se o retorno for igual a 2, Imagem atualizada com sucesso
                            case '2':
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    text: 'Imagem atualizada com sucesso!',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                break;

                            default:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Favor entrar em contato com o suporte.',
                                    html: retorno,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                break;
                        }
                    }
                });
            }
        });
    });

    // EXCLUIR IMAGEM
    $(function() {
        $(document).on('click', '#btn-exc-img', function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja excluir a imagem?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_exc_img = 1;
                    var tipo = $(this).attr('tipo');

                    if (btn_exc_img !== '') {

                        var dados = {

                            tipo: tipo,
                            btn_exc_img: btn_exc_img
                        };

                        $.post('controller/missao_visao_valores_post.php', dados, function(retorno) {

                            switch (retorno) {

                                // Se o retorno for igual a 1, Imagem de Missão Excluida
                                case '1':
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Imagem da missão excluida com sucesso!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    break;

                                    // Se o retorno for igual a 2, Imagem de Visão Excluida
                                case '2':
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Imagem da visão excluida com sucesso!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    break;

                                    // Se o retorno for igual a 3, Imagem de Valores Excluida
                                case '3':
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Imagem dos valores excluida com sucesso!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    break;

                                    // Erro no Try
                                default:
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Favor entrar em contato com o suporte.',
                                        html: retorno,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    break;
                            }
                        });
                    }
                }
            });
        });
    });

    // SALVAR TEXTO
    $(function() {
        $('#form-text').submit(function(e) {
            e.preventDefault(); // impede o envio do formulário por padrão

            var btn_submit_text = 1;
            var tipo = $('#btn-submit-text').attr('tipo');

            if (btn_submit_text !== '') {

                var dados = {

                    tipo: tipo,
                    texto: $('#text_update').val(),
                    btn_submit_text: btn_submit_text
                };

                $.post('controller/missao_visao_valores_post.php', dados, function(retorno) {

                    switch (retorno) {

                        // Se o retorno for igual a 1, Texto atualizado com sucesso
                        case '1':
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Texto atualizado com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            break;

                            // Se o retorno for igual a 0, Texto tem mais de 5000 caracteres
                        case '0':
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'A quantidade de caracteres do texto é maior que o limite permitido de 5000!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });
                            break;

                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            break;
                    }
                });
            }

        });
    });
</script>