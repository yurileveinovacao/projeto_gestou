<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_app.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

if (isset($_SESSION['id_not_item'])) {

    unset($_SESSION['id_not_item']);
}

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

                <!-- TOPBAR -->
                <?php include_once "menu_superior.php"; ?>

                <!-- INICIO CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h4 btn-voltar" style="cursor: pointer; color: #224abe;" onmouseover="this.style.color='#3c0ba9';" onmouseout="this.style.color='#224abe';">
                                <i class="fas fa-chevron-circle-left fa-1x"></i>
                            </li>

                            <li class="breadcrumb-item active h4" aria-current="page">Notificações</li>
                        </ol>
                    </div>

                    <!-- DIV ROW -->
                    <div class="row mb-3">

                        <?php

                        // FOREACH COM RETORNO DOS AVISOS
                        foreach (select_GESNOT($id_usu_default) as $gesnot) {

                            $id_not = $gesnot['id_not'];
                            $titulo = $gesnot['titulo'];
                            $anexo = $gesnot['anexo'];
                            $mensagem = $gesnot['mensagem'];
                            $datainclusao = new DateTime($gesnot["datinc"]);
                            $visualizado = $gesnot['situac_usu_visualizar'];

                            if ($gesnot != 0) { ?>

                                <!-- AVISOS -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card h-100" style="cursor: pointer" not="<?php echo $id_not; ?>" visu="<?php echo $visualizado; ?>">
                                        <div class="card-body">
                                            <div class="row align-items-center text-align-center" style="text-align: center;">
                                                <div class="col mr-2">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-2">
                                                        <?php echo $titulo; ?>
                                                    </div>
                                                    <!-- <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                            Ano Calendário
                                                        </div> -->
                                                    <div class="text-xm font-weight-bold text-uppercase mb-2">
                                                        <span class="text-gray-800 mr-2">
                                                            <?php echo $datainclusao->format("d/m/Y"); ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-xm font-weight-bold text-uppercase mb-1">
                                                        <div class="btn btn-primary btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-eye"></i> </span>
                                                            <span class="text font-weight-bold">VISUALIZAR</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>

                                <div class="m-auto">
                                    <img class="img-fluid" width="400" src="img/logo/blank_notificacoes.png"></img>
                                </div>

                        <?php }
                        } ?>

                    </div>
                    <!-- FIM DIV ROW -->

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

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>


<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>

<script>
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Seleciona todos os elementos com a classe '.h-100'
        $('.h-100').each(function() {

            // Obtém o valor do atributo 'visu' de cada elemento
            var visualizar = $(this).attr('visu');

            // Verifica se o valor do atributo 'visu' é igual a 0
            if (visualizar == 0) {

                // Adiciona a classe 'bg-warning-lighter' ao elemento atual
                $(this).addClass('bg-warning-lighter');
            }
        });
    });
</script>

<script>
    // BTN VOLTAR
    // Esta função é executada quando o documento é carregado
    $(function() {
        // Ao clicar em um elemento com a classe 'btn-voltar'
        $(document).on('click', '.btn-voltar', function() {

            // Redireciona para a página 'fale_rh'
            location.href = 'fale_rh';
        });
    });

    $(function() {
        $(document).on('click', '.h-100', function() {

            // Variável para controle do botão de visualização
            btn_visu = 1;

            // Verifica se a variável btn_visu não está vazia
            if (btn_visu !== '') {

                var dados = {
                    // Obtém o atributo 'not' do elemento clicado
                    id_not: $(this).attr('not'),
                    // Obtém o atributo 'visu' do elemento clicado 
                    visu: $(this).attr('visu'),

                    // Adiciona o valor de btn_visu aos dados enviados
                    btn_visu: btn_visu
                };

                $.post('controller/notificacoes_post.php', dados, function(retorno) {

                    switch (retorno) {

                        case '1':
                            // Redireciona para a página 'notificacoes_item' em caso de sucesso
                            location.href = 'notificacoes_item';
                            break;

                        default:
                            // Exibe um aviso de erro com o conteúdo do retorno
                            Swal.fire({
                                icon: 'warning',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            });
                            break;

                    }
                });
            }
        });
    });
</script>