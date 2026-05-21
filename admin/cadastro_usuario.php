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

// FEA-010 — Líder RH: controle de acesso e contexto pra criação de admin
$id_tus_logado = 0;
foreach (select_GESUSA_id_usa($id_usa_default) as $usuario) {
    $id_tus_logado = (int) $usuario['id_tus'];
}
$is_admin_interno = ($id_tus_logado == 1);
$is_lider_rh = checkLiderRH($id_usa_default, $id_emp_default);
$pode_gerenciar_admins = ($is_admin_interno || $is_lider_rh);

if (!$pode_gerenciar_admins) {
    echo "<script language=javascript>
        alert('Somente Líderes RH ou administradores internos podem cadastrar usuários.');
        location.href = 'tabela_usuarios';
    </script>";
    exit;
}

$lideres_ativos = selectGESUSA_lideres_ativos($id_emp_default);
$limites = selectGESEMP_limites($id_emp_default);
$limite_lideres = $limites['limite_lideres'];
$pode_adicionar_lider = ($lideres_ativos < $limite_lideres);
$limite_admins = $limites['limite_admins_ativos'];
$admins_ativos = $limite_admins !== null ? selectGESUSA_admins_ativos($id_emp_default) : 0;

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

    <title>GESTOU PORTAL - Cadastrar Usuário Admin</title>

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

