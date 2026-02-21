<?php
//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

unset($_SESSION["valores"]);

if (!empty($_SESSION['filtro_lote'])) {
    unset($_SESSION['filtro_lote']);
}

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

    <title>GESTOU PORTAL - Histórico de registros</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!---------------------------------------------------------------------------------------------------------------------------------------------->
    <!-- <link href="style.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

    <!---------------------------------------------------------------------------------------------------------------------------------------------->

    <!---------------------------------------------------------------------------------------------------------------------------------------------->

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                <?php include_once 'barra_superior.php'; ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">

                        <!-- CARD HEADER -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Histórico de Registros</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <!-- Div principal-->
                            <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none; user-select: none" id="dvPrincipal">

                                <div class="form-group mt-3">
                                    <label>Tipo:</label>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio1" name="radio" value="H" data-cad="holerite" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio1">Holerite</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio2" name="radio" value="P" data-cad="ponto" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio2">Ponto</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio3" name="radio" value="I" data-cad="imposto-renda" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio3">Informe</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio4" name="radio" value="R" data-cad="recibo-diverso" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio4">Recibo</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio5">Todos</label>
                                    </div>

                                </div>

                            </div>
                            <!-- Fim Div principal-->

                            <!-- INICIO FORM -->
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                                <!-- INICIO DIV TABLE -->
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                        <!-- THEAD -->
                                        <thead>
                                            <div class="col-sm-12 button-tabela">
                                                <button type="button" id="btnExibeOcultaDiv" class="btn btn-primary"><i class="fas fa-filter"></i> Filtros</button>
                                            </div>
                                            <tr>
                                                <th data-orderable="false" style="display:none">Rank</th>
                                                <th data-orderable=" false" style="width:20%; vertical-align: middle;">Data</th>
                                                <th data-orderable="false" class="coluna-nome" style="width:40%; vertical-align: middle;">Tipo / Período / Arquivo</th>
                                                <th data-orderable="false" style="width:10%; text-align: center; vertical-align: middle;">Usuario Inclusão</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:20%; vertical-align: middle;">Ações</th>
                                            </tr>
                                        </thead>

                                        <!-- TFOOT -->
                                        <tfoot>
                                            <tr>

                                                <th style="display:none">Rank</th>
                                                <th>Data</th>
                                                <th class="coluna-nome">Tipo / Período / Arquivo</th>
                                                <th style="text-align: center;">Usuário Inclusão</th>
                                                <th style="text-align: center;">Ações</th>
                                            </tr>
                                        </tfoot>

                                        <!-- INICIO TBODY -->
                                        <tbody class="texto-table-body lotes">
                                            <?php foreach (selectLOTES_processados($raiz_cnpj, $id_emp_default) as $linha) {

                                                if ($linha != 0) {

                                                    $tipo_lote = substr($linha['tipo'], 0, 1);

                                                    $tipo_lote = strtolower($tipo_lote);

                                                    switch ($tipo_lote) {

                                                        case "h":

                                                            $tabela_regarq = 'public."GESIM1_' . $raiz_cnpj . '"';

                                            ?>

                                                            <tr class="align-middle lote holerite">

                                                            <?php

                                                            break;

                                                        case "p":

                                                            $tabela_regarq = 'public."GESPON1_' . $raiz_cnpj . '"';

                                                            ?>

                                                            <tr class="align-middle lote ponto">

                                                            <?php

                                                            break;

                                                        case "i":

                                                            $tabela_regarq = 'public."GESIRR_' . $raiz_cnpj . '"';

                                                            ?>

                                                            <tr class="align-middle lote imposto-renda">

                                                            <?php

                                                            break;

                                                        case "r":

                                                            ?>

                                                            <tr class="align-middle lote recibo-diverso">

                                                        <?php

                                                            break;
                                                    }

                                                        ?>

                                                        <td style="display:none"><?php echo $linha['rank']; ?></td>

                                                        <td class="linha-valores" style="text-align: center;"><?php echo $linha['datinc']; ?></td>

                                                        <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tipo']; ?></span></td>

                                                        <td class="linha-valores" style="text-align: center;"><?php echo $linha['nome']; ?></td>

                                                        <td class="content-xy-center">

                                                            <!-- INICIO FOREACH USUARIO -->
                                                            <?php

                                                            $id_processamento = $linha["id_processamento"];

                                                            foreach (selectVW_ADMIN_USUARIOS_id_emp_id_usa($id_emp_default, $id_usa_default) as $import_aceite) {

                                                                foreach (select_count_visualizado($raiz_cnpj, $id_processamento) as $contagem_visualizado) {

                                                                    $quantidade_visualizado = $contagem_visualizado["contagem"];
                                                                }

                                                                foreach (select_inconsistencia_irrf($raiz_cnpj, $id_processamento) as $count_inconsistencia_irrf) {

                                                                    $inconsistencia_irrf = $count_inconsistencia_irrf["contagem"];
                                                                }

                                                                if ($tipo_lote != "r") {

                                                                    foreach (select_inconsistencia_regarq($tabela_regarq, $id_processamento) as $count_inconsistencia_regarq) {

                                                                        $inconsistencia_regarq = $count_inconsistencia_regarq["contagem"];
                                                                    }
                                                                }

                                                                $tabela_regarq = 'public."GESIM1_' . $raiz_cnpj . '"';

                                                                foreach (select_inconsistencia_regarq($tabela_regarq, $id_processamento) as $contagem_inconsistencia) {

                                                                    $contagem = $contagem_inconsistencia["contagem"];
                                                                }

                                                                // BOTÃO ON OF

                                                                // IF SITUAC 1 VISUALIZADO
                                                                if ($linha["status"] == 1) {

                                                                    // IF TIPO DE ARQUIVO = H
                                                                    if ($tipo_lote == "h") { ?>

                                                                        <!-- INICIO BOTÃO ACEITAR -->
                                                                        <div class="div-acoes">

                                                                            <?php if ($import_aceite["aceitar"] == "SIM") { ?>

                                                                                <a href="lotes_processados?s2=<?php echo $tipo_lote; ?><?php echo $linha["id_processamento"]; ?>" onclick="envia_email();">
                                                                                    <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 disable content-xy-center" title="Liberar">
                                                                                        <div class="handle"></div>
                                                                                    </button>
                                                                                </a>
                                                                            <?php } else { ?>

                                                                                <!-- BOTÃO AVISO USUÁRIO SEM PERMISSÃO -->
                                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle disable content-xy-center" onclick="usuario_sem_permissao();" title="Liberar">
                                                                                    <div class="handle"></div>
                                                                                </button>
                                                                            <?php } ?>

                                                                        </div>
                                                                        <!-- FIM BOTÃO ACEITAR -->

                                                                        <!-- ELSE IF = H -->
                                                                    <?php } else { ?>

                                                                        <!-- INICIO BOTÃO 2 -->
                                                                        <div class="div-acoes">
                                                                            <a href="lotes_processados?s2=<?php echo $tipo_lote; ?><?php echo $linha["id_processamento"]; ?>" onclick="envia_email();">
                                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 disable content-xy-center" title="Liberar">
                                                                                    <div class="handle"></div>
                                                                                </button>
                                                                            </a>
                                                                        </div>

                                                                    <?php } ?>
                                                                    <!-- FIM IF TIPO DE ARQUIVO = H -->

                                                                    <!-- ELSE SITUAC 2 VISUALIZADO -->
                                                                <?php } else if ($linha["status"] == 2) { ?>

                                                                    <!-- INICIO BOTÃO 2 -->
                                                                    <div class="div-acoes">
                                                                        <!-- IF TIPO DE ARQUIVO = H -->
                                                                        <?php if ($tipo_lote == "h") {

                                                                            // BOTÃO ACEITAR
                                                                            if ($import_aceite["aceitar"] == "SIM") {

                                                                                // IF QUANTIDADE VISUALIZADO
                                                                                if ($quantidade_visualizado > 0) { ?>

                                                                                    <button type="button" class="btn btn-sm btn-orange btn-toggle active content-xy-center" onclick="count_visualizacao()" title="Liberado">
                                                                                        <div class="handle"></div>
                                                                                    </button>

                                                                                <?php } else { ?>

                                                                                    <a href="lotes_processados?v1=<?php echo $tipo_lote; ?><?php echo $linha["id_processamento"]; ?>">
                                                                                        <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 active content-xy-center" title="Liberado">
                                                                                            <div class="handle"></div>
                                                                                        </button>
                                                                                    </a>

                                                                                <?php }
                                                                            } else { ?>

                                                                                <!-- BOTÃO AVISO USUÁRIO SEM PERMISSÃO -->
                                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle active content-xy-center" onclick="usuario_sem_permissao();" title="Liberado">
                                                                                    <div class="handle"></div>
                                                                                </button>

                                                                            <?php }
                                                                            // FIM BOTÃO ACEITAR

                                                                        } else {

                                                                            // IF QUANTIDADE VISUALIZADO
                                                                            if ($quantidade_visualizado > 0) { ?>

                                                                                <button type="button" class="btn btn-sm btn-orange btn-toggle active content-xy-center" onclick="count_visualizacao()" title="Liberado">
                                                                                    <div class="handle"></div>
                                                                                </button>
                                                                            <?php } else { ?>

                                                                                <a href="lotes_processados?v1=<?php echo $tipo_lote; ?><?php echo $linha["id_processamento"]; ?>">
                                                                                    <button type="button" class="btn btn-sm btn-orange btn-toggle m-0 active content-xy-center" title="Liberado">
                                                                                        <div class="handle"></div>
                                                                                    </button>
                                                                                </a>
                                                                        <?php }
                                                                            // FIM BOTÃO ACEITAR
                                                                        } ?>

                                                                    </div>
                                                                    <!-- FIM BOTÃO 2 -->

                                                            <?php }
                                                                // FIM IF SITUAC 2 VISUALIZADO

                                                            } ?>
                                                            <!-- FIM FOREACH USUARIO -->

                                                            <!-- VISAO -->
                                                            <!-- ITENS LOTE -->
                                                            <div class="div-acoes">

                                                                <?php if (!empty($linha["vlr_liquido"])) { ?>

                                                                    <a href="itens_lote<?php echo $tipo_lote; ?>?vw=<?php echo $linha['id_processamento']; ?>">
                                                                        <button type="button" class="btn btn-primary btn-icones" title="Itens Lote">
                                                                            <i class="fas fa-list"></i>
                                                                        </button>
                                                                    </a>
                                                                <?php } else { ?>

                                                                    <a href="javascript:void(0);" id="itens_lote" tipo_lote="<?php echo $tipo_lote; ?>" id_processamento="<?php echo $linha['id_processamento']; ?>">
                                                                        <button type="button" class="btn btn-primary btn-icones" title="Itens Lote">
                                                                            <i class="fas fa-list"></i>
                                                                        </button>
                                                                    </a>
                                                                <?php } ?>

                                                            </div>

                                                            <!-- EVENTOS LOTE -->
                                                            <div class="div-acoes">
                                                                <?php if (($tipo_lote == "r")) { ?>

                                                                    <button type="button" class="btn btn-primary" onclick="alerta_inconsistencia();" title="Inconsistências">
                                                                        <i class="fas fa-clipboard-check" style="margin: 0px 13.5px 0px 13.5px;"></i>
                                                                    </button>
                                                                    <?php } elseif (($tipo_lote == "i" or ($tipo_lote == "h") or ($tipo_lote == "p"))) {

                                                                    if (($inconsistencia_irrf > 0) or ($inconsistencia_regarq > 0)) {

                                                                        if (($inconsistencia_irrf < 10) or ($inconsistencia_regarq < 10)) {

                                                                            $inconsistencia_irrf = substr_replace($inconsistencia_irrf, '0', 0, 0);
                                                                            $inconsistencia_regarq = substr_replace($inconsistencia_regarq, '0', 0, 0);
                                                                        }
                                                                    ?>

                                                                        <button type="button" class="btn btn-primary btn-inconsistencia" valores="<?php echo $linha['id_processamento'] . "|" . $tipo_lote; ?>" title="Inconsistências">
                                                                            <i class="fas fa-clipboard-check"></i>
                                                                            <span class="badge badge-orange badge-counter"><?php echo $inconsistencia_irrf + $inconsistencia_regarq; ?></span>
                                                                        </button>

                                                                    <?php } else { ?>
                                                                        <button type="button" class="btn btn-primary" onclick="alerta_inconsistencia();" title="Inconsistências">
                                                                            <i class="fas fa-clipboard-check" style="margin: 0px 13.5px 0px 13.5px;"></i>
                                                                        </button>

                                                                <?php }
                                                                } ?>
                                                            </div>

                                                            <!-- EXCLUIR LOTE -->
                                                            <div class="div-acoes">

                                                                <?php if ($linha["status"] > 1) { ?>

                                                                    <button type="button" onclick="sem_delete();" class="btn btn-primary" title="Excluir Lote"><i class="far fa-trash-alt"></i></button>
                                                                <?php } else { ?>

                                                                    <a href="lotes_processados?<?php echo $tipo_lote; ?>=<?php echo $linha['id_processamento']; ?>" onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;">
                                                                        <button type="button" class="btn btn-primary btn-icones" title="Excluir Lote">
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </button>
                                                                    </a>
                                                                <?php } ?>
                                                                <!-- </div> -->

                                                            </div>

                                                        </td>
                                                            </tr>

                                                    <?php
                                                }
                                            }

                                                    ?>
                                                    <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                        </tbody>
                                        <!-- FIM TBODY -->

                                    </table>

                                </div>
                                <!-- FIM DIV TABLE -->

                            </form>
                            <!-- FIM FORM -->

                        </div>
                        <!-- FIM CARD BODY -->

                    </div>
                    <!-- FIM CARD SHADOW -->

                </div>
                <!-- FIM PAGE CONTENT -->

            </div>
            <!-- FIM MAIN CONTENT -->


            <!-- -------------------------------------------------------------------------------------------------------------------- -->

            <!-- FOOTER -->
            <?php include_once 'footer.php'; ?>

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
            $('.lotes tr').show()
        } else {
            $('.lote').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    });

    // SWEET ALERT

    // document.getElementById('success').addEventListener('click', (e) => {
    //     Swal.fire({
    //         icon: "success",
    //         title: "Success"
    //     })
    // });

    function alerta_eventos() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Os eventos não estão disponíveis para o lote!'
        });

    }

    function alerta_inconsistencia() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não existem inconsistências para o lote!'
        });

    }

    function count_visualizacao() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Já existem registros visualizados por funcionários e o processo não pode ser desfeito!'
        });

    }

    function usuario_sem_permissao() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Seu usuário não possui permissão para realizar a ação!'
        });

    }

    function sem_delete() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível deletar o lote estando processado / aceito!'
        });

    }

    function alerta_processamento() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possivel processar o lote pois existem inconsistências a serem corrigidas!'
        });

    }

    function funcao_desabilitada() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Esta função foi desabilitada!'
        });

    }

    // Swal.fire({
    //     title: 'Atenção!',
    //     text: 'Tem certeza que deseja excluir o lote?',
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Sim, deletar lote!'
    // }).then((result) => {
    //     if (result.isConfirmed) {
    //         Swal.fire(
    //             'Deleted!',
    //             'Your file has been deleted.',
    //             'success'
    //         );
    //     }
    // });
