<?php
// FEA-009 Fase 3 — Lista de RPAs por mês
require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

$hoje = new DateTime('now');
$mes = isset($_GET['mes']) ? (int) $_GET['mes'] : (int) $hoje->format('m');
$ano = isset($_GET['ano']) ? (int) $_GET['ano'] : (int) $hoje->format('Y');
$status_filtro = isset($_GET['status']) && in_array($_GET['status'], ['rascunho','autorizado','assinado','enviado_fin','pago','cancelado'], true)
    ? $_GET['status'] : null;
$id_dep_filtro = isset($_GET['setor']) && (int) $_GET['setor'] > 0 ? (int) $_GET['setor'] : null;

$lista = selectGESRPA_lista($id_emp_default, $mes, $ano, $status_filtro, $id_dep_filtro);
$departamentos = selectGESDEP_id_emp($id_emp_default);

function _badge_status($s) {
    $map = [
        'rascunho'    => ['secondary', 'Rascunho'],
        'autorizado'  => ['primary',   'Autorizado'],
        'assinado'    => ['info',      'Assinado'],
        'enviado_fin' => ['warning',   'Enviado p/ Financeiro'],
        'pago'        => ['success',   'Pago'],
        'cancelado'   => ['danger',    'Cancelado'],
    ];
    $m = $map[$s] ?? ['light', $s];
    return '<span class="badge badge-' . $m[0] . '">' . $m[1] . '</span>';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <title>GESTOU PORTAL - RPAs</title>

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
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">RPAs — Recibos de Pagamento Autônomo</h6>
                    </div>

                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="get" action="rpas.php" class="form-inline mb-3">
                            <label class="mr-2">Período:</label>
                            <select name="mes" class="form-control mr-2">
                                <?php $meses = ['01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março','04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto','09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro'];
                                foreach ($meses as $v => $nome) {
                                    $sel = ((int)$v === $mes) ? 'selected' : '';
                                    echo '<option value="' . (int)$v . '" '.$sel.'>'.$nome.'</option>';
                                } ?>
                            </select>
                            <select name="ano" class="form-control mr-3">
                                <?php for ($y = (int)$hoje->format('Y') - 2; $y <= (int)$hoje->format('Y') + 1; $y++) {
                                    $sel = ($y === $ano) ? 'selected' : '';
                                    echo '<option value="'.$y.'" '.$sel.'>'.$y.'</option>';
                                } ?>
                            </select>

                            <label class="mr-2">Status:</label>
                            <select name="status" class="form-control mr-3">
                                <option value="">(todos)</option>
                                <?php foreach (['rascunho','autorizado','assinado','enviado_fin','pago','cancelado'] as $s) {
                                    $sel = ($status_filtro === $s) ? 'selected' : '';
                                    echo '<option value="'.$s.'" '.$sel.'>'.$s.'</option>';
                                } ?>
                            </select>

                            <label class="mr-2">Setor:</label>
                            <select name="setor" class="form-control mr-3">
                                <option value="">(todos)</option>
                                <?php if (is_array($departamentos)) foreach ($departamentos as $d) {
                                    if (!is_array($d) || !isset($d['id_dep'])) continue;
                                    $sel = ($id_dep_filtro === (int)$d['id_dep']) ? 'selected' : '';
                                    echo '<option value="'.$d['id_dep'].'" '.$sel.'>'.htmlspecialchars($d['nome']).'</option>';
                                } ?>
                            </select>

                            <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
                        </form>

                        <div class="col-sm-12 button-tabela mb-3">
                            <a href="rpa_incluir.php" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Novo RPA</a>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Autônomo</th>
                                        <th>Setor</th>
                                        <th>Valor Bruto</th>
                                        <th>Valor Líquido</th>
                                        <th>Status</th>
                                        <th>Pgto.</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (is_array($lista) && isset($lista[0]['id_rpa'])) {
                                        foreach ($lista as $r) {
                                            $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $r['autonomo_cpf']);
                                            $data_fmt = date('d/m/Y', strtotime($r['data_servico']));
                                            $pgto_fmt = $r['data_pgto'] ? date('d/m/Y', strtotime($r['data_pgto'])) : '-';
                                    ?>
                                    <tr>
                                        <td class="text-center">#<?php echo $r['id_rpa']; ?></td>
                                        <td><?php echo $data_fmt; ?></td>
                                        <td><?php echo htmlspecialchars($r['autonomo_nome']); ?><br><small class="text-muted"><?php echo $cpf_fmt; ?></small></td>
                                        <td><?php echo htmlspecialchars($r['setor_nome'] ?? '-'); ?></td>
                                        <td class="text-right">R$ <?php echo number_format($r['valor_bruto'], 2, ',', '.'); ?></td>
                                        <td class="text-right">R$ <?php echo number_format($r['valor_liquido'], 2, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo _badge_status($r['status']); ?></td>
                                        <td class="text-center"><?php echo $pgto_fmt; ?></td>
                                        <td class="text-center">
                                            <a href="rpa_alterar.php?al=<?php echo $r['id_rpa']; ?>" class="btn btn-primary btn-icones" title="Abrir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr><td colspan="9" class="text-center text-muted">Nenhum RPA neste período.</td></tr>
                                    <?php } ?>
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
