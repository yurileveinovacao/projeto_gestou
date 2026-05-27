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

    <title>GESTOU PORTAL - Cadastrar Funcionário</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="./style.css"> -->
    <!-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'> -->

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

    <!-- <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'> -->


    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- <style>
        [required] {
  outline: 1px solid red;
}
    </style> -->
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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Funcionário</h6>
                        </div>
                        <div class="card-body">

                            <?php

                            if (isset($_REQUEST['al'])) {
                                try {

                                    $_SESSION["id_fun"] = $_REQUEST["al"];
                                    $id_fun = $_SESSION["id_fun"];
                                } catch (PDOException $erro) {
                                    echo $erro->getMessage();
                                }
                            }

                            ?>

                            <!-- <div class="container"> -->
                            <div class="row m-auto">
                                <!-- <div class="col-md-12"> -->

                                <div class="dropdown no-arrow mb-4 m-auto">

                                    <div class="m-auto" id="div_teste" namespace="<?php echo $id_fun; ?>">
                                        <form action="test-image.php" id="croppie" method="post">

                                            <label class="cabinet center-block">
                                                <figure style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php

                                                    foreach (selectGESUSU_FOTO($id_fun) as $foto_banco) {

                                                        $imagem = $foto_banco["imagem"];

                                                        if (!empty($imagem)) {

                                                    ?>
                                                            <img src="../upload/cadastro/<?php echo $foto_banco["imagem"]; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                        <?php

                                                        } else {

                                                        ?>

                                                            <img src="../upload/cadastro/avatar_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                    <?php

                                                        }
                                                    }

                                                    ?>

                                                    <!-- <figcaption><i class="fa fa-camera"></i></figcaption> -->
                                                </figure>
                                                <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                        <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto de perfil</label>
                                                        <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                                    </a>

                                                    <?php if (!empty($imagem)) { ?>

                                                        <a href="alterar_funcionario?remover_foto=<?php echo $_SESSION["id_fun"]; ?>" onclick="return confirm('Tem certeza que deseja deletar a foto de perfil?'); return false;">
                                                            <div class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                                <label for="remover_foto"><i class="far fa-trash-alt mr-1"></i> Remover foto de perfil</label>
                                                                <!-- <input type="button" id="remover_foto" style="width: 150px; display: none;" class="" name="remover_foto" /> -->
                                                            </div>
                                                        </a>

                                                    <?php } else { ?>

                                                    <?php } ?>

                                                </div>
                                            </label>

                                            <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div> -->

                                        </form>
                                    </div>

                                </div>

                            </div>
                            <!-- </div>
                            </div> -->


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
                                    <a class="nav-item nav-link active" id="menu-geral-tab" data-toggle="tab" href="#menu-geral" role="tab" aria-controls="menu-geral" aria-selected="true">Geral</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="menu-informacoes-tab" data-toggle="tab" href="#menu-informacoes" role="tab" aria-controls="menu-informacoes" aria-selected="false">Outras Informações</a>
                                    <a class="nav-item nav-link" id="menu-parametros-tab" data-toggle="tab" href="#menu-parametros" role="tab" aria-controls="menu-parametros" aria-selected="false">Parâmetros</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form id="form" class="needs-validation" novalidate action="alterar_funcionario" method="POST">

                                <div class="col-md-12">

                                    <!-- INÍCIO MENU GERAL -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="menu-geral" role="tabpanel" aria-labelledby="menu-geral-tab">

                                            <?php

                                            foreach (selectGESUSU($id_fun) as $linha) {
                                                if ($linha != 0) {
                                            ?>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" maxlength="255" value="<?php echo $linha["nome"] ?>" required>
                                                            <div class="invalid-feedback">
                                                                Inválido! Min. 3 caracteres!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="RG">RG</label>
                                                            <input type="text" class="form-control" id="RG" attrname="RG" name="RG" maxlength="14" value="<?php echo $linha["rg"] ?>">
                                                            <div class="invalid-feedback">
                                                                Inválido!
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="CPF">CPF</label>
                                                            <input type="text" class="form-control" id="CPF" attrname="CPF" name="CPF" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" value="<?php echo $linha["cpf"] ?>" required>
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
                                                            <select class="form-control" id="gestor" name="gestor">
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
                                                            <div class="d-flex">
                                                                <input type="text" class="form-control" style="width: 100% !important;" id="datanasc" attrname="datanasc" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datanasc" minlength="8" value="<?php
                                                                                                                                                                                                                                                        if ($linha["datanascimento"] != NULL) {
                                                                                                                                                                                                                                                            $data = new DateTime($linha["datanascimento"]);
                                                                                                                                                                                                                                                            echo $data->format("d/m/Y");
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                        } ?>">
                                                                <div class="pl-1">

                                                                    <?php if ($linha["situac"] == 1) { ?>

                                                                        <button type="button" id="btn-aniversario" class="btn btn-primary ml-auto" id_usu="<?php echo $linha["id_usu"]; ?>">
                                                                            <i class="fas fa-birthday-cake"></i>
                                                                        </button>

                                                                    <?php } else { ?>

                                                                        <button type="button" class="btn btn-secondary ml-auto" onclick="usuario_inativo();">
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
                                                            <input type="text" class="form-control" id="dataadmis" attrname="dataadmis" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="dataadmis" minlength="8" value="<?php
                                                                                                                                                                                                                        if ($linha["dataadmissao"] != NULL) {
                                                                                                                                                                                                                            $data = new DateTime($linha["dataadmissao"]);
                                                                                                                                                                                                                            echo $data->format("d/m/Y");
                                                                                                                                                                                                                        } else {
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
                                                        <?php



                                                        if (!empty($id_fun)) {

                                                            // echo '<script language="javascript">';
                                                            // echo 'alert("ENTROU IF UF")';
                                                            // echo '</script>';

                                                            foreach (select_ESTADO_campo('id_usu', $id_fun, $id_usa, $id_emp) as $estado_banco) {
                                                                echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                                $estado = $estado_banco['estado_atual'];
                                                            }
                                                        } else {
                                                            foreach (select_ESTADO_campo('id_emp', $id_fun, $id_usa, $id_emp) as $estado_banco) {
                                                                echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                                $estado = $estado_banco['estado_atual'];
                                                            }
                                                        }

                                                        ?>
                                                    </select>



                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>

                                                    <!-- <select id="cidade" name="cidade" class="form-control" required>
                                                        ?php
                                                        foreach (select_CIDADE_id_usu($id_fun, $estado) as $cidade_banco) {
                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                        }
                                                        ?>
                                                    </select> -->


                                                    <select id="cidade" name="cidade" class="form-control" required>
                                                        <?php

                                                        if (!empty($id_fun)) {
                                                            foreach (select_CIDADE_campo('id_usu', $id_fun, $id_usa, $id_emp, $estado) as $cidade_banco) {
                                                                echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                                $cep = $cidade_banco['cep'];
                                                            }
                                                        } else {
                                                            foreach (select_CIDADE_campo('id_emp', $id_fun, $id_usa, $id_emp, $estado) as $cidade_banco) {
                                                                echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                                $cep = $cidade_banco['cep'];
                                                            }
                                                        }
                                                        ?>
                                                    </select>


                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="CEP">CEP</label>
                                                    <input type="text" class="form-control" id="CEP" attrname="cep" name="cep" maxlength="10" value="<?php echo $linha["cep"] ?>">
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
                                                    <input type="text" class="form-control" id="salario" placeholder="R$" name="salario" maxlength="12" onKeyPress="return(moeda(this,'.',',',event))" value="R$ <?php echo $salario_vw = str_replace('.', ',', $linha["salario"]); ?>">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="dependentes">Dependentes</label>
                                                    <input type="text" class="form-control" id="dependentes" name="dependentes" maxlength="2" pattern="[0-9]{1,2}" value="<?php echo $linha["dependentes"] ?>">
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
                                        <!-- FIM MENU PARAMETROS -->

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

                                <?php

                                                }
                                            }

                                ?>

                                    </div>
                                    <!-- FIM MENU GERAL -->

                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button id="btn-troca-senha" type="button" data-toggle="modal" data-target="#TrocarSenha" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-unlock mr-sm-2"></i> Trocar Senha</button>
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            <a href="tabela_funcionarios"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                        </div>
                                    </div>
                                    <!-- FIM BOTÃO ENVIAR -->

                                </div>

                            </form>
                            <!-- FIM FORM -->

                        </div>

                    </div>
                </div>

            </div>

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
                        <div class="modal-body">
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
                        <form action="alterar_funcionario" method="POST">
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
                    $id_fun = $_SESSION["id_fun"];

                    if ($novasenha == $confirmnovasenha) {

                        $novasenha_banco = password_hash($novasenha, PASSWORD_DEFAULT);


                        // echo "novasenha".  var_dump($novasenha)."<br>";
                        // echo "confirm".  var_dump($confirmnovasenha)."<br>";
                        // echo "id_fun".  var_dump($id_fun)."<br>";
                        // echo "datatu".  var_dump($datatu)."<br>";
                        // echo "id_usa".  var_dump($id_usa_default)."<br>";
                        // echo "novasenha_banco".  var_dump($novasenha_banco)."<br>";


                        troca_senha_GESUSU($novasenha_banco, $datatu, $id_usa_default, $id_fun);

                        echo "<script>
                        alert('Sua senha foi alterada com sucesso!');
                        location.href='alterar_funcionario?al=" . $_SESSION["id_fun"] . "';
                        </script>";
                    } else {

                        echo "<script>
                        alert('As senhas inseridas não coincidem!');
                        location.href='alterar_funcionario?al=" . $_SESSION["id_fun"] . "';
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

            <!-- REQUISITOS MÁSCARAS JS -->
            <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

            <!-- partial -->
            <script src="./croppie/script.js"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

            <script src="js/dom-to-image.min.js"></script>

</body>

</html>

<script>
    function usuario_inativo() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'O usuário está inativo!'
        });
    }

    //Clique do botão CAKE para abrir modal externo trazendo a extrutura do CARTAO DE ANIVERSARIO
    $(document).ready(function() {
        $(document).on('click', '#btn-aniversario', function() {
            var id_recebido = $(this).attr("id_usu");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
                var dados = {
                    id_recebido: id_recebido
                };
                $.post('cartao_de_aniversario.php', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuCartao").html(retorna);
                    $('#visuModal').modal('show');
                    $('#visuModal').addClass('show');

                    // $(document).on('hidden.bs.modal', '#visuModal', function() {

                    //     window.location.reload();

                    // });

                });
            }
        });
    });

    //Clique do botão BAIXAR para efetuar o download do HTML convertido para JPEG
    $(document).ready(function() {
        $(document).on('click', '#baixar', function() {

            domtoimage.toJpeg(document.getElementById('my-node'), {
                    quality: 1
                })
                .then(function(dataUrl) {
                    var link = document.createElement('a');
                    var nome_usuario = document.getElementById("nome_usuario").innerHTML;
                    link.download = 'CARTAO ANIVERSARIO' + nome_usuario + '.jpeg';
                    link.href = dataUrl;
                    link.click();
                    // location.href = "tabela_funcionarios";
                });
        });

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
    var telMask = ['(999) 99999-9999', '(999) 99999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 16), false);

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

    $(document).ready(function() {

        var valor = document.getElementById("departamento").value;

        if (valor != 0) {

            $("#agrdep").prop("disabled", false);

        }

    })
</script>

<?php

if (isset($_REQUEST["remover_foto"])) {

    $id_fun_foto = $_REQUEST["remover_foto"];

    foreach (selectGESUSU_FOTO($id_fun_foto) as $foto_banco) {

        $imagem = $foto_banco["imagem"];
    }

    if (!empty($imagem)) {

        unlink('../upload/cadastro/' . $imagem . '');

        updateGESUSU_FOTO(NULL, $id_fun_foto, $datatu, $id_usa_default);
    }

    echo "<script language=javascript>
        alert('Foto removida com sucesso!');
        location.href = 'alterar_funcionario?al=" . $_SESSION["id_fun"] . "';
        </script>";
}

if (isset($_REQUEST["btn-submit"])) {

    try {

        $nome = $_POST["nome"];
        $rg_form = $_POST["RG"];
        $cpf_form = $_POST["CPF"];
        $email_form = $_POST["email"];
        $telefone_form = $_POST["telefone"];
        $celular_form = $_POST["celular"];
        $departamento_form = $_POST["departamento"];
        $gestor_form = $_POST["gestor"];
        $datanasc_form = $_POST["datanasc"];
        $dataadmis_form = $_POST["dataadmis"];
        $endereco = $_POST["endereco"];
        $bairro = $_POST["bairro"];
        $complemento_form = $_POST["complemento"];
        $numero_form = $_POST["numero"];
        $id_mun = $_POST["cidade"];
        $cep_form = $_POST["cep"];
        $pis_form = $_POST["pis"];
        $ctps_form = $_POST["ctps"];
        $cbo_form = $_POST["cbo"];
        $titulo_eleitor_form = $_POST["titulo_eleitor"];
        $salario_form = $_POST["salario"];
        $tiposalario_form = $_POST["tiposalario"];
        $sexo = $_POST["sexo"];
        $datarescisao_form = $_POST["datarescisao"];
        $escolaridade_form = $_POST["escolaridade"];
        $funcao_form = $_POST["funcao"];
        $dependentes_form = $_POST["dependentes"];
        $agrdep = $_POST["agrdep"];
        $linkedin = $_POST["linkedin"];
        $cod_integracao = $_POST["cod_integracao"];
        $bloqueado = $_POST["bloqueado"];

        $id_fun = $_SESSION["id_fun"];

        $cpf_update = str_replace('.', '', str_replace('-', '', $cpf_form));
        $datanasc_update = str_replace('/', '-', $datanasc_form);
        $dataadmis_update = str_replace('/', '-', $dataadmis_form);

        if ($rg_form == "") {
            $rg_update = NULL;
        } else {
            $rg_update = $rg_form;
        }
        if ($email_form == "") {
            $email_update = NULL;
        } else {
            $email_update = $email_form;
        }
        if ($telefone_form == "") {
            $telefone_update = NULL;
        } else {
            $telefone_update = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $telefone_form))));
        }
        if ($celular_form == "") {
            $celular_update = NULL;
        } else {
            $celular_update = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $celular_form))));
        }
        if ($cep_form == "") {
            $cep_update = NULL;
        } else {
            $cep_update = str_replace('-', '', $cep_form);
        }
        if ($salario_form == "") {
            $salario_update = NULL;
        } else {
            $salario_update = str_replace('R$ ', '', str_replace('.', '', $salario_form));
            $salario_update = str_replace(',', '.', $salario_update);

            if ($salario_update == "") {

                $salario_update = NULL;
            }
        }
        if ($pis_form == "") {
            $pis_update = NULL;
        } else {
            $pis_update = $pis_form;
        }
        if ($ctps_form == "") {
            $ctps_update = NULL;
        } else {
            $ctps_update = $ctps_form;
        }
        if ($cbo_form == "") {
            $cbo_update = NULL;
        } else {
            $cbo_update = $cbo_form;
        }
        if ($titulo_eleitor_form == "") {
            $titulo_eleitor_update = NULL;
        } else {
            $titulo_eleitor_update = $titulo_eleitor_form;
        }
        if ($funcao_form == "") {
            $funcao_update = NULL;
        } else {
            $funcao_update = mb_strtoupper($funcao_form, 'UTF-8');
        }
        if ($complemento_form == "") {
            $complemento_update = NULL;
        } else {
            $complemento_update = mb_strtoupper($complemento_form, 'UTF-8');
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
        if ($numero_form == "") {
            $numero_update = NULL;
        } else {
            $numero_update = mb_strtoupper($numero_form, 'UTF-8');
        }
        if ($tiposalario_form == "") {
            $tiposalario_update = NULL;
        } else {
            $tiposalario_update = $tiposalario_form;
        }
        if ($dependentes_form == "") {
            $dependentes_update = NULL;
        } else {
            $dependentes_update = $dependentes_form;
        }
        if ($datarescisao_form == "") {
            $datarescisao_update = NULL;
        } else {
            $datarescisao_update = str_replace('/', '-', $datarescisao_form);
            $datarescisao_update = new DateTime($datarescisao_update);
            $datarescisao_update = $datarescisao_update->format("Y-m-d");
        }
        if ($escolaridade_form == "") {
            $escolaridade_update = NULL;
        } else {
            $escolaridade_update = $escolaridade_form;
        }
        if ($agrdep == "") {
            $agrdep = 0;
        } else {
            $agrdep = $agrdep;
        }
        if ($linkedin == "") {
            $linkedin = NULL;
        } else {
            $linkedin = $linkedin;
        }
        if ($cod_integracao == "") {
            $cod_integracao = NULL;
        } else {
            $cod_integracao = $cod_integracao;
        }
        if ($bloqueado == "") {
            $bloqueado = 0;
        } else {
            $bloqueado = $bloqueado;
        }
        if ($datanasc_form == "") {
            $datanasc_update = NULL;
        } else {
            $datanasc_update = $datanasc_form;
            $datanasc_update = implode('-', array_reverse(explode('/', $datanasc_update)));
        }
        if ($dataadmis_form == "") {
            $dataadmis_update = NULL;
        } else {
            $dataadmis_update = $dataadmis_form;
            $dataadmis_update = implode('-', array_reverse(explode('/', $dataadmis_update)));
        }
        if ($sexo == "") {
            $sexo = NULL;
        } else {
            $sexo = $sexo;
        }

        //CONVERTER TEXTO EM MAIUSCULO
        $nome = mb_strtoupper($nome, 'UTF-8');

        // //CONVERTER DATA PARA Y-M-D
        // $dataadmis_update = implode('-', array_reverse(explode('/', $dataadmis_update)));
        // $datanasc_update = implode('-', array_reverse(explode('/', $datanasc_update)));

        // echo var_dump($id_fun)."id_fun:".$id_fun."<br>";
        // echo var_dump($nome)."Nome:".$nome."<br>";
        // echo var_dump($rg_update)."RG:".$rg_update."<br>";
        // echo var_dump($cpf_update)."CPF:".$cpf_update."<br>";
        // echo var_dump($email_update)."Email:".$email_update."<br>";
        // echo var_dump($telefone_update)."Telefone:".$telefone_update."<br>";
        // echo var_dump($celular_update)."Celular:".$celular_update."<br>";
        // echo var_dump($datanasc_update)."Data Nasc.:".$datanasc_update."<br>";
        // echo var_dump($dataadmis_update)."Data Admis.:".$dataadmis_update."<br>";
        // echo var_dump($endereco)."Endereco:".$endereco."<br>";
        // echo var_dump($bairro)."Bairro:".$bairro."<br>";
        // echo var_dump($complemento_update)."Complemento:".$complemento_update."<br>";
        // echo var_dump($numero)."Numero:".$numero."<br>";
        // echo var_dump($id_mun)."Cidade:".$id_mun."<br>";
        // echo var_dump($cep_update)."CEP:".$cep_update."<br>";
        // echo var_dump($pis_update)."PIS:".$pis_update."<br>";
        // echo var_dump($ctps_update)."CTPS:".$ctps_update."<br>";
        // echo var_dump($cbo_update)."CBO:".$cbo_update."<br>";
        // echo var_dump($tiposalario_update)."Tipo Salario:".$tiposalario_update."<br>";
        // echo var_dump($salario_update)."Salario:".$salario_update."<br>";
        // echo var_dump($dependentes_update)."Dependentes:".$dependentes_update."<br>";
        // echo var_dump($funcao_update)."Funcao:".$funcao_update."<br>";
        // echo var_dump($sexo)."Sexo:".$sexo."<br>";
        // echo var_dump($escolaridade_update)."Escolaridade:".$escolaridade_update."<br>";
        // echo var_dump($datarescisao_update)."datarescisao_update:".$datarescisao_update."<br>";

        if ($bloqueado == 1) {

            $situac_funcionario = 0;
            updateGESUSU_SITUAC($situac_funcionario, $id_emp_default, $id_fun, $datatu, $id_usa_default);
        }

        updateGESUSU_alterar_funcionario($nome, $cpf_update, $rg_update, $celular_update, $email_update, $telefone_update, $id_mun, $dataadmis_update, $datanasc_update, $ctps_update, $pis_update, $cbo_update, $titulo_eleitor_update, $datarescisao_update, $funcao_update, $tiposalario_update, $endereco, $complemento_update, $bairro, $dependentes_update, $salario_update, $numero_update, $departamento_form, $gestor_form, $sexo, $escolaridade_update, $agrdep, $linkedin, $cod_integracao, $cep_update, $bloqueado, $id_emp_default, $id_fun, $datatu, $id_usa_default);

        unset($_SESSION["id_usa_alterar"]);

        echo "<script language=javascript>
        alert('Dados atualizados com Sucesso!');
        location.href = 'alterar_funcionario?al=" . $_SESSION["id_fun"] . "';
        </script>";
    } catch (PDOException $erro) {
        ($_SESSION["erro_importação"] = '1 - ' . $erro);

        echo "<script language=javascript>
        location.href = '" . $erro_1 . "';
        </script>";
    }
}

?>

<?php

//CRIAR BOTAO RESET DE SENHA

// CRIA HASH DA SENHA
$hash = 123;
$senha = password_hash($hash, PASSWORD_DEFAULT);

?>