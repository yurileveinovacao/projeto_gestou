<?php

include_once "validar_login.php";

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
//ATRIBUINDO A DATA
$datatu = date('Y-m-d H:i:s');
$datinc = date('Y-m-d H:i:s');

$ip = $_SERVER["REMOTE_ADDR"];

// echo "<br>id_usu:".var_dump($id_usu);

        // echo var_dump($id_usu)."id_usu:".$id_usu."<br>";
        // echo var_dump($id_emp)."id_emp:".$id_emp."<br>";
        // echo var_dump($ip)."ip:".$ip."<br>";
        // echo var_dump($datatu)."datatu:".$datatu."<br>";


foreach(select_GESACE_acesso($id_usu, $id_emp, $ip) as $acesso){

    if($acesso == 0){

        insert_GESACE($id_usu, $id_emp, $ip, $datinc, $datatu);

    }else{

        update_GESACE($id_usu, $id_emp, $ip, $datatu);

    }

}

?>