<?php
//Faz a requisição da Sessão
require 'restrito.php';
?>

<?php

//abre conexao
require_once __DIR__.'/../../config/database.php';

require_once "util.php";
global $nivel_consulta;

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

    <title>GESTOU PORTAL - Organograma da empresa</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once "menu_lateral.php";

        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                include_once "barra_superior.php";

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Organograma</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Organograma da empresa</h6>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">
                                <form action="cadastro_organograma.php" method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputDescricao">Descrição</label>
                                            <input type="text" name="inputDescricao" style="text-transform:uppercase" class="form-control" id="inputDescricao" minlength="2" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPai">Pai</label>
                                            <select id="inputPai" name="inputPai" class="form-control" required>
                                                <option value="" selected disabled>Escolha um pai para o elemento</option>

                                                <?php

                                                $sql2 = 'SELECT * FROM public."VW_ORGANOGRAMA_PROX_NIVEL" WHERE id_emp=' . $id_emp_default . '';
                                                $res2 = pg_exec($conn, $sql2);
                                                $num_row = pg_num_rows($res2);

                                                if ($num_row == 0) {

                                                ?>
                                                    <option>-</option>

                                                    <?php
                                                } else {

                                                    $sql1 = 'SELECT * FROM public."VW_ORGANOGRAMA_PROX_NIVEL" WHERE id_emp=' . $id_emp_default . '';
                                                    $res1 = pg_exec($conn, $sql1);

                                                    while ($linha = pg_fetch_assoc($res1)) {
                                                    ?>
                                                        <option value="<?php echo $linha["novo_nivel"] ?>" onclick="setaID()"><?php echo $linha["descricao"] ?></option>

                                                <?php

                                                    }
                                                }

                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputNível">Nível</label>
                                            <input type="text" name="inputNível" class="form-control" id="inputNível" readonly></input>
                                        </div>
                                    </div>
                                    <div class="textalign-right">
                                        <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button>
                                        <a href="#" data-toggle="modal" data-target="#Visualizar"><button type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button></a>
                                    </div>
                                </form>
                            </div>

                            <!-- Visualizar Organograma Modal-->
                            <div class="modal fade" id="Visualizar" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Visualizar" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Visualizar">Organograma</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <iframe id='print-iframe' name='print-frame-name' src="visualizar_organograma.php" style="width:100%; height: 600px; border: none;"></iframe>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                                            <button type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma" onclick="baixar()"><i class="fas fa-print"></i> Imprimir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTales Example -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th data-orderable="false">Nível</th>
                                                <th data-orderable="false">Nome</th>
                                                <th data-orderable="false">Pai</th>
                                                <th data-orderable="false" class="sorttable_nosort nao_click" style="text-align: center; width: 15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nível</th>
                                                <th>Nome</th>
                                                <th>Pai</th>
                                                <th style="text-align: center" class="sorttable_nosort nao_click">Ações</th>
                                            </tr>
                                        </tfoot>

                                        <tbody class="texto-table-body">
                                            <?php
                                            $sql4 = 'SELECT * FROM public."GESORG" WHERE id_emp=' . $id_emp_default . '';
                                            $res4 = pg_exec($conn, $sql4);

                                            while ($linha = pg_fetch_assoc($res4)) {
                                            ?>

                                                <tr class="hover-linha">
                                                    <td><?php echo $linha['nivel']; ?></td>
                                                    <td><?php echo $linha['descricao']; ?></td>
                                                    <td><?php echo $linha['pai']; ?></td>
                                                    <td class="content-xy-center">
                                                        <!-- INICIO EDITAR -->
                                                        <div class="div-acoes">
                                                            <a href="#Update<?php echo $linha['id_org'] ?>" data-toggle="modal" data-target="#Update<?php echo $linha['id_org'] ?>">
                                                                <button type="button" class="btn btn-primary btn-icones">
                                                                    <i class="fas fa-pencil-alt" title="Editar"></i>
                                                                </button>
                                                            </a>
                                                        </div>

                                                        <!-- INICIO EXCLUIR -->
                                                        <div class="div-acoes">
                                                            <a href="cadastro_organograma.php?ex=<?php echo $linha['nivel']; ?>" onclick="return confirm(' Tem certeza que deseja excluir esse registro?'); return false">
                                                                <button type="button" class="btn btn-primary btn-icones">
                                                                    <i class='far fa-trash-alt' title='Excluir'></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Editar Modal-->
                                                <div class="modal fade" id="Update<?php echo $linha['id_org'] ?>" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Update" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="Update">Editar Organograma</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="cadastro_organograma.php" method="POST">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-1" style="display: none;">
                                                                            <label for="updateID">ID</label>
                                                                            <input type="text" class="form-control" name="updateID" id="updateID" value="<?php echo $linha['id_org'] ?>" readonly>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="updateDescricao">Nome</label>
                                                                            <input type="text" class="form-control" name="updateDescricao" id="updateDescricao" style="text-transform:uppercase" value="<?php echo $linha['descricao'] ?>" minlength="2" required>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="updatePai">Pai</label>
                                                                            <input id="updatePai" tipe="text" class="form-control" value="<?php echo $linha['pai'] ?>" readonly>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label for="updateNível">Nível</label>
                                                                            <input type="text" class="form-control" id="updateNível" value="<?php echo $linha['nivel'] ?>" readonly></input>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                                                                <button class="btn btn-organograma" name="salvar" type="submit">Salvar</button> -->

                                                                <button type="submit" name="salvar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                                                <button type="button" id="btn-voltar" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button>

                                                                <!-- <a href="#" data-toggle="modal" data-target="#Visualizar"><button type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-image mr-sm-2"></i> Visualizar</button></a> -->
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <?php

                if (isset($_REQUEST['btn-submit'])) {
                    try {

                        require_once __DIR__.'/../../config/database.php';


                        $nivel_comparacao = "'" . $_REQUEST["inputPai"] . "'";

                        echo "-----" . $_REQUEST["inputPai"] . "------";
                        $ultimas = substr($_REQUEST["inputPai"], -3);
                        echo "-----" . $ultimas . "------";
                        $primeira = substr($ultimas, 0, 1);
                        echo "-----" . $primeira . "------";

                        if ($primeira == ".") {
                            $sql5 = 'SELECT  descricao as pai  FROM public."GESORG" where  nivel =  ' . 'substring(' . $nivel_comparacao . ',0,(length(' . $nivel_comparacao . ')-2))' . ' and  id_emp =' . $id_emp_default;
                            $res5 = pg_exec($conn, $sql5);
                            $linha5 = pg_fetch_assoc($res5);
                        } else {
                            $sql5 = 'SELECT  descricao as pai  FROM public."GESORG" where  nivel =  ' . 'substring(' . $nivel_comparacao . ',0,(length(' . $nivel_comparacao . ')-1))' . ' and  id_emp =' . $id_emp_default;
                            $res5 = pg_exec($conn, $sql5);
                            $linha5 = pg_fetch_assoc($res5);
                        }

                        $pai = $linha5["pai"];

                        $descricao = $_REQUEST["inputDescricao"];
                        $nivel = $_REQUEST["inputNível"];

                        $id_emp_default = "'" . $id_emp_default . "'";
                        $descricao_novo = "'" . mb_strtoupper($descricao, 'UTF-8') . "'";
                        $pai_novo = "'" . $pai . "'";
                        $nivel_novo = "'" . $nivel . "'";

                        $sql6 = 'SELECT count(descricao) contagem FROM public."GESORG" where  descricao = ' . $descricao_novo . ' and id_emp =' . $id_emp_default . '';
                        $res6 = pg_exec($conn, $sql6);
                        $linha5 = pg_fetch_assoc($res6);

                        if ($linha5["contagem"] < 1) {

                            $sql4 = 'INSERT into public."GESORG"(descricao, pai, id_emp, nivel) VALUES (' . $descricao_novo . ',' . $pai_novo . ',' . $id_emp_default . ',' . $nivel_novo . ') ';
                            $res4 = pg_exec($conn, $sql4);

                            echo "<script language=javascript>
alert('Registro incluido com sucesso!');
location.href='cadastro_organograma.php';
</script>";
                        } else {

                            echo "<script language=javascript>
alert('Esse Nome já existe para essa empresa!');
location.href='cadastro_organograma.php';
</script>";
                        }
                    } catch (PDOException $erro) {
                        echo $erro->getMessage();
                    }
                }


                if (isset($_REQUEST['salvar'])) {
                    try {

                        require_once __DIR__.'/../../config/database.php';

                        $id_org = $_REQUEST["updateID"];
                        $descricao = $_REQUEST["updateDescricao"];

                        $id_org_novo = "'" . $id_org . "'";
                        $descricao_novo = "'" . mb_strtoupper($descricao, 'UTF-8') . "'";

                        $sql3 = 'UPDATE public."GESORG" SET descricao=UPPER(' . $descricao_novo . ') WHERE id_org=' . $id_org_novo . '';
                        $res3 = pg_exec($conn, $sql3);

                        echo "<script language=javascript>
alert('Registro alterado com sucesso!');
location.href='cadastro_organograma.php';
</script>";
                    } catch (PDOException $erro) {
                        echo $erro->getMessage();
                    }
                }

                if (isset($_REQUEST['ex'])) {
                    try {

                        require_once __DIR__.'/../../config/database.php';

                        $nivel = $_REQUEST["ex"];

                        $nivel_delete = "'" . $nivel . "'";

                        $nivel_consulta = "'" . $nivel . ".%'";

                        $select = 'SELECT count(*) conta FROM public."GESORG" WHERE id_emp=' . $id_emp_default . ' and nivel like ' . $nivel_consulta . '';
                        $resultado = pg_exec($conn, $select);
                        $linha_count = pg_fetch_assoc($resultado);

                        if ($linha_count["conta"] > 0) {


                            echo "<script language=javascript>
alert('Não é possível deletar registros que tenham filhos associados!');
location.href='cadastro_organograma.php';
</script>";
                        } else {


                            $sql3 = 'DELETE FROM public."GESORG" WHERE id_emp=' . $id_emp_default . ' and nivel=' . $nivel_delete . '';
                            $res3 = pg_exec($conn, $sql3);

                            echo "<script language=javascript>
alert('Registro excluido com sucesso!');
location.href='cadastro_organograma.php';
</script>";
                        }
                    } catch (PDOException $erro) {
                        echo $erro->getMessage();
                    }
                }

                ?>

                <!-- End of Main Content -->

                <!-- Footer -->
                <?php

                include_once "footer.php";

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

</body>

</html>

<script>
    document.getElementById("inputPai").onchange = function() {
        var select = document.getElementById("inputPai");
        var nivel = select.options[select.selectedIndex].getAttribute("value");
        document.querySelector("[name='inputNível']").value = nivel;
    }

    // var valor_input = document.getElementById('inputPai').value;
    // document.getElementById('inputNível').value = valor_input;



    function baixar() {
        document.getElementById("print-iframe").contentWindow.print();
    }
</script>


<script>
    // AÇÃO BOTÃO VOLTAR
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {

            // DIRECIOINA PARA A PÁGINA ANTERIOR
            location.href = "cadastro_organograma";
        });
    });
</script>