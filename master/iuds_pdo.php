<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once 'conexao_pdo.php';

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


//Tabela GESEMP insert - revisado em 22/03/2023 08:35
function insertGESEMP_MASTER(
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
    $email,
    $layout_ponto,
    $id_per_imp,
    $id_per_ace,
    $layout_irrf,
    $contato,
    $valges,
    $tipo,
    $nomefantasia,
    $resp_financeiro,
    $email_financeiro
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEMP" (nome, cnpj, endereco, numero, bairro, cep, situac, complemento, imagem, layout, id_mun, telefone, datinc, datatu, id_usa_atu, email, layout_ponto, id_per_imp, id_per_ace, layout_irrf, contato, valges, tipo, nomefantasia, resp_financeiro, email_financeiro)
        VALUES (:nome, :cnpj, :endereco, :numero, :bairro, :cep, :situac, :complemento, :imagem, :layout, :id_mun, :telefone, :datinc, :datatu, :id_usa_atu , :email, :layout_ponto, :id_per_imp, :id_per_ace, :layout_irrf, :contato, :valges, :tipo, :nomefantasia, :resp_financeiro, :email_financeiro)
        RETURNING id_emp as pk';
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
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':layout_ponto', $layout_ponto, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':layout_irrf', $layout_irrf, PDO::PARAM_STR);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':valges', $valges, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->execute();
    $id_emp = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_emp;
}

