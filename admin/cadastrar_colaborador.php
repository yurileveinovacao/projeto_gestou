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

    <title>GESTOU PORTAL - Cadastrar Colaborador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                            <h6 class="m-0 font-weight-bold text-primary">Cadastrar Colaborador</h6>
                        </div>

                        <!-- INICIO CARD BODY -->
                        <div class="card-body">

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
                            <form id="form" class="needs-validation" colaborador="<?php echo $id_fun; ?>" novalidate>

                                <!-- INICIO COL-MD-12 -->
                                <div class="col-md-12">

                                    <!-- INICIO TAB CONTENT -->
                                    <div class="tab-content" id="nav-tabContent">

                                        <!-- INÍCIO MENU IDENTIFICAÇÃO -->
                                        <div class="tab-pane fade show active" id="menu-identificacao" role="tabpanel" aria-labelledby="menu-identificacao-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="rg">RG</label>
                                                    <input type="text" class="form-control" id="rg" attrname="rg" name="rg" maxlength="14">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="cpf">CPF</label>
                                                    <input type="text" class="form-control" id="cpf" attrname="cpf" name="cpf" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" maxlength="255" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" id="celular" attrname="celular" name="celular" pattern="\([0-9]{3}\)[\s][0-9]{5}-[0-9]{4}" minlength="15" maxlength="25" value="">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="departamento">Departamento</label>
                                                    <select class="form-control" id="departamento" name="departamento">
                                                        <option selected value="0">Escolha o Departamento</option>
                                                        <?php

                                                        foreach (selectGESDEP_departamento($id_emp_default) as $dep_banco) {

                                                            echo '<option value="' . $dep_banco['id_dep'] . '">' . $dep_banco['nome'] . '</option>';
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
                                                        <option selected value="0">Escolha o Gestor</option>
                                                        <?php

                                                        foreach (selectGESTOR_id_emp($id_emp_default) as $gestor_banco) {

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
                                                    <input type="text" class="form-control" id="datanasc" attrname="datanasc" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="datanasc" minlength="8">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="dataadmis">Data Admissão</label>
                                                    <input type="text" class="form-control" id="dataadmis" attrname="dataadmis" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" name="dataadmis" minlength="8">
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
                                                <div class="col-md-10 mb-3">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" maxlength="255">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero" maxlength="10">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" maxlength="25">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" maxlength="25">
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

                                                        foreach (select_ESTADO_campo('id_emp', $id_fun, $id_usa, $id_emp_default) as $estado_banco) {
                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                            $estado = $estado_banco['estado_atual'];
                                                        }


                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>

                                                        <?php

                                                        foreach (select_CIDADE_campo('id_emp', $id_fun, $id_usa, $id_emp_default, $estado) as $cidade_banco) {
                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                            $cep = $cidade_banco['cep'];
                                                        }


                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="cep">CEP</label>
                                                    <input type="text" class="form-control" id="cep" attrname="cep" name="cep" value="<?php echo $cep ?>" maxlength="10">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU ENDEREÇO -->

                                        <!-- INÍCIO MENU INFORMAÇÕES -->
                                        <div class="tab-pane fade" id="menu-informacoes" role="tabpanel" aria-labelledby="menu-informacoes-tab">

                                            <div class="form-row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="pis">PIS</label>
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" id="pis" name="pis" maxlength="25">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="ctps">CTPS</label>
                                                    <input type="text" class="form-control" id="ctps" name="ctps" maxlength="25">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="titulo_eleitor">Título Eleitor</label>
                                                    <input type="text" class="form-control" id="titulo_eleitor" name="titulo_eleitor" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="25">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="cbo">CBO</label>
                                                    <input type="text" class="form-control" id="cbo" name="cbo" maxlength="25">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="linkedin">Linkedin</label>
                                                    <input type="text" class="form-control" id="linkedin" name="linkedin" maxlength="255">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="tiposalario">Tipo Salário</label>
                                                    <select class="form-control" name="tiposalario" id="tiposalario">
                                                        <option value="" selected>Escolha uma opção</option>
                                                        <option value="D">Diarista</option>
                                                        <option value="M">Mensalista</option>
                                                        <option value="P">Pró-Labore</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="salario">Salário</label>
                                                    <input type="text" class="form-control" id="salario" placeholder="R$" name="salario" value="R$ 0,00" maxlength="12">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="dependentes">Dependentes</label>
                                                    <input type="number" max="99" min="0" value="0" class="form-control" id="dependentes" name="dependentes" oncontextmenu="return false;" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="funcao">Função</label>
                                                    <input type="text" class="form-control" id="funcao" style="text-transform:uppercase" name="funcao" maxlength="255">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control" name="sexo" id="sexo">
                                                        <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="F">Feminino</option>
                                                        <option value="M">Masculino</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="escolaridade">Escolaridade</label>
                                                    <select class="form-control" name="escolaridade" id="escolaridade">
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
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU INFORMAÇÕES -->

                                    </div>
                                    <!-- FIM TAB CONTENT -->

                                    <!-- INÍCIO BOTÃO ENVIAR -->
                                    <div class="form-group">
                                        <div class="textalign-right">
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


</body>

</html>

<script>
    $(document).ready( // QUANDO O FORMULÁRIO É SUBMETIDO
        function() {
            $("#form").submit(function(event) {
                // Previne o comportamento padrão do formulário (recarregar a página)
                event.preventDefault();

                // Valor que define que o formulário foi submetido
                var btn_cadastro = 1;

                // Obtém os valores do formulário
                var dados_form = {

                    colaborador: $("#form").attr("colaborador"),

                    nome_cadastro: $("#nome").val(),
                    rg_cadastro: $("#rg").val(),
                    cpf_cadastro: $("#cpf").val(),
                    email_cadastro: $("#email").val(),
                    telefone_cadastro: $("#telefone").val(),
                    celular_cadastro: $("#celular").val(),
                    departamento_cadastro: $("#departamento").val(),
                    gestor_cadastro: $("#gestor").val(),
                    datanasc_cadastro: $("#datanasc").val(),
                    dataadmis_cadastro: $("#dataadmis").val(),
                    endereco_cadastro: $("#endereco").val(),
                    numero_cadastro: $("#numero").val(),
                    bairro_cadastro: $("#bairro").val(),
                    complemento_cadastro: $("#complemento").val(),
                    // estado_cadastro: $("#estado").val(),
                    cidade_cadastro: $("#cidade").val(),
                    cep_cadastro: $("#cep").val(),
                    pis_cadastro: $("#pis").val(),
                    ctps_cadastro: $("#ctps").val(),
                    tituloeleitor_cadastro: $("#titulo_eleitor").val(),
                    cbo_cadastro: $("#cbo").val(),
                    linkedin_cadastro: $("#linkedin").val(),
                    tiposalario_cadastro: $("#tiposalario").val(),
                    salario_cadastro: $("#salario").val(),
                    dependentes_cadastro: $("#dependentes").val(),
                    funcao_cadastro: $("#funcao").val(),
                    sexo_cadastro: $("#sexo").val(),
                    escolaridade_cadastro: $("#escolaridade").val(),
                    // datarescisao_cadastro: $("#datarescisao").val(),
                    // codintegracao_cadastro: $("#cod_integracao").val(),
                    // agrdep_cadastro: $("#agrdep").is(":checked"),
                    // bloqueado_cadastro: $("#bloqueado").is(":checked"),

                    // Valor que valida o envio do formulário
                    btn_cadastro: btn_cadastro
                }

                // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                $.post('controller/colaboradores_post.php', dados_form, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                    if (retorno == 1) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            title: 'Sucesso!',
                            text: 'Informação cadastrada com sucesso!',
                            // text: retorno,
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "colaboradores";
                            }
                        });
                    }

                    // Se o retorno for igual a 2, cpf ja cadastrado ativo
                    else if (retorno == 2) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'O CPF já está cadastrado para um colaborador ativo!',
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $("#cpf").val("");

                                swal.close();
                            }
                        });
                    }

                    // Se o retorno for igual a 3, telefone ou celular ja cadastrado
                    else if (retorno == 3) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'O celular já está cadastrado para um colaborador ativo!',
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $("#celular").val("");

                                swal.close();
                            }
                        });
                    }

                    // Se o retorno for igual a 4, e-mail ja cadastrado
                    else if (retorno == 4) {

                        // Exibe uma mensagem de sucesso e recarrega a pagina
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'O e-mail já está cadastrado para um colaborador ativo!',
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $("#email").val("");

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 5, cpf já cadastrado nesse cnpj
                    } else if (retorno == 5) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'O CPF já está cadastrado para um colaborador nesse CNPJ!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $("#cpf").val("");

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 6, data de nascimento incorreta
                    } else if (retorno == 6) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'A data de nascimento informada não existe!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 7, data de admissão incorreta
                    } else if (retorno == 7) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'A data de admissão informada não existe!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 8, data de nascimento menor que 15 anos
                    } else if (retorno == 8) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'A data de nascimento informada é menor que a idade permitida!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 9, data de admissão menor que a de nascimento
                    } else if (retorno == 9) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'A data de admissão informada é menor que a de nascimento!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                swal.close();
                            }
                        });

                        // Se o retorno for igual a 0, alguma campo não cumpriu os requisitos para a inserção dos dados
                    } else if (retorno == 0) {

                        // Exibe uma mensagem de erro usando o plugin SweetAlert2
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            title: 'Atenção!',
                            text: 'Preencha os campos requeridos em todas as abas!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                swal.close();
                            }
                        });

                        // Caso não for nem 0 nem 1 houve erro no try e retorna um alerta com o erro exibido pelo catch
                    } else {

                        // alert(retorno);
                        Swal.fire({
                            icon: 'error',
                            title: 'Please contact support.',
                            title: 'Favor entrar em contato com o suporte.',
                            html: retorno
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }

                }).fail(function() {

                    // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                    alert('Fail');

                });

            });
        });

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
    $(function() {

        var cep = $('#cidade option:selected').attr('namespace');

        $('#cep').val(cep);
        // console.log(cep);
    });

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
                        // Swal.fire({
                        //     icon: 'warning',
                        //     title: 'Warning',
                        //     title: 'Atenção!',
                        //     text: 'Preencha os campos requeridos em todas as abas!'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         swal.close();
                        //     }
                        // });
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
    var cpf = document.querySelector('input[attrname=cpf]');
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

    // Bloqueia qualquer tecla menos o tab e F5 - Input dependentes
    $(function() {
        $('#dependentes').keydown(function(event) {
            if (event.which !== 9 && event.which !== 116) {
                event.preventDefault();
            }
        });

    });

    // AÇÕES INPUT SALARIO
    $(function() {
        // Quando uma tecla é pressionada no campo de entrada '#salario'
        $('#salario').keydown(function(event) {
            // Verifica se a tecla pressionada não é uma tecla de navegação (backspace, tab, delete, F5 ou ctrl) 
            // e não é um número de 0 a 9 do teclado alfanumérico ou numérico
            if (![8, 9, 46, 116, 17].includes(event.which) && !(event.which >= 48 && event.which <= 57) && !(event.which >= 96 && event.which <= 105)) {
                // Se a tecla não atender a essas condições, previna o evento padrão de teclado
                event.preventDefault();
            }
        });

        // Quando uma tecla é liberada no campo de entrada '#salario'
        $('#salario').keyup(function(event) {
            // Obtenha o valor do campo de entrada '#salario' como uma string
            var input = $(this);
            var valor = input.val();

            // Remova todos os caracteres que não sejam números da string usando uma expressão regular
            valor = valor.replace(/\D/g, '');

            // Converta o valor numérico para um formato de moeda brasileira com duas casas decimais
            valor = (valor / 100).toFixed(2).replace(".", ",");
            valor = valor.replace(/(\d)(?=(\d{3})+\b)/g, "$1.");

            // Defina o valor do campo de entrada '#salario' como uma string formatada em moeda brasileira
            input.val("R$ " + valor);
        });
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

// if (isset($_REQUEST["btn-submit"])) {

//     try {

//         $nome = $_POST["nome"];
//         $rg_form = $_POST["RG"];
//         $cpf_form = $_POST["CPF"];
//         $email_form = $_POST["email"];
//         $telefone_form = $_POST["telefone"];
//         $celular_form = $_POST["celular"];
//         $departamento_form = $_POST["departamento"];
//         $gestor_form = $_POST["gestor"];
//         $datanasc_form = $_POST["datanasc"];
//         $dataadmis_form = $_POST["dataadmis"];
//         $endereco = $_POST["endereco"];
//         $bairro = $_POST["bairro"];
//         $complemento = $_POST["complemento"];
//         $numero = $_POST["numero"];
//         $id_mun = $_POST["cidade"];
//         $cep_form = $_POST["cep"];
//         $pis_form = $_POST["pis"];
//         $ctps_form = $_POST["ctps"];
//         $titulo_eleitor_form = $_POST["titulo_eleitor"];
//         $cbo_form = $_POST["cbo"];
//         $salario_form = $_POST["salario"];
//         $tiposalario_form = $_POST["tiposalario"];
//         $sexo = $_POST["sexo"];
//         $escolaridade_form = $_POST["escolaridade"];
//         $funcao_form = $_POST["funcao"];
//         $dependentes_form = $_POST["dependentes"];
//         $linkedin = $_POST["linkedin"];

//         $cpf_update = str_replace('.', '', str_replace('-', '', $cpf_form));
//         $datanasc_update = str_replace('/', '-', $datanasc_form);
//         $dataadmis_update = str_replace('/', '-', $dataadmis_form);

//         if ($rg_form == "") {
//             $rg_update = NULL;
//         } else {
//             $rg_update = str_replace('.', '', str_replace('-', '', $rg_form));
//         }
//         if ($email_form == "") {
//             $email_update = NULL;
//         } else {
//             $email_update = $email_form;
//         }
//         if ($telefone_form == "") {
//             $telefone_update = NULL;
//         } else {
//             $telefone_update = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $telefone_form))));
//         }
//         if ($celular_form == "") {
//             $celular_update = NULL;
//         } else {
//             $celular_update = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $celular_form))));
//         }
//         if ($cep_form == "") {
//             $cep_update = NULL;
//         } else {
//             $cep_update = str_replace('-', '', $cep_form);
//         }
//         if ($salario_form == "") {
//             $salario_update = NULL;
//         } else {
//             $salario_update = str_replace('R$', '', str_replace('.', '', $salario_form));
//             $salario_update = str_replace(',', '.', $salario_update);
//         }
//         if ($pis_form == "") {
//             $pis_update = NULL;
//         } else {
//             $pis_update = $pis_form;
//         }
//         if ($ctps_form == "") {
//             $ctps_update = NULL;
//         } else {
//             $ctps_update = $ctps_form;
//         }
//         if ($titulo_eleitor_form == "") {
//             $titulo_eleitor_update = NULL;
//         } else {
//             $titulo_eleitor_update = $titulo_eleitor_form;
//         }
//         if ($cbo_form == "") {
//             $cbo_update = NULL;
//         } else {
//             $cbo_update = $cbo_form;
//         }
//         if ($funcao_form == "") {
//             $funcao_update = NULL;
//         } else {
//             $funcao_update = mb_strtoupper($funcao_form, 'UTF-8');
//         }
//         if ($complemento_form == "") {
//             $complemento_update = NULL;
//         } else {
//             $complemento_update = mb_strtoupper($complemento_form, 'UTF-8');
//         }
//         if ($endereco == "") {
//             $endereco = NULL;
//         } else {
//             $endereco = mb_strtoupper($endereco, 'UTF-8');
//         }
//         if ($bairro == "") {
//             $bairro = NULL;
//         } else {
//             $bairro = mb_strtoupper($bairro, 'UTF-8');
//         }
//         if ($numero == "") {
//             $numero = NULL;
//         } else {
//             $numero = mb_strtoupper($numero, 'UTF-8');
//         }
//         if ($tiposalario_form == "") {
//             $tiposalario_update = NULL;
//         } else {
//             $tiposalario_update = $tiposalario_form;
//         }
//         if ($escolaridade_form == "") {
//             $escolaridade_update = NULL;
//         } else {
//             $escolaridade_update = $escolaridade_form;
//         }
//         if ($linkedin == "") {
//             $linkedin = NULL;
//         } else {
//             $linkedin = $linkedin;
//         }
//         if ($datanasc_form == "") {
//             $datanasc_update = NULL;
//         } else {
//             $datanasc_update = $datanasc_form;
//             $datanasc_update = implode('-', array_reverse(explode('/', $datanasc_update)));
//         }
//         if ($dataadmis_form == "") {
//             $dataadmis_update = NULL;
//         } else {
//             $dataadmis_update = $dataadmis_form;
//             $dataadmis_update = implode('-', array_reverse(explode('/', $dataadmis_update)));
//         }
//         if ($sexo == "") {
//             $sexo = NULL;
//         } else {
//             $sexo = $sexo;
//         }

//         // CRIA HASH DA SENHA
//         $hash = 123;
//         $senha = password_hash($hash, PASSWORD_DEFAULT);

//         $situac = 1;
//         $id_emp_ant = 0;

//         //CONVERTER TEXTO EM MAIUSCULO
//         $nome = mb_strtoupper($nome, 'UTF-8');
//         // $endereco = mb_strtoupper($endereco, 'UTF-8');
//         // $bairro = mb_strtoupper($bairro, 'UTF-8');

//         // //CONVERTER DATA PARA Y-M-D
//         // $dataadmis_update = implode('-', array_reverse(explode('/', $dataadmis_update)));
//         // $datanasc_update = implode('-', array_reverse(explode('/', $datanasc_update)));

//         // echo var_dump($nome)."Nome:".$nome."<br>";
//         // echo var_dump($rg_update)."RG:".$rg_update."<br>";
//         // echo var_dump($cpf_update)."CPF:".$cpf_update."<br>";
//         // echo var_dump($email_update)."Email:".$email_update."<br>";
//         // echo var_dump($telefone_update)."Telefone:".$telefone_update."<br>";
//         // echo var_dump($celular_update)."Celular:".$celular_update."<br>";
//         // echo var_dump($datanasc_update)."Data Nasc.:".$datanasc_update."<br>";
//         // echo var_dump($dataadmis_update)."Data Admis.:".$dataadmis_update."<br>";
//         // echo var_dump($endereco)."Endereco:".$endereco."<br>";
//         // echo var_dump($bairro)."Bairro:".$bairro."<br>";
//         // echo var_dump($complemento_update)."Complemento:".$complemento_update."<br>";
//         // echo var_dump($numero)."Numero:".$numero."<br>";
//         // echo var_dump($id_mun)."Cidade:".$id_mun."<br>";
//         // echo var_dump($cep_update)."CEP:".$cep_update."<br>";
//         // echo var_dump($pis_update)."PIS:".$pis_update."<br>";
//         // echo var_dump($ctps_update)."CTPS:".$ctps_update."<br>";
//         // echo var_dump($cbo_update)."CBO:".$cbo_update."<br>";
//         // echo var_dump($tiposalario_update)."Tipo Salario:".$tiposalario_update."<br>";
//         // echo var_dump($salario_update)."Salario:".$salario_update."<br>";
//         // echo var_dump($dependentes_form)."Dependentes:".$dependentes_form."<br>";
//         // echo var_dump($funcao_update)."Funcao:".$funcao_update."<br>";
//         // echo var_dump($sexo)."Sexo:".$sexo."<br>";
//         // echo var_dump($escolaridade)."Escolaridade:".$escolaridade."<br>";

//         foreach (selectGESUSU_EMAIL($email_update) as $count_email) {

//             $verifica_email = $count_email["count"];
//         }

//         foreach (selectGESUSU_CPF($cpf_update) as $count_cpf) {

//             $verifica_cpf = $count_cpf["contagem_cpf"];
//         }

//         if ($verifica_email == "0") {

//             if ($verifica_cpf == "0") {

//                 insertGESUSU(
//                     $nome,
//                     $cpf_update,
//                     $senha,
//                     $datinc,
//                     $situac,
//                     $rg_update,
//                     $celular_update,
//                     $email_update,
//                     $telefone_update,
//                     $id_mun,
//                     $dataadmis_update,
//                     $datanasc_update,
//                     $ctps_update,
//                     $pis_update,
//                     $cbo_update,
//                     $titulo_eleitor_update,
//                     NULL,
//                     $funcao_update,
//                     NULL,
//                     $tiposalario_update,
//                     $endereco,
//                     $complemento_update,
//                     $bairro,
//                     $dependentes_form,
//                     $salario_update,
//                     $numero,
//                     $departamento_form,
//                     $gestor_form,
//                     $sexo,
//                     $escolaridade_update,
//                     $linkedin,
//                     $cep_update,
//                     $id_emp_default,
//                     $id_emp_ant,
//                     $datatu,
//                     $id_usa_default,
//                     $id_usa_default
//                 );

//                 //     echo "<script language=javascript>
//                 // alert('Dados inseridos com Sucesso!');
//                 // location.href = 'tabela_funcionarios';
//                 // </script>";

//                 echo "<script language=javascript>
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Success',
//                     title: 'Sucesso!',
//                     text: 'Dados inseridos com Sucesso!'
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         location.href = 'tabela_funcionarios';
//                     }
//                 });
//                 </script>
//                 ";
//             } else {

//                 echo "<script language=javascript>
//                 Swal.fire({
//                     icon: 'warning',
//                     title: 'Warning',
//                     title: 'Atenção!',
//                     text: 'O CPF já está cadastrado para um colaborador ativo!'
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         location.href = 'cadastro_funcionario';
//                     }
//                 });
//                 </script>
//                 ";
//             }
//         } else {

//             echo "<script language=javascript>
//             Swal.fire({
//                 icon: 'warning',
//                 title: 'Warning',
//                 title: 'Atenção!',
//                 text: 'Já existe o e-mail cadastrado na base para outro colaborador!'
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     location.href = 'cadastro_funcionario';
//                 }
//             });
//             </script>
//             ";
//         }
//     } catch (PDOException $erro) {
//         ($_SESSION["erro_importação"] = '1 - ' . $erro);

//         echo "<script language=javascript>
//         location.href = '" . $erro_1 . "';
//         </script>";
//     }
// }

?>