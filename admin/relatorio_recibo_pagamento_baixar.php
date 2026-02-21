<?php

use Dompdf\Dompdf;


require "vendor_dompdf/autoload.php";

$dompdf = new Dompdf(["enable_remote" => true]);
// $dompdf->loadHtml(str: "Teste");

ob_start();
require "relatorio_recibo_pagamento.php";
$nome_arquivo = $_SESSION["id_processamento_relatorio"];
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();
// $dompdf->stream($nome_arquivo, ["Attachment" => false]);

$output = $dompdf->output();
file_put_contents("relatorios/financeiro/" . $nome_arquivo . '.pdf', $output);


?>