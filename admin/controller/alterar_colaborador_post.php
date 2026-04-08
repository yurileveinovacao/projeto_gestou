<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

if (isset($_POST['btn_visualizar_anexo'])) {

    $token = $_POST['token'];

    $descricao = $_SESSION['alterar_colaborador']['token'][$token]['descricao'];
    $competencia = $_SESSION['alterar_colaborador']['token'][$token]['competencia'];
    $arquivo = $_SESSION['alterar_colaborador']['token'][$token]['arquivo'];
    $tipo = $_SESSION['alterar_colaborador']['token'][$token]['tipo'];

    $retorno = '';

    //Declarar div para dados do funcionário
    $retorno .= '<div class="form-row">';

    $retorno .= '<div class="col-md-4">';
    $retorno .= '<span style="line-height: 3.00;">' . 'Nome: ' . $descricao . '</span>';
    $retorno .= '</div>';

    $retorno .= '<div class="col-md-4">';
    $retorno .= '</div>';

    $retorno .= '<div class="col-md-4">';
    $retorno .= '<span style="line-height: 3.00;">' . 'Periodo: ' . $competencia . '</span>';
    $retorno .= '</div>';

    $retorno .= '</div>';

    //Montar linhas tabela para venvimentos

    switch ($tipo) {

        case 'Holerite':
            $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $arquivo . '"></iframe>';
            break;

        case 'IRRF':
            $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/irrf/' . $raiz_cnpj . '/' . $arquivo . '"></iframe>';
            break;

        case 'Ponto':
            $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $arquivo . '"></iframe>';
            break;

        case 'Diversos':
            $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $arquivo . '"></iframe>';
            break;

        case 'Documento':

            $id_usu = $_SESSION['colaborador_editar'];

            foreach (selectGESUSU($id_usu) as $select) {

                $cpf = $select['cpf'];
            }

            $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/colaboradores/' . $raiz_cnpj . '/' . $cpf . '/' . $arquivo . '"></iframe>';
            break;
    }

    //retorno da função
    echo $retorno;
};

if (isset($_POST['submit_salvar_doc'])) {

    $descricao = $_POST['salvar_doc_descricao'];
    $competencia = $_POST['salvar_doc_competencia'];

    $descricaoValido = validarValor('VALID', $descricao, 3);
    $competenciaValido = validarValor('REGEX_REQUIRED', $competencia, '/^(\d{2}\/){2}\d{4}$/');

    if ($descricaoValido && $competenciaValido) {

        $nomedoc = $_FILES['input-b1']['name'];
        $temp = $_FILES['input-b1']['tmp_name'];
        $size = $_FILES['input-b1']['size'];

        if ($size > 0) {

            $ext = pathinfo($nomedoc, PATHINFO_EXTENSION);

            if (($ext == 'pdf') || ($ext == 'PDF')) {

                $id_usu = $_SESSION['colaborador_editar'];

                foreach (selectGESUSU($id_usu) as $select) {

                    $cpf = $select['cpf'];
                }

                if (!empty($cpf)) {

                    $path = '../../upload/colaboradores/' . $raiz_cnpj . '/' . $cpf . '/';

                    if (!file_exists($path)) {

                        mkdir($path, 0777, true);
                    }

                    $novo_nomedoc = time() . $nomedoc;

                    if (move_uploaded_file($temp, $path . $novo_nomedoc)) {

                        insert_GESDCOL($descricao, $novo_nomedoc, $id_emp_default, $id_usu, $datinc);

                        $status = 'SUCESSO';
                    } else {

                        $status = 'ERRO_ARQUIVO';
                    }
                } else {

                    $status = 'ERRO_CPF';
                }
            } else {

                $status = 'ERRO_EXT';
            }
        } else {

            $status = 'SEM_ANEXO';
        }
    } else {

        $status = 'VALOR_INVALIDO';
    }


    $retorno = [
        'status' => $status
    ];

    echo json_encode($retorno);
};

// FEA-004: Nova observação do colaborador
if (isset($_POST['submit_nova_observacao'])) {
    try {
        $id_usu = $_SESSION['colaborador_editar'];
        $cnpj = $_SESSION['cnpj_completo'];
        $descricao = trim($_POST['descricao']);
        $data_obs = $_POST['data_observacao'];
        $categoria_id = !empty($_POST['categoria_id']) ? intval($_POST['categoria_id']) : null;
        $criado_por = $_SESSION['id_usa'];
        $criado_em = date('Y-m-d H:i:s');

        if (!empty($descricao) && !empty($data_obs)) {
            insertObservacao($id_usu, $cnpj, $categoria_id, $descricao, $data_obs, $criado_em, $criado_por);
            echo '1';
        } else {
            echo '0';
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// FEA-004: Deletar observação
if (isset($_POST['delete_observacao'])) {
    try {
        $id = intval($_POST['id_observacao']);
        deleteObservacao($id);
        echo '1';
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// FEA-004: Nova categoria de observação
if (isset($_POST['submit_nova_categoria'])) {
    try {
        $cnpj = $_SESSION['cnpj_completo'];
        $nome = trim($_POST['nome_categoria']);
        $criado_em = date('Y-m-d H:i:s');

        if (!empty($nome) && strlen($nome) <= 100) {
            insertCategoria_observacao($cnpj, $nome, $criado_em);
            echo '1';
        } else {
            echo '0';
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// FEA-004: Desativar categoria
if (isset($_POST['inactivate_categoria'])) {
    try {
        $id = intval($_POST['id_categoria']);
        inactivateCategoria_observacao($id);
        echo '1';
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
