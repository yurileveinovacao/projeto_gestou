<?php

require_once 'restrito.php';
require_once 'iuds_pdo.php';

unset($_SESSION["id_emp_master"]); // reset variavel de sessao para limpar o valor caso tenha editado uma empresa antes
unset($_SESSION["tabela_empresas"]["tokens"]);
unset($_SESSION["tabela_empresas"]["id_emp_editar"]);
unset($_SESSION["tabela_empresas"]["id_emp_matriz"]);
unset($_SESSION["adicionar_filial"]["id_emp_filial"]);

unset($_SESSION["alterar_empresa"]["nav_tab"]);

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

    <title>GESTOU PORTAL - Tabela Empresas</title>

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

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Menu Lateral -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Barra Superior -->
                <?php include_once 'barra_superior.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <!-- Card Header -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Empresas</h6>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <!-- Table Responsive -->
                            <div class="table-responsive">

                                <!-- Tabela -->
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                    <!-- Thead -->
                                    <thead style="text-align: center;">

                                        <!-- Botões Superiores Tabela -->
                                        <div class="col-sm-12 button-tabela">
                                            <!-- <button id="btn-excluir" disabled class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button> -->
                                            <button id="btn-grupo" disabled class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-square"></i> Adicionar Grupo</button>
                                            <button id="btn-filial" disabled class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-clone"></i> Adicionar Filial</button>
                                            <button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div>

                                        <!-- Linhas do Cabeçalho da Tabela -->
                                        <tr>
                                            <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox">
                                                <input id="todos_check" type="checkbox"></input>
                                            </th>
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false">Nome Fantasia</th>
                                            <th data-orderable="false">CNPJ</th>
                                            <th data-orderable="false" style="width: 25%;">Endereço</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click" style="width: 5%">Situação</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click" style="width: 5%">Ações</th>
                                        </tr>
                                    </thead>

                                    <!-- Tfoot -->
                                    <tfoot>

                                        <!-- Linhas do Footer -->
                                        <tr>
                                            <th></th>
                                            <th class="coluna-nome">Nome</th>
                                            <th>Nome Fantasia</th>
                                            <th>CNPJ</th>
                                            <th>Endereço</th>
                                            <th>Situação</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>

                                    <!-- Tbody -->
                                    <tbody class="texto-table-body">
                                        <?php foreach (selectGESEMP_ALL() as $linha) {

                                            if (!empty($linha)) {

                                                $token = bin2hex(random_bytes(16));

                                                $_SESSION["tabela_empresas"]["tokens"][$token]["id_emp"] = $linha['id_emp'];

                                                $nome = $linha['nome'];
                                                $nomefantasia = $linha['nomefantasia'];
                                                $cnpj = $linha['cnpj'];
                                                $endereco = $linha['endereco'];
                                                $situac = $linha['situac'];
                                        ?>

                                                <!-- Linhas da Tabela com o TOKEN da empresa -->
                                                <tr data-token="<?php echo $token; ?>">

                                                    <!-- Colunas -->
                                                    <td class="coluna-checkbox">
                                                        <input type="checkbox" class="checkbox_main"></input>
                                                    </td>
                                                    <td><span class="m-0 text-primary tamanho-text"><?php echo $nome; ?></span></td>
                                                    <td><?php echo $nomefantasia; ?></td>
                                                    <td class="text-center"><?php echo $cnpj; ?></td>
                                                    <td><?php echo $endereco; ?></td>

                                                    <!-- Coluna Situac -->
                                                    <td class="text-center">

                                                        <?php
                                                        // Define a classe CSS do span com base no valor de $situac
                                                        $span_class = $situac ? 'text-success' : 'text-danger';

                                                        // Define a classe CSS do ícone (i) com base no valor de $situac
                                                        $i_class = $situac ? 'bx bxs-toggle-right bx-lg' : 'bx bxs-toggle-left bx-lg';

                                                        // Define o título do ícone com base no valor de $situac
                                                        $title = $situac ? 'Ativo' : 'Inativo';
                                                        ?>

                                                        <!-- Span com a classe CSS e o título dinâmicos -->
                                                        <span class="<?php echo $span_class; ?> cursor-pointer" id="btn-situac" data-situac="<?php echo $situac; ?>">
                                                            <!-- Ícone com a classe CSS dinâmica e o título dinâmico -->
                                                            <i class='<?php echo $i_class; ?>' title="<?php echo $title; ?>"></i>
                                                        </span>
                                                    </td>

                                                    <!-- Coluna Ações -->
                                                    <td class="text-center">

                                                        <!-- Botão com ação de redirecionar para a tela de editar -->
                                                        <button type="button" id="btn-edit" class="btn btn-primary btn-icones" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                            // Fim IF
                                        }
                                        // Fim Foreach
                                        ?>
                                    </tbody>
                                    <!-- Fim Tbody -->

                                </table>
                                <!-- Fim Table -->

                            </div>
                            <!-- Fim Table Responsive -->

                        </div>
                        <!-- Fim Card Body -->

                    </div>
                    <!-- Fim Datatables Example -->

                </div>
                <!-- End of Begin Page Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once 'footer.php' ?>

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

    <!-- Script da Página -->
    <script src="scripts/tabela_empresas.js?version=<? echo time(); ?>"></script>

</body>

</html>