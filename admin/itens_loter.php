<?php
require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Item Lote</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead>
                                        <div class="col-sm-12 button-tabela">
                                            <a href="lotes_processados"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar para os lotes" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>
                                        </div>
                                        <tr>
                                            <th data-orderable="false" class="coluna-nome sorttable_nosort nao_click">Nome</th>
                                            <th data-orderable="false" style="width:25%">Descrição / Arquivo</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:15%">Situação</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:15%">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="coluna-nome">Nome</th>
                                            <th>Descrição / Arquivo</th>
                                            <th style="text-align: center;">Situação</th>
                                            <th style="text-align: center;">Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="texto-table-body">
                                        <!-- CORPO DA TABELA COM TODOS -->

                                        <?php

                                        foreach (selectRECIBOS_DIVERSOS($raiz_cnpj, $id_processamento) as $linha) {
                                            if ($linha == 0) {
                                            } else {
                                        ?>
                                                <?php
                                                $situac = $linha['situac'];
                                                $situac_visualizar = $linha['situac_visualizar'];
                                                ?>
                                                <tr>
                                                    <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                    <td><?php echo $linha['descricao']; ?> / <?php echo $linha['origem']; ?></td>
                                                    <?php if ($situac == 0) {    ?>

                                                        <td style="text-align: center;">
                                                            <div class="btn btn-secondary btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">NÃO LIBERADO</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <?php if ($situac == 1) {    ?>

                                                        <td style="text-align: center;">
                                                            <div class="btn btn-secondary btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">AGUARDANDO ACEITE</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <?php if (($situac == 2) && ($situac_visualizar == 0)) {    ?>

                                                        <td style="text-align: center;">
                                                            <div class="btn btn-warning btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">PENDENTE</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <?php if (($situac == 2) && ($situac_visualizar == 1)) {    ?>

                                                        <td style="text-align: center;">
                                                            <div class="btn btn-info btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="far fa-eye"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">VISUALIZADO</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <?php if ($situac == 3) {    ?>

                                                        <td style="text-align: center;">
                                                            <div class="btn btn-success btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">APROVADO</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <?php if ($situac == 4) {    ?>
                                                        <td style="text-align: center;">
                                                            <div class="btn btn-danger btn-icon width-100">
                                                                <span class="icon text-white-30">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">REPROVADO</span>
                                                            </div>
                                                        </td>
                                                    <?php  } ?>

                                                    <td style="text-align: center;">

                                                        <button type="button" data-toggle="modal" data-target="#Visualizar" name="modal" class="btn btn-outline-primary" title="Visualizar Item">Visualizar</button>

                                                        <?php

                                                        if ((empty($linha["motrep"])) and (empty($linha["resprep"]))) {

                                                        ?>

                                                            <button type="button" class="btn btn-outline-secondary sem-mensagens" title="Sem Mensagens"><i class="fas fa-comment-dots"></i></button>

                                                        <?php

                                                        } else {

                                                        ?>

                                                            <button type="button" class="btn btn-outline-primary mensagens" id_rec="<?php echo $id_detalhar = $linha['id_rec']; ?>" id_usu="<?php echo $linha['id_usu']; ?>" title="Visualizar Mensagens"><i class="fas fa-comment-dots"></i></button>

                                                        <?php

                                                        }

                                                        ?>

                                                    </td>

                                                </tr>

                                        <?php
                                            }
                                        }

                                        ?>
                                        <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Visualizar Organograma Modal-->
            <div class="modal fade" id="Visualizar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Visualizar">Visualizar</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <?php

                                foreach (select_GESREC_arquivo($raiz_cnpj, $id_processamento) as $arquivo_banco) {

                                    $arquivo = $arquivo_banco["arquivo"];
                                }

                                ?>

                                <div class="col-md-12">

                                    <iframe style="width: 100%; height: 600px;" src="../upload/beneficios/recibos_diversos/<?php echo $raiz_cnpj; ?>/<?php echo $arquivo; ?>"></iframe>

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------------------------------------------------------------------------- -->

            <div id="visuMensagensModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable h-100" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mensagens Holerite</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="visuMensagensHolerite"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
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

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<script>
    $("#btnExibeOcultaDiv").click(function(e) {
        e.preventDefault(); // evita que o formulário seja submetido
        $("#dvPrincipal").toggle();
    });
</script>

<script>
    function sem_delete() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível deletar o item pois ele já foi visualizado / assinado pelo usuário!'
        });

    }

    //Clique do botão detalhe quando não existirem mensagens
    $(document).ready(function() {
        $(document).on('click', '.sem-mensagens', function() {

            Swal.fire({
                icon: "info",
                title: "Info",
                title: 'Atenção!',
                text: 'Não existem mensagens entre colaborador / empresa nesse lote!'
            });

        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.mensagens', function() {
            var id_recebido = $(this).attr("id_rec");

            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
                var dados = {
                    id_recebido: id_recebido
                };
                $.post('mensagens_recibo_diversos', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuMensagensHolerite").html(retorna);
                    $('#visuMensagensModal').modal('show');

                });
            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn-resprep', function() {
            var resprep = $("#resprep").val();
            var id_rec = $(this).attr("id_rec");

            //verificar se há calor na variavel "id_recebido".
            if ((resprep !== '') && (id_rec !== '')) {
                var dados = {
                    resprep: resprep,
                    id_rec: id_rec
                };
                $.post('itens_loter.php', dados, function(retorna) {

                    window.location.reload();

                });
            }
        });
    });
</script>

<?php

if ((isset($_POST["resprep"])) and (isset($_POST["id_rec"]))) {

    $resprep = $_POST["resprep"];
    $id_rec = $_POST["id_rec"];

    $tabela = 'public."GESREC_' . $raiz_cnpj . '"';

    updateGESREC_resprep($tabela, $resprep, $id_usa_default, $id_rec);
}

// if (isset($_REQUEST['ex'])) {
//     try {

//         $id_rec = $_REQUEST["ex"];

//         deleteGESREC($raiz_cnpj, $id_rec);

//         echo "<script language=javascript>
//         alert('Item deletado com sucesso!');
//         location.href='itens_loter?vw=" . $_SESSION['id_processamento'] . "';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>