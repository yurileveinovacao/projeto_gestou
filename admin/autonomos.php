<?php
// FEA-009 Fase 2 — Lista de autônomos (art. 442-B CLT)

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

$filtro = isset($_GET['filtro']) && in_array($_GET['filtro'], ['ativos', 'inativos', 'todos'], true)
    ? $_GET['filtro']
    : 'ativos';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Autônomos</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="js/sorttable.js"></script>
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include_once 'menu_lateral.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once "barra_superior.php";
                include_once "pagina_restrita.php"; ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Autônomos</h6>
                        <div>
                            <span class="badge badge-pill badge-light">Filtro:</span>
                            <a href="autonomos?filtro=ativos" class="badge badge-pill <?php echo $filtro === 'ativos' ? 'badge-success' : 'badge-secondary' ?>">Ativos</a>
                            <a href="autonomos?filtro=inativos" class="badge badge-pill <?php echo $filtro === 'inativos' ? 'badge-warning' : 'badge-secondary' ?>">Inativos</a>
                            <a href="autonomos?filtro=todos" class="badge badge-pill <?php echo $filtro === 'todos' ? 'badge-info' : 'badge-secondary' ?>">Todos</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-sm-12 button-tabela mb-3">
                            <a href="autonomo_incluir.php" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Novo autônomo</a>
                            <a href="controller/autonomos_exportar_get.php" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-export"></i> Exportar (CSV)</a>
                            <a href="autonomos_importar.php" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-import"></i> Importar (CSV)</a>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th data-orderable="false">Nome</th>
                                        <th data-orderable="false">CPF</th>
                                        <th data-orderable="false">Email</th>
                                        <th data-orderable="false">PIX</th>
                                        <th data-orderable="false" width="10%">Diárias <br>(mês atual)</th>
                                        <th data-orderable="false" width="10%">Status</th>
                                        <th data-orderable="false" width="10%">Ações</th>
                                    </tr>
                                </thead>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Email</th>
                                        <th>PIX</th>
                                        <th>Diárias <br>(mês atual)</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                                <tbody class="texto-table-body">
                                    <?php
                                    $lista = selectGESAUT_lista($id_emp_default, $filtro);
                                    if (is_array($lista) && isset($lista[0]['id_aut'])) {
                                        foreach ($lista as $linha) {
                                            $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $linha['cpf']);
                                            $diarias = (int) ($linha['diarias_mes_atual'] ?? 0);
                                    ?>
                                            <tr>
                                                <td><span class="m-0 text-primary tamanho-text"><?php echo htmlspecialchars($linha['nome']); ?></span></td>
                                                <td><?php echo htmlspecialchars($cpf_fmt); ?></td>
                                                <td><?php echo htmlspecialchars($linha['email']); ?></td>
                                                <td><?php echo htmlspecialchars($linha['pix']); ?></td>
                                                <td class="text-center">
                                                    <?php if ($diarias >= 4) { ?>
                                                        <span class="badge badge-danger" title="Limite CLT atingido"><?php echo $diarias; ?></span>
                                                    <?php } elseif ($diarias >= 3) { ?>
                                                        <span class="badge badge-warning" title="Próximo do limite CLT"><?php echo $diarias; ?></span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-light"><?php echo $diarias; ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td class="content-xy-center">
                                                    <div class="cursor-pointer toggle-ativo" data-id-aut="<?php echo $linha['id_aut']; ?>" data-ativo="<?php echo $linha['ativo']; ?>">
                                                        <?php if ($linha['ativo'] == 1) { ?>
                                                            <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo (clique para inativar)"></i></span>
                                                        <?php } else { ?>
                                                            <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo (clique para reativar)"></i></span>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td class="content-xy-center">
                                                    <a href="autonomo_alterar.php?al=<?php echo $linha['id_aut']; ?>" class="btn btn-primary btn-icones" title="Editar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once "footer.php"; ?>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>
</html>

<script>
// Toggle ativo/inativo do autônomo
$(document).on('click', '.toggle-ativo', function() {
    var id_aut = $(this).data('id-aut');
    var atual  = parseInt($(this).data('ativo'), 10);
    var novo   = atual === 1 ? 0 : 1;
    var acao   = novo === 1 ? 'reativar' : 'inativar';

    Swal.fire({
        title: 'Confirma?',
        text: 'Deseja ' + acao + ' este autônomo?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
    }).then(function(result) {
        if (!result.isConfirmed) return;
        $.post('controller/autonomo_toggle_ativo_post.php', { id_aut: id_aut, novo_ativo: novo }, function(r) {
            try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch (e) {}
            if (r && r.status === 'sucesso') {
                location.reload();
            } else {
                Swal.fire('Erro', (r && r.mensagem) || 'Falha ao atualizar', 'error');
            }
        });
    });
});
</script>
