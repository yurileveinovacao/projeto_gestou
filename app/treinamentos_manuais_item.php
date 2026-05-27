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
    <link rel="icon" type="image/png" href="/img/favicon.png">
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

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <?php

                // Se a variável de sessão 'id_mur_mural' estiver definida, atribui o seu valor a $id_mur
                if (isset($_SESSION['id_tre_item'])) {

                    $id_tre = $_SESSION["id_tre_item"];
                } else {

                    // Caso contrário, exibe uma mensagem de aviso usando o plugin Swal.fire e redireciona para 'treinamentos_manuais'
                    echo "
                        <script>
                        Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        title: 'Atenção!',
                        text: 'Nenhum treinamento/manual selecionado!'
                        }).then((result) => {
                        location.href='treinamentos_manuais';
                        });
                        </script>
                    ";
                }

                ?>

                <!-- TOPBAR -->
                <?php include_once "menu_superior.php"; ?>

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita mb-1 user-select-none">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Itens Treinamentos</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <?php

                        foreach (selectGESTRE_item($id_tre) as $linha) {

                            // Obtém os valores dos campos do registro atual
                            $nome = $linha['nome'];
                            $anexo = $linha['anexo'];
                            $link = $linha['link'];

                            // Gera o nome do arquivo anexo usando o título e a extensão
                            $anexo_nome = $nome . '.pdf';

                        ?>

                            <!-- INICIO CARD SHADOW -->
                            <div class="card shadow mb-2 width-100">
                                <div class="d-block card-header py-3 collapsed">
                                    <div class="col-md-12">

                                        <?php if (!empty($anexo)) { ?>

                                            <div class="row">
                                                <!-- Cria um link para fazer o download do anexo -->
                                                <a href="../upload/utilidades/treinamentos/<?php echo $anexo; ?>" download="<?php echo $anexo_nome; ?>" class="width-100">
                                                    <button class="btn btn-compartilhar width-100 mb-3 m-auto">
                                                        <span class="icon mr-1">
                                                            <i class="fas fa-download"></i>
                                                        </span>
                                                        <span class="text font-weight-bold">DOWNLOAD</span>
                                                    </button>
                                                </a>
                                            </div>

                                        <?php } ?>

                                        <?php if (!empty($link)) {

                                            if (!empty($anexo)) { ?>

                                                <hr style="margin-top: 1rem;margin-bottom: 1rem;">
                                            <?php } ?>

                                            <div class="row">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Link:</h6>
                                            </div>

                                            <div class="row">
                                                <a href="<?php echo $link; ?>" target="_blank">
                                                    <h5 class="m-0 font-weight-bold text-primary mt-2" style="word-break: break-all;">
                                                        <?php echo $link; ?>
                                                    </h5>
                                                </a>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <!-- FIM CARD SHADOW -->

                        <?php } ?>

                    </div>
                    <!-- FIM DIV ROW -->

                </div>
                <!-- FIM DIV CONTAINER FLUID -->

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'treinamentos_manuais'
            location.href = 'treinamentos_manuais';
        });
    });

    // BTN DOWNLOAD
    $(function() {
        // Quando um elemento com a classe '.btn-compartilhar' é clicado, executa a função
        $(document).on('click', '.btn-compartilhar', function() {

            // Chama a função onClickDownload() do objeto Android (supõe-se que seja uma função definida em um contexto Android)
            Android.onClickDownload();
        });
    });
</script>