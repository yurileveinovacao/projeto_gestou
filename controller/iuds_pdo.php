<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once __DIR__.'/../config/database.php';

//Tabela GESUSA select
function selectGESUSA($token)
{
    global $pdo;
    $query =
        'SELECT id_usa, token, id_emp_acess
        FROM public."GESUSA"
        WHERE token=:token and analise=2
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':token', $token, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA update - revisado em 06/04/2023 13:56
function updateGESUSA($id_usa)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSA" 
            SET analise=0, situac_token=1
            WHERE id_usa=:id_usa and analise=2';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 06/04/2023 13:56
function updateGESEMP($id_emp)
{
    global $pdo;
    $query =
        'UPDATE public."GESEMP" 
            SET analise=0
            WHERE id_emp=:id_emp and analise=2';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
}