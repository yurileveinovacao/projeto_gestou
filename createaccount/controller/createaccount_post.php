<?php

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";

/**
 * 
 * Funções no Click
 * 
 */

// Verificação das variáveis
if (isset($_POST["btn_submit"])) {

    // Chama a função para validar os POSTs
    $razaosocialValido = validarValor('VALID', $_POST['razaosocial'], 3);
    $cnpjValido = validarValor('REGEX_REQUIRED', $_POST['cnpj'], '/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/');

    $nomeValido = validarValor('VALID', $_POST['nome'], 3);
    $cpfValido = validarValor('REGEX_REQUIRED', $_POST['cpf'], '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
    $emailValido = validarValor('REGEX', $_POST['email'], '/^([\w.\'+-]+@([\w-]+\.)+[\w-]{2,4})?$/');
    $telefoneValido = validarValor('REGEX_REQUIRED', $_POST['telefone'], '/^\(\d{3}\) \d{4}-\d{4}$|^\(\d{3}\) \d{5}-\d{4}$/');
    $senhaValido = validarValor('REGEX_REQUIRED', $_POST['senha'], '/^(?=.*[!@#$%^&*()_+\-=\[\]{};:\'"\\\\|,.<>\/?])(?=.*[a-zA-Z])(?=.*[0-9]).{8,}\S*$/');
    $confirmsenhaValido = validarValor('REGEX_REQUIRED', $_POST['confirmsenha'], '/^(?=.*[!@#$%^&*()_+\-=\[\]{};:\'"\\\\|,.<>\/?])(?=.*[a-zA-Z])(?=.*[0-9]).{8,}\S*$/');

    // Se os valores forem validados continua com o update
    if ($razaosocialValido && $cnpjValido && $nomeValido && $cpfValido && $emailValido && $telefoneValido && $senhaValido && $confirmsenhaValido) {

        // Atribui valor das Variáveis
        $razaosocial = $_POST['razaosocial']; //REQUIRED
        $cnpj = $_POST['cnpj']; //REQUIRED
        $qtdcolaboradores = $_POST['qtdcolaboradores'];

        $nome = $_POST['nome']; //REQUIRED
        $cpf = $_POST['cpf']; //REQUIRED
        $email = $_POST['email']; //REQUIRED
        $telefone = $_POST['telefone']; //REQUIRED
        $senha = $_POST['senha']; //REQUIRED
        $confirmsenha = $_POST['confirmsenha']; //REQUIRED

        // Formata as variáveis
        $razaosocial = formatarValor("UPPER", $razaosocial);
        $cnpj = $cnpj;
        $qtdcolaboradores = formatarValor("NUM", $qtdcolaboradores);

        $nome = formatarValor("UPPER", $nome);
        $cpf = formatarValor("NUM", $cpf);
        $email = formatarValor("LOWER", $email);
        $telefone = formatarValor("NUM", $telefone);
        $senha = $_POST['senha'];
        $confirmsenha = $_POST['confirmsenha'];


        // Definição do array postado
        $informacoes = array($_POST['informacoes']);

        // Foreach para percorrer as informações e lista-las
        foreach ($informacoes as $array) {

            // Atribuição e concatenação das informações do mesmo tipo
            $browser = "Source: " . $array['source'] . "||Browser Family: " . $array['browser']['family'] . "||Browser Version: " . $array['browser']['version'];
            $os = "OS Family: " . $array['os']['family'];
            $device = "Device Family: " . $array['device']['family'] . "||Device Type: " . $array['device']['type'];
        }

        // Se a senha e a confirmação de senha forem iguais
        if ($senha == $confirmsenha) {

            // CRIA HASH DA SENHA
            $hash = $senha;
            $senha = password_hash($hash, PASSWORD_DEFAULT);

            // Obter o endereço IP do cliente
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // Dados referentes a GESVIN
            $tab_id_emp = "GESEMP";
            $tab_id_usa = "GESUSA";

            // Valor padrão para o insert
            $analise = 1;
            $id_per = 1;
            $situac = 0;

            // Verifica se já existe o CNPJ cadastrado na base
            foreach (selectGESEMP($cnpj) as $verifica_emp) {
                if (!empty($verifica_emp)) {
                    $count_emp = $verifica_emp["contagem"];
                }
            }

            // Verifica se ja existe o CPF
            foreach (selectGESUSA_CPF($cpf) as $verifica_cpf) {
                if (!empty($verifica_cpf)) {
                    $count_cpf = $verifica_cpf["contagem_cpf"];
                }
            }

            // Verifica se ja existe o EMAIL cadastrado na base
            foreach (selectGESUSA_EMAIL($email) as $verifica_email) {
                if (!empty($verifica_emp)) {
                    $count_email = $verifica_email["contagem_email"];
                }
            }

            // Caso ambas as informações não existirem na base, o insert é realizado
            if ((empty($count_emp)) and (empty($count_cpf)) and (empty($count_email))) {

                // Inserts

                $id_emp_insert = insertGESEMP($razaosocial, $cnpj, $email, $telefone, $qtdcolaboradores, $datinc, $datatu, $situac);
                $id_emp = $id_emp_insert["pk"];

                $id_usa_insert = insertGESUSA($nome, $cpf, $email, $telefone, $senha, $datinc, $id_emp, $situac, $analise, $id_per);
                $id_usa = $id_usa_insert["pk"];

                insertGESVIN($tab_id_emp, $id_emp, $tab_id_usa, $id_usa);

                // Loop para a confirmação das políticas
                foreach (selectGESPRI() as $pri) {

                    $id_pri = $pri["id_pri"];

                    insertGESACP($id_usa, $id_pri, $ip_address, $datinc, $browser, $device, $os);
                }

                // Retorno de sucesso
                $retorno = 1;
                echo json_encode($retorno);
            } else {

                if (!empty($count_emp)) {

                    // Retorno que existe o CNPJ cadastrado na base
                    $retorno = 3;
                    echo json_encode($retorno);
                } elseif (!empty($count_cpf)) {

                    // Retorno que existe o CPF cadastrado na base
                    $retorno = 4;
                    echo json_encode($retorno);
                } elseif (!empty($count_email)) {

                    // Retorno que existe o E-MAIL cadastrado na base
                    $retorno = 5;
                    echo json_encode($retorno);
                }
            }
        } else {

            // As senhas não se coincidem
            $retorno = 2;
            echo json_encode($retorno);
        }
    } else {

        // Retorno de informações não preenchidas
        $retorno = 0;
        echo json_encode($retorno);
    }
}
