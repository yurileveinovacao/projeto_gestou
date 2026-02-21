
<?php

// Faz a requisição da Sessão
require '../restrito.php';

// Funções INSERT, UPDATE, DELETE e SELECT
require_once "../iuds_pdo.php";

// Arquivo de Utilitários
require_once "../util2.php";

$desativa_insert = 0;

if (isset($_POST["image"])) {

    $id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

    if (!empty($id_emp)) {

        // Recebe a imagem enviada pelo formulário
        $image = $_POST['image'];

        // Separa o tipo e os dados da imagem
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);

        // Decodifica a imagem de base64 para binário
        $image = base64_decode($image);

        foreach (selectGESEMP_CNPJ($id_emp) as $result) {
            $cnpj = $result['cnpj'];
            // Remover todos os caracteres não numéricos
            $cnpj_formatado = preg_replace('/\D/', '', $cnpj);
        }

        // Define o nome da imagem
        $image_name = $cnpj_formatado . '_logo.png';

        if ($desativa_insert == 0) {

            // Obtém a foto da empresa no banco de dados
            foreach (selectGESEMP_FOTO($id_emp) as $foto_banco) {
                $imagem = $foto_banco["imagem"];

                // Se a imagem existir, remove o arquivo existente
                if ($imagem != NULL) {
                    unlink('../../upload/empresa/' . $imagem);
                }

                // Atualiza o registro da imagem no banco de dados
                updateGESEMP_FOTO($image_name, $id_emp, $datatu, $id_usa_default);
            }

            // Salva a nova imagem no servidor
            file_put_contents('../../upload/empresa/' . $image_name, $image);
        }

        // Define o status como 'sucesso' quando o processo finalizar
        $status = 'sucesso';
        $mensagem = 'Foto alterada com sucesso!';

        // Constrói um array de retorno com o status e a mensagem de erro
        $retorna = array(
            'status' => $status,
            'mensagem' => $mensagem
        );
    } else {
        // Define o status como 'erro' quando o ID da empresa está vazio
        $status = 'erro';
        $mensagem = 'Ocorreu um erro ao enviar os dados.';

        // Constrói um array de retorno com o status e a mensagem de erro
        $retorna = array(
            'status' => $status,
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

if (isset($_POST["remover_foto"])) {

    $id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

    if (!empty($id_emp)) {

        foreach (selectGESEMP_FOTO($id_emp) as $foto_banco) {
            $imagem = $foto_banco["imagem"];
        }

        if (!empty($imagem) && unlink('../../upload/empresa/' . $imagem)) {

            if ($desativa_insert == 0) {

                updateGESEMP_FOTO(NULL, $id_emp, $datatu, $id_usa_default);
            }

            // Define o status como 'sucesso'
            $status = 'sucesso';
            $mensagem = 'Foto removida com sucesso.';

            // Constrói um array de retorno com o status e a mensagem de sucesso
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        } else {
            // Define o status como 'error'
            $status = 'error';
            $mensagem = 'Erro ao remover a foto.';

            // Constrói um array de retorno com o status e a mensagem de sucesso
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        }
    } else {
        // Define o status como 'erro' quando o ID da empresa está vazio
        $status = 'erro';
        $mensagem = 'Ocorreu um erro ao enviar os dados.';

        // Constrói um array de retorno com o status e a mensagem de erro
        $retorna = array(
            'status' => $status,
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

// Adiciona um usuario como GESTOR
if (isset($_POST['btn_inc'])) {

    $id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

    if (!empty($id_emp)) {

        try {

            $gestor = 1;
            $id_usa = $_POST['btn_inc'];
            $_SESSION['alterar_empresa']['nav_tab'] = 4;

            if ($desativa_insert == 0) {

                if (selectGESGES($id_usa, $id_emp) == 0) {
                    insertGESGES($id_usa, $id_emp, $gestor);
                } else {
                    updateGESGES($id_usa, $id_emp, $gestor);
                }
            }

            // Define o status como 'sucesso'
            $status = 'sucesso';
            $mensagem = 'Gestor adicionado com sucesso.';

            // Constrói um array de retorno com o status e a mensagem de sucesso
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        } catch (PDOException $erro) {
            // Captura e trata exceções PDO
            $mensagem = $erro->getMessage();
            $retorna = array(
                'status' => 'erro',
                'mensagem' => $mensagem
            );
        }
    } else {
        // Define o status como 'erro' quando o ID da empresa está vazio
        $status = 'erro';
        $mensagem = 'Ocorreu um erro ao enviar os dados.';

        // Constrói um array de retorno com o status e a mensagem de erro
        $retorna = array(
            'status' => $status,
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}

// Remove um usuario de GESTOR
if (isset($_POST["btn_exc"])) {

    $id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

    if (!empty($id_emp)) {

        try {

            $gestor = 0;
            $id_usa = $_POST["btn_exc"];
            $_SESSION['alterar_empresa']['nav_tab'] = 4;

            $id_usa = preg_replace('/\D+/', '', $id_usa);

            if ($desativa_insert == 0) {

                updateGESGES($id_usa, $id_emp, $gestor);
            }

            // Define o status como 'sucesso'
            $status = 'sucesso';
            $mensagem = 'Gestor removido com sucesso.';

            // Constrói um array de retorno com o status e a mensagem de sucesso
            $retorna = array(
                'status' => $status,
                'mensagem' => $mensagem
            );
        } catch (PDOException $erro) {
            // Captura e trata exceções PDO
            $mensagem = $erro->getMessage();
            $retorna = array(
                'status' => 'erro',
                'mensagem' => $mensagem
            );
        }
    } else {
        // Define o status como 'erro' quando o ID da empresa está vazio
        $status = 'erro';
        $mensagem = 'Ocorreu um erro ao enviar os dados.';

        // Constrói um array de retorno com o status e a mensagem de erro
        $retorna = array(
            'status' => $status,
            'mensagem' => $mensagem
        );
    }

    // Envia o array de retorno em formato JSON
    echo json_encode($retorna);
}


// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_adicionar"])) {

    try {
        // Obtém o ID da empresa matriz da sessão
        $id_emp = $_SESSION["tabela_empresas"]["id_emp_editar"];

        if (!empty($id_emp)) {

            // Define as variáveis
            $nome = $_POST["nome"]; //REQUIRED
            $nomefantasia = $_POST["nomefantasia"]; //REQUIRED
            $email = $_POST["email"];
            $contato = $_POST["contato"];
            $telefone = $_POST["telefone"];
            $resp_financeiro = $_POST['resp_financeiro'];
            $email_financeiro = $_POST['email_financeiro'];
            $endereco = $_POST["endereco"];
            $bairro = $_POST["bairro"];
            $numero = $_POST["numero"];
            $complemento = $_POST["complemento"];
            $cidade = $_POST["cidade"]; //REQUIRED
            $cep = $_POST["cep"];
            $id_emp_h = $_POST["id_emp_h"]; //REQUIRED
            $id_emp_p = $_POST["id_emp_p"]; //REQUIRED
            $id_emp_i = $_POST["id_emp_i"]; //REQUIRED
            $lay_folha = $_POST["lay_folha"];
            $lay_ponto = $_POST["lay_ponto"];
            $lay_irrf = $_POST["lay_irrf"];
            $descricao_layout = $_POST["descricao_layout"];
            $id_per_imp = $_POST['id_per_imp'];
            $id_per_ace = $_POST['id_per_ace'];
            $id_usa_rh = $_POST["id_usa_rh"];
            $id_usa_ouv = $_POST["id_usa_ouv"];
            $id_emp_grupo = $_POST["id_emp_grupo"];
            $lay_h = $_POST["lay_h"]; //REQUIRED
            $lay_p = $_POST["lay_p"]; //REQUIRED
            $lay_i = $_POST["lay_i"]; //REQUIRED
            $tipo_h = $_POST["tipo_h"]; //REQUIRED
            $tipo_p = $_POST["tipo_p"]; //REQUIRED
            $tipo_i = $_POST["tipo_i"]; //REQUIRED
            $validacao_gestor = $_POST["validacao_gestor"];

            $id_usa = $_SESSION['id_mas'];

            // Validação dos campos do formulário
            $nomeValid = validarValor('VALID', $nome, 3);
            $nomefantasiaValid = validarValor('VALID', $nomefantasia, 3);
            $cidadeValid = validarValor('*', $cidade, 1);
            $id_emp_hValid = validarValor('*', $id_emp_h, 1);
            $id_emp_pValid = validarValor('*', $id_emp_p, 1);
            $id_emp_iValid = validarValor('*', $id_emp_i, 1);
            $lay_hValid = validarValor('*', $lay_h, 1);
            $lay_pValid = validarValor('*', $lay_p, 1);
            $lay_iValid = validarValor('*', $lay_i, 1);
            $tipo_hValid = validarValor('*', $tipo_h, 1);
            $tipo_pValid = validarValor('*', $tipo_p, 1);
            $tipo_iValid = validarValor('*', $tipo_i, 1);

            if (
                $nomeValid && $nomefantasiaValid && $cidadeValid && $id_emp_hValid && $id_emp_pValid && $id_emp_iValid
                && $lay_hValid && $lay_pValid && $lay_iValid && $tipo_hValid && $tipo_pValid && $tipo_iValid
            ) {

                // Formatação dos campos
                $nome = formatarValor('UPPER', $nome);
                $nomefantasia = formatarValor('UPPER', $nomefantasia);
                $endereco = formatarValor('UPPER', $endereco);
                $bairro = formatarValor('UPPER', $bairro);
                $numero = formatarValor('UPPER', $numero);
                $complemento = formatarValor('UPPER', $complemento);
                $contato = formatarValor('UPPER', $contato);
                $lay_folha = formatarValor('*', $lay_folha);
                $lay_ponto = formatarValor('*', $lay_ponto);
                $lay_irrf = formatarValor('*', $lay_irrf);
                $resp_financeiro = formatarValor('UPPER', $resp_financeiro);
                $email = formatarValor('*', $email);
                $contato = formatarValor('*', $contato);
                $telefone = formatarValor('NUM', $telefone);
                $endereco = formatarValor('*', $endereco);
                $bairro = formatarValor('*', $bairro);
                $numero = formatarValor('*', $numero);
                $complemento = formatarValor('*', $complemento);
                $cep = formatarValor('NUM', $cep);
                $descricao_layout = formatarValor('*', $descricao_layout);
                $id_usa_rh = formatarValor('*', $id_usa_rh);
                $id_usa_ouv = formatarValor('*', $id_usa_ouv);
                $id_emp_grupo = formatarValor('*', $id_emp_grupo);
                $resp_financeiro = formatarValor('*', $resp_financeiro);
                $email_financeiro = formatarValor('*', $email_financeiro);

                if ($validacao_gestor == '') {

                    $validacao_gestor = 0;
                }

                if ($desativa_insert == 0) {

                    // Executa os update
                    updateGESEMP_CAMPOS(
                        $nome,
                        $nomefantasia,
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
                        $id_emp_h,
                        $id_emp_p,
                        $id_emp_i,
                        $lay_folha,
                        $lay_ponto,
                        $lay_irrf,
                        $descricao_layout,
                        $id_per_imp,
                        $id_per_ace,
                        $id_usa_rh,
                        $id_usa_ouv,
                        $id_emp_grupo,
                        $tipo_h,
                        $tipo_p,
                        $tipo_i,
                        $validacao_gestor,
                        $datatu,
                        $id_emp,
                        $id_usa
                    );

                    foreach (selectGESLAY_id_emp_exists($id_emp) as $verificar) {
                        $layout_exists = $verificar["exists"];
                    }

                    if ($layout_exists) {
                        // O registro existe, realiza o UPDATE
                        updateGESLAY($id_emp, $lay_h, $lay_p, $lay_i);
                    } else {
                        // O registro não existe, realiza o INSERT
                        $layout_vis = "VIS";
                        insertGESLAY($id_emp, $layout_vis, $layout_vis, $layout_vis);
                    }
                }

                // Define mensagem de sucesso
                $mensagem = 'Dados atualizados com sucesso!';
                $retorna = array(
                    'status' => 'sucesso',
                    'mensagem' => $mensagem
                );
            } else {
                // Define mensagem de erro caso as validações falhem
                $mensagem = 'Revise os dados preenchidos e tente novamente!';
                $retorna = array(
                    'status' => 'erro',
                    'mensagem' => $mensagem
                );
            }
        } else {
            // Define o status como 'erro' quando o ID da empresa está vazio
            $status = 'erro';
            $mensagem = 'Ocorreu um erro ao enviar os dados.';

            // Constrói um array de retorno com o status e a mensagem de erro
            $retorna = array(
                'status' => $status,
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

        unset($_SESSION["tabela_empresas"]["id_emp_editar"]);

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
