<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once '../iuds_pdo.php';

//ARQUIVO DE UTILITÁRIOS
require_once '../util.php';

/**
 * 
 * Funções no Click
 * 
 */

// Verificação das variáveis
if (isset($_POST['btn_submit'])) {

    try {

        // Validação dos campos
        $nomeValido = validarValor('VALID', $_POST['nome'], 3); // Verifica se o nome tem pelo menos 3 caracteres
        $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/'); // Verifica se o CPF está no formato correto
        $emailValido = validarValor('REGEX_REQUIRED', $_POST['email'], '/^([\w\.]+@([\w]+\.)+[\w]{2,4})?$/'); // Verifica se o email está no formato correto
        $celularValido = validarValor('REGEX_REQUIRED', $_POST['celular'], '/^\(\d{3}\) (\d{4}|\d{5})-\d{4}$/'); // Verifica se o celular está no formato correto
        $datanascValido = validarValor('REGEX_REQUIRED', $_POST['datanasc'], '/^(\d{2}\/){2}\d{4}$/'); // Verifica se a data de nascimento está no formato correto
        $enderecoValido = validarValor('VALID', $_POST['endereco'], 3); // Verifica se o endereço tem pelo menos 3 caracteres
        $numeroValido = validarValor('VALID', $_POST['numero'], 1); // Verifica se o número do endereço foi fornecido
        $bairroValido = validarValor('VALID', $_POST['bairro'], 3); // Verifica se o bairro tem pelo menos 3 caracteres
        $cidadeValido = validarValor('VALID', $_POST['cidade'], 1); // Verifica se a cidade foi fornecida
        $cepValido = validarValor('REGEX_REQUIRED', $_POST['cep'], '/^\d{5}\-\d{3}$/'); // Verifica se o CEP está no formato correto
        $senhaValido = validarValor('VALID', $_POST['password'], 8); // Verifica se a senha tem pelo menos 8 caracteres

        if ($nomeValido && $cpfValido && $emailValido && $celularValido && $datanascValido && $enderecoValido && $numeroValido && $bairroValido && $cidadeValido && $cepValido && $senhaValido) {

            $token = $_POST['token'];

            // Recupera informações adicionais do token
            foreach (select_GESSEMP_token($token) as $select_gesemp) {

                $venc_token = $select_gesemp["datval_token"]; // Data de validade do token
                $id_emp_employee = $select_gesemp["id_emp"]; // ID da empresa
            }

            $data_atual = new DateTime($datinc); // Data atual do sistema
            $data_venc = new DateTime($venc_token); // Data de validade do token

            if ($data_venc < $data_atual) {

                $vencido = false; // O token está vencido
            } else {

                $vencido = true; // O token está válido
            }

            if ($vencido) {
                if ($_POST['password'] == $_POST['confirmpassword']) {

                    // Verifica se a data de nascimento é válida
                    $verificaDataNasc = explode('/', $_POST['datanasc']);
                    $dataNascVerificada = checkdate(intval($verificaDataNasc[1]), intval($verificaDataNasc[0]), intval($verificaDataNasc[2]));

                    if ($dataNascVerificada) {

                        $data_atual = formatarValor('DATE', $data); // Formata a data atual
                        $data_info = formatarValor('DATE', $_POST['datanasc']); // Formata a data de nascimento fornecida

                        $datetime_subtrair = date_create($data_info); // Cria um objeto DateTime com a data de nascimento
                        $datetime_atual = date_create($data_atual); // Cria um objeto DateTime com a data atual

                        $intervalo_data = $datetime_subtrair->diff($datetime_atual); // Calcula a diferença entre as datas

                        if ($intervalo_data->y < 15 || $intervalo_data->y > 150) {

                            $dataNascIdade = false; // A idade é inválida (menor que 15 anos ou maior que 150 anos)
                        } else {

                            $dataNascIdade = true; // A idade é válida
                        }

                        if ($dataNascIdade) {

                            if ($_POST['termo']) {

                                // Captura os valores dos campos fornecidos
                                $nome_input = $_POST['nome'];
                                $cpf_input = $_POST['cpf'];
                                $email_input = $_POST['email'];
                                $celular_input = $_POST['celular'];
                                $datanasc_input = $_POST['datanasc'];
                                $endereco_input = $_POST['endereco'];
                                $numero_input = $_POST['numero'];
                                $bairro_input = $_POST['bairro'];
                                $complemento_input = $_POST['complemento'];
                                $cidade = $_POST['cidade'];
                                $cep_input = $_POST['cep'];
                                $senha_input = $_POST['password'];
                                $termo = $_POST['termo'];

                                // Formata os valores dos campos
                                $nome = formatarValor('UPPER', $nome_input); // Converte o nome para maiúsculas
                                $cpf = formatarValor('NUM', $cpf_input); // Remove caracteres não numéricos do CPF
                                $email = formatarValor('LOWER', $email_input); // Converte o email para minúsculas
                                $celular = formatarValor('NUM', $celular_input); // Remove caracteres não numéricos do celular
                                $datanasc = formatarValor('DATE', $datanasc_input); // Formata a data de nascimento
                                $endereco = formatarValor('UPPER', $endereco_input); // Converte o endereço para maiúsculas
                                $numero = formatarValor('UPPER', $numero_input); // Converte o número do endereço para maiúsculas
                                $bairro = formatarValor('UPPER', $bairro_input); // Converte o bairro para maiúsculas
                                $complemento = formatarValor('UPPER', $complemento_input); // Converte o complemento para maiúsculas
                                $cep = formatarValor('NUM', $cep_input); // Remove caracteres não numéricos do CEP
                                $senha = password_hash($senha_input, PASSWORD_DEFAULT); // Criptografa a senha

                                // Verifica se o CPF já está cadastrado
                                foreach (select_GESUSU_cpf($cpf) as $select_gesusu_cpf) {

                                    $count_cpf = $select_gesusu_cpf['conta'];
                                }

                                if (empty($count_cpf)) {

                                    // Verifica se o email já está cadastrado
                                    foreach (select_GESUSU_email($email) as $select_gesusu_email) {

                                        $count_email = $select_gesusu_email['conta'];
                                    }

                                    if (empty($count_email)) {

                                        // Insere os dados do usuário no banco de dados
                                        insert_GESUSU(
                                            $nome,
                                            $cpf,
                                            $email,
                                            $celular,
                                            $datanasc,
                                            $endereco,
                                            $numero,
                                            $bairro,
                                            $complemento,
                                            $cep,
                                            $cidade,
                                            $id_emp_employee,
                                            $senha,
                                            $datinc,
                                            $datatu
                                        );

                                        // echo 'Nome: ' . $nome . '<br>';
                                        // echo 'CPF: ' . $cpf . '<br>';
                                        // echo 'Email: ' . $email . '<br>';
                                        // echo 'Celular: ' . $celular . '<br>';
                                        // echo 'Data de Nascimento: ' . $datanasc . '<br>';
                                        // echo 'Endereço: ' . $endereco . '<br>';
                                        // echo 'Número: ' . $numero . '<br>';
                                        // echo 'Bairro: ' . $bairro . '<br>';
                                        // echo 'Complemento: ' . $complemento . '<br>';
                                        // echo 'CEP: ' . $cep . '<br>';
                                        // echo 'Cidade: ' . $cidade . '<br>';
                                        // echo 'ID do funcionário: ' . $id_emp_employee . '<br>';
                                        // echo 'Senha: ' . $senha . '<br>';
                                        // echo 'Data de Inclusão: ' . $datinc . '<br>';
                                        // echo 'Data de Atualização: ' . $datatu . '<br>';


                                        mensagem_retorno(1); // Exibe uma mensagem de retorno de sucesso
                                    } else {

                                        mensagem_retorno(8); // Exibe uma mensagem de erro informando que o email já está cadastrado
                                    }
                                } else {

                                    mensagem_retorno(7); // Exibe uma mensagem de erro informando que o CPF já está cadastrado
                                }
                            } else {

                                mensagem_retorno(5); // Exibe uma mensagem de erro informando que o termo não foi aceito
                            }
                        } else {

                            mensagem_retorno(4); // Exibe uma mensagem de erro informando que a idade é inválida
                        }
                    } else {

                        mensagem_retorno(3); // Exibe uma mensagem de erro informando que a data de nascimento é inválida
                    }
                } else {

                    mensagem_retorno(2); // Exibe uma mensagem de erro informando que as senhas não coincidem
                }
            } else {

                mensagem_retorno(6); // Exibe uma mensagem de erro informando que o token está vencido
            }
        } else {

            mensagem_retorno(0); // Exibe uma mensagem de erro informando que algum campo não foi preenchido corretamente
        }
    } catch (PDOException $erro) {

        mensagem_retorno($erro->getMessage()); // Exibe uma mensagem de erro informando sobre uma exceção no banco de dados
    }
}

