<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

//Atribui as variaveis locais, o valor da variaveis de sessão 
$id_mas_editar = $_SESSION['id_mas_editar'];

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

    <title>GESTOU PORTAL - Alterar Usuário Master</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

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
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputimg.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top" onload="return check_form()">

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <?php if (!isset($_SESSION['id_mas_editar'])) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados do usuário!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'usuarios_master';
                                }
                                });
                                </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Usuário Master</h6>
                        </div>
                        <div class="card-body">

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-identificacao-tab" data-toggle="tab" href="#menu-identificacao" role="tab" aria-controls="menu-identificacao" aria-selected="true">Identificação</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" novalidate id_mas="<?php echo $id_mas_editar; ?>">

                                <div class="col-md-12">

                                    <!-- INÍCIO MENU IDENTIFICAÇÃO -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade active show" id="menu-identificacao" role="tabpanel" aria-labelledby="menu-identificacao-tab">

                                            <?php

                                            foreach (selectGESMAS($id_mas_editar) as $linha) {

                                                if ($linha != 0) {

                                            ?>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" value="<?php echo $linha["nome"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido! Min. 3 caracteres!
                                                            </div>
                                                        </div>

                                                        <input type="hidden" class="situac" id="situac-<?php echo $linha['situac']; ?>">

                                                        <div class="col-md-6 mb-3">
                                                            <label for="cpf">CPF</label>
                                                            <input type="text" class="form-control" id="cpf" attrname="cpf" name="cpf" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" value="<?php echo $linha["cpf"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" value="<?php echo $linha["email"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                                    <div class="form-group">
                                                        <div class="textalign-right">
                                                            <button id="btn-troca-senha" type="button" data-toggle="modal" data-target="#TrocarSenha" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock mr-sm-2"></i> Trocar Senha</button>
                                                            <button type="submit" id="btn-submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                                            <button type="button" id="btn-voltar" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                                        </div>
                                                    </div>
                                                    <!-- FIM BOTÃO ENVIAR -->

                                            <?php

                                                }
                                            }

                                            ?>

                                        </div>
                                        <!-- FIM MENU IDENTIFICAÇÃO -->

                                    </div>
                                    <!-- FIM TAB CONTENT -->

                                </div>
                                <!-- FIM DIV CLASS COL-MD-12 -->

                            </form>
                            <!-- FIM FORM -->

                        </div>

                    </div>
                </div>

            </div>

            <!-- TROCAR SENHA Organograma Modal-->
            <div class="modal fade" id="TrocarSenha" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="TrocarSenha" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document" style="width: 400px !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="TrocarSenha">Trocar Senha</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <!-- <form action="alterar_funcionario" method="POST"> -->
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="troca-senha">Senha</label>
                                        <input type="password" id="troca-senha" name="troca-senha" class="form-control" minlength="3" required>
                                        <i class="fas fa-eye-slash lnr-eye-modal toggle-eye"></i>
                                        </input>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="confirm-senha">Confirmar Senha</label>
                                        <input type="password" id="confirm-senha" name="confirm-senha" class="form-control" minlength="3" required>
                                        <i class="fas fa-eye-slash lnr-eye1-modal toggle-eye"></i>
                                        </input>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-senha" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock"></i> Alterar</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>


</body>

</html>

<script>
    function check_form() {
        var inputs = document.getElementById("form").querySelectorAll("[required]");
        var len = inputs.length;
        var valid = true;
        for (var i = 0; i < len; i++) {
            if (!inputs[i].value) {
                valid = false;
            }
        }
        if (!valid) {
            var element = document.getElementById('btn-troca-senha');
            element.setAttribute('disabled', 'disabled');
            return false;
        } else {
            return true;
        }
    }


    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA CPF
    var cpfMask = ['999.999.999-99', '999.999.999-99'];
    var cpf = document.querySelector('input[attrname=cpf]');
    VMasker(cpf).maskPattern(cpfMask[0]);
    cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

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
                        // alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(document).ready( // QUANDO O FORMULÁRIO É SUBMETIDO
        function() {
            $("#form").submit(function(event) {
                // Previne o comportamento padrão do formulário (recarregar a página)
                event.preventDefault();

                // Valor que define que o formulário foi submetido
                var btn_submit = 1;
                var id_mas_submit = $("#form").attr("id_mas");
                var nome_editar = $("#nome").val();
                var cpf_editar = $("#cpf").val();
                var email_editar = $("#email").val();

                // Obtém os valores do formulário
                var dados_form = {

                    id_mas_submit: id_mas_submit,
                    nome_editar: nome_editar,
                    cpf_editar: cpf_editar,
                    email_editar: email_editar,

                    // Valor que valida o click no botão
                    btn_submit: btn_submit

                }

                // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                $.post('controller/usuarios_master_post.php', dados_form, function(retorno) {

                    switch (retorno) {
                        case "0":

                            // Exibe uma mensagem de erro usando o plugin SweetAlert2
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                title: 'Atenção!',
                                text: 'Preencha os campos requeridos em todas as abas!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });

                            break;

                        case "1":

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                title: 'Sucesso!',
                                text: 'Informação atualizada com sucesso!',
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = "alterar_usuario_master";
                                }
                            });

                            break;

                        case "2":

                            // Exibe uma mensagem de CPF já cadastrado na base
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                title: 'Atenção!',
                                text: 'O CPF já está cadastrado para um colaborador ativo!',
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    $("#cpf").val("");

                                    swal.close();
                                }
                            });

                            break;

                        case "3":

                            // Exibe uma mensagem de E-MAIL já cadastrado na base
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                title: 'Atenção!',
                                text: 'O e-mail já está cadastrado para um colaborador ativo!',
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    $("#email").val("");

                                    swal.close();
                                }
                            });

                            break;

                        default:

                            // alert(retorno);
                            Swal.fire({
                                icon: 'error',
                                title: 'Please contact support.',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });

                            break;
                    }

                }).fail(function() {

                    // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                    Swal.fire({
                        icon: 'error',
                        title: 'Please contact support.',
                        title: 'Favor entrar em contato com o suporte.',
                        html: retorno
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });

                });
            });
        });

    //Clique do botão EYE para realizar a troca do icone
    $(document).ready(function() {
        $(document).on('click', '.lnr-eye-modal', function() {

            var senha = $('#troca-senha');
            senha.attr('type', senha.attr('type') === 'password' ? 'text' : 'password');
            $(this).toggleClass('fa-eye-slash fa-eye');

        });
    });

    //Clique do botão EYE para realizar a troca do icone
    $(document).ready(function() {
        $(document).on('click', '.lnr-eye1-modal', function() {

            var senha = $('#confirm-senha');
            senha.attr('type', senha.attr('type') === 'password' ? 'text' : 'password');
            $(this).toggleClass('fa-eye-slash fa-eye');

        });
    });

    //Clique do botão BTN-SENHA para efetuar o post para alterar a senha
    $(document).ready(function() {
        $(document).on('click', '#btn-senha', function() {


            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja alterar a senha do usuário?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, alterar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Valor que define se o botão foi clicado
                    var btn_senha = 1;

                    // Obtém os valores dos campos
                    var dados_form = {

                        id_mas_senha: $("#form").attr("id_mas"),

                        senha: $("#troca-senha").val(),
                        confirm_senha: $("#confirm-senha").val(),

                        // Valor que valida o click no botão
                        btn_senha: btn_senha
                    }

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/usuarios_master_post.php', dados_form, function(retorno) {

                        // alert(retorno);

                        switch (retorno) {
                            case "0":

                                // Exibe uma mensagem de sucesso e recarrega a pagina
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    title: 'Atenção!',
                                    text: 'A nova senha deve conter no mínimo 3 caracteres!',
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // location.href = "politicas_codconduta";
                                    }
                                });

                                break;

                            case "1":

                                // Exibe uma mensagem de sucesso e recarrega a pagina
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    title: 'Sucesso!',
                                    text: 'Senha alterada com sucesso!',
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href = "alterar_usuario_master";
                                    }
                                });

                                break;

                            case "2":

                                // Exibe uma mensagem de sucesso e recarrega a pagina
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    title: 'Atenção!',
                                    text: 'As duas senhas não coincidem!',
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // location.href = "politicas_codconduta";
                                    }
                                });

                                break;

                            default:
                                break;
                        }

                    });

                }

            });

        });
    });

    // Aguarda o documento ser carregado antes de executar o código
    $(document).ready(function() {

        // Associa um evento de clique ao elemento com o ID 'btn-voltar'
        $(document).on('click', '#btn-voltar', function() {

            // Define a variável 'btn_voltar' e atribui o valor 1 a ela
            var btn_voltar = 1;

            // Verifica se 'btn_voltar' não é uma string vazia
            if (btn_voltar !== '') {

                // Cria um objeto 'dados' com a propriedade 'btn_voltar' e seu valor
                var dados = {
                    btn_voltar: btn_voltar
                };

                // Envia uma solicitação POST para o arquivo 'usuarios_master_post.php' com os dados
                $.post('controller/usuarios_master_post.php', dados, function(retorna) {

                    // Redireciona para a página 'usuarios_master'
                    location.href = "usuarios_master";

                });

            }

        });

    });
</script>