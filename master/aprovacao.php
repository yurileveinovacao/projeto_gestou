<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

// reset variavel de sessao para limpar o valor caso tenha editado uma empresa antes
unset($_SESSION["id_emp_master"]);

$filtro_analise = $_SESSION["filtro_analise"];

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
                            <h6 class="m-0 font-weight-bold text-primary">Aprovação</h6>
                        </div>
                        <div class="card-body">

                            <!-- <form id="processar" action="?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> -->
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead class="text-center">

                                        <div class="col-sm-12 button-tabela">
                                            <button id="" type="button" class="btn btn-primary" title="Filtros" data-toggle="modal" data-target="#filtro">
                                                <i class="fas fa-filter"></i> Filtros
                                            </button>

                                            <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>
                                        </div>

                                        <tr>
                                            <th class="d-none"></th>
                                            <!-- <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th> -->
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false">CNPJ</th>
                                            <th data-orderable="false">E-mail</th>
                                            <!-- <th data-orderable="false">Telefone</th>
                                            <th data-orderable="false">Qtd. Colaboradores</th> -->
                                            <th data-orderable="false">Datinc</th>
                                            <th data-orderable="false">Situação</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click" style="width: 5%">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="text-center">
                                        <tr>
                                            <th class="d-none"></th>
                                            <!-- <th></th> -->
                                            <th class="coluna-nome">Nome</th>
                                            <th>CNPJ</th>
                                            <th>E-mail</th>
                                            <!-- <th>Telefone</th>
                                            <th>Qtd. Colaboradores</th> -->
                                            <th>Datinc</th>
                                            <th>Situação</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                        switch ($filtro_analise) {

                                            case "P":

                                                $analise = 1;

                                                break;

                                            case "L":

                                                $analise = 2;

                                                break;

                                            case "R":

                                                $analise = 3;

                                                break;

                                            case "B":

                                                $analise = 4;

                                                break;

                                            default:

                                                $analise = "*";

                                                break;
                                        }


                                        foreach (selectGESEMP_ANALISIS($analise) as $linha) {

                                            if ($linha != 0) {

                                        ?>

                                                <tr>
                                                    <td class="d-none"><?php echo $linha['rank']; ?></td>
                                                    <!-- <td class="coluna-checkbox"><input type="checkbox" name="checkbox[]" value="?php echo $id_emp = $linha['id_emp']; ?>" title="?php echo $id_emp ?>"></input></td> -->
                                                    <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span></td>
                                                    <td style="text-align: center;"><?php echo $linha['cnpj']; ?></td>
                                                    <td><?php echo $linha['email']; ?></td>
                                                    <td class="text-center">
                                                        <?php

                                                        $data = new DateTime($linha["datinc"]);
                                                        echo $data->format("d/m/Y");

                                                        ?>
                                                    </td>
                                                    <td class="text-center">

                                                        <?php

                                                        switch ($linha["analise"]) {

                                                            case "1":

                                                        ?>

                                                                <div class="btn btn-secondary btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">PENDENTE</span>
                                                                </div>

                                                            <?php

                                                                break;

                                                            case "2":

                                                            ?>

                                                                <div class="btn btn-success btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="far fa-check-circle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">LIBERADO</span>
                                                                </div>

                                                            <?php

                                                                break;

                                                            case "3":

                                                            ?>

                                                                <div class="btn btn-danger btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="far fa-times-circle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">REPROVADO</span>
                                                                </div>

                                                            <?php

                                                                break;

                                                            case "4":

                                                            ?>

                                                                <div class="btn btn-danger btn-icon width-100">
                                                                    <span class="icon text-white-30">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                    </span>
                                                                    <span class="text font-weight-bold">Bloqueado</span>
                                                                </div>

                                                        <?php

                                                                break;
                                                        }

                                                        ?>
                                                    </td>
                                                    <td>

                                                        <?php

                                                        // Bloqueado
                                                        if ($linha["analise"] == 4) {

                                                        ?>

                                                            <div class="content-xy-center">
                                                                <div class="div-acoes">
                                                                    <button type="button" class="btn btn-primary btn-icones  btn-disabilitado" title="Editar" disabled>
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="div-acoes">
                                                                    <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Aprovar" disabled>
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="div-acoes">
                                                                    <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Reprovar" disabled>
                                                                        <i class="fas fa-ban"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="div-acoes">
                                                                    <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Copiar Link" disabled>
                                                                        <i class="fas fa-link"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        <?php

                                                        } else {

                                                        ?>

                                                            <div class="content-xy-center">
                                                                <div class="div-acoes">
                                                                    <button type="button" id="btn-edit" class="btn btn-primary btn-icones" id_emp="<?php echo $linha['id_emp'] ?>" title="Editar">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                </div>

                                                                <?php

                                                                if ((!empty($linha["id_mas"])) and ($linha["analise"] == 1)) {

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" id="btn-aprovar" class="btn btn-primary btn-icones" id_emp="<?php echo $linha['id_emp'] ?>" title="Aprovar">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                } else {

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Aprovar" disabled>
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                }

                                                                ?>

                                                                <?php

                                                                if ((!empty($linha["id_mas"])) and ($linha["analise"] == 1)) {

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" id="btn-reprovar" class="btn btn-primary btn-icones" id_emp="<?php echo $linha['id_emp'] ?>" title="Reprovar">
                                                                            <i class="fas fa-ban"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                } else {

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Reprovar" disabled>
                                                                            <i class="fas fa-ban"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                }

                                                                ?>

                                                                <?php

                                                                if ($linha["analise"] == 2) {

                                                                    $link = "https://www.gestou.com.br/validar_email?token=" . $linha["token_usa"];

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" id="btn-link" class="btn btn-primary btn-icones" id_emp="<?php echo $linha['id_emp'] ?>" link="<?php echo $link; ?>" title="Copiar Link">
                                                                            <i class="fas fa-link"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                } else {

                                                                ?>

                                                                    <div class="div-acoes">
                                                                        <button type="button" class="btn btn-primary btn-icones btn-disabilitado" title="Copiar Link" disabled>
                                                                            <i class="fas fa-link"></i>
                                                                        </button>
                                                                    </div>

                                                                <?php

                                                                }

                                                                ?>
                                                            </div>

                                                        <?php

                                                        }

                                                        ?>
                                                    </td>
                                                </tr>

                                        <?php

                                            }
                                        }

                                        ?>
                                        <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                    </tbody>
                                </table>
                                <!-- FIM TBODY E TABLE -->

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

                            </div>
                        </div>
                        <!-- </form> -->
                    </div>

                </div>
            </div>

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

