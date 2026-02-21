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

//  VISUALIZAR SOLICITAÇÃO
if (isset($_POST['btn_modal'])) {

    try {

        // Atribui Valor as Variaveis
        $id_sol = $_POST['id_sol'];
        $modal = $_POST['modal'];
        $_SESSION['id_sol_update'] = $id_sol;


        foreach (selectGESSOL_id_sol($id_sol) as $linha_gessol) {

            $situac_visualizacao = $linha_gessol['situac_usa_visualizar'];
            $solicitacao = $linha_gessol['tipo_solicitacao'];
            $mensagem = $linha_gessol['mensagem'];
            $situac = $linha_gessol['situac'];
            $justificativa = $linha_gessol['justificativa'];
            $usa_aut = $linha_gessol['usuario'];
            $datatu = $linha_gessol['datatu'];
            $anexo = $linha_gessol['anexo'];
        }

        // Formatar Variáveis
        $datatualizacao = new DateTime($datatu);
        $datatualizacao->format("d/m/Y H:i:s");

        $ext = pathinfo($anexo, PATHINFO_EXTENSION);


        $retorno = '
            <div class="tab-pane fade show active" id="nav-mensagem" role="tabpanel" aria-labelledby="nav-mensagem-tab">
                <div class="col-md-12">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="tipo" class="mt-sm-3 mb-2 font-weight-bold">TIPO DA SOLICITAÇÃO</label>
                            <input type="text" class="form-control" value="' . $solicitacao . '" readonly disabled></input>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="mensagem" class="mt-sm-3 mb-2 font-weight-bold">MENSAGEM</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled>' . $mensagem . '</textarea>
                        </div>
                    </div>
        ';

        if (($situac == 4) OR (!empty($justificativa) AND ($situac == 3))) {

            $retorno .= '
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="justificativa" class="mt-sm-3 mb-2 font-weight-bold">JUSTIFICATIVA:</label>
                        <textarea class="form-control" id="justificativa" name="justificativa" style="resize: none;text-transform: uppercase; height: 173px !important;" maxlength="1000" readonly disabled>' . $justificativa . '</textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="usuario" class="mt-sm-3 mb-2 font-weight-bold">Usuário Alteração:</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="' . $usa_aut . '" readonly disabled></input>
                    </div>

                    <div class="col-md-4">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data" class="mt-sm-3 mb-2 font-weight-bold">Data Alteração:</label>
                        <input type="text" name="data" id="data" style="" class="form-control" value="' . $datatualizacao->format("d/m/Y H:i:s") . '" readonly disabled></input>
                    </div>
                </div>
            ';
        } else if ($situac == 3) {

            $retorno .= '
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="usuario" class="mt-sm-3 mb-2 font-weight-bold">Usuário Alteração:</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="' . $usa_aut . '" readonly disabled></input>
                    </div>

                    <div class="col-md-4">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data" class="mt-sm-3 mb-2 font-weight-bold">Data Alteração:</label>
                        <input type="text" name="data" id="data" style="" class="form-control" value="' . $datatualizacao->format("d/m/Y H:i:s") . '" readonly disabled></input>
                    </div>
                </div>
        ';
        }

        $retorno .= '
                </div>
            </div>

            <div class="tab-pane fade" id="nav-anexo" role="tabpanel" aria-labelledby="nav-anexo-tab">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div id="seadragon-viewer">

        ';

        switch ($ext) {

            case 'png':
                $retorno .= '<img src="../upload/mensagens/solicitacoes/' . $anexo . '" class="img-fluid" type="image/png" draggable="false">';
                break;

            case 'jpg':
                $retorno .= '<img src="../upload/mensagens/solicitacoes/' . $anexo . '" class="img-fluid" type="image/jpeg" draggable="false">';
                break;

            case 'jpeg':
                $retorno .= '<img src="../upload/mensagens/solicitacoes/' . $anexo . '" class="img-fluid" type="image/jpeg" draggable="false">';
                break;

            case 'pdf':
                $retorno .= '<embed src="../upload/mensagens/solicitacoes/' . $anexo . '" width="100%" height="500" type="application/pdf">';
                break;
        }

        $retorno .= '   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';

        // Executa Comandos no Banco
        // UPDATE Tabela GESSOL_situac_visualizar
        if ($situac_visualizacao == 0) {

            updateGESSOL_situac_visualizar($id_sol, $id_usa_default);
        }

        echo $retorno;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// BTN APROVAR
if (isset($_POST['btn_aprovar'])) {

    $_SESSION['id_sol_update'] = $_POST['id_sol'];
    $_SESSION['situac_update'] = $_POST['situac_update'];
}

// APROVAR
if (isset($_POST['submit_aprovar'])) {

    try {

        $id_sol = $_SESSION['id_sol_update'];
        $situac = $_SESSION['situac_update'];
        $resposta_update = $_POST['resposta'];

        $resposta = formatarValor('UPPER', $resposta_update);

        // echo 'Resposta: ' . $resposta_update . '<br>';
        // echo 'Resposta Formatada: ' . $resposta . '<br>';

        // Executa Comandos no Banco
        // UPDATE Tabela GESSOL_aprovar
        updateGESSOL_aprovar2(
            $id_sol,
            $situac,
            $datatu,
            $id_usa_default,
            $resposta
        );

        if ($situac == 2) {

            foreach (select_EMAIL_RH($id_emp_default) as $email_rh) {
                $nome_email = $email_rh["nome"];
                $email_email = $email_rh["email"];

                require "../email_solicitacoes.php";
            }
        }

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT JUSTIFICATIVA
if (isset($_POST['btn_justifica'])) {

    $mensagemValido = validarValor('VALID', $_POST['mensagem'], 3);

    if ($mensagemValido) {

        try {
            // Atribui valor as Variáveis
            $mensagem_update = $_POST['mensagem'];
            $id_sol = $_SESSION['id_sol_update'];
            $situac = 4;

            // Formata Variáveis    
            $mensagem = formatarValor('UPPER', $mensagem_update);

            /*
            // Exibe Variáveis  
            echo 'ID Sol: ' . $id_sol . '<br>'; 
            echo 'Situac: ' . $situac . '<br>'; 
            echo 'Mensagem: ' . $mensagem . '<br>'; 
            echo 'Datatu: ' . $datatu . '<br>'; 
            echo 'ID Usa: ' . $id_usa_default . '<br>'; 
            */

            // Executa Comandos no Banco
            // UPDATE Tabela GESSOL_reprovar
            updateGESSOL_reprovar(
                $id_sol,
                $situac,
                $mensagem,
                $datatu,
                $id_usa_default
            );

            echo 1;
        } catch (PDOException $erro) {

            echo $erro->getMessage();
        }
    } else {

        echo 0;
    }
}

// CLOSE MODAL
if (isset($_POST['close_modal'])) {

    unset($_SESSION['id_sol_update']);
}

// FILTRO
if (isset($_POST['btn_filtro'])) {

    try {

        $_SESSION["solicitacao_filtro_situac"] = $_POST['solicitacao_filtro_situac'];
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}
