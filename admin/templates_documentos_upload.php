<?php

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Importar Template Word</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</head>

<style>
    .drop-zone { border: 2px dashed #c5d4ff; border-radius: 8px; padding: 36px 20px; text-align: center; background: #f8f9fc; cursor: pointer; transition: all 0.2s; }
    .drop-zone:hover, .drop-zone.dragover { border-color: #4e73df; background: #f0f4ff; }
    .drop-zone .icone { font-size: 48px; color: #4e73df; margin-bottom: 12px; }
    .arquivo-info { display:none; margin-top: 14px; padding: 10px 14px; background: #e7f3ff; border-radius: 4px; }
    .arquivo-info.show { display: block; }
</style>

<body id="page-top">

    <div id="wrapper">

        <?php include_once "menu_lateral.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php
                include_once "barra_superior.php";
                include_once "pagina_restrita.php";
                ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Importar Template Word (.docx)</h6>
                        <a href="templates_documentos_instrucoes" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-question-circle"></i> Ver instruções e variáveis disponíveis
                        </a>
                    </div>
                    <div class="card-body">

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle"></i>
                            <strong>Importante:</strong> o arquivo .docx deve ser preparado fora do sistema (Word, Google Docs, LibreOffice) com as variáveis no formato <code>{nome_colaborador}</code>, <code>{cargo}</code>, etc. já escritas no documento.
                            <a href="templates_documentos_instrucoes" target="_blank">Ver a lista completa de variáveis →</a>
                        </div>

                        <form id="form-upload-docx" enctype="multipart/form-data">

                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <label for="nome">Nome interno (referência do admin):</label>
                                    <input type="text" class="form-control" id="nome" name="nome" maxlength="200" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="titulo_documento">Título do documento (aparece pro colaborador):</label>
                                    <input type="text" class="form-control" id="titulo_documento" name="titulo_documento" maxlength="200" required>
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="col-md-12">
                                    <label>Arquivo Word (.docx):</label>
                                    <div class="drop-zone" id="drop_zone">
                                        <div class="icone"><i class="fas fa-file-upload"></i></div>
                                        <div><strong>Clique aqui</strong> ou arraste o arquivo .docx</div>
                                        <div class="text-muted small mt-1">Tamanho máximo: 10 MB</div>
                                    </div>
                                    <input type="file" id="arquivo_docx" name="arquivo_docx" accept=".docx" required style="display:none;">

                                    <div class="arquivo-info" id="arquivo_info">
                                        <i class="fas fa-file-word text-primary"></i>
                                        <strong id="info_nome"></strong> <span class="text-muted" id="info_tamanho"></span>
                                        <button type="button" id="btn_remover" class="btn btn-sm btn-link text-danger ml-2"><i class="fas fa-times"></i> Remover</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 text-right">
                                    <a href="templates_documentos" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
                                    <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar Template</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>

        <?php include_once "footer.php"; ?>

        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    </div>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>

<script>
    var TAMANHO_MAX = 10 * 1024 * 1024;
    var $input = $('#arquivo_docx');
    var $drop = $('#drop_zone');
    var $info = $('#arquivo_info');

    $drop.on('click', function() { $input.click(); });
    $drop.on('dragover', function(e) { e.preventDefault(); $drop.addClass('dragover'); });
    $drop.on('dragleave drop', function() { $drop.removeClass('dragover'); });
    $drop.on('drop', function(e) {
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        if (files && files.length) {
            $input[0].files = files;
            $input.trigger('change');
        }
    });

    $input.on('change', function() {
        var f = this.files[0];
        if (!f) { $info.removeClass('show'); return; }
        if (!f.name.toLowerCase().endsWith('.docx')) {
            Swal.fire({ icon:'warning', title:'Arquivo inválido', text:'Apenas .docx é aceito.' });
            this.value = '';
            $info.removeClass('show');
            return;
        }
        if (f.size > TAMANHO_MAX) {
            Swal.fire({ icon:'warning', title:'Arquivo muito grande', text:'Limite: 10 MB.' });
            this.value = '';
            $info.removeClass('show');
            return;
        }
        $('#info_nome').text(f.name);
        $('#info_tamanho').text(' — ' + (f.size / 1024 / 1024).toFixed(2) + ' MB');
        $info.addClass('show');
    });

    $('#btn_remover').on('click', function() {
        $input.val('');
        $info.removeClass('show');
    });

    $('#form-upload-docx').on('submit', function(e) {
        e.preventDefault();
        if (!$input[0].files.length) {
            Swal.fire({ icon:'warning', title:'Selecione um arquivo .docx' });
            return;
        }
        var formData = new FormData(this);
        formData.append('btn_upload', '1');

        Swal.fire({ title:'Enviando...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });

        $.ajax({
            url: 'controller/templates_documentos_upload_post.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(retorno) {
                try {
                    var r = typeof retorno === 'string' ? JSON.parse(retorno) : retorno;
                    if (r && r.ok) {
                        var msg = 'Template criado com sucesso!';
                        if (r.variaveis_detectadas && r.variaveis_detectadas.length) {
                            msg += '<br><br><strong>Variáveis detectadas no arquivo:</strong><br>' + r.variaveis_detectadas.map(v => '<code>'+v+'</code>').join(' ');
                        }
                        if (r.variaveis_invalidas && r.variaveis_invalidas.length) {
                            msg += '<br><br><strong style="color:#d33;">Variáveis NÃO reconhecidas (vão ficar como texto literal):</strong><br>' + r.variaveis_invalidas.map(v => '<code>'+v+'</code>').join(' ');
                        }
                        Swal.fire({ icon:'success', title:'Pronto!', html: msg, confirmButtonText:'Ir pra listagem' }).then(()=> location.href = 'templates_documentos');
                    } else {
                        Swal.fire({ icon:'error', title:'Erro', html: r && r.erro ? r.erro : 'Falha no upload.' });
                    }
                } catch (e) {
                    Swal.fire({ icon:'error', title:'Erro inesperado', html: retorno });
                }
            },
            error: function(xhr) {
                Swal.fire({ icon:'error', title:'Erro de comunicação', text:'Status ' + xhr.status });
            }
        });
    });
</script>
