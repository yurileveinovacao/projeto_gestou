<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_cto = $_SESSION['editar_id_cto'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Alterar Contatos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <?php if (!isset($_SESSION['editar_id_cto'])) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados do contato!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'contatos_uteis';
                                }
                                });
                                </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Contatos Úteis</h6>
                        </div>

                        <!-- INICIO FORM -->
                        <form id="form" class="needs-validation" novalidate>
                            <div class="card-body">

                                <?php

                                foreach (selectGESCTO_id_cto($id_cto) as $linha) {

                                    if ($linha != 0) {

                                ?>

                                        <div class="col-md-12">
                                            <div class="form-row mb-2">
                                                <div class="col-md-12">
                                                    <label for="nome">Nome:</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" value="<?php echo $linha["nome"]; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-row mb-2">
                                                <div class="col-md-12">
                                                    <label for="descricao">Descrição:</label>
                                                    <textarea class="form-control" style="text-transform:uppercase; resize:none; max-height: 200px" id="descricao" name="descricao" minlength="3" maxlength="200" required><?php echo $linha["descricao"]; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-row mb-2">
                                                <div class="col-md-4">
                                                    <label for="telefone1">Telefone 1:</label>
                                                    <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone1" name="telefone1" attrname="<?php if (strlen($linha['telefone1']) == 11) {
                                                                                                                                                                            echo 'telefone1';
                                                                                                                                                                        } else {
                                                                                                                                                                            echo 'celular1';
                                                                                                                                                                        }  ?>" value="<?php echo $linha["telefone1"]; ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="telefone2">Telefone 2:</label>
                                                    <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone2" name="telefone2" attrname="<?php if (strlen($linha['telefone2']) == 11) {
                                                                                                                                                                            echo 'telefone2';
                                                                                                                                                                        } else {
                                                                                                                                                                            echo 'celular2';
                                                                                                                                                                        }  ?>" value="<?php echo $linha["telefone2"]; ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="telefone3">Telefone 3:</label>
                                                    <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone3" name="telefone3" attrname="<?php if (strlen($linha['telefone3']) == 11) {
                                                                                                                                                                            echo 'telefone3';
                                                                                                                                                                        } else {
                                                                                                                                                                            echo 'celular3';
                                                                                                                                                                        }  ?>" value="<?php echo $linha["telefone3"]; ?>">
                                                </div>
                                            </div>

                                            <div class="form-row mb-2">
                                                <div class="col-md-6">
                                                    <label for="email">E-mail:</label>
                                                    <input type="email" class="form-control" id="email" name="email" minlength="3" value="<?php echo $linha["email"]; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="website">Website:</label>
                                                    <input type="url" class="form-control" id="website" name="website" minlength="3" value="<?php echo $linha["website"]; ?>">
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                    }
                                }
                                ?>

                            </div>
                            <!-- FIM DIV CARD BODY -->
                            <div class="card-footer">
                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="submit" name="btn-alterar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Alterar</button>
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!-- FIM FORM -->

                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

</body>

</html>

<script>
    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // Recebe o attrname do input telefone 1 (telefone / celular)
    var telefone1Name = $('input#telefone1').attr('attrname');
    // Verifica se o attrname é telefone ou celular e define a mascara correta
    if (telefone1Name == 'telefone1') {

        var tel1Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
        var tel1 = document.querySelector('input[attrname=telefone1]');
        VMasker(tel1).maskPattern(tel1Mask[0]);
        tel1.addEventListener('input', inputHandler.bind(undefined, tel1Mask, 15), false);
    } else {

        var cel1Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
        var cel1 = document.querySelector('input[attrname=celular1]');
        VMasker(cel1).maskPattern(cel1Mask[1]);
        cel1.addEventListener('input', inputHandler.bind(undefined, cel1Mask, 15), false);
    }

    // Recebe o attrname do input telefone 2 (telefone / celular)
    var telefone2Name = $('input#telefone2').attr('attrname');
    // Verifica se o attrname é telefone ou celular e define a mascara correta
    if (telefone2Name == 'telefone2') {

        var tel2Mask = ['(999) 9999-9999', '(999) 9999-9999'];
        var tel2 = document.querySelector('input[attrname=telefone2]');
        VMasker(tel2).maskPattern(tel2Mask[0]);
        tel2.addEventListener('input', inputHandler.bind(undefined, tel2Mask, 15), false);
    } else {

        var cel2Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
        var cel2 = document.querySelector('input[attrname=celular2]');
        VMasker(cel2).maskPattern(cel2Mask[1]);
        cel2.addEventListener('input', inputHandler.bind(undefined, cel2Mask, 15), false);
    }

    // Recebe o attrname do input telefone 3 (telefone / celular)
    var telefone3Name = $('input#telefone3').attr('attrname');
    // Verifica se o attrname é telefone ou celular e define a mascara correta
    if (telefone3Name == 'telefone3') {

        var tel3Mask = ['(999) 9999-9999', '(999) 9999-9999'];
        var tel3 = document.querySelector('input[attrname=telefone3]');
        VMasker(tel3).maskPattern(tel3Mask[0]);
        tel3.addEventListener('input', inputHandler.bind(undefined, tel3Mask, 15), false);
    } else {

        var cel3Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
        var cel3 = document.querySelector('input[attrname=celular3]');
        VMasker(cel3).maskPattern(cel3Mask[1]);
        cel3.addEventListener('input', inputHandler.bind(undefined, cel3Mask, 15), false);
    }
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();



    // CLICK NO BOTÃO VOLTAR
    $(function() {
        $(document).on('click', '#btn-voltar', function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {

                dados = {

                    btn_voltar: btn_voltar
                };

                $.post('controller/alterar_contatos_uteis_post.php', dados, function(retorno) {

                    location.href = 'contatos_uteis';
                });
            }
        });
    });

    // QUANDO O FORMULÁRIO É SUBMETIDO
    $(function() {
        $("#form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            // Valor que define que o formulário foi submetido
            var btn_alterar = 1;

            // Obtém os valores do formulário
            var dados_form = {
                // Valor do formulario
                nome_update: $('#nome').val(),
                descricao_update: $('#descricao').val(),
                tel1_update: $('#telefone1').val(),
                tel2_update: $('#telefone2').val(),
                tel3_update: $('#telefone3').val(),
                email_update: $('#email').val(),
                website_update: $('#website').val(),

                // Valor que valida o envio do formulário
                btn_alterar: btn_alterar
            };

            $.post('controller/alterar_contatos_uteis_post.php', dados_form, function(retorno) {

                if (retorno == 1) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Registro alterado com sucesso!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'alterar_contatos_uteis';
                        }
                    })
                } else if (retorno == 0) {

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
                    })
                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Favor entrar em contato com o suporte.',
                        html: retorno,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    })
                }
            }).fail(function() {

                alert('Fail');
            });
        });
    });
</script>