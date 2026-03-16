<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
//require_once 'raiz_cnpj_pdo.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

$tabela1 = 'public."GESIM1_' . $raiz_cnpj . '"';

// if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST') {

//     $s = array();
//     foreach ($_POST as $chave => $valor) {
//       if(is_array($valor)) {
//           echo 'Chave: ' . $chave . ' Valores:<br />';
//           foreach($valor as $ch=>$va){
//               echo 'Chave: ' . $ch . ' | Valor: ' . $va . '<br />';
//           }
//           echo '<br />';
//       } else {
//           echo 'Chave: ' . $chave . ' | Valor: ' . $valor . '<br />';
//       }
//     }

// }

unset($_SESSION["id_emp_master"]); // reset variavel de sessao para limpar o valor caso tenha editado uma empresa antes

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
                        <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastro Menus</h6>
                        </div>
                        <div class="card-body">

                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead style="text-align: center;">

                                            <div class="col-sm-12 button-tabela">

                                                <a href="cadastro_menu"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button></a>
                                                <button type="submit" id="btn-excluir" name="btn-excluir" disabled onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>
                                                <a href="index"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>

                                            </div>

                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                                <th data-orderable="false" class="coluna-nome">Descrição</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Icone</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Link</th>
                                                <th data-orderable="false">Target</th>
                                                <th data-orderable="false">Nivel</th>
                                                <th data-orderable="false">Ordem</th>
                                                <th data-orderable="false">Estagio</th>
                                                <th data-orderable="false">Caminho</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th class="coluna-nome">Descrição</th>
                                                <th>Icone</th>
                                                <th>Link</th>
                                                <th>Target</th>
                                                <th>Nivel</th>
                                                <th>Ordem</th>
                                                <th>Estagio</th>
                                                <th>Caminho</th>
                                                <th>Ações</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <?php

                                            foreach (select_GESMNU_ALL() as $linha) {
                                                if ($linha != 0) {
                                            ?>

                                                    <tr>
                                                        <td class="coluna-checkbox"><input type="checkbox" name="checkbox[]" value="<?php echo $id_emp = $linha['id_mnu']; ?>" title="<?php echo $id_emp ?>"></input></td>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo  $linha['descri']; ?></span>
                                                        </td>
                                                        <td style="text-align: center"><?php echo '<i class ="' . $linha['icone'] . '"></i>'; ?></td>
                                                        <td><?php echo $linha['link']; ?></td>
                                                        <td><?php echo $linha['target']; ?></td>
                                                        <td><?php echo $linha['nivel']; ?></td>
                                                        <td><?php echo $linha['ordem']; ?></td>
                                                        <td><?php echo $linha['estagio']; ?></td>
                                                        <td><?php echo $linha['caminho']; ?></td>
                                                        <td style="text-align: center">
                                                            <button type="button" id="btn-editar" class="btn btn-primary btn-icones" id_mnu="<?php echo $linha['id_mnu']; ?>" title="Editar">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
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
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------------------->
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Leve Inovação Estratégica Ltda — CNPJ 53.094.687/0001-38 — <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
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

</body>

</html>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#btn-editar', function() {

            var btn_editar = $(this).attr("id_mnu");

            if (btn_editar !== '') {

                var dados = {

                    btn_editar: btn_editar
                };

                $.post('tabela_menus.php', dados, function() {

                    location.href = "alterar_menu";
                });
            }
        });
    });
</script>

<?php

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS
if (isset($_POST['btn_editar'])) {

    // VÁRIAVEL PARA LISTAR OS DADOS DO USUARIO NA PÁGINA ALTERAR MENU
    $_SESSION['editar_id_mnu'] = $_POST['btn_editar'];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST['de'])) {
    try {

        $situac = 0;
        $id_emp = $_REQUEST["de"];
        $id_usa_atu = $_SESSION['id_usa'];

        updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

        echo "<script language=javascript>
        location.href = 'tabela_empresas';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['ha'])) {
    try {
        $situac = 1;
        $id_emp = $_REQUEST["ha"];
        $id_usa_atu = $_SESSION['id_usa'];

        updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp);

        echo "<script language=javascript>
        location.href = 'tabela_empresas';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_REQUEST['btn-excluir'])) {
    try {
        echo "entrou try";
        require_once __DIR__.'/../config/database.php';

        $id_mnu;

        if (0 == 0) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                $s = [];
                foreach ($_POST as $chave => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $ch => $va) {
                            if ($va != 'on') {
                                // echo $va.',';
                                $id_mnu = $id_mnu . $va . ',';
                            }
                        }
                    }
                }
            }

            $id_mnu = substr($id_mnu, 0, -1);
            $resultArr = explode(',', $id_mnu);

            switch (deleteGESMNU_in($resultArr)) {
                case 1: //delete executado
                    echo "<script language=javascript>
                    alert('Registro(s) excluido com sucesso!');
                    location.href='tabela_menus';
                    </script>";
                    break;
                case 23503: //erro fk
                    echo "<script language=javascript>
                    alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
                    location.href='tabela_menus';
                    </script>";
                    break;
                default:
                    echo "<script language=javascript>
                    alert('Erro desconhecido, consultar tabela de códigos!');
                    location.href='tabela_menus';
                    </script>";
            }
        } else {
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>