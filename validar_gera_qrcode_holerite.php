<?php

require_once "validar_restrito.php";

require_once 'app/vendor_qrcode/autoload.php';

use chillerlan\QRCode\QRCode;

$id_validador_holerite = $_SESSION["download_id_validador"];

$data = 'https://www.gestou.com.br/novo/validar?hl='.$id_validador_holerite.''; //inserindo a URL do iMasters

echo '<img src="'.(new QRCode)->render($data).'" height="80px" style="margin: auto"/>'; //gerando o QRCode em uma tag img

?>