<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

/*
Permissão
*/

// Grava em sessão o id_mas para realizar a montagem da tela de permissão
if (isset($_POST["id_mas_permissao"])) {

    // Atribuição do id_mas a variavel de sessão
    $_SESSION["id_mas_permissao"] = $_POST["id_mas_permissao"];
    $_SESSION["nome_mas_permissao"] = $_POST["nome_mas_permissao"];
}

// Verifica as variáveis e faz o update
if (isset($_POST["id_mps_permissao"]) && isset($_POST["situac_permissao"])) {

    // Declaração da váriaveis postadas
    $id_mps = $_POST["id_mps_permissao"];
    $situac = $_POST["situac_permissao"];

    // Update GESMPS
    updateGESMPS($situac, $id_mps);
}

/*
Cadastro
*/

// Recebe os dados do POST referente ao update das informações
if ((isset($_POST["btn_cadastro"])) && (isset($_POST["nome_cadastro"])) && (isset($_POST["cpf_cadastro"])) && (isset($_POST["email_cadastro"]))) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_cadastro'], 3);
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_cadastro'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
    $emailValido = validarValor('REGEX_REQUIRED', $_POST['email_cadastro'], '/^([\w.\'+-]+@([\w-]+\.)+[\w-]{2,4})?$/');


    // Se os valores forem validados continua com o update
    if ($nomeValido && $cpfValido && $emailValido) {

        // Declaração da váriaveis postadas
        $btn_cadastro = $_POST["btn_cadastro"];
        $nome_cadastro = $_POST["nome_cadastro"];
        $cpf_cadastro = $_POST["cpf_cadastro"];
        $email_cadastro = $_POST["email_cadastro"];

        // Formata as variáveis
        $nome = formatarValor("UPPER", $nome_cadastro);
        $cpf = formatarValor("NUM", $cpf_cadastro);
        $email = formatarValor("LOWER", $email_cadastro);

        // Verifica se já existe o CPF cadastrado na base
        foreach (selectGESMAS_cpf_count_cadastro($cpf) as $verifica_cpf) {
            if (!empty($verifica_cpf)) {
                $count_cpf = $verifica_cpf["contagem"];
            }
        }

        // Verifica se já existe o E-MAIL cadastrado na base
        foreach (selectGESMAS_email_count_cadastro($email) as $verifica_email) {
            if (!empty($verifica_email)) {
                $count_email = $verifica_email["contagem"];
            }
        }

        // Caso ambas as informações não existirem na base, o insert é realizado
        if ((empty($count_cpf)) and (empty($count_email))) {

            // Cria a senha padrão
            $hash = 123;
            $senha = formatarValor('PASSWORD', $hash);

            // Situac do registro
            $situac = 1;

            // Insert da GESMAS
            insertGESMAS($nome, $cpf, $email, $senha, $datinc, $situac, $datatu);

            // Retorno de sucesso
            $retorno = 1;
            echo json_encode($retorno);
        } else {

            if (!empty($count_cpf)) {

                // Retorno que existe o CPF cadastrado na base
                $retorno = 2;
                echo json_encode($retorno);
            } elseif (!empty($count_email)) {

                // Retorno que existe o E-MAIL cadastrado na base
                $retorno = 3;
                echo json_encode($retorno);
            }
        }
    } else {

        // Informações não preenchidas corretamente ou não preenchidas
        $retorno = 0;
        echo json_encode($retorno);
    }
}

/*
Editar
*/

// Grava em sessão o id_mas para realizar a montagem da tela de edição
if (isset($_POST["id_mas_editar"])) {

    // Atribuição do id_mas a variavel de sessão
    $_SESSION["id_mas_editar"] = $_POST["id_mas_editar"];
}

