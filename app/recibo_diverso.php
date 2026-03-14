<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

unset($_SESSION["id_rec_recibo"]);

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
    <title>Gestou - APP</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
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
                            <li class="breadcrumb-item h4"><a href="beneficios"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                            <li class="breadcrumb-item active h4" aria-current="page">Recibo Diversos</li>
                        </ol>

                    </div>
                    <!-- FIM DIV ICONE VOLTAR -->

                    <!-- DIV ROW -->
                    <div class="row mb-3">

                        <div class="ml-auto" style=" padding-right: 0.75em; margin-top: -20px">
                            <button id="btnExibeOcultaDiv" class="btn btn-brave"><i class="fas fa-filter"></i></button>
                        </div>

                    </div>


                    <!-- Div principal-->
                    <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none; user-select: none" id="dvPrincipal">

                        <div class="form-group">
                            <label>Situação:</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio1" name="radio" value="P" data-cad="pendente" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio1">Andamento</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio2" name="radio" value="V" data-cad="aprovado" class="btn1 custom-control-input">
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
                    <!-- Fim Div principal-->

                    <!-- DIV ROW -->
                    <div class="row mb-3 recibos">

                        <!-- FOREACH COM RETORNO DOS 14 ULTIMOS RECIBOS -->
                        <?php

                        foreach (select_GESREC($raiz_cnpj, $id_emp_default, $id_usu_default) as $recibo_diverso) {

                            $id_rec = $recibo_diverso['id_rec'];
                            $descricao = $recibo_diverso['descricao'];
                            $arquivo = $recibo_diverso['arquivo'];
                            $situac = $recibo_diverso['situac'];
                            $situac_visualizar = $recibo_diverso['situac_visualizar'];
                            $id_validador = $recibo_diverso['id_validador'];

                            if ($recibo_diverso != 0) {

                        ?>

                                <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO -->
                                <?php if ($situac == 2) { ?>

                                    <!-- ESPELHOS PENDENTES -->
                                    <div class="col-xl-3 col-md-6 mb-4 recibo pendente">
                                        <div class="card h-100">
                                            <a href="recibo_diverso_item?vw=<?php echo $id_validador ?>" class="tag-a-sem-acao">
                                                <div class="card-body">
                                                    <div class="row align-items-center text-align-center" style="text-align: center;">
                                                        <div class="col mr-2">
                                                            <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                                RECIBOS DIVERSOS
                                                            </div>
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                                <?php echo $descricao ?>
                                                            </div>
                                                            <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                <div class="btn btn-warning btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-exclamation-triangle"></i></span>
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

                                <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO -->
                                <?php if ($situac == 3) { ?>

                                    <!-- ESPELHOS APROVADO -->
                                    <div class="col-xl-3 col-md-6 mb-4 recibo aprovado">
                                        <div class="card h-100">
                                            <a href="recibo_diverso_item?vw=<?php echo $id_validador ?>" class="tag-a-sem-acao">
                                                <div class="card-body">
                                                    <div class="row align-items-center text-align-center" style="text-align: center;">
                                                        <div class="col mr-2">
                                                            <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                                RECIBOS DIVERSOS
                                                            </div>
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                                <?php echo $descricao ?>
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
                                            </a>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                                <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO -->
                                <?php if ($situac == 4) { ?>

                                    <!-- ESPELHOS PENDENTES -->
                                    <div class="col-xl-3 col-md-6 mb-4 recibo reprovado">
                                        <div class="card h-100">
                                            <a href="recibo_diverso_item?vw=<?php echo $id_validador ?>" class="tag-a-sem-acao">
                                                <div class="card-body">
                                                    <div class="row align-items-center text-align-center" style="text-align: center;">
                                                        <div class="col mr-2">
                                                            <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                                RECIBOS DIVERSOS
                                                            </div>
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                                <?php echo $descricao ?>
                                                            </div>
                                                            <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                <div class="btn btn-danger btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-exclamation-triangle"></i></span>
                                                                    <span class="text font-weight-bold">REPROVADO</span>
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
                            } else {

                                ?>

                                <div class="m-auto">
                                    <img class="img-fluid" width="400" src="img/logo/blank_recibo_diversos.png"></img>
                                </div>

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
        // if (cat == 'reprovado') {
        //     $('.recibo div').show()
        // }
        if (cat == 'todos') {
            $('.recibos div').show()
        } else {
            $('.recibo').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    })
</script>