<?php

require_once 'restrito.php';
require_once 'conexao.php';
require_once 'util.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

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
                            <h6 class="m-0 font-weight-bold text-primary">Espelho de Ponto</h6>
                        </div>
                        <div class="card-body">
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead>
                                            <div class="col-sm-12 button-tabela">

                                                <button type="submit" name="btn-processar" data-toggle="tooltip" title="Processar espelho de ponto" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-cog"></i> Processar</button>
                                                <button type="submit" id="btn-excluir" name="btn-excluir" data-toggle="tooltip" title="Excluir espelho de ponto" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-ban"></i> Excluir</button>
                                                <!-- <button type="submit" id="btn-visualizar" name="btn-visualizar" data-toggle="tooltip" title="Lotes processados" class="btn btn-primary btn-icon-split-organograma"><i class="fas fa-eye"></i> Lotes</button> -->
                                                <button type="submit" id="btn-enviados" name="btn-enviados" data-toggle="tooltip" title="Espelho de Ponto enviados" class="btn btn-primary btn-icon-split-organograma"><i class="fas fa-eye"></i> Enviados</button>
                                            


                                                <!-- <span><h1>REGISTROS</h1></span> -->
                                                <!-- </form> -->
                                            </div>
                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false" style="width:20%">Periodo</th>
                                                <th data-orderable="false" style="width:10%">Total</th>
                                                <th data-orderable="false" style="width:10%">Saldo</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:15%">Visualizar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>Periodo</th>
                                                <th>Total</th>
                                                <th>Saldo</th>
                                                <th style="text-align: center;">Visualizar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="texto-table-body">
                                            <?php foreach (selectESPELHO_PONTO($raiz_cnpj, 0) as $linha) { // Passar o parâmetro 1 para filtrar o status do GESIM1_raiz
                    if ($linha == 0) {
                    } else {
                        ?>
                                                    <tr>
                                                        <td class="coluna-checkbox"><input type="checkbox" name="checkbox[]" value="<?php echo $id_pon1 = $linha['id_pon1']; ?>"></input></td>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['funcao']; ?></td>
                                                        <td><?php echo $linha['periodo']; ?></td>
                                                        <td style="text-align: center;"><?php echo $linha['btotal']; ?></td>
                                                        <td style="text-align: center;"><?php echo $linha['bsaldo']; ?></td>
                                                        <td style="text-align: center;">

                                                            <?php if ($contagem_eventos > 0) { ?>
                                                                <button type="button" class="btn btn-outline-primary view_data_pendente" id_pon1="<?php echo 'NULL'; ?>">Detalhe</button>

                                                            <?php } else { ?>
                                                                <!-- <a href="view_itens_holerite_aceite.php?al=<?php echo $linha['id_pon1']; ?>"
                                                                 target="_blank"> <img src="img/visualizar.png" height="15" width="25" title="Visualizar"></img> </a> -->
                                                                <button type="button" class="btn btn-outline-primary view_data" id_pon1="<?php echo $id_detalhar = $linha['id_pon1']; ?>">Detalhe</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>

                                            <?php
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
  
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; LFP Serviços 2021</span>
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
</script>

<?php

if (isset($_REQUEST['btn-excluir'])) {
    try {
        require 'conexao.php';

        $id_GESPON1;

        if (0 == 0) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                $s = [];
                foreach ($_POST as $chave => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $ch => $va) {
                            if ($va != 'on') {
                                // echo $va.',';
                                $id_GESPON1 = $id_GESPON1.$va.',';
                                // echo $id_im1;
                            }
                        }
                    }
                }
            }

            $GESPON1 = substr($id_GESPON1, 0, -1);
            $resultArr = explode(',', $GESPON1);
            $tabela = 'public."GESPON1_'.$raiz_cnpj.'"';

            deleteGESPON1_in($resultArr, $tabela);
            echo "<script language=javascript>
 alert('Registro(s) excluido com sucesso!');
 location.href='tabela_espelho_ponto';
 </script>";
        } else {
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['btn-visualizar'])) {
    echo "<script language=javascript>
    location.href='periodos_processados';
    </script>";
}

if (isset($_REQUEST['btn-enviados'])) {
    echo "<script language=javascript>
    location.href='pontos_enviados';
    </script>";
}

if (isset($_REQUEST['btn-processar'])) {
    try {
        require 'conexao.php';
        try {
            require 'conexao.php';

            $id_GESPON1;

            if (0 == 0) {
                if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                    $s = [];
                    foreach ($_POST as $chave => $valor) {
                        if (is_array($valor)) {
                            foreach ($valor as $ch => $va) {
                                if ($va != 'on') {
                                    // echo $va.',';
                                    $id_GESPON1 = $id_GESPON1.$va.',';
                                    // echo $id_pon1;
                                }
                            }
                        }
                    }
                }

                $GESPON1 = substr($id_GESPON1, 0, -1);
                $resultArr = explode(',', $GESPON1);

                $tabela = 'public."GESPON1_'.$raiz_cnpj.'"';
                $situac = 2; //atualiza situac para 2

                updateGESPON1_in($resultArr, $tabela, $situac);

                echo "<script language=javascript>
        alert('Registro(s) atualizado(s) com sucesso!');
        location.href='tabela_espelho_ponto';
        </script>";
            } else {
            }
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>
    
<div id="visuDetalheModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="padding-right: 0px">
       
    <div class="modal-content" style ="border: 100px solid rgba(0, 0, 0, 0);">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Itens Espelho de Ponto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="line-height: 0.75;">
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
            var id_recebido = $(this).attr("id_pon1");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
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
        });
    });
</script>