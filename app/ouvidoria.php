<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

unset($_SESSION["id_ouv_item"]);

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - Caixa de Sugestão</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once "menu_lateral.php";

        ?>
        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <!-- MENU SUPERIOR -->
                <?php

                include_once "menu_superior.php";

                ?>
                <!-- FIM MENU SUPERIOR -->

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Caixa de Sugestão</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3">

                        <div class="ml-auto" style=" padding-right: 0.75em; margin-top: -20px">
                            <a href="ouvidoria_incluir"><button class="btn btn-brave"><i class="fas fa-plus"></i></button></a>
                            <button id="btnExibeOcultaDiv" class="btn btn-brave ml-1"><i class="fas fa-filter"></i></button>
                            <a href="ouvidoria_duvidas"><button class="btn btn-brave ml-1"><i class="fas fa-question"></i></button></a>
                        </div>

                    </div>

                    <!-- Div principal-->
                    <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none" id="dvPrincipal">

                        <div class="form-group">
                            <label>Situação:</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio1" name="radio" value="P" data-cad="pendente" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio1">Pendente</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio2" name="radio" value="R" data-cad="respondido" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio2">Respondido</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio3" name="radio" value="C" data-cad="cancelado" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio3">Cancelado</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio4" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio4">Todos</label>
                            </div>

                        </div>

                    </div>
                    <!-- Fim Div principal-->

                    <!-- DIV ROW -->
                    <div class="row mb-3 cursos">

                        <!-- FOREACH COM RETORNO DOS 14 ULTIMOS RECIBOS -->
                        <?php

                        foreach (select_GESOUV_id_usu($id_usu_default) as $ouvidoria) {

                            $id_ouv = $ouvidoria['id_ouv'];
                            $id_tso = $ouvidoria['id_tso'];
                            $mensagem = $ouvidoria['mensagem'];
                            $situac = $ouvidoria['situac'];
                            $situacao = $ouvidoria['situacao'];
                            $id_usu_inc = $ouvidoria['id_usu_inc'];
                            $descri = $ouvidoria['descricao'];
                            $data_inclusao = new DateTime($ouvidoria['datinc']);

                            if ($ouvidoria != 0) {

                        ?>

                                <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO -->
                                <?php

                                if ($situac == 0) {

                                ?>

                                    <!-- RECIBOS pendente -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso pendente">
                                        <div class="card h-100">
                                            <a href="ouvidoria_item?vw=<?php echo $id_ouv; ?>" class="tag-a-sem-acao">
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
                                                                    <span class="text font-weight-bold">PENDENTE</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                                <?php

                                if ($situac == 1) {

                                ?>

                                    <!-- RECIBOS -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso respondido">
                                        <div class="card h-100">
                                            <a href="ouvidoria_item?vw=<?php echo $id_ouv; ?>" class="tag-a-sem-acao">
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
                                                                    <span class="text font-weight-bold">RESPONDIDO</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                                <?php

                                if ($situac == 2) {

                                ?>

                                    <!-- RECIBOS -->
                                    <div class="col-xl-3 col-md-6 mb-4 curso cancelado" style="display: none;">
                                        <div class="card h-100">
                                            <a href="ouvidoria_item?vw=<?php echo $id_ouv; ?>" class="tag-a-sem-acao">
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
                                                                    <span class="text font-weight-bold">CANCELADO</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                            <?php

                            } else {
                            ?>

                                <!-- DIV ROW -->
                                <!-- <div class="row mb-3"> -->
                                <!-- SOBRE -->
                                <div class="m-auto">
                                    <img class="img-fluid" width="400" src="img/logo/blank_ouvidoria.png"></img>
                                </div>

                                <!-- </div> -->
                                <!-- FIM DIV ROW -->

                        <?php
                            }
                        }

                        ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM DIV CONTAINER FLUID -->

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <?php

            include_once "footer.php";

            ?>
            <!-- FIM FOOTER -->

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>
    <!-- FIM DIV WRAPPER -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <!-- <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script> -->
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
        if (cat == 'cancelado') {
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
    })
</script>

<script>
    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {

            location.href = 'fale_rh';
        });
    });
</script>