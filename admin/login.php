<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image text-align-center">
                                <br>
                                <img src="../img/logo_gestou.png" height="300"></img><br>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Admin Login!</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Usuário" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="senha" class="form-control form-control-user" id="senha" placeholder="Senha" required>
                                        </div>
                                        <button type="submit" id="submitBtn" name="logar" class="btn btn-brave btn-user btn-block">
                                            <h6 class="mb-0"><span class="fonte-texto-gestou">ENTRAR</span></h6>
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="esqueci_senha.php">Esqueceu sua senha?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $("#submitBtn").click(function(event) {
            // impede o envio do formulário
            event.preventDefault();

            // verifica se os campos estão preenchidos
            var formValid = true;

            var formValid = true;
            $('input[required]').each(function() {
                var fieldValue = $(this).val();
                var isValid = true;

                if (fieldValue === '') {
                    formValid = false;
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

                    // Valor que valida o envio do formulário
                    btn_submit: btn_submit,

                    email: $("#email").val(),
                    senha: $("#senha").val()

                }

                console.log(dados_form);

                // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                $.post('controller/login_post.php', dados_form, function(retorno) {

                    switch (retorno) {
                        case "0":

                            // Email inválido ou informção não preenchida
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Por favor, preencha os campos de usuário e senha para prosseguir!'
                            });

                            break;

                        case "1":

                            // Retorno de sucesso
                            location.href = "https://www.gestou.com.br/admin/index";

                            break;

                        case "2":

                            // Usuário inativo
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'O usuário informado está inativo ou não existe. Por favor, verifique suas credenciais ou entre em contato com o suporte!'
                            });

                            break;

                        case "3":

                            // Senha incorreta
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'A senha informada está incorreta. Por favor, verifique suas credenciais ou solicite a redefinição das senhas, se necessário!'
                            });

                            break;

                        case "4":

                            // Altere a sua senha para realizar o login
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                title: 'Sucesso!',
                                html: 'Por favor, altere sua senha para prosseguir com o login!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = "https://www.gestou.com.br/admin/esqueci_senha";
                                }
                            });

                            break;

                        case "5":

                            // Usuário em análise
                            Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'O usuário fornecido está passando por uma verificação e será liberado em breve!'
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

            } else {

                // exibe mensagem de erro
                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    title: 'Atenção!',
                    text: 'Por favor, preencha os campos de usuário e senha para prosseguir!'
                });
            }

        });
    });
</script>