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
  <title>Gestou - Missão, Visão e Valores</title>
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

        <!-- INCIO CONTAINER FLUID-->
        <div class="container-fluid" id="container-wrapper">

          <!-- DIV BTN VOLTAR -->
          <div class="iconedireita user-select-none">
            <ol class="breadcrumb">
              <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                <i class="fas fa-chevron-circle-left fa-1x"></i>
              </li>
              <li class="breadcrumb-item active h4" aria-current="page">Missão, Visão e Valores</li>
            </ol>
          </div>

          <?php

          foreach (select_GESSOB_mis_vis_val($id_emp_default) as $mis_vis_val) {

            $mis_texto = $mis_vis_val["mis_texto"];
            $mis_imagem = $mis_vis_val["mis_imagem"];
            $vis_texto = $mis_vis_val["vis_texto"];
            $vis_imagem = $mis_vis_val["vis_imagem"];
            $val_texto = $mis_vis_val["val_texto"];
            $val_imagem = $mis_vis_val["val_imagem"];
          }

          if (!empty($mis_texto) or !empty($mis_imagem) or !empty($vis_texto) or !empty($vis_imagem) or !empty($val_texto) or !empty($val_imagem)) {

            if (!empty($mis_texto) or !empty($mis_imagem)) { ?>

              <!-- DIV ROW -->
              <div class="row mb-3">
                <!-- RECIBOS PAGAMENTOS -->
                <div class="col-xl-12 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-body user-select-none">
                      <div class="row align-items-center padding-2em">
                        <div class="col text-center">
                          <div class="mb-3">
                            <h4 class="fonte-texto-gestou cor-brave">MISSÃO</h4>
                            <hr>
                          </div>
                          <?php if (!empty($mis_imagem)) { ?>
                            <div class="row mb-5">
                              <img class="img-fluid imagem-card m-auto" src="../upload/empresa/<?php echo $mis_imagem; ?>"></img>
                            </div>
                          <?php } ?>
                          <?php if (!empty($mis_texto)) { ?>
                            <div class="row">
                              <div class="mb-0 font-weight-bold text-gray-800 text-justify"><?php echo $mis_texto; ?></div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- FIM DIV ROW -->

            <?php } else {
            }

            if (!empty($vis_texto) or !empty($vis_imagem)) { ?>

              <!-- DIV ROW -->
              <div class="row mb-3">
                <!-- RECIBOS PAGAMENTOS -->
                <div class="col-xl-12 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-body user-select-none">
                      <div class="row align-items-center padding-2em">
                        <div class="col text-center">
                          <div class="mb-3">
                            <h4 class="fonte-texto-gestou cor-brave">VISÃO</h4>
                            <hr>
                          </div>
                          <?php if (!empty($vis_imagem)) { ?>
                            <div class="row mb-5">
                              <img class="img-fluid imagem-card m-auto" src="../upload/empresa/<?php echo $vis_imagem; ?>"></img>
                            </div>
                          <?php } ?>
                          <?php if (!empty($vis_texto)) { ?>
                            <div class="row">
                              <div class="mb-0 font-weight-bold text-gray-800 text-justify"><?php echo $vis_texto; ?></div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- FIM DIV ROW -->

            <?php } else {
            }

            if (!empty($val_texto) or !empty($val_imagem)) { ?>

              <!-- DIV ROW -->
              <div class="row mb-3">
                <!-- RECIBOS PAGAMENTOS -->
                <div class="col-xl-12 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-body user-select-none">
                      <div class="row align-items-center padding-2em">
                        <div class="col text-center">
                          <div class="mb-3">
                            <h4 class="fonte-texto-gestou cor-brave">VALORES</h4>
                            <hr>
                          </div>
                          <?php if (!empty($val_imagem)) { ?>
                            <div class="row mb-5">
                              <img class="img-fluid imagem-card m-auto" src="../upload/empresa/<?php echo $val_imagem; ?>"></img>
                            </div>
                          <?php } ?>
                          <?php if (!empty($val_texto)) { ?>
                            <div class="row">
                              <div class="mb-0 font-weight-bold text-gray-800 text-justify"><?php echo $val_texto; ?></div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- FIM DIV ROW -->

            <?php } else {
            }
          } else { ?>

            <!-- DIV ROW -->
            <div class="row mb-3">
              <!-- SOBRE -->
              <div class="m-auto">
                <img class="img-fluid" width="400" src="img/logo/blank_image.png"></img>
              </div>

            </div>
            <!-- FIM DIV ROW -->

          <?php } ?>

        </div>
        <!-- FIM DIV CONTAINER FLUID -->

      </div>
      <!-- FIM DIV CONTENT -->

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
  // BTN VOLTAR
  // Esta função é executada quando o documento é carregado
  $(function() {
    // Ao clicar em um elemento com a classe 'btn-voltar'
    $(document).on('click', '.btn-voltar', function() {

      // Redireciona para a página 'empresa'
      location.href = 'empresa';
    });
  });
</script>