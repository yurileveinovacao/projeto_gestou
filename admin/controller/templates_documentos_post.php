<?php

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

// Define editar_id_tpl na sessão (vindo do botão Editar na listagem)
if (isset($_POST['editar_id_tpl'])) {
    $_SESSION['editar_id_tpl'] = (int)$_POST['editar_id_tpl'];
    echo 1;
    exit;
}

// SAVE (insert ou update conforme id_tpl)
if (isset($_POST['btn_save'])) {

    $nome     = trim($_POST['nome'] ?? '');
    $titulo   = trim($_POST['titulo_documento'] ?? '');
    $html     = $_POST['conteudo_html'] ?? '';
    $id_tpl   = (int)($_POST['id_tpl'] ?? 0);

    if ($nome === '' || $titulo === '' || trim(strip_tags($html)) === '') {
        echo 0;
        exit;
    }

    try {
        if ($id_tpl > 0) {
            updateGESDOCTPL($id_tpl, $id_emp_default, $nome, $titulo, $html, $id_usa_default);
        } else {
            insertGESDOCTPL($id_emp_default, $nome, $titulo, $html, $id_usa_default);
        }
        unset($_SESSION['editar_id_tpl']);
        echo 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    exit;
}

// SOFT DELETE
if (isset($_POST['btn_delete'])) {
    $id_tpl = (int)($_POST['id_tpl'] ?? 0);
    if ($id_tpl <= 0) {
        echo 0;
        exit;
    }
    try {
        deleteGESDOCTPL($id_tpl, $id_emp_default, $id_usa_default);
        echo 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    exit;
}
