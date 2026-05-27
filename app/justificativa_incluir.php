<?php

//Faz a requisição da Sessão
require 'restrito.php';
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
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Gestou - Nova Justificativa</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
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

                            <li class="breadcrumb-item active h4" aria-current="page">Nova Justificativa</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <div class="card shadow mb-2 width-100">
                            <div class="d-block card-header py-3 collapsed">
                                <form id="form-justificativa" enctype="multipart/form-data">
                                    <div class="col-md-12">

                                        <!-- TIPO -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA JUSTIFICATIVA</label>
                                                <select id="tipo" name="tipo" class="form-control" required>
                                                    <option value="" disabled selected>Escolha uma opção</option>
                                                    <option value="ausencia_ponto">Ausência de batida de ponto</option>
                                                    <option value="falta">Falta</option>
                                                    <option value="falta_atestado">Falta com atestado</option>
                                                    <option value="atraso">Atraso</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- DATA OCORRENCIA -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="data_ocorrencia" class="mt-sm-3 mb-2 font-weight-bold">DATA DA OCORRÊNCIA</label>
                                                <input type="date" class="form-control" id="data_ocorrencia" name="data_ocorrencia" required>
                                            </div>
                                        </div>

                                        <!-- HORA OCORRENCIA (só para ausencia_ponto) -->
                                        <div class="form-row" id="campo-hora" style="display: none;">
                                            <div class="form-group col-md-12">
                                                <label for="hora_ocorrencia" class="mt-sm-3 mb-2 font-weight-bold">HORA DA OCORRÊNCIA</label>
                                                <input type="time" class="form-control" id="hora_ocorrencia" name="hora_ocorrencia">
                                            </div>
                                        </div>

                                        <!-- MENSAGEM (para falta e falta_atestado) -->
                                        <div class="form-row" id="campo-mensagem" style="display: none;">
                                            <div class="form-group col-md-12">
                                                <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                                                <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000"></textarea>
                                            </div>
                                        </div>

                                        <!-- ANEXO (obrigatório para falta_atestado, opcional para atraso) -->
                                        <div class="form-row" id="campo-anexo" style="display: none;">
                                            <div class="form-group col-md-12">
                                                <label for="arquivo" class="mt-sm-3 mb-2 font-weight-bold">
                                                    <span id="label-anexo">ATESTADO (ANEXO)</span>
                                                </label>
                                                <input type="file" class="form-control" id="arquivo" name="arquivo" accept=".pdf,.png,.jpg,.jpeg">
                                            </div>
                                        </div>

                                        <!-- ENVIAR -->
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-brave btn-icon-split-brave width-100 mt-sm-3">
                                                    <span class="font-weight-bold">ENVIAR</span>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<!-- AÇÕES -->
<script>
    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {
            location.href = 'justificativas';
        });
    });

    // SHOW/HIDE CAMPOS CONFORME TIPO
    $(function() {
        $('#tipo').on('change', function() {
            var tipo = $(this).val();

            $('#campo-hora').hide();
            $('#campo-mensagem').hide();
            $('#campo-anexo').hide();

            if (tipo == 'ausencia_ponto') {
                $('#campo-hora').show();
            } else if (tipo == 'falta') {
                $('#campo-mensagem').show();
            } else if (tipo == 'falta_atestado') {
                $('#campo-mensagem').show();
                $('#campo-anexo').show();
                $('#label-anexo').text('ATESTADO (ANEXO)');
            } else if (tipo == 'atraso') {
                $('#campo-hora').show();
                $('#campo-mensagem').show();
                $('#campo-anexo').show();
                $('#label-anexo').text('COMPROVANTE (OPCIONAL)');
            }
        });
    });

    // SUBMIT
    $(function() {
        $('#form-justificativa').submit(function(e) {

            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja enviar esta justificativa?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, enviar!',
                cancelButtonText: 'Não!'
            }).then((result) => {

                if (result.isConfirmed) {

                    var formData = new FormData(document.getElementById('form-justificativa'));
                    formData.append('submit_justificativa', 1);

                    $.ajax({
                        url: 'controller/justificativa_incluir_post.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(retorno) {

                            switch (retorno) {

                                case '0':
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Atenção!',
                                        text: 'Preencha todos os campos obrigatórios!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close();
                                        }
                                    });
                                    break;

                                case '1':
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Justificativa enviada!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.href = 'justificativas';
                                        }
                                    });
                                    break;

                                case '2':
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Atenção!',
                                        text: 'Extensão de arquivo inválida! Use PDF, PNG, JPG ou JPEG.',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close();
                                        }
                                    });
                                    break;

                                case '3':
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
                                    break;

                                case '4':
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: 'Erro ao fazer upload do arquivo.',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close();
                                        }
                                    });
                                    break;

                                case '5':
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Atenção!',
                                        text: 'O atestado é obrigatório para este tipo de justificativa!',
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
                        }
                    });
                }

            });
        });
    });
</script>
