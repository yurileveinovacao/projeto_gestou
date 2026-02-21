<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

// Obtém a imagem do formulário POST
$image = $_POST['image'];

// Divide a string pelo ponto e vírgula e pega a segunda parte
list($type, $image) = explode(';', $image);

// Divide a string pela vírgula e pega a segunda parte
list(, $image) = explode(',', $image);

// Decodifica a imagem em base64
$image = base64_decode($image);

// Define o nome do arquivo da imagem
$image_name = $raiz_cnpj_aprovacao . '_' . date("YmdHis") . '_logo.png';

// Define o caminho da pasta para salvar a imagem
$pasta = "../upload/empresa/" . $raiz_cnpj_aprovacao;

// Percorre as fotos do banco selecionadas por selectGESEMP_FOTO($id_emp_aprovacao)
foreach (selectGESEMP_FOTO($id_emp_aprovacao) as $foto_banco) {
    $imagem = $foto_banco["imagem"];

    // Se a imagem existir no banco, remove o arquivo correspondente
    if (empty($imagem)) {
        unlink($pasta . '/' . $imagem);
    }

    // Atualiza a foto no banco de dados com as informações fornecidas
    updateGESEMP_FOTO($image_name, $id_emp_aprovacao, $datatu, $id_usa_default);
}

// Verifica se a pasta não existe e cria-a recursivamente
if (!file_exists($pasta)) {
    mkdir($pasta, 0777, true);
}

// Salva a imagem na pasta especificada
file_put_contents($pasta . '/' . $image_name, $image);
