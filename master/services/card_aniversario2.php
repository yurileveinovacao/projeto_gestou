<?php 

require "../iuds_pdo.php";

foreach(selectTOTAL_ENVIADOS_ULTIMOS_90_DIAS() as $proximo){

    $total = $proximo["total"];

}

echo $total;


?>