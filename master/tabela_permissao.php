<?php

require_once 'restrito.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

unset($_SESSION["id_usa_selecionado"]);
unset($_SESSION["nome_usa_selecionado"]);
unset($_SESSION["id_emp_selecionado"]);
unset($_SESSION["nome_emp_selecionado"]);

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
                        <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
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
                                        <a href="index"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                    </div> 

                                        <tr>
                                            <th class="text-left coluna-nome" >Id usa</th>
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

                                        foreach (select_GESUSA_usuarios_adm(2) as $linha) {
                                            if ($linha != 0) {
                                                $s_id_usa = $linha['id_usa'];
                                                $s_nome = $linha['nome'];
                                                $s_email = $linha['email'];

                                        ?>

                                                <tr>
                                                    <td>
                                                        <span class="text-primary tamanho-text text-center"><?php echo $s_id_usa; ?></span>
                                                    </td>                                                
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $s_nome; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $s_email; ?></span>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <!-- <button type="button" id_usa="?php echo $s_id_usa; ?>" nome="?php echo $s_nome; ?>" class="btn btn-primary view_data" title="Liberar telas"><i class="fas fa-unlock"></i></button> -->
                                                        <button type="button" id="btn-permissao" id_usa="<?php echo $s_id_usa; ?>" nome="<?php echo $s_nome; ?>" class="btn btn-primary" title="Liberar telas"><i class="fas fa-unlock"></i></button>
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
            // alert(id_recebido);
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

    //Clique botão btn-permissao
    $(document).ready(function() {
    $(document).on('click', '#btn-permissao', function() {
        var id_usa =  $(this).attr("id_usa");
        var nome_usa =  $(this).attr("nome");
        var id_emp_selecionado = 0;
        var nome_emp_selecionado = "Padrão";
        //verificar se há valor nas variaveis
        if (id_usa !== '') {
            var dados = {
                id_usa: id_usa,
                nome_usa: nome_usa,
                id_emp_selecionado: id_emp_selecionado,
                nome_emp_selecionado: nome_emp_selecionado
            };
            // alert("Cliquei btn-permissao: " +  id_usa + ' - ' + nome_usa);
            $.post('adicionar_permissao', dados, function(retorna) {
            location.href = "adicionar_permissao";
            });
        }
        });
    });
</script>
