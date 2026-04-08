<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

// UNSET DA VARIAVEIS DE SESSÃO
unset($_SESSION['alterar_colaborador']['token']);

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

    <title>GESTOU PORTAL - Alterar colaborador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="./style.css"> -->
    <!-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'> -->


    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- the main fileinput plugin script JS file -->
    <!-- <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script> -->

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

    <!-- <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'> -->

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top" onload="return check_form()">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php"; ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">

                        <!-- CARD HEADER -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar colaborador</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <?php $id_fun = $_SESSION["colaborador_editar"];

                            if (empty($id_fun)) {

                                echo "
                                <script>
                                  Swal.fire({
                                    icon: 'info',
                                    title: 'Info',
                                    title: 'Atenção!',
                                    text: 'Não há colaborador selecionado!'
                                  }).then((result) => {
                                        location.href='colaboradores';
                                  });
                                </script>
                                ";
                            } ?>

                            <div class="row m-auto">

                                <div class="dropdown no-arrow mb-4 m-auto">

                                    <div class="m-auto" id="div_teste" namespace="<?php echo $id_fun; ?>">
                                        <!-- <form action="test-image.php" id="croppie" method="post"> -->

                                        <label class="cabinet center-block">
                                            <figure style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                <?php foreach (selectGESUSU_FOTO($id_fun) as $foto_banco) {

                                                    $imagem = $foto_banco["imagem"];

                                                    if (!empty($imagem)) { ?>
                                                        <img src="../upload/cadastro/<?php echo $foto_banco["imagem"]; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                    <?php } else { ?>

                                                        <img src="../upload/cadastro/avatar_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                <?php }
                                                } ?>

                                            </figure>
                                            <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                                <div class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                    <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto de perfil</label>
                                                    <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                                </div>

                                                <?php if (!empty($imagem)) { ?>

                                                    <div class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                        <label for="btn-removerfoto"><i class="far fa-trash-alt mr-1"></i> Remover foto de perfil</label>
                                                        <input type="button" id="btn-removerfoto" style="width: 150px; display: none;" class="">
                                                    </div>

                                                <?php } else { ?>

                                                <?php } ?>

                                            </div>
                                        </label>

                                    </div>

                                </div>

                            </div>

                            <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="margin: auto !important; width: auto !important;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"> </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="upload-demo" class="center-block"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            <button type="button" name="cortar" id="cropImageBtn" class="btn btn-primary">Cortar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-identificacao-tab" data-toggle="tab" href="#menu-identificacao" role="tab" aria-controls="menu-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="menu-informacoes-tab" data-toggle="tab" href="#menu-informacoes" role="tab" aria-controls="menu-informacoes" aria-selected="false">Outras Informações</a>
                                    <a class="nav-item nav-link" id="menu-parametros-tab" data-toggle="tab" href="#menu-parametros" role="tab" aria-controls="menu-parametros" aria-selected="false">Parâmetros</a>
                                    <a class="nav-item nav-link" id="menu-cursos-tab" data-toggle="tab" href="#menu-cursos" role="tab" aria-controls="menu-cursos" aria-selected="false">Cursos/Exames</a>
                                    <a class="nav-item nav-link" id="menu-documentos-tab" data-toggle="tab" href="#menu-documentos" role="tab" aria-controls="menu-documentos" aria-selected="false">Documentos</a>
                                    <a class="nav-item nav-link" id="menu-observacoes-tab" data-toggle="tab" href="#menu-observacoes" role="tab" aria-controls="menu-observacoes" aria-selected="false">Observações</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" colaborador="<?php echo $id_fun; ?>" novalidate>

                                <!-- INICIO COL-MD-12 -->
                                <div class="col-md-12">

                                    <!-- INICIO DIV TAB-CONTENT -->
                                    <div class="tab-content" id="nav-tabContent">

                                        <!-- INÍCIO MENU GERAL -->
                                        <div class="tab-pane fade show active" id="menu-identificacao" role="tabpanel" aria-labelledby="menu-identificacao-tab">

                                            <?php foreach (selectGESUSU($id_fun) as $linha) {
                                                if ($linha != 0) { ?>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" maxlength="255" value="<?php echo $linha["nome"] ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido! Min. 3 caracteres!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="rg">RG</label>
                                                            <input type="text" class="form-control" id="rg" attrname="rg" name="rg" maxlength="14" value="<?php echo $linha["rg"] ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="cpf">CPF</label>
                                                            <input type="text" class="form-control" id="cpf" attrname="cpf" name="cpf" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" value="<?php echo $linha["cpf"] ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" maxlength="255" value="<?php echo $linha["email"] ?>" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="telefone">Telefone Comercial</label>
                                                            <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="<?php echo $linha["telefone"] ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="celular">Celular</label>
                                                            <input type="text" class="form-control" id="celular" attrname="celular" name="celular" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="<?php echo $linha["celular"] ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="departamento">Departamento</label>
                                                            <select class="form-control" id="departamento" name="departamento">

                                                                <?php foreach (selectGESDEP_id_usu($id_fun, $id_emp_default) as $dep_banco) {

                                                                    echo '<option value="' . $dep_banco['id_dep'] . '">' . $dep_banco['departamento'] . '</option>';
                                                                } ?>

                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="gestor">Gestor</label>
                                                            <select class="form-control" id="gestor" name="gestor">

                                                                <?php foreach (selectGESTOR_id_usu($id_fun, $id_emp_default) as $gestor_banco) {

                                                                    echo '<option value="' . $gestor_banco['id_usa'] . '">' . $gestor_banco['nome'] . '</option>';
                                                                } ?>

                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="datanasc">Data Nascimento</label>
                                                            <div class="d-flex">
                                                                <input type="text" class="form-control" style="width: 100% !important;" id="datanasc" attrname="datanasc" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datanasc" minlength="8" value="<?php if ($linha["datanascimento"] != NULL) {
                                                                                                                                                                                                                                                            $data = new DateTime($linha["datanascimento"]);
                                                                                                                                                                                                                                                            echo $data->format("d/m/Y");
                                                                                                                                                                                                                                                        } ?>">
                                                                <div class="pl-1">

                                                                    <!-- Verifica se ativo -->
                                                                    <?php if ($linha["situac"] == 1) {

                                                                        // Verifica se possui data de nascimento cadastrada
                                                                        if (!empty($linha["datanascimento"])) { ?>

                                                                            <button type="button" id="btn-aniversario" class="btn btn-primary ml-auto" id_usu="<?php echo $linha["id_usu"]; ?>">
                                                                                <i class="fas fa-birthday-cake"></i>
                                                                            </button>
                                                                            <!-- Senão possui -->
                                                                        <?php } else { ?>

                                                                            <button type="button" class="btn btn-secondary ml-auto" disabled>
                                                                                <i class="fas fa-birthday-cake"></i>
                                                                            </button>
                                                                        <?php }
                                                                        // Se inativo
                                                                    } else { ?>

                                                                        <button type="button" class="btn btn-secondary ml-auto" disabled>
                                                                            <i class="fas fa-birthday-cake"></i>
                                                                        </button>

                                                                    <?php } ?>

                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label for="dataadmis">Data Admissão</label>
                                                            <input type="text" class="form-control" id="dataadmis" attrname="dataadmis" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="dataadmis" minlength="8" value="<?php if ($linha["dataadmissao"] != NULL) {
                                                                                                                                                                                                                            $data = new DateTime($linha["dataadmissao"]);
                                                                                                                                                                                                                            echo $data->format("d/m/Y");
                                                                                                                                                                                                                        } ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                        <!-- FIM MENU GERAL -->

                                        <!-- INÍCIO MENU ENDEREÇO -->
                                        <div class="tab-pane fade" id="menu-endereco" role="tabpanel" aria-labelledby="menu-endereco-tab">

                                            <div class="form-row">
                                                <div class="col-md-10 mb-3">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" maxlength="255" value="<?php echo $linha["endereco"] ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero" maxlength="10" value="<?php echo $linha["numero"] ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" maxlength="25" value="<?php echo $linha["bairro"] ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" maxlength="25" value="<?php echo $linha["complemento"] ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="estado">Estado</label>

                                                    <!-- <select id="estado" name="estado" class="form-control" required>
                                                        ?php
                                                        foreach (selectGESUSU($id_fun) as $info_banco) {
                                                            $cep = $info_banco['cep'];
                                                            $estado = $info_banco['estado'];
                                                        }
                                                        foreach (select_ESTADO_id_usu($id_fun) as $estado_banco) {
                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        }
                                                        ?>
                                                    </select> -->

                                                    <select id="estado" name="estado" class="form-control" required>

                                                        <?php if (!empty($id_fun)) {

                                                            foreach (select_ESTADO_campo('id_usu', $id_fun, $id_usa_default, $id_emp_default) as $estado_banco) {
                                                                echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                                $estado = $estado_banco['estado_atual'];
                                                            }
                                                        } else {

                                                            foreach (select_ESTADO_campo('id_emp', $id_fun, $id_usa_default, $id_emp_default) as $estado_banco) {
                                                                echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                                $estado = $estado_banco['estado_atual'];
                                                            }
                                                        } ?>
                                                    </select>



                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>

                                                        <?php if (!empty($id_fun)) {
                                                            foreach (select_CIDADE_campo('id_usu', $id_fun, $id_usa_default, $id_emp_default, $estado) as $cidade_banco) {
                                                                echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                                $cep = $cidade_banco['cep'];
                                                            }
                                                        } else {

                                                            foreach (select_CIDADE_campo('id_emp', $id_fun, $id_usa_default, $id_emp_default, $estado) as $cidade_banco) {
                                                                echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                                $cep = $cidade_banco['cep'];
                                                            }
                                                        } ?>
                                                    </select>


                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="cep">CEP</label>
                                                    <input type="text" class="form-control" id="cep" attrname="cep" name="cep" maxlength="10" value="<?php echo $linha["cep"] ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU ENDEREÇO -->

                                        <!-- INÍCIO MENU INFORMAÇÕES -->
                                        <div class="tab-pane fade" id="menu-informacoes" role="tabpanel" aria-labelledby="menu-informacoes-tab">

                                            <div class="form-row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="pis">PIS</label>
                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="pis" name="pis" maxlength="25" value="<?php echo $linha["pis"] ?>">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="ctps">CTPS</label>
                                                    <input type="text" class="form-control" id="ctps" name="ctps" maxlength="25" value="<?php echo $linha["ctps"] ?>">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="titulo_eleitor">Título Eleitor</label>
                                                    <input type="text" class="form-control" id="titulo_eleitor" name="titulo_eleitor" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="25" value="<?php echo $linha["titulo_eleitor"] ?>">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="cbo">CBO</label>
                                                    <input type="text" class="form-control" id="cbo" name="cbo" maxlength="25" value="<?php echo $linha["cbo"] ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="linkedin">Linkedin</label>
                                                    <input type="text" class="form-control" id="linkedin" name="linkedin" maxlength="255" value="<?php echo $linha["linkedin"] ?>">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="tiposalario">Tipo Salário</label>
                                                    <select class="form-control" name="tiposalario" id="tiposalario">
                                                        <?php if ($linha["tpsalario"] == NULL) { ?>
                                                            <option value="" selected>Escolha uma opção</option>
                                                            <option value="D">Diarista</option>
                                                            <option value="M">Mensalista</option>
                                                            <option value="P">Pró-Labore</option>
                                                        <?php }
                                                        if ($linha["tpsalario"] == "D") { ?>
                                                            <option value="D" selected>Diarista</option>
                                                            <option value="M">Mensalista</option>
                                                            <option value="P">Pró-Labore</option>
                                                        <?php }
                                                        if ($linha["tpsalario"] == "M") { ?>
                                                            <option value="M" selected>Mensalista</option>
                                                            <option value="D">Diarista</option>
                                                            <option value="P">Pró-Labore</option>
                                                        <?php }
                                                        if ($linha["tpsalario"] == "P") { ?>
                                                            <option value="P" selected>Pró-Labore</option>
                                                            <option value="D">Diarista</option>
                                                            <option value="M">Mensalista</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="salario">Salário</label>
                                                    <input type="text" class="form-control" id="salario" placeholder="R$" name="salario" maxlength="12" onKeyPress="return(moeda(this,'.',',',event))" value="R$ <?php echo number_format($linha["salario"], 2, ",", "."); ?>">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="dependentes">Dependentes</label>
                                                    <input type="number" class="form-control" id="dependentes" name="dependentes" max="99" min="0" pattern="[0-9]{1,2}" value="<?php echo $linha["dependentes"] ?>" onkeydown="return false;">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="funcao">Função</label>
                                                    <input type="text" class="form-control" id="funcao" style="text-transform:uppercase" name="funcao" maxlength="255" value="<?php echo $linha["funcao"] ?>">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control" name="sexo" id="sexo">
                                                        <?php if ($linha["sexo"] == NULL) { ?>
                                                            <option value="" selected disabled>Escolha uma opção</option>
                                                            <option value="F">Feminino</option>
                                                            <option value="M">Masculino</option>
                                                        <?php } else if ($linha["sexo"] == "F") { ?>
                                                            <option value="F" selected>FEMININO</option>
                                                            <option value="M">MASCULINO</option>
                                                        <?php } else if ($linha["sexo"] == "M") { ?>
                                                            <option value="M" selected>MASCULINO</option>
                                                            <option value="F">FEMININO</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="escolaridade">Escolaridade</label>
                                                    <select class="form-control" name="escolaridade" id="escolaridade">
                                                        <?php if ($linha["escolaridade"] == NULL) { ?>
                                                            <option value="" selected>Escolha uma opção</option>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "1") { ?>
                                                            <option value="1" selected>Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "2") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2" selected>Ensino Fundamental Incompleto
                                                            </option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "3") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3" selected>Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "4") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4" selected>Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "5") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5" selected>Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "6") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6" selected>Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "7") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7" selected>Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "8") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8" selected>Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "9") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9" selected>Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "A") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A" selected>Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "B") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B" selected>Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "C") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C" selected>Doutorado</option>
                                                            <option value="D">Pós Doutorado</option>
                                                        <?php }
                                                        if ($linha["escolaridade"] == "D") { ?>
                                                            <option value="1">Analfabeto</option>
                                                            <option value="2">Ensino Fundamental Incompleto</option>
                                                            <option value="3">Ensino Fundamental Completo</option>
                                                            <option value="4">Ensino Médio Incompleto</option>
                                                            <option value="5">Ensino Médio Completo</option>
                                                            <option value="6">Ensino Técnico Incompleto</option>
                                                            <option value="7">Ensino Técnico Completo</option>
                                                            <option value="8">Ensino Superior Incompleto</option>
                                                            <option value="9">Ensino Superior Completo</option>
                                                            <option value="A">Pós Graduação</option>
                                                            <option value="B">Mestrado</option>
                                                            <option value="C">Doutorado</option>
                                                            <option value="D" selected>Pós Doutorado</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="dataadmis">Data Rescisão</label>
                                                    <input type="text" class="form-control" id="datarescisao" attrname="datarescisao" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datarescisao" minlength="8" value="<?php
                                                                                                                                                                                                                        if ($linha["datarescisao"] != NULL) {
                                                                                                                                                                                                                            $data = new DateTime($linha["datarescisao"]);
                                                                                                                                                                                                                            echo $data->format("d/m/Y");
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                        } ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU OUTRAS INFORMAÇÕES -->

                                        <!-- INÍCIO MENU PARAMETROS -->
                                        <div class="tab-pane fade" id="menu-parametros" role="tabpanel" aria-labelledby="menu-parametros-tab">

                                            <div class="form-row">

                                                <div class="col-md-2 mb-3">
                                                    <label for="cod_integracao">Cód. Integração</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="cod_integracao" name="cod_integracao" maxlength="25" value="<?php echo $linha["cod_integracao"] ?>">
                                                    <!-- <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div> -->
                                                </div>

                                            </div>

                                            <div class="form-row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="agrdep"></label>
                                                        <div class="custom-control custom-checkbox">
                                                            <?php if ($linha["agrdep"] == 0) { ?>
                                                                <input disabled type="checkbox" class="custom-control-input" value="1" name="agrdep" id="agrdep">
                                                            <?php }
                                                            if ($linha["agrdep"] == 1) { ?>
                                                                <input disabled type="checkbox" class="custom-control-input" value="1" name="agrdep" id="agrdep" checked>
                                                            <?php } ?>
                                                            <label class="custom-control-label" for="agrdep" style="user-select: none;">Agrupa por departamento?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bloqueado"></label>
                                                        <div class="custom-control custom-checkbox">
                                                            <?php if ($linha["bloqueado"] == 0) { ?>
                                                                <input type="checkbox" class="custom-control-input" value="1" name="bloqueado" id="bloqueado">
                                                            <?php }
                                                            if ($linha["bloqueado"] == 1) { ?>
                                                                <input type="checkbox" class="custom-control-input" value="1" name="bloqueado" id="bloqueado" checked>
                                                            <?php } ?>
                                                            <label class="custom-control-label" for="bloqueado" style="user-select: none;">Bloqueado?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU PARAMETROS -->

                                        <!-- INÍCIO MENU CURSOS/EXAMES -->
                                        <div class="tab-pane fade" id="menu-cursos" role="tabpanel" aria-labelledby="menu-cursos-tab">

                                            <div class="form-row">

                                                <div class="col-md-6 mb-0 d-flex align-items-end" style="margin-top: 5px;">
                                                    Dentro da Validade
                                                </div>

                                                <div class="col-md-6 mb-2 w-100 d-flex">
                                                    <button type="button" id="lancar-curso" class="btn btn-organograma btn-icon-split-organograma ml-auto">
                                                        <i class="fas fa-plus-circle mr-sm-2"></i> Lançar
                                                    </button>
                                                </div>

                                                <!-- LANÇAMENTOS ATIVOS -->
                                                <div class="col-md-12" style="height: 200px; overflow-y: auto; scrollbar-width: thin; margin-bottom: 16px;">
                                                    <div style="min-height: 100%; max-height: auto; border: 1px solid #e3e6f0; border-top: none;">
                                                        <table class="table sortable" cellspacing="0">
                                                            <thead style="text-align: center;">
                                                                <tr class="list-head">
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Cód</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 40%; vertical-align: middle;">Curso/Exame</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Referência</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Validade</th>
                                                                    <th data-orderable="false" style="width: 30%; vertical-align: middle;">Observação</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php foreach (selectGESLCM_ativos($id_fun) as $linha2) {

                                                                    if (!empty($linha2)) {

                                                                        $id_lcm = $linha2['id_lcm'];
                                                                        $curso_exame = $linha2['curso_exame'];
                                                                        $referencia = new DateTime($linha2['datref']);
                                                                        $validade = new DateTime($linha2['prodat']);
                                                                        $observacao = $linha2['observ']; ?>

                                                                        <tr style="border-bottom: 1px solid #e3e6f0;">
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $id_lcm; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo '<b>' . $curso_exame . '</b>'; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $referencia->format("d/m/Y");; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $validade->format("d/m/Y");; ?></th>
                                                                            <th style="text-align: center; padding: 5px;"><?php echo $observacao; ?></th>
                                                                        </tr>

                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    Histórico
                                                </div>

                                                <!-- LANÇAMENTOS INATIVOS -->
                                                <div class="col-md-12" style="margin-bottom: 16px;">
                                                    <div style="border: 1px solid #e3e6f0; border-top: none; height: 200px; overflow-y: auto; scrollbar-width: thin;">
                                                        <table class="table sortable" cellspacing="0">
                                                            <thead style="text-align: center;">
                                                                <tr class="list-head">
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Cód</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 40%; vertical-align: middle;">Curso/Exame</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Referência</th>
                                                                    <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 10%; vertical-align: middle;">Validade</th>
                                                                    <th data-orderable="false" style="width: 30%; vertical-align: middle;">Observação</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php foreach (selectGESLCM_vencido($id_fun) as $linha2) {

                                                                    if (!empty($linha2)) {

                                                                        $id_lcm = $linha2['id_lcm'];
                                                                        $curso_exame = $linha2['curso_exame'];
                                                                        $referencia = new DateTime($linha2['datref']);
                                                                        $validade = new DateTime($linha2['prodat']);
                                                                        $observacao = $linha2['observ']; ?>

                                                                        <tr style="border-bottom: 1px solid #e3e6f0;">
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $id_lcm; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo '<b>' . $curso_exame . '</b>'; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $referencia->format("d/m/Y");; ?></th>
                                                                            <th style="border-right: 1px solid #e3e6f0; text-align: center; padding: 5px;"><?php echo $validade->format("d/m/Y");; ?></th>
                                                                            <th style="text-align: center; padding: 5px;"><?php echo $observacao; ?></th>
                                                                        </tr>

                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- FIM MENU CURSOS/EXAMES -->

                                        <!-- INICIO MENU DOCUMENTOS -->
                                        <div class="tab-pane fade" id="menu-documentos" role="tabpanel" aria-labelledby="menu-documentos-tab">

                                            <div class="col-md-12 mb-2 w-100 d-flex">
                                                <button type="button" id="incluir_documento" class="btn btn-organograma btn-icon-split-organograma ml-auto">
                                                    <i class="fas fa-plus-circle mr-sm-2"></i> Incluir
                                                </button>
                                            </div>

                                            <div>

                                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                                    <!-- INICIO THEAD -->
                                                    <thead>
                                                        <tr>
                                                            <th data-orderable="false" style="vertical-align: middle;">Descrição</th>
                                                            <th data-orderable="false" style="vertical-align: middle;">Tipo</th>
                                                            <th data-orderable="false" style="vertical-align: middle;">Competência</th>
                                                            <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="vertical-align: middle;">Ações</th>
                                                        </tr>
                                                    </thead>

                                                    <!-- INICIO TFOOT -->
                                                    <tfoot>
                                                        <tr>
                                                            <th rowspan="1" colspan="1">Descrição</th>
                                                            <th rowspan="1" colspan="1">Tipo</th>
                                                            <th rowspan="1" colspan="1">Competência</th>
                                                            <th style="text-align: center;" rowspan="1" colspan="1">Ações</th>
                                                        </tr>
                                                    </tfoot>

                                                    <!-- INICIO TBODY -->
                                                    <tbody class="texto-table-body recibos">

                                                        <?php foreach (select_DOCUMENTOS($raiz_cnpj, $id_fun, $_SESSION['id_emp_default']) as $select) {

                                                            if (!empty($select)) {

                                                                $token = bin2hex(random_bytes(16));

                                                                $_SESSION['alterar_colaborador']['token'][$token]['codigo'] = $select['codigo'];
                                                                $_SESSION['alterar_colaborador']['token'][$token]['arquivo'] = $select['arquivo'];
                                                                $_SESSION['alterar_colaborador']['token'][$token]['descricao'] = $select['descricao'];
                                                                $_SESSION['alterar_colaborador']['token'][$token]['competencia'] = $select['competencia'];
                                                                $_SESSION['alterar_colaborador']['token'][$token]['tipo'] = $select['tipo'];

                                                                $descricao = $select['descricao'];
                                                                $competencia = $select['competencia'];
                                                                $tipo = $select['tipo']; ?>

                                                                <tr data-token="<?php echo $token; ?>">

                                                                    <!-- DESCRIÇÃO -->
                                                                    <td style="width: 40%;">
                                                                        <span class="m-0 text-primary tamanho-text"><?php echo $descricao; ?></span>
                                                                    </td>

                                                                    <!-- TIPO -->
                                                                    <td style="width: 20%;"><?php echo $tipo; ?></td>

                                                                    <!-- COMPETENCIA -->
                                                                    <td style="width: 30%;"><?php echo $competencia; ?></td>

                                                                    <!-- AÇÃO -->
                                                                    <td style="text-align: center; width: 10%;">

                                                                        <button type="button" class="btn btn-outline-primary visualizar_pdf" title="Anexo">Anexo</button>
                                                                    </td>
                                                                </tr>

                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                    <!-- FIM TBODY -->
                                                </table>

                                            </div>
                                        </div>
                                        <!-- FIM MENU DOCUMENTOS -->

                                        <!-- INICIO MENU OBSERVAÇÕES - FEA-004 -->
                                        <div class="tab-pane fade" id="menu-observacoes" role="tabpanel" aria-labelledby="menu-observacoes-tab">

                                            <div class="col-md-12 mb-2 w-100 d-flex">
                                                <button type="button" id="btn-gerenciar-categorias" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-tags mr-sm-1"></i> Gerenciar Categorias
                                                </button>
                                                <button type="button" id="btn-nova-observacao" class="btn btn-organograma btn-icon-split-organograma ml-auto">
                                                    <i class="fas fa-plus-circle mr-sm-2"></i> Nova Observação
                                                </button>
                                            </div>

                                            <div>
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="vertical-align: middle; width: 15%;">Data</th>
                                                            <th style="vertical-align: middle; width: 20%;">Categoria</th>
                                                            <th style="vertical-align: middle; width: 50%;">Descrição</th>
                                                            <th style="vertical-align: middle; width: 15%; text-align: center;">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="texto-table-body">
                                                        <?php
                                                        $observacoes = selectObservacoes_colaborador($id_fun, $cnpj_completo);
                                                        if (!empty($observacoes)) {
                                                            foreach ($observacoes as $obs) {
                                                                if (!empty($obs) && is_array($obs)) {
                                                                    $data_obs_fmt = (new DateTime($obs['data_observacao']))->format('d/m/Y');
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $data_obs_fmt; ?></td>
                                                            <td><?php echo htmlspecialchars($obs['categoria_nome']); ?></td>
                                                            <td><?php echo htmlspecialchars($obs['descricao']); ?></td>
                                                            <td style="text-align: center;">
                                                                <button type="button" class="btn btn-sm btn-outline-danger btn-deletar-observacao" data-id="<?php echo $obs['id']; ?>" title="Deletar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                            }
                                                        } else { ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">Nenhuma observação registrada.</td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- FIM MENU OBSERVAÇÕES -->

                                <?php }
                                            } ?>

                                    </div>
                                    <!-- FIM DIV TAB-CONTENT -->

                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="button" id="btn-troca-senha" data-toggle="modal" data-target="#TrocarSenha" name="modal" class="btn btn-organograma btn-icon-split-organograma">
                                                <i class="fas fa-unlock mr-sm-2"></i> Trocar Senha
                                            </button>
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
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

            <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
            <!-- --------------------------------------------------- INICIO MODAIS -------------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->


            <!-- Aniversario Modal-->
            <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 635px;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Aniversário Imagem</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                            <span id="visuCartao"></span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" id="baixar">Baixar Cartão</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
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
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="troca-senha">Senha</label>
                                        <input type="password" id="troca-senha" name="troca-senha" class="form-control" minlength="3" required>
                                        <i class="fas fa-eye-slash lnr-eye-modal toggle-eye"></i>
                                        </input>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="confirm-senha">Confirmar Senha</label>
                                        <input type="password" id="confirm-senha" name="confirm-senha" class="form-control" minlength="3" required>
                                        <i class="fas fa-eye-slash lnr-eye1-modal toggle-eye"></i>
                                        </input>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-senha" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock"></i> Alterar</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL NOVA OBSERVAÇÃO - FEA-004 -->
            <div class="modal fade" id="modal-nova-observacao" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nova Observação</h5>
                            <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="form-nova-observacao">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="data-obs">Data</label>
                                        <input type="date" class="form-control" id="data-obs" name="data_observacao" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="categoria-select">Categoria</label>
                                        <select class="form-control" id="categoria-select" name="categoria_id">
                                            <option value="">Sem categoria</option>
                                            <?php
                                            $categorias = selectCategorias_observacao($cnpj_completo);
                                            foreach ($categorias as $cat) {
                                                if (!empty($cat) && is_array($cat)) {
                                                    echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['nome']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="descricao-obs">Descrição <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="descricao-obs" name="descricao" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Salvar</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MODAL GERENCIAR CATEGORIAS - FEA-004 -->
            <div class="modal fade" id="modal-gerenciar-categorias" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 40vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Gerenciar Categorias</h5>
                            <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-bordered" id="tabela-categorias">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 80px; text-align: center;">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($categorias)) {
                                        foreach ($categorias as $cat) {
                                            if (!empty($cat) && is_array($cat)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cat['nome']); ?></td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-desativar-categoria" data-id="<?php echo $cat['id']; ?>" title="Desativar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }
                                        }
                                    } ?>
                                </tbody>
                            </table>
                            <hr>
                            <form id="form-nova-categoria" class="form-inline">
                                <input type="text" class="form-control form-control-sm mr-2" id="nome-categoria" name="nome_categoria" placeholder="Nome da categoria" maxlength="100" required style="flex: 1;">
                                <button type="submit" class="btn btn-sm btn-organograma"><i class="fas fa-plus"></i> Adicionar</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL LANÇAR CURSOS/EXAMES -->
            <div class="modal fade" id="modal-lancar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-lancar" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 50vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lançar Cursos/Exames</h5>
                            <button class="close close-modal" type="button">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="form-modal-lancar" class="needs-validation" novalidate>
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                <div class="col-md-12">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="colab">Colaborador:</label>
                                            <?php foreach (selectGESUSU($id_fun) as $select_gesusu_id) {

                                                echo '<input type="text" name="colab" id="colab" class="form-control" minlength="3" maxlength="255" value="' . $select_gesusu_id['nome'] . '" disabled>';
                                            } ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="curso">Curso/Exame:</label>
                                            <select name="curso" class="form-control" id="curso" required>
                                                <option value="">Escolha um Curso/Exame</option>
                                                <?php foreach (selectGESCUR_emp($id_emp_default) as $select_gescur_emp) {

                                                    echo '<option value="' . $select_gescur_emp['id_cur'] . '">' . $select_gescur_emp['descri'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="referencia">Data de Referência:</label>
                                            <input type="text" id="referencia" name="referencia" attrname="referencia" class="form-control" placeholder="Data de inicio do Curso/Exame" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="vencimento">Data de Vencimento:</label>
                                            <input type="text" id="vencimento" name="vencimento" attrname="vencimento" class="form-control" placeholder="Data de vencimento do Curso/Exame" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="observacao">Observação</label>
                                            <input type="text" name="observacao" id="observacao" style="text-transform:uppercase" class="form-control" minlength="3" maxlength="255">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-organograma btn-icon-split-organograma">
                                    <i class="fas fa-plus-circle"></i> Salvar
                                </button>
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MODAL VISUALIZAR ANEXO -->
            <div id="anexo_modal" class="modal fade" id="anexo_modal" tabindex="-1" role="dialog" aria-labelledby="anexo_modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title_modal_anexo">Anexo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 80vh; overflow-x: auto;">
                            <span id="visuAnexo"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL SALVAR ANEXO -->
            <div class="modal fade" id="modal-salvar-doc" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="modal-salvar-doc">
                <div class="modal-dialog modal-dialog-centered pt-5" role="document" style="width: 50vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Salvar Documentos</h5>
                            <button class="close close-modal" type="button">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="form-salvar-doc" class="needs-validation" novalidate>
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto; scrollbar-width: thin;">
                                <div class="col-md-12">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="salvar_doc_colab">Colaborador:</label>
                                            <?php foreach (selectGESUSU($id_fun) as $select_gesusu_id) {

                                                echo '<input type="text" name="salvar_doc_colab" id="salvar_doc_colab" class="form-control" minlength="3" maxlength="255" value="' . $select_gesusu_id['nome'] . '" disabled>';
                                            } ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="salvar_doc_tipo">Tipo:</label>
                                            <select name="salvar_doc_tipo" class="form-control" id="salvar_doc_tipo" disabled required>
                                                <option value="Documento" selected>Documento</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="salvar_doc_descricao">Descrição:</label>
                                            <input type="text" id="salvar_doc_descricao" name="salvar_doc_descricao" attrname="salvar_doc_descricao" class="form-control" placeholder="Descrição do Documento" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="salvar_doc_competencia">Competência:</label>
                                            <input type="text" id="salvar_doc_competencia" name="salvar_doc_competencia" attrname="salvar_doc_competencia" class="form-control" placeholder="Data de competência/inclusão do documento" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="input-b1">Anexar</label><br>
                                            <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf, .PDF" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="btn_submit_doc" class="btn btn-organograma btn-icon-split-organograma">
                                    <i class="fas fa-plus-circle"></i> Salvar
                                </button>
                                <button class="btn btn-secondary close-modal" type="button">Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
            <!-- ------------------------------------------------------ FIM MODAIS -------------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

            <!-- FOOTER -->
            <?php include_once "footer.php" ?>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- REQUISITOS MÁSCARAS JS -->
    <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

    <!-- REQUIRE CROPPIE -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <!-- partial -->
    <script src="./croppie/script_colaborador.js"></script>

    <script src="js/dom-to-image.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- JS DA PAGINA -->
    <script src="scripts/alterar_colaborador.js?version=<?php echo time(); ?>"></script>

    <!-- FEA-004: Observações do colaborador -->
    <script>
    $(function() {
        // Abrir modal nova observação
        $(document).on('click', '#btn-nova-observacao', function() {
            $('#modal-nova-observacao').modal('show');
        });

        // Abrir modal gerenciar categorias
        $(document).on('click', '#btn-gerenciar-categorias', function() {
            $('#modal-gerenciar-categorias').modal('show');
        });

        // Submit nova observação
        $('#form-nova-observacao').submit(function(event) {
            event.preventDefault();
            var descricao = $('#descricao-obs').val().trim();
            if (descricao === '') {
                Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Preencha a descrição.' });
                return;
            }
            var dados = {
                submit_nova_observacao: 1,
                descricao: descricao,
                data_observacao: $('#data-obs').val(),
                categoria_id: $('#categoria-select').val()
            };
            $.post('controller/alterar_colaborador_post.php', dados, function(retorno) {
                if (retorno == '1') {
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Observação adicionada!', allowOutsideClick: false })
                    .then(function(result) { if (result.isConfirmed) location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', html: retorno });
                }
            });
        });

        // Deletar observação
        $(document).on('click', '.btn-deletar-observacao', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Confirmar?', text: 'Deseja deletar esta observação?', icon: 'warning',
                showCancelButton: true, confirmButtonText: 'Sim, deletar', cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.post('controller/alterar_colaborador_post.php', { delete_observacao: 1, id_observacao: id }, function(retorno) {
                        if (retorno == '1') {
                            Swal.fire({ icon: 'success', title: 'Deletado!', allowOutsideClick: false })
                            .then(function(result) { if (result.isConfirmed) location.reload(); });
                        }
                    });
                }
            });
        });

        // Submit nova categoria
        $('#form-nova-categoria').submit(function(event) {
            event.preventDefault();
            var nome = $('#nome-categoria').val().trim();
            if (nome === '') {
                Swal.fire({ icon: 'warning', title: 'Atenção!', text: 'Preencha o nome da categoria.' });
                return;
            }
            $.post('controller/alterar_colaborador_post.php', { submit_nova_categoria: 1, nome_categoria: nome }, function(retorno) {
                if (retorno == '1') {
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Categoria adicionada!', allowOutsideClick: false })
                    .then(function(result) { if (result.isConfirmed) location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Erro', html: retorno });
                }
            });
        });

        // Desativar categoria
        $(document).on('click', '.btn-desativar-categoria', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Confirmar?', text: 'Deseja desativar esta categoria?', icon: 'warning',
                showCancelButton: true, confirmButtonText: 'Sim', cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.post('controller/alterar_colaborador_post.php', { inactivate_categoria: 1, id_categoria: id }, function(retorno) {
                        if (retorno == '1') {
                            Swal.fire({ icon: 'success', title: 'Desativada!', allowOutsideClick: false })
                            .then(function(result) { if (result.isConfirmed) location.reload(); });
                        }
                    });
                }
            });
        });
    });
    </script>

</body>

</html>