</script>

<?php

if (isset($_REQUEST['btn-voltar'])) {
    echo "<script language=javascript>
    location.href='aceite_beneficios';
    </script>";
}
?>

<div id="visuDetalheModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualizar detalhe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visuDetalheProcessamento"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#status').change(function() {
            var status = $('#status').val();
            //alert(status);
            var index = $(this).parent().index();
            var nth = "#dataTable td:nth-child(" + (index + 1).toString() + ")";
            var valor = $(this).val().toUpperCase();
            if (status == '3') {
                alert('Selecionei todos');
                $("#dataTable tbody tr").show();
            } else {
                $("#dataTable tbody tr").show();
                $(nth).each(function() {
                    if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                        $(this).parent().hide();
                    }
                });
            }
        })
    })

    $(document).ready(function() {
        $(document).on('click', '.view_data', function() {
            var id_proc_recebido = $(this).attr("id_proc");
            //alert(id_proc_recebido);
            //verificar se há calor na variavel "id_proc_recebido".
            if (id_proc_recebido !== '') {
                var dados = {
                    id_proc_recebido: id_proc_recebido
                };
                $.post('visualizar_processados.php', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuDetalheProcessamento").html(retorna);
                    $('#visuDetalheModal').modal('show');

                });
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '#itens_lote', function() {
            var tipo_lote = $(this).attr("tipo_lote");
            var id_processamento = $(this).attr("id_processamento");
            //alert(id_proc_recebido);
            //verificar se há calor na variavel "id_proc_recebido".
            if ((tipo_lote !== '') && (id_processamento !== '')) {
                var dados = {
                    tipo_lote: tipo_lote,
                    id_processamento: id_processamento
                };
                $.post('lotes_processados.php', dados, function(retorna) {

                    location.href = 'itens_lote' + tipo_lote + '?vw=' + id_processamento;

                });
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.btn-inconsistencia', function() {
            var valores = $(this).attr("valores");
            //alert(id_proc_recebido);
            //verificar se há calor na variavel "id_proc_recebido".
            if ((valores !== '')) {
                var dados = {
                    valores: valores
                };
                $.post('lotes_processados.php', dados, function(retorna) {

                    location.href = 'inconsistencias_lote';

                });
            }
        });
    });
</script>

<?php

if (isset($_REQUEST['h'])) {
    try {
        $id_processamento = $_REQUEST['h'];
        $tabela = 'GESIM1';

        foreach (select_GESIM1_arquivo($raiz_cnpj, $id_processamento) as $arquivos) {

            $arquivo = $arquivos["arquivo"];

            unlink('../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $arquivo . '');
        }


        delete_LOTE($tabela, $raiz_cnpj, $id_processamento);

        echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Lote deletado!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='lotes_processados';
                }
              })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['p'])) {
    try {
        $id_processamento = $_REQUEST['p'];
        $tabela = 'GESPON1';

        foreach (select_GESPON1($raiz_cnpj, $id_processamento) as $arquivos) {

            $arquivo = $arquivos["arquivo"];

            unlink('../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $arquivo . '');
        }

        delete_LOTE($tabela, $raiz_cnpj, $id_processamento);

        echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Lote deletado!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='lotes_processados';
                }
              })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['i'])) {
    try {
        $id_processamento = $_REQUEST['i'];
        $tabela = 'GESIRR';

        delete_LOTE($tabela, $raiz_cnpj, $id_processamento);

        echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Lote deletado!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='lotes_processados';
                }
              })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['r'])) {
    try {
        $id_processamento = $_REQUEST['r'];
        $tabela = 'GESREC';

        foreach (select_GESREC_arquivo($raiz_cnpj, $id_processamento) as $arquivo_gesrec) {
            $arquivo = $arquivo_gesrec["arquivo"];
        }

        if (!empty($arquivo)) {
            unlink('../upload/beneficios/recibos_diversos/' . $arquivo . '');
        }

        delete_LOTE($tabela, $raiz_cnpj, $id_processamento);

        echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Lote deletado!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='lotes_processados';
                }
              })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// MUDA A SITUAÇÃO DO LOTE PARA 0
