<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";

if (((isset($_POST["texto"])) or (isset($_FILES))) and (isset($_POST["btn_submit"]))) {

    try {

        $texto = $_POST["texto"];
        // $anexo = $_FILES['file']['size'];
        $nomeimg = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $tamanho = $_FILES['file']['size'];
        $tipoimg = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];
        $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

        if (!empty($texto) or (!empty($tamanho))) {

            foreach (selectGESSOB($id_emp_default) as $resultados1) {

                $caminho_banco = $resultados1['sob_imagem'];
            }

            //SELECT QUE VERIFICA SE HÁ LINHAS DESSA EMPRESA
            foreach (selectGESSOB($id_emp_default) as $resultados) {
                if (empty($resultados)) {

                    if ((!empty($tamanho))) {

                        //renomear o nome da imagem
                        $novo_nomeimg = $raiz_cnpj . "_" . time() . '_sobre.' . $ext;
                        //$novo_nomeimg= 'teste'.'.'.$extensao;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                    }

                    insertGESSOB($id_emp_default, $texto, $novo_nomeimg, NULL, NULL, NULL, NULL, NULL, NULL, $datinc, $datatu, $id_usa_default, $id_usa_default);

                    $retorno = 1;
                    echo json_encode($retorno);
                } else {

                    if ($tamanho == 0) {

                        $novo_nomeimg = $caminho_banco;
                    } else {

                        if (empty($texto)) {

                            foreach (selectGESSOB($id_emp_default) as $resultados2) {

                                $texto_banco = $resultados2['sob_texto'];
                            }

                            $texto = $texto_banco;
                        }

                        if (!empty($caminho_banco)) {
                            unlink('../../upload/empresa/' . $caminho_banco . '');
                        }

                        //renomear o nome da imagem
                        $novo_nomeimg = $raiz_cnpj . "_" . time() . '_sobre.' . $ext;
                        //$novo_nomeimg= 'teste'.'.'.$extensao;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                    }

                    updateGESSOB_sobre($texto, $novo_nomeimg, $datatu, $id_usa_default, $id_emp_default);

                    $retorno = 2;
                    echo json_encode($retorno);
                }
            }
        } else {

            $retorno = 0;
            echo json_encode($retorno);
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>

<?php

if (isset($_POST['btn_excluir'])) {
    try {

        foreach (selectGESSOB($id_emp_default) as $caminho_excluir) {

            $caminho_banco_excluir = $caminho_excluir['sob_imagem'];
        }

        updateGESSOB_sobre(NULL, NULL, $datatu, $id_usa_default, $id_emp_default);

        if ($caminho_banco_excluir != NULL) {
            unlink('../../upload/empresa/' . $caminho_banco_excluir . '');
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_POST["abrir_modal"])) {

    if ($_POST["abrir_modal"] == 1) {

        foreach (selectGESSOB($id_emp_default) as $caminho_view) {

            $texto_view_arquivo = $caminho_view['sob_texto'];
            $caminho_view_arquivo = $caminho_view['sob_imagem'];
        }

        $retorno = '';

        if ($caminho_view_arquivo == NULL) {
        } else {

            $retorno .= '<div class="textalign-center">';

            $retorno .= '<img src="../../upload/empresa/' . $caminho_view_arquivo . '" class="img-modal"></img>';

            $retorno .= '</div>';
        }

        if ($texto_view_arquivo == NULL) {
        } else {

            $retorno .= '<div class="textalign-justify">';

            $retorno .= '<h6 class="text-justify">' . $texto_view_arquivo . '</h6>';

            $retorno .= '</div>';
        }

        //retorno da função
        echo $retorno;
    }
}

function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }

    return substr(bin2hex($bytes), 0, $lenght);
}

?>