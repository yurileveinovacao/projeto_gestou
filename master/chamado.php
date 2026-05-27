<?php

require_once 'restrito.php';
//require_once 'raiz_cnpj_pdo.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];
$id_mas = $_SESSION['id_mas'];
$today = date('Y-m-d H:i:s');

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

    <title>GESTOU PORTAL - CHAMADO</title>

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

        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once 'barra_superior.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Begin DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Chamados</h6>
                        </div>
                        <!-- Begin card-body -->
                        <div class="card-body">

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <!-- Begin table-responsive -->
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <button type="button" class="btn btn-organograma" data-toggle="modal" data-target="#filtro"><i class="fas fa-filter"></i></button>
                                                <button type="submit" id="btn-fechar" name="btn-fechar" disabled onclick="$('#resposta').removeAttr('required'); return confirm('Tem certeza que deseja cancelar esse chamado?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-times-circle"></i> Fechar</button>
                                                <button type="submit" id="btn-cancelar" name="btn-cancelar" disabled onclick="$('#resposta').removeAttr('required'); return confirm('Tem certeza que deseja cancelar esse chamado?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-ban"></i> Cancelar</button>
                                                <button type="submit" id="btn-excluir" name="btn-excluir" disabled onclick="$('#resposta').removeAttr('required'); return confirm('Tem certeza que deseja deletar esse chamado?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>
                                                <a href="index"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                                
                                            </div>

                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                                <th data-orderable="false" style=" width: auto;">ID</th>
                                                <th data-orderable="false" style=" width: 182px;">CNPJ</th>
                                                <th data-orderable="false" style=" width: 250px;">Empresa</th>
                                                <th data-orderable="false" style=" width: auto;">Usuário</th>
                                                <th data-orderable="false" style=" width: 200px;">Data inclusão</th>
                                                <th data-orderable="false">Tipo</th>
                                                <th data-orderable="false">Situação</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="texto-table-body chamados">
                                            <?php
                                            foreach (select_VW_CHAMADOS() as $linha) {
                                                if ($linha != 0) {

                                                    $usuario = $linha['usuario'];
                                                    $id_cha = $linha['id_cha'];
                                                    $nome_empresa = $linha['nome'];
                                                    $tipo = $linha['tipo'];
                                                    $datinc = $linha['datinc'];
                                                    $status = $linha['status'];
                                                    $cnpj = $linha['cnpj'];
                                                    $email = $linha['email'];
                                            ?>
                                                    <!-- Aberto -->
                                                    <?php if ($status == 'ABERTO') { ?>
                                                        <tr class="aberto">
                                                            <td class="coluna-checkbox"><input type="checkbox" class="checkboxAbe" name="checkbox[]" value="<?php echo $id_doc = $linha['id_cha']; ?>" title="<?php echo $id_doc ?>"></input></td>
                                                            <td style="text-align: center;"><?php echo $id_cha; ?></td>
                                                            <td style="text-align: center"><?php echo $cnpj; ?></td>
                                                            <td><span class="m-0 text-primary tamanho-text"><?php echo  $nome_empresa; ?></span></td>
                                                            <td style="text-align: center"><?php echo $usuario; ?></td>
                                                            <td style="text-align: center"><?php echo formatDate($datinc); ?></td>
                                                            <td style="text-align: center"><?php echo $tipo; ?></td>
                                                            <td style="text-align: center"><?php echo $status; ?></td>
                                                            <td style="text-align: center">
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#verificar<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#responder<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-paper-plane"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!-- Finalizados -->
                                                    <?php } elseif ($status == 'FINALIZADO') { ?>

                                                        <tr class="fechado">
                                                            <td class="coluna-checkbox"><input type="checkbox" class="checkboxFin" name="checkbox[]" value="<?php echo $id_doc = $linha['id_cha']; ?>" title="<?php echo $id_doc ?>"></input></td>
                                                            <td style="text-align: center;"><?php echo $id_cha; ?></td>
                                                            <td style="text-align: center"><?php echo $cnpj; ?></td>
                                                            <td><span class="m-0 text-primary tamanho-text"><?php echo  $nome_empresa; ?></span></td>
                                                            <td style="text-align: center"><?php echo $usuario; ?></td>
                                                            <td style="text-align: center"><?php echo formatDate($datinc); ?></td>
                                                            <td style="text-align: center"><?php echo $tipo; ?></td>
                                                            <td style="text-align: center"><?php echo $status; ?></td>
                                                            <td style="text-align: center">
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#verificar<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#responder<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-paper-plane"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!-- Cancelados -->
                                                    <?php } else { ?>

                                                        <tr class="cancelado">
                                                            <td class="coluna-checkbox"><input type="checkbox" class="checkboxCan" name="checkbox[]" value="<?php echo $id_doc = $linha['id_cha']; ?>" title="<?php echo $id_doc ?>"></input></td>
                                                            <td style="text-align: center;"><?php echo $id_cha; ?></td>
                                                            <td style="text-align: center"><?php echo $cnpj; ?></td>
                                                            <td><span class="m-0 text-primary tamanho-text"><?php echo  $nome_empresa; ?></span></td>
                                                            <td style="text-align: center"><?php echo $usuario; ?></td>
                                                            <td style="text-align: center"><?php echo formatDate($datinc); ?></td>
                                                            <td style="text-align: center"><?php echo $tipo; ?></td>
                                                            <td style="text-align: center"><?php echo $status; ?></td>
                                                            <td style="text-align: center">
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#verificar<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-primary btn-icones" type="button" data-toggle="modal" data-target="#responder<?php echo $id_cha; ?>">
                                                                    <i class="fas fa-paper-plane"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>


                                                    <!-- Modal Visualizar Mensagens -->
                                                    <div class="modal fade" id="verificar<?php echo $id_cha; ?>" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="visualizar" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 950px !important;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="TituloModalCentralizado">Chamado Número <?php echo $id_cha; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body" style="height: 70vh; overflow-y: auto">
                                                                    <?php

                                                                    foreach (select_VW_CHAMADOS_ITEM($id_cha) as $select_GESCHI) {

                                                                        $id_usa = $select_GESCHI['id_usa_inc'];

                                                                        if (!empty($select_GESCHI['usuario'])) {
                                                                    ?>
                                                                            <label for="mensagem" class="col-form-label">Mensagem de <b><?php echo $select_GESCHI['usuario']; ?></b></label>
                                                                            <div class="card">
                                                                                <div class="card-body" style="background-color:gainsboro;">
                                                                                    <?php echo $select_GESCHI['mensagem']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card" style="border: 0; text-align: right;">
                                                                                <label for="data" class="col-form-label" style="font-size: 90%;"><?php echo formatDate($select_GESCHI['datinc']); ?></label>
                                                                            </div>

                                                                        <?php } else { ?>
                                                                            <label for="mensagem" class="col-form-label">Mensagem de <b><?php echo $select_GESCHI['atendente']; ?></b></label>
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <?php echo $select_GESCHI['mensagem']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card" style="border: 0; text-align: right;">
                                                                                <label for="data" class="col-form-label" style="font-size: 90%;"><?php echo formatDate($select_GESCHI['datinc']); ?></label>
                                                                            </div>

                                                                        <?php } ?>

                                                                    <?php
                                                                    } // foreach select_GESCHI
                                                                    ?>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Responder Mensagens -->
                                                    <div class="modal fade" id="responder<?php echo $id_cha; ?>" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="aprovar" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered " role="document" style="width: 600px !important;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="aprovar">Responder Chamado</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form class="called-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                                                    <div class="modal-body text-center">


                                                                        <input type="hidden" name="id_cha" id="id_cha" value="<?php echo $id_cha; ?>">
                                                                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                                                                        <input type="hidden" name="nome_empresa" id="nome_empresa" value="<?php echo $nome_empresa; ?>">
                                                                        <input type="hidden" name="cnpj" id="cnpj" value="<?php echo $cnpj; ?>">
                                                                        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
                                                                        <input type="hidden" name="status" id="status" value="<?php echo $status; ?>">

                                                                        <textarea name="resposta" id="resposta" cols="50" rows="10" required=""></textarea>


                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                                                                        <button type="submit" id="responder_chamado" name="responder_chamado" class="btn btn-organograma"><i class="fas fa-upload"></i>
                                                                            Enviar</button>

                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Filtro -->
                                                    <div class="modal fade" id="filtro" role="dialog">
                                                        <div class="modal-dialog" role="document" style="width: 400px; position: absolute; right: 30px">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">Status</h3>
                                                                    <button type="button" class="close" data-dismiss="modal">x</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="radio1" name="radio" value="A" data-cad="ativo" class="btn1 custom-control-input">
                                                                        <label class="custom-control-label" for="radio1">Aberto</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="radio2" name="radio" value="F" data-cad="fechado" class="btn1 custom-control-input">
                                                                        <label class="custom-control-label" for="radio2">Fechado</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="radio3" name="radio" value="C" data-cad="cancelado" class="btn1 custom-control-input">
                                                                        <label class="custom-control-label" for="radio3">Cancelado</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="radio4" name="radio" value="T" data-cad="todos" class="btn1 custom-control-input">
                                                                        <label class="custom-control-label" for="radio4">Todos</label>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                            <?php
                                                } //if
                                            } //foreach select_VW_CHAMADOS
                                            ?>
                                            <!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th style=" width: auto;">ID</th>
                                                <th style=" width: 182px;">CNPJ</th>
                                                <th style=" width: 250px;">Empresa</th>
                                                <th style=" width: auto;">Usuário</th>
                                                <th style=" width: 200px;">Data inclusão</th>
                                                <th>Tipo</th>
                                                <th>Situação</th>
                                                <th>Ações</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!-- FIM TBODY E TABLE -->
                                </div>
                                <!-- End of table-responsive -->
                            </form>
                        </div>
                        <!-- End of card-body -->
                    </div>
                    <!-- End of DataTales Example -->

                </div>
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once "footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>

<!-- INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA -->

<script type="text/javascript">
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
</script>

<!-- FIM ANIMAÇÃO RÁPIDA -->

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox:not(:disabled)').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
        $("#btn-fechar").prop("disabled", cont ? false : true);
        $("#btn-cancelar").prop("disabled", cont ? false : true);
    });
