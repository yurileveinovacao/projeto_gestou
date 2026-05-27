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

    <title>GESTOU PORTAL - Solicitações dos colaboradores</title>

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
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdfeimg.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- BOTÃO ON E OFF -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script> -->

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

                include_once "pagina_restrita.php"; ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <!-- HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Solicitações dos colaboradores</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <!-- INICIO DIV TABLE -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                <!-- THEAD -->
                                <thead style="text-align: center;">
                                    <!-- TOP BUTTONS -->
                                    <div class="col-sm-12 button-tabela">
                                        <button type="button" id="btn-reload" class="btn btn-organograma btn-icon-split-organograma" title="Recarregar">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>

                                        <button type="button" class="btn btn-primary abrir-filtro" title="Filtros" abrir-modal="#modal-filtro">
                                            <i class="fas fa-filter"></i> Filtros
                                        </button>
                                    </div>

                                    <!-- CABEÇALHO TABLE -->
                                    <tr>
                                        <th data-orderable="false" style="display:none">Rank</th>
                                        <th data-orderable="false">Data</th>
                                        <th data-orderable="false">Tipo Solicitação</th>
                                        <th data-orderable="false">Usuário</th>
                                        <th data-orderable="false">Gestor</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Situação</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="20%">Ações</th>
                                    </tr>
                                </thead>

                                <!-- TFOOT -->
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th style="display:none">Rank</th>
                                        <th>Data</th>
                                        <th>Tipo Solicitação</th>
                                        <th>Usuário</th>
                                        <th>Gestor</th>
                                        <th>Situação</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <!-- INICIO TBODY -->
                                <tbody class="texto-table-body linhas">

                                    <?php

                                    $situac_filtro = $_SESSION["solicitacao_filtro_situac"];

                                    switch ($situac_filtro) {

                                        case "E":

                                            $situac = 0;

                                            break;

                                        case "G":

                                            $situac = 1;

                                            break;

                                        case "L":

                                            $situac = 2;

                                            break;

                                        case "A":

                                            $situac = 3;

                                            break;

                                        case "R":

                                            $situac = 4;

                                            break;

                                        default:

                                            $situac = 9;

                                            break;
                                    }

                                    foreach (selectGESSOL($id_usa_default, $id_emp_default, $situac) as $linha) {

                                        //IF VERIFICAR SE EXISTEM REGISTROS
                                        if ($linha != 0) { ?>

                                            <tr style="vertical-align: middle;" class="linha-table" visualizado="<?php echo $linha["situac_usa_visualizar"]; ?>" id-sol="<?php echo $linha['id_sol']; ?>">
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
                                                    <span class="m-0 text-primary tamanho-text">
                                                        <?php echo $linha['solicitacao']; ?>
                                                    </span>
                                                </td>

                                                <!-- USUÁRIO -->
                                                <td>
                                                    <?php echo $linha["nome"]; ?>
                                                </td>

                                                <!-- GESTOR -->
                                                <td>
                                                    <?php echo $linha["gestor"]; ?>
                                                </td>

                                                <!-- SITUAÇÃO -->
                                                <td style="text-align:center">

                                                    <?php if ($linha['situac'] == 0) { ?>

                                                        <div class="btn btn-warning btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">PENDENTE</span>
                                                        </div>
                                                    <?php } else if ($linha['situac'] == 1) { ?>

                                                        <div class="btn btn-organograma btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">AGUARDANDO GESTOR</span>
                                                        </div>
                                                    <?php } else if ($linha['situac'] == 2) { ?>

                                                        <div class="btn btn-azulpiscina btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="far fa-check-circle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">LIBERADO GESTOR</span>
                                                        </div>
                                                    <?php } else if ($linha['situac'] == 3) { ?>

                                                        <div class="btn btn-success btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="far fa-check-circle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">APROVADO</span>
                                                        </div>
                                                    <?php } else { ?>

                                                        <div class="btn btn-danger btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="far fa-times-circle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">REPROVADO</span>
                                                        </div>
                                                    <?php } ?>

                                                </td>

                                                <!-- AÇÕES -->
                                                <td style="text-align:center">

                                                    <button type="button" class="btn btn-primary abrir-modal" id_sol="<?php echo $linha["id_sol"]; ?>" abrir-modal="#modal-visualizar" anexo="<?php echo $linha['anexo']; ?>" title="Visualizar Aviso">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <!-- IF RH E SITUAC 0 -->
                                                    <?php if ((($linha["situac"] == 0) and ($linha["tipo"] == "RH")) || (($linha["situac"] == 2) and ($linha["tipo"] == "RH"))) { ?>

                                                        <button type="button" class="btn btn-primary btn-aprovar" id_sol="<?php echo $linha["id_sol"]; ?>" situac-update="3" visualizado="<?php echo $linha["situac_usa_visualizar"]; ?>" title="Aprovar">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-primary abrir-modal" id_sol="<?php echo $linha["id_sol"]; ?>" abrir-modal="#modal-justificativa" title="Reprovar">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <!-- IF GESTOR E SITUAC 1 -->
                                                    <?php } elseif (($linha["situac"] == 1) and ($linha["tipo"] == "GS")) { ?>

                                                        <button type="button" class="btn btn-primary btn-aprovar" id_sol="<?php echo $linha["id_sol"]; ?>" situac-update="2" visualizado="<?php echo $linha["situac_usa_visualizar"]; ?>" title="Aprovar">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-primary abrir-modal" id_sol="<?php echo $linha["id_sol"]; ?>" abrir-modal="#modal-justificativa" title="Reprovar">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <!-- ELSE -->
                                                    <?php } else { ?>

                                                        <button type="button" class="btn btn-secondary" title="Aprovar" disabled>
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-secondary" title="Reprovar" disabled>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php } ?>

                                                </td>

                                            </tr>

                                    <?php }
                                    } ?>

                                </tbody>
                                <!-- FIM TBODY -->

                            </table>

                        </div>
                        <!-- FIM DIV TABLE -->

                        <!-- INICIO MODAIS -->

                        <!-- MODAL Visualizar -->
                        <div class="modal fade modal-mensagem" id="modal-visualizar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px; margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 100vh;">
                                <div class="modal-content">
                                    <div class="modal-header" style="padding-bottom: 0px;">

                                        <div style="display: flex; flex-direction: column;">
                                            <h5 class="modal-title" style="margin-bottom: 10%;">Visualizar Solicitação</h5>

                                            <ul class="nav nav-tabs" style="border-bottom: 0px;">
                                                <li class="nav-item">
                                                    <a class="nav-item nav-link active" id="nav-mensagem-tab" data-toggle="tab" href="#nav-mensagem" role="tab" aria-controls="nav-mensagem" aria-selected="true">Geral</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-item nav-link" id="nav-anexo-tab" data-toggle="tab" href="#nav-anexo" role="tab" aria-controls="nav-anexo" aria-selected="false">Anexo</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modal-visualizar-body" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                                        <div class="tab-content" id="modal-body-content">
                                            <!-- PREENCHIDO PELO PHP -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL RESPOSTA -->
                        <div class="modal fade modal-mensagem" id="modal-resposta" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-resposta" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Enviar Resposta</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-resposta">
                                        <div class="modal-body">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA:</label>
                                                        <textarea class="form-control" id="resposta" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-organograma" type="submit">OK</button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Justificativa -->
                        <div class="modal fade modal-mensagem" id="modal-justificativa" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Justificativa" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Enviar Resposta</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-modal-justificativa">
                                        <div class="modal-body">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="justificativa" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA:</label>
                                                        <textarea class="form-control" id="justificativa" name="justificativa" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" minlength="3" required></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-organograma" type="submit">OK</button>
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

                                                        case "E":

                                                    ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio5">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "G":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio5">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "L":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio5">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "A":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio5">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        case "R":

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio5">Todos</label>
                                                            </div>

                                                        <?php

                                                            break;

                                                        default:

                                                        ?>

                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio0" name="radio" value="E" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio0">Andamento</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio1" name="radio" value="G" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio1">Aguardando Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio2" name="radio" value="L" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio2">Liberado Gestor</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio3" name="radio" value="A" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio3">Aprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio4" name="radio" value="R" class="btn1 custom-control-input filtro-situac">
                                                                <label class="custom-control-label" for="radio4">Reprovado</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="radio5" name="radio" value="T" class="btn1 custom-control-input filtro-situac" checked>
                                                                <label class="custom-control-label" for="radio5">Todos</label>
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
                                        <button type="button" id="btn-filtrar" class="btn btn-organograma btn-icon-split-organograma btn-filtrar">Filtrar</button>
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
        <?php include_once 'footer.php'; ?>

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

            $.post('controller/solicitacoes_post.php', dados, function(retorno) {});
        });
    });

    // LIMPA A SELEÇÃO DE ABAS DO MODAL
    $(function() {

        $('#modal-visualizar').on('hidden.bs.modal', function() {
            // Remove a classe "active" da aba atual
            $('.nav-tabs .active').removeClass('active');

            // Define a primeira aba como ativa
            $('.nav-tabs li:first-child a').addClass('active');
        });
    });
