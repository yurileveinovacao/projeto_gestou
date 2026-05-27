<?php
require_once 'restrito.php';
require_once __DIR__.'/../../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

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

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                        <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <?php

                    try {
                        //REQUEST DA PÁGINA ANTERIOR
                        if (isset($_SESSION['id_usu_beneficios'])) {

                            $id_usu_beneficios = $_SESSION['id_usu_beneficios'];
                        }
                    } catch (PDOException $erro) {
                        echo $erro->getMessage();
                    }

                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Funcionário:
                                <?php
                                foreach (selectTABELA_BENEFICIOS_FUNC($raiz_cnpj, $id_usu_beneficios, $id_emp_default) as $nomefunc) {
                                    if ($nomefunc != 0) {

                                        $nome_func = $nomefunc["nome_func"];
                                    }
                                }

                                echo $nome_func;

                                ?>
                            </h6>
                        </div>
                        <div class="card-body">

                            <!-- Div principal-->
                            <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none; user-select: none" id="dvPrincipal">

                                <div class="form-group mt-3">
                                    <label>Situação:</label>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio0" name="radio" value="N" data-cad="nao-liberado" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio0">Não Liberado</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio1" name="radio" value="A" data-cad="aguardando" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio1">Aguardando Aceite</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio2" name="radio" value="P" data-cad="pendente" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio2">Pendente</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio3" name="radio" value="A" data-cad="aprovado" onclick="inativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio3">Aprovado</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio4" name="radio" value="R" data-cad="reprovado" onclick="inativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio4">Reprovado</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" onclick="ativa_checktodos();" class="btn1 custom-control-input">
                                        <label class="custom-control-label" for="radio5">Todos</label>
                                    </div>

                                </div>

                            </div>
                            <!-- Fim Div principal-->

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead>
                                            <div class="col-sm-12 button-tabela">
                                                <button id="btnExibeOcultaDiv" class="btn btn-primary" title="Filtros"><i class="fas fa-filter"></i> Filtros</button>
                                                <a href="tabela_funcionarios"><button type="button" name="btn-voltar" data-toggle="tooltip" title="Voltar Tabela Funcionários" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button></a>
                                            </div>
                                            <tr>
                                                <th data-orderable="false" class="d-none" style="vertical-align: middle;">Rank</th>
                                                <th data-orderable="false" style="vertical-align: middle;">Datinc</th>
                                                <th data-orderable="false" style="vertical-align: middle;">Tipo / Período / Arquivo</th>
                                                <th data-orderable="false" style="vertical-align: middle;">Situação</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="vertical-align: middle;">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="d-none">Rank</th>
                                                <th>Datinc</th>
                                                <th>Tipo / Período / Arquivo</th>
                                                <th>Situação</th>
                                                <th style="text-align: center;">Ações</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="texto-table-body recibos">
                                            <!-- CORPO DA TABELA COM TODOS -->
                                            <?php

                                            foreach (selectTABELA_BENEFICIOS_FUNC($raiz_cnpj, $id_usu_beneficios, $id_emp_default) as $linha) {
                                                if ($linha != 0) {
                                                    $situac = $linha['situac'];

                                                    if (!empty($linha["arquivo"])) {

                                            ?>

                                                        <!-- IF SITUAC == 0 -->
                                                        <?php if ($situac == 0) { ?>

                                                            <tr class="recibo nao-liberado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">NÃO LIBERADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <button type="button" class="btn btn-outline-primary visualizar_pdf" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 0 -->

                                                        <!-- IF SITUAC == 1 -->
                                                        <?php if ($situac == 1) { ?>

                                                            <tr class="recibo aguardando">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">AGUARDANDO ACEITE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <button type="button" class="btn btn-outline-primary visualizar_pdf" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 1 -->

                                                        <!-- IF SITUAC == 2 -->
                                                        <?php if ($situac == 2) { ?>

                                                            <tr class="recibo pendente">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-warning btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">PENDENTE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <button type="button" class="btn btn-outline-primary visualizar_pdf" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 2 -->

                                                        <!-- IF SITUAC == 3 -->
                                                        <?php if ($situac == 3) { ?>

                                                            <tr class="recibo aprovado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-success btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">APROVADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <button type="button" class="btn btn-outline-primary visualizar_pdf" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 3 -->

                                                        <!-- IF SITUAC == 4 -->
                                                        <?php if ($situac == 4) { ?>

                                                            <tr class="recibo reprovado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-danger btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="far fa-times-circle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">REPROVADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" motrep="<?php echo $motrep = $linha['motrep']; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 4 -->

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <!-- IF SITUAC == 0 -->
                                                        <?php if ($situac == 0) { ?>

                                                            <tr class="recibo nao-liberado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">NÃO LIBERADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 0 -->

                                                        <!-- IF SITUAC == 1 -->
                                                        <?php if ($situac == 1) { ?>

                                                            <tr class="recibo aguardando">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-secondary btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">AGUARDANDO ACEITE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 1 -->

                                                        <!-- IF SITUAC == 2 -->
                                                        <?php if ($situac == 2) { ?>

                                                            <tr class="recibo pendente">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-warning btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">PENDENTE</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 2 -->

                                                        <!-- IF SITUAC == 3 -->
                                                        <?php if ($situac == 3) { ?>

                                                            <tr class="recibo aprovado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-success btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">APROVADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 3 -->

                                                        <!-- IF SITUAC == 4 -->
                                                        <?php if ($situac == 4) { ?>

                                                            <tr class="recibo reprovado">
                                                                <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                                <td class="text-center"><?php echo $linha['datinc']; ?></td>
                                                                <td><span class="m-0 text-primary tamanho-text-08"><?php echo $linha['tip_per_arq']; ?></span></td>


                                                                <td style="text-align: center;">
                                                                    <div class="btn btn-danger btn-icon width-100">
                                                                        <span class="icon text-white-30">
                                                                            <i class="far fa-times-circle"></i>
                                                                        </span>
                                                                        <span class="text font-weight-bold">REPROVADO</span>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align: center;">

                                                                    <?php if ($linha["tipo"] != "") { ?>

                                                                        <?php if ($contagem > 0) { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } else { ?>
                                                                            <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $linha['id']; ?>" tipo="<?php echo $linha["tipo"]; ?>" motrep="<?php echo $motrep = $linha['motrep']; ?>" title="Detalhes Item">Detalhe</button>
                                                                        <?php } ?>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <button type="button" class="btn btn-outline-secondary" title="Detalhes Item">Detalhe</button>

                                                                    <?php

                                                                    }

                                                                    ?>

                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!-- FIM SITUAC == 4 -->

                                            <?php
                                                    }
                                                } else {
                                                }
                                            }

                                            ?>
                                            <!-- FIM DO WHILE COM RETORNO DO BANCO -->

                                        </tbody>
                                    </table>
                            </form>
                            <!-- FIM TBODY E TABLE -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------------------------------- -->

        <!-- Eventos Modal-->
        <div class="modal fade" id="Eventos" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Eventos" aria-hidden="true">
            <div class="modal-dialog" style="width: 900px !important;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Eventos">Eventos</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <form>

                                    <table class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <!-- <table class="linha-altura" width="100%"  width="100%" cellspacing="0">      -->
                                        <thead>
                                            <tr>
                                                <!-- <th data-orderable="false" class="sorttable_nosort nao_click"><input id="checkTodos" type="checkbox"></input></th> -->
                                                <th data-orderable="false" width="10%" class="sorttable_nosort nao_click">Evento</th>
                                                <th data-orderable="false" class="coluna-nome sorttable_nosort nao_click">Descrição</th>
                                                <th width="10%" data-orderable="false" style="text-align: center" class="sorttable_nosort nao_click">Status</th>
                                                <th width="25%" data-orderable="false" class="sorttable_nosort nao_click">Tipo</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th width="10%" class="sorttable_nosort nao_click">Evento</th>
                                                <th class="coluna-nome sorttable_nosort nao_click">Descrição</th>
                                                <th width="10%" style="text-align: center" class="sorttable_nosort nao_click">Status</th>
                                                <th width="25%">Tipo</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <!-- <tbody class="linha-altura"> -->
                                            <?php
                                            $sql_eventos = 'SELECT * FROM public."GESEVE" where id_emp = ' . $idemp . '';
                                            $res_eventos = pg_exec($conn, $sql_eventos);

                                            while ($row_eventos = pg_fetch_assoc($res_eventos)) {
                                            ?>
                                                <!-- <tr> -->
                                                <tr>
                                                    <td style="display: none;" class="linha-altura">
                                                        <?php echo $row_eventos['id_eve']; ?></td>
                                                    <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['codevento']; ?></span>
                                                    </td>
                                                    <td><span class="m-0 tamanho-text linha-altura"><?php echo $row_eventos['nome']; ?></span>
                                                    </td>
                                                    <td style="text-align: center" class="linha-altura">
                                                        <?php
                                                        if ($row_eventos['tipo'] == 'P') {
                                                        ?>
                                                            <img src="img/pendente.png" title="Pendente" height="35" width="35"></img>
                                                        <?php
                                                        }
                                                        if ($row_eventos['tipo'] == 'D') {
                                                        ?>
                                                            <img src="img/desconto.png" title="Desconto" height="35" width="35"></img>
                                                        <?php
                                                        }
                                                        if ($row_eventos['tipo'] == 'V') {
                                                        ?>

                                                            <img src="img/vencimento.png" title="Vencimento" height="35" width="35"></img>

                                                        <?php
                                                        } ?>

                                                    </td>
                                                    <td class="linha-altura">
                                                        <!-- COMEÇO DO SELECT -->
                                                        <select id="comboEvento" name="comboEvento" class="cor-select">
                                                            <?php

                                                            $id_eve = $row_eventos['id_eve'];
                                                            $tipo = "'P'";

                                                            $verifica_tipo = 'SELECT tipo FROM public."GESEVE" where id_emp = ' . $idemp . ' and id_eve=' . $id_eve . ' and tipo= ' . $tipo . ' ';
                                                            $result_tipo = pg_exec($conn, $verifica_tipo);
                                                            $numero_linha = pg_num_rows($result_tipo);

                                                            if ($numero_linha == 1) {
                                                            ?>
                                                                <option value="P" style="color: yellow;" selected>PENDENTE</option>
                                                                <option value="V" style="color: blue">VENCIMENTO</option>
                                                                <option value="D" style="color: red">DESCONTO</option>

                                                                <?php
                                                            } else {
                                                                $verifica_tipo1 = 'SELECT * FROM public."VW_EVENTOS" where id_eve=' . $id_eve . ' and id_emp =' . $idemp . '';
                                                                $result_tipo1 = pg_exec($conn, $verifica_tipo1);

                                                                while ($linha_eventos1 = pg_fetch_assoc($result_tipo1)) {
                                                                    if ($linha_eventos1['tipo'] == 'P') {
                                                                ?>
                                                                        <option value="<?php echo $linha_eventos1['tipo']; ?>" style="color: yellow;">
                                                                            <?php echo $linha_eventos1['tipo_f']; ?></option>
                                                                        <option value="D" style="color: red">DESCONTO</option>
                                                                        <option value="V" style="color: blue">VENCIMENTO</option>

                                                                    <?php
                                                                    }
                                                                    if ($linha_eventos1['tipo'] == 'D') {
                                                                    ?>
                                                                        <option value="<?php echo $linha_eventos1['tipo']; ?>" style="color: red">
                                                                            <?php echo $linha_eventos1['tipo_f']; ?></option>
                                                                        <option value="V" style="color: blue">VENCIMENTO</option>
                                                                        <option value="P" style="color: yellow;">PENDENTE</option>

                                                                    <?php
                                                                    }

                                                                    if ($linha_eventos1['tipo'] == 'V') {
                                                                    ?>
                                                                        <option value="<?php echo $linha_eventos1['tipo']; ?>" style="color: blue">
                                                                            <?php echo $linha_eventos1['tipo_f']; ?></option>
                                                                        <option value="D" style="color: red">DESCONTO</option>
                                                                        <option value="P" style="color: yellow;">PENDENTE</option>

                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btn-salvar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- End of Main Content -->
        <?php

        include_once "footer.php";

        ?>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

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

        <!-- SWEET ALERT -->
        <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
        <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
        <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('input:disabled').prop('checked', false);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
</script>
<script>
    $("#btnExibeOcultaDiv").click(function(e) {
        e.preventDefault(); // evita que o formulário seja submetido
        $("#dvPrincipal").toggle();
    });
</script>

<script>
    $('.btn1').on('click', function() {
        var cat = $(this).attr('data-cad')
        if (cat == 'reprovado') {
            $('.recibo tr').show()
        }
        if (cat == 'todos') {
            $('.recibos tr').show()
        } else {
            $('.recibo').each(function() {
                if (!$(this).hasClass(cat)) {
                    $(this).hide()
                } else {
                    $(this).show()
                }
            })
        }
    })

    function inativa_checktodos() {

        $('#checkTodos').prop('disabled', true);
        $('#checkTodos').prop('checked', false);
        $('#btn-excluir').prop('disabled', true);
        $("[name='checkbox[]']:checked").prop("checked", false);

    }

    function ativa_checktodos() {

        $('#checkTodos').prop('disabled', false);
        $('#checkTodos').prop('checked', false);
        $('#btn-excluir').prop('disabled', true);
        $("[name='checkbox[]']:checked").prop("checked", false);

    }
</script>

<div id="visuDetalheModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Itens de Holerite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visuDetalheHolerite"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#status').change(function() {
            var status = $('#status').val();
            //alert(status);
            var index = $(this).parent().index();
            var nth = "#dataTable td:nth-child(" + (index + 1).toString() + ")";
            var valor = $(this).val().toUpperCase();
            if (status == '3') {
                alert('Selecionei todos');
                $("#dataTable tbody tr").show();
            } else {
                $("#dataTable tbody tr").show();
                $(nth).each(function() {
                    if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                        $(this).parent().hide();
                    }
                });
            }
        })
    })

    //Clique do botão detalhe quando existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.view_data_pendente', function() {
            alert('Ainda há eventos pendentes, não é possível visualizar os dados!');
        })
    })

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.view_data', function() {
            var id_recebido = $(this).attr("id_im1");
            var motrep = $(this).attr("motrep");
            var tipo = $(this).attr("tipo");

            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {

                if (tipo === "H") {

                    if (motrep !== '') {

                        var dados = {
                            id_recebido: id_recebido,
                            motrep: motrep
                        };
                        $.post('visualizar_holerite_aceite', dados, function(retorna) {
                            //alert(retorna);
                            //Carregar o conteudo para o usuário
                            $("#visuDetalheHolerite").html(retorna);
                            $('#visuDetalheModal').modal('show');

                        });

                    } else {

                        var dados = {
                            id_recebido: id_recebido
                        };
                        $.post('visualizar_holerite_aceite', dados, function(retorna) {
                            //alert(retorna);
                            //Carregar o conteudo para o usuário
                            $("#visuDetalheHolerite").html(retorna);
                            $('#visuDetalheModal').modal('show');

                        });

                    }

                }

                if (tipo === "P") {

                    var dados = {
                        id_recebido: id_recebido
                    };
                    $.post('visualizar_itens_ponto', dados, function(retorna) {
                        //alert(retorna);
                        //Carregar o conteudo para o usuário
                        $("#visuDetalheHolerite").html(retorna);
                        $('#visuDetalheModal').modal('show');

                    });

                }

            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.visualizar_pdf', function() {
            var id_recebido = $(this).attr("id_im1");
            var opcao = "visualizar_pdf"
            var tipo = $(this).attr("tipo");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if ((id_recebido !== '') && (opcao !== '') && (tipo !== '')) {

                // If Holerite
                if (tipo === "H") {
                    var dados = {
                        id_recebido: id_recebido,
                        opcao: opcao
                    };

                    $.post('visualizar_holerite_aceite', dados, function(retorna) {
                        //alert(retorna);
                        //Carregar o conteudo para o usuário
                        $("#visuDetalheHolerite").html(retorna);
                        $('#visuDetalheModal').modal('show');

                    });

                }

                if (tipo === "P") {

                    var dados = {
                        id_recebido: id_recebido,
                        opcao: opcao
                    };
                    $.post('visualizar_itens_ponto', dados, function(retorna) {
                        //alert(retorna);
                        //Carregar o conteudo para o usuário
                        $("#visuDetalheHolerite").html(retorna);
                        $('#visuDetalheModal').modal('show');

                    });

                }

                if (tipo === "R") {

                    var dados = {
                        id_recebido: id_recebido,
                        opcao: opcao
                    };
                    $.post('visualizar_itens_recibo', dados, function(retorna) {
                        //alert(retorna);
                        //Carregar o conteudo para o usuário
                        $("#visuDetalheHolerite").html(retorna);
                        $('#visuDetalheModal').modal('show');

                    });

                }

                if (tipo === "I") {

                    var dados = {
                        id_recebido: id_recebido,
                        opcao: opcao
                    };
                    $.post('visualizar_itens_imposto', dados, function(retorna) {
                        //alert(retorna);
                        //Carregar o conteudo para o usuário
                        $("#visuDetalheHolerite").html(retorna);
                        $('#visuDetalheModal').modal('show');

                    });

                }

            }
        });
    });
</script>

<script>
    function sem_delete() {

        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível deletar o(s) item(s)!'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'itens_loteh?vw=<?php echo $_SESSION['id_processamento'] ?>';
            }
        })

    }
