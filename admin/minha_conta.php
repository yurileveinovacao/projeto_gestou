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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                            <h6 class="m-0 font-weight-bold text-primary">Minha Conta</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead>
                                        <div class="col-sm-12 button-tabela">
                                        <!-- botao atualizar --> 
                                        <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"   method="POST">   
                                            <button type="submit" name="btn-atualizar" data-toggle="tooltip" title="Atualizar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sync-alt"></i> Atualizar</button>
                                        </form>
                                        <!-- <span><h1>REGISTROS</h1></span> -->
                                        </div>
                                        <tr>
                                            <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"></th>
                                            <th data-orderable="false" class="coluna-nome" style="width:15%">Nome</th>
                                            <th data-orderable="false" style="width:16%">CNPJ</th>
                                            <th data-orderable="false" style="width:10%">Valor contrato</th>
                                            <th data-orderable="false" style="width:10%">Início contrato</th>
                                            <th data-orderable="false" style="width:10%">Valor CNPJ</th>
                                            <th data-orderable="false" style="width:10%">Valor escritório</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click textalign-center" style="width:29%">Distribuir valores</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th class="coluna-nome">Nome</th>
                                            <th>CNPJ</th>
                                            <th>Valor contrato</th>
                                            <th>Início contrato</th>
                                            <th>Valor CNPJ</th>
                                            <th>Valor escritório</th>
                                            <th style="text-align: center;">Distribuir valores</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="texto-table-body">
                                    <?php foreach (selectVW_ADMIN_MINHACONTA($id_usa_default) as $linha) { ?> 
                                        <tr>
                                        <form action="atualizar_contrato.php" method="post">
                                            <td><input type="text" name="id_con" id=<?php  echo 'id_con_'.$linha['id_con']; ?> value= <?php  echo $linha['id_con']; ?> readonly style="border-style: hidden; outline: none; text-align: right; width: 35px;"></td>
                                            <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span></td>
                                            <td><?php  echo $linha['cnpj']; ?></td>
                                            <td style="text-align: center;"><?php  echo $linha['vlr_contrato']; ?></td>
                                            <td style="text-align: center;"><?php  echo $linha['datini']; ?></td>
                                            <td style="text-align: center;"><?php  echo $linha['valor_emp']; ?></td>
                                            <td style="text-align: center;"><?php  echo $linha['valor_con']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="text" name="display1" id=<?php  echo 'display1_'.$linha['id_con']; ?> value= <?php  echo $linha['perc_emp']; ?> readonly style="border-style: hidden; outline: none; text-align: right; width: 35px;">%
                                                <input type="range" id=<?php  echo 'number'.$linha['id_con']; ?> value= <?php  echo $linha['perc_emp']; ?> step='1' min="0" max="100" onclick="$('#<?php echo 'botao'.$linha['id_con']; ?>').removeAttr('disabled');"  oninput="<?php echo 'display1_'.$linha['id_con']; ?>.value=<?php  echo 'number'.$linha['id_con']; ?>.value; <?php echo 'display2_'.$linha['id_con']; ?>.value=(100 - <?php  echo 'number'.$linha['id_con']; ?>.value)" />
                                                <input type="text" name="display2" id=<?php  echo 'display2_'.$linha['id_con']; ?> value= <?php  echo $linha['perc_con']; ?> readonly style="border-style: hidden; outline: none;  text-align: right; width: 33px;">%
                                                <button type="submit" id=<?php  echo 'botao'.$linha['id_con']; ?>  disabled class="btn btn-primary" onclick="atualizarContrato(document.getElementById('<?php echo 'check'.$linha['id_con']; ?>').value + ',' + document.getElementById('<?php echo 'display1_'.$linha['id_con']; ?>').value + ',' + document.getElementById('<?php echo 'display2_'.$linha['id_con']; ?>').value )">Salvar</button>
                                            </td>
                                        </tr>
                                        </form>

                                        <?php
    }

?>
<!-- FIM DO WHILE COM RETORNO DO BANCO -->
                                    </tbody>
                                </table>
                                <!-- </form> -->                                
                                <!-- FIM TBODY E TABLE -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- -------------------------------------------------------------------------------------------------------------------- -->


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

<?php

if (isset($_REQUEST['btn-atualizar'])) {
    echo '<script language=javascript>
    <!-- window.reload(); -->
    </script>';
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
   $(document).ready(function(){
	$('#status').change(function () {
	var status =  $('#status').val();
	//alert(status);
	       var index = $(this).parent().index();
		   var nth = "#dataTable td:nth-child("+(index+1).toString()+")";
		   var valor = $(this).val().toUpperCase();
		   if(status == '3'){
			alert('Selecionei todos');
			$("#dataTable tbody tr").show();
		   }else{
			$("#dataTable tbody tr").show();			   
			$(nth).each(function(){
				if($(this).text().toUpperCase().indexOf(valor) < 0){
					$(this).parent().hide();
				}
			});
		   }
	})
   })

   //Será execudado quando o botao salvar for clicado
   function atualizarContrato(arrayDados) {
    //visualizar array de dados que foi enviado   
    //alert('Array: ' + arrayDados);
    var y = arrayDados.split(",");
    var id_con = y[0];
    var perc_emp = y[1];    
    var perc_con = y[2]; 
    //visualizar valores separados apos split do arrayDados      
    //alert('Id_con: ' + id_con);
    //alert('Perc_emp: ' + perc_emp);
    //alert('Perc_con: ' + perc_con);
    if(id_con !== '' && perc_emp !== '' && perc_con !== '' ){
        alert('Variáveis preenchidas corretamente');
        //location.href='minha_conta.php';
    }else{
        alert('Ocorreu um erro no envio dos dados, verifique');
    }
   }

 
</script>