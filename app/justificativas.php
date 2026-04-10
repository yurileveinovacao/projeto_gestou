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
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - Justificativas</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.css" rel="stylesheet">
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "menu_superior.php"; ?>

                <!-- INICIO CONTEINER FLUIR-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Justificativas</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3">

                        <div class="ml-auto" style=" padding-right: 0.75em; margin-top: -20px">
                            <button class="btn btn-brave" id="incluir-justificativa">
                                <i class="fas fa-plus"></i>
                            </button>

                            <button id="btnExibeOcultaDiv" class="btn btn-brave ml-1">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                    </div>

                    <!-- FILTRO-->
                    <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none" id="dvPrincipal">

                        <div class="form-group">
                            <label>Situação:</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio1" name="radio" value="pendente" data-cad="pendente" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio1">Pendente</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio2" name="radio" value="aprovada" data-cad="aprovada" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio2">Aprovada</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio3" name="radio" value="reprovada" data-cad="reprovada" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio3">Reprovada</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radio4" name="radio" value="todos" data-cad="todos" class="btn1 custom-control-input">
                                <label class="custom-control-label" for="radio4">Todos</label>
                            </div>

                        </div>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3 cursos">

                        <?php

                        $justificativas = selectJustificativas_colaborador($id_usu_default, $raiz_cnpj);

                        if (count($justificativas) > 0) {

                            foreach ($justificativas as $just) {

                                $id_just = $just['id'];
                                $tipo_raw = $just['tipo'];
                                $status = $just['status'];
                                $data_oc = new DateTime($just['data_ocorrencia']);
                                $hora_oc = $just['hora_ocorrencia'];
                                $mensagem = $just['mensagem'];
                                $arquivo = $just['arquivo_path'];
                                $resposta = $just['resposta_admin'];

                                $tipos = array(
                                    'ausencia_ponto' => 'Ausência de Ponto',
                                    'falta' => 'Falta',
                                    'falta_atestado' => 'Falta com Atestado'
                                );
                                $tipo_formatado = isset($tipos[$tipo_raw]) ? $tipos[$tipo_raw] : $tipo_raw;

                                if ($status == 'pendente') { ?>

                                    <div class="col-xl-3 col-md-6 mb-4 curso pendente">
                                        <div class="card h-100 card-justificativa" id-just="<?php echo $id_just; ?>" tipo="<?php echo htmlspecialchars($tipo_formatado); ?>" data-oc="<?php echo $data_oc->format('d/m/Y'); ?>" hora-oc="<?php echo htmlspecialchars($hora_oc); ?>" mensagem="<?php echo htmlspecialchars($mensagem); ?>" arquivo="<?php echo htmlspecialchars($arquivo); ?>" resposta="" style="cursor: pointer">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $tipo_formatado; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_oc->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-warning btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">PENDENTE</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } elseif ($status == 'aprovada') { ?>

                                    <div class="col-xl-3 col-md-6 mb-4 curso aprovada">
                                        <div class="card h-100 card-justificativa" id-just="<?php echo $id_just; ?>" tipo="<?php echo htmlspecialchars($tipo_formatado); ?>" data-oc="<?php echo $data_oc->format('d/m/Y'); ?>" hora-oc="<?php echo htmlspecialchars($hora_oc); ?>" mensagem="<?php echo htmlspecialchars($mensagem); ?>" arquivo="<?php echo htmlspecialchars($arquivo); ?>" resposta="<?php echo htmlspecialchars($resposta); ?>" style="cursor: pointer">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $tipo_formatado; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_oc->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-success btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">APROVADA</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } elseif ($status == 'reprovada') { ?>

                                    <div class="col-xl-3 col-md-6 mb-4 curso reprovada">
                                        <div class="card h-100 card-justificativa" id-just="<?php echo $id_just; ?>" tipo="<?php echo htmlspecialchars($tipo_formatado); ?>" data-oc="<?php echo $data_oc->format('d/m/Y'); ?>" hora-oc="<?php echo htmlspecialchars($hora_oc); ?>" mensagem="<?php echo htmlspecialchars($mensagem); ?>" arquivo="<?php echo htmlspecialchars($arquivo); ?>" resposta="<?php echo htmlspecialchars($resposta); ?>" style="cursor: pointer">
                                            <div class="card-body">
                                                <div class="row align-items-center text-align-center" style="text-align: center;">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800 mb-1">
                                                            <?php echo $tipo_formatado; ?>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <span class="mr-2">
                                                                <?php echo $data_oc->format("d/m/Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            <div class="btn btn-danger btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="far fa-times-circle"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">REPROVADA</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }

                            }

                        } else { ?>

                            <div class="m-auto">
                                <p class="text-center text-gray-500 mt-4">Nenhuma justificativa encontrada.</p>
                            </div>

                        <?php } ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM CONTEINER FLUIR-->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once "footer.php"; ?>

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

<!-- MODAL DETALHES -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="Detalhes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes da Justificativa</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-detalhes-body">
                <!-- PREENCHIDO PELO JS -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // FILTRO TOGGLE
    $("#btnExibeOcultaDiv").click(function(e) {
        e.preventDefault();
        $("#dvPrincipal").toggle();
    });

    // FILTRO POR STATUS
    $('.btn1').on('click', function() {
        var cat = $(this).attr('data-cad');
        if (cat == 'todos') {
            $('.cursos div').show();
        } else {
            $('.curso').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }
    });

    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {
            location.href = 'fale_rh';
        });
    });

    // BTN INCLUIR JUSTIFICATIVA
    $(function() {
        $(document).on('click', '#incluir-justificativa', function() {
            location.href = 'justificativa_incluir';
        });
    });

    // CLICK NOS CARDS - MODAL DETALHES
    $(function() {
        $(document).on('click', '.card-justificativa', function() {
            var tipo = $(this).attr('tipo');
            var dataOc = $(this).attr('data-oc');
            var horaOc = $(this).attr('hora-oc');
            var mensagem = $(this).attr('mensagem');
            var arquivo = $(this).attr('arquivo');
            var resposta = $(this).attr('resposta');

            var html = '';
            html += '<div class="form-row mb-2">';
            html += '<div class="col-md-6"><strong>Tipo:</strong> ' + tipo + '</div>';
            html += '<div class="col-md-6"><strong>Data:</strong> ' + dataOc + '</div>';
            html += '</div>';

            if (horaOc && horaOc !== '') {
                html += '<div class="form-row mb-2">';
                html += '<div class="col-md-12"><strong>Hora:</strong> ' + horaOc + '</div>';
                html += '</div>';
            }

            if (mensagem && mensagem !== '') {
                html += '<div class="form-row mb-2">';
                html += '<div class="col-md-12"><strong>Mensagem:</strong><br>' + mensagem + '</div>';
                html += '</div>';
            }

            if (arquivo && arquivo !== '') {
                html += '<div class="form-row mb-2">';
                html += '<div class="col-md-12"><strong>Anexo:</strong> <a href="../upload/' + arquivo + '" target="_blank" class="btn btn-sm btn-outline-primary">Ver anexo</a></div>';
                html += '</div>';
            }

            if (resposta && resposta !== '') {
                html += '<hr>';
                html += '<div class="form-row mb-2">';
                html += '<div class="col-md-12"><strong>Resposta do RH:</strong><br>' + resposta + '</div>';
                html += '</div>';
            }

            $('#modal-detalhes-body').html(html);
            $('#modal-detalhes').modal('show');
        });
    });
</script>
