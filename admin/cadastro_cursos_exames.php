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

    <title>GESTOU PORTAL - Cursos e Exames</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                        <h6 class="m-0 font-weight-bold text-primary">Cadastro Cursos E Exames</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">

                                    <div class="col-sm-12 button-tabela">

                                        <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button></a>
                                        <button type="button" id="btn-excluir" name="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" disabled><i class="fas fa-trash-alt"></i> Excluir</button>

                                    </div>

                                    <tr>
                                        <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox">
                                            <input id="checkTodos" type="checkbox" name="checkbox[]"></input>
                                        </th>
                                        <th data-orderable="false">Descrição</th>
                                        <th data-orderable="false">Período</th>
                                        <th data-orderable="false">Carência de Aviso</th>
                                        <th data-orderable="false">Data de Inclusão</th>
                                        <th data-orderable="false" width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th></th>
                                        <th>Descrição</th>
                                        <th>Período</th>
                                        <th>Carência de Aviso</th>
                                        <th>Data de Inclusão</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php foreach (selectGESCUR($id_emp_default) as $linha) {

                                        if (!empty($linha)) { ?>

                                            <tr>
                                                <!-- CHECKBOX -->
                                                <td class="coluna-checkbox">
                                                    <?php if ($linha['situac'] == 1) { ?>

                                                        <input type="checkbox" disabled></input>
                                                    <?php } else { ?>

                                                        <input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $linha['id_cur']; ?>"></input>
                                                    <?php } ?>
                                                </td>

                                                <!-- NOME -->
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text">
                                                        <?php echo $linha['descri']; ?>
                                                    </span>
                                                </td>

                                                <!-- PERIODO EM DIAS -->
                                                <td style="text-align: center;">
                                                    <?php echo $linha['period'] . ' dias'; ?>
                                                </td>

                                                <!-- CARÊNCIA DE AVISO EM DIAS -->
                                                <td style="text-align: center;">
                                                    <?php echo $linha['caravi'] . ' dias'; ?>
                                                </td>

                                                <!-- DATA DE INCLUSÃO -->
                                                <td style="text-align: center;">
                                                    <?php $data_inclusao = new DateTime($linha['datinc']);
                                                    echo $data_inclusao->format('d/m/Y'); ?>
                                                </td>

                                                <td class="content-xy-center">
                                                    <!-- INICIO SITUACAO -->
                                                    <div class="div-acoes">
                                                        <div class="cursor-pointer" id="situac" situac="<?php echo $linha['situac']; ?>" id_cur="<?php echo $linha['id_cur']; ?>">
                                                            <?php if ($linha['situac'] == 1) { ?>

                                                                <span class="text-success"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>
                                                            <?php } else if ($linha['situac'] == 0) { ?>

                                                                <span class="text-danger"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <!-- INICIO EDITAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" id="btn-editar" id_cur="<?php echo $linha['id_cur']; ?>" class="btn btn-primary btn-icones" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
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

                        <!-- MODAL Incluir -->
                        <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Justificativa" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Incluir Cursos/Exames</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-modal-incluir">
                                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="descricao">Descrição</label>
                                                        <input type="text" name="descricao" id="descricao" style="text-transform:uppercase" class="form-control" minlength="3" maxlength="255" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="tipo">Tipo:</label>
                                                        <select name="tipo" class="form-control" id="tipo" required>
                                                            <option value="">Escolha um tipo</option>
                                                            <option value="C">Curso</option>
                                                            <option value="E">Exame</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="local">Local:</label>
                                                        <select name="local" class="form-control" id="local" required>
                                                            <option value="">Escolha um local</option>
                                                            <option value="1">Externo</option>
                                                            <option value="0">Interno</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="periodo">Período (dias):</label>
                                                        <input type="text" id="periodo" name="periodo" class="form-control" placeholder="Duração do Curso/Exame" oninput="this.value = this.value.replace(/\D/g, '')" maxlength="4" required>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="carencia">Carência de Aviso (dias):</label>
                                                        <input type="text" id="carencia" name="carencia" class="form-control" placeholder="Prazo do aviso antes de vencer" oninput="this.value = this.value.replace(/\D/g, '')" maxlength="4">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="painel" id="painel">
                                                            <label class="custom-control-label" for="painel" style="user-select: none;">Não exibir no painel</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-plus-circle"></i> Incluir
                                            </button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL Editar -->
                        <div class="modal fade" id="modal-editar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-editar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Cursos/Exames</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-modal-editar">
                                        <div class="modal-body" id="modal-body-editar" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="submit-editar" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-plus-circle"></i> Salvar
                                            </button>
                                            <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                        </div>
                                    </form>
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
    <script src="vendor/jquery/jquery.min.js"></script>
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
    $('#dataTable').DataTable({
        autoWidth: true,
        "stateSave": true,
        "stateDuration": 0,
        "aaSorting": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    });
</script>

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

    // APAGA ALTERAÇÃO NO MODAL
    $(function() {
        $('#modal-incluir').on('hidden.bs.modal', function() {

            $(this).find('form')[0].reset();
            $('input[required]').css('border-color', '');
            $('select[required]').css('border-color', '');
        });
    });

    // APAGA ALTERAÇÃO NO MODAL
    $(function() {
        $('#modal-editar').on('hidden.bs.modal', function() {

            $(this).find('form')[0].reset();
            $('input[required]').css('border-color', '');
            $('select[required]').css('border-color', '');
        });
    });
</script>

<!-- AÇÕES NO BLUR -->
<script>
    $('input[required]').on('blur', function() {
        // Obtém o valor do campo
        var inputValue = $(this).val();

        // Se o valor do campo estiver vazio
        if (inputValue === '') {

            $(this).css('border-color', 'red');
        }
    });

    $('input[required]').on('focus', function() {

        $(this).css('border-color', '');
    });

    $('select[required]').on('blur', function() {
        // Obtém o valor do campo
        var selectValue = $(this).val();

        // Se o valor do campo estiver vazio
        if (selectValue === '') {

            $(this).css('border-color', 'red');
        }
    });

    $('select[required]').on('focus', function() {

        $(this).css('border-color', '');
    });

    $('#periodo').on('blur', function() {

        var periodValue = $(this).val();

        if (periodValue === '0' || periodValue === '') {

            $(this).css('border-color', 'red');
        } else {

            $(this).css('border-color', '');
        }
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // FOCA NO INPUT DESCRICAO AO ABRIR O MODAL
    $('#modal-incluir').on('shown.bs.modal', function() {
        // Seleciona o elemento input do campo "descricao"
        const inputModal = document.getElementById('descricao');

        // Define o foco para o elemento input
        inputModal.focus();
    });

    // FOCA NO INPUT DESCRICAO AO ABRIR O MODAL
    $('#modal-editar').on('shown.bs.modal', function() {
        // Seleciona o elemento input do campo "descricao_editar"
        const inputModal = document.getElementById('descricao_editar');

        // Define o foco para o elemento input
        inputModal.focus();
    });

    // ALTERAR SITUAÇÃO
    $(function() {
        $(document).on('click', '#situac', function() {

            var btn_situac = 1;

            if (btn_situac !== '') {

                var dados = {
                    // Recebe os valores de situação
                    id_cur: $(this).attr('id_cur'),
                    situac_update: $(this).attr('situac'),

                    // Valida a mudança de situação
                    btn_situac: btn_situac
                };

                $.post('controller/cadastro_cursos_exames_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            location.reload();
                            break;

                        default:
                            $(this).mensagem_alert(retorno);
                            break
                    }
                });
            }
        });
    });

    // BOTÃO INCLUIR
    $(function() {
        $(document).on('click', '#btn-incluir', function() {

            $('#modal-incluir').modal('show');
        });
    });

    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            $('.modal:visible').modal('hide');
        });
    });

    // BOTÃO EDITAR
    // Função executada quando o botão de editar é clicado
    $(function() {
        $(document).on('click', '#btn-editar', function() {

            // Define a variável btn_editar como 1
            var btn_editar = 1;
            var id_cur = $(this).attr('id_cur');

            if (btn_editar !== '') {

                // Cria um objeto com os dados a serem enviados via POST
                var dados = {
                    id_cur: id_cur,
                    btn_editar: btn_editar
                };

                // Envia uma requisição POST para o arquivo 'cadastro_cursos_exames_post.php'
                // passando os dados como parâmetro
                $.post('controller/cadastro_cursos_exames_post.php', dados, function(retorno) {

                    // Insere o retorno da requisição no elemento com o id 'modal-body-editar'
                    $('#modal-body-editar').html(retorno);

                    // Exibe o modal com o id 'modal-editar'
                    $('#modal-editar').modal('show');

                    $('#submit-editar').attr('id_cur', id_cur);
                });
            }
        });
    });


    // BOTÃO EXCLUIR
    $(function() {
        $(document).on('click', '#btn-excluir', function() {

            // Se o usuario realmente quiser excluir o contato
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
                    var ids = $('.checkbox:not(:disabled):checked').map(function() {
                        return this.value;
                    }).get();

                    dados_exc = {
                        ids: ids,
                        btn_exc: btn_exc
                    };

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/cadastro_cursos_exames_post.php', dados_exc, function(retorno) {

                        switch (retorno) {
                            case '0':
                                // Chama o plugin 'mensagem_alerta' com o caso 'NENHUM_ID'
                                $(this).mensagem_alerta('NENHUM_ID');
                                break;

                            case '1':
                                // Chama o plugin 'mensagem_alerta' com o caso 'EXCLUIR_SUCESSO'
                                $(this).mensagem_alerta('EXCLUIR_SUCESSO');
                                break;

                            case '2':
                                // Chama o plugin 'mensagem_alerta' com o caso 'EXCLUIR_ERRO_VINCULO'
                                $(this).mensagem_alerta('EXCLUIR_ERRO_VINCULO');
                                break;

                            default:
                                // Chama o plugin 'mensagem_alerta' com o caso DEFAULT
                                $(this).mensagem_alerta(retorno);
                                break;
                        }
                    });
                }
            });

        });
    });
