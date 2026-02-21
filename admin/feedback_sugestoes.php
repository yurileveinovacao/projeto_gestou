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

    <title>GESTOU PORTAL - Feedback e sugestões</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous"> -->

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
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdfeimg.min.js"></script>

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

                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <!-- HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Feedback e sugestões</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <!-- INICIO DIV TABLE -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                <!-- THEAD -->
                                <thead style="text-align: center;">
                                    <div class="col-sm-12 button-tabela">
                                        <button type="button" id="btn-reload" title="Recarregar" class="btn btn-organograma btn-icon-split-organograma">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>

                                        <button type="button" id="abrir-filtro" class="btn btn-primary" title="Filtros" abrir-modal="#modal-filtro">
                                            <i class="fas fa-filter"></i> Filtros
                                        </button>
                                    </div>
                                    <tr>
                                        <th data-orderable="false" style="display:none">Rank</th>
                                        <th data-orderable="false">Data</th>
                                        <th data-orderable="false">Tipo Solicitação</th>
                                        <th data-orderable="false">Usuário</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Situação</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Ações</th>
                                    </tr>
                                </thead>

                                <!-- TFOOT -->
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th style="display:none">Rank</th>
                                        <th>Data</th>
                                        <th>Tipo Solicitação</th>
                                        <th>Usuário</th>
                                        <th>Situação</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <!-- INICIO TBODY -->
                                <tbody class="texto-table-body linhas">

                                    <?php

                                    $situac_filtro = $_SESSION["feedback_filtro_situac"];

                                    switch ($situac_filtro) {

                                        case "P":

                                            $situac = 0;

                                            break;

                                        case "R":

                                            $situac = 1;

                                            break;

                                        case "C":

                                            $situac = 2;

                                            break;

                                        default:

                                            $situac = 9;

                                            break;
                                    }

                                    foreach (selectGESOUV($id_usa_default, $id_emp_default, $situac) as $linha) {

                                        //IF VERIFICAR SE EXISTEM REGISTROS
                                        if ($linha != 0) {

                                            if ($linha["situac_usa_visualizar"] == 0) {

                                                $cor = "bg-warning-lighter";
                                            } else {

                                                $cor = "";
                                            }
                                    ?>

                                            <tr style="vertical-align: middle;" class="linha <?php echo $cor; ?>">
                                                <td style="display:none"><?php echo $linha['rank']; ?></td>

                                                <!-- DATA -->
                                                <td style="text-align: center;">

                                                    <span class="font-weight-bold">
                                                        <?php
                                                        $datinc = new DateTime($linha["datinc"]);
                                                        echo $datinc->format("d/m/Y");
                                                        ?>
                                                    </span>

                                                </td>

                                                <!-- TIPO SOLICITAÇÃO -->
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text"><?php echo $linha['solicitacao']; ?></span>
                                                </td>

                                                <!-- USUÁRIO -->
                                                <td>
                                                    <?php echo $linha['nome']; ?>
                                                </td>

                                                <!-- SITUAÇÃO -->
                                                <td style="text-align:center">
                                                    <!-- SITUAÇÃO PENDENTE -->
                                                    <?php if ($linha['situac'] == 0) { ?>

                                                        <div class="btn btn-warning btn-icon width-100">
                                                            <span class="icon text-white-30"><i class="fas fa-exclamation-triangle"></i></span>
                                                            <span class="text font-weight-bold">PENDENTE</span>
                                                        </div>

                                                        <!-- SITUAÇÃO RESPONDIDO -->
                                                    <?php } else if ($linha['situac'] == 1) { ?>

                                                        <div class="btn btn-success btn-icon width-100">
                                                            <span class="icon text-white-30"><i class="far fa-check-circle"></i></span>
                                                            <span class="text font-weight-bold">RESPONDIDO</span>
                                                        </div>

                                                        <!-- SITUAÇÃO CANCELADO -->
                                                    <?php } else if ($linha['situac'] == 2) { ?>

                                                        <div class="btn btn-danger btn-icon width-100">
                                                            <span class="icon text-white-30"><i class="far fa-times-circle"></i></span>
                                                            <span class="text font-weight-bold">CANCELADO</span>
                                                        </div>
                                                    <?php } ?>
                                                </td>

                                                <!-- AÇÕES -->
                                                <td style="text-align:center">
                                                    <button type="button" class="btn btn-primary abrir-modal" id_modal="Visualizar" id_ouv="<?php echo $linha['id_ouv']; ?>" title="Visualizar Aviso"><i class="fas fa-eye"></i></button>

                                                    <button type="button" class="btn btn-primary abrir-modal btn-resp" id_modal="Responder" id_ouv="<?php echo $linha['id_ouv']; ?>" situac="<?php echo $linha['situac']; ?>" title="Responder"><i class="fas fa-check"></i></button>

                                                    <button type="button" class="btn btn-primary abrir-modal btn-resp" id_modal="Cancelar" id_ouv="<?php echo $linha['id_ouv']; ?>" situac="<?php echo $linha['situac']; ?>" title="Cancelar"><i class="fas fa-times"></i></button>

                                                </td>
                                            </tr>

                                            <!-- MODAL Visualizar -->
                                            <div class="modal fade modal-mensagem" id="Visualizar<?php echo $linha['id_ouv']; ?>" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="Visualizar">Visualizar Mensagem</h5>
                                                            <button class="close close-modal" type="button">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA SOLICITAÇÃO</label>
                                                                        <input type="text" class="form-control" value="<?php echo $linha["solicitacao"]; ?>" readonly disabled></input>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                                                                        <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $linha["mensagem"]; ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <?php if ($linha["situac"] != 0) { ?>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="resposta" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA:</label>
                                                                            <textarea class="form-control" id="resposta" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $linha["resposta"]; ?></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="usuario" class="mt-sm-3 mb-2 font-weight-bold">Usuário Alteração:</label>
                                                                            <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $linha["usuario_alteracao"]; ?>" readonly disabled></input>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="data" class="mt-sm-3 mb-2 font-weight-bold">Data Alteração:</label>
                                                                            <input type="text" name="data" id="data" style="" class="form-control" value="<?php $datatualizacao = new DateTime($linha["datatu"]);
                                                                                                                                                            echo $datatualizacao->format("d/m/Y H:i:s"); ?>" readonly disabled></input>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php }
                                    } ?>
                                </tbody>
                                <!-- FIM TBODY -->

                            </table>
                        </div>
                        <!-- FIM DIV TABLE -->

                        <!-- INICIO MODAIS -->

                        <!-- MODAL Responder -->
                        <div class="modal fade modal-mensagem" id="Responder" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Responder" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Enviar Resposta</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-resp">
                                        <div class="modal-body">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA:</label>
                                                        <textarea class="form-control" id="mens_responder" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" required></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-organograma" type="submit">Enviar</button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Cancelar -->
                        <div class="modal fade modal-mensagem" id="Cancelar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Cancelar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Cancelar">Motivo do Cancelamento</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-cancel">
                                        <div class="modal-body">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA:</label>
                                                        <textarea class="form-control" id="mens_cancelar" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" required></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-organograma" type="submit">Enviar</button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Filtros -->
                        <div class="modal fade" id="modal-filtro" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="filtros" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Filtros</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="form-group col-md-6 mt-1">
                                                    <label>Situação:</label>

                                                    <?php

                                                    switch ($situac_filtro) {

                                                        case "P":

                                                    ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="P" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio0">Pendente</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Respondido</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="C" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Cancelado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "R":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="P" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Pendente</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="R" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio1">Respondido</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="C" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Cancelado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "C":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="P" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Pendente</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Respondido</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="C" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio2">Cancelado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        default:

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="P" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Pendente</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Respondido</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="C" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Cancelado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="T" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio3">Todos</label>
                                                            </div>

                                                    <?php

                                                            break;
                                                    }

                                                    ?>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btn-filtrar" class="btn btn-organograma btn-icon-split-organograma">Filtrar</button>
                                        <button type="button" class="btn btn-secondary close-modal">Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FIM MODAIS -->

                    </div>
                    <!-- FIM CARD BODY -->

                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- FOOTER -->
        <?php

        include_once 'footer.php';

        ?>

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

<script>
    // APAGA O QUE FOI ESCRITO NO MODAL
    $(function() {
        $('.modal-mensagem').on('hidden.bs.modal', function() {

            var forms = $(this).find('form');

            if (forms.length > 0) {

                forms[0].reset();
            }

            var close_modal = 1;

            var dados = {

                close_modal: close_modal
            };

            $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {});
        });
    });

    // DESABILITA BOTÕES DE AÇÃO QUANDO A SITUAÇÃO FOR 1 OU 2
    $(function() {
        $('.btn-resp').each(function() {

            var situac = $(this).attr('situac');

            if (situac !== '0') {

                $(this).attr('disabled', true);
                $(this).removeClass('btn-primary');
                $(this).removeClass('abrir-modal');
                $(this).addClass('btn-secondary');
            }
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BOTÃO RELOAD
    $(function() {
        $(document).on('click', '#btn-reload', function() {

            location.reload();
        });
    });

    // BOTÃO FILTRO
    $(function() {
        $(document).on('click', '#btnExibeOcultaDiv', function() {

            $("#dvPrincipal").toggle();
        });
    });

    // BOTÕES AÇÕES
    $(function() {
        $(document).on('click', '.abrir-modal', function() {

            var id_ouv_mensagem = $(this).attr('id_ouv');

            // Verifica se há valor na variavel
            if (id_ouv_mensagem !== '') {

                var dados = {

                    id_ouv_mensagem: id_ouv_mensagem
                };

                $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {});
            }
        });
    });

    // ABRIR MODAL
    $(function() {
        $(document).on('click', '.abrir-modal', function() {

            // Atribui valor as Variáveis
            // Recebe o id do Modal que vai ser aberto
            var abrir_modal = $(this).attr('id_modal');
            // Recebe o id_ouv do chamado em que houve o clique do botão
            var id_ouv = $(this).attr('id_ouv');

            if (abrir_modal !== '') {

                var dados = {

                    abrir_modal: abrir_modal,
                    id_ouv: id_ouv
                };

                $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {

                    $(retorno).modal('show');

                    // Se retorno for 0 burlou a regra de disabled
                    if (retorno == 0) {

                        // Exibe uma mensagem de erro e recarrega a pagina
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atenção!',
                            text: 'Você não possui ação nesse status!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                });
            }
        });
    });

    // ABRIR FILTROS
    $(function() {
        $(document).on('click', '#abrir-filtro', function() {

            var abrir_filtro = $(this).attr('abrir-modal');

            if (abrir_filtro !== '') {

                $(abrir_filtro).modal('show');
            }
        });
    });
</script>

<!-- BOTÕES DE MODAL -->
<script>
    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            $('.modal:visible').modal('hide');
        });
    });

    // SUBMIT MODAL RESPOSTA
    $(function() {
        $("#form-resp").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();


            // Valor que define que o formulário foi submetido
            var btn_submit_resp = 1;

            // Obtém os valores do formulário
            var dados = {

                mensagem: $('#mens_responder').val(),

                // Valida o envio do Form
                btn_submit_resp: btn_submit_resp
            };

            $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {

                // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                if (retorno == 1) {

                    // Exibe uma mensagem de sucesso e recarrega a pagina
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Respondido com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    // Se o retorno for igual a 0, os dados não foram preenchidos corretamente
                } else if (retorno == 0) {

                    // Exibe uma mensagem de falha
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Preencha todos os campos para concluir a ação!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });

                    // Caso não for 0/1 houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Favor entrar em contato com o suporte.',
                        html: retorno,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                }
            });
        });
    });

    // SUBMIT MODAL CANCELAR
    $(function() {
        $("#form-cancel").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();


            // Valor que define que o formulário foi submetido
            var btn_submit_cancel = 1;

            // Obtém os valores do formulário
            var dados = {

                mensagem: $('#mens_cancelar').val(),

                // Valida o envio do Form
                btn_submit_cancel: btn_submit_cancel
            };

            $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {

                // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                if (retorno == 1) {

                    // Exibe uma mensagem de sucesso e recarrega a pagina
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Cancelado com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    // Se o retorno for igual a 0, os dados não foram preenchidos corretamente
                } else if (retorno == 0) {

                    // Exibe uma mensagem de falha
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Preencha todos os campos para concluir a ação!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });

                    // Caso não for 0/1 houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Favor entrar em contato com o suporte.',
                        html: retorno,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                }
            });
        });
    });

    // FILTRAR
    $(function() {
        $(document).on('click', '#btn-filtrar', function() {

            var btn_filtro = 1;

            if (btn_filtro !== '') {

                var dados = {

                    feedback_filtro_situac: $('.filtro-situac:not(:disabled):checked').val(),

                    // Valida o click no Filtrar
                    btn_filtro: btn_filtro
                };

                $.post('controller/feedback_sugestoes_post.php', dados, function(retorno) {

                    location.reload();
                });
            }
        });
    });
</script>