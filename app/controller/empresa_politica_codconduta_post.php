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
if (isset($_POST['btn_visu'])) {

    try {
        // Obtendo os valores do formulário
        $visu = $_POST['visu'];
        $id_pol = $_POST['id_pol'];

        // Armazenando o ID em uma variável de sessão
        $_SESSION['id_pol_item'] = $id_pol;

        if (empty($visu)) {

            // Recuperando os dados usando a função select_GESPUL
            foreach (select_GESPUL($id_pol, $id_usu_default) as $linha) {

                $id_pul = $linha['id_pul'];
            }

            // Verificando se $id_pul não está vazio
            if (!empty($id_pul)) {

                // Se não estiver vazio, atualiza os dados usando a função updateGESPUL
                updateGESPUL($id_pul);
            } else {

                // Se estiver vazio, insere novos dados usando a função insertGESPUL
                insertGESPUL($id_usu_default, $id_pol, $datinc);
            }
        }

        // Exibindo uma mensagem de sucesso
        echo 1;
    } catch (PDOException $erro) {

        // Capturando qualquer exceção do tipo PDOException e exibindo a mensagem de erro
        echo $erro->getMessage();
    }
}
