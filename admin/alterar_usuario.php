<?php

//Faz a requisição da Sessão
require 'restrito.php';

// //abre conexao
// require_once __DIR__.'/../config/database.php';
// require_once __DIR__.'/../config/database.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

// FEA-010 — Líder RH: controle de acesso e contexto
$id_tus_logado = 0;
foreach (select_GESUSA_id_usa($id_usa_default) as $usuario) {
    $id_tus_logado = (int) $usuario['id_tus'];
}
$is_admin_interno = ($id_tus_logado == 1);
$is_lider_rh = checkLiderRH($id_usa_default, $id_emp_default);
$pode_gerenciar_admins = ($is_admin_interno || $is_lider_rh);

if (!$pode_gerenciar_admins) {
    echo "<script language=javascript>
        alert('Somente Líderes RH ou administradores internos podem alterar usuários.');
        location.href = 'tabela_usuarios';
    </script>";
    exit;
}

$lideres_ativos = selectGESUSA_lideres_ativos($id_emp_default);
$limites = selectGESEMP_limites($id_emp_default);
$limite_lideres = $limites['limite_lideres'];

// Status atual do usuário-alvo (preenchido após $_REQUEST['al'] ser tratado)
$id_usa_alvo = isset($_REQUEST['al']) ? (int) $_REQUEST['al'] : (int) ($_SESSION['id_usa_alterar'] ?? 0);
$alvo_is_lider = $id_usa_alvo ? checkLiderRH($id_usa_alvo, $id_emp_default) : false;
// Pode marcar Líder se já era (mantendo) ou se ainda há vaga
$pode_marcar_lider = $alvo_is_lider || ($lideres_ativos < $limite_lideres);

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

    <title>GESTOU PORTAL - Alterar Usuário</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputimg.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top" onload="return check_form()">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Usuário</h6>
                            <?php $cor_badge_l = $lideres_ativos > $limite_lideres ? 'badge-danger' : 'badge-info'; ?>
                            <span class="badge <?php echo $cor_badge_l; ?>" title="Líderes RH ativos / limite configurado pelo master">
                                <i class="fas fa-user-shield"></i>
                                <?php echo $lideres_ativos; ?> de <?php echo $limite_lideres; ?> Líderes RH ativos
                            </span>
                        </div>
                        <div class="card-body">

                            <?php

                            if (isset($_REQUEST['al'])) {
                                try {

                                    $_SESSION["id_usa_alterar"] = $_REQUEST["al"];
                                    $id_usa_alterar = $_SESSION["id_usa_alterar"];
                                } catch (PDOException $erro) {
                                    echo $erro->getMessage();
                                }
                            }

                            ?>

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link" id="menu-geral-tab" data-toggle="tab" href="#menu-geral" role="tab" aria-controls="menu-geral" aria-selected="true">Geral</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="menu-empresa-tab" data-toggle="tab" href="#menu-empresa" role="tab" aria-controls="menu-empresa" aria-selected="false">Empresa</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" novalidate action="alterar_usuario" method="POST">

                                <div class="col-md-12">

                                    <!-- INÍCIO MENU GERAL -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade" id="menu-geral" role="tabpanel" aria-labelledby="menu-geral-tab">

                                            <?php

                                            foreach (select_VW_ADMIN_USUARIOS($id_usa_alterar, $id_emp_default) as $linha) {

                                                if ($linha != 0) {

                                            ?>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" value="<?php echo $linha["nome"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido! Min. 3 caracteres!
                                                            </div>
                                                        </div>

                                                        <input type="hidden" class="situac" id="<?php echo $linha['situac']; ?>">

                                                        <div class="col-md-6 mb-3">
                                                            <label for="CPF">CPF</label>
                                                            <input type="text" class="form-control" id="CPF" attrname="CPF" name="CPF" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" value="<?php echo $linha["cpf"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" value="<?php echo $linha["email"]; ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="telefone">Telefone</label>
                                                            <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9]{4}-[0-9]{4}" minlength="15" value="<?php echo $linha["telefone"]; ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="departamento">Departamento</label>
                                                            <select class="form-control" id="departamento" name="departamento">
                                                                <?php

                                                                foreach (selectGESDEP_id_usa($id_usa_alterar, $id_emp_default) as $dep_banco) {

                                                                    echo '<option value="' . $dep_banco['id_dep'] . '">' . $dep_banco['departamento'] . '</option>';
                                                                }

                                                                ?>

                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">

                                                            <?php if ($linha["id_tus"] == 1) { ?>

                                                                <label for="tus">Tipo Usuário</label>
                                                                <input type="text" class="form-control" id="tusadm" name="tusadm" value="ADMIN" disabled>

                                                            <?php } else { ?>

                                                                <label for="tus">Tipo Usuário</label>
                                                                <select class="form-control" id="tus" name="tus">
                                                                    <!-- <option selected value="0">Escolha o Departamento</option> -->
                                                                <?php

                                                                foreach (selectGESTUS_id_usa($id_usa_alterar) as $tus_banco) {

                                                                    echo '<option value="' . $tus_banco['id_tus'] . '">' . $tus_banco['descricao'] . '</option>';
                                                                }
                                                            }
                                                                ?>

                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Inválido!
                                                                </div>
                                                        </div>
                                                    </div>

                                                    <!-- FEA-010: checkbox Líder RH -->
                                                    <?php if ($linha["id_tus"] != 1) { ?>
                                                        <div class="form-row">
                                                            <div class="col-md-12 mb-3">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="is_lider" name="is_lider" value="1"
                                                                        <?php echo $alvo_is_lider ? 'checked' : ''; ?>
                                                                        <?php echo $pode_marcar_lider ? '' : 'disabled'; ?>>
                                                                    <label class="custom-control-label" for="is_lider">
                                                                        <strong>Líder RH</strong>
                                                                        <span class="text-muted">— marcar para conceder gestão de admins desta empresa</span>
                                                                    </label>
                                                                    <?php if (!$pode_marcar_lider) { ?>
                                                                        <small class="form-text text-danger">
                                                                            Limite de <?php echo $limite_lideres; ?> Líderes RH ativos já atingido. Desative um Líder para promover outro.
                                                                        </small>
                                                                    <?php } else { ?>
                                                                        <small class="form-text text-muted">
                                                                            <?php echo $lideres_ativos; ?> de <?php echo $limite_lideres; ?> Líderes RH ativos
                                                                            <?php if ($alvo_is_lider && $lideres_ativos <= 1) { ?>
                                                                                — atenção: desmarcar deixará a empresa sem Líder ativo (bloqueado pelo sistema)
                                                                            <?php } ?>
                                                                        </small>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                                    <div class="form-group">
                                                        <div class="textalign-right">
                                                            <button id="btn-troca-senha" type="button" data-toggle="modal" data-target="#TrocarSenha" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock mr-sm-2"></i> Trocar Senha</button>
                                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                                            <a href="tabela_usuarios"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                        </div>
                                                    </div>
                                                    <!-- FIM BOTÃO ENVIAR -->

                                        </div>
                                        <!-- FIM MENU GERAL -->

                                        <!-- INÍCIO MENU ENDEREÇO -->
                                        <div class="tab-pane fade" id="menu-endereco" role="tabpanel" aria-labelledby="menu-endereco-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" value="<?php echo $linha["endereco"]; ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" value="<?php echo $linha["bairro"]; ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-10 mb-3">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" value="<?php echo $linha["complemento"]; ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero" value="<?php echo $linha["numero"]; ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <select id="estado" name="estado" class="form-control" required>
                                                        <?php

                                                        foreach (selectVW_ADMIN_USUARIOS($id_usa_alterar) as $info_banco) {

                                                            $cep = $info_banco['cep'];
                                                            $estado = $info_banco['estado'];
                                                        }

                                                        foreach (select_ESTADO_id_usa($id_usa_alterar) as $estado_banco) {

                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>

                                                        <?php

                                                        foreach (select_CIDADE_id_usa($id_usa_alterar, $estado) as $cidade_banco) {

                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                        }

                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="CEP">CEP</label>
                                                    <input type="text" class="form-control" id="CEP" attrname="cep" name="cep" value="<?php echo $cep ?>">
                                                </div>
                                            </div>

                                            <!-- INÍCIO BOTÃO ENVIAR -->
                                            <div class="form-group">
                                                <div class="textalign-right">
                                                    <button id="btn-troca-senha" type="button" data-toggle="modal" data-target="#TrocarSenha" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock mr-sm-2"></i> Trocar Senha</button>
                                                    <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                                    <a href="tabela_usuarios"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                </div>
                                            </div>
                                            <!-- FIM BOTÃO ENVIAR -->

                                        </div>
                                        <!-- FIM MENU ENDEREÇO -->

                                        <!-- INICIO MENU EMPRESAS -->
                                        <div class="tab-pane fade" id="menu-empresa" role="tabpanel" aria-labelledby="menu-empresa-tab" style="margin-bottom: 10px;">

                                            <div class="row" style="justify-content: center;">
                                                <div class="col-md-6">Empresas Disponíveis</div>
                                                <div class="col-md-5">Empresas Selecionadas</div>
                                            </div>

                                            <form action="alterar_usuario" method="POST">
                                                <div class="row" style="justify-content: center;">

                                                    <!-- TAB Empresas Disponiveis -->
                                                    <div class="col-md-5" style="height: 450px; overflow: auto; scrollbar-width: thin; margin-bottom: 16px;">
                                                        <table class="table table-bordered sortable" width="100%" cellspacing="0">
                                                            <thead style="text-align: center;">
                                                                <tr class="list-head">
                                                                    <th data-orderable="false">Nome</th>
                                                                    <th data-orderable="false">CNPJ</th>
                                                                    <th data-orderable="false">Grupo</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php
                                                                // FEA-010: Líder RH só vê empresas que ele mesmo acessa.
                                                                // Admin interno (id_tus=1) continua vendo todas (master-like).
                                                                $empresas_disponiveis = $is_admin_interno
                                                                    ? selectGESEMP_emp_disponiveis($id_usa_alterar)
                                                                    : selectGESEMP_emp_disponiveis_lider($id_usa_alterar, $id_usa_default);
                                                                foreach ($empresas_disponiveis as $selectGESEMP1) {

                                                                    $id_emp_tab = $selectGESEMP1['id_emp'];
                                                                    $nome_tab = $selectGESEMP1['nomefantasia'];
                                                                    $cnpj_tab = $selectGESEMP1['cnpj'];
                                                                    $grupo_tab = $selectGESEMP1['grupo']; ?>

                                                                    <tr id="<?php echo $id_emp_tab ?>" class="list-emp">
                                                                        <th><?php echo '<b>' . $nome_tab . '</b>'; ?></th>
                                                                        <th><?php echo $cnpj_tab; ?></th>
                                                                        <th><?php echo $grupo_tab; ?></th>
                                                                    </tr>

                                                                <?php } ?>
                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <!-- Botões de Inclusão e Exclusão -->
                                                    <div class="col-md-1" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

                                                        <input type="hidden" name="emp" class="emp-select">

                                                        <button type="submit" name="btn-inc" class="button-emp"><i class="fas fa-chevron-right"></i></button>
                                                        <button type="submit" name="btn-inc-all" class="button-emp"><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></button>
                                                        <button type="submit" name="btn-exc" class="button-emp"><i class="fas fa-chevron-left"></i></button>
                                                        <button type="submit" name="btn-exc-all" class="button-emp"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></button>
                                                    </div>

                                                    <!-- TAB Empresas Selecionadas -->
                                                    <div class="col-md-5" style="height: 450px; overflow: auto; scrollbar-width: thin;">
                                                        <table class="table table-bordered sortable" width="100%" cellspacing="0">
                                                            <thead style="text-align: center;">
                                                                <tr class="list-head">
                                                                    <th data-orderable="false">Nome</th>
                                                                    <th data-orderable="false">CNPJ</th>
                                                                    <th data-orderable="false">Grupo</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php
                                                                $empresas_selecionadas = $is_admin_interno
                                                                    ? selectGESEMP_emp_selecionadas($id_usa_alterar)
                                                                    : selectGESEMP_emp_selecionadas_lider($id_usa_alterar, $id_usa_default);
                                                                foreach ($empresas_selecionadas as $selectGESEMP2) {

                                                                    $id_emp_tab = $selectGESEMP2['id_emp'];
                                                                    $nome_tab = $selectGESEMP2['nomefantasia'];
                                                                    $cnpj_tab = $selectGESEMP2['cnpj'];
                                                                    $grupo_tab = $selectGESEMP2['grupo']; ?>

                                                                    <tr id="<?php echo 'selec-' . $id_emp_tab ?>" class="list-emp">
                                                                        <th><?php echo '<b>' . $nome_tab . '</b>'; ?></th>
                                                                        <th><?php echo $cnpj_tab; ?></th>
                                                                        <th><?php echo $grupo_tab; ?></th>
                                                                    </tr>

                                                                <?php } ?>
                                                            </tbody>
                                                        </table>

                                                    </div>

                                                </div>
                                            </form>

                                            <!-- INÍCIO BOTÃO ENVIAR -->
                                            <div class="form-group">
                                                <div class="textalign-right">
                                                    <a href="tabela_usuarios"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                </div>
                                            </div>
                                            <!-- FIM BOTÃO ENVIAR -->

                                        </div>

                                    </div>
                                    <!-- FIM TAB CONTENT -->

                            <?php

                                                }
                                            }

                            ?>

                                </div>
                                <!-- FIM DIV CLASS COL-MD-12 -->

                            </form>
                            <!-- FIM FORM -->

                        </div>

                    </div>
                </div>

            </div>

            <!-- TROCAR SENHA Organograma Modal-->
            <div class="modal fade" id="TrocarSenha" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="TrocarSenha" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document" style="width: 400px !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="TrocarSenha">Trocar Senha</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="alterar_usuario" method="POST">
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="novasenha">Senha</label>
                                            <input type="password" name="novasenha" class="form-control" id="novasenha" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();" minlength="3" required></input><span style="text-align: right !important;"></span><i id="exibe" class="fas fa-eye-slash lnr-eye-modal" onclick="mostrarSenha(); document.getElementById('exibe').style.display = 'none'; document.getElementById('oculta').style.display = 'inline';"></i>
                                            <i id="oculta" class="fas fa-eye lnr-eye-modal" style="display: none;" onclick="mostrarSenha();document.getElementById('oculta').style.display = 'none'; document.getElementById('exibe').style.display = 'inline';"></i>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="confirmnovasenha">Confirmar Senha</label>
                                            <input type="password" name="confirmnovasenha" class="form-control" id="confirmnovasenha" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();" minlength="3" required></input><span style="text-align: right !important;"></span><i id="confirm_exibe" class="fas fa-eye-slash lnr-eye1-modal" onclick="confirmSenha(); document.getElementById('confirm_exibe').style.display = 'none'; document.getElementById('confirm_oculta').style.display = 'inline';"></i>
                                            <i id="confirm_oculta" class="fas fa-eye lnr-eye1-modal" style="display: none;" onclick="confirmSenha();document.getElementById('confirm_oculta').style.display = 'none'; document.getElementById('confirm_exibe').style.display = 'inline';"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="botao-alterar-senha" onclick="return confirm('Tem certeza que deseja alterar a senha desse usuário?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock"></i>
                                    Alterar</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php


            if (isset($_REQUEST['botao-alterar-senha'])) {
                try {
                    $novasenha = $_POST['novasenha'];
                    $confirmnovasenha = $_POST['confirmnovasenha'];
                    $id_usa = $_SESSION["id_usa_alterar"];

                    if ($novasenha == $confirmnovasenha) {

                        $novasenha_banco = password_hash($novasenha, PASSWORD_DEFAULT);

                        // echo "novasenha".  var_dump($novasenha)."<br>";
                        // echo "confirm".  var_dump($confirmnovasenha)."<br>";
                        // echo "id_usa".  var_dump($id_usa)."<br>";
                        // echo "datatu".  var_dump($datatu)."<br>";
                        // echo "id_usa".  var_dump($id_usa_default)."<br>";
                        // echo "novasenha_banco".  var_dump($novasenha_banco)."<br>";

                        troca_senha_GESUSA($novasenha_banco, $datatu, $id_usa_default, $id_usa);

                        echo "<script>
                        alert('Senha foi alterada com sucesso!');
                        location.href='alterar_usuario?al=" . $_SESSION["id_usa_alterar"] . "';
                        </script>";
                    } else {

                        echo "<script>
                        alert('As senhas inseridas não coincidem!');
                        location.href='alterar_usuario?al=" . $_SESSION["id_usa_alterar"] . "';
                        </script>";
                    }
                } catch (PDOException $erro) {
                    echo $erro->getMessage();
                }
            }
            ?>


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
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>


</body>

</html>

<script>
    //MOSTRA E OCULTA A SENHA
    function mostrarSenha() {
        var tipo = document.getElementById("novasenha");
        if (tipo.type == "password") {
            tipo.type = "text";
        } else {
            tipo.type = "password";
        }
    }

    function confirmSenha() {
        var tipo = document.getElementById("confirmnovasenha");
        if (tipo.type == "password") {
            tipo.type = "text";
        } else {
            tipo.type = "password";
        }
    }

    function check_form() {
        var inputs = document.getElementById("form").querySelectorAll("[required]");
        var len = inputs.length;
        var valid = true;
        for (var i = 0; i < len; i++) {
            if (!inputs[i].value) {
                valid = false;
            }
        }
        if (!valid) {
            var element = document.getElementById('btn-troca-senha');
            element.setAttribute('disabled', 'disabled');
            return false;
        } else {
            return true;
        }
    }
</script>

<!-- <script language="javascript">
    function moeda(a, e, r, t) {
        let n = "",
            h = j = 0,
            u = tamanho2 = 0,
            l = ajd2 = "",
            o = window.Event ? t.which : t.keyCode;
        a.value = a.value.replace('R$ ', '');
        if (n = String.fromCharCode(o),
            -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.replace('R$ ', '').length,
            h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
        for (l = ""; h < u; h++)
            -
            1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
            0 == (u = l.length) && (a.value = ""),
            1 == u && (a.value = "R$ 0" + r + "0" + l),
            2 == u && (a.value = "R$ 0" + r + l),
            u > 2) {
            for (ajd2 = "",
                j = 0,
                h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                    j = 0),
                ajd2 += l.charAt(h),
                j++;
            if (ajd2.length < 13) {
                for (a.value = "R$ ",
                    tamanho2 = ajd2.length,
                    h = tamanho2 - 1; h >= 0; h--)
                    a.value += ajd2.charAt(h);
                a.value += r + l.substr(u - 2, u)
            } else {

                a.value = "R$ ";

            }
        }
        return !1
    }
</script> -->

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
                        alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Recebe parametros da url
    function getUrlVars() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }


    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA RG
    // var rgMask = ['99.999.999-9', '99.999.999-9'];
    // var rg = document.querySelector('input[attrname=RG]');
    // VMasker(rg).maskPattern(rgMask[0]);
    // rg.addEventListener('input', inputHandler.bind(undefined, rgMask, 13), false);

    // MÁSCARA CPF
    var cpfMask = ['999.999.999-99', '999.999.999-99'];
    var cpf = document.querySelector('input[attrname=CPF]');
    VMasker(cpf).maskPattern(cpfMask[0]);
    cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

    // MÁSCARA TEL
    var telMask = ['(999) 9999-9999', '(999) 9999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);

    // MÁSCARA CEL
    // var celMask = ['(999) 99999-9999', '(999) 99999-9999'];
    // var cel = document.querySelector('input[attrname=celular]');
    // VMasker(cel).maskPattern(celMask[0]);
    // cel.addEventListener('input', inputHandler.bind(undefined, celMask, 16), false);

    // MÁSCARA DATA
    // var datanascMask = ['99/99/9999', '99/99/9999'];
    // var datanasc = document.querySelector('input[attrname=datanasc]');
    // VMasker(datanasc).maskPattern(datanascMask[0]);
    // datanasc.addEventListener('input', inputHandler.bind(undefined, datanascMask, 10), false);

    // MÁSCARA DATA
    // var dataadmisMask = ['99/99/9999', '99/99/9999'];
    // var dataadmis = document.querySelector('input[attrname=dataadmis]');
    // VMasker(dataadmis).maskPattern(dataadmisMask[0]);
    // dataadmis.addEventListener('input', inputHandler.bind(undefined, dataadmisMask, 10), false);

    // MÁSCARA CEP
    var cepMask = ['99999-9999', '99999-999'];
    var cep = document.querySelector('input[attrname=cep]');
    VMasker(cep).maskPattern(cepMask[0]);
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);

    // MÁSCARA DECIMAL
    // var decimalMask = ['$ 9.999.999,99','$ 999.999,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
    // var decimalMask = ['$ ,99','$ 9,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
    // var decimal = document.querySelector('input[attrname=decimal]');
    // VMasker(decimal).maskPattern(decimalMask[0]);
    // decimal.addEventListener('input', inputHandler.bind(undefined, decimalMask, 25), false);
</script>

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<script type="text/javascript">
    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade.php?search=', {
                    estado: $(this).val(),
                    ajax: 'true'
                }, function(j) {
                    var options =
                        '<option value="" selected disabled>Escolha a Cidade</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id_mun + '" namespace="' + j[i]
                            .cep_mun + '">' + j[i].nome_mun + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
            }
        });
    });