// Recebe os dados do POST referente ao update das informações
if ((isset($_POST["btn_submit"])) && (isset($_POST["id_mas_submit"])) && (isset($_POST["nome_editar"])) && (isset($_POST["cpf_editar"])) && (isset($_POST["email_editar"]))) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_editar'], 3);
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_editar'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
    $emailValido = validarValor('REGEX_REQUIRED', $_POST['email_editar'], '/^([\w.\'+-]+@([\w-]+\.)+[\w-]{2,4})?$/');

    // Se os valores forem validados continua com o update
    if ($nomeValido && $cpfValido && $emailValido) {

        // Declaração da váriaveis postadas
        $btn_submit = $_POST["btn_submit"];
        $id_mas_submit = $_POST["id_mas_submit"];
        $nome_editar = $_POST["nome_editar"];
        $cpf_editar = $_POST["cpf_editar"];
        $email_editar = $_POST["email_editar"];

        // Formata as variáveis
        $nome = formatarValor("UPPER", $nome_editar);
        $cpf = $cpf_editar;
        $email = formatarValor("LOWER", $email_editar);

        // Verifica se já existe o CPF cadastrado na base
        foreach (selectGESMAS_cpf_count($cnpj, $id_mas_submit) as $verifica_cpf) {
            if (!empty($verifica_cpf)) {
                $count_cpf = $verifica_cpf["contagem"];
            }
        }

        // Verifica se já existe o E-MAIL cadastrado na base
        foreach (selectGESMAS_email_count($email, $id_mas_submit) as $verifica_email) {
            if (!empty($verifica_email)) {
                $count_email = $verifica_email["contagem"];
            }
        }

        // Caso ambas as informações não existirem na base, o update é realizado
        if ((empty($count_cpf)) and (empty($count_email))) {

            // Update da GESMAS
            updateGESMAS($nome, $cpf, $email, $datatu, $id_mas_submit);

            // Retorno de sucesso
            $retorno = 1;
            echo json_encode($retorno);
        } else {

            if (!empty($count_cpf)) {

                // Retorno que existe o CPF cadastrado na base
                $retorno = 2;
                echo json_encode($retorno);
            } elseif (!empty($count_email)) {

                // Retorno que existe o E-MAIL cadastrado na base
                $retorno = 3;
                echo json_encode($retorno);
            }
        }
    } else {

        // Informações não preenchidas corretamente ou não preenchidas
        $retorno = 0;
        echo json_encode($retorno);
    }
}

// Recebe os dados do POST referente ao update das informações da troca de senha
if ((isset($_POST['btn_senha'])) and (isset($_POST['id_mas_senha']))) {

    // Chama a função para validar os POSTs
    $senhaValida = validarValor('VALID', $_POST['senha'], 3);
    $confirmsenhaValida = validarValor('VALID', $_POST['confirm_senha'], 3);

    if ($senhaValida && $confirmsenhaValida) {

        try {

            $id_mas_senha = $_POST['id_mas_senha'];

            // Atribui valor das Variáveis
            $senha = $_POST['senha']; //REQUIRED
            $confirm_senha = $_POST['confirm_senha']; //REQUIRED

            // Verifica se a senha e a confirmação de senha são iguais
            if ($senha == $confirm_senha) {

                // Gera o hash da nova senha
                $new_senha = password_hash($senha, PASSWORD_DEFAULT);

                // Chama a função para atualizar a senha
                troca_senha_GESMAS($new_senha, $datatu, $id_mas_senha);

                $retorno = 1;
                echo json_encode($retorno);
            } else {

                // As senhas não coincidem
                $retorno = 2;
                echo json_encode($retorno);
            }
        } catch (PDOException $erro) {

            // Trata exceções do PDO
            echo $erro->getMessage();
        }
    } else {

        // Algum dos campos não passou na validação
        $retorno = 0;
        echo json_encode($retorno);
    }
}

/*
Situac
*/

// Recebe os dados do POST referente ao update das informações situac
if ((isset($_POST['btn_situac'])) && (isset($_POST['id_mas_situac']))) {

    // Declaração da váriaveis postadas
    $situac = $_POST['btn_situac'];
    $id_mas_situac = $_POST['id_mas_situac'];

    // Formata as Variaveis
    $situac = formatarValor('SITUAC', $situac);

    // Update no Banco - Tabela GESMAS
    updateGESMAS_SITUAC($situac, $id_mas_situac, $datatu);

    // Retorno de sucesso
    $retorno = 1;
    echo json_encode($retorno);
}

/*
Voltar
*/

// Verifica se o btn-voltar foi clicado
if (isset($_POST["btn_voltar"])) {

    // Unset das variáveis de sessão
    // Permissão
    unset($_SESSION["id_mas_permissao"]);
    unset($_SESSION["nome_mas_permissao"]);

    // Editar
    unset($_SESSION["id_mas_editar"]);
}

// // Realiza o update das informações preenchidas na página
// if (isset($_POST["btn_submit"])) {

