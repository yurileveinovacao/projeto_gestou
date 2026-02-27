<?php

require_once 'restrito.php';

require_once __DIR__."/../config/session.php"; session_start();

if ($_SESSION['id_usa'] == 1 || $_SESSION['id_usa'] == 34 || $_SESSION['id_usa'] == 50) {

    foreach ($_SESSION as $key => $value) {

        var_dump([$key => $value]);
        echo '<br>';
    }
}