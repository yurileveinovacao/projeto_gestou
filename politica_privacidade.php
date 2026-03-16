<?php

require_once 'app/iuds_app.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="app/img/logo/logo.ico" rel="icon">
    <title>Gestou - APP</title>
    <link href="app/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="app/vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="app/css/ruang-admin.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <?php foreach (select_POL_PRIVACIDADE() as $pol_privacidade) {

                        $descricao = $pol_privacidade['descricao'];
                        $situac = $pol_privacidade['situac'];
                    } ?>

                    <div style="text-align: center; margin-top: 20px;">

                        <img src="app/img/logo/logo_gestou_escrita.png" height="50"></img>

                        <h2 style="margin-top: 20px; color: #3C0BA9" class="fonte-texto-gestou">Termos e Condiçoes</h2>

                    </div>

                    <div style="text-align: justify; padding: 20px;" class="politicas-md">

                        <h6> <?php echo str_replace('•', '<br>•', $descricao); ?> </h6>

                    </div>

                </div>
                <!-- FIM DIV CONTAINER FLUID -->

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                            Ambiente Seguro&nbsp;&nbsp;<img src="app/img/logo/icone_seguro.png" height="12"></img> <br><br>
                            Leve Inovação Estratégica Ltda — CNPJ 53.094.687/0001-38
                        </span>
                    </div>
                </div>
            </footer>
            <!-- FIM FOOTER -->

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>
    <!-- FIM DIV WRAPPER -->

    <script src="app/vendor/jquery/jquery.min.js"></script>
    <script src="app/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="app/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>