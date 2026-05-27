<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

unset($_SESSION["colaborador_editar"]);
unset($_SESSION["colaborador_visualizar"]);
unset($_SESSION["colaborador_beneficios"]);

if(empty($_SESSION["colaborador_filtro_situac"])){

}

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

    <title>GESTOU PORTAL - Colaboradores</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link href='css/cartao_de_aniversario.css' rel='stylesheet'>

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
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Colaboradores</h6>
                        </div>
                        <div class="card-body">

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtro" name="modal" title="Filtros"><i class="fas fa-filter"></i> Filtros</button> -->
                                                <button id="" type="button" class="btn btn-primary" title="Filtros" data-toggle="modal" data-target="#filtro"><i class="fas fa-filter"></i> Filtros</button>
                                                <button type="button" id="btn-incluir" class="btn btn-organograma btn-icon-split-organograma" title="Incluir"><i class="fas fa-plus-circle"></i> Incluir</button>
                                                <button disabled type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" title="Excluir"><i class="fas fa-trash-alt"></i> Excluir</button>

                                            </div>

                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]" title="Marcar Todos"></input></th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false">CPF</th>
                                                <th data-orderable="false">RG</th>
                                                <th data-orderable="false">PIS</th>
                                                <th data-orderable="false">Função</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click" width="20%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>CPF</th>
                                                <th>RG</th>
                                                <th>PIS</th>
                                                <th>Função</th>
                                                <th>Ações</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body funcionarios">

                                            <?php

                                            $situac_filtro = $_SESSION["colaborador_filtro_situac"];

                                            switch ($situac_filtro) {

                                                case "I":

                                                    $situac = 0;

                                                    break;

                                                case "A":

                                                    $situac = 1;

                                                    break;

                                                default:

                                                    $situac = 9;

                                                    break;
                                            }

                                            foreach (select_TABELA_COLABORADORES($raiz_cnpj, $id_emp_default, $id_usa_default, $situac) as $linha) {
                                                if (!empty($linha)) {

                                                    switch ($linha["edita"]) {

                                                        case "F":

                                            ?>

                                                            <tr style="background-color: #F5F5F5;">
                                                                <td class="coluna-checkbox">
                                                                    <input type="checkbox" disabled></input>
                                                                </td>
                                                                <td>
                                                                    <span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php echo mascaraCpf($linha["cpf"]); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['rg']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['pis']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['funcao']; ?>
                                                                </td>

                                                                <td class="content-xy-center">

                                                                    <?php

                                                                    if (!empty($linha["cpf"])) {

                                                                    ?>

                                                                        <!-- INICIO SITUACAO -->
                                                                        <div class="div-acoes">
                                                                            <?php

                                                                            if ($linha["situac"] == 0) {

                                                                            ?>

                                                                                <span class="text-danger btn_situac" colaborador="<?php echo $linha["id_usu"]; ?>"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>

                                                                            <?php

                                                                            } else {

                                                                            ?>

                                                                                <span class="text-success btn_situac" colaborador="<?php echo $linha["id_usu"]; ?>"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>

                                                                            <?php

                                                                            }

                                                                            ?>
                                                                        </div>

                                                                    <?php

                                                                    } else {

                                                                    ?>
                                                                        <!-- INICIO SITUACAO -->
                                                                        <div class="div-acoes">
                                                                            <span class="text-danger" onclick="usuario_ativo_outra()"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>
                                                                        </div>
                                                                    <?php

                                                                    }

                                                                    ?>

                                                                    <!-- INICIO VISUALIZAR -->
                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-visualizar" colaborador="<?php echo $linha["id_usu"]; ?>">
                                                                            <i class="fas fa-eye" title="Visualizar"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- INICIO BTN BENEFICIOS -->
                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-beneficios" colaborador="<?php echo $linha["id_usu"]; ?>" title="Benefícios">
                                                                            <i class="fas fa-hand-holding-usd"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- INICIO FOTO -->
                                                                    <div class="div-acoes">
                                                                        <?php

                                                                        if ($linha["verificacao_usa_rh"] == 'S') {

                                                                        ?>

                                                                            <?php

                                                                            switch ($linha["status_imagem"]) {
                                                                                case 'P':

                                                                            ?>

                                                                                    <button type="button" class="btn btn-primary btn-icones btn-aniversario" colaborador="<?php echo $linha["id_usu"]; ?>">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                                <?php

                                                                                    break;

                                                                                case 'A':

                                                                                ?>

                                                                                    <button type="button" class="btn btn-warning btn-icones" onclick="sem_acao_filial();">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                                <?php

                                                                                    break;

                                                                                case 'V':

                                                                                ?>

                                                                                    <button type="button" class="btn btn-danger btn-icones" onclick="aviso_foto();">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                            <?php

                                                                                    break;
                                                                            }

                                                                            ?>

                                                                        <?php

                                                                        } elseif ($linha["verificacao_usa_rh"] == 'N') {

                                                                        ?>

                                                                            <button type="button" class="btn btn-secondary btn-icones" onclick="sem_acao_foto();">
                                                                                <i class="fas fa-camera-retro"></i>
                                                                            </button>

                                                                        <?php

                                                                        }

                                                                        ?>
                                                                    </div>

                                                                </td>

                                                            </tr>

                                                        <?php

                                                            break;

                                                        default:

                                                        ?>

                                                            <tr>
                                                                <td class="coluna-checkbox">
                                                                    <?php

                                                                    if ($linha["situac"] == 1) {

                                                                    ?>
                                                                        <input type="checkbox" disabled></input>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <input type="checkbox" class="selecionar" value="<?php echo $id_usu = $linha['id_usu']; ?>"></input>

                                                                    <?php

                                                                    }

                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php echo mascaraCpf($linha["cpf"]); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['rg']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['pis']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $linha['funcao']; ?>
                                                                </td>

                                                                <td class="content-xy-center">

                                                                    <?php

                                                                    if (!empty($linha["cpf"])) {

                                                                    ?>

                                                                        <!-- INICIO SITUACAO -->
                                                                        <div class="div-acoes">
                                                                            <?php

                                                                            if ($linha["situac"] == 0) {

                                                                            ?>

                                                                                <span class="text-danger btn_situac" colaborador="<?php echo $linha["id_usu"]; ?>"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>

                                                                            <?php

                                                                            } else {

                                                                            ?>

                                                                                <span class="text-success btn_situac" colaborador="<?php echo $linha["id_usu"]; ?>"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>

                                                                            <?php

                                                                            }

                                                                            ?>
                                                                        </div>

                                                                    <?php

                                                                    } else {

                                                                    ?>
                                                                        <!-- INICIO SITUACAO -->
                                                                        <div class="div-acoes">
                                                                            <span class="text-danger" onclick="usuario_ativo_outra()"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>
                                                                        </div>
                                                                    <?php

                                                                    }

                                                                    ?>

                                                                    <!-- INICIO ALTERAR -->
                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-editar" colaborador="<?php echo $linha["id_usu"]; ?>">
                                                                            <i class="fas fa-pencil-alt" title="Editar"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- INICIO BTN BENEFICIOS -->
                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-beneficios" colaborador="<?php echo $linha["id_usu"]; ?>" title="Benefícios">
                                                                            <i class="fas fa-hand-holding-usd"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- INICIO FOTO -->
                                                                    <div class="div-acoes">
                                                                        <?php

                                                                        if ($linha["verificacao_usa_rh"] == 'S') {

                                                                        ?>

                                                                            <?php

                                                                            switch ($linha["status_imagem"]) {
                                                                                case 'P':

                                                                            ?>

                                                                                    <button type="button" class="btn btn-primary btn-icones btn-aniversario" colaborador="<?php echo $linha["id_usu"]; ?>">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                                <?php

                                                                                    break;

                                                                                case 'A':

                                                                                ?>

                                                                                    <button type="button" class="btn btn-warning btn-icones btn-aniversario" colaborador="<?php echo $linha["id_usu"]; ?>">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                                <?php

                                                                                    break;

                                                                                case 'V':

                                                                                ?>

                                                                                    <button type="button" class="btn btn-danger btn-icones" onclick="aviso_foto();">
                                                                                        <i class="fas fa-camera-retro"></i>
                                                                                    </button>

                                                                            <?php

                                                                                    break;
                                                                            }

                                                                            ?>

                                                                        <?php

                                                                        } elseif ($linha["verificacao_usa_rh"] == 'N') {

                                                                        ?>

                                                                            <button type="button" class="btn btn-secondary btn-icones" onclick="sem_acao_foto();">
                                                                                <i class="fas fa-camera-retro"></i>
                                                                            </button>

                                                                        <?php

                                                                        }

                                                                        ?>
                                                                    </div>

                                                                </td>

                                                            </tr>

                                            <?php

                                                            break;
                                                    }
                                                }
                                            }

                                            ?>

                                        </tbody>
                                    </table>
                                    <!-- FIM TBODY E TABLE -->
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Div principal-->
            <!-- <div class="col-md-12 mb-4 card padding-2em" style="background-color: #FFF; display:none; user-select: none" id="dvPrincipal">

                <div class="form-group col-md-6 mt-3">
                    <label>Situação:</label>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="radio1" name="radio" value="I" data-cad="situac-inativo" class="btn1 custom-control-input">
                        <label class="custom-control-label" for="radio1">Inativo</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="radio2" name="radio" value="A" data-cad="situac-ativo" class="btn1 custom-control-input">
                        <label class="custom-control-label" for="radio2">Ativo</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="radio3" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input" checked>
                        <label class="custom-control-label" for="radio3">Todos</label>
                    </div>

                </div>

            </div> -->
            <!-- Fim Div principal-->


            <!-- MODAL Visualizar -->
            <div class="modal fade" id="filtro" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="filtros" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 700px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filtros">Filtros</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group col-md-6 mt-1">
                                        <label>Situação:</label>

                                        <?php

                                        switch ($situac_filtro) {

                                            case "I":

                                        ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="I" data-cad="situac-inativo" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio1">Inativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="A" data-cad="situac-ativo" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Ativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            case "A":

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="I" data-cad="situac-inativo" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Inativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="A" data-cad="situac-ativo" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio2">Ativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            default:

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="I" data-cad="situac-inativo" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Inativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="A" data-cad="situac-ativo" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Ativo</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio3">Todos</label>
                                                </div>

                                        <?php

                                                break;
                                        }

                                        ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-filtrar" class="btn btn-organograma btn-icon-split-organograma btn-filtrar">Filtrar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal pra visualizar o conteudo salvo -->
            <div id="Visualizar" class="modal fade" tabindex="-1" aria-labelledby="Visualizar" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document" style="width: 600px !important;">
                    <div id="visuTela" class="modal-content">
                    </div>
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------------------->
            <!-- End of Main Content -->

            <?php include_once "footer.php"; ?>

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

            <script src="js/dom-to-image.min.js"></script>

