<?php
require_once 'restrito.php';
require_once 'conexao.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

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
                            <h6 class="m-0 font-weight-bold text-primary">Itens Lote</h6>
                        </div>
                        <div class="card-body">

                            <!-- Div principal-->
                            <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none; user-select: none" id="dvPrincipal">

                                <div class="form-group mt-3">
                                    <label>Situação:</label>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio0" name="radio" value="N" data-cad="nao-liberado" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio0">Não Liberado</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio1" name="radio" value="A" data-cad="aguardando" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio1">Aguardando Aceite</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio2" name="radio" value="P" data-cad="pendente" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio2">Pendente</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio3" name="radio" value="V" data-cad="visualizado" onclick="inativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio3">Visualizado</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio4" name="radio" value="T" data-cad="todos" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio4">Todos</label>
                                    </div>

                                </div>

                            </div>
                            <!-- Fim Div principal-->

                            <?php

                            $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';

                            foreach (selectARQUIVO_VIEW($tabela, $id_processamento) as $totalLinha) {
                                if ($totalLinha != 0) {
                                    $arquivo = $totalLinha['arquivo'];
                                }
                            }
                            ?>

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead>
                                            <div class="col-sm-12 button-tabela">
                                                <button id="btnExibeOcultaDiv" class="btn btn-primary"><i class="fas fa-filter"></i> Filtros</button>
                                                <button type="submit" id="btn-excluir" name="btn-excluir" disabled onclick="return confirm('Tem certeza que deseja excluir o(s) registro(s) selecionado(s)?'); return false;" class="btn btn-organograma btn-icon-split-organograma" title="Excluir"><i class="fas fa-trash-alt"></i> Excluir</button>
                                                <a href="lotes_processados"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar para os lotes" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>
                                            </div>
                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox">
                                                    <input id="checkTodos" type="checkbox" name="checkbox[]" title="Marcar Todos"></input>
                                                </th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false" style="width:10%">Ano Cal.</th>
                                                <th data-orderable="false" style="width:10%">Ano Exe.</th>

                                                <?php

                                                if (empty($arquivo)) {

                                                ?>

                                                    <th data-orderable="false" style="width:10%">Renda</th>

                                                <?php

                                                }

                                                ?>

                                                <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:15%">Situação</th>

                                                <?php

                                                if (!empty($arquivo)) {

                                                ?>

                                                    <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:15%">Ações</th>

                                                <?php

                                                }

                                                ?>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>Ano Cal.</th>
                                                <th>Ano Exe.</th>

                                                <?php

                                                if (empty($arquivo)) {

                                                ?>

                                                    <th>Renda</th>

                                                <?php

                                                }

                                                ?>

                                                <th style="text-align: center;">Situação</th>

                                                <?php

                                                if (!empty($arquivo)) {

                                                ?>

                                                    <th style="text-align: center;">Ações</th>

                                                <?php

                                                }

                                                ?>

                                            </tr>
                                        </tfoot>
                                        <tbody class="texto-table-body informes">
                                            <!-- CORPO DA TABELA COM TODOS -->
                                            <?php

                                            foreach (selectIMPOSTO_RENDA($raiz_cnpj, $id_processamento) as $linha) {
                                                if ($linha != 0) {
                                                    $situac = $linha['situac'];
                                                    $situac_visualizar = $linha['situac_visualizar'];

                                                    if (!empty($linha["arquivo"])) {
                                            ?>

                                                        <!-- IF SITUAC == 0 -->
                                                        <?php if ($situac == 0) { ?>

                                                            <tr class="informe nao-liberado">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <?php

                                                                if (empty($arquivo)) {

                                                                ?>

                                                                    <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <?php

                                                                }

                                                                ?>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">NÃO LIBERADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <button type="button" class="btn btn-outline-primary visualizar_pdf" id_irr="<?php echo $id_detalhar = $linha['id_irr']; ?>" title="Detalhes Item">Detalhe</button>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 0 -->

                                                        <!-- IF SITUAC == 1 -->
                                                        <?php if ($situac == 1) { ?>

                                                            <tr class="informe aguardando">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <?php

                                                                if (empty($arquivo)) {

                                                                ?>

                                                                    <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <?php

                                                                }

                                                                ?>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">AGUARDANDO ACEITE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <button type="button" class="btn btn-outline-primary visualizar_pdf" id_irr="<?php echo $id_detalhar = $linha['id_irr']; ?>" title="Detalhes Item">Detalhe</button>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 1 -->

                                                        <!-- IF SITUAC == 2 AND SITUAC_VISUALIZAR == 0 -->
                                                        <?php if (($situac == 2) and ($situac_visualizar == 0)) { ?>

                                                            <tr class="informe pendente">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <?php

                                                                if (empty($arquivo)) {

                                                                ?>

                                                                    <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <?php

                                                                }

                                                                ?>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-warning btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">PENDENTE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <button type="button" class="btn btn-outline-primary visualizar_pdf" id_irr="<?php echo $id_detalhar = $linha['id_irr']; ?>" title="Detalhes Item">Detalhe</button>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 2 AND SITUAC_VISUALIZAR == 0 -->

                                                        <!-- IF SITUAC == 2 AND SITUAC_VISUALIZAR == 1 -->
                                                        <?php if (($situac == 2) and ($situac_visualizar == 1)) { ?>

                                                            <tr class="informe visualizado">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" disabled></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <?php

                                                                if (empty($arquivo)) {

                                                                ?>

                                                                    <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <?php

                                                                }

                                                                ?>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-info btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="far fa-eye"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">VISUALIZADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <button type="button" class="btn btn-outline-primary visualizar_pdf" id_irr="<?php echo $id_detalhar = $linha['id_irr']; ?>" title="Detalhes Item">Detalhe</button>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 2 AND SITUAC_VISUALIZAR == 1 -->

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <!-- IF SITUAC == 0 -->
                                                        <?php if ($situac == 0) { ?>

                                                            <tr class="informe nao-liberado">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">NÃO LIBERADO</span>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 0 -->

                                                        <!-- IF SITUAC == 1 -->
                                                        <?php if ($situac == 1) { ?>

                                                            <tr class="informe aguardando">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">AGUARDANDO ACEITE</span>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 1 -->

                                                        <!-- IF SITUAC == 2 AND SITUAC_VISUALIZAR == 0 -->
                                                        <?php if (($situac == 2) and ($situac_visualizar == 0)) { ?>

                                                            <tr class="informe pendente">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" name="checkbox[]" value="<?php echo $id_irr = $linha['id_irr']; ?>" title="<?php echo $id_irr; ?>"></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-warning btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">PENDENTE</span>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 2 AND SITUAC_VISUALIZAR == 0 -->

                                                        <!-- IF SITUAC == 2 AND SITUAC_VISUALIZAR == 1 -->
                                                        <?php if (($situac == 2) and ($situac_visualizar == 1)) { ?>

                                                            <tr class="informe visualizado">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" disabled></input>
                                                                </td>
                                                                <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anocal']; ?></td>
                                                                <td style="text-align: center;"><?php echo $linha['anoexe']; ?></td>

                                                                <td style="text-align: center;"><?php echo $linha['ren_3_1']; ?></td>

                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-info btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="far fa-eye"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">VISUALIZADO</span>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM IF SITUAC == 2 AND SITUAC_VISUALIZAR == 1 -->

                                            <?php

                                                    }
                                                }
                                            }

                                            ?>
                                            <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                        </tbody>
                                    </table>
                            </form>
                            <!-- FIM TBODY E TABLE -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------------------------------- -->

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

<div id="visuDetalheModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Itens de Holerite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visuDetalheHolerite"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('input:disabled').prop('checked', false);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    $("#btnExibeOcultaDiv").click(function(e) {
        e.preventDefault(); // evita que o formulário seja submetido
        $("#dvPrincipal").toggle();
    });

    $('.btn1').on('click', function() {
        var cat = $(this).attr('data-cad')
        // if (cat == 'reprovado') {
        //     $('.recibo tr').show()
        // }
        if (cat == 'todos') {
            $('.informes tr').show()
        } else {
            $('.informe').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    })

    function inativa_checktodos() {

        $('#checkTodos').prop('disabled', true);
        $('#checkTodos').prop('checked', false);
        $('#btn-excluir').prop('disabled', true);
        $("[name='checkbox[]']:checked").prop("checked", false);

    }

    function ativa_checktodos() {

        $('#checkTodos').prop('disabled', false);
        $('#checkTodos').prop('checked', false);
        $('#btn-excluir').prop('disabled', true);
        $("[name='checkbox[]']:checked").prop("checked", false);

    }

    function sem_delete() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível deletar o(s) item(s)!'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'itens_lotei?vw=<?php echo $_SESSION['id_processamento'] ?>';
            }
        })

    }

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.visualizar_pdf', function() {
            var id_recebido = $(this).attr("id_irr");
            var opcao = "visualizar_pdf"
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if ((id_recebido !== '') && (opcao !== '')) {
                var dados = {
                    id_recebido: id_recebido,
                    opcao: opcao
                };
                $.post('visualizar_irrf_arquivo', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuDetalheHolerite").html(retorna);
                    $('#visuDetalheModal').modal('show');

                });
            }
        });
    });
