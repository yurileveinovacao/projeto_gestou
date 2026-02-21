<?php
    
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_con = htmlspecialchars($_POST['id_con']);
    $display1  = htmlspecialchars($_POST['display1']);
    $display2  = htmlspecialchars($_POST['display2']);
    $id_emp_default = $_SESSION['id_emp_default'];

    //echo $id_con;
    //echo $display1;
    //echo $display2;

    updateGESCON($display1,$display2,$id_con);
    header("location: minha_conta.php");
    
?>