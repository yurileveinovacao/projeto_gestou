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

        $tipo = $_POST['tipo'];

        switch ($tipo) {

            case 'img-missao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['mis_imagem'];
                }
                break;

            case 'img-visao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['vis_imagem'];
                }
                break;

            case 'img-valor':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['val_imagem'];
                }
                break;
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

// VISUALIZAR TEXTO
if (isset($_POST['visu_texto'])) {

    try {

        $tipo = $_POST['tipo'];

        switch ($tipo) {

            case 'text-missao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $retorno = $linha['mis_texto'];
                }
                break;

            case 'text-visao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $retorno = $linha['vis_texto'];
                }
                break;

            case 'text-valor':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $retorno = $linha['val_texto'];
                }
                break;
        }

        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT IMAGEM
if (isset($_POST['btn_submit_img'])) {

    try {

        $tipo = $_POST['tipo'];
        $img_nome = $_FILES['file']['name'];
        $img_temp = $_FILES['file']['tmp_name'];
        $img_size = $_FILES['file']['size'];
        $img_tipo = $_FILES['file']['type'];
        $erro = $_FILES['file']['error'];
        $ext = formatarValor('LOWER', pathinfo($img_nome, PATHINFO_EXTENSION));

        if (!empty($img_size)) {

            switch ($tipo) {

                case 'img-missao':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['mis_imagem'];
                        $text_banco = $linha['mis_texto'];
                    }

                    if (empty($linha)) {

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_missao.' . $ext;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        insertGESSOB(
                            $id_emp_default,
                            NULL,
                            NULL,
                            NULL,
                            $img_novonome,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            $datinc,
                            $datatu,
                            $id_usa_default,
                            $id_usa_default
                        );

                        $retorno = 1;
                        echo json_encode($retorno);
                    } else {

                        if (!empty($img_banco)) {

                            unlink('../../upload/empresa/' . $img_banco . '');
                        }

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_missao.' . $ext;
                        //$novo_nomeimg= 'teste'.'.'.$extensao;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        updateGESSOB_missao(
                            $text_banco,
                            $img_novonome,
                            $datatu,
                            $id_usa_default,
                            $id_emp_default
                        );

                        $retorno = 2;
                        echo json_encode($retorno);
                    }
                    break;

                case 'img-visao':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['vis_imagem'];
                        $text_banco = $linha['vis_texto'];
                    }

                    if (empty($linha)) {

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_visao.' . $ext;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        insertGESSOB(
                            $id_emp_default,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            $img_novonome,
                            $datinc,
                            $datatu,
                            $id_usa_default,
                            $id_usa_default
                        );

                        $retorno = 1;
                        echo json_encode($retorno);
                    } else {

                        if (!empty($img_banco)) {

                            unlink('../../upload/empresa/' . $img_banco . '');
                        }

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_visao.' . $ext;
                        //$novo_nomeimg= 'teste'.'.'.$extensao;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        updateGESSOB_visao(
                            $text_banco,
                            $img_novonome,
                            $datatu,
                            $id_usa_default,
                            $id_emp_default
                        );

                        $retorno = 2;
                        echo json_encode($retorno);
                    }
                    break;

                case 'img-valor':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['val_imagem'];
                        $text_banco = $linha['val_texto'];
                    }

                    if (empty($linha)) {

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_valores.' . $ext;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        insertGESSOB(
                            $id_emp_default,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            $img_novonome,
                            NULL,
                            NULL,
                            $datinc,
                            $datatu,
                            $id_usa_default,
                            $id_usa_default
                        );

                        $retorno = 1;
                        echo json_encode($retorno);
                    } else {

                        if (!empty($img_banco)) {

                            unlink('../../upload/empresa/' . $img_banco . '');
                        }

                        //renomear o nome da imagem
                        $img_novonome = $raiz_cnpj . "_" . uniqidReal() . '_valores.' . $ext;
                        //$novo_nomeimg= 'teste'.'.'.$extensao;

                        //Comando para mover o arquivo para a pasta
                        $mover = move_uploaded_file($img_temp, '../../upload/empresa/' . $img_novonome);

                        updateGESSOB_valores(
                            $text_banco,
                            $img_novonome,
                            $datatu,
                            $id_usa_default,
                            $id_emp_default
                        );

                        $retorno = 2;
                        echo json_encode($retorno);
                    }
                    break;

                default:
                    echo 'Erro ao verificar o tipo de imagem que será atualizada.';
                    break;
            }
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// EXLCUIR IMAGEM
if (isset($_POST['btn_exc_img'])) {

    try {

        $tipo = $_POST['tipo'];

        switch ($tipo) {

            case 'img-missao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $img_banco = $linha['mis_imagem'];
                    $text_banco = $linha['mis_texto'];
                }

                updateGESSOB_missao(
                    $text_banco,
                    NULL,
                    $datatu,
                    $id_usa_default,
                    $id_emp_default
                );

                unlink('../../upload/empresa/' . $img_banco . '');

                echo 1;
                break;

            case 'img-visao':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $img_banco = $linha['vis_imagem'];
                    $text_banco = $linha['vis_texto'];
                }

                updateGESSOB_visao(
                    $text_banco,
                    NULL,
                    $datatu,
                    $id_usa_default,
                    $id_emp_default
                );

                unlink('../../upload/empresa/' . $img_banco . '');

                echo 2;
                break;

            case 'img-valor':
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $img_banco = $linha['val_imagem'];
                    $text_banco = $linha['val_texto'];
                }

                updateGESSOB_valores(
                    $text_banco,
                    NULL,
                    $datatu,
                    $id_usa_default,
                    $id_emp_default
                );

                unlink('../../upload/empresa/' . $img_banco . '');

                echo 3;
                break;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT TEXTO
