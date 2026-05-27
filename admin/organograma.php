<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

global $nivel_consulta;

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

    <title>GESTOU PORTAL - Organograma da empresa</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

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

                    <!-- CARD HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Organograma da empresa</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <!-- INICIO DIV TABLE -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                <!-- THEAD -->
                                <thead>

                                    <div class="col-sm-12 button-tabela">
                                        <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma" title="Incluir">
                                            <i class="fas fa-plus-circle"></i> Incluir
                                        </button>

                                        <button type="button" id="btn-visualizar" class="btn btn-organograma btn-icon-split-organograma">
                                            <i class="fas fa-file-image mr-sm-2"></i> Visualizar
                                        </button>

                                        <button disabled type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" title="Excluir">
                                            <i class="fas fa-trash-alt"></i> Excluir
                                        </button>
                                    </div>

                                    <tr>
                                        <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]" title="Marcar Todos"></input></th>
                                        <th data-orderable="false">Nível</th>
                                        <th data-orderable="false">Nome</th>
                                        <th data-orderable="false">Pai</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" style="text-align: center; width: 15%">Ações</th>
                                    </tr>
                                </thead>

                                <!-- TFOOT -->
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Nível</th>
                                        <th>Nome</th>
                                        <th>Pai</th>
                                        <th style="text-align: center" class="sorttable_nosort nao_click">Ações</th>
                                    </tr>
                                </tfoot>

                                <!-- INICIO TBODY -->
                                <tbody class="texto-table-body">
                                    <?php foreach (select_GESORG($id_emp_default) as $linha) {

                                        if (!empty($linha)) { ?>
                                            <tr class="hover-linha">

                                                <?php foreach (select_GESORG_filho($id_emp_default, $linha['descricao']) as $linha2) {

                                                    $filho = $linha2['conta'];
                                                }

                                                if (!empty($filho)) { ?>

                                                    <!-- Checkbox Disabled -->
                                                    <td class="coluna-checkbox">
                                                        <input type="checkbox" disabled></input>
                                                    </td>
                                                <?php } else { ?>

                                                    <!-- Checkbox -->
                                                    <td class="coluna-checkbox">
                                                        <input type="checkbox" class="selecionar" value="<?php echo $linha['id_org']; ?>"></input>
                                                    </td>
                                                <?php } ?>

                                                <!-- Nível -->
                                                <td>
                                                    <?php echo $linha['nivel']; ?>
                                                </td>

                                                <!-- Descrição -->
                                                <td>
                                                    <?php echo $linha['descricao']; ?>
                                                </td>

                                                <!-- Pai -->
                                                <td>
                                                    <?php echo $linha['pai']; ?>
                                                </td>

                                                <!-- Ações -->
                                                <td class="content-xy-center">
                                                    <!-- INICIO EDITAR -->
                                                    <div class="div-acoes">
                                                        <button type="button" id="btn-editar" class="btn btn-primary btn-icones" id-org="<?php echo $linha['id_org']; ?>">
                                                            <i class="fas fa-pencil-alt" title="Editar"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                                <!-- FIM TBODY -->

                            </table>
                        </div>
                        <!-- FIM DIV TABLE -->

                        <!-- --------------------------------------------------------------------------------------------------- -->
                        <!--                                      INICIO MODAIS                                                  -->
                        <!-- --------------------------------------------------------------------------------------------------- -->

                        <!-- Modal Visualizar -->
                        <div class="modal fade" id="modal-visualizar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-visualizar" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Visualizar">Organograma</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <iframe id='print-iframe' name='print-frame-name' src="visualizar_organograma.php" style="width:100%; height: 600px; border: none;"></iframe>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                                        <button type="button" id="btn-imprimir" class="btn btn-organograma btn-icon-split-organograma">
                                            <i class="fas fa-print"></i> Imprimir
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Incluir Modal-->
                        <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-incluir" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Incluir">Incluir Organograma</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    <form id="form-incluir">

                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputDescricao">Descrição</label>
                                                    <input type="text" name="inputDescricao" style="text-transform:uppercase" class="form-control" id="inputDescricao" minlength="2" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="inputPai">Pai</label>
                                                    <select id="inputPai" name="inputPai" class="form-control" required>
                                                        <option value="" selected disabled>Escolha um pai para o elemento</option>

                                                        <?php foreach (select_VW_ORG($id_emp_default) as $linha3) {

                                                            if (empty($linha3)) { ?>

                                                                <option>-</option>
                                                            <?php
                                                            } else { ?>

                                                                <option value="<?php echo $linha3["nivel"] ?>" nivel-filho="<?php echo $linha3["novo_nivel"] ?>"><?php echo $linha3["descricao"] ?></option>
                                                        <?php }
                                                        } ?>

                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="inputNivel">Nível</label>
                                                    <input type="text" name="inputNivel" class="form-control" id="inputNivel" readonly></input>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>

                                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-save mr-sm-2"></i> Salvar
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Editar Modal-->
                        <div class="modal fade" id="modal-editar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-editar" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Editar">Editar Organograma</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="form-editar">

                                        <div class="modal-body" id="modal-editar-body">
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>

                                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-save mr-sm-2"></i> Salvar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- --------------------------------------------------------------------------------------------------- -->
                        <!--                                      FIM MODAIS                                                     -->
                        <!-- --------------------------------------------------------------------------------------------------- -->


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

<!-- CHECKBOX -->
<script>
    // Marca todos os Checkbox, menos os disabled
    $("#checkTodos").click(function() {
        $('input:checkbox').not(":disabled").prop('checked', this.checked);
    });

    // Habilita o botão excluir se tiver um checkbox marcado
    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        var cont_total = $(".selecionar:not(:disabled)").length;
        var check_todos = cont == cont_total;
        $("#checkTodos").prop("checked", check_todos ? true : false);
    });
