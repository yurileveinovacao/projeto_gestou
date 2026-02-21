<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - APP</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once 'menu_superior.php'; ?>

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita mb-1 user-select-none">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Item Solicitação</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <!-- TOTAL PROVENTOS COLLAPSABLE -->
                        <div class="card shadow mb-2 width-100">
                            <!-- HEADER TOTAL PROVENTOS -->
                            <div class="d-block card-header py-3 collapsed">

                                <?php
                                try {
                                    //REQUEST DA PÁGINA ANTERIOR
                                    if (isset($_SESSION['id_sol_item'])) {

                                        $id_sol = $_SESSION['id_sol_item'];
                                ?>

                                        <?php foreach (select_GESSOL_id_sol($id_sol) as $solicitacoes) {

                                            $mensagem = $solicitacoes['mensagem'];
                                            $descri = $solicitacoes['descri'];
                                            $situacao = $solicitacoes['situacao'];
                                            $justificativa = $solicitacoes['justificativa'];
                                        } ?>

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA SOLICITAÇÃO</label>
                                                    <input type="text" class="form-control" value="<?php echo $descri; ?>" readonly disabled></input>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                                                    <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $mensagem; ?></textarea>
                                                </div>
                                            </div>

                                            <?php if (($situacao == 4) or (!empty($justificativa) and $situacao == 3)) { ?>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="justificativa" class="mt-sm-3 mb-2 font-weight-bold">RESPOSTA</label>
                                                        <textarea class="form-control" id="justificativa" name="justificativa" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled><?php echo $justificativa; ?></textarea>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                            <div class="form-row">
                                                <div class="form-group col-md-12 text-center">

                                                    <?php switch ($situacao) {

                                                        case 0: ?>

                                                            <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                <div class="btn btn-warning btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-exclamation-triangle"></i> </span>
                                                                    <span class="text font-weight-bold">ANDAMENTO</span>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                        case 3: ?>

                                                            <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                <div class="btn btn-success btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-check"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">APROVADO</span>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                        case 4: ?>

                                                            <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                                <div class="btn btn-danger btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="far fa-times-circle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">REPROVADO</span>
                                                                </div>
                                                            </div>
                                                    <?php break;
                                                    } ?>

                                                </div>
                                            </div>
                                        </div>

                                    <?php } else {

                                        echo "
                                            <script>
                                            Swal.fire({
                                            icon: 'info',
                                            title: 'Info',
                                            title: 'Atenção!',
                                            text: 'Nenhuma solicitação selecionada!'
                                            }).then((result) => {
                                            location.href='minhas_solicitacoes';
                                            });
                                            </script>
                                        ";
                                    } ?>

                                <?php } catch (PDOException $erro) {

                                    echo $erro->getMessage();
                                } ?>

                            </div>
                        </div>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM CONTAINER FLUID -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once 'footer.php'; ?>

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>

<script>
    // BTN VOLTAR
    $(function() {
        $(document).on('click', '.btn-voltar', function() {

            location.href = 'minhas_solicitacoes';
        });
    });
</script>