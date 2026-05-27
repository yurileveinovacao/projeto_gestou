<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_emp = $_SESSION["tabela_empresas"]["id_emp_matriz"];

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

    <title>GESTOU PORTAL - Adicionar Filial</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

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
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <?php if (!isset($id_emp)) {

                            echo "<script>
                                Swal.fire({
                                icon: 'info',
                                title: 'Info',
                                title: 'Atenção!',
                                text: 'Não foi possível carregar os dados da empresa!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'tabela_empresas';
                                }
                                });
                                </script>";
                        } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Adicionar Filial</h6>
                        </div>

                        <div class="card-body">

                            <!-- INÍCIO CARD LOGO -->
                            <div class="row m-auto">
                                <div class="dropdown no-arrow mb-4 m-auto d-grid">
                                    <label id="croppie" class="cabinet m-auto center-block">
                                        <!-- <div style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
                                        <!-- Loop para cada imagem recuperada do banco de dados -->
                                        <?php
                                        // Verifica se há imagens disponíveis no banco de dados
                                        $imagens_banco = selectGESEMP_FOTO($id_emp);
                                        if (!empty($imagens_banco)) {
                                            foreach ($imagens_banco as $foto_banco) {
                                                // Usa a imagem do banco de dados ou uma imagem padrão
                                                $imagem = !empty($foto_banco["imagem"]) ? $foto_banco["imagem"] : "avatar_empresa_default.png";
                                            }
                                        } else {
                                            // Se não houver imagens no banco de dados, define uma imagem padrão
                                            $imagem = "avatar_empresa_default.png";
                                        }
                                        ?>
                                        <!-- Exibição da imagem dentro da tag <figure> -->
                                        <img src="../upload/empresa/<?php echo $imagem; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                        <!-- </div> -->

                                        <!-- Menu dropdown para adicionar e remover fotos -->
                                        <!-- <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton"> -->
                                        <!-- <a class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto da empresa</label>
                                                <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                            </a> -->

                                        <?php if (!empty($imagens_banco)) { ?>
                                            <!-- <div class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                    <label for="remover_foto"><i class="far fa-trash-alt mr-1"></i> Remover foto da empresa</label>
                                                </div> -->
                                        <?php } ?>
                                        <!-- </div> -->
                                    </label>
                                    <!-- Informação sobre proporção da imagem -->
                                    <div class="textalign-center mt-sm-2" style="font-size: 75%;">Proporção 2:2 (200 x 200px)</div>
                                </div>
                            </div>

                            <!-- Modal para cortar a imagem -->
                            <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="margin: auto !important; width: auto !important;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"> </h4>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Área de visualização e corte da imagem -->
                                            <div id="upload-demo" class="center-block"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Botão para fechar o modal -->
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            <!-- Botão para confirmar o corte da imagem -->
                                            <button type="button" name="cortar" id="cropImageBtn" class="btn btn-primary">Cortar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM CARD LOGO -->

                            <?php

                            foreach (select_VW_EMPRESAMASTER($id_emp) as $info_banco) {

                                $nome = $info_banco['nome'];
                                $cnpj = $info_banco['cnpj'];
                                $email = $info_banco['email'];
                                $contato = $info_banco['contato'];
                                $endereco = $info_banco['endereco'];
                                $numero = $info_banco['numero'];
                                $bairro = $info_banco['bairro'];
                                $cep = $info_banco['cep'];
                                $complemento = $info_banco['complemento'];
                                $imagem = $info_banco['imagem'];
                                $telefone = $info_banco['telefone'];
                                $estado = $info_banco['estado'];
                                $validacao_gestor_banco = $info_banco['valges'];
                                $tipo = $info_banco['tipo'];
                                $id_emp_h = $info_banco['id_emp_h'];
                                $id_emp_p = $info_banco['id_emp_p'];
                                $id_emp_i = $info_banco['id_emp_i'];
                                $nomefantasia = $info_banco['nomefantasia'];
                                $layout = $info_banco['layout'];
                                $layout_ponto = $info_banco['layout_ponto'];
                                $layout_irrf = $info_banco['layout_irrf'];
                                $id_per_imp = $info_banco['id_per_imp'];
                                $id_per_ace = $info_banco['id_per_ace'];
                                $resp_financeiro =  $info_banco['resp_financeiro'];
                                $email_financeiro = $info_banco['email_financeiro'];
                                $id_emp_grupo = $info_banco['id_emp_grupo'];
                                $tipo_h = $info_banco['tipo_h'];
                                $tipo_p = $info_banco['tipo_p'];
                                $tipo_i = $info_banco['tipo_i'];
                                $id_usa_rh = $info_banco['id_usa_rh'];
                                $id_usa_ouv = $info_banco['id_usa_ouv'];
                                $descricao_layout = $info_banco['descricao_layout'];
                            }

                            ?>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-identificacao-tab" data-toggle="tab" href="#nav-identificacao" role="tab" aria-controls="nav-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="nav-endereco-tab" data-toggle="tab" href="#nav-endereco" role="tab" aria-controls="nav-endereco" aria-selected="false">Endereço</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form id="form_adicionar_filial" class="needs-validation" novalidate>
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV IDENTIFICAÇÃO -->
                                    <div class="tab-pane fade show active" id="nav-identificacao" role="tabpanel" aria-labelledby="nav-identificacao-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" value="<?php echo $nome ?>" minlength="5" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="nomefantasia">Nome Fantasia</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nomefantasia" name="nomefantasia" value="<?php echo $nomefantasia ?>" required>
                                                </div>

                                                <div class="form-group col-md-1">
                                                    <label for="cnpj-raiz">CNPJ</label>
                                                    <input type="text" class="form-control" id="cnpj-raiz" value="<?php echo $raiz = substr($cnpj, 0, 11); ?>" disabled>
                                                </div>

                                                <div class="form-group col-md-1 d-block align-content-end">
                                                    <label for="cnpj-final"></label>
                                                    <input type="text" class="form-control" id="cnpj-final" value="" attrname="cnpjfinal" pattern="[0-9]{4}-[0-9]{2}" minlength="7" required>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="tipo">Tipo</label>
                                                    <select id="tipo" name="tipo" class="form-control" disabled>
                                                        <option value="F" selected>FILIAL</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="contato">Contato</label>
                                                    <input type="text" attrname="contato" id="contato" name="contato" class="form-control" value="<?php echo $contato ?>">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" attrname="<?php if (strlen($telefone) == 11) {
                                                                                        echo 'telefone';
                                                                                    } else {
                                                                                        echo 'celular';
                                                                                    } ?>" name="telefone" id="telefone" class="form-control" value="<?php echo $telefone ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="resp_financeiro">Responsável Financeiro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="resp_financeiro" name="resp_financeiro" value="<?php echo $resp_financeiro ?>" minlength="5">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="email_financeiro">E-mail Financeiro</label>
                                                    <input type="text" class="form-control" title="Separe os endereços de e-mail com ;" id="email_financeiro" name="email_financeiro" value="<?php echo $email_financeiro ?>"></input>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- FIM DIV IDENTIFICAÇÃO -->

                                    <!-- INICIO DIV ENDEREÇO -->
                                    <div class="tab-pane fade" id="nav-endereco" role="tabpanel" aria-labelledby="nav-endereco-tab">

                                        <div class="col-md-12">

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" value="<?php echo $endereco ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="bairro">Bairro</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" value="<?php echo $bairro ?>">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="numero">Número</label>
                                                    <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $numero ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="complemento" name="complemento" value="<?php echo $complemento ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <select id="estado" name="estado" class="form-control" required>
                                                        <?php
                                                        foreach (select_ESTADO($id_emp) as $estado_banco) {
                                                            echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="cidade">Cidade</label>
                                                    <select id="cidade" name="cidade" class="form-control" required>
                                                        <?php
                                                        foreach (select_CIDADE($id_emp, $estado) as $cidade_banco) {
                                                            echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="cep">CEP</label>
                                                    <input type="text" class="form-control" id="cep" attrname="cep" name="cep" value="<?php echo $cep ?>">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- FIM DIV ENDEREÇO -->

                                    <!-- BOTÃO FORM -->
                                    <div class="textalign-right">
                                        <button type="submit" id="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                        <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>


                                </div>
                                <!-- FIM DIV TAB CONTENT -->

                            </form>

                        </div>
                    </div>

                </div>

            </div>

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

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- partial -->
            <script src="./croppie/script_empresa.js"></script>

            <script src="scripts/adicionar_filial.js"></script>

</body>

</html>