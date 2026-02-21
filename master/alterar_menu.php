<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_mnu = $_SESSION["editar_id_mnu"];

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

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

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

                        <?php if (!isset($_SESSION['editar_id_mnu'])) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados do menu!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'tabela_menus';
                                }
                                });
                                </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Dados do menu</h6>
                        </div>

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
                            <form class="" action="alterar_menu" method="POST" enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control" id="icone" name="icone" value="<?php echo $icone ?>"></input>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="link">Link</label>
                                                    <input type="text" class="form-control" id="link" name="link" value="<?php echo $link ?>">
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

                                </div>
                                <!-- FIM DIV TAB CONTENT -->

                                <!-- BOTÃO FORM -->
                                <div class="textalign-right">
                                    <button type="submit" name="btn-submit" onclick="return confirm('Tem certeza que deseja alterar os dados?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                    <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
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

<script>
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            var btn_voltar = 1;

            if (btn_voltar !== '') {

                var dados = {

                    btn_voltar: btn_voltar
                };
                $.post('alterar_menu.php', dados, function(retorn) {

                    location.href = "tabela_menus";
                });
            }
        });
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


        update_GESMNU($descri_update, $icone_update, $link_update, $_target_update, $nivel_update, $ordem_update, $estagio_update, $caminho_update, $id_mnu);

        echo "<script language=javascript>
                 alert('Informação Atualizada com Sucesso!');
                 location.href = 'alterar_menu';         
             </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
        echo "<script language=javascript>
        alert('Erro!');
        location.href = 'alterar_menu';         
    </script>";
    }
}

// POST REALIZADO E UNSET DE VARIÁVEIS DE SESSÃO
if (isset($_POST['btn_voltar'])) {

    // VÁRIAVEL PARA LISTAR OS DADOS DA EMPRESA NA PÁGINA TABELA EMPRESAS
    unset($_SESSION['editar_id_mnu']);
}

?>