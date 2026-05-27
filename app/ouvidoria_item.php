<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

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
    <link rel="icon" type="image/png" href="/img/favicon.png">
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

        include_once 'menu_lateral.php';

        ?>
        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <?php

                try {
                    //REQUEST DA PÁGINA ANTERIOR
                    if (isset($_REQUEST['vw'])) {
                        $_SESSION['id_ouv_item'] = $_REQUEST['vw'];
                        $id_ouv = $_SESSION['id_ouv_item'];

                        foreach (select_GESOUV_id_ouv($id_ouv) as $ouvidoria) {

                            $mensagem = $ouvidoria['mensagem'];
                            $descri = $ouvidoria['descri'];
                            $situac = $ouvidoria['situac'];
                            $resposta = $ouvidoria['resposta'];
                        }

                        if ($situac != 0) {

                            update_GESOUV_situac_visualizar($id_ouv);
                        }

                ?>

                        <!-- MENU SUPERIOR -->
                        <?php

                        include_once 'menu_superior.php'; ?>
                        <!-- FIM MENU SUPERIOR -->

                        <!-- DIV CONTAINER FLUID-->
                        <div class="container-fluid" id="container-wrapper">

                            <!-- DIV ICONE VOLTAR -->
                            <div class="iconedireita mb-1 user-select-none">

                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item h4"><a href="ouvidoria"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                                    <li class="breadcrumb-item active h4" aria-current="page">Mensagem Item</li>
                                </ol>

                            </div>
                            <!-- FIM DIV ICONE VOLTAR -->

                            <!-- DIV ROW -->
                            <div class="row mb-1">

                                <!-- TOTAL PROVENTOS COLLAPSABLE -->
                                <div class="card shadow mb-2 width-100">
                                    <!-- HEADER TOTAL PROVENTOS -->
                                    <div class="d-block card-header py-3 collapsed">

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA SOLICITAÇÃO</label>
                                                    <input type="text" class="form-control" value="<?php echo $descri; ?>" readonly disabled></input>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                                                    <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $mensagem; ?></textarea>
                                                </div>
                                            </div>

                                            <?php if ($situac != 0) { ?>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="resposta" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA</label>
                                                        <textarea class="form-control" id="resposta" name="resposta" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $resposta; ?></textarea>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                            <div class="form-row">
                                                <div class="form-group col-md-12 text-center">

                                                    <?php if ($situac == 0) { ?>

                                                        <img class="img-fluid m-auto" src="img/logo/pendente.png" width="130px"></img>

                                                    <?php }
                                                    if ($situac == 1) { ?>

                                                        <img class="img-fluid m-auto" src="img/logo/respondido.png" width="130px"></img>

                                                    <?php }
                                                    if ($situac == 2) { ?>

                                                        <img class="img-fluid m-auto" src="img/logo/cancelado.png" width="130px"></img>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php
                        }
                            ?>

                            </div>
                            <!-- FIM DIV ROW -->

                        <?php

                    } catch (PDOException $erro) {
                        echo $erro->getMessage();
                    }

                        ?>

                        </div>
                        <!-- FIM DIV CONTAINER FLUID -->

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- FIM FOOTER -->

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>