</body>

</html>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(":disabled").prop('checked', this.checked);
    });

    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
</script>

<script>
    //Clique do botão incluir para realizar o cadastro do colaborador
    $(document).ready(function() {
        $(document).on('click', '#btn-incluir', function() {
            var btn_incluir = 1;

            if (btn_incluir !== '') {

                // window.location.reload();
                location.href = "cadastro_colaborador";

            }
        });
    });

    //Clique do botão situac para ativar e inativar
    $(document).ready(function() {
        $(document).on('click', '.btn_situac', function() {
            var btn_situac = 1;
            var colaborador_situac = $(this).attr("colaborador");

            if ((btn_situac !== '') && (colaborador_situac !== '')) {
                var dados = {
                    btn_situac: btn_situac,
                    colaborador_situac: colaborador_situac
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    window.location.reload();

                });
            }
        });
    });

    //Clique do botão visualizar para ver o cadastro do colaborador
    $(document).ready(function() {
        $(document).on('click', '.btn-visualizar', function() {
            var btn_visualizar = 1;
            var colaborador_visualizar = $(this).attr("colaborador");

            if ((btn_visualizar !== '') && (colaborador_visualizar !== '')) {
                var dados = {
                    btn_visualizar: btn_visualizar,
                    colaborador_visualizar: colaborador_visualizar
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    // window.location.reload();
                    location.href = "visualizar_colaborador";

                });
            }
        });
    });

    //Clique do botão editar para alterar o cadastro do colaborador
    $(document).ready(function() {
        $(document).on('click', '.btn-editar', function() {
            var btn_editar = 1;
            var colaborador_editar = $(this).attr("colaborador");

            if ((btn_editar !== '') && (colaborador_editar !== '')) {
                var dados = {
                    btn_editar: btn_editar,
                    colaborador_editar: colaborador_editar
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    // window.location.reload();
                    location.href = "alterar_colaborador";

                });
            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn-aniversario', function() {
            var abrir_modal = 1;
            var colaborador_aniversario = $(this).attr("colaborador");

            if ((abrir_modal !== '') && (colaborador_aniversario !== '')) {
                var dados = {
                    abrir_modal: abrir_modal,
                    colaborador_aniversario: colaborador_aniversario
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    //Carregar o conteudo para o usuário
                    $("#visuTela").html(retorna);
                    $('#Visualizar').modal('show');
                });
            }
        });
    });

    //Clique do botão aprovar para mover o arquivo e realizar o update externo
    $(document).ready(function() {
        $(document).on('click', '#btn-aprovar', function() {
            var situac_foto = 1;
            var colaborador_foto = $(this).attr("colaborador");

            if ((situac_foto !== '') && (colaborador_foto !== '')) {
                var dados = {
                    situac_foto: situac_foto,
                    colaborador_foto: colaborador_foto
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    if (retorna == 1) {

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            title: 'Sucesso!',
                            text: 'Foto do colaborador aprovada com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })

                    }

                });

            }
        });
    });
    //Clique do botão realizar o update externo
    $(document).ready(function() {
        $(document).on('click', '#btn-reprovar', function() {
            var situac_foto = 0;
            var colaborador_foto = $(this).attr("colaborador");

            if ((situac_foto !== '') && (colaborador_foto !== '')) {
                var dados = {
                    situac_foto: situac_foto,
                    colaborador_foto: colaborador_foto
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    if (retorna == 1) {

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            title: 'Sucesso!',
                            text: 'Foto do colaborador reprovada com sucesso!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })

                    }

                });

            }
        });
    });

    $(document).ready(function() {
        $('#btn-excluir').click(function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja excluir o(s) colaborador(es)?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_excluir = 1;
                    var selecionados = $('.selecionar:not(:disabled):checked').map(function() {
                        return this.value;
                    }).get();

                    //verificar se há calor nas variaveis
                    if ((btn_excluir !== '') && (selecionados !== '')) {
                        var dados = {
                            btn_excluir: btn_excluir,
                            selecionados: selecionados
                        };
                        $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                title: 'Sucesso!',
                                text: 'Colaborador(es) excluido(s) com sucesso!',
                                closeOnClickOutside: false,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                    // location.href = "sobre_nos";
                                }
                            });

                        });

                    }
                    // console.log(selecionados);
                    // // Faça algo com os valores selecionados aqui...

                }
            });

        });
    });

    //Clique do botão btn-beneficios para visualizar os beneficios enviados ao colaborador
    $(document).ready(function() {
        $(document).on('click', '.btn-beneficios', function() {
            var btn_beneficios = 1;
            var colaborador_beneficios = $(this).attr("colaborador");

            if ((btn_beneficios !== '') && (colaborador_beneficios !== '')) {
                var dados = {
                    btn_beneficios: btn_beneficios,
                    colaborador_beneficios: colaborador_beneficios
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    location.href = "beneficios_colaborador";

                });

            }
        });
    });

    //Clique do botão btn-beneficios para visualizar os beneficios enviados ao colaborador
    $(document).ready(function() {
        $(document).on('click', '#btn-filtrar', function() {
            var btn_filtrar = 1;
            var colaborador_filtro_situac = $('.filtro-situac:not(:disabled):checked').val();

            if ((btn_filtrar !== '') && (colaborador_filtro_situac !== '')) {
                var dados = {
                    btn_filtrar: btn_filtrar,
                    colaborador_filtro_situac: colaborador_filtro_situac
                };
                $.post('controller/tabela_colaboradores_post.php', dados, function(retorna) {

                    location.href = "tabela_colaboradores";

                });

            }
        });
    });
