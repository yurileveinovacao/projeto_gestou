<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_emp_aprovacao = $_SESSION['id_emp_aprovacao'];

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

    <title>GESTOU PORTAL - Alterar aprovação</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <!-- <script src="js/sorttable.js"></script> -->

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

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
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <?php
                        if (!isset($_SESSION['id_emp_aprovacao'])) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados da empresa!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'aprovacao';
                                }
                                });
                                </script>";
                        }

                        ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Alterar aprovação</h6>
                        </div>

                        <div class="card-body">

                            <!-- INICO CARD LOGO -->
                            <div class="row m-auto">
                                <div class="dropdown no-arrow mb-4 m-auto">
                                    <div class="m-auto">
                                        <form action="test-image.php" id="croppie" method="post">

                                            <label class="cabinet center-block">
                                                <figure style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php

                                                    foreach (selectGESEMP_FOTO($id_emp_aprovacao) as $foto_banco) {

                                                        $imagem = $foto_banco["imagem"];

                                                        if (!empty($imagem)) {

                                                    ?>
                                                            <img src="../upload/empresa/<?php echo $raiz_cnpj_aprovacao . "/" . $foto_banco["imagem"]; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                        <?php

                                                        } else {

                                                        ?>

                                                            <img src="../upload/empresa/avatar_empresa_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                    <?php

                                                        }
                                                    }

                                                    ?>

                                                </figure>
                                                <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                        <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto da empresa</label>
                                                        <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                                    </a>

                                                    <?php if (!empty($imagem)) { ?>
                                                        <div class="dropdown-item" id="remover-foto" id_emp="<?php echo $id_emp_aprovacao; ?>" style="padding: 0.7rem 1.5rem !important;">
                                                            <label for="remover_foto"><i class="far fa-trash-alt mr-1"></i> Remover foto da empresa</label>
                                                        </div>

                                                    <?php } else { ?>

                                                    <?php } ?>

                                                </div>
                                            </label>
                                        </form>
                                        <sup class="textalign-center mt-sm-4">Proporção 2:2 (200 x 200px)</sup>
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
                            <!-- FIM CARD LOGO -->

                            <?php

                            foreach (select_VW_EMPRESAMASTER($id_emp_aprovacao) as $info_banco) {

                                $imagem = $info_banco['imagem'];
                                $nome = $info_banco['nome'];
                                $nomefantasia = $info_banco['nomefantasia'];
                                $cnpj = $info_banco['cnpj'];
                                $tipo = $info_banco['tipo'];
                                $email = $info_banco['email'];
                                $quant_colab = $info_banco['quant_colab'];
                                $contato = $info_banco['contato'];
                                $telefone = $info_banco['telefone'];
                                $resp_financeiro = $info_banco['resp_financeiro'];
                                $email_financeiro = $info_banco['email_financeiro'];
                                $endereco = $info_banco['endereco'];
                                $bairro = $info_banco['bairro'];
                                $numero = $info_banco['numero'];
                                $complemento = $info_banco['complemento'];
                                $estado = $info_banco['estado'];
                                $cep = $info_banco['cep'];
                            }

                            ?>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-identificacao-tab" data-toggle="tab" href="#nav-identificacao" role="tab" aria-controls="nav-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="nav-endereco-tab" data-toggle="tab" href="#nav-endereco" role="tab" aria-controls="nav-endereco" aria-selected="false">Endereço</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form id="form" class="needs-validation" novalidate enctype="multipart/form-data">
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV IDENTIFICAÇÃO -->
                                    <div class="tab-pane fade active" id="nav-identificacao" role="tabpanel" aria-labelledby="nav-identificacao-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" value="<?php echo $nome ?>" minlength="5" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="nomefantasia">Nome Fantasia</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nomefantasia" name="nomefantasia" value="<?php echo $nomefantasia ?>" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="cnpj">CNPJ</label>
                                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo $cnpj ?>" disabled required></input>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="tipo">Tipo</label>
                                                    <select id="tipo" name="tipo" class="form-control" required>
                                                        <?php

                                                        switch ($tipo) {

                                                            case "F":

                                                        ?>

                                                                <option value="F" selected>FILIAL</option>
                                                                <option value="M">MATRIZ</option>

                                                            <?php

                                                                break;

                                                            case "M":

                                                            ?>

                                                                <option value="F">FILIAL</option>
                                                                <option value="M" selected>MATRIZ</option>

                                                            <?php

                                                                break;

                                                            default:

                                                            ?>

                                                                <option value="" selected disabled>Selecione o tipo da empresa</option>
                                                                <option value="F">FILIAL</option>
                                                                <option value="M">MATRIZ</option>

                                                        <?php

                                                        }

                                                        ?>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="quant_colab">Qtd. Colaboradores</label>
                                                    <input type="number" class="form-control" id="quant_colab" name="quant_colab" value="<?php echo $quant_colab; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="contato">Contato</label>
                                                    <input type="text" id="contato" attrname="contato" name="contato" class="form-control" value="<?php echo $contato ?>" maxlength="25">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" attrname="<?php if (strlen($telefone) == 11) {
                                                                                        echo 'telefone';
                                                                                    } else {
                                                                                        echo 'celular';
                                                                                    } ?>" name="telefone" id="telefone" class="form-control" value="<?php echo $telefone ?>" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="resp_financeiro">Responsável Financeiro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="resp_financeiro" name="resp_financeiro" value="<?php echo $resp_financeiro ?>" minlength="5" maxlength="255">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="email_financeiro">E-mail Financeiro</label>
                                                    <input type="text" class="form-control" title="Separe os endereços de e-mail com ;" id="email_financeiro" name="email_financeiro" value="<?php echo $email_financeiro ?>" maxlength="255">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- BOTÃO FORM -->
                                        <!-- <div class="textalign-right">
                                            <button type="submit" name="btn-submit" onclick="return confirm('Tem certeza que deseja alterar os dados?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            <button type="button" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div> -->

                                    </div>
                                    <!-- FIM DIV IDENTIFICAÇÃO -->

                                    <!-- INICIO DIV ENDEREÇO -->
                                    <div class="tab-pane fade" id="nav-endereco" role="tabpanel" aria-labelledby="nav-endereco-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" minlength="3" value="<?php echo $endereco ?>" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" minlength="3" value="<?php echo $bairro ?>" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $numero ?>" maxlength="25" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" value="<?php echo $complemento ?>" maxlength="25">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <select id="estado" name="estado" class="form-control" required>
                                                        <!-- <option value="" selected disabled>Selecione um estado</option> -->
                                                        <?php
                                                        foreach (select_ESTADO_APROVACAO($id_emp_aprovacao) as $estado_banco) {
                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>
                                                        <!-- <option value="" selected disabled>Selecione um estado</option> -->
                                                        <?php
                                                        foreach (select_CIDADE_APROVACAO() as $cidade_banco) {
                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                            $cep = $cidade_banco['cep'];
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="cep">CEP</label>
                                                    <input type="text" class="form-control" id="cep" attrname="cep" name="cep" value="<?php echo $cep ?>" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- BOTÃO FORM -->
                                        <!-- <div class="textalign-right">
                                            <button type="submit" name="btn-submit" onclick="return confirm('Tem certeza que deseja alterar os dados?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            <button type="button" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div> -->
                                    </div>
                                    <!-- FIM DIV ENDEREÇO -->

                                    <div class="textalign-right">
                                        <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                        <button type="button" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>

                                </div>
                                <!-- FIM DIV TAB CONTENT -->

                            </form>

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
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <!-- <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

            <!-- partial -->
            <script src="./croppie/script_aprovacao.js"></script>

            <!-- Page level custom scripts -->
            <!-- <script src="js/demo/datatables-demo.js"></script> -->

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <!-- <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script> -->

            <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        // Máscara para o campo 'cnpj' no formato '00.000.000/0000-00'
        $('#cnpj').mask('00.000.000/0000-00');
    });

    $(document).ready(function() {
        // Máscara para o campo 'cep' no formato '00000-000'
        $('#cep').mask('00000-000');
    });

    $(document).ready(function() {
        // Máscara para o campo 'quant_colab' no formato '0000#' com a opção 'reverse' habilitada
        $('#quant_colab').mask('0000#', {
            reverse: true
        });

        // Limpa qualquer caractere não numérico inserido no campo 'quant_colab' através do evento 'input'
        $('#quant_colab').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    $(document).ready(function() {
        // Definição de uma função para o comportamento da máscara de telefone
        var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 12 ? '(000) 00000-0000' : '(000) 0000-00009';
        };

        // Opções para a máscara de telefone
        var spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        // Aplica a máscara de telefone no campo 'telefone' com base na função de comportamento e nas opções definidas
        $('#telefone').mask(SPMaskBehavior, spOptions);
    });
</script>

<script>
    // function inputHandler(masks, max, event) {
    //     var c = event.target;
    //     var v = c.value.replace(/\D/g, '');
    //     var m = c.value.length > max ? 1 : 0;
    //     VMasker(c).unMask();
    //     VMasker(c).maskPattern(masks[m]);
    //     c.value = VMasker.toPattern(v, masks[m]);
    // }

    // // Recebe o attrname do input telefone (telefone / celular)
    // var telefoneName = $('input#telefone').attr('attrname');
    // // Verifica se o attrname é telefone ou celular e define a mascara correta
    // if (telefoneName == 'telefone') {

    //     var telMask = ['(999) 9999-99999', '(999) 9 9999-9999'];
    //     var tel = document.querySelector('input[attrname=telefone]');
    //     VMasker(tel).maskPattern(telMask[0]);
    //     tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);
    // } else {

    //     var celMask = ['(999) 9999-9999', '(999) 9 9999-9999'];
    //     var cel = document.querySelector('input[attrname=celular]');
    //     VMasker(cel).maskPattern(celMask[1]);
    //     cel.addEventListener('input', inputHandler.bind(undefined, celMask, 15), false);
    // }

    // var cepMask = ['99999-9999', '99999-999'];
    // var cep = document.querySelector('input[attrname=cep]');
    // VMasker(cep).maskPattern(cepMask[0]);
    // cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);

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
                        // alert("Preencha os campos requeridos em todas as abas!");
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

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // $(document).ready(function() {

    //     $.post('verificar_sessao.php', function(retorna) {

    //         if (retorna == 1) {

    //             // variável de sessão está definida
    //             $('#nav-gestor-tab').addClass('active');
    //             $('#nav-gestor').addClass('show active');
    //         } else {

    //             // variável de sessão não está definida
    //             $('#nav-identificacao-tab').addClass('active');
    //             $('#nav-identificacao').addClass('show active');
    //         }
    //     });
    // });

    $(document).ready(function() {
        $("[name='btn-voltar']").click(function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {

                var dados = {

                    btn_voltar: btn_voltar
                };
                $.post('controller/alterar_aprovacao_post.php', dados, function(retorn) {

                    location.href = "aprovacao";
                });
            }

        });
    });

    // POST AO REMOVER IMAGEM DE LOGO DA EMPRESA
    $(function() {
        $(document).on('click', '#remover-foto', function() {

            alert("Entrou");

            var id_emp_foto = $(this).attr('id_emp');

            if (id_emp_foto !== '') {

                var dados = {

                    id_emp_foto: id_emp_foto
                };

                $.post('controller/alterar_aprovacao_post.php', dados, function(retorna) {

                    if (retorna == 2) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Foto removida com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'alterar_aprovacao';
                            }
                        })

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Ocorreu um erro ao remover a foto!' + retorna
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'alterar_aprovacao';
                            }
                        })

                    }

                });
            }
        });
    });

    // QUANDO O FORMULÁRIO É SUBMETIDO
    $(function() {
        $("#form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            // Valor que define que o formulário foi submetido
            var btn_submit = 1;

            // Obtém os valores do formulário
            var dados_form = {

                nome: $("#nome").val(),
                nomefantasia: $("#nomefantasia").val(),
                cnpj: $("#cnpj").val(),
                tipo: $("#tipo").val(),
                email: $("#email").val(),
                quant_colab: $("#quant_colab").val(),
                contato: $("#contato").val(),
                telefone: $("#telefone").val(),
                resp_financeiro: $("#resp_financeiro").val(),
                email_financeiro: $("#email_financeiro").val(),
                endereco: $("#endereco").val(),
                bairro: $("#bairro").val(),
                numero: $("#numero").val(),
                complemento: $("#complemento").val(),
                estado: $("#estado").val(),
                cidade: $("#cidade").val(),
                cep: $("#cep").val(),

                // Valor que valida o envio do formulário
                btn_submit: btn_submit
            }

            // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
            $.post('controller/alterar_aprovacao_post.php', dados_form, function(retorno) {

                switch (retorno) {
                    case '0':

                        // Informações não preenchidas corretamente ou não preenchidas
                        Swal.fire({
                            icon: "warning",
                            title: "Warning",
                            title: 'Atenção!',
                            text: 'Por favor, preencha todos os campos obrigatórios!'
                        });

                        break;

                    case '1':

                        // Retorno de sucesso
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            title: 'Sucesso!',
                            // html: 'As informações foram atualizadas com sucesso, e a empresa em questão está totalmente apta para utilizar o sistema!'
                            html: 'As informações foram atualizadas com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });

                        break;

                    case '5':

                          // Já existe um cadastro com as informações do CNPJ
                          Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Desculpe, mas já existe um cadastro em nossa base de dados com o CNPJ informado. Por favor, verifique os dados fornecidos e tente novamente!'
                            });

                        break;

                    case '6':

                          // Já existe um cadastro com as informações do E-MAIL
                          Swal.fire({
                                icon: "warning",
                                title: "Warning",
                                title: 'Atenção!',
                                text: 'Desculpe, mas já existe um cadastro em nossa base de dados com o E-MAIL informado. Por favor, verifique os dados fornecidos e tente novamente!'
                            });
                        break;

                    default:

                        // Caso o retorno seja o retorno de um TRY ou diferente de qualquer dos itens acima
                        Swal.fire({
                            icon: "warning",
                            title: "Warning",
                            title: 'Atenção!',
                            text: 'Por favor, preencha todos os campos obrigatórios!'
                        });

                        break;
                }

            }).fail(function() {

                // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    title: 'Erro!',
                    text: 'Desculpe, ocorreu um erro durante a execução. Por favor, tente novamente mais tarde ou entre em contato com o suporte!'
                });

            });

        });
    });
