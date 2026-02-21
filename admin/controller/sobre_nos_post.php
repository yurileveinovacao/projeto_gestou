<?php

//Faz a requisição da Sessão
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

// VISUALIZAR IMAGEM
if (isset($_POST['visualizar_img'])) {

    try {

        foreach (selectGESSOB($id_emp_default) as $linha) {

            $imagem = $linha['sob_imagem'];
        }

        if (!empty($imagem)) {

            $retorno = '<img src="../upload/empresa/' . $imagem . '" style="max-height: 30vh; width: auto;" class="img-fluid">';
        } else {

            $retorno = NULL;
        }

        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Verifica se o botão de envio  de imagem foi pressionado
if (isset($_POST["btn_submit_img"])) {

    try {

        // Tamanho da imagem
        $img_size = $_FILES['file']['size'];

        // Verifica se o tamanho da imagem não está vazio
        if (!empty($img_size)) {

            // Nome original da imagem
            $img_nome = $_FILES['file']['name'];

            // Nome temporário do arquivo
            $img_temp = $_FILES['file']['tmp_name'];

            // Tipo de arquivo
            $img_tipo = $_FILES['file']['type'];

            // Código de erro, se houver
            $img_erro = $_FILES['file']['error'];

            // Extensão da imagem
            $img_ext = formatarValor('LOWER', pathinfo($img_nome, PATHINFO_EXTENSION));

            // Obtém informações do banco de dados para a empresa atual
            foreach (selectGESSOB($id_emp_default) as $linha) {

                $img_banco = $linha['sob_imagem']; // Nome da imagem armazenada no banco de dados
                $text_banco = $linha['sob_texto']; // Texto armazenado no banco de dados
            }

            // Novo nome para a imagem (com base no CNPJ e no timestamp atual)
            $img_novonome = $raiz_cnpj . "_" . time() . '_sobre.' . $img_ext;

            // Move o arquivo da imagem para o diretório de destino
            $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

            // Formata o valor do texto do banco de dados
            $text_banco = formatarValor('*', $text_banco);

            // Se houver uma imagem existente no banco de dados, ela é removida
            if (!empty($img_banco)) {

                unlink('../../upload/empresa/' . $img_banco . '');
            }

            // Se a linha do banco de dados existir, atualiza os valores
            if (!empty($linha)) {

                updateGESSOB_sobre(
                    $text_banco,
                    $img_novonome,
                    $datatu,
                    $id_usa_default,
                    $id_emp_default
                );

                // Se a linha do banco de dados não existir, insere novos valores
            } else {

                insertGESSOB(
                    $id_emp_default,
                    $text_banco,
                    $img_novonome,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    $datinc,
                    $datatu,
                    $id_usa_default,
                    $id_usa_default
                );
            }

            echo 1; // Retorna 1 para indicar sucesso na atualização
        } else {
            echo 0; // Retorna 0 se o tamanho da imagem estiver vazio
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage(); // Exibe a mensagem de erro da exceção PDO
    }
}

// Verifica se o botão de exclusão de imagem foi pressionado
if (isset($_POST['btn_exc_img'])) {

    try {

        // Obtém informações do banco de dados para a empresa atual
        foreach (selectGESSOB($id_emp_default) as $linha) {

            $img_banco = $linha['sob_imagem']; // Nome da imagem armazenada no banco de dados
            $text_banco = $linha['sob_texto']; // Texto armazenado no banco de dados
        }

        // Atualiza os valores no banco de dados, removendo a referência para a imagem
        updateGESSOB_sobre(
            $text_banco,
            NULL,
            $datatu,
            $id_usa_default,
            $id_emp_default
        );

        // Se houver uma imagem existente no banco de dados, ela é removida
        if (!empty($img_banco)) {

            unlink('../../upload/empresa/' . $img_banco . '');
        }

        echo 1; // Retorna 1 para indicar sucesso na exclusão
    } catch (PDOException $erro) {

        echo $erro->getMessage(); // Exibe a mensagem de erro da exceção PDO
    }
}

// Verifica se o botão de visualizar texto foi pressionado
if (isset($_POST['visu_texto'])) {

    // Obtém informações do banco de dados para a empresa atual
    foreach (selectGESSOB($id_emp_default) as $linha) {

        $text_banco = $linha['sob_texto']; // Texto armazenado no banco de dados
    }

    echo $text_banco; // Imprime o valor da variável $text_banco (não está definida no código fornecido)
}

// Verifica se o botão de envio do texto foi pressionado
if (isset($_POST["btn_submit_text"])) {

    try {

        // Obtém o texto a ser atualizado do formulário
        $texto_update = trim($_POST['texto_update']);

        // Remover as tags HTML
        $textoSemTags = strip_tags($texto_update);

        // Contar os caracteres
        $numCaracteres = strlen($textoSemTags);


        if ($numCaracteres <= 5000) {

            // Obtém informações do banco de dados para a empresa atual
            foreach (selectGESSOB($id_emp_default) as $linha) {

                $img_banco = $linha['sob_imagem']; // Nome da imagem armazenada no banco de dados
            }

            // Formata o valor do texto antes de atualizar/inserir no banco de dados (função formatarValor não está definida no código fornecido)
            $texto = formatarValor('*', $texto_update);

            // Se a linha do banco de dados existir, atualiza os valores
            if (!empty($linha)) {

                updateGESSOB_sobre(
                    $texto,
                    $img_banco,
                    $datatu,
                    $id_usa_default,
                    $id_emp_default
                );

                // Se a linha do banco de dados não existir, insere novos valores
            } else {

                insertGESSOB(
                    $id_emp_default,
                    $texto,
                    $img_banco,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    $datinc,
                    $datatu,
                    $id_usa_default,
                    $id_usa_default
                );
            }

            echo 1; // Retorna 1 para indicar sucesso na atualização/inserção
        } else {

            echo 0; // Retorna 0 para indicar que a quantidade de caracteres é maior do que a permitida
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage(); // Exibe a mensagem de erro da exceção PDO
    }
}
