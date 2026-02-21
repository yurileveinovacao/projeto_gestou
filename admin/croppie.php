<?php

require_once "util.php";
require_once "iuds_pdo.php";

$image = $_POST['image'];

list($type, $image) = explode(';', $image);
list(, $image) = explode(',', $image);

$image = base64_decode($image);
$image_name = '' . $raiz_cnpj . '_' . time() . '.png';
file_put_contents('../upload/cadastro/' . $image_name, $image);

// echo 'successfully uploaded';

$id_usu = $_SESSION["id_fun"];

foreach (selectGESUSU_FOTO($id_usu) as $foto_banco) {

    $imagem = $foto_banco["imagem"];

    if ($imagem != NULL) {
        unlink('../upload/cadastro/' . $imagem . '');
    }

    updateGESUSU_FOTO($image_name, $id_usu, $datatu, $id_usa_default);
}
