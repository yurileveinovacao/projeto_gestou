<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_app.php";

require_once '../util.php';

require '../restrito.php';

/**
 * 
 * Funções no Click
 * 
 */
// CLICK NO CARD
if (isset($_POST['btn_visu'])) {

    try {

        $id_not = $_POST['id_not'];
        $visu = $_POST['visu'];

        $_SESSION['id_not_item'] = $id_not;

        if ($visu == 0) {

            updateGESNOT_visualizado($id_not);
        }

        // Retorno de Sucesso
        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}