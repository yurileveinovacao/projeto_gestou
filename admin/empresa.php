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
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Sobre nós</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  
 <!-- the main fileinput plugin script JS file -->
 <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputimg.min.js"></script>
  
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
                        <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Sobre nós</h6>
                        </div>
                        <div class="card-body">

                        <div class="col-md-12">
                                <form class="" action="empresa.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="row">
                                                <label for="input-b1">Imagem</label>
                                                    <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" accept=".png,.jpg,.jpeg">
                                                    <sup class="textalign-right mt-sm-4">Proporção 4:3 (800 x 600px)</sup>
                                            </div>
                                                <label for="inputTextarea" class="mt-sm-3">Texto Opcional</label>
                                                    <textarea class="form-control"  id="inputTextarea" name="inputTextarea" style="height: 150px; resize: none"
                                                        placeholder="Texto sobre a Empresa..."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="textalign-right">
                                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                            
                                            <?php

foreach (selectGESSOB($id_emp_default) as $resultados_modal) {

    $texto_banco_modal = $resultados_modal['sob_texto'];
    $caminho_banco_modal = $resultados_modal['sob_imagem'];

    }


    if(($texto_banco_modal == NULL) and ($caminho_banco_modal == NULL)){

      ?>

    <button disabled type="button" data-toggle="modal" data-target="#Visualizar" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button>

<?php

    }else{

?>

<button type="button" data-toggle="modal" data-target="#Visualizar" name="modal" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button>

<?php

    }

?>

                                    </div>
                                </div>    
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <?php

if (isset($_REQUEST['btn-submit'])) {
        try {
            
            $texto = $_POST["inputTextarea"];
            $anexo = $_FILES['input-b1']['size'];

            if(!empty($texto) or ($anexo != 0)){

//SELECT QUE VERIFICA SE HÁ LINHAS DESSA EMPRESA
foreach (selectGESSOB($id_emp_default) as $resultados) {
if (empty($resultados)) {
        
    insert();
     }else{
        update();
    }
}

}else{

            echo "<script language=javascript>
            alert('Preencha um campo para efetuar a ação!');
            location.href='empresa.php';
            </script>";
            
        }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}
}


// FUNÇÃO INSERT

function insert(){

    global $texto;
    global $anexo;
    global $id_emp_default;
    global $id_usa_default;
    global $raiz_cnpj;
    global $datinc;
    global $datatu;

if($anexo == 0){

    foreach (selectGESSOB($id_emp_default) as $resultados4) {

        $caminho_banco = $resultados4['sob_imagem'];

        }
        
        $novo_nomeimg = $caminho_banco;

}else{

    //CÓDIGO PARA MOVER A IMAGEM ANEXADA PARA O DIRETORIO DO PROJETO

    $nomeimg = $_FILES['input-b1']['name'];
    $temp = $_FILES['input-b1']['tmp_name'];
    $tamanho = $_FILES['input-b1']['size'];
    $tipoimg = $_FILES['input-b1']['type'];
    $erro = $_FILES['input-b1']['error'];

    $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

    if ($tamanho > 100000000) {
        echo "<script language=javascript>
        alert('O arquivo anexado é maior que o limite de 10MB !');
        location.href = 'empresa.php';
        </script>";
    exit;
    }

    if(empty($texto)){

        foreach (selectGESSOB($id_emp_default) as $resultados2) {
    
            $texto_banco = $resultados2['sob_texto'];
    
            }
    
        $texto = $texto_banco;
    
    }

    //renomear o nome da imagem
    $novo_nomeimg = $raiz_cnpj.'_sobre.'.$ext;
    //$novo_nomeimg= 'teste'.'.'.$extensao;

    //Comando para mover o arquivo para a pasta
    $mover = move_uploaded_file($temp, '../upload/empresa/'.$novo_nomeimg);

}

    insertGESSOB($id_emp_default, $texto, $novo_nomeimg, NULL, NULL, NULL, NULL, NULL, NULL, $datinc, $datatu, $id_usa_default, $id_usa_default);

    echo "<script language=javascript>
    alert('Informação incluido com sucesso!');
    location.href = 'empresa.php';
    </script>";
}

// FUNÇÃO UPDATE

function update(){

    global $texto;
    global $anexo;
    global $id_emp_default;
    global $id_usa_default;
    global $raiz_cnpj;
    global $datatu;

    foreach (selectGESSOB($id_emp_default) as $resultados1) {

        $caminho_banco = $resultados1['sob_imagem'];

        }

    if($anexo == 0){


        $novo_nomeimg = $caminho_banco;
       
    
    }else{

    $nomeimg = $_FILES['input-b1']['name'];
    $temp = $_FILES['input-b1']['tmp_name'];
    $tamanho = $_FILES['input-b1']['size'];
    $tipoimg = $_FILES['input-b1']['type'];
    $erro = $_FILES['input-b1']['error'];

    $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

    if ($tamanho > 100000000) {
        echo "<script language=javascript>
        alert('O arquivo anexado é maior que o limite de 10MB !');
        location.href = 'empresa.php';
        </script>";
    exit;
    }

    if(empty($texto)){

        foreach (selectGESSOB($id_emp_default) as $resultados2) {
    
            $texto_banco = $resultados2['sob_texto'];
    
            }
    
        $texto = $texto_banco;
    
    }

    if($caminho_banco != NULL){
    unlink('../upload/empresa/'.$caminho_banco.'');

    }

    //renomear o nome da imagem
    $novo_nomeimg = $raiz_cnpj.'_sobre.'.$ext;
    //$novo_nomeimg= 'teste'.'.'.$extensao;

    //Comando para mover o arquivo para a pasta
    $mover = move_uploaded_file($temp, '../upload/empresa/'.$novo_nomeimg);

    }

    updateGESSOB_sobre($texto, $novo_nomeimg, $datatu, $id_usa_default, $id_emp_default);

    echo "<script language=javascript>
    alert('Informação Atualizada com Sucesso!');
    location.href = 'empresa.php';
    </script>";

}
    ?>

    <!-- Visualizar Organograma Modal-->
    <div class="modal fade" id="Visualizar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Visualizar">Sobre</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="empresa.php">
                    <div class="modal-body">
                        <div class="col-md-12">

                        <?php

                        if($caminho_banco_modal == NULL){

}else{

?>

<div class="textalign-center">

                                <img src="../upload/empresa/<?php echo $caminho_banco_modal ?>" class="img-modal"></img>

                            </div>

<?php

}

if($texto_banco_modal == NULL){

}else{

?>

<div class="textalign-justify">

                                <h6 class="text-justify"><?php echo $texto_banco_modal ?></h6>

                            </div>

<?php

}

?>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="botao-excluir" onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php


if (isset($_REQUEST['botao-excluir'])) {
    try {

        updateGESSOB_sobre(NULL, NULL, $datatu, $id_usa_default, $id_emp_default);

        if($caminho_banco_modal != NULL){
            unlink('../upload/empresa/'.$caminho_banco_modal.'');
        
            }
        echo "<script language=javascript>
        alert('Deletado com Sucesso!');
        location.href = 'empresa.php';
        </script>";
        
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
?>

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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>