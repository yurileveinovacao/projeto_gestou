<?php
// FEA-009 Fase 2 — Form de edição de autônomo
require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

$id_aut = isset($_GET['al']) ? (int) $_GET['al'] : 0;
if ($id_aut <= 0) {
    header('Location: autonomos.php');
    exit;
}

$dados = selectGESAUT($id_aut, $id_emp_default);
if (!is_array($dados) || !isset($dados[0]['id_aut'])) {
    header('Location: autonomos.php');
    exit;
}
$a = $dados[0];

// Conta RPAs anteriores deste autônomo (qualquer status) — pra alerta de edição
global $pdo;
$stmt = $pdo->prepare('SELECT COUNT(*) AS qtd FROM public."GESRPA" WHERE id_aut=:id_aut AND id_emp=:id_emp');
$stmt->execute([':id_aut' => $id_aut, ':id_emp' => $id_emp_default]);
$rpas_anteriores = (int) $stmt->fetch(PDO::FETCH_ASSOC)['qtd'];

$etnias = ['BRANCA', 'PRETA', 'PARDA', 'AMARELA', 'INDIGENA', 'NAO INFORMADO'];
$ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];

$cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $a['cpf']);
$cep_fmt = $a['cep'] ? preg_replace('/(\d{5})(\d{3})/', '$1-$2', $a['cep']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>GESTOU PORTAL - Editar Autônomo</title>

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

                <?php if ($rpas_anteriores > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    Este autônomo tem <strong><?php echo $rpas_anteriores; ?></strong> RPA(s) anterior(es).
                    Alterações nos dados <strong>não afetam documentos já emitidos/assinados</strong> — eles preservam os valores do momento do aceite.
                </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Editar Autônomo</h6>
                        <span class="badge <?php echo $a['ativo'] == 1 ? 'badge-success' : 'badge-danger'; ?>"><?php echo $a['ativo'] == 1 ? 'Ativo' : 'Inativo'; ?></span>
                    </div>

                    <div class="card-body">
                        <form id="form-autonomo" class="needs-validation" novalidate autocomplete="off">
                            <input type="hidden" name="id_aut" value="<?php echo $a['id_aut']; ?>">
                            <input type="hidden" id="rpas_anteriores" value="<?php echo $rpas_anteriores; ?>">

                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="nome">Nome completo *</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" minlength="3" required value="<?php echo htmlspecialchars($a['nome']); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" class="form-control sensivel" id="cpf" name="cpf" attrname="cpf" required value="<?php echo htmlspecialchars($cpf_fmt); ?>" data-original="<?php echo htmlspecialchars($a['cpf']); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="rg">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" value="<?php echo htmlspecialchars($a['rg'] ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_nasc">Data nascimento</label>
                                    <input type="date" class="form-control" id="data_nasc" name="data_nasc" value="<?php echo htmlspecialchars($a['data_nasc'] ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="etnia">Etnia</label>
                                    <select id="etnia" name="etnia" class="form-control">
                                        <option value="">(não informar)</option>
                                        <?php foreach ($etnias as $e) {
                                            $sel = ($a['etnia'] === $e) ? 'selected' : '';
                                            echo '<option value="'.$e.'" '.$sel.'>'.$e.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Contato *</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail *</label>
                                    <input type="email" class="form-control sensivel" id="email" name="email" required value="<?php echo htmlspecialchars($a['email']); ?>" data-original="<?php echo htmlspecialchars($a['email']); ?>">
                                    <small class="form-text text-muted">Usado no envio do link de aceite digital.</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pix">Chave PIX *</label>
                                    <input type="text" class="form-control sensivel" id="pix" name="pix" required value="<?php echo htmlspecialchars($a['pix']); ?>" data-original="<?php echo htmlspecialchars($a['pix']); ?>">
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Endereço</h6>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="endereco">Logradouro</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco" value="<?php echo htmlspecialchars($a['endereco'] ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro" value="<?php echo htmlspecialchars($a['bairro'] ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" attrname="cep" value="<?php echo htmlspecialchars($cep_fmt); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="cidade" name="cidade" value="<?php echo htmlspecialchars($a['cidade'] ?? ''); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="uf">UF</label>
                                    <select id="uf" name="uf" class="form-control">
                                        <option value="">(não informar)</option>
                                        <?php foreach ($ufs as $u) {
                                            $sel = ($a['uf'] === $u) ? 'selected' : '';
                                            echo '<option value="'.$u.'" '.$sel.'>'.$u.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="textalign-right mt-3">
                                <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar alterações</button>
                                <a href="autonomos.php" class="btn btn-secondary">Voltar</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>
</body>
</html>

<script>
// Máscaras
var cpf = document.querySelector('input[attrname=cpf]');
var cep = document.querySelector('input[attrname=cep]');
if (cpf) VMasker(cpf).maskPattern('999.999.999-99');
if (cep) VMasker(cep).maskPattern('99999-999');

function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    for (var t = 9; t < 11; t++) {
        var d = 0;
        for (var c = 0; c < t; c++) d += parseInt(cpf[c]) * ((t + 1) - c);
        d = ((10 * d) % 11) % 10;
        if (parseInt(cpf[c]) !== d) return false;
    }
    return true;
}

document.getElementById('cpf').addEventListener('blur', function () {
    if (this.value && !validarCPF(this.value)) {
        this.setCustomValidity('CPF inválido');
    } else {
        this.setCustomValidity('');
    }
});

// Submit com alerta se mudar dados sensíveis e tiver RPAs anteriores
$('#form-autonomo').on('submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    if (!this.checkValidity()) {
        $form.addClass('was-validated');
        return;
    }
    if (!validarCPF(document.getElementById('cpf').value)) {
        document.getElementById('cpf').setCustomValidity('CPF inválido');
        $form.addClass('was-validated');
        return;
    }

    var rpas = parseInt(document.getElementById('rpas_anteriores').value, 10);
    var sensiveisAlteradas = [];
    document.querySelectorAll('.sensivel').forEach(function (el) {
        var atual = el.value.replace(/\D/g, el.id === 'cpf' ? '' : '');
        var original = el.dataset.original;
        if (el.id === 'cpf' && atual !== original) sensiveisAlteradas.push('CPF');
        else if (el.id !== 'cpf' && el.value !== original) sensiveisAlteradas.push(el.id === 'email' ? 'E-mail' : 'PIX');
    });

    var submit = function () {
        $.post('controller/autonomo_alterar_post.php', $form.serialize(), function (r) {
            try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch (e) {}
            if (r && r.status === 'sucesso') {
                Swal.fire({ icon: 'success', title: 'Alterações salvas!', timer: 1500, showConfirmButton: false })
                    .then(function () { location.href = 'autonomos.php'; });
            } else if (r && r.status === 'cpf_duplicado') {
                Swal.fire('CPF já cadastrado', r.mensagem || '', 'warning');
            } else {
                Swal.fire('Erro', (r && r.mensagem) || 'Falha ao salvar', 'error');
            }
        });
    };

    if (rpas > 0 && sensiveisAlteradas.length > 0) {
        Swal.fire({
            title: 'Confirma alteração?',
            html: 'Você está alterando: <b>' + sensiveisAlteradas.join(', ') + '</b><br><br>' +
                  'Este autônomo tem <b>' + rpas + '</b> RPA(s) anterior(es).<br>' +
                  'Os documentos já assinados <b>não serão afetados</b> — eles preservam os valores do momento do aceite.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, alterar',
            cancelButtonText: 'Cancelar'
        }).then(function (r) { if (r.isConfirmed) submit(); });
    } else {
        submit();
    }
});
</script>
