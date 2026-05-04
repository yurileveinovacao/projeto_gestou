<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";


/**
 * 
 * Funções no Click
 * 
 */

// Função no botão SALVAR
if (isset($_POST['btn_submit'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_update'], 5);
    $nomeFantasiaValido = validarValor('VALID', $_POST['nomefantasia_update'], 5);
    $emailValido = validarValor('REGEX', $_POST['email_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $respFinanceiroValido = validarValor('*', $_POST['resp_financeiro_update'], 3);
    $emailFinanceiroValido = validarValor('REGEX', $_POST['email_financeiro_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $respRhValido = validarValor('VALID', $_POST['resp_rh_update'], 1);
    $respOuvidoriaValido = validarValor('VALID', $_POST['resp_ouvidoria_update'], 1);
    $cidadeValida = validarValor('VALID', $_POST['cidade_update'], 1);
    $cepValido = validarValor('VALID', $_POST['cep_update'], 1);

    /*
    // Exibi as variáveis de validação
    echo 'nomeValido' . $nomeValido . '<br>';
    echo 'nomeFantasiaValido' . $nomeFantasiaValido . '<br>';
    echo 'emailValido' . $emailValido . '<br>';
    echo 'respFinanceiroValido' . $respFinanceiroValido . '<br>';
    echo 'emailFinanceiroValido' . $emailFinanceiroValido . '<br>';
    echo 'respRhValido' . $respRhValido . '<br>';
    echo 'respOuvidoriaValido' . $respOuvidoriaValido . '<br>';
    echo 'cidadeValida' . $cidadeValida . '<br>';
    echo 'cepValido' . $cepValido . '<br>';
    */

    // Se os valores forem validados continua com o update
    if ($nomeValido && $nomeFantasiaValido && $emailValido && $respFinanceiroValido && $emailFinanceiroValido && $respRhValido && $respOuvidoriaValido && $cidadeValida && $cepValido) {

        try {

            // Atribui valor das Variáveis
            $nome_update = $_POST['nome_update']; //REQUIRED
            $nomefantasia_update = $_POST['nomefantasia_update']; //REQUIRED
            $email_update = $_POST['email_update'];
            $contato_update = $_POST['contato_update'];
            $telefone_update = $_POST['telefone_update'];
            $resp_financeiro_update = $_POST['resp_financeiro_update'];
            $email_financeiro_update = $_POST['email_financeiro_update'];
            $resp_rh_update = $_POST['resp_rh_update']; //REQUIRED
            $resp_ouvidoria_update = $_POST['resp_ouvidoria_update']; //REQUIRED
            $validacao_gestor_update = $_POST['validacao_gestor_update'];
            $endereco_update = $_POST['endereco_update'];
            $bairro_update = $_POST['bairro_update'];
            $numero_update = $_POST['numero_update'];
            $complemento_update = $_POST['complemento_update'];
            $cidade_update = $_POST['cidade_update']; //REQUIRED
            $cep_update = $_POST['cep_update']; //REQUIRED

            // FEA-002/003: período de experiência personalizado por empresa
            $dias_exp_1_update = isset($_POST['dias_exp_1_update']) ? intval($_POST['dias_exp_1_update']) : 45;
            $dias_exp_2_update = isset($_POST['dias_exp_2_update']) ? intval($_POST['dias_exp_2_update']) : 90;
            // Sanitização: 1 <= dias_exp_1 <= dias_exp_2 <= 90
            if ($dias_exp_1_update < 1 || $dias_exp_1_update > 90) { $dias_exp_1_update = 45; }
            if ($dias_exp_2_update < 1 || $dias_exp_2_update > 90) { $dias_exp_2_update = 90; }
            if ($dias_exp_2_update < $dias_exp_1_update) { $dias_exp_2_update = $dias_exp_1_update; }

            // Formata as variáveis
            $nome = formatarValor('UPPER', $nome_update);
            $nomefantasia = formatarValor('UPPER', $nomefantasia_update);
            $email = formatarValor('LOWER', $email_update);
            $contato = formatarValor('UPPER', $contato_update);
            $telefone = formatarValor('NUM', $telefone_update);
            $resp_financeiro = formatarValor('UPPER', $resp_financeiro_update);
            $email_financeiro = formatarValor('LOWER', $email_financeiro_update);
            $resp_rh = formatarValor('*', $resp_rh_update);
            $resp_ouvidoria = formatarValor('*', $resp_ouvidoria_update);
            $validacao_gestor = formatarValor('CHECKBOX', $validacao_gestor_update);
            $endereco = formatarValor('UPPER', $endereco_update);
            $bairro = formatarValor('UPPER', $bairro_update);
            $numero = formatarValor('UPPER', $numero_update);
            $complemento = formatarValor('UPPER', $complemento_update);
            $cidade = $cidade_update;
            $cep = formatarValor('NUM', $cep_update);

            /*
            // Retorna as Variáveis
            echo 'Nome: ' . $nome . '<br>';
            echo 'Nome Fantasia: ' . $nomefantasia . '<br>';
            echo 'E-mail: ' . $email . '<br>';
            echo 'Contato: ' . $contato . '<br>';
            echo 'Telefone: ' . $telefone . '<br>';
            echo 'Resp. Financeiro: ' . $resp_financeiro . '<br>';
            echo 'Email Financeiro: ' . $email_financeiro . '<br>';
            echo 'Resp. RH: ' . $resp_rh . '<br>';
            echo 'Resp. Ouvidoria: ' . $resp_ouvidoria . '<br>';
            echo 'Validação Gestor: ' . $validacao_gestor . '<br>';
            echo 'Endereço: ' . $endereco . '<br>';
            echo 'Bairro: ' . $bairro . '<br>';
            echo 'Numero: ' . $numero . '<br>';
            echo 'Complemento: ' . $complemento . '<br>';
            echo 'Cidade: ' . $cidade . '<br>';
            echo 'CEP: ' . $cep . '<br>';
            echo 'Data Atualização: ' . $datatu . '<br>';
            echo 'ID Usa Atualização: ' . $id_usa_default . '<br>';
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            */

            updateGESEMP_CAMPOS(
                $nome,
                $endereco,
                $email,
                $numero,
                $bairro,
                $cep,
                $complemento,
                $cidade,
                $telefone,
                $contato,
                $validacao_gestor,
                $nomefantasia,
                $resp_financeiro,
                $email_financeiro,
                $resp_rh,
                $resp_ouvidoria,
                $datatu,
                $id_usa_default,
                $id_emp_default,
                $dias_exp_1_update,
                $dias_exp_2_update
            );

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// Atribui 1 Usuário como GESTOR
if (isset($_POST["btn_inc"])) {

    try {

        $id_usa = $_POST["btn_inc"];
        $gestor = 1;
        $_SESSION['tab'] = 4;

        if (selectGESGES($id_usa, $id_emp_default) == 0) {

            insertGESGES($id_usa, $id_emp_default, $gestor);
        } else {

            updateGESGES($id_usa, $id_emp_default, $gestor);
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Remove 1 usuario de GESTOR
if (isset($_POST["btn_exc"])) {

    try {

        $id_usa = $_POST["btn_exc"];
        $gestor = 0;
        $_SESSION['tab'] = 4;

        $id_usa = preg_replace('/\D+/', '', $id_usa);

        updateGESGES($id_usa, $id_emp_default, $gestor);
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Remove a foto de logo da empresa
if (isset($_POST["id_emp_foto"])) {

    $id_emp_foto = $_POST["id_emp_foto"];

    foreach (selectGESEMP_FOTO($id_emp_foto) as $foto_banco) {

        $imagem = $foto_banco["imagem"];
    }

    if (!empty($imagem)) {

        unlink('../upload/empresa/' . $imagem . '');

        updateGESEMP_FOTO(NULL, $id_emp_foto, $datatu, $id_usa_default);
    }
}

/**
 * 
 * FUNCTIONS
 * 
 */

function validarValor($case, $valor, $parametro)
{

    switch ($case) {

            // Valida se o valor preenche o requisito minimo de caracteres
        case 'VALID':
            if (!empty($valor)) {
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

// Formatar valor das Variaveis
function formatarValor($case, $valor)
{

    switch ($case) {

            // Formatação caracteres maiusculos
        case 'UPPER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtoupper($valor, 'UTF-8');
            }
            break;

            // Formatação caracteres minusculos
        case 'LOWER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtolower($valor, 'UTF-8');
            }
            break;

            // Formatação somente numeros
        case 'NUM':
            if (empty($valor)) {

                return NULL;
            } else {

                return preg_replace('/\D+/', '', $valor);
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

            // Formatação padrao post
        default:
            if (empty($valor) or $valor == 0) {

                return NULL;
            } else {

                return $valor;
            }
            break;
    }
}
