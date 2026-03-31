<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";
require_once __DIR__.'/../../config/app.php';

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
      // Azure Computer Vision — enviar PDF como binary (application/octet-stream)

      $azure_endpoint = getenv('AZURE_VISION_ENDPOINT') ?: 'https://testegestou.cognitiveservices.azure.com';
      $azure_key = getenv('AZURE_VISION_KEY');
      $pdfContent = file_get_contents($location);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $azure_endpoint . '/vision/v3.2/read/analyze?model-version=latest',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 5000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HEADER => true,
        CURLOPT_POSTFIELDS => $pdfContent,
        CURLOPT_HTTPHEADER => array(
          'Ocp-Apim-Subscription-Key: ' . $azure_key,
          'Content-Type: application/octet-stream'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      sleep(10);

      $p_inicio_key = strpos($response, 'apim-request-id:');
      $p_final_key = strpos($response, 'Strict-Transport-Security:');
      $key = trim(substr($response, $p_inicio_key + 16, ($p_final_key - $p_inicio_key) - 16));

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $azure_endpoint . '/vision/v3.2/read/analyzeResults/' . $key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 13000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Ocp-Apim-Subscription-Key: ' . $azure_key
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      // echo 'RESPOSTA 2 =' . $response;

      $_SESSION["text_vis"] = $response;

      echo 1;

      //-----------------------------------------------------------------------------------------------------

    } else {
      echo 0;
    }
  }
}
