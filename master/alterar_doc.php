<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_doc = $_SESSION["editar_id_doc"];

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

    <title>GESTOU PORTAL - Dados Cadastrais</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom tinnyMCE-->
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        tinyMCE.init({
            selector: "#conteudo",
            height: 1000,
            language_url: 'tinymce/langs/pt_BR.js',
            plugins: 'link image imagetools code lists advlist autolink insertdatetime charmap directionality emoticons fullscreen hr preview print quickbars searchreplace table visualchars wordcount',

            toolbar1: 'insertfile undo redo | styles | numlist bullist hr bold italic underline forecolor | alignleft aligncenter alignright alignjustify | outdent indent | link image emoticons charmap insertdatetime',
            toolbar2: 'fullscreen code preview print searchreplace wordcount | ltr rtl visualchars | formatselect | blockquote quicklink | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol ',

            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            insertdatetime_formats: ['%d/%m/%Y', '%Y-%m-%d', '%d-%m-%Y', '%D', '%I:%M:%S %p', '%H:%M:%S', '%d/%m/%Y - %H:%M:%S']
        });
    </script>

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

                        <?php if (!isset($_SESSION['editar_id_doc'])) {

                            echo "<script>
                            Swal.fire({
                            icon: 'info',
                            title: 'Info',
                            title: 'Atenção!',
                            text: 'Não foi possível carregar os dados da documentação!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'tabela_documentacao';
                            }
                            });
                            </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Dados documentação</h6>
                        </div>

                        <div class="card-body">

                            <?php

                            foreach (selectGESDOCid_doc($id_doc) as $info_banco) {

                                $titulo = $info_banco['titulo'];
                                $conteudo = $info_banco['conteudo'];
                                $publicado = $info_banco['publicado'];
                                $grupo = $info_banco['grupo'];
                                $pai = $info_banco['pai'];
                                $datinc = $info_banco['datinc'];
                                $datatu = $info_banco['datatu'];
                            }
                            ?>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-dados-tab" data-toggle="tab" href="#nav-dados" role="tab" aria-controls="nav-dados" aria-selected="true">Dados documentação</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form class="" action="alterar_doc" method="POST" enctype="multipart/form-data">
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV DADOS -->
                                    <div class="tab-pane fade show active" id="nav-dados" role="tabpanel" aria-labelledby="nav-dados-tab">

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="titulo">Título</label>
                                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo ?>" required minlength="5">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="conteudo">Conteúdo</label>
                                                    <textarea class="form-control" id="conteudo" name="conteudo"><?php echo $conteudo ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="grupo">Grupo</label>
                                                    <input type="text" class="form-control" id="grupo" name="grupo" value="<?php echo $grupo ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="publicado">Publicado</label>
                                                    <select class="form-control" name="publicado" id="publicado" required>
                                                        <?php if ($publicado == 0) { ?>
                                                            <option value="0" selected>Não</option>
                                                            <option value="1">Sim</option>
                                                        <?php }
                                                        if ($publicado == 1) { ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="pai">Pai</label>
                                                    <input type="text" class="form-control" id="pai" name="pai" value="<?php echo $pai ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="datinc">Data inclusão</label>
                                                    <input type="text" class="form-control" id="datinc" name="datinc" value="<?php echo $datinc ?>" disabled>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="datatu">Data atualização</label>
                                                    <input type="text" class="form-control" id="datatu" name="datatu" value="<?php echo $datatu ?>" disabled>
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
                $.post('alterar_doc.php', dados, function(retorn) {

                    location.href = "tabela_documentacao";
                });
            }
        });
    });
</script>

<?php

if (isset($_REQUEST['btn-submit'])) {

    try {
        $titulo_update =  $_POST["titulo"];
        $conteudo_update = $_POST["conteudo"];
        $grupo_update = $_POST["grupo"];
        $publicado_update = $_POST["publicado"];
        $pai_update = $_POST["pai"];


        if ($titulo_update == "") {
            $titulo_update = NULL;
        }
        if ($conteudo_update == "") {
            $conteudo_update = NULL;
        }
        if ($grupo_update == "") {
            $grupo_update = NULL;
        }
        if ($publicado_update == "") {
            $publicado_update = NULL;
        }
        if ($pai_update == "") {
            $pai_update = NULL;
        }

        updateGESDOC($titulo_update, $conteudo_update, $publicado_update, $grupo_update, $pai_update, $id_doc);

        echo "<script language=javascript>
                 alert('Informação Atualizada com Sucesso!');
                 location.href = 'alterar_doc';         
             </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
        echo "<script language=javascript>
        alert('Erro!');
        location.href = 'alterar_doc';         
    </script>";
    }
}

// POST REALIZADO E UNSET DE VARIÁVEIS DE SESSÃO
if (isset($_POST['btn_voltar'])) {

    // VÁRIAVEL PARA LISTAR OS DADOS DA EMPRESA NA PÁGINA TABELA EMPRESAS
    unset($_SESSION['editar_id_doc']);
}
?>