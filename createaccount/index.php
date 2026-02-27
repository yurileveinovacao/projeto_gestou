<?php
// //Faz a requisição da Sessão
// require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

// //ARQUIVO DE UTILITÁRIOS
// require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../img/logo.ico" rel="icon">
    <title>GESTOU - Create Account</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/createaccount.css" rel="stylesheet" type="text/css">

</head>

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


    <div class="container">
        <div class="row py-5 mt-4 align-items-center">
            <!-- For Demo Purpose -->
            <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                <img src="img/createaccount.png" alt="" class="img-fluid mb-3 d-none d-md-block">
                <h1 class="text-center">Crie sua conta</h1>
                <p class="font-italic text-muted mb-0 text-justify">Crie sua conta no portal para gestão de RH do Gestou e tenha acesso fácil e rápido a recursos importantes. Cadastre-se agora e descubra como o Gestou pode ajudar a melhorar sua gestão de RH.</p>
                <!-- <p class="font-italic text-muted">Snippet By <a href="https://bootstrapious.com" class="text-muted">
                        <u>Bootstrapious</u></a>
                </p> -->
            </div>

            <!-- Registeration Form -->
            <div class="col-md-7 col-lg-6 ml-auto">
                <form id="myForm" action="teste.php">
                    <div class="row">

                        <!-- Razao Social -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-building text-muted"></i>
                                </span>
                            </div>
                            <input id="razaosocial" type="text" name="razaosocial" placeholder="Razão social" class="form-control bg-white border-left-0 border-md" minlength="3" required>
                        </div>

                        <!-- CNPJ -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-registered text-muted"></i>
                                </span>
                            </div>
                            <input id="cnpj" type="text" name="cnpj" placeholder="CNPJ" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Last Name -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-users text-muted"></i>
                                </span>
                            </div>
                            <input id="qtdcolaboradores" type="number" name="qtdcolaboradores" placeholder="Quantidade de colaboradores" class="form-control bg-white border-left-0 border-md">
                        </div>

                        <!-- Divider Text -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Admin</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- Job -->
                        <!-- <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-black-tie text-muted"></i>
                                </span>
                            </div>
                            <select id="job" name="jobtitle" class="form-control custom-select bg-white border-left-0 border-md">
                                <option value="">Choose your job</option>
                                <option value="">Designer</option>
                                <option value="">Developer</option>
                                <option value="">Manager</option>
                                <option value="">Accountant</option>
                            </select>
                        </div> -->

                        <!-- Razao Social -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="nomeadm" type="text" name="nomeadm" placeholder="Nome" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- CNPJ -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-id-card text-muted"></i>
                                </span>
                            </div>
                            <input id="cpf" type="text" name="cpf" placeholder="CPF" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Email Address -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="E-mail" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-phone-square text-muted"></i>
                                </span>
                            </div>
                            <!-- <select id="countryCode" name="countryCode" style="max-width: 80px" class="custom-select form-control bg-white border-left-0 border-md h-100 font-weight-bold text-muted">
                                <option value="">+12</option>
                                <option value="">+10</option>
                                <option value="">+15</option>
                                <option value="">+18</option>
                            </select> -->
                            <input id="telefone" type="tel" name="telefone" placeholder="Telefone" class="form-control bg-white border-md border-left-0 pl-3" required>
                        </div>

                        <!-- Password -->
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Senha" class="form-control bg-white border-left-0 border-md" required>
                            <div class="input-group-append">
                                <span class="input-group-text bg-white px-4 border-md border-left-0">
                                    <i class="fa fa-eye text-muted cursor-pointer" id="toggle-password"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirme senha" class="form-control bg-white border-left-0 border-md" required>
                            <div class="input-group-append">
                                <span class="input-group-text bg-white px-4 border-md border-left-0">
                                    <i class="fa fa-eye text-muted cursor-pointer" id="toggle-confirmpassword"></i>
                                </span>
                            </div>
                        </div>

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
                                    <li class="text-danger" id="password_r2"><span class="px-2 small font-weight-bold">Pelo menos uma letra</span></li>
                                    <li class="text-danger" id="password_r3"><span class="px-2 small font-weight-bold">Pelo menos um numero</span></li>
                                    <li class="text-danger" id="password_r4"><span class="px-2 small font-weight-bold">Pelo menos um caractere especial</span></li>
                                </ul>
                            </div>

                        </div>

                        <!-- Accept Terms -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termos-e-politicas" required>
                                <label class="form-check-label text-muted font-weight-bold" for="termos-e-politicas">
                                    Concordo e aceito os <a href="#termosDeUso" class="text-primary" data-toggle="modal" data-target="#termosDeUso">Termos de uso</a> e <a href="#politicasDePrivacidade" class="text-primary" data-toggle="modal" data-target="#politicasDePrivacidade">Políticas de privacidade</a>.
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Crie sua conta</span>
                            </button>
                        </div>

                        <!-- Divider Text -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Ou</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- Divider Text -->
                        <!-- <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div> -->

                        <!-- Social Login -->
                        <!-- <div class="form-group col-lg-12 mx-auto">
                            <a href="#" class="btn btn-primary btn-block py-2 btn-facebook">
                                <i class="fa fa-facebook-f mr-2"></i>
                                <span class="font-weight-bold">Continue with Facebook</span>
                            </a>
                            <a href="#" class="btn btn-primary btn-block py-2 btn-twitter">
                                <i class="fa fa-twitter mr-2"></i>
                                <span class="font-weight-bold">Continue with Twitter</span>
                            </a>
                        </div> -->

                        <!-- Already Registered -->
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Já registrado? <a href="/admin/login" class="text-primary ml-2">Login</a></p>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Termos de uso -->
        <div class="modal fade" id="termosDeUso" tabindex="-1" role="dialog" aria-labelledby="termosDeUso" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termosDeUso">Termos de uso</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php

                        foreach (selectGESPRI_termos() as $linha_termos) {

                            $descricao_termos = $linha_termos["descricao"];
                        }

                        ?>
                        <p><?php echo str_replace('•', '<br>•', $descricao_termos); ?></p>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Políticas de privacidade -->
        <div class="modal fade" id="politicasDePrivacidade" tabindex="-1" role="dialog" aria-labelledby="politicasDePrivacidade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="politicasDePrivacidade">Políticas de privacidade</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php

                        foreach (selectGESPRI_politica() as $linha_politica) {

                            $descricao_politica = $linha_politica["descricao"];
                        }

                        ?>
                        <p><?php echo str_replace('•', '<br>•', $descricao_politica); ?></p>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                </div>
            </div>
        </div>

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

