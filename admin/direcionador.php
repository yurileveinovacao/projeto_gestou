<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title>Validando o Arquivo</title>
  <link rel="icon" type="image/png" href="../img/logo.ico" />
  <meta charset="utf-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />

  <link href="https://fonts.googleapis.com/css?family=Droid+Sans+Mono" rel="stylesheet">
  <link rel="prefetch" href="http://www.iconsdb.com/icons/preview/white/check-mark-xxl.png">
  <link rel="prefetch" href="http://www.iconsdb.com/icons/preview/white/x-mark-xxl.png">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      transition: 0.5s cubic-bezier(0.5, 0, 0.2, 1);
    }

    .abs-center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .container {
      width: 80px;
      height: 80px;
      perspective: 5000px;
      transform-style: preserve-3d;
    }

    .container.flipped {
      transform: translate(-50%, -50%) rotateY(180deg);
    }

    .container.complete .icon-background {
      fill: #21cd92;
      stroke: #21cd92;
    }

    .container.complete .error {
      opacity: 0;
      transition: 0.3s ease;
    }

    .container.error .icon-background {
      fill: #f44336;
      stroke: #f44336;
    }

    .container.error .check {
      opacity: 0;
      transition: 0.3s ease;
    }

    .front,
    .back {
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
    }

    .front {
      z-index: 2;
      transform: rotateY(0deg);
    }

    .back {
      transform: rotateY(180deg);
    }

    .rad-progress,
    .alt-state {
      height: 80px;
      width: 80px;
      border-radius: 100%;
    }

    .rad-progress {
      transform: translate(-50%, -50%) rotateZ(-90deg);
    }

    .progress-background {
      stroke: rgba(0, 0, 0, 0.08);
      stroke-width: 8;
      fill: none;
    }

    .progress-bar {
      stroke: #2195cd;
      stroke-width: 8;
      fill: none;
    }

    .progress-label {
      font-family: 'Droid Sans Mono';
      font-size: 14px;
    }

    .icon {
      height: 30px;
      width: 30px;
      transition: 0.3s 0.3s ease;
      /*
    background-size cover !important
    &.check { background: url('http://www.iconsdb.com/icons/preview/white/check-mark-xxl.png') center no-repeat }
    &.error { background: url('http://www.iconsdb.com/icons/preview/white/x-mark-xxl.png') center no-repeat }
    */
    }

    .icon.check {
      background: url("https://skytango.com/wp-content/uploads/2016/11/White-Checkmark-icon.png") center no-repeat;
      background-size: 130%;
    }

    .icon.error {
      background: url("http://aspiredm.com/wp-content/themes/Aspire2016/library/images/menu-cross.png") center no-repeat;
      background-size: 90%;
    }

    h1 {

      text-align: center;
      margin-top: 15%;
      font-family: 'Ubuntu', sans-serif;

    }
  </style>

</head>

<body>

  <h1>Carregando o Arquivo!</h1>

  <div class="abs-center container">
    <div class="abs-center front">
      <svg viewbox="0 0 80 80" class="abs-center rad-progress">
        <circle class="progress-background" cx="40" cy="40" r="35" />
        <circle class="progress-bar" cx="40" cy="40" r="35" stroke-dasharray="220" stroke-dashoffset="-220" />
        <div class="abs-center progress-label">0%</div>
      </svg>
    </div>
    <div class="abs-center back">
      <svg viewbox="0 0 80 80" class="abs-center alt-state">
        <circle class="icon-background" cx="40" cy="40" r="35" fill="#21cd92" stroke="#21cd92" stroke-width="8" />
        <div class="abs-center icon check"></div>
        <div class="abs-center icon error"></div>
      </svg>
    </div>
  </div>

</body>

</html>

