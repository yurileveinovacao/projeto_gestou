<?php 

if(isset($_POST["situac"])){

require "../iuds_pdo.php";
require "../util.php";

$situac = $_POST["situac"];

updateGESSER_aniversario($situac, $datatu);

}

?>