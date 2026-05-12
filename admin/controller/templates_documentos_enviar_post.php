<?php

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";
require_once __DIR__.'/../helpers/template_pdf.php';

header('Content-Type: application/json');

if (!isset($_POST['btn_enviar'])) {
    echo json_encode(['ok' => false, 'erro' => 'Requisição inválida.']);
    exit;
}

$id_tpl  = (int)($_POST['id_tpl'] ?? 0);
$ids_usu = $_POST['ids_usu'] ?? [];

if ($id_tpl <= 0 || !is_array($ids_usu) || count($ids_usu) === 0) {
    echo json_encode(['ok' => false, 'erro' => 'Informe o template e ao menos 1 colaborador.']);
    exit;
}
if (count($ids_usu) > 100) {
    echo json_encode(['ok' => false, 'erro' => 'Máximo 100 colaboradores por envio.']);
    exit;
}

// Carrega o template (e valida que pertence à empresa do admin logado)
$template = null;
foreach (selectGESDOCTPL_byId($id_tpl, $id_emp_default) as $linha) {
    if (is_array($linha)) {
        $template = $linha;
    }
}
if ($template === null) {
    echo json_encode(['ok' => false, 'erro' => 'Template não encontrado ou de outra empresa.']);
    exit;
}

set_time_limit(0);

// id_processamento compartilhado por todos os destinatários: agrupa o lote no histórico
$id_processamento_lote = uniqidRealFEA008();
$datinc_lote = date('Y-m-d H:i:s');

$enviados = 0;
$falhas   = [];

foreach ($ids_usu as $id_usu_raw) {
    $id_usu = (int)$id_usu_raw;
    if ($id_usu <= 0) {
        continue;
    }

    $dados = null;
    foreach (selectGESUSU_dados_template($id_usu) as $linha) {
        if (is_array($linha)) {
            $dados = $linha;
        }
    }
    if ($dados === null) {
        $falhas[] = "id_usu=$id_usu não encontrado";
        continue;
    }

    try {
        $id_validador = $raiz_cnpj . uniqid() . uniqidRealFEA008();
        $nome_arquivo = gerarPdfTemplate(
            $template['conteudo_html'],
            $template['titulo_documento'],
            $dados,
            $raiz_cnpj,
            $id_validador
        );

        insertGESREC(
            $raiz_cnpj,
            $id_emp_default,
            $id_usu,
            $template['titulo_documento'].'.pdf',
            $nome_arquivo,
            $id_processamento_lote,
            $id_validador,
            $template['titulo_documento'],
            $datinc_lote,
            $id_usa_default
        );

        if (!empty($dados['email'])) {
            $email_destinatario = $dados['email'];
            $nome_destinatario  = $dados['nome'];
            $titulo_documento   = $template['titulo_documento'];
            $nome_empresa       = $dados['empresa_nome'] ?? '';
            include __DIR__.'/../email_aviso_template_documento.php';
        }

        $enviados++;
    } catch (Exception $e) {
        $falhas[] = "id_usu=$id_usu: ".$e->getMessage();
    } catch (PDOException $e) {
        $falhas[] = "id_usu=$id_usu (db): ".$e->getMessage();
    }
}

echo json_encode([
    'ok' => true,
    'enviados' => $enviados,
    'falhas' => $falhas,
]);

function uniqidRealFEA008($lenght = 13)
{
    if (function_exists('random_bytes')) {
        $bytes = random_bytes((int)ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes((int)ceil($lenght / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