</script>

<script>
    // MUDA O BACKGROUND SE A SOLICITAÇÃO NÃO FOI VISUAILIZADA AINDA
    $(function() {
        $('.linha-table').each(function() {

            var visu = $(this).attr('visualizado');

            if (visu == 0) {

                $(this).addClass('bg-warning-lighter');
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

    // ABRIR FILTRO
    $(function() {
        $(document).on('click', '.abrir-filtro', function() {

            var abrir_modal = $(this).attr('abrir-modal');

            $(abrir_modal).modal('show');
        });
    });

    // VISUALIZAR SOLICITAÇÃO
    $(function() {
        $(document).on('click', '.abrir-modal', function() {

            var abrir_modal = $(this).attr('abrir-modal');
            var id_sol = $(this).attr('id_sol');
            var anexo = $(this).attr('anexo');

            if (anexo === '') {

                $('.nav-tabs li:last-child').hide();
            } else {

                $('.nav-tabs li:last-child').show();
            }

            var btn_modal = 1;

            dados = {

                id_sol: id_sol,
                modal: abrir_modal,

                // Valida o Click do Botão
                btn_modal: btn_modal
            };

            $.post('controller/solicitacoes_post.php', dados, function(retorno) {

                $(abrir_modal).modal('show');
                $('#modal-body-content').html(retorno);
            });

            $('.linha-table').each(function() {

                var visu = $(this).attr('visualizado');
                var id_sol_modal = $(this).attr('id-sol');

                if (visu == 0 && id_sol_modal == id_sol) {

                    $(this).removeClass('bg-warning-lighter');
                    $(this).find('.btn-aprovar').attr('visualizado', 1);
                }
            });
        });
    });

    // BOTÃO APROVAR
    $(function() {
        $(document).on('click', '.btn-aprovar', function() {

            var visualizado = $(this).attr('visualizado');
            var btn_aprovar = 1;


            if (visualizado == 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    text: 'Solicitação não visualizada, tem certeza de que deseja aprovar?',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, aprovar!',
                    cancelButtonText: 'Não!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        if (btn_aprovar !== '') {

                            var dados = {
                                id_sol: $(this).attr('id_sol'),
                                situac_update: $(this).attr('situac-update'),
                                btn_aprovar: btn_aprovar
                            };


                            $.post('controller/solicitacoes_post.php', dados, function() {

                                $('#modal-resposta').modal('show');
                            });
                        }
                    }

                });
            } else {

                if (btn_aprovar !== '') {

                    var dados = {
                        id_sol: $(this).attr('id_sol'),
                        situac_update: $(this).attr('situac-update'),
                        btn_aprovar: btn_aprovar
                    };


                    $.post('controller/solicitacoes_post.php', dados, function() {

                        $('#modal-resposta').modal('show');
                    });
                }
            }


        });
    });

    // SUBMIT RESPOSTA
    $(function() {
        $('#form-resposta').submit(function(e) {
            e.preventDefault(); // impede o envio do formulário por padrão

            var submit_aprovar = 1;

            if (submit_aprovar !== '') {

                dados = {
                    resposta: $('#resposta').val(),
                    // Valida Click
                    submit_aprovar: submit_aprovar
                };

                $.post('controller/solicitacoes_post.php', dados, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram atualizados com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Solicitação aprovada com sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        // Caso não for 1, houve erro no try
                    } else {

                        // Retorna um SweetAlert com o erro exibido pelo catch
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
            }

        });
    });
</script>

<!-- AÇÕES NO MODAL -->
<script>
    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            $('.modal:visible').modal('hide');
        });
    });

    // SUBMIT JUSTIFICATIVA
    $(function() {
        $("#form-modal-justificativa").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_justifica = 1;

            if (btn_justifica !== '') {

                dados = {

                    mensagem: $('#justificativa').val(),

                    // Valida o Click
                    btn_justifica: btn_justifica
                };

                $.post('controller/solicitacoes_post.php', dados, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram atualizados com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Solicitação reprovada com sucesso!',
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
                        // Caso não for 0/1, houve erro no try
                    } else {

                        // Retorna um SweetAlert com o erro exibido pelo catch
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
            }
        });
    });

    // SUBMIT FILTROS
    $(function() {
        $(document).on('click', '#btn-filtrar', function() {

            var btn_filtro = 1;

            if (btn_filtro !== '') {

                var dados = {

                    solicitacao_filtro_situac: $('.filtro-situac:not(:disabled):checked').val(),

                    // Valida o click no Filtrar
                    btn_filtro: btn_filtro
                };

                $.post('controller/solicitacoes_post.php', dados, function(retorno) {

                    location.reload();
                });
            }
        });
    });
</script>