if (isset($_REQUEST['s0'])) {
    try {
        $parametro = $_REQUEST['s0'];

        $tabela = substr($parametro, 0, 1);

        if ($tabela == "p") {

            $tabela = 'GESPON1';
        }
        if ($tabela == "h") {

            $tabela = 'GESIM1';
        }
        if ($tabela == "i") {

            $tabela = 'GESIRR';
        }
        if ($tabela == "r") {

            $tabela = 'GESREC';
        }


        $id_processamento = substr($parametro, 1);
        $situac = 0;

        update_lote($tabela, $raiz_cnpj, $situac, $id_processamento);

        echo "<script language=javascript>
        location.href='lotes_processados';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// MUDA A SITUAÇÃO DO LOTE PARA 1
if (isset($_REQUEST['s1'])) {
    try {
        $parametro = $_REQUEST['s1'];

        $tabela = substr($parametro, 0, 1);
        $tipo_lote = substr($parametro, 0, 1);

        if ($tabela == "p") {

            $tabela = 'GESPON1';
        }
        if ($tabela == "h") {

            $tabela = 'GESIM1';



            foreach (selectENVIO_EMAIL_IMPORTACAO($id_emp_default) as $email_importacao) {

                $nome_email_importacao = $email_importacao["nome"];
                $email_email_importacao = $email_importacao["email"];
                $empresa_email_importacao = $email_importacao["nomefantasia"];
                $cnpj_email_importacao = $email_importacao["cnpj"];

                if ((!empty($nome_email_importacao)) or (!empty($email_email_importacao))) {

                    require "email_aviso_importacao.php";
                }
            }
        }
        if ($tabela == "i") {

            $tabela = 'GESIRR';
        }
        if ($tabela == "r") {

            $tabela = 'GESREC';
        }

        $id_processamento = substr($parametro, 1);
        $situac = 1;

        // VERIFICA SE O VALOR LIQUIDO FOR NULL E REALIZA O UPDATE NO CAMPO
        foreach (selectGESIM1_vlr_liquido($raiz_cnpj, $id_emp, $id_processamento) as $valor_liquido) {

            $valor_liquido_lote = $valor_liquido["vlr_liquido"];
        }

        if (empty($valor_liquido_lote)) {

            foreach (selectGESIM2_valores($raiz_cnpj, $id_processamento) as $valores) {

                $id_im1 = $valores["id_im1"];
                $vlr_vencimento = $valores["vlr_vencimento"];
                $vlr_desconto = $valores["vlr_desconto"];
                $vlr_liquido = $valores["vlr_liquido"];

                updateGESIM1_valores($raiz_cnpj, $vlr_vencimento, $vlr_desconto, $vlr_liquido, $id_im1);
            }
        }

        update_lote($tabela, $raiz_cnpj, $situac, $id_processamento);

        echo "<script language=javascript>
            location.href='lotes_processados';
            </script>";

        // echo "<script language=javascript>
        // location.href='lotes_processados';
        // </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// MUDA A SITUAÇÃO DO LOTE PARA 1
if (isset($_REQUEST['v1'])) {
    try {
        $parametro = $_REQUEST['v1'];

        $tabela = substr($parametro, 0, 1);

        if ($tabela == "p") {

            $tabela = 'GESPON1';
        }
        if ($tabela == "h") {

            $tabela = 'GESIM1';
        }
        if ($tabela == "i") {

            $tabela = 'GESIRR';
        }
        if ($tabela == "r") {

            $tabela = 'GESREC';
        }

        $id_processamento = substr($parametro, 1);
        $situac = 1;

        update_lote($tabela, $raiz_cnpj, $situac, $id_processamento);

        echo "<script language=javascript>
        location.href='lotes_processados';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// MUDA A SITUAÇÃO DO LOTE PARA 2
if (isset($_REQUEST['s2'])) {
    try {
        $parametro = $_REQUEST['s2'];

        $tabela = substr($parametro, 0, 1);

        $id_processamento = substr($parametro, 1);
        $situac = 2;

        if ($tabela == "p") {

            $tabela = 'GESPON1';
        }
        if ($tabela == "h") {

            $tabela = 'GESIM1';

            foreach (select_COUNT_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj, $id_processamento) as $contagem_email) {

                if ($contagem_email > 0) {

                    $_SESSION["id_processamento_relatorio"] = $id_processamento;
                    $_SESSION["raiz_cnpj_relatorio"] = $raiz_cnpj;

                    require "relatorio_recibo_pagamento_baixar.php";

                    foreach (select_ENVIA_EMAIL_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj, $id_processamento) as $email_relatorio) {

                        $nome_email_relatorio = $email_relatorio["resp_financeiro"];
                        $email_email_relatorio = explode(";", $email_relatorio["email_financeiro"]);
                        $empresa_email_relatorio = $email_relatorio["nomefantasia"];
                        $cnpj_email_relatorio = $email_relatorio["cnpj"];
                    }

                    require "email_relatorio_recibo_pagamento.php";

                    unlink('relatorios/financeiro/' . $_SESSION["id_processamento_relatorio"] . '.pdf');
                    unset($_SESSION["id_processamento_relatorio"]);
                    unset($_SESSION["raiz_cnpj_relatorio"]);
                }
            }
        }
        if ($tabela == "i") {

            $tabela = 'GESIRR';
        }
        if ($tabela == "r") {

            $tabela = 'GESREC';
        }

        update_lote($tabela, $raiz_cnpj, $situac, $id_processamento);

        echo "<script language=javascript>
    
        Swal.fire({
            title: 'Atenção!',
            text: 'Deseja notificar o(s) usuário(s) por e-mail?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, notificar!',
            cancelButtonText: 'Não!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id = '" . $parametro . "';
                location.href = 'lotes_processados?envia=' + id;
            }else{
                location.href = 'lotes_processados';
            }
          })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// MUDA A SITUAÇÃO DO LOTE PARA 1
if (isset($_REQUEST['envia'])) {
    try {
        $parametro = $_REQUEST['envia'];

        $id_processamento = substr($parametro, 1);

        foreach (selectEMAIL_LOTES($id_emp_default, $id_processamento, $raiz_cnpj) as $email_lote) {

            $nome_email = $email_lote["nome"];
            $email_email = $email_lote["email"];
            $tipo_email = $email_lote["tipo"];

            require "email_beneficios.php";
        }

        echo "<script language=javascript>
        Swal.fire({
            title: 'Sucesso!',
            text: 'O(s) usuário(s) foram notificados!',
            icon: 'success',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK!'
          }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'lotes_processados';
            }else{
                location.href = 'lotes_processados';
            }
          })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}


?>

<?php

// UPDATE VALOR LIQUIDO NULL
if ((isset($_POST['tipo_lote'])) and (isset($_POST['id_processamento']))) {

    $tipo_lote = $_POST["tipo_lote"];
    $id_processamento = $_POST["id_processamento"];

    foreach (selectGESIM2_valores($raiz_cnpj, $id_processamento) as $valores) {

        $id_im1 = $valores["id_im1"];
        $vlr_vencimento = $valores["vlr_vencimento"];
        $vlr_desconto = $valores["vlr_desconto"];
        $vlr_liquido = $valores["vlr_liquido"];

        updateGESIM1_valores($raiz_cnpj, $vlr_vencimento, $vlr_desconto, $vlr_liquido, $id_im1);
    }
}

// UPDATE VALOR LIQUIDO NULL
if (isset($_POST['valores'])) {

    $_SESSION["valores"] = $_POST["valores"];
}
?>