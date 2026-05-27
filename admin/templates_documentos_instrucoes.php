<?php

require 'restrito.php';
require_once "util.php";

// Estrutura das variáveis (mesma usada no editor TinyMCE e no helper de PDF)
$grupos = [
    'Pessoais'   => ['nome_colaborador', 'cpf', 'rg', 'matricula'],
    'Documentos' => ['ctps', 'pis', 'titulo_eleitor'],
    'Endereço'   => ['endereco', 'numero', 'complemento', 'bairro', 'cep', 'cidade', 'uf'],
    'Contato'    => ['telefone', 'celular'],
    'Trabalho'   => ['cargo', 'setor', 'data_admissao'],
    'Empresa'    => ['empresa', 'cnpj'],
    'Data'       => ['data_hoje'],
];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Instruções para Templates Word</title>

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
    .var-chip { display:inline-flex; align-items:center; background:#f0f4ff; border:1px solid #c5d4ff; border-radius:4px; padding:6px 10px; margin:4px 8px 4px 0; font-family: monospace; font-size:13px; cursor:pointer; transition:all 0.15s; }
    .var-chip:hover { background:#1d3a8a; color:#fff; border-color:#1d3a8a; }
    .var-chip .copy-icon { margin-left:8px; opacity:0.6; font-size:11px; }
    .grupo-titulo { font-weight: bold; color:#5a5c69; margin: 12px 0 4px 0; font-size:13px; text-transform: uppercase; letter-spacing: 0.5px; }
    .exemplo-box { background:#f8f9fc; border-left:4px solid #4e73df; padding:14px 18px; font-family: Georgia, serif; line-height:1.6; }
    .exemplo-box code { background:#fff3cd; color:#856404; padding:1px 4px; border-radius:3px; font-family: monospace; font-size:90%; }
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
                        <h6 class="m-0 font-weight-bold text-primary">Como criar um template em Word (.docx)</h6>
                    </div>
                    <div class="card-body">

                        <h5 class="text-primary"><i class="fas fa-info-circle"></i> Passo a passo</h5>
                        <ol>
                            <li>Abra o Word (ou Google Docs / LibreOffice) e prepare seu documento normalmente — com toda a formatação que você quer (cabeçalho, logo, fontes, alinhamento, tabelas etc.).</li>
                            <li>Nos lugares onde os dados do colaborador devem aparecer, escreva a <strong>variável correspondente</strong>, com chaves: por exemplo, <code>{nome_colaborador}</code>, <code>{cargo}</code>, <code>{cpf}</code>.</li>
                            <li>Salve o arquivo no formato <strong>.docx</strong> (formato padrão do Word).</li>
                            <li>Volte aqui, clique em <strong>Novo Template → Importar arquivo Word</strong>, dê um nome interno e um título visível pro colaborador, e faça o upload.</li>
                            <li>Pra editar depois, baixe o .docx pela listagem, edite no Word e suba uma nova versão.</li>
                        </ol>

                        <hr>

                        <h5 class="text-primary"><i class="fas fa-tags"></i> Variáveis disponíveis</h5>
                        <p class="text-muted">Clique em uma variável pra copiar. Cole no Word exatamente como aparece (com chaves <code>{ }</code>).</p>

                        <?php foreach ($grupos as $grupo => $vars) { ?>
                            <div class="grupo-titulo"><?php echo htmlspecialchars($grupo); ?></div>
                            <div>
                                <?php foreach ($vars as $var) { ?>
                                    <span class="var-chip" data-var="{<?php echo $var; ?>}" title="Clique pra copiar">
                                        {<?php echo $var; ?>}
                                        <span class="copy-icon"><i class="fas fa-copy"></i></span>
                                    </span>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <hr>

                        <h5 class="text-primary"><i class="fas fa-file-alt"></i> Exemplo</h5>
                        <p class="text-muted">No Word você escreve assim:</p>
                        <div class="exemplo-box">
                            <p><strong>ACORDO DE COMPENSAÇÃO DE FERIADO</strong></p>
                            <p>Pelo presente, <code>{nome_colaborador}</code>, portador(a) do CPF <code>{cpf}</code>, exercendo a função de <code>{cargo}</code> no setor <code>{setor}</code> da empresa <code>{empresa}</code> (CNPJ <code>{cnpj}</code>), concorda em compensar o feriado conforme descrito abaixo.</p>
                            <p>Data: <code>{data_hoje}</code></p>
                        </div>
                        <p class="text-muted mt-2">No envio, cada colaborador receberá uma cópia personalizada com seus próprios dados no lugar das variáveis.</p>

                        <hr>

                        <h5 class="text-primary"><i class="fas fa-exclamation-triangle"></i> Limitações e dicas</h5>
                        <ul>
                            <li>Tamanho máximo do arquivo: <strong>10 MB</strong></li>
                            <li>Formato aceito: <strong>.docx</strong> (Word 2007 em diante). Não suportamos <code>.doc</code> antigo nem <code>.odt</code>.</li>
                            <li>As chaves <code>{ }</code> devem ser as caracteres normais do teclado, não chaves "decorativas" — copie pelos botões acima pra evitar erros.</li>
                            <li>Variáveis que não constam na lista acima não são substituídas (ficam no documento como texto literal).</li>
                            <li>Se um campo do colaborador estiver vazio no cadastro (ex.: <code>{rg}</code> não preenchido), a variável é substituída por espaço em branco.</li>
                        </ul>

                        <div class="text-right mt-4">
                            <a href="templates_documentos_upload" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-file-upload"></i> Importar arquivo agora</a>
                            <a href="templates_documentos" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar para templates</a>
                        </div>

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
    $(document).on('click', '.var-chip', function() {
        var v = $(this).data('var');
        navigator.clipboard.writeText(v).then(function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Copiado: ' + v,
                showConfirmButton: false,
                timer: 1400
            });
        }).catch(function() {
            // fallback antigo
            var t = document.createElement('textarea');
            t.value = v;
            document.body.appendChild(t);
            t.select();
            try { document.execCommand('copy'); } catch (e) {}
            document.body.removeChild(t);
            Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Copiado: ' + v, showConfirmButton:false, timer:1400 });
        });
    });
</script>
