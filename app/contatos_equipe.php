<?php

//Faz a requisição da Sessão
require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

// VARIAVEL DE COMPARACAO MOBILE
$pagina = "H";

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
  <link href="css/ruang-admin.css" rel="stylesheet" type="text/css">

  <link href="https://www.cssscript.com/demo/sticky.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />

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

        <!-- MENU SUPERIOR -->
        <?php

        include_once 'menu_superior copy.php';

        ?>
        <!-- FIM MENU SUPERIOR -->

        <!-- DIV CONTAINER FLUID-->
        <div class="container-fluid" id="container-wrapper">

          <!-- DIV ICONE VOLTAR -->
          <div class="iconedireita mb-4 user-select-none">
            <ol class="breadcrumb">
              <li class="breadcrumb-item h5"><a href="index"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
              <li class="breadcrumb-item active h5" aria-current="page">Contatos Equipe</li>
            </ol>
          </div>
          <!-- FIM DIV ICONE VOLTAR -->

          <?php

          if (isset($_REQUEST['ce'])) {
            $_SESSION['id_usu_ce'] = $_REQUEST['ce'];
            $id_usu_ce = $_SESSION['id_usu_ce'];
          }

          foreach (select_SEUS_DADOS($id_usu_ce) as $contato_equipe) {

            $imagem = $contato_equipe["imagem"];
            $nome_abreviado = $contato_equipe["nome_abreviado"];
            $email = $contato_equipe["email"];
            $telefone = $contato_equipe["telefone"];
            $celular = $contato_equipe["celular"];
            $funcao = $contato_equipe["funcao"];
            $linkedin = $contato_equipe["linkedin"];
          }

          ?>

          <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4 mb-4">
            <div class="col">
              <div class="card radius-15">
                <div class="card-body text-center">
                  <div class="p-4 border radius-15">
                    <img src="../upload/cadastro/<?php echo $imagem; ?>" width="110" height="110" class="rounded-circle shadow" alt="">
                    <h5 class="mb-0 mt-5"><?php echo $nome_abreviado; ?></h5>
                    <p class="mb-3" style="font-size: 12px;"><?php echo $funcao; ?></p>
                    <div class="list-inline contacts-social mt-3 mb-3">
                      <?php if (empty($telefone)) { ?>
                        <a class="list-inline-item bg-secondary text-white border-0" onclick="sem_informacao()"><i class="fas fa-phone"></i></a>
                      <?php } else { ?>
                        <a href="tel:+55<?php echo $telefone; ?>" class="list-inline-item bg-twitter text-white border-0"><i class="fas fa-phone"></i></a>
                      <?php } ?>
                      <?php if (empty($email)) { ?>
                        <a class="list-inline-item bg-secondary text-white border-0" onclick="sem_informacao()"><i class="fas fa-envelope"></i></a>
                      <?php } else { ?>
                        <a href="mailto:<?php echo $email; ?>" class="list-inline-item bg-twitter text-white border-0"><i class="fas fa-envelope"></i></a>
                      <?php } ?>
                      <?php if (empty($linkedin)) { ?>
                        <a class="list-inline-item bg-secondary text-white border-0" onclick="sem_informacao()"><i class="fab fa-linkedin"></i></a>
                      <?php } else { ?>
                        <a href="<?php echo $linkedin; ?>" target="_blank" class="list-inline-item bg-twitter text-white border-0"><i class="fab fa-linkedin"></i></a>
                      <?php } ?>
                      <!-- <a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0"><i class="fas fa-envelope"></i></a> -->
                      <!-- <a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0"><i class="fab fa-linkedin"></i></a> -->
                    </div>
                    <!-- <div class="d-grid"> <a href="#" class="btn btn-outline-primary radius-15">Contact Me</a>
                    </div> -->
                  </div>
                </div>
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

  <!-- INCLUDE NAVBAR MOBILE -->
  <?php include_once "nav_mobile.php"; ?>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

  <!-- SWEET ALERT -->
  <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
  <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
  <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

  <!-- OCULTA E EXIBE AS NAVS -->
  <script src="js/oculta_navbars.js"></script>
  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="js/slick/slick.js" type="text/javascript" charset="utf-8"></script>

  <script type="text/javascript">
    $(document).on('ready', function() {
      $('.multiple-items').slick({
        infinite: true,
        dots: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: false,
        responsive: [{
            breakpoint: 1920,
            settings: {
              slidesToShow: 8,
              slidesToScroll: 8,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 800,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      })

    });

    function sem_informacao() {

      Swal.fire({
        icon: "info",
        title: "Info",
        title: 'Atenção!',
        text: 'Não existe informação cadastrada!'
      });

    }
  </script>

</body>

</html>

<!-- <script>
  window.addEventListener('orientationchange', function() {
    switch (window.orientation) {
      case -90:
      case 90:
        // alert('landscape');
        $('#nav-mobile').css("display", "none")
        $('#accordionSidebar').css("display", "")
        break;
      default:
        // alert('portrait');
        $('#accordionSidebar').css("display", "none");
        $('#nav-mobile').css("display", "")
        break;
    }
  });
</script> -->