//     // Chama a função para validar os POSTs
//     $nomeValido = validarValor('VALID', $_POST['nome'], 3);
//     $nomefantasiaValido = validarValor('VALID', $_POST['nomefantasia'], 3);
//     $cnpjValido = validarValor('REGEX_REQUIRED', $_POST['cnpj'], '/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/');
//     $tipoValido = validarValor('VALID', $_POST['tipo'], 1);
//     $emailValido = validarValor('REGEX', $_POST['email'], '/^([\w.\'+-]+@([\w-]+\.)+[\w-]{2,4})?$/');
//     $telefoneValido = validarValor('REGEX_REQUIRED', $_POST['telefone'], '/^\(\d{3}\) \d{4}-\d{4}$|^\(\d{3}\) \d{5}-\d{4}$/');
//     $enderecoValido = validarValor('VALID', $_POST['endereco'], 3);
//     $bairroValido = validarValor('VALID', $_POST['bairro'], 3);
//     $numeroValido = validarValor('VALID', $_POST['numero'], 1);
//     $estadoValido = validarValor('VALID', $_POST['estado'], 1);
//     $cidadeValido = validarValor('VALID', $_POST['cidade'], 1);
//     $cepValido = validarValor('REGEX_REQUIRED', $_POST['cep'], '/^\d{5}-\d{3}$/');

//     // echo "nomeValido: " . $nomeValido . "<br>";
//     // echo "nomefantasiaValido: " . $nomefantasiaValido . "<br>";
//     // echo "cnpjValido: " . $cnpjValido . "<br>";
//     // echo "tipoValido: " . $tipoValido . "<br>";
//     // echo "emailValido: " . $emailValido . "Email: " . $_POST['email'] . "<br>";
//     // echo "telefoneValido: " . $telefoneValido . "<br>";
//     // echo "enderecoValido: " . $enderecoValido . "<br>";
//     // echo "bairroValido: " . $bairroValido . "<br>";
//     // echo "numeroValido: " . $numeroValido . "<br>";
//     // echo "estadoValido: " . $estadoValido . "<br>";
//     // echo "cidadeValido: " . $cidadeValido . "<br>";
//     // echo "cepValido: " . $cepValido . "CEP: " . $_POST['cep'] . "<br>";

//     // Se os valores forem validados continua com o update
//     if ($nomeValido && $nomefantasiaValido && $cnpjValido && $tipoValido && $emailValido && $telefoneValido && $enderecoValido && $bairroValido && $numeroValido && $estadoValido && $cidadeValido && $nomefantasiaValido && $cepValido) {

//         // Atribui valor das Variáveis
//         $nome = $_POST['nome']; //REQUIRED
//         $nomefantasia = $_POST['nomefantasia']; //REQUIRED
//         $cnpj = $_POST['cnpj']; //REQUIRED
//         $tipo = $_POST['tipo']; //REQUIRED
//         $email = $_POST['email']; //REQUIRED
//         $quant_colab = $_POST['quant_colab'];
//         $contato = $_POST['contato'];
//         $telefone = $_POST['telefone']; //REQUIRED
//         $resp_financeiro = $_POST['resp_financeiro'];
//         $email_financeiro = $_POST['email_financeiro'];

//         $endereco = $_POST['endereco']; //REQUIRED
//         $bairro = $_POST['bairro']; //REQUIRED
//         $numero = $_POST['numero']; //REQUIRED
//         $complemento = $_POST['complemento'];
//         $estado = $_POST['estado']; //REQUIRED
//         $cidade = $_POST['cidade']; //REQUIRED
//         $cep = $_POST['cep']; //REQUIRED

//         // Formata as variáveis
//         $nome = formatarValor("UPPER", $nome);
//         $nomefantasia = formatarValor("UPPER", $nomefantasia);
//         $cnpj = $cnpj;
//         $tipo = $tipo;
//         $email = formatarValor("LOWER", $email);
//         $quant_colab = formatarValor("*", $quant_colab);
//         $contato = formatarValor("*", $contato);
//         $telefone = formatarValor("NUM", $telefone);
//         $resp_financeiro = formatarValor("*", $resp_financeiro);
//         $email_financeiro = formatarValor("*", $email_financeiro);

//         $endereco = formatarValor("UPPER", $endereco);
//         $bairro = formatarValor("UPPER", $bairro);
//         $numero = $numero;
//         $complemento = formatarValor("*", $complemento);
//         $estado = $estado;
//         $cidade = $cidade;
//         $cep = formatarValor("NUM", $cep);