// Verifica se o botão 'btn_polpri' foi acionado
if (isset($_POST['btn_polpri'])) {

    try {

        // Executa a função select_POL_PRIVACIDADE() e itera sobre o resultado
        foreach (select_POL_PRIVACIDADE() as $select_gespri) {

            // Armazena a descrição obtida em cada iteração
            $descricao = $select_gespri['descricao'];
        }

        // Chama a função mensagem_retorno() passando a descrição obtida como argumento
        mensagem_retorno($descricao);
    } catch (PDOException $erro) {

        // Se ocorrer uma exceção do tipo PDOException, chama a função mensagem_retorno() passando a mensagem de erro como argumento
        mensagem_retorno($erro->getMessage());
    }
}



/**
 * 
 * Funções
 * 
 */
// FUNÇÃO DE MENSAGEM
function mensagem_retorno($mensagem)
{

    echo $mensagem;

    /**
     * LEGENDA
     * 
     * 0 = Falha no Preenchimento de algum campo
     * 1 = Sucesso
     * 2 = Senhas não coincidem
     * 3 = Data de Nascimento Invalida
     * 4 = Data de Nascimento Menor que 15 anos
     * 5 = Termo não Aceito
     * 6 = Token Vencido
     * 7 = CPF já cadastrado
     * 8 = Email já cadastrado
     * 
     */
}
