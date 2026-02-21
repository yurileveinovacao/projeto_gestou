<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once 'conexao.php';

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
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <!-- FIM MENU SUPERIOR -->

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <?php

                    foreach (select_POL_PRIVACIDADE() as $pol_privacidade) {
                        $descricao = $pol_privacidade['descricao'];
                        $situac = $pol_privacidade['situac'];
                    }

                    ?>

                    <div style="text-align: center; margin-top: 20px;">

                        <img src="img/logo/logo_gestou_escrita.png" height="50"></img>

                        <h2 style="margin-top: 20px; color: #3C0BA9" class="fonte-texto-gestou">Termos e Condiçoes</h2>

                    </div>

                    <div style="text-align: justify; padding: 20px;" class="politicas-md" >

                        <h6>

                            <?php

                            echo str_replace('•', '<br>•', $descricao);

                            ?>

                        </h6>

                    </div>

                    <div style="text-align: center; padding: 20px;">

                        <form action="aceite_politicas" method="POST">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="check" id="customControlAutosizing" required>
                                    <label class="custom-control-label" for="customControlAutosizing">Por meio deste,
                                        concordo com a Política de Privacidade apresentada acima.</label>
                                </div>
                            </div>
                            <button type="submit" name="aceitar_politica" class="btn btn-brave width-100"><span class="fonte-texto-gestou">Eu
                                    concordo</span></button>
                        </form>

                    </div>

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
    <!-- FIM DIV WRAPPER -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>

<?php

//INSERT DO ACEITE POLITICAS

//  echo $_SERVER["REMOTE_ADDR"];

try {
    //REQUEST DA PÁGINA ANTERIOR
    if (isset($_REQUEST['aceitar_politica'])) {
        $ip = $_SERVER['REMOTE_ADDR'];

        insert();

        echo "<script language=javascript>
        alert('Política aceita!');
        location.href = 'index';
        </script>";
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

// FUNÇÃO UPDATE

function insert()
{
    global $id_usu_default;
    global $ip;
    global $datinc;
    $id_pri = 1;

    insert_GESACP($id_usu_default, $ip, $datinc, $id_pri);
}

?>