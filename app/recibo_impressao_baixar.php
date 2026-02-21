<?php

use Dompdf\Dompdf;


require "vendor_dompdf/autoload.php";

$dompdf = new Dompdf(["enable_remote" => true]);
// $dompdf->loadHtml(str: "Teste");

ob_start();
require "recibo_impressao.php";
$nome_arquivo = $nome_arquivo_banco;
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();
$dompdf->stream($nome_arquivo, ["Attachment" => false]);


?>