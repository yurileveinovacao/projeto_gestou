<?php

//Faz a requisição da Sessão
require 'restrito.php';
require 'conexao.php';
require_once 'iuds_pdo.php';

$id_mas = $_SESSION['id_mas'];

// $sql = 'SELECT  id_emp from public."VW_ADMIN_EMPACESS" where id_emp_default=id_emp and id_mas='.$id_mas.'';
// $res = pg_exec($conn, $sql);
// $linha = pg_fetch_assoc($res);

// $_SESSION['id_emp_default'] = $linha['id_emp'];

//ATRIBUIÇÃO DE VARIAVEIS BASEADAS NA SESSÃO DO USUÁRIO
// $id_emp_default = $_SESSION['id_emp_default'];
$id_mas_default = $_SESSION['id_mas'];
$id_emp_master = $_SESSION['id_emp_master'];

// Váriavel preenchida no momento em que é acessada a tela de "alterar_aprovacao" em analise
$id_emp_aprovacao = $_SESSION['id_emp_aprovacao'];

//DEFININDO TIMEZONE - DATA E HORA
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$time = date('H:i:s');
//ATRIBUINDO A DATA
$datinc = date('Y-m-d H:i:s');
$datatu = date('Y-m-d H:i:s');

foreach (buscaRaizCNPJ($id_emp_master) as $resultado_raiz) {
     $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
}

// Raiz CNPJ da empresa em aprovação
foreach (buscaRaizCNPJ($id_emp_aprovacao) as $aprovacao_raiz) {
    $raiz_cnpj_aprovacao = $aprovacao_raiz['raiz_cnpj'];
}

// function uniqidReal($lenght)
// {
//     // uniqid gives 13 chars, but you could adjust it to your needs.
//     if (function_exists('random_bytes')) {
//         $bytes = random_bytes(ceil($lenght / 2));
//     } elseif (function_exists('openssl_random_pseudo_bytes')) {
//         $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
//     } else {
//         throw new Exception('no cryptographically secure random function available');
//     }

//     return substr(bin2hex($bytes), 0, $lenght);

//     //chamar funçao uniqid() e uniqidReal()
// //echo uniqid(), uniqidReal(), PHP_EOL;
// }

$id_mas_situac = $_SESSION['id_mas'];

foreach(selectVW_ADMIN_GACESSO_situac($id_mas_situac) as $situac_usa){

    if($situac_usa["situac"] == 0){

        echo "<script language=javascript>
        alert('Seu usuário está inativo!');
        location.href = 'https://www.gestou.com.br/master/login';
        </script>";   

    }

}
