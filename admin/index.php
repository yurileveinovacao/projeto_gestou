<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util2.php";

// Realiza o UNSET da váriavel de filtro dos colaboradores
if (!empty($_SESSION["colaborador_filtro_tipo"])) {

    unset($_SESSION["colaborador_filtro_tipo"]);
}

if (!empty($_SESSION["colaborador_filtro_situac"])) {

    unset($_SESSION["colaborador_filtro_situac"]);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.png" />
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

    <!-- BIBLIOTECA CSS SLICK CARROSSEL -->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick-theme.css" />

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

                    <!-- Content Row -->
                    <div class="row responsive mb-4 mx-4">

                        <!-- 
                            ANIVERSÁRIO DO MES
                        -->
                        <?php foreach (selectANIVERSARIOS_count($id_emp_default) as $select_aniversariantes) {

                            $count_aniver = $select_aniversariantes['aniversariantes'];
                        } ?>

                        <div class="col-md-12 cursor-pointer card-aniver card-slick" num-aniver="<?php echo $count_aniver; ?>">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Aniversariantes do Mês</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_aniver; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-birthday-cake fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- 
                            CARD CURSOS/EXAMES A VENCER
                        -->
                        <?php foreach (select_VW_CURSOS_A_VENCER_count($id_emp_default) as $select_count_curso_exame) {

                            $count_cursos_exames = $select_count_curso_exame['conta'];
                        } ?>

                        <div class="col-md-12 cursor-pointer card-cursos-exames card-slick">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Cursos/Exames a Vencer</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_cursos_exames; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-scroll fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--
                            SOLICITAÇÕES PENDENTES
                        -->
                        <?php foreach (selectGESUSU_aprovacao($id_emp_default) as $select_gesusu_aprovacao) {

                            $count_colab_aprovacao = $select_gesusu_aprovacao['conta'];
                        } ?>

                        <div class="col-md-12 cursor-pointer card-colab-pendentes card-slick" num-colab="<?php echo $count_colab_aprovacao; ?>">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Colaboradores pendentes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_colab_aprovacao; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-lock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--
                            DADOS EMPRESA PREENCHIDOS
                        -->
                        <?php foreach (selectVW_GESSOB($id_emp_default) as $select_vw_gessob) {

                            if ($select_vw_gessob['missao'] == 1 && $select_vw_gessob['visao'] == 1 && $select_vw_gessob['valores'] == 1) {

                                $missao_visao_valores = 1;
                            } else {

                                $missao_visao_valores = 0;
                            }

                            $dados_empresa = [$select_vw_gessob['sobre'], $missao_visao_valores, $select_vw_gessob['politica'], $select_vw_gessob['organograma']];

                            $count_dados_preenchidos = array_sum($dados_empresa);

                            $porcentagem_dados_preenchidos = intval(($count_dados_preenchidos * 100) / 4);
                        } ?>

                        <div class="col-md-12 cursor-pointer abrir-modal-dados card-slick">
                            <div class="card border-left-primary h-100 py-2">
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


                        <!--
                            COLABORADORES ATIVOS
                        -->
                        <?php foreach (selectGESUSU_ativos($id_emp_default) as $select_gesusu_ativos) {

                            $count_colab = $select_gesusu_ativos['conta'];
                        } ?>

                        <div class="col-md-12 cursor-pointer card-colab card-slick" style="height: 100%;">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Colaboradores Ativos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_colab; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- INICIO CONTENT ROW COLUMN -->
                    <div class="row">

                        <!-- INICIO COLUNA 1 -->
                        <div class="column col-lg-8">

                            <!-- GRAFICO -->
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


                            <!-- SOLICITAÇÕES DOS COLABORADORES -->
                            <?php foreach (selectGESSOL_pendentes($id_emp_default) as $select_gessol_pendentes) {

                                $count_sol_respondidos = $select_gessol_pendentes['conta_respondidos'];
                                $count_sol_tudo = $select_gessol_pendentes['conta_tudo'];

                                if ($count_sol_tudo > 0) {

                                    $solicitacoes_respondidas_porcentagem = intval(($count_sol_respondidos * 100) / $count_sol_tudo);
                                } else {

                                    $solicitacoes_respondidas_porcentagem = 100;
                                }
                            }

                            // FALE COM OS COLABORADORES
                            foreach (selectPAINELRH($id_emp_default, 'N') as $select_painelrh_notificacao) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'N'
                                $notificacao_visu = $select_painelrh_notificacao['ocorrencias_situac_1'];
                                $notificacao_total = $select_painelrh_notificacao['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($notificacao_total > 0) {

                                    $notificacao_visu_porcento = intval(($notificacao_visu * 100) / $notificacao_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $notificacao_visu_porcento = 100;
                                }
                            }

                            // MURAL DE AVISO
                            foreach (selectPAINELRH($id_emp_default, 'M') as $select_painelrh_mural) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'M'
                                $mural_visu = $select_painelrh_mural['ocorrencias_situac_1'];
                                $mural_total = $select_painelrh_mural['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($mural_total > 0) {

                                    $mural_visu_porcento = intval(($mural_visu * 100) / $mural_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $mural_visu_porcento = 100;
                                }
                            }

                            // FEEDBACK E SUGESTÕES
                            foreach (selectPAINELRH($id_emp_default, 'F') as $select_painelrh_feedback) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'F'
                                $feedback_visu = $select_painelrh_feedback['ocorrencias_situac_1'];
                                $feedback_total = $select_painelrh_feedback['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($feedback_total > 0) {

                                    $feedback_visu_porcento = intval(($feedback_visu * 100) / $feedback_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $feedback_visu_porcento = 100;
                                }
                            }

                            // TREINAMENTOS E MANUAIS
                            foreach (selectPAINELRH($id_emp_default, 'T') as $select_painelrh_treinamento) {

                                // Obtém o número de ocorrências visualizadas e o total de ocorrências do tipo 'T'
                                $treinamento_visu = $select_painelrh_treinamento['ocorrencias_situac_1'];
                                $treinamento_total = $select_painelrh_treinamento['total_ocorrencias'];

                                // Calcula a porcentagem de ocorrências visualizadas em relação ao total
                                if ($treinamento_total > 0) {

                                    $treinamento_visu_porcento = intval(($treinamento_visu * 100) / $treinamento_total);
                                } else {

                                    // Se não houver ocorrências, define a porcentagem como 100%
                                    $treinamento_visu_porcento = 100;
                                }
                            } ?>

                            <div class="card shadow mb-4">

                                <!-- CARD HEADER -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Painel RH</h6>
                                </div>

                                <!-- CARD BODY -->
                                <div class="card-body">

                                    <!-- GESSOL -->
                                    <div class="abrir-modal-colab cursor-pointer" tipo="S">
                                        <!-- Título e porcentagem de "Fale com os Colaboradores" -->
                                        <h4 class="small font-weight-bold">Solicitações dos Colaboradores<span class="float-right"><?php echo $solicitacoes_respondidas_porcentagem . '%'; ?></span></h4>
                                        <!-- Barra de progresso -->
                                        <div class="progress mb-4">
                                            <?php if ($solicitacoes_respondidas_porcentagem >= 75) { ?>
                                                <!-- Barra de progresso verde se a porcentagem for maior ou igual a 75% -->
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $solicitacoes_respondidas_porcentagem . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else if ($solicitacoes_respondidas_porcentagem >= 25) { ?>
                                                <!-- Barra de progresso amarela se a porcentagem estiver entre 25% e 75% -->
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $solicitacoes_respondidas_porcentagem . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } else { ?>
                                                <!-- Barra de progresso vermelha se a porcentagem for menor que 25% -->
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $solicitacoes_respondidas_porcentagem . '%'; ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!-- GESNOT -->
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

                                    <!-- GESMUR e GESMUU -->
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

                                    <!-- GESOUV -->
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

                                    <!-- GESTRE e GESTRU -->
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
                        <!-- FIM COLUNA 1 -->

                        <!-- INICIO COLUNA 2 -->
                        <div class="column col-lg-4">

                            <?php foreach (selectGESEMP_token($id_emp_default) as $select_gesemp_token) {

                                $token = $select_gesemp_token['token'];
                                $vencimento = $select_gesemp_token['vencimento'];

                                if ($vencimento < $datinc) {

                                    $validade = 0;
                                } else {

                                    $validade = 1;
                                }

                                $venc_format = new DateTime($select_gesemp_token['vencimento']);

                                $venc_format = $venc_format->format('d/m/Y \à\s H:i');
                            } ?>

                            <!-- CARD TOKEN -->
                            <div class="mb-4">

                                <div class="card shadow">

                                    <!-- CARD HEADER -->
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Compartilhar Formulário</h6>
                                    </div>

                                    <!-- CARD BODY -->
                                    <div class="card-body">

                                        <div class="form-row" style="height: 316px">

                                            <div class="col-md-12 pr-0">
                                                <h7 class="ml-2 m-0 small font-weight-bold">O formulário para o cadastro de colaboradores esta ativo nesse URL:</h7>
                                            </div>

                                            <div class="col-md-12" id="token_input" token="<?php echo $token; ?>" vencimento="<?php echo $vencimento; ?>" validade="<?php echo $validade; ?>">
                                                <div class="input-group col-md-12 mb-2 px-0">

                                                    <?php if ($validade == 1) { ?>

                                                        <input type="text" class="form-control bg-white border-right-0 border-md" id="token" name="token" value="https://www.gestou.com.br/createemployee/index?emp=<?php echo $token; ?>" style="opacity: 1; background-color: white;" disabled>

                                                        <div class="input-group-append cursor-pointer btn-copy">
                                                            <span class="input-group-text bg-white px-2 border-md border-left-0" id="span-copy">
                                                                <i class="far fa-copy text-muted pr-2"></i> Copiar
                                                            </span>
                                                        </div>
                                                    <?php } else { ?>

                                                        <input type="text" class="form-control bg-white border-right-0 border-md" id="token" name="token" value="https://www.gestou.com.br/createemployee/index?emp=<?php echo $token; ?>" style="opacity: 1; background-color: white; text-decoration: line-through;" disabled>

                                                        <div class="input-group-append cursor-pointer btn-regerar" id="div-gerar">
                                                            <span class="input-group-text bg-white px-2 border-md border-left-0" id="span-gerar">
                                                                <i class="fas fa-link text-muted pr-2"></i> Gerar Link
                                                            </span>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <button class="btn btn-primary btn-sm btn-icon-split ml-auto btn-abrir-form">
                                                    <span class="text">
                                                        <i class="far fa-window-restore"></i> Abrir em nova aba
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="col-md-12">

                                                <div class="rounded d-flex align-items-center justify-content-center" style="background-color: #e8f0fe; height: 70px; border-radius: 100px !important;">
                                                    <div class="pl-2 mr-3">
                                                        <i class="fas fa-globe-americas fa-2x text-success" style="background-color: white; border-radius: 50%; padding: 7px;"></i>
                                                    </div>

                                                    <div class="pt-3" id="div-p-link">
                                                        <?php if ($validade == 1) { ?>

                                                            <p class="pr-1" style="font-size: 12px;"><b>Através deste link, qualquer pessoa na internet pode preencher o formulário, disponível até <?php echo $venc_format; ?>.</b></p>
                                                        <?php } else { ?>

                                                            <p class="pr-1" style="font-size: 12px;"><b>Este link expirou dia <?php echo $venc_format; ?>. Por favor, clique em 'Gerar link' para criar um novo formulário.</b></p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

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
                            <div class="mb-4 d-flex flex-column" style="height: 415px;">

                                <!-- HOLERITE -->
                                <div class="card shadow mb-2 d-flex align-items-stretch" id="card-holerite" layout="<?php echo $layout; ?>" modelo="<?php echo $modelo_layout; ?>" style="flex: 1;">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="h-100 w-100 d-flex flex-row align-items-center">
                                            <i id="icone-holerite"></i>
                                            <h7 class="ml-2 m-0 font-weight-bold text-primary">Holerite</h7>
                                            <button id="btn-importar-holerite" class="btn btn-primary btn-sm btn-icon-split ml-auto btn-importar" hidden>
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
                                            <button id="btn-importar-ponto" class="btn btn-primary btn-sm btn-icon-split ml-auto btn-importar" hidden>
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
                                            <button id="btn-importar-irrf" class="btn btn-primary btn-sm btn-icon-split ml-auto btn-importar" hidden>
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
                        <!-- FIM COLUNA 2 -->

                    </div>
                    <!-- FIM CONTENT ROW COLUMN -->

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
                                <button class="btn btn-primary btn-icon-split ml-auto btn-verificar" id="verificar-painelrh">
                                    <span class="text">Verificar</span>
                                </button>
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL COLABORADORES PENDENTES -->
                <div class="modal fade" id="modal-colab-pendentes" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-colab-pendentes" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Colaboradores Pendentes</h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body" id="modal-body-colab-pendentes" style="max-height: 470px; overflow-y: auto; scrollbar-width: thin;">

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- MODAL CURSOS E EXAMES -->
                <div id="modal-curexa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-curexa" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="width: 50vw;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-curexa">Cursos/Exames a Vencer</h5>
                                <button class="close close-modal" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body" id="modal-body-curexa" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary btn-icon-split ml-auto" id="btn-verificar-curexa">
                                    <span class="text">Verificar</span>
                                </button>
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

    <!-- BIBLIOTECA SLICK CARROSSEL -->
    <script type="text/javascript" src="vendor/slick/slick.min.js"></script>

    <script>
        $(function() {
            $(document).ready(function() {

                // Objeto contendo os dados para o gráfico
                var dados_graf = {
                    grafico: 1
                };

                // Requisição POST para obter os dados do gráfico
                $.post('controller/index_post.php', dados_graf, function(retorno) {

                    // Parseia o retorno (que é uma string JSON) para um objeto JavaScript
                    var dados = JSON.parse(retorno);

                    // Obtém o contexto do elemento com o ID "myAreaChart"
                    var ctx = document.getElementById("myAreaChart");

                    // Cria um gráfico de linha usando o contexto e os dados obtidos
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dados.label,
                            datasets: [{
                                    label: "Itens Importados",
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
                                    label: "Itens Visualizados",
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

    // Aguarda o documento estar pronto
    $(function() {
        $(document).ready(function() {

            // Obtém os valores do token e data de vencimento do atributo 'token' do elemento com ID 'token_input'
            var token = $('#token_input').attr('token');
            var venc_token = $('#token_input').attr('vencimento');

            if (token === '') {

                // Cria um objeto 'dados' com os valores do token, data de vencimento e um indicador para gerar o token
                var dados = {
                    token: token,
                    venc_token: venc_token,
                    gerar_token: 1
                };

                // Envia uma requisição POST para o arquivo 'controller/index_post.php' com os dados
                $.post('controller/index_post.php', dados, function(retorno) {

                    // Define a página de destino para o token retornado
                    var page = 'https://www.gestou.com.br/createemployee/index?emp=';

                    // Faz o parsing do JSON recebido
                    var retorno_obj = JSON.parse(retorno);

                    // Acessa os valores do retorno corretamente (retorno[0] e retorno[1])
                    var token = retorno_obj[0];
                    var dia_venc = retorno_obj[1];
                    var hora_venc = retorno_obj[2];

                    // console.log(token);
                    // console.log(dia_venc);
                    // console.log(hora_venc);
                    // Define o valor do campo de entrada 'token' concatenando a página de destino com o retorno do servidor
                    $('#token').val(page + token);
                    $('#token').css({
                        'text-decoration': 'none'
                    });

                    $('#div-p-link').html('<p style="font-size: 10px;"><b>Através deste link, qualquer pessoa na internet pode preencher o formulário, disponível até o dia ' + dia_venc + ' às ' + hora_venc + '</b></p>')
                    $('#div-gerar').removeClass('btn-regerar').addClass('btn-copy');
                    $('#span-gerar').html('<i class="far fa-copy text-muted pr-2"></i> Copiar').attr('id', 'span-copy');
                });
            }
        });
    });
</script>

<!-- AÇÕES NO CLICK -->
<script>
    $(function() {
        // Quando o elemento com o class "card-colab" for clicado
        $(document).on('click', '.card-colab', function() {

            var btn_colab = 1;

            if (btn_colab !== '') {

                var dados = {
                    btn_colab: btn_colab
                };

                // Envia uma requisição POST para 'controller/index_post.php' com os dados
                $.post('controller/index_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            // Redireciona para a página 'colaboradores'
                            location.href = 'colaboradores';
                            break;

                        case '0':
                            Swal.fire({
                                icon: 'info',
                                title: 'Atenção!',
                                text: 'Você não tem permissão para acessar esta página. Verifique suas credenciais ou entre em contato com o suporte.',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
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
                                    location.reload(); // Recarrega a página
                                }
                            });
                            break;
                    }


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

                // Envia uma requisição POST para 'controller/index_post.php' com os dados
                $.post('controller/index_post.php', dados, function(retorno) {

                    // Redireciona para a página 'solicitacoes'
                    location.href = 'solicitacoes';
                });
            }
        });
    });

    $(function() {
        // Quando o elemento com a class "card-aniver" for clicado
        $(document).on('click', '.card-aniver', function() {

            var count = $(this).attr('num-aniver');

            if (count > 0) {

                var btn_aniver = 1;

                if (btn_aniver !== '') {

                    var dados = {
                        btn_aniver: btn_aniver
                    };

                    $.post('controller/index_post.php', dados, function(retorno) {

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
        // Quando o elemento com o class "abrir-modal-dados" for clicado
        $(document).on('click', '.abrir-modal-dados', function() {

            // Exibe o modal com o id "modal-dados"
            $('#modal-dados').modal('show');
        });
    });

    $(function() {
        // Quando um botão com a classe "btn-verificar" for clicado
        $(document).on('click', '.btn-verificar', function() {

            var page = $(this).attr('page');
            var btn_verificar_dados = 1;

            if (btn_verificar_dados != '') {

                var dados = {
                    page: page,
                    btn_verificar_dados: btn_verificar_dados
                };

                $.post('controller/index_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            // Redireciona para a página especificada no atributo "page"
                            location.href = page;
                            break;

                        case '0':
                            Swal.fire({
                                icon: 'info',
                                title: 'Atenção!',
                                text: 'Você não tem permissão para acessar esta página. Verifique suas credenciais ou entre em contato com o suporte.',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
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
                                    location.reload(); // Recarrega a página
                                }
                            });
                            break;
                    }
                });
            }
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
        // Define um evento de clique para os elementos com a classe "abrir-modal-colab"
        $(document).on('click', '.abrir-modal-colab', function() {

            // Obtém o valor do atributo "tipo" do elemento clicado
            var tipo = $(this).attr('tipo');

            // Define uma variável btn_colab_visu com o valor 1
            var btn_colab_visu = 1;

            // Executa um switch/case com base no valor de "tipo"
            switch (tipo) {

                case 'N':
                    // Atualiza o texto do elemento com o ID "modal-visualizado" para 'Fale com os Colaboradores (Não Visualizados)'
                    $('#modal-visualizado').text('Fale com os Colaboradores (Não Visualizados)');
                    $('#verificar-painelrh').attr('page', 'notificacoes');
                    break;

                case 'M':
                    // Atualiza o texto do elemento com o ID "modal-visualizado" para 'Mural de Avisos (Não Visualizados)'
                    $('#modal-visualizado').text('Mural de Avisos (Não Visualizados)');
                    $('#verificar-painelrh').attr('page', 'mural_avisos');
                    break;

                case 'F':
                    // Atualiza o texto do elemento com o ID "modal-visualizado" para 'Feedback e Sugestões (Não Respondidos)'
                    $('#modal-visualizado').text('Feedback e Sugestões (Não Respondidos)');
                    $('#verificar-painelrh').attr('page', 'feedback_sugestoes');
                    break;

                case 'T':
                    // Atualiza o texto do elemento com o ID "modal-visualizado" para 'Treinamentos e Manuais (Não Visualizados)'
                    $('#modal-visualizado').text('Treinamentos e Manuais (Não Visualizados)');
                    $('#verificar-painelrh').attr('page', 'treinamentos_manuais');
                    break;

                case 'S':
                    // Atualiza o texto do elemento com o ID "modal-visualizado" para 'Solicitações dos Colaboradores (Não Respondidos)'
                    $('#modal-visualizado').text('Solicitações dos Colaboradores (Não Respondidos)');
                    $('#verificar-painelrh').attr('page', 'solicitacoes');
                    break;
            }

            // Verifica se btn_colab_visu não é uma string vazia
            if (btn_colab_visu !== '') {

                // Cria um objeto "dados" com as propriedades "tipo" e "btn_colab_visu"
                var dados = {
                    tipo: tipo,
                    btn_colab_visu: btn_colab_visu
                };

                // Realiza uma requisição POST para 'controller/index_post.php' com os dados
                $.post('controller/index_post.php', dados, function(retorno) {

                    // Executa um switch/case com base no valor retornado
                    switch (retorno) {

                        case '1':

                            switch (tipo) {

                                case 'N':
                                    // Exibe uma notificação de informação informando que Todas as notificações foram visualizadas pelos colaboradores
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Atenção!',
                                        text: 'Todas as notificações foram visualizadas pelos colaboradores!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close(); // Fecha a notificação
                                        }
                                    });
                                    break;

                                case 'M':
                                    // Exibe uma notificação de informação informando que Todos os avisos foram visualizados pelos colaboradores
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Atenção!',
                                        text: 'Todos os avisos foram visualizados pelos colaboradores!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close(); // Fecha a notificação
                                        }
                                    });
                                    break;

                                case 'F':
                                    // Exibe uma notificação de informação informando que Nenhum feedback pendente de retorno
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Atenção!',
                                        text: 'Nenhum feedback pendente de retorno!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close(); // Fecha a notificação
                                        }
                                    });
                                    break;

                                case 'T':
                                    // Exibe uma notificação de informação informando que Todos os treinamentos e manuais foram visualizados pelos colaboradores
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Atenção!',
                                        text: 'Todos os treinamentos e manuais foram visualizados pelos colaboradores!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close(); // Fecha a notificação
                                        }
                                    });
                                    break;

                                case 'S':
                                    // Exibe uma notificação de informação informando que Nenhuma solicitação pendente de retorno
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Atenção!',
                                        text: 'Nenhuma solicitação pendente de retorno!',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swal.close(); // Fecha a notificação
                                        }
                                    });
                                    break;
                            }
                            break;

                        default:
                            // Atualiza o conteúdo do elemento com o ID "modal-body-colab-visu" com o valor retornado
                            $('#modal-body-colab-visu').html(retorno);
                            // Abre o modal com o ID "modal-colab-visu"
                            $('#modal-colab-visu').modal('show');
                            break;
                    }
                });
            }
        });
    });

    // COPIA O TOKEN
    $(function() {
        // Define um evento de clique para os elementos com a classe "btn-copy"
        $(document).on('click', '.btn-copy', function() {

            // Selecione o elemento desejado com o ID "token"
            var elemento = $('#token');

            // Selecione o texto dentro do elemento
            var texto = elemento.val();

            // Crie um elemento temporário para a seleção
            var tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(texto).select();

            // Copie o texto para a área de transferência
            document.execCommand('copy');

            // Remova o elemento temporário
            tempInput.remove();

            // Atualize o conteúdo e a classe do elemento com o ID "span-copy" para exibir uma mensagem de sucesso
            $('#span-copy').html('<i class="fas fa-check text-success pr-2"></i> Copiado');
            $('#span-copy').addClass('text-success');

        });
    });


    // ABRIR FORM
    $(function() {
        // Define um evento de clique para os elementos com a classe "btn-abrir-form"
        $(document).on('click', '.btn-abrir-form', function() {

            // Obtém o valor do campo de input com o ID "token"
            var link = $('#token').val();
            var btn_abrir_form = 1;

            if (btn_abrir_form !== '') {

                var dados = {
                    link: link,
                    btn_abrir_form: btn_abrir_form
                };

                $.post('controller/index_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            // Abre uma nova janela/tab com o link obtido, em branco (_blank)
                            window.open(link, '_blank');
                            break;

                        default:
                            Swal.fire({
                                icon: 'info',
                                title: 'Atenção!',
                                text: 'O link expirou dia ' + retorno + '. Por favor, clique em \'Gerar link\' para criar um novo formulário.',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close(); // Fecha a notificação
                                }
                            });
                            break;
                    }

                });
            }
        });
    });

    // GERA LINK
    $(function() {
        // Define um evento de clique para os elementos com a classe "btn-regerar"
        $(document).on('click', '.btn-regerar', function() {

            // Define uma variável btn_regerar com o valor 1
            var btn_regerar = 1;

            // Verifica se btn_regerar não é uma string vazia
            if (btn_regerar !== '') {

                // Cria um objeto "dados" com a propriedade "btn_regerar"
                var dados = {
                    btn_regerar: btn_regerar
                };

                // Realiza uma requisição POST para 'controller/index_post.php' com os dados
                $.post('controller/index_post.php', dados, function(retorno) {

                    // Executa um switch/case com base no valor retornado
                    switch (retorno) {

                        case '1':
                            // Exibe uma notificação de sucesso informando que o formulário foi gerado com sucesso
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Formulário gerado com sucesso.',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Recarrega a página
                                }
                            });
                            break;

                        default:
                            // Exibe uma notificação de erro informando para entrar em contato com o suporte e exibe o retorno (mensagem de erro)
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

                });
            }
        });
    });

    $(function() {
        // Aguarda o documento ser carregado e atribui um evento de clique ao elemento com class "card-colab-pendentes"
        $(document).on('click', '.card-colab-pendentes', function() {

            var card_colab_pendentes = 1; // Variável que representa o valor do card de colaboradores pendentes
            var count = $(this).attr('num-colab');

            if (count > 0) {

                if (card_colab_pendentes !== '') { // Verifica se o valor do card de colaboradores pendentes não está vazio

                    var dados = {
                        card_colab_pendentes: card_colab_pendentes
                    };

                    // Envia uma requisição POST para o arquivo 'controller/index_post.php' com os dados
                    $.post('controller/index_post.php', dados, function(retorno) {

                        // Executa um switch/case com base no valor retornado
                        switch (retorno) {

                            case '0':
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Atenção!',
                                    text: 'Você não tem permissão para acessar esta página. Verifique suas credenciais ou entre em contato com o suporte.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        swal.close(); // Fecha a notificação
                                    }
                                });
                                break;

                            default:
                                // Atualiza o conteúdo do elemento com o ID "modal-body-colab-pendentes" com o valor retornado
                                $('#modal-body-colab-pendentes').html(retorno);
                                // Abre o modal com o ID "modal-colab-pendentes"
                                $('#modal-colab-pendentes').modal('show');
                                break;
                        }
                    });
                }
            } else {

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
            }
        });
    });

    $(function() {
        $(document).on('click', '.btn-colab-pendente', function() {

            var btn_colab_pendente = 1;

            if (btn_colab_pendente !== '') {

                var dados = {
                    id_usu: $(this).attr('id_usu'),
                    tipo: $(this).attr('tipo'),
                    btn_colab_pendente: btn_colab_pendente
                };

                $.post('controller/index_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Colaborador aprovado com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            break;

                        case '1':
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Colaborador reprovado com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
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
                });
            }
        });
    });

    $(function() {
        // Evento de clique no card de cursos/exames
        $('.card-cursos-exames').click(function() {

            // Envia a requisição somente se o card_curexa for 1
            var card_curexa = 1;


            var dados = {

                card_curexa: card_curexa
            };

            // Envia a requisição POST para 'controller/index_post.php' com os dados do card_curexa
            $.post('controller/index_post.php', dados, function(retorno) {

                switch (retorno) {

                    case '0':
                        // Exibe uma notificação informando que não há cursos ou exames a vencer
                        Swal.fire({
                            icon: 'info',
                            title: 'Atenção!',
                            text: 'Nenhum curso ou exame vencendo!',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(() => swal.close()); // Fecha a notificação
                        break;

                    default:
                        // Exibe o conteúdo retornado no modal modal-curexa
                        $('#modal-curexa').modal('show').find('#modal-body-curexa').html(retorno);
                        break;
                }
            });
        });
    });

    $(function() {
        $('#btn-verificar-curexa').click(function() {

            var btn_verif_curexa = 1;

            var dados = {
                btn_verif_curexa: btn_verif_curexa
            };

            // Envia a requisição POST para 'controller/index_post.php' com os dados do card_curexa
            $.post('controller/index_post.php', dados, function(retorno) {

                switch (retorno) {

                    case '0':
                        // Exibe uma notificação informando que o usuário não tem permissão para acessar a página
                        Swal.fire({
                            icon: 'info',
                            title: 'Atenção!',
                            text: 'Você não tem permissão para acessar esta página. Verifique suas credenciais ou entre em contato com o suporte.',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(() => swal.close()); // Fecha a notificação
                        break;

                    case '1':
                        location.href = 'lancamento_cursos_exames';
                        break;
                }
            });
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
                url: 'controller/index_post.php', // URL do arquivo PHP que receberá os dados do formulário
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

    // Aguarda o documento estar pronto antes de executar o código
    $(document).ready(function() {
        // Seleciona todos os cards dentro do carrossel
        var elementos = $('.card-slick');

        ajustarAltura(elementos);

        // Redimensiona a altura dos cards quando a janela for redimensionada
        $(window).resize(function() {

            // Redefine as alturas dos cards para o valor automático antes de calcular a altura máxima novamente
            elementos.height('auto');

            ajustarAltura(elementos);
        });

        function ajustarAltura(elements) {

            clearTimeout(resizeTimer);

            var resizeTimer = setTimeout(function() {
                // Encontra a nova altura máxima entre todos os cards
                var maxHeight = Math.max.apply(null, elements.map(function() {

                    return $(this).height();
                }).get());

                // Atribui a nova altura máxima a todos os cards
                elements.height(maxHeight);
            }, 100);
        }
    });
</script>

<!-- JS CARROSSEL SLICK -->
<script>
    $(document).ready(function() {

        $('.responsive').slick({
            dots: true,
            infinite: false,
            arrows: true,
            speed: 1000,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: false,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });
</script>