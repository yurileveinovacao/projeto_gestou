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

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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
                            <h6 class="m-0 font-weight-bold text-primary">Controle de férias</h6>
                        </div>
                        <div class="card-body">

                            <!-- <form id="processar" action="?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> -->
                            <div class="table-responsive">
                                <!-- INICIO TABLE -->
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <!-- THEAD -->
                                    <thead style="text-align: center;">
                                        <div class="col-sm-12 button-tabela">
                                            <button id="" type="button" class="btn btn-primary" title="Filtros" data-toggle="modal" data-target="#filtro">
                                                <i class="fas fa-filter"></i> Filtros
                                            </button>
                                            <button type="button" class="btn btn-organograma btn-icon-split-organograma" title="Incluir" data-toggle="modal" data-target="#modal-incluir">
                                                <i class="fas fa-plus-circle"></i> Incluir
                                            </button>
                                            <button disabled type="button" id="btn-excluir" class="btn btn-organograma btn-icon-split-organograma" title="Excluir">
                                                <i class="fas fa-trash-alt"></i> Excluir
                                            </button>
                                        </div>

                                        <tr>
                                            <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]" title="Marcar Todos"></input></th>
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false">Iniaqu</th>
                                            <th data-orderable="false">Fimaqu</th>
                                            <!-- <th data-orderable="false">Datini</th>
                                            <th data-orderable="false">Datfim</th> -->
                                            <th data-orderable="false">Datlmt</th>
                                            <th data-orderable="false">Tdias</th>
                                            <th data-orderable="false">Situac</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                        </tr>
                                    </thead>

                                    <!-- TFOOT -->
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th class="coluna-nome">Nome</th>
                                            <th>Iniaqu</th>
                                            <th>Fimaqu</th>
                                            <!-- <th>Datini</th>
                                            <th>Datfim</th> -->
                                            <th>Datlmt</th>
                                            <th>Tdias</th>
                                            <th>Situac</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>

                                    <!-- INICIO TBODY -->
                                    <tbody class="texto-table-body funcionarios">

                                        <?php

                                        foreach (selectGESFER($id_emp_default) as $linha) {

                                            if ($linha != 0) {

                                        ?>

                                                <tr>
                                                    <!-- CHECKBOX -->
                                                    <td class="coluna-checkbox">

                                                        <?php if ($linha["situac"] == 1) { ?>

                                                            <input type="checkbox" disabled></input>
                                                        <?php } else { ?>

                                                            <input type="checkbox" class="selecionar" value="<?php echo $if_fer = $linha['if_fer']; ?>"></input>
                                                        <?php } ?>

                                                    </td>

                                                    <!-- NOME -->
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text">YURI PEREIRA DA SILVA</span>
                                                    </td>

                                                    <!-- INIAQU -->
                                                    <td>
                                                        01/07/2023
                                                    </td>

                                                    <!-- FIMAQU -->
                                                    <td>
                                                        01/07/2024
                                                    </td>

                                                    <!-- DATINI -->
                                                    <!-- <td>
                                                01/08/2023
                                            </td> -->

                                                    <!-- DATFIM -->
                                                    <!-- <td>
                                                30/08/2023
                                            </td> -->

                                                    <!-- DATLMT -->
                                                    <td>
                                                        01/06/2023
                                                    </td>

                                                    <!-- TDIAS -->
                                                    <td>
                                                        0 dias
                                                    </td>

                                                    <!-- SITUAC -->
                                                    <td>
                                                        <div class="btn btn-warning btn-icon width-100">
                                                            <span class="icon text-white-30">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text font-weight-bold">PENDENTE</span>
                                                        </div>
                                                    </td>

                                                    <!-- INICIO AÇÕES -->
                                                    <td class="content-xy-center">

                                                        <!-- EDITAR -->
                                                        <div class="div-acoes">
                                                            <button type="button" class="btn btn-primary btn-icones btn-edit" colaborador="<?php echo $linha["if_fer"]; ?>">
                                                                <i class="fas fa-pencil-alt" title="Editar"></i>
                                                            </button>
                                                        </div>

                                                        <!-- BENEFICIOS -->
                                                        <!-- <div class="div-acoes">
                                                            <button type="button" class="btn btn-primary btn-icones btn-beneficios" colaborador="<?php echo $linha["if_fer"]; ?>" title="Benefícios">
                                                                <i class="fas fa-hand-holding-usd"></i>
                                                            </button>
                                                        </div> -->

                                                    </td>
                                                    <!-- FIM AÇÕES -->

                                                </tr>

                                        <?php

                                            }
                                        }

                                        ?>

                                        <tr>
                                            <!-- CHECKBOX -->
                                            <td class="coluna-checkbox">

                                                <?php if ($linha["situac"] == 1) { ?>

                                                    <input type="checkbox" disabled></input>
                                                <?php } else { ?>

                                                    <input type="checkbox" class="selecionar" value="<?php echo $if_fer = $linha['if_fer']; ?>"></input>
                                                <?php } ?>

                                            </td>

                                            <!-- NOME -->
                                            <td>
                                                <span class="m-0 text-primary tamanho-text">YURI PEREIRA DA SILVA</span>
                                            </td>

                                            <!-- INIAQU -->
                                            <td>
                                                01/07/2023
                                            </td>

                                            <!-- FIMAQU -->
                                            <td>
                                                01/07/2024
                                            </td>

                                            <!-- DATINI -->
                                            <!-- <td>
                                                01/08/2023
                                            </td> -->

                                            <!-- DATFIM -->
                                            <!-- <td>
                                                30/08/2023
                                            </td> -->

                                            <!-- DATLMT -->
                                            <td>
                                                01/06/2023
                                            </td>

                                            <!-- TDIAS -->
                                            <td>
                                                0 dias
                                            </td>

                                            <!-- SITUAC -->
                                            <td>
                                                <div class="btn btn-warning btn-icon width-100">
                                                    <span class="icon text-white-30">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </span>
                                                    <span class="text font-weight-bold">PENDENTE</span>
                                                </div>
                                            </td>

                                            <!-- INICIO AÇÕES -->
                                            <td class="content-xy-center">

                                                <!-- EDITAR -->
                                                <div class="div-acoes">
                                                    <button type="button" class="btn btn-primary btn-icones btn-edit" colaborador="<?php echo $linha["if_fer"]; ?>">
                                                        <i class="fas fa-pencil-alt" title="Editar"></i>
                                                    </button>
                                                </div>

                                                <!-- BENEFICIOS -->
                                                <!-- <div class="div-acoes">
                                                    <button type="button" class="btn btn-primary btn-icones btn-beneficios" colaborador="<?php echo $linha["if_fer"]; ?>" title="Benefícios">
                                                        <i class="fas fa-hand-holding-usd"></i>
                                                    </button>
                                                </div> -->

                                            </td>
                                            <!-- FIM AÇÕES -->

                                        </tr>

                                    </tbody>
                                    <!-- FIM TBODY -->

                                </table>
                                <!-- FIM TABLE -->

                            </div>

                        </div>
                        <!-- </form> -->
                    </div>

                </div>
            </div>


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

                                        switch ($filtro_analise) {

                                            case "P":

                                        ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="P" data-cad="situac-pendente" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio1">Pendente</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="L" data-cad="situac-liberado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Liberado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="R" data-cad="situac-reprovado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Reprovado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio4" name="radio" value="B" data-cad="situac-bloqueado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio4">Bloqueado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio5">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            case "L":

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="P" data-cad="situac-pendente" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Pendente</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="L" data-cad="situac-liberado" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio2">Liberado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="R" data-cad="situac-reprovado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Reprovado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio4" name="radio" value="B" data-cad="situac-bloqueado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio4">Bloqueado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio5">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            case "R":

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="P" data-cad="situac-pendente" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Pendente</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="L" data-cad="situac-liberado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Liberado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="R" data-cad="situac-reprovado" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio3">Reprovado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio4" name="radio" value="B" data-cad="situac-bloqueado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio4">Bloqueado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio5">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            case "B":

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="P" data-cad="situac-pendente" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Pendente</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="L" data-cad="situac-liberado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Liberado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="R" data-cad="situac-reprovado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Reprovado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio4" name="radio" value="B" data-cad="situac-bloqueado" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio4">Bloqueado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio5">Todos</label>
                                                </div>

                                            <?php

                                                break;

                                            default:

                                            ?>

                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="radio" value="P" data-cad="situac-pendente" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio1">Pendente</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="radio" value="L" data-cad="situac-liberado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio2">Liberado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio3" name="radio" value="R" data-cad="situac-reprovado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio3">Reprovado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio4" name="radio" value="B" data-cad="situac-bloqueado" class="btn1 custom-control-input filtro-situac">
                                                    <label class="custom-control-label" for="radio4">Bloqueado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="radio5" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input filtro-situac" checked>
                                                    <label class="custom-control-label" for="radio5">Todos</label>
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

            <!-- INICIO MODAL INCLUIR -->
            <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Incluir" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70vw;">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="Incluir">Incluir férias</h5>
                            <button class="close" type="button" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <form id="modal-form-incluir" class="needs-validation" novalidate>
                            <div class="modal-body" style="max-height: 470px; overflow-y: auto; scrollbar-width: thin;">

                                <div class="col-md-12">

                                    <!-- <label for="inputTitulo" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Ex: Título referente ao aviso">Título <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" id="inputTitulo" name="inputTitulo" minlength="3" required></input> -->

                                    <div class="form-row">

                                        <div class="col-md-12">

                                            <label for="inputColaborador" class="mt-sm-3">Colaborador</label>
                                            <select class="form-control" style="text-transform: uppercase;" id="inputColaborador" name="inputColaborador" required>

                                                <option value="" selected disabled>Escolha um colaborador</option>

                                                <?php foreach (selectGESUSU_EMPRESA($id_emp_default) as $usuarios_empresa) { ?>

                                                    <option value="<?php echo $usuarios_empresa["id_usu"]; ?>"><?php echo $usuarios_empresa["nome"]; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-row justify-content-between">

                                        <div class="col-md-2">
                                            <label for="inputIniaqu" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do início do período aquisitivo">Início Aquisitivo <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputIniaqu" name="inputIniaqu" required></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputFimaqu" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do fim do período aquisitivo">Fim Aquisitivo <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputFimaqu" name="inputFimaqu" required></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatini" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do início das férias">Início Férias <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatini" name="inputDatini" required></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatfim" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data do fim das férias">Fim Férias <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatfim" name="inputDatfim" required></input>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="inputDatlmt" class="mt-sm-3" data-toggle="tooltip" data-placement="left" title="Data limite para o aviso de férias">Data Limite <i class="fas fa-info-circle"></i></label>
                                            <input type="text" class="form-control" id="inputDatlmt" name="inputDatlmt" required></input>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id="btn-finalizar" class="btn btn-organograma btn-icon-split-organograma">Finalizar</button>
                                <button class="btn btn-secondary" id="btn-voltar" type="button" data-dismiss="modal">Voltar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- FIM MODAL INCLUIR -->

            <!-- ---------------------------------------------------------------------------------------------------------------------->
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            include_once "footer.php"

            ?>
            <!-- End of Footer -->

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

            <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</body>

</html>

<script>
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
                        // alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(document).ready(function() {

        $('#inputIniaqu').mask('00/00/0000');
        $('#inputFimaqu').mask('00/00/0000');
        $('#inputDatini').mask('00/00/0000');
        $('#inputDatfim').mask('00/00/0000');
        $('#inputDatlmt').mask('00/00/0000');

    });

    $('#dataTable').DataTable({
        autoWidth: true,
        "stateSave": true,
        "stateDuration": 0,
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    }).on('draw', function() {

        // Marca todos os Checkbox, menos os disabled
        $("#checkTodos").click(function() {
            $('input:checkbox').not(":disabled").prop('checked', this.checked);
        });

        // Habilita o botão excluir se tiver um checkbox marcado
        $("input:checkbox").click(function() {
            var cont = $(".selecionar:not(:disabled):checked").length;
            $("#btn-excluir").prop("disabled", cont ? false : true);
        });

        // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
        $("input:checkbox").click(function() {
            var cont = $(".selecionar:not(:disabled):checked").length;
            var cont_total = $(".selecionar:not(:disabled)").length;
            var check_todos = cont == cont_total;
            $("#checkTodos").prop("checked", check_todos ? true : false);
        });
    });

    // Marca todos os Checkbox, menos os disabled
    $("#checkTodos").click(function() {
        $('input:checkbox').not(":disabled").prop('checked', this.checked);
    });

    // Habilita o botão excluir se tiver um checkbox marcado
    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
    $("input:checkbox").click(function() {
        var cont = $(".selecionar:not(:disabled):checked").length;
        var cont_total = $(".selecionar:not(:disabled)").length;
        var check_todos = cont == cont_total;
        $("#checkTodos").prop("checked", check_todos ? true : false);
    });
