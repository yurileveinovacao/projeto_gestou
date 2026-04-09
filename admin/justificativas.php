<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util2.php";

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

    <title>GESTOU PORTAL - Justificativas</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<!-- DEFINE A COR DAS BORDAS DA TABLE -->
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
                        <h6 class="m-0 font-weight-bold text-primary">Justificativas</h6>
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
                                    </div>

                                    <!-- CABEÇALHO TABLE -->
                                    <tr>
                                        <th data-orderable="false">Data</th>
                                        <th data-orderable="false">Colaborador</th>
                                        <th data-orderable="false">Tipo</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Status</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="20%">Ações</th>
                                    </tr>
                                </thead>

                                <!-- TFOOT -->
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th>Data</th>
                                        <th>Colaborador</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <!-- INICIO TBODY -->
                                <tbody class="texto-table-body linhas">

                                    <?php

                                    $tipos_label = array(
                                        'ausencia_ponto' => 'Ausência de Ponto',
                                        'falta' => 'Falta',
                                        'falta_atestado' => 'Falta com Atestado'
                                    );

                                    foreach (selectJustificativas_empresa($id_emp_default) as $linha) {

                                        if ($linha != 0) {

                                            $tipo_formatado = isset($tipos_label[$linha['tipo']]) ? $tipos_label[$linha['tipo']] : $linha['tipo'];
                                            $data_criacao = new DateTime($linha['criado_em']);

                                    ?>

                                            <tr style="vertical-align: middle;" class="linha-table">

                                                <!-- DATA -->
                                                <td style="text-align: center;">
                                                    <span class="font-weight-bold">
                                                        <?php echo $data_criacao->format("d/m/Y"); ?>
                                                    </span>
                                                </td>

                                                <!-- COLABORADOR -->
                                                <td>
                                                    <?php echo htmlspecialchars($linha["colaborador_nome"]); ?>
                                                </td>

                                                <!-- TIPO -->
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text">
                                                        <?php echo $tipo_formatado; ?>
                                                    </span>
                                                </td>

                                                <!-- STATUS -->
                                                <td style="text-align:center">

                                                    <?php if ($linha['status'] == 'pendente') { ?>

                                                        <div class="btn btn-warning btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">PENDENTE</span>
                                                        </div>

                                                    <?php } elseif ($linha['status'] == 'aprovada') { ?>

                                                        <div class="btn btn-success btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="far fa-check-circle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">APROVADA</span>
                                                        </div>

                                                    <?php } else { ?>

                                                        <div class="btn btn-danger btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="far fa-times-circle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">REPROVADA</span>
                                                        </div>

                                                    <?php } ?>

                                                </td>

                                                <!-- AÇÕES -->
                                                <td style="text-align:center">

                                                    <button type="button" class="btn btn-outline-primary btn-visualizar-just" id-justificativa="<?php echo $linha["id"]; ?>" title="Visualizar">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <?php if ($linha['status'] == 'pendente') { ?>

                                                        <button type="button" class="btn btn-outline-success btn-aprovar-just" id-justificativa="<?php echo $linha["id"]; ?>" title="Aprovar">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-outline-danger btn-reprovar-just" id-justificativa="<?php echo $linha["id"]; ?>" title="Reprovar">
                                                            <i class="fas fa-times"></i>
                                                        </button>

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
                        <div class="modal fade modal-mensagem" id="modal-visualizar" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px; margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 100vh;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Visualizar Justificativa</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modal-visualizar-body" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                                        <!-- PREENCHIDO PELO PHP -->
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Aprovar -->
                        <div class="modal fade modal-mensagem" id="modal-aprovar" tabindex="-1" role="dialog" aria-labelledby="Aprovar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Aprovar Justificativa</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="form-aprovar">
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta_aprovar" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA (OPCIONAL):</label>
                                                        <textarea class="form-control" id="resposta_aprovar" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit">Aprovar</button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Reprovar -->
                        <div class="modal fade modal-mensagem" id="modal-reprovar" tabindex="-1" role="dialog" aria-labelledby="Reprovar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reprovar Justificativa</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="form-reprovar">
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta_reprovar" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA (OPCIONAL):</label>
                                                        <textarea class="form-control" id="resposta_reprovar" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" type="submit">Reprovar</button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
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
        });

        // CLOSE MODAL
        $(document).on('click', '.close-modal', function() {
            $('.modal').modal('hide');
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

    // VISUALIZAR JUSTIFICATIVA
    $(function() {
        $(document).on('click', '.btn-visualizar-just', function() {

            var btn_visualizar = 1;
            var id_justificativa = $(this).attr('id-justificativa');

            if (btn_visualizar !== '') {

                var dados = {
                    id_justificativa: id_justificativa,
                    btn_visualizar: btn_visualizar
                };

                $.post('controller/justificativas_post.php', dados, function(retorno) {

                    $('#modal-visualizar-body').html(retorno);
                    $('#modal-visualizar').modal('show');
                });
            }
        });
    });

    // ABRIR MODAL APROVAR
    $(function() {
        $(document).on('click', '.btn-aprovar-just', function() {

            var id_justificativa = $(this).attr('id-justificativa');

            // Salva o id na sessão via post
            var dados = {
                id_justificativa: id_justificativa,
                btn_visualizar: 1
            };

            $.post('controller/justificativas_post.php', dados, function(retorno) {
                $('#modal-aprovar').modal('show');
            });
        });
    });

    // ABRIR MODAL REPROVAR
    $(function() {
        $(document).on('click', '.btn-reprovar-just', function() {

            var id_justificativa = $(this).attr('id-justificativa');

            // Salva o id na sessão via post
            var dados = {
                id_justificativa: id_justificativa,
                btn_visualizar: 1
            };

            $.post('controller/justificativas_post.php', dados, function(retorno) {
                $('#modal-reprovar').modal('show');
            });
        });
    });

    // SUBMIT APROVAR
    $(function() {
        $('#form-aprovar').submit(function(e) {
            e.preventDefault();

            var btn_aprovar = 1;

            if (btn_aprovar !== '') {

                var dados = {
                    resposta: $('#resposta_aprovar').val(),
                    btn_aprovar: btn_aprovar
                };

                $.post('controller/justificativas_post.php', dados, function(retorno) {

                    if (retorno == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Justificativa aprovada com sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
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
            }
        });
    });

    // SUBMIT REPROVAR
    $(function() {
        $('#form-reprovar').submit(function(e) {
            e.preventDefault();

            var btn_reprovar = 1;

            if (btn_reprovar !== '') {

                var dados = {
                    resposta: $('#resposta_reprovar').val(),
                    btn_reprovar: btn_reprovar
                };

                $.post('controller/justificativas_post.php', dados, function(retorno) {

                    if (retorno == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Justificativa reprovada com sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
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
            }
        });
    });
</script>
