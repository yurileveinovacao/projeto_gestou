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

// AÇÃO NO BOTÃO INCLUIR EMPRESA
if (isset($_POST["btn_inc"])) {

    $id_empValido = validarValor('REGEX', $_POST['id_emp'], '/\D/');

    if (!$id_empValido) {

        try {

            // Atribui valor das Variáveis
            $id_emp = $_POST['id_emp'];
            $id_usa = $_SESSION['editar_id_usa'];
            $_SESSION['tab'] = 1;

            /*
            // Exibe as Variáveis
            echo 'ID Emp: ' . $id_emp . '<br>';
            echo 'ID Usa: ' . $id_usa . '<br>';
            */

            // Executa os combandos no Banco
            // INSERT Tabela GESVIN
            insertGESVIN_usuario($id_emp, $id_usa);
            // UPDATE Tabela GESUSA
            updateGESUSA_id_emp_acess($id_usa, $id_emp);
            // Popula GESMPR com menus padrão liberados para a empresa recém-vinculada
            bootstrapGESMPR_empresa($id_usa, $id_emp, $datatu);

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// AÇÃO NO BOTÃO INCLUIR TODAS AS EMPRESA
if (isset($_POST["btn_inc_all"])) {

    $id_empValido = validarValor('VALID', $_POST['id_emp_validador'], 1);

    if ($id_empValido) {

        try {

            $id_usa = $_SESSION['editar_id_usa'];
            $_SESSION['tab'] = 1;

            foreach (selectGESEMP_emp_disponiveis($id_usa) as $linha) {

                $id_emp = $linha['id_emp'];

                if (!empty($id_emp)) {

                    insertGESVIN_usuario($id_emp, $id_usa);
                    bootstrapGESMPR_empresa($id_usa, $id_emp, $datatu);
                }
            }

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// AÇÃO NO BOTÃO EXCLUIR EMPRESA
if (isset($_POST['btn_exc'])) {

    $id_empValido = validarValor('REGEX_REQUIRED', $_POST['id_emp'], '/\D/');

    if ($id_empValido) {

        try {

            // Atribui valor as Variáveis
            $id_emp_update = $_POST['id_emp'];
            $id_usa = $_SESSION['editar_id_usa'];
            $_SESSION['tab'] = 1;

            // Formata as Variaveis
            $id_emp = formatarValor('NUM', $id_emp_update);

            /*
            // Exibe as variaveis
            echo 'ID Emp: ' . $id_emp . '<br>';
            echo 'ID Emp Update: ' . $id_emp_update . '<br>';
            echo 'ID usa: ' . $id_usa . '<br>';
            */

            // Executa os comandos no Banco
            // DELETE Tabela GESVIN
            deleteGESVIN_usuario($id_emp, $id_usa);

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// AÇÃO NO BOTÃO EXCLUIR TODAS AS EMPRESAS
if (isset($_POST['btn_exc_all'])) {

    $id_empValido = validarValor('VALID', $_POST['id_emp_validador'], 1);

    if ($id_empValido) {

        try {

            // Atribui valor as Variáveis
            $id_usa = $_SESSION['editar_id_usa'];
            $_SESSION['tab'] = 1;

            foreach (selectGESEMP_emp_selecionadas($id_usa) as $linha) {

                $id_emp = $linha['id_emp'];

                if (!empty($id_emp)) {

                    deleteGESVIN_usuario($id_emp, $id_usa);
                }
            }

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

//  AÇÃO NO BOTÃO ALTERAR SENHA
if (isset($_POST['btn_alterar_usuario'])) {


    $senhaValido = validarValor('COMPARE', $_POST['senha_update'], $_POST['confirm_senha_update']);
    $senhaValido2 = validarValor('VALID', $_POST['senha_update'], 3);

    if ($senhaValido && $senhaValido2) {

        try {

            // Atribui valor das Variáveis
            $senha_update = $_POST['senha_update'];
            $id_usa = $_SESSION['editar_id_usa'];
            $situac_senha = 1;

            // Formata as variáveis
            $senha = formatarValor('PASSWORD', $senha_update);

            /*
            // Exibe as Variáveis
            echo 'Senha: ' . $senha_update . '<br>';
            echo 'Senha Hash: ' . $senha . '<br>';
            echo 'Situação Senha: ' . $situac_senha . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Master: ' . $id_mas_default . '<br>';
            echo 'ID Usa: ' . $id_usa . '<br>';
            */

            // Executa os comandos no Banco
            // UPDATE Tabela GESUSA
            troca_senha_GESUSA($senha, $situac_senha, $datatu, $id_mas_default, $id_usa);

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}


// AÇÃO NO BOTÃO VOLTAR
if (isset($_POST['btn_voltar'])) {

    // Apaga a variável para listar os dados do usuário na pagina alterar_usuario.php
    unset($_SESSION['editar_id_usa']);
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

        case 'COMPARE':
            if ($valor === $parametro) {

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
