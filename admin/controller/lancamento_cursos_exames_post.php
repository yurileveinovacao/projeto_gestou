<?php

//Faz a requisição da Sessão

use function PHPSTORM_META\map;

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
            mensagem_retorno($data_vencimento);
        }
    }
}

// SUBMIT
if (isset($_POST['btn_submit'])) {

    try {

        // Validação dos valores recebidos do formulário
        $calobValido = validarValor('REQUIRED', $_POST['colab'], 1);
        $cursoValido = validarValor('REQUIRED', $_POST['curso'], 1);
        $referenciaValido = validarValor('REGEX_REQUIRED', $_POST['referencia'], '/(\d{2}\/){2}\d{4}/');
        $vencimentoValido = validarValor('REGEX_REQUIRED', $_POST['vencimento'], '/(\d{2}\/){2}\d{4}/');
        $observacaoValido = validarValor('*', $_POST['observacao'], 3);

        if ($calobValido && $cursoValido && $referenciaValido && $vencimentoValido && $observacaoValido) {

            // Verifica se a referência é uma data válida
            $verificaReferencia = explode('/', $_POST['referencia']);
            $referenciaVerificada = checkdate(intval($verificaReferencia[1]), intval($verificaReferencia[0]), intval($verificaReferencia[2]));

            if ($referenciaVerificada) {

                // Verifica se o vencimento é uma data válida
                $verificaVencimento = explode('/', $_POST['vencimento']);
                $vencimentoVerificado = checkdate(intval($verificaVencimento[1]), intval($verificaVencimento[0]), intval($verificaVencimento[2]));

                if ($vencimentoVerificado) {

                    $validarDatas = validarValor('COMPARAR_DATA', $_POST['vencimento'], $_POST['referencia']);

                    if ($validarDatas) {

                        // Preparação dos dados para inserção no banco de dados
                        $id_usu = $_POST['colab'];
                        $id_cur = $_POST['curso'];
                        $data_ref = $_POST['referencia'];
                        $data_venc = $_POST['vencimento'];
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

                            mensagem_retorno(1); // Exibir mensagem de retorno de sucesso
                        } else {

                            mensagem_retorno(5); // Carencia maior ou igual ao periodo
                        }
                    } else {

                        mensagem_retorno(4); // Exibir mensagem de erro: vencimento menor que referencia
                    }
                } else {
                    mensagem_retorno(3); // Exibir mensagem de erro: vencimento inválido
                }
            } else {
                mensagem_retorno(2); // Exibir mensagem de erro: referência inválida
            }
        } else {
            mensagem_retorno(0); // Exibir mensagem de erro: valores inválidos
        }
    } catch (PDOException $erro) {
        mensagem_retorno($erro->getMessage()); // Exibir mensagem de erro da exceção
    }
}

if (isset($_POST['btn_cancel'])) {

    try {

        // Obter os IDs a serem excluídos
        $ids_lcm = $_POST['ids'];

        if (!empty($ids_lcm)) {

            // Cancela os registros correspondentes aos IDs fornecidos
            updateGESLCM_in_cancelar($ids_lcm);

            mensagem_retorno(1); // Exibir mensagem de retorno de sucesso
        } else {

            mensagem_retorno(0); // Exibir mensagem de erro: IDs vazios
        }
    } catch (PDOException $erro) {

        mensagem_retorno($erro->getMessage()); // Exibir mensagem de erro da exceção
    }
}

