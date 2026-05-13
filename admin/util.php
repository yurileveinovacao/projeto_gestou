<?php

//Faz a requisição da Sessão
require 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'iuds_pdo.php';

$id_usa = (int)$_SESSION['id_usa'];

$stmt = $pdo->prepare('SELECT id_emp, tipo, cnpj FROM public."VW_ADMIN_EMPACESS" WHERE id_emp_default = id_emp AND id_usa = :id_usa');
$stmt->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
$stmt->execute();
$linha = $stmt->fetch(PDO::FETCH_ASSOC);

// Fallback: id_emp_acess inválido/zerado (admin recém-criado ou empresa default removida).
// Pega a primeira empresa vinculada e persiste como default na GESUSA pra próximos logins.
if (!$linha || empty($linha['id_emp'])) {
    $stmt_fb = $pdo->prepare('SELECT id_emp, tipo, cnpj FROM public."VW_ADMIN_EMPACESS" WHERE id_usa = :id_usa AND id_emp IS NOT NULL ORDER BY id_emp LIMIT 1');
    $stmt_fb->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $stmt_fb->execute();
    $linha = $stmt_fb->fetch(PDO::FETCH_ASSOC);

    if ($linha && !empty($linha['id_emp'])) {
        $upd = $pdo->prepare('UPDATE public."GESUSA" SET id_emp_acess = :id_emp WHERE id_usa = :id_usa');
        $upd->bindParam(':id_emp', $linha['id_emp'], PDO::PARAM_INT);
        $upd->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
        $upd->execute();
    }
}

$_SESSION['id_emp_default'] = $linha ? $linha['id_emp'] : null;
$_SESSION['tipo'] = $linha ? $linha['tipo'] : null;
$_SESSION['cnpj_completo'] = $linha ? $linha['cnpj'] : null;

//ATRIBUIÇÃO DE VARIAVEIS BASEADAS NA SESSÃO DO USUÁRIO
$id_emp_default = $_SESSION['id_emp_default'];
$id_usa_default = $_SESSION['id_usa'];

$tipo_empresa = $_SESSION['tipo'];
$cnpj_completo = $_SESSION['cnpj_completo'];

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
//ATRIBUINDO A DATA
$datinc = date('Y-m-d H:i:s');
$datatu = date('Y-m-d H:i:s');

// Variaveis para apontar o erro caso não seja possivel interpretar o arquivo
$erro_1 = '/admin/erro/erro_1'; //erro generico
$erro_3 = '/admin/erro/erro_3'; //erro arquivo anexado

foreach (buscaRaizCNPJ($id_emp_default) as $resultado_raiz) {
    $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
}

$id_usa_situac = $_SESSION['id_usa'];

foreach (selectVW_ADMIN_GACESSO_situac($id_usa_situac) as $situac_usa) {
    if ($situac_usa['situac'] == 0) {
        echo "<script language=javascript>
        alert('Seu usuário está inativo!');
        location.href = '/admin/login';
        </script>";
    }
}

