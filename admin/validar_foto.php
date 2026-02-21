<?php
if ((isset($_POST["id_usu_foto"])) and (isset($_POST["situacao"]))) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_usu_foto = $_POST["id_usu_foto"];
    $situacao = $_POST["situacao"];
    $id_emp_default = $_SESSION['id_emp_default'];

    if ($situacao == 1) {

        $situacao = "APROVADA";

        foreach (selectGESUSU_FOTO_APROVACAO($id_usu_foto) as $imagem_banco) {

            $imagem_aprovacao = $imagem_banco["imagem_aprovacao"];
        }

        $origem = '../upload/cadastro/aprovacao/' . $imagem_aprovacao . '';
        $destino = '../upload/cadastro/' . $imagem_aprovacao . '';

        if (copy($origem, $destino)) {

            echo "Arquivo copiado com Sucesso.";
            unlink('../upload/cadastro/aprovacao/' . $imagem_aprovacao . '');
            updateGESUSU_FOTO_APROV($imagem_aprovacao, $id_usu_foto, $datatu, $id_usa_default);

            foreach (select_EMAIL_COLABORADOR($id_usu_foto) as $email) {

                $nome_colaborador = $email["nome"];
                $email_colaborador = $email["email"];

                require "email_aprovacao_foto.php";
            }
        } else {

            echo "Erro ao copiar arquivo.";
        }
    } elseif ($situacao == 0) {

        $situacao = "REPROVADA";

        foreach (selectGESUSU_FOTO_APROVACAO($id_usu_foto) as $imagem_banco) {

            $imagem_aprovacao = $imagem_banco["imagem_aprovacao"];
        }

        unlink('../upload/cadastro/aprovacao/' . $imagem_aprovacao . '');
        updateGESUSU_FOTO_REPROV($id_usu_foto, $datatu, $id_usa_default);

        foreach (select_EMAIL_COLABORADOR($id_usu_foto) as $email) {

            $nome_colaborador = $email["nome"];
            $email_colaborador = $email["email"];

            require "email_aprovacao_foto.php";
        }
    }
}
