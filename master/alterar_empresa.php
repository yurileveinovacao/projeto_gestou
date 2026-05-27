<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

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

    <title>GESTOU PORTAL - Alterar Empresa</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

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

        <!-- Menu Lateral -->
        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Menu Lateral -->
                <?php include_once "barra_superior.php"; ?>

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
                            <h6 class="m-0 font-weight-bold text-primary">Alterar Empresa</h6>
                        </div>

                        <div class="card-body">

                            <!-- INÍCIO CARD LOGO -->
                            <div class="row m-auto">
                                <div class="dropdown no-arrow mb-4 m-auto d-grid">
                                    <label id="croppie" class="cabinet m-auto center-block">
                                        <div style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                        </div>

                                        <!-- Menu dropdown para adicionar e remover fotos -->
                                        <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                            <div class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto da empresa</label>
                                                <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                            </div>

                                            <?php if (!empty($imagens_banco) && !empty($foto_banco["imagem"])) { ?>
                                                <div class="dropdown-item" id="remover_foto" style="padding: 0.7rem 1.5rem !important; cursor: pointer;">
                                                    <i class="far fa-trash-alt mr-1"></i> Remover foto da empresa
                                                </div>
                                            <?php } ?>
                                        </div>
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

                            // FEA-010 — Líder RH: limites e contagem atual
                            $limites_emp = selectGESEMP_limites($id_emp);
                            $limite_lideres_val = $limites_emp['limite_lideres'];
                            $limite_admins_val = $limites_emp['limite_admins_ativos'];
                            $lideres_ativos_emp = selectGESUSA_lideres_ativos($id_emp);
                            $admins_ativos_emp = selectGESUSA_admins_ativos($id_emp);

                            ?>

                            <!-- INICIO NAV -->
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link" id="nav-identificacao-tab" data-toggle="tab" href="#nav-identificacao" role="tab" aria-controls="nav-identificacao" aria-selected="true">Identificação</a>
                                    <a class="nav-item nav-link" id="nav-endereco-tab" data-toggle="tab" href="#nav-endereco" role="tab" aria-controls="nav-endereco" aria-selected="false">Endereço</a>
                                    <a class="nav-item nav-link" id="nav-integracao-tab" data-toggle="tab" href="#nav-integracao" role="tab" aria-controls="nav-integracao" aria-selected="false">Integração</a>
                                    <a class="nav-item nav-link" id="nav-gestor-tab" data-toggle="tab" href="#nav-gestor" role="tab" aria-controls="nav-gestor" aria-selected="false">Gestor</a>
                                    <a class="nav-item nav-link" id="nav-limites-tab" data-toggle="tab" href="#nav-limites" role="tab" aria-controls="nav-limites" aria-selected="false">Limites</a>
                                </div>
                            </nav>
                            <!-- FIM INICIO NAV -->

                            <!-- INICIO DIV TAB CONTENT -->
                            <form id="form_editar_empresa" class="needs-validation" novalidate>
                                <div class="tab-content" id="nav-tabContent">

                                    <!-- INICIO DIV IDENTIFICAÇÃO -->
                                    <div class="tab-pane fade" id="nav-identificacao" role="tabpanel" aria-labelledby="nav-identificacao-tab">

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

                                                <div class="form-group col-md-2">
                                                    <label for="CNPJ">CNPJ</label>
                                                    <input type="text" class="form-control" id="CNPJ" name="CNPJ" value="<?php echo $cnpj ?>" disabled></input>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="CNPJ">Tipo</label>
                                                    <select id="tipo" name="tipo" class="form-control" disabled>
                                                        <?php if ($tipo == "M") { ?>

                                                            <option value="M" selected>MATRIZ</option>
                                                            <option value="F">FILIAL</option>
                                                        <?php } else { ?>

                                                            <option value="F" selected>FILIAL</option>
                                                            <option value="M">MATRIZ</option>
                                                        <?php } ?>
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
                                                    <input type="text" id="contato" attrname="contato" name="contato" class="form-control" value="<?php echo $contato ?>">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" attrname="<?php echo (strlen($telefone) == 11) ? 'telefone' : 'celular'; ?>" name="telefone" id="telefone" class="form-control" value="<?php echo $telefone ?>">
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

                                    <!-- INICIO DIV INTEGRAÇÃO -->
                                    <div class="tab-pane fade" id="nav-integracao" role="tabpanel" aria-labelledby="nav-integracao-tab">

                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_h">Empresa Holerite</label>
                                                    <select id="id_emp_h" name="id_emp_h" class="form-control" required>

                                                        <?php if (empty($id_emp_h)) { ?>
                                                            <option value="" disabled selected>Escolha uma opção</option>
                                                        <?php } ?>

                                                        <?php foreach (selectVWEMPRESA_tipo_beneficio($id_emp) as $tipo_beneficio) { ?>

                                                            <option value="<?php echo $tipo_beneficio["id_emp"]; ?>"><?php echo $tipo_beneficio["nomefantasia"]; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_p">Empresa Ponto</label>
                                                    <select id="id_emp_p" name="id_emp_p" class="form-control" required>

                                                        <?php if (empty($id_emp_p)) { ?>
                                                            <option value="" disabled selected>Escolha uma opção</option>
                                                        <?php } ?>

                                                        <?php foreach (selectVWEMPRESA_tipo_beneficio($id_emp) as $tipo_beneficio) { ?>

                                                            <option value="<?php echo $tipo_beneficio["id_emp"]; ?>"><?php echo $tipo_beneficio["nomefantasia"]; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_i">Empresa Imposto de Renda</label>
                                                    <select id="id_emp_i" name="id_emp_i" class="form-control" required>

                                                        <?php if (empty($id_emp_i)) { ?>
                                                            <option value="" disabled selected>Escolha uma opção</option>
                                                        <?php } ?>

                                                        <?php foreach (selectVWEMPRESA_tipo_beneficio($id_emp) as $tipo_beneficio) { ?>

                                                            <option value="<?php echo $tipo_beneficio["id_emp"]; ?>"><?php echo $tipo_beneficio["nomefantasia"]; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="lay_folha">Layout Holerite</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_folha" name="lay_folha" minlength="3" value="<?php echo $layout ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_ponto">Layout Ponto</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_ponto" name="lay_ponto" minlength="3" value="<?php echo $layout_ponto ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_irrf">Layout IRRF</label>
                                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="lay_irrf" name="lay_irrf" minlength="3" value="<?php echo $layout_irrf ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="descricao_layout">Descrição Layout</label>
                                                    <input type="text" id="descricao_layout" name="descricao_layout" class="form-control" maxlength="255" value="<?php echo $descricao_layout ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_per_imp">ID Perfil Importação</label>
                                                    <select id="id_per_imp" name="id_per_imp" class="form-control">
                                                        <?php

                                                        foreach (selectGESPER($id_per_imp) as $linha) { ?>

                                                            <option value="<?php echo $linha["id_per"]; ?>" selected><?php echo $linha["nome"];  ?></option>
                                                        <?php }

                                                        foreach (selectGESPER_NOT($id_per_imp) as $linha) { ?>

                                                            <option value="<?php echo $linha["id_per"]; ?>"><?php echo $linha["nome"];  ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_per_ace">ID Perfil Aceite</label>
                                                    <select id="id_per_ace" name="id_per_ace" class="form-control">
                                                        <?php
                                                        foreach (selectGESPER($id_per_ace) as $linha) { ?>

                                                            <option value="<?php echo $linha["id_per"]; ?>" selected><?php echo $linha["nome"];  ?></option>
                                                        <?php }
                                                        foreach (selectGESPER_NOT($id_per_ace) as $linha) { ?>

                                                            <option value="<?php echo $linha["id_per"]; ?>"><?php echo $linha["nome"]; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-row">
                                                <div class="form_group col-md-4">
                                                    <label for="id_usa_rh">Resp. RH</label>
                                                    <select id="id_usa_rh" name="id_usa_rh" class="form-control">

                                                        <?php if (empty($id_usa_rh)) { ?>
                                                            <option value="" disabled selected>Escolha uma opção</option>
                                                        <?php } ?>

                                                        <?php foreach (selectRESP_RH($id_emp) as $r_rh) { ?>

                                                            <option value="<?php echo $r_rh["id_usa"]; ?>"><?php echo $r_rh["nome"]; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form_group col-md-4">
                                                    <label for="id_usa_ouv">Resp. Ouvidoria</label>
                                                    <select id="id_usa_ouv" name="id_usa_ouv" class="form-control">

                                                        <?php if (empty($id_usa_ouv)) { ?>
                                                            <option value="" disabled selected>Escolha uma opção</option>
                                                        <?php } ?>

                                                        <?php foreach (selectRESP_OUVIDORIA($id_emp) as $r_ouv) { ?>

                                                            <option value="<?php echo $r_ouv["id_usa"]; ?>"><?php echo $r_ouv["nome"]; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="id_emp_grupo">ID Grupo Empresa</label>
                                                    <input type="text" id="id_emp_grupo" name="id_emp_grupo" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off" value="<?php echo $id_emp_grupo ?>">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="lay_h">Modelo de Importação Holerite</label>
                                                    <select name="lay_h" id="lay_h" class="form-control" required>
                                                        <?php foreach (selectGESLAY($id_emp) as $linha) {
                                                            $lay_h = $linha['lay_h'];

                                                            if (empty($lay_h)) { ?>

                                                                <option value="" disabled selected>Escolha o Tipo de Importação</option>
                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else if ($lay_h == 'VIS') { ?>

                                                                <option value="VIS" selected>VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else { ?>

                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR" selected>PAR</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_p">Modelo de Importação Ponto</label>
                                                    <select name="lay_p" id="lay_p" class="form-control" required>
                                                        <?php foreach (selectGESLAY($id_emp) as $linha) {
                                                            $lay_p = $linha['lay_p'];

                                                            if (empty($lay_p)) { ?>

                                                                <option value="" disabled selected>Escolha o Tipo de Importação</option>
                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else if ($lay_p == 'VIS') { ?>

                                                                <option value="VIS" selected>VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else { ?>

                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR" selected>PAR</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="lay_i">Modelo de Importação IRRF</label>
                                                    <select name="lay_i" id="lay_i" class="form-control" required>
                                                        <?php foreach (selectGESLAY($id_emp) as $linha) {
                                                            $lay_i = $linha['lay_i'];

                                                            if (empty($lay_i)) { ?>

                                                                <option value="" disabled selected>Escolha o Tipo de Importação</option>
                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else if ($lay_i == 'VIS') { ?>

                                                                <option value="VIS" selected>VIS</option>
                                                                <option value="PAR">PAR</option>
                                                            <?php } else { ?>

                                                                <option value="VIS">VIS</option>
                                                                <option value="PAR" selected>PAR</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="tipo_h">Importar Holerite por</label>
                                                    <select name="tipo_h" id="tipo_h" class="form-control" required>
                                                        <?php switch ($tipo_h) {
                                                            case NULL: ?>

                                                                <option value="" disabled selected>Escolha o Tipo</option>
                                                                <option value="C">CPF</option>
                                                                <option value="R">RG</option>
                                                                <option value="I">Cód. Integração</option>
                                                            <?php break;

                                                            case 'C': ?>

                                                                <option value="C" selected>CPF</option>
                                                                <option value="R">RG</option>
                                                                <option value="I">Cód. Integração</option>
                                                            <?php break;

                                                            case 'R': ?>

                                                                <option value="C">CPF</option>
                                                                <option value="R" selected>RG</option>
                                                                <option value="I">Cód. Integração</option>
                                                            <?php break;

                                                            case 'I': ?>

                                                                <option value="C">CPF</option>
                                                                <option value="R">RG</option>
                                                                <option value="I" selected>Cód. Integração</option>
                                                        <?php break;
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="tipo_p">Importar Ponto por</label>
                                                    <select name="tipo_p" id="tipo_p" class="form-control" required>
                                                        <?php switch ($tipo_p) {
                                                            case NULL: ?>

                                                                <option value="" disabled selected>Escolha o Tipo</option>
                                                                <option value="C">CPF</option>
                                                                <option value="P">PIS</option>
                                                            <?php break;

                                                            case 'C': ?>

                                                                <option value="C" selected>CPF</option>
                                                                <option value="P">PIS</option>
                                                            <?php break;

                                                            case 'P': ?>

                                                                <option value="C">CPF</option>
                                                                <option value="P" selected>PIS</option>
                                                        <?php break;
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="tipo_i">Importar IRRF por</label>
                                                    <select name="tipo_i" id="tipo_i" class="form-control" required>
                                                        <?php switch ($tipo_i) {
                                                            case NULL: ?>

                                                                <option value="" disabled selected>Escolha o Tipo</option>
                                                                <option value="C">CPF</option>
                                                            <?php break;

                                                            case 'C': ?>

                                                                <option value="C">CPF</option>
                                                        <?php break;
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="validacao_gestor"></label>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php if ($validacao_gestor_banco == 0) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor">
                                                        <?php }
                                                        if ($validacao_gestor_banco == 1) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor" checked>
                                                        <?php } ?>
                                                        <label class="custom-control-label" for="validacao_gestor" style="user-select: none;">Utiliza validação por gestor?</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- FIM DIV INTEGRAÇÃO -->

                                    <!-- INICIO DIV GESTOR -->
                                    <div class="tab-pane fade" id="nav-gestor" role="tabpanel" aria-labelledby="nav-gestor-tab" style="margin-bottom: 10px;">
                                        <div class="row justify-content-center mb-2">
                                            <div class="col-md-6">Usuários</div>
                                            <div class="col-md-5">Gestores</div>
                                        </div>

                                        <form action="alterar_empresa" method="POST">
                                            <div class="row justify-content-center">
                                                <!-- TAB Empresas Disponiveis -->
                                                <div class="col-md-5" style="height: 300px; overflow: auto; margin-bottom: 16px;">
                                                    <div class="table-responsive">
                                                        <table class="table sortable">
                                                            <thead class="text-center">
                                                                <tr class="list-head">
                                                                    <th style="border-right: 1px solid #e3e6f0; width: 80%">Nome</th>
                                                                    <th style="width: 20%;">CPF</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php foreach (selectGESGES_disponiveis($id_emp) as $linha) {
                                                                    $id_usa_tab = $linha['id_usa'];
                                                                    $nome_tab = $linha['nome'];
                                                                    $cpf_tab = $linha['cpf'];
                                                                    if (!empty($id_usa_tab)) { ?>
                                                                        <tr id="<?php echo $id_usa_tab ?>" class="list-gestor">
                                                                            <td style="border-right: 1px solid #e3e6f0;"><?php echo '<b>' . $nome_tab . '</b>'; ?></td>
                                                                            <td class="text-center"><?php echo $cpf_tab; ?></td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Botões de Inclusão e Exclusão -->
                                                <div class="col-md-1 d-flex flex-column justify-content-center align-items-center">
                                                    <button type="button" id="btn-inc" class="button-emp"><i class="fas fa-chevron-right"></i></button>
                                                    <button type="button" id="btn-exc" class="button-emp"><i class="fas fa-chevron-left"></i></button>
                                                </div>

                                                <!-- TAB Empresas Selecionadas -->
                                                <div class="col-md-5" style="height: 300px; overflow: auto;">
                                                    <div class="table-responsive">
                                                        <table class="table sortable">
                                                            <thead class="text-center">
                                                                <tr class="list-head">
                                                                    <th style="border-right: 1px solid #e3e6f0; width: 80%">Nome</th>
                                                                    <th style="width: 20%;">CPF</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                                <?php foreach (selectGESGES_selecionados($id_emp) as $linha2) {
                                                                    $id_usa_tab = $linha2['id_usa'];
                                                                    $nome_tab = $linha2['nome'];
                                                                    $cpf_tab = $linha2['cpf'];
                                                                    if (!empty($id_usa_tab)) { ?>
                                                                        <tr id="<?php echo 'selec-' . $id_usa_tab ?>" class="list-gestor">
                                                                            <td style="border-right: 1px solid #e3e6f0;"><?php echo '<b>' . $nome_tab . '</b>'; ?></td>
                                                                            <td class="text-center"><?php echo $cpf_tab; ?></td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- FIM DIV GESTOR -->

                                    <!-- INICIO DIV LIMITES (FEA-010) -->
                                    <div class="tab-pane fade" id="nav-limites" role="tabpanel" aria-labelledby="nav-limites-tab">
                                        <div class="col-md-12">
                                            <div class="alert alert-info" role="alert">
                                                <i class="fas fa-info-circle"></i>
                                                Configuração dos limites de usuários por empresa. Estes valores controlam
                                                quantos Líderes RH cada empresa pode ter e (futuramente) o teto total de
                                                admins ativos para fins de precificação por tier.
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="limite_lideres">Limite de Líderes RH ativos</label>
                                                    <input type="number"
                                                           class="form-control"
                                                           id="limite_lideres"
                                                           name="limite_lideres"
                                                           min="1"
                                                           value="<?php echo $limite_lideres_val; ?>"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        Atualmente: <strong><?php echo $lideres_ativos_emp; ?></strong> Líder(es) RH ativo(s) nesta empresa.
                                                        O limite não pode ser menor que o número atual de Líderes ativos.
                                                    </small>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="limite_admins_ativos">Limite de admins ativos (opcional)</label>
                                                    <input type="number"
                                                           class="form-control"
                                                           id="limite_admins_ativos"
                                                           name="limite_admins_ativos"
                                                           min="1"
                                                           value="<?php echo $limite_admins_val !== null ? $limite_admins_val : ''; ?>"
                                                           placeholder="Sem teto">
                                                    <small class="form-text text-muted">
                                                        Atualmente: <strong><?php echo $admins_ativos_emp; ?></strong> admin(s) ativo(s) nesta empresa
                                                        (sem contar admins internos da Leve).
                                                        Deixe em branco para "sem teto" (default).
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FIM DIV LIMITES -->

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
            <?php include_once "footer.php" ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- REQUIRE CROPPIE -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
            <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- JS da página -->
            <script src="scripts/alterar_empresa.js?version=<? echo time(); ?>"></script>

</body>

</html>
</script>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
</script>

<?php

// // Remove imagem logo
// if (isset($_REQUEST["remover_foto"])) {
//     $id_emp_foto = $_REQUEST["remover_foto"];
//     foreach (selectGESEMP_FOTO($id_emp_foto) as $foto_banco) {
//         $imagem = $foto_banco["imagem"];
//     }
//     if (!empty($imagem)) {
//         unlink('../upload/empresa/' . $imagem . '');
//         updateGESEMP_FOTO(NULL, $id_emp_foto, $datatu, $id_mas_default);
//     }

//     echo "<script language=javascript>
//         alert('Foto removida com sucesso!');
//         location.href = 'alterar_empresa';
//         </script>";
// }

// // POST REALIZADO E UNSET DE VARIÁVEIS DE SESSÃO
// if (isset($_POST['btn_voltar'])) {

//     // VÁRIAVEL PARA LISTAR OS DADOS DA EMPRESA NA PÁGINA TABELA EMPRESAS
//     unset($_SESSION['editar_id_emp']);
// }

// // Atribui 1 Usuario como GESTOR
// if (isset($_POST['btn_inc'])) {

//     try {

//         $id_usa = $_POST['btn_inc'];
//         $gestor = 1;
//         $_SESSION['tab'] = 4;

//         if (selectGESGES($id_usa, $editar_id_emp) == 0) {

//             insertGESGES($id_usa, $editar_id_emp, $gestor);
//         } else {

//             updateGESGES($id_usa, $editar_id_emp, $gestor);
//         }
//     } catch (PDOException $erro) {

//         echo $erro->getMessage();
//     }
// }

// // Remove 1 usuario de GESTOR
// if (isset($_POST["btn_exc"])) {

//     try {

//         $id_usa = $_POST["btn_exc"];
//         $gestor = 0;
//         $_SESSION['tab'] = 4;

//         $id_usa = preg_replace('/\D+/', '', $id_usa);

//         updateGESGES($id_usa, $editar_id_emp, $gestor);
//     } catch (PDOException $erro) {

//         echo $erro->getMessage();
//     }
// }


// if (isset($_REQUEST['btn-submit'])) {

//     try {

//         // Define as variáveis
//         $nome = $_POST["nome"]; //REQUIRED
//         $nomefantasia = $_POST["nomefantasia"]; //REQUIRED
//         $tipo = $_POST["tipo"];
//         $email = $_POST["email"];
//         $contato = $_POST["contato"];
//         $telefone = $_POST["telefone"];
//         $resp_financeiro = $_POST['resp_financeiro'];
//         $email_financeiro = $_POST['email_financeiro'];
//         $endereco = $_POST["endereco"];
//         $bairro = $_POST["bairro"];
//         $numero = $_POST["numero"];
//         $complemento = $_POST["complemento"];
//         $cidade = $_POST["cidade"]; //REQUIRED
//         $cep = $_POST["cep"];
//         $id_emp_h = $_POST["id_emp_h"]; //REQUIRED
//         $id_emp_p = $_POST["id_emp_p"]; //REQUIRED
//         $id_emp_i = $_POST["id_emp_i"]; //REQUIRED
//         $layout_folha = $_POST["lay_folha"];
//         $layout_ponto = $_POST["lay_ponto"];
//         $layout_irrf = $_POST["lay_irrf"];
//         $descricao_layout = $_POST["descricao_layout"];
//         $id_per_imp = $_POST['id_per_imp'];
//         $id_per_ace = $_POST['id_per_ace'];
//         $id_usa_rh = $_POST["id_usa_rh"];
//         $id_usa_ouv = $_POST["id_usa_ouv"];
//         $id_emp_grupo = $_POST["id_emp_grupo"];
//         $lay_h = $_POST["lay_h"]; //REQUIRED
//         $lay_p = $_POST["lay_p"]; //REQUIRED
//         $lay_i = $_POST["lay_i"]; //REQUIRED
//         $tipo_h = $_POST["tipo_h"]; //REQUIRED
//         $tipo_p = $_POST["tipo_p"]; //REQUIRED
//         $tipo_i = $_POST["tipo_i"]; //REQUIRED
//         $validacao_gestor = $_POST["validacao_gestor"];

//         $id_emp = $_SESSION['editar_id_emp'];
//         $id_usa = $_SESSION['id_mas'];


//         // Formata as variáveis
//         if ($email == '') {

//             $email = NULL;
//         }

//         if ($contato == '') {

//             $contato = NULL;
//         }

//         if ($telefone == '') {

//             $telefone_update = NULL;
//         } else {

//             $telefone_update = preg_replace('/\D+/', '', $telefone);
//         }

//         if ($endereco == '') {

//             $endereco = NULL;
//         }

//         if ($bairro == '') {

//             $bairro = NULL;
//         }

//         if ($numero == '') {

//             $numero = NULL;
//         }

//         if ($complemento == '') {

//             $complemento = NULL;
//         }

//         if ($cep == '') {

//             $cep_update = NULL;
//         } else {

//             $cep_update = preg_replace('/\D+/', '', $cep);
//         }

//         if ($layout_folha == '') {

//             $layout_folha = NULL;
//         }

//         if ($layout_ponto == '') {

//             $layout_ponto = NULL;
//         }

//         if ($layout_irrf == '') {

//             $layout_irrf = NULL;
//         }

//         if ($descricao_layout == '') {

//             $descricao_layout = NULL;
//         }

//         if ($id_usa_rh == '') {

//             $id_usa_rh = NULL;
//         }

//         if ($id_usa_ouv == '') {

//             $id_usa_ouv = NULL;
//         }

//         if ($id_emp_grupo == '') {

//             $id_emp_grupo = NULL;
//         }

//         if ($resp_financeiro == '') {

//             $resp_financeiro = NULL;
//         }

//         if ($email_financeiro == '') {

//             $email_financeiro = NULL;
//         }

//         if ($validacao_gestor == '') {

//             $validacao_gestor = 0;
//         }

//         $nome = mb_strtoupper($nome, 'UTF-8');
//         $nomefantasia = mb_strtoupper($nomefantasia, 'UTF-8');
//         $endereco = mb_strtoupper($endereco, 'UTF-8');
//         $bairro = mb_strtoupper($bairro, 'UTF-8');
//         $numero = mb_strtoupper($numero, 'UTF-8');
//         $complemento = mb_strtoupper($complemento, 'UTF-8');
//         $contato = mb_strtoupper($contato, 'UTF-8');
//         $layout_folha = mb_strtoupper($layout_folha, 'UTF-8');
//         $layout_ponto = mb_strtoupper($layout_ponto, 'UTF-8');
//         $layout_irrf = mb_strtoupper($layout_irrf, 'UTF-8');
//         $resp_financeiro = mb_strtoupper($resp_financeiro, 'UTF-8');

//         /*
//         // Exibe as variáveis
//         echo 'Nome: ' . $nome . '<br>';
//         echo 'Nome Fantasia: ' . $nomefantasia . '<br>';
//         echo 'Tipo: ' . $tipo . '<br>';
//         echo 'E-mail: ' . $email . '<br>';
//         echo 'Contato: ' . $contato . '<br>';
//         echo 'Telefone: ' . $telefone_update . '<br>';
//         echo 'Resp financeiro: ' . $resp_financeiro . '<br>';
//         echo 'E-mail financeiro: ' . $email_financeiro . '<br>';
//         echo 'Endereço: ' . $endereco . '<br>';
//         echo 'Bairro: ' . $bairro . '<br>';
//         echo 'Numero: ' . $numero . '<br>';
//         echo 'Complemento: ' . $complemento . '<br>';
//         echo 'Cidade: ' . $cidade . '<br>';
//         echo 'Cep: ' . $cep_update . '<br>';
//         echo 'Id_emp_h: ' . $id_emp_h . '<br>';
//         echo 'Id_emp_p: ' . $id_emp_p . '<br>';
//         echo 'Id_emp_i: ' . $id_emp_i . '<br>';
//         echo 'Folha: ' . $layout_folha . '<br>';
//         echo 'Ponto: ' . $layout_ponto . '<br>';
//         echo 'IRRF: ' . $layout_irrf . '<br>';
//         echo 'Descrição Layout: ' . $descricao_layout . '<br>';
//         echo 'Id_per_imp: ' . $id_per_imp . '<br>';
//         echo 'Id_per_ace: ' . $id_per_ace . '<br>';
//         echo 'Id_usa_rh: ' . $id_usa_rh . '<br>';
//         echo 'Id_usa_ouv: ' . $id_usa_ouv . '<br>';
//         echo 'Id_emp_grupo: ' . $id_emp_grupo . '<br>';
//         echo 'Lay_h: ' . $lay_h . '<br>';
//         echo 'Lay_p: ' . $lay_p . '<br>';
//         echo 'Lay_i: ' . $lay_i . '<br>';
//         echo 'Tipo_h: ' . $tipo_h . '<br>';
//         echo 'Tipo_p: ' . $tipo_p . '<br>';
//         echo 'Tipo_i: ' . $tipo_i . '<br>';
//         echo 'Validador Gestor: ' . $validacao_gestor . '<br>';
//         echo 'Datatu: ' . $datatu . '<br>';
//         echo 'Id_emp: ' . $id_emp . '<br>';
//         echo 'Id_usa: ' . $id_usa . '<br>';
//         echo 'Imagem: ' . $id_usa . '<br>';
//         */

//         // Executa os update
//         updateGESEMP_CAMPOS(
//             $nome,
//             $nomefantasia,
//             $tipo,
//             $email,
//             $contato,
//             $telefone_update,
//             $resp_financeiro,
//             $email_financeiro,
//             $endereco,
//             $bairro,
//             $numero,
//             $complemento,
//             $cidade,
//             $cep_update,
//             $id_emp_h,
//             $id_emp_p,
//             $id_emp_i,
//             $layout_folha,
//             $layout_ponto,
//             $layout_irrf,
//             $descricao_layout,
//             $id_per_imp,
//             $id_per_ace,
//             $id_usa_rh,
//             $id_usa_ouv,
//             $id_emp_grupo,
//             $tipo_h,
//             $tipo_p,
//             $tipo_i,
//             $validacao_gestor,
//             $datatu,
//             $id_emp,
//             $id_usa
//         );

//         updateGESLAY($id_emp, $lay_h, $lay_p, $lay_i);

//         echo "<script language=javascript>
//                  alert('Informação Atualizada com Sucesso!');
//                  location.href = 'alterar_empresa';         
//              </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();

//         echo "<script language=javascript>
//         alert('Erro!');
//     </script>";
//     }
// }
?>