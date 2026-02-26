<?php

//Faz a requisição da Sessão
require 'restrito.php';
// require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../config/database.php';
//FUNÇÕES
// require_once 'iuds_pdo.php';

$id_emp_default = $_SESSION['id_emp_default'];

$sql = 'SELECT raiz_cnpj,tipo from public."VW_EMPRESA" where id_emp='.$id_emp_default.'';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);
$raiz_cnpj = $linha['raiz_cnpj'];
$tipo = $linha['tipo'];
