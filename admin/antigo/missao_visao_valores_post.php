<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";

if (((isset($_POST["texto"])) or (isset($_FILES))) and (isset($_POST["btn_submit"]))) {

    try {

        $tipo_submit = $_POST["btn_submit"];
        $texto = $_POST["texto"];
        // $anexo = $_FILES['file']['size'];
        $nomeimg = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $tamanho = $_FILES['file']['size'];
        $tipoimg = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];
        $ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

        switch ($tipo_submit) {
            case 'submit-missao':

                if (!empty($texto) or (!empty($tamanho))) {

                    foreach (selectGESSOB($id_emp_default) as $missao_banco) {

                        $caminho_banco = $missao_banco['mis_imagem'];
                        $texto_banco = $missao_banco['mis_texto'];

                        if (empty($missao_banco)) {

                            if ((!empty($tamanho))) {

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_missao.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            insertGESSOB($id_emp_default, NULL, NULL, $texto, $novo_nomeimg, NULL, NULL, NULL, NULL, $datinc, $datatu, $id_usa_default, $id_usa_default);

                            $retorno = 1;
                            echo json_encode($retorno);
                        } else {

                            if ($tamanho == 0) {

                                $novo_nomeimg = $caminho_banco;
                            } else {

                                if (empty($texto)) {

                                    $texto = $texto_banco;
                                }

                                if (!empty($caminho_banco)) {
                                    unlink('../../upload/empresa/' . $caminho_banco . '');
                                }

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_missao.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            updateGESSOB_missao($texto, $novo_nomeimg, $datatu, $id_usa_default, $id_emp_default);

                            $retorno = 2;
                            echo json_encode($retorno);
                        }

                        $_SESSION["tab"] = 1;
                    }
                } else {

                    $retorno = 0;
                    echo json_encode($retorno);
                }

                break;

            case 'submit-visao':

                if (!empty($texto) or (!empty($tamanho))) {

                    foreach (selectGESSOB($id_emp_default) as $visao_banco) {

                        $caminho_banco = $visao_banco['vis_imagem'];
                        $texto_banco = $visao_banco['vis_texto'];

                        if (empty($visao_banco)) {

                            if ((!empty($tamanho))) {

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_visao.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            insertGESSOB($id_emp_default, NULL, NULL, NULL, NULL, NULL, NULL, $texto, $novo_nomeimg, $datinc, $datatu, $id_usa_default, $id_usa_default);

                            $retorno = 1;
                            echo json_encode($retorno);
                        } else {

                            if ($tamanho == 0) {

                                $novo_nomeimg = $caminho_banco;
                            } else {

                                if (empty($texto)) {

                                    $texto = $texto_banco;
                                }

                                if (!empty($caminho_banco)) {
                                    unlink('../../upload/empresa/' . $caminho_banco . '');
                                }

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_visao.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            updateGESSOB_visao($texto, $novo_nomeimg, $datatu, $id_usa_default, $id_emp_default);

                            $retorno = 2;
                            echo json_encode($retorno);
                        }

                        $_SESSION["tab"] = 3;
                    }
                } else {

                    $retorno = 0;
                    echo json_encode($retorno);
                }

                break;

            case 'submit-valores':

                if (!empty($texto) or (!empty($tamanho))) {

                    foreach (selectGESSOB($id_emp_default) as $valores_banco) {

                        $caminho_banco = $valores_banco['val_imagem'];
                        $texto_banco = $valores_banco['val_texto'];

                        if (empty($valores_banco)) {

                            if ((!empty($tamanho))) {

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_valores.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            insertGESSOB($id_emp_default, NULL, NULL, NULL, NULL, $texto, $novo_nomeimg, NULL, NULL, $datinc, $datatu, $id_usa_default, $id_usa_default);

                            $retorno = 1;
                            echo json_encode($retorno);
                        } else {

                            if ($tamanho == 0) {

                                $novo_nomeimg = $caminho_banco;
                            } else {

                                if (empty($texto)) {

                                    $texto = $texto_banco;
                                }

                                if (!empty($caminho_banco)) {
                                    unlink('../../upload/empresa/' . $caminho_banco . '');
                                }

                                //renomear o nome da imagem
                                $novo_nomeimg = $raiz_cnpj . "_" . uniqidReal() . '_valores.' . $ext;
                                //$novo_nomeimg= 'teste'.'.'.$extensao;

                                //Comando para mover o arquivo para a pasta
                                $mover = move_uploaded_file($temp, '../../upload/empresa/' . $novo_nomeimg);
                            }

                            updateGESSOB_valores($texto, $novo_nomeimg, $datatu, $id_usa_default, $id_emp_default);

                            $retorno = 2;
                            echo json_encode($retorno);
                        }

                        $_SESSION["tab"] = 4;
                    }
                } else {

                    $retorno = 0;
                    echo json_encode($retorno);
                }

                break;
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_excluir'])) {
    try {

        $tipo_submit = $_POST["btn_excluir"];

        switch ($tipo_submit) {
            case 'visualizar-missao':

                foreach (selectGESSOB($id_emp_default) as $caminho_excluir) {

                    $caminho_banco_excluir = $caminho_excluir['mis_imagem'];
                }

                updateGESSOB_missao(NULL, NULL, $datatu, $id_usa_default, $id_emp_default);

                if (!empty($caminho_banco_excluir)) {
                    unlink('../../upload/empresa/' . $caminho_banco_excluir . '');
                }

                $_SESSION["tab"] = 1;

                break;
            case 'visualizar-visao':

                foreach (selectGESSOB($id_emp_default) as $caminho_excluir) {

                    $caminho_banco_excluir = $caminho_excluir['vis_imagem'];
                }

                updateGESSOB_visao(NULL, NULL, $datatu, $id_usa_default, $id_emp_default);

                if (!empty($caminho_banco_excluir)) {
                    unlink('../../upload/empresa/' . $caminho_banco_excluir . '');
                }

                $_SESSION["tab"] = 3;

                break;

            case 'visualizar-valores':

                foreach (selectGESSOB($id_emp_default) as $caminho_excluir) {

                    $caminho_banco_excluir = $caminho_excluir['val_imagem'];
                }

                updateGESSOB_valores(NULL, NULL, $datatu, $id_usa_default, $id_emp_default);

                if (!empty($caminho_banco_excluir)) {
                    unlink('../../upload/empresa/' . $caminho_banco_excluir . '');
                }

                $_SESSION["tab"] = 4;

                break;
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}


if ((isset($_POST["btn_visualizar"])) and (isset($_POST["abrir_modal"]))) {

    if ($_POST["abrir_modal"] == 1) {

        $tipo_submit = $_POST["btn_visualizar"];

        try {

            switch ($tipo_submit) {
                case 'visualizar-missao':

                    foreach (selectGESSOB($id_emp_default) as $caminho_view) {

                        $texto_view_arquivo = $caminho_view['mis_texto'];
                        $caminho_view_arquivo = $caminho_view['mis_imagem'];
                    }

                    $retorno = '';

                    $retorno .= '<div conteudo="' . $tipo_submit . '" class="col-md-12 conteudo-modal">';

                    if (empty($caminho_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-center">';

                        $retorno .= '<img src="../../upload/empresa/' . $caminho_view_arquivo . '" class="img-fluid"></img>';

                        $retorno .= '</div>';
                    }

                    if (empty($texto_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-justify">';

                        $retorno .= '<h6 class="text-justify">' . $texto_view_arquivo . '</h6>';

                        $retorno .= '</div>';
                    }

                    $retorno .= '</div>';

                    //retorno da função
                    echo $retorno;

                    $_SESSION["tab"] = 1;

                    break;

                case 'visualizar-visao':

                    foreach (selectGESSOB($id_emp_default) as $caminho_view) {

                        $texto_view_arquivo = $caminho_view['vis_texto'];
                        $caminho_view_arquivo = $caminho_view['vis_imagem'];
                    }

                    $retorno = '';

                    $retorno .= '<div conteudo="' . $tipo_submit . '" class="col-md-12 conteudo-modal">';

                    if (empty($caminho_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-center">';

                        $retorno .= '<img src="../../upload/empresa/' . $caminho_view_arquivo . '" class="img-fluid"></img>';

                        $retorno .= '</div>';
                    }

                    if (empty($texto_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-justify">';

                        $retorno .= '<h6 class="text-justify">' . $texto_view_arquivo . '</h6>';

                        $retorno .= '</div>';
                    }

                    $retorno .= '</div>';

                    //retorno da função
                    echo $retorno;

                    $_SESSION["tab"] = 3;

                    break;

                case 'visualizar-valores':

                    foreach (selectGESSOB($id_emp_default) as $caminho_view) {

                        $texto_view_arquivo = $caminho_view['val_texto'];
                        $caminho_view_arquivo = $caminho_view['val_imagem'];
                    }

                    $retorno = '';

                    $retorno .= '<div conteudo="' . $tipo_submit . '" class="col-md-12 conteudo-modal">';

                    if (empty($caminho_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-center">';

                        $retorno .= '<img src="../../upload/empresa/' . $caminho_view_arquivo . '" class="img-fluid"></img>';

                        $retorno .= '</div>';
                    }

                    if (empty($texto_view_arquivo)) {
                    } else {

                        $retorno .= '<div class="textalign-justify">';

                        $retorno .= '<h6 class="text-justify">' . $texto_view_arquivo . '</h6>';

                        $retorno .= '</div>';
                    }

                    $retorno .= '</div>';

                    //retorno da função
                    echo $retorno;

                    $_SESSION["tab"] = 4;

                    break;
            }
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
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
