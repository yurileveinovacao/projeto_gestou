<?php

require_once 'restrito.php';
// require_once 'conexao.php';
// require_once 'raiz_cnpj_pdo.php';
require_once 'util.php';
require_once 'iuds_pdo.php';


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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
                            <h6 class="m-0 font-weight-bold text-primary">Tabela Aniversários</h6>
                        </div>

                        <div class="card-body">

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <a href="index"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                <!-- <a href="cadastro_funcionario"><button type="button" class="btn btn-organograma btn-icon-split-organograma" title="Incluir"><i class="fas fa-plus-circle"></i> Incluir</button></a>
                                                <button type="submit" id="btn-excluir" name="btn-excluir" disabled onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;" class="btn btn-organograma btn-icon-split-organograma" title="Excluir"><i class="fas fa-trash-alt"></i> Excluir</button> -->

                                            </div> 

                                            <tr>
                                                <th data-orderable="false" style="display: none;"></th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false">Empresa</th>
                                                <th data-orderable="false">Prox. Aniversário</th>
                                                <th data-orderable="false">Status</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>Empresa</th>
                                                <th>Prox. Aniversário</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <?php

                                            foreach (selectVW_ANIVERSARIOS() as $linha) {
                                                if ($linha != 0) {
                                            ?>

                                                    <tr>
                                                        <td style="display: none;"><?php echo $linha['rank']; ?></td>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span></td>
                                                        <td><?php echo $linha['empresa']; ?></td>
                                                        <td class="text-center">
                                                            <?php

                                                            $date = new DateTime($linha['prox_aniversario']);
                                                            echo $date->format('d/m/Y');

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($linha['status'] == "Não Enviado") { ?>
                                                                <div class="btn btn-warning btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">Não Enviado</span>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($linha['status'] == "Enviado") { ?>
                                                                <div class="btn btn-success btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="fas fa-check"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">Enviado</span>
                                                                </div>
                                                            <?php } ?>
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

            <?php include_once "footer.php"; ?>

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
<!-- <script>
    function reload_pagina() {
        var delayInMilliseconds = 100000; //1 second

        setTimeout(function() {
            //your code to be executed after 1 second
            location.href = "aniversario_grid";
        }, delayInMilliseconds);
    }
</script> -->

<?php

function Mask($mask, $str)
{

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}

?>