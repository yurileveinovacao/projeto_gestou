<?php

require_once 'restrito.php';
require_once __DIR__.'/../../config/database.php';
require_once 'raiz_cnpj_pdo.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

$tabela1 = 'public."GESIM1_' . $raiz_cnpj . '"';
$tabela2 = 'public."GESIM2_' . $raiz_cnpj . '"';

?>

<?php

try {
    //REQUEST DA PÁGINA ANTERIOR
    if (isset($_REQUEST['vw'])) {
        $_SESSION['id_processamento'] = $_REQUEST['vw'];
        $id_processamento = $_SESSION['id_processamento'];
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

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

    <title>GESTOU PORTAL - Início</title>

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
                            <h6 class="m-0 font-weight-bold text-primary">Definição dos eventos</h6>
                        </div>
                        <div class="card-body">

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <a href="lotes_processados"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar para os lotes" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>

                                            </div>

                                            <tr>
                                                <!-- <th data-orderable="false"
                                                    class="sorttable_nosort nao_click coluna-checkbox"><input
                                                        id="checkTodos" type="checkbox" name="checkbox[]"></input></th> -->
                                                <th data-orderable="false" class="coluna-nome">Cod. Evento</th>
                                                <th data-orderable="false">Nome</th>
                                                <th data-orderable="false" width="15%">Ação</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th class="coluna-nome">Cod. Evento</th>
                                                <th>Nome</th>
                                                <th>Ação</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <!-- <tbody class="linha-altura"> -->

                                            <?php foreach (selectGESEVE_ID_PROCESSAMENTO($id_emp_default, $raiz_cnpj, $id_processamento) as $row_eventos) { ?>

                                                <?php if ($row_eventos['tipo'] == 'P') { ?>
                                                    <tr style="background-color: #ffffbf;">
                                                    <?php } else { ?>
                                                    <tr> <?php } ?>
                                                    <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['codevento']; ?></span></td>
                                                    <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['nome']; ?></span></td>
                                                    <td style="text-align: center" class="linha-altura">
                                                        <?php if ($row_eventos['tipo'] == 'P') { ?>

                                                            <a href="tabela_eventos?ve=<?php echo $row_eventos["id_eve"]; ?>"><button type="button" class="btn btn-secondary" title="Vencimento"><i class="fas fa-plus"></i></button></a>
                                                            <a href="tabela_eventos?de=<?php echo $row_eventos["id_eve"]; ?>"><button type="button" class="btn btn-secondary" title="Desconto"><i class="fas fa-minus"></i></button></a>

                                                        <?php }
                                                        if ($row_eventos['tipo'] == 'D') { ?>

                                                            <a href="tabela_eventos?ve=<?php echo $row_eventos["id_eve"]; ?>"><button type="button" class="btn btn-secondary" title="Vencimento"><i class="fas fa-plus"></i></button></a>
                                                            <button type="button" class="btn btn-danger" title="Desconto"><i class="fas fa-minus"></i></button>

                                                        <?php }
                                                        if ($row_eventos['tipo'] == 'V') { ?>

                                                            <button type="button" class="btn btn-primary" title="Vencimento"><i class="fas fa-plus"></i></button>
                                                            <a href="tabela_eventos?de=<?php echo $row_eventos["id_eve"]; ?>"><button type="button" class="btn btn-secondary" title="Desconto"><i class="fas fa-minus"></i></button></a>

                                                        <?php } ?>
                                                    </td>
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

</body>

</html>

<?php

if (isset($_REQUEST['de'])) {
    try {
        $tipo = 'D';
        $id_eve = $_REQUEST['de'];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_eventos?vw=" . $_SESSION["id_processamento"] . "';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['ve'])) {
    try {
        $tipo = 'V';
        $id_eve = $_REQUEST['ve'];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_eventos?vw=" . $_SESSION["id_processamento"] . "';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
