<?php

require "app/iuds_app.php";

if (isset($_POST["codigo"])) {

  $id_validador = $_POST['codigo'];
  $raiz_validador = substr($id_validador, 0, 8);

  foreach (select_VERIFICA_TABELA($raiz_validador) as $resultados) {
    if ($resultados['exists']) {

      foreach (select_HOLERITE($raiz_validador, $id_validador) as $count_holerite) {

        $contagem = $count_holerite["contagem"];
      }

      foreach (selectGESIM1_arquivo($raiz_validador, $id_validador) as $arquivo_holerite) {

        $arquivo = $arquivo_holerite["arquivo"];
      }

      if ($contagem == 1) {

        if(!empty($arquivo)){

          session_start();

        $_SESSION['download_id_validador'] = $id_validador;
        $_SESSION['download_raiz_validador'] = $raiz_validador;
        $_SESSION['arquivo_validador'] = $arquivo;

        $retorno = 3;
        echo json_encode($retorno);


        }else{

        session_start();

        $_SESSION['download_id_validador'] = $id_validador;
        $_SESSION['download_raiz_validador'] = $raiz_validador;

        $retorno = 1;
        echo json_encode($retorno);

        }
      } else {

        //   echo "<script language=javascript>
        // alert('Código Inválido!');
        // location.href = 'validar?hl=" . $id_validador . "';
        // </script>";

        $retorno = 0;
        echo json_encode($retorno);
      }
    } else {

      // echo "<script language=javascript>
      // alert('Código Inválido!');
      // location.href = 'validar';
      // </script>";

      $retorno = 2;
      echo json_encode($retorno);
    }
  }
}
