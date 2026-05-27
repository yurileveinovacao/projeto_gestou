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

    <title>GESTOU PORTAL - Log Importar Colaboradores</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once 'barra_superior.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Log Importar Colaboradores</h6>
                        </div>
                        <div class="card-body">

                            <!-- INICIO DIV TABLE -->
                            <div class="table-responsive">

                                <!-- INICIO TABLE -->
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <!-- THEAD -->
                                    <thead style="text-align: center;">
                                        <!-- <div class="col-sm-12 button-tabela">
                                            <button id="" type="button" class="btn btn-primary" title="Filtros" data-toggle="modal" data-target="#filtro">
                                                <i class="fas fa-filter"></i> Filtros
                                            </button>
                                            <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma" title="Incluir">
                                                <i class="fas fa-plus-circle"></i> Incluir
                                            </button>
                                            <button disabled type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" title="Excluir">
                                                <i class="fas fa-trash-alt"></i> Excluir
                                            </button>
                                        </div> -->

                                        <tr>
                                            <!-- <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]" title="Marcar Todos"></input></th> -->
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false">CPF</th>
                                            <th data-orderable="false">Status</th>
                                            <th data-orderable="false">Descrição</th>
                                        </tr>
                                    </thead>

                                    <!-- TFOOT -->
                                    <tfoot>
                                        <tr>
                                            <!-- <th></th> -->
                                            <th class="coluna-nome">Nome</th>
                                            <th>CPF</th>
                                            <th>Status</th>
                                            <th>Descrição</th>
                                        </tr>
                                    </tfoot>

                                    <!-- INICIO TBODY -->
                                    <tbody class="texto-table-body">

                                        <!-- <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once 'footer.php'; ?>
            <!-- End of Footer -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

            <script src="scripts/log_importar_colaboradores.js?version=<? echo time(); ?>"></script>

</body>

</html>