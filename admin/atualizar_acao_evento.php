<?php

    require_once 'restrito.php';
    require_once 'conexao.php';
    require_once 'raiz_cnpj_pdo.php';
    require_once 'iuds_pdo.php';
    require_once 'util.php';

    $id_emp_default = $_SESSION['id_emp_default'];    
    $parametros = $_POST['param'];
    $id_eve = ($parametros["id_recebido"]);
    $tipo = ($parametros["tipo"]);

    echo 'tipo ' . $tipo . '<br/>';
    echo 'id_emp_default ' . $id_emp_default . '<br/>';
    echo 'id_eve ' . $id_eve . '<br/>';
    echo 'datatu ' . $datatu . '<br/>';
    echo 'id_usa_default ' . $id_usa_default . '<br/>';
  
    try {
        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);
        echo "<script language=javascript>
        alert('Evento atualizado');
        </script>";
    
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
   
?>
