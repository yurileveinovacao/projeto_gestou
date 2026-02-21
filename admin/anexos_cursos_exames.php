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

    <title>GESTOU PORTAL - Cursos e Exames</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>


    <!-- 
        INICIO CSS FILE INPUT
    -->

    <link rel="stylesheet" href="vendor/kartik-v/bootstrap-fileinput/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <link href="vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>

    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>

    <script src="vendor/kartik-v/bootstrap-fileinput/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script>

    <script src="vendor/kartik-v/bootstrap-fileinput/js/locales/LANG.js"></script>

    <!-- 
        FIM CSS FILE INPUT
    -->

    <script src="js/sorttable.js"></script>

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
        <?php include_once 'menu_lateral.php'; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Anexo Cursos E Exames</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <?php if (isset($_SESSION['id_lcm_anexo'])) {

                            $id_lcm_anexo = $_SESSION['id_lcm_anexo'];
                        } else {

                            echo "
                                <script>
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Info',
                                        title: 'Atenção!',
                                        text: 'Nenhum lançamento selecionado!'
                                    }).then((result) => {
                                        location.href = 'lancamento_cursos_exames';
                                    });
                                </script>
                            ";
                        } ?>

                        <div class="col-sm-12 button-tabela">
                            <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma">
                                <i class="fas fa-plus-circle"></i> Incluir
                            </button>
                            <button type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" disabled>
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                            <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma">
                                <i class="fas fa-sign-out-alt"></i> Voltar
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable bootstrapmin-nao-aplicar-classe" width="100%" cellspacing="0">
                                <thead style="text-align: center;" class="bootstrapmin-nao-aplicar-classe">
                                    <tr>
                                        <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox">
                                            <input id="checkTodos" type="checkbox" name="checkbox[]"></input>
                                        </th>
                                        <th data-orderable="false">Anexo</th>
                                        <th data-orderable="false" width="20%">Data de Inclusão</th>
                                        <th data-orderable="false" width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot style="text-align: center;" class="bootstrapmin-nao-aplicar-classe">
                                    <tr>
                                        <th></th>
                                        <th>Anexo</th>
                                        <th>Data de Inclusão</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php foreach (selectGESANE($id_lcm_anexo) as $linha) {

                                        if (!empty($linha)) {

                                            $id_ane = $linha['id_ane'];
                                            $anexo = preg_replace('/^\d+\_|\.\w+/', '', $linha['anexo']);
                                            $datinc = new DateTime($linha['datinc']);
                                    ?>

                                            <tr class="align-middle">
                                                <!-- CHECKBOX -->
                                                <td class="coluna-checkbox">

                                                    <input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $id_ane; ?>"></input>
                                                </td>

                                                <!-- ANEXO -->
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text">
                                                        <?php echo mb_strtoupper($anexo, 'UTF-8'); ?>
                                                    </span>
                                                </td>


                                                <!-- DATA DE INCLUSÃO -->
                                                <td style="text-align: center;">
                                                    <?php echo $datinc->format('d/m/Y'); ?>
                                                </td>

                                                <!-- AÇÕES -->
                                                <td class="content-xy-center">

                                                    <!-- VISUALIZAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" id_ane="<?php echo $id_ane; ?>" class="btn btn-primary btn-icones btn-visualizar" title="Visualizar">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>

                                                </td>

                                            </tr>

                                    <?php }
                                    } ?>
                                    <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                </tbody>
                            </table>
                            <!-- FIM TBODY E TABLE -->
                        </div>
                        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
                        <!-- --------------------------------------------------- INICIO MODAIS -------------------------------------------------------------------- -->
                        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->


                        <!-- MODAL INCLUIR -->
                        <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-incluir" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Incluir Anexo</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-modal-incluir">
                                        <div class="modal-body" id="modal-body-incluir" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                            <div class="row" style="width: auto;">
                                                <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-plus-circle"></i> Salvar
                                            </button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL VISUALIZAR -->
                        <div class="modal fade" id="modal-visu" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-visu" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Visualizar Anexo</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modal-body-visu" style="height: 70vh;">
                                        <object id="exibe-pdf" type="application/pdf" width="100%" height="100%"></object>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
                        <!-- ------------------------------------------------------ FIM MODAIS -------------------------------------------------------------------- -->
                        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

                    </div>
                    <!-- FIM CARD BODY -->

                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- FOOTER -->
        <?php include_once "footer.php"; ?>

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

    <!-- REQUISITOS MÁSCARAS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>

<!-- 
    APLICA EFEITO DE PAGINAS A TABELA
-->
<script>
    $('#dataTable').DataTable({
        autoWidth: true,
        "aaSorting": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    });
</script>

<!--
    MASCARAS