//Tabela selectGESEMP_FILIAL select - revisado em 06/12/2021 16:26
function selectGESEMP_FILIAL($id_emp)
{
    global $pdo;
    $query = 'SELECT cnpj as cnpj_matriz,imagem,layout,layout_ponto,id_per_imp,id_per_ace,layout_irrf,valges,id_usa_rh,id_usa_ouv,id_emp_grupo,descricao_layout,tipo_h,tipo_p,tipo_i FROM public."GESEMP" where id_emp=:id_emp';
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

//Tabela selectGESEMP_NOVA_GRUPO select - revisado em 06/12/2021 16:26
function selectGESEMP_NOVA_GRUPO($id_emp)
{
    global $pdo;
    $query = 'SELECT cnpj as cnpj_matriz,imagem,layout,layout_ponto,id_per_imp,id_per_ace,layout_irrf,valges,id_usa_rh,id_usa_ouv,id_emp_grupo,descricao_layout,tipo_h,tipo_p,tipo_i FROM public."GESEMP" where id_emp=:id_emp';
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

//Tabela GESEMP insert - revisado em 22/03/2023 08:35
function insertGESEMP_FILIAL(
    $nome,
    $nomefantasia,
    $cnpj,
    $email,
    $contato,
    $telefone,
    $resp_financeiro,
    $email_financeiro,
    $endereco,
    $bairro,
    $numero,
    $complemento,
    $id_mun,
    $cep,
    $imagem,
    $layout,
    $layout_ponto,
    $id_per_imp,
    $id_per_ace,
    $layout_irrf,
    $valges,
    $id_usa_rh,
    $id_usa_ouv,
    $id_emp_grupo,
    $descricao_layout,
    $tipo_h,
    $tipo_p,
    $tipo_i,
    $id_mas,
    $datatu_mas,
    $quant_colab,
    $analise,
    $limite_paginas,
    $id_emp_i,
    $id_emp_p,
    $id_emp_h,
    $tipo,
    $situac
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEMP" (nome, nomefantasia, cnpj, email, contato, telefone, resp_financeiro, email_financeiro, endereco, bairro, numero, complemento, id_mun, cep,
        imagem, layout, layout_ponto, id_per_imp, id_per_ace, layout_irrf, valges, id_usa_rh, id_usa_ouv, id_emp_grupo, descricao_layout, tipo_h, tipo_p, tipo_i,
        id_mas, datatu_mas, quant_colab, analise, limite_paginas, id_emp_i, id_emp_p, id_emp_h, tipo, situac)
        VALUES (:nome, :nomefantasia, :cnpj, :email, :contato, :telefone, :resp_financeiro, :email_financeiro, :endereco, :bairro, :numero, :complemento, :id_mun, :cep,
                :imagem, :layout, :layout_ponto, :id_per_imp, :id_per_ace, :layout_irrf, :valges, :id_usa_rh, :id_usa_ouv, :id_emp_grupo, :descricao_layout, :tipo_h, :tipo_p, :tipo_i,
                :id_mas, :datatu_mas, :quant_colab, :analise, :limite_paginas, :id_emp_i, :id_emp_p, :id_emp_h, :tipo, :situac)
        RETURNING id_emp as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':layout', $layout, PDO::PARAM_STR);
    $statement->bindParam(':layout_ponto', $layout_ponto, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':layout_irrf', $layout_irrf, PDO::PARAM_STR);
    $statement->bindParam(':valges', $valges, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_rh', $id_usa_rh, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_ouv', $id_usa_ouv, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_grupo', $id_emp_grupo, PDO::PARAM_INT);
    $statement->bindParam(':descricao_layout', $descricao_layout, PDO::PARAM_STR);
    $statement->bindParam(':tipo_h', $tipo_h, PDO::PARAM_STR);
    $statement->bindParam(':tipo_p', $tipo_p, PDO::PARAM_STR);
    $statement->bindParam(':tipo_i', $tipo_i, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':quant_colab', $quant_colab, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':limite_paginas', $limite_paginas, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_i', $id_emp_i, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_p', $id_emp_p, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_h', $id_emp_h, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    $id_emp = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_emp;
}

//Tabela GESEMP insert - revisado em 22/03/2023 08:35
function insertGESEMP_NOVA_GRUPO(
    $nome,
    $nomefantasia,
    $cnpj,
    $email,
    $contato,
    $telefone,
    $resp_financeiro,
    $email_financeiro,
    $endereco,
    $bairro,
    $numero,
    $complemento,
    $id_mun,
    $cep,
    $imagem,
    $layout,
    $layout_ponto,
    $id_per_imp,
    $id_per_ace,
    $layout_irrf,
    $valges,
    $id_usa_rh,
    $id_usa_ouv,
    $id_emp_grupo,
    $descricao_layout,
    $tipo_h,
    $tipo_p,
    $tipo_i,
    $id_mas,
    $datatu_mas,
    $quant_colab,
    $analise,
    $limite_paginas,
    $id_emp_i,
    $id_emp_p,
    $id_emp_h,
    $tipo,
    $situac
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEMP" (nome, nomefantasia, cnpj, email, contato, telefone, resp_financeiro, email_financeiro, endereco, bairro, numero, complemento, id_mun, cep,
        imagem, layout, layout_ponto, id_per_imp, id_per_ace, layout_irrf, valges, id_usa_rh, id_usa_ouv, id_emp_grupo, descricao_layout, tipo_h, tipo_p, tipo_i,
        id_mas, datatu_mas, quant_colab, analise, limite_paginas, id_emp_i, id_emp_p, id_emp_h, tipo, situac)
        VALUES (:nome, :nomefantasia, :cnpj, :email, :contato, :telefone, :resp_financeiro, :email_financeiro, :endereco, :bairro, :numero, :complemento, :id_mun, :cep,
                :imagem, :layout, :layout_ponto, :id_per_imp, :id_per_ace, :layout_irrf, :valges, :id_usa_rh, :id_usa_ouv, :id_emp_grupo, :descricao_layout, :tipo_h, :tipo_p, :tipo_i,
                :id_mas, :datatu_mas, :quant_colab, :analise, :limite_paginas, :id_emp_i, :id_emp_p, :id_emp_h, :tipo, :situac)
        RETURNING id_emp as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':layout', $layout, PDO::PARAM_STR);
    $statement->bindParam(':layout_ponto', $layout_ponto, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':layout_irrf', $layout_irrf, PDO::PARAM_STR);
    $statement->bindParam(':valges', $valges, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_rh', $id_usa_rh, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_ouv', $id_usa_ouv, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_grupo', $id_emp_grupo, PDO::PARAM_INT);
    $statement->bindParam(':descricao_layout', $descricao_layout, PDO::PARAM_STR);
    $statement->bindParam(':tipo_h', $tipo_h, PDO::PARAM_STR);
    $statement->bindParam(':tipo_p', $tipo_p, PDO::PARAM_STR);
    $statement->bindParam(':tipo_i', $tipo_i, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':quant_colab', $quant_colab, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':limite_paginas', $limite_paginas, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_i', $id_emp_i, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_p', $id_emp_p, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_h', $id_emp_h, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
    $id_emp = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_emp;
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


//Tabela GESEMP update - revisado em 23/03/2023 08:37
function updateGESEMP_CAMPOS(
    $nome,
    $nomefantasia,
    $email,
    $contato,
    $telefone_update,
    $resp_financeiro,
    $email_financeiro,
    $endereco,
    $bairro,
    $numero,
    $complemento,
    $id_mun,
    $cep_update,
    $id_emp_h,
    $id_emp_p,
    $id_emp_i,
    $layout_folha,
    $layout_ponto,
    $layout_irrf,
    $descricao_layout,
    $id_per_imp,
    $id_per_ace,
    $id_usa_rh,
    $id_usa_ouv,
    $id_emp_grupo,
    $tipo_h,
    $tipo_p,
    $tipo_i,
    $validacao_gestor,
    $datatu,
    $id_emp,
    $id_usa
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP"
            SET nome = :nome, endereco = :endereco, numero = :numero, bairro = :bairro, cep = :cep_update, complemento = :complemento, layout = :layout_folha, id_mun = :id_mun, telefone = :telefone_update, datatu = :datatu, id_usa_atu = :id_usa, email = :email, layout_ponto = :layout_ponto, id_per_imp = :id_per_imp, id_per_ace = :id_per_ace, layout_irrf = :layout_irrf, contato = :contato, valges = :validacao_gestor, id_emp_h = :id_emp_h, id_emp_p = :id_emp_p, id_emp_i = :id_emp_i, nomefantasia = :nomefantasia, resp_financeiro = :resp_financeiro, email_financeiro = :email_financeiro, id_usa_rh = :id_usa_rh, id_usa_ouv = :id_usa_ouv, id_emp_grupo = :id_emp_grupo, descricao_layout = :descricao_layout, tipo_h = :tipo_h, tipo_p = :tipo_p, tipo_i = :tipo_i
            WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':telefone_update', $telefone_update, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cep_update', $cep_update, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_h', $id_emp_h, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_p', $id_emp_p, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_i', $id_emp_i, PDO::PARAM_INT);
    $statement->bindParam(':layout_folha', $layout_folha, PDO::PARAM_STR);
    $statement->bindParam(':layout_ponto', $layout_ponto, PDO::PARAM_STR);
    $statement->bindParam(':layout_irrf', $layout_irrf, PDO::PARAM_STR);
    $statement->bindParam(':descricao_layout', $descricao_layout, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_rh', $id_usa_rh, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_ouv', $id_usa_ouv, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_grupo', $id_emp_grupo, PDO::PARAM_INT);
    $statement->bindParam(':tipo_h', $tipo_h, PDO::PARAM_STR);
    $statement->bindParam(':tipo_p', $tipo_p, PDO::PARAM_STR);
    $statement->bindParam(':tipo_i', $tipo_i, PDO::PARAM_STR);
    $statement->bindParam(':validacao_gestor', $validacao_gestor, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 24/03/2022 13:10
function updateGESEMP_CAMPOSMASTER($nome, $endereco, $email, $numero, $bairro, $cep, $complemento, $id_mun, $telefone, $valges, $nomefantasia, $tipo, $id_emp_h, $id_emp_p, $id_emp_i, $datatu, $id_usa_atu, $layout, $layout_ponto, $layout_irrf, $id_per_imp, $id_per_ace, $resp_financeiro, $email_financeiro, $id_emp)
{
    global $pdo;
    $query = 'UPDATE public."GESEMP" SET nome =:nome, endereco =:endereco, email =:email, numero =:numero, bairro =:bairro, cep =:cep, complemento =:complemento, id_mun =:id_mun, telefone =:telefone, valges =:valges, nomefantasia =:nomefantasia, tipo =:tipo, id_emp_h =:id_emp_h, id_emp_p =:id_emp_p, id_emp_i =:id_emp_i, datatu =:datatu, id_usa_atu =:id_usa_atu, layout =:layout , layout_ponto =:layout_ponto , layout_irrf =:layout_irrf, id_per_imp =:id_per_imp, id_per_ace =:id_per_ace, resp_financeiro =:resp_financeiro, email_financeiro =:email_financeiro  WHERE id_emp =:id_emp';
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
    $statement->bindParam(':valges', $valges, PDO::PARAM_INT);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_h', $id_emp_h, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_p', $id_emp_p, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_i', $id_emp_i, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':layout', $layout, PDO::PARAM_STR);
    $statement->bindParam(':layout_ponto', $layout_ponto, PDO::PARAM_STR);
    $statement->bindParam(':layout_irrf', $layout_irrf, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 14/12/2021 09:12
function updateGESEMP_LOGO($imagem, $datatu, $id_usa_atu, $id_emp)
{
    global $pdo;
    $query = 'UPDATE public."GESEMP" SET imagem =:imagem, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP situac update - revisado em 28/03/2022 09:12
function updateGESEMP_SITUAC($situac, $datatu, $id_usa_atu, $id_emp)
{
    global $pdo;
    $query = 'UPDATE public."GESEMP" SET situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_emp =:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
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

//Tabela GESUSU delete - revisado 16/12/2021 08:41
function deleteGESEMP_in(array $id_emp)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_emp), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESEMP" WHERE id_emp IN(' . $inQuery . ')');
    foreach ($id_emp as $k => $id) {
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

//Tabela GESEMP select - revisado em 06/12/2021 16:26
function selectGESEMP($id_emp)
{
    global $pdo;
    $query = 'SELECT id_emp, nome, cnpj, endereco, numero, bairro, cep, situac, complemento, imagem, layout, id_mun, telefone, datinc, datatu, id_usa_atu, contato, email, layout_ponto, layout_irrf FROM public."GESEMP" WHERE id_emp =:id_emp';
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

//Tabela GESEMP select - revisado em 29/03/2023 08:02
function selectGESEMP_ALL()
{
    global $pdo;
    $query =
        'SELECT id_emp, nome,  cnpj, endereco, numero, bairro, cep, situac, complemento, imagem, layout, id_mun, telefone, nomefantasia, datinc, datatu, id_usa_atu, contato FROM public."GESEMP" order by id_emp';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESEMP select - revisado em 29/03/2023 08:02
function selectGESEMP_TIPO($id_emp)
{
    global $pdo;
    $query =
        'SELECT tipo FROM public."GESEMP" WHERE id_emp=:id_emp';
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

//Tabela GESEMP select - revisado em 17/03/2023 13:54
function selectVWEMPRESA_tipo_beneficio($id_emp)
{
    global $pdo;
    $query =
        'SELECT 1 AS RANK ,ID_EMP,CONCAT(CNPJ,\' - \',NOMEFANTASIA) AS NOMEFANTASIA FROM public."VW_EMPRESA" WHERE ID_EMP =:id_emp
        UNION
SELECT 2 AS RANK ,ID_EMP,CONCAT(CNPJ,\' - \',NOMEFANTASIA) AS NOMEFANTASIA FROM public."VW_EMPRESA" WHERE ID_EMP <>:id_emp AND  RAIZ_CNPJ IN (SELECT	REPLACE(SUBSTRING(CNPJ,0,11),\'.\',\'\') FROM public."VW_EMPRESA" WHERE ID_EMP =:id_emp)
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

//Tabela GESDEP insert - revisado em 07/12/2021 08:33
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
        'INSERT INTO public."GESDEP"(id_emp, nome, situac, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:id_emp, :nome, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
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

//Tabela GESDEP update - revisado em 07/12/2021 08:33
function updateGESDEP_nome(
    $id_emp,
    $nome,
    $datatu,
    $id_usa_atu,
    $id_dep
) {
    global $pdo;
    $query =
        'UPDATE public."GESDEP" SET id_emp =:id_emp, nome =:nome, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESDEP update - revisado em 07/12/2021 08:33
function updateGESDEP_situac(
    $id_emp,
    $situac,
    $datatu,
    $id_usa_atu,
    $id_dep
) {
    global $pdo;
    $query =
        'UPDATE public."GESDEP" SET id_emp =:id_emp, situac =:situac, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_dep =:id_dep';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
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
        'SELECT id_dep, nome FROM public."GESDEP" WHERE situac=1 AND id_emp = :id_emp';
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
        'SELECT a.id_dep as id,a.id_dep as id_dep,b.nome as departamento FROM public."GESUSU" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usu =:id_usu
        union
        SELECT null as id,c.id_dep as id_dep, c.nome as departamento FROM public."GESDEP" as c WHERE c.situac=1 AND c.id_emp =:id_emp and c.id_dep not in (SELECT coalesce(a.id_dep, 0) FROM public."GESUSU" as a left outer join public."GESDEP" as b on a.id_dep=b.id_dep WHERE a.id_usu =:id_usu)';
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

//Tabela GESDOC insert - revisado em 07/12/2021 08:41
function insertGESDOC($titulo, $conteudo, $publicado, $grupo, $pai)
{
    global $pdo;
    $query = 'INSERT INTO public."GESDOC"(titulo, conteudo, publicado, grupo, pai, datinc, datatu) VALUES (:titulo, :conteudo, :publicado, :grupo, :pai, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) RETURNING id_doc as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
    $statement->bindParam(':publicado', $publicado, PDO::PARAM_INT);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->execute();
    $id_doc = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_doc;
}

//Tabela GESDOC update - revisado em 07/12/2021 08:41
function updateGESDOC($titulo, $conteudo, $publicado, $grupo, $pai, $id_doc)
{
    global $pdo;
    $query =
        'UPDATE public."GESDOC" SET titulo =:titulo, conteudo =:conteudo, publicado =:publicado, grupo =:grupo, pai =:pai, datatu = (CURRENT_TIMESTAMP) WHERE id_doc =:id_doc';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $statement->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
    $statement->bindParam(':publicado', $publicado, PDO::PARAM_INT);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
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
        'SELECT id_doc, titulo, conteudo, case when publicado = 1 then \'Sim\' else \'Não\' end publicado, grupo, pai, to_char(datinc, \'DD/MM/YYYY\')datinc, to_char(datatu, \'DD/MM/YYYY HH24:MI:SS\')datatu FROM public."GESDOC" ORDER BY grupo';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESDOC delete_in
function deleteGESDOC_in(array $id_doc)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_doc), '?'));
    echo $inQuery;
    $statement = $pdo->prepare('DELETE FROM public."GESDOC" WHERE id_doc IN(' . $inQuery . ')');
    foreach ($id_doc as $k => $id) {
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

//Tabela GESDOC select - revisado em 07/12/2021 08:41
function selectGESDOCid_doc($id_doc)
{
    global $pdo;
    $query =
        'SELECT id_doc, titulo, conteudo, publicado, grupo, pai, to_char(datinc, \'DD/MM/YYYY\')datinc, to_char(datatu, \'DD/MM/YYYY HH24:MI:SS\')datatu FROM public."GESDOC" WHERE id_doc =:id_doc';
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

//Tabela selectGESEST_default select
function selectGESEST_default()
{
    global $pdo;
    $query =
        'SELECT id_est, sigla, nome FROM public."GESEST"';
    $statement = $pdo->prepare($query);
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
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESEVE"(codevento, nome, id_emp, tipo, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:codevento, :nome, :id_emp, :tipo, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':codevento', $codevento, PDO::PARAM_STR);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
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

//Tabela GESUSU update - revisado em 08/12/2021 08:51
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

//Tabela GESEVE delete
function deleteGESEVE($id_eve)
{
    global $pdo;
    $query = 'DELETE FROM public."GESEVE" WHERE id_eve =:id_eve';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_eve', $id_eve, PDO::PARAM_INT);
    $statement->execute();
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

//Tabela GESORG update - revisado em 07/12/2021 16:47
function updateGESORG(
    $descricao,
    $pai,
    $id_emp,
    $nivel,
    $datinc,
    $datatu,
    $id_usa_inc,
    $id_usa_atu,
    $id_org
) {
    global $pdo;
    $query =
        'UPDATE public."GESORG" SET descricao =:descricao, pai =:pai, id_emp =:id_emp, nivel =:nivel, datinc =:datinc, datatu =:datatu, id_usa_inc =:id_usa_inc, id_usa_atu =:id_usa_atu WHERE id_org=:id_org';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $statement->bindParam(':pai', $pai, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
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
        'SELECT id_per, nome, situac FROM public."GESPER" WHERE id_per =:id_per AND situac = 1';
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

//Tabela GESPER select
function selectGESPER_ALL()
{
    global $pdo;
    $query =
        'SELECT id_per, nome, situac FROM public."GESPER" order by id_per ';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESPER select
function selectGESPER_NOT($id_per)
{
    global $pdo;
    $query =
        'SELECT id_per, nome, situac FROM public."GESPER" WHERE id_per <> :id_per AND situac = 1 order by id_per ';
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
        'INSERT INTO public."GESPOL"(id_emp, nome, anexo, situac, datinc, datatu, id_usa_inc, id_usa_atu) VALUES (:id_emp, :nome, :anexo, :situac, :datinc, :datatu, :id_usa_inc, :id_usa_atu)';
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

//Tabela GESUSA insert
function insertGESUSA_FILIAL($nome, $cpf, $senha, $datinc, $id_emp_acess, $email, $situac, $id_tus, $id_per, $id_mun, $cep, $telefone, $endereco, $bairro, $complemento, $numero, $id_mas, $datatu_mas)
{
    global $pdo;
    $query = 'INSERT INTO public."GESUSA"(nome, cpf, senha, datinc, id_emp_acess, email, situac, id_tus, id_per, id_mun, cep, telefone, endereco, bairro, complemento, numero, id_mas, datatu_mas)
    VALUES (:nome, :cpf, :senha, :datinc, :id_emp_acess, :email, :situac, :id_tus, :id_per, :id_mun, :cep, :telefone, :endereco, :bairro, :complemento, :numero, :id_mas, :datatu_mas)
    RETURNING id_usa as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->execute();
    $id_usa = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usa;
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
    $datatu,
    $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESUSU"(nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_dep, sexo, escolaridade, cep, id_emp, id_emp_ant, datatu, id_usa_inc, id_usa_atu) VALUES (:nome, :cpf, :senha, :datinc, :situac, :rg, :celular, :email, :telefone, :id_mun, :dataadmissao, :datanascimento, :ctps, :pis, :cbo, :datarescisao, :funcao, :dataopcao, :tpsalario, :endereco, :complemento, :bairro, :dependentes, :salario, :numero, :id_dep, :sexo, :escolaridade, :cep, :id_emp, :id_emp_ant, :datatu, :id_usa_inc, :id_usa_atu)';
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
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_inc', $id_usa_inc, PDO::PARAM_INT);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU select Valida para update - revisado em 14/01/2022 08:45
function validaGESUSU_campos($id_usu)
{
    global $pdo;
    $query = 'SELECT CASE WHEN datanascimento IS NULL OR dataadmissao IS NULL OR endereco IS NULL OR BAIRRO IS NULL OR numero IS NULL OR tpsalario IS NULL OR SEXO IS NULL THEN FALSE ELSE TRUE END AS VALIDA FROM public."GESUSU" WHERE id_usu =:id_usu';
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
    $sexo,
    $escolaridade,
    $cep,
    $id_emp,
    // $id_emp_ant,
    $id_usu,
    $datatu,
    // $id_usa_inc,
    $id_usa_atu
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET nome =:nome, cpf =:cpf, rg =:rg, celular =:celular, email =:email, telefone =:telefone, id_mun =:id_mun, dataadmissao =:dataadmissao, datanascimento =:datanascimento, ctps =:ctps, pis =:pis, cbo =:cbo, datarescisao =:datarescisao, funcao =:funcao, tpsalario =:tpsalario, endereco =:endereco, complemento =:complemento, bairro =:bairro, dependentes =:dependentes, salario =:salario, numero =:numero, id_dep =:id_dep, sexo =:sexo, escolaridade =:escolaridade, cep =:cep, id_emp =:id_emp, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
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
    $statement->bindParam(':sexo', $sexo, PDO::PARAM_STR);
    $statement->bindParam(':escolaridade', $escolaridade, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
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
function updateGESUSU_SITUAC($situac, $id_emp, $id_usu, $datatu, $id_usa_atu)
{
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
        'SELECT id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_dep, sexo, escolaridade, cep, id_emp, id_emp_ant, datatu, id_usa_inc, id_usa_atu FROM public."GESUSU" WHERE id_usu =:id_usu';
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

//View VW_RECIBO_PAGAMENTO select - revisado em 21/12/2021 14:10
function selectRECIBO_PAGAMENTO_ENVIADO($raizCNPJ, $id_processamento)
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
    FROM public."GESIM1_' . $raizCNPJ . '" where id_processamento =:id_processamento and situac IN (0,1,2,3,4) GROUP BY id_usu, id_im1,
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
    $query = 'SELECT a.id_im1,replace(replace(replace(concat(a.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.codevento,
    a.nome,
    round(a.quantidade,2)AS quantidade,
    formatar_moeda(CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END) AS vencimentos,
    formatar_moeda(CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END) AS descontos,
    CASE WHEN b.tipo = \'V\' THEN a.valor ELSE 0 END AS vencimentos_val,
    CASE WHEN b.tipo = \'D\' THEN a.valor * \'-1\' ELSE 0 END AS descontos_val,
    a.id_im1,
    a.datinc 
    FROM public."GESIM2_' . $raizCNPJ . '" a 
    LEFT JOIN public."GESEVE" b ON a.id_eve = b.id_eve 
    LEFT JOIN public."GESIM1_' . $raizCNPJ . '" c ON a.id_im1 = c.id_im1
    where  a.id_im1 = \'' . $id . '\'
    ORDER BY a.id_im2';
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
    id_mun,null as telefone,"GESMUN".nome as cidade,"GESEST".nome as estado from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' )
    union
    SELECT id_emp,nome,cnpj,email,endereco, numero,bairro,cep,situac,complemento,imagem,id_mun, telefone, cidade, estado FROM public."VW_EMPRESA" where id_emp=' . $id_emp . ' order by  id_emp desc';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View VW_EMPRESA select - revisado em 22/03/2023 14:27
function select_VW_EMPRESAMASTER($id_emp)
{
    global $pdo;
    $query = 'SELECT null as id_emp,null as nome,null as cnpj,null as email,null as endereco,null as numero,null as bairro,cep,null as situac,null as complemento,null as imagem,  id_mun,null as telefone
    ,null as layout, null as layout_ponto, null as layout_irrf,null as valges,null as tipo,null as id_emp_h,null as id_emp_p,null as id_emp_i,null as nomefantasia
    ,"GESMUN".nome as cidade,"GESEST".nome as estado, null as contato, null as id_per_imp, null as id_per_ace, null as resp_financeiro, null as email_financeiro 
    ,null as id_usa_rh, null as id_usa_ouv, null as id_emp_grupo, null as descricao_layout, null as    tipo_h,null as tipo_p,null as tipo_i,null as quant_colab
    
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp =:id_emp ) 
            union
    SELECT id_emp,nome,cnpj,email,endereco, numero,bairro,cep,situac,complemento,imagem,id_mun, telefone
    , layout, layout_ponto, layout_irrf, valges,tipo,id_emp_h,id_emp_p,id_emp_i,nomefantasia, cidade, estado, contato, id_per_imp, id_per_ace, resp_financeiro, email_financeiro 
    ,id_usa_rh, id_usa_ouv, id_emp_grupo, descricao_layout,tipo_h,tipo_p,tipo_i,quant_colab
    FROM public."VW_EMPRESA" where id_emp =:id_emp order by  id_emp desc
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


//View VW_CIDADE select - revisado em 28/03/2022 14:29
function select_ESTADO_TODOS()
{
    global $pdo;
    $query = 'SELECT "GESEST".nome as estado from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est group by "GESEST".nome order by  estado';
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

//View VW_CIDADE select - revisado em 10/12/2021 14:31
function select_CIDADE_TODOS($estado)
{
    global $pdo;
    $query = 'SELECT id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome = \'' . $estado . '\'  order by  id_emp asc, cidade';
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

//NOVO

//Tabela GESDEP select - revisado em 17/12/2021 08:33
// function selectGESDEP_departamento($id_emp)
// {
//     global $pdo;
//     $query =
//         'SELECT id_dep, nome FROM public."GESDEP" WHERE situac=1 AND id_emp = :id_emp';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

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
function select_VW_USUARIOS($id_emp)
{
    global $pdo;
    $query = 'SELECT cidade, estado, departamento, cep, id_usu, nome, cpf, senha, datinc, situac, rg, celular, email, telefone, id_mun, dataadmissao, datanascimento, ctps, pis, cbo, datarescisao, funcao, dataopcao, tpsalario, endereco, complemento, bairro, dependentes, salario, numero, id_emp, id_emp_ant, datatu, id_usa_inc FROM public."VW_USUARIOS" where id_emp=:id_emp';
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

//Tabela GESIM1 selectPONTO_DADOS - revisado em 04/02/2022 08:30
function selectPONTO_DADOS($raizCNPJ, $id)
{
    global $pdo;
    $query = 'SELECT SUBSTRING(a.periodo,1,10)  periodo_inicio, SUBSTRING(a.periodo,16,20) periodo_final, a.pis, a.btotal,a.bsaldo, b.nome FROM public."GESPON1_' . $raizCNPJ . '" a left join "GESUSU" b on a.id_usu = b.id_usu where id_pon1 = \'' . $id . '\' LIMIT 1';
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
    $query = 'SELECT a.id_pon1,replace(replace(replace(concat(c.datinc,c.id_emp, c.id_usu),\'-\',\'\'),\':\',\'\'),\' \',\'\') AS id,
    a.ent1,
    a.sai1,
    a.ent2,
    a.sai2,
    a.ent3,
    a.sai3,
    a.btotal,
    a.bsaldo,
 
    a.id_pon2,
    to_char(a.data, \'DD/MM/YYYY\') AS data
    
    FROM public."GESPON2_' . $raizCNPJ . '" a 
    LEFT JOIN public."GESPON1_' . $raizCNPJ . '" c ON a.id_pon1 = c.id_pon1
    where  a.id_pon1 = \'' . $id . '\'
    ORDER BY a.id_pon2';
    $statement = $pdo->prepare($query);
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
        'SELECT * FROM public."GESCTO" WHERE id_emp =:id_emp';
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
    $query = 'SELECT b.id_tab1 as id_emp,a.* FROM public."GESUSA" as a  inner join  public."GESVIN" as b on a.id_usa=b.id_tab2 
    where  b.tabvin2=\'GESUSA\'
    and b.id_tab1= :id_emp';
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
    $query = 'SELECT  to_char(a.datinc, \'DD/MM/YYYY HH:MM:SS\') AS datinc ,a.datinc as data ,CONCAT(\'HOLERITE - \',a.competencia,\' - \',a.origem) AS tipo,a.origem ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
,(select CASE 
  WHEN z.situac =\'0\' THEN \'0\'
  WHEN z.situac =\'1\' THEN \'1\'
  WHEN z.situac =\'2\' THEN \'2\' 
  WHEN z.situac =\'3\' THEN \'2\'
  WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESIM1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
FROM public."GESIM1_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
where a.situac<>9 and id_emp =:id_emp
group by a.id_processamento,a.datinc,b.nome ,a.origem,a.competencia

UNION
SELECT to_char(a.datinc, \'DD/MM/YYYY HH:MM:SS\') AS datinc,a.datinc as data,CONCAT(\'PONTO  - \',a.periodo,\' - \',a.origem) AS tipo,a.origem  ,substring(b.nome,0,POSITION (\' \' IN b.nome)) as nome
,(select CASE 
WHEN z.situac =\'0\' THEN \'0\'
WHEN z.situac =\'1\' THEN \'1\'
WHEN z.situac =\'2\' THEN \'2\' 
WHEN z.situac =\'3\' THEN \'2\'
WHEN z.situac =\'4\' THEN \'2\' else \'2\' end FROM public."GESPON1_' . $raizCNPJ . '" as z where z.situac<>9 and z.id_processamento=a.id_processamento LIMIT 1 ) as status,a.id_processamento
FROM public."GESPON1_' . $raizCNPJ . '" as a
left outer join public."GESUSA" as b on a.id_usa_inc=b.id_usa
where a.situac<>9 and id_emp =:id_emp
group by a.id_processamento,a.datinc,b.nome ,a.origem,a.periodo
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

//Tabela GESDEP select - revisado em 13/03/2023 09:54
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

//Tabela GESUSA insert - revisado em 05/12/2023 07:24
function insertGESUSA_RETID(
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
    $id_dep,
    $datatu,
    $id_usa_atu,
    $id_tus,
    $endereco,
    $complemento,
    $bairro,
    $numero,
    $cep
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESUSA" (nome, cpf, senha, datinc, id_emp_acess, email, situac, id_per, id_mun, telefone, id_dep, datatu, id_usa_atu, id_tus, endereco, complemento, bairro, numero, cep, analise)
        VALUES (:nome, :cpf, :senha, :datinc, :id_emp_acess, :email, :situac, :id_per, :id_mun, :telefone, :id_dep, :datatu, :id_usa_atu, :id_tus, :endereco, :complemento, :bairro, :numero, :cep, 0)
        RETURNING id_usa as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_STR);
    $statement->bindParam(':id_per', $id_per, PDO::PARAM_INT);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_tus', $id_tus, PDO::PARAM_INT);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->execute();
    $id_usa = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_usa;
}

//Tabela GESVIN_usuario insert - revisado em 14/03/2023 13:51
function insertGESVIN_usuario($id_emp, $id_usa)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESVIN" (tabvin1,id_tab1,tabvin2,id_tab2) 
        VALUES (\'GESEMP\', :id_emp, \'GESUSA\', :id_usa)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
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

//Tabela GESDEP select - revisado em 17/12/2021 08:33
// function select_GESMUN_estado($id_mun)
// {
//     global $pdo;
//     $query =
//         'SELECT b.id_est,b.sigla,b.nome as estado
//         FROM public."GESMUN" as a inner join  public."GESEST" as b on a.id_est=b.id_est
//         where a.id_mun=:id_mun
//         ';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

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

//Tabela GESUSA select - revisado em 13/03/2023 14:02
function select_VW_ADMIN_GESUSA($id_usa)
{
    global $pdo;
    $query = 'SELECT * FROM public."VW_ADMIN_GESUSA" WHERE id_usa = :id_usa';
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

//Tabela GESTUS select - revisado em 13/03/2023 12:30
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
function updateGESUSA_usuario($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_tus, $id_mun, $id_usa, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSA" 
            SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, bairro = :bairro, complemento = :complemento, numero = :numero, cep = :cep, id_tus = :id_tus, id_mun = :id_mun, datatu = :datatu, id_usa_atu = :id_usa_atu 
            WHERE id_usa = :id_usa';
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
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA update
function updateGESUSA_usuario_sem_id_tus($nome, $cpf, $email, $telefone, $endereco, $bairro, $complemento, $numero, $cep, $id_mun, $id_usa, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSA" 
            SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, endereco = :endereco, bairro = :bairro, complemento = :complemento, numero = :numero, cep = :cep, id_mun = :id_mun, datatu = :datatu, id_usa_atu = :id_usa_atu 
            WHERE id_usa = :id_usa';
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
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

// Tabela GESUSA update - revisado em 06/04/2023 13:01
function troca_senha_GESUSA(
    $senha,
    $situac_senha,
    $datatu,
    $id_usa_atu,
    $id_usa
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA"
            SET senha = :senha, situac_senha = :situac_senha, datatu = :datatu, id_usa_atu = :id_usa_atu
            WHERE id_usa = :id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':situac_senha', $situac_senha, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTUS select - revisado em 17/12/2021 08:33
function selectVW_ADMIN_GACESSO_situac($id_mas)
{
    global $pdo;
    $query =
        'SELECT situac from public."GESMAS" where id_mas =:id_mas';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
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
    $query = 'SELECT COUNT(ID_IM1) 
    + (SELECT COUNT(ID_PON1) AS C2 FROM public."GESPON1_' . $raizCNPJ . '" WHERE SITUAC = 2 AND SITUAC_VISUALIZAR = 1 AND ID_PROCESSAMENTO =:id_processamento ) AS CONTAGEM
   FROM public."GESIM1_' . $raizCNPJ . '" WHERE SITUAC IN (3,4) AND ID_PROCESSAMENTO =:id_processamento
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

//Tabela GESPON1 / GESIM1 update - revisado em 22/02/2021 08:58
function update_lote(
    $tabela,
    $raizCNPJ,
    $situac,
    $id_processamento
) {
    global $pdo;
    $query =
        'UPDATE public."' . $tabela . '_' . $raizCNPJ . '" SET situac =:situac WHERE id_processamento =:id_processamento';
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

//Tabela GESTUS select - revisado em 17/12/2021 08:33
function selectVW_ANIVERSARIOS()
{
    global $pdo;
    $query =
        'SELECT RANK () OVER ( 
            ORDER BY PROX_ANIVERSARIO 
    ) rank,* FROM public."VW_ANIVERSARIOS" ORDER BY PROX_ANIVERSARIO ASC
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSU select - revisado em 18/04/2022 10:14
function select_ANIVERSARIOS_DETALHE_7DIAS()
{
    global $pdo;
    $query = 'SELECT a.id_usu,a.nome,b.nome as empresa, to_char(a.datanascimento, \'DD/MM/YYYY\')datanascimento, to_char(a.datatu_env_aniversario, \'DD/MM/YYYY\')datatu_env_aniversario FROM "GESUSU" a JOIN "GESEMP" b ON a.id_emp = b.id_emp  WHERE a.datatu_env_aniversario IS NOT NULL AND a.datatu_env_aniversario >= (CURRENT_DATE - 7) AND a.datatu_env_aniversario <= CURRENT_DATE; ';
    $statement = $pdo->prepare($query);
    //$statement->bindParam(':dias', $dias, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESUSU select - revisado em 18/04/2022 13:03
function select_ANIVERSARIOS_DETALHE_90DIAS()
{
    global $pdo;
    $query = 'SELECT a.id_usu,a.nome,b.nome as empresa, to_char(a.datanascimento, \'DD/MM/YYYY\')datanascimento, to_char(a.datatu_env_aniversario, \'DD/MM/YYYY\')datatu_env_aniversario FROM "GESUSU" a JOIN "GESEMP" b ON a.id_emp = b.id_emp  WHERE a.datatu_env_aniversario IS NOT NULL AND a.datatu_env_aniversario >= (CURRENT_DATE - 90) AND a.datatu_env_aniversario <= CURRENT_DATE; ';
    $statement = $pdo->prepare($query);
    //$statement->bindParam(':dias', $dias, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESUSU select - revisado em 18/04/2022 13:18
function select_ANIVERSARIOS_DETALHE_HOJE()
{
    global $pdo;
    $query = 'SELECT a.id_usu,a.nome,b.nome as empresa, to_char(a.datanascimento, \'DD/MM/YYYY\')datanascimento, to_char(a.datatu_env_aniversario, \'DD/MM/YYYY\')datatu_env_aniversario FROM "GESUSU" a JOIN "GESEMP" b ON a.id_emp = b.id_emp  WHERE a.datatu_env_aniversario IS NOT NULL AND a.datatu_env_aniversario = (CURRENT_DATE) ; ';
    $statement = $pdo->prepare($query);
    //$statement->bindParam(':dias', $dias, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESUSU select - revisado em 18/04/2022 13:44
function select_ANIVERSARIOS_DETALHE_PRO7()
{
    global $pdo;
    $query = 'SELECT id_usu,nome,empresa,to_char(to_date(datanascimento, \'YYYY/MM/DD\'),\'DD/MM/YYYY\')datanascimento,to_char(prox_aniversario,\'DD/MM/YYYY\') prox_aniversario FROM "VW_ANIVERSARIOS" WHERE "VW_ANIVERSARIOS".status = \'Não Enviado\'::text AND "VW_ANIVERSARIOS".prox_aniversario <= (CURRENT_DATE + 7); ';
    $statement = $pdo->prepare($query);
    //$statement->bindParam(':dias', $dias, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESUSU select - revisado em 18/04/2022 13:54
function select_ANIVERSARIOS_DETALHE_PRO90()
{
    global $pdo;
    $query = 'SELECT id_usu,nome,empresa,to_char(to_date(datanascimento, \'YYYY/MM/DD\'),\'DD/MM/YYYY\')datanascimento,to_char(prox_aniversario,\'DD/MM/YYYY\') prox_aniversario FROM "VW_ANIVERSARIOS" WHERE "VW_ANIVERSARIOS".status = \'Não Enviado\'::text AND "VW_ANIVERSARIOS".prox_aniversario <= (CURRENT_DATE + 90); ';
    $statement = $pdo->prepare($query);
    //$statement->bindParam(':dias', $dias, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}



//Tabela VW_ENVIAR_ANIVERSARIO select - revisado em 17/12/2021 08:33
function VW_ANIVERSARIOS_ENVIAR_PROX_7_DIAS()
{
    global $pdo;
    $query =
        'SELECT TOTAL FROM public."VW_ANIVERSARIOS_ENVIAR_PROX_7_DIAS"
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela selectTOTAL_ENVIADOS_ULTIMOS_90_DIAS - revisado em 17/12/2021 08:33
function selectTOTAL_ENVIADOS_ULTIMOS_90_DIAS()
{
    global $pdo;
    $query =
        '
        SELECT count(id_usu) as total
        
        from public."GESUSU"
        
        WHERE datatu_env_aniversario is not null and datatu_env_aniversario >= CURRENT_DATE-90 and datatu_env_aniversario <= CURRENT_DATE
        
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela selectTOTAL_ENVIADOS_ULTIMOS_90_DIAS - revisado em 17/12/2021 08:33
function TOTAL_ENVIADOS_ULTIMOS_7_DIAS()
{
    global $pdo;
    $query =
        '
        select count(id_usu) as total

    from public."GESUSU"

    WHERE datatu_env_aniversario is not null and datatu_env_aniversario >= CURRENT_DATE-7 and datatu_env_aniversario <= CURRENT_DATE
        
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_ANIVERSARIOS_ENVIADO_HOJE select - revisado em 17/12/2021 08:33
function VW_ANIVERSARIOS_ENVIADO_HOJE()
{
    global $pdo;
    $query =
        'SELECT TOTAL FROM public."VW_ANIVERSARIOS_ENVIADO_HOJE"
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela VW_ANIVERSARIOS_PROX_90_DIAS select - revisado em 17/12/2021 08:33
function VW_ANIVERSARIOS_ENVIAR_PROX_90_DIAS()
{
    global $pdo;
    $query =
        'SELECT TOTAL FROM public."VW_ANIVERSARIOS_ENVIAR_PROX_90_DIAS"
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela selectGESSER - revisado em 17/12/2021 08:33
function selectGESSER_aniversario()
{
    global $pdo;
    $query =
        'SELECT id_ser, situac, datatu FROM public."GESSER" WHERE id_ser = 1
    ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela updateGESSER - revisado em 17/12/2021 08:33
function updateGESSER_aniversario($situac, $datatu)
{
    global $pdo;
    $query =
        'UPDATE public."GESSER" SET situac =:situac, datatu =:datatu WHERE id_ser = 1
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela selectGESSER - revisado em 17/12/2021 08:33
function selectCOUNT_VW_ANIVERSARIOS()
{
    global $pdo;
    $query =
        'SELECT count(id_usu) as contagem FROM "VW_ANIVERSARIOS" 
        WHERE "VW_ANIVERSARIOS".status = \'Não Enviado\' AND "VW_ANIVERSARIOS".prox_aniversario <= (CURRENT_DATE );
        ';

    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela selectGESSER - revisado em 17/12/2021 08:33
function select_VW_ANIVERSARIOS()
{
    global $pdo;
    $query =
        'SELECT * FROM "VW_ANIVERSARIOS" 
        WHERE "VW_ANIVERSARIOS".status = \'Não Enviado\' AND "VW_ANIVERSARIOS".prox_aniversario <= (CURRENT_DATE);      
        ';

    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela updateGESSER - revisado em 17/12/2021 08:33
function updateDATA_ENVIO_ANIVERSARIO($id_usu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSU" set datatu_env_aniversario = (CURRENT_DATE) where id_usu=:id_usu
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


//Tabela selectGESMNU - revisado em 14/04/2022 16:02
function select_GESMNU_ALL()
{
    global $pdo;
    $query = 'SELECT id_mnu, descri, icone, link, target , nivel, ordem, estagio, caminho FROM public."GESMNU" order by ordem';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela selectGESMNU - revisado em 14/04/2022 16:28
function select_GESMNU($id_mnu)
{
    global $pdo;
    $query = 'SELECT id_mnu, descri, icone, link, target , nivel, ordem, estagio, caminho FROM public."GESMNU" where id_mnu=:id_mnu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mnu', $id_mnu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela selectGESMNU - revisado em 13/04/2022 16:28
function update_GESMNU($descri, $icone, $link, $target, $nivel, $ordem, $estagio, $caminho, $id_mnu)
{
    global $pdo;
    $query = 'UPDATE public."GESMNU" SET descri =:descri, icone =:icone, link =:link, target =:target , nivel =:nivel, ordem =:ordem, estagio =:estagio, caminho =:caminho where id_mnu=:id_mnu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descri', $descri, PDO::PARAM_STR);
    $statement->bindParam(':icone', $icone, PDO::PARAM_STR);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':target', $target, PDO::PARAM_STR);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->bindParam(':ordem', $ordem, PDO::PARAM_INT);
    $statement->bindParam(':estagio', $estagio, PDO::PARAM_INT);
    $statement->bindParam(':caminho', $caminho, PDO::PARAM_STR);
    $statement->bindParam(':id_mnu', $id_mnu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela deleteGESMNU - revisado em 13/04/2022 16:28
function deleteGESMNU_in(array $id_mnu)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_mnu), '?'));
    $statement = $pdo->prepare('DELETE FROM public."GESMNU" WHERE id_mnu IN(' . $inQuery . ')');
    foreach ($id_mnu as $k => $id) {
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

//Tabela GESMNU insert - revisado em 30/03/2022 13:19
function insertGESMNU($descri, $icone, $link, $target, $nivel, $ordem, $estagio, $caminho)
{
    global $pdo;
    $query = 'INSERT INTO public."GESMNU"(descri, icone, link, target, nivel, ordem, estagio, caminho) VALUES (:descri, :icone, :link, :target, :nivel, :ordem, :estagio, :caminho)  RETURNING id_mnu as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':descri', $descri, PDO::PARAM_STR);
    $statement->bindParam(':icone', $icone, PDO::PARAM_STR);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':target', $target, PDO::PARAM_STR);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_INT);
    $statement->bindParam(':ordem', $ordem, PDO::PARAM_INT);
    $statement->bindParam(':estagio', $estagio, PDO::PARAM_STR);
    $statement->bindParam(':caminho', $caminho, PDO::PARAM_STR);
    $statement->execute();
    $id_mnu = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_mnu;
}

//Tabela GESTRE insert
function insertGESMNU_add($id_usa, $id_emp, $contagem, $datatu)
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

//View VW_RECIBO_PAGAMENTO_ITENS select - revisado em 27/12/2021 16:02
function selectTELAS_USUARIO($id_usa, $id_emp)
{
    global $pdo;
    $query = 'SELECT a.*,coalesce((select b.situac from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as situac,
    coalesce((select b.id_mpr from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_mpr,
    coalesce((select b.id_usa from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_usa,
    coalesce((select b.id_emp from public."GESMPR" as b where b.id_mnu=a.id_mnu and b.id_usa=:id_usa and b.id_emp=:id_emp) ,0)as id_emp
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

//Tabela GESUSU update
function updateGESMPR($situac, $id_mpr)
{
    global $pdo;
    $query =
        'UPDATE public."GESMPR" SET situac=:situac WHERE id_mpr=:id_mpr;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mpr', $id_mpr, PDO::PARAM_INT);
    $statement->execute();
}


//Tabela selectGESJOB - revisado em 14/04/2022 10:08
function select_GESJOB($id_job)
{
    global $pdo;
    $query = 'SELECT id_job, descri, situac, datstrt, datstop FROM public."GESJOB" where id_job=:id_job';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_job', $id_job, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela updateGESJOB - revisado em 14/04/2022 13:14
function updateGESJOB($situac, $id_job)
{
    global $pdo;
    if ($situac == 1) {
        $query = 'UPDATE public."GESJOB" set datstrt = (CURRENT_TIMESTAMP), datstop = null, situac =:situac where id_job=:id_job';
    } else {
        $query = 'UPDATE public."GESJOB" set datstrt = null , datstop = (CURRENT_TIMESTAMP), situac =:situac where id_job=:id_job';
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_job', $id_job, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }
    return $resultset;
}

//Tabela GESUSA select - revisado em 29/03/2023 07:58
function select_GESUSA_usuarios_adm($case)
{
    global $pdo;
    switch ($case) {

        case 1:
            $query = 'SELECT * FROM public."GESUSA"';
            break;

        case 2:
            $query = 'SELECT * FROM public."GESUSA" WHERE situac = 1';
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
function select_ESTADO_usuario_adm()
{
    global $pdo;
    $query = 'SELECT id_emp, estado FROM public."VW_EMPRESA" group by id_emp,id_mun, estado
    union
    SELECT null as id_emp,"GESEST".nome as estado 
    from public."GESMUN" left outer join "GESEST" on "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" ) group by    "GESEST".nome
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
function select_CIDADE_usuario_adm()
{
    global $pdo;
    $query = 'SELECT  id_emp,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_EMPRESA"
    union
    SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA")
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

// Tabela VW_CHAMADOS select - revisado em 08/11/2022 08:28
function select_VW_CHAMADOS()
{
    global $pdo;
    $query =
        'SELECT * FROM public."VW_CHAMADOS" ORDER BY id_cha DESC';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

// Tabela GESCHI select - revisado em 08/11/2022 15:13
function select_VW_CHAMADOS_ITEM($id_cha)
{
    global $pdo;
    $query =
        'SELECT * FROM public."VW_CHAMADOS_ITEM" WHERE id_cha = :id_cha ORDER BY id_chi DESC';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_cha', $id_cha, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESUSA_chamado select - revisado em 09/11/2022 09:04
function selectGESUSA_chamado($id_usa)
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

// Tabela GESCHI insert - revisado em 09/11/2022 09:06
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

//Tabela GESCHA delete_in
function deleteGESCHA_in(array $id_cha)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_cha), '?'));
    echo $inQuery;
    $statement = $pdo->prepare('DELETE FROM public."GESCHA" WHERE id_cha IN(' . $inQuery . ')');
    foreach ($id_cha as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }
    $resultado = $statement->execute();

    return $resultado;
}

//Tabela GESCHA update_in
function updateGESCHA_in(array $id_cha, $tipo)
{
    global $pdo;
    $inQuery = implode(',', array_fill(0, count($id_cha), '?'));
    echo $inQuery;
    $statement = $pdo->prepare('UPDATE public."GESCHA" SET status = ' . $tipo . '  WHERE id_cha IN(' . $inQuery . ')');

    foreach ($id_cha as $k => $id) {
        $statement->bindValue(($k + 1), $id);
    }
    $resultado = $statement->execute();

    return $resultado;
}

// tabela GESEMP_emp_selecionadas select - revisado em 13/03/2023 12:18
function selectGESEMP_emp_selecionadas($id_usa)
{
    global $pdo;
    $query =
        'SELECT a.id_emp,a.NOMEFANTASIA,a.CNPJ,replace(coalesce(b.nomefantasia,\'-\'),\'- MATRIZ\',\'\') as grupo 
        FROM public."VW_MASTER_EMPACESS"  as a
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

// tabela GESEMP_emp_disponiveis select - revisado em 23/03/2023 13:03
function selectGESEMP_emp_disponiveis($id_usa)
{
    global $pdo;
    $query =
        'SELECT a.id_emp,a.NOMEFANTASIA,a.CNPJ,replace(coalesce(b.nomefantasia,\'-\'),\'- MATRIZ\',\'\') as grupo 
        FROM  public."GESEMP" as a 
                               left outer join public."GESEMP" as b on a.id_emp_grupo=b.id_emp
                               WHERE a.id_emp NOT IN 
        (SELECT a.id_emp
        FROM public."VW_MASTER_EMPACESS"  as a
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

//Tabela GESVIN delete - revisado em 14/03/2023 13:53
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

// tabela GESGES_selecionados select - revisado em 17/03/2023 15:47
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

// tabela GESGES_disponiveis select - revisado em 17/03/2023 15:47
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

// tabela GESGES_inclusao select - revisado em 17/03/2023 15:47
function selectGESGES_inclusao($id_emp)
{
    global $pdo;
    $query =
        'SELECT b.id_usa,b.nome,b.cpf FROM public."GESVIN" AS a 
        LEFT OUTER JOIN public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND b.id_tus IN (2,3) AND b.id_usa <> 39 AND a.id_tab1 = :id_emp 
        UNION
        SELECT b.id_usa,b.nome,b.cpf FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        WHERE b.situac = 1 AND b.id_tus IN (2,3) AND b.id_usa <> 39 AND a.id_tab1 = :id_emp AND b.id_usa NOT IN 
        (SELECT b.id_usa FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND a.id_tab1 = :id_emp 
        UNION
        SELECT b.id_usa FROM public."GESVIN" AS a 
        LEFT OUTER JOIN  public."GESUSA" AS b ON a.id_tab2 = b.id_usa
        INNER JOIN public."GESGES" c ON b.id_usa = c.id_usa AND a.id_tab1 = c.id_emp  
        WHERE b.situac = 1 AND a.id_tab1 = :id_emp)
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

// tabela GESGES select - revisado em 17/03/2023 15:54
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

//Tabela GESGES insert - revisado em 29/03/2023 14:09
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

//Tabela GESGES update - revisado em 21/03/2023 14:09
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

//Tabela GESLAY insert - revisado em 22/03/2023 08:04
function insertGESLAY($id_emp, $lay_h, $lay_p, $lay_i)
{
    global $pdo;
    $query = 'INSERT INTO public."GESLAY" (id_emp, lay_h, lay_p, lay_i) VALUES (:id_emp, :lay_h, :lay_p, :lay_i)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':lay_h', $lay_h, PDO::PARAM_STR);
    $statement->bindParam(':lay_p', $lay_p, PDO::PARAM_STR);
    $statement->bindParam(':lay_i', $lay_i, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESLAY select - revisado em 22/03/2023 13:49
function selectGESLAY($id_emp)
{
    global $pdo;
    $query = 'SELECT lay_h, lay_p, lay_i FROM public. "GESLAY" WHERE id_emp = :id_emp';
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

//Tabela GESEMP select - revisado em 22/03/2023 14:52
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

//Tabela GESEMP select - revisado em 22/03/2023 14:52
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

//Tabela GESLAY update - revisado em 23/03/2023 08:52
function updateGESLAY($id_emp, $lay_h, $lay_p, $lay_i)
{
    global $pdo;
    $query =
        'UPDATE public."GESLAY" 
            SET lay_h = :lay_h, lay_p = :lay_p, lay_i = :lay_i
            WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':lay_h', $lay_h, PDO::PARAM_STR);
    $statement->bindParam(':lay_p', $lay_p, PDO::PARAM_STR);
    $statement->bindParam(':lay_i', $lay_i, PDO::PARAM_STR);
    $statement->execute();
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
            $query = 'SELECT a.id_emp_acess as id_emp,c.nome as estado,c.nome as estado_atual
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
        case 'id_cad':
            $query = 'SELECT  id_emp, estado, estado as estado_atual FROM public."VW_EMPRESA" where id_emp=1 
                union
                SELECT null as id_emp,"GESEST".nome as estado ,COALESCE((SELECT  estado FROM public."VW_EMPRESA" where id_emp=1),\'ACRE\') as estado_atual
                from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est
                where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" where id_emp=1 )
                group by    "GESEST".nome
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

            $query = 'SELECT a.id_emp_acess as id_emp,a.id_mun,b.nome as cidade,c.nome as estado ,concat(substring(a.cep,1,5),\'-\',substring(a.cep,6,3)) as  cep
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

//Tabela GESUSA_id_emp_acess update - revisado em 06/04/2023 13:56
function updateGESUSA_id_emp_acess($id_usa, $id_emp)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSA" 
            SET id_emp_acess = :id_emp
            WHERE id_usa = :id_usa';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP select - revisado em 29/03/2023 08:02
function selectGESEMP_ANALISIS($analise)
{
    global $pdo;

    switch ($analise) {
        case 1:

            $query =
                'SELECT
        RANK() OVER (ORDER BY a.datinc DESC) AS rank,
        b.id_usa,b.token as token_usa,a.*
                FROM public."GESEMP" as a
                left outer join public."GESUSA" as b on a.id_emp=b.id_emp_acess
                where a.analise IN (1) order by a.datinc desc';

            break;

        case 2:

            $query =
                'SELECT
            RANK() OVER (ORDER BY a.datinc DESC) AS rank,
            b.id_usa,b.token as token_usa,a.*
                    FROM public."GESEMP" as a
                    left outer join public."GESUSA" as b on a.id_emp=b.id_emp_acess
                    where a.analise IN (2) order by a.datinc desc';

            break;

        case 3:

            $query =
                'SELECT
                RANK() OVER (ORDER BY a.datinc DESC) AS rank,
                b.id_usa,b.token as token_usa,a.*
                        FROM public."GESEMP" as a
                        left outer join public."GESUSA" as b on a.id_emp=b.id_emp_acess
                        where a.analise IN (3) order by a.datinc desc';

            break;

        case 4:

            $query =
                'SELECT
                    RANK() OVER (ORDER BY a.datinc DESC) AS rank,
                    b.id_usa,b.token as token_usa,a.*
                            FROM public."GESEMP" as a
                            left outer join public."GESUSA" as b on a.id_emp=b.id_emp_acess
                            where a.analise IN (4) order by a.datinc desc';

            break;

        default:

            $query =
                'SELECT
                        RANK() OVER (ORDER BY a.datinc DESC) AS rank,
                        b.id_usa,b.token as token_usa,a.*
                                FROM public."GESEMP" as a
                                left outer join public."GESUSA" as b on a.id_emp=b.id_emp_acess
                                where a.analise IN (1, 2, 3, 4) order by a.datinc desc';

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
function select_ESTADO_APROVACAO()
{
    global $pdo;
    $query = 'SELECT id_emp, estado FROM public."VW_EMPRESA" where id_emp=\'1\' group by id_emp,id_mun, estado
    union
    SELECT null as id_emp,"GESEST".nome as estado
    from public."GESMUN" left outer join "GESEST" on "GESEST".id_est="GESMUN".id_est
	where "GESEST".nome not in ( SELECT estado FROM public."VW_EMPRESA" where id_emp=\'1\' )
	group by "GESEST".nome
    order by id_emp asc, estado';
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
function select_CIDADE_APROVACAO()
{
    global $pdo;
    $query = 'SELECT  id_emp,id_mun,  cidade, estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep FROM public."VW_EMPRESA" where id_emp=\'1\'
    union
    SELECT null as id_emp,id_mun,"GESMUN".nome as cidade,"GESEST".nome as estado, concat(substring(cep,1,5),\'-\',substring(cep,6,3)) as cep
    from public."GESMUN"  left outer join "GESEST"  on  "GESEST".id_est=  "GESMUN".id_est where "GESEST".nome =  \'SÃO PAULO\' and id_mun not in ( SELECT id_mun FROM public."VW_EMPRESA" where id_emp=\'1\' )
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

//Tabela GESEMP update - revisado em 23/03/2023 08:37
function updateGESEMP_APROVACAO(
    $nome,
    $nomefantasia,
    $cnpj,
    $tipo,
    $email,
    $quant_colab,
    $contato,
    $telefone,
    $resp_financeiro,
    $email_financeiro,
    $endereco,
    $bairro,
    $numero,
    $complemento,
    $id_mun,
    $cep,
    $datatu_mas,
    $id_per_imp,
    $id_per_ace,
    $id_mas,
    $id_emp

) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP"
        SET nome=:nome, nomefantasia=:nomefantasia, cnpj=:cnpj, tipo=:tipo, email=:email, quant_colab=:quant_colab, contato=:contato, telefone=:telefone, resp_financeiro=:resp_financeiro, 
        email_financeiro=:email_financeiro, endereco=:endereco, bairro=:bairro, numero=:numero, complemento=:complemento, id_mun=:id_mun, cep=:cep, datatu_mas=:datatu_mas,
        id_per_imp=:id_per_imp, id_per_ace=:id_per_ace, id_mas=:id_mas
        WHERE id_emp = :id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':nomefantasia', $nomefantasia, PDO::PARAM_STR);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':quant_colab', $quant_colab, PDO::PARAM_INT);
    $statement->bindParam(':contato', $contato, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':resp_financeiro', $resp_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':email_financeiro', $email_financeiro, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':id_mun', $id_mun, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_per_imp', $id_per_imp, PDO::PARAM_INT);
    $statement->bindParam(':id_per_ace', $id_per_ace, PDO::PARAM_INT);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP update - revisado em 23/03/2023 08:37
function updateGESEMP_APROVACAO_situac(
    $situac,
    $analise,
    $datatu_mas,
    $id_mas,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP"
        SET situac=:situac, analise=:analise, datatu_mas=:datatu_mas, id_mas=:id_mas
        WHERE id_emp=:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA update - revisado em 23/03/2023 08:37
function updateGESUSA_APROVACAO_situac(
    $situac,
    $analise,
    $token,
    $situac_token,
    $datatu_mas,
    $id_mas,
    $id_emp_acess
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA"
        SET situac=:situac, analise=:analise, token=:token, situac_token=:situac_token, datatu_mas=:datatu_mas, id_mas=:id_mas, id_tus=2
        WHERE id_emp_acess=:id_emp_acess and analise=1 RETURNING id_usa as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':token', $token, PDO::PARAM_STR);
    $statement->bindParam(':situac_token', $situac_token, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->execute();
    $id_usa = $statement->fetch(PDO::FETCH_ASSOC);

    return $id_usa;
}


//Tabela GESEMP update - revisado em 23/03/2023 08:37
function updateGESEMP_REPROVACAO_situac(
    $situac,
    $analise,
    $datatu_mas,
    $id_mas,
    $id_emp
) {
    global $pdo;
    $query =
        'UPDATE public."GESEMP"
        SET situac=:situac, analise=:analise, datatu_mas=:datatu_mas, id_mas=:id_mas
        WHERE id_emp=:id_emp';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSA update - revisado em 23/03/2023 08:37
function updateGESUSA_REPROVACAO_situac(
    $situac,
    $analise,
    $datatu_mas,
    $id_mas,
    $id_emp_acess
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSA"
        SET situac=:situac, analise=:analise, datatu_mas=:datatu_mas, id_mas=:id_mas
        WHERE id_emp_acess=:id_emp_acess and analise=1';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':analise', $analise, PDO::PARAM_INT);
    $statement->bindParam(':datatu_mas', $datatu_mas, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_acess', $id_emp_acess, PDO::PARAM_INT);
    $statement->execute();
}


//Tabela GESEMP select
function selectGESEMP_APROVACAO_cnpj($cnpj, $id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_emp) as contagem
        FROM public."GESEMP"
        WHERE cnpj=:cnpj and id_emp<>:id_emp
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
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
function selectGESEMP_APROVACAO_email($email, $id_emp)
{
    global $pdo;
    $query =
        'SELECT count(id_emp) as contagem
        FROM public."GESEMP"
        WHERE email=:email and id_emp<>:id_emp
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMPR update - revisado em 23/03/2023 08:37
function updateGESMPR_menus(
    $id_usa,
    $id_emp,
    $datatu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESMPR" (id_usa, id_emp, id_mnu, datatu, situac)
        VALUES
            (:id_usa, :id_emp, 1, :datatu, 1),
            (:id_usa, :id_emp, 2, :datatu, 1),
            (:id_usa, :id_emp, 3, :datatu, 1),
            (:id_usa, :id_emp, 4, :datatu, 1),
            (:id_usa, :id_emp, 5, :datatu, 1),
            (:id_usa, :id_emp, 6, :datatu, 1),
            (:id_usa, :id_emp, 7, :datatu, 1),
            (:id_usa, :id_emp, 16, :datatu, 1),
            (:id_usa, :id_emp, 8, :datatu, 1),
            (:id_usa, :id_emp, 9, :datatu, 1),
            (:id_usa, :id_emp, 10, :datatu, 1),
            (:id_usa, :id_emp, 11, :datatu, 1),
            (:id_usa, :id_emp, 12, :datatu, 1),
            (:id_usa, :id_emp, 13, :datatu, 1),
            (:id_usa, :id_emp, 20, :datatu, 1),
            (:id_usa, :id_emp, 23, :datatu, 1),
            (:id_usa, :id_emp, 21, :datatu, 1),
            (:id_usa, :id_emp, 22, :datatu, 1),
            (:id_usa, :id_emp, 37, :datatu, 1),
            (:id_usa, :id_emp, 15, :datatu, 1),
            (:id_usa, :id_emp, 17, :datatu, 1),
            (:id_usa, :id_emp, 31, :datatu, 1),
            (:id_usa, :id_emp, 32, :datatu, 1),
            (:id_usa, :id_emp, 33, :datatu, 1)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESVI2 insert - revisado em 22/03/2023 08:04
function insertGESVI2($id_emp)
{
    global $pdo;
    $query = 'INSERT INTO public."GESVI2"(tabvin1, id_tab1, tabvin2, id_tab2, id_emp) VALUES (\'GESPER\', 1, \'GESTUS\', 1, :id_emp1);
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp1', $id_emp, PDO::PARAM_INT);
    $statement->execute();

    $query = 'INSERT INTO public."GESVI2"(tabvin1, id_tab1, tabvin2, id_tab2, id_emp) VALUES (\'GESPER\', 2, \'GESTUS\', 3, :id_emp2);
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp2', $id_emp, PDO::PARAM_INT);
    $statement->execute();

    $query = 'INSERT INTO public."GESVI2"(tabvin1, id_tab1, tabvin2, id_tab2, id_emp) VALUES (\'GESPER\', 1, \'GESTUS\', 2, :id_emp3);
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp3', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 create - revisado em 22/03/2023 08:04
function createGESIM1($raizCNPJ)
{
    global $pdo;
    $query = 'CREATE TABLE IF NOT EXISTS public."GESIM1_' . $raizCNPJ . '"
    (
        id_im1 integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
        competencia character varying(25) COLLATE pg_catalog."default",
        rg character varying(14) COLLATE pg_catalog."default",
        cpf character varying(14) COLLATE pg_catalog."default",
        nome character varying(255) COLLATE pg_catalog."default",
        cargo character varying(255) COLLATE pg_catalog."default",
        vlr_vencimento numeric(12,2),
        vlr_desconto numeric(12,2),
        vlr_liquido numeric(12,2),
        faixa_irrf numeric(12,2),
        vlr_basesalario numeric(12,2),
        vlr_baseinss numeric(12,2),
        vlr_basefgts numeric(12,2),
        vlr_baseirrf numeric(12,2),
        vlr_baseir numeric(12,2),
        situac integer DEFAULT 1,
        vlr_fgts numeric(12,2),
        data_credito timestamp without time zone,
        id_emp integer NOT NULL,
        descricao character varying(255) COLLATE pg_catalog."default",
        id_usu integer,
        datinc timestamp without time zone,
        id_usa_inc integer,
        id_validador character varying(34) COLLATE pg_catalog."default",
        id_processamento character varying(13) COLLATE pg_catalog."default",
        motrep character varying(255) COLLATE pg_catalog."default",
        id_usu_aceite integer,
        ip_aceite character varying(255) COLLATE pg_catalog."default",
        data_aceite timestamp with time zone,
        situac_visualizar integer DEFAULT 0,
        origem character varying(255) COLLATE pg_catalog."default",
        arquivo character varying(255) COLLATE pg_catalog."default",
        resprep character varying(255) COLLATE pg_catalog."default",
        id_usa_atu integer,
        regarq integer,
        CONSTRAINT "GESIM1_' . $raizCNPJ . 'pkey" PRIMARY KEY (id_im1),
        CONSTRAINT "GESIM1' . $raizCNPJ . 'id_emp_fkey" FOREIGN KEY (id_emp)
            REFERENCES public."GESEMP" (id_emp) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION,
        CONSTRAINT "GESIM1' . $raizCNPJ . 'id_usa_inc_fkey" FOREIGN KEY (id_usa_inc)
            REFERENCES public."GESUSA" (id_usa) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION,
        CONSTRAINT "GESIM1' . $raizCNPJ . '_id_usu_fkey" FOREIGN KEY (id_usu)
            REFERENCES public."GESUSU" (id_usu) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
    )
    
    TABLESPACE pg_default;
    
    ALTER TABLE IF EXISTS public."GESIM1_' . $raizCNPJ . '"
        OWNER to gestou;
    
    COMMENT ON TABLE public."GESIM1_' . $raizCNPJ . '"
        IS \'TABELA CABECALHO RODAPE HOLERITE\';
    
    COMMENT ON COLUMN public."GESIM1_00000000".situac
        IS \'SITUAÇÃO DO ESTAGIO ATUAL DO REGISTRO
    
    1 = Pendente
    2 = Liberado pelo RH / Pendente para usuario
    3 = Aprovado pelo usuario
    4 = Recusado pelo usuario\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".motrep
        IS \'MOTIVO PEDIDO DE REVISAO PELO USUARIO, SOMENTE APLICADO EM SITUAC ( 4 )\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".id_usu_aceite
        IS \'ID USUARIO ACEITE OU PEDIDO DE REVISAO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".ip_aceite
        IS \'IP USUARIO ACEITE OU PEDIDO DE REVISAO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".data_aceite
        IS \'DATA ACEITE OU PEDIDO DE REVISAO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".situac_visualizar
        IS \'0 - ALERTA PARA USUARIO VISUALIZAR
    1 - VISUALIZADO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".resprep
        IS \'RESPOSTA PEDIDO DE REVISAO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".id_usa_atu
        IS \'UTILIZADO RESPOSTA REVISAO RECIBO PAGAMENTO\';
    
    COMMENT ON COLUMN public."GESIM1_' . $raizCNPJ . '".regarq
        IS \'REGISTROS POR ARQUIVO\';
    ';
    $pdo->exec($query);
}

//Tabela GESREC create - revisado em 22/03/2023 08:04
function createGESREC($raizCNPJ)
{
    global $pdo;
    $query = 'CREATE TABLE IF NOT EXISTS public."GESREC_' . $raizCNPJ . '"
    (
        id_rec integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
        id_emp integer,
        id_usu integer,
        id_processamento character varying(13) COLLATE pg_catalog."default",
        descricao character varying(255) COLLATE pg_catalog."default",
        situac integer DEFAULT 1,
        situac_visualizar integer DEFAULT 0,
        datinc timestamp without time zone,
        id_usa_inc integer,
        origem character varying(255) COLLATE pg_catalog."default",
        arquivo character varying(255) COLLATE pg_catalog."default",
        id_validador character varying(34) COLLATE pg_catalog."default",
        motrep character varying(255) COLLATE pg_catalog."default",
        id_usu_aceite integer,
        ip_aceite character varying(255) COLLATE pg_catalog."default",
        data_aceite timestamp without time zone,
        resprep character varying(255) COLLATE pg_catalog."default",
        id_usa_atu integer,
        CONSTRAINT "GESREC_' . $raizCNPJ . '_pkey" PRIMARY KEY (id_rec)
    )
    
    TABLESPACE pg_default;
    
    ALTER TABLE IF EXISTS public."GESREC_' . $raizCNPJ . '"
        OWNER to gestou;
    
    COMMENT ON TABLE public."GESREC_' . $raizCNPJ . '"
        IS \'TABELA RECIBOS DIVERSOS\';
    ';
    $pdo->exec($query);
}

//Tabela GESIRR create - revisado em 22/03/2023 08:04
function createGESIRR($raizCNPJ)
{
    global $pdo;
    $query = 'CREATE TABLE IF NOT EXISTS public."GESIRR_' . $raizCNPJ . '"
    (
        id_irr integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
        anoexe character varying(4) COLLATE pg_catalog."default",
        anocal character varying(4) COLLATE pg_catalog."default",
        cpf character varying(14) COLLATE pg_catalog."default",
        natren character varying(255) COLLATE pg_catalog."default",
        ren_3_1 numeric(12,2),
        ren_3_2 numeric(12,2),
        ren_3_3 numeric(12,2),
        ren_3_4 numeric(12,2),
        ren_3_5 numeric(12,2),
        ren_4_1 numeric(12,2),
        ren_4_2 numeric(12,2),
        ren_4_3 numeric(12,2),
        ren_4_4 numeric(12,2),
        ren_4_5 numeric(12,2),
        ren_4_6 numeric(12,2),
        ren_4_7 numeric(12,2),
        ren_5_1 numeric(12,2),
        ren_5_2 numeric(12,2),
        ren_5_3 numeric(12,2),
        numpro character varying(255) COLLATE pg_catalog."default",
        quames numeric(12,2),
        natren_6_1 character varying(255) COLLATE pg_catalog."default",
        ren_6_1 numeric(12,2),
        ren_6_2 numeric(12,2),
        ren_6_3 numeric(12,2),
        ren_6_4 numeric(12,2),
        ren_6_5 numeric(12,2),
        ren_6_6 numeric(12,2),
        infcom text COLLATE pg_catalog."default",
        id_usu integer,
        id_emp integer,
        situac integer DEFAULT 1,
        situac_visualizar integer DEFAULT 0,
        id_processamento character varying(13) COLLATE pg_catalog."default",
        id_usa_inc integer,
        datinc timestamp without time zone,
        desc_4_7 character varying(255) COLLATE pg_catalog."default",
        nome_8_1 character varying(255) COLLATE pg_catalog."default",
        data_8_1 date,
        origem character varying(255) COLLATE pg_catalog."default",
        arquivo character varying(255) COLLATE pg_catalog."default",
        regarq integer,
        CONSTRAINT "GESIRR_' . $raizCNPJ . '_pkey" PRIMARY KEY (id_irr)
    )
    
    TABLESPACE pg_default;
    
    ALTER TABLE IF EXISTS public."GESIRR_' . $raizCNPJ . '"
        OWNER to gestou;
    
    COMMENT ON TABLE public."GESIRR_' . $raizCNPJ . '"
        IS \'IMPORTAÇÃO INFORME DE RENDIMENTOS\';
    ';
    $pdo->exec($query);
}

//Tabela GESPON1 create - revisado em 22/03/2023 08:04
function createGESPON1($raizCNPJ)
{
    global $pdo;
    $query = 'CREATE TABLE IF NOT EXISTS public."GESPON1_' . $raizCNPJ . '"
    (
        id_pon1 integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
        pis character varying(25) COLLATE pg_catalog."default",
        id_usu integer,
        id_emp integer,
        periodo character varying(255) COLLATE pg_catalog."default",
        situac integer DEFAULT 1,
        datinc timestamp without time zone,
        btotal character varying(25) COLLATE pg_catalog."default",
        bsaldo character varying(25) COLLATE pg_catalog."default",
        ex50 character varying(25) COLLATE pg_catalog."default",
        exf01 character varying(25) COLLATE pg_catalog."default",
        extras character varying(25) COLLATE pg_catalog."default",
        situac_visualizar integer DEFAULT 0,
        id_processamento character varying(13) COLLATE pg_catalog."default",
        id_usa_inc integer,
        origem character varying(255) COLLATE pg_catalog."default",
        arquivo character varying(255) COLLATE pg_catalog."default",
        regarq integer,
        CONSTRAINT "GESPON1_' . $raizCNPJ . '_pkey" PRIMARY KEY (id_pon1)
    )
    
    TABLESPACE pg_default;
    
    ALTER TABLE IF EXISTS public."GESPON1_' . $raizCNPJ . '"
        OWNER to gestou;
    
    COMMENT ON TABLE public."GESPON1_' . $raizCNPJ . '"
        IS \'TABELA IMPORTAÇAO PONTOS\';
    
    COMMENT ON COLUMN public."GESPON1_' . $raizCNPJ . '".origem
        IS \'Nome do arquivo de origem\';
    
    COMMENT ON COLUMN public."GESPON1_' . $raizCNPJ . '".arquivo
        IS \'Nome arquivo gerado pela importação\';
    ';
    $pdo->exec($query);
}

//Tabela GESUSA select
function selectGESUSA_token($id_usa)
{
    global $pdo;
    $query =
        'SELECT id_usa, nome, email, token FROM public."GESUSA" WHERE id_usa =:id_usa';
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

//Tabela GESEMP select - revisado em 10/12/2021 14:29
function selectGESEMP_verifica_cnpj($id_emp)
{
    global $pdo;
    $query = 'SELECT count(*) FROM public."GESEMP"
    WHERE substring(cnpj,0,11) = (SELECT substring(cnpj,0,11) FROM public."GESEMP" where id_emp =  :id_emp)
    AND id_emp != :id_emp';
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

//Tabela GESMAS select - revisado em 29/03/2023 07:58
function select_GESMAS()
{
    global $pdo;
    $query = 'SELECT * FROM public."GESMAS"';
    $statement = $pdo->prepare($query);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View GESMNU select - revisado em 27/12/2021 16:02
function selectCOUNT_GESMNU_master($id_mas)
{
    global $pdo;
    $query = 'SELECT count(id_mnu) as contagem FROM public."GESMNU" as a where a.tipo=\'master\' and a.id_mnu not in (
    select b.id_mnu from public."GESMPS" b where b.id_mas=:id_mas)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View GESMNU select - revisado em 27/12/2021 16:02
function select_TELAS_INSERT_master($id_mas)
{
    global $pdo;
    $query = 'SELECT (id_mnu) FROM public."GESMNU" as a where a.tipo=\'master\' and a.id_mnu not in ( select b.id_mnu from public."GESMPS" b where b.id_mas=:id_mas)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//insert GESMPS insert
function insertGESMNU_add_master($id_mas, $contagem, $datatu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMPS"(id_mas, id_mnu, datatu)
    VALUES (:id_mas, :contagem, :datatu);';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':contagem', $contagem, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}


//View selectTELAS_master select - revisado em 27/12/2021 16:02
function selectTELAS_master($id_mas)
{
    global $pdo;
    $query = 'SELECT a.*,coalesce((select b.situac from public."GESMPS" as b where b.id_mnu=a.id_mnu and b.id_mas=:id_mas) ,0)as situac,
    coalesce((select b.id_mps from public."GESMPS" as b where b.id_mnu=a.id_mnu and b.id_mas=:id_mas) ,0)as id_mps,
    coalesce((select b.id_mas from public."GESMPS" as b where b.id_mnu=a.id_mnu and b.id_mas=:id_mas) ,0)as id_mas
    FROM public."GESMNU" as a
    WHERE tipo=\'master\'
    ORDER BY a.ordem';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Select MENUS_master select - revisado em 27/12/2021 16:02
function selectMENUS_master($id_mas)
{
    global $pdo;
    $query = 'SELECT a.*,b.situac,b.id_mps
    FROM public."GESMNU" as a left outer join public."GESMPS" as b on b.id_mnu=a.id_mnu 
    where  b.id_mas=:id_mas and b.situac = 1 and a.estagio=1
    ORDER BY a.ordem
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Select selectITENS_MENUS_master select - revisado em 27/12/2021 16:02
function selectITENS_MENUS_master($id_mas, $nivel)
{
    global $pdo;
    $query = 'SELECT a.*,b.situac,b.id_mps
    FROM public."GESMNU" as a left outer join public."GESMPS" as b on b.id_mnu=a.id_mnu 
    where  b.id_mas=:id_mas and b.situac = 1 and a.nivel like :nivel
    ORDER BY a.ordem
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMPS update
function updateGESMPS($situac, $id_mps)
{
    global $pdo;
    $query =
        'UPDATE public."GESMPS" SET situac=:situac WHERE id_mps=:id_mps;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mps', $id_mps, PDO::PARAM_INT);
    $statement->execute();
}

//Select selectGESMAS select - revisado em 27/12/2021 16:02
function selectGESMAS($id_mas)
{
    global $pdo;
    $query = 'SELECT * FROM public."GESMAS" WHERE id_mas=:id_mas
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMAS select
function selectGESMAS_cpf_count($cpf, $id_mas)
{
    global $pdo;
    $query =
        'SELECT count(cpf) as contagem
        FROM public."GESMAS"
        WHERE cpf=:cpf and id_mas<>:id_mas
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMAS select
function selectGESMAS_email_count($email, $id_mas)
{
    global $pdo;
    $query =
        'SELECT count(email) as contagem
        FROM public."GESMAS"
        WHERE email=:email and id_mas<>:id_mas
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMAS update
function updateGESMAS($nome, $cpf, $email, $datatu, $id_mas)
{
    global $pdo;
    $query =
        'UPDATE public."GESMAS" SET nome=:nome, cpf=:cpf, email=:email, datatu=:datatu WHERE id_mas=:id_mas;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMAS update - revisado em 22/01/2021 16:02
function troca_senha_GESMAS(
    $senha,
    $datatu,
    $id_mas
) {
    global $pdo;
    $query =
        'UPDATE public."GESMAS" SET senha =:senha, datatu =:datatu, situac_senha = 1 WHERE id_mas =:id_mas';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESMAS update - revisado em 08/12/2021 08:51
function updateGESMAS_SITUAC(
    $situac,
    $id_mas,
    $datatu
) {
    global $pdo;
    $query =
        'UPDATE public."GESMAS" SET situac =:situac, datatu =:datatu WHERE id_mas =:id_mas';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_mas', $id_mas, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESMAS select
function selectGESMAS_cpf_count_cadastro($cpf)
{
    global $pdo;
    $query =
        'SELECT count(cpf) as contagem
        FROM public."GESMAS"
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

//Tabela GESMAS select
function selectGESMAS_email_count_cadastro($email)
{
    global $pdo;
    $query =
        'SELECT count(email) as contagem
        FROM public."GESMAS"
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

//insert GESMAS insert
function insertGESMAS($nome, $cpf, $email, $senha, $datinc, $situac, $datatu)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMAS"(nome, cpf, email, senha, datinc, situac, datatu)
    VALUES (:nome, :cpf, :email, :senha, :datinc, :situac, :datatu);';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESMPR select
function selectGESMPR($id_usa, $id_emp)
{
    global $pdo;
    $query =
        'SELECT * FROM public."GESMPR"
        WHERE id_usa=:id_usa AND id_emp=:id_emp and situac=1';
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

//Tabela GESMPR insert
function insertGESMPR($id_usa, $id_emp, $id_mnu, $datatu, $situac)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESMPR"(id_usa, id_emp, id_mnu, datatu, situac)
    VALUES (:id_usa, :id_emp, :id_mnu, :datatu, :situac);';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usa', $id_usa, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_mnu', $id_mnu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESEMP select
function selectGESEMP_VERIFICACNPJ($cnpj)
{
    global $pdo;
    $query =
        'SELECT EXISTS (
            SELECT 1 
            FROM public."GESEMP" 
            WHERE cnpj = :cnpj
        );';
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

//Tabela GESUSA select
function selectGESUSA_VERIFICACPF($cpf)
{
    global $pdo;
    $query =
        'SELECT EXISTS (
            SELECT 1 
            FROM public."GESUSA" 
            WHERE cpf = :cpf
        );';
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

//Tabela GESEMP select
function selectGESEMP_VERIFICAFILIAL($id_emp)
{
    global $pdo;
    $query =
        'SELECT tipo 
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

//Tabela GESEMP select
function selectGESEMP_CNPJ($id_emp)
{
    global $pdo;
    $query =
        'SELECT cnpj 
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

//Tabela GESLAY select
function selectGESLAY_id_emp_exists($id_emp)
{
    global $pdo;
    $query =
        'SELECT EXISTS(
            SELECT 1 
            FROM public."GESLAY" 
            WHERE id_emp = :id_emp
        )';
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

//View VW_EMPRESA select - revisado em 10/12/2021 14:29
function selectGESEMP_VERIFICARAIZCNPJ($raiz_cnpj)
{
    global $pdo;
    $query = 'SELECT EXISTS (
            SELECT 1 
            FROM public."GESEMP" 
           WHERE LEFT(regexp_replace(cnpj, \'[^0-9]\', \'\', \'g\'), 8) = :raiz_cnpj
        );';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':raiz_cnpj', $raiz_cnpj, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}
