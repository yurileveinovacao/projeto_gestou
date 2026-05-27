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

    <title>GESTOU PORTAL - Cadastrar empresa</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastrar empresa</h6>
                        </div>

                        <div class="card-body">

                            <!-- DIV Logo da Empresa (Só adicionavel no alterar empresa) -->
                            <div class="row m-auto">
                                <div class="dropdown no-arrow mb-4 m-auto">
                                    <div class="m-auto">

                                        <figure style="user-select: none;" aria-haspopup="true" aria-expanded="false">

                                            <img src="../upload/empresa/avatar_empresa_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                        </figure>

                                        <sup class="textalign-center mt-sm-4">Proporção 2:2 (200 x 200px)</sup>
                                    </div>
                                </div>
                            </div>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-identificacao-tab" data-toggle="tab" href="#nav-identificacao" role="tab" aria-controls="nav-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="nav-endereco-tab" data-toggle="tab" href="#nav-endereco" role="tab" aria-controls="nav-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="nav-integracao-tab" data-toggle="tab" href="#nav-integracao" role="tab" aria-controls="nav-integracao" aria-selected="false">Integração</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form class="needs-validation" novalidate action="cadastro_empresa" method="POST" enctype="multipart/form-data">
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV IDENTIFICAÇÃO -->
                                    <div class="tab-pane fade show active" id="nav-identificacao" role="tabpanel" aria-labelledby="nav-identificacao-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" minlength="5" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="nomefantasia">Nome Fantasia</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nomefantasia" name="nomefantasia" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="CNPJ">CNPJ</label>
                                                    <input type="text" class="form-control" id="CNPJ" name="CNPJ" required>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="tipo">Tipo</label>
                                                    <select id="tipo" name="tipo" class="form-control" required>

                                                        <option value="">Escolha o Tipo de Empresa</option>
                                                        <option value="M">MATRIZ</option>
                                                        <option value="F">FILIAL</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input name="email" id="email" class="form-control" type="email">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="contato">Contato</label>
                                                    <input attrname="contato" name="contato" id="contato" class="form-control" type="text">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="telefone">Telefone</label>
                                                    <input attrname="telefone" name="telefone" id="telefone" class="form-control" type="text">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="resp_financeiro">Responsável Financeiro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="resp_financeiro" name="resp_financeiro" value="<?php echo $resp_financeiro ?>" minlength="5">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="email_financeiro">E-mail Financeiro</label>
                                                    <input type="email  " class="form-control" id="email_financeiro" name="email_financeiro" value="<?php echo $email_financeiro ?>"></input>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- FIM DIV IDENTIFICAÇÃO -->

                                    <!-- INICIO DIV ENDEREÇO -->
                                    <div class="tab-pane fade" id="nav-endereco" role="tabpanel" aria-labelledby="nav-endereco-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="endereco">Endereco</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" id="numero" name="numero">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento">
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
                                                        $emp_padrao = 0;
                                                        foreach (select_ESTADO($emp_padrao) as $estado_banco) {
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
                                                        <?php
                                                        $emp_padrao = 0;
                                                        foreach (select_CIDADE($emp_padrao, $estado) as $cidade_banco) {
                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="CEP">CEP</label>
                                                    <input type="text" class="form-control" id="CEP" attrname="cep" name="cep">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- FIM DIV ENDEREÇO -->

                                    <!-- INICIO DIV INTEGRAÇÃO -->
                                    <div class="tab-pane fade" id="nav-integracao" role="tabpanel" aria-labelledby="nav-integracao-tab">

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_h">Empresa Holerite</label>
                                                    <select id="id_emp_h" name="id_emp_h" class="form-control" disabled>

                                                        <option value="" disabled selected>Escolha uma opção após salvar</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_p">Empresa Ponto</label>
                                                    <select id="id_emp_p" name="id_emp_p" class="form-control" disabled>

                                                        <option value="" disabled selected>Escolha uma opção após salvar</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_i">Empresa Imposto de Renda</label>
                                                    <select id="id_emp_i" name="id_emp_i" class="form-control" disabled>

                                                        <option value="" disabled selected>Escolha uma opção após salvar</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="lay_folha">Layout Holerite</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_folha" name="lay_folha" minlength="3" value="<?php echo $layout ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_ponto">Layout Ponto</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_ponto" name="lay_ponto" minlength="3" value="<?php echo $layout_ponto ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_irrf">Layout IRRF</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_irrf" name="lay_irrf" value="<?php echo $layout_irrf ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="id_tus_imp">ID Perfil Importação</label>
                                                    <select id="id_tus_imp" name="id_tus_imp" class="form-control" required>

                                                        <option value="" disabled selected>Escolha uma opção</option>

                                                        <?php foreach (selectGESTUS() as $linha) { ?>

                                                            <option value="<?php echo $linha['id_tus']; ?>"><?php echo $linha['descricao']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="id_tus_ace">ID Perfil Aceite</label>
                                                    <select id="id_tus_ace" name="id_tus_ace" class="form-control" required>

                                                        <option value="" disabled selected>Escolha uma opção</option>

                                                        <?php foreach (selectGESTUS() as $linha2) { ?>

                                                            <option value="<?php echo $linha2['id_tus']; ?>"><?php echo $linha2['descricao']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="validacao_gestor"></label>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php if ($validacao_gestor_banco == 0) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor">
                                                        <?php }
                                                        if ($validacao_gestor_banco == 1) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor" checked>
                                                        <?php } ?>
                                                        <label class="custom-control-label" for="validacao_gestor" style="user-select: none;">Utiliza validação por gestor?</label>
                                                        <div class="invalid-feedback">
                                                            Inválido!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FIM DIV INTEGRAÇÃO -->

                                    <!-- BOTÃO FORM -->
                                    <div class="textalign-right">
                                        <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
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
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

        </div>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $("#CNPJ").mask("99.999.999/9999-99");
    });
