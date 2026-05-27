<?php
// FEA-009 Fase 2 — Importação CSV de autônomos
require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>GESTOU PORTAL - Importar Autônomos</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <style>
        .preview-table tr.valido     { background-color: #d4edda; }
        .preview-table tr.duplicado  { background-color: #fff3cd; }
        .preview-table tr.invalido   { background-color: #f8d7da; }
        .preview-table .motivo       { font-size: 0.85em; font-style: italic; }
    </style>
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
                        <h6 class="m-0 font-weight-bold text-primary">Importar Autônomos (CSV)</h6>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            <strong>Formato esperado:</strong> arquivo CSV separado por <code>;</code> (ponto e vírgula), UTF-8,
                            até 500 linhas. Cabeçalho obrigatório na primeira linha:<br>
                            <code>nome;cpf;rg;data_nasc;etnia;endereco;cep;bairro;cidade;uf;email;pix;ativo</code><br>
                            <small>Dica: clique em "Exportar (CSV)" na tela de autônomos pra obter um arquivo no formato correto.</small>
                        </div>

                        <form id="form-upload" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="arquivo">Arquivo CSV *</label>
                                <input type="file" class="form-control-file" id="arquivo" name="arquivo" accept=".csv,text/csv" required>
                            </div>
                            <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-eye"></i> Analisar arquivo</button>
                            <a href="autonomos.php" class="btn btn-secondary">Voltar</a>
                        </form>

                        <div id="preview-area" class="mt-4" style="display:none;">
                            <hr>
                            <h5>Preview</h5>
                            <div id="resumo" class="mb-3"></div>

                            <div class="table-responsive">
                                <table id="preview-table" class="table table-bordered preview-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Status</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Email</th>
                                            <th>PIX</th>
                                            <th class="motivo">Motivo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="preview-body"></tbody>
                                </table>
                            </div>

                            <button type="button" id="btn-confirmar" class="btn btn-success btn-icon-split-organograma" disabled>
                                <i class="fas fa-check"></i> Confirmar importação
                            </button>
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
</body>
</html>

<script>
$('#form-upload').on('submit', function (e) {
    e.preventDefault();
    var fileInput = document.getElementById('arquivo');
    if (!fileInput.files.length) return;

    var fd = new FormData();
    fd.append('arquivo', fileInput.files[0]);
    fd.append('acao', 'preview');

    $.ajax({
        url: 'controller/autonomos_importar_post.php',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json'
    }).done(function (r) {
        if (r.status !== 'sucesso') {
            Swal.fire('Erro', r.mensagem || 'Falha no upload.', 'error');
            return;
        }
        renderPreview(r);
    }).fail(function (xhr) {
        Swal.fire('Erro', 'Falha na comunicação com o servidor.', 'error');
    });
});

function renderPreview(r) {
    var $body = $('#preview-body').empty();
    var validos = 0, duplicados = 0, invalidos = 0;

    r.linhas.forEach(function (l) {
        var cls = '';
        var statusLabel = '';
        if (l.status === 'valido')      { cls = 'valido'; statusLabel = '<span class="badge badge-success">Válido</span>'; validos++; }
        else if (l.status === 'duplicado') { cls = 'duplicado'; statusLabel = '<span class="badge badge-warning">Duplicado</span>'; duplicados++; }
        else                              { cls = 'invalido'; statusLabel = '<span class="badge badge-danger">Inválido</span>'; invalidos++; }

        $body.append(
            '<tr class="' + cls + '">' +
            '<td>' + l.linha + '</td>' +
            '<td>' + statusLabel + '</td>' +
            '<td>' + escapeHtml(l.nome || '') + '</td>' +
            '<td>' + escapeHtml(l.cpf  || '') + '</td>' +
            '<td>' + escapeHtml(l.email|| '') + '</td>' +
            '<td>' + escapeHtml(l.pix  || '') + '</td>' +
            '<td class="motivo">' + escapeHtml(l.motivo || '') + '</td>' +
            '</tr>'
        );
    });

    $('#resumo').html(
        '<strong>' + r.linhas.length + '</strong> linhas analisadas: ' +
        '<span class="badge badge-success">' + validos + ' válidas</span> ' +
        '<span class="badge badge-warning">' + duplicados + ' duplicadas (serão puladas)</span> ' +
        '<span class="badge badge-danger">' + invalidos + ' inválidas</span>'
    );
    $('#preview-area').show();
    $('#btn-confirmar').prop('disabled', validos === 0).text(' Confirmar importação (' + validos + ' linhas)');
    $('#btn-confirmar').prepend('<i class="fas fa-check"></i>');
}

function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, function (c) {
        return { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;' }[c];
    });
}

$('#btn-confirmar').on('click', function () {
    var fileInput = document.getElementById('arquivo');
    if (!fileInput.files.length) return;

    Swal.fire({
        title: 'Confirma importação?',
        text: 'Apenas linhas válidas serão importadas. Duplicadas e inválidas serão ignoradas.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, importar',
        cancelButtonText: 'Cancelar'
    }).then(function (res) {
        if (!res.isConfirmed) return;

        var fd = new FormData();
        fd.append('arquivo', fileInput.files[0]);
        fd.append('acao', 'confirmar');

        $.ajax({
            url: 'controller/autonomos_importar_post.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json'
        }).done(function (r) {
            if (r.status === 'sucesso') {
                Swal.fire({
                    icon: 'success',
                    title: 'Importação concluída!',
                    text: r.inseridos + ' autônomos importados.',
                    timer: 2500,
                    showConfirmButton: false
                }).then(function () { location.href = 'autonomos.php'; });
            } else {
                Swal.fire('Erro', r.mensagem || 'Falha na importação.', 'error');
            }
        });
    });
});
</script>