</script>

<!-- FIM ANIMAÇÃO RÁPIDA -->

<script>
    document.getElementById("estado").onchange = function() {

        // var select = document.getElementById("estado");

        // var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = '';

    }

    document.getElementById("cidade").onchange = function() {

        var select = document.getElementById("cidade");

        var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = cep;

    }

    $('.list-emp').click(function() {

        var link = $(this).attr("id");

        // Limpa outras seleções
        $('.list-emp').css({
            backgroundColor: "white"
        });

        // Destaca empresa selecionada
        $('#' + link).css({
            backgroundColor: "#eaecf4"

        });

        $('.emp-select').val(link);
    });


    $('document').ready(function() {

        var tab = getUrlVars()["tab"];

        if (tab == 3) {

            $('#menu-empresa-tab').addClass('active');
            $('#menu-empresa').addClass('show active');
        } else {

            $('#menu-geral-tab').addClass('active');
            $('#menu-geral').addClass('show active');
        }

    });

    $('document').ready(function() {

        var situac = $('.situac').attr("id");

        if (situac == 0) {

            $('#menu-empresa-tab').attr("hidden", true);
            $('#menu-empresa').attr("hidden", true);
        }
    });
</script>

<!-- MÁSCARA DE INPUT DECIMAL -->
<!-- <script>
    String.prototype.Moeda = function() {
        var v = this;
        v = v.replace(/\D/g,'')
        v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2")
        v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        v = v.replace(/^(\d)/g,"R$ $1")
        return v;
    }
