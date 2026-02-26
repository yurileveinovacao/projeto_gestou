<?php

//Faz a requisição da Sessão
require 'restrito.php';
require_once __DIR__.'/../config/database.php';
require_once 'iuds_pdo.php';

$id_usa = $_SESSION['id_usa'];

$sql = 'SELECT  id_emp,tipo,cnpj from public."VW_ADMIN_EMPACESS" where id_emp_default=id_emp and id_usa=' . $id_usa . '';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);

$_SESSION['id_emp_default'] = $linha['id_emp'];
$_SESSION['tipo'] = $linha['tipo'];
$_SESSION['cnpj_completo'] = $linha['cnpj'];

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
$erro_1 = 'https://www.gestou.com.br/admin/erro/erro_1'; //erro generico
$erro_3 = 'https://www.gestou.com.br/admin/erro/erro_3'; //erro arquivo anexado

foreach (buscaRaizCNPJ($id_emp_default) as $resultado_raiz) {
    $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
}

$id_usa_situac = $_SESSION['id_usa'];

foreach (selectVW_ADMIN_GACESSO_situac($id_usa_situac) as $situac_usa) {
    if ($situac_usa['situac'] == 0) {
        echo "<script language=javascript>
        alert('Seu usuário está inativo!');
        location.href = 'https://www.gestou.com.br/admin/login';
        </script>";
    }
}