</script>

<script>
    // $("#btnExibeOcultaDiv").click(function(e) {
    //     e.preventDefault(); // evita que o formulário seja submetido
    //     $("#dvPrincipal").toggle();
    // });

    // $('.btn1').on('click', function() {
    //     var cat = $(this).attr('data-cad')
    //     // if (cat == 'reprovado') {
    //     //     $('.recibo tr').show()
    //     // }
    //     if (cat == 'todos') {

    //         $('.funcionarios tr').show();

    //     } else {
    //         $('.funcionario').each(function() {
    //             if (!$(this).hasClass(cat)) {

    //                 $(this).hide();

    //             } else {

    //                 $(this).show();

    //             }
    //         })
    //     }
    // });

    // $('.btn2').on('click', function() {
    //     var cat = $(this).attr('data-cad')
    //     // if (cat == 'reprovado') {
    //     //     $('.recibo tr').show()
    //     // }
    //     if (cat == 'todos-tipos') {

    //         $('.funcionarios tr').each(function() {
    //             if ($(this).hasClass("situac-ligado")) {

    //                 $(this).show();
    //                 $(this).addClass("tipo-ligado");

    //             }
    //         })

    //     } else {
    //         $('.funcionario').each(function() {
    //             if (!$(this).hasClass(cat)) {

    //                 if ($(this).hasClass("situac-ligado")) {

    //                     $(this).hide();
    //                     $(this).removeClass("tipo-ligado");

    //                 }

    //             } else {

    //                 if ($(this).hasClass("situac-ligado")) {

    //                     $(this).show();
    //                     $(this).addClass("tipo-ligado");

    //                 }
    //             }
    //         })
    //     }
    // });

    // //Clique do botão aprovar para mover o arquivo e realizar o update externo
    // $(document).ready(function() {
    //     $(document).on('click', '.btn-filtrar', function() {

    //         if ($("input[name='radio']:checked")) {

    //             var situac_filtro = $("input[name='radio']:checked").val();

    //         }

    //         if ($("input[name='tipo']:checked")) {

    //             var tipo_filtro = $("input[name='tipo']:checked").val();

    //         }

    //         if ((situac_filtro !== '') && (tipo_filtro !== '')) {
    //             var dados = {
    //                 situac_filtro: situac_filtro,
    //                 tipo_filtro: tipo_filtro
    //             };
    //             $.post('tabela_funcionarios.php', dados, function(retorna) {

    //                 window.location.reload();

    //             });

    //         }
    //     });
    // });

    // //Clique do botão btn-beneficios para visualizar os arquivos enviados ao colaborador
    // $(document).ready(function() {
    //     $(document).on('click', '.btn-beneficios', function() {
    //         var id_usu_beneficios = $(this).attr("id_usu");

    //         if (id_usu_beneficios !== '') {
    //             var dados = {
    //                 id_usu_beneficios: id_usu_beneficios
    //             };
    //             $.post('tabela_funcionarios.php', dados, function(retorna) {

    //                 location.href = "tabela_beneficios_funcionario";

    //             });

    //         }
    //     });
    // });

    // //Clique do botão CAKE para abrir modal externo trazendo a extrutura do CARTAO DE ANIVERSARIO
    // $(document).ready(function() {
    //     $(document).on('click', '.view_data', function() {
    //         var id_recebido = $(this).attr("id_usu");
    //         //alert(id_recebido);
    //         //verificar se há calor na variavel "id_recebido".
    //         if (id_recebido !== '') {
    //             var dados = {
    //                 id_recebido: id_recebido
    //             };
    //             $.post('cartao_de_aniversario.php', dados, function(retorna) {
    //                 //alert(retorna);
    //                 //Carregar o conteudo para o usuário
    //                 $("#visuCartao").html(retorna);
    //                 $('#visuModal').modal('show');

    //                 // $(document).on('hidden.bs.modal', '#visuModal', function() {

    //                 //     window.location.reload();

    //                 // });

    //             });
    //         }
    //     });
    // });

    // //Clique do botão BAIXAR para efetuar o download do HTML convertido para JPEG
    // $(document).ready(function() {
    //     $(document).on('click', '#baixar', function() {

    //         domtoimage.toJpeg(document.getElementById('my-node'), {
    //                 quality: 1
    //             })
    //             .then(function(dataUrl) {
    //                 var link = document.createElement('a');
    //                 var nome_usuario = document.getElementById("nome_usuario").innerHTML;
    //                 link.download = 'CARTAO ANIVERSARIO' + nome_usuario + '.jpeg';
    //                 link.href = dataUrl;
    //                 link.click();
    //                 // location.href = "tabela_funcionarios";
    //             });
    //     });

    // });
