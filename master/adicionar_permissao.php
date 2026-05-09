<?php

require_once 'restrito.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

//Verifica se id_usa e nome_usa foi postado
if (isset($_POST["id_usa"]) && isset($_POST["nome_usa"]) ) {
    $id_usa_selecionado = $_POST["id_usa"];
    $nome_usa_selecionado = $_POST["nome_usa"];
    $id_emp_selecionado = $_POST["id_emp_selecionado"];
    $nome_emp_selecionado = $_POST["id_emp_selecionado"] . ' - ' . $_POST["nome_emp_selecionado"];

    $_SESSION["id_usa_selecionado"] = $id_usa_selecionado;
    $_SESSION["nome_usa_selecionado"] = $nome_usa_selecionado;
    $_SESSION["id_emp_selecionado"] = $id_emp_selecionado;
    $_SESSION["nome_emp_selecionado"] = $nome_emp_selecionado;
}

//Atribui as variaveis locais, o valor da variaveis de sessão 
$id_usa_selecionado = $_SESSION["id_usa_selecionado"];
$nome_usa_selecionado = $_SESSION["nome_usa_selecionado"];
$id_emp_selecionado = $_SESSION["id_emp_selecionado"];
$nome_emp_selecionado = $_SESSION["nome_emp_selecionado"];

//Contar menus do usuario para empresa selecionada
foreach (selectCOUNT_GESMNU($id_usa_selecionado, $id_emp_selecionado) as $count_gesmnu) {
    $contagem = $count_gesmnu["contagem"];
}

//Se contagem diferente de zero, executar insert em GESMPR de todos menus que estão faltando.
//Menus na lista padrão entram já com situac=1 (liberados); demais entram com situac=0.
$menus_padrao = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 20, 21, 22, 23, 31, 32, 33, 37, 57];
if ($contagem != 0) {
    foreach (select_TELAS_INSERT($id_usa_selecionado, $id_emp_selecionado) as $telas_insert) {
        $id_mnu_atual = (int) $telas_insert["id_mnu"];
        $situac_default = in_array($id_mnu_atual, $menus_padrao, true) ? 1 : 0;
        insertGESMNU_add($id_usa_selecionado, $id_emp_selecionado, $id_mnu_atual, $datatu, $situac_default);
    }
}

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

    <title>GESTOU PORTAL - Adicionar/remover acesso</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Adicionar/remover acesso <?php echo ' - empresa selecionada: ' . $nome_emp_selecionado; ?></h5>
                            <h6>ID usuário: <?php echo $id_usa_selecionado . ' - ' . 'Nome: ' . $nome_usa_selecionado ?></h6>

                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">
                                            <button type="button" class="btn btn-organograma" title="Clique para alterar o contexto" data-toggle="modal" data-target="#filtro"><i class="fas fa-filter"></i> Empresa</button>
                                            <a href="tabela_permissao"><button type="button" title="Clique para voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                        </div>

                                        <tr>
                                            <th class="text-left coluna-nome">Ordem</th>    
                                            <th data-orderable="false" class="coluna-nome text-left">Descrição</th>
                                            <th class="text-left coluna-nome">Id menu</th>    
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Liberado</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-left" width="10%">Ordem</th>
                                            <th class="text-left" width="70%">Descrição</th>
                                            <th class="text-left" width="10%">Id menu</th>
                                            <th class="text-center" width="10%">Liberado</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                        foreach (selectTELAS_USUARIO($id_usa_selecionado, $id_emp_selecionado) as $linha) {
                                            if ($linha != 0) {
                                                $s_id_emp = $linha['id_emp'];
                                                $s_id_usa = $linha['id_usa'];
                                                $s_id_mnu = $linha['id_mnu'];
                                                $s_descri = $linha['caminho'];
                                                $s_ordem = $linha['ordem'];
                                                $s_estagio = $linha['estagio'];
                                                $s_situac = $linha['situac'];
                                                $s_id_mpr = $linha['id_mpr'];

                                        ?>

                                                <tr>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text text-center"><?php echo $s_ordem ; ?></span>    
                                                    </td>
                                                    <td>
                                                        <span class="m-0 text-primary tamanho-text"><?php echo $s_descri ; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-primary tamanho-text text-center"><?php echo $s_id_mnu ; ?></span>    
                                                    </td>
                                                    <?php
                                                    if ($s_situac == 1) {
                                                        echo '<td style="text-align: center"><input type="checkbox" class="teste" id="' . $linha['id_mpr'] . '" id_mpr="' . $linha['id_mpr'] . '" name="checkbox[]" checked></td>';
                                                    } else {
                                                        echo '<td style="text-align: center"><input type="checkbox" class="teste" id="' . $linha['id_mpr'] . '" id_mpr="' . $linha['id_mpr'] . '" name="checkbox[]" ></td>';
                                                    }
                                                    ?>
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
                    </div>
                </div>
            </div>

            <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Liberação de Telas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <span id="visuTela"></span>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="submit" name="btn-liberar" class="btn btn-organograma">Liberar</button> -->
                            <button type="button" id="fechar-modal" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Filtro -->
            <div class="modal fade" id="filtro" role="dialog">
                <div class="modal-dialog" role="document" style="width: 600px; position: absolute; right: 30px">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3 class="modal-title">Selecionar empresa</h3>
                            <button type="button" class="close" data-dismiss="modal">x</button>
                        </div>

                        <div class="modal-body">
                          <div class="form-row">             
                            <div class="col-md-12 mb-5">
                                <label for="empresa">Alterar contexto:</label>
                                    <select class="form-control" id="empresa" name="empresa">
                                        <?php
                                            foreach (selectGESEMP_ALL() as $linha) {
                                                ?>
                                                <option value="<?php echo $linha['id_emp']; ?>" <?php if ($linha['id_emp'] == $id_emp_selecionado) {
                                                    echo 'selected';
                                                  } ?>><?php echo $linha['id_emp'] . ' - '. $linha['nome']; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Inválido!
                                    </div>
                                </div>
                                <div class="col-md-13 mb-5">
                                    <button class="btn btn-secondary" id="btn-selec_emp" type="button">Definir empresa</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                        </div>

                    </div>
                </div>
            </div>


            <!-- ---------------------------------------------------------------------------------------------------------------------->
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

</body>

</html>

<script>
    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.view_data', function() {
            var id_recebido = $(this).attr("id_usa");
            // alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
                var dados = {
                    id_recebido: id_recebido
                };
                $.post('visualizar_telas_usuario.php', dados, function(retorna) {
                    //alert(retorna);
                    //Carregar o conteudo para o usuário
                    $("#visuTela").html(retorna);
                    $('#visuModal').modal('show');

                    $(document).on('hidden.bs.modal', '#visuModal', function() {

                        window.location.reload();

                    });

                });
            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.teste', function() {
            var id_mpr = $(this).attr("id_mpr");

            let checkbox = document.getElementById(id_mpr);
            if (checkbox.checked) {
                situac = 1;
            } else {
                situac = 0;
            }

            if (id_mpr !== '') {
                var dados = {
                    id_mpr: id_mpr,
                    situac: situac
                };
                $.post('adicionar_permissao.php', dados, function(retorna) {
                });
            }
        });
    });

    $('#btn-selec_emp').on('click', function() {
        var index = document.getElementById('empresa').selectedIndex;
        var id_emp_selecionado = document.getElementsByTagName("option")[index].value;
        var nome_emp_selecionado = document.getElementsByTagName("option")[index].text;
        if (id_emp_selecionado !== '') {
            var dados = {
                id_emp_selecionado: id_emp_selecionado,
                nome_emp_selecionado: nome_emp_selecionado
            }
        };
        // alert(dados.id_emp_selecionado);
        $.post('adicionar_permissao', dados, function(retorna) {
              location.href = "adicionar_permissao";
        });        
    });


