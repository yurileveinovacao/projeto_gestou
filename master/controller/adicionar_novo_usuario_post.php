<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

$desativa_insert = 0;

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_add"])) {

    try {

        // Atribuição de id_emps
        $id_emp = $_SESSION["tabela_empresas"]["id_emp_matriz"];
        $id_emp_filial = $_SESSION["adicionar_filial"]["id_emp_filial"];
        $id_emp_novagrupo = $_SESSION["adicionar_novagrupo"]["id_emp_novagrupo"];
        $tipo_id_emp = $_SESSION["tabela_empresas"]["tipo_id_emp"];

        $id_emp_update = $tipo_id_emp == "FILIAL" ? $id_emp_filial : $id_emp_novagrupo;

        // Captura os dados do formulário
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];;
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $id_tus = $_POST["tus"];
        $endereco = $_POST["endereco"];
        $bairro = $_POST["bairro"];
        $complemento = $_POST["complemento"];
        $numero = $_POST["numero"];
        $cidade = $_POST["cidade"];
        $cep = $_POST["cep"];

        // Variáveis manuais e de configuração
        $valor = 1234;
        $senha = password_hash($valor, PASSWORD_DEFAULT);
        $situac = 1;
        $id_per = 1;

        // Validação dos campos do formulário
        $nomeValid = validarValor('VALID', $nome, 3);
        $cpf_Valid = validarValor('REGEX_REQUIRED', $cpf, '/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/');
        $email_Valid = validarValor('REGEX_REQUIRED', $email, '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
        // $telefone_Valid = validarValor('REGEX_REQUIRED', $telefone, '/^\(?\d{3}\)? ?\d{4,5}-?\d{4}$/');
        $cep_Valid = validarValor('REGEX_REQUIRED', $cep, '/^\d{5}-?\d{3}$/');

        $nome = formatarValor('UPPER', $nome);
        $cpf = formatarValor('NUM', $cpf);
        $cep = formatarValor('NUM', $cep);
        $telefone = formatarValor('NUM', $telefone);
        $endereco = formatarValor('UPPER', $endereco);
        $bairro = formatarValor('UPPER', $bairro);
        $complemento = formatarValor('UPPER', $complemento);
        $numero = formatarValor('UPPER', $numero);

        // Verifica se todas as validações passaram
        if ($nomeValid && $cpf_Valid && $email_Valid && $cep_Valid) {

            foreach (selectGESUSA_VERIFICACPF($cpf) as $select_valida) {

                $verifica_cpf = $select_valida["exists"];
            }

            if (empty($verifica_cpf) || !$verifica_cpf) {

                if ($desativa_insert == 0) {

                    // Insert na GESUSA
                    $id_usaGESUSA = insertGESUSA_FILIAL(
                        $nome,
                        $cpf,
                        $senha,
                        $datinc,
                        $id_emp_update,
                        $email,
                        $situac,
                        $id_tus,
                        $id_per,
                        $cidade,
                        $cep,
                        $telefone,
                        $endereco,
                        $bairro,
                        $complemento,
                        $numero,
                        $id_mas_default,
                        $datatu
                    );

                    $id_usa = $id_usaGESUSA['pk'];

                    // Variáveis para inserção em tabelas vinculadas
                    $tabvin1 = "GESEMP";
                    $id_tab1 = $id_emp_update;
                    $tabvin2 = "GESUSA";
                    $id_tab2 = $id_usa;

                    // Insere na tabela de vínculos GESVIN1
                    insertGESVIN($tabvin1, $id_tab1, $tabvin2, $id_tab2);

                    // // Insere na tabela de vínculos GESVIN2
                    // insertGESVI2($id_emp_update);

                    // Menus padrão
                    $menus = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 20, 21, 22, 23, 31, 32, 33, 37, 57, 58];

                    // Insere os menus para o usuário
                    foreach ($menus as $id_mnu => $value) {
                        insertGESMPR($id_usa, $id_emp_update, $value, $datatu, $situac);
                    }
                }

                // Define mensagem de sucesso
                $mensagem = 'Usuário adicionado com sucesso!';
                $retorna = array(
                    'status' => 'sucesso',
                    'mensagem' => $mensagem
                );
            } else {
                // Define mensagem de erro caso o cpf já exista
                $mensagem = 'O <b>CPF</b> informado já existe.';
                $retorna = array(
                    'status' => 'verifica_cpf',
                    'mensagem' => $mensagem
                );
            }
        } else {
            // Define mensagem de erro caso a validação falhe
            $mensagem = 'Revise os dados preenchidos e tente novamente!';
            $retorna = array(
                'status' => 'erro',
                'mensagem' => $mensagem
            );
        }
    } catch (PDOException $erro) {
        // Captura e trata exceções PDO
        $mensagem = $erro->getMessage();
        $retorna = array(
            'status' => 'erro',
            'mensagem' => $mensagem
        );
    }

    // Envia a resposta em formato JSON
    echo json_encode($retorna);
}
