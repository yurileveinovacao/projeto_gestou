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

    <title>GESTOU PORTAL - Departamentos</title>

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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once 'menu_lateral.php';

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once 'barra_superior.php';

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Departamentos</h6>
                        </div>
                        <div class="card-body">

                            <form id="processar">
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
                                                <th data-orderable="false">Departamento</th>
                                                <th data-orderable="false" width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot style="text-align: center;">
                                            <tr>
                                                <th></th>
                                                <th>Departamento</th>
                                                <th>Ações</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <?php

                                            foreach (selectGESDEP_id_emp($id_emp_default) as $linha) {

                                                if ($linha != 0) {

                                            ?>

                                                    <tr>
                                                        <td class="coluna-checkbox">
                                                            <?php if ($linha['situac'] == 1) { ?>

                                                                <input type="checkbox" disabled></input>
                                                            <?php } else { ?>

                                                                <input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $linha['id_dep']; ?>"></input>
                                                            <?php } ?>
                                                        </td>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                        </td>

                                                        <td class="content-xy-center">
                                                            <!-- INICIO SITUACAO -->
                                                            <div class="div-acoes">
                                                                <div class="cursor-pointer" id="situac" situac="<?php echo $linha['situac']; ?>" id_dep="<?php echo $linha['id_dep']; ?>">
                                                                    <?php if ($linha['situac'] == 1) { ?>

                                                                        <span class="text-success"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>
                                                                    <?php } else if ($linha['situac'] == 0) { ?>

                                                                        <span class="text-danger"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                            <!-- INICIO EDITAR -->
                                                            <div class="div-acoes">
                                                                <button type="button" id="btn-editar" id_dep="<?php echo $linha['id_dep']; ?>" class="btn btn-primary btn-icones" title="Editar">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>

                                            <?php
                                                } else {
                                                }
                                            }

                                            ?>
                                            <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                        </tbody>
                                    </table>
                                    <!-- FIM TBODY E TABLE -->
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

            <?php

            include_once "footer.php";

            ?>

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

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

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
    // ALTERAR SITUAÇÃO
    $(function() {
        $(document).on('click', '#situac', function() {

            var btn_situac = 1;

            if (btn_situac !== '') {

                var dados = {
                    // Recebe os valores de situação
                    id_dep_update: $(this).attr('id_dep'),
                    situac_update: $(this).attr('situac'),

                    // Valida a mudança de situação
                    btn_situac: btn_situac
                };

                $.post('controller/tabela_departamento_post.php', dados, function(retorno) {

                    if (retorno == 1) {

                        location.reload();
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

    // BOTÃO INCLUIR
    $(function() {
        $(document).on('click', '#btn-incluir', function() {

            // Direciona para a página incluir departamento
            location.href = 'cadastro_departamento';
        });
    });

    // BOTÃO EDITAR
    $(function() {
        $(document).on('click', '#btn-editar', function() {

            // ATRIBUIÇÃO DE VARIAVEL PELO ATRIBUTO
            var id_dep = $(this).attr("id_dep");

            // IF SE A VARIAVEL NÃO ESTÁ VAZIA
            if (id_dep !== '') {

                var dados = {

                    id_dep: id_dep
                };

                $.post('controller/tabela_departamento_post.php', dados, function(retorno) {

                    location.href = 'alterar_departamento';
                });
            }
        });
    });

    // BOTÃO EXCLUIR
    $(function() {
        $(document).on('click', '#btn-excluir', function() {

            // Se o usuario realmente quiser excluir o contato
            if (confirm('Tem certeza que deseja deletar esse registro?')) {

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
                $.post('controller/tabela_departamento_post.php', dados_exc, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Departamento(s) excluido(s) com sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                        // Caso o contrario, nenhum departamento foi selecionado
                    } else {

                        // Exibe uma mensagem de falha
                        Swal.fire({
                            icon: 'warning',
                            title: 'Nenhum departamento inativo selecionado!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                swal.close();
                            }
                        })
                    }

                });
            } else {

                return false;
            }

        });
    });
</script>