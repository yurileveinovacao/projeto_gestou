<?php 

require "../iuds_pdo.php";
require "../util.php";

foreach(selectCOUNT_VW_ANIVERSARIOS() as $contagem){

    $contagem = $contagem["contagem"];

}

if($contagem > 0 ){

    foreach(select_VW_ANIVERSARIOS() as $info_email){

        $id_usu_email = $info_email["id_usu"];
        $nome_email = $info_email["nome"];
        $funcao_email = $info_email["funcao"];
        $imagem_empresa_email = $info_email["imagem_empresa"];
        $imagem_funcionario_email = $info_email["imagem_funcionario"];
        $email_funcionario = $info_email["email"];

        require "email_aniversario.php";

        updateDATA_ENVIO_ANIVERSARIO($id_usu_email);

    }

}else{
    
}