</script>

<!-- INICIO - Filtro -->
<script>
    $(document).ready(function() {
        $('.fechado, .cancelado').hide();
        $('.checkboxFin, .checkboxCan').attr('disabled', true);
    });


    $('#radio1').on('click', function() {
        $('.aberto').show();
        $('.fechado, .cancelado').hide();
        $('.checkboxFin, .checkboxCan').attr('disabled', true);
        $('.checkboxAbe').attr('disabled', false);
    });
    $('#radio2').on('click', function() {
        $('.aberto, .cancelado').hide();
        $('.fechado').show();
        $('.checkboxAbe, .checkboxCan').attr('disabled', true);
        $('.checkboxFin').attr('disabled', false);
    });
    $('#radio3').on('click', function() {
        $('.aberto, .fechado').hide();
        $('.cancelado').show();
        $('.checkboxFin, .checkboxAbe').attr('disabled', true);
        $('.checkboxCan').attr('disabled', false);
    });
    $('#radio4').on('click', function() {
        $('.aberto, .fechado, .cancelado').show();
        $('.checkboxAbe, .checkboxFin, .checkboxCan').attr('disabled', false);
    });
</script>
<!-- FIM - Filtro -->

<?php

function formatDate($data)
{

    $format1 = explode(' ', $data);
    $format2 = explode('-', $format1[0]);
    $format3 = $format2[2] . '/' . $format2[1] . '/' . $format2[0];
    $format4 = $format3 . ' ' . $format1[1];

    return $format4;
}

