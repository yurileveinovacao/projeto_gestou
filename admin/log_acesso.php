<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'raiz_cnpj_pdo.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

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

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="js/sorttable.js"></script>

<!---------------------------------------------------------------------------------------- -->

<!---------------------------------------------------------------------------------------- -->

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                            <h6 class="m-0 font-weight-bold text-primary">Log de Acessos</h6>
                        </div>
                        <div class="card-body">
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%">
                                    

                                    <!-- <table  class="table table-bordered sortable"  width="100%"    cellspacing="0">-->
                                        <thead style="text-align: center;">
                                            <div class="col-sm-12 button-tabela">
                                            </div>
                                            <tr>
                                            <th data-orderable="false" style="display:none" >Rank</th>
                                                <th data-orderable="false" style="width:10%" >ID</th>
                                                <th data-orderable="false" class="coluna-nome" style="width:40%">Nome</th>
                                                <th data-orderable="false" style="width:30%">Endereço IP</th>
                                                <th data-orderable="false" style="width:30%; text-align: center">Data Atualização</th> 
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th style="display:none" >Rank</th>
                                            <th>ID</th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>Endereço IP</th>
                                                <th style="text-align: center">Data Atualização</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="texto-table-body">
<?php
    foreach (select_VW_GESACE($id_emp_default) as $linha) {
        ?>
                                            <tr>
                                            <td style="display:none" ><?php  echo $linha['rank']; ?></td>
                                            <td><?php  echo $linha['id']; ?></td>
                                                <td><span class="m-0 text-primary tamanho-text"><?php  echo $linha['usuario']; ?></span>  </td>
                                                <td><?php  echo $linha['ip']; ?></td>
                                                <td class="linha-valores" style="text-align: center;"><?php  echo $linha['datatu']; ?></td>
                                                <?php
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

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; LFP Serviços 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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
