<?php
// FEA-009 Fase 3 — Visualização / ações do RPA
// Fase 3 cobre: visualizar, baixar PDFs, cancelar.
// Fases 4-6 vão acrescentar: aprovar, aceite digital, enviar p/ financeiro, marcar pago.

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

$id_rpa = isset($_GET['al']) ? (int) $_GET['al'] : 0;
if ($id_rpa <= 0) {
    header('Location: rpas.php');
    exit;
}

$rpa = selectGESRPA($id_rpa, $id_emp_default);
if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
    header('Location: rpas.php');
    exit;
}
$r = $rpa[0];

function _badge_status_full($s) {
    $map = [
        'rascunho'    => ['secondary', 'Rascunho'],
        'autorizado'  => ['primary',   'Autorizado'],
        'assinado'    => ['info',      'Assinado pelo autônomo'],
        'enviado_fin' => ['warning',   'Enviado para financeiro'],
        'pago'        => ['success',   'Pago'],
        'cancelado'   => ['danger',    'Cancelado'],
    ];
    $m = $map[$s] ?? ['light', $s];
    return '<span class="badge badge-' . $m[0] . ' p-2">' . $m[1] . '</span>';
}

$cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $r['autonomo_cpf']);
$data_fmt = date('d/m/Y', strtotime($r['data_servico']));
$pode_cancelar = !in_array($r['status'], ['pago', 'cancelado'], true);

