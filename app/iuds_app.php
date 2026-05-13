<?php

/**IUD
 **Métodos Insert/Update/Delete para banco PostgreSQL
 **PDO - PHP Data Objects
 **Banco Gestou
 **Versão do arquivo IUDS_PDO: 2021-12-16-0846
 **/

require_once __DIR__.'/../config/database.php';

//SELECT CONSULTA CPF PARA LOGIN - revisado em 22/01/2022 09:14
function login_cpf($cpf)
{
    global $pdo;
    $query = 'SELECT * from public."VW_APP_GACESSO" WHERE cpf = :cpf';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT CONSULTA EMAIL PARA LOGIN - revisado em 22/01/2022 09:14
function login_email($email)
{
    global $pdo;
    $query = 'SELECT * from public."VW_APP_GACESSO" WHERE email = :email';
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

//SELECT CONSULTA CELULAR PARA LOGIN - revisado em 22/01/2022 09:14
function login_telefone($celular)
{
    global $pdo;
    $query = 'SELECT * from public."VW_APP_GACESSO" WHERE celular = :celular';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':celular', $celular, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT VW_APP_EMPACESS - revisado em 03/01/2022 09:14
function VW_APP_EMPACESS($id_usu)
{
    global $pdo;
    $query = 'SELECT
    a.nome as nome_usuario,
    a.agrdep,
    a.id_dep,
    a.bloqueado,
    a.situac,
    c.id_emp,
    c.nome,
    c.cnpj,
    c.imagem
   from public."GESUSU" as a LEFT OUTER JOIN "GESEMP" c ON a.id_emp=c.id_emp where  a.id_usu= :id_usu
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

//SELECT RAIZ CNPJ - revisado em 03/01/2022 09:14
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

//Tabela GESIM1 select - revisado em 03/01/2022 09:14
function select_GESIM1($raiz_cnpj, $id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT id_validador,descricao,competencia,vlr_liquido,id_usu,id_emp,situac
        FROM public."GESIM1_' . $raiz_cnpj . '" 
        WHERE SITUAC IN (2,3,4)
        and id_emp = :id_emp
        and id_usu = :id_usu
        ORDER BY datinc desc 
        limit 14
        ';
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

//Tabela GESIM1 select - revisado em 03/01/2022 09:14
function select_GESIM1_id_validador($raiz_cnpj, $id_validador, $id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT id_validador,descricao,competencia,vlr_liquido,id_usu,id_emp,situac,motrep,resprep
        FROM public."GESIM1_' . $raiz_cnpj . '" 
        WHERE SITUAC IN (2,3,4)
        and id_emp = :id_emp
        and id_validador =  :id_validador
        and id_usu = :id_usu
        ORDER BY datinc desc 
        limit 14
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESIM1 update - revisado em 07/12/2021 16:02
function updateGESIM1_reprovar(
    $raiz_cnpj,
    $situac,
    $motrep,
    $id_validador,
    $id_usu_aceite,
    $ip_aceite,
    $data_aceite
) {
    global $pdo;
    $query =
        'UPDATE public."GESIM1_' . $raiz_cnpj . '" SET situac =:situac, motrep =:motrep, id_usu_aceite =:id_usu_aceite, ip_aceite =:ip_aceite, data_aceite =:data_aceite WHERE id_validador =:id_validador';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':motrep', $motrep, PDO::PARAM_STR);
    $statement->bindParam(':id_usu_aceite', $id_usu_aceite, PDO::PARAM_STR);
    $statement->bindParam(':ip_aceite', $ip_aceite, PDO::PARAM_STR);
    $statement->bindParam(':data_aceite', $data_aceite, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESIM1 update - revisado em 07/12/2021 16:02
function updateGESIM1_aprovar(
    $raiz_cnpj,
    $situac,
    $id_validador,
    $id_usu_aceite,
    $ip_aceite,
    $data_aceite
) {
    global $pdo;
    $query =
        'UPDATE public."GESIM1_' . $raiz_cnpj . '" SET situac =:situac, id_usu_aceite =:id_usu_aceite, ip_aceite =:ip_aceite, data_aceite =:data_aceite WHERE id_validador =:id_validador';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu_aceite', $id_usu_aceite, PDO::PARAM_STR);
    $statement->bindParam(':ip_aceite', $ip_aceite, PDO::PARAM_STR);
    $statement->bindParam(':data_aceite', $data_aceite, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESREC update - revisado em 07/12/2021 16:02
function updateGESREC_reprovar(
    $raiz_cnpj,
    $situac,
    $motrep,
    $id_validador,
    $id_usu_aceite,
    $ip_aceite,
    $data_aceite
) {
    global $pdo;
    $query =
        'UPDATE public."GESREC_' . $raiz_cnpj . '" SET situac =:situac, motrep =:motrep, id_usu_aceite =:id_usu_aceite, ip_aceite =:ip_aceite, data_aceite =:data_aceite WHERE id_validador =:id_validador';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':motrep', $motrep, PDO::PARAM_STR);
    $statement->bindParam(':id_usu_aceite', $id_usu_aceite, PDO::PARAM_STR);
    $statement->bindParam(':ip_aceite', $ip_aceite, PDO::PARAM_STR);
    $statement->bindParam(':data_aceite', $data_aceite, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESREC update - revisado em 07/12/2021 16:02
function updateGESREC_aprovar(
    $raiz_cnpj,
    $situac,
    $id_validador,
    $id_usu_aceite,
    $ip_aceite,
    $data_aceite
) {
    global $pdo;
    $query =
        'UPDATE public."GESREC_' . $raiz_cnpj . '" SET situac =:situac, id_usu_aceite =:id_usu_aceite, ip_aceite =:ip_aceite, data_aceite =:data_aceite WHERE id_validador =:id_validador';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':id_usu_aceite', $id_usu_aceite, PDO::PARAM_STR);
    $statement->bindParam(':ip_aceite', $ip_aceite, PDO::PARAM_STR);
    $statement->bindParam(':data_aceite', $data_aceite, PDO::PARAM_STR);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT VALOR VENCIMENTO DO RECIBO - revisado em 03/01/2022 15:24
function select_PROV($raiz_cnpj, $id_validador)
{
    global $pdo;
    $tipo = 'V';

    $query =
        'SELECT sum(a.valor) as vlr, b.tipo 
        FROM public."GESIM2_' . $raiz_cnpj . '" AS a 
        left outer join public."GESIM1_' . $raiz_cnpj . '" as c on a.id_im1=c.id_im1
        left outer join public."GESEVE" as b ON a.codevento=b.codevento and c.id_emp = b.id_emp
        where id_validador= :id_validador and b.tipo = :tipo
        group by b.tipo      
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT VALOR DESCONTO DO RECIBO - revisado em 03/01/2022 15:24
function select_DESC($raiz_cnpj, $id_validador)
{
    global $pdo;
    $tipo = 'D';

    $query =
        'SELECT sum(a.valor) as vlr,b.tipo FROM public."GESIM2_' . $raiz_cnpj . '" AS a 
        left outer join public."GESIM1_' . $raiz_cnpj . '" as c on a.id_im1=c.id_im1
        left outer join public."GESEVE" as b ON a.codevento=b.codevento and c.id_emp = b.id_emp
        where id_validador= :id_validador and tipo = :tipo
        group by b.tipo       
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT EVENTOS VENCIMENTO DO RECIBO - revisado em 03/01/2022 15:24
function select_EVE_PROV($raiz_cnpj, $id_validador)
{
    global $pdo;
    $tipo = 'V';

    $query =
        'SELECT a.*,b.tipo FROM public."GESIM2_' . $raiz_cnpj . '" AS a 
        left outer join public."GESIM1_' . $raiz_cnpj . '" as c on a.id_im1=c.id_im1
        left outer join public."GESEVE" as b ON a.codevento=b.codevento and c.id_emp = b.id_emp
        where id_validador = :id_validador and tipo = :tipo  
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT VALOR DESCONTO DO RECIBO - revisado em 03/01/2022 15:24
function select_EVE_DESC($raiz_cnpj, $id_validador)
{
    global $pdo;
    $tipo = 'D';

    $query =
        'SELECT a.*,b.tipo FROM public."GESIM2_' . $raiz_cnpj . '" AS a 
        left outer join public."GESIM1_' . $raiz_cnpj . '" as c on a.id_im1=c.id_im1
        left outer join public."GESEVE" as b ON a.codevento=b.codevento and c.id_emp = b.id_emp
        where id_validador = :id_validador and tipo = :tipo         
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT DADOS EMPRESA E FUNCIONARIO HOLERITE - revisado em 03/01/2022 15:24
function select_DADOS_EMPRESA_FUNCIONARIO_HOLERITE($raiz_cnpj, $id_validador)
{
    global $pdo;

    $query =
        'SELECT a.id_validador,b.imagem as logo_empresa,b.nome as empresa,b.cnpj,b.endereco as endereco_empresa,b.numero as numero_empresa,b.bairro as bairro_empresa,b.complemento as complemento_empresa,b.cep as cep_empresa, b.telefone as telefone_empresa
        ,c.nome as cidade_empresa,d.sigla as uf_empresa
        ,a.competencia,a.data_credito,e.cpf,e.rg,a.nome,a.cargo,e.id_usu,e.endereco,e.bairro,e.numero,e.funcao,e.dataadmissao,e.datanascimento,e.tpsalario,e.ctps,e.cbo,e.pis,e.salario,
                e.email,e.celular,e.telefone,
                a.faixa_irrf,a.vlr_baseinss,a.vlr_basefgts,vlr_baseirrf,vlr_baseir,vlr_fgts
        ,f.nome as cidade_usuario,g.sigla as uf_usuario, h.nome as departamento
        ,e.cep as cep_usuario

        ,CONCAT(\'RECIBO\',\'_\',replace(a.competencia,\'/\',\'_\')) AS nome_arquivo

        FROM public."GESIM1_' . $raiz_cnpj . '" as a
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp 
        left outer join public."GESMUN" as c on c.id_mun=b.id_mun
        left outer join public."GESEST" as d on d.id_est=c.id_est
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        left outer join public."GESMUN" as f on f.id_mun=e.id_mun
        left outer join public."GESEST" as g on g.id_est=f.id_est
        left outer join public."GESDEP" as h on h.id_dep=e.id_dep
        where a.id_validador= :id_validador      
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT DADOS EVENTOS HOLERITE - revisado em 03/01/2022 15:24
function select_EVENTOS_HOLERITE($raiz_cnpj, $id_validador)
{
    global $pdo;
    $V = 'V';
    $D = 'D';

    $query =
        'SELECT c.id_validador,a.*,b.tipo ,case when b.tipo= :V then a.valor else 0 end as vencimento ,case when b.tipo= :D then a.valor else 0 end as desconto
        FROM public."GESIM2_' . $raiz_cnpj . '" AS a 
        left outer join public."GESIM1_' . $raiz_cnpj . '" as c on a.id_im1=c.id_im1
        left outer join public."GESEVE" as b ON a.codevento=b.codevento   and b.id_emp=c.id_emp
        where c.id_validador = :id_validador
        order by a.id_im2
        
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':V', $V, PDO::PARAM_STR);
    $statement->bindParam(':D', $D, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT HOLERITE - revisado em 03/01/2022 15:24
function select_HOLERITE($raiz_validador, $id_validador)
{
    global $pdo;

    $query =
        'SELECT count(id_validador) as contagem 
        FROM public."GESIM1_' . $raiz_validador . '" 
        where id_validador = :id_validador
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
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

//SELECT HOLERITE - revisado em 03/01/2022 15:24
function select_POL_PRIVACIDADE()
{
    global $pdo;

    $query =
        'SELECT * FROM public."GESPRI" WHERE app=1 and tipo=\'P\' and situac=1
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

//SELECT GESACE - revisado em 20/01/2022 15:24
function select_GESACE($id_usu)
{
    global $pdo;
    $pendente = 'Pendente';
    $aceito = 'Aceito';

    $query =
        'SELECT case when b.id_acp is null then :pendente else :aceito end as STATUS,a.nome 
        FROM public."GESUSU" a 
		left outer join public."GESACP" b on a.id_usu=b.id_usu
        left outer join public."GESPRI" c on b.id_pri=c.id_pri and c.situac=1
        where a.id_usu = :id_usu
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_STR);
    $statement->bindParam(':pendente', $pendente, PDO::PARAM_STR);
    $statement->bindParam(':aceito', $aceito, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESACE - revisado em 20/01/2022 15:24
function select_GESACE_acesso(
    $id_usu,
    $id_emp_ace,
    $ip
) {
    global $pdo;
    $query =
        'SELECT * FROM public."GESACE" where id_usu = :id_usu and id_emp_ace = :id_emp_ace and ip = :ip
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ace', $id_emp_ace, PDO::PARAM_INT);
    $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESACE insert - revisado em 07/12/2021 08:41
function insert_GESACE(
    $id_usu,
    $id_emp_ace,
    $ip,
    $datinc,
    $datatu
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESACE"(id_usu, id_emp_ace, ip, datinc, datatu) VALUES (:id_usu, :id_emp_ace, :ip, :datinc, :datatu)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ace', $id_emp_ace, PDO::PARAM_INT);
    $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESACE insert - revisado em 07/12/2021 08:41
function update_GESACE(
    $id_usu,
    $id_emp_ace,
    $ip,
    $datatu
) {
    global $pdo;
    $query =
        'UPDATE public."GESACE" SET datatu = :datatu where id_usu = :id_usu and id_emp_ace = :id_emp_ace and ip = :ip';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp_ace', $id_emp_ace, PDO::PARAM_INT);
    $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT NOTIFICACOES - revisado em 20/01/2022 15:24
function select_count_NOTIFICACOES($raiz_cnpj, $id_usu)
{
    global $pdo;

    $query =

        // SELECT count(id_im1) as contagem FROM public."GESIM1_'.$raiz_cnpj.'" where situac=2 and situac_visualizar=0 and id_usu = :id_usu

        '
        SELECT 
        (SELECT count(id_pon1) as contagem FROM public."GESPON1_' . $raiz_cnpj . '" where situac=2 and situac_visualizar=0 and id_usu =  :id_usu)
        + (SELECT count(ID_IRR) as contagem FROM public."GESIRR_' . $raiz_cnpj . '" where situac=2 and situac_visualizar=0 and id_usu =  :id_usu)
        + (SELECT count(ID_REC) as contagem FROM public."GESREC_' . $raiz_cnpj . '" where situac=2 and situac_visualizar=0 and id_usu =  :id_usu)
        + count(id_im1) as contagem FROM public."GESIM1_' . $raiz_cnpj . '" where situac=2 and situac_visualizar=0 and id_usu =  :id_usu

        ';
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

//SELECT COUNT_NOTIFICACOES - revisado em 20/01/2022 15:24
function select_NOTIFICACOES($raiz_cnpj, $id_usu)
{
    global $pdo;

    $query =
        // 'SELECT
        // case when vlr_liquido > 0 then
        // concat(\'Foi incluido um recibo de R$\',vlr_liquido,\' para o seu usuario!\')
        // else
        // \'Foi incluido um recibo para o seu usuario!\' end
        // as mensagem
        // ,id_im1,datinc,id_validador FROM public."GESIM1_'.$raiz_cnpj.'" where  situac=2 and situac_visualizar=0 and id_usu = :id_usu'

        'SELECT
        case when vlr_liquido > 0 then
        concat(\'Foi incluido um recibo de R$\',vlr_liquido,\' para o seu usuário!\')
        else
        \'Foi incluido um recibo para o seu usuário!\' end  as mensagem
        ,id_im1,datinc,id_validador,\'H\' as tipo 
FROM public."GESIM1_' . $raiz_cnpj . '" where  situac=2 and situac_visualizar=0 and id_usu = :id_usu'
        . ' union ' .
        'SELECT \'Foi incluido um espelho de ponto para o seu usuário!\' as        mensagem
        ,id_pon1 as id_im1,datinc,CAST(id_pon1 AS VARCHAR) as id_validador,\'P\' as tipo 
FROM public."GESPON1_' . $raiz_cnpj . '" where  situac=2 and situac_visualizar=0 and id_usu = :id_usu

' . ' union ' .
        'SELECT \'Foi incluido um Informe de Rendimentos para o seu usuário!\' as        mensagem
        ,id_irr as id_im1,datinc,CAST(id_irr AS VARCHAR) as id_validador,\'I\' as tipo 
FROM public."GESIRR_' . $raiz_cnpj . '" where  situac=2 and situac_visualizar=0 and id_usu = :id_usu
' . ' union ' .
        'SELECT \'Foi incluido um Recibo Diverso para o seu usuário!\' as        mensagem
,id_rec as id_rec,datinc, id_validador,\'D\' as tipo 
FROM public."GESREC_' . $raiz_cnpj . '" where  situac=2 and situac_visualizar=0 and id_usu = :id_usu
';
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

//Tabela GESIM1 update - revisado em 07/12/2021 16:02
function update_situac_visualizar(
    $raiz_cnpj,
    $id_validador
) {
    global $pdo;
    $query =
        'UPDATE public."GESIM1_' . $raiz_cnpj . '" set situac_visualizar = 1 where id_validador = :id_validador
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT CONSULTA CPF - revisado em 22/01/2022 09:14
function consulta_cpf($cpf)
{
    global $pdo;
    // LIMIT 1: evita envio múltiplo de e-mail quando há contas duplicadas com o mesmo CPF (situac=1 já filtra inativos)
    $query = 'SELECT * FROM public."VW_APP_GACESSO" WHERE cpf = :cpf AND situac = 1 ORDER BY id_usu DESC LIMIT 1';
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

//SELECT CONSULTA CPF - revisado em 22/01/2022 09:14
function consulta_contrasenha($contrasenha, $cpf)
{
    global $pdo;
    $query = 'SELECT * from public."VW_APP_GACESSO" WHERE contrasenha = :contrasenha and cpf = :cpf';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':contrasenha', $contrasenha, PDO::PARAM_INT);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
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
    $id_usu,
    $contrasenha
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET contrasenha =:contrasenha WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':contrasenha', $contrasenha, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU update - revisado em 22/01/2021 16:02
function update_senha_GESUSU(
    $senha,
    $cpf
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET senha =:senha, situac_senha = 1 WHERE cpf =:cpf';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT VW_APP_EMPACESS - revisado em 03/01/2022 09:14
function select_GESEMP_cpf(
    $cpf
) {
    global $pdo;
    $query = 'SELECT
    c.nome,
    c.email
    from public."GESEMP" as a
    LEFT OUTER JOIN public."GESUSU" as b on a.id_emp=b.id_emp
    left outer join public."GESUSA" as c on c.id_usa=a.id_usa_rh
    where b.cpf= :cpf
    ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':cpf', $cpf, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESACP insert - revisado em 07/12/2021 08:41
function insert_GESACP(
    $id_usu,
    $ip,
    $datinc,
    $id_pri
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESACP"(id_usu, ip, datinc, id_pri) VALUES (:id_usu, :ip, :datinc, :id_pri)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_pri', $id_pri, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT GESOB SOBRE - revisado em 28/01/2022 09:14
function select_GESSOB_sobre(
    $id_emp
) {
    global $pdo;
    $query = 'SELECT sob_texto, sob_imagem from public."GESSOB" where id_emp= :id_emp
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

//SELECT GESOB MISSAO, VISAO, VALORES - revisado em 28/01/2022 09:14
function select_GESSOB_mis_vis_val(
    $id_emp
) {
    global $pdo;
    $query = 'SELECT mis_texto, mis_imagem, vis_texto, vis_imagem, val_texto, val_imagem from public."GESSOB" where id_emp= :id_emp
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

//SELECT GESPOL - revisado em 28/01/2022 09:14
function select_GESPOL_count(
    $id_emp
) {
    global $pdo;
    $query = 'SELECT count(nome) as contagem from public."GESPOL" where id_emp= :id_emp and situac = 1
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

//SELECT GESPOL - revisado em 28/01/2022 09:14
function select_GESPOL(
    $id_emp
) {
    global $pdo;
    $query = 'SELECT nome, anexo, datatu from public."GESPOL" where id_emp= :id_emp and situac = 1';
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

//SELECT GESPOL - revisado em 28/01/2022 09:14
function select_organograma(
    $id_emp
) {
    global $pdo;
    $query = 'SELECT nome FROM public."VW_ORGANOGRAMA" WHERE id_emp= :id_emp order by nivel ASC
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

//Tabela GESIM1 select - revisado em 04/02/2022 14:51
function select_GESPON1(
    $raiz_cnpj,
    $id_emp,
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT id_pon1,periodo,btotal,bsaldo,situac,situac_visualizar
        FROM public."GESPON1_' . $raiz_cnpj . '"
        WHERE SITUAC IN (2)
            and id_emp = :id_emp
            and id_usu = :id_usu
            ORDER BY datinc desc 
            limit 14
        ';
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

//Tabela GESPON1 update - revisado em 05/02/2022 07:56
function update_GESPON1_situac_visualizar(
    $raiz_cnpj,
    $id_pon1
) {
    global $pdo;
    $query =
        'UPDATE public."GESPON1_' . $raiz_cnpj . '" set situac_visualizar = 1 where id_pon1 = :id_pon1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pon1', $id_pon1, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 select - revisado em 04/02/2022 14:51
function select_GESPON1_item(
    $raiz_cnpj,
    $id_emp,
    $id_pon1
) {
    global $pdo;
    $query =
        'SELECT id_pon1,periodo,btotal,bsaldo,situac,arquivo 
        FROM public."GESPON1_' . $raiz_cnpj . '"
        WHERE id_emp = :id_emp
            and id_pon1 = :id_pon1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_pon1', $id_pon1, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT DADOS PONTOS - revisado em 05/02/2022 09:34
function select_GESPON_dados($raiz_cnpj, $id_pon1)
{
    global $pdo;

    $query =
        'SELECT a.id_pon1,b.imagem as logo_empresa,b.nome as empresa,b.cnpj,b.endereco as endereco_empresa,b.numero as numero_empresa,b.bairro as bairro_empresa,b.complemento as complemento_empresa,b.cep as cep_empresa, b.telefone as telefone_empresa
        ,c.nome as cidade_empresa,d.sigla as uf_empresa
        ,a.periodo,e.cpf,e.rg,e.nome,e.funcao,e.id_usu,e.endereco,e.bairro,e.numero,e.funcao,e.dataadmissao,e.datanascimento,e.tpsalario,e.ctps,e.cbo,e.pis,e.salario,
                e.email,e.celular,e.telefone,
                a.btotal,a.bsaldo
        ,f.nome as cidade_usuario,g.sigla as uf_usuario, h.nome as departamento
        ,e.cep as cep_usuario
        ,x.id_pon2,x.data,x.ent1,x.sai1,x.ent2,x.sai2,x.ent3,x.sai3,x.btotal,x.bsaldo
        ,CONCAT(\'PONTOS\',\'_\'
                                                               
        ,replace(replace(a.periodo,\'/\',\'_\'),\'É\',\'E\')

        ) AS nome_arquivo
        FROM public."GESPON1_' . $raiz_cnpj . '" as a
        left outer join public."GESPON2_' . $raiz_cnpj . '" as x ON a.id_pon1=x.id_pon1 
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp 
        left outer join public."GESMUN" as c on c.id_mun=b.id_mun
        left outer join public."GESEST" as d on d.id_est=c.id_est
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        left outer join public."GESMUN" as f on f.id_mun=e.id_mun
        left outer join public."GESEST" as g on g.id_est=f.id_est
        left outer join public."GESDEP" as h on h.id_dep=e.id_dep
        where a.id_pon1= :id_pon1
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pon1', $id_pon1, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT DADOS PONTOS - revisado em 05/02/2022 09:34
function select_SEUS_DADOS($id_usu)
{
    global $pdo;

    $query =
        'SELECT *
        FROM public."VW_APP_NOME_USUARIO_4" WHERE id_usu=:id_usu
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

//SELECT DADOS PONTOS - revisado em 05/02/2022 09:34
function select_GESCTO($id_emp)
{
    global $pdo;

    $query =
        'SELECT * FROM public."GESCTO" where id_emp= :id_emp and situac = 1 order by nome asc
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

//SELECT DADOS PONTOS - revisado em 05/02/2022 09:34
function select_GESIRR_dados($raiz_cnpj, $id_irr)
{
    global $pdo;

    $query =
        'SELECT a.id_processamento,a.id_irr,b.nome as empresa,b.cnpj
        ,a.anoexe,e.cpf,e.nome,
        a.anocal,a.natren
		,formatar_moeda(a.ren_3_1) as ren_3_1
		,formatar_moeda(a.ren_3_2) as ren_3_2
		,formatar_moeda(a.ren_3_3) as ren_3_3
		,formatar_moeda(a.ren_3_4) as ren_3_4
		,formatar_moeda(a.ren_3_5) as ren_3_5
		,formatar_moeda(a.ren_4_1) as ren_4_1
		,formatar_moeda(a.ren_4_2) as ren_4_2
		,formatar_moeda(a.ren_4_3) as ren_4_3
		,formatar_moeda(a.ren_4_4) as ren_4_4
		,formatar_moeda(a.ren_4_5) as ren_4_5
		,formatar_moeda(a.ren_4_6) as ren_4_6
		,formatar_moeda(a.ren_4_7) as ren_4_7
        ,formatar_moeda(a.ren_5_1) as ren_5_1
		,formatar_moeda(a.ren_5_2) as ren_5_2
		,formatar_moeda(a.ren_5_3) as ren_5_3
		,formatar_moeda(a.ren_6_1) as ren_6_1
		,formatar_moeda(a.ren_6_2) as ren_6_2
		,formatar_moeda(a.ren_6_3) as ren_6_3
		,formatar_moeda(a.ren_6_4) as ren_6_4
		,formatar_moeda(a.ren_6_5) as ren_6_5
		,formatar_moeda(a.ren_6_6) as ren_6_6
		,(a.desc_4_7) as desc_4_7
		
		,a.numpro,a.quames,a.natren_6_1,a.infcom
		,a.nome_8_1,a.data_8_1,a.id_usu,a.id_emp
        ,CONCAT(\'IMPOSTO_RENDA\',\'_\',replace(a.anocal,\'/\',\'_\')) AS nome_arquivo
        FROM public."GESIRR_' . $raiz_cnpj . '" as a
        left outer join public."GESEMP" as b ON a.id_emp=b.id_emp 
        left outer join public."GESUSU" as e on e.id_usu=a.id_usu
        where a.id_irr =:id_irr    
        ';
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

//Tabela GESIM1 select - revisado em 04/02/2022 14:51
function select_GESIRR(
    $raiz_cnpj,
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT id_irr,anoexe,anocal,situac,situac_visualizar
        FROM public."GESIRR_' . $raiz_cnpj . '"
        WHERE SITUAC IN (2)
            and id_usu = :id_usu
            ORDER BY datinc desc 
            limit 14
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

//Tabela GESPON1 update - revisado em 05/02/2022 07:56
function update_GESIRR_situac_visualizar(
    $raiz_cnpj,
    $id_irr
) {
    global $pdo;
    $query =
        'UPDATE public."GESIRR_' . $raiz_cnpj . '" set situac_visualizar = 1 where id_irr = :id_irr
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESIM1 select - revisado em 04/02/2022 14:51
function select_GESIRR_item(
    $raiz_cnpj,
    $id_emp,
    $id_irr
) {
    global $pdo;
    $query =
        'SELECT id_irr,anoexe,anocal,situac
        FROM public."GESIRR_' . $raiz_cnpj . '"
        WHERE id_emp = :id_emp
        and id_irr = :id_irr
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_irr', $id_irr, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//SELECT GESTRE - revisado em 28/01/2022 09:14
function select_GESTRE_count(
    $id_emp,
    $id_usu
) {
    global $pdo;
    $query = 'SELECT count(nome) as contagem from public."GESTRE" where id_emp=:id_emp and situac = 1 AND id_dep in (
        SELECT 0 as id_dep from public."GESUSU" where id_emp =:id_emp AND id_usu=:id_usu
        union
        SELECT id_dep from public."GESUSU" where id_emp =:id_emp AND id_usu=:id_usu )
    ';
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

//SELECT GESTRE - revisado em 17/05/2023 09:03
function select_GESTRE($id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT a.id_tre, a.nome, a.datatu
            FROM public."GESTRE" AS a
        INNER JOIN  public."GESUSU" AS b ON a.id_dep = b.id_dep AND b.id_usu = :id_usu
            WHERE a.id_emp = :id_emp AND a.situac = 1
        UNION
        SELECT a.id_tre, a.nome, a.datatu
            FROM public."GESTRE" AS a
            WHERE a.id_emp = :id_emp AND a.situac = 1 AND a.id_dep = 0
        ORDER BY datatu DESC
        ';
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

//Tabela GESIM1 select - revisado em 04/02/2022 14:51
function select_GESREC(
    $raiz_cnpj,
    $id_emp,
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT id_rec,descricao,arquivo,situac,situac_visualizar,id_validador
        FROM public."GESREC_' . $raiz_cnpj . '"
        WHERE SITUAC IN (2, 3, 4)
            and id_emp = :id_emp
            and id_usu = :id_usu
            ORDER BY datinc desc 
            limit 14
        ';
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

//Tabela GESPON1 update - revisado em 05/02/2022 07:56
function update_GESREC_situac_visualizar(
    $raiz_cnpj,
    $id_validador
) {
    global $pdo;
    $query =
        'UPDATE public."GESREC_' . $raiz_cnpj . '" set situac_visualizar = 1 where id_validador = :id_validador
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
}

// //Tabela GESIM1 select - revisado em 04/02/2022 14:51
// function select_GESREC_item(
//     $raiz_cnpj,
//     $id_emp,
//     $id_rec
// ) {
//     global $pdo;
//     $query =
//         'SELECT id_rec,descricao,arquivo,situac,situac_visualizar
//         FROM public."GESREC_' . $raiz_cnpj . '"
//         WHERE id_emp = :id_emp
//         and id_rec = :id_rec
//         ';
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
//     $statement->bindParam(':id_rec', $id_rec, PDO::PARAM_INT);
//     $statement->execute();
//     if ($statement->rowCount() > 0) {
//         $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
//     } else {
//         $resultset = [0];
//     }

//     return $resultset;
// }

//Tabela GESIM1 select - revisado em 03/01/2022 09:14
function select_GESREC_id_validador($raiz_cnpj, $id_validador, $id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT id_validador,arquivo,descricao,id_usu,id_emp,situac,motrep,resprep
        FROM public."GESREC_' . $raiz_cnpj . '" 
        WHERE SITUAC IN (2,3,4)
        and id_emp = :id_emp
        and id_validador =  :id_validador
        and id_usu = :id_usu
        ORDER BY datinc desc 
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUR select - revisado em 04/02/2022 14:51
function select_GESMUR(
    $id_usu
) {
    global $pdo;
    $query =
        // 'SELECT * FROM public."GESMUR" WHERE SITUAC=1 AND ENVIADO=1 AND ID_DEP=:id_dep
        // UNION
        // SELECT * FROM public."GESMUR" WHERE SITUAC=1 AND ENVIADO=1 AND ID_DEP IN (
        // select ID_DEP from public."GESUSU" WHERE ID_USU=:id_usu)
        // ORDER BY DATINC DESC
        'SELECT * FROM public."VW_MENSAGENS_APP" where id_usu=:id_usu and tipo=\'M\' order by datinc desc
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

//Tabela GESMUR select - revisado em 04/02/2022 14:51
function select_ID_DEP_ID_USU(
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT id_dep FROM public."GESUSU" WHERE ID_USU=:id_usu
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

//Tabela GESMUR select - revisado em 04/02/2022 14:51
function select_GESMUR_item(
    $id_mur
) {
    global $pdo;
    $query =
        'SELECT id_mur,titulo,anexo,mensagem,datatu
        , case
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.pdf\' then \'ARQUIVO\'
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.jpg\' then \'IMAGEM\'
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.png\' then \'IMAGEM\'
        when substring(anexo, CHAR_LENGTH(anexo)-4,5) =\'.jpeg\' then \'IMAGEM\' else \'ERRO\' end as VERIFICACAO
        FROM public."GESMUR"
        WHERE id_mur = :id_mur
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

//SELECT COUNT_MENSAGENS - revisado em 15/05/2023 16:14
function select_count_MENSAGENS($id_usu)
{
    global $pdo;

    $query =
        'SELECT count(id) AS contagem FROM public."VW_MENSAGENS" WHERE id_usu = :id_usu';
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

//SELECT select_MENSAGENS - revisado em 15/05/2023 10:28
function select_MENSAGENS($id_usu)
{
    global $pdo;

    $query =
        'SELECT RANK () OVER (ORDER BY datinc desc) rank, * FROM public."VW_MENSAGENS" WHERE id_usu = :id_usu';
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

//Tabela GESNOT select - revisado em 04/02/2022 14:51
function select_GESNOT(
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT * FROM public."GESNOT" WHERE SITUAC=1 AND ENVIADO=1 AND ID_USU=:id_usu
        ORDER BY DATINC DESC
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

//Tabela GESNOT select - revisado em 04/02/2022 14:51
function select_GESNOT_item(
    $id_not
) {
    global $pdo;
    $query =
        'SELECT id_not,titulo,anexo,mensagem,datatu
        , case
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.pdf\' then \'ARQUIVO\'
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.jpg\' then \'IMAGEM\'
        when substring(anexo, CHAR_LENGTH(anexo)-3,4) =\'.png\' then \'IMAGEM\'
        when substring(anexo, CHAR_LENGTH(anexo)-4,5) =\'.jpeg\' then \'IMAGEM\' else \'ERRO\' end as VERIFICACAO
        FROM public."GESNOT"
        WHERE id_not = :id_not
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

//Tabela GESTSO select - revisado em 04/02/2022 14:51
function select_GESTSO($tabela)
{
    global $pdo;
    $query =
        'SELECT id_tso, descri, situac, ordem
        FROM public."GESTSO"
        WHERE situac = 1 and tabela = ' . $tabela . '
        ORDER BY ordem asc
        ';
    $statement = $pdo->prepare($query);
    // $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESSOL insert - revisado em 07/12/2021 08:41
function insert_GESSOL(
    $id_tso,
    $mensagem,
    $anexo,
    $situac,
    $datinc,
    $id_usu_inc,
    $datatu,
    $id_usa_atu,
    $id_emp
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESSOL"(id_tso, mensagem, anexo, situac, datinc, id_usu_inc, datatu, id_usa_atu, id_emp) VALUES (:id_tso, :mensagem, :anexo, :situac, :datinc, :id_usu_inc, :datatu, :id_usa_atu, :id_emp)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tso', $id_tso, PDO::PARAM_INT);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $statement->bindParam(':anexo', $anexo, PDO::PARAM_STR);
    $statement->bindParam(':situac', $situac, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usu_inc', $id_usu_inc, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOL select - revisado em 04/02/2022 14:51
function select_GESSOL_id_usu(
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT
        case
        when a.situac = 1 then 0
        when a.situac = 2 then 0
        else a.situac end as situacao,
        b.descri,
        a.* FROM public."GESSOL" as a left outer join public."GESTSO" as b on a. id_tso=b.id_tso WHERE id_usu_inc = :id_usu
        ORDER BY a.datinc desc    
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

//Tabela GESSOL_visualizar select - revisado em 15/05/2023 16:06
function select_GESSOL_visualizar($id_sol)
{
    global $pdo;
    $query =
        'SELECT situac_usu_visualizar, situac FROM public."GESSOL" WHERE id_sol = :id_sol';
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

//Tabela GESSOL_visualizar update - revisado em 15/05/2023 15:33
function updateGESSOL_visualizar($id_sol)
{
    global $pdo;
    $query =
        'UPDATE public."GESSOL" SET situac_usu_visualizar = 1 WHERE id_sol = :id_sol';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_sol', $id_sol, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESSOL select - revisado em 04/02/2022 14:51
function select_GESSOL_id_sol(
    $id_sol
) {
    global $pdo;
    $query =
        'SELECT b.descri, a.*,
        case
        when a.situac = 1 then 0
        when a.situac = 2 then 0
        else a.situac end as situacao 
        FROM public."GESSOL" as a left outer join public."GESTSO" as b 
        on a. id_tso=b.id_tso 
        WHERE id_sol = :id_sol
        ORDER BY a.datinc desc    
        ';
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

//Tabela GESSOL select - revisado em 04/02/2022 14:51
function select_GESEMP_valges(
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT case
        when a.valges = 1 and id_usa_gestor <> 0 then 1
        else 0 end as validacao
        FROM public."GESEMP" a
        left outer join public."GESUSU" b on a.ID_EMP=b.id_emp
        where b.ID_USU=:id_usu
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

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU_FOTO($id_usu)
{
    global $pdo;
    $query =
        'SELECT a.nome, a.imagem, c.id_emp, c.nome as nome_empresa, c.cnpj, c.imagem as logo_empresa
        FROM public."GESUSU" as a 
        LEFT OUTER JOIN "GESEMP" c 
        ON a.id_emp=c.id_emp 
        WHERE id_usu =:id_usu
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

//Tabela SOLICITAÇOES select - revisado em 08/12/2021 08:55
function select_SOLICITACOES_EMAIL($id_usu)
{
    global $pdo;
    $query =
        'SELECT a.nome as nome_envio,a.email as email_envio,b.nome as usuario_envio
        from
        public."VW_ADMIN_USUARIOS" as a
        left outer join public."GESUSU" as b on a.id_emp=b.id_emp and b.id_usa_gestor= a.id_usa
        where a.valges=1 and id_usu=:id_usu
        union
        select c.nome as nome_envio,c.email as email_envio,b.nome as usuario_envio
        from
        public."VW_ADMIN_USUARIOS" as a
        left outer join public."GESUSU" as b on a.id_emp=b.id_emp
        left outer join public."GESUSA" as c on c.id_usa=a.id_usa_rh
        where a.valges=0 and id_usu=:id_usu
        union
        select g.nome as nome_envio ,g.email as email_envio,(select z.nome from public."GESUSU" as z where z.id_usu=:id_usu) as usuario_envio
        FROM
        public."GESUSA" as g inner join
        public."GESEMP" as e on g.id_usa=e.id_usa_rh
        inner join public."GESSOL" as f on e.id_emp=f.id_emp
        where f.id_usu_inc=:id_usu and f.id_sol not in (
        select a.id_sol FROM public."GESSOL" as a
        inner join public."GESUSU" as b on a.id_usu_inc=b.id_usu
        inner join public."VW_ADMIN_USUARIOS" as d on a.id_emp=d.id_emp and b.id_usa_gestor= d.id_usa
        where d.valges=1 and a.id_usu_inc=:id_usu
        )
        group by nome_envio,email_envio,usuario_envio';
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

//Tabela GESSOL select - revisado em 04/02/2022 14:51
function select_GESOUV_id_usu(
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT RANK () OVER ( ORDER BY datinc DESC ) as rank,situacao,descricao,id_ouv,id_tso,mensagem,situac,datinc,id_usu_inc,id_usu_ano,datatu,id_usa_atu,resposta
        FROM
        (SELECT case when a.situac = 0 then \'Pendente\' when a.situac = 1 then \'Resolvido\' when a.situac = 2 then \'Cancelado\' else \'\' end as situacao, b.descri as descricao, a.id_ouv,a.id_tso
        ,mensagem,a.situac,datinc,id_usu_inc,id_usu_ano,datatu,id_usa_atu,id_emp,resposta
        FROM public."GESOUV" as a
        left outer join public."GESTSO" as b on a. id_tso=b.id_tso
        WHERE id_usu_inc = :id_usu
        UNION
        SELECT case when a.situac = 0 then \'Pendente\' when a.situac = 1 then \'Resolvido\' when a.situac = 2 then \'Cancelado\' else \'\' end as situacao, b.descri as descricao,a.id_ouv,a.id_tso
        ,mensagem,a.situac,datinc,id_usu_inc,id_usu_ano,datatu,id_usa_atu,id_emp,resposta
        FROM public."GESOUV" as a
        left outer join public."GESTSO" as b on a. id_tso=b.id_tso
        WHERE cast( cast(PGP_SYM_DECRYPT(a.id_usu_ano::bytea, \'key\') as text) as integer) = :id_usu) as x
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

//Tabela GESOUV insert - revisado em 07/12/2021 08:41
function insert_GESOUV(
    $id_tso,
    $mensagem,
    $datinc,
    $id_usu_inc,
    $datatu,
    $id_emp
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESOUV"(id_tso, mensagem, datinc, id_usu_inc, datatu, id_emp) VALUES (:id_tso, :mensagem, :datinc, :id_usu_inc, :datatu, :id_emp) RETURNING id_ouv as pk';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tso', $id_tso, PDO::PARAM_INT);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usu_inc', $id_usu_inc, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    $id_ouv = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_ouv;
}

//Tabela GESOUV insert - revisado em 07/12/2021 08:41
function insert_GESOUV_anonimo(
    $id_tso,
    $mensagem,
    $datinc,
    $id_usu_inc,
    $datatu,
    $id_emp
) {
    global $pdo;
    $query =
        'INSERT INTO public."GESOUV"(id_tso, mensagem, datinc, id_usu_ano, datatu, id_emp, id_usu_inc) VALUES (:id_tso, :mensagem, :datinc, PGP_SYM_ENCRYPT(:id_usu_inc, \'key\')::text, :datatu, :id_emp, 0)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_tso', $id_tso, PDO::PARAM_INT);
    $statement->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->bindParam(':id_usu_inc', $id_usu_inc, PDO::PARAM_STR);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_emp', $id_emp, PDO::PARAM_INT);
    $statement->execute();
    $id_ouv = $statement->fetch(PDO::FETCH_ASSOC);
    return $id_ouv;
}

//Tabela GESSOL select - revisado em 04/02/2022 14:51
function select_GESOUV_id_ouv(
    $id_ouv
) {
    global $pdo;
    $query =
        'SELECT b.descri, a.* 
        FROM public."GESOUV" as a left outer join public."GESTSO" as b 
        on a. id_tso=b.id_tso 
        WHERE id_ouv = :id_ouv
        ORDER BY a.datinc desc    
        ';
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

//Tabela SOLICITAÇOES select - revisado em 08/12/2021 08:55
function select_OUVIDORIA_EMAIL($id_ouv)
{
    global $pdo;
    $query =
        'SELECT f.email as email_envio,f.nome as nome_envio
        FROM public."GESOUV" as a
        left outer join public."GESTSO" as b on a. id_tso=b.id_tso
        left outer join public."GESEMP" as e on a.id_emp=e.id_emp
        left outer join public."GESUSA" as f on e.id_usa_ouv=f.id_usa
        WHERE a.id_ouv=:id_ouv';
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

//Tabela GESOUV__situac_visualizar update - revisado em 05/02/2022 07:56
function update_GESOUV_situac_visualizar($id_ouv)
{
    global $pdo;
    $query =
        'UPDATE public."GESOUV" SET situac_usu_visualizar = 1 WHERE id_ouv = :id_ouv';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_ouv', $id_ouv, PDO::PARAM_INT);
    $statement->execute();
}

//SELECT select_FOTOS_EMPRESA - revisado em 03/01/2022 09:14
// function select_FOTOS_EMPRESA($id_emp)
// {
//     global $pdo;
//     $query = 'SELECT
//     id_usu,
//     imagem
//     from public."GESUSU" where id_emp= :id_emp
// ';
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

//SELECT select_FOTOS_EMPRESA - revisado em 03/01/2022 09:14
function select_FOTOS_EMPRESA($id_emp, $id_dep)
{
    global $pdo;
    $query = 'SELECT regra,id_usu,imagem,id_dep,nome, primeiro_nome from
    (SELECT 1 as regra,id_usu
    ,case when imagem is null then \'avatar_default.png\' else imagem end as imagem
    ,id_dep,nome
    ,split_part(initcap(nome),\' \',1) as primeiro_nome
    from public."GESUSU"
    where id_emp= :id_emp and id_dep=:id_dep and situac = 1
    union
    SELECT 0 as regra,id_usu
    ,case when imagem is null then \'avatar_default.png\' else imagem end as imagem
    ,id_dep,nome
    ,split_part(initcap(nome),\' \',1) as primeiro_nome
    from public."GESUSU"
    where id_emp= :id_emp and situac = 1 ) as x
    order by nome
    
';
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

//Tabela GESUSU update
function updateGESUSU_FOTO_APROVACAO($imagem, $id_usu, $datatu, $id_usa_atu)
{
    global $pdo;
    $query =
        'UPDATE public."GESUSU" SET imagem_aprovacao =:imagem_aprovacao, datatu =:datatu, id_usa_atu =:id_usa_atu WHERE id_usu =:id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':imagem_aprovacao', $imagem, PDO::PARAM_STR);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':datatu', $datatu, PDO::PARAM_STR);
    $statement->bindParam(':id_usa_atu', $id_usa_atu, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESUSU select - revisado em 08/12/2021 08:55
function selectGESUSU_FOTO_APROVACO($id_usu)
{
    global $pdo;
    $query =
        'SELECT imagem_aprovacao FROM public."GESUSU" WHERE id_usu =:id_usu';
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

//Tabela Email RH select
function select_EMAIL_RH_APROVAR_FOTO($id_emp, $id_usu)
{
    global $pdo;
    $query =
        'SELECT g.nome as nome_rh,g.email as email_rh, (SELECT trim(f.nome) FROM public."GESUSU" as f where id_usu=:id_usu) as nome_colaborador
        FROM public."GESUSA" as g
        inner join public."GESEMP" as e on g.id_usa=e.id_usa_rh
        where id_emp=:id_emp
        ';
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

//Tabela Email RH select
function selectGESIM1_arquivo($raiz_cnpj, $id_validador)
{
    global $pdo;
    $query =
        'SELECT arquivo, competencia
        FROM public."GESIM1_' . $raiz_cnpj . '"
        where id_validador=:id_validador
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela Email RH select
function selectGESREC_arquivo($raiz_cnpj, $id_validador)
{
    global $pdo;
    $query =
        'SELECT arquivo
        FROM public."GESREC_' . $raiz_cnpj . '"
        where id_validador=:id_validador
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//View selectMENSAGENS_HOLERITE select - revisado em 27/12/2021 16:02
function selectMENSAGENS_HOLERITE($raizCNPJ, $id_validador)
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
    where id_validador= :id_validador ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//View selectMENSAGENS_RECIBO_DIVERSOS select - revisado em 27/12/2021 16:02
function selectMENSAGENS_RECIBO_DIVERSOS($raizCNPJ, $id_validador)
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
    where id_validador= :id_validador ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_validador', $id_validador, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}


//Tabela Email RH select
function selectGESIRR_arquivo($raiz_cnpj, $id_irr)
{
    global $pdo;
    $query =
        'SELECT arquivo, anocal, anoexe
        FROM public."GESIRR_' . $raiz_cnpj . '"
        where id_irr=:id_irr
        ';
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

//Tabela GESMUU select - revisado 17/05/2023 13:26
function selectGESMUU($id_usu, $id_mur)
{
    global $pdo;
    $query =
        'SELECT situac_usu_visualizar
            FROM public."GESMUU"
            WHERE id_usu = :id_usu AND id_mur = :id_mur
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESTRU select - revisado 17/05/2023 15:52
function selectGESTRU($id_usu, $id_tre)
{
    global $pdo;
    $query =
        'SELECT situac_usu_visualizar
            FROM public."GESTRU"
            WHERE id_usu = :id_usu AND id_tre = :id_tre
        ';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESMUU update - revisado 17/05/2023 15:09
function updateGESMUU_visualizado($id_usu, $id_mur)
{
    global $pdo;
    $query =
        'UPDATE public."GESMUU" SET situac_usu_visualizar = 1 WHERE id_usu = :id_usu AND id_mur = :id_mur';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_mur', $id_mur, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTRU update - revisado 18/05/2023 12:28
function updateGESTRU_visualizado($id_usu, $id_tre)
{
    global $pdo;
    $query =
        'UPDATE public."GESTRU" SET situac_usu_visualizar = 1 WHERE id_usu = :id_usu AND id_tre = :id_tre';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_tre', $id_tre, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESTRE select - revisado 18/05/2023 12:47
function selectGESTRE_item($id_tre)
{
    global $pdo;
    $query =
        'SELECT nome, anexo, link
            FROM public."GESTRE"
            WHERE id_tre = :id_tre
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

//Tabela GESNOT update - revisado 19/05/2023 08:29
function updateGESNOT_visualizado($id_not)
{
    global $pdo;
    $query =
        'UPDATE public."GESNOT" SET situac_usu_visualizar = 1 WHERE id_not = :id_not';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_not', $id_not, PDO::PARAM_INT);
    $statement->execute();
}

//View VW_CIDADE select - revisado em 29/05/2023 09:21
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

//View VW_CIDADE select - revisado em 29/05/2023 09:25
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

//View VW_CIDADE select - revisado em 29/05/2023 10:30
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

//Tabela GESUSU update - revisado 29/05/2023 14:29
function updateGESUSU(
    $id_usu,
    $email,
    $telefone,
    $celular,
    $endereco,
    $numero,
    $bairro,
    $complemento,
    $cidade,
    $cep
) {
    global $pdo;
    $query =
        'UPDATE public."GESUSU"
        SET email = :email, telefone = :telefone, celular = :celular, endereco = :endereco, numero = :numero, bairro = :bairro, complemento = :complemento, id_mun = :cidade, cep = :cep
        WHERE id_usu = :id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $statement->bindParam(':celular', $celular, PDO::PARAM_STR);
    $statement->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $statement->bindParam(':numero', $numero, PDO::PARAM_STR);
    $statement->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $statement->bindParam(':complemento', $complemento, PDO::PARAM_STR);
    $statement->bindParam(':cidade', $cidade, PDO::PARAM_INT);
    $statement->bindParam(':cep', $cep, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT GESPOL_visualizar - revisado em 30/05/2023 08:23
function select_GESPOL_visualizar(
    $id_emp,
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT a.id_pol, a.nome, a.datatu, b.situac_usu_visualizar
            FROM public."GESPOL" AS a
        LEFT JOIN public."GESPUL" AS b
            ON b.id_pol = a.id_pol AND b.id_usu = :id_usu
        WHERE a.id_emp = :id_emp AND a.situac = 1';
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

//SELECT GESPUL - revisado em 30/05/2023 08:50
function select_GESPUL(
    $id_pol,
    $id_usu
) {
    global $pdo;
    $query =
        'SELECT id_pul
            FROM public."GESPUL"
            WHERE id_pol = :id_pol AND id_usu = :id_usu';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultset = [0];
    }

    return $resultset;
}

//Tabela GESPUL update - revisado 30/05/2023 08:54
function updateGESPUL($id_pul)
{
    global $pdo;
    $query =
        'UPDATE public."GESPUL"
            SET situac_usu_visualizar = 1
            WHERE id_pul = :id_pul';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_pul', $id_pul, PDO::PARAM_INT);
    $statement->execute();
}

//Tabela GESPUL insert - revisado em 30/05/2023 08:56
function insertGESPUL($id_usu, $id_pol, $datinc)
{
    global $pdo;
    $query =
        'INSERT INTO public."GESPUL" (id_usu, id_pol, datinc, situac_usu_visualizar)
        VALUES (:id_usu, :id_pol, :datinc, 1)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_usu', $id_usu, PDO::PARAM_INT);
    $statement->bindParam(':id_pol', $id_pol, PDO::PARAM_INT);
    $statement->bindParam(':datinc', $datinc, PDO::PARAM_STR);
    $statement->execute();
}

//Tabela GESPOL_item select - revisado 30/05/2023 09:07
function selectGESPOL_item($id_pol)
{
    global $pdo;
    $query =
        'SELECT nome, anexo
            FROM public."GESPOL"
            WHERE id_pol = :id_pol';
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

//INSERT justificativa - FEA-005
function insertJustificativa($colaborador_id, $cnpj, $tipo, $data_ocorrencia, $hora_ocorrencia, $mensagem, $arquivo_path, $criado_em)
{
    global $pdo;
    $query = 'INSERT INTO justificativas (colaborador_id, cnpj_empresa, tipo, data_ocorrencia, hora_ocorrencia, mensagem, arquivo_path, criado_em) VALUES (:colaborador_id, :cnpj, :tipo, :data_ocorrencia, :hora_ocorrencia, :mensagem, :arquivo_path, :criado_em)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':colaborador_id', $colaborador_id, PDO::PARAM_INT);
    $statement->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
    $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $statement->bindParam(':data_ocorrencia', $data_ocorrencia, PDO::PARAM_STR);
    $hora = !empty($hora_ocorrencia) ? $hora_ocorrencia : null;
    $statement->bindParam(':hora_ocorrencia', $hora, PDO::PARAM_STR);
    $msg = !empty($mensagem) ? $mensagem : null;
    $statement->bindParam(':mensagem', $msg, PDO::PARAM_STR);
    $arq = !empty($arquivo_path) ? $arquivo_path : null;
    $statement->bindParam(':arquivo_path', $arq, PDO::PARAM_STR);
    $statement->bindParam(':criado_em', $criado_em, PDO::PARAM_STR);
    $statement->execute();
}

//SELECT justificativas do colaborador - FEA-005
function selectJustificativas_colaborador($id_usu, $cnpj)
{
    global $pdo;
    $query = 'SELECT * FROM justificativas WHERE colaborador_id = :id_usu AND cnpj_empresa = :cnpj ORDER BY criado_em DESC';
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