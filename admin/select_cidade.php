<?php   

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

	$estado = $_REQUEST['estado'];
    $estado = "'".$estado."'";
	
    foreach (select_CIDADE_ESTADO($estado) as $cidade_banco) {
    
		$workspace_post[] = array(
			'id_mun'	=> $cidade_banco['id_mun'],
			'nome_mun' => $cidade_banco['cidade'],
            'cep_mun' => $cidade_banco['cep'],
		);
	}
	
	echo(json_encode($workspace_post));