</body>

</html>

<script>
    $('#dataTable').DataTable({
        autoWidth: true,
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-disabilitado', function() {

            // Btn-disabled
            Swal.fire({
                icon: "info",
                title: 'Atenção!',
                text: 'Desculpe, o botão está desabilitado. Nenhuma ação é possível no momento.'
            });

        });
    });

    $(document).ready(function() {
        $(document).on('click', '#btn-link', function() {

            // Seleciona o elemento de texto
            var elemento = $(this);

            // Obtém o texto do elemento
            var texto = elemento.attr("link");

            // Cria um elemento temporário para armazenar o texto
            var tempInput = $('<input>');

            // Define o valor do elemento temporário como o texto a ser copiado
            tempInput.val(texto);

            // Anexa o elemento temporário ao corpo do documento
            $('body').append(tempInput);

            // Seleciona o texto no elemento temporário
            tempInput.select();

            // Copia o texto para a área de transferência
            document.execCommand('copy');

            // Remove o elemento temporário
            tempInput.remove();

            // Exibe uma mensagem de sucesso
            Swal.fire({
                icon: "success",
                title: "Sucess",
                title: 'Sucesso!',
                text: 'Link copiado!'
            });

        });
    });

    $(document).ready(function() {
        // Definição de uma função para o comportamento da máscara de telefone
        var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 12 ? '(000) 00000-0000' : '(000) 0000-00009';
        };

        // Opções para a máscara de telefone
        var spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        // Aplica a máscara de telefone no campo 'telefone' com base na função de comportamento e nas opções definidas
        $('.telefone').mask(SPMaskBehavior, spOptions);
    });

    // Realiza o POST do editar empresa no clique do botão editar
    $(document).ready(function() {
        $(document).on('click', '#btn-edit', function() {

            var editar_id_emp = $(this).attr("id_emp");

            //verificar se há valor nas variaveis
            if (editar_id_emp !== '') {
                var dados = {
                    editar_id_emp: editar_id_emp
                };
                $.post('controller/alterar_aprovacao_post.php', dados, function(retorna) {

                    location.href = "alterar_aprovacao";
                });
            }
        });
    });

    // Realiza o POST do editar empresa no clique do botão editar
    $(document).ready(function() {
        $(document).on('click', '#btn-aprovar', function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja aprovar a empresa? Após fazer isso a operação não poderá ser desfeita!',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, aprovar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_aprovar = 1;

                    var aprovar_id_emp = $(this).attr("id_emp");

                    //verificar se há valor nas variaveis
                    if ((aprovar_id_emp !== '') && (btn_aprovar !== '')) {
                        var dados = {
                            aprovar_id_emp: aprovar_id_emp,

                            btn_aprovar: btn_aprovar
                        };
                        $.post('controller/alterar_aprovacao_post.php', dados, function(retorna) {

                            switch (retorna) {
                                case '3':

                                    // Informações não preenchidas corretamente ou não preenchidas
                                    Swal.fire({
                                        icon: "warning",
                                        title: "Warning",
                                        title: 'Atenção!',
                                        text: 'Por favor, selecione uma empresa para realizar a ação!'
                                    });

                                    break;

                                case '4':

                                    // Retorno de sucesso
                                    Swal.fire({
                                        icon: "success",
                                        title: "Sucess",
                                        title: 'Sucesso!',
                                        text: 'Sucesso, a empresa está totalmente apta para utilizar o sistema!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });

                                    break;

                                case '8':

                                    // Retorno de raiz_cnpj já cadastrada na base de dados
                                    Swal.fire({
                                        icon: "warning",
                                        title: "Warning",
                                        title: 'Atenção!',
                                        text: 'Desculpe, essa raiz do CNPJ já existe na nossa base de dados, favor entrar em contato com o suporte!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });

                                    break;

                                default:

                                    // Caso o retorno seja o retorno de um TRY ou diferente de qualquer dos itens acima
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        title: 'Erro!',
                                        text: 'Desculpe, ocorreu um erro durante a execução. Por favor, tente novamente mais tarde ou entre em contato com o suporte!' + retorna
                                    });

                                    break;
                            }
                        });
                    }

                }
            });

        });
    });

    // Realiza o POST do editar empresa no clique do botão editar
    $(document).ready(function() {
        $(document).on('click', '#btn-reprovar', function() {

            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Deseja reprovar a empresa? Após fazer isso a operação não poderá ser desfeita!',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, reprovar!',
                cancelButtonText: 'Não!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var btn_reprovar = 1;

                    var reprovar_id_emp = $(this).attr("id_emp");

                    //verificar se há valor nas variaveis
                    if ((reprovar_id_emp !== '') && (btn_reprovar !== '')) {
                        var dados = {
                            reprovar_id_emp: reprovar_id_emp,

                            btn_reprovar: btn_reprovar
                        };
                        $.post('controller/alterar_aprovacao_post.php', dados, function(retorna) {

                            switch (retorna) {
                                case '3':

                                    // Informações não preenchidas corretamente ou não preenchidas
                                    Swal.fire({
                                        icon: "warning",
                                        title: "Warning",
                                        title: 'Atenção!',
                                        text: 'Por favor, selecione uma empresa para realizar a ação!'
                                    });

                                    break;

                                case '7':

                                    // Retorno de sucesso
                                    Swal.fire({
                                        icon: "success",
                                        title: "Sucess",
                                        title: 'Sucesso!',
                                        text: 'Sucesso, a empresa foi reprovada!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });

                                    break;

                                default:

                                    // Caso o retorno seja o retorno de um TRY ou diferente de qualquer dos itens acima
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        title: 'Erro!',
                                        text: 'Desculpe, ocorreu um erro durante a execução. Por favor, tente novamente mais tarde ou entre em contato com o suporte!'
                                    });

                                    break;
                            }
                        });
                    }

                }
            });

        });
    });

    //Clique do botão btn-filtrar para filtrar entre as situações do cadastro
    $(document).ready(function() {
        $(document).on('click', '#btn-filtrar', function() {
            var btn_filtrar = 1;
            var filtro_analise = $('.filtro-situac:not(:disabled):checked').val();

            if ((btn_filtrar !== '') && (filtro_analise !== '')) {
                var dados = {
                    btn_filtrar: btn_filtrar,
                    filtro_analise: filtro_analise
                };
                $.post('controller/alterar_aprovacao_post.php', dados, function(retorna) {

                    location.reload();

                });

            }
        });
    });

    // Aguarda até que o documento HTML seja totalmente carregado
    $(document).ready(function() {

        // Quando o elemento com o ID "btn-voltar" é clicado...
        $('#btn-voltar').click(function() {

            // Redireciona para a página "index"
            location.href = "index";
        });
    });
