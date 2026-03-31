<?php

require_once 'restrito.php';
require_once 'iuds_pdo.php';
require_once __DIR__.'/../config/app.php';
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

      $nome_url = '{"url":"' . $app_url . '/admin/uploads/' . $filename . '"}';

      // echo "NOME_URL: " . $nome_url;

      //-----------------------------------------------------------------------------------------------------

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://computer-vision-gestou.cognitiveservices.azure.com/vision/v3.2/read/analyze?model-version=latest',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 5000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HEADER => true, //incluir cabeçalhos na saida
        // CURLOPT_POSTFIELDS => '{"url":"<?= $app_url ?>/admin/uploads/HOLERITE_EMPRESA_TESTE.pdf"}',
        // CURLOPT_POSTFIELDS => '{"url":"<?= $app_url ?>/admin/uploads/' . $filename . '"}',
        CURLOPT_POSTFIELDS => $nome_url,
        CURLOPT_HTTPHEADER => array(
          'Ocp-Apim-Subscription-Key: 1e62c619e8d24934aca329709a979b60',
          'Host: computer-vision-gestou.cognitiveservices.azure.com',
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      //echo  'RESPOSTA 1 ='.$response.'<br>';

      sleep(10);

      $p_inicio_key = strpos($response, 'apim-request-id:');
      $p_final_key = strpos($response, 'Strict-Transport-Security:');
      $key = trim(substr($response, $p_inicio_key + 16, ($p_final_key - $p_inicio_key) - 16));
      //--------------------------------------------------------------------------------------------------------------------------------
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://computer-vision-gestou.cognitiveservices.azure.com/vision/v3.2/read/analyzeResults/' . $key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 13000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Host: computer-vision-gestou.cognitiveservices.azure.com',
          'Ocp-Apim-Subscription-Key: 1e62c619e8d24934aca329709a979b60'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo 'RESPOSTA 2 =' . $response;

      $_SESSION["text_vis"] = $response;

      //-----------------------------------------------------------------------------------------------------

    } else {
      echo 0;
    }
  }
}
