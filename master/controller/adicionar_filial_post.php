<?php

// Faz a requisição da Sessão
require '../restrito.php';

// Funções INSERT, UPDATE, DELETE e SELECT
require_once "../iuds_pdo.php";

// Arquivo de Utilitários
require_once "../util2.php";

$desativa_insert = 0;

// if (isset($_POST["image"])) {

//     $id_emp = $_SESSION["tabela_empresas"]["id_emp_filial"];

//     if (!empty($id_emp)) {

//         // Recebe a imagem enviada pelo formulário
//         $image = $_POST['image'];

//         // Separa o tipo e os dados da imagem
//         list($type, $image) = explode(';', $image);
//         list(, $image) = explode(',', $image);

//         // Decodifica a imagem de base64 para binário
//         $image = base64_decode($image);

//         // Define o nome da imagem
//         $image_name = $raiz_cnpj . '_logo.png';

//         // Obtém a foto da empresa no banco de dados
//         foreach (selectGESEMP_FOTO($id_emp_master) as $foto_banco) {
//             $imagem = $foto_banco["imagem"];

//             // Se a imagem existir, remove o arquivo existente
//             if ($imagem != NULL) {
//                 unlink('../upload/empresa/' . $imagem);
//             }

//             // Atualiza o registro da imagem no banco de dados
//             updateGESEMP_FOTO($image_name, $id_emp_master, $datatu, $id_usa_default);
//         }

//         // Salva a nova imagem no servidor
//         file_put_contents('../upload/empresa/' . $image_name, $image);

//         // Define o status como 'sucesso' quando o processo finalizar
//         $status = 'sucesso';
//         $mensagem = 'Foto alterada com sucesso!';

//         // Constrói um array de retorno com o status e a mensagem de erro
//         $retorna = array(
//             'status' => $status,
//             'mensagem' => $mensagem
//         );
//     } else {
//         // Define o status como 'erro' quando o ID da empresa está vazio
//         $status = 'erro';
//         $mensagem = 'Ocorreu um erro ao enviar os dados.';

//         // Constrói um array de retorno com o status e a mensagem de erro
//         $retorna = array(
//             'status' => $status,
//             'mensagem' => $mensagem
//         );
//     }

//     // Envia o array de retorno em formato JSON
//     echo json_encode($retorna);
// }

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
            $cnpj_raiz = $_POST["cnpj_raiz"];
            $cnpj_final = $_POST["cnpj_final"];
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
            $cnpj_raizValid = validarValor('REGEX_REQUIRED', $cnpj_raiz, '/^\d{2}\.\d{3}\.\d{3}\/$/');
            $cnpj_finalValid = validarValor('REGEX_REQUIRED', $cnpj_final, '/^\d{4}-\d{2}$/');
            $cidadeValid = validarValor('*', $cidade, 1);

            // Verifica se todas as validações passaram
            if ($nomeValid && $nomefantasiaValid && $cnpj_raizValid && $cnpj_finalValid && $cidadeValid) {

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

                // Concatena as partes do CNPJ
                $cnpj = $cnpj_raiz . $cnpj_final;

                foreach (selectGESEMP_VERIFICACNPJ($cnpj) as $select_valida) {

                    $verifica_cnpj = $select_valida["exists"];
                }

                if (empty($verifica_cnpj) || !$verifica_cnpj) {
                    // O CNPJ não existe no banco de dados (false ou vazio)

                    // Seleciona dados da empresa matriz
                    $dados_matriz = selectGESEMP_FILIAL($id_emp);
                    if (!empty($dados_matriz)) {
                        // Extrai os dados necessários da empresa matriz
                        foreach ($dados_matriz as $dados) {
                            $imagem = $dados["imagem"];
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

                        // Parâmetros fixos para a nova filial
                        $id_mas = $id_mas_default;
                        $datatu_mas = $datatu;
                        $quant_colab = 0;
                        $analise = 0;
                        $limite_paginas = 500;
                        $id_emp_i = $id_emp;
                        $id_emp_p = $id_emp;
                        $id_emp_h = $id_emp;
                        $tipo = "F";
                        $situac = 1;

                        if ($desativa_insert == 0) {

                            // Inserção na tabela GESEMP_FILIAL
                            $id_empGESEMP = insertGESEMP_FILIAL(
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
                            );

                            // Atribui o ID da nova filial
                            $id_emp_filial = $id_empGESEMP['pk'];
                            $_SESSION["adicionar_filial"]["id_emp_filial"] = $id_emp_filial;

                            // Vincula os usuários Suporte e Yuri José
                            $tabvin1 = "GESEMP";
                            $id_tab1 = $id_emp_filial;
                            $tabvin2 = "GESUSA";
                            $usuarios = [1, 39]; // Usuários Suporte e Yuri José

                            // Insere na tabela GESVIN para cada usuário
                            foreach ($usuarios as $id) {
                                $id_tab2 = $id;
                                insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2);
                            }

                            // Insere na tabela GESVIN2
                            insertGESVI2($id_emp_filial);

                            // Insere os menus para os usuários Suporte e Yuri José
                            foreach ($usuarios as $id) {
                                $id_usa = $id;
                                foreach (selectGESMPR($id_usa, $id_emp) as $linha) {
                                    if (!empty($linha)) {
                                        $id_mnu = $linha["id_mnu"];
                                        insertGESMPR($id_usa, $id_emp_filial, $id_mnu, $datatu, $situac);
                                    }
                                }
                            }

                            // Caminhos das imagens
                            $diretorio = '../../upload/empresa/';
                            $imagem_original = $diretorio . $imagem;
                            $cnpj_formatado = preg_replace('/\D/', '', $cnpj);

                            // Extrair a extensão da imagem original
                            $extensao = pathinfo($imagem_original, PATHINFO_EXTENSION);
                            $nova_imagem = $diretorio . $cnpj_formatado . '_logo' . '.' . $extensao;

                            // Duplicar e renomear a imagem
                            if (file_exists($imagem_original)) {
                                if (copy($imagem_original, $nova_imagem)) {
                                    // Atribuir o novo nome da imagem ao campo imagem
                                    $imagem = $cnpj_formatado . '_logo' . '.' . $extensao;
                                    // Atualiza o registro da imagem no banco de dados
                                    updateGESEMP_FOTO($imagem, $id_emp_filial, $datatu, $id_usa_default);
                                } else {
                                    // Tratamento de erro se a cópia falhar
                                    $mensagem = 'Erro ao duplicar a imagem.';
                                    $retorna = array(
                                        'status' => 'erro',
                                        'mensagem' => $mensagem
                                    );
                                    // Envia a resposta em formato JSON
                                    echo json_encode($retorna);
                                    exit;
                                }
                            } else {
                                // Tratamento de erro se a imagem original não existir
                                $mensagem = 'Imagem original não encontrada.';
                                $retorna = array(
                                    'status' => 'erro',
                                    'mensagem' => $mensagem
                                );
                                // Envia a resposta em formato JSON
                                echo json_encode($retorna);
                                exit;
                            }
                        }

                        // Define mensagem de sucesso
                        $mensagem = 'Filial adicionada com sucesso!';
                        $retorna = array(
                            'status' => 'sucesso',
                            'mensagem' => $mensagem
                        );
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

        unset($_SESSION["tabela_empresas"]["id_emp_filial"]);

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