//         // Caso as váriaveis forem diferentes de NULL
//         if (!empty($quant_colab)) {

//             $quant_colab = formatarValor("NUM", $quant_colab);
//         } else {

//             $quant_colab = 0;
//         }

//         if (!empty($resp_financeiro)) {

//             $resp_financeiro = formatarValor("UPPER", $resp_financeiro);
//         } else {
//             $resp_financeiro = NULL;
//         }

//         if (!empty($email_financeiro)) {

//             $email_financeiro = formatarValor("LOWER", $email_financeiro);
//         } else {
//             $resp_financeiro = NULL;
//         }

//         if (!empty($complemento)) {

//             $complemento = formatarValor("UPPER", $complemento);
//         } else {
//             $resp_financeiro = NULL;
//         }

//         if (empty($contato)) {
//             $contato = NULL;
//         }

//         // Atribuição de informação de importação
//         $id_per_imp = 1;
//         $id_per_ace = 1;

//         // // Situac da empresa após o Update
//         // $situac = 1;

//         // ID_EMP atribuido da sessão
//         $id_emp = $_SESSION["id_emp_aprovacao"];

//         // Verifica se já existe o CNPJ cadastrado na base
//         foreach (selectGESEMP_APROVACAO_cnpj($cnpj, $id_emp) as $verifica_emp) {
//             if (!empty($verifica_emp)) {
//                 $count_emp = $verifica_emp["contagem"];
//             }
//         }

//         // Verifica se já existe o E-MAIL cadastrado na base
//         foreach (selectGESEMP_APROVACAO_email($email, $id_emp) as $verifica_email) {
//             if (!empty($verifica_email)) {
//                 $count_email = $verifica_email["contagem"];
//             }
//         }

//         // Caso ambas as informações não existirem na base, o update é realizado
//         if ((empty($count_emp)) and (empty($count_email))) {

//             // Update da GESEMP 
//             updateGESEMP_APROVACAO($nome, $nomefantasia, $cnpj, $tipo, $email, $quant_colab, $contato, $telefone, $resp_financeiro, $email_financeiro, $endereco, $bairro, $numero, $complemento, $cidade, $cep, $datatu, $id_per_imp, $id_per_ace, $id_mas_default, $id_emp);

//             // Retorno de sucesso
//             $retorno = 1;
//             echo json_encode($retorno);
//         } else {

//             if (!empty($count_emp)) {

//                 // Retorno que existe o CNPJ cadastrado na base
//                 $retorno = 5;
//                 echo json_encode($retorno);
//             } elseif (!empty($count_email)) {

//                 // Retorno que existe o E-MAIL cadastrado na base
//                 $retorno = 6;
//                 echo json_encode($retorno);
//             }
//         }
//     } else {

//         // Informações não preenchidas corretamente ou não preenchidas
//         $retorno = 0;
//         echo json_encode($retorno);
//     }
// }

// // Volta para a página de grid e limpa as variáveis postadas em sessão
// if (isset($_POST["btn_voltar"])) {

//     // Limpa a váriavel de sessão que contem o ID_EMP
//     unset($_SESSION["id_emp_aprovacao"]);
//     unset($_SESSION["filtro_analise"]);
// }

// // Remove a foto de logo da empresa
// if (isset($_POST["id_emp_foto"])) {

//     $id_emp_foto = $_POST["id_emp_foto"];

//     // Percorre as fotos do banco selecionadas por selectGESEMP_FOTO($id_emp_foto)
//     foreach (selectGESEMP_FOTO($id_emp_foto) as $foto_banco) {
//         $imagem = $foto_banco["imagem"];
//     }

//     // Verifica se a imagem não está vazia
//     if (!empty($imagem)) {
//         // Remove o arquivo correspondente à imagem
//         unlink('../../upload/empresa/' . $raiz_cnpj_aprovacao . '/' . $imagem);

//         // Atualiza o banco de dados para remover a referência à imagem
//         updateGESEMP_FOTO(NULL, $id_emp_foto, $datatu, $id_mas_default);
//     }

//     // Retorno de sucesso
//     $retorno = 2;
//     echo json_encode($retorno);
// }

// // Realiza o update da empresa para que ela fique válida
// if (isset($_POST["btn_aprovar"])) {

//     $id_emp_aprovacao = $_POST["aprovar_id_emp"];

//     if (!empty($id_emp_aprovacao)) {

