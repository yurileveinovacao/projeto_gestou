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

        if (in_array($tipo, ['ausencia_ponto', 'atraso'], true) && empty($hora_ocorrencia)) {
            echo '0';
            exit;
        }

        if (in_array($tipo, ['falta', 'falta_atestado', 'atraso'], true) && empty($mensagem)) {
            echo '0';
            exit;
        }

        // Anexo: obrigatório para 'falta_atestado', opcional para 'atraso', ignorado para os demais
        $tem_anexo = isset($_FILES['arquivo']) && $_FILES['arquivo']['size'] > 0;

        if ($tipo == 'falta_atestado' && !$tem_anexo) {
            echo '5'; // atestado obrigatório
            exit;
        }

        if (in_array($tipo, ['falta_atestado', 'atraso'], true) && $tem_anexo) {
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
        }

        insertJustificativa($id_usu_default, $raiz_cnpj, $tipo, $data_ocorrencia, $hora_ocorrencia, $mensagem, $arquivo_path, $criado_em);
        echo '1'; // sucesso

    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