</script>

<?php

if (isset($_REQUEST['btn-excluir'])) {
    try {

        // require 'conexao.php';

        $id_irr_excluir;

        if (0 == 0) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                $s = [];
                foreach ($_POST as $chave => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $ch => $va) {
                            if ($va != 'on') {
                                // echo $va.',';
                                $id_irr_excluir = $id_irr_excluir . $va . ',';
                            }
                        }
                    }
                }
            }

            if (empty($id_irr_excluir)) {

                echo "<script>
                sem_delete();
                </script>";
            } else {

                $tabela = "GESIRR_" . $raiz_cnpj . "";
                $campo = "id_irr";

                $id_irr_excluir = substr($id_irr_excluir, 0, -1);
                $resultArr = explode(',', $id_irr_excluir);

                switch (delete_id_in($resultArr, $tabela, $campo)) {
                    case 1: //delete executado
                        echo "<script language=javascript>
                    alert('Registro(s) excluido(s) com sucesso!');
                    location.href='itens_lotei?vw=" . $_SESSION['id_processamento'] . "';
                    </script>";
                        break;
                        // case 23503: //erro fk
                        //     echo "<script language=javascript>
                        //     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
                        //     location.href='tabela_funcionarios';
                        //     </script>";
                        //     break;
                    default:
                        echo "<script language=javascript>
                    alert('Erro desconhecido, consultar tabela de códigos!');
                    location.href='itens_lotei?vw=" . $_SESSION['id_processamento'] . "';
                    </script>";
                }
            }
        } else {

            echo "<script>
            sem_delete();
        </script>";
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// if (isset($_REQUEST['ex'])) {
//     try {

//         $id_irr = $_REQUEST["ex"];

//         deleteGESIRR($raiz_cnpj, $id_irr);

//         echo "<script language=javascript>
//         alert('Item deletado com sucesso!');
//         location.href='itens_lotei?vw=" . $_SESSION['id_processamento'] . "';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>