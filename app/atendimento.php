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
  <title>Gestou - Fale com RH</title>
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
          <div class="iconedireita mb-4 user-select-none">
            <ol class="breadcrumb">
              <li class="breadcrumb-item h4"><a href="./"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
              <li class="breadcrumb-item active h4" aria-current="page">Fale com RH</li>
            </ol>

          </div>
          <!-- FIM DIV ICONE VOLTAR -->

          <!-- DIV ROW -->
          <div class="row mb-3">
            <!-- RECIBOS PAGAMENTOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a class="text-decoration-none" href="fale_rh">
                  <div class="card-body user-select-none">
                    <div class="row align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Fale com RH</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-comment-dots fa-2x text-danger"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>

            <!-- RECIBOS DIVERSOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <a class="text-decoration-none" href="ouvidoria">
                  <div class="card-body user-select-none">
                    <div class="row no-gutters align-items-center padding-2em">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Ouvidoria Interna</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-podcast fa-2x text-danger"></i>
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
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>


<!-- AÇÕES NO CLICK -->
<script>
  // BTN VOLTAR
  // Esta função é executada quando o documento é carregado
  $(function() {
    // Ao clicar em um elemento com a classe 'btn-voltar'
    $(document).on('click', '.btn-voltar', function() {

      // Redireciona para a página 'index'
      location.href = 'index';
    });
  });

  // // CLICK NOS CARDS
  // // Aguarda o documento estar pronto antes de executar o código jQuery
  // $(function() {
  //   // Quando um elemento com a classe 'h-100' é clicado
  //   $(document).on('click', '.h-100', function() {

  //     // Obtém o valor do atributo 'page' do elemento clicado
  //     var pagina = $(this).attr('page');

  //     // Verifica se o valor do atributo 'page' não é vazio
  //     if (pagina !== '') {

  //       // Redireciona para a página especificada pelo valor do atributo 'page'
  //       location.href = pagina;
  //     }
  //   });
  // });
</script>