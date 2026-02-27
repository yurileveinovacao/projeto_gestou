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
                            <li class="breadcrumb-item active h4" aria-current="page">Incluir Manifestação</li>
                        </ol>

                    </div>
                    <!-- FIM DIV ICONE VOLTAR -->

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                        <div class="card shadow mb-2 width-100">
                            <!-- HEADER TOTAL PROVENTOS -->
                            <div class="d-block card-header py-3 collapsed">
                                <form action="ouvidoria_incluir" method="POST" id="formName">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA MANIFESTAÇÃO</label>
                                                <select id="tipo" name="tipo" class="form-control" required>
                                                    <option value="" disabled selected>Escolha uma opção</option>
                                                    <?php

                                                    $tabela = "'GESOUV'";

                                                    foreach (select_GESTSO($tabela) as $tipo_solic) {

                                                        echo '<option value="' . $tipo_solic['id_tso'] . '">' . $tipo_solic['descri'] . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="manifestacao" class="mt-sm-3 mb-2 font-weight-bold">MANIFESTAÇÃO</label>
                                                <textarea class="form-control" id="manifestacao" name="manifestacao" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6 custom-control custom-radio" style="padding-left: 1.8rem;">
                                                <input type="radio" class="custom-control-input" name="radio" value="0" id="customControlAutosizing" checked>
                                                <label class="custom-control-label" for="customControlAutosizing">
                                                    Desejo me identificar.
                                                </label>
                                            </div>
                                            <div class="form-group col-md-6 custom-control custom-radio" style="padding-left: 1.8rem;">
                                                <input type="radio" class="custom-control-input" name="radio" value="1" id="customControlAutosizing2">
                                                <label class="custom-control-label" for="customControlAutosizing2">
                                                    Desejo manter meus dados pessoais em sigilo.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <!-- <button type="submit" name="btn-submit" onclick="return confirm('Tem certeza que deseja realizar essa mensagem?'); return false;" class="btn btn-brave btn-icon-split-brave width-100 mt-sm-3"><span class="font-weight-bold">ENVIAR</span></button> -->
                                                <button type="button" id="botao" data-toggle="modal" data-target="#Enviar" name="modal" class="btn btn-brave btn-icon-split-brave width-100 mt-sm-3"><span class="font-weight-bold">ENVIAR</span></button>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <a href="ouvidoria"><button type="button" name="btn-voltar" class="btn btn-brave-border btn-icon-split-brave width-100"><span class="font-weight-bold">CANCELAR</span></button></a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL Enviar -->
                                    <div class="modal fade" id="Enviar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Enviar" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document" style="width: auto;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="Enviar">Ao submeter esta solicitação, confirmo:</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12">

                                                        <p>• Serem verdadeiras as informações fornecidas e que sou a pessoa natural titular dos dados informados acima.</p>

                                                        <p>• Aceitar que a empresa avalie esta solicitação e a atenda de acordo com os requisitos legais vigentes e normativos internos.</p>

                                                        <p>• Permitir o tratamento e armazenamento destas informações para atendimento desta solicitação.</p>

                                                        <p>• Estar ciente de como meus dados pessoais serão tratados durante a tramitação da minha demanda.</p>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="btn-submit" class="btn btn-brave btn-icon-split-brave width-100"><span class="font-weight-bold">CONFIRMAR ENVIO</span></button>
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
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
</body>

</html>

<script>
    $(function () {
    var $inputs = $("input, textarea, select", "#formName"),
        $button = $("#botao");

    var limpos = 0;

    // verificação inicial
    $inputs.each(function () {
        var $this = $(this);
        var val = $this.val();
        val || limpos++;
        $this.data("val-antigo", val);
    });

    $button.prop("disabled", !!limpos);

    $inputs.on("change keyup mouseup", function () {
        var $this = $(this);
        var val = $this.val();
        limpos += (val ? 0 : 1) - ($this.data("val-antigo") ? 0 : 1);
        $this.data("val-antigo", val);
        $button.prop("disabled", !!limpos);
    });
});
</script>

<?php

//INCLUIR SOLICITAÇÃO
try {
    // AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['btn-submit'])) {

        $tipo_ouvidoria = $_POST["tipo"];
        $manifestacao_ouvidoria = $_POST["manifestacao"];
        $anonimo = $_POST["radio"];
        $manifestacao_ouvidoria = mb_strtoupper($manifestacao_ouvidoria);

        if ($anonimo == 1) {

            $id_ouv = insert_GESOUV_anonimo($tipo_ouvidoria, $manifestacao_ouvidoria, $datinc, $id_usu_default, $datatu, $id_emp_default);
        } else {
            $id_ouv = insert_GESOUV($tipo_ouvidoria, $manifestacao_ouvidoria, $datinc, $id_usu_default, $datatu, $id_emp_default);
        }

        $id_ouv_insert = $id_ouv["pk"];

        foreach (select_OUVIDORIA_EMAIL($id_ouv_insert) as $ouvidoria) {
            $nome_email = $ouvidoria["nome_envio"];
            $email_email = $ouvidoria["email_envio"];

            require "email_ouvidoria.php";
        }

        echo "<script language=javascript>
        	alert('Manifestação incluída com sucesso!');
        	location.href = 'ouvidoria';
        	</script>";
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

?>