</script>

<?php

// // Remove imagem logo
// if (isset($_REQUEST["remover_foto"])) {
//     $id_emp_foto = $_REQUEST["remover_foto"];
//     foreach (selectGESEMP_FOTO($id_emp_foto) as $foto_banco) {
//         $imagem = $foto_banco["imagem"];
//     }
//     if (!empty($imagem)) {
//         unlink('../upload/empresa/' . $imagem . '');
//         updateGESEMP_FOTO(NULL, $id_emp_foto, $datatu, $id_mas_default);
//     }

//     echo "<script language=javascript>
//         alert('Foto removida com sucesso!');
//         location.href = 'alterar_empresa';
//         </script>";
// }

// // POST REALIZADO E UNSET DE VARIÁVEIS DE SESSÃO
// if (isset($_POST['btn_voltar'])) {

//     // VÁRIAVEL PARA LISTAR OS DADOS DA EMPRESA NA PÁGINA TABELA EMPRESAS
//     unset($_SESSION['editar_id_emp']);
// }

// // Atribui 1 Usuario como GESTOR
// if (isset($_POST['btn_inc'])) {

//     try {

//         $id_usa = $_POST['btn_inc'];
//         $gestor = 1;
//         $_SESSION['tab'] = 4;

//         if (selectGESGES($id_usa, $editar_id_emp) == 0) {