</script>

<script>
    //document.getElementById("estado").onchange = function () {

    // var select = document.getElementById("estado");

    // var cep = select.options[select.selectedIndex].getAttribute("namespace");

    //document.querySelector("[name='cep']").value = '';

    //}

    //document.getElementById("cidade").onchange = function () {

    //    var select = document.getElementById("cidade");

    //    var cep = select.options[select.selectedIndex].getAttribute("namespace");

    //    document.querySelector("[name='cep']").value = cep;

    //}
</script>

<script>
    // $("#checkTodos").click(function() {
    //     $('input:checkbox').not(this).prop('checked', this.checked);
    // });

    // $("[name='checkbox[]']").click(function() {
    //     var cont = $("[name='checkbox[]']:checked").length;
    //     $("#btn-excluir").prop("disabled", cont ? false : true);
    // });

    //Manipulando as colunas
    //   function exibeColumn() {
    //     if(document.getElementById("colunaoculta").style.display == "none"){
    //         document.getElementById("dataTable").style.width = '150%'
    //     $(document).ready(function() 
    //  {
    //      $('td:nth-child(3),th:nth-child(3)').show();
    // });

    // $(document).ready(function() 
    //  {
    //      $('td:nth-child(4),th:nth-child(4)').show();
    // });
    //     }els{

    //         document.getElementById("dataTable").style.width = '100%'

    // $(document).ready(function() 
    //  {
    //      $('td:nth-child(3),th:nth-child(3)').hide();
    // });

    // $(document).ready(function() 
    //  {
    //      $('td:nth-child(4),th:nth-child(4)').hide();
    // });

    //     }

    // }
