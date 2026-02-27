<?php

require_once 'restrito.php';
require_once 'iuds_pdo.php';
require_once __DIR__.'/../config/app.php';
require_once __DIR__.'/../config/ocr.php';
require_once 'util.php';

if ((isset($_POST["descricao"])) or (isset($_FILES)) or (isset($_POST["periodo"]))) {

  $_SESSION["descricao"] = $_POST["descricao"];
  $_SESSION["periodo"] = $_POST["periodo"];

  $nomepdf = $_FILES['file']['name'];
  $_SESSION["nomepdf"] = $nomepdf;

  /* Getting file name */
  $filename = $raiz_cnpj . ".pdf";

  /* Location */
  $location = "uploads/" . $filename;
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
      echo 'RESPOSTA 2 =' . $response;

      $_SESSION["text_vis"] = $response;

      //-----------------------------------------------------------------------------------------------------

    } else {
      echo 0;
    }
  }
}
