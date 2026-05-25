<?php
// FEA-009 Fase 2 — Form de inclusão de autônomo
require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

$etnias = ['BRANCA', 'PRETA', 'PARDA', 'AMARELA', 'INDIGENA', 'NAO INFORMADO'];
$ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Novo Autônomo</title>

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
                        <h6 class="m-0 font-weight-bold text-primary">Novo Autônomo</h6>
                    </div>

                    <div class="card-body">
                        <form id="form-autonomo" class="needs-validation" novalidate autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="nome">Nome completo *</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="nome" name="nome" minlength="3" required>
                                    <div class="invalid-feedback">Mínimo 3 caracteres.</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" attrname="cpf" required>
                                    <div class="invalid-feedback">CPF inválido.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="rg">RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_nasc">Data nascimento</label>
                                    <input type="date" class="form-control" id="data_nasc" name="data_nasc">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="etnia">Etnia</label>
                                    <select id="etnia" name="etnia" class="form-control">
                                        <option value="">(não informar)</option>
                                        <?php foreach ($etnias as $e) echo '<option value="'.$e.'">'.$e.'</option>'; ?>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Contato *</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <small class="form-text text-muted">Obrigatório — usado para envio do link de aceite digital do RPA.</small>
                                    <div class="invalid-feedback">E-mail inválido.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pix">Chave PIX *</label>
                                    <input type="text" class="form-control" id="pix" name="pix" required>
                                    <small class="form-text text-muted">CPF, e-mail, telefone ou chave aleatória.</small>
                                    <div class="invalid-feedback">Informe a chave PIX.</div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-primary mb-3">Endereço</h6>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="endereco">Logradouro</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="endereco" name="endereco">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="bairro" name="bairro">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" attrname="cep">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="cidade" name="cidade">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="uf">UF</label>
                                    <select id="uf" name="uf" class="form-control">
                                        <option value="">(não informar)</option>
                                        <?php foreach ($ufs as $u) echo '<option value="'.$u.'">'.$u.'</option>'; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="textalign-right mt-3">
                                <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar</button>
                                <a href="autonomos.php" class="btn btn-secondary">Cancelar</a>
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
var cpfMask = ['999.999.999-99'];
var cep = document.querySelector('input[attrname=cep]');
var cpf = document.querySelector('input[attrname=cpf]');
if (cpf) VMasker(cpf).maskPattern(cpfMask[0]);
if (cep) VMasker(cep).maskPattern('99999-999');

// Validação CPF client-side
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    var t, c, d;
    for (t = 9; t < 11; t++) {
        d = 0;
        for (c = 0; c < t; c++) d += parseInt(cpf[c]) * ((t + 1) - c);
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

// Submit
$('#form-autonomo').on('submit', function (e) {
    e.preventDefault();
    if (!this.checkValidity()) {
        $(this).addClass('was-validated');
        return;
    }
    if (!validarCPF(document.getElementById('cpf').value)) {
        document.getElementById('cpf').setCustomValidity('CPF inválido');
        $(this).addClass('was-validated');
        return;
    }
    $.post('controller/autonomo_incluir_post.php', $(this).serialize(), function (r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch (e) {}
        if (r && r.status === 'sucesso') {
            Swal.fire({ icon: 'success', title: 'Autônomo cadastrado!', timer: 1500, showConfirmButton: false })
                .then(function () { location.href = 'autonomos.php'; });
        } else if (r && r.status === 'cpf_duplicado') {
            Swal.fire('CPF já cadastrado', r.mensagem || 'Este CPF já existe nesta empresa.', 'warning');
        } else {
            Swal.fire('Erro', (r && r.mensagem) || 'Falha ao salvar', 'error');
        }
    });
});
</script>