<script>
  // https://uimovement.com/ui/3192/crospots-search/
  function update_progress(pct) {
    if (!isNaN(pct)) {
      if (pct > 100) {
        pct = 100
      }; // Too High
      if (pct < 0) {
        pct = 0
      }; // Too Low
      var offset = ((-parseFloat(pct) / 100) * 220) - 220; // Getting offset for the SVG

      $('.progress-bar').attr('stroke-dashoffset', offset);
      $('.progress-label').text(Number(Math.round(pct + 'e2') + 'e-2') + '%'); // Rounds to two decimal places
    };

    // Check for finish
    (pct === 100) ? (complete()) : (incomplete());

    // setTimeout(direcionar, 6000);
  };

  // Complete and Error States
  function complete() {
    $('.container').addClass('flipped complete').removeClass('error');
  };

  function incomplete() {
    $('.container').removeClass('flipped complete');
  };

  function error() {
    $('.container').addClass('flipped error').removeClass('complete');
  };

  function no_error() {
    $('.container').removeClass('flipped error');
  };
  // function direcionar() { window.location.href = "folhamatic.php"; };

  // For testing
  function test() {
    $('.progress-bar').css('transition', '0.12s ease');
    for (var i = 0; i <= 100; i++) {
      timer_thing(i);
    };
    setTimeout(function() {
      $('.progress-bar').css('transition', '0.4s cubic-bezier(0.5,0,0.2,1)');
    }, 10100);
  };

  function timer_thing(i) {
    setTimeout(function() {
      update_progress(i)
    }, (50 * i));
  };

  test();
</script>

<?php

foreach (selectGESEMP_layout_importacao($id_emp_default) as $linha) {

  $layout = $linha['layout'];
  $tipo_layout = $linha["tipo_layout"];

}

$_SESSION['descricao'] = $_REQUEST['descricao'];

//$diretorio = 'uploads/teste.pdf';
$nomepdf = $_FILES['input-b1']['name'];
$temp = $_FILES['input-b1']['tmp_name'];
$tamanho = $_FILES['input-b1']['size'];
$tipopdf = $_FILES['input-b1']['type'];
$erro = $_FILES['input-b1']['error'];

$ext = pathinfo($nomepdf, PATHINFO_EXTENSION);

$ext = strtolower($ext);

$diretorio = 'uploads/' . $raiz_cnpj . '.' . $ext;

if ($tipo_layout == $ext) {

  if (file_exists($diretorio)) {
    // echo "IF se o diretorio $diretorio existe";

    //unlink('uploads/teste.pdf');

    unlink('uploads/' . $raiz_cnpj . '.' . $ext);

    // $extensao = 'pdf';

    // if (($ext != 'pdf') and ($ext != 'PDF')) {
    //     echo "<script language=javascript>
    //         alert('SÓ É POSSÍVEL FAZER UPLOAD DE ARQUIVO COM EXTENSÃO PDF!');
    //         location.href = 'recibo_pagamento';
    //         </script>";
    //     exit;
    // }

    if ($tamanho > 10000000) {
      echo "<script language=javascript>
            alert('Verifique o tamanho do seu arquivo, ele excede o máximo de 10MB!');
            location.href = 'recibo_pagamento';
            </script>";
      exit;
    }

    //renomear o nome da imagem
    $novo_nomepdf = $raiz_cnpj . '.' . $ext;
    //$novo_nomepdf= 'teste'.'.'.$extensao;

    //Comando para mover o arquivo para a pasta
    $mover = move_uploaded_file($temp, 'uploads/' . $novo_nomepdf);

    //envia variavel para proxima pagina
    $_SESSION['nomepdf'] = $nomepdf;

    echo "<script language=javascript>
setTimeout(direcionar, 6000);
function direcionar(){
            location.href = 'layout/$layout';
          }</script>";
  } else {
    // echo "IF se o diretorio $diretorio não existe";

    // $extensao = 'pdf';

    // if (($ext != 'PDF') and ($ext != 'pdf')) {
    //     echo "<script language=javascript>
    //         alert('SÓ É POSSÍVEL FAZER UPLOAD DE ARQUIVO COM EXTENSÃO PDF!');
    //         location.href = 'recibo_pagamento';
    //         </script>";
    //     exit;
    // }
    if ($tamanho > 10000000) {
      echo "<script language=javascript>
            alert('Verifique o tamanho do seu arquivo, ele excede o máximo de 10MB!');
            location.href = 'recibo_pagamento';
            </script>";
      exit;
    }

    //renomear o nome da imagem
    $novo_nomepdf = $raiz_cnpj . '.' . $ext;
    //$novo_nomepdf= 'teste'.'.'.$extensao;

    //Comando para mover o arquivo para a pasta
    $mover = move_uploaded_file($temp, 'uploads/' . $novo_nomepdf);

    echo "<script language=javascript>
setTimeout(direcionar, 6000);
function direcionar(){
  location.href = 'layout/$layout';
          }</script>";
  }
} else {

  echo "<script language=javascript>
            location.href = 'erro/erro_2';
            </script>";
}

?>