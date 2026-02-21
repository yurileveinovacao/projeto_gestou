<?php

//Faz a requisição da Sessão
require_once 'restrito.php';

//ARQUIVO DE UTILITÁRIOS
require_once 'util.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once 'iuds_pdo.php';

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

    <title>GESTOU PORTAL - Usuários</title>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabela Usuários</h6>
                        </div>
                        <div class="card-body">

                            <form id="processar">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma" title="Incluir Usuário"><i class="fas fa-plus-circle"></i> Incluir</button>
                                                <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                            </div>

                                            <tr>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false" class="sorttable_sort">E-mail</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Tipo Usuário</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="coluna-nome text-center">Nome</th>
                                                <th class="text-center">E-mail</th>
                                                <th class="text-center">Tipo Usuário</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <?php

                                            foreach (select_GESUSA_usuarios_adm(1) as $linha) {

                                                if ($linha != 0) {
                                            ?>

                                                    <tr>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                        </td>

                                                        <td><?php echo $linha['email']; ?></td>

                                                        <td style="text-align:center">
                                                            <?php

                                                            if ($linha['id_tus'] == 3) {
                                                            ?>

                                                                <i class="fas fa-user-tie fa-2x text-primary" title="Contábil"></i>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php

                                                            if ($linha['id_tus'] == 2) {
                                                            ?>

                                                                <i class="fas fa-user fa-2x text-primary" title="Empresa"></i>
                                                            <?php
                                                            }
                                                            if ($linha['id_tus'] == 1) {
                                                            ?>

                                                                <i class="fas fa-user-cog fa-2x ml-2 text-primary" title="Admin"></i>
                                                            <?php
                                                            } ?>
                                                        </td>

                                                        <td class="content-xy-center">
                                                            <!-- INICIO SITUACAO -->
                                                            <div class="div-acoes">

                                                                <?php if ($linha['situac'] == 1) { ?>

                                                                    <span class="text-success cursor-pointer btn-situac" situac="<?php echo $linha['situac'] ?>" id-usa="<?php echo $linha['id_usa']; ?>"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span>
                                                                <?php } else if ($linha['situac'] == 0) { ?>

                                                                    <span class="text-danger cursor-pointer btn-situac" situac="<?php echo $linha['situac'] ?>" id-usa="<?php echo $linha['id_usa']; ?>"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span>
                                                                <?php } ?>

                                                            </div>

                                                            <!-- INICIO EDITAR -->
                                                            <div class="div-acoes">
                                                                <button type="button" id="btn-editar" class="btn btn-primary btn-icones" id_usa="<?php echo $linha['id_usa']; ?>" title="Editar">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>


                                                    </tr>



                                            <?php
                                                }
                                            }
                                            ?>

                                            <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                        </tbody>
                                    </table>
                                    <!-- FIM TBODY E TABLE -->
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------------------->
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

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<script type="text/javascript">
    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade_idusu.php?search=', {
                    estado: $(this).val(),
                    ajax: 'true'
                }, function(j) {
                    var options =
                        '<option value="" selected disabled>Escolha a Cidade</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id_mun + '" namespace="' + j[i]
                            .cep_mun + '">' + j[i].nome_mun + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
            }
        });
    });
</script>

<!-- FIM ANIMAÇÃO RÁPIDA -->

<script>
    document.getElementById("estado").onchange = function() {
        document.querySelector("[name='cep']").value = '';

    }

    document.getElementById("cidade").onchange = function() {

        var select = document.getElementById("cidade");

        var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = cep;

    }
</script>

<!-- AÇÕES NO CLICK DE BOTÕES -->
<script>
    // BOTÃO EDITAR
    $(function() {
        $(document).on('click', '#btn-editar', function() {

            var btn_editar = $(this).attr("id_usa");

            if (btn_editar !== '') {

                var dados = {
                    btn_editar: btn_editar
                };

                $.post('controller/tabela_usuarios_post.php', dados, function(retorno) {

                    location.href = 'alterar_usuario2';
                });
            }
        });
    });

    // BOTÃO VOLTAR
    $(function() {
        $(document).on('click', '#btn-voltar', function() {

            location.href = 'index';
        })
    });

    // BOTÃO INCLUIR
    $(function() {
        $(document).on('click', '#btn-incluir', function() {

            location.href = 'cadastro_usuario';
        });
    });

    // ALTERAR SITUAÇÃO (ATIVO/INATIVO)
    $(function() {
        $(document).on('click', '.btn-situac', function() {

            // Valores recebidos no click
            var btn_situac = $(this).attr('situac');
            var id_usa = $(this).attr('id-usa');

            if (btn_situac !== '') {

                // Obtém os valores do click
                dados = {

                    btn_situac: btn_situac,
                    id_usa: id_usa
                };

                // Envia os dados do click para o arquivo PHP usando o método POST do jQuery
                $.post('controller/tabela_usuarios_post.php', dados, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram atualizados com sucesso
                    if (retorno == 1) {

                        location.reload();

                        // Caso não for, houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
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
                        })
                    }
                });
            }
        });
    });
</script>