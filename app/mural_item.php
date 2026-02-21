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
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <?php

                // Se a variável de sessão 'id_mur_mural' estiver definida, atribui o seu valor a $id_mur
                if (isset($_SESSION['id_mur_mural'])) {

                    $id_mur = $_SESSION["id_mur_mural"];
                } else {

                    // Caso contrário, exibe uma mensagem de aviso usando o plugin Swal.fire e redireciona para 'mural_avisos'
                    echo "
                        <script>
                        Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        title: 'Atenção!',
                        text: 'Nenhum aviso selecionado!'
                        }).then((result) => {
                        location.href='mural_avisos';
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

                            <li class="breadcrumb-item active h4" aria-current="page">Itens Mural de Avisos</li>
                        </ol>

                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-1">

                        <?php

                        foreach (select_GESMUR_item($id_mur) as $mural_item) {

                            // Obtém os valores dos campos do registro atual
                            $id_mur = $mural_item['id_mur'];
                            $titulo = $mural_item['titulo'];
                            $anexo = $mural_item['anexo'];
                            $mensagem = $mural_item['mensagem'];
                            $situac = $mural_item['situac'];
                            $verificacao = $mural_item["verificacao"];

                            // Obtém a extensão do arquivo anexo
                            $ext = pathinfo($anexo, PATHINFO_EXTENSION);

                            // Gera o nome do arquivo anexo usando o título e a extensão
                            $anexo_nome = $titulo . '.' . $ext;

                        ?>

                            <!-- INICIO CARD SHADOW -->
                            <div class="card shadow mb-2 width-100">
                                <div class="d-block card-header py-3 collapsed" style="overflow-wrap: anywhere;">
                                    <div class="col-md-12">

                                        <?php if (!empty($anexo)) {

                                            switch ($verificacao) {

                                                case 'ARQUIVO': ?>
                                                    <div class="row">
                                                        <!-- Cria um link para fazer o download do anexo -->
                                                        <a href="../upload/mensagens/notificacoes/mural_aviso/<?php echo $anexo; ?>" download="<?php echo $anexo_nome; ?>" class="width-100">
                                                            <button class="btn btn-compartilhar width-100 mb-3 m-auto">
                                                                <span class="icon mr-1">
                                                                    <i class="fas fa-download"></i>
                                                                </span>
                                                                <span class="text font-weight-bold">DOWNLOAD</span>
                                                            </button>
                                                        </a>
                                                    </div>
                                                <?php break;

                                                case 'IMAGEM': ?>
                                                    <div class="row">
                                                        <!-- Exibe a imagem anexa -->
                                                        <img src="../upload/mensagens/notificacoes/mural_aviso/<?php echo $anexo; ?>" class="img-fluid m-auto"></img>
                                                    </div>
                                            <?php break;
                                            } ?>

                                        <?php } ?>

                                        <?php if (!empty($mensagem)) {

                                            if (!empty($anexo)) { ?>

                                                <hr style="margin-top: 1rem;margin-bottom: 1rem;">
                                            <?php } ?>

                                            <div class="row">
                                                <h6 class="m-0 font-weight-bold text-gray-800">Mensagem:</h6>
                                            </div>

                                            <div class="row" style="padding-top: 5px;">
                                                <h5 class="m-0 font-weight-bold mt-2">
                                                    <?php echo $mensagem; ?>
                                                </h5>
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

</body>

</html>

<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'mural_avisos'
            location.href = 'mural_avisos';
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