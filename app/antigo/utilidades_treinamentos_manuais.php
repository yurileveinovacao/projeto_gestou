<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../../config/database.php';

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
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
              <li class="breadcrumb-item h5"><a href="utilidades"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
              <!-- <li class="breadcrumb-item">Bootstrap UI</li> -->
              <li class="breadcrumb-item active h5" aria-current="page">Treinamentos e Manuais</li>
            </ol>

          </div>
          <!-- FIM DIV ICONE VOLTAR -->

          <?php

          foreach (select_GESTRE_count($id_emp_default, $id_usu_default) as $contagem) {

            $contagem = $contagem["contagem"];
          }

          ?>

          <?php

          if ($contagem > 0) {

          ?>

            <div class="row">
              <!-- DataTable with Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Treinamentos e Manuais</h6>
                  </div>
                  <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                      <thead class="thead-light">
                        <tr>
                          <th>Nome</th>
                          <th>Treinamentos</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Nome</th>
                          <th>Treinamentos</th>
                        </tr>
                      </tfoot>
                      <tbody>

                        <?php foreach (select_GESTRE($id_emp_default, $id_usu_default) as $treinamentos) {

                          if ($treinamentos != 0) {
                        ?>

                            <tr>
                              <td class="td-politicas"><?php echo $nome = $treinamentos["nome"]; ?></td>
                              <td class="td-politicas text-center"><?php if (!empty($treinamentos["anexo"])) {  ?>
                                  <a href="../upload/utilidades/treinamentos/<?php echo $anexo = $treinamentos["anexo"]; ?>" download="<?php echo $nome; ?>"><button type="button" class="btn btn-primary">Download</button></a>
                                <?php }else{
                                  ?>
                                  <a href="<?php echo $treinamentos["link"]; ?>"><?php echo $treinamentos["link"]; ?></a>
                                  <?php 
                                } ?>
                              </td>
                            </tr>

                        <?php
                          }
                        }
                        ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--Row-->

          <?php } else { ?>

            <!-- DIV ROW -->
            <div class="row mb-3">
              <!-- SOBRE -->
              <div class="m-auto">
                <img class="img-fluid" width="400" src="img/logo/blank_treinamentos_manuais.png"></img>
              </div>

            </div>
            <!-- FIM DIV ROW -->

          <?php } ?>

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
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>