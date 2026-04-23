<?php

require_once __DIR__ . '/../config/maintenance.php';
checkMaintenanceMode();

require_once __DIR__ . '/../config/session.php';
session_start();

// echo "<p style='color:black'>".$_SESSION["id_usa"]."<br>";
//                  echo $_SESSION["email"]."<br></p>";

if ((!isset($_SESSION['id_usa'])) and (!isset($_SESSION['email']))) {
    
    //header("location:acesso.php");

    echo "<script language=javascript>
    alert('Você não tem permissão para acessar essa página! Efetue o login!');
    location.href = '/admin/login';
    </script>";        
}

?>
