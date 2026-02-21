<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

if (!empty($_SESSION["politica_editar"])) {

    unset($_SESSION["politica_editar"]);
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

    <title>GESTOU PORTAL - Políticas e código de conduta</title>

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

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<!-- DEFINE A COR DAS BORDAS DA TABLE, SE REMOVER SERÁ DEFINIDA COMO PRETO -->
<style>
    .table>:not(:last-child)>:last-child>* {

        border-bottom-color: #E3E6F0 !important;
    }
</style>

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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Políticas e código de conduta</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                <thead style="text-align: center;">

                                    <div class="col-sm-12 button-tabela">

                                        <button type="button" class="btn btn-organograma btn-icon-split-organograma" data-toggle="modal" data-target="#Incluir"><i class="fas fa-plus-circle"></i> Incluir</button>
                                        <button disabled type="button" id="btn-excluir" name="btn-excluir" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>

                                    </div>

                                    <tr>
                                        <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox"></input></th>
                                        <th data-orderable="false">Título</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th></th>
                                        <th>Título</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php

                                    foreach (selectGESPOL_id_emp($id_emp_default) as $linha) {

                                        if ($linha != 0) {

                                    ?>
                                            <tr class="align-middle">

                                                <td class="coluna-checkbox">

                                                    <?php

                                                    switch ($linha['situac']) {
                                                        case 1:

                                                    ?>

                                                            <input type="checkbox" disabled></input>

                                                        <?php

                                                            break;

                                                        case 0:

                                                        ?>

                                                            <input type="checkbox" class="selecionar" value="<?php echo $id_pol = $linha['id_pol']; ?>"></input>

                                                    <?php

                                                            break;
                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    if (empty($linha["anexo"])) {

                                                    ?>
                                                        <!-- <a href="../upload/empresa/politicas/?php echo $linha['anexo']; ?>" download> -->
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                        <!-- </a> -->

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>

                                                    <?php

                                                    }

                                                    ?>
                                                </td>

                                                <td class="content-xy-center">
                                                    <!-- INICIO SITUACAO -->
                                                    <div class="div-acoes">
                                                        <?php

                                                        switch ($linha['situac']) {
                                                            case 1:

                                                        ?>

                                                                <span class="text-success cursor-pointer btn_situac" politica="<?php echo $linha["id_pol"]; ?>"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>

                                                            <?php

                                                                break;

                                                            case 0:

                                                            ?>

                                                                <span class="text-danger cursor-pointer btn_situac" politica="<?php echo $linha["id_pol"]; ?>"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>

                                                        <?php

                                                                break;
                                                        }

                                                        ?>
                                                    </div>

                                                    <!-- INICIO EDITAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-primary btn-icones btn-editar" politica="<?php echo $linha["id_pol"]; ?>">
                                                            <i class="fas fa-pencil-alt" title="Editar"></i>
                                                        </button>
                                                    </div>

                                                    <!-- INICIO EDITAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-primary btn-icones visualizar_modal" politica="<?php echo $linha["id_pol"]; ?>">
                                                            <i class="fas fa-eye" title="Visualizar"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>


                                    <?php
                                        } else {
                                        }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            <!-- FIM CONTAINER FLUID -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- Incluir Politica Modal-->
        <div class="modal fade" id="Incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Incluir" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Incluir">Políticas e código de conduta</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="mb-3">

                                <label for="titulo" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Título referente a Política ou Cód. Conduta.">Título <i class="fas fa-info-circle"></i></label>
                                <input type="text" class="form-control" style="text-transform: uppercase;" id="titulo" name="titulo" required></input>

                                <label for="input-b1">Anexar</label>
                                <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF" required>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pra visualizar o conteudo salvo -->
        <div id="Visualizar" class="modal fade" tabindex="-1" aria-labelledby="Visualizar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Visualizar">Políticas e código de conduta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="visuTela" class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include_once 'footer.php'; ?>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

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

<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $("#checkTodos").click(function() {
        $('input:checkbox').not(":disabled").prop('checked', this.checked);
    });

    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    $(document).ready(function() {
        $("#btn-submit").click(function() {
            var btn_submit = 1;
            var fd = new FormData();
            var files = $('#input-b1')[0].files[0];
            var titulo = $('#titulo').val();
            fd.append('btn_submit', btn_submit);
            fd.append('file', files);
            fd.append('titulo', titulo);

            if (btn_submit !== '') {

                $.post({
                    url: 'controller/politicas_codconduta_post.php',
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
                                    window.location.reload();
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
        $('.btn-editar').click(function() {

            var btn_editar = 1;
            var politica_editar = $(this).attr("politica");

            //verificar se há calor nas variaveis
            if ((btn_editar !== '') && (politica_editar !== '')) {
                var dados = {
                    btn_editar: btn_editar,
                    politica_editar: politica_editar
                };
                $.post('controller/politicas_codconduta_post.php', dados, function(retorna) {

                    location.href = "alterar_politicas_codconduta";

                });

            }
            // console.log(selecionados);
            // // Faça algo com os valores selecionados aqui...
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.visualizar_modal', function() {
            var abrir_modal = 1;
            var politica = $(this).attr("politica");

            if ((abrir_modal !== '') && (politica !== '')) {
                var dados = {
                    abrir_modal: abrir_modal,
                    politica: politica
                };
                $.post('controller/politicas_codconduta_post.php', dados, function(retorna) {

                    //Carregar o conteudo para o usuário
                    $("#visuTela").html(retorna);
                    $('#Visualizar').modal('show');
                });
            }
        });
    });

    $(document).ready(function() {
        $('#btn-excluir').click(function() {

            var btn_excluir = 1;
            var selecionados = $('.selecionar:not(:disabled):checked').map(function() {
                return this.value;
            }).get();

            //verificar se há calor nas variaveis
            if ((btn_excluir !== '') && (selecionados !== '')) {
                var dados = {
                    btn_excluir: btn_excluir,
                    selecionados: selecionados
                };
                $.post('controller/politicas_codconduta_post.php', dados, function(retorna) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        title: 'Sucesso!',
                        text: 'Informação excluida com sucesso!',
                        closeOnClickOutside: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                            // location.href = "sobre_nos";
                        }
                    });

                });

            }
            // console.log(selecionados);
            // // Faça algo com os valores selecionados aqui...
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn_situac', function() {
            var btn_situac = 1;
            var politica_situac = $(this).attr("politica");

            if ((btn_situac !== '') && (politica_situac !== '')) {
                var dados = {
                    btn_situac: btn_situac,
                    politica_situac: politica_situac
                };
                $.post('controller/politicas_codconduta_post.php', dados, function(retorna) {

                    window.location.reload();

                });
            }
        });
    });
</script>