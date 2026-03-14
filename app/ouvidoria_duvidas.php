<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - APP</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once 'menu_lateral.php';

        ?>
        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <!-- MENU SUPERIOR -->
                <?php

                include_once 'menu_superior.php'; ?>
                <!-- FIM MENU SUPERIOR -->

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita mb-1 user-select-none">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4"><a href="ouvidoria"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                            <li class="breadcrumb-item active h4" aria-current="page">Dúvidas Ouvidoria</li>
                        </ol>

                    </div>
                    <!-- FIM DIV ICONE VOLTAR -->

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                        <div class="card shadow mb-2 width-100">
                            <!-- HEADER TOTAL PROVENTOS -->
                            <div class="d-block card-header py-3 mt-3 collapsed">

                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Sobre a Ouvidoria Interna
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <p class="text-justify">Por meio do canal de denúncias independente, disponibilizado para o colaborador, podem ser relatados casos de violação ao Código de Conduta, às leis ou regimentos internos. O canal possibilita contato anônimo, totalmente seguro e com número de protocolo para acompanhamento do status. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    O que é Ouvidoria Interna?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                <p class="text-justify">A Ouvidoria Interna é um canal de participação, com visão diretamente no foco do problema para facilitar e encontrar soluções para as mais diversas situações dentro da empresa. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Papel da Ouvidoria Interna
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                            <div class="panel-body">
                                                <p class="text-justify">O principal papel da Ouvidoria Interna é o de integração. Através dela, as informações decorrentes de reclamações e sugestões se tornam importantes dados para melhorar o rendimento dos colaboradores por meio de estratégias traçadas em cima de todo o feedback recolhido.
                                                    O ouvidor pode ser comparado a um termômetro dentro da empresa, alertando sempre aos gestores tudo o que acontece dentro do ambiente de trabalho como forma de sempre manter a organização, transparência e bom ambiente. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading4">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                    Posso pedir sigilo?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                            <div class="panel-body">
                                                <p class="text-justify">Sim. O manifestante pode marcar a opção “Desejo manter meus dados pessoais em sigilo”. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM DIV CONTAINER FLUID -->

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- FIM FOOTER -->

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<?php

//INCLUIR SOLICITAÇÃO
try {
    // AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['btn-submit'])) {

        $tipo_solicitacao = $_POST["tipo"];
        $mensagem_solicitacao = $_POST["mensagem"];

        foreach (select_GESEMP_valges($id_usu_default) as $verificacao) {
            $valges = $verificacao["validacao"];
        }

        $mensagem_solicitacao = mb_strtoupper($mensagem_solicitacao);

        $situac = $valges;

        insert_GESSOL($tipo_solicitacao, $mensagem_solicitacao, $situac, $datinc, $id_usu_default, $datatu, NULL, $id_emp_default);

        foreach (select_SOLICITACOES_EMAIL($id_usu_default) as $solicitacao) {
            $nome_email = $solicitacao["nome_envio"];
            $email_email = $solicitacao["email_envio"];
            $nome_usuario = $solicitacao["usuario_envio"];

            require "email_minhas_solicitacoes.php";
        }

        echo "<script language=javascript>
        	alert('Solicitação realizada!');
        	location.href = 'minhas_solicitacoes';
        	</script>";
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

?>