//         // Select GESEMP consultando o id_emp
//         foreach (selectGESEMP_verifica_cnpj($id_emp_aprovacao) as $verifica_cnpj) {
//             $existe_cnpj = $verifica_cnpj['count'];
//         }

//         // Se caso $existe_cnpj for igual a 0, cadastra a empresa
//         if ($existe_cnpj == 0) {

//             // Gere o token de validação
//             $token = bin2hex(random_bytes(16)); // Gera 32 caracteres hexadecimais (16 bytes)

//             // Obtenha a data e hora atual
//             $dataHora = date('YmdHis');

//             // Concatena as duas váriaveis
//             $token = $dataHora . $token;

//             // Salve o token no banco de dados ou em algum outro lugar para uso posterior

//             // // Crie a URL com o token de validação
//             // $url = "https://exemplo.com/validar_email.php?token=" . $token;

//             // Váriaveis com valor padrão
//             $situac = 1;
//             $analise = 2;
//             $situac_token = 0;

//             // Update GESEMP
//             updateGESEMP_APROVACAO_situac($situac, $analise, $datatu, $id_mas_default, $id_emp_aprovacao);

//             // Update GESUSA retornando o id_usa
//             $id_usa_update = updateGESUSA_APROVACAO_situac($situac, $analise, $token, $situac_token, $datatu, $id_mas_default, $id_emp_aprovacao);
//             $id_usa = $id_usa_update["pk"];

//             // Update GESMPR setando os menus padrão
//             updateGESMPR_menus($id_usa, $id_emp_aprovacao, $datatu);

//             // Update GESVI2
//             insertGESVI2($id_emp_aprovacao);

//             // Select GESEMP consultando o id_emp
//             foreach (buscaRaizCNPJ($id_emp_aprovacao) as $resultado_raiz) {
//                 $raiz_cnpj = $resultado_raiz['raiz_cnpj'];
//             }

//             // Cria as tabelas baseada na raiz_cnpj
//             createGESIM1($raiz_cnpj);
//             createGESREC($raiz_cnpj);
//             createGESIRR($raiz_cnpj);
//             createGESPON1($raiz_cnpj);

//             // Select GESUSA consultando o id_usa
//             foreach (selectGESUSA_token($id_usa) as $select_token) {

//                 // Atribuição das variáveis listadas do banco
//                 $nome = $select_token["nome"];
//                 $email = $select_token["email"];
//                 $token = $select_token["token"];
//             }

//             // Chama o arquivo que realiza o envio do e-mail
//             require "email_token.php";

//             // Retorno de sucesso
//             $retorno = 4;
//             echo json_encode($retorno);
//         } else {

//             // Váriaveis com valor padrão
//             $situac = 0;
//             $analise = 4;

//             // Update GESEMP
//             updateGESEMP_APROVACAO_situac($situac, $analise, $datatu, $id_mas_default, $id_emp_aprovacao);

//             // Retorno de raiz_cnpj já cadastrada na base de dados
//             $retorno = 8;
//             echo json_encode($retorno);
//         }
//     } else {

//         // Retorno váriavel não preenchida
//         $retorno = 3;
//         echo json_encode($retorno);
//     }
// }

// // Realiza o update da empresa para que ela fique válida
// if (isset($_POST["btn_reprovar"])) {

//     $id_emp_reprovacao = $_POST["reprovar_id_emp"];

//     if (!empty($id_emp_reprovacao)) {

//         // Váriaveis com valor padrão
//         $situac = 0;
//         $analise = 3;

//         updateGESEMP_REPROVACAO_situac($situac, $analise, $datatu, $id_mas_default, $id_emp_reprovacao);

//         updateGESUSA_REPROVACAO_situac($situac, $analise, $datatu, $id_mas_default, $id_emp_reprovacao);

//         // Retorno de sucesso
//         $retorno = 7;
//         echo json_encode($retorno);
//     } else {

//         // Retorno váriavel não preenchida
//         $retorno = 3;
//         echo json_encode($retorno);
//     }
// }

// /**
//  * Filtros 
//  */
// // Realiza o filtro e atribui as variáveis postadas em sessão
// if ((isset($_POST["btn_filtrar"])) && (isset($_POST["filtro_analise"]))) {

//     // Atribui a váriavel de sessão que contem o filtro
//     $_SESSION["filtro_analise"] = $_POST["filtro_analise"];
// }
