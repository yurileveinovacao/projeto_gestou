<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once __DIR__.'/../config/database.php';


//View VW_CIDADE select - revisado em 09/06/2023 13:56
function select_ESTADO_campo($id_emp)
{
    global $pdo;
    $query =
        'SELECT  id_emp, estado, estado AS estado_atual
            FROM public."VW_EMPRESA"
            WHERE id_emp = :id_emp
        UNION
        SELECT NULL AS id_emp,"GESEST".nome AS estado ,COALESCE((SELECT  estado FROM public."VW_EMPRESA" WHERE id_emp = :id_emp),\'ACRE\') AS estado_atual
            FROM public."GESMUN"
            LEFT OUTER JOIN "GESEST"
                ON "GESEST".id_est = "GESMUN".id_est
                WHERE "GESEST".nome NOT IN ( SELECT estado FROM public."VW_EMPRESA" WHERE id_emp = :id_emp)
                GROUP BY "GESEST".nome
        ORDER BY id_emp ASC, estado';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 09/06/2023 14:03
function select_CIDADE_campo($id_emp, $estado)
{
    global $pdo;
    $query =
        'SELECT id_emp, id_mun, cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) AS cep
            FROM public."VW_EMPRESA"
            WHERE id_emp = :id_emp
        UNION
        SELECT NULL AS id_emp, id_mun, "GESMUN".nome AS cidade, "GESEST".nome AS estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) AS cep
            FROM public."GESMUN"
            LEFT OUTER JOIN "GESEST"
                ON "GESEST".id_est = "GESMUN".id_est
                WHERE "GESEST".nome = :estado AND id_mun NOT IN ( SELECT id_mun FROM public."VW_EMPRESA" WHERE id_emp = :id_emp)
        ORDER BY id_emp ASC, cidade';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':estado', $estado, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP_token select - revisado em 09/06/2023 14:10
function select_GESSEMP_token($token)
{
    global $pdo;
    $query =
        'SELECT id_emp, datval_token
            FROM public."GESEMP"
            WHERE token = :token';
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

//View VW_CIDADE select - revisado em 09/06/2023 14:19
function select_CIDADE_ESTADO($estado)
{
    global $pdo;
    $query = 'SELECT null as id_emp, id_mun,"GESMUN".nome as cidade, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = :estado
    order by  id_emp asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':estado', $estado, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela GESUSU_cpf select - revisado em 12/06/2023 10:20
function select_GESUSU_cpf($cpf)
{
    global $pdo;
    $query = 'SELECT count(id_usu) as conta FROM public."GESUSU" WHERE cpf = :cpf AND situac = 1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU_email select - revisado em 12/06/2023 10:23
function select_GESUSU_email($email)
{
    global $pdo;
    $query = 'SELECT count(id_usu) as conta FROM public."GESUSU" WHERE email = :email AND situac = 1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU insert - revisado em 12/06/2023 10:32
function insert_GESUSU(
    $nome,
    $cpf,
    $email,
    $celular,
    $datanasc,
    $endereco,
    $numero,
    $bairro,
    $complemento,
    $cep,
    $cidade,
    $id_emp,
    $senha,
    $datinc,
    $datatu
)
{
    global $pdo;
    $query = 
        'INSERT INTO public."GESUSU" (nome, cpf, email, celular, datanascimento, endereco, numero, bairro, complemento, cep, id_mun, id_emp, senha, datinc, datatu, situac, situac_senha, situac_politica, analise, situac_inclusao)
        VALUES (:nome, :cpf, :email, :celular, :datanasc, :endereco, :numero, :bairro, :complemento, :cep, :cidade, :id_emp, :senha, :datinc, :datatu, 0, 1, 1, 1, 1)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':datanasc', $datanasc, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':cidade', $cidade, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPRI select - revisado em 12/06/2023 13:06
function select_POL_PRIVACIDADE()
{
    global $pdo;
    $query = 'SELECT * FROM public."GESPRI" WHERE app = 1 AND tipo = \'P\' AND situac = 1';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}