// Líder RH da empresa atual pode aprovar/recusar quando status=rascunho
$is_lider_rh = checkLiderRH($id_usa_default, $id_emp_default);
$pode_aprovar = ($r['status'] === 'rascunho') && $is_lider_rh;
$pode_reenviar_aceite = ($r['status'] === 'autorizado');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <title>GESTOU PORTAL - RPA #<?php echo $r['id_rpa']; ?></title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">RPA #<?php echo $r['id_rpa']; ?></h6>
                        <?php echo _badge_status_full($r['status']); ?>
                    </div>

                    <div class="card-body">

                        <!-- Resumo principal -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary">Autônomo</h6>
                                <p class="mb-1"><strong><?php echo htmlspecialchars($r['autonomo_nome']); ?></strong></p>
                                <p class="text-muted mb-0">CPF: <?php echo $cpf_fmt; ?> &nbsp; | &nbsp; Email: <?php echo htmlspecialchars($r['autonomo_email']); ?></p>
                                <p class="text-muted">PIX: <?php echo htmlspecialchars($r['autonomo_pix']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Serviço</h6>
                                <p class="mb-1"><strong><?php echo htmlspecialchars($r['cargo'] ?? '(sem cargo)'); ?></strong></p>
                                <p class="text-muted mb-0">Setor: <?php echo htmlspecialchars($r['setor_nome'] ?? '-'); ?></p>
                                <p class="text-muted mb-0">Data: <?php echo $data_fmt; ?> &nbsp; | &nbsp; Diárias: <?php echo $r['diarias']; ?></p>
                                <?php if ($r['hora_ini'] || $r['hora_fim']): ?>
                                <p class="text-muted">Horário: <?php echo $r['hora_ini'] ?: '?'; ?> às <?php echo $r['hora_fim'] ?: '?'; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($r['justificativa'])): ?>
                        <div class="alert alert-light"><strong>Justificativa:</strong> <?php echo nl2br(htmlspecialchars($r['justificativa'])); ?></div>
                        <?php endif; ?>

                        <!-- Valores -->
                        <h6 class="text-primary mt-3">Valores</h6>
                        <table class="table table-bordered" style="max-width: 500px;">
                            <tr><td>Valor bruto</td><td class="text-right">R$ <?php echo number_format($r['valor_bruto'], 2, ',', '.'); ?></td></tr>
                            <tr><td>(-) INSS retido (<?php echo number_format($r['perc_imposto'], 2, ',', '.'); ?>%)</td><td class="text-right">R$ <?php echo number_format($r['valor_inss'], 2, ',', '.'); ?></td></tr>
                            <tr class="bg-light"><th>Líquido via PIX</th><th class="text-right">R$ <?php echo number_format($r['valor_liquido'], 2, ',', '.'); ?></th></tr>
                        </table>

                        <!-- Trilha de eventos -->
                        <h6 class="text-primary mt-4">Trilha</h6>
                        <ul class="list-unstyled">
                            <li><i class="far fa-file-alt text-secondary"></i> <strong>Criado:</strong> <?php echo date('d/m/Y H:i', strtotime($r['datinc'])); ?></li>
                            <?php if ($r['data_autorizacao']): ?>
                            <li><i class="fas fa-check text-primary"></i> <strong>Autorizado em:</strong> <?php echo date('d/m/Y H:i', strtotime($r['data_autorizacao'])); ?> (id_usa <?php echo $r['autorizado_por']; ?>)</li>
                            <?php endif; ?>
                            <?php if ($r['data_assinatura']): ?>
                            <li><i class="fas fa-signature text-info"></i> <strong>Assinado em:</strong> <?php echo date('d/m/Y H:i', strtotime($r['data_assinatura'])); ?> — IP <?php echo htmlspecialchars($r['ip_assinatura']); ?></li>
                            <?php endif; ?>
                            <?php if ($r['data_envio_fin']): ?>
                            <li><i class="fas fa-paper-plane text-warning"></i> <strong>Enviado p/ financeiro:</strong> <?php echo date('d/m/Y', strtotime($r['data_envio_fin'])); ?></li>
                            <?php endif; ?>
                            <?php if ($r['data_pgto']): ?>
                            <li><i class="fas fa-dollar-sign text-success"></i> <strong>Pago em:</strong> <?php echo date('d/m/Y', strtotime($r['data_pgto'])); ?></li>
                            <?php endif; ?>
                            <?php if ($r['motivo_cancelamento']): ?>
                            <li><i class="fas fa-ban text-danger"></i> <strong>Cancelado:</strong> <?php echo htmlspecialchars($r['motivo_cancelamento']); ?></li>
                            <?php endif; ?>
                        </ul>

                        <!-- PDFs -->
                        <h6 class="text-primary mt-4">Documentos</h6>
                        <div class="mb-3">
                            <?php foreach ([
                                'autorizacao' => 'Autorização de Pagamento',
                                'contrato'    => 'Contrato (Art. 442-B)',
                                'recibo'      => 'Recibo de Pagamento'
                            ] as $tipo => $label):
                                $path = $r[$tipo . '_pdf_path'] ?? null; ?>
                                <?php if ($path): ?>
                                    <a href="controller/rpa_baixar_pdf_get.php?id_rpa=<?php echo $r['id_rpa']; ?>&tipo=<?php echo $tipo; ?>"
                                       target="_blank" class="btn btn-outline-primary btn-sm mr-2">
                                        <i class="fas fa-file-pdf"></i> <?php echo $label; ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted mr-2"><i class="fas fa-file-pdf"></i> <?php echo $label; ?> (não gerado)</span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Ações -->
                        <div class="mt-4 textalign-right">
                            <a href="rpas.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
                            <?php if ($pode_reenviar_aceite): ?>
                            <button type="button" id="btn-reenviar-aceite" class="btn btn-info"><i class="fas fa-paper-plane"></i> Reenviar email de aceite</button>
                            <?php endif; ?>
                            <?php if ($pode_aprovar): ?>
                            <button type="button" id="btn-recusar" class="btn btn-warning"><i class="fas fa-times-circle"></i> Recusar</button>
                            <button type="button" id="btn-aprovar" class="btn btn-success"><i class="fas fa-check-circle"></i> Aprovar</button>
                            <?php endif; ?>
                            <?php if ($pode_cancelar): ?>
                            <button type="button" id="btn-cancelar" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar RPA</button>
                            <?php endif; ?>
                        </div>

                        <?php if ($r['status'] === 'rascunho' && !$is_lider_rh): ?>
                        <div class="alert alert-info mt-3 small">
                            <i class="fas fa-info-circle"></i> Este RPA aguarda aprovação de um Líder RH. Você (admin comum) só pode visualizar.
                        </div>
                        <?php endif; ?>
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
</body>
</html>

<script>
const ID_RPA_ATUAL = <?php echo $r['id_rpa']; ?>;

