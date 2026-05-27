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
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Incluir Eventos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once 'menu_lateral.php';

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once 'barra_superior.php';

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Incluir evento</h6>
                        </div>
                        <div class="card-body">

                            <!-- FORM -->
                            <form class="needs-validation" novalidate action="incluir_eventos.php" method="POST">
                                <!-- COL-MD-12 -->
                                <div class="col-md-12">

                                    <div class="form-row">
                                        <div class="col-md-2 mb-3">
                                            <label for="codevento">Cód. Evento</label>
                                            <input type="text" class="form-control" id="codevento" name="codevento" minlength="1" required>
                                            <div class="invalid-feedback">
                                                Inválido!
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" required>
                                            <div class="invalid-feedback">
                                                Inválido! Min. 3 caracteres!
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="tipoevento">Tipo Evento</label>
                                            <select class="form-control" id="tipoevento" name="tipoevento" required>
                                                <option value="">Escolha o tipo do evento</option>
                                                <option value="D">Desconto</option>
                                                <option value="V">Vencimento</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Inválido!
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="usaref">Utiliza Referência?</label>
                                            <select class="form-control" id="usaref" name="usaref">
                                                <option value="">Escolha</option>
                                                <option value="S">Sim</option>
                                                <option value="N">Não</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Inválido!
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BOTÃO ENVIAR -->
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            <button type="button" id="btn-voltar" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div>
                                    </div>
                                    <!-- FIM BOTÃO ENVIAR -->

                                </div>
                                <!-- FIM COL-MD-12 -->
                            </form>
                            <!-- FIM FORM -->

                        </div>
                    </div>

                </div>
            </div>

            <?php

            include_once "footer.php";

            ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

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
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atenção!',
                            text: 'Preencha os campos requeridos em todas as abas!'
                        })
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // AÇÃO BOTÃO VOLTAR
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            // DIRECIOINA PARA A PÁGINA CADASTRO EVENTOS
            location.href = "cadastro_eventos";
        });
    });
</script>

<?php

if (isset($_REQUEST["btn-submit"])) {

    try {

        $codevento = $_POST["codevento"];
        $nome = $_POST["nome"];
        $nome = mb_strtoupper($nome, 'UTF-8');
        $tipoevento = $_POST["tipoevento"];
        $usaref = $_POST["usaref"];

        insertGESEVE($codevento, $nome, $id_emp_default, $tipoevento, $usaref, $datinc, $datatu, $id_usa_default, $id_usa_default);

        echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Evento incluído com sucesso!',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'cadastro_eventos';
                }
            })
            </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>