// Resposta do Chamado
if (isset($_REQUEST['responder_chamado'])) {

    // echo "Entrou no if";

    if ($_POST["status"] == 'ABERTO') {

        try {

            $id_cha_ori = $_POST["id_cha"];
            $id_usa_default = $_POST["id_usa"];
            $chamado = $_POST["resposta"];
            $chamado = preg_replace('/\s\n/', '<br>', $chamado);

            $nome_email = $_POST["usuario"];
            $email_email = $_POST["email"];
            $empresa_email = $_POST["nome_empresa"];
            $cnpj_email = $_POST["cnpj"];

            try {

                insertGESCHI(mb_strtoupper($chamado, 'UTF-8'), $id_cha_ori, $id_mas, NULL, $today);
            } catch (PDOException $erro) {

                die(($_SESSION['erro_importação'] = '0 - ' . $erro) . (header('Location: erro/erro_1')));
            }

            require "email_resposta_chamado.php";

            echo "<script language=javascript> 
                    Swal.fire({
                        icon: 'success',
                        title: 'Enviado com sucesso!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        location.href='chamado';
                        }
                    })
                    </script>";
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    } else {

        echo "<script language=javascript> 
        Swal.fire({
            icon: 'error',
            title: 'Chamado deve estar Aberto para resposta!'
        }).then((result) => {
            if (result.isConfirmed) {
              location.href='chamado';
            }
          })
        </script>";
    }
}

