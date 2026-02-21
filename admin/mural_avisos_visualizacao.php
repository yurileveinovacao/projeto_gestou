<?php

require_once 'restrito.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

if (isset($_POST["id_recebido"])) {

    $id_recebido = $_POST["id_recebido"];

    foreach (selectGESMUR_id_mur($id_recebido) as $gesmur) {

        $mensagem = $gesmur["mensagem"];
    }

    $retorno = '';

    // $retorno .= '<div class="row">';
    // $retorno .= '<div class="col-md-12">';

    $retorno .= '<span>' . $mensagem . '</span>';

    // $retorno .= '</div>';
    // $retorno .= '</div>';

    //retorno da função
    echo $retorno;
}
