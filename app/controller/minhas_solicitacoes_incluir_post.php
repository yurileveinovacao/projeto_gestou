<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_app.php";

require_once '../util.php';

require '../restrito.php';

/**
 * 
 * Funções no Click
 * 
 */
if (isset($_POST['btn_submit'])) {

    $tipoValido = validarValor('REQUIRED', $_POST['tipo'], 1);
    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 3);

    if ($tipoValido and $mensagemValido) {

        $tipo = $_POST['tipo'];
        $mensagem_update = $_POST['mensagem'];
        $anexo_size = $_FILES['file']['size'];

        if (!empty($anexo_size)) {

            $anexo_nome = $_FILES['file']['name'];
            $anexo_temp = $_FILES['file']['tmp_name'];
            $anexo_type = $_FILES['file']['type'];
            $erro = $_FILES['file']['error'];

            $ext = formatarValor('LOWER', pathinfo($anexo_nome, PATHINFO_EXTENSION));


            if ($anexo_size > 100000000) {

                echo 2;
                exit;
            }

            //renomear o nome da imagem
            $anexo_newname = $raiz_cnpj . '_' . time() . '.' . $ext;

            //Comando para mover o arquivo para a pasta
            $mover = move_uploaded_file($anexo_temp, '../../upload/mensagens/solicitacoes/' . $anexo_newname);
        } else {

            $anexo_newname = NULL;
        }

        foreach (select_GESEMP_valges($id_usu_default) as $verificacao) {

            $situac = $verificacao["validacao"];
        }

        $mensagem = formatarValor('UPPER', $mensagem_update);


        /*
        // Exibe Variáveis
        echo 'Tipo: ' . $tipo . '<br>';
        echo 'Mensagem: ' . $mensagem . '<br>';
        echo 'Nome Anexo: ' . $anexo_newname . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'Datinc: ' . $datinc . '<br>';
        echo 'ID Usu: ' . $id_usu_default . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Emp: ' . $id_emp_default . '<br>';
        */
        
        insert_GESSOL(
            $tipo,
            $mensagem,
            $anexo_newname,
            $situac,
            $datinc,
            $id_usu_default,
            $datatu,
            NULL,
            $id_emp_default
        );
        

        foreach (select_SOLICITACOES_EMAIL($id_usu_default) as $solicitacao) {
            $nome_email = $solicitacao["nome_envio"];
            $email_email = $solicitacao["email_envio"];
            $nome_usuario = $solicitacao["usuario_envio"];

            require "../email_minhas_solicitacoes.php";
        }

        echo 1;
    } else {

        echo 0;
    }
}