// Botão excluir
if (isset($_REQUEST['btn-excluir'])) {
    try {
        //echo "entrou try";

        $id_cha_delete;

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $s = [];
            foreach ($_POST as $chave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $ch => $va) {
                        if ($va != 'on') {
                            //echo 'Valor de $VA: ' . $va.',';
                            $id_cha_delete = $id_cha_delete . $va . ',';
                        }
                    }
                }
            }
        }

        $id_cha_delete = substr($id_cha_delete, 0, -1);
        $resultArr = explode(',', $id_cha_delete);

        // echo 'id_cha_delete: ' . $id_cha_delete . '<br>';
        // var_dump($resultArr);


        switch (deleteGESCHA_in($resultArr)) {
            case 1: //delete executado
                echo "<script language=javascript>
                alert('Chamado(s) excluido com sucesso!');
                location.href='chamado';
                </script>";
                //echo 'entrei caso 1';
                break;
            default:
                echo "<script language=javascript>
                alert('Erro desconhecido, consultar tabela de códigos!');
                location.href='chamado';
                </script>";
                //echo 'entrei default';
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['btn-fechar'])) {

    try {
        // echo "entrou try";

        $id_cha_fechar;

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $s = [];
            foreach ($_POST as $chave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $ch => $va) {
                        if ($va != 'on') {
                            //echo 'Valor de $VA: ' . $va.',';
                            $id_cha_fechar = $id_cha_fechar . $va . ',';
                        }
                    }
                }
            }
        }

        $id_cha_fechar = substr($id_cha_fechar, 0, -1);
        $resultArr = explode(',', $id_cha_fechar);
        $tipo = "'F'";

        // echo 'id_cha_fechar: ' . $id_cha_fechar . '<br>';
        // var_dump($resultArr);
        // echo '<br>Tipo: ' . $tipo . '<br>';


        switch (updateGESCHA_in($resultArr, $tipo)) {
            case 1: //delete executado
                echo "<script language=javascript> 
                Swal.fire({
                    icon: 'success',
                    title: 'Finalizado com sucesso!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='chamado';
                    }
                  })
                </script>";
                //echo 'entrei caso 1';
                break;
            default:
                echo "<script language=javascript>
                alert('Erro desconhecido, consultar tabela de códigos!');
                location.href='chamado';
                </script>";
                //echo 'entrei default';
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['btn-cancelar'])) {
    try {
        // echo "entrou try";

        $id_cha_cancelar;

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $s = [];
            foreach ($_POST as $chave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $ch => $va) {
                        if ($va != 'on') {
                            //echo 'Valor de $VA: ' . $va.',';
                            $id_cha_cancelar = $id_cha_cancelar . $va . ',';
                        }
                    }
                }
            }
        }

        $id_cha_cancelar = substr($id_cha_cancelar, 0, -1);
        $resultArr = explode(',', $id_cha_cancelar);
        $tipo = "'C'";

        // echo 'id_cha_cancelar: ' . $id_cha_cancelar . '<br>';
        // var_dump($resultArr);


        switch (updateGESCHA_in($resultArr, $tipo)) {
            case 1: //delete executado
                echo "<script language=javascript> 
                Swal.fire({
                    icon: 'success',
                    title: 'Cancelado com sucesso!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='chamado';
                    }
                  })
                </script>";
                //echo 'entrei caso 1';
                break;
            default:
                echo "<script language=javascript>
                alert('Erro desconhecido, consultar tabela de códigos!');
                location.href='chamado';
                </script>";
                //echo 'entrei default';
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
