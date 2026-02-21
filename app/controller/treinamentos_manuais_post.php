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

        $id_tre = $_POST['id_tre'];
        $visu = $_POST['visu'];

        $_SESSION['id_tre_item'] = $id_tre;

        if ($visu == 0) {

            updateGESTRU_visualizado($id_usu_default, $id_tre);
        }

        // Retorno de Sucesso
        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}