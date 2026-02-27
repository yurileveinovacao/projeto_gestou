<?php

session_start();

if ((!isset($_SESSION['download_id_validador'])) and (!isset($_SESSION['download_raiz_validador']))) {

    echo "<script language=javascript>
    alert('Insira um código para consultar!');
    location.href = '/validar';
    </script>";

}