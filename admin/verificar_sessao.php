<?php

//Faz a requisição da Sessão
require 'restrito.php';

if (!empty($_SESSION['tab'])) {

    echo json_encode(1);

    unset($_SESSION['tab']);
} else {

    echo json_encode(0);
}