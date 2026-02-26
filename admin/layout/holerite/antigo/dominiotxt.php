<?php
require '../restrito.php';
require_once __DIR__.'/../../../../config/database.php';
require_once '../util.php';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//RECUPERAR VARIAVEIS DE SESSAO
$id_emp_default = $_SESSION['id_emp_default'];
$today = "'" . date('Y-m-d H:i:s') . "'";
$id_usa = $_SESSION['id_usa'];
$descricao_recibo = "'" . $_SESSION['descricao'] . "'";

$val3 = uniqidReal();
$processamento = "'" . $val3 . "'";
$origem = "'".$_SESSION['nomepdf']."'";

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Difinir $log_on como um para ativar ou zero para desativar todos echos do arquivo
$log_on = 0; 

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Definir $insert_on e $update_on para um para executar todos insert/update ou zero para desativar todos insert/update 
$insert_on = 1; 
$update_on = 1; 

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Definir $redirecionar como um para direcionar para pagina de lotes processados ou zero NAO redirecionar
$redirecionar = 1; 

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Variaveis Globais
$textoSemValorGlobal;
$textoSemValorSemReferenciaGlobal;
$textoSemValorSemReferenciaSemCodigoGlobal;

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Inicio Log
echoD (1);
echoX (1,'Log processamento iniciado . . .');

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//Mensagem de controle de parametros 
if($insert_on == 1){echoD (1);echoX (1,'Script configurado para executar INSERT');}else{echoX (1,'Script configurado para NAO executar INSERT');}
if($update_on == 1){echoD (1);echoX (1,'Script configurado para executar UPDATE');}else{echoX (1,'Script configurado para NAO executar UPDATE');}
echoX(1,'Script executado em : ' . $today);

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//SELECT PARA CRIAR NOME ARQUIVO
$sql = 'SELECT cnpj,nome from public."GESEMP" where id_emp=' . $id_emp_default .  '';
$res = pg_exec($conn, $sql);
$linha = pg_fetch_assoc($res);

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//RECUPERANDO RAIZ CNPJ
$raiz1 = str_replace('.', '', $linha['cnpj']);
$raiz2 = str_replace('-', '', $raiz1);
$raiz3 = str_replace('/', '', $raiz2);
$raiz4 = substr($raiz3, 0, 8);
$filial = substr($raiz3, 10,2);

$nomeEmpresa = $linha['nome'];
echoD(2);
echoX(2,'Nome empresa : ' . $nomeEmpresa);
echoX(2,'Raiz CNPJ : ' . $raiz4);
echoX(2,'Filial : ' . $filial);

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//CRIANDO NOME TABELA
$raiz_cnpj = $raiz4;
$tabela1 = 'public."GESIM1_'.$raiz_cnpj.'"';
$tabela2 = 'public."GESIM2_'.$raiz_cnpj.'"';
$tabela3 = 'public."GESEVE"';
$tabela4 = 'public."GESUSU"';

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
echoD(2);
echoX(3,'Ler arquivo iniciado . . .');

//VARIAVEIS
$arquivo_txt = file_get_contents('../uploads/' . $raiz4 . '.txt'); //retornar conteudo do arquivo txt

//CONDIÇAO PARA REMOVER O \n NO FINAL DO ARQUIVO QUE FAZIA O CONTADOR DO LOOP SER INCREMENTADO + 1x
if(substr($arquivo_txt,strlen($arquivo_txt),1) ==""){
    $arquivo_txt = substr($arquivo_txt,0,strlen($arquivo_txt)-1); //executo substr de zero até da ultima posição -1 da string
}

$linhas = explode("\n", $arquivo_txt);                             //transformar em tinhas array para percorrer dados
$linhas = mb_convert_encoding($linhas,"UTF-8");                    //converter array pra UTF-8
$tamanho = count($linhas);                                         //contar quantos elementos o array possui
$quantos_envelopes = 0;                                            //contar quantos envelopes o arquivo possui
$numero_anterior_envelope = 0;                                     //guardar valor do envelope para contador de envelopes 

echoX(3,$arquivo_txt);

echoX(3,'Ler arquivo concluido . . .');
echoD(3);

echoX(3,'Tamanho do array lido : ' . $tamanho);
echoD(3);

echoX(3,'Processar partes iniciado . . .');
echoD(3);

//Variaveis para totalizar eventos do envelope
$vProventos = 0.00;
$vDescontos = 0.00;
$vTotalLiquido = 0.00;