</script>

<script>
    // SUBMIT INCLUIR
    $(function() {
        $("#modal-form-incluir").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            var btn_submit = 1;

            if (btn_submit !== '') {

                var dados = {

                    colaborador: $('#inputColaborador').val(),
                    iniaqu: $('#inputIniaqu').val(),
                    fimaqu: $('#inputFimaqu').val(),
                    datini: $('#inputDatini').val(),
                    datfim: $('#inputDatfim').val(),
                    datlmt: $('#inputDatlmt').val(),

                    // Valida o Submit
                    btn_submit: btn_submit
                };

                // $.post('controller/controle_ferias_post.php', dados, function(retorno) {

                // });

            }

        });
    });

    // Realiza o POST do editar ferias no clique do botão editar
    $(document).ready(function() {
        $(document).on('click', '.btn-edit', function() {

            var btn_editar = 1;
            var editar_if_fer = $(this).attr("if_fer");

            //verificar se há valor nas variaveis
            if ((btn_editar !== '') && (editar_if_fer !== '')) {
                var dados = {
                    editar_if_fer: editar_if_fer,
                    btn_editar: btn_editar
                };
                // $.post('controller/controle_ferias_post.php', dados, function(retorna) {

                //     location.href = "controle_ferias_editar";
                // });
            }
        });
    });
</script>