</script>

<?php

if (isset($_REQUEST['btn-excluir'])) {
    try {

        // require_once __DIR__.'/../../config/database.php';

        $id_im1_excluir;

        if (0 == 0) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                $s = [];
                foreach ($_POST as $chave => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $ch => $va) {
                            if ($va != 'on') {
                                // echo $va.',';
                                $id_im1_excluir = $id_im1_excluir . $va . ',';
                            }
                        }
                    }
                }
            }

            if (empty($id_im1_excluir)) {

                echo "<script>
                sem_delete();
                </script>";
            } else {

                $tabela = "GESIM1_" . $raiz_cnpj . "";
                $campo = "id_im1";

                $id_im1_excluir = substr($id_im1_excluir, 0, -1);
                $resultArr = explode(',', $id_im1_excluir);

                foreach (select_id_in($resultArr, $tabela, $campo) as $arquivos) {

                    $arquivo = $arquivos["arquivo"];

                    unlink('../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $arquivo . '');
                }

                switch (delete_id_in($resultArr, $tabela, $campo)) {
                    case 1: //delete executado
                        echo "<script language=javascript>
                    alert('Registro(s) excluido(s) com sucesso!');
                    location.href='itens_loteh?vw=" . $_SESSION['id_processamento'] . "';
                    </script>";
                        break;
                        // case 23503: //erro fk
                        //     echo "<script language=javascript>
                        //     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
                        //     location.href='tabela_funcionarios';
                        //     </script>";
                        //     break;
                    default:
                        echo "<script language=javascript>
                    alert('Erro desconhecido, consultar tabela de códigos!');
                    location.href='itens_loteh?vw=" . $_SESSION['id_processamento'] . "';
                    </script>";
                }
            }
        } else {

            echo "<script>
            function sem_delete() {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    title: 'Atenção!',
                    text: 'Não é possível deletar o item pois ele já foi visualizado / assinado pelo usuário!'
                });
        
            }
        </script>";
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// if (isset($_REQUEST['ex'])) {
//     try {

//         $id_im1 = $_REQUEST["ex"];

//         deleteGESIM1($raiz_cnpj, $id_im1);

//         echo "<script language=javascript>
//         alert('Item deletado com sucesso!');
//         location.href='itens_loteh?vw=" . $_SESSION['id_processamento'] . "';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>