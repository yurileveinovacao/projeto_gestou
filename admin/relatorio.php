<?php

//Faz a requisição da Sessão
require 'restrito.php';

?>

<?php

//abre conexao
require_once 'conexao.php';

//VERIFICA SE HA VALOR NA VARIAVEL E REALIZA UNSET
if (isset($_SESSION["situac_filtro"])) {
    unset($_SESSION["situac_filtro"]);
}

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

    <title>GESTOU PORTAL - Relatórios</title>

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

    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once "menu_lateral.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once "barra_superior.php";

                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Relatórios</h6>
                    </div>
                    <div class="card-body">

                        <div class="col-sm-12 text-right mb-3">
                            <a href="javascript:void(0);" class="linkdirect" onclick="swa_retorno_default();"><button id="btn-processar" type="button" name="btn-processar" data-toggle="tooltip" title="Processar Relatório" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-cog"></i> Processar</button></a>
                        </div>

                        <div class="col-sm-12">
                            <div id="treeview"></div>
                        </div>

                    </div>
                </div>

                <!-- escolhe_situac Modal-->
                <div class="modal fade" id="escolhe_situac" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="escolhe_situac" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered " role="document" style="width: 400px !important;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="escolhe_situac">Filtro:</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <label>Situação</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input situac_filtro" value="3" name="situac_filtro" id="situac_todos" checked>
                                                <label class="custom-control-label" for="situac_todos" style="user-select: none;">Todos</label>
                                            </div>
                                            <div class="custom-control custom-radio ">
                                                <input type="radio" class="custom-control-input situac_filtro" value="1" name="situac_filtro" id="situac_ativo">
                                                <label class="custom-control-label" for="situac_ativo" style="user-select: none;">Ativo</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input situac_filtro" value="0" name="situac_filtro" id="situac_inativo">
                                                <label class="custom-control-label" for="situac_inativo" style="user-select: none;">Inativo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0);" class="apontamento"><button id="btn-processar" type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"> OK </button></a>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                            </div>
                        </div>
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

        <!-- COMPONENTE TREEVIEW -->
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>

</body>

</html>

<script>
    function swa_retorno_default() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            html: 'Nenhum relatório foi selecionado! Selecione um relatório <b>válido</b> e tente novamente!'
        });

    }

    $(document).ready(function() {
        $.ajax({
            url: "relatorio_consulta.php",
            method: "POST",
            dataType: "json",
            success: function(retorno) {
                $('#treeview').treeview({
                    color: "#428bca",
                    // enableLinks: true,
                    showTags: true,
                    data: retorno,
                    onNodeSelected: function(event, node) {
                        if (node.nodes == undefined) {
                            // sends node info to another element
                        } else if (node.state.expanded) {
                            // TODO collapse children 
                            collapseNode(node.nodeId);
                        } else {
                            // TODO expand children 
                            expandNode(node.nodeId);
                        }
                    }
                });
                $('#treeview').treeview('collapseAll', {
                    silent: true
                });
            }
        });

    });

    function collapseNode(nodeId) {
        $('#treeview').treeview('collapseNode', [nodeId]);
    }

    function expandNode(nodeId) {
        $('#treeview').treeview('expandNode', [nodeId]);
    }

    // $(document).ready(function() {

    //     $(document).on('click', '#btn-processar', function() {

    //         var codigo_rel = $('.node-selected > #codigo_rel').text();

    //         if (codigo_rel !== '') {

    //             var dados = {
    //                 codigo_rel: codigo_rel
    //             };
    //             $.post('relatorio_post', dados, function(retorna) {

    //                 alert("Valor do plano: " + codigo_rel);

    //             });

    //         } else {

    //         }

    //     });

    // });

    $(document).ready(function() {

        $(document).on('click', '.node-treeview', function() {

            var linkdirect = $('.node-selected > #link_rel').val();
            var codigo_rel = $('.node-selected > #codigo_rel').val();

            if ((linkdirect !== '') && (codigo_rel !== '')) {

                if ((linkdirect !== undefined) && (codigo_rel !== undefined)) {

                    var dados = {
                        linkdirect: linkdirect,
                        codigo_rel: codigo_rel
                    };
                    $.post('controller/relatorio_post.php', dados, function(retorna) {

                        // alert("Valor do plano: " + linkdirect);

                        $(".linkdirect").removeAttr("onclick", "swa_retorno_default();");
                        //ATRIBUIÇÕES DO MODAL
                        $(".linkdirect").attr("data-toggle", "modal");
                        $(".linkdirect").attr("data-target", '#escolhe_situac');
                        $(".linkdirect").attr("name", "modal");
                        //ATRIBUIÇÕES DO LINK
                        $(".apontamento").attr("href", linkdirect);
                        $(".apontamento").attr("download", "");

                    });

                } else {

                    var unset_codigo_rel = 1;

                    var dados = {
                        unset_codigo_rel: unset_codigo_rel
                    };
                    $.post('controller/relatorio_post.php', dados, function(retorna) {

                        // alert("Valor do plano: " + linkdirect);

                        $(".linkdirect").attr("onclick", "swa_retorno_default();");
                        //ATRIBUIÇÕES DO MODAL
                        $(".linkdirect").removeAttr("data-toggle", "modal");
                        $(".linkdirect").removeAttr("data-target", '#escolhe_situac');
                        $(".linkdirect").removeAttr("name", "modal");
                        //ATRIBUIÇÕES DO LINK
                        $(".apontamento").attr("href", "javascript:void(0);");
                        $(".apontamento").removeAttr("download");

                    });

                }

            } else {

                var unset_codigo_rel = 1;

                var dados = {
                    unset_codigo_rel: unset_codigo_rel
                };
                $.post('controller/relatorio_post.php', dados, function(retorna) {

                    // alert("Valor do plano: " + linkdirect);

                    $(".linkdirect").attr("onclick", "swa_retorno_default();");
                    //ATRIBUIÇÕES DO MODAL
                    $(".linkdirect").removeAttr("data-toggle", "modal");
                    $(".linkdirect").removeAttr("data-target", '#escolhe_situac');
                    $(".linkdirect").removeAttr("name", "modal");
                    //ATRIBUIÇÕES DO LINK
                    $(".apontamento").attr("href", "javascript:void(0);");
                    $(".apontamento").removeAttr("download");

                });

            }

        });

    });

    $(document).ready(function() {

        $(document).on('click', '.situac_filtro', function() {

            var situac_filtro = $(this).val();

            if (situac_filtro !== '') {

                var dados = {
                    situac_filtro: situac_filtro
                };
                $.post('controller/relatorio_post.php', dados, function(retorna) {

                });

            }
        });

    });

    $('#escolhe_situac').on('hide.bs.modal', function(event) {
        //AO FECHAR O MODAL ELE LIMPA A VARIAVEL DE SESSAO situac_filtro

        unset_situac_filtro = 1;

        var dados = {
            unset_situac_filtro: unset_situac_filtro
        };
        $.post('controller/relatorio_post.php', dados, function(retorna) {

            $("#situac_todos").prop('checked', true);

        });


    });
</script>