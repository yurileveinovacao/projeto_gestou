<?php

require_once '../admin/iuds_pdo.php';

echo '<h2><center>Documentação do Gestou</center></h2>' . '<br>';

if (isset($_GET['id_doc'])) {
    $tmpId_doc = $_GET['id_doc'];
} else {
    $tmpId_doc = null;
}

foreach (selectGESDOCid_doc($tmpId_doc) as $resultados) {
    echo '<h3>' . $resultados['grupo'] . ' - ' . $resultados['titulo'] . '</h3>';
    echo '<br>';
    echo $resultados['conteudo'];
}

echo '<br><br>';
echo '<a href="https://gestou.com.br/novo/doc">Voltar</a>'; 

?>
