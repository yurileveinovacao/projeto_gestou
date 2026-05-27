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

    <title>GESTOU PORTAL - Início</title>

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
    <link href="vendor/kartik-v/bootstrap-fileinput/css/mural_fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- <link href="vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" /> -->
    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

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
    <script src="vendor/kartik-v/bootstrap-fileinput/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdfeimg.min.js"></script>
    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/locales/LANG.js"></script>


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

    <!-- Custom tinnyMCE-->
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>


    <script type="text/javascript">
        tinyMCE.init({
            selector: "#inputMensagem",
            height: 350,
            menubar: false,
            language_url: 'tinymce/langs/pt_BR.js',
            plugins: 'autolink link image emoticons charmap insertdatetime code',
            toolbar1: 'insertfile undo redo | numlist bullist hr bold italic underline forecolor | outdent indent | code',
            // toolbar2: 'fullscreen code preview print searchreplace wordcount | ltr rtl visualchars | formatselect | blockquote quicklink | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            insertdatetime_formats: ['%d/%m/%Y', '%Y-%m-%d', '%d-%m-%Y', '%D', '%I:%M:%S %p', '%H:%M:%S', '%d/%m/%Y - %H:%M:%S']
        });
    </script>

</head>

<!-- DEFINE A COR DAS BORDAS DA TABLE, SE REMOVER SERÁ DEFINIDA COMO PRETO -->
<style>
    .table>:not(:last-child)>:last-child>* {

        border-bottom-color: #E3E6F0 !important;
    }
</style>

