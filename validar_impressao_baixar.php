<?php

require "validar_restrito.php";

use Dompdf\Dompdf;


require "app/vendor_dompdf/autoload.php";

$dompdf = new Dompdf(["enable_remote" => true]);
// $dompdf->loadHtml(str: "Teste");

ob_start();
require "validar_impressao.php";
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();
$dompdf->stream("holerite.pdf", ["Attachment" => false])


?>