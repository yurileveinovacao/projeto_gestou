<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once 'conexao_pdo.php';

//Tabela GESPRI select
function selectGESPRI_termos()
{
    global $pdo;
    $query =
        'SELECT descricao
        FROM public."GESPRI"
        WHERE admin=1 and tipo=\'T\' and situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPRI select
function selectGESPRI_politica()
{
    global $pdo;
    $query =
        'SELECT descricao
        FROM public."GESPRI"
        WHERE admin=1 and tipo=\'P\' and situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPRI select
function selectGESPRI()
{
    global $pdo;
    $query =
        'SELECT id_pri
        FROM public."GESPRI"
        WHERE admin=1 and situac=1
        ';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESEMP select
function selectGESEMP($cnpj)
{
    global $pdo;
    $query =
        'SELECT count(id_emp) as contagem
        FROM public."GESEMP"
        WHERE cnpj=:cnpj
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA_CPF select
function selectGESUSA_CPF($cpf)
{
    global $pdo;
    $query =
        'SELECT count(cpf) as contagem_cpf
        FROM public."GESUSA"
        WHERE cpf=:cpf
        ';
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


//Tabela GESUSA_EMAIL select
function selectGESUSA_EMAIL($email)
{
    global $pdo;
    $query =
        'SELECT count(email) as contagem_email
        FROM public."GESUSA"
        WHERE email=:email
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

//Tabela GESEMP insert
function insertGESEMP(
    $nome,
    $cnpj,
    $email,
    $telefone,
    $quant_colab,
    $datinc,
    $datatu,
    $situac
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEMP"(nome, cnpj, email, telefone, quant_colab, datinc, datatu, situac) VALUES (:nome, :cnpj, :email, :telefone, :quant_colab, :datinc, :datatu, :situac) RETURNING id_emp as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':quant_colab', $quant_colab, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    $id_emp = $statement->fetch(PDO::FETCH_ASSOC);

    return $id_emp;
}

//Tabela GESUSA insert
function insertGESUSA($nome, $cpf, $email, $telefone, $senha, $datinc, $id_emp_acess, $situac, $analise, $id_per)
{
    global $pdo;
    $query = 'INSERT INTO public."GESUSA"(nome, cpf, email, telefone, senha, datinc, id_emp_acess, situac, analise, id_per) VALUES (:nome, :cpf, :email, :telefone, :senha, :datinc, :id_emp_acess, :situac, :analise, :id_per) RETURNING id_usa as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->execute();
    $id_usa = $statement->fetch(PDO::FETCH_ASSOC);

    return $id_usa;
}

//Tabela GESVIN insert
function insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2)
{
    global $pdo;
    $query = 'INSERT INTO public."GESVIN"(tabvin1, id_tab1, tabvin2, id_tab2) VALUES (:tabvin1, :id_tab1, :tabvin2, :id_tab2)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tabvin1', $tabvin1, PDO::PARAM_STR);
    $statement->bindParam(':id_tab1', $id_tab1, PDO::PARAM_INT);
    $statement->bindParam(':tabvin2', $tabvin2, PDO::PARAM_STR);
    $statement->bindParam(':id_tab2', $id_tab2, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESACP insert
function insertGESACP($id_usa, $id_pri, $ip, $datinc, $browser, $device, $os)
{
    global $pdo;
    $query = 'INSERT INTO public."GESACP"(id_usa, id_pri, ip, datinc, browser, device, os) VALUES (:id_usa, :id_pri, :ip, :datinc, :browser, :device, :os)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_pri', $id_pri, PDO::PARAM_INT);
    $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':browser', $browser, PDO::PARAM_STR);
    $statement->bindParam(':device', $device, PDO::PARAM_STR);
    $statement->bindParam(':os', $os, PDO::PARAM_STR);
    $statement->execute();
}
