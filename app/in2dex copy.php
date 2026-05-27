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
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <title>Gestou - APP</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
  <link href="css/ruang-admin.css" rel="stylesheet" type="text/css">

  <link href="https://www.cssscript.com/demo/sticky.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <!-- <link rel="stylesheet" href="css/styless.css"> -->

  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">

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

          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb iconedireita">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div> -->

          <!-- DIV ICONE VOLTAR -->
          <!-- <div class="iconedireita mb-4">

          <a href="./"><i class="fas fa-chevron-circle-left fa-2x"></i></a>

          </div> -->
          <!-- FIM DIV ICONE VOLTAR -->

          <!-- <div class="row mb-4">
            <div class="col-md-12">
              <h5>Olá, <span class="font-weight-bold cor-brave fonte-texto-gestou">?php echo explode(' ', $nome_usuario_default)[0]; ?></span></h5>
            </div>
          </div> -->

          <section class="multiple-items" id="fotos_contatos" style="display: none;">

            <?php foreach (select_FOTOS_EMPRESA($id_emp_default, $id_dep_default) as $fotos_empresa) { ?>

              <?php if ($fotos_empresa["regra"] == $agrdep_default) { ?>

                <a href="contatos_equipe?ce=<?php echo $fotos_empresa["id_usu"]; ?>">
                  <div class="rounded-circle text-center" style="background-color: #fff;">
                    <img class="img-profile rounded-circle img-fluid" height="50px" src="../upload/cadastro/<?php echo $fotos_empresa["imagem"]; ?>">
                    <p class="fs-nome-fotos mt-1">
                      <?php echo $fotos_empresa["primeiro_nome"]; ?>
                    </p>
                  </div>
                </a>

              <?php } ?>
            <?php } ?>

          </section>

          <!-- </div>
              </div>
            </div> -->
          <!-- </div> -->

          <!-- DIV ROW COMO ESTOU ME SENTINDO -->
          <div class="row mb-3">
            <!-- COMO ESTOU ME SENTINDO -->
            <div class="col-xl-12 col-md-12 mb-4">
              <div class="card h-100">
                <!-- <a class="text-decoration-none" href="empresa"> -->
                <div class="card-body user-select-none">
                  <div class="row align-items-center padding-1em mb-4">
                    <div class="col">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Como estou me sentindo?</div>
                    </div>
                  </div>
                  <div class="row align-items-center text-center padding-1em">
                    <div class="m-auto">
                      <i class="fas fa-laugh-beam fa-2x text-secondary shadow-emoji"></i>
                    </div>
                    <div class="m-auto">
                      <i class="fas fa-smile fa-2x text-secondary shadow-emoji"></i>
                    </div>
                    <div class="m-auto">
                      <i class="fas fa-meh fa-2x text-warning shadow-emoji"></i>
                    </div>
                    <div class="m-auto">
                      <i class="fas fa-frown fa-2x text-secondary shadow-emoji"></i>
                    </div>
                    <div class="m-auto">
                      <i class="fas fa-angry fa-2x text-secondary shadow-emoji"></i>
                    </div>
                    <!-- <div class="col-auto">
                        <i class="fas fa-building fa-2x text-primary"></i>
                      </div> -->
                  </div>
                </div>
                <!-- </a> -->
              </div>
            </div>
            <!-- FIM COMO ESTOU ME SENTINDO -->

          </div>
          <!-- FIM DIV ROW -->

          <!-- BOTOES FILTROS -->
          <div class="col-md-12 mb-4">

            <div class="row">

              <div class="col-md-metade pr-2">
                <button class="btn btn-brave width-100 mb-2 btn1" id="celebracoes" data-cad="celebracoes">Celebrações
                  <i class="fas fa-birthday-cake"></i>
                </button>
              </div>
              <div class="col-md-metade pl-2">
                <button class="btn btn-secondary width-100 mb-2 btn1" id="anuncios" data-cad="anuncios">Anúncios
                  <i class="fas fa-bullhorn"></i>
                  <span class="badge badge-danger badge-counter badge-botao-menu">
                    5
                  </span>
                </button>
              </div>

            </div>

          </div>
          <!-- FIM COMO ESTOU ME SENTINDO -->

          <!-- DIV ROW ANIVERSARIOS -->
          <div class="row mb-3 filtros">
            <!-- ANIVERSARIOS -->
            <div class="col-xl-12 col-md-12 mb-4 filtro celebracoes">
              <div class="card h-100">
                <!-- <a class="text-decoration-none" href="empresa"> -->
                <div class="card-body user-select-none">

                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <div class="rounded-circle text-center" style="background-color: #fff;">
                        <img class="img-profile rounded-circle" style="width: 3.5em;" src="../upload/cadastro/24546709_1646683117.png">
                      </div>
                    </div>
                    <div class="col">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Yuri Pereira <i class="fas fa-birthday-cake"></i></div>
                      <div class="mb-0 mr-3 text-gray-800" style="font-size: 0.7rem;">Aniversário 04 Mai 22</div>
                    </div>
                  </div>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto text-justify">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Hoje nosso colaborador completa mais um ano de vida!</div>
                    </div>
                  </div>
                  <hr>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <button class="btn btn-secondarycards btn-like" id_like="1"><i class="fas fa-thumbs-up"></i>
                        <span class="badge badge-danger badge-counter badge-botao-like" id_like_badge="1">5</span>
                      </button>
                      <button class="btn btn-secondarycards btn-cake" id_cake="1"><i class="fas fa-birthday-cake"></i>
                        <span class="badge badge-danger badge-counter badge-botao-cake" id_cake_badge="1">9</span>
                      </button>
                    </div>
                    <div class="col text-right">
                      <i class="fas fa-eye"></i> 11 View
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ANIVERSARIOS -->
            <div class="col-xl-12 col-md-12 mb-4 filtro celebracoes">
              <div class="card h-100">
                <!-- <a class="text-decoration-none" href="empresa"> -->
                <div class="card-body user-select-none">

                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <div class="rounded-circle text-center" style="background-color: #fff;">
                        <img class="img-profile rounded-circle" style="width: 3.5em;" src="../upload/cadastro/24546709_1647281615.png">
                      </div>
                    </div>
                    <div class="col">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Junior Tiezzi <i class="fas fa-birthday-cake"></i></div>
                      <div class="mb-0 mr-3 text-gray-800" style="font-size: 0.7rem;">Aniversário 04 Mai 22</div>
                    </div>
                  </div>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto text-justify">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Hoje nosso colaborador completa mais um ano de vida!</div>
                    </div>
                  </div>
                  <hr>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <button class="btn btn-secondarycards btn-like" id_like="2"><i class="fas fa-thumbs-up"></i>
                        <span class="badge badge-danger badge-counter badge-botao-like" id_like_badge="2">9</span>
                      </button>
                      <button class="btn btn-secondarycards btn-cake" id_cake="2"><i class="fas fa-birthday-cake"></i>
                        <span class="badge badge-danger badge-counter badge-botao-cake" id_cake_badge="2">5</span>
                      </button>
                    </div>
                    <div class="col text-right">
                      <i class="fas fa-eye"></i> 11 View
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- ANIVERSARIOS -->
            <div class="col-xl-12 col-md-12 mb-4 filtro anuncios" style="display: none;">
              <div class="card h-100">
                <!-- <a class="text-decoration-none" href="empresa"> -->
                <div class="card-body user-select-none">

                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <div class="rounded-circle text-center" style="background-color: #fff;">
                        <div class="icon-circle bg-danger">
                          <i class="fas fa-window-maximize text-white"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Mural de Avisos</div>
                      <div class="mb-0 mr-3 text-gray-800" style="font-size: 0.7rem;">Inclusão 09 Mai 22</div>
                    </div>
                  </div>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto text-justify">
                      <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Teste mural de avisos!</div>
                    </div>
                  </div>
                  <hr>
                  <div class="row align-items-center mb-4">
                    <div class="col-auto">
                      <button class="btn btn-primary">Visualizar
                      </button>
                    </div>
                    <div class="col text-right">
                      <i class="fas fa-eye"></i> 11 View
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- FIM DIV ROW ANIVERSARIOS -->

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

  <!-- OCULTA E EXIBE AS NAVS -->
  <script src="js/oculta_navbars.js"></script>
  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="js/slick/slick.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>

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
</script>

