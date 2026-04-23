<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

if (isset($_SESSION['id_lcm_anexo'])) {

    unset($_SESSION['id_lcm_anexo']);
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

    <title>GESTOU PORTAL - Cursos e Exames</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        <h6 class="m-0 font-weight-bold text-primary">Lançamento Cursos E Exames</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">

                                    <div class="col-sm-12 button-tabela">
                                        <button type="button" id="btn-lancar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Lançar</button>
                                        <button type="button" id="btn-cancelar" name="btn-cancelar" class="btn btn-organograma btn-icon-split-organograma" disabled><i class="fas fa-ban"></i> Cancelar</button>
                                    </div>

                                    <tr>
                                        <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox">
                                            <input id="checkTodos" type="checkbox" name="checkbox[]"></input>
                                        </th>
                                        <th data-orderable="false">Curso/Exame</th>
                                        <th data-orderable="false">Colaborador</th>
                                        <th data-orderable="false">Referência</th>
                                        <th data-orderable="false">Vencimento</th>
                                        <th data-orderable="false">Situação</th>
                                        <th data-orderable="false" width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th></th>
                                        <th>Curso/Exame</th>
                                        <th>Colaborador</th>
                                        <th>Referência</th>
                                        <th>Vencimento</th>
                                        <th>Situação</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php foreach (selectGESLCM($id_emp_default) as $linha) {

                                        if (!empty($linha)) {

                                            $id_lcm = $linha['id_lcm'];
                                            $titulo = $linha['titulo'];
                                            $colaborador = $linha['colaborador'];
                                            $data_referencia = new DateTime($linha['datref']);
                                            $data_vencimento = new DateTime($linha['prodat']);

                                            if ($linha['situac'] == 1) {

                                                $situac = 'Cancelado';
                                            } else {

                                                $situac = 'Cadastrado';
                                            }

                                    ?>

                                            <tr>
                                                <!-- CHECKBOX -->
                                                <td class="coluna-checkbox">

                                                    <?php if ($linha['situac'] == 1) { ?>

                                                        <input type="checkbox" class="checkbox" name="checkbox[]" disabled></input>
                                                    <?php } else { ?>

                                                        <input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $id_lcm; ?>"></input>
                                                    <?php } ?>
                                                </td>

                                                <!-- CURSO/EXAME -->
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text">
                                                        <?php echo $titulo; ?>
                                                    </span>
                                                </td>


                                                <!-- COLABORADOR -->
                                                <td>
                                                    <?php echo $colaborador; ?>
                                                </td>

                                                <!-- DATA DE REFERENCIA -->
                                                <td style="text-align: center;">
                                                    <?php echo $data_referencia->format('d/m/Y'); ?>
                                                </td>

                                                <!-- DATA DE VENCIMENTO -->
                                                <td style="text-align: center;">
                                                    <?php echo $data_vencimento->format('d/m/Y'); ?>
                                                </td>

                                                <!-- SITUAÇÃO -->
                                                <td style="text-align: center;">
                                                    <?php echo $situac; ?>
                                                </td>

                                                <!-- AÇÕES -->
                                                <td class="content-xy-center">

                                                    <!-- EDITAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" id_lcm="<?php echo $id_lcm; ?>" class="btn btn-primary btn-icones btn-editar" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    </div>

                                                    <!-- ANEXO -->
                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-primary btn-icones btn-anexo" id_lcm="<?php echo $id_lcm; ?>" title="Anexos">
                                                            <i class="fas fa-file-pdf"></i>
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

                        <!-- MODAL Lançar -->
                        <div class="modal fade" id="modal-lancar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-lancar" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Lançar Cursos/Exames</h5>
                                        <button class="close close-modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-modal-lancar">
                                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                            <div class="col-md-12">

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="colab">Colaborador:</label>
                                                        <select name="colab" class="form-control" id="colab" required>
                                                            <option value="">Escolha um colaborador</option>

                                                            <?php foreach (selectGESUSU_emp($id_emp_default) as $select_gesusu_emp) {

                                                                echo '<option value="' . $select_gesusu_emp['id_usu'] . '">' . $select_gesusu_emp['nome'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="curso">Curso/Exame:</label>
                                                        <select name="curso" class="form-control" id="curso" required>
                                                            <option value="">Escolha um Curso/Exame</option>
                                                            <?php foreach (selectGESCUR_emp($id_emp_default) as $select_gescur_emp) {

                                                                echo '<option value="' . $select_gescur_emp['id_cur'] . '">' . $select_gescur_emp['descri'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="referencia">Data de Referência:</label>
                                                        <input type="text" id="referencia" name="referencia" class="form-control" placeholder="Data de inicio do Curso/Exame" required>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="vencimento">Data de Vencimento:</label>
                                                        <input type="text" id="vencimento" name="vencimento" class="form-control" placeholder="Data de vencimento do Curso/Exame" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="observacao">Observação</label>
                                                        <input type="text" name="observacao" id="observacao" style="text-transform:uppercase" class="form-control" minlength="3" maxlength="255">
                                                    </div>
                                                </div>

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
    }).on('draw', function() {

        // Marca todos os Checkbox, menos os disabled
        $("#checkTodos").click(function() {
            $('input:checkbox:not(:disabled)').not(this).prop('checked', this.checked);
        });

        // Habilita o botão excluir se tiver um checkbox marcado
        $("[name='checkbox[]']").click(function() {
            var cont = $(".checkbox:checked").length;
            $("#btn-cancelar").prop("disabled", cont ? false : true);
        });

        // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
        $(".checkbox").click(function() {
            var cont = $(".checkbox:checked").length;
            var cont_total = $(".checkbox:not(:disabled)").length;
            var check_todos = cont == cont_total;
            $("#checkTodos").prop("checked", check_todos ? true : false);
        });
    });
</script>

<!-- MASCARAS -->
<script>
    $(document).ready(function() {

        $('#referencia').mask('00/00/0000');
        $('#vencimento').mask('00/00/0000');
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
        $("#btn-cancelar").prop("disabled", cont ? false : true);
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
        $('#modal-lancar').on('hidden.bs.modal', function() {

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

    $(function() {
        $('#referencia').on('blur', function() {

            var referencia = $(this).val();
            var id_cur = $('#curso').val();
            var blur_referencia = 1;

            if (id_cur !== '') {

                var dados = {
                    referencia: referencia,
                    id_cur: id_cur,
                    blur_referencia: blur_referencia
                };

                $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {

                    $('#vencimento').val(retorno);
                });
            }
        });

        $('#curso').on('change', function() {

            var valCurso = $(this).val();
            var valref = $('#referencia').val();
            var blur_referencia = 1;

            if (valref !== '') {

                var dados = {
                    referencia: valref,
                    id_cur: valCurso,
                    blur_referencia: blur_referencia
                };

                $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {

                    $('#vencimento').val(retorno);
                });
            }
        });
    });

    $(function() {
        $('#modal-editar').on('show.bs.modal', function() {
            // Quando o modal de edição é exibido

            // Aplica a máscara "00/00/0000" ao campo com id "referencia_editar"
            $('#referencia_editar').mask('00/00/0000');
            // Aplica a máscara "00/00/0000" ao campo com id "vencimento_editar"
            $('#vencimento_editar').mask('00/00/0000');

            // Quando o campo "referencia_editar" perde o foco
            $('#referencia_editar').on('blur', function() {

                // Obtém o valor do campo "referencia_editar"
                var referencia = $(this).val();
                // Obtém o valor do campo "curso_editar"
                var id_cur = $('#curso_editar').val();
                // Define o indicador de "blur_referencia" como 1
                var blur_referencia = 1;

                if (id_cur !== '') {
                    // Se o campo "curso_editar" não estiver vazio

                    var dados = {
                        referencia: referencia,
                        id_cur: id_cur,
                        blur_referencia: blur_referencia
                    };

                    // Envia uma requisição POST para o arquivo "lancamento_cursos_exames_post.php" com os dados
                    $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {

                        // Define o valor retornado como o valor do campo "vencimento_editar"
                        $('#vencimento_editar').val(retorno);
                    });
                }
            });

            // Quando o valor do campo "curso_editar" é alterado
            $('#curso_editar').on('change', function() {

                // Obtém o valor do campo "curso_editar"
                var valCurso = $(this).val();
                // Obtém o valor do campo "referencia_editar"
                var valref = $('#referencia_editar').val();
                // Define o indicador de "blur_referencia" como 1
                var blur_referencia = 1;

                if (valref !== '') {
                    // Se o campo "referencia_editar" não estiver vazio

                    var dados = {
                        referencia: valref,
                        id_cur: valCurso,
                        blur_referencia: blur_referencia
                    };

                    // Envia uma requisição POST para o arquivo "lancamento_cursos_exames_post.php" com os dados
                    $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {

                        // Define o valor retornado como o valor do campo "vencimento_editar"
                        $('#vencimento_editar').val(retorno);
                    });
                }
            });
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BOTÃO LANÇAR
    $(function() {
        $(document).on('click', '#btn-lancar', function() {

            $('#modal-lancar').modal('show');
        });
    });

    // CLOSE MODAL
    $(function() {
        $(document).on('click', '.close-modal', function() {

            $('.modal:visible').modal('hide');
        });
    });

    // BOTÃO CANCELAR
    $(function() {
        $(document).on('click', '#btn-cancelar', function() {

            // Se o usuario realmente quiser excluir o contato
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja cancelar esse(s) registro(s)?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, cancelar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_cancel = 1;
                    var ids = $('.checkbox:not(:disabled):checked').map(function() {
                        return this.value;
                    }).get();

                    dados_cancel = {
                        ids: ids,
                        btn_cancel: btn_cancel
                    };

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/lancamento_cursos_exames_post.php', dados_cancel, function(retorno) {

                        switch (retorno) {
                            case '0':
                                // Chama o plugin 'mensagem_alerta' com o caso 'NENHUM_ID'
                                $(this).mensagem_alerta('NENHUM_ID');
                                break;

                            case '1':
                                // Chama o plugin 'mensagem_alerta' com o caso 'CANCELAR_SUCESSO'
                                $(this).mensagem_alerta('CANCELAR_SUCESSO');
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

    // BTN EDITAR
    $(function() {
        $(document).on('click', '.btn-editar', function() {

            var btn_editar = 1;
            var id_lcm = $(this).attr('id_lcm'); // Obtém o valor do atributo 'id_lcm' do elemento clicado

            if (btn_editar !== '') {

                var dados = {
                    id_lcm: id_lcm,
                    btn_editar: btn_editar
                };

                // Envia uma solicitação POST para o arquivo 'lancamento_cursos_exames_post.php' com os dados
                $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {
                    // Insere o retorno no elemento com ID 'modal-body-editar'
                    $('#modal-body-editar').html(retorno);

                    $('#submit-editar').attr('id_lcm', id_lcm);

                    // Exibe o modal com ID 'modal-editar'
                    $('#modal-editar').modal('show');
                });
            }
        });
    });

    $(function() {
        $('.btn-anexo').click(function() {

            var btn_anexo = 1;

            var dados = {
                id_lcm: $(this).attr('id_lcm'),
                btn_anexo: btn_anexo
            };

            $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {

                location.href = 'anexos_cursos_exames';
            });
        });
    });
</script>

<!-- SUBMIT -->
<script>
    // SUBMIT INCLUIR
    $(function() {
        // Manipula o evento de envio do formulário com id "form-modal-lancar"
        $("#form-modal-lancar").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_submit = 1;

            if (btn_submit !== '') {
                // Obtém os dados do formulário
                var dados = {
                    colab: $('#colab').val(),
                    curso: $('#curso').val(),
                    referencia: $('#referencia').val(),
                    vencimento: $('#vencimento').val(),
                    observacao: $('#observacao').val(),

                    // Valida o Submit
                    btn_submit: btn_submit
                };

                // Envia uma requisição POST para o arquivo "controller/lancamento_cursos_exames_post.php" com os dados do formulário
                $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {
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
                            // Chama o plugin 'mensagem_alerta' com o caso 'REFERENCIA_INVALIDO'
                            $(this).mensagem_alerta('REFERENCIA_INVALIDO');
                            break;

                        case '3':
                            // Chama o plugin 'mensagem_alerta' com o caso 'VENCIMENTO_INVALIDO'
                            $(this).mensagem_alerta('VENCIMENTO_INVALIDO');
                            break;

                        case '4':
                            // Chama o plugin 'mensagem_alerta' com o caso 'REFERENCIA_MAIOR_VENCIMENTO'
                            $(this).mensagem_alerta('REFERENCIA_MAIOR_VENCIMENTO');
                            break;

                        case '5':
                            // Chama o plugin 'mensagem_alerta' com o caso 'PERIODO_MENOR_IGUAL_CARENCIA'
                            $(this).mensagem_alerta('PERIODO_MENOR_IGUAL_CARENCIA');
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

    $(function() {
        $("#form-modal-editar").submit(function(event) {

            event.preventDefault();

            var submit_editar = 1;

            var dados = {
                colab: $('#colab_editar').val(),
                curso: $('#curso_editar').val(),
                datref: $('#referencia_editar').val(),
                datvenc: $('#vencimento_editar').val(),
                observacao: $('#observacao_editar').val(),
                id_lcm: $('#submit-editar').attr('id_lcm'),

                submit_editar: submit_editar
            };

            // Envia uma requisição POST para o arquivo "controller/lancamento_cursos_exames_post.php" com os dados do formulário
            $.post('controller/lancamento_cursos_exames_post.php', dados, function(retorno) {
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
                        // Chama o plugin 'mensagem_alerta' com o caso 'REFERENCIA_INVALIDO'
                        $(this).mensagem_alerta('REFERENCIA_INVALIDO');
                        break;

                    case '3':
                        // Chama o plugin 'mensagem_alerta' com o caso 'VENCIMENTO_INVALIDO'
                        $(this).mensagem_alerta('VENCIMENTO_INVALIDO');
                        break;

                    case '4':
                        // Chama o plugin 'mensagem_alerta' com o caso 'REFERENCIA_MAIOR_VENCIMENTO'
                        $(this).mensagem_alerta('REFERENCIA_MAIOR_VENCIMENTO');
                        break;

                    case '5':
                        // Chama o plugin 'mensagem_alerta' com o caso 'PERIODO_MENOR_IGUAL_CARENCIA'
                        $(this).mensagem_alerta('PERIODO_MENOR_IGUAL_CARENCIA');
                        break;

                    default:
                        // Chama o plugin 'mensagem_alerta' com o caso DEFAULT
                        $(this).mensagem_alerta(retorno);
                        break;
                }
            });
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

                case 'INCLUIR_SUCESSO':
                    // Mostra um alerta de sucesso usando o Swal.fire
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Curso/Exame lançado com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;

                case 'EDITAR_SUCESSO':
                    // Mostra um alerta de sucesso usando o Swal.fire
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Lançamento alterado com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Recarrega a página se o usuário confirmar o alerta
                            location.reload();
                        }
                    });
                    break;

                case 'REFERENCIA_INVALIDO':
                    // Mostra um alerta de aviso para um referencia inválido
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'A data de referência informada é inválida!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Define a cor da borda do elemento 'referencia' como vermelho e foca nele
                                $('#referencia').css('border-color', 'red').focus()
                            ]
                        }
                    });
                    break;

                case 'VENCIMENTO_INVALIDO':
                    // Mostra um alerta de aviso para um vencimento inválido
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'A data de vencimento informado é inválido!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Define a cor da borda do elemento 'vencimento' como vermelho e foca nele
                                $('#vencimento').css('border-color', 'red').focus()
                            ]
                        }
                    });
                    break;

                case 'REFERENCIA_MAIOR_VENCIMENTO':
                    // Mostra um alerta de aviso para um valor 'referencia' maior que o valor 'vencimento'
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'A data de referência não pode ser maior que o vencimento',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                // Foca no elemento 'referencia'
                                $('#referencia').focus()
                            ]
                        }
                    });
                    break;

                case 'NENHUM_ID':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Nenhum registro selecionado',
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

                case 'CANCELAR_SUCESSO':
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        title: 'Sucesso!',
                        text: 'Registro(s) cancelado(s) com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    break;

                case 'PERIODO_MENOR_IGUAL_CARENCIA':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Periodo não pode ser menor do que a carencia de aviso cadastrada para esse curso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Fecha o alerta se o usuário confirmar
                            swal.close();
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