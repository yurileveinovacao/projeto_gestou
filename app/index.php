<?php

//Faz a requisição da Sessão
require 'restrito.php';

// Chama a pagina de utilidades
require 'util.php';

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
  <link href="css/ruang-admin.css" rel="stylesheet" type="text/css">
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

  <!-- INICIO WRAPPER -->
  <div id="wrapper">

    <!-- LEFTBAR -->
    <?php include_once 'menu_lateral.php'; ?>

    <!-- INICIO CONTENT WRAPPER -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- INCIO MAIN CONTENT -->
      <div id="content">

        <!-- TOPBAR -->
        <?php include_once 'menu_superior.php'; ?>

        <!-- INICIO CONTAINER FLUID-->
        <div class="container-fluid" id="container-wrapper">

          <!-- DIV ROW -->
          <div class="row mb-3">

            <?php if ($situac_default == 1) { ?>

              <!-- CARD EMPRESA -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100" page="empresa" style="cursor: pointer;">
                  <div class="card-body user-select-none">
                    <div class="row align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">EMPRESA</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-building fa-2x text-primary"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CARD MEUS DOCUMENTOS -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100" page="documentos" style="cursor: pointer;">
                  <div class="card-body user-select-none">
                    <div class="row no-gutters align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">MEUS DOCUMENTOS</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CARD FALE COM RH -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100" page="fale_rh" style="cursor: pointer;">
                  <div class="card-body user-select-none">
                    <div class="row no-gutters align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">FALE COM RH</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-headset fa-2x text-danger"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CARD MEUS DADOS -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100" page="meus_dados" style="cursor: pointer;">
                  <div class="card-body user-select-none">
                    <div class="row no-gutters align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">MEUS DADOS</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-user-circle fa-2x text-info"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else { ?>

              <!-- CARD DOCUMENTOS -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100" page="beneficios" style="cursor: pointer;">
                  <div class="card-body user-select-none">
                    <div class="row no-gutters align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">BENEFÍCIOS</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } ?>

          </div>
          <!-- FIM DIV ROW -->

        </div>
        <!-- FIM CONTAINER FLUID -->

      </div>
      <!-- FIM MAIN CONTENT -->

      <!-- FOOTER -->
      <?php include_once 'footer.php'; ?>

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
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<script>
  // Aguarda o documento estar pronto antes de executar o código jQuery
  $(function() {
    // Quando um elemento com a classe 'h-100' é clicado
    $(document).on('click', '.h-100', function() {

      // Obtém o valor do atributo 'page' do elemento clicado
      var pagina = $(this).attr('page');

      // Verifica se o valor do atributo 'page' não é vazio
      if (pagina !== '') {

        // Redireciona para a página especificada pelo valor do atributo 'page'
        location.href = pagina;
      }
    });
  });
</script>