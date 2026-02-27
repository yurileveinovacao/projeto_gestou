<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";
require_once __DIR__.'/../../config/app.php';
require_once __DIR__.'/../../config/ocr.php';

if ((isset($_POST["btn_submit"])) and (isset($_FILES))) {

  $nomepdf = $_FILES['file']['name'];
  $_SESSION["nomepdf"] = $nomepdf;

  /* Getting file name */
  $filename = $raiz_cnpj . ".pdf";

  /* Location */
  $location = "../uploads/" . $filename;
  $uploadOk = 1;

  if ($uploadOk == 0) {
    echo 0;
  } else {
    /* Upload file */
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
      // echo $location;

      //-----------------------------------------------------------------------------------------------------
      // Google Cloud Vision OCR (replaces Azure Computer Vision)
      $response = googleVisionOCR($location);

      $_SESSION["text_vis"] = $response;

      echo 1;

      //-----------------------------------------------------------------------------------------------------

    } else {
      echo 0;
    }
  }
}