//             insertGESGES($id_usa, $editar_id_emp, $gestor);
//         } else {

//             updateGESGES($id_usa, $editar_id_emp, $gestor);
//         }
//     } catch (PDOException $erro) {

//         echo $erro->getMessage();
//     }
// }

// // Remove 1 usuario de GESTOR
// if (isset($_POST["btn_exc"])) {

//     try {

//         $id_usa = $_POST["btn_exc"];
//         $gestor = 0;
//         $_SESSION['tab'] = 4;

//         $id_usa = preg_replace('/\D+/', '', $id_usa);

//         updateGESGES($id_usa, $editar_id_emp, $gestor);
//     } catch (PDOException $erro) {

//         echo $erro->getMessage();
//     }
// }


// if (isset($_REQUEST['btn-submit'])) {

//     try {

//         // Define as variáveis
//         $nome = $_POST["nome"]; //REQUIRED
//         $nomefantasia = $_POST["nomefantasia"]; //REQUIRED
//         $tipo = $_POST["tipo"];
//         $email = $_POST["email"];
//         $contato = $_POST["contato"];
//         $telefone = $_POST["telefone"];
//         $resp_financeiro = $_POST['resp_financeiro'];
//         $email_financeiro = $_POST['email_financeiro'];
//         $endereco = $_POST["endereco"];
//         $bairro = $_POST["bairro"];
//         $numero = $_POST["numero"];
//         $complemento = $_POST["complemento"];
//         $cidade = $_POST["cidade"]; //REQUIRED
//         $cep = $_POST["cep"];
//         $id_emp_h = $_POST["id_emp_h"]; //REQUIRED
//         $id_emp_p = $_POST["id_emp_p"]; //REQUIRED
//         $id_emp_i = $_POST["id_emp_i"]; //REQUIRED
//         $layout_folha = $_POST["lay_folha"];
//         $layout_ponto = $_POST["lay_ponto"];
//         $layout_irrf = $_POST["lay_irrf"];
//         $descricao_layout = $_POST["descricao_layout"];
//         $id_per_imp = $_POST['id_per_imp'];
//         $id_per_ace = $_POST['id_per_ace'];
//         $id_usa_rh = $_POST["id_usa_rh"];
//         $id_usa_ouv = $_POST["id_usa_ouv"];
//         $id_emp_grupo = $_POST["id_emp_grupo"];
//         $lay_h = $_POST["lay_h"]; //REQUIRED
//         $lay_p = $_POST["lay_p"]; //REQUIRED
//         $lay_i = $_POST["lay_i"]; //REQUIRED
//         $tipo_h = $_POST["tipo_h"]; //REQUIRED
//         $tipo_p = $_POST["tipo_p"]; //REQUIRED
//         $tipo_i = $_POST["tipo_i"]; //REQUIRED
//         $validacao_gestor = $_POST["validacao_gestor"];

