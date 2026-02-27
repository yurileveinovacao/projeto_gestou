<?php
    require_once '../admin/iuds_pdo.php';
    echo '<h2><center>Documentação do Gestou</center></h2>' . '<br>' ;
        echo '<form action="pesquisar.php" method="POST">';
            echo '<label for="fname">Pesquisar:</label> &nbsp;';
            echo '<input type="text" id="fpesquisa" name="fpesquisa" size=40 placeholder="Digite algo para pesquisar"> &nbsp;';
            echo '<input type="submit" value="Procurar">';
        echo '</form>';
    echo '<br><br>';
    echo '<ul>';
        foreach (selectGESDOC() as $resultados) {
            echo '<a href="/doc/pagina.php?id_doc='. $resultados['id_doc'].'">'. '<li>' . $resultados['grupo'] . ' - '. $resultados['titulo'] . '</li>' . '<br>' .'</a>';
        }
    echo '</ul>';
?>