</script>

<!-- SUBMIT -->
<script>
    // SUBMIT INCLUIR
    $(function() {
        // Manipula o evento de envio do formulário com id "form-modal-incluir"
        $("#form-modal-incluir").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_submit = 1;

            if ($('#painel').prop('checked')) {

                var painel = 1;
            } else {

                var painel = 0;
            }

            if (btn_submit !== '') {
                // Obtém os dados do formulário
                var dados = {
                    descricao: $('#descricao').val(),
                    tipo: $('#tipo').val(),
                    local: $('#local').val(),
                    periodo: $('#periodo').val(),
                    carencia: $('#carencia').val(),
                    painel: painel,

                    // Valida o Submit
                    btn_submit: btn_submit
                };

                // Envia uma requisição POST para o arquivo "controller/cadastro_cursos_exames_post.php" com os dados do formulário
                $.post('controller/cadastro_cursos_exames_post.php', dados, function(retorno) {
                    switch (retorno) {
                        case '0':
                            // Chama o plugin 'mensagem_alerta' com o caso 'PREENCHIMENTO'
                            $(this).mensagem_alerta('PREENCHIMENTO');
                            break;

                        case '1':
                            // Chama o plugin 'mensagem_alerta' com o caso 'INCLUIR_SUCESSO'
                            $(this).mensagem_alerta('INCLUIR_SUCESSO');
                            break;

                        case '2':
                            // Chama o plugin 'mensagem_alerta' com o caso 'INCLUIR_PERIODO_INVALIDO'
                            $(this).mensagem_alerta('INCLUIR_PERIODO_INVALIDO');
                            break;

                        case '3':
                            // Chama o plugin 'mensagem_alerta' com o caso 'INCLIUR_CARENCIA_MAIOR_PERIODO'
                            $(this).mensagem_alerta('INCLIUR_CARENCIA_MAIOR_PERIODO');
                            break;

                        default:
                            // Chama o plugin 'mensagem_alerta' com o caso DEFAULT
                            $(this).mensagem_alerta(retorno);
                            break;
                    }
                });
            }
        });
    });


    // SUBMIT EDITAR
    $(function() {
        // Manipula o evento de envio do formulário com id "form-modal-editar"
        $("#form-modal-editar").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_submit_editar = 1;

            if ($('#painel_editar').prop('checked')) {

                var painel = 1;
            } else {

                var painel = 0;
            }

            if (btn_submit_editar !== '') {
                // Obtém os dados do formulário
                var dados = {
                    descricao: $('#descricao_editar').val(),
                    tipo: $('#tipo_editar').val(),
                    local: $('#local_editar').val(),
                    periodo: $('#periodo_editar').val(),
                    carencia: $('#carencia_editar').val(),
                    id_cur: $('#submit-editar').attr('id_cur'),
                    painel: painel,

                    // Valida o Submit Editar
                    btn_submit_editar: btn_submit_editar
                };

                // Envia uma requisição POST para o arquivo "controller/cadastro_cursos_exames_post.php" com os dados do formulário
                $.post('controller/cadastro_cursos_exames_post.php', dados, function(retorno) {
                    switch (retorno) {
                        case '0':
                            // Chama o plugin 'mensagem_alerta' com o caso 'PREENCHIMENTO'
                            $(this).mensagem_alerta('PREENCHIMENTO');
                            break;

                        case '1':
                            // Chama o plugin 'mensagem_alerta' com o caso 'EDITAR_SUCESSO'
                            $(this).mensagem_alerta('EDITAR_SUCESSO');
                            break;

                        case '2':
                            // Chama o plugin 'mensagem_alerta' com o caso 'EDITAR_PERIODO_INVALIDO'
                            $(this).mensagem_alerta('EDITAR_PERIODO_INVALIDO');
                            break;

                        case '3':
                            // Chama o plugin 'mensagem_alerta' com o caso 'EDITAR_CARENCIA_MAIOR_PERIODO'
                            $(this).mensagem_alerta('EDITAR_CARENCIA_MAIOR_PERIODO');
                            break;

                        default:
                            // Chama o plugin 'mensagem_alerta' com o caso DEFAULT
                            $(this).mensagem_alerta(retorno);
                            break;
                    }
                });
            }
        });
    });
