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

//  Abrir Modal de Visualização
if (isset($_POST['btn_visualizar'])) {

    try {

        $id_not = $_POST['id_not'];

        foreach (selectGESNOT_visualizar($id_not) as $linha) {

            $anexo = $linha['anexo'];
            $mensagem = $linha['mensagem'];
        }

        $ext = pathinfo($anexo, PATHINFO_EXTENSION);

        $ext = formatarValor('UPPER', $ext);

        if ($ext == 'PDF') {

            $tipo_anexo = 'ARQUIVO';
        } else if ($ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {

            $tipo_anexo = 'IMAGEM';
        } else {

            $tipo_anexo = NULL;
        }

        /*
        // Exibe as Variáveis
        echo 'ID Not: ' . $id_not . '<br>';
        echo 'Anexo: ' . $anexo . '<br>';
        echo 'Tipo Anexo: ' . $tipo_anexo . '<br>';
        echo 'Mensagem: ' . $mensagem . '<br>';
        */

        if (!empty($anexo) && !empty($mensagem)) {

            if ($tipo_anexo == 'ARQUIVO') {

                $retorno = '
                    <div class="col-md-12">

                        <div class="row">
                            <iframe src="../upload/mensagens/notificacoes/notificacoes/' . $anexo . '" class="m-auto" style="width: 600px;height: 600px"></iframe>
                        </div>
    
                        <div class="row mt-4">
                            <span>' . $mensagem . '</span>
                        </div>

                    </div>
                ';
            } else {

                $retorno = '
                    <div class="col-md-12">

                        <div class="row">
                            <img src="../upload/mensagens/notificacoes/notificacoes/' . $anexo . '" class="m-auto img-fluid" style="max-width: 50% !important;"></img>
                        </div>
    
                        <div class="row mt-4">
                            <span>' . $mensagem . '</span>
                        </div>
    
                    </div>
                ';
            }
        } else if (!empty($anexo) && empty($mensagem)) {

            if ($tipo_anexo == 'ARQUIVO') {

                $retorno = '
                    <div class="col-md-12">

                        <div class="row">
                            <iframe src="../upload/mensagens/notificacoes/notificacoes/' . $anexo . '" class="m-auto" style="width: 600px;height: 600px"></iframe>
                        </div>

                    </div>
                ';
            } else {

                $retorno = '
                    <div class="col-md-12">

                        <div class="row">
                            <img src="../upload/mensagens/notificacoes/notificacoes/' . $anexo . '" class="m-auto img-fluid" style="max-width: 50% !important;"></img>
                        </div>
    
                    </div>
                ';
            }
        } else if (empty($anexo) && !empty($mensagem)) {

            $retorno = '
                    <div class="col-md-12">
    
                        <div class="row">
                            <span>' . $mensagem . '</span>
                        </div>
    
                    </div>
                ';
        }

        // Retorna o código HTML
        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// ALTERAR SITUAÇÃO
if (isset($_POST['btn_situac'])) {

    try {

        // Atribui valor as Variáveis
        $id_not = $_POST['id_not'];
        $situac_update = $_POST['situac'];
        $enviado = $_POST['enviado'];

        // Formata Variáveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe Variáveis
        echo 'ID Emp: ' . $id_emp_default . '<br>';
        echo 'Situac Anterior: ' . $situac_update . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'ID Not: ' . $id_not . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Usa: ' . $id_usa_default . '<br>';
        */

        if ($enviado == 0 && $situac_update == 0) {

            // Envio de E-mail
            foreach (selectGESNOT_email($id_not) as $email_notificacao) {

                $titulo_email = $email_notificacao['titulo'];
                $nome_email = $email_notificacao['nome'];
                $email_email = $email_notificacao['email'];
                $nome_cc = $email_notificacao['nome_cc'];
                $email_cc = $email_notificacao['email_cc'];

                require '../email_notificacoes.php';
            }

            updateGESNOT_email($id_not);
        }

        // Executa comandos no Banco
        // UPDATE Tabela GESNOT
        updateGESNOT_situac(
            $id_emp_default,
            $situac,
            $id_not,
            $datatu,
            $id_usa_default
        );
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

            foreach (selectGESNOT_anexo($id) as $anexo_banco) {

                $anexo_excluir = $anexo_banco["anexo"];
            }

            if (!empty($anexo_excluir)) {

                unlink('../../upload/mensagens/notificacoes/notificacoes/' . $anexo_excluir . '');
                // echo 'ID: ' . $id . ' - Anexo: ' . $anexo_excluir . '<br>';
            }
        }


        /*
        // Exibi as Variáveis
        $echo_ids = implode(',', $ids);
        echo 'IDS: ' .
            $echo_ids . '<br>';
        */


        deleteGESNOT_in($ids);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT
if (isset($_POST['btn_submit'])) {

    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 1);
    $anexoValido = validarValor('VALID', $_FILES['file']['size'], 1);

    if ($mensagemValido || $anexoValido) {

        try {

            // Atribui valor as variáveis
            $titulo = $_POST['titulo'];
            $mensagem = $_POST['mensagem'];
            $id_usu = $_POST['id_usu'];
            $anexo_size = $_FILES['file']['size'];
            $situac = 0;

            //CÓDIGO PARA MOVER A IMAGEM ANEXADA PARA O DIRETORIO DO PROJETO
            if ($anexo_size != 0) {

                // Atribui valor as variáveis
                $anexo_nome = $_FILES['file']['name'];
                $anexo_temp = $_FILES['file']['tmp_name'];
                $anexo_tipo = $_FILES['file']['type'];
                $anexo_erro = $_FILES['file']['error'];

                $anexo_ext_update = pathinfo($anexo_nome, PATHINFO_EXTENSION);

                // Verifica se o anexo não ultrapassa o tamanho maximo
                if ($anexo_size > 100000000) {

                    // Anexo maior que o maximo permitido;
                    echo 2;
                    exit;
                }

                // Formatar Variáveis
                $data_nome = formatarValor('NUM', $datinc);
                $anexo_ext = formatarValor('LOWER', $anexo_ext_update);

                // Gera o novo nome do arquivo
                $anexo_nomeNovo = $raiz_cnpj . '_' . $data_nome . '.' . $anexo_ext;

                //Comando para mover o arquivo para a pasta
                $mover = move_uploaded_file($anexo_temp, '../../upload/mensagens/notificacoes/notificacoes/' . $anexo_nomeNovo);
            } else {

                $anexo_nomeNovo = NULL;
            }

            /*
            // Exibe as Variáveis
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            echo 'ID Usu: ' . $id_usu . '<br>';
            echo 'Titulo: ' . $titulo . '<br>';
            echo 'Anexo: ' . $anexo_nomeNovo . '<br>';
            echo 'Mensagem: ' . $mensagem . '<br>';
            echo 'Situac: ' . $situac . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            */


            // Executa Comandos no Banco
            // INSERT Tabela GESNOT
            insertGESNOT(
                $id_emp_default,
                $id_usu,
                $titulo,
                $anexo_nomeNovo,
                $mensagem,
                $situac,
                $datinc,
                $datatu,
                $id_usa_default,
                $id_usa_default
            );


            // Retorno de Sucesso
            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        // Não preencheu o campo mensagem nem selecionou um anexo
        echo 0;
    }
}

// Verifica se o botão 'btn_avancar1' foi acionado.
if (isset($_POST['btn_avancar1'])) {

    // Valida o valor do campo 'titulo' com uma comprimento mínimo de 3 caracteres.
    $tituloValido = validarValor('VALID', $_POST['titulo'], 3);
    // Valida se o campo 'id_usu' está presente e não está vazio.
    $usuValido = validarValor('REQUIRED', $_POST['id_usu'], 1);

    /*
    // Imprime o valor do campo 'titulo'.
    echo 'Titulo: ' . $_POST['titulo'] . '<br>';
    // Imprime o resultado da validação do campo 'titulo'.
    echo 'Titulo Valido: ' . $tituloValido . '<br>';
    // Imprime o valor do campo 'id_usu'.
    echo 'ID Dep: ' . $_POST['id_usu'] . '<br>';
    // Imprime o resultado da validação do campo 'id_usu'.
    echo 'Dep Valido: ' . $usuValido . '<br>';
    */

    if ($tituloValido and $usuValido) {

        // Ambos os campos são válidos.
        echo 1;
    } else {

        if (!$tituloValido and $usuValido) {

            // O campo 'titulo' não é válido, mas o campo 'id_usu' é válido.
            echo 2;
        } else if ($tituloValido and !$usuValido) {

            // O campo 'id_usu' não é válido, mas o campo 'titulo' é válido.
            echo 3;
        } else {

            // Ambos os campos não são válidos.
            echo 0;
        }
    }
}