<body id="page-top">

    <!-- INICIO PAGE WRAPPER -->
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

                <!-- PAGE HEADING -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <!-- CARD HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Mural de avisos</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">
                        <!-- INICIO FORM TABLE -->
                        <form enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                    <!-- THEAD -->
                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">

                                            <button type="button" class="btn btn-organograma btn-icon-split-organograma btn-modal" abrir-modal="#modal-incluir"><i class="fas fa-plus-circle"></i> Incluir</button>

                                            <button type="button" id="btn-excluir" name="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" disabled><i class="fas fa-trash-alt"></i> Excluir</button>

                                        </div>

                                        <tr>
                                            <th data-orderable="false" style="display:none">Rank</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                            <th data-orderable="false">Título</th>
                                            <th data-orderable="false">Departamento</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click" width="20%">Ações</th>
                                        </tr>
                                    </thead>

                                    <!-- TFOOT -->
                                    <tfoot style="text-align: center;">
                                        <tr>
                                            <th style="display:none">Rank</th>
                                            <th></th>
                                            <th>Título</th>
                                            <th>Departamento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>

                                    <!-- INICIO TBODY -->
                                    <tbody class="texto-table-body">

                                        <?php foreach (selectGESMUR_id_emp($id_emp_default) as $linha) {

                                            if ($linha != 0) { ?>

                                                <tr class="align-middle">
                                                    <td style="display:none"><?php echo $linha['rank']; ?></td>

                                                    <!-- CHECKBOX -->
                                                    <?php if ($linha['situac'] == 0) { ?>

                                                        <td class="coluna-checkbox"><input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $linha['id_mur']; ?>"></input></td>
                                                    <?php } else { ?>

                                                        <td class="coluna-checkbox"><input type="checkbox" disabled></input></td>
                                                    <?php } ?>

                                                    <!-- TITULO -->
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $linha['titulo']; ?></span>
                                                    </td>

                                                    <!-- DEPARTAMENTO -->
                                                    <td>
                                                        <?php echo $linha["departamento"]; ?>
                                                    </td>

                                                    <!-- INICIO AÇÕES -->
                                                    <td class="content-xy-center">

                                                        <!-- ENVIAR -->
                                                        <div class="div-acoes">
                                                            <?php if ($linha['situac'] == 0) { ?>

                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 disable content-xy-center btn-enviar" title="Inativo" id-mur="<?php echo $linha['id_mur']; ?>" situac="0">
                                                                    <div class="handle"></div>
                                                                </button>
                                                            <?php } else { ?>

                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 active content-xy-center btn-enviar" title="Ativo" id-mur="<?php echo $linha['id_mur']; ?>" situac="1">
                                                                    <div class="handle"></div>
                                                                </button>
                                                            <?php } ?>
                                                        </div>

                                                        <!-- INICIO VISUALIZAR -->
                                                        <div class="div-acoes">
                                                            <button type="button" class="btn btn-primary btn-modal" abrir-modal="#Visualizar<?php echo $linha['id_mur']; ?>" title="Visualizar Aviso"><i class="fas fa-eye"></i></button>
                                                        </div>

                                                    </td>
                                                    <!-- FIM AÇÕES -->

                                                </tr>

                                                <!-- MODAL Visualizar -->
                                                <div class="modal fade" id="Visualizar<?php echo $linha['id_mur']; ?>" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="Visualizar">Visualizar Aviso</h5>
                                                                <button class="close close-modal" type="button">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="col-md-12">

                                                                    <?php if (!empty($linha["anexo"])) { ?>

                                                                        <?php

                                                                        if ($linha["tipo_anexo"] == "IMAGEM") {

                                                                        ?>
                                                                            <div class="row">
                                                                                <img src="../upload/mensagens/notificacoes/mural_aviso/<?php echo $linha["anexo"]; ?>" class="m-auto img-fluid" style="max-width: 50% !important;"></img>
                                                                            </div>
                                                                        <?php

                                                                        }

                                                                        if ($linha["tipo_anexo"] == "ARQUIVO") {

                                                                        ?>
                                                                            <div class="row">
                                                                                <iframe src="../upload/mensagens/notificacoes/mural_aviso/<?php echo $linha["anexo"]; ?>" class="m-auto" style="width: 600px;height: 600px"></iframe>
                                                                            </div>
                                                                        <?php

                                                                        }

                                                                        ?>

                                                                    <?php } ?>

                                                                    <?php if (!empty($linha["mensagem"])) { ?>

                                                                        <div class="row <?php if (!empty($linha['anexo'])) { ?> mt-4 <?php } ?>">
                                                                            <span><?php echo $linha["mensagem"]; ?></span>
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
                        </form>
                        <!-- FIM FORM TABLE -->

                    </div>
                    <!-- FIM CARD BODY -->

                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- INICIO MODAL INCLUIR -->
        <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Incluir" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="Incluir">Incluir Aviso</h5>
                        <button class="close close-modal" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form id="modal-form" enctype="multipart/form-data">
                        <div class="modal-body" style="height: 470px; overflow-y: auto; scrollbar-width: thin;">

                            <div classs="col-md-12" style="display: flex; justify-content: center;">

                                <ul class="nav">
                                    <li class="nav-item" style="margin-right: 20px;">
                                        <!-- <button class="btn btn-secondary btn-sem-click" style="width: 200px; text-align: left;" id="nav-etapa2-tab"> -->
                                        <!-- <button class="btn btn-success btn-sem-click" style="width: 200px; text-align: left;" id="nav-etapa3-tab"> -->
                                        <button class="btn btn-primary btn-sem-click" style="width: 200px; text-align: left;" id="nav-etapa1">
                                            Etapa 1
                                        </button>
                                    </li>

                                    <li class="nav-item" style="margin-right: 20px;">
                                        <button class="btn btn-secondary btn-sem-click" style="width: 200px; text-align: left;" id="nav-etapa2">
                                            Etapa 2
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="btn btn-secondary btn-sem-click" style="width: 200px; text-align: left;" id="nav-etapa3">
                                            Etapa 3
                                        </button>
                                    </li>

                                </ul>

                            </div>

                            <!-- ETAPA 1 -->
                            <div class="col-md-12" id="etapa1" style="width: 100%;">
                                <div class="col-md-12">


                                    <label for="inputTitulo" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Título referente ao aviso">Título <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" id="inputTitulo" name="inputTitulo" minlength="3" required></input>

                                    <label for="inputid_dep" class="mt-sm-3">Departamento</label>
                                    <select class="form-control" style="text-transform: uppercase;" id="inputid_dep" name="inputid_dep" required>

                                        <option value="" selected disabled>Escolha um departamento</option>

                                        <?php foreach (selectGESDEP_emp($id_emp_default) as $departamento) { ?>

                                            <option value="<?php echo $departamento["id_dep"]; ?>"><?php echo $departamento["nome"]; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>

                            <!-- ETAPA 2 -->
                            <div class="col-md-12" id="etapa2" style="width: 100%; display: none;">

                                <div class="col-md-12">

                                    <label for="inputMensagem" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Mensagem referente ao aviso">Mensagem <i class="fas fa-info-circle"></i></label>
                                    <textarea class="form-control" id="inputMensagem" name="inputMensagem"></textarea>
                                </div>
                            </div>

                            <!-- ETAPA 3 -->
                            <div class="col-md-12" id="etapa3" style="width: 100%; display: none;">

                                <div class="col-md-12">

                                    <label for="input-b1" class="mt-sm-3">Anexar</label>
                                    <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF, .jpg, .JPG, .png, .PNG, .jpeg, .JPEG">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary close-modal" id="btn-voltar" type="button">Voltar</button>
                            <button type="submit" id="btn-finalizar" class="btn btn-organograma btn-icon-split-organograma" style="display: none;">Finalizar</button>
                            <button type="button" id="btn-avancar" class="btn btn-organograma btn-icon-split-organograma">Avançar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIM MODAL INCLUIR -->

        <!-- FOOTER -->
        <?php include_once 'footer.php'; ?>

    </div>
    <!-- FIM CONTENT WRAPPER -->
    </div>
    <!-- FIM PAGE WRAPPER -->


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

    <!-- REQUISITOS MÁSCARAS JS -->
    <!-- <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script> -->

</body>

</html>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

<!-- <script>
    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA DATA
    var datvalMask = ['99/99/9999', '99/99/9999'];
    var datval = document.querySelector('input[attrname=datval]');
    VMasker(datval).maskPattern(datvalMask[0]);
    datval.addEventListener('input', inputHandler.bind(undefined, datvalMask, 10), false);
</script> -->

<!-- AÇÃO DOS CHECKBOX -->
<script>
    // Marca todos os Checkbox, menos os disabled
    $("#checkTodos").click(function() {
        $('input:checkbox:not(:disabled)').not(this).prop('checked', this.checked);
    });

    // Habilita o botão excluir se tiver um checkbox marcado
    $("[name='checkbox[]']").click(function() {
        var cont = $(".checkbox:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
    $(".checkbox").click(function() {
        var cont = $(".checkbox:checked").length;
        var cont_total = $(".checkbox:not(:disabled)").length;
        var check_todos = cont == cont_total;
        $("#checkTodos").prop("checked", check_todos ? true : false);
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BOTÃO ENVIAR
    $(function() {
        $(document).on('click', '.btn-enviar', function() {

            var btn_enviar = 1;

            if (btn_enviar !== '') {

                dados = {

                    id_mur: $(this).attr('id-mur'),
                    situac: $(this).attr('situac'),

                    // Valida o click do botão
                    btn_enviar: btn_enviar
                };

                $.post('controller/mural_avisos_post.php', dados, function(retorno) {

                    // Se o retorno for igual a 1, dados foram atualizados com sucesso
                    if (retorno == 1) {

                        location.reload();
                    } else {

                        // Exibe uma mensagem de falha com o retorno do Catch
                        Swal.fire({
                            icon: 'error',
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

    // ABRIR MODAL
    $(function() {
        $(document).on('click', '.btn-modal', function() {

            var abrir_modal = $(this).attr('abrir-modal');

            $(abrir_modal).modal('show');
        });
    });

    // BOTÃO EXCLUIR
    $(function() {
        $(document).on('click', '#btn-excluir', function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja excluir esse(s) registro(s)?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_exc = 1;
                    var ids = [];

                    // Recebe os ids dos contatos marcados
                    $('.checkbox:not(:disabled):checked').each(function() {
                        ids.push($(this).val());
                    });

                    dados_exc = {

                        ids: ids,

                        btn_exc: btn_exc
                    };

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/mural_avisos_post.php', dados_exc, function(retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        if (retorno == 1) {

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Registro(s) excluido(s) com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            // Caso o contrario, nenhum contato foi selecionado
                        } else {

                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'error',
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
    });
</script>

<!-- AÇÕES NO MODAL -->
<script>
    // APAGA ALTERAÇÃO NO MODAL
    $(function() {
        $('#modal-incluir').on('hidden.bs.modal', function() {
            // Obtém as referências aos elementos do DOM
            var nav_etapa1 = $('#nav-etapa1');
            var nav_etapa2 = $('#nav-etapa2');
            var nav_etapa3 = $('#nav-etapa3');
            var etapa1 = $('#etapa1');
            var etapa2 = $('#etapa2');
            var etapa3 = $('#etapa3');

            // Verifica se a etapa atual é a etapa3
            if (nav_etapa3.hasClass('btn-primary')) {
                // Retorna à etapa1 e redefine as classes dos botões
                nav_etapa3.removeClass('btn-primary').addClass('btn-secondary');
                nav_etapa2.removeClass('btn-success').addClass('btn-secondary');
                nav_etapa1.removeClass('btn-success').addClass('btn-primary');
                etapa3.hide();
                etapa1.show();

                // Oculta o botão "Finalizar" e exibe o botão "Avançar"
                $('#btn-finalizar').hide();
                $('#btn-avancar').show();
            } else if (nav_etapa2.hasClass('btn-primary')) {
                // Caso contrário, verifica se a etapa atual é a etapa2
                // Retorna à etapa1 e redefine as classes dos botões
                nav_etapa2.removeClass('btn-primary').addClass('btn-secondary');
                nav_etapa1.removeClass('btn-success').addClass('btn-primary');
                etapa2.hide();
                etapa1.show();
            }

            // Limpa o formulário do modal
            $(this).find('form')[0].reset();
        });
    });

    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            $('.modal:visible').modal('hide');
        });
    });

    // SUBMIT INCLUIR AVISO
    $(function() {
        $('#modal-form').submit(function(e) {
            e.preventDefault(); // impede o envio do formulário por padrão

            // Valida o envio do form
            var btn_submit = 1;

            // cria um objeto FormData com os valores do formulário
            var formData = new FormData(this);
            formData.append('btn_submit', btn_submit);

            $.post({
                url: 'controller/mural_avisos_post.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(retorno) {

                    switch (retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        case '1':
                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Informação incluida com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            break;

                            // Se o retorno for igual a 0, mensagem e anexo não preenchidos
                        case '0':
                            // Exibe uma mensagem de falha
                            Swal.fire({
                                title: 'Atenção',
                                text: 'Preencha o campo mensagem ou selecione um anexo!',
                                icon: 'warning',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didClose: () => {
                                    return [
                                        $('#nav-etapa3').removeClass('btn-primary'),
                                        $('#nav-etapa3').addClass('btn-secondary'),
                                        $('#nav-etapa2').removeClass('btn-success'),
                                        $('#nav-etapa2').addClass('btn-primary'),
                                        $('#etapa3').hide(),
                                        $('#etapa2').show(),
                                        $('#btn-finalizar').hide(),
                                        $('#btn-avancar').show(),
                                        $("#inputMensagem").focus()
                                    ]
                                }
                            });
                            break;

                            // Se o retorno for igual a 2, os dados não foram preenchidos corretamente
                        case '2':
                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'Preencha o campo mensagem ou selecione um anexo!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });
                            break;

                            // Se o retorno for igual a 3, o anexo é maior que o maximo permitido (10MB)
                        case '3':
                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'O arquivo anexado é maior que o limite de 10MB!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });
                            break;

                            // Houve erro no try, retorna um SweetAlert com o erro exibido pelo catch
                        default:
                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'error',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });
                            break;

                    }
                }
            });
        });
    });

    $(function() {
        $(document).on('click', '.btn-sem-click', function(e) {

            e.preventDefault();
        });
    });

    $(function() {
        // Evento de input para o campo de Titulo
        $('#inputTitulo').on('input', function() {
            // Verifica se o valor do campo tem pelo menos 3 caracteres
            if ($('#inputTitulo').val().length >= 3) {
                // Verifica se a cor da borda do campo Titulo não está vazia
                if ($('#inputTitulo').css('border-color') !== '') {
                    // Remove a cor da borda do campo Titulo
                    $('#inputTitulo').css("border-color", "");
                }
            }
        });

        // Evento de input para o campo de id_dep
        $('#inputid_dep').on('input', function() {
            // Verifica se a cor da borda do campo id_dep não está vazia
            if ($('#inputid_dep').css('border-color') !== '') {
                // Remove a cor da borda do campo id_dep
                $('#inputid_dep').css("border-color", "");
            }
        });

        // Evento de input para o editor de texto tinymce
        tinymce.get('inputMensagem').on('input', function() {
            // Obter o elemento HTML do editor
            var editorElement = tinymce.get('inputMensagem').getElement();

            // Obter a cor da borda usando css('border-color')
            var borderColor = $(editorElement).css('border-color');

            // Verifica se a cor da borda não está vazia
            if (borderColor !== '') {
                // Remove a cor da borda do editor tinymce
                $('.tox-tinymce').css("border-color", "");
            }
        });
    });


    $(function() {
        $(document).on('click', '.btn-voltar', function() {

            if ($('#nav-etapa2').hasClass('btn-primary')) {

                $('#nav-etapa2').removeClass('btn-primary');
                $('#nav-etapa2').addClass('btn-secondary');
                $('#nav-etapa1').removeClass('btn-success');
                $('#nav-etapa1').addClass('btn-primary');
                $('#btn-voltar').removeClass('btn-voltar');
                $('#btn-voltar').addClass('close-modal');
                $('#etapa2').hide();
                $('#etapa1').show();
            } else if ($('#nav-etapa3').hasClass('btn-primary')) {

                $('#nav-etapa3').removeClass('btn-primary');
                $('#nav-etapa3').addClass('btn-secondary');
                $('#nav-etapa2').removeClass('btn-success');
                $('#nav-etapa2').addClass('btn-primary');
                $('#etapa3').hide();
                $('#etapa2').show();
                $('#btn-finalizar').hide();
                $('#btn-avancar').show();
            }
        });
    });

    $(function() {
        $(document).on('click', '#btn-avancar', function() {

            if ($('#nav-etapa1').hasClass('btn-primary')) {

                btn_avancar1 = 1;

                var dados1 = {

                    titulo: $('#inputTitulo').val(),
                    id_dep: $('#inputid_dep').val(),

                    btn_avancar1: btn_avancar1
                };

                $.post('controller/mural_avisos_post.php', dados1, function(retorno) {

                    switch (retorno) {

                        // Todos os Campos Preenchidos
                        case '1':
                            $('#nav-etapa1').removeClass('btn-primary');
                            $('#nav-etapa1').addClass('btn-success');
                            $('#nav-etapa2').removeClass('btn-secondary');
                            $('#nav-etapa2').addClass('btn-primary');
                            $('#btn-voltar').removeClass('close-modal');
                            $('#btn-voltar').addClass('btn-voltar');
                            $('#etapa1').hide();
                            $('#etapa2').show();
                            break;

                            // Titulo não preenchido
                        case '2':
                            Swal.fire({
                                title: 'Atenção',
                                text: 'Preencha todos os campos para concluir a ação',
                                icon: 'warning',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didClose: () => {
                                    return [
                                        $("#inputTitulo").focus()
                                    ]
                                }
                            });

                            $('#inputTitulo').css("border-color", "#e74a3b");
                            $('#inputid_dep').css("border-color", "");
                            break;

                            // Departamento não selecionado
                        case '3':
                            Swal.fire({
                                title: 'Atenção',
                                text: 'Preencha todos os campos para concluir a ação',
                                icon: 'warning',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didClose: () => {
                                    return [
                                        $("#inputid_dep").focus()
                                    ]
                                }
                            });
                            $('#inputid_dep').css("border-color", "#e74a3b");
                            $('#inputTitulo').css("border-color", "");
                            break;

                        case '0':
                            Swal.fire({
                                title: 'Atenção',
                                text: 'Preencha todos os campos para concluir a ação',
                                icon: 'warning',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didClose: () => {
                                    return [
                                        $("#inputTitulo").focus()
                                    ]
                                }
                            });
                            $('#inputTitulo').css("border-color", "#e74a3b");
                            $('#inputid_dep').css("border-color", "#e74a3b");
                            break;
                    }
                });

            } else if ($('#nav-etapa2').hasClass('btn-primary')) {

                $('#nav-etapa2').removeClass('btn-primary');
                $('#nav-etapa2').addClass('btn-success');
                $('#nav-etapa3').removeClass('btn-secondary');
                $('#nav-etapa3').addClass('btn-primary');
                $('#etapa2').hide();
                $('#etapa3').show();
                $('#btn-avancar').hide();
                $('#btn-finalizar').show();
            }

        });
    });

    // $(function() {
    //     // Acessa o objeto TinyMCE
    //     var editor = tinymce.get('inputMensagem');

    //     // Adiciona um evento de keyup para substituir o texto selecionado e impedir a digitação de caracteres excedentes
    //     editor.on('keyup', function(e) {
    //         var selection = editor.selection.getContent({
    //             format: 'text'
    //         }); // Obtém o texto selecionado
    //         var content = editor.getContent({
    //             format: 'text'
    //         }); // Obtém o conteúdo do TinyMCE sem as tags

    //         var maxLength = 5000; // Número máximo de caracteres permitidos

    //         if (selection.length > 0) {
    //             // Se houver texto selecionado, substitua-o pelo novo valor digitado
    //             var newValue = content.substring(0, editor.selection.getStart()) + editor.selection.getContent() + content.substring(editor.selection.getEnd());
    //             editor.setContent(newValue);
    //         } else if (content.length >= maxLength) {
    //             // Se não houver texto selecionado, verifique se o limite de caracteres foi atingido
    //             // Impede a digitação de mais caracteres
    //             e.preventDefault();
    //         }
    //     });



    //     // Adiciona um evento de paste para excluir caracteres excedentes ao colar um texto
    //     editor.on('paste', function(e) {
    //         var content = editor.getContent({
    //             format: 'text'
    //         }); // Obtém o conteúdo do TinyMCE sem as tags
    //         var maxLength = 5000; // Número máximo de caracteres permitidos
    //         var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain'); // Obtém o texto colado

    //         // Verifica se o texto colado excede o limite
    //         if (content.length + pastedText.length > maxLength) {
    //             // Remove os caracteres excedentes do texto colado
    //             var newContent = (content + pastedText).substring(0, maxLength);
    //             editor.setContent(newContent); // Define o novo conteúdo
    //             e.preventDefault(); // Impede a colagem de mais caracteres
    //         }
    //     });
    // });
</script>