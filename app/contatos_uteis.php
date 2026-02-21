<?php

//Faz a requisição da Sessão
require 'restrito.php';

// Chama a pagina de utilidades
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
    <title>Gestou - Contatos Uteis</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <?php include_once "menu_superior.php"; ?>

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV BTN VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>
                            <li class="breadcrumb-item active h4" aria-current="page">Contatos Uteis</li>
                        </ol>
                    </div>

                    <!-- DIV ROW -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">

                                <?php

                                foreach (select_GESCTO($id_emp_default) as $contatos_uteis) {

                                    if ($contatos_uteis != 0) {

                                ?>

                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $contatos_uteis["nome"]; ?>:</h6>
                                        </div>

                                        <label class="font-weight-bolder" style="padding: 0 1.75rem;"><?php echo $contatos_uteis["descricao"]; ?></label>

                                        <!-- INICIO LINHA 1 -->
                                        <div class="col-md-12" style="padding: 1.75em;">

                                            <div class="form-row">

                                                <?php if (($contatos_uteis["telefone1"] != "") or ($contatos_uteis["telefone1"] != NULL)) { ?>

                                                    <div class="col-md-4">

                                                        <label for="nome" class="mr-2 font-weight-bolder">Telefone1: </label><span class="font-size-8rem"><?php echo Mask("(###) ####-####", $contatos_uteis["telefone1"]); ?></span>
                                                        <hr>
                                                    </div>

                                                <?php } ?>
                                                <?php if (($contatos_uteis["telefone2"] != "") or ($contatos_uteis["telefone2"] != NULL)) { ?>

                                                    <div class="col-md-4">

                                                        <label for="cpf" class="mr-2 font-weight-bolder">Telefone2: </label><span class="font-size-8rem"><?php echo Mask("(###) ####-####", $contatos_uteis["telefone2"]); ?></span>
                                                        <hr>
                                                    </div>

                                                <?php } ?>
                                                <?php if (($contatos_uteis["telefone3"] != "") or ($contatos_uteis["telefone3"] != NULL)) { ?>

                                                    <div class="col-md-4">

                                                        <label for="rg" class="mr-2 font-weight-bolder">Telefone3: </label><span class="font-size-8rem"><?php echo Mask("(###) ####-####", $contatos_uteis["telefone3"]); ?></span>
                                                        <hr>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="form-row">

                                                <?php if (($contatos_uteis["email"] != "") or ($contatos_uteis["email"] != NULL)) { ?>

                                                    <div class="col-md-6">

                                                        <label for="nome" class="mr-2 font-weight-bolder">E-mail: </label><span class="font-size-8rem"><?php echo $contatos_uteis["email"]; ?></span>
                                                        <hr>
                                                    </div>

                                                <?php } ?>
                                                <?php if (($contatos_uteis["website"] != "") or ($contatos_uteis["website"] != NULL)) { ?>

                                                    <div class="col-md-6">

                                                        <label for="cpf" class="mr-2 font-weight-bolder">Website: </label><span class="font-size-8rem"><?php echo $contatos_uteis["website"]; ?></span>
                                                        <hr>
                                                    </div>

                                                <?php } ?>

                                            </div>

                                        </div>
                                        <!-- FIM LINHA 1 -->

                                <?php
                                    }
                                }

                                ?>

                            </div>
                        </div>

                    </div>
                    <!-- FIM DIV ROW -->

                    <?php if ($contatos_uteis == 0) {

                    ?>

                        <!-- DIV ROW -->
                        <div class="row mb-3">
                            <!-- SOBRE -->
                            <div class="m-auto">
                                <img class="img-fluid" width="400" src="img/logo/blank_contatos.png"></img>
                            </div>

                        </div>
                        <!-- FIM DIV ROW -->

                    <?php
                    }
                    ?>

                </div>
                <!-- FIM CONTAINER FLUID -->

            </div>
            <!-- FIM MAIN CONTENT -->

            <!-- FOOTER -->
            <?php include_once "footer.php"; ?>

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

</body>

</html>

<?php
function Mask($mask, $str)
{

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}

?>

<!-- AÇÕES NO CLICK -->
<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'empresa'
            location.href = 'empresa';
        });
    });
</script>