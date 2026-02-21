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

//  MUDAR SITUAÇÃO
if (isset($_POST['btn_situac'])) {

    try {

        // Atribui valor as Variáveis
        $situac_update = $_POST['situac_update'];
        $id_mur = $_POST['id_mur'];

        // Formata as Variáveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe Variáveis
        echo 'ID Emp: ' . $id_emp_default . '<br>';
        echo 'Situac Update: ' . $situac_update . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'ID Mur: ' . $id_mur . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Usa: ' . $id_usa_default . '<br>';
        */

        // Executa Comandos no Banco
        // UPDATE Tabela GESMUR
        updateGESMUR_situac($id_emp_default, $situac, $id_mur, $datatu, $id_usa_default);

        // Retorno de Sucesso
        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// BOTÃO ENVIAR
if (isset($_POST['btn_enviar'])) {

    try {

        // Atribui valor as Variáveis
        $id_mur = $_POST['id_mur'];
        $situac_update = $_POST['situac'];
        // Valida se envia o e-mail
        $enviar_email = 0;

        // Formata as Variáveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe Variaveis
        echo 'ID Emp: ' . $id_emp_default . '<br>';
        echo 'ID Mur: ' . $id_mur . '<br>';
        echo 'Situac Update: ' . $situac_update . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'Enviar Email: ' . $enviar_email . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Usa: ' . $id_usa_default . '<br>';
        */

        // Executa Comandos no Banco
        // UPDATE Tabela GESMUR (MUDA O STATUS DO AVISO)
        updateGESMUR_situac($id_emp_default, $situac, $id_mur, $datatu, $id_usa_default);

        foreach (selectGESMUR_enviado($id_mur) as $linha) {

            $enviado = $linha['enviado'];
        }


        // Executa comando se $enviado for 0
        if ($enviado == 0 && $situac_update == 0) {

            // UPDATE Tabela GESMUR
            updateGESMUR_email($id_mur);

            // Se $enviar_email for 1 envia o e-mail
            if ($enviar_email == 1) {

                foreach (selectGESMUR_email($id_mur) as $linha_email) {

                    $titulo_email = $linha_email["titulo"];
                    $nome_email = $linha_email["nome"];
                    $email_email = $linha_email["email"];

                    require "../email_mural_avisos.php";
                }
            }
        }

        // Retorno de Sucesso
        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// BOTÃO EXCLUIR
if (isset($_POST['btn_exc']) and !empty($_POST['ids'])) {

    try {

        // Atribui valor as Variáveis
        $ids = $_POST['ids'];

        foreach ($ids as $id) {

            foreach (selectGESMUR_anexo($id) as $anexo_banco) {

                $anexo_excluir = $anexo_banco["anexo"];
            }

            if (!empty($anexo_excluir)) {

                unlink('../../upload/mensagens/notificacoes/mural_aviso/' . $anexo_excluir . '');
                // echo 'ID: ' . $id . ' - Anexo: ' . $anexo_excluir . '<br>';
            }
        }


        /*
        // Exibi as Variáveis
        $echo_ids = implode(',', $ids);
        echo 'IDS: ' .
            $echo_ids . '<br>';
        */

        deleteGESMUR_in($ids);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT
if (isset($_POST['btn_submit'])) {

    // Valida o valor do campo 'inputMensagem' com um comprimento mínimo de 1 caractere
    $mensagemValido = validarValor('VALID', $_POST['inputMensagem'], 1);
    // Valida o tamanho do arquivo enviado pelo campo 'input-b1'
    $anexoValido = validarValor('VALID', $_FILES['input-b1']['size'], 1);

    // Verifica se a mensagem ou o anexo são válidos
    if ($mensagemValido || $anexoValido) {

        try {

            // Obtém os valores dos campos do formulário
            $titulo = $_POST['inputTitulo'];
            $mensagem = $_POST['inputMensagem'];
            $dep = $_POST['inputid_dep'];
            $anexo_size = $_FILES['input-b1']['size'];
            $situac = 0;

            // Verifica se foi enviado um anexo
            if ($anexo_size != 0) {

                $anexo_nome = $_FILES['input-b1']['name'];
                $anexo_temp = $_FILES['input-b1']['tmp_name'];
                $anexo_tipo = $_FILES['input-b1']['type'];
                $anexo_erro = $_FILES['input-b1']['error'];

                // Obtém a extensão do arquivo anexo
                $anexo_ext = formatarValor('LOWER', pathinfo($anexo_nome, PATHINFO_EXTENSION));

                // Verifica se o tamanho do anexo excede o limite de 100000000 bytes
                if ($anexo_size > 100000000) {

                    echo 3;
                    exit;
                }

                // Formata a data de inclusão do anexo
                $data_nome = formatarValor('NUM', $datinc);

                // Define o novo nome do anexo baseado no CNPJ e na data de inclusão
                $anexo_nomeNovo = $raiz_cnpj . '_' . $data_nome . '.' . $anexo_ext;

                // Move o anexo para o diretório de uploads
                $mover = move_uploaded_file($anexo_temp, '../../upload/mensagens/notificacoes/mural_aviso/' . $anexo_nomeNovo);
            } else {

                // Caso não tenha sido enviado um anexo, define o nome do anexo como NULL
                $anexo_nomeNovo = NULL;
            }

            /*
            echo 'Titulo: ' . $titulo . '<br>';
            echo 'Mensagem: ' . $mensagem . '<br>';
            echo 'Departamento: ' . $dep . '<br>';
            echo 'Anexo: ' . $anexo_nomeNovo . '<br>';
            */

            // Insere os dados na tabela 'GESMUR' com a função 'insertGESMUR2'
            $insertGESMUR = insertGESMUR(
                $id_emp_default,
                $dep,
                $titulo,
                $anexo_nomeNovo,
                $mensagem,
                $situac,
                $datinc,
                $datatu,
                $id_usa_default,
                $id_usa_default,
            );

            // Obtém o ID do registro inserido
            $id_mur = $insertGESMUR['pk'];

            // Para cada usuário do departamento selecionado, insere uma linha na tabela 'GESMUU'
            foreach (selectGESUSU_departamento($id_emp_default, $dep) as $linha) {

                $id_usu = $linha['id_usu'];

                if (!empty($id_usu)) {

                    insertGESMUU(
                        $id_usu,
                        $id_mur,
                        $datinc
                    );
                }
            }

            // Retorno de Sucesso
            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        // Mensagem e Anexo não preenchidos
        echo 0;
    }
}

// Verifica se o botão 'btn_avancar1' foi acionado.
if (isset($_POST['btn_avancar1'])) {

    // Valida o valor do campo 'titulo' com uma comprimento mínimo de 3 caracteres.
    $tituloValido = validarValor('VALID', $_POST['titulo'], 3);
    // Valida se o campo 'id_dep' está presente e não está vazio.
    $depValido = validarValor('REQUIRED', $_POST['id_dep'], 1);

    /*
    // Imprime o valor do campo 'titulo'.
    echo 'Titulo: ' . $_POST['titulo'] . '<br>';
    // Imprime o resultado da validação do campo 'titulo'.
    echo 'Titulo Valido: ' . $tituloValido . '<br>';
    // Imprime o valor do campo 'id_dep'.
    echo 'ID Dep: ' . $_POST['id_dep'] . '<br>';
    // Imprime o resultado da validação do campo 'id_dep'.
    echo 'Dep Valido: ' . $depValido . '<br>';
    */

    if ($tituloValido and $depValido) {

        // Ambos os campos são válidos.
        echo 1;
    } else {

        if (!$tituloValido and $depValido) {

            // O campo 'titulo' não é válido, mas o campo 'id_dep' é válido.
            echo 2;
        } else if ($tituloValido and !$depValido) {

            // O campo 'id_dep' não é válido, mas o campo 'titulo' é válido.
            echo 3;
        } else {

            // Ambos os campos não são válidos.
            echo 0;
        }
    }
}

// Verifica se o botão 'btn_avancar1' foi acionado.
if (isset($_POST['btn_avancar2'])) {

    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 3);

    if ($mensagemValido) {

        // Ambos os campos são válidos.
        echo 1;
    } else {

        // Campo mensagem inválido.
        echo 0;
    }
}