</script>

<script type="text/javascript">

(function(view) {
    var valr_parc  = document.getElementsByClassName("valr-parc")[0];


    valr_parc.onkeyup =  function(){
        this.value = this.value.Moeda();
    };

})(this);
</script> -->

<!-- FIM MÁSCARA DE INPUT DECIMAL -->

<?php

// Atribui 1 empresa ao Usuario ADM
if (isset($_REQUEST["btn-inc"])) {

    try {

        $id_emp = $_POST["emp"];
        $id_usa = $_SESSION["id_usa_alterar"];

        $link = 'alterar_usuario?al=' . $id_usa . '&tab=3';

        preg_match('/\D/', $id_emp, $match);

        // FEA-010: Líder RH só pode vincular a empresas que ele mesmo acessa.
        if (!$is_admin_interno && !empty($id_emp) && empty($match)
            && !adminAcessaEmpresa($id_usa_default, (int) $id_emp)) {
            echo "<script language=javascript>
                Swal.fire({icon: 'error', title: 'Você não tem acesso a essa empresa.'})
                  .then((r) => { if (r.isConfirmed) location.href='" . $link . "'; });
            </script>";
            exit;
        }

        if (empty($match) && !empty($id_emp)) {

            insertGESVIN_usuario($id_emp, $id_usa);

            echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Empresa adicionada com Sucesso!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='" . $link . "';
                }
              })
            </script>";
        } else {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Selecione uma empresa da tabela Empresas Disponíveis!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='" . $link . "';
                }
            })
            </script>";
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Atribui todas as empresas ao Usuario ADM
if (isset($_REQUEST["btn-inc-all"])) {

    try {

        $id_usa = $_SESSION["id_usa_alterar"];

        $link = 'alterar_usuario?al=' . $id_usa . '&tab=3';

        // FEA-010: Líder RH só pode adicionar empresas que ele mesmo acessa.
        $emp_inc_all = $is_admin_interno
            ? selectGESEMP_emp_disponiveis($id_usa)
            : selectGESEMP_emp_disponiveis_lider($id_usa, $id_usa_default);
        foreach ($emp_inc_all as $linha) {

            $id_emp = $linha['id_emp'];

            if (!empty($id_emp)) {

                insertGESVIN_usuario($id_emp, $id_usa);
            }
        }

        if (!empty($id_emp)) {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Empresas adicionadas com Sucesso!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='" . $link . "';
                }
                })
            </script>";
        } else {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'info',
                title: 'Todas as empresas já foram adicionadas!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='" . $link . "';
                }
                })
            </script>";
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Remove acesso a 1 empresa do Usuario ADM
if (isset($_REQUEST["btn-exc"])) {

    try {

        $id_emp = $_POST["emp"];
        $id_usa = $_SESSION["id_usa_alterar"];

        $link = 'alterar_usuario?al=' . $id_usa . '&tab=3';

        preg_match('/\D/', $id_emp, $match);

        $id_emp = preg_replace('/\D+/', '', $id_emp);

        // FEA-010: Líder RH só pode remover vínculo de empresas que ele mesmo acessa.
        if (!$is_admin_interno && !empty($id_emp)
            && !adminAcessaEmpresa($id_usa_default, (int) $id_emp)) {
            echo "<script language=javascript>
                Swal.fire({icon: 'error', title: 'Você não tem acesso a essa empresa.'})
                  .then((r) => { if (r.isConfirmed) location.href='" . $link . "'; });
            </script>";
            exit;
        }

        if ($match != NULL) {

            if ($id_emp == $id_emp_default) {

                echo "<script language=javascript>
                Swal.fire({
                    icon: 'info',
                    title: 'Não é possivel remover a empresa default. <br>Favor inativar usuário!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href='tabela_usuarios';
                    }
                })
                </script>";
            } else {

                deleteGESVIN_usuario($id_emp, $id_usa);

                echo "<script language=javascript>
                Swal.fire({
                    icon: 'success',
                    title: 'Empresa removida com Sucesso!'
                }).then((result) => {
                    if (result.isConfirmed) {
                    location.href='" . $link . "';
                    }
                })
                </script>";
            }
        } else {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Selecione uma empresa da tabela Empresas Selecionadas!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='" . $link . "';
                }
            })
            </script>";
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Remove acesso a todas as empresas do Usuario ADM
if (isset($_REQUEST["btn-exc-all"])) {

    try {

        $id_usa = $_SESSION["id_usa_alterar"];

        $link = 'alterar_usuario?al=' . $id_usa . '&tab=3';

        // Define se existe só a empresa default para exclusão (se 1 - só empresa default, se 0 - maisn empresas)
        $exc_sucess = 1;

        // FEA-010: Líder RH só pode remover empresas que ele mesmo acessa.
        $emp_exc_all = $is_admin_interno
            ? selectGESEMP_emp_selecionadas($id_usa)
            : selectGESEMP_emp_selecionadas_lider($id_usa, $id_usa_default);
        foreach ($emp_exc_all as $linha) {

            $id_emp = $linha['id_emp'];

            if ($id_emp != $id_emp_default) {

                deleteGESVIN_usuario($id_emp, $id_usa);

                $exc_sucess = 0;
            }
        }

        if ($exc_sucess == 0) {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'success',
                title: 'Empresas removidas com Sucesso!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='" . $link . "';
                }
                })
            </script>";
        } else {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'info',
                title: 'Não é possivel remover a empresa default. <br>Favor inativar usuário!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href='tabela_usuarios';
                }
            })
            </script>";
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if (isset($_REQUEST["btn-submit"])) {

    try {

        $nome = $_POST["nome"];
        $cpf = $_POST["CPF"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $id_mun = $_POST["cidade"];
        $id_dep = $_POST["departamento"];
        $id_tus = $_POST["tus"];
        $endereco = $_POST["endereco"];
        $bairro = $_POST["bairro"];
        $complemento = $_POST["complemento"];
        $numero = $_POST["numero"];
        $cep = $_POST["cep"];

        // FEA-010: checkbox Líder RH + validações
        $id_usa_alvo_form = (int) $_SESSION["id_usa_alterar"];
        $is_lider_novo = isset($_POST["is_lider"]) && $_POST["is_lider"] == '1' ? 1 : 0;
        $is_lider_atual = checkLiderRH($id_usa_alvo_form, $id_emp_default) ? 1 : 0;

        // Promoção: estava 0, vai pra 1 — checar limite
        if ($is_lider_atual === 0 && $is_lider_novo === 1) {
            if ($lideres_ativos >= $limite_lideres) {
                echo "<script language=javascript>
                    alert('Limite de " . $limite_lideres . " Líderes RH ativos atingido. Desative um Líder antes de promover outro.');
                    location.href = 'alterar_usuario?al=" . $id_usa_alvo_form . "';
                </script>";
                exit;
            }
        }

        // Despromoção: estava 1, vai pra 0 — checar manter ≥1 Líder ativo
        if ($is_lider_atual === 1 && $is_lider_novo === 0 && $lideres_ativos <= 1) {
            echo "<script language=javascript>
                alert('É necessário manter pelo menos 1 Líder RH ativo na empresa. Promova outro admin a Líder antes de desmarcar este.');
                location.href = 'alterar_usuario?al=" . $id_usa_alvo_form . "';
            </script>";
            exit;
        }

        //CONVERTER TEXTO EM MAIUSCULO
        $nome = mb_strtoupper($nome, 'UTF-8');
        // $endereco = mb_strtoupper($endereco, 'UTF-8');
        // $bairro = mb_strtoupper($bairro, 'UTF-8');
        // $numero = mb_strtoupper($numero, 'UTF-8');

        $cpf = preg_replace('/\D/', '', $cpf);

        if ($email == "") {
            $email = NULL;
        } else {
            $email = $email;
        }
        if ($telefone == "") {
            $telefone = NULL;
        } else {
            $telefone = preg_replace('/\D/', '', $telefone);
        }
        if ($complemento == "") {
            $complemento = NULL;
        } else {
            $complemento = mb_strtoupper($complemento, 'UTF-8');
        }
        if ($endereco == "") {
            $endereco = NULL;
        } else {
            $endereco = mb_strtoupper($endereco, 'UTF-8');
        }
        if ($bairro == "") {
            $bairro = NULL;
        } else {
            $bairro = mb_strtoupper($bairro, 'UTF-8');
        }
        if ($numero == "") {
            $numero = NULL;
        } else {
            $numero = mb_strtoupper($numero, 'UTF-8');
        }
        if ($cep == "") {
            $cep = NULL;
        } else {
            $cep = str_replace('-', '', $cep);
        }

        $id_usa = $_SESSION["id_usa_alterar"];

        /*
        echo 'Nome: ' . $nome . '<br>';
        echo 'CPF: ' . $cpf . '<br>';
        echo 'datinc: ' . $datinc . '<br>';
        echo 'email: ' . $email . '<br>';
        echo 'telefone: ' . $telefone . '<br>';
        echo 'endereco: ' . $endereco . '<br>';
        echo 'bairro: ' . $bairro . '<br>';
        echo 'complemento: ' . $complemento . '<br>';
        echo 'numero: ' . $numero . '<br>';
        echo 'cep: ' . $cep . '<br>';
        echo 'id_tus: ' . $id_tus . '<br>'; // ID tipo de Usuario
        echo 'id_mun: ' . $id_mun . '<br>';
        echo 'id_dep: ' . $id_dep . '<br>';
        echo 'datatu: ' . $datatu . '<br>';
        echo 'id_usa: ' . $id_usa . '<br>';
        echo 'id_usa_default: ' . $id_usa_default . '<br>';
*/

        // SE usuario tipo ADMIN
        if ($id_tus == "") {

            // UPDATE COM O SELECT DO TIPO DE USUARIO ADMIN

            updateGESUSA_usuario_sem_id_tus($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_mun, $id_dep, $id_usa, $datatu, $id_usa_default);
        } else {

            updateGESUSA_usuario($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_tus, $id_mun, $id_dep, $id_usa, $datatu, $id_usa_default);
        }

        // FEA-010: persistir flag Líder RH em GESGES (insert se não existir, senão update)
        // + sincronizar permissões dos menus de gestão de admins (34/35/36)
        if (selectGESGES($id_usa, $id_emp_default) == 0) {
            insertGESGES($id_usa, $id_emp_default, $is_lider_novo);
        } else {
            updateGESGES($id_usa, $id_emp_default, $is_lider_novo);
        }
        upsertGESMPR_lider_menus($id_usa, $id_emp_default, $is_lider_novo, $datatu);

        echo "<script language=javascript>
        alert('Dados alterados com Sucesso!');
        location.href = 'tabela_usuarios';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>