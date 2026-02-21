<?php 

require "../iuds_pdo.php";

foreach(VW_ANIVERSARIOS_ENVIAR_PROX_7_DIAS() as $proximo){

    $total = $proximo["total"];

}

echo $total;


?>