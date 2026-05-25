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

    <title>GESTOU PORTAL - Dados Cadastrais</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Ordena as colunas da Table -->
    <script src="js/sorttable.js"></script>

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <link rel='stylesheet prefetch' href='https://foliotek.github.io/Croppie/croppie.css'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                </div>

                <!-- INICIO CARD SHADOW -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Dados da empresa</h6>
                    </div>
                    <div class="card-body">

                        <div class="row m-auto">
                            <div class="dropdown no-arrow mb-4 m-auto">
                                <div class="m-auto">
                                    <form id="croppie">

                                        <label class="cabinet center-block">
                                            <figure style="user-select: none;" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php

                                                foreach (selectGESEMP_FOTO($id_emp_default) as $foto_banco) {

                                                    $imagem = $foto_banco["imagem"];

                                                    if (!empty($imagem)) {

                                                ?>
                                                        <img src="../upload/empresa/<?php echo $foto_banco["imagem"]; ?>" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <img src="../upload/empresa/avatar_empresa_default.png" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                                                <?php

                                                    }
                                                }

                                                ?>

                                            </figure>
                                            <div class="dropdown-menu" style="padding: 0rem 0 !important;" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" style="padding: 0.7rem 1.5rem !important;">
                                                    <label for="adicionar_foto"><i class="fas fa-plus-circle mr-1"></i> Adicionar foto da empresa</label>
                                                    <input type="file" accept="image/*" id="adicionar_foto" style="width: 150px; display: none;" class="item-img file center-block" name="file_photo" />
                                                </a>

                                                <?php if (!empty($imagem)) { ?>
                                                    <div class="dropdown-item" id="remover-foto" id_foto="<?php echo $id_emp_default; ?>" style="padding: 0.7rem 1.5rem !important;">
                                                        <label for="remover_foto"><i class="far fa-trash-alt mr-1"></i> Remover foto da empresa</label>
                                                    </div>

                                                <?php } else { ?>

                                                <?php } ?>

                                            </div>
                                        </label>
                                    </form>
                                    <sup class="textalign-center mt-sm-4">Proporção 2:2 (200 x 200px)</sup>
                                </div>

                            </div>

                        </div>
                        <!-- </div>
                            </div> -->


                        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="margin: auto !important; width: auto !important;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"></h4>
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

                        <?php

                        foreach (selectVW_EMPRESA_dados($id_emp_default) as $info_banco) {

                            $nome = $info_banco['nome'];
                            $cnpj = $info_banco['cnpj'];
                            $email = $info_banco['email'];
                            $endereco = $info_banco['endereco'];
                            $numero = $info_banco['numero'];
                            $bairro = $info_banco['bairro'];
                            $cep = $info_banco['cep'];
                            $complemento = $info_banco['complemento'];
                            $imagem = $info_banco['imagem'];
                            $telefone = $info_banco['telefone'];
                            $contato = $info_banco['contato'];
                            $estado = $info_banco['estado'];
                            $validacao_gestor_banco = $info_banco['valges'];
                            $tipo = $info_banco['tipo'];
                            $id_emp_h = $info_banco['id_emp_h'];
                            $id_emp_p = $info_banco['id_emp_p'];
                            $id_emp_i = $info_banco['id_emp_i'];
                            $nomefantasia = $info_banco['nomefantasia'];
                            $resp_financeiro = $info_banco['resp_financeiro'];
                            $email_financeiro = $info_banco['email_financeiro'];
                            $resp_rh = $info_banco['id_usa_rh'];
                            $resp_ouvidoria = $info_banco['id_usa_ouv'];
                        }

                        // FEA-002/003: dias de experiência personalizados por empresa
                        $dias_exp = selectGESEMP_dias_experiencia($id_emp_default);
                        $dias_exp_1 = $dias_exp['dias_exp_1'];
                        $dias_exp_2 = $dias_exp['dias_exp_2'];

                        ?>

                        <!-- INICIO NAV -->
                        <nav>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link" id="nav-identificacao-tab" data-toggle="tab" href="#nav-identificacao" role="tab" aria-controls="nav-identificacao" aria-selected="true">Identificação</a>
                                <a class="nav-item nav-link" id="nav-endereco-tab" data-toggle="tab" href="#nav-endereco" role="tab" aria-controls="nav-endereco" aria-selected="false">Endereço</a>
                                <a class="nav-item nav-link" id="nav-gestor-tab" data-toggle="tab" href="#nav-gestor" role="tab" aria-controls="nav-outras" aria-selected="false">Gestor</a>
                                <a class="nav-item nav-link" id="nav-rpa-tab" data-toggle="tab" href="#nav-rpa" role="tab" aria-controls="nav-rpa" aria-selected="false">RPA</a>
                            </div>
                        </nav>
                        <!-- FIM INICIO NAV -->

                        <!-- INICIO DIV TAB CONTENT -->
                        <form id="form" class="needs-validation" novalidate>
                            <div class="tab-content" id="nav-tabContent">

                                <!-- INICIO DIV IDENTIFICAÇÃO -->
                                <div class="tab-pane fade" id="nav-identificacao" role="tabpanel" aria-labelledby="nav-identificacao-tab">

                                    <div class="col-md-12">

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="nome">Nome</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" value="<?php echo $nome ?>" required minlength="5">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="nomefantasia">Nome Fantasia</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="nomefantasia" name="nomefantasia" value="<?php echo $nomefantasia ?>" required minlength="5">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="CNPJ">CNPJ</label>
                                                <input type="text" class="form-control" id="CNPJ" name="CNPJ" value="<?php echo $cnpj ?>" readonly disabled></input>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="tipo">Tipo Empresa</label>
                                                <select id="tipo" name="tipo" class="form-control" readonly disabled>
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
                                                <input name="email" class="form-control" type="email" value="<?php echo $email ?>">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="telefone">Contato</label>
                                                <input attrname="contato" name="contato" class="form-control" type="text" value="<?php echo $contato ?>">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="telefone">Telefone</label>
                                                <input attrname="<?php if (strlen($telefone) == 11) {
                                                                        echo 'telefone';
                                                                    } else {
                                                                        echo 'celular';
                                                                    } ?>" name="telefone" id="telefone" class="form-control" type="text" value="<?php echo $telefone ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="resp_financeiro">Resp. Financeiro:</label>
                                                <input type="text" class="form-control" style="text-transform: uppercase;" id="resp_financeiro" name="resp_financeiro" value="<?php echo $resp_financeiro; ?>" minlength="3">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email_financeiro">E-mail Financeiro:</label>
                                                <input type="email" class="form-control" id="email_financeiro" name="email_financeiro" value="<?php echo $email_financeiro; ?>"></input>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="resp_rh">Resp. RH</label>
                                                <select id="resp_rh" name="resp_rh" class="form-control" required>

                                                    <?php if (empty($resp_rh)) { ?>
                                                        <option value="" disabled selected>Escolha uma opção</option>
                                                    <?php } ?>

                                                    <?php foreach (selectRESP_RH($id_emp_default) as $r_rh) { ?>

                                                        <option value="<?php echo $r_rh["id_usa"]; ?>"><?php echo $r_rh["nome"]; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="resp_ouvidoria">Resp. Ouvidoria</label>
                                                <select id="resp_ouvidoria" name="resp_ouvidoria" class="form-control" required>

                                                    <?php if (empty($resp_ouvidoria)) { ?>
                                                        <option value="1" disabled selected>Escolha uma opção</option>
                                                    <?php } ?>

                                                    <?php foreach (selectRESP_OUVIDORIA($id_emp_default) as $r_ouvidoria) { ?>

                                                        <option value="<?php echo $r_ouvidoria["id_usa"]; ?>"><?php echo $r_ouvidoria["nome"]; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="validacao_gestor"></label>
                                                    <div class="custom-control custom-checkbox" id="valida_gestor">
                                                        <?php if ($validacao_gestor_banco == 0) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor" data-value="0">
                                                        <?php }
                                                        if ($validacao_gestor_banco == 1) { ?>
                                                            <input type="checkbox" class="custom-control-input" value="1" name="validacao_gestor" id="validacao_gestor" data-value="1" checked>
                                                        <?php } ?>
                                                        <label class="custom-control-label" for="validacao_gestor" style="user-select: none;">Utiliza validação por gestor?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FEA-002/003: período de experiência personalizado -->
                                        <hr style="margin-top: 20px; margin-bottom: 16px;">
                                        <h6 class="text-gray-700 mb-2"><i class="fas fa-hourglass-half mr-1"></i> Período de Experiência (CLT)</h6>
                                        <p class="text-muted small mb-3" style="line-height: 1.5;">
                                            Configure como sua empresa divide o contrato de experiência. O padrão é dividir em duas fases (ex: <strong>45 + 45 = 90 dias totais</strong>).
                                            Empresas que <strong>não usam prorrogação</strong> podem aplicar tudo numa única fase — basta colocar o mesmo número nos dois campos (ex: <strong>90 + 90</strong> → fase única de 90 dias). O total não pode passar de <strong>90 dias</strong> (limite legal CLT).
                                        </p>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="dias_exp_1">Final da 1ª fase (dias)</label>
                                                <input type="number" class="form-control" id="dias_exp_1" name="dias_exp_1_update" value="<?php echo $dias_exp_1; ?>" min="1" max="90" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="dias_exp_2">Final da prorrogação (total, dias)</label>
                                                <input type="number" class="form-control" id="dias_exp_2" name="dias_exp_2_update" value="<?php echo $dias_exp_2; ?>" min="1" max="90" required>
                                            </div>
                                            <div class="form-group col-md-6 align-self-end">
                                                <small class="text-muted">A 2ª fase deve ser maior ou igual à 1ª. Quando iguais, o sistema entende como fase única.</small>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- BOTÃO FORM -->
                                    <div class="textalign-right">
                                        <button type="submit" id="btn-submit" class="btn btn-organograma btn-icon-split-organograma"> <i class="fas fa-save mr-sm-2"> </i> Salvar</button>
                                        <button type="button" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>

                                </div>
                                <!-- FIM DIV IDENTIFICAÇÃO -->

                                <!-- INICIO DIV ENDEREÇO -->
                                <div class="tab-pane fade" id="nav-endereco" role="tabpanel" aria-labelledby="nav-endereco-tab">

                                    <div class="col-md-12">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="endereco">Endereco</label>
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

                                                    foreach (select_ESTADO($id_emp_default) as $estado_banco) {

                                                        echo '<option value="' . $estado_banco['estado'] . '">' . $estado_banco['estado'] . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cidade">Cidade</label>
                                                <select id="cidade" name="cidade" class="form-control" required>

                                                    <?php

                                                    foreach (select_CIDADE($id_emp_default, $estado) as $cidade_banco) {

                                                        echo '<option value="' . $cidade_banco['id_mun'] . '" namespace="' . $cidade_banco['cep'] . '">' . $cidade_banco['cidade'] . '</option>';
                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="CEP">CEP</label>
                                                <input type="text" class="form-control" id="CEP" attrname="cep" name="cep" value="<?php echo $cep ?>" required>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- BOTÃO FORM -->
                                    <div class="textalign-right">
                                        <button type="submit" id="btn-submit" class="btn btn-organograma btn-icon-split-organograma"> <i class="fas fa-save mr-sm-2"> </i> Salvar</button>
                                        <button type="button" name="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                    </div>
                                </div>
                                <!-- FIM DIV ENDEREÇO -->

                                <!-- INICIO DIV GESTOR -->
                                <div class="tab-pane fade" id="nav-gestor" role="tabpanel" aria-labelledby="nav-gestor-tab" style="margin-bottom: 10px;">

                                    <div class="row" style="justify-content: center; margin-bottom: 8px;">
                                        <div class="col-md-6">Usuários</div>
                                        <div class="col-md-5">Gestores</div>
                                    </div>

                                    <form action="dados_cadastrais" method="POST">
                                        <div class="row" style="justify-content: center;">

                                            <!-- TAB Empresas Disponiveis -->
                                            <div class="col-md-5" style="height: 300px; overflow: auto; scrollbar-width: thin; margin-bottom: 16px;">
                                                <div style="min-height: 100%; max-height: auto; border: 1px solid #e3e6f0; border-top: none;">
                                                    <table class="table sortable" width="100%" cellspacing="0" style="margin-bottom: 0;">
                                                        <thead style="text-align: center;">
                                                            <tr class="list-head">
                                                                <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 80%">Nome</th>
                                                                <th data-orderable="false" style="width: 20%;">CPF</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                            <?php foreach (selectGESGES_disponiveis($id_emp_default) as $linha) {

                                                                $id_usa_tab = $linha['id_usa'];
                                                                $nome_tab = $linha['nome'];
                                                                $cpf_tab = $linha['cpf'];

                                                                if (!empty($id_usa_tab)) { ?>

                                                                    <tr id="<?php echo $id_usa_tab ?>" class="list-gestor" style="border-bottom: 1px solid #e3e6f0;">
                                                                        <th style="border-right: 1px solid #e3e6f0;"><?php echo '<b>' . $nome_tab . '</b>'; ?></th>
                                                                        <th style="text-align: center"><?php echo $cpf_tab; ?></th>

                                                                    </tr>

                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Botões de Inclusão e Exclusão -->
                                            <div class="col-md-1" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <button type="button" id="btn-inc" class="button-emp"><i class="fas fa-chevron-right"></i></button>
                                                <button type="button" id="btn-exc" class="button-emp"><i class="fas fa-chevron-left"></i></button>
                                            </div>

                                            <!-- TAB Empresas Selecionadas -->
                                            <div class="col-md-5" style="height: 300px; overflow: auto; scrollbar-width: thin;">
                                                <div style="min-height: 100%; max-height: auto; border: 1px solid #e3e6f0; border-top: none;">
                                                    <table class="table sortable" width="100%" cellspacing="0" style="margin-bottom: 0;">
                                                        <thead style="text-align: center;">
                                                            <tr class="list-head">
                                                                <th data-orderable="false" style="border-right: 1px solid #e3e6f0; width: 80%">Nome</th>
                                                                <th data-orderable="false" style="width: 20%;">CPF</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody class="texto-table-body" style="font-size: 0.8rem;">
                                                            <?php foreach (selectGESGES_selecionados($id_emp_default) as $linha2) {

                                                                $id_usa_tab = $linha2['id_usa'];
                                                                $nome_tab = $linha2['nome'];
                                                                $cpf_tab = $linha2['cpf'];

                                                                if (!empty($id_usa_tab)) { ?>

                                                                    <tr id="<?php echo 'selec-' . $id_usa_tab ?>" class="list-gestor" style="border-bottom: 1px solid #e3e6f0;">
                                                                        <th style="border-right: 1px solid #e3e6f0;"><?php echo '<b>' . $nome_tab . '</b>'; ?></th>
                                                                        <th style="text-align: center"><?php echo $cpf_tab; ?></th>
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
                                <!-- INICIO FIM EMPRESAS -->

                                <!-- FEA-009 Fase 6 — Aba RPA: config por empresa (valores padrão + limites + templates HTML) -->
                                <div class="tab-pane fade" id="nav-rpa" role="tabpanel" aria-labelledby="nav-rpa-tab" style="margin-bottom: 10px;">
                                    <?php $rpa_cfg = selectGESRPACFG($id_emp_default); ?>
                                    <form id="form-rpa-cfg" autocomplete="off">
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-3">
                                                <label for="rpa_valor_padrao">Valor líquido padrão (R$)</label>
                                                <input type="number" step="0.01" min="0.01" class="form-control" id="rpa_valor_padrao" name="valor_liquido_padrao" value="<?php echo htmlspecialchars(number_format($rpa_cfg['valor_liquido_padrao'] ?? 150, 2, '.', '')); ?>">
                                                <small class="form-text text-muted">Sugestão inicial no form de novo RPA.</small>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="rpa_perc_imposto">INSS (%)</label>
                                                <input type="number" step="0.01" class="form-control" id="rpa_perc_imposto" name="perc_imposto_padrao" value="<?php echo htmlspecialchars(number_format($rpa_cfg['perc_imposto_padrao'] ?? 12.36, 2, '.', '')); ?>" readonly>
                                                <small class="form-text text-muted">Fixo no MVP (12,36%).</small>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="rpa_alerta">Alerta de risco CLT (diárias)</label>
                                                <input type="number" min="1" class="form-control" id="rpa_alerta" name="limite_dias_alerta" value="<?php echo (int) ($rpa_cfg['limite_dias_alerta'] ?? 3); ?>">
                                                <small class="form-text text-muted">Aviso amarelo no form de novo RPA.</small>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="rpa_bloqueio">Bloqueio CLT (diárias)</label>
                                                <input type="number" min="1" class="form-control" id="rpa_bloqueio" name="limite_dias_bloqueio" value="<?php echo (int) ($rpa_cfg['limite_dias_bloqueio'] ?? 4); ?>">
                                                <small class="form-text text-muted">Bloqueia novo RPA.</small>
                                            </div>
                                        </div>

                                        <hr>
                                        <h6 class="text-primary">Templates HTML (deixe em branco para usar o padrão embutido do sistema)</h6>
                                        <p class="small text-muted">Placeholders disponíveis: <code>{nome_autonomo}</code>, <code>{cpf}</code>, <code>{rg}</code>, <code>{email}</code>, <code>{pix}</code>, <code>{endereco}</code>, <code>{bairro}</code>, <code>{cidade}</code>, <code>{uf}</code>, <code>{cep}</code>, <code>{empresa_nome}</code>, <code>{empresa_cnpj}</code>, <code>{cargo}</code>, <code>{setor}</code>, <code>{data_servico}</code>, <code>{hora_ini}</code>, <code>{hora_fim}</code>, <code>{diarias}</code>, <code>{valor_bruto}</code>, <code>{valor_inss}</code>, <code>{valor_liquido}</code>, <code>{perc_imposto}</code>, <code>{justificativa}</code>, <code>{id_rpa}</code>, <code>{data_hoje}</code></p>

                                        <div class="form-group mt-3">
                                            <label for="rpa_tpl_autorizacao">Autorização</label>
                                            <textarea class="form-control" id="rpa_tpl_autorizacao" name="texto_autorizacao_html" rows="6"><?php echo htmlspecialchars($rpa_cfg['texto_autorizacao_html'] ?? ''); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="rpa_tpl_contrato">Contrato (Art. 442-B CLT)</label>
                                            <textarea class="form-control" id="rpa_tpl_contrato" name="texto_contrato_html" rows="8"><?php echo htmlspecialchars($rpa_cfg['texto_contrato_html'] ?? ''); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="rpa_tpl_recibo">Recibo</label>
                                            <textarea class="form-control" id="rpa_tpl_recibo" name="texto_recibo_html" rows="6"><?php echo htmlspecialchars($rpa_cfg['texto_recibo_html'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="textalign-right mt-3">
                                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar configurações RPA</button>
                                        </div>
                                    </form>

                                    <script>
                                    $('#form-rpa-cfg').on('submit', function (e) {
                                        e.preventDefault();
                                        $.post('controller/dados_cadastrais_rpa_post.php', $(this).serialize(), function (r) {
                                            try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch (e) {}
                                            if (r && r.status === 'sucesso') {
                                                if (typeof Swal !== 'undefined') {
                                                    Swal.fire({ icon: 'success', title: 'Configurações salvas.', timer: 1500, showConfirmButton: false });
                                                } else { alert('Configurações salvas.'); }
                                            } else {
                                                alert((r && r.mensagem) || 'Falha ao salvar.');
                                            }
                                        });
                                    });
                                    </script>
                                </div>
                                <!-- FIM ABA RPA -->

                            </div>
                            <!-- FIM DIV TAB CONTENT -->
                        </form>

                    </div>
                </div>
                <!-- FIM CARD SHADOW -->

            </div>
            <!-- FIM CONTENT FLUID -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- FOOTER -->
        <?php include_once "footer.php" ?>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- REQUISITOS MÁSCARAS JS -->
    <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

    <!-- REQUIRE CROPPIE -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <!-- partial -->
    <script src="./croppie/script_empresa.js"></script>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $("#CNPJ").mask("99.999.999/9999-99");
    });
</script>

<script>
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // Recebe o attrname do input telefone (telefone / celular)
    var telefoneName = $('input#telefone').attr('attrname');
    // Verifica se o attrname é telefone ou celular e define a mascara correta
    if (telefoneName == 'telefone') {

        var telMask = ['(999) 9999-99999', '(999) 99999-9999'];
        var tel = document.querySelector('input[attrname=telefone]');
        VMasker(tel).maskPattern(telMask[0]);
        tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false);
    } else {

        var celMask = ['(999) 9999-9999', '(999) 99999-9999'];
        var cel = document.querySelector('input[attrname=celular]');
        VMasker(cel).maskPattern(celMask[1]);
        cel.addEventListener('input', inputHandler.bind(undefined, celMask, 15), false);
    }

    var cepMask = ['99999-9999', '99999-999'];
    var cep = document.querySelector('input[attrname=cep]');
    VMasker(cep).maskPattern(cepMask[0]);
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false);
</script>

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<script type="text/javascript">
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade.php?search=', {
                    estado: $(this).val(),
                    ajax: 'true'
                }, function(j) {
                    var options =
                        '<option value="" selected disabled>Escolha a Cidade</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id_mun + '" namespace="' + j[i]
                            .cep_mun + '">' + j[i].nome_mun + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
            }
        });
    });
