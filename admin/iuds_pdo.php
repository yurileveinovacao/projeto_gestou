<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once __DIR__.'/../config/database.php';

//Tabela GESCON update - revisado em 04/01/2022 10:19
function updateGESCON(
    $perc_emp,
    $perc_con,
    $id_con
) {
    global $pdo;
    $query =
        'update public."GESCON" set perc_emp =:perc_emp, perc_con =:perc_con where id_con =:id_con';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':perc_emp', $perc_emp, PDO::PARAM_STR);
    $statement->bindParam(':perc_con', $perc_con, PDO::PARAM_STR);
    $statement->bindParam(':id_con', $id_con, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP insert - revisado em 06/12/2021 16:26
function insertGESEMP(
    $nome,
    $cnpj,
    $endereco,
    $numero,
    $bairro,
    $cep,
    $situac,
    $complemento,
    $imagem,
    $layout,
    $id_mun,
    $telefone,
    $datinc,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEMP"(nome, cnpj, endereco, numero, bairro, cep, situac, complemento, imagem, layout, id_mun, telefone, datinc, datatu, id_usa_atu) VALUES (:nome, :cnpj, :endereco, :numero, :bairro, :cep, :situac, :complemento, :imagem, :layout, :id_mun, :telefone, :datinc, :datatu, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':layout', $layout, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 06/12/2021 16:26
function updateGESEMP(
    $nome,
    $cnpj,
    $endereco,
    $numero,
    $bairro,
    $cep,
    $situac,
    $complemento,
    $imagem,
    $layout,
    $id_mun,
    $telefone,
    $datinc,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP" SET nome =:nome, cnpj =:cnpj, endereco =:endereco, numero =:numero, bairro =:bairro, cep =:cep, situac =:situac, complemento =:complemento, imagem =:imagem, layout =:layout, id_mun =:id_mun, telefone =:telefone, datinc =:datinc, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':layout', $layout, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 03/04/2023 09:45
function updateGESEMP_CAMPOS(
    $nome,
    $endereco,
    $email,
    $numero,
    $bairro,
    $cep,
    $complemento,
    $id_mun,
    $telefone,
    $contato,
    $valges,
    $nomefantasia,
    $resp_financeiro,
    $email_financeiro,
    $id_usa_rh,
    $id_usa_ouv,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP" 
            SET nome = :nome, endereco = :endereco, email = :email, numero = :numero, bairro = :bairro, cep = :cep, complemento = :complemento, id_mun = :id_mun, telefone = :telefone, contato = :contato, valges = :valges, nomefantasia = :nomefantasia, resp_financeiro = :resp_financeiro, email_financeiro = :email_financeiro, id_usa_rh = :id_usa_rh, id_usa_ouv = :id_usa_ouv, datatu = :datatu, id_usa_atu = :id_usa_atu 
            WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':valges', $valges, PDO::PARAM_INT);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_rh', $id_usa_rh, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_ouv', $id_usa_ouv, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 14/12/2021 09:12
function updateGESEMP_LOGO(
    $imagem,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP" SET imagem =:imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP delete
function deleteGESEMP($id_emp)
{
    global $pdo;
    $query = 'DELETE FROM public."GESEMP" WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP select - revisado em 06/12/2021 16:26
function selectGESEMP($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_emp, nome, cnpj, endereco, numero, bairro, cep, situac, complemento, imagem, layout, id_mun, telefone, datinc, datatu, id_usa_atu FROM public."GESEMP" WHERE id_emp =:id_emp';
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

//Tabela GESDEP insert - revisado em 10/04/2023 13:23
function insertGESDEP(
    $id_emp,
    $nome,
    $situac,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESDEP"(id_emp, nome, situac, datinc, datatu, id_usa_inc, id_usa_atu) 
        VALUES (:id_emp, :nome, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP update - revisado em 07/12/2021 08:33
function updateGESDEP(
    $id_emp,
    $nome,
    $situac,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu,
    $id_dep
) {
    global $pdo;
    $query =
        'UPDATE public."GESDEP" SET id_emp =:id_emp, nome =:nome, situac =:situac, datinc =:datinc, datatu =:datatu, id_usa_inc =:id_usa_inc, id_usa_atu =:id_usa_atu WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP update - revisado em 10/04/2023 14:47
function updateGESDEP_nome(
    $nome,
    $datatu,
    $id_usa_atu,
    $id_dep
) {
    global $pdo;
    $query =
        'UPDATE public."GESDEP" 
            SET nome = :nome, datatu = :datatu, id_usa_atu = :id_usa_atu
            WHERE id_dep = :id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP update - revisado em 07/12/2021 08:33
function updateGESDEP_situac(
    $situac,
    $datatu,
    $id_usa_atu,
    $id_dep
) {
    global $pdo;
    $query =
        'UPDATE public."GESDEP" SET situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP delete
function deleteGESDEP($id_dep)
{
    global $pdo;
    $query = 'DELETE FROM public."GESDEP" WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU delete - revisado 16/12/2021 08:41
function deleteGESDEP_in(array $id_usu)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_usu), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESDEP" WHERE id_dep IN(' . $inQuery . ')');
    foreach ($id_usu as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESDEP select - revisado em 07/12/2021 08:33
function selectGESDEP($id_dep)
{
    global $pdo;
    $query =
        'SELECT id_dep, id_emp, nome, situac, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESDEP" WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_departamento($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_dep, nome FROM public."GESDEP" WHERE  id_dep = 0             
        union
        SELECT id_dep, nome FROM public."GESDEP" WHERE situac=1 AND id_emp = :id_emp';
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

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_id_usu($id_usu, $id_emp)
{
    global $pdo;
    $query =
        'SELECT 1 as rank, COALESCE(a.id_dep,0) as id,COALESCE(a.id_dep,0) as id_dep,COALESCE(b.nome,\'NÃO PREENCHIDO\') as departamento 
        FROM public."GESUSU" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usu =:id_usu
                union
        SELECT 2 as rank, null as id,c.id_dep as id_dep, c.nome as departamento FROM public."GESDEP" as c 
        WHERE c.situac=1 AND c.id_emp =:id_emp and c.id_dep not in (SELECT coalesce(a.id_dep, 0) 
        FROM public."GESUSU" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usu =:id_usu)
                ORDER BY rank
        
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT ID_DEP,CASE WHEN NOME=\'NÃO PREENCHIDO\' THEN \'TODOS\' END AS NOME FROM public."GESDEP" WHERE situac=0 and id_emp = 0
        UNION
        SELECT ID_DEP,NOME FROM public."GESDEP" WHERE situac=1 and id_emp = :id_emp order by nome DESC
        ';
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

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESDEP" WHERE id_emp = :id_emp order by nome asc';
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

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_id_dep($id_dep)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESDEP" WHERE id_dep = :id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela GESDOC insert - revisado em 07/12/2021 08:41
function insertGESDOC(
    $titulo,
    $conteudo,
    $publicado,
    $grupo,
    $pai,
    $datinc,
    $datatu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESDOC"(titulo, conteudo, publicado, grupo, pai, datinc, datatu) VALUES (:titulo, :conteudo, :publicado, :grupo, :pai, :datinc, :datatu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
    $statement->bindParam(':publicado', $publicado, PDO::PARAM_INT);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESDOC update - revisado em 07/12/2021 08:41
function updateGESDOC(
    $titulo,
    $conteudo,
    $publicado,
    $grupo,
    $pai,
    $datinc,
    $datatu,
    $id_doc
) {
    global $pdo;
    $query =
        'UPDATE public."GESDOC" SET titulo =:titulo, conteudo =:conteudo, publicado =:publicado, grupo =:grupo, pai =:pai, datinc =:datinc, datatu =:datatu WHERE id_doc =:id_doc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
    $statement->bindParam(':publicado', $publicado, PDO::PARAM_INT);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDOC delete
function deleteGESDOC($id_doc)
{
    global $pdo;
    $query = 'DELETE FROM public."GESDOC" WHERE id_doc =:id_doc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDOC select - revisado em 07/12/2021 08:41
function selectGESDOC()
{
    global $pdo;
    $query =
        'SELECT id_doc, titulo, conteudo, publicado, grupo, pai, datinc, datatu FROM public."GESDOC" WHERE publicado = 1 ORDER BY grupo';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDOC select
function selectGESDOC_grupo($grupo)
{
    require_once __DIR__.'/../config/database.php';
    $query = 'SELECT id_doc,grupo,titulo,conteudo FROM public."GESDOC" WHERE publicado = 1 and grupo =:grupo ORDER BY grupo';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $resultado;
}

//Tabela GESDOC select - revisado em 27/04/2022 14:49
function selectGESDOC_PAI()
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        'SELECT  substring( pai,1,1)as pai  FROM public."GESDOC" WHERE publicado = 1 GROUP BY  substring( pai,1,1)  ORDER BY PAI ';

    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDOC select - revisado em 27/04/2022 14:49
function selectGESDOC_IDPAI($pai)
{
    global $pdo;
    $query =
        'SELECT a.id_doc, a.titulo, a.publicado, a.grupo
        , a.pai
        ,(select count(b.*) FROM public."GESDOC" b where b.publicado = 1 and substring(b.grupo,1,1) = a.grupo)total_artigos FROM public."GESDOC" a WHERE a.publicado = 1 
        and substring( a.pai,1,1)  = substring( :pai,1,1)
        --and a.pai =:pai 
        
        ORDER BY a.grupo';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDOC select - revisado em 07/12/2021 08:41
function selectGESDOCid_doc($id_doc)
{
    global $pdo;
    $query =
        'SELECT id_doc, titulo, conteudo, publicado, grupo, pai, datinc, datatu, to_char(datatu, \'DD/MM/YYYY HH24:MM\') AS  datatuatualizacao FROM public."GESDOC" WHERE publicado = 1  and id_doc =:id_doc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDOC select - revisado em 14/12/2021 13:40
function selectGESDOC_conteudo($conteudo)
{
    global $pdo;
    $pattern = '%' . $conteudo . '%';
    $query = 'SELECT id_doc, titulo, conteudo, publicado, grupo, pai, datinc, datatu FROM public."GESDOC" WHERE publicado = 1  and upper(conteudo) like :conteudo';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':conteudo', $pattern, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEST insert
function insertGESEST($sigla, $nome)
{
    global $pdo;
    $query = 'INSERT INTO public."GESEST"(sigla, nome) VALUES (:sigla, :nome)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':sigla', $sigla, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESEST update
function updateGESEST($sigla, $nome, $id_est)
{
    global $pdo;
    $query =
        'UPDATE public."GESEST" SET sigla =:sigla, nome =:nome WHERE id_est =:id_est';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':sigla', $sigla, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':id_est', $id_est, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEST delete
function deleteGESEST($id_est)
{
    global $pdo;
    $query = 'DELETE FROM public."GESEST" WHERE id_est =:id_est';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_est', $id_est, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEST select
function selectGESEST($id_est)
{
    global $pdo;
    $query =
        'SELECT id_est, sigla, nome FROM public."GESEST" WHERE id_est =:id_est';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_est', $id_est, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE insert - revisado em 07/12/2021 09:04
function insertGESEVE(
    $codevento,
    $nome,
    $id_emp,
    $tipo,
    $usaref,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEVE"(codevento, nome, id_emp, tipo, usaref, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:codevento, :nome, :id_emp, :tipo, :usaref, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':usaref', $usaref, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEVE update - revisado em 07/12/2021 09:04
function updateGESEVE(
    $codevento,
    $nome,
    $id_emp,
    $tipo,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu,
    $id_eve
) {
    global $pdo;
    $query =
        'UPDATE public."GESEVE" SET codevento =:codevento, nome =:nome, id_emp =:id_emp, tipo =:tipo, datinc =:datinc, datatu =:datatu, id_usa_inc =:id_usa_inc, id_usa_atu =:id_usa_atu WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEVE update - revisado em 08/12/2021 08:51
function updateGESEVE_SITUAC(
    $tipo,
    $id_emp,
    $id_eve,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESEVE" SET tipo =:tipo, id_emp =:id_emp, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEVE update - revisado em 08/12/2021 08:51
function updateGESEVE_usaref(
    $usaref,
    $id_eve,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESEVE" SET usaref =:usaref, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':usaref', $usaref, PDO::PARAM_STR);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEVE delete
function deleteGESEVE($id_eve)
{
    global $pdo;
    $query = 'DELETE FROM public."GESEVE" WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEVE delete - revisado 16/12/2021 08:41
function deleteGESEVE_in($id_eve)
{
    global $pdo;
    $statement = $pdo->prepare('DELETE FROM public."GESEVE" WHERE id_eve=:id_eve');
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESEVE select - revisado em 07/12/2021 09:04
function selectGESEVE($id_eve)
{
    global $pdo;
    $query =
        'SELECT id_eve, codevento, nome, id_emp, tipo, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESEVE" WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 06/01/2022 13:05
function selectGESEVE_ID_EMP($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_eve, codevento, nome, id_emp, tipo, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESEVE" WHERE id_emp =:id_emp';
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

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function selectGESEVE_ID_PROCESSAMENTO($id_emp, $raizCNPJ, $id_processamento)
{
    global $pdo;
    $query =

        'SELECT * FROM public."GESEVE" WHERE id_emp = :id_emp and CODEVENTO IN
(SELECT CODEVENTO FROM public."GESIM2_' . $raizCNPJ . '" as a INNER JOIN public."GESIM1_' . $raizCNPJ . '" as b on a.id_im1=b.id_im1
 where b.id_processamento=:id_processamento)
 order by nome asc';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 insert - revisado em 07/12/2021 16:01
function insertGESIM1(
    $raizCNPJ,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $situac,
    $vlr_fgts,
    $data_credito,
    $id_emp,
    $descricao,
    $id_usu,
    $datinc,
    $id_usa_inc
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESIM1_' . $raizCNPJ . '"(competencia, rg, cpf, nome, cargo, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, situac, vlr_fgts, data_credito, id_emp, descricao, id_usu, datinc, id_usa_inc)	VALUES (:competencia, :rg, :cpf, :nome, :cargo, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_baseir, :situac, :vlr_fgts, :data_credito, :id_emp, :descricao, :id_usu, :datinc, :id_usa_inc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 update - revisado em 07/12/2021 16:02
function updateGESIM1(
    $raizCNPJ,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $situac,
    $vlr_fgts,
    $data_credito,
    $id_emp,
    $descricao,
    $id_usu,
    $datinc,
    $id_usa_inc,
    $id_im1
) {
    global $pdo;
    $query =
        'UPDATE public."GESIM1_' . $raizCNPJ . '" SET competencia =:competencia, rg =:rg, cpf =:cpf, nome =:nome, cargo =:cargo, vlr_vencimento =:vlr_vencimento, vlr_desconto =:vlr_desconto, vlr_liquido =:vlr_liquido, faixa_irrf =:faixa_irrf, vlr_basesalario =:vlr_basesalario, vlr_baseinss =:vlr_baseinss, vlr_basefgts =:vlr_basefgts, vlr_baseirrf =:vlr_baseirrf, vlr_baseir =:vlr_baseir, situac =:situac, vlr_fgts =:vlr_fgts, data_credito =:data_credito, id_emp =:id_emp, descricao =:descricao, id_usu =:id_usu, datinc =:datinc, id_usa_inc =:id_usa_inc WHERE id_im1 =:id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 delete
function deleteGESIM1($raizCNPJ, $id_im1)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESIM1_' . $raizCNPJ . '" WHERE id_im1 =:id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 select - revisado em 07/12/2021 16:12
function selectGESIM1($raizCNPJ, $id_im1)
{
    global $pdo;
    $query =
        'SELECT id_im1, competencia, rg, cpf, nome, cargo, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, situac, vlr_fgts, data_credito, id_emp, descricao, id_usu, datinc, id_usa_inc FROM public."GESIM1_' .
        $raizCNPJ .
        '" WHERE id_im1 =:id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 select competencia- revisado em 22/12/2021 08:04
function selectGESIM1_competencia($raizCNPJ, $id_emp)
{
    global $pdo;
    $query = 'SELECT competencia FROM public."GESIM1_' . $raizCNPJ . '" WHERE id_emp =:id_emp group by competencia';
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

//Tabela GESIM1 updateGESIM1_in - revisado em 22/12/2021 07:47
function updateGESIM1_in(array $id_im1, $tabela, $situac)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_im1), '?'));
    $query =
        $statement = $pdo->prepare('UPDATE ' . $tabela . ' SET situac =' . $situac . '	 WHERE id_im1 IN (' . $inQuery . ')');
    foreach ($id_im1 as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESIM1 deleteGESIM1_in - revisado 22/12/2021 07:48
function deleteGESIM1_in(array $id_im1, $tabela)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_im1), '?'));
    $statement = $pdo->prepare('DELETE FROM ' . $tabela . ' WHERE id_im1 IN(' . $inQuery . ')');
    foreach ($id_im1 as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESIM1 select periodos processados - revisado em 23/12/2021 10:20
function selectGESIM1_processados($raizCNPJ, $id_emp)
{
    global $pdo;
    $query = 'SELECT 
    id_processamento,
    competencia,
    descricao,
    formatar_moeda(sum(vlr_vencimento)) AS vlr_vencimento,
    formatar_moeda(sum(vlr_desconto)) AS vlr_desconto,
    formatar_moeda(sum(vlr_liquido)) AS vlr_liquido,
    formatar_moeda(sum(vlr_basesalario)) AS vlr_basesalario,
    formatar_moeda(sum(vlr_baseinss)) AS vlr_baseinss,
    formatar_moeda(sum(vlr_basefgts)) AS vlr_basefgts 
    FROM public."GESIM1_' . $raizCNPJ . '" WHERE situac IN (2,3) and id_emp =:id_emp group by id_processamento,competencia,descricao order by competencia';
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

//Tabela GESIM1 select periodos proc_detalhado - revisado em 23/12/2021 16:43
function selectGESIM1_proc_detalhado($raizCNPJ, $id_emp, $id_processamento)
{
    global $pdo;
    $query = 'SELECT 
    nome,
    id_processamento,competencia,descricao,id_emp,
    formatar_moeda(vlr_vencimento) AS vlr_vencimento,
    formatar_moeda(vlr_desconto) AS vlr_desconto,
    formatar_moeda(vlr_liquido) AS vlr_liquido,
    formatar_moeda(vlr_basesalario) AS vlr_basesalario,
    formatar_moeda(vlr_baseinss) AS vlr_baseinss,
    formatar_moeda(vlr_basefgts) AS vlr_basefgts,
    formatar_moeda(vlr_basefgts) AS vlr_basefgts
    FROM public."GESIM1_' . $raizCNPJ . '" WHERE situac IN (2,3) and id_emp =:id_emp and id_processamento =:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 select recibo dados - revisado em 28/12/2021 13:53
function selectRECIBO_DADOS($raizCNPJ, $id)
{
    global $pdo;
    $query = 'SELECT 
    competencia,
    to_char(data_credito, \'DD/MM/YYYY\') AS data_credito,
    descricao,nome,cargo
    FROM public."GESIM1_' . $raizCNPJ . '" where id_im1 = \'' . $id . '\' LIMIT 1';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM2 insert - revisado em 07/12/2021 16:20
function insertGESIM2(
    $raizCNPJ,
    $codevento,
    $nome,
    $quantidade,
    $valor,
    $id_im1,
    $id_eve,
    $datinc
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESIM2_' .
        $raizCNPJ .
        '"(codevento, nome, quantidade, valor, id_im1, id_eve, datinc) VALUES (:codevento, :nome, :quantidade, :valor, :id_im1, :id_eve, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':quantidade', $quantidade, PDO::PARAM_STR);
    $statement->bindParam(':valor', $valor, PDO::PARAM_STR);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_STR);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESIM2 update - revisado em 07/12/2021 16:32
function updateGESIM2(
    $raizCNPJ,
    $codevento,
    $nome,
    $quantidade,
    $valor,
    $id_im1,
    $id_eve,
    $datinc,
    $id_im2
) {
    global $pdo;
    $query =
        'UPDATE public."GESIM2_' .
        $raizCNPJ .
        '" SET codevento =:codevento, nome =:nome, quantidade =:quantidade, valor =:valor, id_im1 =:id_im1, id_eve =:id_eve, datinc =:datinc WHERE id_im2 =:id_im2';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':quantidade', $quantidade, PDO::PARAM_STR);
    $statement->bindParam(':valor', $valor, PDO::PARAM_STR);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_im2', $id_im2, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM2 delete
function deleteGESIM2($raizCNPJ, $id_im2)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESIM2_' . $raizCNPJ . '" WHERE id_im2 =:id_im2';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im2', $id_im2, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM2 select - revisado em 07/12/2021 16:34
function selectGESIM2($raizCNPJ, $id_im2)
{
    global $pdo;
    $query =
        'SELECT id_im2, codevento, nome, quantidade, valor, id_im1, id_eve, datinc FROM public."GESIM2_' .
        $raizCNPJ .
        '" WHERE id_im2 =:id_im2';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im2', $id_im2, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUN insert
function insertGESMUN($id_est, $nome, $cep)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMUN"(id_est, nome, cep) VALUES (:id_est, :nome, :cep)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_est', $id_est, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESMUN update
function updateGESMUN($id_est, $nome, $cep, $id_mun)
{
    global $pdo;
    $query =
        'UPDATE public."GESMUN" SET id_est =:id_est, nome =:nome, cep =:cep WHERE id_mun =:id_mun';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_est', $id_est, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMUN delete
function deleteGESMUN($id_mun)
{
    global $pdo;
    $query = 'DELETE FROM public."GESMUN" WHERE id_mun =:id_mun';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMUN select
function selectGESMUN($id_mun)
{
    global $pdo;
    $query =
        'SELECT id_mun, id_est, nome, cep FROM public."GESMUN" WHERE id_mun =:id_mun';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESORG insert - revisado em 07/12/2021 16:39
function insertGESORG(
    $descricao,
    $pai,
    $id_emp,
    $nivel,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESORG"(descricao, pai, id_emp, nivel, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:descricao, :pai, :id_emp, :nivel, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESORG update - revisado em 09/05/2023 15:06
function updateGESORG(
    $descricao,
    $datatu,
    $id_usa_atu,
    $id_org
) {
    global $pdo;
    $query =
        'UPDATE public."GESORG"
            SET descricao = :descricao, datatu = :datatu, id_usa_atu = :id_usa_atu
            WHERE id_org = :id_org';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_org', $id_org, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESORG delete
function deleteGESORG($id_org)
{
    global $pdo;
    $query = 'DELETE FROM public."GESORG" WHERE id_org=:id_org';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_org', $id_org, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESORG select - revisado em 07/12/2021 16:48
function selectGESORG($id_org)
{
    global $pdo;
    $query =
        'SELECT id_org, descricao, pai, id_emp, nivel, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESORG" WHERE id_org=:id_org';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_org', $id_org, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPER insert
function insertGESPER($nome, $situac)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESPER"(nome, situac) VALUES (:nome, :situac)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPER update
function updateGESPER($nome, $situac, $id_per)
{
    global $pdo;
    $query =
        'UPDATE public."GESPER" SET nome =:nome, situac =:situac WHERE id_per =:id_per';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPER delete
function deleteGESPER($id_per)
{
    global $pdo;
    $query = 'DELETE FROM public."GESPER" WHERE id_per =:id_per';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPER select
function selectGESPER($id_per)
{
    global $pdo;
    $query =
        'SELECT id_per, nome, situac FROM public."GESPER" WHERE id_per =:id_per';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPOL insert
function insertGESPOL($id_emp, $nome, $anexo, $situac, $datinc, $datatu, $id_usa_inc, $id_usa_atu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESPOL"(id_emp, nome, anexo, situac, datinc, datatu, id_usa_inc, id_usa_atu)
        VALUES (:id_emp, :nome, :anexo, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)
        RETURNING id_pol as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_pol = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_pol;
}

//Tabela GESPOL update
function updateGESPOL($id_emp, $nome, $anexo, $situac, $id_pol)
{
    global $pdo;
    $query =
        'UPDATE public."GESPOL" SET id_emp =:id_emp, nome =:nome, anexo =:anexo, situac =:situac WHERE id_pol =:id_pol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPOL update
function updateGESPOL_titulo_anexo($id_emp, $nome, $anexo, $id_pol, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESPOL" SET id_emp =:id_emp, nome =:nome, anexo =:anexo, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_pol =:id_pol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPOL update
function updateGESPOL_situac($id_emp, $situac, $id_pol, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESPOL" SET id_emp =:id_emp, situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_pol =:id_pol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPOL delete
function deleteGESPOL($id_pol)
{
    global $pdo;
    $query = 'DELETE FROM public."GESPOL" WHERE id_pol =:id_pol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU delete - revisado 16/12/2021 08:41
function deleteGESPOL_in(array $id_pol)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_pol), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESPOL" WHERE id_pol IN(' . $inQuery . ')');
    foreach ($id_pol as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESPOL select
function selectGESPOL($id_pol)
{
    global $pdo;
    $query =
        'SELECT id_pol, id_emp, nome, anexo, situac FROM public."GESPOL" WHERE id_pol =:id_pol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPOL select
function selectGESPOL_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_pol, id_emp, nome, anexo, situac FROM public."GESPOL" WHERE id_emp =:id_emp';
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

//Tabela GESPRI insert
function insertGESPRI($descricao, $datatu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESPRI"(descricao, datatu) VALUES (:descricao, :datatu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESPRI update
function updateGESPRI($descricao, $datatu, $id_pri)
{
    global $pdo;
    $query =
        'UPDATE public."GESPRI" SET descricao =:descricao, datatu =:datatu WHERE id_pri =:id_pri';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_pri', $id_pri, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPRI delete
function deleteGESPRI($id_pri)
{
    global $pdo;
    $query = 'DELETE FROM public."GESPRI" WHERE id_pri =:id_pri';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pri', $id_pri, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPRI select
function selectGESPRI($id_pri)
{
    global $pdo;
    $query =
        'SELECT id_pri, descricao, datatu FROM public."GESPRI" WHERE id_pri =:id_pri';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pri', $id_pri, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESSOB insert - revisado em 07/12/2021 10:26
function insertGESSOB(
    $id_emp,
    $sob_texto,
    $sob_imagem,
    $mis_texto,
    $mis_imagem,
    $val_texto,
    $val_imagem,
    $vis_texto,
    $vis_imagem,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESSOB"(id_emp, sob_texto, sob_imagem, mis_texto, mis_imagem, val_texto, val_imagem, vis_texto, vis_imagem, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:id_emp, :sob_texto, :sob_imagem, :mis_texto, :mis_imagem, :val_texto, :val_imagem, :vis_texto, :vis_imagem, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':sob_texto', $sob_texto, PDO::PARAM_STR);
    $statement->bindParam(':sob_imagem', $sob_imagem, PDO::PARAM_STR);
    $statement->bindParam(':mis_texto', $mis_texto, PDO::PARAM_STR);
    $statement->bindParam(':mis_imagem', $mis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':val_texto', $val_texto, PDO::PARAM_STR);
    $statement->bindParam(':val_imagem', $val_imagem, PDO::PARAM_STR);
    $statement->bindParam(':vis_texto', $vis_texto, PDO::PARAM_STR);
    $statement->bindParam(':vis_imagem', $vis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB update - revisado em 07/12/2021 11:02
function updateGESSOB(
    $id_emp,
    $sob_texto,
    $sob_imagem,
    $mis_texto,
    $mis_imagem,
    $val_texto,
    $val_imagem,
    $vis_texto,
    $vis_imagem,
    $datatu,
    $id_usa_atu,
    $id_sob
) {
    global $pdo;
    $query =
        'UPDATE public."GESSOB" SET id_emp =:id_emp, sob_texto =:sob_texto, sob_imagem =:sob_imagem, mis_texto =:mis_texto, mis_imagem =:mis_imagem, val_texto =:val_texto, val_imagem =:val_imagem, vis_texto =:vis_texto, vis_imagem =:vis_imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_sob =:id_sob';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':sob_texto', $sob_texto, PDO::PARAM_STR);
    $statement->bindParam(':sob_imagem', $sob_imagem, PDO::PARAM_STR);
    $statement->bindParam(':mis_texto', $mis_texto, PDO::PARAM_STR);
    $statement->bindParam(':mis_imagem', $mis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':val_texto', $val_texto, PDO::PARAM_STR);
    $statement->bindParam(':val_imagem', $val_imagem, PDO::PARAM_STR);
    $statement->bindParam(':vis_texto', $vis_texto, PDO::PARAM_STR);
    $statement->bindParam(':vis_imagem', $vis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_sob', $id_sob, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB_sobre update - revisado em 07/12/2021 11:03
function updateGESSOB_sobre(
    $sob_texto,
    $sob_imagem,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESSOB" SET sob_texto =:sob_texto, sob_imagem =:sob_imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':sob_texto', $sob_texto, PDO::PARAM_STR);
    $statement->bindParam(':sob_imagem', $sob_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB_sobre update - revisado em 07/12/2021 11:04
function updateGESSOB_missao(
    $mis_texto,
    $mis_imagem,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESSOB" SET mis_texto =:mis_texto, mis_imagem =:mis_imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':mis_texto', $mis_texto, PDO::PARAM_STR);
    $statement->bindParam(':mis_imagem', $mis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB_sobre update - revisado em 07/12/2021 11:04
function updateGESSOB_visao(
    $vis_texto,
    $vis_imagem,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESSOB" SET vis_texto =:vis_texto, vis_imagem =:vis_imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':vis_texto', $vis_texto, PDO::PARAM_STR);
    $statement->bindParam(':vis_imagem', $vis_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB_sobre update - revisado em 07/12/2021 11:04
function updateGESSOB_valores(
    $val_texto,
    $val_imagem,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESSOB" SET val_texto =:val_texto, val_imagem =:val_imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':val_texto', $val_texto, PDO::PARAM_STR);
    $statement->bindParam(':val_imagem', $val_imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB delete
function deleteGESSOB($id_sob)
{
    global $pdo;
    $query = 'DELETE FROM public."GESSOB" WHERE id_sob =:id_sob';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sob', $id_sob, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOB select - revisado em 07/12/2021 10:40
function selectGESSOB($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_sob, id_emp, sob_texto, sob_imagem, mis_texto, mis_imagem, val_texto, val_imagem, vis_texto, vis_imagem, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESSOB" WHERE id_emp =:id_emp';
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

//Tabela GESSOB select - revisado em 07/12/2021 10:40
function selectGESSOB_sobre_nos($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_sob, id_emp, sob_texto, sob_imagem, datinc, datatu, id_usa_inc, id_usa_atu FROM public."GESSOB" WHERE id_emp =:id_emp';
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


//Tabela GESUSA insert
function insertGESUSA($nome, $cpf, $senha, $datinc, $id_emp_acess, $email, $situac, $id_per, $id_mun, $telefone)
{
    global $pdo;
    $query = 'INSERT INTO public."GESUSA"(nome, cpf, senha, datinc, id_emp_acess, email, situac, id_per, id_mun, telefone) VALUES (:nome, :cpf, :senha, :datinc, :id_emp_acess, :email, :situac, :id_per, :id_mun, :telefone)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESUSA update
function updateGESUSA(
    $nome,
    $cpf,
    $senha,
    $datinc,
    $id_emp_acess,
    $email,
    $situac,
    $id_per,
    $id_mun,
    $telefone,
    $id_usa
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA" SET nome =:nome, cpf =:cpf, senha =:senha, datinc =:datinc, id_emp_acess =:id_emp_acess, email =:email, situac =:situac, id_per =:id_per, id_mun =:id_mun, telefone =:telefone WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA delete
function deleteGESUSA($id_usa)
{
    global $pdo;
    $query = 'DELETE FROM public."GESUSA" WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA select
function selectGESUSA($id_usa)
{
    global $pdo;
    $query =
        'SELECT id_usa, nome, cpf, senha, datinc, id_emp_acess, email, situac, id_per, id_mun, telefone FROM public."GESUSA" WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU insert - revisado em 08/12/2021 08:49
function insertGESUSU(
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $rg,
    $celular,
    $email,
    $telefone,
    $id_mun,
    $dataadmissao,
    $datanascimento,
    $ctps,
    $pis,
    $cbo,
    $titulo_eleitor,
    $datarescisao,
    $funcao,
    $dataopcao,
    $tpsalario,
    $endereco,
    $complemento,
    $bairro,
    $dependentes,
    $salario,
    $numero,
    $id_dep,
    $id_usa_gestor,
    $sexo,
    $escolaridade,
    $linkedin,
    $cep,
    $id_emp,
    $id_emp_ant,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESUSU"(nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, titulo_eleitor, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_dep, id_usa_gestor, sexo, escolaridade, linkedin, cep, id_emp, id_emp_ant, datatu, id_usa_inc, id_usa_atu) VALUES (:nome, :cpf, :senha, :datinc, :situac, :rg, :celular, :email, :telefone, :id_mun, :dataadmissao, :datanascimento, :ctps, :pis, :cbo, :titulo_eleitor, :datarescisao, :funcao, :dataopcao, :tpsalario, :endereco, :complemento, :bairro, :dependentes, :salario, :numero, :id_dep, :id_usa_gestor, :sexo, :escolaridade, :linkedin, :cep, :id_emp, :id_emp_ant, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':dataadmissao', $dataadmissao, PDO::PARAM_STR);
    $statement->bindParam(':datanascimento', $datanascimento, PDO::PARAM_STR);
    $statement->bindParam(':ctps', $ctps, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':cbo', $cbo, PDO::PARAM_STR);
    $statement->bindParam(':titulo_eleitor', $titulo_eleitor, PDO::PARAM_STR);
    $statement->bindParam(':datarescisao', $datarescisao, PDO::PARAM_STR);
    $statement->bindParam(':funcao', $funcao, PDO::PARAM_STR);
    $statement->bindParam(':dataopcao', $dataopcao, PDO::PARAM_STR);
    $statement->bindParam(':tpsalario', $tpsalario, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
    $statement->bindParam(':salario', $salario, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_gestor', $id_usa_gestor, PDO::PARAM_INT);
    $statement->bindParam(':sexo', $sexo, PDO::PARAM_STR);
    $statement->bindParam(':escolaridade', $escolaridade, PDO::PARAM_STR);
    $statement->bindParam(':linkedin', $linkedin, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU select Valida para update - revisado em 14/01/2022 08:45
function validaGESUSU_campos($id_usu)
{
    global $pdo;
    // $query = 'SELECT CASE WHEN datanascimento IS NULL OR dataadmissao IS NULL OR tpsalario IS NULL OR SEXO IS NULL THEN FALSE ELSE TRUE END AS VALIDA FROM public."GESUSU" WHERE id_usu =:id_usu';
    $query = 'SELECT CASE WHEN cpf IS NULL THEN FALSE ELSE TRUE END AS VALIDA FROM public."GESUSU" WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultset as $linha) {
            if ($linha['valida'] == true) {
                $result = true;
            } else {
                $result = false;
            }
        }
    }

    return $result;
}

//Tabela GESUSU update - revisado em 23/12/2021 11:00
function updateGESUSU_alterar_funcionario(
    $nome,
    $cpf,
    $rg,
    $celular,
    $email,
    $telefone,
    $id_mun,
    $dataadmissao,
    $datanascimento,
    $ctps,
    $pis,
    $cbo,
    $titulo_eleitor,
    $datarescisao,
    $funcao,
    // $dataopcao,
    $tpsalario,
    $endereco,
    $complemento,
    $bairro,
    $dependentes,
    $salario,
    $numero,
    $id_dep,
    $id_usa_gestor,
    $sexo,
    $escolaridade,
    $agrdep,
    $linkedin,
    $cod_integracao,
    $cep,
    $bloqueado,
    $id_emp,
    // $id_emp_ant,
    $id_usu,
    $datatu,
    // $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET nome =:nome, cpf =:cpf, rg =:rg, celular =:celular, email =:email, telefone =:telefone, id_mun =:id_mun, dataadmissao =:dataadmissao, datanascimento =:datanascimento, ctps =:ctps, pis =:pis, cbo =:cbo, titulo_eleitor = :titulo_eleitor, datarescisao =:datarescisao, funcao =:funcao, tpsalario =:tpsalario, endereco =:endereco, complemento =:complemento, bairro =:bairro, dependentes =:dependentes, salario =:salario, numero =:numero, id_dep =:id_dep, id_usa_gestor =:id_usa_gestor, sexo =:sexo, escolaridade =:escolaridade, agrdep =:agrdep, linkedin =:linkedin, cod_integracao =:cod_integracao, cep =:cep, bloqueado =:bloqueado, id_emp =:id_emp, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':dataadmissao', $dataadmissao, PDO::PARAM_STR);
    $statement->bindParam(':datanascimento', $datanascimento, PDO::PARAM_STR);
    $statement->bindParam(':ctps', $ctps, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':cbo', $cbo, PDO::PARAM_STR);
    $statement->bindParam(':titulo_eleitor', $titulo_eleitor, PDO::PARAM_STR);
    $statement->bindParam(':datarescisao', $datarescisao, PDO::PARAM_STR);
    $statement->bindParam(':funcao', $funcao, PDO::PARAM_STR);
    // $statement->bindParam(':dataopcao', $dataopcao, PDO::PARAM_STR);
    $statement->bindParam(':tpsalario', $tpsalario, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
    $statement->bindParam(':salario', $salario, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_gestor', $id_usa_gestor, PDO::PARAM_INT);
    $statement->bindParam(':sexo', $sexo, PDO::PARAM_STR);
    $statement->bindParam(':escolaridade', $escolaridade, PDO::PARAM_STR);
    $statement->bindParam(':agrdep', $agrdep, PDO::PARAM_STR);
    $statement->bindParam(':linkedin', $linkedin, PDO::PARAM_STR);
    $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':bloqueado', $bloqueado, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    // $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    // $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update - revisado em 08/12/2021 08:51
function updateGESUSU(
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $rg,
    $celular,
    $email,
    $telefone,
    $id_mun,
    $dataadmissao,
    $datanascimento,
    $ctps,
    $pis,
    $cbo,
    $datarescisao,
    $funcao,
    $dataopcao,
    $tpsalario,
    $endereco,
    $complemento,
    $bairro,
    $dependentes,
    $salario,
    $numero,
    $id_dep,
    $sexo,
    $escolaridade,
    $cep,
    $id_emp,
    $id_emp_ant,
    $id_usu,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET nome =:nome, cpf =:cpf, senha =:senha, datinc =:datinc, situac =:situac, rg =:rg, celular =:celular, email =:email, telefone =:telefone, id_mun =:id_mun, dataadmissao =:dataadmissao, datanascimento =:datanascimento, ctps =:ctps, pis =:pis, cbo =:cbo, datarescisao =:datarescisao, funcao =:funcao, dataopcao =:dataopcao, tpsalario =:tpsalario, endereco =:endereco, complemento =:complemento, bairro =:bairro, dependentes =:dependentes, salario =:salario, numero =:numero, id_dep =:id_dep, sexo =:sexo, escolaridade =:escolaridade, cep =:cep, id_emp =:id_emp, id_emp_ant =:id_emp_ant, datatu =:datatu, id_usa_inc =:id_usa_inc, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':dataadmissao', $dataadmissao, PDO::PARAM_STR);
    $statement->bindParam(':datanascimento', $datanascimento, PDO::PARAM_STR);
    $statement->bindParam(':ctps', $ctps, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':cbo', $cbo, PDO::PARAM_STR);
    $statement->bindParam(':datarescisao', $datarescisao, PDO::PARAM_STR);
    $statement->bindParam(':funcao', $funcao, PDO::PARAM_STR);
    $statement->bindParam(':dataopcao', $dataopcao, PDO::PARAM_STR);
    $statement->bindParam(':tpsalario', $tpsalario, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
    $statement->bindParam(':salario', $salario, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':sexo', $sexo, PDO::PARAM_STR);
    $statement->bindParam(':escolaridade', $escolaridade, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update - revisado em 08/12/2021 08:51
function updateGESUSU_SITUAC(
    $situac,
    $id_emp,
    $id_usu,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET situac =:situac, id_emp =:id_emp, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update datarescisao - FEA-001
function updateGESUSU_DATARESCISAO($id_usu, $datarescisao)
{
    global $pdo;
    $query = 'UPDATE public."GESUSU" SET datarescisao = :datarescisao WHERE id_usu = :id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':datarescisao', $datarescisao, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU delete
function deleteGESUSU($id_usu)
{
    global $pdo;
    $query = 'DELETE FROM public."GESUSU" WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU delete - revisado 16/12/2021 08:41
function deleteGESUSU_in(array $id_usu)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_usu), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESUSU" WHERE id_usu IN(' . $inQuery . ')');
    foreach ($id_usu as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU($id_usu)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, titulo_eleitor, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_dep, sexo, escolaridade, cep, id_emp, id_emp_ant, datatu, id_usa_inc, id_usa_atu, agrdep, linkedin, cod_integracao, bloqueado FROM public."GESUSU" WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESVIN insert
function insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESVIN"(tabvin1, id_tab1, tabvin2, id_tab2) VALUES (:tabvin1, :id_tab1, :tabvin2, :id_tab2)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tabvin1', $tabvin1, PDO::PARAM_STR);
    $statement->bindParam(':id_tab1', $id_tab1, PDO::PARAM_INT);
    $statement->bindParam(':tabvin2', $tabvin2, PDO::PARAM_STR);
    $statement->bindParam(':id_tab2', $id_tab2, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESVIN update
function updateGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2, $id_vin)
{
    global $pdo;
    $query =
        'UPDATE public."GESVIN" SET tabvin1 =:tabvin1, id_tab1 =:id_tab1, tabvin2 =:tabvin2, id_tab2 =:id_tab2	WHERE id_vin =:id_vin';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tabvin1', $tabvin1, PDO::PARAM_STR);
    $statement->bindParam(':id_tab1', $id_tab1, PDO::PARAM_INT);
    $statement->bindParam(':tabvin2', $tabvin2, PDO::PARAM_STR);
    $statement->bindParam(':id_tab2', $id_tab2, PDO::PARAM_INT);
    $statement->bindParam(':id_vin', $id_vin, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESVIN delete
function deleteGESVIN($id_vin)
{
    global $pdo;
    $query = 'DELETE FROM public."GESVIN" WHERE id_vin =:id_vin';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_vin', $id_vin, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESVIN select
function selectGESVIN($id_vin)
{
    global $pdo;
    $query =
        'SELECT id_vin, tabvin1, id_tab1, tabvin2, id_tab2 FROM public."GESVIN" WHERE id_vin =:id_vin';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_vin', $id_vin, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

////////////////////////////////////////////////////////////////////////VIEWS////////////////////////////////////////////////////////////////////////////////////////////////////

//View VW_EMPRESA select - revisado em 10/12/2021 14:29
function buscaRaizCNPJ($id_emp)
{
    global $pdo;
    $query = 'SELECT raiz_cnpj from public."VW_EMPRESA" WHERE id_emp = :id_emp';
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

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function selectRECIBO_PAGAMENTO($raizCNPJ, $situac)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(datinc,id_emp, id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    id_usu,
    id_im1,
    competencia,
    data_credito,
    id_emp,
    descricao,
    nome,
    cargo,
    formatar_moeda(sum(vlr_vencimento)) AS vlr_vencimento,
    formatar_moeda(sum(vlr_desconto)) AS vlr_desconto,
    formatar_moeda(sum(vlr_liquido)) AS vlr_liquido,
    formatar_moeda(sum(faixa_irrf)) AS faixa_irrf,
    formatar_moeda(sum(vlr_basesalario)) AS vlr_basesalario,
    formatar_moeda(sum(vlr_baseinss)) AS vlr_baseinss,
    formatar_moeda(sum(vlr_basefgts)) AS vlr_basefgts,
    formatar_moeda(sum(vlr_baseirrf)) AS vlr_baseirrf,
    formatar_moeda(sum(vlr_baseir)) AS vlr_baseir,
    formatar_moeda(sum(vlr_fgts)) AS vlr_fgts 
    FROM public."GESIM1_' . $raizCNPJ . '" where situac = ' . $situac . ' GROUP BY id_usu, id_im1,
    competencia,
    datinc,
    id_emp, 
    descricao, 
    nome,
    cargo,
    data_credito,
    datinc
    order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View Totalizador RECIBO_PAGAMENTO_ENVIADO select - revisado em 02/03/2022 10:13
function selectTOTAL_RECIBO_PAGAMENTO_ENVIADO($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT formatar_moeda(sum(vlr_liquido)) AS vlr_liquido, sum(vlr_liquido) as valor_original, id_processamento,(SELECT arquivo FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento =:id_processamento and situac IN (0,1,2,3,4) limit 1) as arquivo
    FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento =:id_processamento and situac IN (0,1,2,3,4)
    group by id_processamento';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function selectRECIBO_PAGAMENTO_ENVIADO($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(datinc,id_emp, id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    motrep,
    id_usu,
    id_im1,
    competencia,
    data_credito,
    id_emp,
    descricao,
    nome,
    cargo,
    situac,
    situac_visualizar,
    arquivo,
    formatar_moeda(sum(vlr_vencimento)) AS vlr_vencimento,
    formatar_moeda(sum(vlr_desconto)) AS vlr_desconto,
    formatar_moeda(sum(vlr_liquido)) AS vlr_liquido,
    formatar_moeda(sum(faixa_irrf)) AS faixa_irrf,
    formatar_moeda(sum(vlr_basesalario)) AS vlr_basesalario,
    formatar_moeda(sum(vlr_baseinss)) AS vlr_baseinss,
    formatar_moeda(sum(vlr_basefgts)) AS vlr_basefgts,
    formatar_moeda(sum(vlr_baseirrf)) AS vlr_baseirrf,
    formatar_moeda(sum(vlr_baseir)) AS vlr_baseir,
    formatar_moeda(sum(vlr_fgts)) AS vlr_fgts 
    FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento =:id_processamento and situac IN (0,1,2,3,4) GROUP BY id_usu, id_im1,
    motrep,
    competencia,
    datinc,
    id_emp, 
    descricao, 
    nome,
    cargo,
    situac,
    situac_visualizar,
    data_credito,
    datinc
    order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function selectRECIBO_PAGAMENTO_ENVIADO_situac($raizCNPJ, $situac, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(datinc,id_emp, id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    id_usu,
    id_im1,
    competencia,
    data_credito,
    id_emp,
    descricao,
    nome,
    cargo,
    situac,
    formatar_moeda(sum(vlr_vencimento)) AS vlr_vencimento,
    formatar_moeda(sum(vlr_desconto)) AS vlr_desconto,
    formatar_moeda(sum(vlr_liquido)) AS vlr_liquido,
    formatar_moeda(sum(faixa_irrf)) AS faixa_irrf,
    formatar_moeda(sum(vlr_basesalario)) AS vlr_basesalario,
    formatar_moeda(sum(vlr_baseinss)) AS vlr_baseinss,
    formatar_moeda(sum(vlr_basefgts)) AS vlr_basefgts,
    formatar_moeda(sum(vlr_baseirrf)) AS vlr_baseirrf,
    formatar_moeda(sum(vlr_baseir)) AS vlr_baseir,
    formatar_moeda(sum(vlr_fgts)) AS vlr_fgts 
    FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento =:id_processamento and situac =:situac GROUP BY id_usu, id_im1,
    competencia,
    datinc,
    id_emp, 
    descricao, 
    nome,
    cargo,
    situac,
    data_credito,
    datinc
    order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO select - revisado em 09/12/2021 13:53
function selectRECIBO_PAGAMENTO_NOME($raizCNPJ, $id)
{
    global $pdo;
    $query = 'SELECT id_im1,replace(replace(replace(concat(datinc,id_emp, id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    id_usu,
    competencia,
    data_credito,
    id_emp,
    descricao,
    nome,
    cargo,
    sum(vlr_vencimento) AS vlr_vencimento,
    sum(vlr_desconto) AS vlr_desconto,
    sum(vlr_liquido) AS vlr_liquido,
    sum(faixa_irrf) AS faixa_irrf,
    sum(vlr_basesalario) AS vlr_basesalario,
    sum(vlr_baseinss) AS vlr_baseinss,
    sum(vlr_basefgts) AS vlr_basefgts,
    sum(vlr_baseirrf) AS vlr_baseirrf,
    sum(vlr_baseir) AS vlr_baseir,
    sum(vlr_fgts) AS vlr_fgts 
    FROM public."GESIM1_' . $raizCNPJ . '" where situac = 0 
    and  id_im1 = \'' . $id . '\'
    GROUP BY id_im1,id_usu, 
    competencia,
    datinc,
    id_emp, 
    descricao, 
    nome,
    cargo,
    data_credito,
    datinc
    order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectRECIBO_PAGAMENTO_ITENS($raizCNPJ, $id)
{
    global $pdo;
    // $query = 'SELECT a.id_im1,replace(replace(replace(concat(a.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    // a.codevento,
    // a.nome,
    // round(a.quantidade,2)AS quantidade,
    // formatar_moeda(CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END) AS vencimentos,
    // formatar_moeda(CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END) AS descontos,
    // CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END AS vencimentos_val,
    // CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END AS descontos_val,
    // a.id_im1,
    // a.datinc 
    // FROM public."GESIM2_' . $raizCNPJ . '" a 
    // LEFT JOIN public."GESEVE" b ON a.id_eve = b.id_eve 
    // LEFT JOIN public."GESIM1_' . $raizCNPJ . '" c ON a.id_im1 = c.id_im1
    // where  a.id_im1 = \'' . $id . '\'
    // ORDER BY a.id_im2';


    // UTILIZAÇÃO DA GESIM2
    // $query = 'SELECT a.id_im1,replace(replace(replace(concat(a.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    // a.codevento,
    // a.nome,
    // round(a.quantidade,2)AS quantidade,
    // formatar_moeda(CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END) AS vencimentos,
    // formatar_moeda(CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END) AS descontos,
    // CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END AS vencimentos_val,
    // CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END AS descontos_val,
    // a.id_im1,
    // a.datinc , NULL as arquivo,a.id_im2 AS id_im2
    // FROM public."GESIM2_' . $raizCNPJ . '" a
    // LEFT JOIN public."GESEVE" b ON a.id_eve = b.id_eve
    // LEFT JOIN public."GESIM1_' . $raizCNPJ . '" c ON a.id_im1 = c.id_im1
    // where a.id_im1 = \'' . $id . '\'
    // union
    // select c.id_im1 as id_im1 ,replace(replace(replace(concat(c.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id, NULL as codevento, NULL as nome, 0 as quantidade, NULL AS vencimentos, NULL AS descontos, 0 as vencimentos_val,
    // 0 AS descontos_val, c.id_im1, c.datinc , c.arquivo as arquivo,0 AS id_im2
    // FROM public."GESIM1_' . $raizCNPJ . '" c
    // where c.id_im1 = \'' . $id . '\'
    // ORDER BY id_im2';

    $query = 'SELECT c.id_im1 as id_im1 ,replace(replace(replace(concat(c.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id, NULL as codevento, NULL as nome, 0 as quantidade, NULL AS vencimentos, NULL AS descontos, 0 as vencimentos_val,
    0 AS descontos_val, c.id_im1, c.datinc , c.arquivo as arquivo,0 AS id_im2
    FROM public."GESIM1_' . $raizCNPJ . '" c
    where c.id_im1 = \'' . $id . '\'
    ORDER BY id_im2';

    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_EMPRESA select - revisado em 10/12/2021 14:31
function select_VW_EMPRESA($id_emp)
{
    global $pdo;
    $query = 'SELECT null as id_emp,null as nome,null as cnpj,null as email,null as endereco,null as numero,null as bairro,cep,null as situac,null as complemento,null as imagem,
    id_mun,null as telefone,null as valges,null as tipo,null as id_emp_h,null as id_emp_p,null as id_emp_i,null as resp_financeiro, null as email_financeiro, null as id_usa_rh, null as id_usa_ouv, null as nomefantasia,"GESMUN".nome as cidade,"GESEST".nome as estado from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' )
    union
    SELECT id_emp,nome,cnpj,email,endereco, numero,bairro,cep,situac,complemento,imagem,id_mun, telefone, valges,tipo,id_emp_h,id_emp_p,id_emp_i,resp_financeiro,email_financeiro,id_usa_rh,id_usa_ouv,nomefantasia, cidade, estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' order by  id_emp desc';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_ESTADO($id_emp)
{
    global $pdo;
    $query = 'SELECT  id_emp,   estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' group by id_emp,id_mun,   estado
    union
    SELECT null as id_emp,"GESEST".nome as estado 
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' ) group by    "GESEST".nome
    order by  id_emp asc, estado';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_CIDADE($id_emp, $estado)
{
    global $pdo;
    $query = 'SELECT  id_emp,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_EMPRESA" where id_emp=' . $id_emp . '
    union
    SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' and id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' )
    order by  id_emp asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 14/12/2021 09:24
function select_CIDADE_ESTADO($estado)
{
    global $pdo;
    $query = 'SELECT null as id_emp, id_mun,"GESMUN".nome as cidade, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome =' . $estado . ' 
    order by  id_emp asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU_EMPRESA($id_emp)
{
    global $pdo;
    $query = 'SELECT id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc FROM public."GESUSU" where id_emp=:id_emp';
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

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_ESTADO_id_usu($id_usu)
{
    global $pdo;
    $query = 'SELECT  id_usu,   estado FROM public."VW_USUARIOS" where id_usu=' . $id_usu . ' group by id_usu,id_mun,   estado
    union
    SELECT null as id_usu,"GESEST".nome as estado 
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_USUARIOS" where id_emp=' . $id_usu . ' ) group by    "GESEST".nome
    order by  id_usu asc, estado';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_CIDADE_id_usu($id_usu, $estado)
{
    global $pdo;
    $query = 'SELECT  id_usu,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_USUARIOS" where id_usu=' . $id_usu . '
    union
    SELECT null as id_usu,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' and id_mun not in ( SELECT id_mun FROM public."VW_USUARIOS" where id_usu=' . $id_usu . ' )
    order by  id_usu asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function select_VW_USUARIOS($id_emp, $id_usa)
{
    global $pdo;
    $query = 'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
    , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo, imagem, imagem_aprovacao
    , (SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=:id_emp LIMIT 1) as verificacao_usa_rh
    , case when imagem isnull and imagem_aprovacao isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
    FROM public."VW_USUARIOS" where id_emp=:id_emp order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function select_VW_USUARIOS_RAIZ_CNPJ($raiz_cnpj, $id_usa)
{
    global $pdo;
    $query = 'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
    , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo , imagem, imagem_aprovacao
    , coalesce((SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=x.id_emp),\'N\') as verificacao_usa_rh
    , case when imagem isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
    FROM public."VW_USUARIOS" as x where raiz_cnpj=:raiz_cnpj order by nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 14/12/2021 09:24
function select_CIDADE_ESTADO_idusu($estado)
{
    global $pdo;
    $query = 'SELECT null as id_emp, id_mun,"GESMUN".nome as cidade, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome =' . $estado . ' 
    order by  id_emp asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_ADMIN_EMPACESS select - revisado em 28/12/2021 14:59
function selectVW_ADMIN_EMPACESS($id_usa)
{
    global $pdo;
    $query = 'SELECT id_usa,
    id_con, 
    id_emp, 
    nome, 
    cnpj, 
    id_emp_default, 
    imagem, 
    id_per, 
    perfil, 
    formatar_moeda(vlr_contrato)as vlr_contrato, 
    to_char(datini, \'DD/MM/YYYY\') AS datini,
    to_char(datfim, \'DD/MM/YYYY\') AS datfim,
    perc_emp, 
    perc_con, 
    complemento,
    formatar_moeda(((vlr_contrato * perc_emp)/100))valor_emp,
    formatar_moeda(((vlr_contrato * perc_con)/100))valor_con
    FROM public."VW_ADMIN_EMPACESS" WHERE id_usa =:id_usa order by id_con';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_ADMIN_EMPACESS select - revisado em 07/02/2021 15:59
function selectVW_ADMIN_MINHACONTA($id_usa)
{
    global $pdo;
    $query = 'SELECT id_usa,
    id_con, 
    id_emp, 
    nome, 
    cnpj, 
    id_emp_default, 
    imagem, 
    id_per, 
    perfil, 
    formatar_moeda(vlr_contrato)as vlr_contrato, 
    to_char(datini, \'DD/MM/YYYY\') AS datini,
    to_char(datfim, \'DD/MM/YYYY\') AS datfim,
    perc_emp, 
    perc_con, 
    complemento,
    formatar_moeda(((vlr_contrato * perc_emp)/100))valor_emp,
    formatar_moeda(((vlr_contrato * perc_con)/100))valor_con
    FROM public."VW_ADMIN_EMPACESS" WHERE id_usa =:id_usa and  id_con is not null  order by id_con';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT HOLERITE - revisado em 03/01/2022 15:24
function select_VERIFICA_TABELA($raiz_cnpj)
{
    global $pdo;
    $query = 'SELECT EXISTS(SELECT FROM information_schema.tables WHERE  table_name = \'GESIM1_' . $raiz_cnpj . '\')';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT CONSULTA EMAIL - revisado em 22/01/2022 09:14
function consulta_email($email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_ADMIN_GACESSO" WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT CONSULTA CONTRASENHA - revisado em 22/01/2022 09:14
function consulta_contrasenha($contrasenha, $email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_ADMIN_GACESSO" WHERE contrasenha = :contrasenha and email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':contrasenha', $contrasenha, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU update - revisado em 22/01/2021 16:02
function update_contrasenha_GESUSU(
    $id_usa,
    $contrasenha
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA" SET contrasenha =:contrasenha WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':contrasenha', $contrasenha, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update - revisado em 22/01/2021 16:02
function update_senha_GESUSU(
    $senha,
    $email
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA" SET senha =:senha, situac_senha = 1 WHERE email =:email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT VW_APP_EMPACESS - revisado em 03/01/2022 09:14
function select_GESEMP_email(
    $email
) {
    global $pdo;
    $query = 'SELECT a.* from public."GESEMP" as a LEFT OUTER JOIN  public."GESUSA" as b on a.id_emp=b.id_emp where b.email= :email
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESACE select - revisado em 25/01/2022 13:55
function select_VW_GESACE($id_emp)
{
    global $pdo;
    $query = 'SELECT id,usuario,empresa,ip, to_char(datatu, \'DD/MM/YYYY HH24:MM\') AS  datatu
    ,datatu as data , to_char(datatu, \'YYYY/MM/DD HH24:MM\') AS  datatu1,RANK () OVER ( 
		ORDER BY datatu desc 
	) rank
    FROM public."VW_GESACE" 
    where id_emp=:id_emp';

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

//SELECT CONSULTA EMAIL - revisado em 01/02/2022 09:14
function select_consulta_email($email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_ADMIN_GACESSO" WHERE email = :email';
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

//Tabela GESUSA update - revisado em 22/01/2021 16:02
function troca_senha_GESUSU(
    $senha,
    $datatu,
    $id_usa_atu,
    $id_usu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET senha =:senha, datatu =:datatu, id_usa_atu =:id_usa_atu, situac_senha = 1 WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
}

function selectESPELHO_PONTO($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.id_usu,
    a.id_pon1,
    a.periodo,
    a.id_emp,
    b.nome,
    b.funcao,
    a.btotal,
    a.bsaldo, 
    a.situac, 
    a.arquivo,
    a.situac_visualizar
    FROM public."GESPON1_' . $raizCNPJ . '" as a left outer join  public."GESUSU" as b on a.id_usu=b.id_usu where id_processamento =:id_processamento
    order by b.nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

function selectESPELHO_PONTO_situac($raizCNPJ, $situac, $situac_visualizar, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.id_usu,
    a.id_pon1,
    a.periodo,
    a.id_emp,
    b.nome,
    b.funcao,
    a.btotal,
    a.bsaldo, 
    a.situac, 
    a.situac_visualizar
    FROM public."GESPON1_' . $raizCNPJ . '" as a left outer join  public."GESUSU" as b on a.id_usu=b.id_usu
    where id_processamento =:id_processamento and a.situac =:situac and a.situac_visualizar =:situac_visualizar
    order by b.nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':situac_visualizar', $situac_visualizar, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 deleteGESPON1_in - revisado 22/12/2021 07:48
function deleteGESPON1_in(array $id_pon1, $tabela)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_pon1), '?'));
    $statement = $pdo->prepare('DELETE FROM ' . $tabela . ' WHERE id_pon1 IN(' . $inQuery . ')');
    foreach ($id_pon1 as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESPON1 updateGESPON1_in - revisado em 07/02/2022 07:47
function updateGESPON1_in(array $id_pon1, $tabela, $situac)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_pon1), '?'));
    $query =
        $statement = $pdo->prepare('UPDATE ' . $tabela . ' SET situac =' . $situac . '	 WHERE id_pon1 IN (' . $inQuery . ')');
    foreach ($id_pon1 as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESIM1 selectPONTO_DADOS - revisado em 08/05/2023 10:23
function selectPONTO_DADOS($raizCNPJ, $id)
{
    global $pdo;
    $query = 'SELECT SUBSTRING(a.periodo,1,10)  periodo_inicio, SUBSTRING(a.periodo,16,20) periodo_final, a.periodo, a.pis, a.btotal,a.bsaldo, b.nome, a.origem FROM public."GESPON1_' . $raizCNPJ . '" a left join "GESUSU" b on a.id_usu = b.id_usu where id_pon1 = \'' . $id . '\' LIMIT 1';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectRECIBO_PONTO_ITENS($raizCNPJ, $id)
{
    global $pdo;
    // $query = 'SELECT c.id_pon1,replace(replace(replace(concat(c.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    // a.ent1,
    // a.sai1,
    // a.ent2,
    // a.sai2,
    // a.ent3,
    // a.sai3,
    // a.btotal,
    // a.bsaldo,
    // c.arquivo,

    // a.id_pon2,
    // to_char(a.data, \'DD/MM/YYYY\') AS data

    // FROM public."GESPON2_' . $raizCNPJ . '" a 
    // RIGHT JOIN public."GESPON1_' . $raizCNPJ . '" c ON a.id_pon1 = c.id_pon1
    // where  c.id_pon1 = \'' . $id . '\'
    // ORDER BY a.id_pon2';
    $query = 'SELECT id_pon1,replace(replace(replace(concat(datinc,id_emp, id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    arquivo
    FROM public."GESPON1_' . $raizCNPJ . '"
    where  id_pon1 = \'' . $id . '\'';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 selectPONTO_DADOS - revisado em 04/02/2022 08:30
function selectINFORME_DADOS($raizCNPJ, $id)
{
    global $pdo;
    $query = 'SELECT a.anocal, a.anoexe, b.nome, a.origem FROM public."GESIRR_' . $raizCNPJ . '" a left join "GESUSU" b on a.id_usu = b.id_usu where id_irr = \'' . $id . '\' LIMIT 1';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectINFORME_ITENS($raizCNPJ, $id_irr)
{
    global $pdo;
    $query = 'SELECT arquivo
    FROM public."GESIRR_' . $raizCNPJ . '" 
    where id_irr = :id_irr';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectRECIBO_DIVERSOS_ITENS($raizCNPJ, $id_rec)
{
    global $pdo;
    $query = 'SELECT arquivo
    FROM public."GESREC_' . $raizCNPJ . '" 
    where id_rec = :id_rec';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_rec', $id_rec, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectRECIBO_IMPOSTO_ITENS($raizCNPJ, $id_irr)
{
    global $pdo;
    $query = 'SELECT arquivo
    FROM public."GESIRR_' . $raizCNPJ . '" 
    where id_irr = :id_irr';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESCTO select
function selectGESCTO_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESCTO" WHERE id_emp =:id_emp ORDER BY nome';
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

//Tabela GESCTO insert - revisado em 09/02/2022 15:16
function insertGESCTO(
    $nome,
    $descricao,
    $telefone1,
    $telefone2,
    $telefone3,
    $email,
    $website,
    $datinc,
    $datatu,
    $situac,
    $id_emp,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESCTO"(nome, descricao, telefone1, telefone2, telefone3, email, website, datinc, datatu, situac, id_emp, id_usa_inc, id_usa_atu) VALUES (:nome, :descricao, :telefone1, :telefone2, :telefone3, :email, :website, :datinc, :datatu, :situac, :id_emp, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':telefone1', $telefone1, PDO::PARAM_STR);
    $statement->bindParam(':telefone2', $telefone2, PDO::PARAM_STR);
    $statement->bindParam(':telefone3', $telefone3, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':website', $website, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESCTO update - revisado em 09/02/2022 15:17
function updateGESCTO_situac(
    $id_cto,
    $situac,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESCTO" SET situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu where id_cto =:id_cto';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_cto', $id_cto, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU delete - revisado 16/12/2021 08:41
function deleteGESCTO_in(array $id_cto)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_cto), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESCTO" WHERE id_cto IN(' . $inQuery . ')');
    foreach ($id_cto as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESCTO update - revisado em 09/02/2022 15:17
function updateGESCTO_campos(
    $nome,
    $descricao,
    $telefone1,
    $telefone2,
    $telefone3,
    $email,
    $website,
    $datatu,
    $id_usa_atu,
    $id_cto
) {
    global $pdo;
    $query =
        'UPDATE public."GESCTO" SET nome =:nome, descricao =:descricao, telefone1 =:telefone1, telefone2 =:telefone2, telefone3 =:telefone3, email =:email, website =:website, datatu =:datatu, id_usa_atu =:id_usa_atu where id_cto =:id_cto';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':telefone1', $telefone1, PDO::PARAM_STR);
    $statement->bindParam(':telefone2', $telefone2, PDO::PARAM_STR);
    $statement->bindParam(':telefone3', $telefone3, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':website', $website, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_cto', $id_cto, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESCTO select
function selectGESCTO_id_cto($id_cto)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESCTO" WHERE id_cto =:id_cto';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_cto', $id_cto, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA select - revisado em 08/12/2021 08:55
function select_GESUSA_USUARIOS($id_emp)
{
    global $pdo;
    $query = 'SELECT id_usa,nome,gestor,id_tus,situac,email from public."VW_ADMIN_USUARIOS" where id_emp=:id_emp';
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

//Tabela GESUSU update - revisado em 08/12/2021 08:51
function updateGESUSA_SITUAC(
    $situac,
    $id_usa,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA" SET situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 select periodos processados - revisado em 23/12/2021 10:20
function selectLOTES_processados($raizCNPJ, $id_emp)
{
    global $pdo;
    $query = 'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc ,a.datinc as data ,CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIM1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento,sum(a.vlr_liquido) as vlr_liquido
    FROM public."GESIM1_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.competencia
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESPON1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento,NULL as vlr_liquido
    FROM public."GESPON1_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.periodo
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIRR_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento,NULL as vlr_liquido
    FROM public."GESIRR_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.anocal
    
    
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESREC_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento,NULL as vlr_liquido
    FROM public."GESREC_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.descricao
    
    
    ORDER BY data desc
    
';

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


//Tabela GESIM1 select periodos processados - revisado em 23/12/2021 10:20
function selectLOTES_processados1($raizCNPJ, $id_emp)
{
    global $pdo;
    $query = 'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc ,a.datinc as data ,CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIM1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
    ,sum(a.vlr_liquido) as vlr_liquido
    ,(SELECT COUNT(ID_IM1) FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
    ,0 as inconsistencia_irrf
    ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
    FROM public."GESIM1_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.competencia
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESPON1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
    ,NULL as vlr_liquido
    ,(SELECT COUNT(ID_PON1) FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
    ,0 as inconsistencia_irrf
    ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESPON1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
    FROM public."GESPON1_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.periodo
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIRR_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
    ,NULL as vlr_liquido
    ,(SELECT COUNT(ID_IRR) FROM public."GESIRR_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
    ,(SELECT count(id_processamento) as contagem FROM public."GESIRR_' . $raizCNPJ . '"  where anocal is null and id_processamento = a.id_processamento) as inconsistencia_irrf
    ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIRR_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq

    FROM public."GESIRR_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.anocal
    
    
    UNION
    SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
    ,(select CASE
    WHEN z.situac =\'0\' THEN \'0\'
    WHEN z.situac =\'1\' THEN \'1\'
    WHEN z.situac =\'2\' THEN \'2\'
    WHEN z.situac =\'3\' THEN \'2\'
    WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESREC_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
    ,NULL as vlr_liquido
    ,(SELECT COUNT(ID_REC) FROM public."GESREC_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
    ,0 as inconsistencia_irrf
    ,0 as inconsistencia_regarq
    FROM public."GESREC_' . $raizCNPJ . '" as a
    left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
    where a.situac<>9 and id_emp =:id_emp
    group by a.id_processamento,a.datinc,b.nome ,a.origem,a.descricao
    
    
    ORDER BY data desc
    
';

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

//Tabela LOTES_PROCESSADOS_situac select - revisado em 30/05/2023 14:01
function selectLOTES_situac($raizCNPJ, $id_emp, $case)
{
    global $pdo;

    switch ($case) {

        case 'H':
            $query =
                'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc ,a.datinc as data ,CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIM1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,sum(a.vlr_liquido) as vlr_liquido
                ,(SELECT COUNT(ID_IM1) FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
                FROM public."GESIM1_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.competencia
                ORDER BY data desc';
            break;

        case 'P':
            $query =
                'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESPON1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_PON1) FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESPON1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
                FROM public."GESPON1_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.periodo
                ORDER BY data desc';
            break;

        case 'I':
            $query =
                'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIRR_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_IRR) FROM public."GESIRR_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,(SELECT count(id_processamento) as contagem FROM public."GESIRR_' . $raizCNPJ . '"  where anocal is null and id_processamento = a.id_processamento) as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIRR_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
            
                FROM public."GESIRR_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.anocal
                ORDER BY data desc';
            break;

        case 'R':
            $query =
                'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESREC_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_REC) FROM public."GESREC_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,0 as inconsistencia_regarq
                FROM public."GESREC_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.descricao
                ORDER BY data desc';
            break;

        default:
            $query =
                'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc ,a.datinc as data ,CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIM1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,sum(a.vlr_liquido) as vlr_liquido
                ,(SELECT COUNT(ID_IM1) FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
                FROM public."GESIM1_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.competencia
                UNION
                SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESPON1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_PON1) FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESPON1_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq
                FROM public."GESPON1_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.periodo
                UNION
                SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIRR_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_IRR) FROM public."GESIRR_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,(SELECT count(id_processamento) as contagem FROM public."GESIRR_' . $raizCNPJ . '"  where anocal is null and id_processamento = a.id_processamento) as inconsistencia_irrf
                ,(SELECT case when regarq = count(id_processamento) then 0 ELSE 1 end as contagem   FROM public."GESIRR_' . $raizCNPJ . '" where id_processamento=a.id_processamento group by regarq) as inconsistencia_regarq

                FROM public."GESIRR_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.anocal
                
                
                UNION
                SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,a.datinc as data,CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tipo,a.origem ,split_part(b.nome, \' \', 1) as nome
                ,(select CASE
                WHEN z.situac =\'0\' THEN \'0\'
                WHEN z.situac =\'1\' THEN \'1\'
                WHEN z.situac =\'2\' THEN \'2\'
                WHEN z.situac =\'3\' THEN \'2\'
                WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESREC_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
                ,NULL as vlr_liquido
                ,(SELECT COUNT(ID_REC) FROM public."GESREC_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO = a.id_processamento) as quantidade_visualizado
                ,0 as inconsistencia_irrf
                ,0 as inconsistencia_regarq
                FROM public."GESREC_' . $raizCNPJ . '" as a
                left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
                where a.situac<>9 and id_emp =:id_emp
                group by a.id_processamento,a.datinc,b.nome ,a.origem,a.descricao
                
                ORDER BY data desc';
            break;
    }
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


//Tabela GESTUS select - revisado em 22/02/2023 13:33
function selectGESTUS()
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESTUS" WHERE id_tus != 1 AND situac = 1';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU insert - revisado em 08/12/2021 08:49
function insertGESUSA_usuario($nome, $cpf, $senha, $datinc, $situac, $email, $telefone, $gestor, $id_tus, $id_mun, $id_dep, $id_emp_acess, $id_per, $datatu, $id_usa_atu)
{
    global $pdo;
    $query = 'INSERT INTO public."GESUSA"(nome, cpf, senha, datinc, situac, email, telefone, gestor, id_tus, id_mun, id_dep, id_emp_acess, id_per, datatu, id_usa_atu) VALUES (:nome, :cpf, :senha, :datinc, :situac, :email, :telefone, :gestor, :id_tus, :id_mun, :id_dep, :id_emp_acess, :id_per, :datatu, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':gestor', $gestor, PDO::PARAM_INT);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA insert com retorno do ID gerado
function insertGESUSA_RETID($nome, $cpf, $senha, $datinc, $situac, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_tus, $id_mun, $id_dep, $id_emp_acess, $id_per, $datatu, $id_usa_atu)
{
    global $pdo;
    $query = 'INSERT INTO public."GESUSA"(nome, cpf, senha, datinc, situac, email, telefone, endereco, bairro, complemento, numero, cep, id_tus, id_mun, id_dep, id_emp_acess, id_per, datatu, id_usa_atu) 
        VALUES (:nome, :cpf, :senha, :datinc, :situac, :email, :telefone, :endereco, :bairro, :complemento, :numero, :cep, :id_tus, :id_mun, :id_dep, :id_emp_acess, :id_per, :datatu, :id_usa_atu)
        RETURNING id_usa as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_usa = $statement->fetch(PDO::FETCH_ASSOC);

    return $id_usa;
}

//Tabela GESVIN_usuario insert - revisado em 08/12/2021 08:49
function insertGESVIN_usuario($id_emp, $id_usa)
{
    global $pdo;
    $query = 'insert into public."GESVIN" (tabvin1,id_tab1,tabvin2,id_tab2) values (\'GESEMP\',:id_emp,\'GESUSA\',:id_usa)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESVI2_usuario insert - revisado em 22/02/2023 13:49
function insertGESVI2_usuario($id_per, $id_tus, $id_emp)
{
    global $pdo;
    $query = 'INSERT INTO public."GESVI2" (tabvin1, id_tab1, tabvin2, id_tab2, id_emp) VALUES (\'GESPER\', :id_per, \'GESTUS\', :id_tus, :id_emp)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESVI2_usuario select - revisado em 22/02/2023 16:05
function selectGESVI2_usuario($id_per, $id_tus, $id_emp)
{
    global $pdo;
    $query = 'SELECT * FROM public."GESVI2" WHERE id_tab1 = :id_per AND id_tab2 = :id_tus AND id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        $resultset = 1;
    } else {
        $resultset = 0;
    }

    return $resultset;
}

//Tabela GESUSA select - revisado em 08/12/2021 08:55
function select_GESUSA_id_usa($id_usa)
{
    global $pdo;
    $query = 'SELECT * FROM public."GESUSA" WHERE id_usa= :id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESDEP_id_usa($id_usa, $id_emp)
{
    global $pdo;
    $query =
        'SELECT a.id_dep as id,a.id_dep as id_dep,b.nome as departamento FROM public."GESUSA" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usa =:id_usa and a.situac=1
        union
        SELECT null as id,c.id_dep as id_dep, c.nome as departamento FROM public."GESDEP" as c WHERE c.situac=1 AND c.id_emp =:id_emp and c.id_dep not in (SELECT coalesce(a.id_dep, 0) FROM public."GESUSA" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usa =:id_usa)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectVW_ADMIN_USUARIOS($id_usa)
{
    global $pdo;
    $query =
        'SELECT * FROM public."VW_ADMIN_USUARIOS" WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_ESTADO_id_usa($id_usa)
{
    global $pdo;
    $query = 'SELECT  id_usa,   estado FROM public."VW_ADMIN_USUARIOS" where id_usa=' . $id_usa . ' group by id_usa,id_mun,   estado
    union
    SELECT null as id_usa,"GESEST".nome as estado 
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_ADMIN_USUARIOS" where id_emp=' . $id_usa . ' ) group by    "GESEST".nome
    order by  id_usa asc, estado';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

function select_CIDADE_id_usa($id_usa, $estado)
{
    global $pdo;
    $query = 'SELECT  id_usa,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_ADMIN_USUARIOS" where id_usa=' . $id_usa . '
    union
    SELECT null as id_usa,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' and id_mun not in ( SELECT id_mun FROM public."VW_ADMIN_USUARIOS" where id_usa=' . $id_usa . ' )
    order by  id_usa asc, cidade';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA select - revisado em 08/12/2021 08:55
function select_VW_ADMIN_USUARIOS($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT * FROM public."VW_ADMIN_USUARIOS" WHERE id_usa= :id_usa and id_emp= :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTUS select - revisado em 07/03/2023 14:39
function selectGESTUS_id_usa($id_usa)
{
    global $pdo;
    $query =
        'SELECT 1 as id,a.id_tus as id_tus,b.descricao as descricao FROM public."GESUSA" as a 
            left outer join public."GESTUS" as b on a.id_tus=b.id_tus 
                WHERE a.id_usa =:id_usa
            union
        SELECT 2 as id,c.id_tus as id_tus, c.descricao as descricao FROM public."GESTUS" as c 
            WHERE c.situac=1 and c.id_tus not in 
                ((SELECT a.id_tus FROM public."GESUSA" as a left outer join public."GESTUS" as b on a.id_tus=b.id_tus WHERE a.id_usa =:id_usa),1) 
        order by id asc
';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA update
function updateGESUSA_usuario($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_tus, $id_mun, $id_dep, $id_usa, $datatu, $id_usa_atu)
{
    global $pdo;
    $query = 'UPDATE public."GESUSA" SET nome=:nome, cpf=:cpf, email=:email, telefone=:telefone, endereco=:endereco, bairro=:bairro, complemento=:complemento, numero=:numero, cep=:cep, id_tus=:id_tus, id_mun=:id_mun, id_dep=:id_dep, datatu=:datatu, id_usa_atu=:id_usa_atu WHERE id_usa=:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA update
function updateGESUSA_usuario_sem_id_tus($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_mun, $id_dep, $id_usa, $datatu, $id_usa_atu)
{
    global $pdo;
    $query = 'UPDATE public."GESUSA" SET nome=:nome, cpf=:cpf, email=:email, telefone=:telefone, endereco=:endereco, bairro=:bairro, complemento=:complemento, numero=:numero, cep=:cep, id_mun=:id_mun, id_dep=:id_dep, datatu=:datatu, id_usa_atu=:id_usa_atu WHERE id_usa=:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA update - revisado em 22/01/2021 16:02
function troca_senha_GESUSA(
    $senha,
    $datatu,
    $id_usa_atu,
    $id_usa
) {
    global $pdo;
    $situac_senha = 1;
    $query =
        'UPDATE public."GESUSA" SET senha =:senha, datatu =:datatu, id_usa_atu =:id_usa_atu, situac_senha = ' . $situac_senha . ' WHERE id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTUS select - revisado em 17/12/2021 08:33
function selectVW_ADMIN_GACESSO_situac($id_usa)
{
    global $pdo;
    $query =
        'SELECT situac from public."VW_ADMIN_GACESSO" where id_usa =:id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function select_LOTE_RECIBO($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT count(id_im1) as contagem 
    FROM public."GESIM1_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento and situac IN (3,4)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function select_LOTE_PONTO($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT count(id_pon1) as contagem 
    FROM public."GESPON1_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento and situac IN (2)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

function delete_LOTE($tabela, $raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'DELETE FROM public."' . $tabela . '_' . $raizCNPJ . '" WHERE id_processamento =:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_count_geseve($id_emp, $raizCNPJ, $id_processamento)
{
    global $pdo;
    $query =

        'SELECT count(id_eve) as contagem FROM public."GESEVE" WHERE id_emp = :id_emp and tipo =\'P\' and CODEVENTO IN
(SELECT CODEVENTO FROM public."GESIM2_' . $raizCNPJ . '" as a INNER JOIN public."GESIM1_' . $raizCNPJ . '" as b on a.id_im1=b.id_im1
 where b.id_processamento=:id_processamento)';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_count_visualizado($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = '   SELECT COUNT(ID_IM1) 
    + (SELECT COUNT(ID_PON1) AS C2 FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO =:id_processamento ) 
    + (SELECT COUNT(ID_IRR) AS C2 FROM public."GESIRR_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO =:id_processamento )
    + (SELECT COUNT(ID_REC) AS C2 FROM public."GESREC_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO =:id_processamento )  AS CONTAGEM
    FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO =:id_processamento';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_contagem_0($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = '   SELECT COUNT(ID_IM1) 
    + (SELECT COUNT(ID_PON1) AS C2 FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 0  AND ID_PROCESSAMENTO =:id_processamento ) 
    + (SELECT COUNT(ID_IRR) AS C2 FROM public."GESIRR_' . $raizCNPJ . '" WHERE SITUAC = 0  AND ID_PROCESSAMENTO =:id_processamento )
    + (SELECT COUNT(ID_REC) AS C2 FROM public."GESREC_' . $raizCNPJ . '" WHERE SITUAC = 0  AND ID_PROCESSAMENTO =:id_processamento )  AS CONTAGEM
    FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (0) AND ID_PROCESSAMENTO =:id_processamento';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_inconsistencia_irrf($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT count(id_processamento) as contagem, id_processamento FROM public."GESIRR_' . $raizCNPJ . '"
    where anocal is null and id_processamento = :id_processamento
    group by id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_inconsistencia_regarq($tabela, $id_processamento)
{
    global $pdo;
    $query = 'SELECT case when regarq = count(id_processamento) then \'0\' ELSE \'1\' end as contagem, regarq as total_localizado,count(id_processamento) as total_importado, id_processamento
    FROM ' . $tabela . ' where id_processamento=:id_processamento group by regarq,id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPON1 / GESIM1 update - revisado em 22/02/2021 08:58
function update_lote(
    $tabela,
    $raizCNPJ,
    $situac,
    $id_processamento
) {
    global $pdo;
    $query =
        'UPDATE public."' . $tabela . '_' . $raizCNPJ . '" SET situac =:situac WHERE id_processamento =:id_processamento and situac <> 9';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function selectVW_ADMIN_USUARIOS_id_emp_id_usa($id_emp, $id_usa)
{
    global $pdo;
    $query = 'SELECT importar, aceitar FROM public."VW_ADMIN_USUARIOS" WHERE id_emp =:id_emp and id_usa =:id_usa
    ';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 delete - revisado em 21/02/2022 10:00
// function delete_LOTE($tabela, $raizCNPJ, $id_processamento)
// {
//     global $pdo;
//     $query = 'DELETE FROM public."' . $tabela . '_' . $raizCNPJ . '" WHERE id_processamento =:id_processamento';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

//Tabela GESIM1 delete
function deleteGESPON1($raizCNPJ, $id_pon1)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESPON1_' . $raizCNPJ . '" WHERE id_pon1 =:id_pon1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pon1', $id_pon1, PDO::PARAM_INT);
    $statement->execute();
}

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function select_LOTE_IRRF($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT count(id_irr) as contagem 
    FROM public."GESIRR_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento and situac IN (2)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

function selectIMPOSTO_RENDA($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.id_usu,
    a.id_irr,
    a.anocal,
    a.id_emp,
    b.nome,
    b.funcao,
    a.ren_3_1,
    a.anoexe, 
    a.situac, 
    a.situac_visualizar,
    a.arquivo
    FROM public."GESIRR_' . $raizCNPJ . '" as a left outer join  public."GESUSU" as b on a.id_usu=b.id_usu where id_processamento =:id_processamento
    order by b.nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

function selectIMPOSTO_RENDA_situac($raizCNPJ, $situac, $situac_visualizar, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.id_usu,
    a.id_irr,
    a.anocal,
    a.id_emp,
    b.nome,
    b.funcao,
    a.ren_3_1,
    a.anoexe, 
    a.situac, 
    a.situac_visualizar
    FROM public."GESIRR_' . $raizCNPJ . '" as a left outer join  public."GESUSU" as b on a.id_usu=b.id_usu
    where id_processamento =:id_processamento and a.situac =:situac and a.situac_visualizar =:situac_visualizar
    order by b.nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':situac_visualizar', $situac_visualizar, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 delete
function deleteGESIRR($raizCNPJ, $id_irr)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESIRR_' . $raizCNPJ . '" WHERE id_irr =:id_irr';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTRE select
function selectGESTRE_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT a.id_tre, a.id_emp, a.nome, a.link, a.anexo, a.situac, a.id_dep , CASE WHEN b.nome=\'NÃO PREENCHIDO\' THEN \'TODOS\' else b.nome END  as departamento
        FROM public."GESTRE" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep 
        WHERE a.id_emp =:id_emp
        ';
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

//Tabela GESTRE insert
function insertGESTRE($id_emp, $id_dep, $nome, $link, $anexo, $situac, $datinc, $datatu, $id_usa_inc, $id_usa_atu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESTRE"(id_emp, id_dep, nome, link, anexo, situac, datinc, datatu, id_usa_inc, id_usa_atu)
        VALUES (:id_emp, :id_dep, :nome, :link, :anexo, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)
        RETURNING id_tre as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_tre = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_tre;
}

//Tabela GESTRE update
function updateGESTRE_situac($id_emp, $situac, $id_tre, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESTRE" SET id_emp =:id_emp, situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_tre =:id_tre';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTRE select
function selectGESTRE($id_tre)
{
    global $pdo;
    $query =
        'SELECT id_tre, id_emp, nome, link, anexo, situac FROM public."GESPOL" WHERE id_tre =:id_tre';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESTOR_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT 0 as id_usa,\'NÃO PREENCHIDO\' as nome from public."VW_ADMIN_USUARIOS" WHERE  id_usa=1 and id_emp =:id_emp
        union    
        SELECT id_usa,nome from public."VW_ADMIN_USUARIOS" WHERE gestor =1 and id_usa<>1 and id_emp =:id_emp                       
        ';
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

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESTOR_id_usu($id_usu, $id_emp)
{
    global $pdo;
    $query =
        'SELECT \'1\'as rank, a.id_usa_gestor as id_usa,coalesce(b.nome,\'NÃO PREENCHIDO\') as nome
        FROM public."GESUSU" as a
        left outer join public."GESUSA" as b on a.id_usa_gestor=b.id_usa WHERE a.id_usu =:id_usu
        UNION
        select \'2\' as rank,id_usa,nome from public."VW_ADMIN_USUARIOS" WHERE gestor=1 and id_usa<>1 and id_emp=:id_emp and id_usa not in (
        SELECT a.id_usa_gestor
        FROM public."GESUSU" as a
        left outer join public."GESUSA" as b on a.id_usa_gestor=b.id_usa WHERE a.id_usu =:id_usu )
        order by rank          
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU update
function updateGESUSU_FOTO($imagem, $id_usu, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET imagem =:imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU_FOTO($id_usu)
{
    global $pdo;
    $query =
        'SELECT imagem FROM public."GESUSU" WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select - revisado em 08/12/2021 08:55
function selectGESEMP_FOTO($id_emp)
{
    global $pdo;
    $query =
        'SELECT imagem FROM public."GESEMP" WHERE id_emp =:id_emp';
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

//Tabela GESUSU update
function updateGESEMP_FOTO($imagem, $id_emp, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESEMP" SET imagem =:imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP select - revisado em 08/12/2021 08:55
function selectVWEMPRESA_tipo_beneficio($id_emp, $raiz_cnpj)
{
    global $pdo;
    $query =
        'SELECT 1 AS RANK ,ID_EMP,CONCAT(CNPJ,\' - \',NOMEFANTASIA) AS NOMEFANTASIA FROM public."VW_EMPRESA" WHERE ID_EMP =:id_emp
        UNION
        SELECT 2 AS RANK ,ID_EMP,CONCAT(CNPJ,\' - \',NOMEFANTASIA) AS NOMEFANTASIA FROM public."VW_EMPRESA" WHERE RAIZ_CNPJ =:raiz_cnpj AND ID_EMP <>:id_emp
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESUSU_usuario($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome FROM public."GESUSU" WHERE id_emp =:id_emp and situac =1
        order by nome asc
        ';
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

//Tabela GESREC insert
function insertGESREC($raiz_cnpj, $id_emp, $id_usu, $origem, $arquivo, $id_processamento, $id_validador, $descricao, $datinc, $id_usa_inc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESREC_' . $raiz_cnpj . '"(id_emp, id_usu, origem, arquivo, id_processamento, id_validador, descricao, datinc, id_usa_inc) VALUES (:id_emp, :id_usu, :origem, :arquivo, :id_processamento, :id_validador, :descricao, :datinc, :id_usa_inc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->execute();
}

//View select_LOTE_GESREC select - revisado em 21/12/2021 14:10
function select_LOTE_GESREC($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT count(id_rec) as contagem
    FROM public."GESREC_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento and situac IN (2)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View select_LOTE_GESREC select - revisado em 21/12/2021 14:10
function select_GESREC_arquivo($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT arquivo 
    FROM public."GESREC_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela DELETE ID EM TABELA - revisado 22/12/2021 07:48
function delete_id_in(array $id_item, $tabela, $campo)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_item), '?'));
    $statement = $pdo->prepare('DELETE FROM "' . $tabela . '" WHERE "' . $campo . '" IN(' . $inQuery . ')');
    foreach ($id_item as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela SELECT ID EM TABELA - revisado 22/12/2021 07:48
function select_id_in(array $id_item, $tabela, $campo)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_item), '?'));
    $statement = $pdo->prepare('SELECT * FROM "' . $tabela . '" WHERE "' . $campo . '" IN(' . $inQuery . ')');
    foreach ($id_item as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $resultset = [0];
        }
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultset = 23503;
        }
    }

    return $resultset;
}

function selectRECIBOS_DIVERSOS($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.id_usu,
    a.id_rec,
    a.arquivo,
    a.descricao,
    a.origem,
    a.id_emp,
    b.nome,
    b.funcao, 
    a.situac, 
    a.situac_visualizar,
    a.motrep,
    a.resprep
    FROM public."GESREC_' . $raizCNPJ . '" as a left outer join  public."GESUSU" as b on a.id_usu=b.id_usu where id_processamento =:id_processamento
    order by b.nome asc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTRE delete
function deleteGESTRE($id_tre)
{
    global $pdo;
    $query = 'DELETE FROM public."GESTRE" WHERE id_tre =:id_tre';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTRE select
function selectGESTRE_anexo($id_tre)
{
    global $pdo;
    $query =
        'SELECT anexo FROM public."GESTRE" WHERE id_tre =:id_tre
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select
function selectGESEMP_layouts($id_emp)
{
    global $pdo;
    $query =
        'SELECT a.layout, a.layout_ponto, a.layout_irrf,b.lay_h,b.lay_p,b.lay_i,b.gvc,b.fpd
        FROM public."GESEMP" as a
        LEFT OUTER JOIN public."GESLAY" as b on a.id_emp=b.id_emp
        WHERE a.id_emp =:id_emp
        ';
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

//Tabela GESEMP select
function selectEMAIL_LOTES($id_emp, $id_processamento, $raizCNPJ)
{
    global $pdo;
    $query =
        'SELECT  \'H\' as tipo, c.nome,c.email,a.id_processamento
    
        FROM public."GESIM1_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
        left outer join public."GESUSU" as c on a.id_usu=c.id_usu
where a.situac not in (0,1,9) and c.situac = 1 and a.id_emp =:id_emp and a.id_processamento = :id_processamento
and c.email is not null
        

                                                       UNION
SELECT \'P\' as tipo, c.nome,c.email,a.id_processamento

FROM public."GESPON1_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
        left outer join public."GESUSU" as c on a.id_usu=c.id_usu
where a.situac not in (0,1,9) and c.situac = 1 and a.id_emp =:id_emp and a.id_processamento = :id_processamento
and c.email is not null

                                                       UNION
SELECT  \'I\' as tipo, c.nome,c.email,a.id_processamento

FROM public."GESIRR_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
        left outer join public."GESUSU" as c on a.id_usu=c.id_usu
where a.situac not in (0,1,9) and c.situac = 1 and a.id_emp =:id_emp and a.id_processamento = :id_processamento
and c.email is not null

        UNION
SELECT  \'R\' as tipo, c.nome,c.email,a.id_processamento
        
FROM public."GESREC_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
        left outer join public."GESUSU" as c on a.id_usu=c.id_usu
where a.situac not in (0,1,9) and c.situac = 1 and a.id_emp =:id_emp and a.id_processamento = :id_processamento
and c.email is not null

        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectCOUNT_GESMNU($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT count(id_mnu) as contagem FROM public."GESMNU" as a where a.id_mnu not in (
    select b.id_mnu from public."GESMPR" b where b.id_usa=:id_usa and b.id_emp=:id_emp)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function select_TELAS_INSERT($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT (id_mnu) FROM public."GESMNU" as a where a.id_mnu not in ( select b.id_mnu from public."GESMPR" b where b.id_usa=:id_usa and b.id_emp=:id_emp)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectTELAS_USUARIO($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT a.*,coalesce((select b.situac from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as situac

    ,coalesce((select b.id_mpr from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_mpr
    
    FROM public."GESMNU" as a
    
    ORDER BY a.ordem';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTRE insert
function insertGESMNU($id_usa, $id_emp, $contagem, $datatu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMPR"(id_usa, id_emp, id_mnu, datatu)
    VALUES (:id_usa, :id_emp, :contagem, :datatu);';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':contagem', $contagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESUSU update
function updateGESMPR($situac, $id_mpr)
{
    global $pdo;
    $query =
        'UPDATE public."GESMPR"
        SET situac=:situac
        WHERE id_mpr=:id_mpr;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mpr', $id_mpr, PDO::PARAM_INT);
    $statement->execute();
}

// //View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
// function selectMENUS_USUARIO($id_usa, $id_emp)
// {
//     global $pdo;
//     $query = 'SELECT a.*,coalesce((select b.situac from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as situac

//     ,coalesce((select b.id_mpr from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_mpr

//     FROM public."GESMNU" as a where a.nivel <> \'0\' and a.estagio = 1

//     ORDER BY a.ordem';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
//     $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

// //View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
// function selectITENS_MENUS_USUARIO($id_usa, $id_emp, $nivel)
// {
//     global $pdo;
//     $query = 'SELECT a.*,coalesce((select b.situac from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as situac

//     ,coalesce((select b.id_mpr from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_mpr

//     FROM public."GESMNU" as a where a.nivel <> \'0\' and a.estagio = 2 and a.nivel like :nivel

//     ORDER BY a.ordem';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
//     $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
//     $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectMENUS_USUARIO($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT a.*,b.situac,b.id_mpr
    FROM public."GESMNU" as a left outer join public."GESMPR" as b on b.id_mnu=a.id_mnu 
    where  b.id_usa=:id_usa and b.id_emp=:id_emp and b.situac = 1 and a.estagio=1
    ORDER BY a.ordem
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectITENS_MENUS_USUARIO($id_usa, $id_emp, $nivel)
{
    global $pdo;
    $query = 'SELECT a.*,b.situac,b.id_mpr
    FROM public."GESMNU" as a left outer join public."GESMPR" as b on b.id_mnu=a.id_mnu 
    where  b.id_usa=:id_usa and b.id_emp=:id_emp and b.situac = 1 and a.nivel like :nivel
    ORDER BY a.ordem
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUR select
function selectGESMUR_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT

        RANK () OVER (
        
        ORDER BY a.datinc DESC
        
        ) rank, a.id_mur, a.id_emp, a.titulo, a.mensagem, a.anexo, a.situac, a.id_dep, a.enviado, a.datval , case when a.datval >= CURRENT_DATE then 1 else 0 end as valido
        , case        
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.pdf\' then \'ARQUIVO\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.jpg\' then \'IMAGEM\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.png\' then \'IMAGEM\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-4,5) =\'.jpeg\' then \'IMAGEM\' else \'ERRO\' end as tipo_anexo
        , CASE WHEN b.nome=\'NÃO PREENCHIDO\' THEN \'TODOS\' else b.nome END as departamento
        FROM public."GESMUR" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep 
        WHERE a.id_emp =:id_emp 
        order by a.datinc desc
        ';
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

//Tabela GESMUR insert
function insertGESMUR(
    $id_emp,
    $id_dep,
    $titulo,
    $anexo,
    $mensagem,
    $situac,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESMUR" (id_emp, id_dep, titulo, anexo, mensagem, situac, datinc, datatu, id_usa_inc, id_usa_atu) 
        VALUES (:id_emp, :id_dep, :titulo, :anexo, :mensagem, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)
        RETURNING id_mur as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_mur = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_mur;
}

//Tabela GESMUR update
function updateGESMUR_situac($id_emp, $situac, $id_mur, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESMUR" SET id_emp =:id_emp, situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_mur =:id_mur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMUR select
function selectGESMUR_anexo($id_mur)
{
    global $pdo;
    $query =
        'SELECT anexo FROM public."GESMUR" WHERE id_mur =:id_mur
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUR delete
function deleteGESMUR($id_mur)
{
    global $pdo;
    $query = 'DELETE FROM public."GESMUR" WHERE id_mur =:id_mur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMUR select
function selectGESMUR_id_mur($id_mur)
{
    global $pdo;
    $query =
        'SELECT mensagem FROM public."GESMUR"
        WHERE id_mur =:id_mur
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select
function selectGESMUR_email($id_mur)
{
    global $pdo;
    $query =
        'SELECT a.email,a.nome,b.titulo
        from public."GESUSU" as a
        inner join public."GESMUR" as b on a.id_emp=b.id_emp and a.id_dep=b.id_dep
        where a.email is not null
        and b.id_dep<>0 and b.id_mur=:id_mur and a.situac=1
        union
        select a.email,a.nome,b.titulo
        from public."GESUSU" as a
        inner join public."GESMUR" as b on a.id_emp=b.id_emp
        where a.email is not null
        and b.id_dep=0 and b.id_mur=:id_mur and a.situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select
function updateGESMUR_email($id_mur)
{
    global $pdo;
    $query =
        'UPDATE public."GESMUR"
        SET enviado =1 where id_mur=:id_mur
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela GESNOT select
function selectGESNOT_id_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT

        RANK () OVER (
        
        ORDER BY a.datinc DESC
        
        ) rank, a.id_not, a.id_emp, a.titulo, a.mensagem, a.anexo, a.situac, a.enviado
        , case when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.pdf\' then \'ARQUIVO\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.jpg\' then \'IMAGEM\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-3,4) =\'.png\' then \'IMAGEM\'
        when substring(a.anexo, CHAR_LENGTH(a.anexo)-4,5) =\'.jpeg\' then \'IMAGEM\'
        else \'ERRO\' end as tipo_anexo , b.nome as usuario, a.id_usu
        FROM public."GESNOT" as a left outer join public."GESUSU" as b on a.id_usu=b.id_usu 
        WHERE a.id_emp =:id_emp
        order by a.datinc desc
        ';
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

//Tabela GESNOT insert
function insertGESNOT(
    $id_emp,
    $id_usu,
    $titulo,
    $anexo,
    $mensagem,
    $situac,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESNOT" (id_emp, id_usu, titulo, anexo, mensagem, situac, datinc, datatu, id_usa_inc, id_usa_atu)
            VALUES (:id_emp, :id_usu, :titulo, :anexo, :mensagem, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT update
function updateGESNOT_situac($id_emp, $situac, $id_not, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESNOT" SET id_emp =:id_emp, situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_not =:id_not';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT select
function selectGESNOT_email($id_not)
{
    global $pdo;
    $query =
        'SELECT a.email,a.nome,b.titulo , c.nome as nome_cc, c.email as email_cc
        from public."GESUSU" as a
        inner join public."GESNOT" as b on a.id_usu=b.id_usu
        left outer join public."GESUSA" as c on b.id_usa_inc=c.id_usa
        where a.email is not null
        and b.id_not=:id_not and a.situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESNOT select
function updateGESNOT_email($id_not)
{
    global $pdo;
    $query =
        'UPDATE public."GESNOT"
        SET enviado =1 where id_not=:id_not
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESNOT select
function selectGESNOT_anexo($id_not)
{
    global $pdo;
    $query =
        'SELECT anexo FROM public."GESNOT" WHERE id_not =:id_not
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESNOT delete
function deleteGESNOT($id_not)
{
    global $pdo;
    $query = 'DELETE FROM public."GESNOT" WHERE id_not =:id_not';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT select
function selectENVIO_EMAIL_IMPORTACAO($id_emp)
{
    global $pdo;
    $query =
        'SELECT a.nome,a.email,b.nomefantasia,b.cnpj,a.situac FROM public."VW_ADMIN_USUARIOS" AS a
        inner join public."GESEMP" as b on a.id_emp=b.id_emp
        WHERE a.id_emp=:id_emp AND a.importar=\'NAO\' AND a.aceitar=\'SIM\' AND a.tipo_usuario=\'EMPRESA\' AND a.situac=1
        ';
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

//SELECT DADOS EMPRESA E FUNCIONARIO HOLERITE - revisado em 03/01/2022 15:24
function select_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj, $id_processamento)
{
    global $pdo;

    $query =
        'SELECT
        b.resp_financeiro,b.email_financeiro,
        a.ID_PROCESSAMENTO,b.imagem as logo_empresa,b.nome as empresa,b.nomefantasia,b.cnpj,b.endereco as endereco_empresa,b.numero as numero_empresa,b.bairro as bairro_empresa,b.complemento as complemento_empresa,b.cep as cep_empresa
        , b.telefone as telefone_empresa ,c.nome as cidade_empresa,d.sigla as uf_empresa
        ,a.competencia,e.cpf,a.nome,a.cargo,a.VLR_LIQUIDO
        FROM public."GESIM1_' . $raiz_cnpj . '" as a
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp
        left outer join public."GESMUN" as c on c.id_mun=b.id_mun
        left outer join public."GESEST" as d on d.id_est=c.id_est
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        where a.ID_PROCESSAMENTO= :id_processamento and b.email_financeiro is not null  
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT COUNT - revisado em 03/01/2022 15:24
function select_COUNT_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj, $id_processamento)
{
    global $pdo;

    $query =
        'SELECT count(a.ID_PROCESSAMENTO) as contagem
        FROM public."GESIM1_' . $raiz_cnpj . '" as a
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp
        left outer join public."GESMUN" as c on c.id_mun=b.id_mun
        left outer join public."GESEST" as d on d.id_est=c.id_est
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        where a.ID_PROCESSAMENTO= :id_processamento and b.email_financeiro is not null
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT COUNT - revisado em 03/01/2022 15:24
function select_ENVIA_EMAIL_RELATORIO_RECIBO_PAGAMENTO($raiz_cnpj, $id_processamento)
{
    global $pdo;

    $query =
        'SELECT b.resp_financeiro,b.email_financeiro,a.ID_PROCESSAMENTO,b.nomefantasia,b.cnpj
        FROM public."GESIM1_' . $raiz_cnpj . '" as a
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp       
        left outer join public."GESMUN" as c on c.id_mun=b.id_mun
        left outer join public."GESEST" as d on d.id_est=c.id_est
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        where a.ID_PROCESSAMENTO= :id_processamento and b.email_financeiro is not null limit 1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESGES insert - revisado em 08/12/2021 08:49
function insertGESGES($id_usa, $id_emp, $gestor)
{
    global $pdo;
    $query = 'INSERT INTO public."GESGES" (id_usa, id_emp, gestor) VALUES (:id_usa, :id_emp, :gestor)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':gestor', $gestor, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESGES update
function updateGESGES($id_usa, $id_emp, $gestor)
{
    global $pdo;
    $query = 'UPDATE public."GESGES" SET gestor = :gestor WHERE id_usa = :id_usa AND id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':gestor', $gestor, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP select - revisado em 08/12/2021 08:55
function selectRESP_RH($id_emp)
{
    global $pdo;
    $query =
        'SELECT \'1\'as rank, a.id_usa_rh as id_usa,coalesce(b.nome,\'NÃO PREENCHIDO\') as nome
        FROM public."GESEMP" as a left outer join public."GESUSA" as b on a.id_usa_rh=b.id_usa
        WHERE b.situac<>0 and id_tus in(2, 3) 
                               and case when a.id_emp <> 11 then b.id_usa<>39 else b.id_usa<>0 end
                               and a.id_emp =:id_emp
        UNION
        select \'2\' as rank,id_usa,nome from public."VW_ADMIN_USUARIOS"
        WHERE id_usa<>1 and situac<>0 and id_tus in(2, 3) 
                               and case when id_emp <> 11 then id_usa<>39 else id_usa<>0 end
                               and id_emp=:id_emp and id_usa
        not in ( SELECT coalesce(a.id_usa_rh,0) FROM public."GESEMP" as a left outer join public."GESUSA" as b on a.id_usa_rh=b.id_usa
        WHERE a.id_emp =:id_emp ) order by rank

        ';
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

//Tabela GESEMP select - revisado em 08/12/2021 08:55
function selectRESP_OUVIDORIA($id_emp)
{
    global $pdo;
    $query =
        'SELECT \'1\'as rank, a.id_usa_ouv as id_usa,coalesce(b.nome,\'NÃO PREENCHIDO\') as nome
        FROM public."GESEMP" as a left outer join public."GESUSA" as b on a.id_usa_ouv=b.id_usa
        WHERE b.situac<>0 and id_tus in(2, 3) 
                               and case when a.id_emp <> 11 then b.id_usa<>39 else b.id_usa<>0 end
                               and a.id_emp =:id_emp
        UNION        
        select \'2\' as rank,id_usa,nome from public."VW_ADMIN_USUARIOS"
        WHERE id_usa<>1 and situac<>0 and id_tus in(2, 3) 
                               and case when id_emp <> 11 then id_usa<>39 else id_usa<>0 end
                               and id_emp=:id_emp and id_usa
        not in ( SELECT coalesce(a.id_usa_ouv,0) FROM public."GESEMP" as a left outer join public."GESUSA" as b on a.id_usa_ouv=b.id_usa
        WHERE a.id_emp =:id_emp ) order by rank

        ';
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

//Tabela GESSOL select - revisado 24/04/2023 12:56
function selectGESSOL($id_usa, $id_emp, $situac)
{
    global $pdo;
    switch ($situac) {

        case '9':
            $query =
                'SELECT RANK () OVER ( ORDER BY data DESC ) as rank,data,solicitacao,nome,tipo,gestor,usuario_alteracao,datinc,situac,id_sol,datatu,justificativa,mensagem,anexo,situac_usa_visualizar
                FROM (
                SELECT a.situac_usa_visualizar, a.datatu as data,a.datinc,a.situac,a.id_sol,a.datatu,a.justificativa,a.mensagem,c.descri as solicitacao,b.nome as nome ,\'RH\' AS TIPO,  substring(e.nome,0,POSITION(\' \' IN e.nome)) as gestor,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao,a.anexo
                FROM public."GESSOL" as a
                left outer join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                left outer join public."GESTSO" as c on a.id_tso=c.id_tso
                left outer join public."GESEMP" as d on a.id_emp=d.id_emp
                left outer join public."GESUSA" as e on e.id_usa=b.id_usa_gestor
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu
                where d.id_usa_rh=:id_usa and a.id_emp=:id_emp and a.situac <> :situac
                UNION
                SELECT a.situac_usa_visualizar,a.datinc as data,a.datinc,a.situac,a.id_sol,a.datatu,a.justificativa,a.mensagem,c.descri as solicitacao,b.nome as nome ,\'GS\' AS TIPO, substring(d.nome,0,POSITION(\' \' IN d.nome)) as gestor,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao,a.anexo
                FROM public."GESSOL" as a
                left outer join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                left outer join public."GESTSO" as c on a.id_tso=c.id_tso
                left outer join public."VW_ADMIN_USUARIOS" as d on a.id_emp=d.id_emp and b.id_usa_gestor= d.id_usa
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu where d.id_usa=:id_usa and a.id_emp=:id_emp and a.situac <> :situac
                ) as x
            ';
            break;

        default:
            $query =
                'SELECT RANK () OVER ( ORDER BY data DESC ) as rank,data,solicitacao,nome,tipo,gestor,usuario_alteracao,datinc,situac,id_sol,datatu,justificativa,mensagem,anexo,situac_usa_visualizar
                FROM (
                SELECT a.situac_usa_visualizar, a.datatu as data,a.datinc,a.situac,a.id_sol,a.datatu,a.justificativa,a.mensagem,c.descri as solicitacao,b.nome as nome ,\'RH\' AS TIPO,  substring(e.nome,0,POSITION(\' \' IN e.nome)) as gestor,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao,a.anexo
                FROM public."GESSOL" as a
                left outer join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                left outer join public."GESTSO" as c on a.id_tso=c.id_tso
                left outer join public."GESEMP" as d on a.id_emp=d.id_emp
                left outer join public."GESUSA" as e on e.id_usa=b.id_usa_gestor
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu
                where d.id_usa_rh=:id_usa and a.id_emp=:id_emp and a.situac = :situac
                UNION
                SELECT a.situac_usa_visualizar,a.datinc as data,a.datinc,a.situac,a.id_sol,a.datatu,a.justificativa,a.mensagem,c.descri as solicitacao,b.nome as nome ,\'GS\' AS TIPO, substring(d.nome,0,POSITION(\' \' IN d.nome)) as gestor,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao,a.anexo
                FROM public."GESSOL" as a
                left outer join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                left outer join public."GESTSO" as c on a.id_tso=c.id_tso
                left outer join public."VW_ADMIN_USUARIOS" as d on a.id_emp=d.id_emp and b.id_usa_gestor= d.id_usa
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu where d.id_usa=:id_usa and a.id_emp=:id_emp and a.situac = :situac
                ) as x
            ';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESSOL update
function updateGESSOL_aprovar($id_sol, $situac, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESSOL" SET situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_sol =:id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOL update
function updateGESSOL_aprovar2($id_sol, $situac, $datatu, $id_usa_atu, $resposta)
{
    global $pdo;
    $query =
        'UPDATE public."GESSOL"
            SET situac = :situac, datatu = :datatu, id_usa_atu = :id_usa_atu, justificativa = :resposta
            WHERE id_sol = :id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':resposta', $resposta, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESSOL update
function updateGESSOL_reprovar($id_sol, $situac, $justificativa, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESSOL" SET situac =:situac, justificativa =:justificativa, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_sol =:id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':justificativa', $justificativa, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOL update
function updateGESSOL_situac_visualizar($id_sol, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESSOL" SET situac_usa_visualizar = 1, id_usa_atu =:id_usa_atu WHERE id_sol =:id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT select
function select_EMAIL_RH($id_emp)
{
    global $pdo;
    $query =
        'SELECT g.nome,g.email
        FROM
        public."GESUSA" as g inner join
        public."GESEMP" as e on g.id_usa=e.id_usa_rh
        where id_emp=:id_emp
        ';
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

//Tabela GESOUV select - revisado 24/04/2023 14:20
function selectGESOUV($id_usa, $id_emp, $situac)
{
    global $pdo;
    switch ($situac) {

        case 9:
            $query =
                'SELECT RANK () OVER ( ORDER BY a.datinc DESC ) as rank,a.datinc,a.situac,a.id_ouv,a.datatu,a.mensagem,a.resposta,a.situac_usa_visualizar,c.descri as solicitacao,case when b.id_usu=0 then \'ANONIMO\' else b.nome end as nome ,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao
                FROM public."GESOUV" as a
                inner join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                inner join public."GESTSO" as c on a.id_tso=c.id_tso
                inner join public."GESEMP" as d on a.id_emp=d.id_emp
                left outer join public."VW_ADMIN_USUARIOS" as e on e.id_usa=b.id_usa_gestor
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu where d.id_usa_ouv=:id_usa and a.id_emp=:id_emp and a.situac <> :situac
                ';
            break;

        default:
            $query =
                'SELECT RANK () OVER ( ORDER BY a.datinc DESC ) as rank,a.datinc,a.situac,a.id_ouv,a.datatu,a.mensagem,a.resposta,a.situac_usa_visualizar,c.descri as solicitacao,case when b.id_usu=0 then \'ANONIMO\' else b.nome end as nome ,substring(f.nome,0,POSITION(\' \' IN f.nome)) as usuario_alteracao
                FROM public."GESOUV" as a
                inner join public."GESUSU" as b on a.id_usu_inc=b.id_usu
                inner join public."GESTSO" as c on a.id_tso=c.id_tso
                inner join public."GESEMP" as d on a.id_emp=d.id_emp
                left outer join public."VW_ADMIN_USUARIOS" as e on e.id_usa=b.id_usa_gestor
                left outer join public."GESUSA" as f on f.id_usa=a.id_usa_atu where d.id_usa_ouv=:id_usa and a.id_emp=:id_emp and a.situac = :situac
                ';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESSOL update
function updateGESOUV_resposta($id_ouv, $situac, $resposta, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESOUV" SET situac =:situac, resposta =:resposta, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_ouv =:id_ouv';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ouv', $id_ouv, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':resposta', $resposta, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT COUNT_MENSAGENS - revisado em 20/01/2022 15:24
function select_count_MENSAGENS_ADMIN($id_usa, $id_emp)
{
    global $pdo;

    $query =

        // SELECT count(id_im1) as contagem FROM public."GESIM1_'.$raiz_cnpj.'" where situac=2 and situac_visualizar=0 and id_usu = :id_usu

        'SELECT count(id_validador) as contagem
        FROM public."VW_MENSAGENS_ADMIN" where id_usa_ouv=:id_usa and id_emp = :id_emp
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT COUNT_MENSAGENS - revisado em 20/01/2022 15:24
function select_MENSAGENS_ADMIN($id_usa, $id_emp)
{
    global $pdo;

    $query =
        'SELECT RANK () OVER (ORDER BY datinc desc) rank,* FROM public."VW_MENSAGENS_ADMIN" WHERE id_usa_ouv = :id_usa and id_emp = :id_emp
';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPON1 update - revisado em 05/02/2022 07:56
function update_GESOUV_situac_visualizar(
    $id_ouv
) {
    global $pdo;
    $query =
        'UPDATE public."GESOUV" set situac_usa_visualizar = 1 where id_ouv = :id_ouv
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ouv', $id_ouv, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT select
function select_ENVIO_EMAIL_OUVIDORIA($id_ouv, $id_emp)
{
    global $pdo;
    $query =
        'SELECT \'O\' as tipo, c.nome as nome_envio,c.email as email_envio,a.id_ouv
        FROM public."GESOUV" as a
        left outer join public."GESUSU" as c on a.id_usu_inc=c.id_usu
        where a.id_emp =:id_emp
        and a.id_ouv = :id_ouv
        and c.email is not null
        union
        SELECT \'O\' as tipo, c.nome,c.email,a.id_ouv
        FROM public."GESOUV" as a
        left outer join public."GESUSU" as c on pgp_sym_decrypt(a.id_usu_ano::bytea, \'key\'::text)::integer=c.id_usu
        where a.id_emp =:id_emp
        and a.id_ouv = :id_ouv
        and c.email is not null
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ouv', $id_ouv, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU_FOTO_APROVACAO($id_usu)
{
    global $pdo;
    $query =
        'SELECT imagem,imagem_aprovacao FROM public."GESUSU" WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU update
function updateGESUSU_FOTO_APROV($imagem, $id_usu, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET imagem =:imagem, imagem_aprovacao = NULL, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update
function updateGESUSU_FOTO_REPROV($id_usu, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET imagem_aprovacao = NULL, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESNOT select
function select_EMAIL_COLABORADOR($id_usu)
{
    global $pdo;
    $query =
        'SELECT nome, email
        FROM
        public."GESUSU"
        where id_usu=:id_usu and situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESNOT select
function select_VW_ANIVERSARIOS_SEM_FILTRO_EMAIL($id_usu, $id_emp)
{
    global $pdo;
    $query =
        'SELECT nome, imagem_funcionario, imagem_empresa, prox_aniversario
        FROM
        public."VW_ANIVERSARIOS_SEM_FILTRO_EMAIL"
        where id_usu=:id_usu AND id_emp=:id_emp ORDER BY prox_aniversario ASC LIMIT 1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE select - revisado em 21/02/2022 10:00
function select_GESEVE_count_EVENTOS($id_emp, $raizCNPJ)
{
    global $pdo;
    $query =
        'SELECT count(id_eve) as contagem FROM public."GESEVE" WHERE id_emp = :id_emp and tipo =\'P\' and CODEVENTO IN
        (SELECT CODEVENTO FROM public."GESIM2_' . $raizCNPJ . '" as a INNER JOIN public."GESIM1_' . $raizCNPJ . '" as b on a.id_im1=b.id_im1)';
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

//Tabela GESEVE select - revisado em 29/06/2022 09:00
function selectGESEVE_EVENTOS($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESEVE" WHERE id_emp = :id_emp
        ';
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

//Tabela GRELAT select - revisado em 29/06/2022 09:00
function select_GRELAT($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GRELAT" where id_emp in (0, :id_emp)
        ';
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

//Tabela GRELAT select - revisado em 29/06/2022 09:00
function select_GRELAT_id_rel($id_rel)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GRELAT" where id_rel=:id_rel
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_rel', $id_rel, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_REL_DEPARTAMENTO_DADOS_EMPRESA select - revisado em 29/06/2022 09:00
function select_VW_REL_DEPARTAMENTO_DADOS_EMPRESA($id_emp)
{
    global $pdo;
    $query =
        'SELECT empresa, imagem FROM public."VW_REL_DEPARTAMENTO" WHERE id_emp=:id_emp GROUP BY empresa, imagem
        ';
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

//Tabela VW_REL_DEPARTAMENTO select - revisado em 29/06/2022 09:00
function select_VW_REL_DEPARTAMENTO_DADOS_DEPARTAMENTO($id_emp, $situac)
{
    global $pdo;
    $query =
        'SELECT id_dep, nome, situac_departamento FROM public."VW_REL_DEPARTAMENTO" WHERE id_emp=:id_emp and situac=:situac
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_REL_FUNCIONARIO select - revisado em 29/06/2022 09:00
function select_VW_REL_FUNCIONARIO_DADOS_EMPRESA($id_emp)
{
    global $pdo;
    $query =
        'SELECT imagem_empresa,empresa FROM public."VW_REL_FUNCIONARIO" WHERE id_emp=:id_emp
        ';
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

//Tabela VW_REL_FUNCIONARIO select - revisado em 29/06/2022 09:00
function select_VW_REL_FUNCIONARIO_DADOS_FUNCIONARIO_DEPARTAMENTO($id_emp, $situac)
{
    global $pdo;
    $query =
        'SELECT nome,cpf,funcao,departamento,situac_funcionario FROM public."VW_REL_FUNCIONARIO" WHERE id_emp=:id_emp and situac=:situac ORDER BY departamento
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_REL_FUNCIONARIO select - revisado em 29/06/2022 09:00
function select_VW_REL_FUNCIONARIO_DADOS_FUNCIONARIO_FUNCAO($id_emp, $situac)
{
    global $pdo;
    $query =
        'SELECT nome,cpf,funcao,departamento,situac_funcionario FROM public."VW_REL_FUNCIONARIO" WHERE id_emp=:id_emp and situac=:situac ORDER BY funcao
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_PAI()
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC" WHERE classificacao=\'P\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_FILHO($pai)
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC" WHERE pai=:pai AND classificacao=\'F\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':pai', $pai, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_NETO($pai)
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC" WHERE pai=:pai AND classificacao=\'N\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':pai', $pai, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_PAI_artigo($id_doc)
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC" WHERE grupo=
        (SELECT pai FROM public."VW_GESDOC"
        WHERE grupo=(SELECT pai FROM public."VW_GESDOC" WHERE id_doc=:id_doc )
        AND classificacao=\'F\' and publicado = 1 )
        and classificacao=\'P\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_FILHO_artigo($id_doc)
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC"
        WHERE grupo=(SELECT pai FROM public."VW_GESDOC" WHERE id_doc=:id_doc )
        AND classificacao=\'F\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_GESDOC select - revisado em 27/04/2022 14:49
function selectVW_GESDOC_NETO_artigo($id_doc)
{
    global $pdo;
    $query =
        //'SELECT pai FROM public."GESDOC" WHERE publicado = 1 GROUP BY PAI ORDER BY PAI';
        // WHERE GRUPO LIKE "1%"
        'SELECT * FROM public."VW_GESDOC" WHERE replace(pai,\'.\',\'\') IN (SELECT replace(pai,\'.\',\'\') FROM public."VW_GESDOC" WHERE id_doc=:id_doc )
        AND classificacao=\'N\' and publicado = 1 ORDER BY GRUPO';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_doc', $id_doc, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select - revisado em 27/04/2022 14:49
function selectGESEMP_layout_importacao($id_emp)
{
    global $pdo;
    $query =
        'SELECT cnpj,layout, case when substring(layout, CHAR_LENGTH(layout)-2,3) = \'txt\' then \'txt\' else \'pdf\' end as tipo_layout from public."GESEMP" where id_emp=:id_emp';

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

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESIM1_vlr_liquido($raizCNPJ, $id_emp, $id_processamento)
{
    global $pdo;
    $query =
        'SELECT sum(vlr_liquido) as vlr_liquido
        FROM public."GESIM1_' . $raizCNPJ . '" WHERE id_emp=:id_emp and id_processamento=:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDEP select - revisado em 17/12/2021 08:33
function selectGESIM2_valores($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query =
        'SELECT a.id_im1, 
    coalesce((SELECT sum(b.valor) FROM public."GESIM2_' . $raizCNPJ . '" AS b LEFT OUTER JOIN public."GESEVE" AS c ON b.ID_EVE=c.ID_EVE where c.tipo = \'V\' and b.id_im1=a.id_im1 group by c.tipo),0) as VLR_VENCIMENTO
    , coalesce((SELECT sum(b.valor) FROM public."GESIM2_' . $raizCNPJ . '" AS b LEFT OUTER JOIN public."GESEVE" AS c ON b.ID_EVE=c.ID_EVE where c.tipo = \'D\' and b.id_im1=a.id_im1 group by c.tipo),0) as VLR_DESCONTO
    , (coalesce((SELECT sum(b.valor) FROM public."GESIM2_' . $raizCNPJ . '" AS b LEFT OUTER JOIN public."GESEVE" AS c ON b.ID_EVE=c.ID_EVE where c.tipo = \'V\' and b.id_im1=a.id_im1 group by c.tipo),0) -
    coalesce((SELECT sum(b.valor) FROM public."GESIM2_' . $raizCNPJ . '" AS b LEFT OUTER JOIN public."GESEVE" AS c ON b.ID_EVE=c.ID_EVE where c.tipo = \'D\' and b.id_im1=a.id_im1 group by c.tipo),0) ) as VLR_LIQUIDO
    FROM public."GESIM1_' . $raizCNPJ . '" as a where  a.id_processamento=:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU update
function updateGESIM1_valores($raizCNPJ, $vlr_vencimento, $vlr_desconto, $vlr_liquido, $id_im1)
{
    global $pdo;
    $query =
        'UPDATE public."GESIM1_' . $raizCNPJ . '" SET vlr_vencimento =:vlr_vencimento, vlr_desconto = :vlr_desconto, vlr_liquido =:vlr_liquido WHERE id_im1 =:id_im1 and situac<>9';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA_AJUDA select
function selectGESUSA_ajuda($id_usa)
{
    global $pdo;
    $query =
        'SELECT a.id_usa as id_usa, a.nome as nome, a.cpf as cpf, a.senha as senha, a.datinc as datinc, a.id_emp_acess as id_emp_acess, a.email as email, a.situac as situac
        , a.id_per as id_per, a.id_mun as id_mun, a.telefone as telefone ,b.nome as nome_empresa, b.cnpj as cnpj_empresa
        FROM public."GESUSA" as a
        left outer join  public."GESEMP" as b
        on a.id_emp_acess = b.id_emp WHERE a.id_usa =:id_usa';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela Id_EMP_Layout select - revisado em 03/10/2022 14:56
function select_id_emp_Layout($id_emp_default)
{
    global $pdo;
    $query =
        'SELECT cnpj FROM public. "GESEMP" WHERE id_emp=:id_emp_default';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 03/10/2022 15:33
function selectGESUSU_LAYOUT_id_cod($tabela, $cod_integracao, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,cpf, FormatCPFCNPJ(cpf) AS cpf_formatado  FROM ' . $tabela . ' WHERE cod_integracao=:cod_integracao AND id_emp =:id_emp and cpf is not null';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/11/2022 13:55
function selectGESUSU_LAYOUT_NOME($tabela, $nome, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, cod_integracao FROM ' . $tabela . ' WHERE nome=:nome AND id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 30/09/2022 15:41
function selectGESUSU_LAYOUT_id_cpf_rg($tabela, $cpf, $rg, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,cpf from ' . $tabela . ' WHERE id_emp =:id_emp AND (cpf =:cpf or rg =:rg)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}




//Tabela GESUSU select - revisado em 28/10/2022 09:24
function selectGESUSU_LAYOUT_id_cpf($tabela, $cpf, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,cpf from ' . $tabela . ' WHERE cpf =:cpf AND id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}



//Tabela GESUSU select - revisado em 28/10/2022 09:24
function selectGESUSU_LAYOUT_id_cpf_raiz($tabela, $cpf, $raiz_cnpj)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,cpf from ' . $tabela . ' WHERE cpf =:cpf and id_emp in( select id_emp from public."GESEMP" where substring(replace(cnpj,\'.\',\'\'),0,9) =:raiz_cnpj) AND situac = 1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela GESUSU select - revisado em 28/10/2022 09:24
function selectGESUSU_LAYOUT_CPF($tabela, $cpf)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,cpf from ' . $tabela . ' WHERE cpf =:cpf';
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

//Tabela GESUSU select - revisado em 28/10/2022 09:24
function selectGESUSU_LAYOUT_id_pis($tabela, $pis, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu,nome,funcao,pis from ' . $tabela . ' WHERE pis =:pis AND id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela insertGESIM2_LAYOUT - revisado 13/10/2022 10:27
function insertGESIM2_LAYOUT(
    $tabela,
    $code,
    $nome,
    $qtdo,
    $valor,
    $id_im1,
    $id_eve,
    $datinc
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (codevento, nome, quantidade, valor, id_im1, id_eve, datinc)
        VALUES (:code, :nome, :qtdo, :valor, :id_im1, :id_eve, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':code', $code, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':qtdo', $qtdo, PDO::PARAM_STR);
    $statement->bindParam(':valor', $valor, PDO::PARAM_STR);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESUSU_DPCUCA insert - revisado em 30/09/2022 10:04
function insertGESUSU_dpcuca(
    $tabela,
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $rg,
    $id_mun,
    $dataadmissao,
    $pis,
    $cbo,
    $cargo,
    $id_emp_default,
    $id_emp_ant,
    $datatu,
    $id_usa,
    $id_dep,
    $cep,
    $dependentes,
    $vlr_basesalario,
    $situac_politica,
    $codigo
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (nome, cpf, senha, datinc, situac, rg, id_mun, dataadmissao, pis, cbo, funcao, id_emp, id_emp_ant, datatu, id_usa_inc, id_dep, cep, dependentes, salario, situac_politica, cod_integracao) 
        VALUES (:nome, :cpf, :senha, :datinc, :situac, :rg, :id_mun, :dataadmissao, :pis, :cbo, :cargo, :id_emp_default, :id_emp_ant, :datatu, :id_usa, :id_dep, :cep, :dependentes, :vlr_basesalario, :situac_politica, :codigo)
        RETURNING id_usu as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':dataadmissao', $dataadmissao, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_INT);
    $statement->bindParam(':cbo', $cbo, PDO::PARAM_INT);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':situac_politica', $situac_politica, PDO::PARAM_INT);
    $statement->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $statement->execute();
    $id_usu = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usu;
}

//Tabela GESIM1_DPCUCA insert - revisado em 29/09/2022 10:34
function insertGESIM1_dpcuca(
    $tabela,
    $id_emp,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa_inc,
    $descricao,
    $id_validador,
    $id_processamento,
    $origem
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, rg, cpf, nome, cargo, vlr_vencimento, vlr_desconto, vlr_liquido, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem)
        VALUES (:id_emp, :competencia, :rg, :cpf, :nome, :cargo, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa_inc, :descricao, :id_validador, :id_processamento, :origem)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_INT);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESIM1 select - revisado em 30/09/2022 15:41
function selectGESIM1_dpcuca($tabela, $cpf, $rg)
{
    global $pdo;
    $query =
        'SELECT id_im1 from ' . $tabela . ' WHERE cpf =:cpf or rg =:rg';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEVE_dpcuca select - revisado em 03/10/2022 09:22
function selectGESEVE_dpcuca($tabela, $id_emp_default, $codevento)
{
    global $pdo;
    $query =
        'SELECT id_eve,codevento,nome FROM ' . $tabela . ' WHERE id_emp=:id_emp_default and codevento=:codevento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1_dpcuca delete - revisado em 03/10/2022 09:45
function deleteGESIM1_dpcuca($tabela, $datinc)
{
    global $pdo;
    $query =
        'DELETE FROM ' . $tabela . 'where datinc=:datinc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

// //Tabela GESUSU_contmatic select - revisado em 03/10/2022 15:33
// function selectGESUSU_contmatic($tabela, $cod_integracao)
// {
//     global $pdo;
//     $query =
//         'SELECT id_usu FROM ' . $tabela . ' WHERE cod_integracao=:cod_integracao';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_INT);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

//Tabela GESUSU_contmatic insert - revisado em 03/10/2022 16:06
function insertGESUSU_contmatic(
    $tabela,
    $nome,
    $senha,
    $datinc,
    $situac,
    $id_mun,
    $dataadmissao,
    $funcao,
    $salario,
    $id_emp,
    $id_emp_ant,
    $datatu,
    $id_usa_inc,
    $id_dep,
    $cep,
    $dependentes,
    $situac_politica,
    $cod_integracao
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (nome, senha, datinc, situac, id_mun, dataadmissao, funcao, salario, id_emp, id_emp_ant, datatu, id_usa_inc, id_dep, cep, dependentes, situac_politica, cod_integracao)
        VALUES (:nome,:senha,:datinc,:situac,:id_mun,:dataadmissao,:funcao,:salario,:id_emp,:id_emp_ant,:datatu,:id_usa_inc,:id_dep,:cep,:dependentes,:situac_politica,:cod_integracao)
        RETURNING id_usu as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':dataadmissao', $dataadmissao, PDO::PARAM_STR);
    $statement->bindParam(':funcao', $funcao, PDO::PARAM_STR);
    $statement->bindParam(':salario', $salario, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_INT);
    $statement->bindParam(':situac_politica', $situac_politica, PDO::PARAM_STR);
    $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_INT);
    $statement->execute();
    $id_usu = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usu;
}

//Tabela GESIM1_contmatic insert - revisado em 03/10/2022
function insertGESIM1_contmatic(
    $tabela,
    $id_emp_default,
    $competencia,
    $nome,
    $cargo,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa,
    $descricao_recibo,
    $validador,
    $processamento,
    $origem
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, nome, cargo, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem)
        VALUES (:id_emp_default, :competencia, :nome, :cargo, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa, :descricao_recibo, :validador, :processamento, :origem)
        RETURNING id_im1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':descricao_recibo', $descricao_recibo, PDO::PARAM_STR);
    $statement->bindParam(':validador', $validador, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//Tabela GESEVE_contmatic select - revisado em 04/10/2022 10:03
function selectGESEVE_contmatic($tabela, $id_emp_default, $codevento)
{
    global $pdo;
    $query =
        'SELECT id_eve, codevento, nome, usaref FROM ' . $tabela . ' WHERE id_emp=:id_emp_default AND codevento=:codevento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1_contmatic delete - revisado em 04/10/2022 10:10
function deleteGESIM1_contmatic($tabela, $datinc)
{
    global $pdo;
    $query =
        'DELETE FROM ' . $tabela . 'where datinc=:datinc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESUSU_acedata insert - revisado em 04/10/2022 16:36
function insertGESUSU_acedata(
    $tabela,
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $rg,
    $id_mun,
    $cargo,
    $id_emp_default,
    $id_emp_ant,
    $datatu,
    $id_usa,
    $id_dep,
    $cep,
    $dependentes,
    $situac_politica,
    $cod_integracao
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (nome, cpf, senha, datinc, situac, rg, id_mun, funcao, id_emp, id_emp_ant, datatu, id_usa_inc, id_dep, cep, dependentes, situac_politica, cod_integracao)
        VALUES (:nome,:cpf,:senha,:datinc,:situac,:rg,:id_mun,:cargo,:id_emp_default,:id_emp_ant,:datatu,:id_usa,:id_dep,:cep,:dependentes,:situac_politica,:cod_integracao)
        RETURNING id_usu as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_INT);
    $statement->bindParam(':situac_politica', $situac_politica, PDO::PARAM_STR);
    $statement->bindParam(':cod_integracao', $cod_integracao, PDO::PARAM_INT);
    $statement->execute();
    $id_usu = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usu;
}

//Tabela GESIM1_acedata insert - revisado em 04/10/2022 16:49
function insertGESIM1_acedata(
    $tabela,
    $id_emp_default,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $data_credito,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa,
    $descricao_recibo,
    $validador,
    $processamento,
    $origem
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, rg, cpf, nome, cargo, data_credito, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem)
        VALUES (:id_emp_default, :competencia, :rg, :cpf, :nome, :cargo, :data_credito, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_baseir, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa, :descricao_recibo, :validador, :processamento, :origem)
        RETURNING id_im1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':descricao_recibo', $descricao_recibo, PDO::PARAM_STR);
    $statement->bindParam(':validador', $validador, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//Tabela GESEVE_acedata select - revisado em 04/10/2022 16:49
function selectGESEVE_acedata($tabela, $id_emp_default, $codevento)
{
    global $pdo;
    $query =
        'SELECT id_eve, codevento, nome FROM ' . $tabela . ' WHERE id_emp=:id_emp_default AND codevento=:codevento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1_acedata insert - revisado em 05/10/2022 08:10
function insertGESEVE_acedata(
    $tabela,
    $tipo,
    $codeevento,
    $nomeevento,
    $id_emp_default,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (tipo, codevento, nome, id_emp, datinc, datatu, id_usa_inc, id_usa_atu)
        VALUES (:tipo, :codeevento, :nomeevento, :id_emp_default, :datinc, :datatu, :id_usa_inc, :id_usa_atu)
        RETURNING id_eve as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':codeevento', $codeevento, PDO::PARAM_INT);
    $statement->bindParam(':nomeevento', $nomeevento, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_eve = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_eve;
}

//Tabela GESEVE_acedata - revisado em 05/10/2022 08:27
function updateGESEVE_acedata(
    $tabela,
    $nomeevento,
    $datatu,
    $id_usa_atu,
    $id_eve
) {
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET nome=:nomeevento, datatu=:datatu, id_usa_atu=:id_usa_atu WHERE id_eve=:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nomeevento', $nomeevento, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP_acedata select - revisado em 04/10/2022 16:49
function selectGESDEP_acedata($id_emp_default)
{
    global $pdo;
    $query =
        'SELECT cod_integracao from public."GESDEP" where id_emp=:id_emp_default and cod_integracao is not null';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU_folhamatic insert - revisado em 13/10/2022 15:51
function insertGESUSU_folhamatic(
    $tabela,
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $rg,
    $id_mun,
    $cargo,
    $id_emp,
    $id_emp_ant,
    $datatu,
    $id_usa_inc,
    $id_dep,
    $cep,
    $dependentes,
    $situac_politica
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (nome, cpf, senha, datinc, situac, rg, id_mun, funcao, id_emp, id_emp_ant, datatu, id_usa_inc, id_dep, cep, dependentes, situac_politica)
        VALUES (:nome, :cpf, :senha, :datinc, :situac, :rg, :id_mun, :cargo, :id_emp, :id_emp_ant, :datatu, :id_usa_inc, :id_dep, :cep, :dependentes, :situac_politica)
        RETURNING id_usu as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ant', $id_emp_ant, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':dependentes', $dependentes, PDO::PARAM_STR);
    $statement->bindParam(':situac_politica', $situac_politica, PDO::PARAM_INT);
    $statement->execute();
    $id_usu = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usu;
}

//Tabela GESIM1_folhamatic insert - revisado em 13/10/2022 16:08
function insertGESIM1_folhamatic(
    $tabela,
    $id_emp_default,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $data_credito,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa,
    $descricao_recibo,
    $validador,
    $processamento,
    $origem
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, rg, cpf, nome, cargo, data_credito, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem)
        VALUES (:id_emp_default, :competencia, :rg, :cpf, :nome, :cargo, :data_credito, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_baseir, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa, :descricao_recibo, :validador, :processamento, :origem)
        RETURNING id_im1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':descricao_recibo', $descricao_recibo, PDO::PARAM_STR);
    $statement->bindParam(':validador', $validador, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//Tabela GESIM1_folhamatic select - revisado em 13/10/2022 16:17
function selectGESIM1_folhamatic($tabela, $cpf, $rg)
{
    global $pdo;
    $query =
        'SELECT id_im1 FROM ' . $tabela . ' WHERE situac=0 AND cpf=:cpf OR rg=:rg ORDER BY id_im1 DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// Tabela GESEVE_folhamatic select - revisado em 14/10/2022 07:40
function selectGESEVE_folhamatic($tabela, $id_emp, $code)
{
    global $pdo;
    $query =
        'SELECT id_eve,codevento,nome FROM ' . $tabela . ' WHERE id_emp=:id_emp AND codevento=:code';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':code', $code, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// Tabela GESEVE_folhamatic insert - revisado em 14/10/2022 09:07
function insertGESEVE_folhamatic(
    $tabela,
    $tipo,
    $code,
    $nome,
    $id_emp,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (tipo, codevento, nome, id_emp, datinc, datatu, id_usa_inc, id_usa_atu)
        VALUES (:tipo, :code, :nome, :id_emp, :datinc, :datatu, :id_usa_inc, :id_usa_atu)
        RETURNING id_eve as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':code', $code, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
    $id_eve = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_eve;
}

// Tabela GESEVE_folhamatic update - revisado em 14/10/2022 09:16
function updateGESEVE_folhamatic(
    $tabela,
    $nome,
    $datatu,
    $id_usa_atu,
    $id_eve
) {
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET nome=:nome, datatu=:datatu, id_usa_atu=:id_usa_atu WHERE id_eve=:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESIM1_folhamatic update - revisado em 14/10/2022 09:40
function updateGESIM1_folhamatic($tabela)
{
    global $pdo;
    $query =
        'UPDATE ' . $tabela . '  SET situac = 9 WHERE id_im1 IN (SELECT id_im1 FROM ' . $tabela . '  WHERE vlr_liquido = 0 AND vlr_vencimento = 0 AND vlr_desconto = 0)';
    $statement = $pdo->prepare($query);
    $statement->execute();
}

// Tabela GESIM2_folhamatic update - revisado em 14/10/2022 09:50
function updateGESIM2_folhamatic($tabela, $tabela1, $processamento)
{
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET id_im1 = id_im1+1 WHERE id_im1 IN (SELECT id_im1  FROM ' . $tabela1 . ' WHERE situac = 9 AND id_processamento = :processamento)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESPON1_tangerino insert - revisado em 25/10/2022 08:19
function insertGESPON1_tangerino(
    $tabela,
    $id_emp,
    $pis,
    $id_usu,
    $periodo,
    $datinc,
    $btotal,
    $bsaldo,
    $processamento,
    $id_usa,
    $origem,
    $arquivo
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, pis, id_usu, periodo, datinc, btotal, bsaldo, id_processamento, id_usa_inc, origem, arquivo)
        VALUES (:id_emp, :pis, :id_usu, :periodo, :datinc, :btotal, :bsaldo, :processamento, :id_usa, :origem, :arquivo)
        RETURNING id_pon1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_STR);
    $statement->bindParam(':periodo', $periodo, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':btotal', $btotal, PDO::PARAM_STR);
    $statement->bindParam(':bsaldo', $bsaldo, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->execute();
    $id_pon1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_pon1;
}

// Tabela GESPON1_tangerino insert - revisado em 25/10/2022 08:19
function insertGESPON1_secullum(
    $tabela,
    $id_emp,
    $pis,
    $id_usu,
    $periodo,
    $datinc,
    $btotal,
    $bsaldo,
    $processamento,
    $id_usa,
    $origem,
    $arquivo,
    $regarq
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, pis, id_usu, periodo, datinc, btotal, bsaldo, id_processamento, id_usa_inc, origem, arquivo, regarq)
        VALUES (:id_emp, :pis, :id_usu, :periodo, :datinc, :btotal, :bsaldo, :processamento, :id_usa, :origem, :arquivo, :regarq)
        RETURNING id_pon1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_STR);
    $statement->bindParam(':periodo', $periodo, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':btotal', $btotal, PDO::PARAM_STR);
    $statement->bindParam(':bsaldo', $bsaldo, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_INT);
    $statement->execute();
    $id_pon1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_pon1;
}

// Tabela GESPON2_tangerino insert - revisado em 25/10/2022 13:49
function insertGESPON2_tangerino(
    $tabela,
    $id_pon1,
    $data,
    $ent1,
    $sai1,
    $ent2,
    $sai2,
    $ent3,
    $sai3,
    $bsaldo,
    $datinc
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_pon1, data, ent1, sai1, ent2, sai2, ent3, sai3, bsaldo, datinc)
        VALUES (:id_pon1, :data, :ent1, :sai1, :ent2, :sai2, :ent3, :sai3, :bsaldo, :datinc)
        RETURNING id_pon1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pon1', $id_pon1, PDO::PARAM_INT);
    $statement->bindParam(':data', $data, PDO::PARAM_STR);
    $statement->bindParam(':ent1', $ent1, PDO::PARAM_STR);
    $statement->bindParam(':sai1', $sai1, PDO::PARAM_STR);
    $statement->bindParam(':ent2', $ent2, PDO::PARAM_STR);
    $statement->bindParam(':sai2', $sai2, PDO::PARAM_STR);
    $statement->bindParam(':ent3', $ent3, PDO::PARAM_STR);
    $statement->bindParam(':sai3', $sai3, PDO::PARAM_STR);
    $statement->bindParam(':bsaldo', $bsaldo, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}



//Tabela GESUSU select - revisado em 01/10/2022 15:41
function selectGESUSU_LAYOUT_id_cpf_rg_pis($tabela, $id_emp, $cpf, $rg, $pis)
{
    global $pdo;
    $query =
        'SELECT id_usu,pis from ' . $tabela . ' WHERE id_emp = :id_emp and (cpf =:cpf or rg =:rg or pis =:pis)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':pis', $pis, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 delete
function deleteGESREC($raizCNPJ, $id_rec)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESREC_' . $raizCNPJ . '" WHERE id_rec =:id_rec';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_rec', $id_rec, PDO::PARAM_INT);
    $statement->execute();
}

//View select_GESPON1 select - revisado em 21/12/2021 14:10
function select_GESPON1($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT arquivo 
    FROM public."GESPON1_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// Tabela GESCHA insert - revisado em 07/11/2022 14:39
function insertGESCHA(
    $id_emp,
    $status,
    $datinc,
    $tipo
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESCHA" (id_emp, status, datinc, tipo)
        VALUES (:id_emp, :status, :datinc, :tipo)
        RETURNING id_cha as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    $id_cha = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_cha;
}

// Tabela GESCHI insert - revisado em 07/11/2022 14:52
function insertGESCHI(
    $mensagem,
    $id_cha,
    $id_mas,
    $id_usa_inc,
    $datinc
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESCHI" (mensagem, id_cha, id_mas, id_usa_inc, datinc)
        VALUES (:mensagem, :id_cha, :id_mas, :id_usa_inc, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_INT);
    $statement->bindParam(':id_cha', $id_cha, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}


//Tabela GESIM1_arquivo insert - revisado em 08/11/2022 16:08
function insertGESIM1_arquivo_regarq(
    $tabela,
    $id_emp_default,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $data_credito,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa,
    $descricao_recibo,
    $validador,
    $processamento,
    $origem,
    $arquivo,
    $regarq
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, rg, cpf, nome, cargo, data_credito, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem, arquivo, regarq)
        VALUES (:id_emp_default, :competencia, :rg, :cpf, :nome, :cargo, :data_credito, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_baseir, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa, :descricao_recibo, :validador, :processamento, :origem, :arquivo, :regarq)
        RETURNING id_im1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':descricao_recibo', $descricao_recibo, PDO::PARAM_STR);
    $statement->bindParam(':validador', $validador, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//Tabela GESIM1_arquivo insert - revisado em 08/11/2022 16:08
function insertGESIM1_arquivo(
    $tabela,
    $id_emp_default,
    $competencia,
    $rg,
    $cpf,
    $nome,
    $cargo,
    $data_credito,
    $vlr_vencimento,
    $vlr_desconto,
    $vlr_liquido,
    $faixa_irrf,
    $vlr_basesalario,
    $vlr_baseinss,
    $vlr_basefgts,
    $vlr_baseirrf,
    $vlr_baseir,
    $vlr_fgts,
    $situac,
    $id_usu,
    $datinc,
    $id_usa,
    $descricao_recibo,
    $validador,
    $processamento,
    $origem,
    $arquivo
) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (id_emp, competencia, rg, cpf, nome, cargo, data_credito, vlr_vencimento, vlr_desconto, vlr_liquido, faixa_irrf, vlr_basesalario, vlr_baseinss, vlr_basefgts, vlr_baseirrf, vlr_baseir, vlr_fgts, situac, id_usu, datinc, id_usa_inc, descricao, id_validador, id_processamento, origem, arquivo)
        VALUES (:id_emp_default, :competencia, :rg, :cpf, :nome, :cargo, :data_credito, :vlr_vencimento, :vlr_desconto, :vlr_liquido, :faixa_irrf, :vlr_basesalario, :vlr_baseinss, :vlr_basefgts, :vlr_baseirrf, :vlr_baseir, :vlr_fgts, :situac, :id_usu, :datinc, :id_usa, :descricao_recibo, :validador, :processamento, :origem, :arquivo)
        RETURNING id_im1 as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':competencia', $competencia, PDO::PARAM_STR);
    $statement->bindParam(':rg', $rg, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $statement->bindParam(':data_credito', $data_credito, PDO::PARAM_STR);
    $statement->bindParam(':vlr_vencimento', $vlr_vencimento, PDO::PARAM_STR);
    $statement->bindParam(':vlr_desconto', $vlr_desconto, PDO::PARAM_STR);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':faixa_irrf', $faixa_irrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basesalario', $vlr_basesalario, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseinss', $vlr_baseinss, PDO::PARAM_STR);
    $statement->bindParam(':vlr_basefgts', $vlr_basefgts, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseirrf', $vlr_baseirrf, PDO::PARAM_STR);
    $statement->bindParam(':vlr_baseir', $vlr_baseir, PDO::PARAM_STR);
    $statement->bindParam(':vlr_fgts', $vlr_fgts, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':descricao_recibo', $descricao_recibo, PDO::PARAM_STR);
    $statement->bindParam(':validador', $validador, PDO::PARAM_STR);
    $statement->bindParam(':processamento', $processamento, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//View select_GESIM1 select - revisado em 21/12/2021 14:10
function select_GESIM1_arquivo($raizCNPJ, $id_processamento)
{
    global $pdo;
    $query = 'SELECT arquivo 
    FROM public."GESIM1_' . $raizCNPJ . '" 
    where id_processamento =:id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View select_GESIM1 select - revisado em 21/12/2021 14:10
function selectTABELA_BENEFICIOS_FUNC($raizCNPJ, $id_usu, $id_emp)
{
    global $pdo;
    // $query = 'SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
    // CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tip_per_arq,
    // substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome,

    //  CASE
    //     WHEN a.situac =\'0\' THEN \'0\'
    //     WHEN a.situac =\'1\' THEN \'1\'
    //     WHEN a.situac =\'2\' THEN \'2\'
    //     WHEN a.situac =\'3\' THEN \'2\'
    //     WHEN a.situac =\'4\' THEN \'2\' else \'2\' end as situac,

    // a.arquivo,b.nome,a.id_im1 as id,\'H\' as tipo
    // FROM public."GESIM1_' . $raizCNPJ . '" as a 
    // left outer join public."GESUSU" as b on a.id_usu=b.id_usu 
    // WHERE a.id_usu =:id_usu and a.id_emp=:id_emp and a.situac IN (0,1,2,3,4) 
    // union
    // SELECT to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
    // CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tip_per_arq,
    // substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome,

    //  CASE
    //     WHEN a.situac =\'0\' THEN \'0\'
    //     WHEN a.situac =\'1\' THEN \'1\'
    //     WHEN a.situac =\'2\' THEN \'2\'
    //     WHEN a.situac =\'3\' THEN \'2\'
    //     WHEN a.situac =\'4\' THEN \'2\' else \'2\' end as situac,

    // a.arquivo,b.nome,a.id_pon1 as id,\'P\' as tipo
    // FROM public."GESPON1_' . $raizCNPJ . '" as a 
    // left outer join public."GESUSU" as b on a.id_usu=b.id_usu 
    // where a.id_usu =:id_usu and a.id_emp=:id_emp
    // union
    // select to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
    // CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tip_per_arq,
    // substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome,

    //  CASE
    //     WHEN a.situac =\'0\' THEN \'0\'
    //     WHEN a.situac =\'1\' THEN \'1\'
    //     WHEN a.situac =\'2\' THEN \'2\'
    //     WHEN a.situac =\'3\' THEN \'2\'
    //     WHEN a.situac =\'4\' THEN \'2\' else \'2\' end as situac,

    // a.arquivo,b.nome,a.id_irr as id,\'I\' as tipo
    // FROM public."GESIRR_' . $raizCNPJ . '" as a 
    // left outer join public."GESUSU" as b on a.id_usu=b.id_usu 
    // where a.id_usu =:id_usu and a.id_emp=:id_emp
    // union
    // select to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
    // CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tip_per_arq,
    // substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome,

    // CASE
    //     WHEN a.situac =\'0\' THEN \'0\'
    //     WHEN a.situac =\'1\' THEN \'1\'
    //     WHEN a.situac =\'2\' THEN \'2\'
    //     WHEN a.situac =\'3\' THEN \'2\'
    //     WHEN a.situac =\'4\' THEN \'2\' else \'2\' end as situac,

    // a.arquivo,b.nome,a.id_rec as id,\'R\' as tipo
    // FROM public."GESREC_' . $raizCNPJ . '" as a 
    // left outer join public."GESUSU" as b on a.id_usu=b.id_usu 
    // where a.id_usu =:id_usu and a.id_emp=:id_emp';
    $query = 'SELECT RANK () OVER (ORDER BY data desc) as rank,datinc,data,tip_per_arq,nome_func,situac,tipo,arquivo,id from (
        SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
        to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
        a.datinc as data,
        CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tip_per_arq,
        b.nome as nome_func,
        
        CASE
        WHEN a.situac =\'0\' THEN \'0\'
        WHEN a.situac =\'1\' THEN \'1\'
        WHEN a.situac =\'2\' THEN \'2\'
        WHEN a.situac =\'3\' THEN \'3\'
        WHEN a.situac =\'4\' THEN \'4\' else \'2\' end as situac,
        
        a.arquivo,b.nome,a.id_im1 as id,\'H\' as tipo
        FROM public."GESIM1_' . $raizCNPJ . '" as a
        left outer join public."GESUSU" as b on a.id_usu=b.id_usu
        WHERE a.id_usu =:id_usu and a.id_emp=:id_emp and a.situac <>9
        union
        SELECT
        replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
        to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
        a.datinc as data,
        CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tip_per_arq,
        b.nome as nome_func,
        
        CASE
        WHEN a.situac =\'0\' THEN \'0\'
        WHEN a.situac =\'1\' THEN \'1\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
        end as situac,
        
        a.arquivo,b.nome,a.id_pon1 as id,\'P\' as tipo
        FROM public."GESPON1_' . $raizCNPJ . '" as a
        left outer join public."GESUSU" as b on a.id_usu=b.id_usu
        where a.id_usu =:id_usu and a.id_emp=:id_emp
        union
        select
        replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
        to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
        a.datinc as data,
        CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tip_per_arq,
        b.nome as nome_func,
        
        CASE
        WHEN a.situac =\'0\' THEN \'0\'
        WHEN a.situac =\'1\' THEN \'1\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
        end as situac,
        a.arquivo,b.nome,a.id_irr as id,\'I\' as tipo
        FROM public."GESIRR_' . $raizCNPJ . '" as a
        left outer join public."GESUSU" as b on a.id_usu=b.id_usu
        where a.id_usu =:id_usu and a.id_emp=:id_emp
        union
        select
        replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
        to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
        a.datinc as data,
        CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tip_per_arq,
        b.nome as nome_func,
        CASE
        WHEN a.situac =\'0\' THEN \'0\'
        WHEN a.situac =\'1\' THEN \'1\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
        WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
        end as situac,
        a.arquivo,b.nome,a.id_rec as id,\'R\' as tipo
        FROM public."GESREC_' . $raizCNPJ . '" as a
        left outer join public."GESUSU" as b on a.id_usu=b.id_usu
        where a.id_usu =:id_usu and a.id_emp=:id_emp
        ) as rank
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View select_GESIM1 select - revisado em 28/04/2023 09:32
function selectTABELA_BENEFICIOS_FUNC2($raizCNPJ, $id_usu, $id_emp, $situac)
{
    global $pdo;
    switch ($situac) {

        case 9:
            $query = 'SELECT RANK () OVER (ORDER BY data desc) as rank,datinc,data,tip_per_arq,nome_func,situac,tipo,arquivo,id from (
                SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' THEN \'2\'
                WHEN a.situac =\'3\' THEN \'3\'
                WHEN a.situac =\'4\' THEN \'4\' else \'2\' end as situac,
                
                a.arquivo,b.nome,a.id_im1 as id,\'H\' as tipo
                FROM public."GESIM1_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                WHERE a.id_usu =:id_usu and a.id_emp=:id_emp and a.situac <>9
                union
                SELECT
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                
                a.arquivo,b.nome,a.id_pon1 as id,\'P\' as tipo
                FROM public."GESPON1_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                union
                select
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                a.arquivo,b.nome,a.id_irr as id,\'I\' as tipo
                FROM public."GESIRR_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                union
                select
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                a.arquivo,b.nome,a.id_rec as id,\'R\' as tipo
                FROM public."GESREC_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                ) as rank
                WHERE situac <> :situac
            ';
            break;

        default:
            $query = 'SELECT RANK () OVER (ORDER BY data desc) as rank,datinc,data,tip_per_arq,nome_func,situac,tipo,arquivo,id from (
                SELECT replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' THEN \'2\'
                WHEN a.situac =\'3\' THEN \'3\'
                WHEN a.situac =\'4\' THEN \'4\' else \'2\' end as situac,
                
                a.arquivo,b.nome,a.id_im1 as id,\'H\' as tipo
                FROM public."GESIM1_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                WHERE a.id_usu =:id_usu and a.id_emp=:id_emp and a.situac <>9
                union
                SELECT
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'PONTO - \',a.periodo,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                
                a.arquivo,b.nome,a.id_pon1 as id,\'P\' as tipo
                FROM public."GESPON1_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                union
                select
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'INFORME - CALENDARIO \',a.anocal,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                a.arquivo,b.nome,a.id_irr as id,\'I\' as tipo
                FROM public."GESIRR_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                union
                select
                replace(replace(replace(concat(a.datinc,a.id_emp, a.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id_beneficio,
                to_char(a.datinc ::TIMESTAMP, \'DD/MM/YYYY HH:MI:SS\') AS datinc,
                a.datinc as data,
                CONCAT(\'RECIBO - \',a.descricao,\' - \',a.origem) AS tip_per_arq,
                b.nome as nome_func,
                CASE
                WHEN a.situac =\'0\' THEN \'0\'
                WHEN a.situac =\'1\' THEN \'1\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'0\' THEN \'2\'
                WHEN a.situac =\'2\' AND a.situac_visualizar = \'1\' THEN \'3\'
                end as situac,
                a.arquivo,b.nome,a.id_rec as id,\'R\' as tipo
                FROM public."GESREC_' . $raizCNPJ . '" as a
                left outer join public."GESUSU" as b on a.id_usu=b.id_usu
                where a.id_usu =:id_usu and a.id_emp=:id_emp
                ) as rank
                WHERE situac = :situac
            ';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View selectMENSAGENS_HOLERITE select - revisado em 27/12/2021 16:02
function selectMENSAGENS_HOLERITE($raizCNPJ, $id_im1)
{
    global $pdo;
    $query = 'SELECT a.motrep, a.resprep,
     CASE WHEN b.imagem IS NOT NULL 
    THEN b.imagem 
    else \'avatar_default.png\' end as imagem, 
    b.id_usu, c.imagem as logo
    FROM public."GESIM1_' . $raizCNPJ . '" a
    left outer join public."GESUSU" as b on a.id_usu=b.id_usu
    left outer join public."GESEMP" as c on a.id_emp=c.id_emp
    where id_im1 = :id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View selectAJUSTE_VALOR_HOLERITE select - revisado em 27/12/2021 16:02
function selectAJUSTE_VALOR_HOLERITE($raizCNPJ, $id_im1)
{
    global $pdo;
    $query = 'SELECT a.vlr_liquido,
    b.id_usu, b.nome as nome_colaborador
    FROM public."GESIM1_' . $raizCNPJ . '" a
    left outer join public."GESUSU" as b on a.id_usu=b.id_usu
    left outer join public."GESEMP" as c on a.id_emp=c.id_emp
    where id_im1 = :id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View selectMENSAGENS_RECIBO_DIVERSOS select - revisado em 27/12/2021 16:02
function selectMENSAGENS_RECIBO_DIVERSOS($raizCNPJ, $id_rec)
{
    global $pdo;
    $query = 'SELECT a.motrep, a.resprep,
     CASE WHEN b.imagem IS NOT NULL 
    THEN b.imagem 
    else \'avatar_default.png\' end as imagem, 
    b.id_usu, c.imagem as logo
    FROM public."GESREC_' . $raizCNPJ . '" a
    left outer join public."GESUSU" as b on a.id_usu=b.id_usu
    left outer join public."GESEMP" as c on a.id_emp=c.id_emp
    where id_rec = :id_rec';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_rec', $id_rec, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// Tabela updateGESIM1_resprep update - revisado em 14/10/2022 09:50
function updateGESIM1_resprep($tabela, $resprep, $id_usa_atu, $id_im1)
{
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET resprep = :resprep, situac = 2, id_usa_atu = :id_usa_atu WHERE id_im1 = :id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':resprep', $resprep, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela updateGESIM1_resprep update - revisado em 14/10/2022 09:50
function updateGESREC_resprep($tabela, $resprep, $id_usa_atu, $id_rec)
{
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET resprep = :resprep, situac = 2, id_usa_atu = :id_usa_atu WHERE id_rec = :id_rec';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':resprep', $resprep, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_rec', $id_rec, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1_arquivo insert - revisado em 08/11/2022 16:08
function insertGESIRR_arquivo(
    $tabela,
    $anoexe,
    $anocal,
    $situac,
    $id_usu,
    $id_emp,
    $datinc,
    $id_processamento,
    $id_usa_inc,
    $origem,
    $arquivo

) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (anoexe, anocal, situac, id_usu, id_emp, datinc, id_processamento, id_usa_inc, origem, arquivo)
        VALUES (:anoexe, :anocal, :situac, :id_usu, :id_emp, :datinc, :id_processamento, :id_usa_inc, :origem, :arquivo)
        RETURNING id_irr as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':anoexe', $anoexe, PDO::PARAM_STR);
    $statement->bindParam(':anocal', $anocal, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}

//Tabela GESIM1_arquivo insert - revisado em 08/11/2022 16:08
function insertGESIRR_arquivo_regarq(
    $tabela,
    $anoexe,
    $anocal,
    $situac,
    $id_usu,
    $id_emp,
    $datinc,
    $id_processamento,
    $id_usa_inc,
    $origem,
    $arquivo,
    $regarq

) {
    global $pdo;
    $query =
        'INSERT INTO ' . $tabela . ' (anoexe, anocal, situac, id_usu, id_emp, datinc, id_processamento, id_usa_inc, origem, arquivo, regarq)
        VALUES (:anoexe, :anocal, :situac, :id_usu, :id_emp, :datinc, :id_processamento, :id_usa_inc, :origem, :arquivo, :regarq)
        RETURNING id_irr as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':anoexe', $anoexe, PDO::PARAM_STR);
    $statement->bindParam(':anocal', $anocal, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_INT);
    $statement->execute();
    $id_im1 = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_im1;
}


//SELECT selectARQUIVO_VIEW select - revisado em 02/03/2022 10:13
function selectARQUIVO_VIEW($tabela, $id_processamento)
{
    global $pdo;
    $query = 'SELECT arquivo FROM ' . $tabela . ' where id_processamento =:id_processamento and situac IN (0,1,2,3,4) group by arquivo';

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function selectARQUIVO_MODAL_DETALHES($tabela, $id_irr)
{
    global $pdo;
    $query = 'SELECT arquivo FROM ' . $tabela . ' where id_irr =:id_irr ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPON1 / GESIM1 update - revisado em 22/02/2021 08:58
function updateGESIRR_anocal(
    $tabela,
    $anocal,
    $anoexe,
    $id_processamento
) {
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' set anocal = :anocal, anoexe= :anoexe where id_processamento = :id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':anocal', $anocal, PDO::PARAM_STR);
    $statement->bindParam(':anoexe', $anoexe, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESPON1 / GESIM1 update - revisado em 22/02/2021 08:58
function updateGES_regarq(
    $tabela,
    $regarq,
    $id_processamento
) {
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' set regarq = :regarq where id_processamento = :id_processamento';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_INT);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->execute();
}

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_EMAIL($email)
{
    global $pdo;
    $query =
        'SELECT COUNT(email) FROM public."GESUSU" WHERE email=:email and situac=1                
        ';
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

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_CELULAR($celular)
{
    global $pdo;
    $query =
        'SELECT count(celular) as contagem FROM public."GESUSU" WHERE situac=1 and celular=:celular                 
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_CPF($cpf)
{
    global $pdo;
    $query =
        'SELECT COUNT(cpf) AS contagem_cpf FROM public."GESUSU" WHERE cpf = :cpf AND situac=1';
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

// GESTOR select - revisado em 02/05/2023 13:47
function selectGESUSU_CPF_EMP($case, $cpf, $id_emp, $id_usu)
{
    global $pdo;
    switch ($case) {

        case 'ALT':
            $query =
                'SELECT COUNT(cpf) AS contagem_cpf FROM public."GESUSU" WHERE cpf = :cpf AND id_emp = :id_emp AND id_usu <> ' . $id_usu;
            break;

        case 'CAD':
            $query =
                'SELECT COUNT(cpf) AS contagem_cpf FROM public."GESUSU" WHERE cpf = :cpf AND id_emp = :id_emp';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_EMAIL_id_usu($email, $id_usu)
{
    global $pdo;
    $query =
        'SELECT COUNT(email) FROM public."GESUSU" WHERE email=:email and situac=1 and id_usu<>:id_usu              
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_CELULAR_id_usu($celular, $id_usu)
{
    global $pdo;
    $query =
        'SELECT count(celular) as contagem FROM public."GESUSU" WHERE situac=1 and celular=:celular and id_usu<>:id_usu          
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_CPF_id_usu($cpf, $id_usu)
{
    global $pdo;
    $query =
        'SELECT COUNT(cpf) AS contagem_cpf FROM public."GESUSU" WHERE cpf = :cpf AND situac=1 and id_usu<>:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// GESTOR select - revisado em 01/03/2022 08:33
function selectGESUSU_CPF_SITUAC($id_usu)
{
    global $pdo;
    $query =
        'SELECT COUNT(cpf) AS contagem_cpf FROM public."GESUSU" WHERE cpf = (SELECT cpf FROM public."GESUSU" WHERE id_usu = :id_usu) AND situac=1 ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}



//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_ESTADO_campo($campo, $id_usu, $id_usa, $id_emp)
{
    global $pdo;

    switch ($campo) {
        case 'id_usu':
            $query = 'SELECT a.id_emp,c.nome as estado,c.nome as estado_atual
                      FROM public."GESUSU" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usu=' . $id_usu . '
                          union
                      SELECT null as id_emp,"GESEST".nome as estado , 
                     (SELECT c.nome 
                      FROM public."GESUSU" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usu=' . $id_usu . ') as estado_atual
                      from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in (  SELECT c.nome
                      FROM public."GESUSU" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usu=' . $id_usu . ' ) group by    "GESEST".nome
                      order by  id_emp asc, estado';
            break;
        case 'id_usa':
            $query = 'SELECT a.id_emp,c.nome as estado,c.nome as estado_atual
                      FROM public."GESUSA" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usa=' . $id_usa . '
                          union
                      SELECT null as id_emp,"GESEST".nome as estado ,
                      (SELECT c.nome 
                      FROM public."GESUSA" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usa=' . $id_usa . ') as estado_atual
                      from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in (  SELECT c.nome
                      FROM public."GESUSA" as a 
                      left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
                      left outer join public."GESEST" as c on b.id_est=c.id_est 
                      where a.id_usa=' . $id_usa . ' ) group by    "GESEST".nome
                      order by  id_emp asc, estado';
            break;
        case 'id_emp':
            $query = 'SELECT  id_emp, estado, estado as estado_atual FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' 
                          union
                      SELECT null as id_emp,"GESEST".nome as estado ,COALESCE((SELECT  estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . '),\'ACRE\') as estado_atual
                      from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' ) group by    "GESEST".nome
                      order by  id_emp asc, estado';
            break;
        default:
            $query = 'SELECT  id_emp, estado, estado as estado_atual FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' 
                        union
                    SELECT null as id_emp,"GESEST".nome as estado ,COALESCE((SELECT  estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . '),\'ACRE\') as estado_atual
                    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' ) group by    "GESEST".nome
                    order by  id_emp asc, estado';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}




//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_CIDADE_campo($campo, $id_usu, $id_usa, $id_emp, $estado)
{
    global $pdo;

    switch ($campo) {
        case 'id_usu':

            $query = 'SELECT a.id_emp,a.id_mun,b.nome as cidade,c.nome as estado ,concat(substring(a.cep,1,5),\'-\',substring(a.cep,6,3)) as  cep
            FROM public."GESUSU" as a 
            left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
            left outer join public."GESEST" as c on b.id_est=c.id_est 
            where a.id_usu=' . $id_usu . '
        	    union
            SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
            from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' 
	        and id_mun not in ( SELECT a.id_mun
            FROM public."GESUSU" as a 
            left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
            left outer join public."GESEST" as c on b.id_est=c.id_est 
            where a.id_usu=' . $id_usu . ' )
            order by  id_emp asc, cidade';
            break;
        case 'id_usa':

            $query = 'SELECT a.id_emp,a.id_mun,b.nome as cidade,c.nome as estado ,concat(substring(a.cep,1,5),\'-\',substring(a.cep,6,3)) as  cep
            FROM public."GESUSA" as a 
            left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
            left outer join public."GESEST" as c on b.id_est=c.id_est 
            where a.id_usa=' . $id_usa . '
                union
            SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
            from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' 
            and id_mun not in ( SELECT a.id_mun
            FROM public."GESUSA" as a 
            left outer join public."GESMUN" as b on a.id_mun=b.id_mun 
            left outer join public."GESEST" as c on b.id_est=c.id_est 
            where a.id_usa=' . $id_usa . ' )
            order by  id_emp asc, cidade';
            break;
        case 'id_emp':
            $query = 'SELECT  id_emp,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_EMPRESA" where id_emp=' . $id_emp . '
            union
            SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
            from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' and id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' )
            order by  id_emp asc, cidade';
            break;
        default:
            $query = 'SELECT  id_emp,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_EMPRESA" where id_emp=' . $id_emp . '
            union
            SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
            from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\' and id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' )
            order by  id_emp asc, cidade';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->execute();



    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// tabela GESEMP_emp_selecionadas select - revisado em 07/03/2023 09:40
function selectGESEMP_emp_selecionadas($id_usa)
{
    global $pdo;
    $query =
        'SELECT a.id_emp,a.NOMEFANTASIA,a.CNPJ,replace(coalesce(b.nomefantasia,\'-\'),\'- MATRIZ\',\'\') as grupo 
        FROM public."VW_ADMIN_EMPACESS"  as a
        left outer join public."GESEMP" as b on a.id_emp_grupo=b.id_emp
        WHERE ID_USA = :id_usa
        ORDER BY a.NOMEFANTASIA ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// tabela GESEMP_emp_disponiveis select - revisado em 07/03/2023 09:40
function selectGESEMP_emp_disponiveis($id_usa)
{
    global $pdo;
    $query =
        'SELECT a.id_emp,a.NOMEFANTASIA,a.CNPJ,replace(coalesce(b.nomefantasia,\'-\'),\'- MATRIZ\',\'\') as grupo 
        FROM public."VW_ADMIN_EMPACESS"  as a
        left outer join public."GESEMP" as b on a.id_emp_grupo=b.id_emp WHERE a.id_emp NOT IN 
        (SELECT a.id_emp
        FROM public."VW_ADMIN_EMPACESS"  as a
        left outer join public."GESEMP" as b on a.id_emp_grupo=b.id_emp
        WHERE ID_USA = :id_usa)
        group by a.id_emp,a.NOMEFANTASIA,a.CNPJ,b.nomefantasia
        ORDER BY a.NOMEFANTASIA ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESVIN delete - revisado em 08/03/2023 08:00
function deleteGESVIN_usuario($id_emp, $id_usa)
{
    global $pdo;
    $query =
        'DELETE FROM public."GESVIN" WHERE id_tab2 = :id_usa AND id_tab1 = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

// tabela GESGES_selecionados select - revisado em 08/03/2023 14:49
function selectGESGES_selecionados($id_emp)
{
    global $pdo;
    $query =
        'SELECT b.id_usa, b.nome, b.cpf FROM public."GESVIN" AS a
        LEFT OUTER JOIN public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" AS c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND c.gestor = 1 AND a.id_tab1 = :id_emp
            ORDER BY nome';
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

// tabela GESGES_disponiveis select - revisado em 09/03/2023 15:43
function selectGESGES_disponiveis($id_emp)
{
    global $pdo;
    $query =
        'SELECT b.id_usa,b.nome,b.cpf FROM public."GESVIN" AS a 
        LEFT OUTER JOIN public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND b.id_tus IN (2,3) AND b.id_usa <> 39 AND c.gestor = 0 AND a.id_tab1 = :id_emp 
        UNION
        SELECT b.id_usa,b.nome,b.cpf FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        WHERE b.situac = 1 AND b.id_tus IN (2,3) AND b.id_usa <> 39 AND a.id_tab1 = :id_emp AND b.id_usa NOT IN 
        (SELECT b.id_usa FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND c.gestor = 0 AND a.id_tab1 = :id_emp 
        UNION
        SELECT b.id_usa FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND c.gestor = 1 AND a.id_tab1 = :id_emp)
        ORDER BY nome';
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

// tabela GESGES select - revisado em 08/03/2023 16:21
function selectGESGES($id_usa, $id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESGES" WHERE id_usa = :id_usa AND id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = 1;
    } else {
        $resultset = 0;
    }

    return $resultset;
}

// Tabela GESEMP_dados select - revisado em 31/03/2023 12:57
function selectVW_EMPRESA_dados($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_emp, nome, cnpj, email, contato, endereco, numero, bairro, cep, situac, complemento, imagem, id_mun, telefone, valges, tipo, id_emp_h, id_emp_p, id_emp_i, resp_financeiro, email_financeiro, id_usa_rh, id_usa_ouv, nomefantasia, cidade, estado
        FROM public."VW_EMPRESA" 
        WHERE id_emp = :id_emp order by id_emp desc';
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

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function select_TABELA_COLABORADORES($raiz_cnpj, $id_emp, $id_usa, $situac)
{

    global $pdo;

    switch ($situac) {
        case 9:
            $query =
                'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
                , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo , imagem, imagem_aprovacao
                , coalesce((SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=x.id_emp),\'N\') as verificacao_usa_rh
                , case when imagem isnull AND imagem_aprovacao isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
                ,CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = tipo then \'M\' else \'F\' end as edita         
                FROM public."VW_USUARIOS" as x where raiz_cnpj=:raiz_cnpj 
                and tipo = CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = \'F\' THEN \'F\' ELSE tipo END
                and situac <> :situac
                order by nome asc';
            break;
        default:
            $query =
                'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
                , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo , imagem, imagem_aprovacao
                , coalesce((SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=x.id_emp),\'N\') as verificacao_usa_rh
                , case when imagem isnull AND imagem_aprovacao isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
                ,CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = tipo then \'M\' else \'F\' end as edita         
                FROM public."VW_USUARIOS" as x where raiz_cnpj=:raiz_cnpj 
                and tipo = CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = \'F\' THEN \'F\' ELSE tipo END
                and situac = :situac
                order by nome asc';
            break;
    }

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function select_TABELA_COLABORADORES0($raiz_cnpj, $id_emp, $id_usa, $situac, $tipo)
{

    global $pdo;

    switch ($situac) {
        case 9:
            $query =
                'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
                , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo , imagem, imagem_aprovacao
                , coalesce((SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=x.id_emp),\'N\') as verificacao_usa_rh
                , case when imagem isnull AND imagem_aprovacao isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
                ,CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = tipo then \'M\' else \'F\' end as edita         
                FROM public."VW_USUARIOS" as x where raiz_cnpj=:raiz_cnpj 
                and tipo = CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = \'F\' THEN \'F\' ELSE tipo END
                and situac <> :situac
                and CASE 
                WHEN :tipo = \'M\' THEN id_emp=:id_emp
                WHEN :tipo = \'F\' THEN id_emp<>:id_emp
                WHEN :tipo = \'T\' THEN id_emp<>0
                END
                order by nome asc';
            break;
        default:
            $query =
                'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao
                , funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc,tipo , imagem, imagem_aprovacao
                , coalesce((SELECT case when id_usa_rh = id_usa then \'S\' else \'N\' end as verificacao FROM public."VW_ADMIN_USUARIOS" where id_usa=:id_usa and id_emp=x.id_emp),\'N\') as verificacao_usa_rh
                , case when imagem isnull AND imagem_aprovacao isnull then \'V\' when imagem_aprovacao IS NOT NULL then \'A\' when imagem_aprovacao isnull and imagem IS NOT NULL then \'P\' end as status_imagem
                ,CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = tipo then \'M\' else \'F\' end as edita         
                FROM public."VW_USUARIOS" as x where raiz_cnpj=:raiz_cnpj 
                and tipo = CASE WHEN (select tipo FROM public."GESEMP" where id_emp=:id_emp) = \'F\' THEN \'F\' ELSE tipo END
                and situac = :situac
                and CASE 
                WHEN :tipo = \'M\' THEN id_emp=:id_emp
                WHEN :tipo = \'F\' THEN id_emp<>:id_emp
                WHEN :tipo = \'T\' THEN id_emp<>0
                END
                order by nome asc';
            break;
    }

    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTRE delete - revisado 11/04/2023 09:04
function deleteGESTRE_in(array $id_tre)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_tre), '?'));
    $query = 'DELETE FROM public."GESTRE" WHERE id_tre IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($id_tre as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }

    try {
        $resultado = $statement->execute();
    } catch (\PDOException $err) {
        if ($err->getCode() == 23503) {
            $resultado = 23503;
        }
    }

    return $resultado;
}

// Tabela GESOUV_modal select - revisado 13/04/2023 14:52
function selectGESOUV_modal($id_ouv)
{
    global $pdo;
    $query =
        'SELECT situac
        FROM public."GESOUV" 
        WHERE id_ouv = :id_ouv';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ouv', $id_ouv, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUR_enviado select - revisado 17/04/2023 08:39
function selectGESMUR_enviado($id_mur)
{
    global $pdo;
    $query =
        'SELECT enviado FROM public."GESMUR"
            WHERE id_mur = :id_mur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUR delete - revisado 17/04/2023 09:31
function deleteGESMUR_in(array $id_mur)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_mur), '?'));
    $query =
        'DELETE FROM public."GESMUR" 
            WHERE id_mur IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($id_mur as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    try {

        $resultado = $statement->execute();
    } catch (\PDOException $err) {

        if ($err->getCode() == 23503) {

            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESNOT_visualizar select
function selectGESNOT_visualizar($id_not)
{
    global $pdo;
    $query =
        'SELECT anexo, mensagem
            FROM public."GESNOT"
            WHERE id_not = :id_not';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESNOT_in delete - revisado 18/04/2023 13:01
function deleteGESNOT_in(array $id_not)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_not), '?'));
    $query =
        'DELETE FROM public."GESNOT" 
            WHERE id_not IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($id_not as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    try {

        $resultado = $statement->execute();
    } catch (\PDOException $err) {

        if ($err->getCode() == 23503) {

            $resultado = 23503;
        }
    }

    return $resultado;
}

//Tabela GESSOL_id_sol select - revisado 19/04/2023 09:44
function selectGESSOL_id_sol($id_sol)
{
    global $pdo;
    $query =
        'SELECT c.descri AS tipo_solicitacao, b.nome AS usuario, a.*
            FROM public."GESSOL" AS a
        LEFT OUTER JOIN public."GESUSA" AS b 
            ON a.id_usa_atu = b.id_usa
        LEFT OUTER JOIN public."GESTSO" AS c 
            ON a.id_tso = c.id_tso
        WHERE a.id_sol = :id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela GESIM_LOG insert - revisado em 03/05/2023 11:08
function insertGESIM_LOG(

    $id_emp_default,
    $identificador,
    $tipo,
    $descricao,
    $origem,
    $id_processamento,
    $regarq,
    $pagina,
    $datinc

) {
    global $pdo;
    $query =
        'INSERT INTO public."GESIM_LOG" (id_emp, identificador, tipo, descricao, origem, id_processamento, regarq, pagina, datinc)
        VALUES (:id_emp_default, :identificador, :tipo, :descricao, :origem, :id_processamento, :regarq, :pagina, :datinc)
        RETURNING id_imlog as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':identificador', $identificador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_STR);
    $statement->bindParam(':pagina', $pagina, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);

    $statement->execute();
    $id_imlog = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_imlog;
}

//Tabela select_GESIM_LOG select - revisado 03/05/2023 14:29
function select_GESIM_LOG($id_processamento, $id_emp)
{
    global $pdo;
    $query =
        'SELECT pagina, tipo, identificador 
            FROM public."VW_GESLOG" 
            WHERE id_processamento = :id_processamento AND id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}




//Tabela GESIM_LOG insert - revisado em 03/05/2023 11:08
function insertGESPON_LOG(

    $id_emp_default,
    $identificador,
    $tipo,
    $descricao,
    $origem,
    $id_processamento,
    $regarq,
    $pagina,
    $datinc

) {
    global $pdo;
    $query =
        'INSERT INTO public."GESPON_LOG" (id_emp, identificador, tipo, descricao, origem, id_processamento, regarq, pagina, datinc)
        VALUES (:id_emp_default, :identificador, :tipo, :descricao, :origem, :id_processamento, :regarq, :pagina, :datinc)
        RETURNING id_ponlog as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp_default', $id_emp_default, PDO::PARAM_INT);
    $statement->bindParam(':identificador', $identificador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':origem', $origem, PDO::PARAM_STR);
    $statement->bindParam(':id_processamento', $id_processamento, PDO::PARAM_STR);
    $statement->bindParam(':regarq', $regarq, PDO::PARAM_STR);
    $statement->bindParam(':pagina', $pagina, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);

    $statement->execute();
    $id_ponlog = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_ponlog;
}

//Tabela select_VW_ORG select - revisado 09/05/2023 09:08
function select_VW_ORG($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."VW_ORGANOGRAMA_PROX_NIVEL"
            WHERE id_emp = :id_emp';
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

//Tabela select_GESORG select - revisado 09/05/2023 14:19
function select_GESORG($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESORG"
            WHERE id_emp = :id_emp
            ORDER BY nivel';
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

//Tabela select_GESORG_pai select - revisado 09/05/2023 13:45
function select_GESORG_pai($id_emp, $nivel)
{
    global $pdo;
    $query =
        'SELECT descricao
            FROM public."GESORG"
            WHERE id_emp = :id_emp AND nivel = :nivel';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela select_GESORG_filho select - revisado 09/05/2023 10:19
function select_GESORG_filho($id_emp, $descricao)
{
    global $pdo;
    $query =
        'SELECT count(*) conta 
            FROM public."GESORG"
            WHERE id_emp = :id_emp AND pai = :descricao';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela select_GESORG_descricao select - revisado 09/05/2023 14:20
function select_GESORG_descricao($id_emp, $descricao)
{
    global $pdo;
    $query =
        'SELECT count(*) conta 
            FROM public."GESORG"
            WHERE id_emp = :id_emp AND descricao = :descricao';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela select_GESORG_edit select - revisado 09/05/2023 14:37
function select_GESORG_edit($id_org)
{
    global $pdo;
    $query =
        'SELECT descricao, pai, nivel
            FROM public."GESORG"
            WHERE id_org = :id_org';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_org', $id_org, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESORG_in delete - revisado 09/05/2023 10:40
function deleteGESORG_in(array $id_org)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_org), '?'));
    $query =
        'DELETE FROM public."GESORG" 
            WHERE id_org IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($id_org as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    try {

        $resultado = $statement->execute();
    } catch (\PDOException $err) {

        if ($err->getCode() == 23503) {

            $resultado = 23503;
        }
    }

    return $resultado;
}

//SELECT VW_ADMIN_GACESSO - revisado em 22/01/2022 09:14
function selectVW_ADMIN_GACESSO($email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_ADMIN_GACESSO" WHERE email=:email and analise<>1';
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

//SELECT GESUSU_departamento - revisado em 17/05/2023 09:57
function selectGESUSU_departamento($id_emp, $id_dep)
{
    global $pdo;
    switch ($id_dep) {

        case '0':
            $query = 'SELECT id_usu FROM public."GESUSU" WHERE id_emp = :id_emp AND (id_dep <> :id_dep OR id_dep = :id_dep) AND situac = 1';
            break;

        default:
            $query = 'SELECT id_usu FROM public."GESUSU" WHERE id_emp = :id_emp AND id_dep = :id_dep AND situac = 1';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTRU insert - revisado em 17/05/2023 10:19
function insertGESTRU($id_usu, $id_tre, $datinc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESTRU" (id_usu, id_tre, datinc)
        VALUES (:id_usu, :id_tre, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESMUU insert - revisado em 17/05/2023 11:01
function insertGESMUU($id_usu, $id_mur, $datinc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMUU" (id_usu, id_mur, datinc)
        VALUES (:id_usu, :id_mur, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESPUL insert - revisado em 30/05/2023 08:03
function insertGESPUL($id_usu, $id_pol, $datinc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESPUL" (id_usu, id_pol, datinc)
        VALUES (:id_usu, :id_pol, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT GESUSU_ativos - revisado em 31/05/2023 09:50
function selectGESUSU_ativos($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS conta
        FROM public."GESUSU"
        WHERE id_emp = :id_emp AND situac = 1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESUSU experiencia 45 dias count - FEA-002
function selectGESUSU_experiencia_45d_count($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS conta
        FROM public."GESUSU"
        WHERE id_emp = :id_emp
          AND situac = 1
          AND dataadmissao IS NOT NULL
          AND (CURRENT_DATE - dataadmissao::date) >= 45
          AND (CURRENT_DATE - dataadmissao::date) <= 90';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESUSU experiencia 90 dias count - FEA-002
function selectGESUSU_experiencia_90d_count($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS conta
        FROM public."GESUSU"
        WHERE id_emp = :id_emp
          AND situac = 1
          AND dataadmissao IS NOT NULL
          AND (CURRENT_DATE - dataadmissao::date) >= 90';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESUSU experiencia listagem - FEA-002
function selectGESUSU_experiencia_lista($id_emp, $tipo)
{
    global $pdo;
    if ($tipo == 45) {
        $query =
            'SELECT id_usu, nome, dataadmissao,
                (dataadmissao::date + 45) AS vencimento_45d,
                (dataadmissao::date + 90) AS vencimento_90d,
                (CURRENT_DATE - dataadmissao::date) AS dias_desde_admissao
            FROM public."GESUSU"
            WHERE id_emp = :id_emp
              AND situac = 1
              AND dataadmissao IS NOT NULL
              AND (CURRENT_DATE - dataadmissao::date) >= 45
              AND (CURRENT_DATE - dataadmissao::date) <= 90
            ORDER BY dataadmissao ASC';
    } else {
        $query =
            'SELECT id_usu, nome, dataadmissao,
                (dataadmissao::date + 45) AS vencimento_45d,
                (dataadmissao::date + 90) AS vencimento_90d,
                (CURRENT_DATE - dataadmissao::date) AS dias_desde_admissao
            FROM public."GESUSU"
            WHERE id_emp = :id_emp
              AND situac = 1
              AND dataadmissao IS NOT NULL
              AND (CURRENT_DATE - dataadmissao::date) >= 90
            ORDER BY dataadmissao ASC';
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESUSU experiencias vencendo em ate 7 dias - FEA-003
function selectGESUSU_experiencia_alerta($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome, dataadmissao,
            (dataadmissao::date + 45) AS vencimento_45d,
            (dataadmissao::date + 90) AS vencimento_90d,
            (CURRENT_DATE - dataadmissao::date) AS dias_desde_admissao,
            CASE
                WHEN (dataadmissao::date + 45) - CURRENT_DATE BETWEEN 0 AND 7 THEN 45
                WHEN (dataadmissao::date + 90) - CURRENT_DATE BETWEEN 0 AND 7 THEN 90
            END AS tipo_alerta,
            CASE
                WHEN (dataadmissao::date + 45) - CURRENT_DATE BETWEEN 0 AND 7 THEN (dataadmissao::date + 45) - CURRENT_DATE
                WHEN (dataadmissao::date + 90) - CURRENT_DATE BETWEEN 0 AND 7 THEN (dataadmissao::date + 90) - CURRENT_DATE
            END AS dias_restantes
        FROM public."GESUSU"
        WHERE id_emp = :id_emp
          AND situac = 1
          AND dataadmissao IS NOT NULL
          AND (
              (dataadmissao::date + 45) - CURRENT_DATE BETWEEN 0 AND 7
              OR (dataadmissao::date + 90) - CURRENT_DATE BETWEEN 0 AND 7
          )
        ORDER BY dias_restantes ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }

    return $resultset;
}

//SELECT observacoes do colaborador - FEA-004
function selectObservacoes_colaborador($id_usu, $cnpj)
{
    global $pdo;
    $query =
        'SELECT o.id, o.descricao, o.data_observacao, o.criado_em,
            COALESCE(c.nome, \'Sem categoria\') AS categoria_nome
        FROM observacoes_colaborador o
        LEFT JOIN categorias_observacao c ON o.categoria_id = c.id
        WHERE o.colaborador_id = :id_usu AND o.cnpj_empresa = :cnpj
        ORDER BY o.data_observacao DESC, o.criado_em DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }
    return $resultset;
}

//SELECT categorias de observacao ativas por empresa - FEA-004
function selectCategorias_observacao($cnpj)
{
    global $pdo;
    $query =
        'SELECT id, nome FROM categorias_observacao
        WHERE cnpj_empresa = :cnpj AND ativo = TRUE
        ORDER BY nome ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }
    return $resultset;
}

//INSERT observacao do colaborador - FEA-004
function insertObservacao($colaborador_id, $cnpj, $categoria_id, $descricao, $data_obs, $criado_em, $criado_por)
{
    global $pdo;
    $query =
        'INSERT INTO observacoes_colaborador (colaborador_id, cnpj_empresa, categoria_id, descricao, data_observacao, criado_em, criado_por)
        VALUES (:colaborador_id, :cnpj, :categoria_id, :descricao, :data_obs, :criado_em, :criado_por)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':colaborador_id', $colaborador_id, PDO::PARAM_INT);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $cat_id = !empty($categoria_id) ? $categoria_id : null;
    $statement->bindParam(':categoria_id', $cat_id, PDO::PARAM_INT);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':data_obs', $data_obs, PDO::PARAM_STR);
    $statement->bindParam(':criado_em', $criado_em, PDO::PARAM_STR);
    $statement->bindParam(':criado_por', $criado_por, PDO::PARAM_INT);
    $statement->execute();
}

//DELETE observacao do colaborador - FEA-004
function deleteObservacao($id)
{
    global $pdo;
    $query = 'DELETE FROM observacoes_colaborador WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//INSERT categoria de observacao - FEA-004
function insertCategoria_observacao($cnpj, $nome, $criado_em)
{
    global $pdo;
    $query =
        'INSERT INTO categorias_observacao (cnpj_empresa, nome, criado_em)
        VALUES (:cnpj, :nome, :criado_em)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':criado_em', $criado_em, PDO::PARAM_STR);
    $statement->execute();
}

//UPDATE desativar categoria de observacao - FEA-004
function inactivateCategoria_observacao($id)
{
    global $pdo;
    $query = 'UPDATE categorias_observacao SET ativo = FALSE WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT justificativas por empresa - FEA-005
function selectJustificativas_empresa($id_emp)
{
    global $pdo;
    $query = 'SELECT j.*, u.nome AS colaborador_nome FROM justificativas j LEFT JOIN public."GESUSU" u ON j.colaborador_id = u.id_usu WHERE u.id_emp = :id_emp ORDER BY j.criado_em DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }
    return $resultset;
}

//SELECT justificativa por id - FEA-005
function selectJustificativa_id($id)
{
    global $pdo;
    $query = 'SELECT j.*, u.nome AS colaborador_nome, u.email AS colaborador_email FROM justificativas j LEFT JOIN public."GESUSU" u ON j.colaborador_id = u.id_usu WHERE j.id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }
    return $resultset;
}

//UPDATE justificativa status - FEA-005
function updateJustificativa_status($id, $status, $resposta, $respondido_em, $respondido_por)
{
    global $pdo;
    $query = 'UPDATE justificativas SET status = :status, resposta_admin = :resposta, respondido_em = :respondido_em, respondido_por = :respondido_por WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_STR);
    $resp = !empty($resposta) ? $resposta : null;
    $statement->bindParam(':resposta', $resp, PDO::PARAM_STR);
    $statement->bindParam(':respondido_em', $respondido_em, PDO::PARAM_STR);
    $statement->bindParam(':respondido_por', $respondido_por, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT justificativas pendentes count - FEA-005
function selectJustificativas_pendentes_count($id_emp)
{
    global $pdo;
    $query = 'SELECT count(j.id) AS conta FROM justificativas j LEFT JOIN public."GESUSU" u ON j.colaborador_id = u.id_usu WHERE u.id_emp = :id_emp AND j.status = \'pendente\'';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//SELECT GESEMP todas ativas com email do admin - FEA-003
function selectGESEMP_ativas_com_admin()
{
    global $pdo;
    $query =
        'SELECT e.id_emp, e.nome, e.cnpj, a.email AS email_admin, a.nome AS nome_admin
        FROM public."GESEMP" e
        LEFT JOIN public."GESUSA" a ON a.id_emp_acess = e.id_emp AND a.situac = 1
        WHERE e.situac = 1
        ORDER BY e.id_emp';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [];
    }

    return $resultset;
}

//SELECT GESSOL_pendentes - revisado em 31/05/2023 12:15
function selectGESSOL_pendentes($id_emp)
{
    global $pdo;
    // Consulta para obter a contagem de solicitações pendentes e o total de solicitações
    // A função COUNT() é utilizada para contar o número de ocorrências.
    // A primeira contagem é feita com a cláusula CASE WHEN:
    // - Quando a coluna "situac" está presente nos valores (3 - APROVADO, 4 - REPROVADO), a coluna "id_sol" é contada.
    // - Caso contrário, é retornado NULL.
    // Essa contagem representa a quantidade de solicitações respondidas.
    // A segunda contagem é feita simplesmente contando a coluna "id_sol" para todas as solicitações.
    // A cláusula WHERE filtra as solicitações com base no parâmetro:
    // - id_emp: ID da empresa
    // Os resultados retornarão a contagem de solicitações respondidas e o total de solicitações.
    $query =
        'SELECT COUNT(CASE WHEN situac IN (3, 4) THEN id_sol ELSE NULL END) AS conta_respondidos, count(id_sol) as conta_tudo
        FROM public."GESSOL"
        WHERE id_emp = :id_emp';
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

//SELECT ANIVERSARIOS_count - revisado em 31/05/2023 12:58
function selectANIVERSARIOS_count($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS aniversariantes
        FROM public."GESUSU"
        WHERE datanascimento IS NOT NULL
          AND id_emp = :id_emp
          AND situac = 1
          AND EXTRACT(MONTH FROM datanascimento) = EXTRACT(MONTH FROM CURRENT_DATE);';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT VW_GESSOB - revisado em 31/05/2023 13:31
function selectVW_GESSOB($id_emp)
{
    global $pdo;
    $query =
        'SELECT *
        FROM public."VW_GESSOB"
        WHERE id_emp = :id_emp;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESEMP_modelos - revisado em 01/06/2023 08:40
function selectGESEMP_modelos($id_emp)
{
    global $pdo;
    $query =
        'SELECT layout, layout_ponto, layout_irrf, modelo_layout, modelo_layout_ponto, modelo_layout_irrf
        FROM public."GESEMP"
        WHERE id_emp = :id_emp;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP_modelo update - revisado em 01/06/2023 10:34
function updateGESEMP_modelos($id_emp, $modelo, $tipo)
{
    global $pdo;
    switch ($tipo) {

        case 'H':
            $query = 'UPDATE public."GESEMP" SET modelo_layout = :modelo WHERE id_emp = :id_emp';
            break;

        case 'P':
            $query = 'UPDATE public."GESEMP" SET modelo_layout_ponto = :modelo WHERE id_emp = :id_emp';
            break;

        case 'I':
            $query = 'UPDATE public."GESEMP" SET modelo_layout_irrf = :modelo WHERE id_emp = :id_emp';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':modelo', $modelo, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT GESUSU_aniversariantes - revisado em 01/06/2023 12:59
function selectGESUSU_aniversariantes($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome AS aniversariantes, datanascimento AS datanasc
        FROM public."GESUSU"
        WHERE datanascimento IS NOT NULL
          AND id_emp = :id_emp
          AND situac = 1
          AND EXTRACT(MONTH FROM datanascimento) = EXTRACT(MONTH FROM CURRENT_DATE)
        ORDER BY EXTRACT(DAY FROM datanascimento) ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT PainelRH - revisado em 02/06/2023 07:36
function selectPAINELRH($id_emp, $tipo)
{
    global $pdo;
    $query =
        'SELECT * FROM public."VW_VISUALIZACAO_PAINEL_RH" WHERE id_emp = :id_emp AND tipo = :tipo';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT PainelRH_colab - revisado em 13/06/2023 07:59
// Parâmetros:
// $id_emp: ID da empresa
// $tipo: Tipo de mensagem (N - Fale com os Colaboradores, M - Mural de Avisos, F - Feedback e Sugestões, T - Treinamentos e Manuais, S - Solicitações dos Colaboradores)
function selectPAINELRH_colab($id_emp, $tipo)
{
    global $pdo;
    switch ($tipo) {

            // Consulta para obter usuários distintos do PainelRH que têm notificações pendentes de visualização
        case 'N':
            // A coluna "id_usu" e a coluna "nome" da tabela "GESUSU" são selecionadas.
            // A cláusula DISTINCT garante que apenas valores únicos sejam retornados.
            // A consulta é realizada utilizando um LEFT JOIN entre as tabelas "GESUSU" e "GESNOT".
            // A condição ON especifica que as duas tabelas são unidas pelo campo "id_usu".
            // A condição b.situac_usu_visualizar = 0 filtra as notificações que ainda não foram visualizadas pelo usuário.
            // A cláusula WHERE filtra os usuários com base nas seguintes condições:
            // - b.id_emp: ID da empresa
            // - a.situac: Valor igual a 1, indicando que o usuário está ativo
            // - b.datinc: A data de inclusão da notificação deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem alfabética com base na coluna "nome" da tabela "GESUSU".
            // A consulta retorna apenas os usuários distintos que têm notificações pendentes de visualização.
            $query =
                'SELECT DISTINCT a.id_usu, a.nome
                FROM public."GESUSU" AS a
                LEFT JOIN public."GESNOT" AS b
                ON a.id_usu = b.id_usu AND b.situac_usu_visualizar = 0
                WHERE b.id_emp = :id_emp AND a.situac = 1 AND b.datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY a.nome';
            break;

            // Consulta para obter usuários distintos do PainelRH que têm avisos pendentes de visualização
        case 'M':
            // A coluna "id_usu" e a coluna "nome" da tabela "GESUSU" são selecionadas.
            // A cláusula DISTINCT garante que apenas valores únicos sejam retornados.
            // A consulta é realizada utilizando dois LEFT JOINs:
            // - O primeiro LEFT JOIN é entre as tabelas "GESUSU" e "GESMUU".
            //   A condição ON especifica que as duas tabelas são unidas pelo campo "id_usu".
            //   A condição b.situac_usu_visualizar = 0 filtra os avisos que ainda não foram visualizados pelo usuário.
            // - O segundo LEFT JOIN é entre as tabelas "GESMUU" e "GESMUR".
            //   A condição ON especifica que as duas tabelas são unidas pelo campo "id_mur".
            // A cláusula WHERE filtra os usuários com base nas seguintes condições:
            // - c.id_emp: ID da empresa
            // - a.situac: Valor igual a 1, indicando que o usuário está ativo
            // - c.datinc: A data de inclusão do aviso deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem alfabética com base na coluna "nome" da tabela "GESUSU".
            // A consulta retorna apenas os usuários distintos que têm avisos pendentes de visualização.
            $query =
                'SELECT DISTINCT a.id_usu, a.nome
                FROM public."GESUSU" AS a
                LEFT JOIN public."GESMUU" AS b
                    ON a.id_usu = b.id_usu AND b.situac_usu_visualizar = 0
                LEFT JOIN public."GESMUR" AS c
                    ON b.id_mur = c.id_mur
                WHERE c.id_emp = :id_emp AND a.situac = 1 AND c.datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY a.nome';
            break;

            // Consulta para obter usuários distintos do PainelRH que têm mensagens da ouvidoria pendentes de resposta
        case 'F':
            // A coluna "id_usu" da tabela "GESUSU" é selecionada, juntamente com uma coluna calculada "nome".
            // A cláusula DISTINCT garante que apenas valores únicos sejam retornados.
            // A cláusula CASE WHEN é usada para verificar se o valor da coluna "id_usu" é diferente de 0.
            // - Se for diferente de 0, o valor da coluna "nome" é mantido intacto.
            // - Caso contrário, é retornado o valor 'ANONIMO'.
            // A consulta é realizada utilizando um LEFT JOIN entre as tabelas "GESUSU" e "GESOUV".
            // A condição ON especifica que as duas tabelas são unidas pelo campo "id_usu_inc".
            // A condição b.situac = 0 filtra as mensagens da ouvidoria que estão PENDENTES.
            // A cláusula WHERE filtra os usuários com base nas seguintes condições:
            // - b.id_emp: ID da empresa
            // - a.situac: Valor igual a 1, indicando que o usuário está ativo.
            // Os resultados são ordenados em ordem alfabética com base na coluna "nome".
            // A consulta retorna apenas os usuários distintos que têm mensagens da ouvidoria pendentes de resposta.
            // Caso o usuário seja anônimo (id_usu = 0), o nome exibido será 'ANONIMO'.
            $query =
                'SELECT DISTINCT a.id_usu, case when a.id_usu <> 0 then a.nome else \'ANONIMO\' END AS nome
                FROM public."GESUSU" AS a
                LEFT JOIN public."GESOUV" AS b
                ON a.id_usu = b.id_usu_inc AND b.situac = 0
                WHERE b.id_emp = :id_emp AND a.situac = 1
                ORDER BY nome';
            break;

            // Consulta para obter usuários distintos do PainelRH que têm treinamentos pendentes de visualização
        case 'T':
            // A coluna "id_usu" e a coluna "nome" da tabela "GESUSU" são selecionadas.
            // A cláusula DISTINCT garante que apenas valores únicos sejam retornados.
            // A consulta é realizada utilizando dois LEFT JOINs:
            // - O primeiro LEFT JOIN é entre as tabelas "GESUSU" e "GESTRU".
            //   A condição ON especifica que as duas tabelas são unidas pelo campo "id_usu".
            //   A condição b.situac_usu_visualizar = 0 filtra os treinamentos que ainda não foram visualizados pelo usuário.
            // - O segundo LEFT JOIN é entre as tabelas "GESTRU" e "GESTRE".
            //   A condição ON especifica que as duas tabelas são unidas pelo campo "id_tre".
            // A cláusula WHERE filtra os usuários com base nas seguintes condições:
            // - c.id_emp: ID da empresa
            // - a.situac: Valor igual a 1, indicando que o usuário está ativo
            // - c.datinc: A data de inclusão do treinamento deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem alfabética com base na coluna "nome" da tabela "GESUSU".
            // A consulta retorna apenas os usuários distintos que têm treinamentos pendentes de visualização.
            $query =
                'SELECT DISTINCT a.id_usu, a.nome
                FROM public."GESUSU" AS a
                LEFT JOIN public."GESTRU" AS b
                    ON a.id_usu = b.id_usu AND b.situac_usu_visualizar = 0
                LEFT JOIN public."GESTRE" AS c
                    ON b.id_tre = c.id_tre
                WHERE c.id_emp = :id_emp AND a.situac = 1 AND c.datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY a.nome';
            break;

            // Consulta para obter usuários distintos do PainelRH que têm solicitações pendentes
        case 'S':
            // A coluna "id_usu" e a coluna "nome" da tabela "GESUSU" são selecionadas.
            // A cláusula DISTINCT garante que apenas valores únicos sejam retornados.
            // A consulta é realizada utilizando um LEFT JOIN entre as tabelas "GESUSU" e "GESSOL".
            // A condição ON especifica que as duas tabelas são unidas pelo campo "id_usu_inc".
            // A condição b.situac <> 3 AND b.situac <> 4 filtra as solicitações que não estão aprovadas nem reprovadas.
            // A cláusula WHERE filtra os usuários com base nas seguintes condições:
            // - b.id_emp: ID da empresa
            // - a.situac: Valor igual a 1, indicando que o usuário está ativo.
            // Os resultados são ordenados em ordem alfabética com base na coluna "nome" da tabela "GESUSU".
            // A consulta retorna apenas os usuários distintos que têm solicitações pendentes.
            $query =
                'SELECT DISTINCT a.id_usu, a.nome
                    FROM public."GESUSU" AS a
                LEFT JOIN public."GESSOL" AS b
                    ON a.id_usu = b.id_usu_inc AND b.situac NOT IN (3, 4)
                WHERE b.id_emp = :id_emp AND a.situac = 1
                ORDER BY a.nome';
            break;
    }
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

//SELECT PainelRH_mensagem - revisado em 05/06/2023 07:23
// Parâmetros:
// $id_usu: ID do usuário
// $tipo: Tipo de mensagem (N - Fale com os Colaboradores, M - Mural de Avisos, F - Feedback e Sugestões, T - Treinamentos e Manuais, S - Solicitações dos Colaboradores)
// $id_emp: ID da empresa
function selectPAINELRH_mensagem($id_usu, $tipo, $id_emp)
{
    global $pdo;
    switch ($tipo) {

            // Consulta para obter NOTIFICAÇÕES do PainelRH
        case 'N':
            // A coluna "titulo" é verificada se seu comprimento é menor ou igual a 60 caracteres.
            // Se for, o valor da coluna "titulo" é mantido intacto.
            // Caso contrário, é retornado um subconjunto dos primeiros 60 caracteres da coluna "titulo".
            // A coluna resultante é renomeada como "titulo".
            // Também é selecionada a coluna "datinc".
            // A consulta é realizada na tabela "GESNOT" no esquema "public".
            // A condição WHERE filtra as notificações com base nos parâmetros:
            // - id_usu: ID do usuário
            // - id_emp: ID da empresa
            // - situac_usu_visualizar: Valor igual a 0, indicando que o usuário ainda não visualizou a notificação.
            // - datinc: A data de inclusão da notificação deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem decrescente com base na coluna "datinc".
            $query =
                'SELECT 
                    CASE WHEN LENGTH(titulo) <= 60
                        THEN titulo ELSE SUBSTRING(titulo, 1, 60)
                    END AS titulo,
                    datinc
                FROM public."GESNOT"
                WHERE id_usu = :id_usu AND id_emp = :id_emp AND situac_usu_visualizar = 0 AND datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY datinc DESC';
            break;

            // Consulta para obter AVISOS do PainelRH
        case 'M':
            // A coluna "titulo" da tabela "GESMUR" é verificada se seu comprimento é menor ou igual a 60 caracteres.
            // Se for, o valor da coluna "titulo" é mantido intacto.
            // Caso contrário, é retornado um subconjunto dos primeiros 60 caracteres da coluna "titulo".
            // A coluna resultante é renomeada como "titulo".
            // Também é selecionada a coluna "datinc" da tabela "GESMUR".
            // A consulta é realizada utilizando um LEFT JOIN entre as tabelas "GESMUR" e "GESMUU".
            // A condição ON especifica que as duas tabelas são unidas pelo campo "id_mur".
            // A cláusula WHERE filtra os avisos com base nas seguintes condições:
            // - b.id_usu: ID do usuário
            // - a.id_emp: ID da empresa
            // - b.situac_usu_visualizar: Valor igual a 0, indicando que o usuário ainda não visualizou o aviso.
            // - a.datinc: A data de inclusão do aviso deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem decrescente com base na coluna "datinc" da tabela "GESMUR".
            $query =
                'SELECT 
                    CASE WHEN LENGTH(a.titulo) <= 60
                        THEN a.titulo ELSE SUBSTRING(a.titulo, 1, 60)
                    END AS titulo,
                    a.datinc
                FROM public."GESMUR" AS a
                LEFT JOIN public."GESMUU" AS b
                    ON a.id_mur = b.id_mur
                WHERE b.id_usu = :id_usu AND a.id_emp = :id_emp AND b.situac_usu_visualizar = 0 AND a.datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY a.datinc DESC';
            break;

            // Consulta para obter mensagens da ouvidoria do PainelRH
        case 'F':
            // A coluna "mensagem" é verificada se seu comprimento é menor ou igual a 60 caracteres.
            // Se for, o valor da coluna "mensagem" é mantido intacto.
            // Caso contrário, é retornado um subconjunto dos primeiros 60 caracteres da coluna "mensagem".
            // A coluna resultante é renomeada como "titulo".
            // Também é selecionada a coluna "datinc".
            // A consulta é realizada na tabela "GESOUV" no esquema "public".
            // A condição WHERE filtra as mensagens da ouvidoria com base nos parâmetros:
            // - id_usu_inc: ID do usuário que incluiu a mensagem
            // - id_emp: ID da empresa
            // - situac: Valor igual a 0, indicando que a mensagem está em situação PENDENTE
            // Os resultados são ordenados em ordem decrescente com base na coluna "datinc".
            $query =
                'SELECT
                    CASE WHEN LENGTH(mensagem) <= 60
                        THEN mensagem ELSE SUBSTRING(mensagem, 1, 60)
                    END AS titulo,
                    datinc
                FROM public."GESOUV"
                WHERE id_usu_inc = :id_usu AND id_emp = :id_emp AND situac = 0
                ORDER BY datinc DESC';
            break;

            // Consulta para obter treinamentos do PainelRH
        case 'T':
            // A coluna "nome" da tabela "GESTRE" é verificada se seu comprimento é menor ou igual a 60 caracteres.
            // Se for, o valor da coluna "nome" é mantido intacto.
            // Caso contrário, é retornado um subconjunto dos primeiros 60 caracteres da coluna "nome".
            // A coluna resultante é renomeada como "titulo".
            // Também é selecionada a coluna "datinc" da tabela "GESTRE".
            // A consulta é realizada utilizando um LEFT JOIN entre as tabelas "GESTRE" e "GESTRU".
            // A condição ON especifica que as duas tabelas são unidas pelo campo "id_tre".
            // A cláusula WHERE filtra os treinamentos com base nas seguintes condições:
            // - b.id_usu: ID do usuário
            // - a.id_emp: ID da empresa
            // - b.situac_usu_visualizar: Valor igual a 0, indicando que o usuário ainda não visualizou o treinamento.
            // - a.datinc: A data de inclusão do treinamento deve ser maior ou igual a 90 dias atrás a partir da data atual.
            // Os resultados são ordenados em ordem decrescente com base na coluna "datinc" da tabela "GESTRE".
            $query =
                'SELECT 
                    CASE WHEN LENGTH(a.nome) <= 60
                        THEN a.nome ELSE SUBSTRING(a.nome, 1, 60)
                    END AS titulo,
                    a.datinc
                FROM public."GESTRE" AS a
                LEFT JOIN public."GESTRU" AS b
                    ON a.id_tre = b.id_tre
                WHERE b.id_usu = :id_usu AND a.id_emp = :id_emp AND b.situac_usu_visualizar = 0 AND a.datinc >= NOW() - INTERVAL \'90 days\'
                ORDER BY a.datinc DESC';
            break;

            // Consulta para obter solicitações do PainelRH
        case 'S':
            // A coluna "mensagem" é verificada se seu comprimento é menor ou igual a 60 caracteres.
            // Se for, o valor da coluna "mensagem" é mantido intacto.
            // Caso contrário, é retornado um subconjunto dos primeiros 60 caracteres da coluna "mensagem".
            // A coluna resultante é renomeada como "titulo".
            // Também é selecionada a coluna "datinc".
            // A consulta é realizada na tabela "GESSOL" no esquema "public".
            // A condição WHERE filtra as solicitações com base nos parâmetros:
            // - id_usu_inc: ID do usuário que incluiu a solicitação
            // - id_emp: ID da empresa
            // - situac: A coluna "situac" não pode ser igual a 3 (Aprovado) e nem igual a 4 (Reprovado).
            // Os resultados são ordenados em ordem decrescente com base na coluna "datinc".
            // A consulta retorna apenas as solicitações que não estão aprovadas nem reprovadas.
            $query =
                'SELECT
                    CASE WHEN LENGTH(mensagem) <= 60
                        THEN mensagem ELSE SUBSTRING(mensagem, 1, 60)
                    END AS titulo,
                    datinc
                FROM public."GESSOL"
                WHERE id_usu_inc = :id_usu AND id_emp = :id_emp AND situac NOT IN (3, 4)
                ORDER BY datinc DESC';
            break;
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT DOCUMENTOS_grafico - revisado em 07/06/2023 12:59
function selectDOCUMENTOS_grafico($tabela1, $tabela2, $tabela3, $tabela4, $id_emp)
{
    global $pdo;
    $query =
        'SELECT sequencia, ano, mes, SUM(documentos_visualizados) AS total_documentos_visualizados, SUM(total_documentos) AS total_documentos
            FROM (SELECT CONCAT(EXTRACT(YEAR FROM datinc), \'-\', LPAD(  EXTRACT(MONTH FROM datinc)::text, 2, \'0\')) AS sequencia,
                EXTRACT(YEAR FROM datinc) AS ano,
                EXTRACT(MONTH FROM datinc) AS mes,
                COUNT(CASE WHEN situac_visualizar = 1 THEN 1 END) AS documentos_visualizados,
                COUNT(*) AS total_documentos
            FROM ' . $tabela1 . '
        WHERE situac <> 1 AND datinc >= DATE_TRUNC(\'MONTH\', CURRENT_DATE) - INTERVAL \'6 months\' AND id_emp = :id_emp
        GROUP BY ano, mes
            
        UNION

        SELECT CONCAT(EXTRACT(YEAR FROM datinc), \'-\', LPAD(  EXTRACT(MONTH FROM datinc)::text, 2, \'0\')) AS sequencia,
                EXTRACT(YEAR FROM datinc) AS ano,
                EXTRACT(MONTH FROM datinc) AS mes,
                COUNT(CASE WHEN situac_visualizar = 1 THEN 1 END) AS documentos_visualizados,
                COUNT(*) AS total_documentos
            FROM ' . $tabela2 . '
        WHERE situac <> 1 AND datinc >= DATE_TRUNC(\'MONTH\', CURRENT_DATE) - INTERVAL \'6 months\' AND id_emp = :id_emp
        GROUP BY ano, mes
        
        UNION

        SELECT CONCAT(EXTRACT(YEAR FROM datinc), \'-\', LPAD(  EXTRACT(MONTH FROM datinc)::text, 2, \'0\')) AS sequencia,
                EXTRACT(YEAR FROM datinc) AS ano,
                EXTRACT(MONTH FROM datinc) AS mes,
                COUNT(CASE WHEN situac_visualizar = 1 THEN 1 END) AS documentos_visualizados,
                COUNT(*) AS total_documentos
            FROM ' . $tabela3 . '
        WHERE situac <> 1 AND datinc >= DATE_TRUNC(\'MONTH\', CURRENT_DATE) - INTERVAL \'6 months\' AND id_emp = :id_emp
        GROUP BY ano, mes
        
        UNION

        SELECT CONCAT(EXTRACT(YEAR FROM datinc), \'-\', LPAD(  EXTRACT(MONTH FROM datinc)::text, 2, \'0\')) AS sequencia,
                EXTRACT(YEAR FROM datinc) AS ano,
                EXTRACT(MONTH FROM datinc) AS mes,
                COUNT(CASE WHEN situac_visualizar = 1 THEN 1 END) AS documentos_visualizados,
                COUNT(*) AS total_documentos
            FROM ' . $tabela4 . '
        WHERE situac <> 1 AND datinc >= DATE_TRUNC(\'MONTH\', CURRENT_DATE) - INTERVAL \'6 months\' AND id_emp = :id_emp
        GROUP BY ano, mes) AS subquery
        GROUP BY sequencia, ano, mes
        ORDER BY sequencia';
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

//SELECT GESLCM_ativos - revisado em 05/06/2023 15:49
function selectGESLCM_ativos($id_usu)
{
    global $pdo;
    $query =
        'SELECT A.ID_LCM,B.DESCRI AS CURSO_EXAME, A.DATREF, A.PRODAT, A.OBSERV
        FROM public."GESLCM" AS A
        INNER JOIN public."GESCUR" AS B ON A.ID_CUR = B.ID_CUR
        WHERE A.SITUAC = 0 AND PRODAT > CURRENT_DATE AND id_usu = :id_usu
        ORDER BY A.PRODAT DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESLCM_vencido - revisado em 05/06/2023 15:49
function selectGESLCM_vencido($id_usu)
{
    global $pdo;
    $query =
        'SELECT A.ID_LCM, B.DESCRI AS CURSO_EXAME, A.DATREF, A.PRODAT, A.OBSERV
        FROM public."GESLCM" AS A
        INNER JOIN public."GESCUR" AS B ON A.ID_CUR = B.ID_CUR
        WHERE A.SITUAC = 0 AND PRODAT <= CURRENT_DATE AND id_usu = :id_usu
        ORDER BY A.PRODAT DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESEMP_token - revisado em 06/05/2023 10:00
function selectGESEMP_token($id_emp)
{
    global $pdo;
    $query =
        'SELECT token, datval_token AS vencimento
        FROM public."GESEMP"
        WHERE id_emp = :id_emp';
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

//Tabela GESEMP_token update - revisado em 06/06/2023 12:56
function updateGESEMP_token($id_emp, $token, $venc_token, $datatu)
{
    global $pdo;
    $query = 'UPDATE public."GESEMP" SET token = :token, datval_token = :venc_token, datatu = :datatu WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':token', $token, PDO::PARAM_STR);
    $statement->bindParam(':venc_token', $venc_token, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT GESUSU_aprovacao - revisado em 12/06/2023 15:31
function selectGESUSU_aprovacao($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS conta
        FROM public."GESUSU"
        WHERE id_emp = :id_emp AND analise = 1 AND situac_inclusao = 1';
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

//SELECT GESUSU_dados_aprovacao - revisado em 13/06/2023 13:04
function selectGESUSU_dados_aprovacao($id_emp)
{
    global $pdo;
    //     Consulta para obter informações de usuários no PainelRH
    // Seleciona as colunas "id_usu", "nome", "cpf" e "email" da tabela "GESUSU" no esquema "public"
    // A condição WHERE filtra os resultados com base nos parâmetros:
    // - id_emp: ID da empresa
    // - analise: A coluna "analise" deve ser igual a 1, ou seja, está pendente de aprovação
    // - situac_inclusao: A coluna "situac_inclusao" deve ser igual a 1, ou seja, foi incluido pelo colaborador pelo link de createemployee
    $query =
        'SELECT id_usu, nome, cpf, email
        FROM public."GESUSU"
        WHERE id_emp = :id_emp AND analise = 1 AND situac_inclusao = 1';
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

//Tabela GESUSU_aprovacao update - revisado em 13/06/2023 13:44
function updateGESUSU_aprovacao($id_usu, $bloqueado, $situac, $datatu)
{
    global $pdo;
    $query = 'UPDATE public."GESUSU" SET bloqueado = :bloqueado, analise = 0, situac = :situac, datatu = :datatu WHERE id_usu = :id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':bloqueado', $bloqueado, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESMNU_link select - revisado em 14/06/2023 15:06
function selectGESMNU_link($link, $tipo)
{
    global $pdo;
    $query =
        'SELECT id_mnu
        FROM public."GESMNU"
        WHERE link = :link AND tipo = :tipo';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMPR_permissao select - revisado em 14/06/2023 08:32
function selectGESMPR_permissao($id_emp, $id_usa, $id_mnu)
{
    global $pdo;
    $query =
        'SELECT situac
        FROM public."GESMPR"
        WHERE id_emp = :id_emp AND id_usa = :id_usa AND id_mnu = :id_mnu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_mnu', $id_mnu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESCUR - revisado em 15/06/2023 10:22
function selectGESCUR($id_emp)
{
    global $pdo;
    $query =
        'SELECT *
        FROM public."GESCUR"
        WHERE id_emp = :id_emp
        ORDER BY datatu DESC';
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

//Tabela GESCUR insert - revisado em 23/06/2023 10:18
function insertGESCUR(
    $tipo,
    $descricao,
    $periodo,
    $carencia,
    $local,
    $painel,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESCUR" (tipcur, descri, period, caravi, local, painel, situac, datinc, datatu, id_usa_inc, id_usa_atu, id_emp)
        VALUES (:tipo, :descricao, :periodo, :carencia, :local, :painel, 1, :datinc, :datatu, :id_usa_inc, :id_usa_atu, :id_emp)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':periodo', $periodo, PDO::PARAM_INT);
    $statement->bindParam(':carencia', $carencia, PDO::PARAM_INT);
    $statement->bindParam(':local', $local, PDO::PARAM_INT);
    $statement->bindParam(':painel', $painel, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESCUR_situac update - revisado em 16/06/2023 15:03
function updateGESCUR_situac($id_cur, $situac, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESCUR"
            SET situac = :situac, datatu = :datatu, id_usa_atu = :id_usa_atu
        WHERE id_cur = :id_cur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT GESCUR_id - revisado em 19/06/2023 10:07
function selectGESCUR_id($id_cur)
{
    global $pdo;
    $query =
        'SELECT *
        FROM public."GESCUR"
        WHERE id_cur = :id_cur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESCUR_editar update - revisado em 23/06/2023 12:28
function updateGESCUR_editar(
    $tipo,
    $descricao,
    $periodo,
    $carencia,
    $local,
    $painel,
    $datatu,
    $id_usa_atu,
    $id_cur
) {
    global $pdo;
    $query =
        'UPDATE public."GESCUR"
            SET tipcur = :tipo, descri = :descricao, period = :periodo, caravi = :carencia, local = :local, painel = :painel, datatu = :datatu, id_usa_atu = :id_usa_atu
        WHERE id_cur = :id_cur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':periodo', $periodo, PDO::PARAM_INT);
    $statement->bindParam(':carencia', $carencia, PDO::PARAM_INT);
    $statement->bindParam(':local', $local, PDO::PARAM_INT);
    $statement->bindParam(':painel', $painel, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESCUR_in delete - revisado 19/06/2023 12:56
function deleteGESCUR_in(array $ids_cur)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($ids_cur), '?'));
    $query =
        'DELETE FROM public."GESCUR" 
            WHERE id_cur IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($ids_cur as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    $statement->execute();
}

//SELECT GESLCM - revisado em 19/06/2023 14:28
function selectGESLCM($id_emp)
{
    global $pdo;
    $query =
        'SELECT a.*, b.nome as colaborador, c.descri as titulo
        FROM public."GESLCM" AS a
        LEFT JOIN public."GESUSU" AS b
            ON a.id_usu = b.id_usu
        LEFT JOIN public."GESCUR" AS c
            ON a.id_cur = c.id_cur
        WHERE a.id_emp = :id_emp
        ORDER BY a.datref DESC';
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

//Tabela GESUSU_emp select - revisado em 19/06/2023 16:31
function selectGESUSU_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome
            FROM public."GESUSU"
        WHERE id_emp = :id_emp AND situac = 1
        ORDER BY nome';
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

//Tabela GESCUR_emp select - revisado em 19/06/2023 16:37
function selectGESCUR_emp($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_cur, descri, period
        FROM public."GESCUR"
        WHERE id_emp = :id_emp AND situac = 1
        ORDER BY descri DESC';
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

//Tabela GESLCM insert - revisado em 21/06/2023 08:41
function insertGESLCM(
    $id_emp,
    $id_usu,
    $id_cur,
    $period,
    $datref,
    $prodat,
    $observ,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESLCM" (id_emp, id_usu, id_cur, period, datref, prodat, observ, situac, datinc, datatu, id_usa_inc, id_usa_atu)
        VALUES (:id_emp, :id_usu, :id_cur, :period, :datref, :prodat, :observ, 0, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->bindParam(':period', $period, PDO::PARAM_INT);
    $statement->bindParam(':datref', $datref, PDO::PARAM_STR);
    $statement->bindParam(':prodat', $prodat, PDO::PARAM_STR);
    $statement->bindParam(':observ', $observ, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESLCM_in delete - revisado 21/06/2023 09:20
function deleteGESLCM_in(array $ids_lcm)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($ids_lcm), '?'));
    $query =
        'DELETE FROM public."GESLCM" 
            WHERE id_lcm IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($ids_lcm as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    $statement->execute();
}

//SELECT GESLCM_id - revisado em 21/06/2023 09:30
function selectGESLCM_id($id_lcm)
{
    global $pdo;
    $query =
        'SELECT *
        FROM public."GESLCM"
        WHERE id_lcm = :id_lcm';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_lcm', $id_lcm, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESUSU_id_lcm - revisado em 21/06/2023 09:36
function selectGESUSU_id_lcm($id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT id_usu, nome
        FROM public."GESUSU"
        WHERE id_emp = :id_emp AND situac = 1
        ORDER BY CASE WHEN id_usu = :id_usu THEN 0 ELSE 1 END, nome';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESCUR_id_lcm - revisado em 21/06/2023 09:42
function selectGESCUR_id_lcm($id_emp, $id_cur)
{
    global $pdo;
    $query =
        'SELECT id_cur, descri
        FROM public."GESCUR"
        WHERE id_emp = :id_emp AND situac = 1
        ORDER BY CASE WHEN id_cur = :id_cur THEN 0 ELSE 1 END, descri';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESLCM_editar update - revisado em 21/06/2023 10:12
function updateGESLCM_editar(
    $id_lcm,
    $id_usu,
    $id_cur,
    $period,
    $datref,
    $prodat,
    $observ,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESLCM"
            SET id_usu = :id_usu, id_cur = :id_cur, period = :period, datref = :datref, prodat = :prodat, observ = :observ, datatu = :datatu, id_usa_atu = :id_usa_atu
        WHERE id_lcm = :id_lcm';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_lcm', $id_lcm, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->bindParam(':period', $period, PDO::PARAM_INT);
    $statement->bindParam(':datref', $datref, PDO::PARAM_STR);
    $statement->bindParam(':prodat', $prodat, PDO::PARAM_STR);
    $statement->bindParam(':observ', $observ, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESLCM_in_cancelar update - revisado 21/06/2023 10:32
function updateGESLCM_in_cancelar(array $ids_lcm)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($ids_lcm), '?'));
    $query =
        'UPDATE public."GESLCM" 
            SET situac = 1
            WHERE id_lcm IN(' . $inQuery . ')';
    $statement = $pdo->prepare($query);
    foreach ($ids_lcm as $k => $id) {

        $statement->bindValue(($k + 1), $id);
    }

    $statement->execute();
}

//SELECT VW_CURSOS_A_VENCER_count - revisado em 23/06/2023 08:22
function select_VW_CURSOS_A_VENCER_count($id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_usu) AS conta
        FROM public."VW_CURSOS_A_VENCER"
        WHERE id_emp = :id_emp AND status = 1';
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

//SELECT VW_CURSOS_A_VENCER_curso - revisado em 23/06/2023 10:24
function select_VW_CURSOS_A_VENCER_curso($id_emp)
{
    global $pdo;
    $query =
        'SELECT DISTINCT id_cur, curso
        FROM public."VW_CURSOS_A_VENCER"
        WHERE id_emp = :id_emp AND status = 1';
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

//SELECT VW_CURSOS_A_VENCER - revisado em 28/06/2023 08:58
function select_VW_CURSOS_A_VENCER($id_emp, $id_cur)
{
    global $pdo;
    $query =
        'SELECT nome, last_prodat AS vencimento
        FROM public."VW_CURSOS_A_VENCER"
        WHERE id_emp = :id_emp AND id_cur = :id_cur AND status = 1
        ORDER BY last_prodat ASC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_cur', $id_cur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESANE - revisado em 28/06/2023 08:34
function selectGESANE($id_lcm)
{
    global $pdo;
    $query =
        'SELECT *
        FROM public."GESANE"
        WHERE id_lcm = :id_lcm AND situac = 0
        ORDER BY datatu DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_lcm', $id_lcm, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESLCM_colab - revisado em 26/06/2023 13:11
function selectGESLCM_colab($id_lcm)
{
    global $pdo;
    $query =
        'SELECT a.cpf AS cpf
        FROM public."GESUSU" AS a
        INNER JOIN public."GESLCM" AS b
        ON a.id_usu = b.id_usu
        WHERE b.id_lcm = :id_lcm';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_lcm', $id_lcm, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESANE insert - revisado em 26/06/2023 14:06
function insertGESANE(
    $anexo,
    $datinc,
    $id_usa_inc,
    $datatu,
    $id_usa_atu,
    $caminho,
    $id_lcm
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESANE" (anexo, datinc, id_usa_inc, datatu, id_usa_atu, caminho, id_lcm)
        VALUES (:anexo, :datinc, :id_usa_inc, :datatu, :id_usa_atu, :caminho, :id_lcm)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':caminho', $caminho, PDO::PARAM_STR);
    $statement->bindParam(':id_lcm', $id_lcm, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT GESANE_max - revisado em 26/06/2023 14:24
function selectGESANE_max()
{
    global $pdo;
    $query =
        'SELECT MAX(id_ane) AS num_id FROM public."GESANE"';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESANE_id - revisado em 28/06/2023 07:45
function selectGESANE_id($id_ane)
{
    global $pdo;
    $query =
        'SELECT anexo, caminho, id_lcm
        FROM public."GESANE"
        WHERE id_ane = :id_ane
        ORDER BY datatu DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ane', $id_ane, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESANE_excluir update - revisado em 28/06/2023 08:24
function updateGESANE_excluir($id_ane, $caminho)
{
    global $pdo;
    $query =
        'UPDATE public."GESANE"
            SET situac = 1, caminho = :caminho
        WHERE id_ane = :id_ane';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ane', $id_ane, PDO::PARAM_INT);
    $statement->bindParam(':caminho', $caminho, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESFER select - revisado em 29/06/2023 08:33
function selectGESFER($id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESFER" WHERE id_emp = :id_emp order by id_fer asc';
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

//Tabela GESFER insert - revisado em 29/06/2023 14:06
function insertGESFER(
    $iniaqu,
    $fimaqu,
    $datini,
    $datfim,
    $datlmt,
    $situac,
    $id_usa
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESFER" (iniaqu, fimaqu, datini, datfim, datlmt, situac, id_usa)
        VALUES (:iniaqu, :fimaqu, :datini, :datfim, :datlmt, :situac, :id_usa)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':iniaqu', $iniaqu, PDO::PARAM_STR);
    $statement->bindParam(':fimaqu', $fimaqu, PDO::PARAM_STR);
    $statement->bindParam(':datini', $datini, PDO::PARAM_STR);
    $statement->bindParam(':datfim', $datfim, PDO::PARAM_STR);
    $statement->bindParam(':datlmt', $datlmt, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela updateGESIM1_ajuste_salario update - revisado em 14/10/2022 09:50
function updateGESIM1_ajuste_salario($tabela, $vlr_liquido, $id_usa_atu, $id_im1)
{
    global $pdo;
    $query =
        'UPDATE ' . $tabela . ' SET vlr_liquido = :vlr_liquido, id_usa_atu = :id_usa_atu WHERE id_im1 = :id_im1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':vlr_liquido', $vlr_liquido, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_im1', $id_im1, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU select
function selectGESUSU_VERIFICACPF($cpf, $id_emp)
{
    global $pdo;
    $query =
        'SELECT EXISTS (
            SELECT 1 
            FROM public."GESUSU" 
            WHERE cpf = :cpf and id_emp = :id_emp
        );';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select
function selectGESEMP_CONSULTAIDMUN($id_emp)
{
    global $pdo;
    $query =
        'SELECT id_mun FROM public."GESEMP" 
            WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select
function selectGESUSU_VERIFICAEMAIL($cpf, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_usu, email FROM public."GESUSU" 
            WHERE cpf = :cpf and id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU insert - revisado em 08/12/2021 08:49
function insertGESUSU_importacao(
    $nome,
    $cpf,
    $senha,
    $datinc,
    $situac,
    $email,
    $id_emp,
    $id_mun,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESUSU"(nome, cpf, senha, datinc, situac, email, id_emp, id_mun, datatu, id_usa_inc, id_usa_atu) VALUES (:nome, :cpf, :senha, :datinc, :situac, :email, :id_emp, :id_mun, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESUSU update - revisado em 08/12/2021 08:49
function updateGESUSU_importacao(
    $id_usu,
    $email,
    $datatu,
    $id_usa_atu
) {
    global $pdo;
    $query = '
        UPDATE public."GESUSU"
        SET
            email = :email,
            datatu = :datatu,
            id_usa_atu = :id_usa_atu
        WHERE
            id_usu = :id_usu
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

// SELECT GESIM1 - revisado em 05/09/2024 - 18:47
function select_DOCUMENTOS($raiz_cnpj, $id_usu, $id_emp)
{
    global $pdo;
    $query =
        'SELECT id_im1 AS codigo, descricao AS descricao, arquivo AS arquivo, competencia AS competencia, \'Holerite\' AS tipo, datinc AS inclusao
            FROM public."GESIM1_' . $raiz_cnpj . '"
        WHERE id_usu = :id_usu AND id_emp = :id_emp AND arquivo IS NOT NULL
        
        UNION

        SELECT id_irr AS codigo, regexp_replace(origem, \'(.pdf)|(.PDF)$\', \'\') AS descricao, arquivo AS arquivo, anoexe AS competencia, \'IRRF\' AS tipo, datinc AS inclusao
            FROM public."GESIRR_' . $raiz_cnpj . '"
        WHERE id_usu = :id_usu AND id_emp = :id_emp AND arquivo IS NOT NULL
        
        UNION

        SELECT id_pon1 AS codigo, regexp_replace(origem, \'(.pdf)|(.PDF)$\', \'\') AS descricao, arquivo AS arquivo, periodo AS competencia, \'Ponto\' AS tipo, datinc AS inclusao
            FROM public."GESPON1_' . $raiz_cnpj . '"
        WHERE id_usu = :id_usu AND id_emp = :id_emp AND arquivo IS NOT NULL
        
        UNION

        SELECT id_rec AS codigo, descricao AS descricao, arquivo AS arquivo, TO_CHAR(datinc, \'DD/MM/YYYY\') AS competencia, \'Diversos\' AS tipo, datinc AS inclusao
            FROM public."GESREC_' . $raiz_cnpj . '"
        WHERE id_usu = :id_usu AND id_emp = :id_emp AND arquivo IS NOT NULL

        UNION

        SELECT id_dcol AS codigo, descricao AS descricao, arquivo AS arquivo, TO_CHAR(datinc, \'DD/MM/YYYY\') AS competencia, \'Documento\' AS tipo, datinc AS inclusao
            FROM public."GESDCOL"
        WHERE id_usu = :id_usu AND id_emp = :id_emp AND arquivo IS NOT NULL

        ORDER BY inclusao DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//INSERT insert_GESDCOL revisado - 05/09/2024 17:52
function insert_GESDCOL($descricao, $arquivo, $id_emp, $id_usu, $datinc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESDCOL" (descricao, arquivo, id_emp, id_usu, datinc, datatu) VALUES (:descricao, :arquivo, :id_emp, :id_usu, :datinc, :datinc)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':arquivo', $arquivo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}