if (isset($_POST['btn_editar'])) {

    $id_lcm = $_POST['id_lcm'];

    foreach (selectGESLCM_id($id_lcm) as $linha) {

        // Obtém os valores das colunas do banco de dados
        $id_usu = $linha['id_usu'];
        $id_cur = $linha['id_cur'];
        $data_ref = new DateTime($linha['datref']);
        $data_venc = new DateTime($linha['prodat']);
        $observacao = $linha['observ'];
    }

    $retorno .= '
        <div class="col-md-12">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="colab_editar">Colaborador:</label>
                <select name="colab_editar" class="form-control" id="colab_editar" required>
    ';

    foreach (selectGESUSU_id_lcm($id_emp_default, $id_usu) as $select_gesusu_id_lcm) {

        // Cria opções para seleção do colaborador
        $retorno .= '<option value="' . $select_gesusu_id_lcm['id_usu'] . '">' . $select_gesusu_id_lcm['nome'] . '</option>';
    }

    $retorno .= '
        </select>
        </div>

        <div class="form-group col-md-6">
            <label for="curso_editar">Curso/Exame:</label>
            <select name="curso_editar" class="form-control" id="curso_editar" required>
    ';

    foreach (selectGESCUR_id_lcm($id_emp_default, $id_cur) as $select_gescur_id_lcm) {

        // Cria opções para seleção do curso/exame
        $retorno .= '<option value="' . $select_gescur_id_lcm['id_cur'] . '">' . $select_gescur_id_lcm['descri'] . '</option>';
    }

    $retorno .= '
                </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="referencia_editar">Data de Referência:</label>
                    <input type="text" id="referencia_editar" name="referencia_editar" class="form-control" placeholder="Data de inicio do Curso/Exame" value="' . $data_ref->format('d/m/Y') . '" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="vencimento_editar">Data de Vencimento:</label>
                    <input type="text" id="vencimento_editar" name="vencimento_editar" class="form-control" placeholder="Data de vencimento do Curso/Exame" value="' . $data_venc->format('d/m/Y') . '" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="observacao_editar">Observação</label>
                    <input type="text" name="observacao_editar" id="observacao_editar" style="text-transform:uppercase" class="form-control" minlength="3" maxlength="255" value="' . $observacao . '">
                </div>
            </div>

        </div>
    ';

    mensagem_retorno($retorno);
}

if (isset($_POST['submit_editar'])) {

    try {

        // Validação dos valores recebidos do formulário
        $calobValido = validarValor('REQUIRED', $_POST['colab'], 1);
        $cursoValido = validarValor('REQUIRED', $_POST['curso'], 1);
        $referenciaValido = validarValor('REGEX_REQUIRED', $_POST['datref'], '/(\d{2}\/){2}\d{4}/');
        $vencimentoValido = validarValor('REGEX_REQUIRED', $_POST['datvenc'], '/(\d{2}\/){2}\d{4}/');
        $observacaoValido = validarValor('*', $_POST['observacao'], 3);

        if ($calobValido && $cursoValido && $referenciaValido && $vencimentoValido && $observacaoValido) {

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
                        $id_usu = $_POST['colab'];
                        $id_cur = $_POST['curso'];
                        $data_ref = $_POST['datref'];
                        $data_venc = $_POST['datvenc'];
                        $observacao = $_POST['observacao'];
                        $id_lcm = $_POST['id_lcm'];

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
                        echo 'ID LCM: ' . $id_lcm . '<br>';
                        echo 'ID Usu: ' . $id_usu . '<br>';
                        echo 'ID Cur: ' . $id_cur . '<br>';
                        echo 'Periodo: ' . $periodo . '<br>';
                        echo 'Data Referencia: ' . $data_ref . '<br>';
                        echo 'Data Vencimento: ' . $data_venc . '<br>';
                        echo 'Observação: ' . $observacao . '<br>';
                        echo 'Datatu: ' . $datatu . '<br>';
                        echo 'ID Usa: ' . $id_usa_default . '<br>';
                        */

                        if ($periodo > $carencia_banco) {

                            // Inserir dados no banco de dados
                            updateGESLCM_editar(
                                $id_lcm,
                                $id_usu,
                                $id_cur,
                                $periodo,
                                $data_ref,
                                $data_venc,
                                $observacao,
                                $datatu,
                                $id_usa_default
                            );

                            mensagem_retorno(1); // Exibir mensagem de retorno de sucesso
                        } else {

                            mensagem_retorno(5); // Carencia maior ou igual ao periodo
                        }
                    } else {

                        mensagem_retorno(4); // Exibir mensagem de erro: vencimento menor que referencia
                    }
                } else {
                    mensagem_retorno(3); // Exibir mensagem de erro: vencimento inválido
                }
            } else {
                mensagem_retorno(2); // Exibir mensagem de erro: referência inválida
            }
        } else {
            mensagem_retorno(0); // Exibir mensagem de erro: valores inválidos
        }
    } catch (PDOException $erro) {
        mensagem_retorno($erro->getMessage()); // Exibir mensagem de erro da exceção
    }
}

if (isset($_POST['btn_anexo'])) {

    $_SESSION['id_lcm_anexo'] = $_POST['id_lcm'];
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
     * 2 = Referencia não é uma data valida
     * 3 = Vencimento não é uma data valida
     * 4 = Vencimento é menor que a referência
     * 5 = Periodo não é maior que a carencia cadastrda na GESCUR
     * 
     */
}