</script>

<script>
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    var telMask = ['(999) 9999-99999', '(999) 9 9999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);

    var cepMask = ['99999-9999', '99999-999'];
    var cep = document.querySelector('input[attrname=cep]');
    VMasker(cep).maskPattern(cepMask[0]);
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);


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
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            location.href = 'tabela_empresas';
        });
    });
</script>

<?php

if (isset($_REQUEST['btn-submit'])) {
    try {
        $nome = $_POST["nome"]; //REQUIRED
        $cnpj = $_POST["CNPJ"]; //REQUIRED
        $endereco = $_POST["endereco"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cep = $_POST["cep"];
        $complemento = $_POST["complemento"];
        $layout_folha = $_POST["lay_folha"];
        $cidade = $_POST["cidade"]; //id_mun //REQUIRED
        $telefone = $_POST["telefone"];
        $email = $_POST["email"];
        $layout_ponto = $_POST["lay_ponto"];
        $id_tus_imp = $_POST["id_tus_imp"]; //REQUIRED
        $id_tus_ace = $_POST["id_tus_ace"]; //REQUIRED
        $layout_irrf = $_POST["lay_irrf"];
        $contato = $_POST["contato"];
        $validacao_gestor = $_POST["validacao_gestor"];
        $tipo = $_POST["tipo"]; //REQUIRED
        $nomefantasia = $_POST["nomefantasia"]; //REQUIRED
        $resp_financeiro = $_POST["resp_financeiro"];
        $email_financeiro = $_POST["email_financeiro"];

        $situac = 1;
        $imagem_update = NULL;

        // INICIO FORMATAÇÃO DE DADOS

        if ($id_tus_imp == 2) {
            $id_per_imp = 1;
        } else if ($id_tus_imp == 3) {
            $id_per_imp = 2;
        }

        if ($id_tus_ace == 2) {
            $id_per_ace = 1;
        } else if ($id_tus_ace == 3) {
            $id_per_ace = 2;
        }

        if ($email == "") {
            $email = NULL;
        }

        if ($contato == "") {
            $contato = NULL;
        } else {
            $contato = mb_strtoupper($contato, 'UTF-8');
        }

        if ($telefone == "") {
            $telefone = NULL;
        } else {
            $telefone = preg_replace('/\D+/', '', $telefone);
        }

        if ($endereco == "") {
            $endereco = NULL;
        }

        if ($bairro == "") {
            $bairro = NULL;
        }

        if ($numero == "") {
            $numero = NULL;
        }

        if ($complemento == "") {
            $complemento = NULL;
        }

        if ($cep == "") {
            $cep = NULL;
        } else {
            $cep = preg_replace('/\D+/', '', $cep);
        }

        if ($layout_folha == "") {
            $layout_folha = NULL;
        }

        if ($layout_ponto == "") {
            $layout_ponto = NULL;
        }

        if ($layout_irrf == "") {
            $layout_irrf = NULL;
        }

        if ($resp_financeiro == "") {
            $resp_financeiro = NULL;
        }

        if ($email_financeiro == "") {
            $email_financeiro = NULL;
        }

        if ($validacao_gestor == "") {
            $validacao_gestor = 0;
        }

        $nome = mb_strtoupper($nome, 'UTF-8');
        $nomefantasia = mb_strtoupper($nomefantasia, 'UTF-8');
        $endereco = mb_strtoupper($endereco, 'UTF-8');
        $bairro = mb_strtoupper($bairro, 'UTF-8');
        $numero = mb_strtoupper($numero, 'UTF-8');
        $complemento = mb_strtoupper($complemento, 'UTF-8');
        $layout_folha = mb_strtoupper($layout_folha, 'UTF-8');
        $layout_ponto = mb_strtoupper($layout_ponto, 'UTF-8');
        $layout_irrf = mb_strtoupper($layout_irrf, 'UTF-8');

        // FIM FORMATAÇÃO DE DADOS

        /*
        //Imprimir valores na tela para conferencia:        
        echo 'Nome: ' . $nome . '<br>';
        echo 'CNPJ: ' . $cnpj . '<br>';
        echo 'Endereço: ' . $endereco . '<br>';
        echo 'Numero: ' . $numero . '<br>';
        echo 'Bairro: ' . $bairro . '<br>';
        echo 'Cep: ' . $cep . '<br>';
        echo 'Complemento: ' . $complemento . '<br>';
        echo 'Folha: ' . $layout_folha . '<br>';
        echo 'Cidade: ' . $cidade . '<br>';
        echo 'Telefone: ' . $telefone . '<br>';
        echo 'Email: ' . $email . '<br>';
        echo 'Ponto: ' . $layout_ponto . '<br>';
        echo 'Id_per_imp: ' . $id_per_imp . '<br>';
        echo 'Id_per_ace: ' . $id_per_ace . '<br>';
        echo 'IRRF: ' . $layout_irrf . '<br>';
        echo 'Contato: ' . $contato . '<br>';
        echo 'Validação Gestor: ' . $validacao_gestor . '<br>';
        echo 'Tipo: ' . $tipo . '<br>';
        echo 'Nome Fantasia: ' . $nomefantasia . '<br>';
        echo 'Resp Financeiro: ' . $resp_financeiro . '<br>';
        echo 'Email Financeiro: ' . $email_financeiro . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'Iamgem: ' . $imagem_update . '<br>';
        echo 'Datinc: ' . $datinc . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID_Mas: ' . $id_mas_default . '<br><br><br>'; */

        // Gera a raiz do CNPJ
        $cnpj_exp = explode('/', $cnpj);
        $raiz = preg_replace('/\D+/', '', $cnpj_exp[0]);

        // Define os diretorios que serão criados
        $diretorio = [
            // Pastas em Beneficios
            '../upload/beneficios/holerite/' . $raiz,
            '../upload/beneficios/irrf/' . $raiz,
            '../upload/beneficios/ponto/' . $raiz,
            '../upload/beneficios/recibos_diversos/' . $raiz,

            // Pastas em Beneficios
            '../upload/cadastro/' . $raiz,

            // Pastas em Empresa
            '../upload/empresa/' . $raiz,

            // Pastas em Mensagens
            '../upload/mensagens/notificacoes/mural_aviso/' . $raiz,
            '../upload/mensagens/notificacoes/notificacoes/' . $raiz,
            '../upload/mensagens/solicitacoes/' . $raiz,

            // Pastas em Utilidades
            '../upload/utilidades/treinamentos/' . $raiz,
        ];

        // Cria os diretorios
        foreach ($diretorio as $pasta) {

            if (!file_exists($pasta)) {

                mkdir($pasta, 0700, true);

                // echo 'Pasta ' . $pasta . ' criada <br>';
            } else {

                // echo 'Pasta ' . $pasta . ' já existe <br>';
            }
        }



        //chamar função de insert
        $insertGESEMP_MASTER = insertGESEMP_MASTER(
            $nome,
            $cnpj,
            $endereco,
            $numero,
            $bairro,
            $cep,
            $situac,
            $complemento,
            $imagem_update,
            $layout_folha,
            $cidade,
            $telefone,
            $datinc,
            $datatu,
            $id_mas_default,
            $email,
            $layout_ponto,
            $id_per_imp,
            $id_per_ace,
            $layout_irrf,
            $contato,
            $validacao_gestor,
            $tipo,
            $nomefantasia,
            $resp_financeiro,
            $email_financeiro
        );

        $id_emp = $insertGESEMP_MASTER['pk'];

        $lay_h = 'VIS';
        $lay_p = 'VIS';
        $lay_i = 'VIS';


        insertGESLAY($id_emp, $lay_h, $lay_p, $lay_i);


        echo "<script language=javascript>
                 alert('Empresa adicionada com Sucesso!');
                 location.href = 'alterar_empresa?al=" .  $id_emp . "';
                 </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();

        echo "<script language=javascript>
        alert('Erro!');
        
    </script>";
    }
}
?>