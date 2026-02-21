<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

unset($_SESSION['id_mnu']);

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

    <title>GESTOU PORTAL - Dados Cadastrais</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Dados do menu</h6>
                        </div>

                        <?php

                        if (isset($_REQUEST['al'])) {
                            try {
                                $_SESSION["id_mnu"] = $_REQUEST["al"];
                                $id_mnu = -1;
                            } catch (PDOException $erro) {
                                echo $erro->getMessage();
                            }
                        }else{
                            $id_mnu = -1;
                        }
                        ?> 

                        <div class="card-body">
                            
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

                            <?php

                            foreach (select_GESMNU($id_mnu) as $info_banco) {

                                $descri = $info_banco['descri'];
                                $icone = $info_banco['icone'];
                                $link = $info_banco['link'];
                                $target = $info_banco['target'];
                                $nivel = $info_banco['nivel'];
                                $ordem = $info_banco['ordem'];
                                $estagio = $info_banco['estagio'];
                                $caminho = $info_banco['caminho'];
                            }

                            ?>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-dados-tab" data-toggle="tab" href="#nav-dados" role="tab" aria-controls="nav-dados" aria-selected="true">Dados do menu</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form class="" action="cadastro_menu" method="POST" enctype="multipart/form-data">
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV DADOS -->
                                    <div class="tab-pane fade show active" id="nav-dados" role="tabpanel" aria-labelledby="nav-dados-tab">

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="descri">Descrição</label>
                                                    <input type="text" class="form-control" id="descri" name="descri" value="<?php echo $descri ?>" required minlength="5">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="icone">Icone</label>
                                                    <input type="text" class="form-control" id="icone" name="icone" value="<?php echo $icone ?>" ></input>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="link">Link</label>
                                                    <input type="text" class="form-control" id="link" name="link" value="<?php echo $link ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="_target">Target</label>
                                                    <input type="text" class="form-control" id="_target" name="_target" value="<?php echo $target ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="nivel">Nível</label>
                                                    <input type="text" class="form-control" id="nivel" name="nivel" value="<?php echo $nivel ?>">
                                                </div>                                                
                                                <div class="form-group col-md-2">
                                                    <label for="ordem">Ordem</label>
                                                    <input type="text" class="form-control" id="ordem" name="ordem" value="<?php echo $ordem ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estagio">Estágio</label>
                                                    <input type="text" class="form-control" id="estagio" name="estagio" value="<?php echo $estagio ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-4">
                                                    <label for="caminho">Caminho</label>
                                                    <input type="text" class="form-control" id="caminho" name="caminho" value="<?php echo $caminho ?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM DIV DADOS -->

                                    <!-- INICIO DIV ENDEREÇO -->
                                    <!-- FIM DIV ENDEREÇO -->

                                    <!-- INICIO DIV OUTRAS INFORMAÇÕES -->
                                    <!-- FIM DIV OUTRAS INFORMAÇÕES -->

                                    <!-- INICIO DIV AUTOMACOES-->
                                    <!-- FIM DIV AUTOMACOES -->
                    
                                </div>
                                <!-- FIM DIV TAB CONTENT -->

                                <!-- BOTÃO FORM -->
                                <div class="textalign-right">
                                    <button type="submit" name="btn-submit" onclick="return confirm('Tem certeza que deseja salvar os dados?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                    <a href="tabela_menus"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                </div>
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

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>            

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- partial -->
            <script src="./croppie/script_empresa.js"></script>

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

    var telMask = ['(999) 9999-99999', '(999) 9999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);

    var cepMask = ['99999-9999', '99999-999'];
    var cep = document.querySelector('input[attrname=cep]');
    VMasker(cep).maskPattern(cepMask[0]);
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);
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

<?php

if (isset($_REQUEST['btn-submit'])) {

    try {
        $descri_update =  $_POST["descri"];
        $icone_update = $_POST["icone"];
        $link_update = $_POST["link"];
        $_target_update = $_POST["_target"];
        $nivel_update = $_POST["nivel"];
        $ordem_update = $_POST["ordem"];
        $estagio_update = $_POST["estagio"];
        $caminho_update = $_POST["caminho"];

        if ($icone_update == "") {
            $icone_update = NULL;
        } 
        if ($_target_update == "") {
            $_target_update = NULL;
        }
        if ($link_update == "") {
            $link_update = NULL;
        }

        //chamar função de insert e recuperar pk
        $id_mnu_novo = insertGESMNU($descri_update, $icone_update, $link_update, $_target_update, $nivel_update, $ordem_update, $estagio_update, $caminho_update);

        //echo 'Dados: ' . $descri_update . '<br>' . $icone_update. '<br>' . $link_update. '<br>' . $_target_update. '<br>' . $nivel_update. '<br>' . $ordem_update. '<br>' . $estagio_update. '<br>' . $caminho_update;

        //echo 'ID gerado : ' .  $id_mnu_novo['pk'];

        //armazenar o novo id_emp gerado na sessao
        $_SESSION["id_mnu"] = $id_mnu_novo['pk'];

        echo "<script language=javascript>
                 alert('Informação inserida com sucesso!');
                 location.href = 'alterar_menu?al=" .  $_SESSION["id_mnu"] . "';                
             </script>";
        
    } catch (PDOException $erro) {
        echo $erro->getMessage();
        echo "<script language=javascript>
        alert('Erro!');
        location.href = 'alterar_menu?al=" .  $_SESSION["id_mnu"] . "';                 
    </script>";
    }
    
}

?>