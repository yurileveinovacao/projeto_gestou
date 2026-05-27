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

    <title>GESTOU PORTAL - Artigo</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include_once 'menu_lateral.php';
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once 'barra_superior.php';
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php

                    $id_doc_documentacao = $_SESSION["id_doc_documentacao"];

                    if (!empty($id_doc_documentacao)) {

                    ?>

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>

                        <!-- Begin card shadow mb-4  -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Base de conhecimento</h6>
                            </div>
                            <!-- Begin card-body -->
                            <div class="card-body p-1">
                                <div class="col-sm-12 text-right p-3">
                                    <a href="documentacao"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar home" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>
                                </div>

                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-9">

                                            <!-- BEGIN SELECT CARDS -->
                                            <?php

                                            foreach (selectGESDOCid_doc($id_doc_documentacao) as $artigo) {
                                                $id_doc = $artigo["id_doc"];
                                                $titulo  = $artigo["titulo"];
                                                $conteudo  = $artigo["conteudo"];
                                                $publicado  = $artigo["publicado"];
                                                $grupo = $artigo["grupo"];
                                                $pai = $artigo["pai"];
                                                $datinc = $artigo["datinc"];
                                                $datatu = $artigo["datatu"];
                                                $datatuatualizacao = $artigo["datatuatualizacao"];

                                            ?>
                                                <div class="col-xl-12 col-md-6 mb-4">
                                                    <div class="card border-left-primary shadow h-100 padd-1">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center p-1">
                                                                <div class="col mr-2">
                                                                    <div class="h4 mb-4 font-weight-bold text-gray-800">
                                                                        <?php echo $titulo; ?>
                                                                        <hr>
                                                                    </div>
                                                                    <div class="mb-0 text-gray-800">
                                                                        <!-- EXIBIR ARTIGO -->
                                                                        <div class="mb-4 conteudo-artigo">
                                                                            <?php echo $conteudo; ?>
                                                                        </div>

                                                                        <div class="text-right">
                                                                            Atualizado em: <?php echo $datatuatualizacao; ?>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php

                                            }

                                            ?>
                                            <!-- END OF SELECT CARDS -->

                                        </div>

                                        <div class="col-md-3">

                                            <div class="row" id="accordion">

                                                <!-- MONTA O CARD SOMENTE QUANDO A CLASSIFICAÇÃO FOR P -->
                                                <div class="col-md-12 mb-4">
                                                    <div class="card border-left-primary shadow h-100 padd-1">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center p-1">
                                                                <div class="col mr-2">
                                                                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                                                                        Artigos Relacionados
                                                                    </div>

                                                                    <?php

                                                                    // FOREACH PARA LISTAR AS INFORMAÇÕES DO PAI
                                                                    foreach (selectVW_GESDOC_PAI_artigo($id_doc_documentacao) as $pai_informacoes) {

                                                                        $titulo_pai = $pai_informacoes["titulo"];
                                                                        $classificacao_pai = $pai_informacoes["classificacao"];
                                                                        $grupo_pai = $pai_informacoes["grupo"];
                                                                        $pai = $pai_informacoes["pai"];

                                                                    ?>

                                                                        <div class="h6 mb-0 mt-2 font-weight-bold text-gray-800">
                                                                            <?php echo $grupo_pai . " - " . $titulo_pai; ?>
                                                                        </div>

                                                                        <?php

                                                                        // FOREACH PARA LISTAR AS INFORMAÇÕES DO FILHO
                                                                        foreach (selectVW_GESDOC_FILHO_artigo($id_doc_documentacao) as $filho_informacoes) {

                                                                            $id_doc_filho = $filho_informacoes["id_doc"];
                                                                            $titulo_filho = $filho_informacoes["titulo"];
                                                                            $classificacao_filho = $filho_informacoes["classificacao"];
                                                                            $grupo_filho = $filho_informacoes["grupo"];
                                                                            $filho_pai = $filho_informacoes["pai"];

                                                                            $collapse_neto = str_replace(".", "_", $grupo_filho);

                                                                        ?>

                                                                            <!-- UL PARA LISTAR OS ITENS FILHO -->
                                                                            <ul class="mb-0 ul-padding-left-n">
                                                                                <li class="filho list-unstyled">

                                                                                    <div id="heading_base<?php echo $collapse_neto; ?>">
                                                                                        <h5 class="mb-0">
                                                                                            <button class="btn btn-transparent text-gray-800" data-toggle="collapse" data-target="#collapse_base<?php echo $collapse_neto; ?>" aria-expanded="true" aria-controls="collapse_base<?php echo $collapse_neto; ?>">
                                                                                                <b><?php echo $grupo_filho . " - " . $titulo_filho; ?></b>
                                                                                            </button>
                                                                                        </h5>
                                                                                    </div>

                                                                                    <!-- <a href="javascript:void(0);" class="a_filho" data-toggle="collapse" data-target="#collapseNeto?php echo $collapse_neto; ?>" aria-expanded="false" aria-controls="collapseNeto"></a> -->

                                                                                    <!-- UL PARA LISTAR OS ITENS NETO -->
                                                                                    <ul id="collapse_base<?php echo $collapse_neto; ?>" class="collapse show ul-padding-left-n" aria-labelledby="heading_base<?php echo $collapse_neto; ?>" data-parent="#accordion">

                                                                                        <?php

                                                                                        // FOREACH PARA LISTAR AS INFORMAÇÕES DO NETO
                                                                                        foreach (selectVW_GESDOC_NETO_artigo($id_doc_documentacao) as $neto_informacoes) {

                                                                                            $id_doc_neto = $neto_informacoes["id_doc"];
                                                                                            $titulo_neto = $neto_informacoes["titulo"];
                                                                                            $classificacao_neto = $neto_informacoes["classificacao"];
                                                                                            $grupo_neto = $neto_informacoes["grupo"];
                                                                                            $filho_neto = $neto_informacoes["pai"];

                                                                                            if ($neto_informacoes != 0) {

                                                                                        ?>

                                                                                                <li class="neto list-unstyled">

                                                                                                    <a href="javascript:void(0);" class="direcionamento" link="<?php echo $id_doc_neto; ?>"><?php echo $grupo_neto . " - " . $titulo_neto; ?></a>

                                                                                                </li>

                                                                                        <?php

                                                                                            } else {
                                                                                            }
                                                                                        }
                                                                                        //FIM FOREACH NETO

                                                                                        ?>

                                                                                    </ul>
                                                                                    <!-- FIM UL PARA LISTAR OS ITENS NETO -->


                                                                                </li>
                                                                            </ul>
                                                                            <!-- FIM UL PARA LISTAR OS ITENS FILHO -->

                                                                        <?php

                                                                        }
                                                                        //FIM FOREACH FILHO

                                                                        ?>

                                                                    <?php

                                                                    }
                                                                    //FIM FOREACH PAI

                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- End of card-body -->
                        </div>
                        <!-- End of card shadow mb-4  -->

                    <?php

                    } else {

                        echo "<script language=javascript>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                title: 'Atenção!',
                                text: 'Selecione um artigo para realizar a consulta!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                location.href='documentacao';
                                }
                            })
                            </script>";
                    }

                    ?>

                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {

        $(document).on('click', '.direcionamento', function() {

            var link = $(this).attr("link");

            //verificar se há calor nas variaveis
            if (link !== '') {
                var dados = {
                    link: link
                };
                $.post('artigo.php', dados, function(retorna) {

                    location.href = "artigo";

                });

            }

        });

    });
</script>

<?php

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS 
if (isset($_POST["link"])) {

    // VÁRIAVEL PARA LISTAR OS DADOS DA DOCUMENTAÇÃO NA PÁGINA ARTIGO
    $_SESSION["id_doc_documentacao"] = $_POST["link"];
}


?>