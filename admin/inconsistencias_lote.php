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
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Inconsistências Lote</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- <link href="style.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

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
                            <h6 class="m-0 font-weight-bold text-primary">Inconsistências Lote</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <?php if (isset($_SESSION["valores"])) {

                                // Variavel de sessao
                                $valores = $_SESSION["valores"];
                                $valores_explode = explode("|", $valores);

                                // Resultado do explode
                                $id_processamento = $valores_explode[0];
                                $tipo_lote = $valores_explode[1];

                                switch ($tipo_lote) {

                                    case "h":

                                        $tabela_regarq = 'public."GESIM1_' . $raiz_cnpj . '"';
                                        break;

                                    case "p":

                                        $tabela_regarq = 'public."GESPON1_' . $raiz_cnpj . '"';
                                        break;

                                    case "i":

                                        $tabela_regarq = 'public."GESIRR_' . $raiz_cnpj . '"';
                                        break;

                                    case "r":

                                        break;
                                }
                            } ?>

                            <!-- INICIO DIV TABLE -->
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                    <!-- THEAD -->
                                    <thead>
                                        <div class="col-sm-12 button-tabela">
                                            <button type="button" id="btn-voltar" data-toggle="tooltip" title="Voltar para os lotes" class="btn btn-organograma">
                                                <i class="fas fa-sign-out-alt"></i> Voltar
                                            </button>
                                        </div>
                                        <tr>
                                            <th data-orderable="false" class="coluna-nome">Descrição</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:20%; vertical-align: middle;">Ações</th>
                                        </tr>
                                    </thead>

                                    <!-- TFOOT -->
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">Descrição</th>
                                            <th style="text-align: center;">Ações</th>
                                        </tr>
                                    </tfoot>

                                    <!-- INICIO TBODY -->
                                    <tbody class="texto-table-body">

                                        <?php switch ($tipo_lote) {

                                            case "i":

                                                foreach (select_inconsistencia_irrf($raiz_cnpj, $id_processamento) as $count) {

                                                    $inconsistencia_irrf = $count["contagem"];
                                                }

                                                if ($inconsistencia_irrf > 0) { ?>

                                                    <tr class="align-middle irrf" utiliza_anocal="SIM">
                                                        <td>Existem inconsistências no <span class="text-primary font-weight-bolder"> Ano Calendário </span> para o lote</td>
                                                        <td class="content-xy-center">

                                                            <div class="div-acoes">

                                                                <button type="button" class="btn btn-primary btn-inconsistencia" descr="ANOCAL" title="Inconsistências">

                                                                    <?php if ($inconsistencia_irrf > 0) {
                                                                        if ($inconsistencia_irrf < 10) {
                                                                            $inconsistencia_irrf = substr_replace($inconsistencia_irrf, '0', 0, 0);
                                                                        } ?>

                                                                        <i class="fas fa-wrench"></i>
                                                                        <span class="badge badge-orange badge-counter"><?php echo $inconsistencia_irrf; ?></span>

                                                                    <?php } else { ?>

                                                                        <i class="fas fa-wrench" style="margin: 0px 13.5px 0px 13.5px;"></i>

                                                                    <?php } ?>

                                                                </button>

                                                            </div>

                                                        </td>
                                                    </tr>

                                                <?php }

                                                break;

                                            default:

                                                break;
                                        }

                                        if ($tipo_lote != "r") {


                                            foreach (select_inconsistencia_regarq($tabela_regarq, $id_processamento) as $count_inconsistencia_regarq) {

                                                $inconsistencia_regarq = $count_inconsistencia_regarq["contagem"];
                                                $total_localizado_regarq = $count_inconsistencia_regarq["total_localizado"];
                                                $total_importado_regarq = $count_inconsistencia_regarq["total_importado"];
                                            }

                                            if ($inconsistencia_regarq > 0) { ?>

                                                <tr class="align-middle">
                                                    <td>Foram importados <span class="text-primary font-weight-bolder"> <?php echo $total_importado_regarq; ?> </span> de <span class="text-primary font-weight-bolder"> <?php echo $total_localizado_regarq; ?> </span> registros.</td>
                                                    <td class="content-xy-center">
                                                        <div class="div-acoes">
                                                            <button type="button" class="btn btn-primary modal-inconsistencia" title="Inconsistência">
                                                                <i class="fas fa-info" style="margin: 0px 13.5px 0px 13.5px;"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                        <?php }
                                        } ?>

                                    </tbody>
                                    <!-- FIM TBODY -->

                                </table>
                            </div>
                            <!-- FIM DIV TABLE -->

                        </div>
                        <!-- FIM CARD BODY -->

                    </div>
                    <!-- FIM CARD SHADOW -->

                </div>
                <!-- FIM PAGE CONTENT -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- --------------------------------------------------------- INICIO MODAIS ----------------------------------------------------------- -->

            <!-- MODAL INCONSISTENCIA IRRF -->
            <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajuste Inconsistência</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form class="needs-validation" novalidate action="inconsistencias_lote" method="POST">
                            <div class="modal-body">

                                <?php switch ($tipo_lote) {

                                    case "i":

                                        if ($inconsistencia_irrf > 0) { ?>

                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="anocal">Ano Calendário</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="anocal" name="anocal" attrname="anocal" maxlength="4" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Preencha a data corretamente!
                                                    </div>
                                                </div>
                                            </div>

                                <?php }

                                        break;
                                } ?>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-ajustar" class="btn btn-organograma">Ajustar</button>
                                <button type="button" id="fechar-modal" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- MODAL INCONSISTENCIAS -->
            <div id="modal-inconsistencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" style="width: 800px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inconsistências</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form class="needs-validation" novalidate>
                            <div class="modal-body" id="body-modal-inconsistencia" style="padding: 0px;">
                            </div>

                            <div class="modal-footer">
                                <!-- <button type="submit" name="btn-ajustar" class="btn btn-organograma">Ajustar</button> -->
                                <button type="button" id="fechar-modal" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- --------------------------------------------------------- FIM MODAIS ----------------------------------------------------------- -->

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

    <!-- REQUISITOS MÁSCARAS JS -->
    <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    var utiliza_anocal = $("tr .irrf").attr("utiliza_anocal");

    if (utiliza_anocal === "SIM") {

        // MÁSCARA DATA
        var anocalMask = ['9999', '9999'];
        var anocal = document.querySelector('input[attrname=anocal]');
        VMasker(anocal).maskPattern(anocalMask[0]);
        anocal.addEventListener('input', inputHandler.bind(undefined, anocalMask, 4), false);

    }

    function sem_acao() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível realizar ações de correção!'
        });

    }

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {
            var voltar = 1;
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (voltar !== '') {

                var dados = {
                    voltar: voltar
                };
                $.post('inconsistencias_lote.php', dados, function(retorna) {

                    location.href = "lotes_processados";

                });

            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn-inconsistencia', function() {
            var descr = $(this).attr("descr");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (descr !== '') {

                if (descr === "ANOCAL") {

                    $('#visuModal').modal('show');

                }
            }
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // ABRIR MODAL INCONSISTENCIAS
    $(function() {
        $(document).on('click', '.modal-inconsistencia', function() {

            var btn_modal = 1;

            if (btn_modal !== '') {

                var dados = {

                    btn_modal: btn_modal
                };

                $.post('controller/inconsistencias_lote_post.php', dados, function(retorno) {

                    if (retorno == 0) {

                        // Caso retorno 0, não existe informação da inconsistencia
                        Swal.fire({
                            icon: 'info',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'Não possui informação disponível.',
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // location.href = "politicas_codconduta";
                            }
                        });
                    } else {

                        $('#modal-inconsistencia').modal('show');
                        $('#body-modal-inconsistencia').html(retorno);
                    }
                });
            }
        });
    });
</script>

<?php
if (isset($_POST["voltar"])) {

    try {

        // Limpa a variavel de sessão
        unset($_SESSION["valores"]);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST["btn-ajustar"])) {

    try {

        switch ($tipo_lote) {

            case "i";

                $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';
                $anocal = $_POST["anocal"];
                $anoexe = intval($anocal) + 1;

                updateGESIRR_anocal($tabela, $anocal, $anoexe, $id_processamento);

                echo "<script language=javascript>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'A inconsistência foi corrigida!',
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

                break;
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
?>