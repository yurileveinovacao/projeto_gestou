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
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Eventos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">

                    <!-- CARD HEADER -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Eventos</h6>
                    </div>

                    <!-- INICIO CARD BODY -->
                    <div class="card-body">

                        <!-- INICIO TABLE RESPONSIVE -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">

                                    <div class="col-sm-12 button-tabela">

                                        <button type="button" id="btn-incluir" name="btn-incluir" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button></a>
                                        <button type="button" id="btn-voltar" name="btn-voltar" data-toggle="tooltip" title="Voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button>

                                    </div>

                                    <tr>
                                        <th data-orderable="false" class="coluna-nome">Cod. Evento</th>
                                        <th data-orderable="false">Nome</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Ação</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="coluna-nome">Cod. Evento</th>
                                        <th>Nome</th>
                                        <th>Ação</th>
                                    </tr>
                                </tfoot>

                                <tbody class="texto-table-body">
                                    <?php foreach (selectGESEVE_EVENTOS($id_emp_default) as $row_eventos) {

                                        if (!empty($row_eventos)) { ?>

                                            <tr <?php if ($row_eventos["tipo"] == 'P') {
                                                    echo 'style="background-color: #ffffbf;"';
                                                } ?>>
                                                <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['codevento']; ?></span></td>
                                                <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['nome']; ?></span></td>
                                                <td style="text-align: center" class="linha-altura">
                                                    <?php

                                                    switch ($row_eventos["tipo"]) {

                                                        case 'P':

                                                    ?>

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-secondary vencimento" title="Vencimento"><i class="fas fa-plus"></i></button>
                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-secondary desconto" title="Desconto"><i class="fas fa-minus"></i></button>

                                                            <!-- INICIO REFERENCIA -->
                                                            <?php

                                                            if ($row_eventos["usaref"] == "S") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-primary usaref" title="Utiliza referência"><i class="far fa-check-square"></i></button>

                                                            <?php

                                                            } elseif ($row_eventos["usaref"] == "N") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-danger usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-secondary usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            }

                                                            ?>
                                                            <!-- FIM REFERENCIA -->

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-primary excluir" title="Excluir evento"><i class="far fa-trash-alt"></i></button>

                                                        <?php

                                                            break;
                                                        case 'D':

                                                        ?>

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-secondary vencimento" title="Vencimento"><i class="fas fa-plus"></i></button>
                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-danger desconto" title="Desconto"><i class="fas fa-minus"></i></button>

                                                            <!-- INICIO REFERENCIA -->
                                                            <?php

                                                            if ($row_eventos["usaref"] == "S") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-primary usaref" title="Utiliza referência"><i class="far fa-check-square"></i></button>

                                                            <?php

                                                            } elseif ($row_eventos["usaref"] == "N") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-danger usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-secondary usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            }

                                                            ?>
                                                            <!-- FIM REFERENCIA -->

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-primary excluir" title="Excluir evento"><i class="far fa-trash-alt"></i></button>

                                                        <?php

                                                            break;
                                                        case 'V':

                                                        ?>

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-primary vencimento" title="Vencimento"><i class="fas fa-plus"></i></button>
                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-secondary desconto" title="Desconto"><i class="fas fa-minus"></i></button>

                                                            <!-- INICIO REFERENCIA -->
                                                            <?php

                                                            if ($row_eventos["usaref"] == "S") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-primary usaref" title="Utiliza referência"><i class="far fa-check-square"></i></button>

                                                            <?php

                                                            } elseif ($row_eventos["usaref"] == "N") {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-danger usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" ref="<?php echo $row_eventos["usaref"]; ?>" class="btn btn-secondary usaref" title="Não utiliza referência"><i class="far fa-square"></i></button>

                                                            <?php

                                                            }

                                                            ?>
                                                            <!-- FIM REFERENCIA -->

                                                            <button type="button" id_eve="<?php echo $row_eventos["id_eve"]; ?>" class="btn btn-primary excluir" title="Excluir evento"><i class="far fa-trash-alt"></i></button>

                                                    <?php

                                                            break;
                                                    } ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                    <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                </tbody>
                            </table>
                            <!-- FIM TBODY E TABLE -->
                        </div>
                        <!-- FIM TABLE RESPONSIVE -->

                    </div>
                    <!-- FIM CARD BODY -->

                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- FOOTER -->
        <?php include_once "footer.php"; ?>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

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
    function btn_excluir_disabled() {

        Swal.fire({
            title: 'Atenção!',
            text: 'Função desabilitada no momento!',
            icon: 'info'
        });

    }

    // AÇÃO BOTÃO INCLUIR
    $(document).ready(function() {
        $(document).on('click', '#btn-incluir', function() {

            // DIRECIOINA PARA A PÁGINA INDEX
            location.href = "incluir_eventos";
        });
    });
    // AÇÃO BOTÃO VOLTAR
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            // DIRECIOINA PARA A PÁGINA INDEX
            location.href = "index";
        });
    });

    // AÇÃO DE DESCONTO NO EVENTO
    $(document).ready(function() {
        $(document).on('click', '.desconto', function() {

            // ATRIBUIÇÃO DE VARIAVEL PELO ATRIBUTO
            var id_eve_desconto = $(this).attr("id_eve");

            // IF SE A VARIAVEL NÃO ESTÁ VAZIA
            if (id_eve_desconto !== '') {
                var dados = {
                    id_eve_desconto: id_eve_desconto
                };
                $.post('cadastro_eventos.php', dados, function(retorna) {

                    location.href = 'cadastro_eventos';

                });
            }
        });
    });

    // AÇÃO DE VENCIMENTO NO EVENTO
    $(document).ready(function() {
        $(document).on('click', '.vencimento', function() {

            // ATRIBUIÇÃO DE VARIAVEL PELO ATRIBUTO
            var id_eve_vencimento = $(this).attr("id_eve");

            // IF SE A VARIAVEL NÃO ESTÁ VAZIA
            if (id_eve_vencimento !== '') {
                var dados = {
                    id_eve_vencimento: id_eve_vencimento
                };
                $.post('cadastro_eventos.php', dados, function(retorna) {

                    location.href = 'cadastro_eventos';

                });
            }
        });
    });

    // AÇÃO DE REFERÊNCIA NO EVENTO
    $(document).ready(function() {
        $(document).on('click', '.usaref', function() {

            // ATRIBUIÇÃO DE VARIAVEL PELO ATRIBUTO
            var id_eve_usaref = $(this).attr("id_eve");
            var ref_usaref = $(this).attr("ref");

            if (ref_usaref == 'S') {

                ref_usaref = 'N';

            } else {

                ref_usaref = 'S';

            }

            // IF SE A VARIAVEL NÃO ESTÁ VAZIA
            if ((id_eve_usaref !== '') && (ref_usaref !== '')) {
                var dados = {
                    id_eve_usaref: id_eve_usaref,
                    ref_usaref: ref_usaref
                };
                $.post('cadastro_eventos.php', dados, function(retorna) {

                    location.href = 'cadastro_eventos';

                });
            }
        });
    });

    // AÇÃO DE EXCLUSÃO NO EVENTO
    $(document).ready(function() {
        $(document).on('click', '.excluir', function() {

            Swal.fire({
                title: 'Atenção!',
                text: 'Deseja excluir o evento?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#28a745',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // ATRIBUIÇÃO DE VARIAVEL PELO ATRIBUTO
                    var id_eve_excluir = $(this).attr("id_eve");

                    // IF SE A VARIAVEL NÃO ESTÁ VAZIA
                    if (id_eve_excluir !== '') {
                        var dados = {
                            id_eve_excluir: id_eve_excluir
                        };
                        $.post('exclui_eventos.php', dados, function(retorna) {

                            if (retorna == 1) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso',
                                    text: 'Registro(s) excluído(s) com sucesso!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = 'cadastro_eventos';
                                    }
                                })

                            }
                            if (retorna == 2) {

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atenção',
                                    text: 'O(s) Registro(s) selecionados tem vínculo com outra tabela!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = 'cadastro_eventos';
                                    }
                                })

                            }

                            if (retorna == 3) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: 'Erro desconhecido, consultar tabela de códigos!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = 'cadastro_eventos';
                                    }
                                })

                            }

                        });
                    }

                }
            });

        });
    });
</script>

<?php

if (isset($_POST['id_eve_desconto'])) {
    try {
        $tipo = 'D';
        $id_eve = $_POST['id_eve_desconto'];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_POST['id_eve_vencimento'])) {
    try {
        $tipo = 'V';
        $id_eve = $_POST['id_eve_vencimento'];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if ((isset($_POST['id_eve_usaref'])) and (isset($_POST['ref_usaref']))) {
    try {

        $id_eve_usaref = $_POST['id_eve_usaref'];
        $ref_usaref = $_POST['ref_usaref'];

        updateGESEVE_usaref($ref_usaref, $id_eve_usaref, $datatu, $id_usa_default);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
?>