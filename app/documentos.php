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
  <link href="img/logo/logo.ico" rel="icon">
  <title>Gestou - Meus Documentos</title>
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

    <!-- DIV CONTENT WRAPPER -->
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
              <li class="breadcrumb-item active h4" aria-current="page">Meus Documentos</li>
            </ol>
          </div>

          <!-- DIV ROW -->
          <div class="row mb-3">

            <!-- CARD HOLERITE -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100" page="holerite" style="cursor: pointer;">
                <div class="card-body user-select-none">
                  <div class="row align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Holerite</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-invoice-dollar fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD ESPELHOS PONTOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100" page="espelho_ponto" style="cursor: pointer;">
                <div class="card-body user-select-none">
                  <div class="row no-gutters align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Espelho de Ponto</div>
                    </div>
                    <div class="col-auto">
                      <img src="img/logo/documentos/espelho_pontos.svg" height="32" width="24"></img>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD DOCUMENTOS DIVERSOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100" page="documentos_diversos" style="cursor: pointer;">
                <div class="card-body user-select-none">
                  <div class="row no-gutters align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Documentos Diversos</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-receipt fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD INFORME RENDIMENTOS -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100" page="informe_rendimento" style="cursor: pointer;">
                <div class="card-body user-select-none">
                  <div class="row no-gutters align-items-center padding-2em">
                    <div class="col mr-2">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Informe de Rendimentos</div>
                    </div>
                    <div class="col-auto">
                      <img src="img/logo/documentos/informe_rendimentos.png" height="32" width="24"></img>
                    </div>
                  </div>
                </div>
              </div>
            </div>

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

  // CLICK NOS CARDS
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