</script>

<!-- FUNÇÃO SWEETALERT -->
<script>
    $(function() {
        // Cria um novo plugin jQuery chamado 'mensagem_alerta'
        $.fn.mensagem_alerta = function(caseValue) {
            // Utiliza um switch para lidar com diferentes valores de caso
            switch (caseValue) {
                case 'INCLUIR_SUCESSO':
                    // Mostra um alerta de sucesso usando o Swal.fire
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Curso/Exame incluído com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;

                case 'INCLUIR_PERIODO_INVALIDO':
                    // Mostra um alerta de aviso para um período inválido
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'O período deve ser maior que 0 dias!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Define a cor da borda do elemento 'periodo' como vermelho e foca nele
                                $('#periodo').css('border-color', 'red').focus()
                            ]
                        }
                    });
                    break;

                case 'INCLIUR_CARENCIA_MAIOR_PERIODO':
                    // Mostra um alerta de aviso para um valor 'carencia' maior que o valor 'periodo'
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'O período deve ser maior que a carência!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Foca no elemento 'carencia'
                                $('#carencia').focus()
                            ]
                        }
                    });
                    break;

                case 'EDITAR_SUCESSO':
                    // Mostra um alerta de sucesso para a edição bem-sucedida do curso/exame
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Curso/Exame alterado com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;

                case 'EDITAR_PERIODO_INVALIDO':
                    // Mostra um alerta de aviso para um período inválido durante a edição
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'O período deve ser maior que 0 dias!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Define a cor da borda do elemento 'periodo_editar' como vermelho e foca nele
                                $('#periodo_editar').css('border-color', 'red').focus()
                            ]
                        }
                    });
                    break;

                case 'EDITAR_CARENCIA_MAIOR_PERIODO':
                    // Mostra um alerta de aviso para um valor 'carencia' maior que o valor 'periodo' durante a edição
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'O período deve ser maior que a carência!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Foca no elemento 'carencia_editar'
                                $('#carencia_editar').focus()
                            ]
                        }
                    });
                    break;

                case 'PREENCHIMENTO':
                    // Mostra um alerta de aviso para campos de formulário incompletos
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Preencha todos os campos para concluir a ação!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Fecha o alerta se o usuário confirmar
                            swal.close();
                        }
                    });
                    break;

                case 'NENHUM_ID':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Nenhum registro selecionado para exclusão',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Fecha o alerta se o usuário confirmar
                            swal.close();
                        }
                    });
                    break;

                case 'EXCLUIR_SUCESSO':
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        title: 'Sucesso!',
                        text: 'Registro(s) excluido(s) com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    break;

                case 'EXCLUIR_ERRO_VINCULO':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention!',
                        title: 'Atenção!',
                        text: 'O registro não pode ser excluido, pois possui referência em outra tabela.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
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