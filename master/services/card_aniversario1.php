<?php 

require "../iuds_pdo.php";

foreach(TOTAL_ENVIADOS_ULTIMOS_7_DIAS() as $proximo){

    $total = $proximo["total"];

}

echo $total;


?>