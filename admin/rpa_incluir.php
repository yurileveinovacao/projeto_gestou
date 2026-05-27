<?php
// FEA-009 Fase 3 — Form de inclusão de RPA
require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

// Carrega config da empresa pra valores padrão
$cfg = selectGESRPACFG($id_emp_default);
$valor_padrao = $cfg['valor_liquido_padrao'] ?? 150.00;
$perc_padrao  = $cfg['perc_imposto_padrao']  ?? 12.36;
$limite_alerta   = (int) ($cfg['limite_dias_alerta']   ?? 3);
$limite_bloqueio = (int) ($cfg['limite_dias_bloqueio'] ?? 4);

// Lista de autônomos ativos da empresa pra autocomplete
$autonomos = selectGESAUT_lista($id_emp_default, 'ativos');
$departamentos = selectGESDEP_id_emp($id_emp_default);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>GESTOU PORTAL - Novo RPA</title>

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
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Novo RPA</h6>
                    </div>

                    <div class="card-body">
                        <form id="form-rpa" class="needs-validation" novalidate autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="id_aut">Autônomo *</label>
                                    <select id="id_aut" name="id_aut" class="form-control" required>
                                        <option value="">— selecione —</option>
                                        <?php if (is_array($autonomos) && isset($autonomos[0]['id_aut'])) {
                                            foreach ($autonomos as $a) {
                                                $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $a['cpf']);
                                                echo '<option value="'.$a['id_aut'].'" data-diarias="'.(int)$a['diarias_mes_atual'].'">'
                                                     .htmlspecialchars($a['nome']).' — '.$cpf_fmt.'</option>';
                                            }
                                        } ?>
                                    </select>
                                    <small id="aviso-diarias" class="form-text"></small>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_dep">Setor</label>
                                    <select id="id_dep" name="id_dep" class="form-control">
                                        <option value="">(opcional)</option>
                                        <?php if (is_array($departamentos)) foreach ($departamentos as $d) {
                                            if (!is_array($d) || !isset($d['id_dep'])) continue;
                                            echo '<option value="'.$d['id_dep'].'">'.htmlspecialchars($d['nome']).'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cargo">Cargo / descrição do serviço</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="cargo" name="cargo" maxlength="100">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_servico">Data do serviço *</label>
                                    <input type="date" class="form-control" id="data_servico" name="data_servico" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="diarias">Diárias *</label>
                                    <input type="number" class="form-control" id="diarias" name="diarias" min="1" max="<?php echo $limite_bloqueio - 1; ?>" value="1" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="hora_ini">Hora início</label>
                                    <input type="time" class="form-control" id="hora_ini" name="hora_ini">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="hora_fim">Hora fim</label>
                                    <input type="time" class="form-control" id="hora_fim" name="hora_fim">
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Valores</h6>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="valor_liquido">Valor LÍQUIDO a pagar (R$) *</label>
                                    <input type="number" step="0.01" min="0.01" class="form-control" id="valor_liquido" name="valor_liquido" value="<?php echo number_format($valor_padrao, 2, '.', ''); ?>" required>
                                    <small class="form-text text-muted">Valor que o autônomo receberá no PIX.</small>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="perc_imposto">INSS (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="perc_imposto" name="perc_imposto" value="<?php echo number_format($perc_padrao, 2, '.', ''); ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_inss_display">INSS retido (R$)</label>
                                    <input type="text" class="form-control" id="valor_inss_display" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_bruto_display">Valor BRUTO (R$)</label>
                                    <input type="text" class="form-control font-weight-bold" id="valor_bruto_display" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="justificativa">Justificativa</label>
                                    <textarea class="form-control" id="justificativa" name="justificativa" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="textalign-right mt-3">
                                <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar RPA</button>
                                <a href="rpas.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
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
const LIMITE_ALERTA   = <?php echo $limite_alerta; ?>;
const LIMITE_BLOQUEIO = <?php echo $limite_bloqueio; ?>;

function fmtMoeda(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function recalcular() {
    var liq  = parseFloat(document.getElementById('valor_liquido').value || 0);
    var perc = parseFloat(document.getElementById('perc_imposto').value  || 0);
    var bruto = liq * (1 + perc / 100);
    var inss  = bruto - liq;
    document.getElementById('valor_inss_display').value  = fmtMoeda(inss);
    document.getElementById('valor_bruto_display').value = fmtMoeda(bruto);
}

document.getElementById('valor_liquido').addEventListener('input', recalcular);
recalcular();

// Render seguro do aviso (sem innerHTML — apenas textContent)
function renderAvisoDiarias(tipo, msg, valorDestacado) {
    var aviso = document.getElementById('aviso-diarias');
    while (aviso.firstChild) aviso.removeChild(aviso.firstChild);
    if (!tipo) return;

    var span = document.createElement('span');
    span.className = tipo === 'erro' ? 'text-danger' :
                     tipo === 'alerta' ? 'text-warning' : 'text-muted';

    if (tipo !== 'info') {
        var icon = document.createElement('i');
        icon.className = tipo === 'erro' ? 'fas fa-ban' : 'fas fa-exclamation-triangle';
        span.appendChild(icon);
        span.appendChild(document.createTextNode(' '));
    }

    span.appendChild(document.createTextNode(msg));
    if (valorDestacado !== undefined) {
        var b = document.createElement('b');
        b.textContent = ' ' + valorDestacado + ' ';
        span.appendChild(b);
    }
    aviso.appendChild(span);
}

// Aviso de diárias ao selecionar autônomo
function avaliarDiarias() {
    var sel = document.getElementById('id_aut');
    var opt = sel.options[sel.selectedIndex];
    if (!opt.value) { renderAvisoDiarias(null); return; }
    var diariasExistentes = parseInt(opt.dataset.diarias || 0, 10);
    var diariasAtual = parseInt(document.getElementById('diarias').value, 10) || 1;
    var total = diariasExistentes + diariasAtual;

    if (total >= LIMITE_BLOQUEIO) {
        renderAvisoDiarias('erro',
            'Bloqueado: autônomo já tem ' + diariasExistentes + ' diárias no mês. Adicionar ' + diariasAtual + ' ultrapassa o limite de ' + LIMITE_BLOQUEIO + ' (risco CLT).');
    } else if (total >= LIMITE_ALERTA) {
        renderAvisoDiarias('alerta',
            'Atenção: autônomo terá ' + total + ' diárias no mês. Limite seguro: ' + (LIMITE_ALERTA - 1) + '.');
    } else {
        renderAvisoDiarias('info', 'Autônomo tem ' + diariasExistentes + ' diárias no mês atual.');
    }
}
document.getElementById('id_aut').addEventListener('change', avaliarDiarias);
document.getElementById('diarias').addEventListener('change', avaliarDiarias);

// Submit
$('#form-rpa').on('submit', function (e) {
    e.preventDefault();
    if (!this.checkValidity()) { $(this).addClass('was-validated'); return; }

    $.post('controller/rpa_incluir_post.php', $(this).serialize(), function (r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch (e) {}
        if (r && r.status === 'sucesso') {
            Swal.fire({ icon: 'success', title: 'RPA salvo!', text: 'PDFs gerados.', timer: 1800, showConfirmButton: false })
                .then(function () { location.href = 'rpa_alterar.php?al=' + r.id_rpa; });
        } else if (r && r.status === 'bloqueio_clt') {
            Swal.fire('Limite CLT atingido', r.mensagem, 'error');
        } else if (r && r.status === 'alerta_clt') {
            Swal.fire({
                icon: 'warning',
                title: 'Próximo do limite CLT',
                text: r.mensagem + ' Deseja prosseguir mesmo assim?',
                showCancelButton: true,
                confirmButtonText: 'Sim, salvar',
                cancelButtonText: 'Cancelar'
            }).then(function (res) {
                if (!res.isConfirmed) return;
                var dados = $('#form-rpa').serialize() + '&confirmar_alerta=1';
                $.post('controller/rpa_incluir_post.php', dados, function (r2) {
                    try { r2 = typeof r2 === 'string' ? JSON.parse(r2) : r2; } catch (e) {}
                    if (r2 && r2.status === 'sucesso') {
                        Swal.fire({ icon: 'success', title: 'RPA salvo!', timer: 1500, showConfirmButton: false })
                            .then(function () { location.href = 'rpa_alterar.php?al=' + r2.id_rpa; });
                    } else {
                        Swal.fire('Erro', (r2 && r2.mensagem) || 'Falha ao salvar', 'error');
                    }
                });
            });
        } else {
            Swal.fire('Erro', (r && r.mensagem) || 'Falha ao salvar', 'error');
        }
    });
});
</script>
