<?php

//Faz a requisição da Sessão

use function PHPSTORM_META\map;

require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";


/**
 * 
 * Funções no Click
 * 
 */
// VOLTAR PARA LANÇAMENTOS
if (isset($_POST['btn_voltar'])) {

    if (isset($_SESSION['id_lcm_anexo'])) {

        unset($_SESSION['id_lcm_anexo']);
    }
}

if (isset($_POST['btn_submit'])) {

    // Verifica se o anexo é válido
    $anexoValido = validarValor('VALID', $_FILES['file']['size'], 1);

    if ($anexoValido) {

        try {
            // Obtém informações sobre o anexo
            $anexo_size = $_FILES['file']['size'];
            $anexo_nome = $_FILES['file']['name'];
            $anexo_temp = $_FILES['file']['tmp_name'];
            $anexo_tipo = $_FILES['file']['type'];
            $anexo_erro = $_FILES['file']['error'];
            $id_lcm = $_SESSION['id_lcm_anexo'];

            // Verifica o tamanho máximo do anexo
            if ($anexo_size > 100000000) {
                mensagem_retorno(2);
                exit;
            }

            // Obtém o valor máximo de um determinado campo
            foreach (selectGESANE_max() as $linha2) {
                $max_id = $linha2['num_id'];
            }

            // Se o valor máximo não existe, define como 1
            if (empty($max_id)) {

                $max_id = 1;
            } else {

                $max_id += 1;
            }

            // Formata o nome do anexo para letras minúsculas
            $anexo_nome = formatarValor('LOWER', $anexo_nome);

            // Cria um novo nome para o anexo usando o valor máximo e o nome original
            $anexo_nomeNovo = $max_id . '_' . $anexo_nome;

            // Obtém o nome do CNPJ formatado como número
            $nomeCNPJ = formatarValor('NUM', $_SESSION['cnpj_completo']);

            // Obtém o nome do CPF formatado como número para cada colaborador
            foreach (selectGESLCM_colab($id_lcm) as $linha) {

                $nomeCPF = formatarValor('NUM', $linha['cpf']);
            }

            // Define o diretório onde o arquivo será armazenado
            $diretorio = '../../upload/' . $nomeCNPJ . '/painel_rh/cursos_exames/' . $nomeCPF;

            // Cria o diretório se ele não existir
            if (!file_exists($diretorio)) {

                mkdir($diretorio, 0755, true);
            }

            // Define o caminho completo do arquivo
            $caminho = $diretorio . '/';

            // Move o arquivo enviado para o diretório especificado
            $mover = move_uploaded_file($anexo_temp, $caminho . $anexo_nomeNovo);

            // Insere informações sobre o anexo no banco de dados
            insertGESANE(
                $anexo_nomeNovo,
                $datinc,
                $id_usa_default,
                $datatu,
                $id_usa_default,
                $caminho,
                $id_lcm
            );

            mensagem_retorno(1);
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        mensagem_retorno(0);
    }
}

// Verifica se o botão 'btn_visualizar' foi acionado no formulário
if (isset($_POST['btn_visualizar'])) {

    try {

        // Obtém o valor do campo 'id_ane' enviado via POST
        $id_ane = $_POST['id_ane'];

        // Itera sobre o resultado da função 'selectGESANE_id' com base no valor de 'id_ane'
        foreach (selectGESANE_id($id_ane) as $linha) {

            $nomePDF = $linha['anexo']; // Obtém o valor do campo 'anexo' do resultado da consulta
            $caminho = $linha['caminho']; // Obtém o valor do campo 'caminho' do resultado da consulta
        }

        // Concatena o caminho e o nome do PDF
        $retorno = $caminho . $nomePDF;

        // Chama a função 'mensagem_retorno' passando o valor concatenado como parâmetro
        mensagem_retorno($retorno);
    } catch (PDOException $erro) {

        // Em caso de erro, exibe a mensagem de exceção
        echo $erro->getMessage();
    }
}


// Verifica se o botão de exclusão foi acionado
if (isset($_POST['btn_excluir'])) {

    try {

        // Obtém os IDs dos itens selecionados a serem excluídos
        $ids_ane = $_POST['selecionados'];

        // Verifica se o array $ids_ane não está vazio
        if (!empty($ids_ane)) {

            // Itera sobre cada ID selecionado
            foreach ($ids_ane as $value) {

                // Obtém os dados do anexo correspondente ao ID
                foreach (selectGESANE_id($value) as $linha) {

                    $anexo_banco = $linha['anexo'];
                    $caminho_banco = $linha['caminho'];
                    $id_lcm_banco = $linha['id_lcm'];
                }

                // Obtém o CNPJ formatado a partir da sessão atual
                $nomeCNPJ = formatarValor('NUM', $_SESSION['cnpj_completo']);

                // Obtém o CPF formatado do colaborador relacionado ao anexo
                foreach (selectGESLCM_colab($id_lcm_banco) as $linha) {

                    $nomeCPF = formatarValor('NUM', $linha['cpf']);
                }

                // Define o diretório de destino para mover o anexo excluído
                $diretorio = '../../upload/' . $nomeCNPJ . '/painel_rh/cursos_exames/' . $nomeCPF . '/lixeira';

                // Verifica se o diretório de destino não existe e cria-o
                if (!file_exists($diretorio)) {

                    mkdir($diretorio, 0755, true);
                }

                $novo_caminho = $diretorio . '/';

                // Define o caminho de origem e destino do arquivo a ser movido
                $origem = $caminho_banco . $anexo_banco;
                $destino = $novo_caminho . $anexo_banco;

                // Move o arquivo para o diretório de destino
                rename($origem, $destino);

                updateGESANE_excluir($value, $novo_caminho);
            }

            // Exibe uma mensagem de retorno indicando o sucesso da exclusão
            mensagem_retorno(1);
        } else {

            // Exibe uma mensagem de retorno indicando que nenhum item foi selecionado para exclusão
            mensagem_retorno(0);
        }
    } catch (PDOException $erro) {

        // Captura e exibe qualquer exceção do tipo PDOException ocorrida durante a execução do código
        echo $erro->getMessage();
    }
}



/**
 * 
 * Funções
 * 
 */
// FUNÇÃO DE MENSAGEM
function mensagem_retorno($mensagem)
{

    echo $mensagem;

    /**
     * LEGENDA
     * 
     * 0 = Anexo não preenchido
     * 1 = Sucesso
     * 2 = Anexo maior que o limite permitido
     * 
     */
}
