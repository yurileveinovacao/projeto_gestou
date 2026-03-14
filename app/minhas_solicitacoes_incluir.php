<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

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

    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous"> -->

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputsolicitacao.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once 'menu_superior.php'; ?>

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita mb-1 user-select-none">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Incluir Solicitação</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                        <div class="card shadow mb-2 width-100">
                            <!-- HEADER TOTAL PROVENTOS -->
                            <div class="d-block card-header py-3 collapsed">
                                <form id="form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <!-- TIPO SOLICITAÇÃO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA SOLICITAÇÃO</label>
                                                <select id="tipo" name="tipo" class="form-control" required>
                                                    <option value="" disabled selected>Escolha uma opção</option>

                                                    <?php $tabela = "'GESSOL'";

                                                    foreach (select_GESTSO($tabela) as $tipo_solic) {

                                                        echo '<option value="' . $tipo_solic['id_tso'] . '">' . $tipo_solic['descri'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- MENSAGEM -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                                                <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" minlength="3" required></textarea>
                                            </div>
                                        </div>

                                        <!-- ANEXO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="file">Anexo</label>
                                                <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".png,.jpg,.jpeg,.pdf">
                                            </div>
                                        </div>

                                        <!-- ENVIAR -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-brave btn-icon-split-brave width-100 mt-sm-3">
                                                    <span class="font-weight-bold">ENVIAR</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- CANCELAR -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <button type="button" class="btn btn-brave-border btn-icon-split-brave width-100 btn-voltar">
                                                    <span class="font-weight-bold">CANCELAR</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM CONTAINER FLUID-->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once 'footer.php'; ?>

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<!-- AÇÕES NO CLICK -->
<script>
    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {

            location.href = 'minhas_solicitacoes';
        });
    });

    // SUBMIT
    $(function() {
        $('#form').submit(function(e) {

            // impede o envio do formulário por padrão
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja realizar essa solicitação?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, aprovar!',
                cancelButtonText: 'Não!'
            }).then((result) => {

                if (result.isConfirmed) {

                    var btn_submit = 1;

                    if (btn_submit !== '') {

                        var formData = new FormData(this);
                        formData.append('btn_submit', btn_submit);

                        $.post({
                            url: 'controller/minhas_solicitacoes_incluir_post.php',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(retorno) {

                                switch (retorno) {

                                    // Se retorno igual 0, dados não foram preenchidos corretamente
                                    case '0':
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Atenção!',
                                            text: 'Preencha todos os campos para concluir a ação!',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                swal.close();
                                            }
                                        });
                                        break;

                                        // Se retorno igual 1, solicitação enviada com sucesso
                                    case '1':
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            text: 'Solicitação realizada!',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.href = 'minhas_solicitacoes';
                                            }
                                        });
                                        break;

                                        // Se retorno igual 2, anexo maior que o limite permitido (10MB)
                                    case '2':
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Atenção!',
                                            text: 'O arquivo anexado é maior que o limite de 10MB!',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                swal.close();
                                            }
                                        });
                                        break;

                                        // Erro no try
                                    default:
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Favor entrar em contato com o suporte.',
                                            html: retorno,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                        break;
                                }
                            }
                        });
                    }
                }

            });
        });
    });
</script>

<?php
/*
//INCLUIR SOLICITAÇÃO
try {
    // AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['btn-submit'])) {

        $tipo_solicitacao = $_POST["tipo"];
        $mensagem_solicitacao = $_POST["mensagem"];

        $nomeimg = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $tamanho = $_FILES['file']['size'];
        $tipoimg = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];

        $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);
        $ext = strtolower($ext);

        if (!empty($tamanho)) {

            if ($tamanho > 100000000) {
                echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                title: 'Atenção!',
                text: 'O arquivo anexado é maior que o limite de 10MB !'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='minhas_solicitacoes_incluir';
                }
              });
        </script>";
                exit;
            }



            //renomear o nome da imagem
            $anexo = $raiz_cnpj . '_' . time() . '.' . $ext;

            //Comando para mover o arquivo para a pasta
            $mover = move_uploaded_file($temp, '../upload/mensagens/solicitacoes/' . $anexo);
        }

        foreach (select_GESEMP_valges($id_usu_default) as $verificacao) {
            $valges = $verificacao["validacao"];
        }

        $mensagem_solicitacao = mb_strtoupper($mensagem_solicitacao);

        $situac = $valges;

        // echo $anexo;

        insert_GESSOL($tipo_solicitacao, $mensagem_solicitacao, $anexo, $situac, $datinc, $id_usu_default, $datatu, NULL, $id_emp_default);

        foreach (select_SOLICITACOES_EMAIL($id_usu_default) as $solicitacao) {
            $nome_email = $solicitacao["nome_envio"];
            $email_email = $solicitacao["email_envio"];
            $nome_usuario = $solicitacao["usuario_envio"];

            require "email_minhas_solicitacoes.php";
        }

        echo "<script language=javascript>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            title: 'Sucesso!',
            text: 'Solicitação realizada!'
        }).then((result) => {
            if (result.isConfirmed) {
              location.href='minhas_solicitacoes';
            }
          });
        	</script>";
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}
*/
?>