<?php

require_once "util.php";
require_once "iuds_pdo.php";

$image = $_POST['image'];

list($type, $image) = explode(';', $image);
list(, $image) = explode(',', $image);

$image = base64_decode($image);
$image_name = '' . $raiz_cnpj . '_' . 'logo _' . time() . '.png';
// echo 'successfully uploaded';

foreach (selectGESEMP_FOTO($id_emp_default) as $foto_banco) {

    $imagem = $foto_banco["imagem"];

    if ($imagem != NULL) {
        unlink('../upload/empresa/' . $imagem . '');
    }

    updateGESEMP_FOTO($image_name, $id_emp_default, $datatu, $id_usa_default);
}

file_put_contents('../upload/empresa/' . $image_name, $image);

