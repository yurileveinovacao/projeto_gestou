<?php

try {
  // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
  if (isset($_REQUEST['token'])) {

    $token = $_REQUEST["token"];
  }
} catch (PDOException $erro) {
  echo $erro->getMessage();
}

// echo "TOKEN:" . $token;

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>GESTOU - Validar E-mail</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/logo.ico" rel="icon">
  <link href="img/logo.ico" rel="apple-touch-icon">

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

  <!-- SWEET ALERT -->
  <link rel="stylesheet" href="admin/vendor_sweeetalert/sweetalert2.min.css">
  <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
  <script src="admin/vendor_sweeetalert/sweetalert2.all.min.js"></script>

  <!-- =======================================================
  * Template Name: Bootslander - v4.7.0
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index"><img src="https://www.gestou.com.br/img/logo_gestou_escrita_branco_logo_amarelo.png" height="40" alt="Logo Gestou Amarelo"></img></a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="#hero" class="nav-link scrollto active">Início</a></li>
          <li class="dropdown" style="cursor: pointer"><a href="./#" class="nav-link">Serviços<i class="bi bi-chevron-down"></i></a>
            <ul>
          </li>
          <li><a href="https://www.gestou.com.br/admin/login">Administrador</a></li>
          <li><a href="https://www.gestou.com.br/app/login">Holerite Digital</a></li>
          <li><a href="https://www.gestou.com.br/validar">Validar Holerite</a></li>
          <li><a href="https://www.gestou.com.br/download">Download</a></li>
        </ul>
        </li>
        <li><a href="./#features" class="nav-link scrollto">Recursos</a></li>
        <li><a href="./#gallery" class="nav-link scrollto">Galeria</a></li>
        <li><a href="contato" class="nav-link scrollto">Contato</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->

    </div>
  </header>
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">

    <div class="container pt-5 pb-5">
      <div class="row justify-content-between">
        <div class="col-lg-12 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
          <div data-aos="zoom-out" class="text-center">
            <div id="retorno-mensagem">
            </div>
            <!-- <h1>O e-mail foi validado e sua empresa está apta a utilizar o <span class="fonte-texto-gestou">GESTOU</span></h1>
              <h2>Obrigado por validar o e-mail.</h2>
              <button type="button" id="login" name="login" style="border: none;" class="text-center text-lg-start btn-get-started"><span class="fonte-texto-gestou" style="font-size: x-large;">LOGIN</span></button> -->
          </div>
        </div>
        <!-- <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
          <img src="img/hero-img.png" class="img-fluid animated" alt="">
        </div> -->
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


  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Links Úteis</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="index">Início</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="./#about">Serviços</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="./#features">Recursos</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="./#gallery">Galeria</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.gestou.com.br/contato">Contato</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Nossos Serviços</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.gestou.com.br/admin/login">Administrador</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.gestou.com.br/app/login">Holerite Digital</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.gestou.com.br/validar">Validar Holerite</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="https://www.gestou.com.br/download">Download</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Nosso boletim informativo</h4>
            <p>Deixe seu e-mail abaixo para receber nosso informativo por e-mail!</p>
            <form action="" method="post">
              <input type="email" id="email_informativo" name="email_informativo">
              <input type="submit" id="btn_informativo" value="Enviar">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span class="fonte-texto-gestou">GESTOU</span></strong>. Todos os direitos reservados!
      </div>
      <div class="credits">
      </div>
    </div>
  </footer><!-- End Footer -->

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
    // $(document).on('click', '#enviar', function() {

    // Obtenha a URL atual
    var url = new URL(window.location.href);

    // Obtenha o objeto URLSearchParams da URL
    var params = new URLSearchParams(url.search);

    // Obtenha o valor de um parâmetro específico
    var parametro = params.get('token');

    if (parametro !== null) {

      //verificar se há valor nas variaveis
      if (parametro !== '') {
        var dados = {
          parametro: parametro
        };

        $.post('controller/validar_email_post.php', dados, function(retorno) {

          //Carregar o conteudo para o usuário
          $("#retorno-mensagem").html(retorno);

        });

      }

    } else {

      var dados = {
        parametro: parametro
      };

      $.post('controller/validar_email_post.php', dados, function(retorno) {

        //Carregar o conteudo para o usuário
        $("#retorno-mensagem").html(retorno);

      });

    }

  });
</script>