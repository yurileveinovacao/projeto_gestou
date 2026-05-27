<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

unset($_SESSION["id_mas_permissao"]);

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

    <title>GESTOU PORTAL - Permissão</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Boxicons -->
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
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabela permissão</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">
                                            <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma" title="Incluir">
                                                <i class="fas fa-plus-circle"></i> Incluir
                                            </button>
                                            <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-sign-out-alt"></i> Voltar
                                            </button>
                                        </div>

                                        <tr>
                                            <th class="text-left coluna-nome">Id usa</th>
                                            <th data-orderable="false" class="coluna-nome text-left">Nome</th>
                                            <th class="text-left coluna-nome">E-mail</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-left" width="10%">Id usa</th>
                                            <th class="text-left" width="70%">Nome</th>
                                            <th class="text-left" width="70%">E-mail</th>
                                            <th class="text-center" width="5%">Ações</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                        foreach (select_GESMAS() as $linha) {
                                            if ($linha != 0) {
                                                $id_mas = $linha['id_mas'];
                                                $nome = $linha['nome'];
                                                $email = $linha['email'];
                                                $situac = $linha['situac'];

                                        ?>

                                                <tr>
                                                    <td>
                                                        <span class="text-primary tamanho-text text-center"><?php echo $id_mas; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $nome; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $email; ?></span>
                                                    </td>
                                                    <td class="content-xy-center">
                                                        <div class="div-acoes">
                                                            <?php

                                                            if ($situac == 1) {

                                                            ?>

                                                                <span class="text-success cursor-pointer btn-situac" situac="<?php echo $situac; ?>" id_mas="<?php echo $id_mas; ?>"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <span class="text-danger cursor-pointer btn-situac" situac="<?php echo $situac; ?>" id_mas="<?php echo $id_mas; ?>"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span>

                                                            <?php

                                                            }

                                                            ?>
                                                        </div>
                                                        <div class="div-acoes">
                                                            <button type="button" id="btn-editar" id_mas="<?php echo $id_mas; ?>" class="btn btn-primary" title="Editar">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </div>
                                                        <div class="div-acoes">
                                                            <button type="button" id="btn-permissao" id_mas="<?php echo $id_mas; ?>" nome="<?php echo $nome; ?>" class="btn btn-primary" title="Liberar telas">
                                                                <i class="fas fa-unlock"></i>
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

<script>
    //Clique botão btn-permissao
    $(document).ready(function() {
        $(document).on('click', '#btn-permissao', function() {

            // Obtendo o valor do atributo "id_mas" do botão clicado
            var id_mas_permissao = $(this).attr("id_mas");
            var nome_mas_permissao = $(this).attr("nome");

            // Verificar se há um valor válido na variável "id_mas_permissao"
            if ((id_mas_permissao !== '') && (nome_mas_permissao !== '')) {

                // Criando um objeto de dados para ser enviado por POST
                var dados = {
                    id_mas_permissao: id_mas_permissao,
                    nome_mas_permissao: nome_mas_permissao
                };

                $.post('controller/usuarios_master_post.php', dados, function(retorna) {
                    location.href = "usuarios_master_permissao";
                });
            }
        });
    });

    //Clique botão btn-editar
    $(document).ready(function() {
        $(document).on('click', '#btn-incluir', function() {

            location.href = "cadastro_usuario_master";

        });
    });

    //Clique botão btn-editar
    $(document).ready(function() {
        $(document).on('click', '#btn-editar', function() {

            // Obtendo o valor do atributo "id_mas" do botão clicado
            var id_mas_editar = $(this).attr("id_mas");

            // Verificar se há um valor válido na variável "id_mas_editar"
            if (id_mas_editar !== '') {

                // Criando um objeto de dados para ser enviado por POST
                var dados = {
                    id_mas_editar: id_mas_editar
                };

                $.post('controller/usuarios_master_post.php', dados, function(retorna) {
                    location.href = "alterar_usuario_master";
                });
            }
        });
    });

    //Clique botão btn-editar
    $(document).ready(function() {
        $(document).on('click', '.btn-situac', function() {

            // Obtendo o valor do atributo "id_mas" do botão clicado
            var btn_situac = $(this).attr("situac");
            var id_mas_situac = $(this).attr("id_mas");

            // Verificar se há um valor válido na variável "id_mas_situac"
            if ((btn_situac !== '') && (id_mas_situac !== '')) {

                // Criando um objeto de dados para ser enviado por POST
                var dados = {
                    btn_situac: btn_situac,
                    id_mas_situac: id_mas_situac
                };

                $.post('controller/usuarios_master_post.php', dados, function(retorna) {
                    switch (retorna) {
                        case "1":

                            window.location.reload();

                            break;

                        default:

                            // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                            Swal.fire({
                                icon: 'error',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorna
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });

                            break;
                    }
                });
            }
        });
    });
</script>