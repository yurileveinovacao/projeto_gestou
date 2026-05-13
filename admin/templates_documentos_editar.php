<?php

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

// "Novo Template" limpa qualquer id de edição persistente da sessão
if (isset($_GET['novo'])) {
    unset($_SESSION['editar_id_tpl']);
}

// Modo edição vs criação
$modo_edicao = isset($_SESSION['editar_id_tpl']) && (int)$_SESSION['editar_id_tpl'] > 0;
$tpl = ['id_tpl' => 0, 'nome' => '', 'titulo_documento' => '', 'conteudo_html' => ''];

if ($modo_edicao) {
    foreach (selectGESDOCTPL_byId((int)$_SESSION['editar_id_tpl'], $id_emp_default) as $linha) {
        if (is_array($linha)) {
            $tpl = $linha;
        }
    }
}
$titulo_pagina = $modo_edicao ? 'Editar Template' : 'Novo Template';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - <?php echo $titulo_pagina; ?></title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        tinyMCE.init({
            selector: "#conteudo_html",
            height: 500,
            menubar: false,
            language_url: 'tinymce/langs/pt_BR.js',
            plugins: 'autolink link image emoticons charmap insertdatetime code lists table',
            toolbar1: 'undo redo | bold italic underline forecolor backcolor | alignleft aligncenter alignright | numlist bullist | outdent indent | link image table | code',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px } p { margin:0 0 0.8em 0; }',
            insertdatetime_formats: ['%d/%m/%Y', '%Y-%m-%d', '%d-%m-%Y']
        });

        function inserirVariavelTemplate(placeholder) {
            tinyMCE.activeEditor.execCommand('mceInsertContent', false, placeholder);
        }
    </script>
</head>

<style>
    .variaveis-bar { background:#f8f9fc; border:1px solid #e3e6f0; border-radius:4px; padding:10px 14px; margin-bottom:12px; }
    .variaveis-bar .grupo-var { margin-bottom:6px; }
    .variaveis-bar .grupo-var strong { display:inline-block; min-width:95px; font-size:12px; color:#5a5c69; }
    .variaveis-bar .btn-var { margin:2px 4px 2px 0; font-family: monospace; font-size:12px; }
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
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo_pagina; ?></h6>
                    </div>
                    <div class="card-body">

                        <form id="form-template">
                            <input type="hidden" id="id_tpl" name="id_tpl" value="<?php echo (int)$tpl['id_tpl']; ?>">

                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <label for="nome">Nome interno (referência do admin):</label>
                                    <input type="text" class="form-control" id="nome" name="nome" maxlength="200" required value="<?php echo htmlspecialchars($tpl['nome'], ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="titulo_documento">Título do documento (aparece pro colaborador):</label>
                                    <input type="text" class="form-control" id="titulo_documento" name="titulo_documento" maxlength="200" required value="<?php echo htmlspecialchars($tpl['titulo_documento'], ENT_QUOTES); ?>">
                                </div>
                            </div>

                            <div class="variaveis-bar">
                                <div class="grupo-var">
                                    <strong>Pessoais:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{nome_colaborador}')">{nome_colaborador}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{cpf}')">{cpf}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{rg}')">{rg}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{matricula}')">{matricula}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Documentos:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{ctps}')">{ctps}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{pis}')">{pis}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{titulo_eleitor}')">{titulo_eleitor}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Endereço:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{endereco}')">{endereco}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{numero}')">{numero}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{complemento}')">{complemento}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{bairro}')">{bairro}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{cep}')">{cep}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{cidade}')">{cidade}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{uf}')">{uf}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Contato:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{telefone}')">{telefone}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{celular}')">{celular}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Trabalho:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{cargo}')">{cargo}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{setor}')">{setor}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{data_admissao}')">{data_admissao}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Empresa:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{empresa}')">{empresa}</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{cnpj}')">{cnpj}</button>
                                </div>
                                <div class="grupo-var">
                                    <strong>Data:</strong>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-var" onclick="inserirVariavelTemplate('{data_hoje}')">{data_hoje}</button>
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="col-md-12">
                                    <label for="conteudo_html">Conteúdo do documento:</label>
                                    <textarea id="conteudo_html" name="conteudo_html"><?php echo htmlspecialchars($tpl['conteudo_html']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 text-right">
                                    <a href="templates_documentos" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
                                    <button type="submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save"></i> Salvar</button>
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
    $('#form-template').on('submit', function(e) {
        e.preventDefault();

        // Garante que o TinyMCE escreve no textarea antes de coletar
        tinyMCE.triggerSave();

        var dados = {
            btn_save: 1,
            id_tpl: $('#id_tpl').val(),
            nome: $('#nome').val(),
            titulo_documento: $('#titulo_documento').val(),
            conteudo_html: $('#conteudo_html').val()
        };

        if (!dados.nome || !dados.titulo_documento || !dados.conteudo_html) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Preencha nome, título e conteúdo.' });
            return;
        }

        $.post('controller/templates_documentos_post.php', dados, function(retorno) {
            if (retorno == 1) {
                Swal.fire({ icon: 'success', title: 'Template salvo!', allowOutsideClick: false }).then(() => {
                    location.href = 'templates_documentos';
                });
            } else if (retorno == 0) {
                Swal.fire({ icon: 'warning', title: 'Dados inválidos' });
            } else {
                Swal.fire({ icon: 'error', title: 'Erro', html: retorno });
            }
        });
    });
</script>
