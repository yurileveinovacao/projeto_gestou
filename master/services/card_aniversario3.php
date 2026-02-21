<?php 

require "../iuds_pdo.php";

foreach(VW_ANIVERSARIOS_ENVIADO_HOJE() as $proximo){

    $total = $proximo["total"];

}

echo $total;


?>