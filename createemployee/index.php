<?php
require_once __DIR__ . '/../config/maintenance.php';
checkMaintenanceMode();

// //Faz a requisição da Sessão
// require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

// //ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>GESTOU - Create Employee</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/createemployee.css" rel="stylesheet" type="text/css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<?php if (isset($_REQUEST['emp'])) {

    $emp_token = $_REQUEST["emp"];

    foreach (select_GESSEMP_token($emp_token) as $select_gesemp) {

        $id_emp_employee = $select_gesemp["id_emp"];
        $venc_token = $select_gesemp["datval_token"];
    }

    if (!empty($select_gesemp)) {

        $data_atual = new DateTime($datinc);
        $data_banco = new DateTime($venc_token);

        if ($data_banco < $data_atual) {

            $vencido = 1;
        } else {

            $vencido = 0;
        }
    } else {

        $vencido = 1;
    }
} else {

    $vencido = 2;
} ?>

<body>

    <!-- Navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="/" class="navbar-brand">
                    <img src="../img/icone_gestou.png" alt="logo" width="150">
                </a>
            </div>
        </nav>
    </header>

    <div class="container" id="conteiner" vencido="<?php echo $vencido; ?>" hidden>
        <div class="row py-5 mt-4 align-items-center">
            <!-- For Demo Purpose -->
            <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                <img src="img/createemployee.png" alt="" class="img-fluid mb-3 d-none d-md-block">
                <h1 class="text-center">Crie sua conta</h1>
                <p class="font-italic text-muted mb-0 text-justify">Crie sua conta no portal Gestou e aproveite todos os benefícios e recursos disponíveis.</p>
                <!-- <p class="font-italic text-muted">Snippet By <a href="https://bootstrapious.com" class="text-muted">
                        <u>Bootstrapious</u></a>
                </p> -->
            </div>

            <!-- Registeration Form -->
            <div class="col-md-7 col-lg-6 ml-auto">
                <form id="myForm">
                    <div class="row">

                        <!-- DIVISÃO IDENTIFICAÇÃO -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Identificação</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- INPUT NOME -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="nome" type="text" name="nome" placeholder="Nome" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- INPUT CPF -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-id-card text-muted"></i>
                                </span>
                            </div>
                            <input id="cpf" type="text" name="cpf" placeholder="CPF" inputmode="numeric" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- INPUT EMAIL -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="E-mail" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- INPUT CELULAR -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fas fa-mobile-alt text-muted"></i>
                                </span>
                            </div>
                            <input id="celular" type="text" name="celular" placeholder="Celular" inputmode="numeric" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- INPUT DATA NASCIMENTO -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fas fa-calendar-alt text-muted"></i>
                                </span>
                            </div>
                            <input id="datanasc" type="text" name="datanasc" placeholder="Data de Nascimento" inputmode="numeric" class="form-control bg-white border-left-0 border-md" required>
                        </div>


                        <!-- DIVISÃO ENDEREÇO -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Endereço</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- INPUT ENDEREÇO -->
                        <div class="input-group col-lg-12 mb-4">
                            <input id="endereco" type="text" name="endereco" placeholder="Endereço" class="form-control bg-white border-md" maxlength="255" required>
                        </div>

                        <!-- INPUT NUMERO -->
                        <div class="input-group col-lg-12 mb-4">
                            <input id="numero" type="text" name="numero" placeholder="Número" class="form-control bg-white border-md" maxlength="10" required>
                        </div>

                        <!-- INPUT BAIRRO -->
                        <div class="input-group col-lg-12 mb-4">
                            <input id="bairro" type="text" name="bairro" placeholder="Bairro" class="form-control bg-white border-md" maxlength="25" required>
                        </div>

                        <!-- INPUT COMPLEMENTO -->
                        <div class="input-group col-lg-12 mb-4">
                            <input id="complemento" type="text" name="complemento" placeholder="Complemento" class="form-control bg-white border-md" maxlength="25">
                        </div>

                        <!-- INPUT ESTADO -->
                        <div class="input-group col-lg-12 mb-4">
                            <select id="estado" name="estado" class="form-control bg-white border-md" required>
                                <?php foreach (select_ESTADO_campo($id_emp_employee) as $estado_banco) {

                                    echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                    $estado = $estado_banco['estado_atual'];
                                } ?>
                            </select>
                        </div>

                        <!-- INPUT CIDADE -->
                        <div class="input-group col-lg-12 mb-4">
                            <select id="cidade" name="cidade" class="form-control bg-white border-md" required>
                                <?php foreach (select_CIDADE_campo($id_emp_employee, $estado) as $cidade_banco) {

                                    echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                    $cep = $cidade_banco['cep'];
                                } ?>
                            </select>
                        </div>

                        <!-- INPUT CEP -->
                        <div class="input-group col-lg-12 mb-4">
                            <input id="cep" type="text" name="cep" placeholder="CEP" inputmode="numeric" class="form-control bg-white border-md pl-3" required>
                        </div>

                        <!-- INPUT SENHA -->
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Senha" class="form-control bg-white border-left-0 border-md" maxlength="255" required>
                            <div class="input-group-append">
                                <span class="input-group-text bg-white px-4 border-md border-left-0">
                                    <i class="fa fa-eye text-muted cursor-pointer" id="toggle-password"></i>
                                </span>
                            </div>
                        </div>

                        <!-- INPUT CONFIRMAR SENHA -->
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirme senha" class="form-control bg-white border-left-0 border-md" maxlength="255" required>
                            <div class="input-group-append">
                                <span class="input-group-text bg-white px-4 border-md border-left-0">
                                    <i class="fa fa-eye text-muted cursor-pointer" id="toggle-confirmpassword"></i>
                                </span>
                            </div>
                        </div>

                        <!-- REQUISITOS SENHA -->
                        <div id="password_requirements" class="col-md-12" style="display: none;">

                            <!-- Divider Text -->
                            <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                                <div class="border-bottom w-100 ml-5"></div>
                                <span class="px-2 small text-muted font-weight-bold text-muted w-100">Requisitos de senha</span>
                                <div class="border-bottom w-100 mr-5"></div>
                            </div>

                            <!-- Divider Text -->
                            <div class="input-group col-lg-12 mb-4">
                                <ul>
                                    <li class="text-danger" id="password_r1"><span class="px-2 small font-weight-bold">Mínimo de 8 caracteres</span></li>
                                </ul>
                            </div>

                        </div>

                        <!-- CHECKBOX ACEITE DE TERMOS -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termos-e-politicas" required>
                                <label class="form-check-label text-muted font-weight-bold" for="termos-e-politicas">
                                    <div class="d-flex">
                                        <p>Concordo e aceito as</p>
                                        <p class="ml-1 text-primary cursor-pointer" id="btn-polpri">Políticas de privacidade</p>.
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Crie sua conta</span>
                            </button>
                        </div>

                        <!-- Divider Text -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Ou</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- Already Registered -->
                        <div class="w-100 d-flex justify-content-center">
                            <p class="text-muted font-weight-bold">Já registrado?</p>
                            <p class="font-weight-bold text-primary ml-2 cursor-pointer" id="btn-login">Login</p>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- --------------------------------------------------- INICIO MODAIS -------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

        <!-- Modal Políticas de privacidade -->
        <div class="modal fade" id="politicasDePrivacidade" tabindex="-1" role="dialog" aria-labelledby="politicasDePrivacidade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Políticas de privacidade</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-politica">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Captcha -->
        <div class="modal fade" id="captcha" tabindex="-1" role="dialog" aria-labelledby="captcha" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Captcha</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="form-modal-captcha">
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LdoVD4eAAAAAHOaEUgE70s5Ii_yS9BSg87PLr1Z" data-callback="recaptchaCallback"></div>
                                <input class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- ------------------------------------------------------ FIM MODAIS -------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->


    </div>

    <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="js/detect.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</body>

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

    $(function() {

        var cep = $('#cidade option:selected').attr('namespace');

        $('#cep').val(cep);
    });
