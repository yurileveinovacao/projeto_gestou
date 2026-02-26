<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

unset($_SESSION["id_fun"]);

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

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!--   <h1 class="h3 mb-0 text-gray-800">Recibos de Pagamento</h1>-->
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabela Usuários</h6>
                    </div>
                    <div class="card-body">

                        <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">

                                            <?php
                                            foreach (select_GESUSA_id_usa($id_usa_default) as $usuario) {

                                                $id_tus = $usuario["id_tus"];
                                            }

                                            // IF SE O USUARIO FOR ADMIN
                                            if ($id_tus == 1) {
                                            ?>

                                                <a href="cadastro_usuario"><button type="button" class="btn btn-organograma btn-icon-split-organograma" title="Incluir Usuário"><i class="fas fa-plus-circle"></i> Incluir</button></a>

                                        </div>

                                        <tr>
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">E-mail</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Tipo Usuário</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="coluna-nome text-center">Nome</th>
                                            <th class="text-center">E-mail</th>
                                            <th class="text-center">Tipo Usuário</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                                foreach (select_GESUSA_USUARIOS($id_emp_default) as $linha) {

                                                    if ($linha != 0) {
                                        ?>

                                                <tr>
                                                    <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                                    </td>
                                                    <td><?php echo $linha['email']; ?></td>
                                                    <td style="text-align:center">
                                                        <?php

                                                        if ($linha['id_tus'] == 3) {
                                                        ?>

                                                            <i class="fas fa-user-tie fa-2x text-primary" title="Contábil"></i>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php

                                                        if ($linha['id_tus'] == 2) {
                                                        ?>

                                                            <i class="fas fa-user fa-2x text-primary" title="Empresa"></i>
                                                        <?php
                                                        }
                                                        if ($linha['id_tus'] == 1) {
                                                        ?>

                                                            <i class="fas fa-user-cog fa-2x ml-2 text-primary" title="Admin"></i>
                                                        <?php
                                                        } ?>
                                                    </td>

                                                    <td class="content-xy-center">
                                                        <!-- INICIO SITUACAO -->
                                                        <div class="div-acoes">
                                                            <?php

                                                            if ($linha['situac'] == 1) {
                                                            ?>
                                                                <a href="tabela_usuarios.php?de=<?php echo $linha['id_usa']; ?>">
                                                                    <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span></a>

                                                            <?php
                                                            }
                                                            if ($linha['situac'] == 0) {
                                                            ?>
                                                                <a href="tabela_usuarios.php?ha=<?php echo $linha['id_usa']; ?>">
                                                                    <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span>
                                                                </a>
                                                            <?php
                                                            } ?>
                                                        </div>

                                                        <!-- INICIO EDITAR -->
                                                        <div class="div-acoes">
                                                            <a href="alterar_usuario?al=<?php echo $linha['id_usa'] ?>">
                                                                <button type="button" class="btn btn-primary btn-icones" title="Editar">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>


                                                </tr>



                                        <?php
                                                    }
                                                }

                                                //   ELSE SE O USUARIO FOR DIFERENTE DE ADMIN 
                                            } else { ?>

                                        <button type="button" class="btn btn-organograma btn-icon-split-organograma" disabled><i class="fas fa-plus-circle"></i> Incluir</button>

                            </div>

                            <tr>
                                <th data-orderable="false" class="coluna-nome">Nome</th>
                                <th data-orderable="false" class="sorttable_nosort nao_click">E-mail</th>
                                <th data-orderable="false" class="sorttable_nosort nao_click">Tipo Usuário</th>
                                <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                            </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="coluna-nome text-center">Nome</th>
                                    <th class="text-center" width="15%">E-mail</th>
                                    <th class="text-center" width="15%">Tipo Usuário</th>
                                    <th class="text-center" width="15%">Ações</th>
                                </tr>
                            </tfoot>

                            <tbody class="texto-table-body">
                                <?php

                                                foreach (select_GESUSA_USUARIOS($id_emp_default) as $linha) {

                                                    if ($linha != 0) {
                                ?>

                                        <tr>
                                            <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span>
                                            </td>
                                            <td><?php echo $linha['email']; ?></td>
                                            <td style="text-align:center">
                                                <?php

                                                        if ($linha['id_tus'] == 3) {
                                                ?>

                                                    <i class="fas fa-user-tie fa-2x text-primary" title="Contábil"></i>
                                                <?php
                                                        }
                                                ?>
                                                <?php

                                                        if ($linha['id_tus'] == 2) {
                                                ?>

                                                    <i class="fas fa-user fa-2x text-primary" title="Empresa"></i>
                                                <?php
                                                        }
                                                        if ($linha['id_tus'] == 1) {
                                                ?>

                                                    <i class="fas fa-user-cog fa-2x ml-2 text-primary" title="Admin"></i>
                                                <?php
                                                        } ?>
                                            </td>

                                            <td class="content-xy-center">
                                                <!-- INICIO SITUACAO -->
                                                <div class="div-acoes">
                                                    <?php

                                                        if ($linha['situac'] == 1) {
                                                    ?>

                                                        <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span>
                                                    <?php
                                                        }
                                                        if ($linha['situac'] == 0) {
                                                    ?>

                                                        <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span>
                                                    <?php
                                                        } ?>
                                                </div>

                                                <!-- INICIO EDITAR -->
                                                <div class="div-acoes">
                                                    <button type="button" class="btn btn-secondary btn-icones" title="Editar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                </div>
                                            </td>


                                        </tr>



                                <?php
                                                    }
                                                }

                                ?>

                            <?php } ?>

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
    document.getElementById("estado").onchange = function() {
        document.querySelector("[name='cep']").value = '';

    }

    document.getElementById("cidade").onchange = function() {

        var select = document.getElementById("cidade");

        var cep = select.options[select.selectedIndex].getAttribute("namespace");

        document.querySelector("[name='cep']").value = cep;

    }
</script>

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST['de'])) {
    try {

        $situac = 0;
        $id_usa = $_REQUEST["de"];

        updateGESUSA_SITUAC($situac, $id_usa, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_usuarios';
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['ha'])) {
    try {

        $situac = 1;
        $id_usa = $_REQUEST["ha"];

        updateGESUSA_SITUAC($situac, $id_usa, $datatu, $id_usa_default);

        echo "<script language=javascript>
        location.href = 'tabela_usuarios';
        </script>";

        // if(validaGESUSU_campos($id_usu)){
        //     try{

        //         updateGESUSU_SITUAC($situac, $id_emp_default, $id_usu, $datatu, $id_usa_default);
        //         echo "<script language=javascript>
        //         location.href = 'tabela_usuarios';
        //         </script>";

        //     }catch (PDOException $erro) {
        //         echo "<script language=javascript>
        //         location.href = 'tabela_usuarios';
        //         </script>"; 
        //         echo $erro->getMessage();
        //     }
        // }else{
        //     echo "<script language=javascript>
        //     alert('Preencha os campos requeridos em todas as abas antes de ativar');
        //     </script>";
        // }
    } catch (PDOException $erro) {

        echo "<script language=javascript>
        location.href = 'tabela_usuarios';
        </script>";

        echo $erro->getMessage();
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// if (isset($_REQUEST['btn-excluir'])) {
//     try {
//         echo "entrou try";
//         require_once __DIR__.'/../config/database.php';

//         $id_usuario;

//         if (0 == 0) {
//             if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
//                 $s = [];
//                 foreach ($_POST as $chave => $valor) {
//                     if (is_array($valor)) {
//                         foreach ($valor as $ch => $va) {
//                             if ($va != 'on') {
//                                 // echo $va.',';
//                                 $id_usuario = $id_usuario.$va.',';
//                             }
//                         }
//                     }
//                 }
//             }

//             $id_usu = substr($id_usuario, 0, -1);
//             $resultArr = explode(',', $id_usu);  

//             switch(deleteGESUSU_in($resultArr)){
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