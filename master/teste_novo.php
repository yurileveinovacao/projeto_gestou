<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$id_emp = insertGESEMP_MASTER("teste","88888888888888","teste","999","teste","99999999",1,"teste",null,"teste",9658,"1111",null,null,1,"teste","teste",2,2,"teste","teste",1,"M",0,0,0,"teste","teste","teste@teste.com.br");

echo  'Id_emp inserido: ' . $id_emp['pk'];

echo '<br>';

var_dump($id_emp);

?>