</script>

<script>
    function sem_acao_filial() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Não é possível realizar a ação pela matriz!'
        });
    }

    function aviso_foto() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'O colaborador não possui foto de perfil!'
        });
    }

    function sem_acao_foto() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Seu usuário não possui ação nesse item!'
        });
    }

    function usuario_nao_e_rh() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Seu usuário não possui ação nesse item!'
        });
    }

    function usuario_inativo() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'O usuário está inativo!'
        });
    }

    function acao_indisponivel_matriz() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'Ação indisponível na Matriz!'
        });
    }

    function usuario_ativo_outra() {
        Swal.fire({
            icon: "info",
            title: "Info",
            title: 'Atenção!',
            text: 'O usuário já está ativo em outra empresa!'
        });
    }
</script>

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<!-- <script type="text/javascript">
    $(function() {
        $('#estado').change(function() {
            if ($(this).val()) {
                $('#cidade').hide();
                $('.carregando').show();
                $.getJSON('select_cidade_idusu.php?search=', {
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
</script> -->

<!-- FIM ANIMAÇÃO RÁPIDA -->

<!-- <script>
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
</script> -->

<!-- <script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('input:disabled').prop('checked', false);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
</script> -->

<?php

// // POST ID_USU BENEFICIOS
// if (isset($_POST['id_usu_beneficios'])) {

//     $_SESSION["id_usu_beneficios"] = $_POST['id_usu_beneficios'];
// }

// // POST FILTROS
// if ((isset($_POST['situac_filtro'])) and (isset($_POST['tipo_filtro']))) {

//     $_SESSION["situac_filtro"] = $_POST['situac_filtro'];
//     $_SESSION["tipo_filtro"] = $_POST['tipo_filtro'];
// }


// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// if (isset($_REQUEST['de'])) {
//     try {
//         $situac = 0;
//         $id_usu = $_REQUEST['de'];

//         updateGESUSU_SITUAC($situac, $id_emp_default, $id_usu, $datatu, $id_usa_default);

//         echo "<script language=javascript>
//         location.href = 'tabela_funcionarios';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

// if (isset($_REQUEST['ha'])) {
//     try {
//         $situac = 1;
//         $id_usu = $_REQUEST['ha'];

//         if (validaGESUSU_campos($id_usu)) {
//             try {
//                 updateGESUSU_SITUAC($situac, $id_emp_default, $id_usu, $datatu, $id_usa_default);
//                 echo "<script language=javascript>
//                 location.href = 'tabela_funcionarios';
//                 </script>";
//             } catch (PDOException $erro) {
//                 echo "<script language=javascript>
//                 location.href = 'tabela_funcionarios';
//                 </script>";
//                 echo $erro->getMessage();
//             }
//         } else {
//             echo "<script language=javascript>
//             alert('O campo CPF não está preenchido, portanto não é possível ativar o usuário!');
//             location.href = 'tabela_funcionarios';
//             </script>";
//         }
//     } catch (PDOException $erro) {
//         echo "<script language=javascript>
//         location.href = 'tabela_funcionarios';
//         </script>";

//         echo $erro->getMessage();
//     }
// }
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// if (isset($_REQUEST['btn-excluir'])) {
//     try {
//         // echo 'entrou try';
//         require_once __DIR__.'/../../config/database.php';

//         $id_usuario;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_usuario = $id_usuario . $va . ',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_usu = substr($id_usuario, 0, -1);
//             $resultArr = explode(',', $id_usu);

//             switch (deleteGESUSU_in($resultArr)) {
//                 case 1: //delete executado
//                     echo "<script language=javascript>
//                     alert('Registro(s) excluido com sucesso!');
//                     location.href='tabela_funcionarios';
//                     </script>";
//                     break;
//                 case 23503: //erro fk
//                     echo "<script language=javascript>
//                     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
//                     location.href='tabela_funcionarios';
//                     </script>";
//                     break;
//                 default:
//                     echo "<script language=javascript>
//                     alert('Erro desconhecido, consultar tabela de códigos!');
//                     location.href='tabela_funcionarios';
//                     </script>";
//             }
//         } else {
//         }
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>

<?php

function mascaraCpf($cpf)
{
    if (empty($cpf)) {
        return "";
    }
    $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    return $cpfFormatado;
}

// function Mask($mask, $str)
// {

//     $str = str_replace(" ", "", $str);

//     for ($i = 0; $i < strlen($str); $i++) {
//         $mask[strpos($mask, "#")] = $str[$i];
//     }

//     return $mask;
// }

?>