//         $id_emp = $_SESSION['editar_id_emp'];
//         $id_usa = $_SESSION['id_mas'];


//         // Formata as variáveis
//         if ($email == '') {

//             $email = NULL;
//         }

//         if ($contato == '') {

//             $contato = NULL;
//         }

//         if ($telefone == '') {

//             $telefone_update = NULL;
//         } else {

//             $telefone_update = preg_replace('/\D+/', '', $telefone);
//         }

//         if ($endereco == '') {

//             $endereco = NULL;
//         }

//         if ($bairro == '') {

//             $bairro = NULL;
//         }

//         if ($numero == '') {

//             $numero = NULL;
//         }

//         if ($complemento == '') {

//             $complemento = NULL;
//         }

//         if ($cep == '') {

//             $cep_update = NULL;
//         } else {

//             $cep_update = preg_replace('/\D+/', '', $cep);
//         }

//         if ($layout_folha == '') {

//             $layout_folha = NULL;
//         }

//         if ($layout_ponto == '') {

//             $layout_ponto = NULL;
//         }

//         if ($layout_irrf == '') {

//             $layout_irrf = NULL;
//         }

//         if ($descricao_layout == '') {

//             $descricao_layout = NULL;
//         }

//         if ($id_usa_rh == '') {

//             $id_usa_rh = NULL;
//         }

