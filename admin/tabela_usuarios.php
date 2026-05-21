<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

unset($_SESSION["id_fun"]);

// FEA-010 — Líder RH: contexto de gestão de admins
$id_tus = 0;
foreach (select_GESUSA_id_usa($id_usa_default) as $usuario) {
    $id_tus = (int) $usuario['id_tus'];
}
$is_admin_interno = ($id_tus == 1);
$is_lider_rh = checkLiderRH($id_usa_default, $id_emp_default);
$pode_gerenciar_admins = ($is_admin_interno || $is_lider_rh);

$lideres_ativos = selectGESUSA_lideres_ativos($id_emp_default);
$limites = selectGESEMP_limites($id_emp_default);
$limite_lideres = $limites['limite_lideres'];

$filtro_situac = isset($_GET['filtro']) && in_array($_GET['filtro'], ['ativos', 'inativos', 'todos'], true)
    ? $_GET['filtro']
    : 'ativos';

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
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Tabela Usuários</h6>
                        <?php if ($pode_gerenciar_admins) {
                            $cor_badge = $lideres_ativos > $limite_lideres ? 'badge-danger' : 'badge-info';
                        ?>
                            <span class="badge <?php echo $cor_badge; ?>" title="Líderes RH ativos / limite configurado pelo master">
                                <i class="fas fa-user-shield"></i>
                                <?php echo $lideres_ativos; ?> de <?php echo $limite_lideres; ?> Líderes RH ativos
                            </span>
                        <?php } ?>
                    </div>
                    <div class="card-body">

                        <!-- Filtro de situação + botão Incluir -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group" role="group" aria-label="Filtro de situação">
                                <?php foreach (['ativos' => 'Ativos', 'inativos' => 'Inativos', 'todos' => 'Todos'] as $k => $label) {
                                    $ativo = ($filtro_situac === $k);
                                ?>
                                    <a href="?filtro=<?php echo $k; ?>" class="btn btn-sm <?php echo $ativo ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        <?php echo $label; ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php if ($pode_gerenciar_admins) { ?>
                                <a href="cadastro_usuario"><button type="button" class="btn btn-organograma btn-icon-split-organograma" title="Incluir Usuário"><i class="fas fa-plus-circle"></i> Incluir</button></a>
                            <?php } else { ?>
                                <button type="button" class="btn btn-organograma btn-icon-split-organograma" disabled title="Somente Líderes RH podem incluir usuários"><i class="fas fa-plus-circle"></i> Incluir</button>
                            <?php } ?>
                        </div>

                        <form id="processar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th data-orderable="false" class="coluna-nome">Nome</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">E-mail</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Tipo Usuário</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Criado por</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="coluna-nome text-center">Nome</th>
                                            <th class="text-center">E-mail</th>
                                            <th class="text-center">Tipo Usuário</th>
                                            <th class="text-center">Criado por</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php foreach (select_GESUSA_USUARIOS_lider($id_emp_default, $filtro_situac) as $linha) { ?>
                                            <tr<?php echo $linha['situac'] == 0 ? ' class="text-muted"' : ''; ?>>
                                                <td>
                                                    <span class="m-0 text-primary tamanho-text"><?php echo htmlspecialchars($linha['nome']); ?></span>
                                                    <?php if ($linha['gestor'] == 1) { ?>
                                                        <span class="badge badge-primary ml-1" title="Líder RH desta empresa">
                                                            <i class="fas fa-user-shield"></i> Líder RH
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($linha['email']); ?></td>
                                                <td style="text-align:center">
                                                    <?php if ($linha['id_tus'] == 3) { ?>
                                                        <i class="fas fa-user-tie fa-2x text-primary" title="Contábil"></i>
                                                    <?php } elseif ($linha['id_tus'] == 2) { ?>
                                                        <i class="fas fa-user fa-2x text-primary" title="Empresa"></i>
                                                    <?php } elseif ($linha['id_tus'] == 1) { ?>
                                                        <i class="fas fa-user-cog fa-2x ml-2 text-primary" title="Admin"></i>
                                                    <?php } ?>
                                                </td>
                                                <td style="text-align:center">
                                                    <?php echo htmlspecialchars($linha['criado_por'] ?? '—'); ?>
                                                </td>
                                                <td class="content-xy-center">
                                                    <!-- SITUACAO -->
                                                    <div class="div-acoes">
                                                        <?php if ($pode_gerenciar_admins) { ?>
                                                            <?php if ($linha['situac'] == 1) { ?>
                                                                <a href="tabela_usuarios.php?de=<?php echo $linha['id_usa']; ?>&filtro=<?php echo $filtro_situac; ?>">
                                                                    <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo — clique para desativar"></i></span>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="tabela_usuarios.php?ha=<?php echo $linha['id_usa']; ?>&filtro=<?php echo $filtro_situac; ?>">
                                                                    <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo — clique para reativar"></i></span>
                                                                </a>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php if ($linha['situac'] == 1) { ?>
                                                                <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span>
                                                            <?php } else { ?>
                                                                <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>

                                                    <!-- EDITAR -->
                                                    <div class="div-acoes">
                                                        <?php if ($pode_gerenciar_admins) { ?>
                                                            <a href="alterar_usuario?al=<?php echo $linha['id_usa']; ?>">
                                                                <button type="button" class="btn btn-primary btn-icones" title="Editar">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </a>
                                                        <?php } else { ?>
                                                            <button type="button" class="btn btn-secondary btn-icones" title="Somente Líderes RH podem editar" disabled>
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
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
// FEA-010: ativação/desativação com auditoria e proteção do último Líder RH ativo
$redirect = "tabela_usuarios.php?filtro=" . $filtro_situac;

if (isset($_REQUEST['de']) || isset($_REQUEST['ha'])) {
    if (!$pode_gerenciar_admins) {
        echo "<script language=javascript>
            alert('Somente Líderes RH ou administradores internos podem alterar status de usuários.');
            location.href = '" . $redirect . "';
        </script>";
        exit;
    }

    $id_usa_alvo = (int) ($_REQUEST['de'] ?? $_REQUEST['ha']);
    $vai_desativar = isset($_REQUEST['de']);

    if ($vai_desativar && checkLiderRH($id_usa_alvo, $id_emp_default) && $lideres_ativos <= 1) {
        echo "<script language=javascript>
            alert('É necessário manter pelo menos 1 Líder RH ativo na empresa. Promova outro admin a Líder antes de desativar este.');
            location.href = '" . $redirect . "';
        </script>";
        exit;
    }

    try {
        $situac_novo = $vai_desativar ? 0 : 1;
        updateGESUSA_situac_lider($situac_novo, $id_usa_alvo, $datatu, $id_usa_default);
        echo "<script language=javascript>location.href = '" . $redirect . "';</script>";
        exit;
    } catch (PDOException $erro) {
        echo "<script language=javascript>
            alert('Erro ao alterar status: " . addslashes($erro->getMessage()) . "');
            location.href = '" . $redirect . "';
        </script>";
        exit;
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