<?php

require_once '../admin/iuds_pdo.php';
echo '<h2><center>Documentação do Gestou</center></h2>' . '<br>' ;
if (isset($_POST['fpesquisa'])) {
    $tmpPesquisa = $_POST['fpesquisa'];
    echo 'Valor pesquisado: ' . $tmpPesquisa;
    echo '<br>';    
    echo '<ul>';
    foreach (selectGESDOC_conteudo(strtoupper($tmpPesquisa)) as $resultados) {
        if (!empty($resultados)) {
            //echo 'Array preenchido !!!! <br>';
            echo '<a href="/doc/pagina.php?id_doc='. $resultados['id_doc'].'">'. '<li>' . $resultados['grupo'] . ' - '. $resultados['titulo'] . '</li>' . '<br>' .'</a>';
        }else{
            echo 'Array vazio !!!! <br>';
        }
    }    
} else {
    $tmpPesquisa = null;
}

echo '</ul>';






?>