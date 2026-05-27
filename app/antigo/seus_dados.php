<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../../config/database.php';

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
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>
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

                <!-- MENU SUPERIOR -->
                <?php

                include_once "menu_superior.php";

                ?>
                <!-- FIM MENU SUPERIOR -->

                <!-- DIV CONTAINER FLUID-->
                <div class="container-fluid" id="container-wrapper">

                    <!-- DIV ICONE VOLTAR -->
                    <div class="iconedireita mb-4 user-select-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item h5"><a href="index"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
                            <li class="breadcrumb-item active h5" aria-current="page">Seus Dados</li>
                        </ol>
                    </div>
                    <!-- FIM DIV ICONE VOLTAR -->

                    <?php

                    //   foreach (select_GESPOL_count($id_emp_default) as $contagem) {

                    //     $contagem = $contagem["contagem"];
                    //   }

                    ?>

                    <?php

                    //   if ($contagem >= 1) {

                    ?>

                    <!-- DIV ROW -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">

                                <?php

                                foreach (select_SEUS_DADOS($id_usu_default) as $seus_dados) {

                                    $nome = $seus_dados["nome"];
                                    $cpf = $seus_dados["cpf"];
                                    $rg = $seus_dados["rg"];
                                    $email = $seus_dados["email"];
                                    $telefone = $seus_dados["telefone"];
                                    $celular = $seus_dados["celular"];
                                    $departamento = $seus_dados["departamento"];

                                    if (!empty($seus_dados["datanascimento"])) {

                                        $datanascimento = new DateTime($seus_dados["datanascimento"]);
                                    } else {

                                        $datanascimento = NULL;
                                    }
                                    if (!empty($seus_dados["dataadmissao"])) {

                                        $dataadmissao = new DateTime($seus_dados["dataadmissao"]);
                                    } else {

                                        $dataadmissao = NULL;
                                    }

                                    $endereco = $seus_dados["endereco"];
                                    $bairro = $seus_dados["bairro"];
                                    $complemento = $seus_dados["complemento"];
                                    $nome_uf = $seus_dados["nome_uf"];
                                    $nome_cidade = $seus_dados["nome_cidade"];
                                    $cep = $seus_dados["cep"];
                                    $pis = $seus_dados["pis"];
                                    $ctps = $seus_dados["ctps"];
                                    $cbo = $seus_dados["cbo"];
                                    $tpsalario = $seus_dados["nome_tpsalario"];
                                    $salario = $seus_dados["salario"];
                                    $dependentes = $seus_dados["dependentes"];
                                    $funcao = $seus_dados["funcao"];
                                    $sexo = $seus_dados["nome_sexo"];
                                    $escolaridade = $seus_dados["nome_escolaridade"];
                                    $imagem_aprovacao = $seus_dados["imagem_aprovacao"];
                                }

                                ?>

                                <div class="col-md-12">

                                    <div class="form-row">


                                        <div class="dropdown no-arrow mb-4 m-auto">

                                            <div class="m-auto" id="div_teste" namespace="<?php echo $id_usu_default; ?>">
                                                <form action="test-image.php" id="croppie" method="post">

                                                    <label class="cabinet center-block">
                                                        <figure style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <?php

                                                            foreach (selectGESUSU_FOTO($id_usu_default) as $foto_banco) {

                                                                $imagem = $foto_banco["imagem"];

                                                                if (!empty($imagem)) {

                                                            ?>
                                                                    <img src="../upload/cadastro/<?php echo $foto_banco["imagem"]; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                                <?php

                                                                } else {

                                                                ?>

                                                                    <img src="../upload/cadastro/avatar_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                            <?php

                                                                }
                                                            }

                                                            ?>

                                                        </figure>
                                                        <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                                <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto de perfil</label>
                                                                <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                                            </a>

                                                        </div>
                                                    </label>

                                                </form>
                                            </div>



                                        </div>

                                    </div>

                                    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="margin: auto !important; width: auto !important;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"> </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="upload-demo" class="center-block"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="cortar" id="cropImageBtn" class="btn btn-primary">Cortar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!empty($imagem_aprovacao)) { ?>

                                        <div class="alert alert-info m-auto opacity-50 text-center" role="alert">
                                            Nova imagem aguardando aprovação!
                                        </div>

                                    <?php } ?>

                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Geral:</h6>
                                    </div>

                                    <!-- INICIO LINHA 1 -->
                                    <div class="col-md-12" style="padding: 1.75em;">

                                        <div class="form-row">
                                            <div class="col-md-6">

                                                <label for="nome" class="mr-2 font-weight-bolder">Nome: </label><span class="font-size-8rem"><?php echo $nome; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="cpf" class="mr-2 font-weight-bolder">CPF: </label><span class="font-size-8rem"><?php echo Mask("###.###.###-##", $cpf); ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="rg" class="mr-2 font-weight-bolder">RG: </label><span class="font-size-8rem"><?php echo $rg; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">

                                                <label for="nome" class="mr-2 font-weight-bolder">E-mail: </label><span class="font-size-8rem"><?php echo $email; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="cpf" class="mr-2 font-weight-bolder">Telefone: </label><span class="font-size-8rem"><?php if (!empty($telefone)) {
                                                                                                                                                    echo Mask("(###) #####-####", $telefone);
                                                                                                                                                } else {
                                                                                                                                                }; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="rg" class="mr-2 font-weight-bolder">Celular: </label><span class="font-size-8rem"><?php if (!empty($celular)) {
                                                                                                                                                    echo Mask("(###) #####-####", $celular);
                                                                                                                                                } else {
                                                                                                                                                }; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">

                                                <label for="nome" class="mr-2 font-weight-bolder">Departamento: </label><span class="font-size-8rem"><?php echo $departamento; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="cpf" class="mr-2 font-weight-bolder">Nascimento: </label><span class="font-size-8rem"><?php if (!empty($datanascimento)) {
                                                                                                                                                        echo $datanascimento->format("d/m/Y");
                                                                                                                                                    } else {
                                                                                                                                                    };  ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">

                                                <label for="rg" class="mr-2 font-weight-bolder">Admissão: </label><span class="font-size-8rem"><?php if (!empty($dataadmissao)) {
                                                                                                                                                    echo $dataadmissao->format("d/m/Y");
                                                                                                                                                } else {
                                                                                                                                                };  ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM LINHA 1 -->

                                    <!-- HEADER LINHA 2 -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Endereço:</h6>
                                    </div>

                                    <!-- INICIO LINHA 2 -->
                                    <div class="col-md-12" style="padding: 1.75em;">

                                        <div class="form-row">
                                            <div class="col-md-6">

                                                <label for="endereco" class="mr-2 font-weight-bolder">Endereço: </label><span class="font-size-8rem"><?php echo $endereco; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">

                                                <label for="bairro" class="mr-2 font-weight-bolder">Bairro: </label><span class="font-size-8rem"><?php echo $bairro; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">

                                                <label for="complemento" class="mr-2 font-weight-bolder">Complemento: </label><span class="font-size-8rem"><?php echo $complemento; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4">

                                                <label for="estado" class="mr-2 font-weight-bolder">Estado: </label><span class="font-size-8rem"><?php echo $nome_uf; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="cidade" class="mr-2 font-weight-bolder">Cidade: </label><span class="font-size-8rem"><?php echo $nome_cidade; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="cep" class="mr-2 font-weight-bolder">CEP: </label><span class="font-size-8rem"><?php if (!empty($cep)) {
                                                                                                                                                echo Mask("#####-###", $cep);
                                                                                                                                            } else {
                                                                                                                                            }; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM LINHA 2 -->

                                    <!-- HEADER LINHA 3 -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Outras Informações:</h6>
                                    </div>

                                    <!-- INICIO LINHA 3 -->
                                    <div class="col-md-12" style="padding: 1.75em;">

                                        <div class="form-row">
                                            <div class="col-md-4">

                                                <label for="pis" class="mr-2 font-weight-bolder">PIS: </label><span class="font-size-8rem"><?php echo $pis; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="ctps" class="mr-2 font-weight-bolder">CTPS: </label><span class="font-size-8rem"><?php echo $ctps; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="cbo" class="mr-2 font-weight-bolder">CBO: </label><span class="font-size-8rem"><?php echo $cbo; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4">

                                                <label for="tiposalario" class="mr-2 font-weight-bolder">Tipo Salário: </label><span class="font-size-8rem"><?php echo $tpsalario; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="salario" class="mr-2 font-weight-bolder">Salário: </label><span class="font-size-8rem"><?php echo $salario; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="dependentes" class="mr-2 font-weight-bolder">Dependentes: </label><span class="font-size-8rem"><?php echo $dependentes; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">

                                                <label for="funcao" class="mr-2 font-weight-bolder">Função: </label><span class="font-size-8rem"><?php echo $funcao; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-2">

                                                <label for="sexo" class="mr-2 font-weight-bolder">Sexo: </label><span class="font-size-8rem"><?php echo $sexo; ?></span>
                                                <hr>
                                            </div>
                                            <div class="col-md-4">

                                                <label for="escolaridade" class="mr-2 font-weight-bolder">Escolaridade: </label><span class="font-size-8rem"><?php echo $escolaridade; ?></span>
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- FIM LINHA 3 -->

                                </div>
                            </div>

                        </div>
                        <!-- FIM DIV ROW -->

                    </div>
                    <!-- FIM DIV CONTAINER FLUID -->

                </div>
                <!-- FIM DIV CONTENT -->

                <!-- FOOTER -->
                <?php

                include_once "footer.php";

                ?>
                <!-- FIM FOOTER -->

                <!-- Scroll to top -->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

            </div>
            <!-- FIM DIV CONTENT WRAPPER -->

        </div>
        <!-- FIM DIV WRAPPER -->

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/ruang-admin.min.js"></script>
        <!-- REQUIRE CROPPIE -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
        <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

        <!-- partial -->
        <script src="croppie/script.js"></script>

        <!-- SWEET ALERT -->
        <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
        <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
        <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

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

<?php

if (isset($_REQUEST['ag'])) {

    echo "<script>
    Swal.fire({
        icon: 'info',
        title: 'Info',
        title: 'Atenção!',
        text: 'Nova imagem aguardando aprovação!'
      }).then((result) => {
        if (result.isConfirmed) {
            location.href = 'seus_dados';
        }else{
            location.href = 'seus_dados';
        }
      })
    </script>";

}

?>