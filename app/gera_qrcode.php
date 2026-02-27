<?php

require_once 'vendor_qrcode/autoload.php';
require_once __DIR__.'/../config/app.php';

use chillerlan\QRCode\QRCode;

$data = $app_url . '/app/recibo_item?vw=61d2e41393ab320ef2c4f7dbff'; //inserindo a URL do iMasters

echo '<img src="'.(new QRCode)->render($data).'" style="margin: auto"/>'; //gerando o QRCode em uma tag img

?>