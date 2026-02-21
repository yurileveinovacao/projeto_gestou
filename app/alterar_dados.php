<?php

//Faz a requisição da Sessão
require 'restrito.php';

// Chama a pagina de utilidades
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
    <title>Gestou - Alterar Dados</title>
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

                            <li class="breadcrumb-item active h4" aria-current="page">Alterar Dados</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                        <div class="card shadow mb-2 width-100">
                            <!-- HEADER TOTAL PROVENTOS -->
                            <div class="d-block card-header py-3 collapsed">

                                <?php

                                foreach (select_SEUS_DADOS($id_usu_default) as $linha) {

                                    $email = $linha["email"];
                                    $telefone = $linha["telefone"];
                                    $celular = $linha["celular"];
                                    $endereco = $linha["endereco"];
                                    $numero = $linha["numero"];
                                    $bairro = $linha["bairro"];
                                    $complemento = $linha["complemento"];
                                    $cep_banco = $linha["cep"];
                                } ?>

                                <form id="form" class="needs-validation" novalidate>

                                    <div class="col-md-12">

                                        <!-- E-MAIL -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="email" class="mt-sm-3 mb-2 font-weight-bold">E-mail</label>
                                                <input type="email" class="form-control" id="email" name="email" maxlength="255" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" value="<?php echo $email; ?>">
                                            </div>
                                        </div>

                                        <!-- TELEFONE -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="telefone" class="mt-sm-3 mb-2 font-weight-bold">Telefone</label>
                                                <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="<?php echo $telefone; ?>" inputmode="tel">
                                            </div>
                                        </div>

                                        <!-- CELULAR -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="celular" class="mt-sm-3 mb-2 font-weight-bold">Celular</label>
                                                <input type="text" class="form-control" id="celular" attrname="celular" name="celular" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="<?php echo $celular; ?>" inputmode="tel">
                                            </div>
                                        </div>

                                        <!-- ENDEREÇO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="endereco" class="mt-sm-3 mb-2 font-weight-bold">Endereço</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" maxlength="255" value="<?php echo $endereco; ?>">
                                            </div>
                                        </div>

                                        <!-- NUMERO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="numero" class="mt-sm-3 mb-2 font-weight-bold">Número</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero" maxlength="10" value="<?php echo $numero; ?>">
                                            </div>
                                        </div>

                                        <!-- BAIRRO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="bairro" class="mt-sm-3 mb-2 font-weight-bold">Bairro</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" maxlength="25" value="<?php echo $bairro; ?>">
                                            </div>
                                        </div>

                                        <!-- COMPLEMENTO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="complemento" class="mt-sm-3 mb-2 font-weight-bold">Complemento</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" maxlength="25" value="<?php echo $complemento; ?>">
                                            </div>
                                        </div>

                                        <!-- ESTADO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="estado" class="mt-sm-3 mb-2 font-weight-bold">Estado</label>
                                                <select id="estado" name="estado" class="form-control" required>
                                                    <?php
                                                    foreach (select_ESTADO_campo('id_usu', $id_usu_default, 0, 0) as $estado_banco) {

                                                        echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        $estado = $estado_banco['estado_atual'];
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- CIDADE -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="cidade" class="mt-sm-3 mb-2 font-weight-bold">Cidade</label>
                                                <select id="cidade" name="cidade" class="form-control" required>

                                                    <?php
                                                    foreach (select_CIDADE_campo('id_usu', $id_usu_default, 0, 0, $estado) as $cidade_banco) {

                                                        echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                        $cep = $cidade_banco['cep'];
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- CEP -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="cep" class="mt-sm-3 mb-2 font-weight-bold">CEP</label>
                                                <input type="text" class="form-control" id="cep" attrname="cep" name="cep" pattern="^\d{5}-?\d{3}$" value="<?php echo $cep_banco ?>" maxlength="10" required>
                                            </div>
                                        </div>

                                        <!-- ENVIAR -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-brave btn-icon-split-brave width-100 mt-sm-3">
                                                    <span class="font-weight-bold">SALVAR</span>
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

    <!-- REQUISITOS MÁSCARAS JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#telefone').mask('(000) 00000-0000');
        $('#celular').mask('(000) 00000-0000');
        $('#cep').mask('00000-000');
        // e assim por diante para outros campos de entrada
    });
</script>

<script type="text/javascript">
    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade_idusu.php?search=', {
                    estado: $(this).val(),
                    ajax: 'true'
                }, function(j) {
                    var options =
                        '<option value="" selected disabled>Escolha a Cidade</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id_mun + '" namespace="' + j[i]
                            .cep_mun + '">' + j[i].nome_mun + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
            }
        });
    });
</script>

<!-- FIM ANIMAÇÃO RÁPIDA -->

<script>
    document.getElementById("estado").onchange = function() {
        // var select = document.getElementById("estado");
        // var cep = select.options[select.selectedIndex].getAttribute("namespace");
        document.querySelector("[name='cep']").value = '';

    }

    document.getElementById("cidade").onchange = function() {
        var select = document.getElementById("cidade");
        var cep = select.options[select.selectedIndex].getAttribute("namespace");
        document.querySelector("[name='cep']").value = cep;
    }
</script>

<!-- VALIDA O ENVIO DO FORM -->
<script>
    // Seleciona todos os elementos com a classe 'needs-validation' e armazena em 'forms'
    var forms = document.getElementsByClassName('needs-validation');

    // Itera sobre cada formulário encontrado
    Array.from(forms).forEach(function(form) {

        // Adiciona um ouvinte de evento para o evento 'submit' em cada formulário
        form.addEventListener('submit', function(event) {

            // Verifica se o formulário é inválido
            if (form.checkValidity() === false) {
                event.preventDefault(); // Impede o envio do formulário
                event.stopPropagation(); // Impede a propagação do evento
            }

            form.classList.add('was-validated'); // Adiciona a classe 'was-validated' ao formulário
        }, false);
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'meus_dados'
            location.href = 'meus_dados';
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
                text: 'Tem certeza que deseja realizar essa alteração?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, realizar!',
                cancelButtonText: 'Não!'
            }).then((result) => {

                if (result.isConfirmed) {

                    var btn_submit = 1;

                    if (btn_submit !== '') {

                        var dados = {
                            email: $('#email').val(),
                            telefone: $('#telefone').val(),
                            celular: $('#celular').val(),
                            endereco: $('#endereco').val(),
                            numero: $('#numero').val(),
                            bairro: $('#bairro').val(),
                            complemento: $('#complemento').val(),
                            estado: $('#estado').val(),
                            cidade: $('#cidade').val(),
                            cep: $('#cep').val(),

                            btn_submit: btn_submit
                        };

                        $.post('controller/alterar_dados_post.php', dados, function(retorno) {

                            switch (retorno) {

                                case '1':
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Dados atualizados com sucesso!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = 'meus_dados';
                                        }
                                    });
                                    break;

                                case '0':
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Atenção!',
                                        text: 'Preencha todos os campos requeridos para completar a ação!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close();
                                        }
                                    });
                                    break;

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

                        });
                    }
                }

            });
        });
    });
</script>