</script>

<?php
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// if (isset($_REQUEST['de'])) {
//     try {

//         $situac = 0;
//         $id_emp = $_REQUEST["de"];
//         $id_usa_atu = $_SESSION['id_usa'];

//         // echo '$situac : ' .  $situac .'<br>' . '$datatu : ' . $datatu .'<br>' . '$id_usa_atu : ' . $id_usa_atu .'<br>' . '$id_emp : ' . $id_emp ;

//         updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

//         echo "<script language=javascript>
//         location.href = 'tabela_empresas';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

// if (isset($_REQUEST['ha'])) {
//     try {
//         $situac = 1;
//         $id_emp = $_REQUEST["ha"];
//         $id_usa_atu = $_SESSION['id_usa'];

//         // echo '$situac : ' .  $situac .'<br>' . '$datatu : ' . $datatu .'<br>' . '$id_usa_atu : ' . $id_usa_atu .'<br>' . '$id_emp : ' . $id_emp ;

//         updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

//         echo "<script language=javascript>
//         location.href = 'tabela_empresas';
//         </script>";
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// if (isset($_REQUEST['btn-excluir'])) {
//     try {

//         $id_emp_master;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_emp_master = $id_emp_master . $va . ',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_emp = substr($id_emp_master, 0, -1);
//             $resultArr = explode(',', $id_emp);

//             switch (deleteGESEMP_in($resultArr)) {
//                 case 1: //delete executado
//                     echo "<script language=javascript>
//                     alert('Registro(s) excluido com sucesso!');
//                     location.href='tabela_empresas';
//                     </script>";
//                     break;
//                 case 23503: //erro fk
//                     echo "<script language=javascript>
//                     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
//                     location.href='tabela_empresas';
//                     </script>";
//                     break;
//                 default:
//                     echo "<script language=javascript>
//                     alert('Erro desconhecido, consultar tabela de códigos!');
//                     location.href='tabela_empresas';
//                     </script>";
//             }
//         } else {
//         }
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

// // POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS
// if (isset($_POST["editar_id_emp"])) {

//     // VÁRIAVEL PARA LISTAR OS DADOS DO CLIENTE NA PÁGINA VISUALIZAR CLIENTES
//     $_SESSION["editar_id_emp"] = $_POST["editar_id_emp"];
// }

?>