</script>

<script>
    document.getElementById("inputPai").onchange = function() {
        var select = document.getElementById("inputPai");
        var nivel = select.options[select.selectedIndex].getAttribute("nivel-filho");
        document.querySelector("[name='inputNivel']").value = nivel;
    }

    // APAGA ALTERAÇÃO NO MODAL
    $(function() {
        $('#modal-incluir').on('hidden.bs.modal', function() {

            $(this).find('form')[0].reset();
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BTN IMPRIMIR
    $(function() {
        $(document).on('click', '#btn-imprimir', function() {

            document.getElementById("print-iframe").contentWindow.print();
        });
    });

    // BTN VISUALIZAR
    $(function() {
        $(document).on('click', '#btn-visualizar', function() {

            $('#modal-visualizar').modal('show');
        });
    });

    // BTN INCLUIR
    $(function() {
        $(document).on('click', '#btn-incluir', function() {

            $('#modal-incluir').modal('show');
        });
    });

    // BTN EDITAR
    $(function() {
        $(document).on('click', '#btn-editar', function() {

            var btn_editar = 1;
            var id_org = $(this).attr('id-org');

            if (btn_editar !== '') {

                var dados = {
                    id_org: id_org,

                    btn_editar: btn_editar
                };

                $.post('controller/organograma_post.php', dados, function(retorno) {

                    $('#modal-editar').modal('show');
                    $('#modal-editar-body').html(retorno);
                });
            }
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
                    var selecionados = $('.selecionar:not(:disabled):checked').map(function() {
                        return this.value;
                    }).get();

                    //verificar se há calor nas variaveis
                    if (btn_excluir !== '') {

                        var dados = {
                            selecionados: selecionados,

                            // Valida o excluir
                            btn_excluir: btn_excluir
                        };

                        $.post('controller/organograma_post.php', dados, function(retorno) {

                            switch (retorno) {

                                case '1':
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

                                case '0':
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

                                default:
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Please contact support.',
                                        title: 'Favor entrar em contato com o suporte.',
                                        html: retorno,
                                        closeOnClickOutside: false,
                                        allowOutsideClick: false
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

    // SUBMIT INCLUIR
    $(function() {
        // QUANDO O FORMULÁRIO É SUBMETIDO
        $("#form-incluir").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_incluir = 1;

            if (btn_incluir !== '') {

                // cria um objeto FormData com os valores do formulário
                var formData = new FormData(this);
                formData.append('btn_incluir', btn_incluir);

                $.post({
                    url: 'controller/organograma_post.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(retorno) {

                        switch (retorno) {

                            // Se 1, registro cadastrado com sucesso
                            case '1':
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    title: 'Sucesso!',
                                    text: 'Registro incluido com sucesso!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                break;

                                // Se 0, faltou preencher algum campo
                            case '0':
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Attention!',
                                    title: 'Atenção!',
                                    text: 'Preencha todos os campos para efetuar a ação!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close();
                                    }
                                });
                                break;

                                // Se 2, descrição já cadastrada
                            case '2':
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Attention!',
                                    title: 'Atenção!',
                                    text: 'Esse nome já existe para essa empresa!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close();
                                    }
                                });
                                break;

                                // Erro no Try
                            default:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please contact support.',
                                    title: 'Favor entrar em contato com o suporte.',
                                    html: retorno,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
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

    // SUBMIT EDITAR
    $(function() {
        // QUANDO O FORMULÁRIO É SUBMETIDO
        $("#form-editar").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_atualizar = 1;

            if (btn_atualizar !== '') {

                // cria um objeto FormData com os valores do formulário
                var formData = new FormData(this);
                formData.append('btn_atualizar', btn_atualizar);

                $.post({
                    url: 'controller/organograma_post.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(retorno) {

                        switch (retorno) {

                            // Se 1, registro cadastrado com sucesso
                            case '1':
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    title: 'Sucesso!',
                                    text: 'Registro atualizado com sucesso!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                break;

                                // Se 0, faltou preencher algum campo
                            case '0':
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Attention!',
                                    title: 'Atenção!',
                                    text: 'Preencha todos os campos para efetuar a ação!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close();
                                    }
                                });
                                break;

                                // Se 2, descrição já cadastrada
                            case '2':
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Attention!',
                                    title: 'Atenção!',
                                    text: 'Esse nome já existe para essa empresa!',
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close();
                                    }
                                });
                                break;

                                // Erro no Try
                            default:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please contact support.',
                                    title: 'Favor entrar em contato com o suporte.',
                                    html: retorno,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
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
</script>