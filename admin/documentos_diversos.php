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

    <title>GESTOU PORTAL - Documentos Diversos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- the fileinput plugin styling CSS file -->
    <link href="vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdfeimg.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/locales/LANG.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
                <?php include_once 'barra_superior.php'; ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">

                        <!-- CARD HEADER -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Documentos Diversos</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <div class="col-md-12">

                                <form id="form-recibo" enctype="multipart/form-data">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="descricao" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Reembolso, Devolução valor.">Descrição
                                                <i class="fas fa-info-circle"></i>
                                            </label>
                                            <input type="text" class="form-control" id="descricao" name="descricao" style="text-transform: uppercase;" placeholder="Insira uma descrição..." minlength="3" required></input>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="funcionario" class="mt-sm-3">Funcionário</label>
                                            <select id="funcionario" name="funcionario" class="form-control" required>
                                                <option value="" disabled selected>Escolha um funcionário</option>

                                                <?php foreach (selectGESUSU_usuario($id_emp_default) as $usuario_banco) { ?>

                                                    <option value="<?php echo $usuario_banco["id_usu"]; ?>"><?php echo $usuario_banco["nome"]; ?></option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="row mt-sm-2">
                                                <label for="file">Arquivo</label>
                                                <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <!-- <sup class="textalign-right mt-sm-4">Proporção 4:3 (800 x 600px)</sup> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-upload"></i> Enviar
                                            </button>
                                            <a href="importacao">
                                                <button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar importação" class="btn btn-organograma btn-icon-split-organograma">
                                                    <i class="fas fa-sign-out-alt"></i> Voltar
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                        <!-- FIM CARD BODY -->

                    </div>
                    <!-- FIM CARD SHADOW -->

                </div>
                <!-- FIM PAGE CONTENT -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once 'footer.php'; ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->


    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>


    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script> -->

</body>

</html>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    // SUBMIT INCLUIR AVISO
    $(function() {
        $('#form-recibo').submit(function(e) {
            e.preventDefault(); // impede o envio do formulário por padrão

            var btn_submit = 1;

            if (btn_submit !== '') {

                // cria um objeto FormData com os valores do formulário
                var formData = new FormData(this);
                formData.append('btn_submit', btn_submit);

                $.post({
                    url: 'controller/documentos_diversos_post.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        if (retorno == 1) {

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Informação incluida com Sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'lotes_processados';
                                }
                            });

                            // Se o retorno for igual a 1, faltou preencher algum dado corretamente
                        } else if (retorno == 0) {

                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'Preencha todos os campos para efetuar a ação!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });

                            // Se o retorno for igual a 2, arquivo grande demais
                        } else if (retorno == 2) {

                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'O arquivo anexado é maior que o limite de 10MB!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });

                            // Caso contrario, houve erro no try, retorna o erro no catch
                        } else {

                            // Exibe uma mensagem de falha
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
                    }
                });

            }
        });
    });
</script>