//         if ($id_usa_ouv == '') {

//             $id_usa_ouv = NULL;
//         }

//         if ($id_emp_grupo == '') {

//             $id_emp_grupo = NULL;
//         }

//         if ($resp_financeiro == '') {

//             $resp_financeiro = NULL;
//         }

//         if ($email_financeiro == '') {

//             $email_financeiro = NULL;
//         }

//         if ($validacao_gestor == '') {

//             $validacao_gestor = 0;
//         }

//         $nome = mb_strtoupper($nome, 'UTF-8');
//         $nomefantasia = mb_strtoupper($nomefantasia, 'UTF-8');
//         $endereco = mb_strtoupper($endereco, 'UTF-8');
//         $bairro = mb_strtoupper($bairro, 'UTF-8');
//         $numero = mb_strtoupper($numero, 'UTF-8');
//         $complemento = mb_strtoupper($complemento, 'UTF-8');
//         $contato = mb_strtoupper($contato, 'UTF-8');
//         $layout_folha = mb_strtoupper($layout_folha, 'UTF-8');
//         $layout_ponto = mb_strtoupper($layout_ponto, 'UTF-8');
//         $layout_irrf = mb_strtoupper($layout_irrf, 'UTF-8');
//         $resp_financeiro = mb_strtoupper($resp_financeiro, 'UTF-8');