<script>
    /*
iPhone 4 Example User Agent:
Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7
*/

    var ua = detect.parse(navigator.userAgent);

    // ua.browser.family // "Mobile Safari"
    // ua.browser.name // "Mobile Safari 4.0.5"
    // ua.browser.version // "4.0.5"
    // ua.browser.major // 4
    // ua.browser.minor // 0
    // ua.browser.patch // 5

    // ua.device.family // "iPhone"
    // ua.device.name // "iPhone"
    // ua.device.version // ""
    // ua.device.major // null
    // ua.device.minor // null
    // ua.device.patch // null
    // ua.device.type // "Mobile"
    // ua.device.manufacturer // "Apple"

    // ua.os.family // "iOS"
    // ua.os.name // "iOS 4"
    // ua.os.version // "4"
    // ua.os.major // 4
    // ua.os.minor // 0
    // ua.os.patch // null

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

    $(document).ready(function() {
        // Máscara para o campo 'cnpj' no formato '00.000.000/0000-00'
        $('#cnpj').mask('00.000.000/0000-00');
    });

    $(document).ready(function() {
        // Máscara para o campo 'qtdcolaboradores' no formato '0000#' com a opção 'reverse' habilitada
        $('#qtdcolaboradores').mask('0000#', {
            reverse: true
        });

        // Limpa qualquer caractere não numérico inserido no campo 'qtdcolaboradores' através do evento 'input'
        $('#qtdcolaboradores').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    $(document).ready(function() {
        // Máscara para o campo 'cpf' no formato '000.000.000-00'
        $('#cpf').mask('000.000.000-00');
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
            return val.replace(/\D/g, '').length === 12 ? '(000) 00000-0000' : '(000) 0000-00009';
        };

        // Opções para a máscara de telefone
        var spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        // Aplica a máscara de telefone no campo 'telefone' com base na função de comportamento e nas opções definidas
        $('#telefone').mask(SPMaskBehavior, spOptions);
    });

    $(document).ready(function() {

        // Váriaveis de REGEX
        var razaosocialRegex = /^.{3,}$/;
        var nomeadmRegex = /^.{3,}$/;
        var cnpjRegex = /^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/;
        var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var cpfRegex = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/;
        var telefoneRegex = /^\(\d{3}\) \d{4}-\d{4}$|^\(\d{3}\) \d{5}-\d{4}$/;
        var password = /^(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])(?=.*[a-zA-Z])(?=.*[0-9]).{8,}\S*$/;

        // Quando um campo obrigatório perde o foco (evento blur)
        $('input[required]').on('blur', function() {
            // Obtém o valor do campo
            var fieldValue = $(this).val();
            // Variável para verificar se o campo é válido
            var isValid = true;

            // Se o valor do campo estiver vazio
            if (fieldValue === '') {
                // Adiciona a classe 'error' ao próprio campo
                $(this).addClass('error');
                // Adiciona a classe 'error' ao elemento pai do campo que contém a classe 'input-group-text'
                $(this).parent().find('.input-group-text').addClass('error');
            } else { // Se o valor do campo não estiver vazio
                // Obtém o nome do campo através do atributo 'name'
                var fieldName = $(this).attr('name');

                // Verifica o nome do campo usando uma instrução switch
                switch (fieldName) {
                    case 'razaosocial':
                        // Valida o campo usando uma expressão regular específica para 'razaosocial'
                        isValid = razaosocialRegex.test(fieldValue);
                        break;
                    case 'nomeadm':
                        // Valida o campo usando uma expressão regular específica para 'nomeadm'
                        isValid = nomeadmRegex.test(fieldValue);
                        break;
                    case 'cnpj':
                        // Valida o campo usando uma expressão regular específica para 'cnpj'
                        isValid = cnpjRegex.test(fieldValue);
                        break;
                    case 'email':
                        // Valida o campo usando uma expressão regular específica para 'email'
                        isValid = emailRegex.test(fieldValue);
                        break;
                    case 'cpf':
                        // Valida o campo usando uma expressão regular específica para 'cpf'
                        isValid = cpfRegex.test(fieldValue);
                        break;
                    case 'telefone':
                        // Valida o campo usando uma expressão regular específica para 'telefone'
                        isValid = telefoneRegex.test(fieldValue);
                        break;
                    case 'password':
                        // Valida o campo usando uma expressão regular específica para 'password'
                        isValid = password.test(fieldValue);
                        break;
                    case 'confirmpassword':
                        // Valida o campo usando uma expressão regular específica para 'confirmpassword'
                        isValid = password.test(fieldValue);
                        break;
                        // Adicione mais casos para outros campos que precisam de validação usando expressões regulares
                    default:
                        break;
                }

                // Se o campo for válido
                if (isValid) {
                    // Remove a classe 'error' do próprio campo
                    $(this).removeClass('error');
                    // Remove a classe 'error' do elemento pai do campo que contém a classe 'input-group-text'
                    $(this).parent().find('.input-group-text').removeClass('error');
                } else { // Se o campo não for válido
                    // Adiciona a classe 'error' ao próprio campo
                    $(this).addClass('error');
                    // Adiciona a classe 'error' ao elemento pai do campo que contém a classe 'input-group-text'
                    $(this).parent().find('.input-group-text').addClass('error');
                }
            }
        });

        // Quando um checkbox obrigatório for clicado
        $('input[type="checkbox"][required]').on('click', function() {
            // Verifica se o checkbox foi marcado
            var isChecked = $(this).prop('checked');

            // Se não estiver marcado
            if (!isChecked) {
                // Adiciona a classe 'error-checkbox' ao checkbox
                $(this).addClass('error-checkbox');
                // Adiciona a classe 'error-checkbox' ao elemento pai do checkbox que contém a classe 'input-group-text'
                $(this).parent().find('.input-group-text').addClass('error-checkbox');
            } else { // Se estiver marcado
                // Remove a classe 'error-checkbox' do checkbox
                $(this).removeClass('error-checkbox');
                // Remove a classe 'error-checkbox' do elemento pai do checkbox que contém a classe 'input-group-text'
                $(this).parent().find('.input-group-text').removeClass('error-checkbox');
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

                // Verifica se há pelo menos uma letra maiúscula ou minúscula na senha
                if (senha.match(/^(?=.*[a-zA-Z]).+$/)) {
                    $('#password_r2').removeClass('text-danger');
                    $('#password_r2').addClass('text-success');
                } else {
                    $('#password_r2').removeClass('text-success');
                    $('#password_r2').addClass('text-danger');
                    senhaValid = false;
                }

                // Verifica se há pelo menos um caractere especial na senha
                if (senha.match(/^(?=.*[@#$%^&+=]).+$/)) {
                    $('#password_r4').removeClass('text-danger');
                    $('#password_r4').addClass('text-success');
                } else {
                    $('#password_r4').removeClass('text-success');
                    $('#password_r4').addClass('text-danger');
                    senhaValid = false;
                }

                // Verifica se há pelo menos um número na senha
                if (senha.match(/^(?=.*\d).+$/)) {
                    $('#password_r3').removeClass('text-danger');
                    $('#password_r3').addClass('text-success');
                } else {
                    $('#password_r3').removeClass('text-success');
                    $('#password_r3').addClass('text-danger');
                    senhaValid = false;
                }

                // Verifica se as três condições são satisfeitas e se a senha tem no mínimo 8 caracteres
                if (senha.match(/^(?=.*[a-zA-Z])(?=.*[@#$%^&+=])(?=.*\d).{8,}$/)) {
                    $('#password_r1').removeClass('text-danger');
                    $('#password_r1').addClass('text-success');
                    senhaValid = true;
                } else {
                    $('#password_r1').removeClass('text-success');
                    $('#password_r1').addClass('text-danger');
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
                // Adiciona a classe 'error' aos elementos de senha e confirmação de senha
                $('#password, #confirmpassword').addClass('error');
                // Adiciona a classe 'error' aos elementos irmãos da classe '.input-group-text'
                $('#password, #confirmpassword').parent().find('.input-group-text').addClass('error');
            } else {
                // Verifica se a senha é válida
                if (senhaValid) {
                    // Remove a classe 'error' dos elementos de senha e confirmação de senha
                    $('#password, #confirmpassword').removeClass('error');
                    // Remove a classe 'error' dos elementos irmãos da classe '.input-group-text'
                    $('#password, #confirmpassword').parent().find('.input-group-text').removeClass('error');
                } else {
                    // Adiciona a classe 'error' aos elementos de senha e confirmação de senha
                    $('#password, #confirmpassword').addClass('error');
                    // Adiciona a classe 'error' aos elementos irmãos da classe '.input-group-text'
                    $('#password, #confirmpassword').parent().find('.input-group-text').addClass('error');
                }
            }
        });


        $("#submitBtn").click(function(event) {
            // impede o envio do formulário
            event.preventDefault();

            // verifica se os campos estão preenchidos
            var formValid = true;

            $('input[required]').each(function() {

                // Obtém o valor do campo atual
                var fieldValue = $(this).val();

                // Variável para armazenar se o campo é válido ou não
                var isValid = true;

                // Obtém o nome do campo atual
                var fieldName = $(this).attr('name');

                // Verifica se o campo é do tipo checkbox
                if ($(this).is(':checkbox')) {

                    // Verifica se a caixa de seleção está marcada
                    if (!$(this).is(':checked')) {
                        // O formulário não é válido se o checkbox não estiver marcado
                        formValid = false;

                        // Adiciona a classe de erro ao campo checkbox
                        $(this).addClass('error-checkbox');

                        // Adiciona a classe de erro ao elemento .input-group-text relacionado
                        $(this).parent().find('.input-group-text').addClass('error-checkbox');
                    } else {
                        // Remove a classe de erro do campo checkbox se estiver marcado
                        $(this).removeClass('error-checkbox');

                        // Remove a classe de erro do elemento .input-group-text relacionado
                        $(this).parent().find('.input-group-text').removeClass('error-checkbox');
                    }
                } else if (fieldValue === '') {
                    // O formulário não é válido se o valor do campo estiver vazio

                    // Adiciona a classe de erro ao campo vazio
                    $(this).addClass('error');

                    // Adiciona a classe de erro ao elemento .input-group-text relacionado
                    $(this).parent().find('.input-group-text').addClass('error');

                    // Define que o campo não é válido
                    formValid = false;
                } else {
                    // Se o campo não for checkbox nem vazio, realiza a validação específica para cada campo

                    switch (fieldName) {
                        case 'razaosocial':
                            // Validação para o campo "razaosocial" usando a expressão regular razaosocialRegex
                            isValid = razaosocialRegex.test(fieldValue);
                            break;
                        case 'nomeadm':
                            // Validação para o campo "nomeadm" usando a expressão regular nomeadmRegex
                            isValid = nomeadmRegex.test(fieldValue);
                            break;
                        case 'cnpj':
                            // Validação para o campo "cnpj" usando a expressão regular cnpjRegex
                            isValid = cnpjRegex.test(fieldValue);
                            break;
                        case 'email':
                            // Validação para o campo "email" usando a expressão regular emailRegex
                            isValid = emailRegex.test(fieldValue);
                            break;
                        case 'cpf':
                            // Validação para o campo "cpf" usando a expressão regular cpfRegex
                            isValid = cpfRegex.test(fieldValue);
                            break;
                        case 'telefone':
                            // Validação para o campo "telefone" usando a expressão regular telefoneRegex
                            isValid = telefoneRegex.test(fieldValue);
                            break;
                        case 'password':
                            // Validação para o campo "password" usando a expressão regular password
                            isValid = password.test(fieldValue);
                            break;
                        case 'confirmpassword':
                            // Validação para o campo "confirmpassword" usando a expressão regular password
                            isValid = password.test(fieldValue);
                            break;
                            // Adicione mais casos para outros campos que precisam de validação regex

                        default:
                            break;
                    }

                    if (isValid) {
                        // Se o campo for válido, remove a classe de erro do campo e do elemento .input-group-text relacionado
                        $(this).removeClass('error');
                        $(this).parent().find('.input-group-text').removeClass('error');
                    } else {
                        // Se o campo não for válido, adiciona a classe de erro ao campo e ao elemento .input-group-text relacionado
                        $(this).addClass('error');
                        $(this).parent().find('.input-group-text').addClass('error');

                        // Define que o formulário não é válido
                        formValid = false;
                    }
                }

            });

            if (formValid) {
                // envia o formulário
                // Previne o comportamento padrão do formulário (recarregar a página)
                event.preventDefault();

                // Valor que define que o formulário foi submetido
                var btn_submit = 1;

                // Obtém os valores do formulário
                var dados_form = {

                    razaosocial: $("#razaosocial").val(),
                    cnpj: $("#cnpj").val(),
                    qtdcolaboradores: $("#qtdcolaboradores").val(),
                    nome: $("#nomeadm").val(),
                    cpf: $("#cpf").val(),
                    email: $("#email").val(),
                    telefone: $("#telefone").val(),
                    senha: $("#password").val(),
                    confirmsenha: $("#confirmpassword").val(),

                    // Array que contem as informações do usuario
                    informacoes: ua,

                    // Valor que valida o envio do formulário
                    btn_submit: btn_submit
                }

                // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                $.post('controller/createaccount_post.php', dados_form, function(retorno) {

                    // Switch case para tratar o retorno do servidor
                    switch (retorno) {
                        case "0":

                            // Caso as informações nao forem preenchidas
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Por favor, preencha todos os campos obrigatórios antes de prosseguir!'
                            });

                            break;

                        case "1":

                            // Retorno de sucesso
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                title: 'Sucesso!',
                                html: 'Obrigado por se cadastrar! Seu cadastro foi enviado para análise e está aguardando aprovação do sistema. Pedimos que aguarde enquanto verificamos as informações fornecidas. Assim que seu cadastro for aprovado, entraremos em contato. Agradecemos sua paciência e compreensão!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = "/admin/login";
                                }
                            });

                            break;

                        case "2":

                            // As senhas não se coincidem
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'A senha informada está incorreta. Por favor, verifique suas credenciais ou solicite a redefinição das senhas, se necessário!'
                            });

                            break;

                        case "3":

                            // Já existe um cadastro com as informações do CNPJ
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Desculpe, mas já existe um cadastro em nossa base de dados com o CNPJ informado. Por favor, verifique os dados fornecidos e tente novamente!'
                            });

                            break;

                        case "4":

                            // Já existe um cadastro com as informações do CPF
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Desculpe, mas já existe um cadastro em nossa base de dados com o CPF informado. Por favor, verifique os dados fornecidos e tente novamente!'
                            });

                            break;

                        case "5":

                            // Já existe um cadastro com as informações do E-MAIL
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Desculpe, mas já existe um cadastro em nossa base de dados com o E-MAIL informado. Por favor, verifique os dados fornecidos e tente novamente!'
                            });

                            break;

                        default:

                            // Caso o retorno seja o retorno de um TRY ou diferente de qualquer dos itens acima
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                title: 'Erro!',
                                text: 'Desculpe, ocorreu um erro durante a execução. Por favor, tente novamente mais tarde ou entre em contato com o suporte!'
                            });

                            break;
                    }

                }).fail(function() {

                    // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        title: 'Erro!',
                        text: 'Desculpe, ocorreu um erro durante a execução. Por favor, tente novamente mais tarde ou entre em contato com o suporte!'
                    });

                });

                console.log(dados_form);

            } else {

                // exibe mensagem de erro
                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    title: 'Atenção!',
                    text: 'Por favor, preencha todos os campos obrigatórios antes de prosseguir!'
                });
            }
        });
    });
</script>