if (isset($_POST['btn_submit_text'])) {

    try {

        $tipo = $_POST['tipo'];
        $texto = trim($_POST['texto']);

        // Remover as tags HTML
        $textoSemTags = strip_tags($texto);

        // Contar os caracteres
        $numCaracteres = strlen($textoSemTags);


        if ($numCaracteres <= 5000) {
            switch ($tipo) {

                case 'text-missao':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['mis_imagem'];
                    }

                    if (empty($texto)) {

                        $texto = NULL;
                    }

                    updateGESSOB_missao(
                        $texto,
                        $img_banco,
                        $datatu,
                        $id_usa_default,
                        $id_emp_default
                    );

                    echo 1;
                    break;

                case 'text-visao':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['vis_imagem'];
                    }

                    if (empty($texto)) {

                        $texto = NULL;
                    }

                    updateGESSOB_visao(
                        $texto,
                        $img_banco,
                        $datatu,
                        $id_usa_default,
                        $id_emp_default
                    );

                    echo 1;
                    break;

                case 'text-valor':
                    foreach (selectGESSOB($id_emp_default) as $linha) {

                        $img_banco = $linha['val_imagem'];
                    }

                    if (empty($texto)) {

                        $texto = NULL;
                    }

                    updateGESSOB_valores(
                        $texto,
                        $img_banco,
                        $datatu,
                        $id_usa_default,
                        $id_emp_default
                    );

                    echo 1;
                    break;
            }
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if (isset($_POST['visu_img'])) {

    try {
        // Obtém o tipo de imagem do formulário
        $tipo = $_POST['tipo'];

        switch ($tipo) {

            case 'Missão':
                // Obtém a imagem da tabela usando a função selectGESSOB para o tipo 'Missão'
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['mis_imagem'];
                }
                break;

            case 'Visão':
                // Obtém a imagem da tabela usando a função selectGESSOB para o tipo 'Visão'
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['vis_imagem'];
                }
                break;

            case 'Valores':
                // Obtém a imagem da tabela usando a função selectGESSOB para o tipo 'Valores'
                foreach (selectGESSOB($id_emp_default) as $linha) {

                    $imagem = $linha['val_imagem'];
                }
                break;
        }

        // Cria a tag <img> com o caminho da imagem e define o estilo
        $retorno = '<img src="../upload/empresa/' . $imagem . '" style="max-height: 80vh; width: auto;" class="img-fluid">';

        // Exibe a imagem na página
        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}


/**
 * 
 * Funções
 * 
 */
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
