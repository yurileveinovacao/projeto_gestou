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

// Cadastra um novo contato
if (isset($_POST['btn_submit'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);
    $descricaoValido = validarValor('VALID', $_POST['descricao_update'], 3);
    $tel1Valido = validarValor('*', $_POST['tel1_update'], 1);
    $tel2Valido = validarValor('*', $_POST['tel2_update'], 1);
    $tel3Valido = validarValor('*', $_POST['tel3_update'], 1);
    $emailValido = validarValor('REGEX', $_POST['email_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $websiteValido = validarValor('*', $_POST['website_update'], 3);


    // Se os valores forem validados continua com o update
    if ($nomeValido && $descricaoValido && $tel1Valido && $tel2Valido && $tel3Valido && $emailValido && $websiteValido) {

        try {

            // Atribui valor das Variáveis
            $nome_update = $_POST['nome_update'];
            $descricao_update = $_POST['descricao_update'];
            $tel1_update = $_POST['tel1_update'];
            $tel2_update = $_POST['tel2_update'];
            $tel3_update = $_POST['tel3_update'];
            $email_update = $_POST['email_update'];
            $website = $_POST['website_update'];

            $situac = 1;

            // Formata as variáveis
            $nome = formatarValor('UPPER', $nome_update);
            $descricao = formatarValor('UPPER', $descricao_update);
            $tel1 = formatarValor('NUM', $tel1_update);
            $tel2 = formatarValor('NUM', $tel2_update);
            $tel3 = formatarValor('NUM', $tel3_update);
            $email = formatarValor('LOWER', $email_update);

            
            /*
            // Retorna as Variáveis
            echo 'Nome: ' . $nome;
            echo '            ';
            echo 'Descricao: ' . $descricao;
            echo '            ';
            echo 'Telefone 1: ' . $tel1;
            echo '            ';
            echo 'Telefone 2: ' . $tel2;
            echo '            ';
            echo 'Telefone 3: ' . $tel3;
            echo '            ';
            echo 'E-mail: ' . $email;
            echo '            ';
            echo 'Website: ' . $website;
            echo '            ';
            echo 'Datinc: ' . $datinc;
            echo '            ';
            echo 'Datatu: ' . $datatu;
            echo '            ';
            echo 'Situac: ' . $situac;
            echo '            ';
            echo 'Id Emp Default: ' . $id_emp_default;
            echo '            ';
            echo 'Id Usa Default: ' . $id_usa_default;
            echo '            ';
            */

            // Executa o insert no banco
            insertGESCTO(
                $nome,
                $descricao,
                $tel1,
                $tel2,
                $tel3,
                $email,
                $website,
                $datinc,
                $datatu,
                $situac,
                $id_emp_default,
                $id_usa_default,
                $id_usa_default
            );

            // Valida o Insert
            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        // Erro no insert devido a campo preenchido incorretamente
        echo 0;
    }
}

// Muda a situação do contato (Ativo/Inativo)
if (isset($_POST['id_cto'])) {

    try {

        $id_cto = $_POST['id_cto'];
        $situac = $_POST['situac_cto'];

        if ($situac == 1) {

            $situac_update = 0;
        } else if ($situac == 0) {

            $situac_update = 1;
        }

        updateGESCTO_situac($id_cto, $situac_update, $datatu, $id_usa_default);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Exclui os contatos selecionados
if (isset($_POST['btn_exc']) and !empty($_POST['ids'])) {

    try {

        $ids = $_POST['ids'];

        deleteGESCTO_in($ids);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// POST REALIZADO E ATRIBUIÇÃO DE VARIÁVEIS
if (isset($_POST["editar_id_cto"])) {

    // VÁRIAVEL PARA LISTAR OS DADOS DO CLIENTE NA PÁGINA VISUALIZAR CLIENTES
    $_SESSION["editar_id_cto"] = $_POST["editar_id_cto"];
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

// Formatar valor da Variaveis
function formatarValor($case, $valor)
{

    switch ($case) {

        case 'UPPER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtoupper($valor, 'UTF-8');
            }
            break;

        case 'LOWER':
            if (empty($valor)) {

                return NULL;
            } else {

                return mb_strtolower($valor, 'UTF-8');
            }
            break;

        case 'NUM':
            if (empty($valor)) {

                return NULL;
            } else {

                return preg_replace('/\D+/', '', $valor);
            }
            break;

        default:
            if (empty($valor) or $valor == 0) {

                return NULL;
            }
            break;
    }
}