-->
<script>
    $(document).ready(function() {

        $('#referencia').mask('00/00/0000');
        $('#vencimento').mask('00/00/0000');
    });
</script>

<!--
    AÇÃO DOS CHECKBOX
-->
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

<!-- 
    AÇÕES NO CLICK
-->
<script>
    // BTN VOLTAR
    $(function() {
        $('#btn-voltar').click(function() {

            // Define uma variável para indicar o clique no botão 'Voltar'
            var btn_voltar = 1;

            var dados = {
                // Cria um objeto com a propriedade 'btn_voltar' e seu valor
                btn_voltar: btn_voltar
            };

            // Envia uma solicitação POST para o arquivo PHP 'anexos_cursos_exames_post.php' com os dados
            $.post('controller/anexos_cursos_exames_post.php', dados, function() {

                // Redireciona para a página 'lancamento_cursos_exames'
                location.href = 'lancamento_cursos_exames';
            });
        });
    });

    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            // Oculta o modal visível ao clicar no elemento com a classe 'close-modal'
            $('.modal:visible').modal('hide');
        });
    });

    // BTN INCLUIR
    $(function() {
        $('#btn-incluir').click(function() {

            $('#modal-incluir').modal('show');
        });
    });

    $(function() {
        $('.btn-visualizar').click(function() {

            var btn_visualizar = 1;

            var dados = {
                id_ane: $(this).attr('id_ane'),
                btn_visualizar: btn_visualizar
            };

            $.post('controller/anexos_cursos_exames_post.php', dados, function(retorno) {

                $('#exibe-pdf').attr('data', retorno);
                $('#modal-visu').modal('show');
            });
        });
    });

    // BTN EXCLUIR
    $(function() {
        $(document).on('click', '#btn-excluir', function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja excluir o(s) registro(s)?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_excluir = 1;

                    var selecionados = $('.checkbox:not(:disabled):checked').map(function() {
                        return this.value;
                    }).get();

                    var dados = {
                        selecionados: selecionados,
                        btn_excluir: btn_excluir
                    };

                    $.post('controller/anexos_cursos_exames_post.php', dados, function(retorno) {

                        switch (retorno) {

                            case '0':
                                $(this).mensagem_alerta('ERRO_DELETE');
                                break;

                            case '1':
                                $(this).mensagem_alerta('SUCESSO_DELETE');
                                break;

                            default:
                                $(this).mensagem_alerta(retorno);
                                break;
                        }
                    });

                }
            });
        });
    });
</script>

<!-- 
    SUBMIT
-->
<script>
    $(function() {
        $('#form-modal-incluir').submit(function(event) {

            event.preventDefault();

            var btn_submit = 1;

            var formData = new FormData(this);
            formData.append('btn_submit', btn_submit);

            $.post({
                url: 'controller/anexos_cursos_exames_post.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(retorno) {

                    switch (retorno) {

                        case '0':
                            $(this).mensagem_alerta('ANEXO_VAZIO');
                            break;

                        case '1':
                            $(this).mensagem_alerta('SUCESSO');
                            break;

                        case '2':
                            $(this).mensagem_alerta('LIMITE_ANEXO_ULTRAPASSADO');
                            break;

                        default:
                            $(this).mensagem_alerta(retorno);
                            break;
                    }
                }
            });
        });
    });
</script>

<!--
    FUNÇÃO SWEETALERT
-->
<script>
    $(function() {
        // Cria um novo plugin jQuery chamado 'mensagem_alerta'
        $.fn.mensagem_alerta = function(caseValue) {
            // Utiliza um switch para lidar com diferentes valores de caso
            switch (caseValue) {
                case 'SUCESSO':
                    // Mostra um alerta de sucesso usando o Swal.fire
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        title: 'Sucesso!',
                        text: 'Anexo incluído com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;

                case 'ANEXO_VAZIO':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention!',
                        title: 'Atenção!',
                        text: 'Selecione um anexo para continuar!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                    break;

                case 'LIMITE_ANEXO_ULTRAPASSADO':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention!',
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

                case 'ERRO_DELETE':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention!',
                        title: 'Atenção!',
                        text: 'Nenhum registro selecionado!',
                        closeOnClickOutside: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                    break;

                case 'SUCESSO_DELETE':
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        title: 'Sucesso!',
                        text: 'Registro(s) excluido(s) com sucesso!',
                        closeOnClickOutside: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    break;

                default:
                    // Mostra um alerta de erro e fornece uma mensagem para entrar em contato com o suporte
                    Swal.fire({
                        icon: 'error',
                        title: 'Please contact support.',
                        title: 'Favor entrar em contato com o suporte.',
                        html: caseValue
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;
            }

            // Retorna 'this' para manter a encadeabilidade
            return this;
        };
    });
</script>