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
//  CLICK NO CARD PARA VISUALIZAR AVISOS
if (isset($_POST['btn_visu'])) {

    try {

        // Obtém os valores enviados por POST
        $id_mur = $_POST['id_mur'];
        $visu = $_POST['visu'];

        // Atribui o valor de $id_mur à variável de sessão 'id_mur_mural'
        $_SESSION["id_mur_mural"] = $id_mur;

        // Verifica se $visu é igual a 0
        if ($visu == 0) {

            // Chama a função updateGESMUU_visualizado(), que define situac_usu_visualizar = 1, passando $id_usu_default e $id_mur como argumentos
            updateGESMUU_visualizado($id_usu_default, $id_mur);
        }
    } catch (PDOException $erro) {

        // Em caso de erro, exibe a mensagem de erro
        echo $erro->getMessage();
    }
}
