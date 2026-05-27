<?php

require_once 'restrito.php';
// require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

unset($_SESSION["id_fun"]);

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

    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabela Permissão</h6>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th data-orderable="false" class="coluna-nome">Nome</th>
                                        <!-- <th data-orderable="false" class="sorttable_nosort nao_click">O Usuário é Gestor?
                                                </th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Tipo Usuário
                                                </th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Situação
                                                </th> -->
                                        <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" width="80%">Nome</th>
                                        <!-- <th class="text-center">O Usuário é Gestor?</th>
                                                <th class="text-center">Tipo Usuário</th>
                                                <th class="text-center">Situação</th> -->
                                        <th class="text-center" width="5%">Ações</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php

                                    foreach (select_GESUSA_USUARIOS($id_emp_default) as $linha) {

                                        if ($linha != 0) {
                                    ?>

                                            <tr>
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                </td>
                                                <td style="text-align:center">
                                                    <button type="button" id_usa="<?php echo $linha["id_usa"] ?>" class="btn btn-primary view_data" title="Liberar telas"><i class="fas fa-unlock"></i></button>
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

        <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document" style="width: 500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Liberação de Telas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <span id="visuTela"></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="submit" name="btn-liberar" class="btn btn-organograma">Liberar</button> -->
                        <button type="button" id="fechar-modal" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                    </div>
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

</body>

</html>

<script>
    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.view_data', function() {
            var id_recebido = $(this).attr("id_usa");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
                var dados = {
                    id_recebido: id_recebido
                };
                $.post('visualizar_telas_usuario.php', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuTela").html(retorna);
                    $('#visuModal').modal('show');

                    $(document).on('hidden.bs.modal', '#visuModal', function() {

                        window.location.reload();

                    });

                });
            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.teste', function() {
            var id_mpr = $(this).attr("id_mpr");

            let checkbox = document.getElementById(id_mpr);
            if (checkbox.checked) {

                situac = 1;

            } else {

                situac = 0;

            }

            if (id_mpr !== '') {
                var dados = {
                    id_mpr: id_mpr,
                    situac: situac
                };
                $.post('update_telas_usuario.php', dados, function(retorna) {

                });
            }
        });
    });
</script>

<?php

// if (isset($_REQUEST['btn-liberar'])) {
//     try {
//         echo "entrou try";
//         require_once __DIR__.'/../config/database.php';

//         $id_mpr;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_mpr = $id_mpr . $va . ',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_mpr = substr($id_mpr, 0, -1);
//             $resultArr = explode(',', $id_mpr);

//             switch (deleteGESUSU_in($resultArr)) {
//                 case 1: //delete executado
//                     echo "<script language=javascript>
//                     alert('Registro(s) excluido com sucesso!');
//                     location.href='tabela_usuarios';
//                     </script>";
//                     break;
//                 case 23503: //erro fk
//                     echo "<script language=javascript>
//                     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
//                     location.href='tabela_usuarios';
//                     </script>";
//                     break;
//                 default:
//                     echo "<script language=javascript>
//                     alert('Erro desconhecido, consultar tabela de códigos!');
//                     location.href='tabela_usuarios';
//                     </script>";
//             }
//         } else {
//         }
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>