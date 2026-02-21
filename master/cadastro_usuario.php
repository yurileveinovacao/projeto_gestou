<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Cadastrar Usuário</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- INICIO MAIN WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastrar Usuário</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-identificacao-tab" data-toggle="tab" href="#menu-identificacao" role="tab" aria-controls="menu-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" novalidate>

                                <!-- INICIO DIV CLASS COL-MD-12 -->
                                <div class="col-md-12">

                                    <!-- INICIO TAB CONTENT -->
                                    <div class="tab-content" id="nav-tabContent">

                                        <!-- INÍCIO MENU IDENTIFICAÇÃO -->
                                        <div class="tab-pane fade show active" id="menu-identificacao" role="tabpanel" aria-labelledby="menu-identificacao-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="CPF">CPF</label>
                                                    <input type="text" class="form-control" id="CPF" attrname="CPF" name="CPF" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9][\s][0-9]{4}-[0-9]{4}||\([0-9]{3}\)[\s][0-9]{4}-[0-9]{4}" minlength="15" value="">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="tus">Tipo Usuário</label>
                                                    <select class="form-control" id="tus" name="tus">

                                                        <?php

                                                        foreach (selectGESTUS() as $tus_banco) {

                                                            echo '<option value="' . $tus_banco['id_tus'] . '">' . $tus_banco['descricao'] . '</option>';
                                                        }

                                                        ?>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU IDENTIFICAÇÃO -->

                                        <!-- INÍCIO MENU ENDEREÇO -->
                                        <div class="tab-pane fade" id="menu-endereco" role="tabpanel" aria-labelledby="menu-endereco-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-10 mb-3">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <select id="estado" name="estado" class="form-control" required>
                                                        <option value="" selected>Selecione um Estado</option>
                                                        <?php foreach (select_ESTADO_campo('id_cad', $id_fun, $id_usa_alterar, $id_emp_default) as $estado_banco) {
                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                            $estado = $estado_banco['estado_atual'];
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required></select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="CEP">CEP</label>
                                                    <input type="text" class="form-control" id="CEP" attrname="cep" name="cep" value="<?php echo $cep ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU ENDEREÇO -->

                                        <!-- INÍCIO BOTÃO ENVIAR -->
                                        <div class="form-group">
                                            <div class="textalign-right">
                                                <button type="submit" id="btn-salvar" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                                <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                            </div>
                                        </div>
                                        <!-- FIM BOTÃO ENVIAR -->

                                    </div>
                                    <!-- FIM TAB CONTENT -->
                                </div>
                                <!-- FIM DIV CLASS COL-MD-12 -->
                            </form>
                            <!-- FIM FORM -->

                        </div>
                        <!-- FIM CARD BODY -->

                    </div>
                    <!-- FIM CARD SHADOW -->

                </div>
                <!-- FIM PAGE CONTENT -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php

            include_once "footer.php"

            ?>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM MAIN WRAPPER -->


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

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

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


    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA RG
    // var rgMask = ['99.999.999-9', '99.999.999-9'];
    // var rg = document.querySelector('input[attrname=RG]');
    // VMasker(rg).maskPattern(rgMask[0]);
    // rg.addEventListener('input', inputHandler.bind(undefined, rgMask, 13), false);

    // MÁSCARA CPF
    var cpfMask = ['999.999.999-99', '999.999.999-99'];
    var cpf = document.querySelector('input[attrname=CPF]');
    VMasker(cpf).maskPattern(cpfMask[0]);
    cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

    // MÁSCARA TEL
    var telMask = ['(999) 9999-9999', '(999) 9 9999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);

    // MÁSCARA CEL
    // var celMask = ['(999) 99999-9999', '(999) 99999-9999'];
    // var cel = document.querySelector('input[attrname=celular]');
    // VMasker(cel).maskPattern(celMask[0]);
    // cel.addEventListener('input', inputHandler.bind(undefined, celMask, 16), false);

    // MÁSCARA DATA
    // var datanascMask = ['99/99/9999', '99/99/9999'];
    // var datanasc = document.querySelector('input[attrname=datanasc]');
    // VMasker(datanasc).maskPattern(datanascMask[0]);
    // datanasc.addEventListener('input', inputHandler.bind(undefined, datanascMask, 10), false);

    // MÁSCARA DATA
    // var dataadmisMask = ['99/99/9999', '99/99/9999'];
    // var dataadmis = document.querySelector('input[attrname=dataadmis]');
    // VMasker(dataadmis).maskPattern(dataadmisMask[0]);
    // dataadmis.addEventListener('input', inputHandler.bind(undefined, dataadmisMask, 10), false);

    // MÁSCARA CEP
    var cepMask = ['99999-9999', '99999-999'];
    var cep = document.querySelector('input[attrname=cep]');
    VMasker(cep).maskPattern(cepMask[0]);
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);

    // MÁSCARA DECIMAL
    // var decimalMask = ['$ 9.999.999,99','$ 999.999,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
    // var decimalMask = ['$ ,99','$ 9,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
    // var decimal = document.querySelector('input[attrname=decimal]');
    // VMasker(decimal).maskPattern(decimalMask[0]);
    // decimal.addEventListener('input', inputHandler.bind(undefined, decimalMask, 25), false);
</script>

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<script type="text/javascript">
    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade.php?search=', {
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

<!-- AÇÕES NO CLICK -->
<script>
    // BOTÃO VOLTAR
    $(function() {
        $(document).on('click', '#btn-voltar', function() {

            location.href = 'tabela_usuarios';
        });
    });

    // QUANDO O FORMULÁRIO É SUBMETIDO
    $(function() {
        $("#form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            // Valor que define que o formulário foi submetido
            var btn_salvar = 1;

            if (btn_salvar !== '') {

                // Obtém os valores do formulário
                var dados_form = {
                    // Valor do formulario
                    // Menu Identificação
                    nome_update: $('#nome').val(),
                    cpf_update: $('#CPF').val(),
                    email_update: $('#email').val(),
                    telefone_update: $('#telefone').val(),
                    tus_update: $('#tus').val(),

                    // Menu Endereço
                    endereco_update: $('#endereco').val(),
                    bairro_update: $('#bairro').val(),
                    complemento_update: $('#complemento').val(),
                    numero_update: $('#numero').val(),
                    cidade_update: $('#cidade').val(),
                    cep_update: $('#CEP').val(),

                    // Valor que valida o envio do formulário
                    btn_salvar: btn_salvar
                }

                $.post('controller/cadastro_usuario_post.php', dados_form, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e abre a pagina alterar_usuario.php
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Dados inseridos com Sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'alterar_usuario';
                            }
                        })
                        // Se o retorno for igual a 0, os dados não foram preenchidos corretamente
                    } else if (retorno == 0) {

                        // Exibe uma mensagem de falha
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atenção',
                            text: 'Preencha todos os campos para concluir a ação!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                swal.close();
                            }
                        })
                        // Caso não for 0/1, houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
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

                });
            }
        });
    });
</script>