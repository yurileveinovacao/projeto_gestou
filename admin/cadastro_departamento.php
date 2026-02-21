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

    <title>GESTOU PORTAL - Cadastrar Departamento</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top" onload="return check_form()">

    <!-- INICIO PAGE WRAPPER -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">

                        <!-- CARD HEADER -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastro Departamento</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-geral-tab" data-toggle="tab" href="#menu-geral" role="tab" aria-controls="menu-geral" aria-selected="true">Geral</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" novalidate>

                                <!-- INICIO COL-MD-12 -->
                                <div class="col-md-12">

                                    <!-- INICIO TAB CONTENT -->
                                    <div class="tab-content" id="nav-tabContent">

                                        <!-- INÍCIO MENU GERAL -->
                                        <div class="tab-pane fade show active" id="menu-geral" role="tabpanel" aria-labelledby="menu-geral-tab">

                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" maxlength="255" value="<?php echo $dep["nome"]; ?>" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU GERAL -->

                                    </div>
                                    <!-- FIM TAB CONTENT -->

                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button>
                                            <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div>
                                    </div>
                                    <!-- FIM BOTÃO ENVIAR -->

                                </div>
                                <!-- FIM COL-MD-12 -->

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
        <!-- INICIO CONTENT WRAPPER -->

    </div>
    <!-- FIM PAGE WRAPPER -->


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
</script>

<!-- AÇÕES NO CLICK -->
<script>
    // BOTÃO VOLTAR
    $(function() {
        $(document).on('click', '#btn-voltar', function() {

            // Direciona para a pagina Tabela Departamento
            location.href = "tabela_departamento";
        });
    });

    // BOTÃO SALVAR
    $(function() {
        $("#form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            // Se o usuario realmente quiser excluir o contato
            if (confirm('Tem certeza que deseja salvar esse departamento?')) {

                // Valor que define que o formulário foi submetido
                var btn_submit = 1;

                // Obtém os valores do formulário
                var dados_form = {
                    // Valor do formulario
                    nome_update: $('#nome').val(),

                    // Valor que valida o envio do formulário
                    btn_submit: btn_submit
                };

                $.post('controller/cadastro_departamento_post.php', dados_form, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Departamento incluido com sucesso!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'tabela_departamento';
                            }
                        });

                        // Se o retorno for igual a 0, os dados não foram preenchidos corretamente
                    } else if (retorno == 0) {

                        // Exibe uma mensagem de falha
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

                        // Caso não for 0/1 houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
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
                        });
                    }
                });

            } else {

                return false;
            }
        });
    });
</script>