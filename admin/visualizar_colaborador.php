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

    <title>GESTOU PORTAL - Visualizar Colaborador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

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
                <?php include_once "barra_superior.php"; ?>

                <!-- INICIO PAGE CONTENT -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- INICIO CARD SHADOW -->
                    <div class="card shadow mb-4">

                        <!-- CARD HEADER -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Visualizar Colaborador</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

                            <?php

                            $id_fun = $_SESSION["colaborador_visualizar"];

                            if (empty($id_fun)) {

                                echo "
                                <script>
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Info',
                                    title: 'Atenção!',
                                    text: 'Não há colaborador selecionado!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href='tabela_colaboradores';
                                    }else{
                                        location.href='tabela_colaboradores';
                                    }
                                });
                                </script>
                                ";
                            } ?>

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-identificacao-tab" data-toggle="tab" href="#menu-identificacao" role="tab" aria-controls="menu-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="menu-informacoes-tab" data-toggle="tab" href="#menu-informacoes" role="tab" aria-controls="menu-informacoes" aria-selected="false">Outras Informações</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <div class="col-md-12">

                                <!-- INÍCIO MENU IDENTIFICAÇÃO -->
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="menu-identificacao" role="tabpanel" aria-labelledby="menu-identificacao-tab">

                                        <?php

                                        foreach (selectGESUSU($id_fun) as $linha) {

                                            if ($linha != 0) {

                                        ?>

                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" value="<?php echo $linha["nome"] ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido! Min. 3 caracteres!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="RG">RG</label>
                                                        <input type="text" class="form-control" id="RG" attrname="RG" name="RG" maxlength="15" value="<?php echo $linha["rg"] ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="CPF">CPF</label>
                                                        <input type="text" class="form-control" id="CPF" attrname="CPF" name="CPF" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" value="<?php echo $linha["cpf"] ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $linha["email"] ?>" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="telefone">Telefone</label>
                                                        <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9]{4}-[0-9]{4}" minlength="15" value="<?php echo $linha["telefone"] ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="celular">Celular</label>
                                                        <input type="text" class="form-control" id="celular" attrname="celular" name="celular" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" value="<?php echo $linha["celular"] ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="departamento">Departamento</label>
                                                        <select class="form-control" id="departamento" name="departamento" disabled>
                                                            <?php

                                                            foreach (selectGESDEP_id_usu($id_fun, $id_emp_default) as $dep_banco) {

                                                                echo '<option value="' . $dep_banco['id_dep'] . '">' . $dep_banco['departamento'] . '</option>';
                                                            }

                                                            ?>

                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="gestor">Gestor</label>
                                                        <select class="form-control" id="gestor" name="gestor" disabled>
                                                            <?php

                                                            foreach (selectGESTOR_id_usu($id_fun, $id_emp_default) as $gestor_banco) {

                                                                echo '<option value="' . $gestor_banco['id_usa'] . '">' . $gestor_banco['nome'] . '</option>';
                                                            }

                                                            ?>

                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="datanasc">Data Nascimento</label>
                                                        <input type="text" class="form-control" id="datanasc" attrname="datanasc" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datanasc" minlength="8" value="<?php
                                                                                                                                                                                                                if ($linha["datanascimento"] != NULL) {
                                                                                                                                                                                                                    $data = new DateTime($linha["datanascimento"]);
                                                                                                                                                                                                                    echo $data->format("d/m/Y");
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                } ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="dataadmis">Data Admissão</label>
                                                        <input type="text" class="form-control" id="dataadmis" attrname="dataadmis" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="dataadmis" minlength="8" value="<?php
                                                                                                                                                                                                                    if ($linha["dataadmissao"] != NULL) {
                                                                                                                                                                                                                        $data = new DateTime($linha["dataadmissao"]);
                                                                                                                                                                                                                        echo $data->format("d/m/Y");
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                    } ?>" disabled>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                    <!-- FIM MENU IDENTIFICAÇÃO -->

                                    <!-- INÍCIO MENU ENDEREÇO -->
                                    <div class="tab-pane fade" id="menu-endereco" role="tabpanel" aria-labelledby="menu-endereco-tab">

                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="endereco">Endereço</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" value="<?php echo $linha["endereco"] ?>" disabled>
                                                <div class="invalid-feedback">
                                                    Inválido!
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bairro">Bairro</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" value="<?php echo $linha["bairro"] ?>" disabled>
                                                <div class="invalid-feedback">
                                                    Inválido!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-10 mb-3">
                                                <label for="complemento">Complemento</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" value="<?php echo $linha["complemento"] ?>" disabled>
                                                <div class="invalid-feedback">
                                                    Inválido!
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="numero">Número</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero" value="<?php echo $linha["numero"] ?>" disabled>
                                                <div class="invalid-feedback">
                                                    Inválido!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="estado">Estado</label>
                                                <select id="estado" name="estado" class="form-control" disabled>
                                                    <?php

                                                    foreach (selectGESUSU($id_fun) as $info_banco) {

                                                        $cep = $info_banco['cep'];
                                                        $estado = $info_banco['estado'];
                                                    }

                                                    foreach (select_ESTADO_id_usu($id_fun) as $estado_banco) {

                                                        echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cidade">Cidade</label>
                                                <select id="cidade" name="cidade" class="form-control" disabled>

                                                    <?php

                                                    foreach (select_CIDADE_id_usu($id_fun, $estado) as $cidade_banco) {

                                                        echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="CEP">CEP</label>
                                                <input type="text" class="form-control" id="CEP" attrname="cep" name="cep" value="<?php echo $linha["cep"] ?>" disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM MENU ENDEREÇO -->

                                    <!-- INÍCIO MENU INFORMAÇÕES -->
                                    <div class="tab-pane fade" id="menu-informacoes" role="tabpanel" aria-labelledby="menu-informacoes-tab">

                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="pis">PIS</label>
                                                <input type="text" class="form-control" id="pis" name="pis" maxlength="15" value="<?php echo $linha["pis"] ?>" disabled>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="ctps">CTPS</label>
                                                <input type="text" class="form-control" id="ctps" name="ctps" maxlength="15" value="<?php echo $linha["ctps"] ?>" disabled>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="cbo">CBO</label>
                                                <input type="text" class="form-control" id="cbo" name="cbo" maxlength="15" value="<?php echo $linha["cbo"] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="tiposalario">Tipo Salário</label>
                                                <select class="form-control" name="tiposalario" id="tiposalario" disabled>
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
                                            <div class="col-md-4 mb-3">
                                                <label for="salario">Salário</label>
                                                <input type="text" class="form-control" id="salario" placeholder="R$" name="salario" onKeyPress="return(moeda(this,'.',',',event))" value="R$ <?php echo $salario_vw = str_replace('.', ',', $linha["salario"]); ?>" disabled>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="dependentes">Dependentes</label>
                                                <input type="number" step="1" min="0" max="10" class="form-control" id="dependentes" name="dependentes" maxlength="2" pattern="[0-9]{1,2}" value="<?php echo $linha["dependentes"] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="funcao">Função</label>
                                                <input type="text" class="form-control" id="funcao" style="text-transform:uppercase" name="funcao" maxlength="25" value="<?php echo $linha["funcao"] ?>" disabled>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="sexo">Sexo</label>
                                                <select class="form-control" name="sexo" id="sexo" disabled>
                                                    <!-- <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="F">Feminino</option>
                                                        <option value="M">Masculino</option> -->
                                                    <?php if ($linha["sexo"] == NULL) { ?>
                                                        <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="F">Feminino</option>
                                                        <option value="M">Masculino</option>
                                                    <?php }
                                                    if ($linha["sexo"] == "F") { ?>
                                                        <option value="F" selected>FEMININO</option>
                                                        <option value="M">MASCULINO</option>
                                                    <?php }
                                                    if ($linha["sexo"] == "M") { ?>
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
                                                <select class="form-control" name="escolaridade" id="escolaridade" disabled>
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
                                                <input type="text" class="form-control" id="datarescisao" attrname="datarescisao" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datarescisao" minlength="8" value="<?php if ($linha["datarescisao"] != NULL) {
                                                                                                                                                                                                                        $data = new DateTime($linha["datarescisao"]);
                                                                                                                                                                                                                        echo $data->format("d/m/Y");
                                                                                                                                                                                                                    } ?>" disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM MENU INFORMAÇÕES -->

                            <?php

                                            }
                                        }

                            ?>

                                </div>
                                <!-- FIM MENU GERAL -->

                                <!-- INÍCIO BOTÃO ENVIAR -->
                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>
                                </div>
                                <!-- FIM BOTÃO ENVIAR -->

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
            <?php include_once "footer.php"; ?>

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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- REQUISITOS MÁSCARAS JS -->
    <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $('#btn-voltar').click(function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {
                var dados = {
                    btn_voltar: btn_voltar
                };
                $.post('controller/colaboradores_post.php', dados, function(retorna) {

                    location.href = "colaboradores";
                });
            }

        })
    });