<script>
  $('.btn1').on('click', function() {
    var cat = $(this).attr('data-cad')

    //Botão celebracoes
    if (cat == 'celebracoes') {
      //Remove e aplica cor nos botoes 
      $(this).removeClass('btn-secondary').addClass('btn-brave');
      $('#anuncios').removeClass('btn-brave').addClass('btn-secondary');
    }
    //Botão anuncios
    if (cat == 'anuncios') {
      //Exibe o menu que estava oculto 
      $('.filtro div').show();
      //Remove e aplica cor nos botoes 
      $(this).removeClass('btn-secondary').addClass('btn-brave');
      $('#celebracoes').removeClass('btn-brave').addClass('btn-secondary');
      //Remove os badges do botao
      // $('.badge-botao-menu').hide();
    }
    if (cat == 'todos') {
      $('.filtros div').show()
    } else {
      $('.filtro').each(function() {
        if (!$(this).hasClass(cat)) {
          $(this).hide()
        } else {
          $(this).show()
        }
      })
    }
  })
</script>

<script>
  $(document).ready(function() {

    $('#fotos_contatos').show();

  });

  $(document).ready(function() {
    $('.btn-like').on('click', function() {

      //COLETA DO ID_LIKE DO BOTAO
      var id_like = $(this).attr("id_like");

      //IF VERIFICANDO A CLASSE DO BOTAO
      if ($(this).hasClass('btn-secondarycards')) {

        //COLETA DO TEXTO DA BADGE
        var count = $(this).text();
        var count = parseInt(count);

        //SETANDO O NOVO VALOR NA BADGE COM O MESMO ID DO ID_LIKE
        $("[id_like_badge=" + id_like + "]").text(count++ + 1);

      }

      //IF VERIFICANDO A CLASSE DO BOTAO
      if ($(this).hasClass('btn-brave')) {

        //COLETA DO TEXTO DA BADGE
        var count = $(this).text();
        var count = parseInt(count);

        //SETANDO O NOVO VALOR NA BADGE COM O MESMO ID DO ID_LIKE
        $("[id_like_badge=" + id_like + "]").text(count-- - 1);

      }

      //TROCA DAS CLASSES 
      $(this).toggleClass('btn-brave');
      $(this).toggleClass('btn-secondarycards');

    });
  });

  $(document).ready(function() {
    $('.btn-cake').on('click', function() {

      //COLETA DO ID_CAKE DO BOTAO
      var id_cake = $(this).attr("id_cake");

      //IF VERIFICANDO A CLASSE DO BOTAO
      if ($(this).hasClass('btn-secondarycards')) {

        //COLETA DO TEXTO DA BADGE
        var count = $(this).text();
        var count = parseInt(count);

        //SETANDO O NOVO VALOR NA BADGE COM O MESMO ID DO ID_CAKE
        $("[id_cake_badge=" + id_cake + "]").text(count++ + 1);

      }

      //IF VERIFICANDO A CLASSE DO BOTAO
      if ($(this).hasClass('btn-brave')) {

        //COLETA DO TEXTO DA BADGE
        var count = $(this).text();
        var count = parseInt(count);

        //SETANDO O NOVO VALOR NA BADGE COM O MESMO ID DO ID_CAKE
        $("[id_cake_badge=" + id_cake + "]").text(count-- - 1);

      }

      //TROCA DAS CLASSES 
      $(this).toggleClass('btn-brave');
      $(this).toggleClass('btn-secondarycards');

    });
  });
</script>