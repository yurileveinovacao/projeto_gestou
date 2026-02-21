<?php

require_once "util.php";
require_once "iuds_app.php";

// $id_emp_default = $_SESSION['id_emp_default_app'];
// $id_usu_default = $_SESSION['id_usu_app'];

foreach (selectGESUSU_FOTO_APROVACO($id_usu_default) as $imagem_banco) {

    $imagem_aprovacao = $imagem_banco["imagem_aprovacao"];

    if (!empty($imagem_aprovacao)) {
        unlink('../upload/cadastro/aprovacao/' . $imagem_aprovacao . '');
    }
}

$image = $_POST['image'];

list($type, $image) = explode(';', $image);
list(, $image) = explode(',', $image);

$image = base64_decode($image);
$image_name = '' . $raiz_cnpj . '_' . time() . '.png';
file_put_contents('../upload/cadastro/aprovacao/' . $image_name, $image);

updateGESUSU_FOTO_APROVACAO($image_name, $id_usu_default, $datatu, $id_usa_default);

foreach (select_EMAIL_RH_APROVAR_FOTO($id_emp_default, $id_usu_default) as $linha) {

    $nome_rh = $linha["nome_rh"];
    $email_rh = $linha["email_rh"];
    $nome_colaborador = $linha["nome_colaborador"];

    require "email_aprovacao_foto.php";
}
