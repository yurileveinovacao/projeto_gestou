<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$id_emp_default = $_SESSION['id_emp_default'];

// $tabela1 = 'public."GESIM1_'.$raiz_cnpj.'"';

// $_SESSION["descricao"] = null;

//envia variavel para SESSION
$_SESSION['controleModal'] = 1;

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
                            <h6 class="m-0 font-weight-bold text-primary">Recibos de Pagamento</h6>
                        </div>
                        <div class="card-body">
                        <!-- <button type="button" class="btn btn-outline-primary view_eventos" >Eventos novo</button> -->
                            <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                method="POST">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <div class="col-sm-12 button-tabela">
                                                <!-- <a href="tabela_eventos"> -->
                                                    <button type="button" name="btn-eventos" class="btn btn-organograma btn-icon-split-organograma view_eventos"><i class="fas fa-clipboard"></i> Eventos <?php $idemp = $_SESSION['id_emp_default'];
                                            $tipo = "'P'";

$consulta_eventos = 'SELECT count(id_eve) as contagem FROM public."GESEVE" where id_emp = '.$idemp.' and tipo='.$tipo.' ';
$resultado_eventos = pg_exec($conn, $consulta_eventos);
$linha_eventos = pg_fetch_assoc($resultado_eventos);
$contagem_eventos = $linha_eventos['contagem'];
if ($contagem_eventos > 0) {
    ?>
                                                        <span
                                                            class="badge badge-primary badge-counter"><?php echo $contagem_eventos; ?></span>
                                                        <?php
} ?>
                                                    </button>
                                                <!-- </a> -->
                                                    
                                                <button type="submit" id="btn-processar" name="btn-processar"
                                                    class="btn btn-organograma btn-icon-split-organograma"
                                                    onclick="return confirm('Deseja processar o(s) item(s) selecionado(s)? \n(Depois confirmada a ação o registro ficará disponível em Aceite Benefícios!)'); return false;"
                                                    disabled><i class="fas fa-cog"></i> Processar</button>

                                                <button type="submit" id="btn-excluir" name="btn-excluir"
                                                onclick="return confirm('Deseja excluir o(s) item(s) selecionado(s)?'); return false;"
                                                    class="btn btn-organograma btn-icon-split-organograma" disabled><i
                                                        class="fas fa-trash-alt"></i> Excluir</button>


                                                <!-- <span><h1>REGISTROS</h1></span> -->
                                                <!-- </form> -->
                                            </div>
                                            <tr>
                                                <th data-orderable="false"
                                                    class="sorttable_nosort nao_click coluna-checkbox"><input
                                                        id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                                <th data-orderable="false">Competência</th>
                                                <th data-orderable="false">Descrição</th>
                                                <th data-orderable="false">Vencimentos</th>
                                                <th data-orderable="false">Descontos</th>
                                                <th data-orderable="false">Liquido</th>
                                                <th data-orderable="false"
                                                    class="sorttable_nosort nao_click textalign-center">Visualizar</th>
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
                                            <?php foreach (selectRECIBO_PAGAMENTO($raiz_cnpj, 0) as $linha) { if($linha != 0 ){?>
                                            <tr>
                                                <td class="coluna-checkbox"><input type="checkbox" name="checkbox[]"
                                                        value="<?php echo $id_im1 = $linha['id_im1']; ?>"></input></td>
                                                <td><span
                                                        class="m-0 text-primary tamanho-text"><?php  echo $linha['nome']; ?></span>
                                                    <br><?php  echo $linha['cargo']; ?></td>
                                                <td><?php  echo $linha['competencia']; ?></td>
                                                <td><?php  echo $linha['descricao']; ?></td>
                                                <td class="linha-valores"><?php  echo $linha['vlr_vencimento']; ?></td>
                                                <td class="linha-valores"><?php  echo $linha['vlr_desconto']; ?></td>
                                                <td class="linha-valores"><?php  echo $linha['vlr_liquido']; ?></td>
                                                <td style="text-align: center;">

                                                    <?php if ($contagem_eventos > 0) { ?>
                                                        <!-- <a href="" onclick="alert('Ainda há eventos pendentes, não é possível visualizar os dados!');return false;"><img src="img/visualizar.png" height="15" width="25" title="Visualizar"></img> </a> -->
                                                        <button type="button" class="btn btn-outline-primary view_data_pendente" id_im1="<?php echo "NULL"; ?>">Detalhe</button>
                                                    <?php } else { ?>
                                                        <!--<a href="view_itens_holerite.php?al=?php echo $linha['id_im1']; ?>"><img src="img/visualizar.png" height="15" width="25"title="Visualizar"></img> </a> -->
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

<div id="visuAcaoModalEvento" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">Definição dos eventos</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <span id="visuAcaoEvento"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div id="visuAcaoModalEvento2" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title font-weight-bold text-primary" id="exampleModalLabel">Definição dos eventos2</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <span id="visuAcaoEvento2"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<script>
    $("#checkTodos").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function () {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });
    
    $("[name='checkbox[]']").click(function () {
        var cont = $("[name='checkbox[]']:checked").length;
        $("#btn-processar").prop("disabled", cont ? false : true);
    });

  //Clique do botão detalhe quando existirem eventos pendentes
  $(document).ready(function(){
    $(document).on('click','.view_data_pendente',function(){
        alert('Ainda há eventos pendentes, não é possível visualizar os dados!');
    }) 
   })

   //Clique do botão detalhe quando não existirem eventos pendentes
   $(document).ready(function(){
       $(document).on('click','.view_data',function(){
           var id_recebido = $(this).attr("id_im1");
           //alert(id_recebido);
           //verificar se há calor na variavel "id_recebido".
           if(id_recebido !== ''){
               var dados = {
                id_recebido: id_recebido
               };
               $.post('visualizar_recibo_pagamento.php', dados, function(retorna){
                //alert(retorna);
                //Carregar o conteudo para o usuário
                $("#visuDetalheHolerite").html(retorna);
                $('#visuDetalheModal').modal('show');

               });
           }
       });
   }); 

   //Clique do botao eventos novo - 06/01/2022 - 09:56
   $(document).ready(function(){
       $(document).on('click','.view_eventos',function(){
         //estou enviando null no segundo parametro do post porque nao passo id especifico para pesquisar
        $.post('visualizar_acao_eventos.php', null , function(retorna){
            //alert(retorna);
            $("#visuAcaoEvento").html(retorna);
            $('#visuAcaoModalEvento').modal('show');
            });
        });
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
 location.href='tabela_recibo_pagamento.php';
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

        echo 'ENTROU WHILE'.'<br>';
        echo 'id='.$row_eventos3['id_eve'].'<br>';
        echo 'nomeevento'.$nomeevento.'<br>';
        echo 'codevento'.$codevento.'<br>';

        $query4 = 'UPDATE public."GESEVE"  SET tipo =  '.$nomeevento.' WHERE id_eve='.$row_eventos3['id_eve'].'';
        pg_query($conn, $query4)
                or die('Encountered an error when executing given sql statement: '.pg_last_error().'<br/>');

        // echo "<script language=javascript>
        // alert('EXECUTOU SALVAR!');
        // location.href='tabela_recibo_pagamento.php';
        // </script>";
    }
}

if (isset($_REQUEST['btn-processar'])) {
    try {
        require_once __DIR__.'/../config/database.php';

        if ($contagem_eventos > 0) {
            echo "<script language=javascript>
        alert('Ainda há eventos pendentes, não é possível processar os dados!');
        location.href='tabela_recibo_pagamento.php';
        </script>";
        } else {
            echo '<br>entrou no processar';
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
                    $situac = 1;

                    // echo '<br>'.$resultArr;
                    // echo '<br>'.$tabela;
                    // echo '<br>'.$situac;

                    updateGESIM1_in($resultArr, $tabela, $situac);

                    echo "<script language=javascript>
        alert('Registro(s) atualizados com sucesso!');
        location.href='tabela_recibo_pagamento.php';
        </script>";
                } else {
                }
            } catch (PDOException $erro) {
                echo $erro->getMessage();
            }
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST['de'])) {
    try {
        
        $tipo = "D";
        $id_eve = $_REQUEST["de"];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_eventos';
        </script>";

    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

  if (isset($_REQUEST['ve'])) {
      try {
          
        $tipo = "V";
        $id_eve = $_REQUEST["ve"];

        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_eventos';
        </script>";

      } catch (PDOException $erro) {
          echo $erro->getMessage();
      }
  }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