//GESIM1_ => INFORMACOES: INSERIR O PRIMEIRO REGISTRO E FAZER UPDATE ATE MUDAR O NUMERO DO ENVELOPE
//GESIM2_ => INFORMACOES: INSERIR TODOS OS REGISTROS COM ID_M1 RELACIONADO
$vControleINSERT = 0; // 0 = INSERT // 1 = UPDATE

//LAÇO PRINCIPAL
for($cont1 = 0; $cont1 < $tamanho; $cont1++){

    //CRIAR ID_VALIDADOR
    $val1 = uniqid();
    $val2 = uniqidReal();
    $validador = $raiz_cnpj.$val1.$val2;
    $validador = "'".$validador."'";    

    echoX(4,'Contador de linha: ' . $cont1);
    echoX(4,'$var : ' . $linhas[$cont1]);
    
    $var = $linhas[$cont1];
    
    $numero_envelope = substr($linhas[$cont1],5,2);
    if($numero_envelope != $numero_anterior_envelope){
        $numero_anterior_envelope = $numero_envelope;
        $quantos_envelopes++;
        $vProventos = 0.00;     //reset variavel porque é um novo envelope
        $vDescontos = 0.00;     //reset variavel porque é um novo envelope
        $vTotalLiquido = 0.00;  //reset variavel porque é um novo envelope
        $vControleINSERT = 0;   //voltar ControleInsert para zero porque é um novo envelope
    }
   
    echoX(4,'Numero do envelope : ' . $numero_envelope);
    echoD(4);

    echoX(4,'Dados extraidos:');
    echoD(4);

    // variaveis iniciadas por $p = posição
    // variaveis iniciadas por $v = valor da variavel

    //expressão regular CNPJ 99999999999999
    $pattern1= "/\d[0-9]{13}/";                          
    preg_match($pattern1, $var, $vCNPJ_array);
    $vCNPJ = trim($vCNPJ_array[0]);                           //variavel CNPJ
    $pCNPJ = strpos($var, $vCNPJ);                            //posicao CNPJ
    $vCNPJRaiz = substr($vCNPJ, 0, 8);
    echoX(4,'CNPJ : ' . $vCNPJ);
    echoX(4,'Raiz : ' . $vCNPJRaiz);
    
    if($vCNPJRaiz == $raiz4){   //Verifico se a Raiz do CNPJ encontrado no arquivo_txt e igual a Raiz do CNPJ da tabela GESEMP

    echoX(4,'Validacao OK: | vCNPJRaiz = raiz4 | ' . $vCNPJRaiz . '  =  ' . $raiz4 . ' |');
    echoD(4);

    //expressão regular CPF 9999999999
    $pattern2= "/\s\d[0-9]{10}\s/";                          
    preg_match($pattern2, $var, $vCPF_array);
    $vCPF = preg_replace("/\s/i", '', $vCPF_array[0]);        //variavel CPF
    $pCPF = strpos($var, $vCPF);                              //posicao CPF
    echoX(4,'CPF : ' . $vCPF);
    $cpf = "'" . $vCPF . "'";

    //expressão regular DATA 99/99/9999
    $pattern2= "/\d{2}\/\d{2}\/\d{4}/";                          
    preg_match($pattern2, $var, $vAdmissao_array);
    $vAdmissao = $vAdmissao_array[0];                 //variavel Data Admissão
    $pAdmissao = strpos($var, $vAdmissao);            //posicao Data Admissão
    echoX(4,'ADMISSAO : ' . $vAdmissao);

    //nome do funcionario
    $pNome = 8;                                       //Posicao Nome
    $vNome = trim(substr($var,$pNome,$pCPF-14));            //variavel Nome
    echoX(4,'NOME : ' . $vNome);
    $nome = "'". $vNome ."'";

    //matricula funcionario
    $pMatricula = 5;                                //Posicao Matricula
    $vMatricula = substr($var,$pMatricula,2);       //variavel Matricula
    echoX(4,'MATRICULA : ' . $vMatricula);
    
    //expressão regular UF CIDADE: MG FORMIGA
    $pattern3= "/MG\sFORMIGA/";                          
    preg_match($pattern3, $var, $vUFCidade_array);
    $vUFCidade = $vUFCidade_array[0];                 //variavel UF Cidade
    $pUFCidade = strpos($var, $vUFCidade);            //posicao UF Cidade
    echoX(4,'UF CIDADE : ' . $vUFCidade);

    //endereço empresa
    $pEndereco = $pCNPJ+17;                                        //Posicao Endereço
    $vEndereco = substr($var,$pEndereco,$pUFCidade - $pEndereco);  //variavel Endereço
    echoX(4,'ENDEREÇO : ' . $vEndereco);

    //funcao do funcionario
    $parte_var = substr($var,$pUFCidade + strlen($vUFCidade),strlen($var));                           //parte da variavel @var
    $pFuncao_ini = $pUFCidade + strlen($vUFCidade);                                                   //posicao inicial funcao
    $pFuncao_fim = ultimaPosicaoFuncao($parte_var);                                                   //posicao final funcao
    $vFuncao = trim(substr($parte_var,$pFuncao,$pFuncao_fim));                                        //variavel funcao
    echoX(4,'FUNCAO: ' . $vFuncao);
    $cargo = "'" . $vFuncao . "'";

    //CBO do funcionario
    $pCBO = strpos($var,$vFuncao)+strlen($vFuncao);                         //posicao CBO
    $vCBO = substr($var,$pCBO,7);                                           //variavel CBO
    echoX(4,'CBO: ' . $vCBO);

    //expressão regular carteira trabalho e serie 9999999 9999
    $pattern4= "/\d{7}\s\d{4}/";                          
    preg_match($pattern4, $var, $vCarteiraSerie_array);
    $vCarteiraSerie = $vCarteiraSerie_array[0];                 //variavel Carteira Serie
    $pCarteiraSerie = strpos($var, $vCarteiraSerie);            //posicao Carteira Serie
    echoX(4,'CARTEIRA SERIE : ' . $vCarteiraSerie);

    //SELECT OU INSERT PARA VERIFICAR CADASTRO DE USUARIO
    $sql1 = 'SELECT id_usu from '.$tabela4.' where cpf=\''.$vCPF.'\'';     //query select CPF
    echoX(10,'CONSULTA ID_USU : ' . $sql1 );

    $res1 = pg_exec($conn, $sql1);                                         //executar consulta
    $linha_id_usu = pg_fetch_assoc($res1);                                 //armazenar resultado da consulta
    
    if (!empty($linha_id_usu['id_usu'])) {
        $id_usu = $linha_id_usu['id_usu'];                                 //$id_usu existe na tabela
        echoX(10,'ENCONTREI ID_USU : ' . $id_usu );
    }else{
        echoX(10,'ID_USU NAO ENCONTRADO, PROCESSO INCLUIR ID_USU : ');                            //$id_usu não existe na tabela
        $senha = "'".'$2y$10$Iipf8SP78Bt1iC1zyNLKcOtWYqto/gHQavJm3WmjJJxwoJHrt/K.e'."'";
        $id_mun = "'11061'";
        $id_emp_ant = 0;
        $situac = 0;
        $rg = 'null';
        $id_dep = 0;
        $cep = "'00000000'";
        $dependentes = "'0'";
        $situac_politica = 0;
        $query_insert1 = 'INSERT INTO '.$tabela4.' (nome, cpf, senha, datinc, situac, rg, id_mun, funcao, id_emp, id_emp_ant,datatu,id_usa_inc,id_dep,cep,dependentes,situac_politica)
        VALUES (\''.$vNome.'\',\''.$vCPF.'\', '.$senha.', '.$today.', '.$situac.','.$rg.', '.$id_mun.',\''.$vFuncao.'\','.$id_emp_default.','.$id_emp_ant.','.$today.','.$id_usa.', '.$id_dep.', '.$cep.', '.$dependentes.', '.$situac_politica.')  RETURNING id_usu as pk;';
        echoX(10,"INCLUIR FUNCIONARIO : " . $query_insert1 );
        if($insert_on == 1) {
            $id_usu = pg_fetch_result(pg_query($conn, $query_insert1), 0, 'pk')
            or die('Encountered an error when executing given sql statement: '.pg_last_error());
            echoX(10,'ID_USU INSERIDO : ' . $id_usu );
        }else{
            echoX(10,'COMANDO INSERT DESABILITADO PELO PARAMETRO INSERT_ON = 0' );
        }
        
    }    

    //competencia holerite
    $pFolhaMensal = strpos($var,'Folha Mensal')-11;                     //posicao Folha Mensal
    $vFolhaMensal = mesCompetencia(substr($var,$pFolhaMensal,11));      //variavel Folha Mensal
    echoX(4,'COMPETENCIA : ' . $vFolhaMensal);
    $competencia = "'". $vFolhaMensal . "'";

    //tipo evento - expressao regular P 11 ou D 11 ou P 41 ou D 41 - Alterei o $pattern5 em 12/08/2022 13:30hs de "/\s[PD]\s[11]{2}/" para: "/\s[PD]\s[41]{2}\s/" porque o adiantamento de salario trocou os codigos de 11 para 41
    //Alterei o $pattern5 em 14/09/2022 09:00hs de "/\s[PD]\s[41]{2}\s/" para "/\s[PD]\s[01234567891]{2}\s/" porque o adiantamento de 13 terceiro trocou os codigos de 11 e 41 para 51 - OBS: adicionei as condições de 0 a 9 no $pattern5 prevendo outras ocorrencias de 0 a 9 antes digito 1
    $pattern5= "/\s[PD]\s[01234567891]{2}\s/";  
    preg_match($pattern5, $var, $vPD_array);                            //localizar expressao regular dentro de @var e armazenar em $vPD_array
    $pTipoEventoPD = $vPD_array[0];                                     //armazenar valor de $vPD_array da posição zero em $pTipoEventoPD
    $posicaoTipoEventoPD = strpos($var, $pTipoEventoPD);                //posicao de $pTipoEventoPD em $var
    $vTipoEventoPD = trim(substr($pTipoEventoPD,1,1));                  //variavel Tipo de evento
    if($vTipoEventoPD == 'P'){$vTipoEventoPD = 'V';}                    //alterar valor encontrado de P para V
    echoX(4,'TIPO DE EVENTO : ' . $vTipoEventoPD);
    
    //eventos completo (descricao, codigo nao indentificado, codigo do evento, referencia, valor do evento)
    $vEventoCompleto = substr($var,$pAdmissao+11,$posicaoTipoEventoPD-$pAdmissao-11);    //variavel evento completo
    echoX(4,'EVENTO COMPLETO : ' . $vEventoCompleto);

    //valor evento
    $vValorEvento = valorEvento($vEventoCompleto);                      //variavel valor evento
    echoX(4,'VALOR EVENTO : ' . $vValorEvento);
    $vlrevento = $vValorEvento;

    //valor total proventos
    if($vTipoEventoPD == 'V'){$vProventos = $vProventos + $vValorEvento;}   //variavel valor proventos
    //echoX(4,'TOTAL PROVENTOS : ' . number_format($vProventos,2));         //formatar float
    echoX(4,'TOTAL PROVENTOS : ' . $vProventos);
    $vlr_vencimento = $vProventos;

    //valor total descontos
    if($vTipoEventoPD == 'D'){$vDescontos = $vDescontos + $vValorEvento;}   //variavel valor descontos
    //echoX(4,'TOTAL DESCONTOS : ' . number_format($vDescontos,2));         //formatar float
    echoX(4,'TOTAL DESCONTOS : ' . $vDescontos);
    $vlr_desconto = $vDescontos;
    
    //valor total liquido 
    $vTotalLiquido = $vProventos - $vDescontos;                             //variavel total liquido
    //echoX(4,'TOTAL LIQUIDO : ' . number_format($vTotalLiquido,2));        //formatar float
    echoX(4,'TOTAL LIQUIDO : ' . $vTotalLiquido);
    $vlr_liquido = $vTotalLiquido;

    //referencia evento
    $vReferenciaEvento = referenciaEvento();                            //variavel referencia evento
    echoX(4,'REFERENCIA EVENTO : ' . $vReferenciaEvento);
    $qtdevento = str_replace(',','.',$vReferenciaEvento);

    //codigo evento
    $vCodigoEvento = codigoEvento();                                    //variavel codigo evento
    echoX(4,'CODIGO EVENTO : ' . $vCodigoEvento);
    $codevento = "'".$vCodigoEvento."'";

    //descricao evento
    $vDescricaoEvento = substr($textoSemValorSemReferenciaSemCodigoGlobal,0,strlen($textoSemValorSemReferenciaSemCodigoGlobal)-2);      //variavel descricao evento
    echoX(4,'DESCRICAO EVENTO : ' . dicionario($vDescricaoEvento));
    $nomeevento = "'".$vDescricaoEvento."'";

    //SELECT OU INSERT PARA VERIFICAR CODEVENTO
    $sql2 = 'SELECT id_eve,codevento,nome from '.$tabela3.' where id_emp='.$id_emp_default.' and codevento= \''.$vCodigoEvento.'\'';
    echoX(10,'CONSULTA ID_EVE : ' . $sql2);

    $res2 = pg_exec($conn, $sql2);
    $linha_id_eve = pg_fetch_assoc($res2);

    if (!empty($linha_id_eve['id_eve'])) {
        $id_eve = $linha_id_eve['id_eve'];
        echoX(10,'ENCONTREI ID_EVE : ' . $id_eve );
        if ($vDescricaoEvento != $linha_id_eve['nome']) {
            //ALTERAR NOME EVENTO
            $query_update1 = 'UPDATE '.$tabela3.'  SET nome =  \''.$vDescricaoEvento.'\',  datatu =  '.$today.',  id_usa_atu =  '.$id_usa.' WHERE id_eve='.$id_eve.'';
            if($update_on == 1){
                pg_query($conn, $query_update1)
                or die('Encountered an error when executing given sql statement: '.pg_last_error());
                echoX(10,'ALTEREI NOME EVENTO : ' . $vDescricaoEvento );
            }else{
                echoX(10,'COMANDO UPDATE DESABILITADO PELO PARAMETRO UPDATE_ON = 0' );
            }
        }
    }else{
        echoX(10,'ID_EVE NAO ENCONTRADO, PROCESSO INCLUIR ID_EVE : ');
        $query_insert2 = 'INSERT INTO '.$tabela3.' (tipo,codevento,nome,id_emp,datinc,datatu,id_usa_inc,id_usa_atu) 
        VALUES (\''.$vTipoEventoPD.'\','.$vCodigoEvento.',\''.$vDescricaoEvento.'\','.$id_emp_default.','.$today.','.$today.','.$id_usa.','.$id_usa.') RETURNING id_eve as pk_eve;';
        echoX(10,"INCLUIR EVENTO : " . $query_insert2 );
        if($insert_on == 1) {
            $id_eve = pg_fetch_result(pg_query($conn, $query_insert2), 0, 'pk_eve')
            or die('Encountered an error when executing given sql statement: '.pg_last_error());
            echoX(10,'ID_EVE INSERIDO : ' . $id_eve );
        }else{
            echoX(10,'COMANDO INSERT DESABILITADO PELO PARAMETRO INSERT_ON = 0' );
        }            
    }

    //base completa
    $parte_var_base = substr($var,$posicaoTipoEventoPD+5,strlen($var));                          //removo parte inicial de $var para isolar bases de calculo do envelope
    $parte_var_base = substr($parte_var_base,0,strpos($parte_var_base,$vFuncao)-2);              //removo parte final de $parte_var_base para isolar bases de calculo do envelope
    $vBaseCompleta = preg_replace('/\s[N]/u', '', $parte_var_base);                              //removo a letra N com espaço da string $parte_var_base
    echoX(4,'BASE COMPLETA : ' . $vBaseCompleta);

    //salario base - expressao regular para localizar espaço e trocar por |
    $vBaseCompleta = preg_replace("/\s/i", '|', trim($vBaseCompleta));
    $vSalarioBase = separarBases('SalBase',$vBaseCompleta);                                      //variavel salario base
    echoX(4,'SALARIO BASE : ' . $vSalarioBase);
    $vlr_basesalario = $vSalarioBase;

    //salario contribuicao
    $vSalarioContribuicao = separarBases('SalContINSS',$vBaseCompleta);                          //variavel salario contribuicao
    echoX(4,'SALARIO CONTRIBUICAO INSS : ' . $vSalarioContribuicao);
    $vlr_baseinss = $vSalarioContribuicao;
 
    //base de calculo FGTS
    $vBaseFGTS = separarBases('BaseGFTS',$vBaseCompleta);                                        //variavel  base de calculo FGTS
    echoX(4,'BASE CALCULO FGTS : ' . $vBaseFGTS);
    $vlr_basefgts = $vBaseFGTS;

    //FGTS do periodo
    $vFGTSPeriodo = separarBases('FGTS',$vBaseCompleta);                                         //variavel FGTS periodo
    echoX(4,'FGTS PERIODO : ' . $vFGTSPeriodo);
    $vlr_fgts = $vFGTSPeriodo;
    
    //base de calculo IRRF
    $vBaseCalculoIRRF = separarBases('BaseIRRF',$vBaseCompleta);                                 //variavel base de calculo IRRF
    echoX(4,'BASE DE CALCULO IRRF : ' . $vBaseCalculoIRRF);
    $vlr_baseirrf = $vBaseCalculoIRRF;
    
    //Faixa IRRF
    $vFaixaIRRF = separarBases('FaixaIRRF',$vBaseCompleta);                                      //variavel base de calculo IRRF
    echoX(4,'FAIXA IRRF : ' . $vFaixaIRRF);
    $faixa_irrf = $vFaixaIRRF;

    //INSERT GESIM1
    if($vControleINSERT == 0){
        $rg = 'null';
        $data_credito = 'null';
        $vlr_baseir = 0;
        $situac = 0;
        
        echoD(15);
        echoX(15,'EXECUTAR INSERT GESIM1_'.$raiz_cnpj);
        $query_insert3 = 'INSERT INTO '.$tabela1.' (id_emp,competencia,rg,cpf,nome,cargo,data_credito,vlr_vencimento,vlr_desconto,vlr_liquido,faixa_irrf,vlr_basesalario,vlr_baseinss,vlr_basefgts,vlr_baseirrf,vlr_baseir,vlr_fgts,situac,id_usu,datinc,id_usa_inc,descricao,id_validador,id_processamento,origem) 
        VALUES ('.$id_emp_default.','.$competencia.','.$rg.','.$cpf.','.$nome.','.$cargo.','.$data_credito.','.$vlr_vencimento.','.$vlr_desconto.','.$vlr_liquido.','.$faixa_irrf.','.$vlr_basesalario.','.$vlr_baseinss.','.$vlr_basefgts.','.$vlr_baseirrf.','.$vlr_baseir.','.$vlr_fgts.','.$situac.','.$id_usu.','.$today.','.$id_usa.','.$descricao_recibo.','.$validador.','.$processamento.','.$origem.') RETURNING id_im1 as pk_im1;';
        echoX(15,'INCLUIR CABEÇALHO : ');
        echoX(15, $query_insert3);
        $vControleINSERT = 1; // ALTERAR PARAMETRO PARA UM PARA QUE NO PROXIMO LOOP DENTRO DO MESMO FUNCIONARIO O SCRIPT EXECUTE UPDATE NO CABEÇALHO ATÉ A ULTIMA LINHA (SOMA DOS VENCIMENTOS,DESCONTOS E BASES)
            if($insert_on == 1) {
                $id_im1 = pg_fetch_result(pg_query($conn, $query_insert3), 0, 'pk_im1')
                or die('Encountered an error when executing given sql statement: '.pg_last_error());
                echoX(15,'ID_IM1 INSERIDO : ' . $id_im1 );
                echoD(15);
            }else{
                echoX(15,'COMANDO INSERT DESABILITADO PELO PARAMETRO INSERT_ON = 0' );
            }
    }else{
        echoD(15);
        echoX(15,'EXECUTAR UPDATE GESIM1_'.$raiz_cnpj);
        $query_update2 = 'UPDATE '.$tabela1.' SET vlr_vencimento = '.$vlr_vencimento.',vlr_desconto = '.$vlr_desconto.',vlr_liquido = '.$vlr_liquido.',faixa_irrf = '.$faixa_irrf.',vlr_basesalario = '.$vlr_basesalario.',vlr_baseinss = '.$vlr_baseinss.',vlr_basefgts = '.$vlr_basefgts.',vlr_baseirrf = '.$vlr_baseirrf.',vlr_baseir = '.$vlr_baseir.',vlr_fgts = '.$vlr_fgts.',id_validador = '.$validador.',id_processamento = '.$processamento.' where id_im1 = '.$id_im1.' and id_emp = '.$id_emp_default .'';
        echoX(15,'ATUALIZAR CABEÇALHO : ');
        echoX(15, $query_update2);
        echoD(15);
        if($update_on == 1) {
            pg_query($conn, $query_update2)
            or die('Encountered an error when executing given sql statement: '.pg_last_error());
            echoX(15,'ALTEREI VALORES EM GESIM1_'.$raiz_cnpj);
        }else{
            echoX(15,'COMANDO UPDATE DESABILITADO PELO PARAMETRO UPDATE_ON = 0' );
        }
    }

    //INSERT GESM2
    echoD(20);
    echoX(20,'EXECUTAR INSERT GESIM2_'.$raiz_cnpj);
    $query_insert4 = 'INSERT INTO '.$tabela2.' (codevento,nome,quantidade,valor,id_im1,id_eve,datinc) 
    VALUES ('.$codevento.','.$nomeevento.','.$qtdevento.','.$vlrevento.','.$id_im1.','.$id_eve.','.$today.');';
    echoX(20,'INCLUIR ITENS : ');
    echoX(20, $query_insert4);
    if($insert_on == 1) {
        pg_query($conn, $query_insert4)
        or die('Encountered an error when executing given sql statement: '.pg_last_error());
    }else{
        echoX(20,'COMANDO INSERT DESABILITADO PELO PARAMETRO INSERT_ON = 0' );
    }

    echoX(4,'Quantidade de envelopes localizados até o momento: ' . $quantos_envelopes);
    echoD(4);

    }else{
        $redirecionar = 0;
        echoX(4,'Validacao NAO OK: vCNPJRaiz != raiz4 ' . $vCNPJRaiz . ' != ' . $vCNPJ);
        echoD(4);
        echo "<script language=javascript>
        alert('ARQUIVO ANEXADO NÃO PERTENCE A ESSA EMPRESA!!');
        location.href = '../recibo_pagamento';
        </script>";
    }
} //LAÇO PRINCIPAL

echoX(3,'Processar partes concluido . . .');
echoD(3);

echoX(1,'Log processamento concluido . . .');
echoD(1);

//Verificar redirecionamento
if($redirecionar == 1){
    echo "<script language=javascript>
    location.href = '../lotes_processados';
    </script>";
}

//FUNCAO UNIQIDREAL
function uniqidReal($lenght = 13){
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

//FUNCAO ESPACOS
function espaco($quant){
    $varEspacos = '';
    for ($i = 1; $i <= $quant; ++$i) {
        $varEspacos .= '&nbsp; ';
    }
    return $varEspacos;
}

//FUNCAO ECHOX TABULADA E CONTROLADA POR VARIAVEL GLOBAL
function echoX($tabulacao,$texto){
    global $log_on;
    if($log_on == 1){
        echo espaco($tabulacao) . $texto ;
        echo '<br>';
    }
}

//FUNCAO ECHOD DIVISOR TABULADO
function echoD($tabulacao){
    global $log_on;
    if($log_on == 1){
        echo espaco($tabulacao) . '-----------------------------------------------------------------------------------' ;
        echo '<br>';
    }
}

//FUNCAO LOCALIZAR ULTIMA POSICAO FUNCAO
function ultimaPosicaoFuncao($texto){
    $tamanhoString = strlen($texto);
    $posicaoInicial = 0;
    $posicaoFinal = $posicaoInicial;
        //Percorrer caracter por caracter da variavel string $texto passada na função até achar um numero
        for ($i = $posicaoInicial; $i <= $tamanhoString; ++$i) {
            $temp1 = substr($texto,$i,1);
            
            //Expressao regular para localizar espaço
            $pattern= "/\s/i"; 
            
            if(!is_numeric(substr($texto, $i, 1)) || (preg_match($pattern, $temp1) == 1) ){
                $posicaoFinal = $i;
            }else{
                $i = $tamanhoString +1;	
            }
        }
        return $posicaoFinal;
}

//FUNCAO MES COMPETENCIA
function mesCompetencia($texto){
    $mes = substr($texto,3,2);
    $ano = substr($texto,6,4);
    switch ($mes) {
        case '01':
            $mes_ext = 'Janeiro';
            break;
        case '02':
            $mes_ext = 'Fevereiro';
            break;
        case '03':
            $mes_ext = 'Março';
            break;
        case '04':
            $mes_ext = 'Abril';
            break;
        case '05':
            $mes_ext = 'Maio';
            break;	
        case '06':
            $mes_ext = 'Junho';
            break;	
        case '07':
            $mes_ext = 'Julho';
            break;
        case '08':
            $mes_ext = 'Agosto';
            break;	
        case '09':
            $mes_ext = 'Setembro';
            break;	
        case '10':
            $mes_ext = 'Outubro';
            break;	
        case '11':
            $mes_ext = 'Novembro';
            break;
         default:
            $mes_ext = 'Dezembro';
            break;	
     }
     $competencia = $mes_ext . '/'. $ano;
     return $competencia;
}

//FUNCAO PARA SEPARAR VALOR DO EVENTO COMPLETO
function valorEvento($texto){
    global $textoSemValorGlobal;
    $valorEvento = '';
    $posicaoInicial = 0;
    $posicaoFinal = strlen($texto);
    //Percorrer caracter por caracter da variavel string $texto passada na função e testar se possui um espaço entre eles
    for ($i = $posicaoFinal; $i > 0 ; --$i) {
        $temp2 = substr($texto,$i,1);

		//Expressao regular para localizar espaço
        $pattern= "/\s/i";  

        if(preg_match($pattern, $temp2) == 1){
            $posicaoInicial = $i;
            $i = 0;
        }
    }
    $textoSemValorGlobal = substr($texto,0,$posicaoInicial);
    $valorEvento = substr($texto,$posicaoInicial,$posicaoFinal);
    $valorEvento = str_replace(',','.',$valorEvento);
    return $valorEvento;
}

//FUNCAO PARA SEPARAR REFERENCIA DO EVENTO COMPLETO
function referenciaEvento(){
    global $textoSemValorGlobal;
    global $textoSemValorSemReferenciaGlobal;
    $referenciaEvento = '';
    $posicaoInicial = 0;
    $posicaoFinal = strlen($textoSemValorGlobal);
    //Percorrer caracter por caracter da variavel string $texto passada na função e testar se possui um espaço entre eles
    for ($i = $posicaoFinal; $i > 0 ; --$i) {
        $temp2 = substr($textoSemValorGlobal,$i,1);

		//Expressao regular para localizar espaço
        $pattern= "/\s/i";  

        if(preg_match($pattern, $temp2) == 1){
            $posicaoInicial = $i;
            $i = 0;
        }
    }
    $textoSemValorSemReferenciaGlobal = substr($textoSemValorGlobal,0,$posicaoInicial);
    $referenciaEvento = substr($textoSemValorGlobal,$posicaoInicial,$posicaoFinal);
    return $referenciaEvento;
}

//FUNCAO PARA SEPARAR CODIGO DO EVENTO COMPLETO
function codigoEvento(){
    global $textoSemValorSemReferenciaGlobal;
    global $textoSemValorSemReferenciaSemCodigoGlobal;
    $codigoEvento = '';
    $posicaoInicial = 0;
    $posicaoFinal = strlen($textoSemValorSemReferenciaGlobal);
    //Percorrer caracter por caracter da variavel string $texto passada na função e testar se possui um espaço entre eles
    for ($i = $posicaoFinal; $i > 0 ; --$i) {
        $temp2 = substr($textoSemValorSemReferenciaGlobal,$i,1);

		//Expressao regular para localizar espaço
        $pattern= "/\s/i";  

        if(preg_match($pattern, $temp2) == 1){
            $posicaoInicial = $i;
            $i = 0;
        }
    }
    $textoSemValorSemReferenciaSemCodigoGlobal = substr($textoSemValorSemReferenciaGlobal,0,$posicaoInicial);
    $codigoEvento = preg_replace("/\s/i", '',substr($textoSemValorSemReferenciaGlobal,$posicaoInicial,$posicaoFinal)); //remover espaços com preg_replace
    return $codigoEvento;
}

//FUNCAO DICIONARIO
function dicionario($texto){
    $temp = preg_replace('/SA\?DE/u', 'SAUDE', $texto);
	$temp = preg_replace('/ODONTOL\?GICO/u','ODONTOLOGICO',$temp);
    return $temp;
}

//FUNCAO SEPARAR BASES
function separarBases($tipo,$texto){
    $valorBase = 0;
    $temp = explode("|",$texto);
    switch ($tipo) {
        case 'SalBase':
            $valorBase = str_replace(',','.',$temp[0]);
            break;
        case 'SalContINSS':
            $valorBase = str_replace(',','.',$temp[1]);
            break;
        case 'BaseGFTS';
            $valorBase = str_replace(',','.',$temp[3]);
            break;
        case 'FGTS';
            $valorBase = str_replace(',','.',$temp[4]);
            break;
        case 'BaseIRRF';
            $valorBase = str_replace(',','.',$temp[2]);
            break;
        default:
            //FaixaIRRF
            $valorBase = str_replace(',','.',$temp[5]); 
            break;
    }
    return $valorBase;    
}


?>