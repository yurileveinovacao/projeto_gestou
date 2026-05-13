<?php
// FEA-008: gera PDF de pré-visualização on-the-fly usando o primeiro colaborador ativo como amostra.
// Saída: stream do PDF (não grava em GESREC nem em upload/beneficios/recibos_diversos/).

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";
require_once __DIR__ . '/../helpers/template_pdf.php';
require_once __DIR__ . '/../helpers/template_docx_pdf.php';

$id_tpl = (int)($_GET['id_tpl'] ?? 0);
if ($id_tpl <= 0) {
    http_response_code(400);
    echo 'id_tpl inválido';
    exit;
}

$template = null;
foreach (selectGESDOCTPL_byId($id_tpl, $id_emp_default) as $linha) {
    if (is_array($linha)) {
        $template = $linha;
    }
}
if (!$template) {
    http_response_code(404);
    echo 'Template não encontrado.';
    exit;
}

$colab = null;
foreach (selectGESUSU_ativos_envio($id_emp_default) as $c) {
    if (is_array($c)) {
        $colab = $c;
        break;
    }
}
if (!$colab) {
    http_response_code(404);
    echo 'Nenhum colaborador ativo encontrado pra usar como exemplo.';
    exit;
}

$dados = null;
foreach (selectGESUSU_dados_template((int)$colab['id_usu']) as $d) {
    if (is_array($d)) {
        $dados = $d;
    }
}
if (!$dados) {
    http_response_code(500);
    echo 'Falha ao carregar dados do colaborador-exemplo.';
    exit;
}

$file_id = 'preview_' . uniqid();

try {
    if (($template['tipo'] ?? 'html') === 'docx') {
        $arquivo_origem = __DIR__ . '/../../upload/templates/' . $raiz_cnpj . '/' . $template['arquivo_docx'];
        $nome_pdf = gerarPdfTemplateDocx($arquivo_origem, $dados, $raiz_cnpj, $file_id);
    } else {
        $nome_pdf = gerarPdfTemplate(
            $template['conteudo_html'],
            $template['titulo_documento'],
            $dados,
            $raiz_cnpj,
            $file_id
        );
    }

    $caminho_pdf = __DIR__ . '/../../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $nome_pdf;
    if (!file_exists($caminho_pdf)) {
        http_response_code(500);
        echo 'PDF não foi gerado.';
        exit;
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="preview.pdf"');
    header('Content-Length: ' . filesize($caminho_pdf));
    readfile($caminho_pdf);

    // Remove o arquivo temporário (não polui o GCS/disco com previews)
    @unlink($caminho_pdf);
} catch (Exception $e) {
    http_response_code(500);
    echo 'Erro na pré-visualização: ' . $e->getMessage();
}
