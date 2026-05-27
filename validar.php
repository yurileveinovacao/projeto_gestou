<?php

unset($_SESSION["download_id_validador"]);
unset($_SESSION["download_raiz_validador"]);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>GESTOU - Validar Recibo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <link href="img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="vendor/aos/aos.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Bootslander - v4.7.0
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index"><img src="/img/gestou-logo.png" height="40" alt="Logo Gestou Amarelo"></img></a></h1>
      </div>

    </div>
  </header>
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">

    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
          <div data-aos="zoom-out" class="text-center">
            <h1>Valide seu código que foi gerado através do <span class="fonte-texto-gestou">GESTOU</span></h1>
            <h2>Este código permite a verificação da autenticidade das informações que estão no recibo de pagamento
              gerado.</h2>

            <?php

            try {
              // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
              if (isset($_REQUEST['hl'])) {

                $id_recibo_holerite = $_REQUEST["hl"];
              }
            } catch (PDOException $erro) {
              echo $erro->getMessage();
            }

            ?>

            <!-- <form action="validar" method="post"> -->
            <div>
              <input type="text" id="codigo" name="codigo" value="<?php echo $id_recibo_holerite; ?>" style="width: 80%; height: 50px; margin-bottom: 20px; font-size: x-large; padding: 20px; text-align: center;">
            </div>
            <button type="button" id="enviar" name="enviar" style="border: none;" class="text-center text-lg-start btn-get-started"><span class="fonte-texto-gestou" style="font-size: x-large;">VALIDAR</span></button>
            <!-- </form> -->
          </div>
        </div>
        <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
          <img src="img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
      </g>
    </svg>

  </section>
  <!-- End Hero -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="vendor/purecounter/purecounter.js"></script>
  <script src="vendor/aos/aos.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/glightbox/js/glightbox.min.js"></script>
  <script src="vendor/swiper/swiper-bundle.min.js"></script>
  <script src="vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="js/main.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>

<script>
  //Clique BOTÃO FILTRO para redirecionar para a página salvando em SESSION o que foi clicado
  $(document).ready(function() {
    $(document).on('click', '#enviar', function() {

      var codigo = $("#codigo").val();

      //verificar se há valor nas variaveis
      if (codigo !== '') {
        var dados = {
          codigo: codigo
        };
        // alert(filtro_status);
        $.post('consulta_registro.php', dados, function(retorna) {

          if (retorna == 1) {

            location.href = "validar_download";

          } else if (retorna == 0) {

            window.location.reload();

          } else if (retorna == 3) {

            location.href = "validar_download_arquivo";

          } else {

            location.href = "validar";

          }

        });

      }

    });

  });
</script>

<?php

// require "app/iuds_app.php";

// try {
//   // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
//   if (isset($_REQUEST['enviar'])) {

//     $id_validador = $_POST['codigo'];
//     $raiz_validador = substr($id_validador, 0, 8);

//     foreach (select_VERIFICA_TABELA($raiz_validador) as $resultados) {
//       if ($resultados['exists']) {
//         echo 'existe';

//         foreach (select_HOLERITE($raiz_validador, $id_validador) as $count_holerite) {

//           $contagem = $count_holerite["contagem"];
//         }

//         if ($contagem == 1) {

//           session_start();

//           $_SESSION['download_id_validador'] = $id_validador;
//           $_SESSION['download_raiz_validador'] = $raiz_validador;

//           echo "<script>location.href = 'validar_download';</script>";
//         } else {

//           echo "<script language=javascript>
// 			alert('Código Inválido!');
// 			location.href = 'validar?hl=" . $id_validador . "';
// 			</script>";
//         }
//       } else {

//         echo "<script language=javascript>
// 			alert('Código Inválido!');
// 			location.href = 'validar';
// 			</script>";
//       }
//     }
//   }
// } catch (PDOException $erro) {
//   echo $erro->getMessage();
// }

?>