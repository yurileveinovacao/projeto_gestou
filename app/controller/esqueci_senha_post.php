<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_app.php";

/**
 * 
 * Funções no Click
 * 
 */
if (isset($_POST['btn_submit'])) {

    // Validação do CPF
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_update'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');

    if ($cpfValido) {

        $cpf = formatarValor('NUM', $_POST['cpf_update']);

        // echo $cpf;

        // Busca o usuário pelo CPF
        foreach (consulta_cpf($cpf) as $usuario) {

            // echo $usuario;

            switch ($usuario) {

                case null:
                    // Usuário não encontrado
                    apresentar_mensagem(2);
                    break;

                case empty($usuario['email']):
                    // Usuário sem email
                    foreach (select_GESEMP_cpf($cpf) as $email_cpf) {

                        $nome_resp_rh = $email_cpf["nome"];

                        if (empty($email_cpf["email"])) {

                            $email_resp_rh = getenv('SMTP_FROM') ?: 'contato@leveinovacao.com.br';
                        } else {
                            $email_resp_rh = $email_cpf["email"];
                        }
                    }

                    enviar_email_empresa($email_resp_rh, $nome_resp_rh, $usuario['nome'], $_POST['cpf_update']);

                    apresentar_mensagem(3);
                    break;

                default:
                    // Usuário com email
                    $codigo = gerar_codigo_senha();
                    enviar_email_recuperacao_senha($usuario['email'], $codigo, $usuario['nome']);

                    $contrasenha = password_hash($codigo, PASSWORD_DEFAULT);

                    $retorno = atualizar_senha_usuario($usuario['id_usu'], $contrasenha);

                    iniciar_sessao_recuperacao_senha($usuario['cpf']);

                    apresentar_mensagem($retorno);
                    break;
            }
        }
    } else {
        // CPF inválido
        apresentar_mensagem(0);
    }
}


/**
 * 
 * Funções
 * 
 */
function gerar_codigo_senha()
{

    $digitosPermitidos = '1234567890';
    $qtdeDigitos = strlen($digitosPermitidos);
    $codigo = '';

    // Gera um código de 6 dígitos para recuperação de senha
    for ($i = 0; $i < 6; $i++) {
        $posicaoAleatoria = rand(0, $qtdeDigitos - 1);
        $digitoAleatorio = substr($digitosPermitidos, $posicaoAleatoria, 1);
        $codigo .= $digitoAleatorio;
    }

    return $codigo;
}

function enviar_email_recuperacao_senha($email, $codigo, $nome)
{
    // Envia um email de recuperação de senha para o usuário
    require "../esqueci_email.php";
}

function enviar_email_empresa($email_resp_rh, $nome_resp_rh, $nome, $cpf)
{
    // Envia um email de recuperação de senha para o usuário
    require "../esqueci_email_empresa.php";
}

function atualizar_senha_usuario($id_usu, $codigo)
{
    // Atualiza a senha do usuário com o código de recuperação de senha
    try {

        update_contrasenha_GESUSU($id_usu, $codigo);

        return 1;
    } catch (PDOException $erro) {

        return $erro->getMessage();
    }
}

function iniciar_sessao_recuperacao_senha($cpf)
{
    // Inicia a sessão para recuperação de senha
    global $pdo;
    session_name("troca_senha");
    require_once __DIR__."/../../config/session.php"; session_start();

    $_SESSION["troca_senha_cpf"] = $cpf;
}

function apresentar_mensagem($codigo)
{
    // Apresenta uma mensagem na tela de acordo com o código recebido
    // 0 = CPF inválido
    // 1 = Senha enviada por email
    // 2 = Usuário não encontrado
    // 3 = E-mail não cadastrado

    echo $codigo;
}


//  Valida o valor
function validarValor($case, $valor, $parametro)
{

    switch ($case) {

            // Valida se o valor preenche o requisito minimo de caracteres
        case 'VALID':
            if (!empty(trim($valor))) {
                return strlen($valor) >= $parametro;
            }
            break;

            // Valida se o valor combina com o parametro (regex)
        case 'REGEX':
            if (!empty($valor)) {

                return preg_match($parametro, $valor);
            } else {

                return true;
            }
            break;

            // Valida se o valor combina com o parametro (regex)
        case 'REGEX_REQUIRED':
            if (!empty($valor)) {

                return preg_match($parametro, $valor);
            }
            break;

            // Valida se o valor não estiver vazio ou for igual a 0
        case 'REQUIRED':
            if (!empty($valor) or $valor == 0) {

                return true;
            }
            break;

            // Valida se Valor é igual Parametro
        case 'COMPARAR_DATA':

            $valorFormat = formatarValor('DATE', $valor);
            $parametroFormat = formatarValor('DATE', $parametro);

            if (strtotime($valorFormat) >= strtotime($parametroFormat)) {

                return true;
            }
            break;

            // Valida se o campo preencher os requisitos minimo de caracteres ou se estiver vazio
        default:
            if (!empty($valor)) {

                return strlen($valor) >= $parametro;
            } else {

                return true;
            }
            break;
    }
}


// Formata o valor 
function formatarValor($campo, $valor)
{

    // Case verificando o valor do campo da Função
    switch ($campo) {

            // Formatação somente numeros
        case "NUM";

            if (!empty($valor)) {

                return preg_replace('/\D+/', '', $valor);
            } else {

                return NULL;
            }

            break;

            // Formatação data padrao Banco de dados
        case "DATE";

            if (!empty($valor)) {

                return implode('-', array_reverse(explode('/', $valor)));
            } else {

                return NULL;
            }

            break;

            // Formatação caracteres maiusculos
        case "UPPER";

            if (!empty($valor)) {

                return mb_strtoupper($valor, 'UTF-8');
            } else {

                return NULL;
            }

            break;

            // Formatação caracteres minusculos
        case "LOWER";

            if (!empty($valor)) {

                return mb_strtolower($valor, 'UTF-8');
            } else {

                return NULL;
            }

            break;

            // Formatação checkbox não preenchido
        case "CHECKBOX";

            if ($valor == "false") {

                return 0;
            } else {

                return 1;
            }

            break;

            // Formatação situação ATIVO/INATIVO
        case 'SITUAC':
            if ($valor == 1) {

                return 0;
            } else {

                return 1;
            }
            break;

            // Formatação dinheiro
        case "VALOR_DECIMAL";

            if (!empty($valor)) {

                $valorSemMoeda = preg_replace('/[^\d\,]/', '', $valor);
                return str_replace(',', ".", $valorSemMoeda);
            } else {

                return NULL;
            }

            break;

            // Formatação padrao post
        default:

            if ((!empty($valor)) or ($valor == 0)) {

                return $valor;
            } else {

                return NULL;
            }

            break;
    }
}
