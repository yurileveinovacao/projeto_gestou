<?php
//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";

require '../vendor_phpspreadsheet/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Verifica se o formulário foi submetido via método POST
if (isset($_POST["btn_add"])) {

    try {

        if ($_FILES['file']['name']) {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if ($ext === 'xls' || $ext === 'xlsx') {
                $spreadsheet = IOFactory::load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                // Definir o cabeçalho esperado
                $expectedHeader = ['NOME', 'CPF', 'E-MAIL'];
                $collaborators = [];
                $logs = [];

                // Obter o cabeçalho do arquivo enviado (assumindo que a primeira linha é o cabeçalho)
                $fileHeader = array_map('trim', $sheetData[1]); // Obter a primeira linha como cabeçalho

                // Verificar se o cabeçalho do arquivo corresponde ao esperado
                if (count(array_diff($expectedHeader, $fileHeader)) > 0) {
                    $mensagem = 'Cabeçalho do arquivo inválido. Por favor, siga o formato padrão.';
                    $retorna = [
                        'status' => 'erro',
                        'mensagem' => $mensagem
                    ];
                    // Envia a resposta em formato JSON
                    echo json_encode($retorna);
                    exit;
                }

                foreach ($sheetData as $index => $row) {
                    // Supondo que a primeira linha é o cabeçalho, pular essa linha
                    if ($index === 1) {
                        continue;
                    }

                    // Verificar se Nome e CPF não estão vazios
                    if (empty($row['A']) || empty($row['B'])) {
                        // Se Nome ou CPF estiverem vazios, ignorar essa linha
                        continue;
                    }

                    $validar_cpf = validarValor('REGEX_REQUIRED', $row['B'], '/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/');

                    if ($validar_cpf) {
                        // Adicionar os dados do colaborador apenas se Nome e CPF estiverem preenchidos
                        // Extrair o primeiro nome do colaborador
                        $nomeCompleto = $row['A'];
                        $partesNome = explode(' ', $nomeCompleto);
                        $primeiroNome = strtolower($partesNome[0]); // Converter para minúsculas

                        // Remover a máscara do CPF (pontos e traços)
                        $cpfSenha = preg_replace('/[^0-9]/', '', $row['B']);

                        // Extrair os 5 primeiros dígitos do CPF
                        $primeiros5Cpf = substr($cpfSenha, 0, 5);

                        // Criar a senha
                        $senha = $primeiroNome . '@' . $primeiros5Cpf;

                        // Adicionar o colaborador ao array
                        $collaborators[] = [
                            'nome' => $row['A'], // Coluna A
                            'cpf' => $row['B'], // Coluna B
                            'email' => isset($row['C']) ? $row['C'] : NULL, // Coluna C (tratamento para caso não exista)
                            'senha' => $senha,
                        ];
                    } else {
                        // Remover todos os caracteres não numéricos
                        $cpf = preg_replace('/\D/', '', $row['B']);
                        // Formatar o CPF com máscara
                        $cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);

                        $validar_cpf_formatado = validarValor('REGEX_REQUIRED', $cpf, '/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/');

                        if ($validar_cpf_formatado) {
                            // Adicionar os dados do colaborador apenas se Nome e CPF estiverem preenchidos
                            // Extrair o primeiro nome do colaborador
                            $nomeCompleto = $row['A'];
                            $partesNome = explode(' ', $nomeCompleto);
                            $primeiroNome = strtolower($partesNome[0]); // Converter para minúsculas

                            // Remover a máscara do CPF (pontos e traços)
                            $cpfSenha = preg_replace('/[^0-9]/', '', $row['B']);

                            // Extrair os 5 primeiros dígitos do CPF
                            $primeiros5Cpf = substr($cpfSenha, 0, 5);

                            // Criar a senha
                            $senha = $primeiroNome . '@' . $primeiros5Cpf;

                            // Adicionar o colaborador ao array
                            $collaborators[] = [
                                'nome' => $row['A'], // Coluna A
                                'cpf' => $row['B'], // Coluna B
                                'email' => isset($row['C']) ? $row['C'] : NULL, // Coluna C (tratamento para caso não exista)
                                'senha' => $senha,
                            ];
                        }
                    }
                }

                foreach ($collaborators as $colaboradores) {
                    $nome = formatarValor('UPPER', $colaboradores["nome"]);
                    $cpf = formatarValor('NUM', $colaboradores["cpf"]);
                    $email = $colaboradores["email"];
                    $senha = password_hash($colaboradores["senha"], PASSWORD_DEFAULT);
                    $situac = 1;

                    foreach (selectGESUSU_VERIFICACPF($cpf, $id_emp_default) as $select_valida) {

                        $verifica_cpf = $select_valida["exists"];
                    }

                    if (empty($verifica_cpf) || !$verifica_cpf) {

                        foreach (selectGESEMP_CONSULTAIDMUN($id_emp_default) as $consulta_idmun) {

                            $id_mun = $select_valida["id_mun"];
                        }
                        
                        insertGESUSU_importacao($nome, $cpf, $senha, $datinc, $situac, $email, $id_emp_default, $id_mun, $datatu, $id_usa_default, $id_usa_default);

                        $logs[] = [
                            'nome' => $nome,
                            'cpf' => $cpf,
                            'status' => 'Importado',
                            'descricao' => 'Usuário importado.'
                        ];
                    } else {

                        foreach (selectGESUSU_VERIFICAEMAIL($cpf, $id_emp_default) as $select_valida) {
                            if (!empty($select_valida)) {
                                $id_usu = $select_valida["id_usu"];
                                $verifica_email = $select_valida["email"];
                            }
                        }

                        if (empty($verifica_email) || $verifica_email === '') {

                            updateGESUSU_importacao($id_usu, $email, $datatu, $id_usa_default);

                            $logs[] = [
                                'nome' => $nome,
                                'cpf' => $cpf,
                                'status' => 'Atualizado',
                                'descricao' => 'E-mail atualizado.'
                            ];
                        } else {

                            $logs[] = [
                                'nome' => $nome,
                                'cpf' => $cpf,
                                'status' => 'Existente',
                                'descricao' => 'Usuário já existe.'
                            ];
                        }
                    }
                }

                // Adicione o array $logs à variável de sessão
                if (!isset($_SESSION['logs'])) {
                    $_SESSION['logs'] = [];
                }

                $_SESSION['logs'] = array_merge($_SESSION['logs'], $logs);

                // Define mensagem de sucesso
                $mensagem = 'Colaboradores adicionados com sucesso!';
                $retorna = [
                    'status' => 'sucesso',
                    'mensagem' => $mensagem,
                    // 'dados' => $collaborators // Adiciona os dados dos colaboradores no retorno de sucesso, se necessário
                ];
            } else {
                $mensagem = 'Formato de arquivo inválido.';
                $retorna = [
                    'status' => 'erro',
                    'mensagem' => $mensagem
                ];
            }
        } else {
            $mensagem = 'Nenhum arquivo enviado.';
            $retorna = [
                'status' => 'erro',
                'mensagem' => $mensagem
            ];
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
