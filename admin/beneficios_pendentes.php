<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Benefícios pendentes</h6>
                        </div>
                        <div class="card-body">
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead>
                                            <div class="col-sm-12 button-tabela">

                                                <button type="submit" name="btn-voltar" data-toggle="tooltip" title="Voltar para benefícios enviados" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-undo-alt"></i> Voltar</button>


                                                <!-- <span><h1>REGISTROS</h1></span> -->
                                                <!-- </form> -->
                                            </div>
                                            <tr>
                                                <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false">Competência</th>
                                                <th data-orderable="false">Descrição</th>
                                                <th data-orderable="false">Vencimentos</th>
                                                <th data-orderable="false">Descontos</th>
                                                <th data-orderable="false">Liquido</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click textalign-center">Visualizar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th class="coluna-nome">Nome</th>
                                                <th>Competência</th>
                                                <th>Descrição</th>
                                                <th>Vencimentos</th>
                                                <th>Descontos</th>
                                                <th>Liquido</th>
                                                <th style="text-align: center;">Visualizar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody class="texto-table-body">
                                            <?php foreach (selectRECIBO_PAGAMENTO($raiz_cnpj, 2) as $linha) {  //Passar o parâmetro 2 para filtrar o status pendente do GESIM1_raiz
                    if ($linha == 0) {
                    } else {
                        ?>

                                                    <tr>
                                                        <td class="coluna-checkbox"><input type="checkbox" name="checkbox[]" value="<?php echo $id_im1 = $linha['id_im1']; ?>"></input></td>
                                                        <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span> <br><?php echo $linha['cargo']; ?></td>
                                                        <td><?php echo $linha['competencia']; ?></td>
                                                        <td><?php echo $linha['descricao']; ?></td>
                                                        <td class="linha-valores"><?php echo $linha['vlr_vencimento']; ?></td>
                                                        <td class="linha-valores"><?php echo $linha['vlr_desconto']; ?></td>
                                                        <td class="linha-valores"><?php echo $linha['vlr_liquido']; ?></td>
                                                        <td style="text-align: center;">

                                                            <?php if ($contagem_eventos > 0) { ?>
                                                                <!-- <a href="" onclick="alert('Ainda há eventos pendentes, não é possível visualizar os dados!');return false;"> <img src="img/visualizar.png" height="15" width="25" title="Visualizar"></img> </a>  -->
                                                                <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo 'NULL'; ?>">Detalhe</button>

                                                            <?php } else { ?>
                                                                <!-- <a href="view_itens_holerite_aceite.php?al=<?php echo $linha['id_im1']; ?>" target="_blank"> <img src="img/visualizar.png" height="15" width="25" title="Visualizar"></img> </a> -->
                                                                <button type="button" class="btn btn-outline-primary view_data" id_im1="<?php echo $id_detalhar = $linha['id_im1']; ?>">Detalhe</button>
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
                                            $sql_eventos = 'SELECT * FROM public."GESEVE" where id_emp = '.$idemp.'';
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

                                                $verifica_tipo = 'SELECT tipo FROM public."GESEVE" where id_emp = '.$idemp.' and id_eve='.$id_eve.' and tipo= '.$tipo.' ';
                                                $result_tipo = pg_exec($conn, $verifica_tipo);
                                                $numero_linha = pg_num_rows($result_tipo);

                                                if ($numero_linha == 1) {
                                                    ?>
                                                                <option value="P" style="color: yellow;" selected>PENDENTE</option>
                                                                <option value="V" style="color: blue">VENCIMENTO</option>
                                                                <option value="D" style="color: red">DESCONTO</option>

                                                                <?php
                                                } else {
                                                    $verifica_tipo1 = 'SELECT * FROM public."VW_EVENTOS" where id_eve='.$id_eve.' and id_emp ='.$idemp.'';
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
</script>

<?php

if (isset($_REQUEST['btn-excluir'])) {
    echo '<br>entrou no excluir';
    try {
        require_once __DIR__.'/../config/database.php';

        $id_GESIM1;

        if (0 == 0) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                $s = [];
                foreach ($_POST as $chave => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $ch => $va) {
                            if ($va != 'on') {
                                // echo $va.',';
                                $id_GESIM1 = $id_GESIM1.$va.',';
                                // echo $id_im1;
                            }
                        }
                    }
                }
            }

            $GESIM1 = substr($id_GESIM1, 0, -1);
            $resultArr = explode(',', $GESIM1);

            $tabela = 'public."GESIM1_'.$raiz_cnpj.'"';

            deleteGESIM1_in($resultArr, $tabela);

            echo "<script language=javascript>
 alert('Registro(s) excluido com sucesso!');
 location.href='tabela_recibo_pagamento';
 </script>";
        } else {
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['btn-salvar'])) {
    require_once __DIR__.'/../config/database.php';

    $sql_eventos3 = 'SELECT * FROM public."GESEVE" where id_emp = '.$idemp.' ';
    $res_eventos3 = pg_exec($conn, $sql_eventos3);

    while ($row_eventos3 = pg_fetch_assoc($res_eventos3)) {
        require_once __DIR__.'/../config/database.php';
        $nomeevento = "'".$_REQUEST['comboEvento']."'";
        $codevento = "'".$_REQUEST['Evento']."'";

        // echo 'ENTROU WHILE' . '<br>';
        // echo 'id=' . $row_eventos3['id_eve'] . '<br>';
        // echo 'nomeevento' . $nomeevento . '<br>';
        // echo 'codevento' . $codevento . '<br>';

        $query4 = 'UPDATE public."GESEVE"  SET tipo =  '.$nomeevento.' WHERE id_eve='.$row_eventos3['id_eve'].'';
        pg_query($conn, $query4)
            or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');
    }
}

if (isset($_REQUEST['btn-visualizar'])) {
    echo "<script language=javascript>
    location.href='periodos_processados';
    </script>";
}

if (isset($_REQUEST['btn-voltar'])) {
    echo "<script language=javascript>
    location.href='beneficios_enviados';
    </script>";
}

?>

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
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (id_recebido !== '') {
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
        });
    });
</script>