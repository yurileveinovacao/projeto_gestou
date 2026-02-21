<?php

require_once "vendor_gvc/vendor/autoload.php"; // Autoload files using Composer autoload

use GvcPdf2Pdf\PdfTextApply;

$jsonFile = "vendor_gvc/src/01-in-google-vision-cloud.json";
$pdfSourceFile = "vendor_gvc/src/dpcuca.pdf";

$pdfOutFile1 = "vendor_gvc/src/cuca2.pdf";
$pdf = new PdfTextApply($jsonFile, $pdfSourceFile, $pdfOutFile1);
$pdf->watermark->text = '';
$pdf->run();

// $pdfOutFile2 = __DIR__ .'/01-out-pdf-with-text-visible-for-debug.pdf';
// $pdf = new PdfTextApply($jsonFile, $pdfSourceFile, $pdfOutFile2);
// $pdf->showText()->run();
