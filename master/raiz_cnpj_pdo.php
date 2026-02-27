<?php

//Faz a requisição da Sessão
require 'restrito.php';
// require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../config/database.php';
//FUNÇÕES
// require_once 'iuds_pdo.php';

$id_emp_default = $_SESSION['id_emp_default'];

$sql = 'SELECT raiz_cnpj from public."VW_EMPRESA" where id_emp='.$id_emp_default.'';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);
$raiz_cnpj = $linha['raiz_cnpj'];

////////////////////////
// foreach (selectGESEMP($id_emp_default) as $resultados) {
//     $cnpj_banco = $resultados["cnpj"];
// }

//RECUPERANDO RAIZ CNPJ
// $raiz1 = str_replace('.', '', $cnpj_banco);
// $raiz2 = str_replace('-', '', $raiz1);
// $raiz3 = str_replace('/', '', $raiz2);
// $cnpj = substr($raiz3, 0, 8);

// echo $cnpj;