</script>

<!-- MASCARAS -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');
        $('#datanasc').mask('00/00/0000');
    });

    $(document).ready(function() {
        // Máscara para o campo 'email' com tradução personalizada
        $('#email').mask('A', {
            'translation': {
                A: {
                    pattern: /[\w@\-.+]/,
                    recursive: true
                }
            }
        });
    });

    $(document).ready(function() {
        // Definição de uma função para o comportamento da máscara de telefone
        var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 12 ? '(000) 00000-0000' : '(000) 0000-00000';
        };

        // Opções para a máscara de telefone
        var spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        // Aplica a máscara de telefone no campo 'telefone' com base na função de comportamento e nas opções definidas
        $('#celular').mask(SPMaskBehavior, spOptions);
    });
</script>

<!-- AÇÕES NO CARREGAMENTO DA PAGINA -->
<script>
    $(document).ready(function() {
        $('#captcha').on('hidden.bs.modal', function() {
            // Recarregar o reCAPTCHA
            grecaptcha.reset();
        });
    });

    $(function() {
        $(document).ready(function() {

            var vencimento = $('#conteiner').attr('vencido');

            if (vencimento === '1') {

                $(this).mensagem_alert('VENCIDO');
            } else if (vencimento === '2') {

                $(this).mensagem_alert('SEM_TOKEN');
            } else {

                $('#conteiner').attr('hidden', false);
            }
        });
    });

    // ADICIONA O ALERTA DE INPUT ERRADO
    $(document).ready(function() {

        // Váriaveis de REGEX
        var textoRegex = /^.{3,}$/;
        var cpfRegex = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/;
        var emailRegex = /^([\w\.]+@([\w]+\.)+[\w]{2,4})?$/;
        var celularRegex = /^\(\d{3}\) (\d{4}|\d{5})-\d{4}$/;
        var nascRegex = /^(\d{2}\/){2}\d{4}$/;
        var nuemroRegex = /^[\w\s]+$/;
        var estcidRegex = /^\d+$/;
        var cepRegex = /^\d{5}\-\d{3}$/;
        var senhaRegex = /^\S{8,}$/;

        // Quando um campo obrigatório perde o foco (evento blur)
        $('input[required]').on('blur', function() {
            // Obtém o valor do campo
            var fieldValue = $(this).val();
            // Variável para verificar se o campo é válido
            var isValid = true;

            // Se o valor do campo estiver vazio
            if (fieldValue === '') {

                // Adiciona a classe 'error' ao próprio campo e ao elemento span do campo que contém a classe 'input-group-text'
                $(this).addClass('error').parent().find('.input-group-text').addClass('error');
            } else { // Se o valor do campo não estiver vazio

                // Obtém o nome do campo através do atributo 'name'
                var fieldName = $(this).attr('name');

                // Verifica o nome do campo usando uma instrução switch
                switch (fieldName) {
                    case 'nome':
                    case 'endereco':
                    case 'bairro':
                        // Valida o campo usando uma expressão regular específica para 'nome', 'endereco' e 'bairro'
                        isValid = textoRegex.test(fieldValue);
                        break;
                    case 'cpf':
                        // Valida o campo usando uma expressão regular específica para 'cpf'
                        isValid = cpfRegex.test(fieldValue);
                        break;
                    case 'email':
                        // Valida o campo usando uma expressão regular específica para 'email'
                        isValid = emailRegex.test(fieldValue);
                        break;
                    case 'celular':
                        // Valida o campo usando uma expressão regular específica para 'celular'
                        isValid = celularRegex.test(fieldValue);
                        break;
                    case 'datanasc':
                        // Valida o campo usando uma expressão regular específica para 'datanasc'
                        isValid = nascRegex.test(fieldValue);
                        break;
                    case 'numero':
                        // Valida o campo usando uma expressão regular específica para 'numero'
                        isValid = nuemroRegex.test(fieldValue);
                        break;
                    case 'estado':
                    case 'cidade':
                        // Valida o campo usando uma expressão regular específica para 'estado' e 'cidade'
                        isValid = estcidRegex.test(fieldValue);
                        break;
                    case 'cep':
                        // Valida o campo usando uma expressão regular específica para 'cep'
                        isValid = cepRegex.test(fieldValue);
                        break;
                    case 'password':
                    case 'confirmpassword':
                        // Valida o campo usando uma expressão regular específica para 'password' e 'confirmpassword'
                        isValid = senhaRegex.test(fieldValue);
                        break;
                }

                // Se o campo for válido
                if (isValid) {

                    // Remove a classe 'error' do próprio campo e do elemento span do campo que contém a classe 'input-group-text'
                    $(this).removeClass('error').parent().find('.input-group-text').removeClass('error');
                } else { // Se o campo não for válido

                    // Adiciona a classe 'error' ao próprio campo e ao elemento span do campo que contém a classe 'input-group-text'
                    $(this).addClass('error').parent().find('.input-group-text').addClass('error');
                }
            }
        });

        // Quando um checkbox obrigatório for clicado
        $('input[type="checkbox"][required]').on('click', function() {
            // Verifica se o checkbox foi marcado
            var isChecked = $(this).prop('checked');

            // Se não estiver marcado
            if (!isChecked) {
                // Adiciona a classe 'error-checkbox' ao checkbox e o elemento pai do checkbox que contém a classe 'input-group-text'
                $(this).addClass('error-checkbox').parent().find('.input-group-text').addClass('error-checkbox');
            } else { // Se estiver marcado
                // Remove a classe 'error-checkbox' do checkbox e do elemento pai do checkbox que contém a classe 'input-group-text'
                $(this).removeClass('error-checkbox').parent().find('.input-group-text').removeClass('error-checkbox');
            }
        });

        // verifica se as senhas estão validas
        var senhaValid = false;

        // Quando o campo de senha recebe o foco
        $('#password').on('focus', function() {
            // Exibe os requisitos da senha
            $('#password_requirements').show();
        });

        // Aguarda o documento estar pronto para executar o código
        $(document).ready(function() {
            // Quando uma tecla for pressionada no campo de senha
            $('#password').on('keyup', function() {
                var senha = $(this).val();

                // Verifica se as três condições são satisfeitas e se a senha tem no mínimo 8 caracteres
                if (senha.match(senhaRegex)) {
                    $('#password_r1').removeClass('text-danger').addClass('text-success');
                    senhaValid = true;
                } else {
                    $('#password_r1').removeClass('text-success').addClass('text-danger');
                    senhaValid = false;
                }
            });
        });

        // Este trecho de código adiciona um manipulador de eventos ao elemento com o ID 'password' quando ele perde o foco
        $('#password').on('blur', function() {

            // Verifica se a senha é válida
            if (senhaValid) {
                // Esconde as informações de requisitos de senha
                $('#password_requirements').hide();
            }
        });

        // Este trecho de código adiciona um manipulador de eventos ao elemento com o ID 'confirmpassword' quando ele perde o foco
        $('#confirmpassword').on('blur', function() {

            // Obtém o valor da senha
            var passwordValue = $('#password').val();
            // Obtém o valor de confirmação da senha
            var confirmPasswordValue = $(this).val();

            // Verifica se as senhas são diferentes ou se ambas estão vazias
            if ((passwordValue !== confirmPasswordValue) || (passwordValue == "" && confirmPasswordValue == "")) {

                // Adiciona a classe 'error' aos elementos de senha, confirmação de senha e irmãos da classe '.input-group-text'
                $('#password, #confirmpassword').addClass('error').parent().find('.input-group-text').addClass('error');
            } else {
                // Verifica se a senha é válida
                if (senhaValid) {
                    // Remove a classe 'error' dos elementos de senha, confirmação de senha e irmãos da classe '.input-group-text'
                    $('#password, #confirmpassword').removeClass('error').parent().find('.input-group-text').removeClass('error');
                } else {
                    // Adiciona a classe 'error' aos elementos de senha, confirmação de senha e irmãos da classe '.input-group-text'
                    $('#password, #confirmpassword').addClass('error').parent().find('.input-group-text').addClass('error');
                }
            }
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    $(function() {
        $(document).on('click', '#btn-login', function() {

            location.href = '../app/login';
        });
    });

    $(function() {
        $(document).ready(function() {
            // Quando o botão 'toggle-password' é clicado
            $('#toggle-password').click(function() {
                // Obtém o campo de senha
                const password = $('#password');
                // Obtém o tipo de campo (password ou text)
                const type = password.attr('type') === 'password' ? 'text' : 'password';
                // Altera o tipo do campo para o tipo oposto
                password.attr('type', type);
                // Altera a classe do ícone do botão para alternar entre os ícones 'fa-eye' e 'fa-eye-slash'
                $(this).toggleClass('fa-eye-slash');
            });
        });
    });

    $(function() {
        $(document).ready(function() {
            // Quando o botão 'toggle-confirmpassword' é clicado
            $('#toggle-confirmpassword').click(function() {
                // Obtém o campo de confirmação de senha
                const password = $('#confirmpassword');
                // Obtém o tipo de campo (password ou text)
                const type = password.attr('type') === 'password' ? 'text' : 'password';
                // Altera o tipo do campo para o tipo oposto
                password.attr('type', type);
                // Altera a classe do ícone do botão para alternar entre os ícones 'fa-eye' e 'fa-eye-slash'
                $(this).toggleClass('fa-eye-slash');
            });
        });
    });

    // Para fins de demonstração [Alterando o texto do grupo de entrada ao focar]
    $(function() {
        $('input, select').on({
            // Quando um campo de entrada ou seleção recebe o foco
            focus: function() {
                // Adiciona a classe 'focusinput' ao elemento 'input-group-text' que é pai do campo atual
                $(this).parent().find('.input-group-text').addClass('focusinput');
            },
            // Quando um campo de entrada ou seleção perde o foco
            blur: function() {
                // Remove a classe 'focusinput' do elemento 'input-group-text' que é pai do campo atual
                $(this).parent().find('.input-group-text').removeClass('focusinput');
            }
        });
    });

    $(function() {
        $(document).on('click', '#btn-polpri', function() {

            var btn_polpri = 1;

            if (btn_polpri !== '') {

                var dados = {
                    btn_polpri: btn_polpri
                };

                $.post('controller/createemployee_post.php', dados, function(retorno) {

                    $('#modal-body-politica').html(retorno);
                    $('#politicasDePrivacidade').modal('show');
                });
            }
        });
    });
</script>

<!-- SUBMIT -->
<script>
    $(function() {
        $('#myForm').submit(function(e) {

            e.preventDefault(); // impede o envio do formulário por padrão

            var checkbox = $('#termos-e-politicas:not(:disabled):checked');

            if (checkbox !== '') {

                termo = 1;
            } else {

                termo = 0;
            }

            if (termo === 1) {

                $('#captcha').modal('show');
            }
        });
    });

    function recaptchaCallback() {

        var btn_submit = 1;
        var checkbox = $('#termos-e-politicas:not(:disabled):checked');

        if (checkbox !== '') {

            termo = 1;
        } else {

            termo = 0;
        }

        // Obter a URL atual
        var url = new URL(window.location.href);

        // Extrair os parâmetros da URL
        var params = new URLSearchParams(url.search);

        // Obter o valor do parâmetro 'emp'
        var token = params.get('emp');

        if (btn_submit !== '') {

            var formData = new FormData($('#myForm')[0]);
            formData.append('btn_submit', btn_submit);
            formData.append('termo', termo);
            formData.append('token', token);

            $.post({
                url: 'controller/createemployee_post.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(retorno) {

                    switch (retorno) {

                        case '0':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('PREENCHIMENTO');
                            break;

                        case '1':
                            $(this).mensagem_alert('SUCESSO');
                            break;

                        case '2':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('CONFIRM_SENHA_INCORRETA');
                            break;

                        case '3':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('DATANASC_INVALIDA');
                            break;

                        case '4':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('DATANASC_MENOR_PERMITIDA');
                            break;

                        case '5':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('TERMO_N_ACEITO');
                            break;

                        case '6':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('VENCIDO');
                            break;

                        case '7':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('CPF_EXISTE');
                            break;

                        case '8':
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert('EMAIL_EXISTE');
                            break;

                        default:
                            $('#captcha').modal('hide');
                            $(this).mensagem_alert(retorno);
                            break;
                    }
                }
            });
        }
    };
</script>

<!-- FUNÇÃO SWEETALERT -->
<script>
    $(function() {
        $.fn.mensagem_alert = function(caseValue) {

            switch (caseValue) {
                case 'PREENCHIMENTO':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Preencha todos os campos requeridos para continuar!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                    break;

                case 'SUCESSO':
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Sua conta foi criada com sucesso! Aguarde a aprovação da empresa e, assim que aprovado, será notificado pelo e-mail cadastrado.',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '../';
                        }
                    });
                    break;

                case 'CONFIRM_SENHA_INCORRETA':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'As senhas informadas não coincidem. Por favor, verifique as senha antes de continuar!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#confirmpassword').focus()
                            ]
                        }
                    });
                    break;

                case 'DATANASC_INVALIDA':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'A data de nascimento é inválida!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#datanasc').addClass('error').focus().parent().find('.input-group-text').addClass('error')
                            ]
                        }
                    });
                    break;

                case 'DATANASC_MENOR_PERMITIDA':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'Data de nascimento é menor que a mínima permitida!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#datanasc').addClass('error').focus().parent().find('.input-group-text').addClass('error')
                            ]
                        }
                    });
                    break;

                case 'TERMO_N_ACEITO':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'É necessário o aceite da Políticas de privacidade para continuar!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#termos-e-politicas').addClass('error-checkbox').focus().parent().find('.input-group-text').addClass('error-checkbox')
                            ]
                        }
                    });
                    break;

                case 'VENCIDO':
                    Swal.fire({
                        icon: 'info',
                        title: 'Atenção!',
                        text: 'Link selecionado está vencido, por favor entrar em contato com a empresa para obter um novo link!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '../';
                        }
                    });
                    break;

                case 'SEM_TOKEN':
                    Swal.fire({
                        icon: 'info',
                        title: 'Atenção!',
                        text: 'Nenhum token selecionado!',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '../';
                        }
                    });
                    break;

                case 'CPF_EXISTE':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'CPF já cadastrado!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#cpf').focus()
                            ]
                        }
                    });
                    break;

                case 'EMAIL_EXISTE':
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'E-mail já cadastrado!',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            return [
                                $('#email').focus()
                            ]
                        }
                    });
                    break;

                default:
                    Swal.fire({
                        icon: 'error',
                        title: 'Please contact support.',
                        title: 'Favor entrar em contato com o suporte.',
                        html: caseValue
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    });
                    break;
            }

            return this;
        };
    });
</script>