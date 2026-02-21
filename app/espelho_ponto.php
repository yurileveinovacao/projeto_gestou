<?php

//Faz a requisição da Sessão
require 'restrito.php';

// Chama a pagina de utilidades
require 'util.php';

if (isset($_SESSION["id_pon1_espelho"])) {

    unset($_SESSION["id_pon1_espelho"]);
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
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - Espelho de Ponto</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
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

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV BTN VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>
                            <li class="breadcrumb-item active h4" aria-current="page">Espelho de Ponto</li>
                        </ol>
                    </div>

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
                                <input type="radio" id="radio2" name="radio" value="V" data-cad="visualizado" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio2">Visualizado</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio4" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio4">Todos</label>
                            </div>

                        </div>

                    </div>
                    <!-- Fim Div principal-->

                    <!-- DIV ROW -->
                    <div class="row mb-3 espelhos">

                        <!-- FOREACH COM RETORNO DOS 14 ULTIMOS RECIBOS -->
                        <?php

                        foreach (select_GESPON1($raiz_cnpj, $id_emp_default, $id_usu_default) as $espelho_ponto) {

                            $id_pon1 = $espelho_ponto['id_pon1'];
                            $periodo = $espelho_ponto['periodo'];
                            $btotal = $espelho_ponto['btotal'];
                            $bsaldo = $espelho_ponto['bsaldo'];
                            $situac = $espelho_ponto['situac'];
                            $situac_visualizar = $espelho_ponto['situac_visualizar'];
                            $tipo_valor_total = substr($btotal, 0, 1);
                            $tipo_valor_saldo = substr($bsaldo, 0, 1);

                            if ($espelho_ponto != 0) {

                                if ((empty($btotal)) or (empty($bsaldo))) {

                        ?>

                                    <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE PONTOS DA NOVA IMPORTAÇÃO -->
                                    <?php if ($situac_visualizar == 0) { ?>

                                        <!-- ESPELHOS PENDENTES -->
                                        <div class="col-xl-3 col-md-6 mb-4 espelho pendente">
                                            <div class="card h-100">
                                                <a href="espelho_item?vw=<?php echo $id_pon1 ?>" class="tag-a-sem-acao">
                                                    <div class="card-body">
                                                        <div class="row align-items-center text-align-center" style="text-align: center;">
                                                            <div class="col mr-2">
                                                                <div class="h6 mb-0 font-weight-bold text-gray-800 mb-4">
                                                                    ESPELHO PONTO
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase mb-4">
                                                                    <?php echo $periodo ?>
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

                                    <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE PONTOS DA NOVA IMPORTAÇÃO -->
                                    <?php

                                    if ($situac_visualizar == 1) { //VISUALIZADO

                                    ?>

                                        <!-- ESPELHOS VISUALIZADO -->
                                        <div class="col-xl-3 col-md-6 mb-4 espelho visualizado">
                                            <div class="card h-100">
                                                <a href="espelho_item?vw=<?php echo $id_pon1 ?>" class="tag-a-sem-acao">
                                                    <div class="card-body">
                                                        <div class="row align-items-center text-align-center" style="text-align: center;">
                                                            <div class="col mr-2">
                                                                <div class="h6 mb-0 font-weight-bold text-gray-800 mb-4">
                                                                    ESPELHO PONTO
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase mb-4">
                                                                    <?php echo $periodo ?>
                                                                </div>

                                                                <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                    <div class="btn btn-success btn-icon-split">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">VISUALIZADO</span>
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

                                    <!-- IF SITUAÇÃO EXIBINDO OS REGISTROS DE ACORDO -->
                                    <?php if ($situac_visualizar == 0) { ?>

                                        <!-- ESPELHOS PENDENTES -->
                                        <div class="col-xl-3 col-md-6 mb-4 espelho pendente">
                                            <div class="card h-100">
                                                <a href="espelho_item?vw=<?php echo $id_pon1 ?>" class="tag-a-sem-acao">
                                                    <div class="card-body">
                                                        <div class="row align-items-center text-align-center" style="text-align: center;">
                                                            <div class="col mr-2">
                                                                <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                                    ESPELHO PONTO
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase">
                                                                    <?php echo $periodo ?>
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase">
                                                                    Total Mês:
                                                                    <?php if ($tipo_valor_total != "-") { ?>
                                                                        <span class="text-primary mr-2"><?php } ?>
                                                                        <?php if ($tipo_valor_total == "-") { ?>
                                                                            <span class="text-danger mr-2"><?php } ?>
                                                                            <?php echo $btotal ?>
                                                                            </span>
                                                                </div>
                                                                <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                    Saldo:
                                                                    <?php if ($tipo_valor_saldo != "-") { ?>
                                                                        <span class="text-primary mr-2"><?php } ?>
                                                                        <?php if ($tipo_valor_saldo == "-") { ?>
                                                                            <span class="text-danger mr-2"><?php } ?>
                                                                            <?php echo $bsaldo ?>
                                                                            </span>
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
                                    <?php

                                    if ($situac_visualizar == 1) { //VISUALIZADO

                                    ?>

                                        <!-- ESPELHOS VISUALIZADO -->
                                        <div class="col-xl-3 col-md-6 mb-4 espelho visualizado">
                                            <div class="card h-100">
                                                <a href="espelho_item?vw=<?php echo $id_pon1 ?>" class="tag-a-sem-acao">
                                                    <div class="card-body">
                                                        <div class="row align-items-center text-align-center" style="text-align: center;">
                                                            <div class="col mr-2">
                                                                <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                                    ESPELHO PONTO
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase">
                                                                    <?php echo $periodo ?>
                                                                </div>
                                                                <div class="text-xs font-weight-bold text-uppercase">
                                                                    Total Mês:
                                                                    <?php if ($tipo_valor_total != "-") { ?>
                                                                        <span class="text-primary mr-2"><?php } ?>
                                                                        <?php if ($tipo_valor_total == "-") { ?>
                                                                            <span class="text-danger mr-2"><?php } ?>
                                                                            <?php echo $btotal ?>
                                                                            </span>
                                                                </div>
                                                                <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                    Saldo:
                                                                    <?php if ($tipo_valor_saldo != "-") { ?>
                                                                        <span class="text-primary mr-2"><?php } ?>
                                                                        <?php if ($tipo_valor_saldo == "-") { ?>
                                                                            <span class="text-danger mr-2"><?php } ?>
                                                                            <?php echo $bsaldo ?>
                                                                            </span>
                                                                </div>
                                                                <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                    <div class="btn btn-success btn-icon-split">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">VISUALIZADO</span>
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
                                }

                                ?>

                            <?php

                            } else {

                            ?>

                                <div class="m-auto">
                                    <img class="img-fluid" width="400" src="img/logo/blank_pontos.png"></img>
                                </div>

                        <?php

                            }
                        }

                        ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM CONTAINER FLUID -->

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
            $('.espelhos div').show()
        } else {
            $('.espelho').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    })
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'documentos'
            location.href = 'documentos';
        });
    });
</script>