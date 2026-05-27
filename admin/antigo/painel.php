<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util2.php";

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

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="vendor/kartik-v/bootstrap-fileinput/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <!-- <link href="vendor/kartik-v/bootstrap-fileinput/css/mural_fileinput.min.css" media="all" rel="stylesheet" type="text/css" /> -->
    <link href="vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

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
    <script src="vendor/kartik-v/bootstrap-fileinput/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdfeimg.min.js"></script>
    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

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

                <!-- INICIO CONTEINER FLUID -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Painel</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <?php foreach (selectANIVERSARIOS_count($id_emp_default) as $linha) {

                            $count_aniver = $linha['aniversariantes'];
                        } ?>

                        <!-- ANIVERSÁRIO DO MES -->
                        <div class="col-xl-3 col-md-6 mb-4 cursor-pointer" id="card-aniver" num-aniver="<?php echo $count_aniver; ?>">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Aniversáriantes do Mês</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_aniver; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-birthday-cake fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php foreach (selectGESUSU_ativos($id_emp_default) as $linha2) {

                            $count_colab = $linha2['conta'];
                        } ?>
                        <!-- COLABORADORES ATIVOS -->
                        <div class="col-xl-3 col-md-6 mb-4 cursor-pointer" id="card-colab">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Funcionários Ativos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_colab; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php foreach (selectVW_GESSOB($id_emp_default) as $linha3) {

                            if ($linha3['missao'] == 1 && $linha3['visao'] == 1 && $linha3['valores'] == 1) {

                                $missao_visao_valores = 1;
                            } else {

                                $missao_visao_valores = 0;
                            }

                            $dados_empresa = [$linha3['sobre'], $missao_visao_valores, $linha3['politica'], $linha3['organograma']];

                            $count_dados_preenchidos = array_sum($dados_empresa);

                            $porcentagem_dados_preenchidos = intval(($count_dados_preenchidos * 100) / 4);
                        } ?>

                        <!-- DADOS EMPRESA PREENCHIDOS -->
                        <div class="col-xl-3 col-md-6 mb-4 cursor-pointer" id="abrir-modal-dados">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dados Preenchidos
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $porcentagem_dados_preenchidos . '%'; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <?php if ($porcentagem_dados_preenchidos >= 75) { ?>

                                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentagem_dados_preenchidos . '%'; ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } else if ($porcentagem_dados_preenchidos > 25) { ?>

                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $porcentagem_dados_preenchidos . '%'; ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } else { ?>

                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $porcentagem_dados_preenchidos . '%'; ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php foreach (selectGESSOL_pendentes($id_emp_default) as $linha4) {

                            $count_sol_pendente = $linha4['conta_pendente'];
                            $count_sol_tudo = $linha4['conta_tudo'];

                            if ($count_sol_tudo > 0) {

                                $porcentagem_pendente = intval((($count_sol_tudo - $count_sol_pendente) * 100) / $count_sol_tudo);
                            } else {

                                $porcentagem_pendente = 100;
                            }
                        } ?>

                        <!-- SOLICITAÇÕES PENDENTES -->
                        <div class="col-xl-3 col-md-6 mb-4 cursor-pointer" id="card-solicitacao">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Solicitações Respondidas</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $porcentagem_pendente . '%' ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <?php if ($porcentagem_pendente >= 75) { ?>

                                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentagem_pendente . '%' ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } else if ($porcentagem_pendente > 25) { ?>

                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $porcentagem_pendente . '%' ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } else { ?>

                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $porcentagem_pendente . '%' ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- GRAFICO -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                                <!-- HEADER -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Documentos</h6>
                                </div>

                                <!-- BODY -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php foreach (selectGESEMP_modelos($id_emp_default) as $linha5) {


                            $layout = $linha5['layout'];
                            $layout_ponto = $linha5['layout_ponto'];
                            $layout_irrf = $linha5['layout_irrf'];
                            $modelo_layout = $linha5['modelo_layout'];
                            $modelo_layout_ponto = $linha5['modelo_layout_ponto'];
                            $modelo_layout_irrf = $linha5['modelo_layout_irrf'];
                        } ?>

                        <!-- ENVIO DE DOCUMENTOS -->
                        <div class="col-xl-4 col-lg-5 mb-4 d-flex flex-column" style="height: 415px;">

                            <!-- HOLERITE -->
                            <div class="card shadow mb-2 d-flex align-items-stretch" id="card-holerite" layout="<?php echo $layout; ?>" modelo="<?php echo $modelo_layout; ?>" style="flex: 1;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="h-100 w-100 d-flex flex-row align-items-center">
                                        <i id="icone-holerite"></i>
                                        <h7 class="ml-2 m-0 font-weight-bold text-primary">Holerite</h7>
                                        <button id="btn-importar-holerite" class="btn btn-primary btn-icon-split ml-auto btn-importar" hidden>
                                            <span class="text">Importar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <!-- ESPELHO DE PONTOS -->
                            <div class="card shadow mb-2 d-flex align-items-stretch" id="card-ponto" layout="<?php echo $layout_ponto; ?>" modelo="<?php echo $modelo_layout_ponto; ?>" style="flex: 1;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="h-100 w-100 d-flex flex-row align-items-center">
                                        <i id="icone-ponto"></i>
                                        <h7 class="ml-2 m-0 font-weight-bold text-primary">Espelho de Pontos</h7>
                                        <button id="btn-importar-ponto" class="btn btn-primary btn-icon-split ml-auto btn-importar" hidden>
                                            <span class="text">Importar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- INFORME DE RENDIMENTO -->
                            <div class="card shadow mb-2 d-flex align-items-stretch" id="card-irrf" layout="<?php echo $layout_irrf; ?>" modelo="<?php echo $modelo_layout_irrf; ?>" style="flex: 1;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="h-100 w-100 d-flex flex-row align-items-center">
                                        <i id="icone-irrf"></i>
                                        <h7 class="ml-2 m-0 font-weight-bold text-primary">Informe de Rendimento</h7>
                                        <button id="btn-importar-irrf" class="btn btn-primary btn-icon-split ml-auto btn-importar" hidden>
                                            <span class="text">Importar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- DOCUMENTOS DIVERSOS -->
                            <div class="card shadow d-flex align-items-stretch border-left-success" style="flex: 1;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="h-100 w-100 d-flex flex-row align-items-center">
                                        <i class="fas fa-check text-success" title="Aprovado"></i>
                                        <h7 class="ml-2 m-0 font-weight-bold text-primary">Documentos Diversos</h7>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <!-- <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Dados Empresariais</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                        </div> -->

                        <div class="col-lg-12 mb-4">

                            <?php foreach (selectPAINELRH($id_emp_default, 'N') as $linha6) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'N'
                                $notificacao_visu = $linha6['ocorrencias_situac_1'];
                                $notificacao_total = $linha6['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($notificacao_total > 0) {

                                    $notificacao_visu_porcento = intval(($notificacao_visu * 100) / $notificacao_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $notificacao_visu_porcento = 100;
                                }
                            }

                            foreach (selectPAINELRH($id_emp_default, 'M') as $linha7) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'M'
                                $mural_visu = $linha7['ocorrencias_situac_1'];
                                $mural_total = $linha7['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($mural_total > 0) {

                                    $mural_visu_porcento = intval(($mural_visu * 100) / $mural_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $mural_visu_porcento = 100;
                                }
                            }

                            foreach (selectPAINELRH($id_emp_default, 'F') as $linha8) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'F'
                                $feedback_visu = $linha8['ocorrencias_situac_1'];
                                $feedback_total = $linha8['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($feedback_total > 0) {

                                    $feedback_visu_porcento = intval(($feedback_visu * 100) / $feedback_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $feedback_visu_porcento = 100;
                                }
                            }

                            foreach (selectPAINELRH($id_emp_default, 'T') as $linha9) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'T'
                                $treinamento_visu = $linha9['ocorrencias_situac_1'];
                                $treinamento_total = $linha9['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($treinamento_total > 0) {

                                    $treinamento_visu_porcento = intval(($treinamento_visu * 100) / $treinamento_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $treinamento_visu_porcento = 100;
                                }
                            } ?>


                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <!-- Título do painel -->
                                    <h6 class="m-0 font-weight-bold text-primary">Visualizados Painel RH</h6>
                                </div>
                                <div class="card-body">
                                    <div class="abrir-modal-colab cursor-pointer" tipo="N">
                                        <!-- Título e porcentagem de "Fale com os Colaboradores" -->
                                        <h4 class="small font-weight-bold">Fale com os Colaboradores <span class="float-right"><?php echo $notificacao_visu_porcento . '%'; ?></span></h4>
                                        <!-- Barra de progresso -->
                                        <div class="progress mb-4">
                                            <?php if ($notificacao_visu_porcento >= 75) { ?>
                                                <!-- Barra de progresso verde se a porcentagem for maior ou igual a 75% -->
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $notificacao_visu_porcento . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else if ($notificacao_visu_porcento >= 25) { ?>
                                                <!-- Barra de progresso amarela se a porcentagem estiver entre 25% e 75% -->
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $notificacao_visu_porcento . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else { ?>
                                                <!-- Barra de progresso vermelha se a porcentagem for menor que 25% -->
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $notificacao_visu_porcento . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="abrir-modal-colab cursor-pointer" tipo="M">
                                        <!-- Título e porcentagem de "Mural de Avisos" -->
                                        <h4 class="small font-weight-bold">Mural de Avisos <span class="float-right"><?php echo $mural_visu_porcento . '%'; ?></span></h4>
                                        <!-- Barra de progresso -->
                                        <div class="progress mb-4">
                                            <?php if ($mural_visu_porcento >= 75) { ?>
                                                <!-- Barra de progresso verde se a porcentagem for maior ou igual a 75% -->
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $mural_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else if ($mural_visu_porcento >= 25) { ?>
                                                <!-- Barra de progresso amarela se a porcentagem estiver entre 25% e 75% -->
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $mural_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else { ?>
                                                <!-- Barra de progresso vermelha se a porcentagem for menor que 25% -->
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $mural_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="abrir-modal-colab cursor-pointer" tipo="F">
                                        <!-- Título e porcentagem de "Feedback e Sugestões" -->
                                        <h4 class="small font-weight-bold">Feedback e Sugestões <span class="float-right"><?php echo $feedback_visu_porcento . '%'; ?></span></h4>
                                        <!-- Barra de progresso -->
                                        <div class="progress mb-4">
                                            <?php if ($feedback_visu_porcento >= 75) { ?>
                                                <!-- Barra de progresso verde se a porcentagem for maior ou igual a 75% -->
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $feedback_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else if ($feedback_visu_porcento >= 25) { ?>
                                                <!-- Barra de progresso amarela se a porcentagem estiver entre 25% e 75% -->
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $feedback_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else { ?>
                                                <!-- Barra de progresso vermelha se a porcentagem for menor que 25% -->
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $feedback_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="abrir-modal-colab cursor-pointer" tipo="T">
                                        <!-- Título e porcentagem de "Treinamentos e Manuais" -->
                                        <h4 class="small font-weight-bold">Treinamentos e Manuais <span class="float-right"><?php echo $treinamento_visu_porcento . '%'; ?></span></h4>
                                        <!-- Barra de progresso -->
                                        <div class="progress mb-4">
                                            <?php if ($treinamento_visu_porcento >= 75) { ?>
                                                <!-- Barra de progresso verde se a porcentagem for maior ou igual a 75% -->
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $treinamento_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else if ($treinamento_visu_porcento >= 25) { ?>
                                                <!-- Barra de progresso amarela se a porcentagem estiver entre 25% e 75% -->
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $treinamento_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else { ?>
                                                <!-- Barra de progresso vermelha se a porcentagem for menor que 25% -->
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $treinamento_visu_porcento . '%'; ?>" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- FIM CONTEINER FLUID -->

                <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
                <!-- --------------------------------------------------- INICIO MODAIS -------------------------------------------------------------------- -->
                <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->


                <!-- MODAL DADOS DA EMPRESA -->
                <div class="modal fade" id="modal-dados" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-dados" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Dados da Empresa</h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body d-flex flex-column" style="height: 470px;">

                                <!-- SOBRE NOS -->
                                <div class="card mb-2 d-flex align-items-stretch card-dados-emp" style="flex: 1;" valor="<?php echo $dados_empresa[0]; ?>">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="h-100 w-100 d-flex flex-row align-items-center">
                                            <h7 class="ml-2 m-0 font-weight-bold text-primary">Sobre nós</h7>
                                            <button class="btn btn-primary btn-icon-split ml-auto btn-verificar" page="sobre_nos">
                                                <span class="text">Verificar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <!-- MISSÃO, VISÃO E VALORES -->
                                <div class="card mb-2 d-flex align-items-stretch card-dados-emp" style="flex: 1;" valor="<?php echo $missao_visao_valores; ?>">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="h-100 w-100 d-flex flex-row align-items-center">
                                            <h7 class="ml-2 m-0 font-weight-bold text-primary">Missão, Visão e Valores</h7>
                                            <button class="btn btn-primary btn-icon-split ml-auto btn-verificar" page="missao_visao_valores">
                                                <span class="text">Verificar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- POLÍTICAS E CÓDIGO DE CONDUTA -->
                                <div class="card mb-2 d-flex align-items-stretch card-dados-emp" style="flex: 1;" valor="<?php echo $dados_empresa[2]; ?>">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="h-100 w-100 d-flex flex-row align-items-center">
                                            <h7 class="ml-2 m-0 font-weight-bold text-primary">Política e Código de Conduta</h7>
                                            <button class="btn btn-primary btn-icon-split ml-auto btn-verificar" page="politicas_codconduta">
                                                <span class="text">Verificar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- ORGANOGRAMA DA EMPRESA -->
                                <div class="card mb-2 d-flex align-items-stretch card-dados-emp" style="flex: 1;" valor="<?php echo $dados_empresa[3]; ?>">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="h-100 w-100 d-flex flex-row align-items-center">
                                            <h7 class="ml-2 m-0 font-weight-bold text-primary">Organograma da Empresa</h7>
                                            <button class="btn btn-primary btn-icon-split ml-auto btn-verificar" page="organograma">
                                                <span class="text">Verificar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- MODAL IMPORTAR -->
                <div class="modal fade" id="modal-importar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-importar" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Importar Arquivo</h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <form id="form-importar">
                                <div class="modal-body" style="height: 470px;">
                                    <label for="file" class="mt-sm-3">Anexar</label>
                                    <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF">
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                                    <button type="submit" class="btn btn-organograma btn-icon-split-organograma">Importar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- MODAL ANIVERSARIANTES -->
                <div class="modal fade" id="modal-aniversariantes" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-aniversariantes" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Aniversariantes</h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body" id="modal-body-aniversariantes" style="max-height: 470px; overflow-y: auto; scrollbar-width: thin;">

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- MODAL CARTAO ANIVERSARIO-->
                <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 635px;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aniversário Imagem</h5>
                                <button class="close btn-close-aniver" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                <span id="visuCartao"></span>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" id="baixar">Baixar Cartão</button>
                                <button class="btn btn-secondary btn-close-aniver" type="button">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL COLABORADORES NAO VISUALIZOU -->
                <div id="modal-colab-visu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-colab-visu" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="width: 50vw;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-visualizado"></h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body" id="modal-body-colab-visu" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
                <!-- ------------------------------------------------------ FIM MODAIS -------------------------------------------------------------------- -->
                <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once 'footer.php'; ?>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="js/dom-to-image.min.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <script>
        $(function() {
            $(document).ready(function() {

                var dados_graf = {
                    grafico: 1
                };

                $.post('controller/painel_post.php', dados_graf, function(retorno) {

                    var dados = JSON.parse(retorno);

                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dados.label,
                            datasets: [{
                                    label: "Documentos Importados",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dados.dados1,
                                },
                                {
                                    label: "Documentos Visualizados",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(255, 127, 39, 0.05)",
                                    borderColor: "rgba(255, 127, 39, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(255, 127, 39, 1)",
                                    pointBorderColor: "rgba(255, 127, 39, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(255, 127, 39, 1)",
                                    pointHoverBorderColor: "rgba(255, 127, 39, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dados.dados2,
                                }
                            ],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                            }
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>
<!-- AÇÕES NO CARREGAMENTO -->
<script>
    $(function() {
        $(document).ready(function() {

            // Para cada elemento com a classe "card-dados-emp"
            $('.card-dados-emp').each(function() {

                var valor = $(this).attr('valor');

                if (valor === '1') {

                    // Adiciona a classe "border-left-success"
                    $(this).addClass('border-left-success');
                } else {

                    // Adiciona a classe "border-left-danger"
                    $(this).addClass('border-left-danger');
                }

            });
        });
    });

    // Função executada quando a página é carregada
    $(function() {
        // Função executada quando o documento HTML estiver pronto
        $(document).ready(function() {

            // Obtendo os atributos 'layout' e 'modelo' do elemento com o ID 'card-holerite'
            var layout = $('#card-holerite').attr('layout');
            var modelo_layout = $('#card-holerite').attr('modelo');

            // Obtendo os atributos 'layout' e 'modelo' do elemento com o ID 'card-ponto'
            var layout_ponto = $('#card-ponto').attr('layout');
            var modelo_layout_ponto = $('#card-ponto').attr('modelo');

            // Obtendo os atributos 'layout' e 'modelo' do elemento com o ID 'card-irrf'
            var layout_irrf = $('#card-irrf').attr('layout');
            var modelo_layout_irrf = $('#card-irrf').attr('modelo');

            // Se o atributo 'layout' não estiver vazio
            if (layout !== '') {

                // Adiciona a classe 'border-left-success' ao elemento com o ID 'card-holerite'
                $('#card-holerite').addClass('border-left-success');

                // Adiciona as classes 'fas fa-check text-success' e define o atributo 'title' como 'Aprovado' ao elemento com o ID 'icone-holerite'
                $('#icone-holerite').addClass('fas fa-check text-success').attr('title', 'Aprovado');
                // Se o atributo 'modelo' não estiver vazio
            } else if (modelo_layout !== '') {

                // Adiciona a classe 'border-left-warning' ao elemento com o ID 'card-holerite'
                $('#card-holerite').addClass('border-left-warning');

                // Adiciona as classes 'far fa-clock text-warning' e define o atributo 'title' como 'Em Análise' ao elemento com o ID 'icone-holerite'
                $('#icone-holerite').addClass('far fa-clock text-warning').attr('title', 'Em Análise');
                // Se nenhum dos atributos 'layout' e 'modelo' estiverem preenchidos
            } else {

                // Adiciona a classe 'border-left-danger' ao elemento com o ID 'card-holerite'
                $('#card-holerite').addClass('border-left-danger');

                // Adiciona as classes 'fas fa-exclamation-triangle text-danger' e define o atributo 'title' como 'Aguardando Envio' ao elemento com o ID 'icone-holerite'
                $('#icone-holerite').addClass('fas fa-exclamation-triangle text-danger').attr('title', 'Aguardando Envio');

                // Exibe o botão com o ID 'btn-importar-holerite' que estava oculto
                $('#btn-importar-holerite').attr('hidden', false);
            }

            // Repetem-se as mesmas estruturas de condicional para os elementos com os IDs 'card-ponto' e 'card-irrf'

            if (layout_ponto !== '') {

                $('#card-ponto').addClass('border-left-success');
                $('#icone-ponto').addClass('fas fa-check text-success').attr('title', 'Aprovado');
            } else if (modelo_layout_ponto !== '') {

                $('#card-ponto').addClass('border-left-warning');
                $('#icone-ponto').addClass('far fa-clock text-warning').attr('title', 'Em Análise');
            } else {

                $('#card-ponto').addClass('border-left-danger');
                $('#icone-ponto').addClass('fas fa-exclamation-triangle text-danger').attr('title', 'Aguardando Envio');
                $('#btn-importar-ponto').attr('hidden', false);
            }

            if (layout_irrf !== '') {

                $('#card-irrf').addClass('border-left-success');
                $('#icone-irrf').addClass('fas fa-check text-success').attr('title', 'Aprovado');
            } else if (modelo_layout_irrf !== '') {

                $('#card-irrf').addClass('border-left-warning');
                $('#icone-irrf').addClass('far fa-clock text-warning').attr('title', 'Em Análise');
            } else {

                $('#card-irrf').addClass('border-left-danger');
                $('#icone-irrf').addClass('fas fa-exclamation-triangle text-danger').attr('title', 'Aguardando Envio');
                $('#btn-importar-irrf').attr('hidden', false);
            }
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    $(function() {
        // Quando o elemento com o id "card-colab" for clicado
        $(document).on('click', '#card-colab', function() {

            var btn_colab = 1;

            if (btn_colab !== '') {

                var dados = {
                    btn_colab: btn_colab
                };

                // Envia uma requisição POST para 'controller/painel_post.php' com os dados
                $.post('controller/painel_post.php', dados, function(retorno) {

                    // Redireciona para a página 'colaboradores'
                    location.href = 'colaboradores';
                });
            }
        });
    });

    $(function() {
        // Quando o elemento com o id "card-solicitacao" for clicado
        $(document).on('click', '#card-solicitacao', function() {

            var btn_sol = 1;

            if (btn_sol !== '') {

                var dados = {
                    btn_sol: btn_sol
                };

                // Envia uma requisição POST para 'controller/painel_post.php' com os dados
                $.post('controller/painel_post.php', dados, function(retorno) {

                    // Redireciona para a página 'solicitacoes'
                    location.href = 'solicitacoes';
                });
            }
        });
    });

    $(function() {
        // Quando o elemento com o id "card-aniver" for clicado
        $(document).on('click', '#card-aniver', function() {

            var count = $(this).attr('num-aniver');

            if (count > 0) {

                var btn_aniver = 1;

                if (btn_aniver !== '') {

                    var dados = {
                        btn_aniver: btn_aniver
                    };

                    $.post('controller/painel_post.php', dados, function(retorno) {

                        $('#modal-body-aniversariantes').html(retorno);
                        $('#modal-aniversariantes').modal('show');
                    });
                }
            } else {

                Swal.fire({
                    icon: 'info',
                    title: 'Atenção!',
                    text: 'Nenhum colaborador faz aniversário esse mês!',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.close(); // Fecha a notificação
                    }
                });
            }
        });
    });

    $(function() {
        // Quando o elemento com o id "abrir-modal-dados" for clicado
        $(document).on('click', '#abrir-modal-dados', function() {

            // Exibe o modal com o id "modal-dados"
            $('#modal-dados').modal('show');
        });
    });

    $(function() {
        // Quando um botão com a classe "btn-verificar" for clicado
        $(document).on('click', '.btn-verificar', function() {

            var page = $(this).attr('page');

            // Redireciona para a página especificada no atributo "page"
            location.href = page;
        });
    });

    $(function() {
        // Quando um elemento com a classe "close-modal" for clicado
        $(document).on('click', '.close-modal', function() {

            // Esconde o modal que está visível
            $('.modal:visible').modal('hide');
        });
    });

    $(function() {
        $(document).on('click', '.btn-importar', function() {

            var tipo = $(this).attr('id');

            $('#file').attr('modelo', tipo);

            // Exibe o modal com o id "modal-importar"
            $('#modal-importar').modal('show');
        });
    });

    $(function() {
        $(document).on('click', '#btn-aniversario', function() {

            var id_recebido = $(this).attr("id_usu");

            // Verificar se há valor na variável "id_recebido".
            if (id_recebido !== '') {

                var dados = {
                    id_recebido: id_recebido
                };

                // Enviar uma solicitação AJAX para o arquivo 'cartao_de_aniversario.php' com os dados e manipular a resposta retornada.
                $.post('cartao_de_aniversario.php', dados, function(retorna) {

                    // Atualizar o conteúdo do elemento com o ID "visuCartao" com o retorno do servidor.
                    $("#visuCartao").html(retorna);
                    // Fechar o modal com o ID "modal-aniversariantes".
                    $('#modal-aniversariantes').modal('hide');
                    // Exibir o modal com o ID "visuModal".
                    $('#visuModal').modal('show');
                });
            }
        });
    });

    $(function() {
        $(document).on('click', '.btn-close-aniver', function() {

            // Fechar o modal com o ID "visuModal".
            $('#visuModal').modal('hide');
            // Exibir o modal com o ID "modal-aniversariantes".
            $('#modal-aniversariantes').modal('show');
        });
    });

    // Clique do botão BAIXAR para efetuar o download do HTML convertido para JPEG.
    $(function() {
        $(document).on('click', '#baixar', function() {

            // Converter o elemento com o ID "my-node" para JPEG usando a biblioteca 'dom-to-image'.
            domtoimage.toJpeg(document.getElementById('my-node'), {
                    quality: 1
                })
                .then(function(dataUrl) {
                    var link = document.createElement('a');
                    // Obter o nome do usuário do elemento com o ID "nome_usuario".
                    var nome_usuario = $.trim(document.getElementById("nome_usuario").innerHTML);
                    // Definir o nome do arquivo como 'CARTAO ANIVERSARIO' + nome_usuario + '.jpeg'.
                    link.download = 'CARTAO ANIVERSARIO_' + nome_usuario + '.jpeg';
                    link.href = dataUrl;
                    link.click();
                });
        });
    });

    $(function() {
        $(document).on('click', '.abrir-modal-colab', function() {

            var tipo = $(this).attr('tipo');
            var btn_colab_visu = 1;

            switch (tipo) {

                case 'N':
                    $('#modal-visualizado').text('Fale com os Colaboradores (Não Visualizados)');
                    break;

                case 'M':
                    $('#modal-visualizado').text('Mural de Avisos (Não Visualizados)');
                    break;

                case 'F':
                    $('#modal-visualizado').text('Feedback e Sugestões (Não Visualizados)');
                    break;

                case 'T':
                    $('#modal-visualizado').text('Treinamentos e Manuais (Não Visualizados)');
                    break;
            }

            if (btn_colab_visu !== '') {

                var dados = {

                    tipo: tipo,
                    btn_colab_visu: btn_colab_visu
                };

                $.post('controller/painel_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            Swal.fire({
                                icon: 'info',
                                title: 'Atenção!',
                                text: 'Nenhum item disponível para visualização!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
                                }
                            });
                            break;

                        default:
                            $('#modal-body-colab-visu').html(retorno);
                            $('#modal-colab-visu').modal('show');
                            break;
                    }
                });
            }
        });
    });
</script>

<!-- SUBMIT -->
<script>
    // SUBMIT INCLUIR AVISO
    $(function() {
        $('#form-importar').submit(function(e) {
            e.preventDefault(); // Impede o comportamento padrão do envio do formulário

            var btn_submit = 1;
            var tipo = $('#file').attr('modelo');

            var formData = new FormData(this);
            formData.append('btn_submit', btn_submit);
            formData.append('tipo', tipo);

            // Envio assíncrono do formulário usando POST
            $.post({
                url: 'controller/painel_post.php', // URL do arquivo PHP que receberá os dados do formulário
                data: formData, // Dados do formulário
                processData: false, // Impede o jQuery de processar os dados
                contentType: false, // Impede o jQuery de definir o cabeçalho Content-Type
                success: function(retorno) { // Função chamada quando a requisição é bem-sucedida

                    switch (retorno) {
                        case '1': // Caso o retorno seja '1'
                            // Exibe uma notificação de sucesso usando a biblioteca Swal
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Modelo importado com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Recarrega a página
                                }
                            });
                            break;

                        case '2': // Caso o retorno seja '2'
                            // Exibe uma notificação de aviso informando que o arquivo é maior que o limite de 100MB
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'O arquivo anexado é maior que o limite de 100MB!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
                                }
                            });
                            break;

                        case '0': // Caso o retorno seja '0'
                            // Exibe uma notificação de aviso informando que nenhum arquivo foi selecionado
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'Selecione um anexo para continuar!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
                                }
                            });
                            break;

                        default: // Caso o retorno seja qualquer outro valor
                            // Exibe uma notificação de erro e exibe o retorno como conteúdo HTML
                            Swal.fire({
                                icon: 'error',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Recarrega a página
                                }
                            });
                            break;
                    }

                }
            });
        });
    });
</script>