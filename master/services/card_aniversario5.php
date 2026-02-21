<?php 

require "../iuds_pdo.php";

foreach(VW_ANIVERSARIOS_ENVIAR_PROX_90_DIAS() as $proximo){

    $total = $proximo["total"];

}

echo $total;


?>