//         /*
//         // Exibe as variáveis
//         echo 'Nome: ' . $nome . '<br>';
//         echo 'Nome Fantasia: ' . $nomefantasia . '<br>';
//         echo 'Tipo: ' . $tipo . '<br>';
//         echo 'E-mail: ' . $email . '<br>';
//         echo 'Contato: ' . $contato . '<br>';
//         echo 'Telefone: ' . $telefone_update . '<br>';
//         echo 'Resp financeiro: ' . $resp_financeiro . '<br>';
//         echo 'E-mail financeiro: ' . $email_financeiro . '<br>';
//         echo 'Endereço: ' . $endereco . '<br>';
//         echo 'Bairro: ' . $bairro . '<br>';
//         echo 'Numero: ' . $numero . '<br>';
//         echo 'Complemento: ' . $complemento . '<br>';
//         echo 'Cidade: ' . $cidade . '<br>';
//         echo 'Cep: ' . $cep_update . '<br>';
//         echo 'Id_emp_h: ' . $id_emp_h . '<br>';
//         echo 'Id_emp_p: ' . $id_emp_p . '<br>';
//         echo 'Id_emp_i: ' . $id_emp_i . '<br>';
//         echo 'Folha: ' . $layout_folha . '<br>';
//         echo 'Ponto: ' . $layout_ponto . '<br>';
//         echo 'IRRF: ' . $layout_irrf . '<br>';
//         echo 'Descrição Layout: ' . $descricao_layout . '<br>';
//         echo 'Id_per_imp: ' . $id_per_imp . '<br>';
//         echo 'Id_per_ace: ' . $id_per_ace . '<br>';
//         echo 'Id_usa_rh: ' . $id_usa_rh . '<br>';
//         echo 'Id_usa_ouv: ' . $id_usa_ouv . '<br>';
//         echo 'Id_emp_grupo: ' . $id_emp_grupo . '<br>';
//         echo 'Lay_h: ' . $lay_h . '<br>';
//         echo 'Lay_p: ' . $lay_p . '<br>';
//         echo 'Lay_i: ' . $lay_i . '<br>';
//         echo 'Tipo_h: ' . $tipo_h . '<br>';
//         echo 'Tipo_p: ' . $tipo_p . '<br>';
//         echo 'Tipo_i: ' . $tipo_i . '<br>';
//         echo 'Validador Gestor: ' . $validacao_gestor . '<br>';
//         echo 'Datatu: ' . $datatu . '<br>';
//         echo 'Id_emp: ' . $id_emp . '<br>';
//         echo 'Id_usa: ' . $id_usa . '<br>';
//         echo 'Imagem: ' . $id_usa . '<br>';
//         */

//         // Executa os update
//         updateGESEMP_CAMPOS(
//             $nome,
//             $nomefantasia,
//             $tipo,
//             $email,
//             $contato,
//             $telefone_update,
//             $resp_financeiro,
//             $email_financeiro,
//             $endereco,
//             $bairro,
//             $numero,
//             $complemento,
//             $cidade,
//             $cep_update,
//             $id_emp_h,
//             $id_emp_p,
//             $id_emp_i,
//             $layout_folha,
//             $layout_ponto,
//             $layout_irrf,
//             $descricao_layout,
//             $id_per_imp,
//             $id_per_ace,
//             $id_usa_rh,
//             $id_usa_ouv,
//             $id_emp_grupo,
//             $tipo_h,
//             $tipo_p,
//             $tipo_i,
//             $validacao_gestor,
//             $datatu,
//             $id_emp,
//             $id_usa
//         );

//         updateGESLAY($id_emp, $lay_h, $lay_p, $lay_i);

//         echo "<script language=javascript>
//                  alert('Informação Atualizada com Sucesso!');
//                  location.href = 'alterar_empresa';         
//              </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();

//         echo "<script language=javascript>
//         alert('Erro!');
//     </script>";
//     }
// }
?>