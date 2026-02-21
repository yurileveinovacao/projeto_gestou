<?php
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
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Documentos Diversos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputsembotaoupload.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Documentos Diversos</h6>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">

                                <form action="recibo_diversos" method="POST" enctype="multipart/form-data">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="descricao" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Reembolso, Devolução valor.">Descrição <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="descricao" name="descricao" style="text-transform: uppercase;" placeholder="Insira uma descrição..." required></input>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="funcionario" class="mt-sm-3">Funcionário</label>
                                            <select id="funcionario" name="funcionario" class="form-control" required>
                                                <option value="" disabled selected>Escolha um funcionário</option>

                                                <?php foreach (selectGESUSU_usuario($id_emp_default) as $usuario_banco) { ?>

                                                    <option value="<?php echo $usuario_banco["id_usu"]; ?>"><?php echo $usuario_banco["nome"]; ?></option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="row mt-sm-2">
                                                <label for="input-b1">Arquivo</label>
                                                <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".pdf" required>
                                                <!-- <sup class="textalign-right mt-sm-4">Proporção 4:3 (800 x 600px)</sup> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-upload"></i> Enviar</button>
                                            <a href="importacao"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar importação" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>

                                        </div>
                                    </div>
                                </form>



                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once 'footer.php';

            ?>
            <!-- End of Footer -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <!-- <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script> -->

</body>

</html>

<?php

if (isset($_REQUEST['btn-submit'])) {
    try {
        $descricao = $_POST['descricao'];
        $arquivo = $_FILES['input-b1']['size'];
        $funcionario = $_POST['funcionario'];
        $descricao = mb_strtoupper($descricao, 'UTF-8');

        $val1 = uniqid();
        $val2 = uniqidReal();
        $validador = $raiz_cnpj . $val1 . $val2;
        $validador = $validador;

        if (!empty($descricao) and ($arquivo != 0) and !empty($funcionario)) {

            insert();
        } else {
            echo "<script language=javascript>
            alert('Preencha um campo para efetuar a ação!');
            location.href='recibo_diversos';
            </script>";
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>

<?php

function insert()
{

    global $descricao;
    global $funcionario;
    global $id_emp_default;
    global $id_usa_default;
    global $raiz_cnpj;
    global $datinc;
    global $validador;


    //CÓDIGO PARA MOVER A IMAGEM ANEXADA PARA O DIRETORIO DO PROJETO

    $nomearquivo = $_FILES['input-b1']['name'];
    $temp = $_FILES['input-b1']['tmp_name'];
    $tamanho = $_FILES['input-b1']['size'];
    $tipoimg = $_FILES['input-b1']['type'];
    $erro = $_FILES['input-b1']['error'];

    $ext = pathinfo($nomearquivo, PATHINFO_EXTENSION);

    if ($tamanho > 100000000) {
        echo "<script language=javascript>
        alert('O arquivo anexado é maior que o limite de 10MB !');
        location.href = 'recibo_diversos';
        </script>";
        exit;
    }

    if (file_exists('../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '')) {

        $origem = $nomearquivo;

        $id_processamento = uniqidReal();

        //renomear o nome da imagem
        $novo_nomearquivo = $raiz_cnpj . '_' . $id_processamento . '_recibodiversos.' . $ext;
        //$novo_nomeimg= 'teste'.'.'.$extensao;

        //Comando para mover o arquivo para a pasta
        $mover = move_uploaded_file($temp, '../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $novo_nomearquivo);

        insertGESREC($raiz_cnpj, $id_emp_default, $funcionario, $origem, $novo_nomearquivo, $id_processamento, $validador, $descricao, $datinc, $id_usa_default);

        echo "<script language=javascript>
    alert('Informação incluida com Sucesso!');
    location.href = 'lotes_processados';
    </script>";
    } else {

        mkdir('../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/', 0777, true);

        $origem = $nomearquivo;

        $id_processamento = uniqidReal();

        //renomear o nome da imagem
        $novo_nomearquivo = $raiz_cnpj . '_' . $id_processamento . '_recibodiversos.' . $ext;
        //$novo_nomeimg= 'teste'.'.'.$extensao;

        //Comando para mover o arquivo para a pasta
        $mover = move_uploaded_file($temp, '../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $novo_nomearquivo);

        insertGESREC($raiz_cnpj, $id_emp_default, $funcionario, $origem, $novo_nomearquivo, $id_processamento, $validador, $descricao, $datinc, $id_usa_default);

        echo "<script language=javascript>
    alert('Informação incluida com Sucesso!');
    location.href = 'lotes_processados';
    </script>";
    }
}

?>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<?php

function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }

    return substr(bin2hex($bytes), 0, $lenght);
}

?>