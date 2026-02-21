<?php 

require "../iuds_pdo.php";

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
//ATRIBUINDO A DATA
$datinc = date('Y-m-d H:i:s');
$datatu = date('H:i:s');

echo $datatu;

?>