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

// Click Botão Salvar
if (isset($_POST['btn_salvar'])) {

    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_update'], '/(\d{3}\.){2}\d{3}\-\d{2}/');
    $emailValido = validarValor('REGEX_REQUIRED', $_POST['email_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $telefoneValido = validarValor('*', $_POST['telefone_update'], 15);
    $enderecoValido = validarValor('*', $_POST['endereco_update'], 3);
    $bairroValido = validarValor('*', $_POST['bairro_update'], 3);
    $cidadeValido = validarValor('VALID', $_POST['cidade_update'], 1);

    /*
    // Exibe Variáveis de Validação
    echo 'Nome Valido: ' . $nomeValido . '<br>';
    echo 'CPF Valido: ' . $cpfValido . '<br>';
    echo 'Email Valido: ' . $emailValido . '<br>';
    echo 'Telefone Valido: ' . $telefoneValido . '<br>';
    echo 'Endereço Valido: ' . $enderecoValido . '<br>';
    echo 'Bairro Valido: ' . $bairroValido . '<br>';
    echo 'Cidade Valido: ' . $cidadeValido . '<br>';
    */

    if ($nomeValido && $cpfValido && $emailValido && $telefoneValido && $enderecoValido && $bairroValido && $cidadeValido) {

        try {

            // Atribui valor das Variáveis
            $nome_update = $_POST['nome_update'];
            $cpf_update = $_POST['cpf_update'];
            $email_update = $_POST['email_update'];
            $telefone_update = $_POST['telefone_update'];
            $tus_update = $_POST['tus_update'];
            $endereco_update = $_POST['endereco_update'];
            $bairro_update = $_POST['bairro_update'];
            $complemento_update = $_POST['complemento_update'];
            $numero_update = $_POST['numero_update'];
            $cidade_update = $_POST['cidade_update'];
            $cep_update = $_POST['cep_update'];

            $hash = 123;
            $situac = 1;
            $id_emp_acess = 0;
            $id_dep = 0;


            // Formata as variáveis
            $nome = formatarValor('UPPER', $nome_update);
            $cpf = formatarValor('NUM', $cpf_update);
            $email = formatarValor('LOWER', $email_update);
            $telefone = formatarValor('NUM', $telefone_update);
            $id_tus = formatarValor('*', $tus_update);
            $endereco = formatarValor('UPPER', $endereco_update);
            $bairro = formatarValor('UPPER', $bairro_update);
            $complemento = formatarValor('UPPER', $complemento_update);
            $numero = formatarValor('UPPER', $numero_update);
            $cidade = formatarValor('*', $cidade_update);
            $cep = formatarValor('NUM', $cep_update);
            $senha = formatarValor('PASSWORD', $hash);
            $id_per = formatarValor('TUS', $tus_update);


            /* 
            // Exibe as Variáveis
            echo "Nome: " . $nome . "<br>";
            echo "Cpf: " . $cpf . "<br>";
            echo "Senha: " . $senha . "<br>";
            echo "Datinc: " . $datinc . "<br>";
            echo "ID Emp Acess: " . $id_emp_acess . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Situac: " . $situac . "<br>";
            echo "ID Per: " . $id_per . "<br>";
            echo "Cidade: " . $cidade . "<br>";
            echo "Telefone: " . $telefone . "<br>";
            echo "Id Dep: " . $id_dep . "<br>";
            echo "Datatu: " . $datatu . "<br>";
            echo "ID Master: " . $id_mas_default . "<br>";
            echo "ID Tus: " . $id_tus . "<br>";
            echo "Endereco: " . $endereco . "<br>";
            echo "Complemento: " . $complemento . "<br>";
            echo "Bairro: " . $bairro . "<br>";
            echo "Numero: " . $numero . "<br>";
            echo "Cep: " . $cep . "<br>";
            */

            // Executa o INSERT no Banco - Tabela GESUSA
            $insert_GESUSA = insertGESUSA_RETID(
                $nome,
                $cpf,
                $senha,
                $datinc,
                $id_emp_acess,
                $email,
                $situac,
                $id_per,
                $cidade,
                $telefone,
                $id_dep,
                $datatu,
                $id_mas_default,
                $id_tus,
                $endereco,
                $complemento,
                $bairro,
                $numero,
                $cep
            );

            $_SESSION['editar_id_usa'] = $insert_GESUSA['pk'];

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
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

            // Valida se o valor combina com o parametro (regex) ou se está vazio
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

        case 'SITUAC':
            if ($valor == 1) {

                return 0;
            } else {

                return 1;
            }
            break;

        case 'PASSWORD':
            return password_hash($valor, PASSWORD_DEFAULT);
            break;

        case 'TUS':
            if ($valor == 2) {

                return 1;
            } else if ($valor == 3) {

                return 2;
            }
            break;

        default:
            if (!empty($valor) or $valor == 0) {

                return $valor;
            } else {

                return NULL;
            }
            break;
    }
}
