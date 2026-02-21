<?php

require_once 'vendor_qrcode/autoload.php';

use chillerlan\QRCode\QRCode;

$id_validador_holerite = $_SESSION["id_validador_holerite"];

$data = 'https://www.gestou.com.br/validar?hl='.$id_validador_holerite.''; //inserindo a URL do iMasters

echo '<img src="'.(new QRCode)->render($data).'" style="margin: auto"/>'; //gerando o QRCode em uma tag img

?>