</script>

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
</script>

<script language="javascript">
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
</script>

<script>
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
    var celMask = ['(999) 99999-9999', '(999) 99999-9999'];
    var cel = document.querySelector('input[attrname=celular]');
    VMasker(cel).maskPattern(celMask[0]);
    cel.addEventListener('input', inputHandler.bind(undefined, celMask, 16), false);

    // MÁSCARA DATA
    var datanascMask = ['99/99/9999', '99/99/9999'];
    var datanasc = document.querySelector('input[attrname=datanasc]');
    VMasker(datanasc).maskPattern(datanascMask[0]);
    datanasc.addEventListener('input', inputHandler.bind(undefined, datanascMask, 10), false);

    // MÁSCARA DATA
    var dataadmisMask = ['99/99/9999', '99/99/9999'];
    var dataadmis = document.querySelector('input[attrname=dataadmis]');
    VMasker(dataadmis).maskPattern(dataadmisMask[0]);
    dataadmis.addEventListener('input', inputHandler.bind(undefined, dataadmisMask, 10), false);

    // MÁSCARA DATA
    var datarescisaoMask = ['99/99/9999', '99/99/9999'];
    var datarescisao = document.querySelector('input[attrname=datarescisao]');
    VMasker(datarescisao).maskPattern(datarescisaoMask[0]);
    datarescisao.addEventListener('input', inputHandler.bind(undefined, datarescisaoMask, 10), false);

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
                $.getJSON('select_cidade_idusu.php?search=', {
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
</script>