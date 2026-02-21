<?php

//Faz a requisição da Sessão
require 'restrito.php';

if (isset($_SESSION['alterar_empresa']['nav_tab'])) {

    echo json_encode(1);

    unset($_SESSION['alterar_empresa']['nav_tab']);
} else {

    echo json_encode(0);
}