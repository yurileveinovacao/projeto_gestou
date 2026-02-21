<?php
    require_once 'iuds_pdo.php';
    echo '<h2><center>TESTE GESSOB</center></h2>' . "<br>" ;

    echo '<br><br>';
    /*
        foreach (selectGESSOB_count(3) as $resultados) {
            echo $resultados['registros'];
            if ($res == 0){
                echo "nada";
            }else{
                echo "tem";
            }
        }
    */
    //foreach (selectGESSOB_count(3) as $resultados) {

    //}

    $var = selectGESSOB_count(3);


if($var == 0){
    echo 'zero';
}else{
    echo 'tem alguma coisa';
}

    
?>