</script>

<!-- FIM ANIMAÇÃO RÁPIDA -->

<script>
    document.getElementById("estado").onchange = function() {

        // var select = document.getElementById("estado");

        // var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = '';

    }

    document.getElementById("cidade").onchange = function() {

        var select = document.getElementById("cidade");

        var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = cep;

    }
</script>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // Seleciona todos os elementos com a classe "list-gestor" quando clicados
    $('.list-gestor').click(function() {

        // Obtém o atributo "id" do elemento clicado
        var link = $(this).attr("id");

        // Limpa a cor de fundo de todos os elementos com a classe "list-gestor"
        $('.list-gestor').css({
            backgroundColor: "white"
        });

        // Define a cor de fundo do elemento clicado
        $('#' + link).css({
            backgroundColor: "#eaecf4"

        });

        // Define o valor do botão com a classe "button-emp" como o valor do link
        $('.button-emp').val(link);
    });

    // FAZ UMA REQUISIÇÃO ASSÍNCRONA PARA VERIFICAR SE A VARIÁVEL DE SESSÃO $_SESSION['tab'] ESTÁ DEFINIDA
    $.getJSON('verificar_sessao.php', function(retorna) {

        if (retorna == 1) {

            // Se a variável de sessão estiver definida (retorna == 1), adiciona as classes 'active' e 'show' aos elementos HTML com os IDs 'nav-gestor-tab' e 'nav-gestor'.
            $('#nav-gestor-tab').addClass('active');
            $('#nav-gestor').addClass('show active');
        } else {

            // Se a variável de sessão não estiver definida (retorna != 1), adiciona as classes 'active' e 'show' aos elementos HTML com os IDs 'nav-identificacao-tab' e 'nav-identificacao'.
            $('#nav-identificacao-tab').addClass('active');
            $('#nav-identificacao').addClass('show active');
        }
    })

    // REDIRECIONA O USUÁRIO PARA A PÁGINA "INDEX" QUANDO O BOTÃO "VOLTAR" É CLICADO.
    $(function() {
        $(document).on('click', '[name=btn-voltar]', function() {

            location.href = 'index';
        });
    });

    // QUANDO O FORMULÁRIO É SUBMETIDO
    $(function() {
        $("#form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja alterar os dados?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, alterar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Valor que define que o formulário foi submetido
                    var btn_submit = 1;

                    // Obtém os valores do formulário
                    var dados_form = {
                        // Menu Indentificação
                        nome_update: $('[name=nome]').val(),
                        nomefantasia_update: $('[name=nomefantasia]').val(),
                        email_update: $('[name=email]').val(),
                        contato_update: $('[name=contato]').val(),
                        telefone_update: $('[name=telefone]').val(),
                        resp_financeiro_update: $('[name=resp_financeiro]').val(),
                        email_financeiro_update: $('[name=email_financeiro]').val(),
                        resp_rh_update: $('[name=resp_rh]').val(),
                        resp_ouvidoria_update: $('[name=resp_ouvidoria]').val(),
                        validacao_gestor_update: $('[name=validacao_gestor]').is(':checked'),

                        // Menu Endereço
                        endereco_update: $('[name=endereco]').val(),
                        bairro_update: $('[name=bairro]').val(),
                        numero_update: $('[name=numero]').val(),
                        complemento_update: $('[name=complemento]').val(),
                        cidade_update: $('[name=cidade]').val(),
                        cep_update: $('[name=cep]').val(),

                        // FEA-002/003: período de experiência personalizado
                        dias_exp_1_update: $('[name=dias_exp_1_update]').val(),
                        dias_exp_2_update: $('[name=dias_exp_2_update]').val(),

                        // Valor que valida o envio do formulário
                        btn_submit: btn_submit
                    }

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/dados_cadastrais_post.php', dados_form, function(retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        if (retorno == 1) {

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Dados cadastrados com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'dados_cadastrais';
                                }
                            })

                            // Se o retorno for igual a 0, alguma campo não cumpriu os requisitos para a inserção dos dados
                        } else if (retorno == 0) {

                            // Exibe uma mensagem de erro usando o plugin SweetAlert2
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção!',
                                text: 'Preencha os campos requeridos em todas as abas!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            })

                            // Caso não for nem 0 nem 1 houve erro no try e retorna um SweetAlert2 com o erro exibido pelo catch
                        } else {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Erro',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            })
                        }

                    }).fail(function() {

                        // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
                        alert('Fail');

                    });

                }
            });

        });
    });

    // POST QUANDO CLICA PARA INCLUIR UM GESTOR
    $(function() {
        $(document).on('click', '#btn-inc', function() {

            var btn_inc = $(this).val();

            if (btn_inc !== '') {

                dados = {
                    btn_inc: btn_inc
                };

                if (!btn_inc.match(/\D/)) {

                    $.post('controller/dados_cadastrais_post.php', dados, function(retorna) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Gestor cadastrado com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'dados_cadastrais';
                            }
                        })
                    });
                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Selecione um usuário da tabela Usuários!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    })
                }
            } else {

                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione um usuário da tabela Usuários!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.close();
                    }
                })
            }
        });
    });

    // POST QUANDO CLICA PARA REMOVER UM GESTOR
    $(function() {
        $(document).on('click', '#btn-exc', function() {

            var btn_exc = $(this).val();

            if (btn_exc !== '') {

                dados = {
                    btn_exc: btn_exc
                };

                if (btn_exc.match(/\D/)) {

                    $.post('controller/dados_cadastrais_post.php', dados, function(retorna) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Gestor removido com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'dados_cadastrais';
                            }
                        })
                    });
                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Selecione um Gestor da tabela Gestores!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swal.close();
                        }
                    })
                }
            } else {

                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione um Gestor da tabela Gestores!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.close();
                    }
                })
            }
        });
    });

    // POST AO REMOVER IMAGEM DE LOGO DA EMPRESA
    $(function() {
        $(document).on('click', '#remover-foto', function() {

            var id_emp_foto = $(this).attr('id_foto');

            if (id_emp_foto !== '') {

                var dados = {

                    id_emp_foto: id_emp_foto
                };

                $.post('controller/dados_cadastrais_post.php', dados, function(retorna) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Foto removida com sucesso!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'dados_cadastrais';
                        }
                    })
                });
            }
        });
    });
</script>