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

// SUBMIT
if (isset($_POST['btn_submit'])) {

    try {
        // Validando os valores de entrada
        $validoDescricao = validarValor('VALID', $_POST['descricao'], 3);
        $validoTipo = validarValor('VALID', $_POST['tipo'], 1);
        $validoLocal = validarValor('REQUIRED', $_POST['local'], 1);
        $validoPeriodo = validarValor('REQUIRED', $_POST['periodo'], 1);
        $validoCarencia = validarValor('REQUIRED', $_POST['carencia'], 1);

        // Se todos os valores de entrada forem válidos
        if ($validoDescricao && $validoTipo && $validoLocal && $validoPeriodo && $validoCarencia) {

            // Obtendo os valores de entrada
            $descricao_update = $_POST['descricao'];
            $tipo = $_POST['tipo'];
            $local = $_POST['local'];
            $periodo = $_POST['periodo'];
            $carencia = $_POST['carencia'];
            $painel = $_POST['painel'];

            // Formatando o valor da descrição em letras maiúsculas
            $descricao = formatarValor('UPPER', $descricao_update);

            // Se o período for 0
            if ($periodo == 0) {

                echo 2;
                exit;
            }

            // Se o período de carência for maior que o período total
            if ($carencia >= $periodo) {

                echo 3;
                exit;
            }

            // Inserindo os dados no banco de dados usando a função insertGESCUR()
            insertGESCUR(
                $tipo,
                $descricao,
                $periodo,
                $carencia,
                $local,
                $painel,
                $datinc,
                $datatu,
                $id_usa_default,
                $id_usa_default,
                $id_emp_default
            );

            echo 1; // Sucesso

            // Se algum valor de entrada for inválido
        } else {

            echo 0; // Entrada inválida
        }
        // Capturando quaisquer erros do banco de dados e exibindo a mensagem de erro
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SITUAC
// Verifica se o botão 'btn_situac' foi acionado
if (isset($_POST['btn_situac'])) {

    try {
        // Obtém os valores enviados via POST
        $situac_update = $_POST['situac_update'];
        $id_cur = $_POST['id_cur'];

        // Formata o valor 'SITUAC' usando a função 'formatarValor'
        $situac = formatarValor('SITUAC', $situac_update);

        // Exibe os valores para depuração (comentados para evitar exibição no código final)
        // echo 'ID Cur: ' . $id_cur . '<br>';
        // echo 'Situac: ' . $situac . '<br>';
        // echo 'Datatu: ' . $datatu . '<br>';
        // echo 'Id Usa: ' . $id_usa_default . '<br>';

        // Chama a função 'updateGESCUR_situac' para atualizar a tabela com os valores fornecidos
        updateGESCUR_situac($id_cur, $situac, $datatu, $id_usa_default);

        // Exibe '1' para indicar que a atualização foi bem-sucedida
        echo 1;
    } catch (PDOException $erro) {

        // Em caso de erro, exibe a mensagem de exceção
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_editar'])) {

    try {
        // Obtém o ID do curso a ser editado
        $id_cur_edit = $_POST['id_cur'];

        // Itera sobre os resultados da função 'selectGESCUR_id' usando o ID do curso
        foreach (selectGESCUR_id($id_cur_edit) as $linha) {

            // Obtém os valores do curso a ser editado
            $descricao = $linha['descri'];
            $tipo = $linha['tipcur'];
            $local = $linha['local'];
            $periodo = $linha['period'];
            $carencia = $linha['caravi'];
            $painel = $linha['painel'];
        }

        // Constrói a string de retorno para exibir o formulário de edição
        $retorno .= '
            <div class="col-md-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="descricao_editar">Descrição</label>
                        <input type="text" name="descricao_editar" id="descricao_editar" style="text-transform:uppercase" class="form-control" value="' . $descricao . '" minlength="3" maxlength="255" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipo_editar">Tipo:</label>
                        <select name="tipo_editar" class="form-control" id="tipo_editar" required>
        ';

        // Verifica o tipo do curso e seleciona a opção correta no formulário
        if ($tipo == 'C') {

            $retorno .= '
                <option value="C" selected>Curso</option>
                <option value="E">Exame</option>
            ';
        } else {

            $retorno .= '
                <option value="C">Curso</option>
                <option value="E" selected>Exame</option>
            ';
        }

        $retorno .= '
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="local_editar">Local:</label>
                <select name="local_editar" class="form-control" id="local_editar" required>
        ';

        // Verifica o local do curso e seleciona a opção correta no formulário
        if ($local == 1) {

            $retorno .= '
                <option value="1" selected>Externo</option>
                <option value="0">Interno</option>
            ';
        } else {

            $retorno .= '
                <option value="1">Externo</option>
                <option value="0" selected>Interno</option>
            ';
        }

        $retorno .= '
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="periodo_editar">Período (dias):</label>
                        <input type="text" id="periodo_editar" name="periodo_editar" class="form-control" placeholder="Duração do Curso/Exame" oninput="this.value = this.value.replace(/\D/g, \'\')" value="' . $periodo . '" maxlength="4" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="carencia_editar">Carência de Aviso (dias):</label>
                        <input type="text" id="carencia_editar" name="carencia_editar" class="form-control" placeholder="Prazo do aviso antes de vencer" oninput="this.value = this.value.replace(/\D/g, \'\')" value="' . $carencia . '" maxlength="4">
                    </div>
                </div>

                <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="custom-control custom-checkbox">
        ';

        if ($painel == 1) {

            $retorno .= '<input type="checkbox" class="custom-control-input" name="painel_editar" id="painel_editar" checked>';
        } else {

            $retorno .= '<input type="checkbox" class="custom-control-input" name="painel_editar" id="painel_editar">';
        }

        $retorno .= '
                        <label class="custom-control-label" for="painel_editar" style="user-select: none;">Não exibir no painel</label>
                        </div>
                    </div>
                </div>
            </div>
        ';

        // Exibe a string de retorno para exibir o formulário de edição
        echo $retorno;
    } catch (PDOException $erro) {
        // Em caso de erro, exibe a mensagem de exceção
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_submit_editar'])) {

    try {

        // Validando os valores de entrada
        $validoDescricao = validarValor('VALID', $_POST['descricao'], 3);
        $validoTipo = validarValor('VALID', $_POST['tipo'], 1);
        $validoLocal = validarValor('REQUIRED', $_POST['local'], 1);
        $validoPeriodo = validarValor('REQUIRED', $_POST['periodo'], 1);
        $validoCarencia = validarValor('REQUIRED', $_POST['carencia'], 1);

        // Se todos os valores de entrada forem válidos
        if ($validoDescricao && $validoTipo && $validoLocal && $validoPeriodo && $validoCarencia) {

            // Obtendo os valores de entrada
            $descricao = $_POST['descricao'];
            $tipo = $_POST['tipo'];
            $local = $_POST['local'];
            $periodo = $_POST['periodo'];
            $carencia = $_POST['carencia'];
            $id_cur = $_POST['id_cur'];
            $painel = $_POST['painel'];

            // Formatando o valor da descrição em letras maiúsculas
            $descricao = formatarValor('UPPER', $descricao);

            // Se o período for 0
            if ($periodo == 0) {

                echo 2;
                exit;
            }

            // Se o período de carência for maior que o período total
            if ($carencia >= $periodo) {

                echo 3;
                exit;
            }

            // echo 'Descricao: ' . $descricao . '<br>';
            // echo 'Tipo: ' . $tipo . '<br>';
            // echo 'Local: ' . $local . '<br>';
            // echo 'Periodo: ' . $periodo . '<br>';
            // echo 'Carencia: ' . $carencia . '<br>';
            // echo 'Datatu: ' . $datatu . '<br>';
            // echo 'ID Usa: ' . $id_usa_default . '<br>';
            // echo 'ID Cur: ' . $id_cur . '<br>';

            updateGESCUR_editar(
                $tipo,
                $descricao,
                $periodo,
                $carencia,
                $local,
                $painel,
                $datatu,
                $id_usa_default,
                $id_cur
            );

            echo 1; // Sucesso

            // Se algum valor de entrada for inválido
        } else {

            echo 0; // Entrada inválida
        }
    } catch (PDOException $erro) {

        // Em caso de erro, exibe a mensagem de exceção
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_exc'])) {

    try {

        $ids_cur = $_POST['ids'];

        // echo var_dump($id_cur);

        if (!empty($ids_cur)) {

            deleteGESCUR_in($ids_cur);

            echo 1;
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        $mensagemErro = $erro->getMessage();

        if (strpos($mensagemErro, '23503') !== false) {

            echo 2;
        } else {

            echo $mensagemErro;
        }
    }
}