<body id="page-top">

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
                            <h6 class="m-0 font-weight-bold text-primary">Cadastrar Usuário Admin</h6>
                            <div>
                                <?php $cor_badge_l = $lideres_ativos > $limite_lideres ? 'badge-danger' : 'badge-info'; ?>
                                <span class="badge <?php echo $cor_badge_l; ?>" title="Líderes RH ativos / limite configurado pelo master">
                                    <i class="fas fa-user-shield"></i>
                                    <?php echo $lideres_ativos; ?> de <?php echo $limite_lideres; ?> Líderes RH ativos
                                </span>
                                <?php if ($limite_admins !== null) {
                                    $cor_badge_a = $admins_ativos > $limite_admins ? 'badge-danger' : 'badge-info';
                                ?>
                                    <span class="badge <?php echo $cor_badge_a; ?> ml-1" title="Admins ativos / limite configurado pelo master (sem contar internos)">
                                        <i class="fas fa-users"></i>
                                        <?php echo $admins_ativos; ?> de <?php echo $limite_admins; ?> admins ativos
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">

                            <!-- INÍCIO NAV MENUS -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="menu-geral-tab" data-toggle="tab" href="#menu-geral" role="tab" aria-controls="menu-geral" aria-selected="true">Geral</a>
                                    <a class="nav-item nav-link" id="menu-endereco-tab" data-toggle="tab" href="#menu-endereco" role="tab" aria-controls="menu-endereco" aria-selected="false">Endereço</a>
                                </div>
                            </nav>
                            <!-- FIM NAV MENUS -->

                            <!-- INÍCIO FORM -->
                            <form class="needs-validation" novalidate action="cadastro_usuario" method="POST">

                                <div class="col-md-12">

                                    <!-- INÍCIO MENU GERAL -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="menu-geral" role="tabpanel" aria-labelledby="menu-geral-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="CPF">CPF</label>
                                                    <input type="text" class="form-control" id="CPF" attrname="CPF" name="CPF" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z._\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" pattern="\([0-9]{3}\)[\s][0-9][\s][0-9]{4}-[0-9]{4}" minlength="15" value="">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
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
                                                <div class="col-md-6 mb-3">
                                                    <label for="tus">Tipo Usuário</label>
                                                    <select class="form-control" id="tus" name="tus">

                                                        <?php

                                                        foreach (selectGESTUS() as $tus_banco) {

                                                            echo '<option value="' . $tus_banco['id_tus'] . '">' . $tus_banco['descricao'] . '</option>';
                                                        }

                                                        ?>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FEA-010: checkbox Líder RH -->
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="is_lider" name="is_lider" value="1" <?php echo $pode_adicionar_lider ? '' : 'disabled'; ?>>
                                                        <label class="custom-control-label" for="is_lider">
                                                            <strong>Líder RH</strong>
                                                            <span class="text-muted">— marcar para conceder gestão de admins desta empresa</span>
                                                        </label>
                                                        <?php if (!$pode_adicionar_lider) { ?>
                                                            <small class="form-text text-danger">
                                                                Limite de <?php echo $limite_lideres; ?> Líderes RH ativos já atingido nesta empresa. Desative um Líder ou solicite ampliação do limite ao master.
                                                            </small>
                                                        <?php } else { ?>
                                                            <small class="form-text text-muted">
                                                                <?php echo $lideres_ativos; ?> de <?php echo $limite_lideres; ?> Líderes RH ativos
                                                            </small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- FIM MENU GERAL -->

                                        <!-- INÍCIO MENU ENDEREÇO -->
                                        <div class="tab-pane fade" id="menu-endereco" role="tabpanel" aria-labelledby="menu-endereco-tab">

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-10 mb-3">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="numero" name="numero">
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

                                                        foreach (select_VW_EMPRESA($id_emp_default) as $info_banco) {

                                                            $cep = $info_banco['cep'];
                                                            $estado = $info_banco['estado'];
                                                        }

                                                        foreach (select_ESTADO($id_emp_default) as $estado_banco) {

                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>

                                                        <?php

                                                        foreach (select_CIDADE($id_emp_default, $estado) as $cidade_banco) {

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

                                        </div>
                                        <!-- FIM MENU ENDEREÇO -->

                                        <!-- INÍCIO BOTÃO ENVIAR -->
                                        <div class="form-group">
                                            <div class="textalign-right">
                                                <a href="tabela_usuarios"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            </div>
                                        </div>
                                        <!-- FIM BOTÃO ENVIAR -->

                                    </div>
                                    <!-- FIM DIV CLASS COL-MD-12 -->

                            </form>
                            <!-- FIM FORM -->

                        </div>

                    </div>
                </div>

            </div>
        </div>


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


</body>

</html>

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
    var telMask = ['(999) 9 9999-9999', '(999) 9 9999-9999'];
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

        // FEA-010: checkbox Líder RH
        $is_lider = isset($_POST["is_lider"]) && $_POST["is_lider"] == '1' ? 1 : 0;

        if ($is_lider === 1 && !$pode_adicionar_lider) {
            echo "<script language=javascript>
                alert('Limite de " . $limite_lideres . " Líderes RH ativos atingido. Desative um Líder antes de cadastrar outro como Líder.');
                location.href = 'cadastro_usuario';
            </script>";
            exit;
        }


        //CONVERTER TEXTO EM MAIUSCULO
        $nome = mb_strtoupper($nome, 'UTF-8');
        // $endereco = mb_strtoupper($endereco, 'UTF-8');
        // $bairro = mb_strtoupper($bairro, 'UTF-8');
        // $numero = mb_strtoupper($numero, 'UTF-8');

        // $cpf = str_replace('.', '', str_replace('-', '', $cpf));
        $cpf = preg_replace('/\D/', '', $cpf);

        if ($email == "") {
            $email = NULL;
        } else {
            $email = $email;
        }
        if ($telefone == "") {
            $telefone = NULL;
        } else {
            // $telefone = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $telefone))));
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

        // CRIA HASH DA SENHA
        $hash = 123;
        $senha = password_hash($hash, PASSWORD_DEFAULT);

        $situac = 1;
        $id_emp_acess = $id_emp_default;

        if ($id_tus == 2) {

            $id_per = 1;
        } else if ($id_tus == 3) {

            $id_per = 2;
        }
/*
        echo 'Nome: ' . $nome . '<br>';
        echo 'CPF: ' . $cpf . '<br>';
        echo 'senha: ' . $senha . '<br>';
        echo 'datinc: ' . $datinc . '<br>';
        echo 'situac: ' . $situac . '<br>';
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
        echo 'id_emp_acess: ' . $id_emp_acess . '<br>';
        echo 'id_per: ' . $id_per . '<br>'; // ID 
        echo 'datatu: ' . $datatu . '<br>';
        echo 'id_usa_default: ' . $id_usa_default . '<br>';
*/
        $insert_GESUSA_RETID = insertGESUSA_RETID(
            $nome,
            $cpf,
            $senha,
            $datinc,
            $situac,
            $email,
            $telefone,
            $endereco,
            $bairro,
            $complemento,
            $numero,
            $cep,
            $id_tus,
            $id_mun,
            $id_dep,
            $id_emp_acess,
            $id_per,
            $datatu,
            $id_usa_default
        );

        $id_usa = $insert_GESUSA_RETID['pk'];


        // Relaciona o Usuario a empresa
        insertGESVIN_usuario($id_emp_default, $id_usa);

        if (selectGESVI2_usuario($id_per, $id_tus, $id_emp_default) == 0) {

            insertGESVI2_usuario($id_per, $id_tus, $id_emp_default);
        }

        // FEA-010: vínculo GESGES com flag de Líder RH + permissões padrão (26 menus)
        // + menus de gestão de admins (34/35/36) caso seja Líder RH
        insertGESGES($id_usa, $id_emp_default, $is_lider);
        updateGESMPR_menus($id_usa, $id_emp_default, $datatu);
        upsertGESMPR_lider_menus($id_usa, $id_emp_default, $is_lider, $datatu);

        echo "<script language=javascript>
        alert('Dados inseridos com Sucesso!');
        location.href = 'alterar_usuario?al=" . $id_usa . "';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>