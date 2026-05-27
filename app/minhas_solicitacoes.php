<?php

//Faz a requisição da Sessão
require 'restrito.php';

require 'util.php';

if (isset($_SESSION["id_sol_item"])) {
 
    unset($_SESSION["id_sol_item"]);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Gestou - Minhas Solicitações</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "menu_superior.php"; ?>

                <!-- INICIO CONTEINER FLUIR-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Minhas Solicitações</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3">

                        <div class="ml-auto" style=" padding-right: 0.75em; margin-top: -20px">
                            <button class="btn btn-brave" id="incluir-sol">
                                <i class="fas fa-plus"></i>
                            </button>

                            <button id="btnExibeOcultaDiv" class="btn btn-brave ml-1">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                    </div>

                    <!-- FILTRO-->
                    <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none" id="dvPrincipal">

                        <div class="form-group">
                            <label>Situação:</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio1" name="radio" value="E" data-cad="andamento" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio1">Andamento</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio2" name="radio" value="A" data-cad="aprovado" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio2">Aprovado</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio3" name="radio" value="R" data-cad="reprovado" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio3">Reprovado</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio4" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio4">Todos</label>
                            </div>

                        </div>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3 cursos">

                        <!-- FOREACH COM RETORNO DOS 14 ULTIMOS RECIBOS -->
                        <?php

                        foreach (select_GESSOL_id_usu($id_usu_default) as $solicitacoes) {

                            $id_sol = $solicitacoes['id_sol'];
                            $id_tso = $solicitacoes['id_tso'];
                            $mensagem = $solicitacoes['mensagem'];
                            $situac = $solicitacoes['situac'];
                            $situacao = $solicitacoes['situacao'];
                            $id_usu_inc = $solicitacoes['id_usu_inc'];
                            $descri = $solicitacoes['descri'];
                            $data_inclusao = new DateTime($solicitacoes['datinc']);
                            $situac_visualizar = $solicitacoes['situac_usu_visualizar'];

                            if ($solicitacoes != 0) {

                                // IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO

                                if ($situacao == 0) { ?>

                                    <!-- RECIBOS ANDAMENTOS -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso andamento">
                                        <div class="card h-100" sol="<?php echo $id_sol; ?>" style="cursor: pointer">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $descri; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_inclusao->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-warning btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-exclamation-triangle"></i> </span>
                                                                <span class="text font-weight-bold">ANDAMENTO</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }

                                if ($situacao == 3) { ?>

                                    <!-- RECIBOS -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso aprovado">
                                        <div class="card h-100" sol="<?php echo $id_sol; ?>" style="cursor: pointer" visu="<?php echo $situac_visualizar; ?>">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $descri; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_inclusao->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-success btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">APROVADO</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php

                                }

                                if ($situacao == 4) { ?>

                                    <!-- RECIBOS -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso reprovado">
                                        <div class="card h-100" sol="<?php echo $id_sol; ?>" style="cursor: pointer" visu="<?php echo $situac_visualizar; ?>">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $descri; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_inclusao->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-danger btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="far fa-times-circle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">REPROVADO</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }
                            } else { ?>

                                <!-- DIV ROW -->
                                <!-- <div class="row mb-3"> -->
                                <!-- SOBRE -->
                                <div class="m-auto">
                                    <img class="img-fluid" width="400" src="img/logo/blank_solicitacoes.png"></img>
                                </div>

                                <!-- </div> -->
                                <!-- FIM DIV ROW -->

                        <?php }
                        } ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM CONTEINER FLUIR-->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once "footer.php"; ?>

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <!-- <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script> -->
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<script>
    $("#btnExibeOcultaDiv").click(function(e) {
        e.preventDefault(); // evita que o formulário seja submetido
        $("#dvPrincipal").toggle();
    });
</script>

<script>
    $('.btn1').on('click', function() {
        var cat = $(this).attr('data-cad')
        if (cat == 'reprovado') {
            $('.curso div').show()
        }
        if (cat == 'todos') {
            $('.cursos div').show()
        } else {
            $('.curso').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    });

    $(function() {

        $('.h-100').each(function() {

            var visualizar = $(this).attr('visu');

            if (visualizar == 0) {

                $(this).addClass('bg-warning-lighter');
            }
        });
    });
</script>

<!-- AÇÃO NO CLICK -->
<script>
    // CLICK NOS CARDS
    $(function() {
        $(document).on('click', '.h-100', function() {

            var click_card = 1;

            if (click_card !== '') {

                var dados = {
                    id_sol: $(this).attr('sol'),
                    click_card: click_card
                };

                $.post('controller/minhas_solicitacoes_post.php', dados, function(retorno) {

                    location.href = 'minhas_solicitacoes_item';
                });
            }
        });
    });

    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {

            location.href = 'fale_rh';
        });
    });

    // BTN INCLUIR SOLICITAÇÃO
    $(function() {
        $(document).on('click', '#incluir-sol', function() {

            location.href = 'minhas_solicitacoes_incluir';
        });
    });
</script>