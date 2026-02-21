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

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Editar Controle de férias</h6>
                        </div>
                        <div class="card-body">

                            <?php

                            // Atribuição do ID_FER em sessão para variável em página
                            $id_fer_edit = $_SESSION["editar_controle_ferias"];

                            // Select na GESFER para carregar os dados referentes ao colaborador
                            foreach (selectGESFER_id_fer($id_fer_edit) as $dados) {

                                // Verifica se o array $dados está preenchido
                                if (!empty($dados)) {

                                    // Atribuição das váriaveis referentes a linha
                                    $id_fer = $dados["id_fer"];
                                    $colaborador = $dados["colaborador"];
                                    $iniaqu = $dados["iniaqu"];
                                    $fimaqu = $dados["fimaqu"];
                                    $datini = $dados["datini"];
                                    $datfim = $dados["datfim"];
                                    $datlmt = $dados["datlmt"];
                                }
                            }

                            ?>

                            <form id="modal-form-editar" class="needs-validation" id_fer="<?php echo $id_fer; ?>" novalidate>

                                <div class="col-md-12 mb-3">

                                    <div class="form-row">

                                        <div class="col-md-12">

                                            <label for="inputColaborador" class="mt-sm-3">Colaborador</label>
                                            <input type="text" class="form-control" id="inputColaborador" name="inputColaborador" required disabled readonly><?php echo $colaborador; ?></input>

                                        </div>

                                    </div>

                                    <div class="form-row justify-content-between">

                                        <div class="col-md-2">
                                            <label for="inputIniaqu" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do início do período aquisitivo">Início Aquisitivo <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputIniaqu" name="inputIniaqu" required disabled readonly><?php echo $iniaqu; ?></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputFimaqu" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do fim do período aquisitivo">Fim Aquisitivo <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputFimaqu" name="inputFimaqu" required disabled readonly><?php echo $fimaqu; ?></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatini" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do início das férias">Início Férias <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatini" name="inputDatini" required><?php echo $datini; ?></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatfim" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do fim das férias">Fim Férias <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatfim" name="inputDatfim" required><?php echo $datfim; ?></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatlmt" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data limite para o aviso de férias">Data Limite <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatlmt" name="inputDatlmt" required disabled readonly><?php echo $datlmt; ?></input>
                                        </div>

                                    </div>

                                </div>

                                <!-- INÍCIO BOTÃO ENVIAR -->
                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="submit" name="btn-editar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>
                                </div>
                                <!-- FIM BOTÃO ENVIAR -->
                            </form>

                        </div>
                        <!-- </form> -->
                    </div>

                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------------------->
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
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

            <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

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
                        // alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(document).ready(function() {
  // Verifica se o navegador suporta a API de geolocalização
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      // Faça algo com a latitude e longitude
      console.log("Latitude: " + latitude);
      console.log("Longitude: " + longitude);
    });
  } else {
    console.log("Geolocalização não suportada pelo navegador.");
  }
});

    $(document).ready(function() {

        $('#inputIniaqu').mask('00/00/0000');
        $('#inputFimaqu').mask('00/00/0000');
        $('#inputDatini').mask('00/00/0000');
        $('#inputDatfim').mask('00/00/0000');
        $('#inputDatlmt').mask('00/00/0000');

    });
</script>

<script>
    // SUBMIT INCLUIR
    $(function() {
        $("#modal-form-editar").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_salvar = 1;
            var id_fer = $('#modal-form-editar').attr("id_fer");

            if (btn_salvar !== '') {

                var dados = {

                    id_fer: id_fer,
                    // iniaqu: $('#inputIniaqu').val(),
                    // fimaqu: $('#inputFimaqu').val(),
                    datini: $('#inputDatini').val(),
                    datfim: $('#inputDatfim').val(),
                    // datlmt: $('#inputDatlmt').val(),

                    // Valida o Submit
                    btn_salvar: btn_salvar
                };

                // $.post('controller/controle_ferias_post.php', dados, function(retorno) {

                // });

            }

        });
    });

    // Realiza o POST do voltar ferias no clique do botão voltar
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            var btn_voltar = 1;

            //verificar se há valor nas variaveis
            if (btn_voltar !== '') {
                var dados = {
                    btn_voltar: btn_voltar
                };

                // $.post('controller/controle_ferias_post.php', dados, function(retorna) {

                //     location.href = "controle_ferias_editar";
                // });
            }
        });
    });
</script>