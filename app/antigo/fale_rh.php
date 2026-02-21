<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

// unset($_SESSION["tipo_filtro"]);

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

          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb iconedireita">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div> -->

          <!-- DIV ICONE VOLTAR -->
          <!-- <i class="fas fa-chevron-circle-left fa-2x"></i> -->
          <div class="iconedireita mb-4 user-select-none">

            <!-- <i class="fas fa-chevron-circle-left fa-2x"></i><span class="h3 mb-0 text-gray-800" aria-current="page">&nbsp; Benefícios<span> -->

            <ol class="breadcrumb">
              <li class="breadcrumb-item h4"><a href="atendimento"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
              <!-- <li class="breadcrumb-item">Bootstrap UI</li> -->
              <li class="breadcrumb-item active h4" aria-current="page">Fale com o RH</li>
            </ol>

          </div>
          <!-- FIM DIV ICONE VOLTAR -->

          <!-- DIV ROW -->
          <div class="row mb-3">
            <!-- RECIBOS PAGAMENTOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a class="text-decoration-none" href="minhas_solicitacoes">
                <div class="card-body user-select-none">
                  <div class="row align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">MINHAS SOLICITAÇÕES</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-list-alt fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <!-- RECIBOS DIVERSOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a class="text-decoration-none" href="notificacoes">
                <div class="card-body user-select-none">
                  <div class="row no-gutters align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">MINHAS NOTIFICAÇÕES</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-bell fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <!-- INFORME RENDIMENTOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a class="text-decoration-none" href="mural_avisos">
                <div class="card-body user-select-none">
                  <div class="row no-gutters align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">MURAL DE AVISOS</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-window-maximize fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>

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