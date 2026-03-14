<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

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

<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body id="page-top">

    <!-- DIV WRAPPER -->
    <div id="wrapper">

        <!-- MENU LATERAL -->
        <?php

        include_once "menu_lateral.php";

        ?>
        <!-- FIM MENU LATERAL -->

        <!-- DIV CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DIV MENU CONTENT -->
            <div id="content">

                <?php

                if (isset($_SESSION["id_not_item"])) {

                    $id_not = $_SESSION["id_not_item"];
                } else {

                    echo "
                        <script>
                        Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        title: 'Atenção!',
                        text: 'Nenhuma notificação selecionada!'
                        }).then((result) => {
                        location.href='notificacoes';
                        });
                        </script>
                    ";
                }

                ?>

                <!-- MENU SUPERIOR -->
                <?php

                include_once "menu_superior.php";

                ?>
                <!-- FIM MENU SUPERIOR -->

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Itens Notificação</li>
                        </ol>
                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <?php

                        foreach (select_GESNOT_item($id_not) as $notificacoes_item) {

                            $id_not = $notificacoes_item['id_not'];
                            $titulo = $notificacoes_item['titulo'];
                            $anexo = $notificacoes_item['anexo'];
                            $mensagem = $notificacoes_item['mensagem'];
                            $situac = $notificacoes_item['situac'];
                            $verificacao = $notificacoes_item["verificacao"];

                        ?>

                            <!-- TOTAL PROVENTOS COLLAPSABLE -->
                            <div class="card shadow mb-2 width-100">
                                <!-- HEADER TOTAL PROVENTOS -->
                                <div class="d-block card-header py-3 collapsed" style="overflow-wrap: anywhere;">

                                    <div class="col-md-12">

                                        <?php if (!empty($anexo)) { ?>

                                            <?php if ($verificacao == "ARQUIVO") { ?>

                                                <div class="row">
                                                    <a href="../upload/mensagens/notificacoes/notificacoes/<?php echo $anexo; ?>" download="<?php echo $titulo; ?>" class="width-100">
                                                        <button class="btn btn-compartilhar width-100 mb-3 m-auto" onclick="onClickDownload()">
                                                            <span class="icon mr-1">
                                                                <i class="fas fa-download"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">DOWNLOAD</span>
                                                        </button>
                                                    </a>
                                                </div>

                                            <?php } ?>

                                            <?php if ($verificacao == "IMAGEM") { ?>

                                                <div class="row">
                                                    <img src="../upload/mensagens/notificacoes/notificacoes/<?php echo $anexo; ?>" class="img-fluid m-auto"></img>
                                                </div>

                                            <?php } ?>

                                        <?php } ?>

                                        <?php if (!empty($mensagem)) { ?>

                                            <?php if (!empty($anexo)) { ?>
                                                <hr style="margin-top: 1rem;margin-bottom: 1rem;">
                                            <?php } ?>

                                            <div class="row">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Mensagem:</h6>
                                            </div>
                                            <div class="row" style="padding-top: 5px;">
                                                <h5 class="m-0 font-weight-bold">
                                                    <?php echo $mensagem; ?>
                                                </h5>
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <!-- <h6 class="m-0 font-weight-bold text-gray-800">Ano Calendário</h6><br>
                                            <h5 class="m-0 font-weight-bold text-primary">
                                                ?php echo $anocal; ?>
                                            </h5> -->
                                </div>
                            </div>

                        <?php

                        }

                        ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM DIV CONTAINER FLUID -->

            </div>
            <!-- FIM DIV CONTENT -->

            <!-- FOOTER -->
            <?php include_once "footer.php"; ?>

            <!-- Scroll to top -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>
        <!-- FIM DIV CONTENT WRAPPER -->

    </div>
    <!-- FIM DIV WRAPPER -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<script type="text/javascript">
    function onClickDownload() {
        Android.onClickDownload();
    }
</script>

<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'notificacoes'
            location.href = 'notificacoes';
        });
    });
</script>