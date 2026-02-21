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
if (isset($_POST['click_card'])) {

    try {

        $id_sol = $_POST['id_sol'];

        foreach (select_GESSOL_visualizar($id_sol) as $linha) {

            $situac_visualizar = $linha['situac_usu_visualizar'];
            $situac = $linha['situac'];
        }

        if (empty($situac_visualizar) AND ($situac == 3 OR $situac == 4)) {

            updateGESSOL_visualizar($id_sol);
        }

        $_SESSION['id_sol_item'] = $id_sol;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }

}