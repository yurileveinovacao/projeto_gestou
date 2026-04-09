<?php
require '../restrito.php';
require '../util.php';

if (isset($_POST['submit_justificativa'])) {
    try {
        $tipo = $_POST['tipo'];
        $data_ocorrencia = $_POST['data_ocorrencia'];
        $hora_ocorrencia = isset($_POST['hora_ocorrencia']) ? $_POST['hora_ocorrencia'] : null;
        $mensagem = isset($_POST['mensagem']) ? strtoupper(trim($_POST['mensagem'])) : null;
        $criado_em = date('Y-m-d H:i:s');
        $arquivo_path = null;

        // Validações por tipo
        if (empty($tipo) || empty($data_ocorrencia)) {
            echo '0';
            exit;
        }

        if ($tipo == 'ausencia_ponto' && empty($hora_ocorrencia)) {
            echo '0';
            exit;
        }

        if (($tipo == 'falta' || $tipo == 'falta_atestado') && empty($mensagem)) {
            echo '0';
            exit;
        }

        // Upload de atestado
        if ($tipo == 'falta_atestado') {
            if (isset($_FILES['arquivo']) && $_FILES['arquivo']['size'] > 0) {
                $nome_arquivo = $_FILES['arquivo']['name'];
                $temp = $_FILES['arquivo']['tmp_name'];
                $ext = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

                if (!in_array($ext, ['pdf', 'png', 'jpg', 'jpeg'])) {
                    echo '2'; // extensão inválida
                    exit;
                }

                if ($_FILES['arquivo']['size'] > 10000000) {
                    echo '3'; // arquivo muito grande
                    exit;
                }

                $pasta = '../../upload/justificativas/' . $raiz_cnpj . '/' . $id_usu_default . '/';
                if (!file_exists($pasta)) {
                    mkdir($pasta, 0777, true);
                }

                $novo_nome = time() . '_' . $nome_arquivo;
                if (move_uploaded_file($temp, $pasta . $novo_nome)) {
                    $arquivo_path = 'justificativas/' . $raiz_cnpj . '/' . $id_usu_default . '/' . $novo_nome;
                } else {
                    echo '4'; // erro upload
                    exit;
                }
            } else {
                echo '5'; // atestado obrigatório
                exit;
            }
        }

        insertJustificativa($id_usu_default, $cnpj_completo, $tipo, $data_ocorrencia, $hora_ocorrencia, $mensagem, $arquivo_path, $criado_em);
        echo '1'; // sucesso

    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
