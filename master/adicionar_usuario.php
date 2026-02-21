<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_emp = $_SESSION["tabela_empresas"]["id_emp_matriz"];

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

    <title>GESTOU PORTAL - Adicionar Usuário</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <?php if (!isset($id_emp)) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados da empresa!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'tabela_empresas';
                                }
                                });
                                </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Adicionar Usuário</h6>
                        </div>

                        <div class="card-body">

                            <!-- TAB Empresas Disponiveis -->
                            <div class="col-md-12" style="height: 300px; overflow: auto; scrollbar-width: thin; margin-bottom: 16px;">
                                <div style="min-height: 100%; max-height: auto; border: 1px solid #e3e6f0; border-top: none;">
                                    <table id="tabela-usuarios" class="table sortable" width="100%" cellspacing="0" style="margin-bottom: 0;">
                                        <thead style="text-align: center;">
                                            <tr class="list-head">
                                                <th data-orderable="false" style="border-right: 1px solid #e3e6f0;">Nome</th>
                                                <th data-orderable="false">CPF</th>
                                            </tr>
                                        </thead>

                                        <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                            <?php foreach (selectGESGES_inclusao($id_emp) as $linha) {

                                                $token = bin2hex(random_bytes(16));

                                                $_SESSION["adicionar_usuario"]["tokens"][$token]["id_usa"] = $linha['id_usa'];

                                                $nome_tab = $linha['nome'];
                                                $cpf_tab = $linha['cpf'];

                                                if (!empty($linha['id_usa'])) { ?>

                                                    <tr data-token="<?php echo $token ?>" class="list-gestor" style="border-bottom: 1px solid #e3e6f0;">
                                                        <th style="border-right: 1px solid #e3e6f0;"><?php echo '<b>' . $nome_tab . '</b>'; ?></th>
                                                        <th style="text-align: center"><?php echo $cpf_tab; ?></th>

                                                    </tr>

                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- BOTÃO FORM -->
                            <div class="textalign-right">
                                <button id="btn-add-usuario" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-check"></i> Adicionar</button>
                                <button id="btn-new-usuario" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus"></i> Novo</button>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- partial -->
            <script src="./croppie/script_empresa.js"></script>

            <script src="scripts/adicionar_usuario.js?version=<? echo time(); ?>"></script>

</body>

</html>