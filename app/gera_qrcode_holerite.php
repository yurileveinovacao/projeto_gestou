<?php

require_once 'vendor_qrcode/autoload.php';
require_once __DIR__.'/../config/app.php';

use chillerlan\QRCode\QRCode;

$id_validador_holerite = $_SESSION["id_validador_holerite"];

$data = $app_url . '/validar?hl='.$id_validador_holerite.''; //inserindo a URL do iMasters

echo '<img src="'.(new QRCode)->render($data).'" style="margin: auto"/>'; //gerando o QRCode em uma tag img

?>