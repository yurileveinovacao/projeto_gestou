<?php


//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

//Atribui as variaveis locais, o valor da variaveis de sessão 
$id_mas_permissao = $_SESSION["id_mas_permissao"];
$nome_mas_permissao = $_SESSION["nome_mas_permissao"];

//Contar menus do usuario para empresa selecionada
foreach (selectCOUNT_GESMNU_master($id_mas_permissao) as $count_gesmnu) {
    $contagem = $count_gesmnu["contagem"];
}

//Se contagem diferente de zero, executar insert em GESMPR de todos menus que estão faltando
if ($contagem != 0) {
    foreach (select_TELAS_INSERT_master($id_mas_permissao) as $telas_insert) {
        insertGESMNU_add_master($id_mas_permissao, $telas_insert["id_mnu"], $datatu);
    }
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

    <title>GESTOU PORTAL - Adicionar/remover acesso</title>

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
                            <h5 class="m-0 font-weight-bold text-primary">Adicionar/remover acesso</h5>
                            <h6>ID master: <?php echo $id_mas_permissao . ' - ' . 'Nome: ' . $nome_mas_permissao ?></h6>

                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">
                                            <button type="button" id="btn-voltar" title="Clique para voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div>

                                        <tr>
                                            <th class="text-left coluna-nome">Ordem</th>
                                            <th data-orderable="false" class="coluna-nome text-left">Descrição</th>
                                            <th class="text-left coluna-nome">Id menu</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Liberado</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-left" width="10%">Ordem</th>
                                            <th class="text-left" width="70%">Descrição</th>
                                            <th class="text-left" width="10%">Id menu</th>
                                            <th class="text-center" width="10%">Liberado</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                        foreach (selectTELAS_master($id_mas_permissao) as $linha) {
                                            if ($linha != 0) {
                                                $s_id_emp = $linha['id_emp'];
                                                $s_id_usa = $linha['id_mas'];
                                                $s_id_mnu = $linha['id_mnu'];
                                                $s_descri = $linha['caminho'];
                                                $s_ordem = $linha['ordem'];
                                                $s_estagio = $linha['estagio'];
                                                $s_situac = $linha['situac'];
                                                $s_id_mps = $linha['id_mps'];

                                        ?>

                                                <tr>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text text-center"><?php echo $s_ordem; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $s_descri; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-primary tamanho-text text-center"><?php echo $s_id_mnu; ?></span>
                                                    </td>
                                                    <?php

                                                    if ($s_situac == 1) {

                                                    ?>

                                                        <td style="text-align: center"><input type="checkbox" class="btn-permissao" id="<?php echo $linha['id_mps']; ?>" id_mps="<?php echo $linha['id_mps']; ?>" checked></td>

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <td style="text-align: center"><input type="checkbox" class="btn-permissao" id="<?php echo $linha['id_mps']; ?>" id_mps="<?php echo $linha['id_mps']; ?>"></td>

                                                    <?php

                                                    }

                                                    ?>
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

</body>

</html>

<script>
    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn-permissao', function() {
            var id_mps_permissao = $(this).attr("id_mps");

            let checkbox = document.getElementById(id_mps_permissao);
            if (checkbox.checked) {
                situac_permissao = 1;
            } else {
                situac_permissao = 0;
            }

            if ((id_mps_permissao !== '') && (situac_permissao !== '')) {
                var dados = {
                    id_mps_permissao: id_mps_permissao,
                    situac_permissao: situac_permissao
                };
                $.post('controller/usuarios_master_post.php', dados, function(retorna) {});
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {
                var dados = {
                    btn_voltar: btn_voltar
                };
                $.post('controller/usuarios_master_post.php', dados, function(retorna) {

                    location.href = "usuarios_master";

                });

            }

        });
    });
</script>