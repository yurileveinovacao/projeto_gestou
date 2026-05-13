<?php

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

if (!isset($_POST['btn_upload'])) {
    echo json_encode(['ok' => false, 'erro' => 'Requisição inválida.']);
    exit;
}

$nome   = trim($_POST['nome'] ?? '');
$titulo = trim($_POST['titulo_documento'] ?? '');

if ($nome === '' || $titulo === '') {
    echo json_encode(['ok' => false, 'erro' => 'Preencha nome e título do documento.']);
    exit;
}

if (empty($_FILES['arquivo_docx']) || $_FILES['arquivo_docx']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['ok' => false, 'erro' => 'Erro no upload do arquivo.']);
    exit;
}

$file = $_FILES['arquivo_docx'];
$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($ext !== 'docx') {
    echo json_encode(['ok' => false, 'erro' => 'Apenas .docx é aceito.']);
    exit;
}

if ($file['size'] > 10 * 1024 * 1024) {
    echo json_encode(['ok' => false, 'erro' => 'Arquivo excede 10 MB.']);
    exit;
}

// Detecta variáveis usadas no arquivo (.docx é um zip; lê word/document.xml)
$variaveis_disponiveis = [
    'nome_colaborador', 'cpf', 'rg', 'matricula',
    'ctps', 'pis', 'titulo_eleitor',
    'endereco', 'numero', 'complemento', 'bairro', 'cep', 'cidade', 'uf',
    'telefone', 'celular',
    'cargo', 'setor', 'data_admissao',
    'empresa', 'cnpj',
    'data_hoje',
];

$variaveis_detectadas = [];
$variaveis_invalidas  = [];

$zip = new ZipArchive();
if ($zip->open($file['tmp_name']) === true) {
    $xml = $zip->getFromName('word/document.xml');
    $zip->close();
    if ($xml !== false) {
        // O Word pode quebrar uma {variavel} em vários <w:t> runs; junta tudo num "fluxo" simples antes de procurar
        $texto_corrido = preg_replace('/<[^>]+>/', '', $xml);
        if (preg_match_all('/\{([a-z_]+)\}/i', $texto_corrido, $matches)) {
            foreach (array_unique($matches[1]) as $v) {
                $placeholder = '{' . $v . '}';
                if (in_array(strtolower($v), $variaveis_disponiveis)) {
                    $variaveis_detectadas[] = $placeholder;
                } else {
                    $variaveis_invalidas[] = $placeholder;
                }
            }
        }
    }
} else {
    echo json_encode(['ok' => false, 'erro' => 'Não foi possível ler o arquivo .docx (pode estar corrompido).']);
    exit;
}

try {
    // INSERT primeiro pra obter id_tpl, depois usa o id no nome do arquivo
    // Conteúdo HTML fica vazio pra docx (NOT NULL na coluna), só com referência ao arquivo
    $id_tpl = insertGESDOCTPL(
        $id_emp_default,
        $nome,
        $titulo,
        '', // conteudo_html vazio pra docx
        $id_usa_default,
        'docx',
        null // arquivo_docx provisório, vamos preencher logo depois
    );

    if (!$id_tpl) {
        echo json_encode(['ok' => false, 'erro' => 'Falha ao criar o registro do template.']);
        exit;
    }

    $nome_arquivo = $id_tpl . '.docx';
    $dir = __DIR__ . '/../../upload/templates/' . $raiz_cnpj;

    if (!file_exists($dir)) {
        $umaskOld = umask(0);
        mkdir($dir, 0777, true);
        umask($umaskOld);
    }

    $destino = $dir . '/' . $nome_arquivo;

    if (!move_uploaded_file($file['tmp_name'], $destino)) {
        // Rollback: remove o registro recém-criado se a gravação falhou
        deleteGESDOCTPL($id_tpl, $id_emp_default, $id_usa_default);
        echo json_encode(['ok' => false, 'erro' => 'Falha ao salvar o arquivo em disco (verifique permissões).']);
        exit;
    }

    // Atualiza o registro com o nome do arquivo definitivo
    $upd = $pdo->prepare('UPDATE public."GESDOCTPL" SET arquivo_docx =:arq WHERE id_tpl =:id AND id_emp =:emp');
    $upd->bindParam(':arq', $nome_arquivo, PDO::PARAM_STR);
    $upd->bindParam(':id',  $id_tpl,        PDO::PARAM_INT);
    $upd->bindParam(':emp', $id_emp_default, PDO::PARAM_INT);
    $upd->execute();

    echo json_encode([
        'ok' => true,
        'id_tpl' => (int)$id_tpl,
        'variaveis_detectadas' => $variaveis_detectadas,
        'variaveis_invalidas'  => $variaveis_invalidas,
    ]);
} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'erro' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'erro' => $e->getMessage()]);
}
