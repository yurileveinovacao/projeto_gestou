<?php
if (isset($_POST["id_mpr"]) and isset($_POST["situac"])) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_mpr = $_POST["id_mpr"];
    $situac = $_POST["situac"];
    $id_emp_default = $_SESSION['id_emp_default'];

    updateGESMPR($situac, $id_mpr);

}
