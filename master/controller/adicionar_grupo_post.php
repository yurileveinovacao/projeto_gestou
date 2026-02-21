<?php

// Faz a requisição da Sessão
require '../restrito.php';

// Funções INSERT, UPDATE, DELETE e SELECT
require_once "../iuds_pdo.php";

// Arquivo de Utilitários
require_once "../util2.php";

$desativa_insert = 0;

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_adicionar"])) {

    try {
        // Obtém o ID da empresa matriz da sessão
        $id_emp = $_SESSION["tabela_empresas"]["id_emp_matriz"];

        // Verifica se o ID da empresa matriz não está vazio
        if (!empty($id_emp)) {

            // Captura os dados do formulário
            $nome = $_POST["nome"];
            $nomefantasia = $_POST["nomefantasia"];
            $cnpj = $_POST["cnpj"];
            $email = $_POST["email"];
            $contato = $_POST["contato"];
            $telefone = $_POST["telefone"];
            $resp_financeiro = $_POST["resp_financeiro"];
            $email_financeiro = $_POST["email_financeiro"];
            $endereco = $_POST["endereco"];
            $bairro = $_POST["bairro"];
            $numero = $_POST["numero"];
            $complemento = $_POST["complemento"];
            $estado = $_POST["estado"];
            $cidade = $_POST["cidade"];
            $cep = $_POST["cep"];

            // Validação dos campos do formulário
            $nomeValid = validarValor('VALID', $nome, 3);
            $nomefantasiaValid = validarValor('VALID', $nomefantasia, 3);
            $cnpjValid = validarValor('REGEX_REQUIRED', $cnpj, '/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/');
            $cidadeValid = validarValor('*', $cidade, 1);

            // Verifica se todas as validações passaram
            if ($nomeValid && $nomefantasiaValid && $cnpjValid && $cidadeValid) {

                // Formatação dos campos
                $nome = formatarValor('UPPER', $nome);
                $nomefantasia = formatarValor('UPPER', $nomefantasia);
                $contato = formatarValor('UPPER', $contato);
                $telefone = formatarValor('NUM', $telefone);
                $resp_financeiro = formatarValor('*', $resp_financeiro);
                $email_financeiro = formatarValor('*', $email_financeiro);
                $endereco = formatarValor('UPPER', $endereco);
                $bairro = formatarValor('UPPER', $bairro);
                $numero = formatarValor('UPPER', $numero);
                $complemento = formatarValor('UPPER', $complemento);
                $cep = formatarValor('NUM', $cep);

                // Verifica se o CNPJ existe na base de dados
                foreach (selectGESEMP_VERIFICACNPJ($cnpj) as $select_valida) {

                    $verifica_cnpj = $select_valida["exists"];
                }

                if (empty($verifica_cnpj) || !$verifica_cnpj) {
                    // O CNPJ não existe no banco de dados (false ou vazio)

                    // Seleciona dados da empresa matriz
                    $dados_matriz = selectGESEMP_NOVA_GRUPO($id_emp);
                    if (!empty($dados_matriz)) {
                        // Extrai os dados necessários da empresa matriz
                        foreach ($dados_matriz as $dados) {
                            // $imagem = $dados["imagem"];
                            $layout = $dados["layout"];
                            $layout_ponto = $dados["layout_ponto"];
                            $id_per_imp = $dados["id_per_imp"];
                            $id_per_ace = $dados["id_per_ace"];
                            $layout_irrf = $dados["layout_irrf"];
                            $valges = $dados["valges"];
                            $id_usa_rh = $dados["id_usa_rh"];
                            $id_usa_ouv = $dados["id_usa_ouv"];
                            $id_emp_grupo = $dados["id_emp_grupo"];
                            $descricao_layout = $dados["descricao_layout"];
                            $tipo_h = $dados["tipo_h"];
                            $tipo_p = $dados["tipo_p"];
                            $tipo_i = $dados["tipo_i"];
                        }

                        // Parâmetros fixos para a nova empresa do grupo
                        $id_mas = $id_mas_default;
                        $datatu_mas = $datatu;
                        $quant_colab = 0;
                        $analise = 0;
                        $limite_paginas = 500;
                        $id_emp_i = $id_emp;
                        $id_emp_p = $id_emp;
                        $id_emp_h = $id_emp;
                        $tipo = "M";
                        $situac = 1;

                        $raizcnpj = substr(preg_replace('/\D/', '', $cnpj), 0, 8);

                        // Busca a raiz do CNPJ da nova empresa do grupo
                        foreach (selectGESEMP_VERIFICARAIZCNPJ($raizcnpj) as $resultado) {
                            $verifica_raizcnpj = $resultado['exists'];
                        }

                        if (empty($verifica_raizcnpj) || !$verifica_raizcnpj) {

                            if ($desativa_insert == 0) {

                                // Inserção na tabela GESEMP_NOVA_GRUPO
                                $id_empGESEMP = insertGESEMP_NOVA_GRUPO(
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
                                    $cidade,
                                    $cep,
                                    NULL,
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
                                );

                                // Atribui o ID da nova empresa do grupo
                                $id_emp_novagrupo = $id_empGESEMP['pk'];
                                $_SESSION["adicionar_novagrupo"]["id_emp_novagrupo"] = $id_emp_novagrupo;

                                // Vincula os usuários Suporte e Yuri José
                                $tabvin1 = "GESEMP";
                                $id_tab1 = $id_emp_novagrupo;
                                $tabvin2 = "GESUSA";
                                $usuarios = [1, 39]; // Usuários Suporte e Yuri José

                                // Insere na tabela GESVIN para cada usuário
                                foreach ($usuarios as $id) {
                                    $id_tab2 = $id;
                                    insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2);
                                }

                                // Insere na tabela GESVIN2
                                insertGESVI2($id_emp_novagrupo);

                                // Insere os menus para os usuários Suporte e Yuri José
                                foreach ($usuarios as $id) {
                                    $id_usa = $id;
                                    foreach (selectGESMPR($id_usa, $id_emp) as $linha) {
                                        if (!empty($linha)) {
                                            $id_mnu = $linha["id_mnu"];
                                            insertGESMPR($id_usa, $id_emp_novagrupo, $id_mnu, $datatu, $situac);
                                        }
                                    }
                                }

                                // Cria registros nas tabelas GESIM1, GESPON1, GESREC, GESIRR para a raiz do CNPJ
                                if (!empty($raizcnpj)) {
                                    createGESIM1($raizcnpj);
                                    createGESPON1($raizcnpj);
                                    createGESREC($raizcnpj);
                                    createGESIRR($raizcnpj);

                                    if (!file_exists('../../upload/beneficios/holerite/' . $raizcnpj . '')) {
                                        mkdir('../../upload/beneficios/holerite/' . $raizcnpj . '/', 0777, true);
                                    }

                                    if (!file_exists('../../upload/beneficios/ponto/' . $raizcnpj . '')) {
                                        mkdir('../../upload/beneficios/ponto/' . $raizcnpj . '/', 0777, true);
                                    }

                                    if (!file_exists('../../upload/beneficios/irrf/' . $raizcnpj . '')) {
                                        mkdir('../../upload/beneficios/irrf/' . $raizcnpj . '/', 0777, true);
                                    }

                                    if (!file_exists('../../upload/beneficios/recibos_diversos/' . $raizcnpj . '')) {
                                        mkdir('../../upload/beneficios/recibos_diversos/' . $raizcnpj . '/', 0777, true);
                                    }
                                }
                            }

                            // Define mensagem de sucesso
                            $mensagem = 'Empresa do grupo adicionada com sucesso!';
                            $retorna = array(
                                'status' => 'sucesso',
                                'mensagem' => $mensagem
                            );
                        } else {
                            // Define mensagem de erro caso o cnpj já exista
                            $mensagem = 'A <b>RAIZ do CNPJ</b> informado já existe.';
                            $retorna = array(
                                'status' => 'verifica_cnpj',
                                'mensagem' => $mensagem
                            );
                        }
                    } else {
                        // Define mensagem de erro caso os dados da matriz estejam vazios
                        $mensagem = 'Ocorreu um erro ao consultar os dados da empresa matriz.';
                        $retorna = array(
                            'status' => 'erro',
                            'mensagem' => $mensagem
                        );
                    }
                } else {
                    // Define mensagem de erro caso o cnpj já exista
                    $mensagem = 'O <b>CNPJ</b> informado já existe.';
                    $retorna = array(
                        'status' => 'verifica_cnpj',
                        'mensagem' => $mensagem
                    );
                }
            } else {
                // Define mensagem de erro caso as validações falhem
                $mensagem = 'Revise os dados preenchidos e tente novamente!';
                $retorna = array(
                    'status' => 'erro',
                    'mensagem' => $mensagem
                );
            }
        } else {
            // Define mensagem de erro caso o ID da empresa matriz esteja vazio
            $mensagem = 'Ocorreu um erro ao enviar os dados.';
            $retorna = array(
                'status' => 'erro',
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Captura e trata exceções PDO
        $mensagem = $erro->getMessage();
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia a resposta em formato JSON
    echo json_encode($retorna);
}

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_voltar"])) {

    try {

        unset($_SESSION["tabela_empresas"]["id_emp_novagrupo"]);

        // Define o status como 'sucesso'
        $retorna = array(
            'status' => 'sucesso'
        );
    } catch (PDOException $erro) {
        // Em caso de exceção PDO, captura a mensagem de erro
        $mensagem = $erro->getMessage();

        // Define o status como 'erro' e a mensagem de erro
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}