document.getElementById('btn-reenviar-aceite')?.addEventListener('click', async function () {
    const r = await Swal.fire({
        title: 'Reenviar email de aceite?',
        text: 'Um novo link será gerado e o link anterior (caso enviado) será invalidado.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, reenviar',
        cancelButtonText: 'Cancelar'
    });
    if (!r.isConfirmed) return;
    $.post('controller/rpa_reenviar_aceite_post.php', { id_rpa: ID_RPA_ATUAL }, function (resp) {
        try { resp = typeof resp === 'string' ? JSON.parse(resp) : resp; } catch (e) {}
        if (resp && resp.status === 'sucesso') {
            Swal.fire('Enviado!', resp.mensagem || '', 'success');
        } else {
            Swal.fire('Erro', (resp && resp.mensagem) || 'Falha ao reenviar.', 'error');
        }
    });
});

document.getElementById('btn-aprovar')?.addEventListener('click', async function () {
    const r = await Swal.fire({
        title: 'Aprovar este RPA?',
        text: 'Após aprovar, o autônomo receberá um email com link para aceite digital.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, aprovar',
        cancelButtonText: 'Cancelar'
    });
    if (!r.isConfirmed) return;

    $.post('controller/rpa_aprovar_post.php', { id_rpa: ID_RPA_ATUAL, acao: 'aprovar' }, function (resp) {
        try { resp = typeof resp === 'string' ? JSON.parse(resp) : resp; } catch (e) {}
        if (resp && resp.status === 'sucesso') {
            Swal.fire({ icon: 'success', title: 'RPA aprovado.', timer: 1500, showConfirmButton: false })
                .then(function () { location.reload(); });
        } else {
            Swal.fire('Erro', (resp && resp.mensagem) || 'Falha ao aprovar.', 'error');
        }
    });
});

document.getElementById('btn-recusar')?.addEventListener('click', async function () {
    const { value: motivo } = await Swal.fire({
        title: 'Recusar este RPA?',
        input: 'textarea',
        inputLabel: 'Motivo da recusa (mínimo 5 caracteres)',
        inputPlaceholder: 'Descreva o motivo...',
        showCancelButton: true,
        confirmButtonText: 'Recusar',
        cancelButtonText: 'Voltar',
        inputValidator: function (v) {
            return (!v || v.trim().length < 5) ? 'Informe ao menos 5 caracteres.' : null;
        }
    });
    if (!motivo) return;

    $.post('controller/rpa_aprovar_post.php', { id_rpa: ID_RPA_ATUAL, acao: 'recusar', motivo: motivo }, function (resp) {
        try { resp = typeof resp === 'string' ? JSON.parse(resp) : resp; } catch (e) {}
        if (resp && resp.status === 'sucesso') {
            Swal.fire({ icon: 'success', title: 'RPA recusado e cancelado.', timer: 1500, showConfirmButton: false })
                .then(function () { location.reload(); });
        } else {
            Swal.fire('Erro', (resp && resp.mensagem) || 'Falha ao recusar.', 'error');
        }
    });
});

document.getElementById('btn-cancelar')?.addEventListener('click', async function () {
    const { value: motivo } = await Swal.fire({
        title: 'Cancelar RPA?',
        input: 'textarea',
        inputLabel: 'Motivo do cancelamento (mínimo 5 caracteres)',
        inputPlaceholder: 'Descreva o motivo...',
        showCancelButton: true,
        confirmButtonText: 'Cancelar RPA',
        cancelButtonText: 'Voltar',
        inputValidator: function (v) {
            return (!v || v.trim().length < 5) ? 'Informe ao menos 5 caracteres.' : null;
        }
    });
    if (!motivo) return;

    $.post('controller/rpa_cancelar_post.php', { id_rpa: <?php echo $r['id_rpa']; ?>, motivo: motivo }, function (resp) {
        try { resp = typeof resp === 'string' ? JSON.parse(resp) : resp; } catch (e) {}
        if (resp && resp.status === 'sucesso') {
            Swal.fire({ icon: 'success', title: 'RPA cancelado.', timer: 1500, showConfirmButton: false })
                .then(function () { location.reload(); });
        } else {
            Swal.fire('Erro', (resp && resp.mensagem) || 'Falha ao cancelar.', 'error');
        }
    });
});
</script>
