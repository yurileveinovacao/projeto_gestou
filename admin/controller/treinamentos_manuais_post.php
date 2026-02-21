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

// ALTERAR SITUAÇÃO
if (isset($_POST['btn_situac'])) {

    try {

        // Atribui valor as Variáveis
        $id_tre = $_POST['id_tre'];
        $situac_update = $_POST['situac'];

        // Formata as Variáveis
        $situac = formatarValor('SITUAC', $situac_update);

        /*
        // Exibe as Variáveis
        echo 'ID Emp: ' . $id_emp_default . '<br>';
        echo 'Situac Update: ' . $situac_update . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'ID Tre: ' . $id_tre . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID Usa: ' . $id_usa_default . '<br>';
        */

        // Executa comando no Banco
        // UPDATE Tabela GESTRE
        updateGESTRE_situac($id_emp_default, $situac, $id_tre, $datatu, $id_usa_default);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// EXCLUIR REGISTROS
if (isset($_POST['btn_exc']) and !empty($_POST['ids'])) {

    try {

        // Atribui valor as Variáveis
        $ids = $_POST['ids'];

        foreach ($ids as $id) {

            foreach (selectGESTRE_anexo($id) as $anexo_banco) {

                $anexo_excluir = $anexo_banco["anexo"];
            }

            if (!empty($anexo_excluir)) {

                unlink('../../upload/utilidades/treinamentos/' . $anexo_excluir . '');
            }
        }


        /*
        // Exibi as Variáveis
        $echo_ids = implode(',', $ids);
        echo 'IDS: ' . 
        $echo_ids . '<br>';
        */

        deleteGESTRE_in($ids);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT
if (isset($_POST['btn_submit'])) {

    $anexoValido = validarValor('VALID', $_FILES['file']['size'], 1);
    $linkValido = validarValor('REGEX_REQUIRED', $_POST['link'], '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/');

    if ($anexoValido || $linkValido) {

        try {

            // Atribui valor as Variáveis
            $titulo = $_POST['titulo'];
            $link = $_POST['link'];
            $id_dep = $_POST['id_dep'];
            $situac = 1;
            $anexo_size = $_FILES['file']['size'];

            //CÓDIGO PARA MOVER A IMAGEM ANEXADA PARA O DIRETORIO DO PROJETO
            if (!empty($anexo_size)) {


                $anexo_nome = $_FILES['file']['name'];
                $anexo_temp = $_FILES['file']['tmp_name'];
                $anexo_tipo = $_FILES['file']['type'];
                $anexo_erro = $_FILES['file']['error'];

                if ($anexo_size > 100000000) {

                    echo 2;
                    exit;
                }

                // Formata as Variáveis
                $datanova = formatarValor('NUM', $datinc);

                //renomear o nome da imagem
                $anexo_nome_update = $raiz_cnpj . '_' . $datanova . '.pdf';

                //Comando para mover o arquivo para a pasta
                $mover = move_uploaded_file($anexo_temp, '../../upload/utilidades/treinamentos/' . $anexo_nome_update);
            } else {

                $anexo_nome_update = NULL;
            }

            /*
            // Exibe as Variáveis
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            echo 'ID Dep: ' . $id_dep . '<br>';
            echo 'Titulo: ' . $titulo . '<br>';
            echo 'Link: ' . $link . '<br>';
            echo 'Anexo: ' . $anexo_nome_update . '<br>';
            echo 'Situac: ' . $situac . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa Inc: ' . $id_usa_default . '<br>';
            echo 'ID Usa Atu: ' . $id_usa_default . '<br>';
            */

            // Executa Comandos no Banco
            // INSERT Tabela GESTRE
            $insertGESTRE = insertGESTRE(
                $id_emp_default,
                $id_dep,
                $titulo,
                $link,
                $anexo_nome_update,
                $situac,
                $datinc,
                $datatu,
                $id_usa_default,
                $id_usa_default
            );

            $id_tre = $insertGESTRE['pk'];

            foreach (selectGESUSU_departamento($id_emp_default, $id_dep) as $linha) {

                $id_usu = $linha['id_usu'];

                if (!empty($id_usu)) {

                    insertGESTRU(
                        $id_usu,
                        $id_tre,
                        $datinc
                    );
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

// VISUALIZAR ANEXO
if (isset($_POST["abrir_modal"])) {

    try {

        $id_anexo = $_POST['id_anexo'];

        foreach (selectGESTRE_anexo($id_anexo) as $caminho_view) {

            $caminho_view_arquivo = $caminho_view['anexo'];
        }

        $retorno = '';

        if (!empty($caminho_view_arquivo)) {

            $retorno .= '<object data="../../upload/utilidades/treinamentos/' . $caminho_view_arquivo . '" type="application/pdf" width="100%" height="100%"></object>';
        }

        //retorno da função
        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
        echo 'Catch';
    }
}

// Verifica se o botão 'btn_avancar' foi acionado.
if (isset($_POST['btn_avancar'])) {

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
