<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'raiz_cnpj_pdo.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

$tabela1 = 'public."GESIM1_'.$raiz_cnpj.'"';

?>

<?php

if (isset($_REQUEST['al'])) {
    try {
        require_once __DIR__.'/../config/database.php';

        $id = $_REQUEST["al"];
        
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
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

    <title>GESTOU PORTAL - Itens Holerite</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">



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
                            <h6 class="m-0 font-weight-bold text-primary">Itens de Holerite (<?php
                            // echo $tabela1;
                            foreach (selectRECIBO_PAGAMENTO_NOME($raiz_cnpj, $id) as $linha) {

                                echo $linha["nome"];

                            }
                             ?>)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <div class="col-sm-12 button-tabela">

                                            <a href="aceite_beneficios"><button type="button" name="btn-voltar" data-toggle="tooltip"
                                                title="Voltar para aceite de benefícios"
                                                class="btn btn-organograma btn-icon-split-organograma"><i
                                                    class="fas fa-undo-alt"></i> Voltar</button></a>

                                        </div>

                                        <tr>
                                            <th data-orderable="false">Cód. Evento</th>
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false">Quantidade</th>
                                            <th data-orderable="false">Vencimentos</th>
                                            <th data-orderable="false">Descontos</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Cód. Evento</th>
                                            <th class="coluna-nome">Nome</th>
                                            <th>Quantidade</th>
                                            <th>Vencimentos</th>
                                            <th>Descontos</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php
// $sql2 = 'SELECT * FROM public."VW_RECIBO_DE_PAGAMENTO_ITENS"
// where id_im1='.$id_im1.'';
// $res2 = pg_exec($conn, $sql2);

//     while ($linha = pg_fetch_assoc($res2)) {

    foreach (selectRECIBO_PAGAMENTO_ITENS($raiz_cnpj, $id) as $linha) {

        $codevento = $linha['codevento'];
        $nome = $linha['nome'];
        $quantidade = $linha['quantidade'];
        $vencimentos = $linha['vencimentos'];
        $descontos = $linha['descontos'];
    
        

        ?>
                                        <?php
                                            
                                            if($vencimentos > 0){

                                        ?>
                                        <tr style="color: #3C0BA9;" class="tamanho-text-600">

                                            <?php 
                                        
                                            }if($descontos < 0){

                                        ?>

                                        <tr style="color: #D81F2D;" class="tamanho-text-600">

                                            <?php
                                            }
                                        ?>

                                            <td><?php  echo $linha["codevento"]; ?></td>
                                            <td><?php  echo $linha['nome']; ?></td>
                                            <td class="linha-valores"><?php  echo $linha['quantidade']; ?></td>
                                            <td class="linha-valores"><?php  echo $linha['vencimentos']; ?></td>
                                            <td class="linha-valores"><?php  echo $linha['descontos']; ?></td>
                                        </tr>

                                        <?php
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

            <!-- ---------------------------------------------------------------------------------------------------------------------->

            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Leve Inovação Estratégica Ltda — CNPJ 53.094.687/0001-38 — <?php echo date('Y'); ?></span>
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