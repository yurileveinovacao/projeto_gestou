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

/**
 * Tabela Colaboradores
 */

if ((isset($_POST['btn_situac'])) and (isset($_POST['colaborador_situac']))) {
    try {

        $id_usu_ativo = $_POST["colaborador_situac"];

        foreach (selectGESUSU($id_usu_ativo) as $caminho_ativo) {

            $situac_update = $caminho_ativo['situac'];
            $cpf = $caminho_ativo['cpf'];
        }

        if ($situac_update == 0) {

            foreach (selectGESUSU_CPF($cpf) as $count_cpf) {

                $verifica_cpf = $count_cpf["contagem_cpf"];
            }
        }

        $situac = formatarValor('SITUAC', $situac_update);

        if (!empty($cpf)) {

            if (empty($verifica_cpf)) {

                updateGESUSU_SITUAC($situac, $id_emp_default, $id_usu_ativo, $datatu, $id_usa_default);

                // FEA-001: preenche datarescisao automaticamente na desativação
                if ($situac == 0) {
                    updateGESUSU_DATARESCISAO($id_usu_ativo, date('Y-m-d'));
                }
            } else {

                echo 1;
            }
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if ((isset($_POST['btn_visualizar'])) and (isset($_POST['colaborador_visualizar']))) {

    try {

        $_SESSION["colaborador_visualizar"] = $_POST['colaborador_visualizar'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if ((isset($_POST['btn_editar'])) and (isset($_POST['colaborador_editar']))) {

    try {

        $_SESSION["colaborador_editar"] = $_POST['colaborador_editar'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if ((isset($_POST["abrir_modal"])) and (isset($_POST["colaborador_aniversario"]))) {

    if ($_POST["abrir_modal"] == 1) {

        try {

            $colaborador_aniversario = $_POST["colaborador_aniversario"];

            foreach (selectGESUSU_FOTO_APROVACAO($colaborador_aniversario) as $caminho_view) {

                $imagem_aniversario = $caminho_view['imagem'];
                $imagem_aprovacao_aniversario = $caminho_view['imagem_aprovacao'];
            }

            $retorno = '';

            if (empty($imagem_aprovacao_aniversario)) {

                $retorno .= '<div class="modal-header">';
                $retorno .= '<h5 class="modal-title">Visualizar Foto</h5>';
                $retorno .= '<button class="close" type="button" data-dismiss="modal" aria-label="Close">';
                $retorno .= '<span aria-hidden="true">×</span>';
                $retorno .= '</button>';
                $retorno .= '</div>';
                $retorno .= '<div class="modal-body">';
                $retorno .= '<div class="col-md-12 text-center">';

                $retorno .= '<img src="../../upload/cadastro/' . $imagem_aniversario . '" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />';

                $retorno .= '</div>';
                $retorno .= '</div>';
                $retorno .= '<div class="modal-footer">';
                $retorno .= '<button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>';
                $retorno .= '</div>';
            } else {

                $retorno .= '<div class="modal-header">';
                $retorno .= '<h5 class="modal-title">Validar Foto</h5>';
                $retorno .= '<button class="close" type="button" data-dismiss="modal" aria-label="Close">';
                $retorno .= '<span aria-hidden="true">×</span>';
                $retorno .= '</button>';
                $retorno .= '</div>';
                $retorno .= '<div class="modal-body">';
                $retorno .= '<div class="col-md-12 text-center">';

                $retorno .= '<img src="../../upload/cadastro/aprovacao/' . $imagem_aprovacao_aniversario . '" style="width: 150px;" class="gambar img-responsive img-thumbnail" id="item-img-output" />';

                $retorno .= '</div>';
                $retorno .= '</div>';
                $retorno .= '<div class="modal-footer">';
                $retorno .= '<button type="button" id="btn-aprovar" colaborador="' . $colaborador_aniversario . '" class="btn btn-primary btn-icon-split-organograma"><i class="fas fa-check"></i>Aprovar</button>';
                $retorno .= '<button type="button" id="btn-reprovar" colaborador="' . $colaborador_aniversario . '" class="btn btn-danger btn-icon-split-organograma"><i class="fas fa-times"></i>Reprovar</button>';
                $retorno .= '<button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>';
                $retorno .= '</div>';
            }

            //retorno da função
            echo $retorno;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    }
}

if ((isset($_POST['situac_foto'])) and (isset($_POST['colaborador_foto']))) {
    try {

        $situac_foto = $_POST["situac_foto"];
        $colaborador_foto = $_POST["colaborador_foto"];

        if ($situac_foto == 1) {

            $situacao = "APROVADA";

            foreach (selectGESUSU_FOTO_APROVACAO($colaborador_foto) as $imagem_banco) {

                $imagem_aprovacao = $imagem_banco["imagem_aprovacao"];
            }

            $origem = '../../upload/cadastro/aprovacao/' . $imagem_aprovacao . '';
            $destino = '../../upload/cadastro/' . $imagem_aprovacao . '';

            if (copy($origem, $destino)) {

                // echo "Arquivo copiado com Sucesso.";
                unlink('../../upload/cadastro/aprovacao/' . $imagem_aprovacao . '');
                updateGESUSU_FOTO_APROV($imagem_aprovacao, $colaborador_foto, $datatu, $id_usa_default);

                /*
                foreach (select_EMAIL_COLABORADOR($colaborador_foto) as $email) {

                    $nome_colaborador = $email["nome"];
                    $email_colaborador = $email["email"];

                    require "../email_aprovacao_foto.php";
                }
                */

                $retorno = 1;
                echo json_encode($retorno);
            } else {

                $retorno = 0;
                echo json_encode($retorno);

                // echo "Erro ao copiar arquivo.";
            }
        } elseif ($situac_foto == 0) {

            $situacao = "REPROVADA";

            foreach (selectGESUSU_FOTO_APROVACAO($colaborador_foto) as $imagem_banco) {

                $imagem_aprovacao = $imagem_banco["imagem_aprovacao"];
            }

            unlink('../../upload/cadastro/aprovacao/' . $imagem_aprovacao . '');
            updateGESUSU_FOTO_REPROV($colaborador_foto, $datatu, $id_usa_default);

            /*
            foreach (select_EMAIL_COLABORADOR($colaborador_foto) as $email) {

                $nome_colaborador = $email["nome"];
                $email_colaborador = $email["email"];

                require "../email_aprovacao_foto.php";
            }
            */

            $retorno = 1;
            echo json_encode($retorno);
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if ((isset($_POST['btn_excluir'])) and (isset($_POST['selecionados']))) {
    try {

        $selecionados = $_POST["selecionados"];

        foreach ($selecionados as $valores) {

            $id_usu = intval($valores);

            foreach (selectGESUSU_FOTO($id_usu) as $caminho_excluir) {

                $caminho_banco_excluir = $caminho_excluir['imagem'];

                if (!empty($caminho_banco_excluir)) {

                    if (deleteGESUSU($id_usu)) {

                        unlink('../../upload/cadastro/' . $caminho_banco_excluir . '');
                    }
                } else {

                    deleteGESUSU($id_usu);
                }
            }
        }

        echo 1;
    } catch (PDOException $erro) {

        $mensagemErro = $erro->getMessage();

        if (strpos($mensagemErro, '23503') !== false) {

            echo 0;
        } else {

            echo $mensagemErro;
        }
    }
}

if (isset($_POST['btn_voltar'])) {

    try {

        unset($_SESSION["colaborador_editar"]);
        unset($_SESSION["colaborador_visualizar"]);
        unset($_SESSION["colaborador_beneficios"]);
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

/**
 * Cadastro Colaboradores
 */

// Função no botão SALVAR
if (isset($_POST['btn_cadastro'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_cadastro'], 3);
    $emailValido = validarValor('REGEX', $_POST['email_cadastro'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_cadastro'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
    // $estadoValido = validarValor('VALID', $_POST['estado_update'], 1);
    $cidadeValido = validarValor('VALID', $_POST['cidade_cadastro'], 1);

    // echo "nomeValido:" . $nomeValido . "<br>";
    // echo "emailValido:" . $emailValido . "<br>";
    // echo "cpfValido:" . $cpfValido . "<br>";
    // echo "estadoValido:" . $estadoValido . "<br>";
    // echo "cidadeValido:" . $cidadeValido . "<br>";

    // Se os valores forem validados continua com o update
    if ($nomeValido && $emailValido && $cpfValido && $cidadeValido) {

        try {

            // Atribui o valor do id_usu
            $id_fun = $_POST['colaborador'];

            // Atribui valor das Variáveis
            $nome_cadastro = $_POST['nome_cadastro']; //REQUIRED
            $rg_cadastro = $_POST['rg_cadastro'];
            $cpf_cadastro = $_POST['cpf_cadastro']; //REQUIRED
            $email_cadastro = $_POST['email_cadastro'];
            $telefone_cadastro = $_POST['telefone_cadastro'];
            $celular_cadastro = $_POST['celular_cadastro'];
            $departamento_cadastro = $_POST['departamento_cadastro'];
            $gestor_cadastro = $_POST['gestor_cadastro'];
            $datanasc_cadastro = $_POST['datanasc_cadastro'];
            $dataadmis_cadastro = $_POST['dataadmis_cadastro'];

            // Endereço
            $endereco_cadastro = $_POST['endereco_cadastro'];
            $numero_cadastro = $_POST['numero_cadastro'];
            $bairro_cadastro = $_POST['bairro_cadastro'];
            $complemento_cadastro = $_POST['complemento_cadastro'];
            // $estado_cadastro = $_POST['estado_cadastro']; //REQUIRED
            $cidade_cadastro = $_POST['cidade_cadastro']; //REQUIRED
            $cep_cadastro = $_POST['cep_cadastro'];

            // Outras Informações
            $pis_cadastro = $_POST['pis_cadastro'];
            $ctps_cadastro = $_POST['ctps_cadastro'];
            $tituloeleitor_cadastro = $_POST['tituloeleitor_cadastro'];
            $cbo_cadastro = $_POST['cbo_cadastro'];
            $linkedin_cadastro = $_POST['linkedin_cadastro'];
            $tiposalario_cadastro = $_POST['tiposalario_cadastro'];
            $salario_cadastro = $_POST['salario_cadastro'];
            $dependentes_cadastro = $_POST['dependentes_cadastro'];
            $funcao_cadastro = $_POST['funcao_cadastro'];
            $sexo_cadastro = $_POST['sexo_cadastro'];
            $escolaridade_cadastro = $_POST['escolaridade_cadastro'];
            $datarescisao_cadastro = $_POST['datarescisao_cadastro'];

            // Formata as variáveis
            // Geral
            $nome = formatarValor("UPPER", $nome_cadastro);
            $rg = formatarValor("*", $rg_cadastro);
            $cpf = formatarValor("NUM", $cpf_cadastro);
            $email = formatarValor("LOWER", $email_cadastro);
            $telefone = formatarValor("NUM", $telefone_cadastro);
            $celular = formatarValor("NUM", $celular_cadastro);
            $departamento = formatarValor("*", $departamento_cadastro);
            $gestor = formatarValor("*", $gestor_cadastro);
            $datanasc = formatarValor("DATE", $datanasc_cadastro);
            $dataadmis = formatarValor("DATE", $dataadmis_cadastro);


            if (!empty($datanasc)) {

                $verificaDataNasc = explode('/', $datanasc_cadastro);
                $dataNascVerificada = checkdate(intval($verificaDataNasc[1]), intval($verificaDataNasc[0]), intval($verificaDataNasc[2]));

                if ($dataNascVerificada) {

                    $data_atual = formatarValor('DATE', $data);

                    $datetime_subtrair = date_create($datanasc);
                    $datetime_atual = date_create($data_atual);

                    $intervalo_data = $datetime_subtrair->diff($datetime_atual);

                    if ($intervalo_data->y < 15) {

                        $dataNascIdade = false;
                    } else {

                        $dataNascIdade = true;
                    }
                }
            } else {

                $dataNascVerificada = true;
                $dataNascIdade = true;
            }

            if (!empty($dataadmis)) {

                if (!empty($datanasc)) {

                    if (strtotime($dataadmis) > strtotime($datanasc)) {

                        $dataAdmisValida = true;
                    } else {

                        $dataAdmisValida = false;
                    }
                } else {

                    $dataAdmisValida = true;
                }

                $verificaDataAdmis = explode('/', $dataadmis_cadastro);
                $dataAdmisVerificada = checkdate(intval($verificaDataAdmis[1]), intval($verificaDataAdmis[0]), intval($verificaDataAdmis[2]));
            } else {

                $dataAdmisVerificada = true;
                $dataAdmisValida = true;
            }

            // Endereço
            $endereco = formatarValor("UPPER", $endereco_cadastro);
            $numero = formatarValor("UPPER", $numero_cadastro);
            $bairro = formatarValor("UPPER", $bairro_cadastro);
            $complemento = formatarValor("UPPER", $complemento_cadastro);
            // $estado = formatarValor("*", $estado_cadastro);
            $cidade = formatarValor("*", $cidade_cadastro);
            $cep = formatarValor("NUM", $cep_cadastro);

            // Outras Informações
            $pis = formatarValor("NUM", $pis_cadastro);
            $ctps = formatarValor("*", $ctps_cadastro);
            $tituloeleitor = formatarValor("NUM", $tituloeleitor_cadastro);
            $cbo = formatarValor("NUM", $cbo_cadastro);
            $linkedin = formatarValor("*", $linkedin_cadastro);
            $tiposalario = formatarValor("*", $tiposalario_cadastro);
            $salario = formatarValor("VALOR_DECIMAL", $salario_cadastro);
            $dependentes = formatarValor("*", $dependentes_cadastro);
            $funcao = formatarValor("UPPER", $funcao_cadastro);
            $sexo = formatarValor("*", $sexo_cadastro);
            $escolaridade = formatarValor("*", $escolaridade_cadastro);
            $datarescisao = formatarValor("DATE", $datarescisao_cadastro);

            // CRIA HASH DA SENHA
            $hash = 123;
            $senha = password_hash($hash, PASSWORD_DEFAULT);

            $situac = 1;
            $id_emp_ant = 0;

            foreach (selectGESUSU_EMAIL($email) as $count_email) {

                $verifica_email = $count_email["count"];
            }

            foreach (selectGESUSU_CELULAR($celular) as $count_celular) {

                $verifica_telefone_celular = $count_celular["contagem"];
            }

            foreach (selectGESUSU_CPF($cpf) as $count_cpf) {

                $verifica_cpf = $count_cpf["contagem_cpf"];
            }

            foreach (selectGESUSU_CPF_EMP('CAD', $cpf, $id_emp_default, $id_fun) as $count_cpf_emp) {

                $verifica_cpf_emp = $count_cpf_emp["contagem_cpf"];
            }

            if ($dataNascVerificada) {

                if ($dataNascIdade) {

                    if ($dataAdmisVerificada) {

                        if ($dataAdmisValida) {

                            if ($verifica_email == 0) {

                                if ($verifica_telefone_celular == 0) {

                                    if ($verifica_cpf == 0) {

                                        if ($verifica_cpf_emp == 0) {

                                            insertGESUSU($nome, $cpf, $senha, $datinc, $situac, $rg, $celular, $email, $telefone, $cidade, $dataadmis, $datanasc, $ctps, $pis, $cbo, $tituloeleitor, NULL, $funcao, NULL, $tiposalario, $endereco, $complemento, $bairro, $dependentes, $salario, $numero, $departamento, $gestor, $sexo, $escolaridade, $linkedin, $cep, $id_emp_default, $id_emp_ant, $datatu, $id_usa_default, $id_usa_default);

                                            $retorno = 1;
                                            echo json_encode($retorno);

                                            // $retorno = '';

                                            // $retorno .= 'Nome:' . $nome . '<br>';
                                            // $retorno .= 'RG:' . $rg . '<br>';
                                            // $retorno .= 'cpf:' . $cpf . '<br>';
                                            // $retorno .= 'email:' . $email . '<br>';
                                            // $retorno .= 'telefone:' . $telefone . '<br>';
                                            // $retorno .= 'celular:' . $celular . '<br>';
                                            // $retorno .= 'departamento:' . $departamento . '<br>';
                                            // $retorno .= 'gestor:' . $gestor . '<br>';
                                            // $retorno .= 'datanasc:' . $datanasc . '<br>';
                                            // $retorno .= 'dataadmis:' . $dataadmis . '<br>';

                                            // $retorno .= 'endereco:' . $endereco . '<br>';
                                            // $retorno .= 'numero:' . $numero . '<br>';
                                            // $retorno .= 'bairro:' . $bairro . '<br>';
                                            // $retorno .= 'complemento:' . $complemento . '<br>';
                                            // // $retorno .= 'estado:' . $estado . '<br>';
                                            // $retorno .= 'cidade:' . $cidade . '<br>';
                                            // $retorno .= 'cep:' . $cep . '<br>';

                                            // $retorno .= 'pis:' . $pis . '<br>';
                                            // $retorno .= 'ctps:' . $ctps . '<br>';
                                            // $retorno .= 'tituloeleitor:' . $tituloeleitor . '<br>';
                                            // $retorno .= 'cbo:' . $cbo . '<br>';
                                            // $retorno .= 'linkedin:' . $linkedin . '<br>';
                                            // $retorno .= 'tiposalario:' . $tiposalario . '<br>';
                                            // $retorno .= 'salario:' . $salario . '<br>';
                                            // $retorno .= 'dependentes:' . $dependentes . '<br>';
                                            // $retorno .= 'funcao:' . $funcao . '<br>';
                                            // $retorno .= 'sexo:' . $sexo . '<br>';
                                            // $retorno .= 'escolaridade:' . $escolaridade . '<br>';
                                            // $retorno .= 'datarescisao:' . $datarescisao . '<br>';

                                            // $retorno .= 'cod_integracao:' . $cod_integracao . '<br>';
                                            // $retorno .= 'agrdep:' . $agrdep . '<br>';
                                            // $retorno .= 'bloqueado:' . $bloqueado . '<br>';

                                            // echo $retorno;

                                        } else {

                                            $retorno = 5;
                                            echo json_encode($retorno);
                                        }
                                    } else {

                                        $retorno = 2;
                                        echo json_encode($retorno);
                                    }
                                } else {

                                    $retorno = 3;
                                    echo json_encode($retorno);
                                }
                            } else {

                                $retorno = 4;
                                echo json_encode($retorno);
                            }
                        } else {

                            $retorno = 9;
                            echo json_encode($retorno);
                        }
                    } else {

                        $retorno = 7;
                        echo json_encode($retorno);
                    }
                } else {

                    $retorno = 8;
                    echo json_encode($retorno);
                }
            } else {

                $retorno = 6;
                echo json_encode($retorno);
            }
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        $retorno = 0;
        echo json_encode($retorno);
    }
}

/**
 * Alterar Colaborador
 */


// Função no botão SALVAR
if (isset($_POST['btn_submit'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarValor('VALID', $_POST['nome_update'], 3);
    $emailValido = validarValor('REGEX', $_POST['email_update'], '/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf_update'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
    // $estadoValido = validarValor('VALID', $_POST['estado_update'], 1);
    $cidadeValido = validarValor('VALID', $_POST['cidade_update'], 1);

    // echo "nomeValido:" . $nomeValido . "<br>";
    // echo "emailValido:" . $emailValido . "<br>";
    // echo "cpfValido:" . $cpfValido . "<br>";
    // echo "estadoValido:" . $estadoValido . "<br>";
    // echo "cidadeValido:" . $cidadeValido . "<br>";

    // Se os valores forem validados continua com o update
    if ($nomeValido && $emailValido && $cpfValido && $cidadeValido) {

        try {

            // Atribui o valor do id_usu
            $id_fun = $_POST['colaborador'];

            // Atribui valor das Variáveis
            $nome_update = $_POST['nome_update']; //REQUIRED
            $rg_update = $_POST['rg_update'];
            $cpf_update = $_POST['cpf_update']; //REQUIRED
            $email_update = $_POST['email_update'];
            $telefone_update = $_POST['telefone_update'];
            $celular_update = $_POST['celular_update'];
            $departamento_update = $_POST['departamento_update'];
            $gestor_update = $_POST['gestor_update'];
            $datanasc_update = $_POST['datanasc_update'];
            $dataadmis_update = $_POST['dataadmis_update'];

            // Endereço
            $endereco_update = $_POST['endereco_update'];
            $numero_update = $_POST['numero_update'];
            $bairro_update = $_POST['bairro_update'];
            $complemento_update = $_POST['complemento_update'];
            // $estado_update = $_POST['estado_update']; //REQUIRED
            $cidade_update = $_POST['cidade_update']; //REQUIRED
            $cep_update = $_POST['cep_update'];

            // Outras Informações
            $pis_update = $_POST['pis_update'];
            $ctps_update = $_POST['ctps_update'];
            $tituloeleitor_update = $_POST['tituloeleitor_update'];
            $cbo_update = $_POST['cbo_update'];
            $linkedin_update = $_POST['linkedin_update'];
            $tiposalario_update = $_POST['tiposalario_update'];
            $salario_update = $_POST['salario_update'];
            $dependentes_update = $_POST['dependentes_update'];
            $funcao_update = $_POST['funcao_update'];
            $sexo_update = $_POST['sexo_update'];
            $escolaridade_update = $_POST['escolaridade_update'];
            $datarescisao_update = $_POST['datarescisao_update'];

            // Integração
            $codintegracao_update = $_POST['codintegracao_update'];
            $agrdep_update = $_POST['agrdep_update'];
            $bloqueado_update = $_POST['bloqueado_update'];

            // Formata as variáveis
            // Geral
            $nome = formatarValor("UPPER", $nome_update);
            $rg = formatarValor("*", $rg_update);
            $cpf = formatarValor("NUM", $cpf_update);
            $email = formatarValor("LOWER", $email_update);
            $telefone = formatarValor("NUM", $telefone_update);
            $celular = formatarValor("NUM", $celular_update);
            $departamento = formatarValor("*", $departamento_update);
            $gestor = formatarValor("*", $gestor_update);
            $datanasc = formatarValor("DATE", $datanasc_update);
            $dataadmis = formatarValor("DATE", $dataadmis_update);

            // Endereço
            $endereco = formatarValor("UPPER", $endereco_update);
            $numero = formatarValor("UPPER", $numero_update);
            $bairro = formatarValor("UPPER", $bairro_update);
            $complemento = formatarValor("UPPER", $complemento_update);
            // $estado = formatarValor("*", $estado_update);
            $cidade = formatarValor("*", $cidade_update);
            $cep = formatarValor("NUM", $cep_update);

            // Outras Informações
            $pis = formatarValor("NUM", $pis_update);
            $ctps = formatarValor("*", $ctps_update);
            $tituloeleitor = formatarValor("NUM", $tituloeleitor_update);
            $cbo = formatarValor("NUM", $cbo_update);
            $linkedin = formatarValor("*", $linkedin_update);
            $tiposalario = formatarValor("*", $tiposalario_update);
            $salario = formatarValor("VALOR_DECIMAL", $salario_update);
            $dependentes = formatarValor("*", $dependentes_update);
            $funcao = formatarValor("UPPER", $funcao_update);
            $sexo = formatarValor("*", $sexo_update);
            $escolaridade = formatarValor("*", $escolaridade_update);
            $datarescisao = formatarValor("DATE", $datarescisao_update);

            // Parametros
            $cod_integracao = formatarValor("NUM", $codintegracao_update);
            $agrdep = formatarValor("CHECKBOX", $agrdep_update);
            $bloqueado = formatarValor("CHECKBOX", $bloqueado_update);


            if (!empty($datanasc)) {

                $verificaDataNasc = explode('/', $datanasc_update);
                $dataNascVerificada = checkdate(intval($verificaDataNasc[1]), intval($verificaDataNasc[0]), intval($verificaDataNasc[2]));

                if ($dataNascVerificada) {

                    $data_atual = formatarValor('DATE', $data);

                    $datetime_subtrair = date_create($datanasc);
                    $datetime_atual = date_create($data_atual);

                    $intervalo_data = $datetime_subtrair->diff($datetime_atual);

                    if ($intervalo_data->y < 15) {

                        $dataNascIdade = false;
                    } else {

                        $dataNascIdade = true;
                    }
                }
            } else {

                $dataNascVerificada = true;
                $dataNascIdade = true;
            }

            if (!empty($dataadmis)) {

                if (!empty($datanasc)) {

                    if (strtotime($dataadmis) > strtotime($datanasc)) {

                        $dataAdmisValida = true;
                    } else {

                        $dataAdmisValida = false;
                    }
                } else {

                    $dataAdmisValida = true;
                }

                $verificaDataAdmis = explode('/', $dataadmis_update);
                $dataAdmisVerificada = checkdate(intval($verificaDataAdmis[1]), intval($verificaDataAdmis[0]), intval($verificaDataAdmis[2]));
            } else {

                $dataAdmisVerificada = true;
                $dataAdmisValida = true;
            }

            if ($bloqueado == 1) {

                $situac_funcionario = 0;
                updateGESUSU_SITUAC($situac_funcionario, $id_emp_default, $id_fun, $datatu, $id_usa_default);
            }

            foreach (selectGESUSU_EMAIL_id_usu($email, $id_fun) as $count_email) {

                $verifica_email = $count_email["count"];
            }

            foreach (selectGESUSU_CELULAR_id_usu($celular, $id_fun) as $count_celular) {

                $verifica_telefone_celular = $count_celular["contagem"];
            }

            foreach (selectGESUSU_CPF_id_usu($cpf, $id_fun) as $count_cpf) {

                $verifica_cpf = $count_cpf["contagem_cpf"];
            }

            foreach (selectGESUSU_CPF_EMP('ALT', $cpf, $id_emp_default, $id_fun) as $count_cpf_emp) {

                $verifica_cpf_emp = $count_cpf_emp["contagem_cpf"];
            }

            if ($dataNascVerificada) {

                if ($dataNascIdade) {

                    if ($dataAdmisVerificada) {

                        if ($dataAdmisValida) {

                            if ($verifica_email == 0) {

                                if ($verifica_telefone_celular == 0) {

                                    if ($verifica_cpf == 0) {

                                        if ($verifica_cpf_emp == 0) {

                                            updateGESUSU_alterar_funcionario($nome, $cpf, $rg, $celular, $email, $telefone, $cidade, $dataadmis, $datanasc, $ctps, $pis, $cbo, $tituloeleitor, $datarescisao, $funcao, $tiposalario, $endereco, $complemento, $bairro, $dependentes, $salario, $numero, $departamento, $gestor, $sexo, $escolaridade, $agrdep, $linkedin, $cod_integracao, $cep, $bloqueado, $id_emp_default, $id_fun, $datatu, $id_usa_default);

                                            unset($_SESSION["colaborador_editar"]);

                                            $retorno = 1;
                                            echo json_encode($retorno);

                                            // $retorno = '';

                                            // $retorno .= 'Nome:' . $nome . '<br>';
                                            // $retorno .= 'RG:' . $rg . '<br>';
                                            // $retorno .= 'cpf:' . $cpf . '<br>';
                                            // $retorno .= 'email:' . $email . '<br>';
                                            // $retorno .= 'telefone:' . $telefone . '<br>';
                                            // $retorno .= 'celular:' . $celular . '<br>';
                                            // $retorno .= 'departamento:' . $departamento . '<br>';
                                            // $retorno .= 'gestor:' . $gestor . '<br>';
                                            // $retorno .= 'datanasc:' . $datanasc . '<br>';
                                            // $retorno .= 'dataadmis:' . $dataadmis . '<br>';

                                            // $retorno .= 'endereco:' . $endereco . '<br>';
                                            // $retorno .= 'numero:' . $numero . '<br>';
                                            // $retorno .= 'bairro:' . $bairro . '<br>';
                                            // $retorno .= 'complemento:' . $complemento . '<br>';
                                            // // $retorno .= 'estado:' . $estado . '<br>';
                                            // $retorno .= 'cidade:' . $cidade . '<br>';
                                            // $retorno .= 'cep:' . $cep . '<br>';

                                            // $retorno .= 'pis:' . $pis . '<br>';
                                            // $retorno .= 'ctps:' . $ctps . '<br>';
                                            // $retorno .= 'tituloeleitor:' . $tituloeleitor . '<br>';
                                            // $retorno .= 'cbo:' . $cbo . '<br>';
                                            // $retorno .= 'linkedin:' . $linkedin . '<br>';
                                            // $retorno .= 'tiposalario:' . $tiposalario . '<br>';
                                            // $retorno .= 'salario:' . $salario . '<br>';
                                            // $retorno .= 'dependentes:' . $dependentes . '<br>';
                                            // $retorno .= 'funcao:' . $funcao . '<br>';
                                            // $retorno .= 'sexo:' . $sexo . '<br>';
                                            // $retorno .= 'escolaridade:' . $escolaridade . '<br>';
                                            // $retorno .= 'datarescisao:' . $datarescisao . '<br>';

                                            // $retorno .= 'cod_integracao:' . $cod_integracao . '<br>';
                                            // $retorno .= 'agrdep:' . $agrdep . '<br>';
                                            // $retorno .= 'bloqueado:' . $bloqueado . '<br>';

                                            // echo $retorno;

                                        } else {

                                            $retorno = 5;
                                            echo json_encode($retorno);
                                        }
                                    } else {

                                        $retorno = 2;
                                        echo json_encode($retorno);
                                    }
                                } else {

                                    $retorno = 3;
                                    echo json_encode($retorno);
                                }
                            } else {

                                $retorno = 4;
                                echo json_encode($retorno);
                            }
                        } else {

                            $retorno = 9;
                            echo json_encode($retorno);
                        }
                    } else {

                        $retorno = 7;
                        echo json_encode($retorno);
                    }
                } else {

                    $retorno = 8;
                    echo json_encode($retorno);
                }
            } else {

                $retorno = 6;
                echo json_encode($retorno);
            }
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        $retorno = 0;
        echo json_encode($retorno);
    }
}

// Função no botão SALVAR
if ((isset($_POST['btn_senha'])) and (isset($_POST['colaborador_senha']))) {

    // Chama a função para validar os POSTs
    $senhaValida = validarValor('VALID', $_POST['senha'], 3);
    $confirmsenhaValida = validarValor('VALID', $_POST['confirm_senha'], 3);

    if ($senhaValida && $confirmsenhaValida) {

        try {

            $id_fun = $_POST['colaborador_senha'];

            // Atribui valor das Variáveis
            $senha = $_POST['senha']; //REQUIRED
            $confirm_senha = $_POST['confirm_senha']; //REQUIRED

            if ($senha == $confirm_senha) {

                // echo $senha . "||" . $confirm_senha;

                $new_senha = password_hash($senha, PASSWORD_DEFAULT);
                troca_senha_GESUSU($new_senha, $datatu, $id_usa_default, $id_fun);

                $retorno = 1;
                echo json_encode($retorno);
            } else {

                $retorno = 2;
                echo json_encode($retorno);
            }
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        $retorno = 0;
        echo json_encode($retorno);
    }
}

if ((isset($_POST['btn_removerfoto'])) && (isset($_POST['colaborador_removerfoto']))) {

    $btn_removerfoto = $_POST["btn_removerfoto"];
    $colaborador_removerfoto = $_POST["colaborador_removerfoto"];

    try {

        if ($btn_removerfoto == 1) {

            // $id_fun_foto = $_REQUEST["remover_foto"];

            foreach (selectGESUSU_FOTO($colaborador_removerfoto) as $foto_banco) {

                $imagem = $foto_banco["imagem"];
            }

            if (!empty($imagem)) {

                unlink('../../upload/cadastro/' . $imagem . '');

                updateGESUSU_FOTO(NULL, $colaborador_removerfoto, $datatu, $id_usa_default);
            }

            $retorno = 1;
            echo json_encode($retorno);
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_lancar'])) {

    try {

        $id_mnu_page = 54;

        foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, $id_mnu_page) as $select_permissao_usa) {

            $situac_permissao_page = $select_permissao_usa['situac'];
        }

        if ($situac_permissao_page == 1) {

            echo 1;
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

/**
 * Benefícios 
 */

if ((isset($_POST['btn_beneficios'])) and (isset($_POST['colaborador_beneficios']))) {

    try {

        $_SESSION["colaborador_beneficios"] = $_POST['colaborador_beneficios'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

/**
 * Filtros 
 */
if ((isset($_POST['btn_filtrar'])) and (isset($_POST['colaborador_filtro_situac'])) and (isset($_POST['colaborador_filtro_tipo']))) {

    try {

        $_SESSION["colaborador_filtro_situac"] = $_POST['colaborador_filtro_situac'];
        $_SESSION["colaborador_filtro_tipo"] = $_POST['colaborador_filtro_tipo'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

/**
 * LANÇAR CURSO/EXAME
 */
if (isset($_POST['submit_lancar'])) {

    try {

        // Validação dos valores recebidos do formulário
        $cursoValido = validarValor('REQUIRED', $_POST['curso'], 1);
        $referenciaValido = validarValor('REGEX_REQUIRED', $_POST['datref'], '/(\d{2}\/){2}\d{4}/');
        $vencimentoValido = validarValor('REGEX_REQUIRED', $_POST['datvenc'], '/(\d{2}\/){2}\d{4}/');
        $observacaoValido = validarValor('*', $_POST['observacao'], 3);

        if ($cursoValido && $referenciaValido && $vencimentoValido && $observacaoValido) {

            // Verifica se a referência é uma data válida
            $verificaReferencia = explode('/', $_POST['datref']);
            $referenciaVerificada = checkdate(intval($verificaReferencia[1]), intval($verificaReferencia[0]), intval($verificaReferencia[2]));

            if ($referenciaVerificada) {

                // Verifica se o vencimento é uma data válida
                $verificaVencimento = explode('/', $_POST['datvenc']);
                $vencimentoVerificado = checkdate(intval($verificaVencimento[1]), intval($verificaVencimento[0]), intval($verificaVencimento[2]));

                if ($vencimentoVerificado) {

                    $validarDatas = validarValor('COMPARAR_DATA', $_POST['datvenc'], $_POST['datref']);

                    if ($validarDatas) {

                        // Preparação dos dados para inserção no banco de dados
                        $id_usu = $_SESSION["colaborador_editar"];
                        $id_cur = $_POST['curso'];
                        $data_ref = $_POST['datref'];
                        $data_venc = $_POST['datvenc'];
                        $observacao = $_POST['observacao'];

                        $data_ref = formatarValor('DATE', $data_ref);
                        $data_venc = formatarValor('DATE', $data_venc);
                        $observacao = formatarValor('UPPER', $observacao);

                        $data1 = new DateTime($data_ref);
                        $data2 = new DateTime($data_venc);

                        $intervalo = $data2->diff($data1);
                        $periodo = $intervalo->days;

                        foreach (selectGESCUR_id($id_cur) as $select_gescur_id) {

                            $carencia_banco = $select_gescur_id['caravi'];
                        }

                        // EXIBE AS VARIÁVEIS
                        /*
                        echo 'ID Emp: ' . $id_emp_default . '<br>';
                        echo 'ID Usu: ' . $id_usu . '<br>';
                        echo 'ID Cur: ' . $id_cur . '<br>';
                        echo 'Periodo: ' . $periodo . '<br>';
                        echo 'Data Referencia: ' . $data_ref . '<br>';
                        echo 'Data Vencimento: ' . $data_venc . '<br>';
                        echo 'Observação: ' . $observacao . '<br>';
                        echo 'Datinc: ' . $datinc . '<br>';
                        echo 'Datatu: ' . $datatu . '<br>';
                        echo 'ID Usa: ' . $id_usa_default . '<br>';
                        */

                        if ($periodo > $carencia_banco) {

                            // Inserir dados no banco de dados
                            insertGESLCM(
                                $id_emp_default,
                                $id_usu,
                                $id_cur,
                                $periodo,
                                $data_ref,
                                $data_venc,
                                $observacao,
                                $datinc,
                                $datatu,
                                $id_usa_default,
                                $id_usa_default
                            );

                            echo 1; // Exibir mensagem de retorno de sucesso
                        } else {

                            echo 5; // Carencia maior ou igual ao periodo
                        }
                    } else {

                        echo 4; // Exibir mensagem de erro: vencimento menor que referencia
                    }
                } else {
                    echo 3; // Exibir mensagem de erro: vencimento inválido
                }
            } else {
                echo 2; // Exibir mensagem de erro: referência inválida
            }
        } else {
            echo 0; // Exibir mensagem de erro: valores inválidos
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage(); // Exibir mensagem de erro da exceção
    }
}

if (isset($_POST['blur_referencia'])) {

    $referenciaValido = validarValor('REGEX_REQUIRED', $_POST['referencia'], '/(\d{2}\/){2}\d{4}/');

    if ($referenciaValido) {

        // Verifica se a referência é uma data válida
        $verificaReferencia = explode('/', $_POST['referencia']);
        $referenciaVerificada = checkdate(intval($verificaReferencia[1]), intval($verificaReferencia[0]), intval($verificaReferencia[2]));

        if ($referenciaVerificada) {

            $id_cur = $_POST['id_cur'];

            // Cria um objeto DateTime a partir da referência
            $data_referencia = DateTime::createFromFormat('d/m/Y', $_POST['referencia']);

            foreach (selectGESCUR_id($id_cur) as $linha) {
                // Obtém o período da linha atual
                $periodo = $linha['period'];
            }

            // Adiciona o período à data de referência
            $data_referencia->add(new DateInterval('P' . $periodo . 'D'));
            $data_vencimento = $data_referencia->format('d/m/Y');

            // Retorna a data de vencimento
            echo $data_vencimento;
        }
    }
}

/**
 * 
 * Funções de validação
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