</script>

<?php

if ((isset($_POST["id_emp_selecionado"]))) {
    $id_emp_selecionado = $_POST["id_emp_selecionado"];
    $nome_emp_selecionado = $_POST["nome_emp_selecionado"];
    $_SESSION["id_emp_selecionado"] = $id_emp_selecionado;
    $_SESSION["nome_emp_selecionado"] = $nome_emp_selecionado;
}


if (isset($_POST["id_mpr"]) && isset($_POST["situac"])) {
    $id_mpr = $_POST["id_mpr"];
    $situac = $_POST["situac"];
    updateGESMPR($situac, $id_mpr);
}

// if (isset($_REQUEST['btn-liberar'])) {
//     try {
//         echo "entrou try";
//         require_once __DIR__.'/../config/database.php';

//         $id_mpr;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_mpr = $id_mpr . $va . ',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_mpr = substr($id_mpr, 0, -1);
//             $resultArr = explode(',', $id_mpr);

//             switch (deleteGESUSU_in($resultArr)) {
//                 case 1: //delete executado
//                     echo "<script language=javascript>
//                     alert('Registro(s) excluido com sucesso!');
//                     location.href='tabela_usuarios';
//                     </script>";
//                     break;
//                 case 23503: //erro fk
//                     echo "<script language=javascript>
//                     alert('O(s) Registro(s) selecionados tem vínculo com outra tabela!');
//                     location.href='tabela_usuarios';
//                     </script>";
//                     break;
//                 default:
//                     echo "<script language=javascript>
//                     alert('Erro desconhecido, consultar tabela de códigos!');
//                     location.href='tabela_usuarios';
//                     </script>";
//             }
//         } else {
//         }
//     } catch (PDOException $erro) {
//         echo $erro->getMessage();
//     }
// }

?>