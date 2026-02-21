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

// BTN EXLCUIR
if (isset($_POST['btn_excluir'])) {

    try {

        $id_org = $_POST['selecionados'];

        // var_dump($id_org);
        // echo '<br>';

        if (!empty($id_org)) {

            deleteGESORG_in($id_org);

            echo 1;
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// BTN EDITAR
if (isset($_POST['btn_editar']) && !empty($_POST['id_org'])) {

    try {

        $id_org = $_POST['id_org'];

        foreach (select_GESORG_edit($id_org) as $linha) {

            $descricao = $linha['descricao'];
            $pai = $linha['pai'];
            $nivel = $linha['nivel'];
        }

        $retorno = '
            <div class="form-row">
                <div class="form-group col-md-1" style="display: none;">
                    <label for="updateID">ID</label>
                    <input type="text" class="form-control" name="updateID" id="updateID" value="' . $id_org . '" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="updateDescricao">Nome</label>
                    <input type="text" class="form-control" name="updateDescricao" id="updateDescricao" style="text-transform:uppercase" value="' . $descricao . '" minlength="2" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="updatePai">Pai</label>
                    <input id="updatePai" tipe="text" class="form-control" value="' . $pai . '" readonly>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="updateNível">Nível</label>
                    <input type="text" class="form-control" id="updateNível" value="' . $nivel . '" readonly></input>
                </div>
            </div>
        ';

        echo $retorno;

    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT INCLUIR
if (isset($_POST['btn_incluir'])) {

    try {

        $descricaoValido = validarValor('VALID', $_POST['inputDescricao'], 2);
        $paiValido = validarValor('REQUIRED', $_POST['inputPai'], 0);

        if ($descricaoValido && $paiValido) {

            $descricao_update = $_POST['inputDescricao'];
            $nivelPai_update = $_POST['inputPai'];
            $nivel_update = $_POST['inputNivel'];

            // Formatar Variáveis
            $descricao = formatarValor('UPPER', $descricao_update);
            $nivelPai = formatarValor('*', $nivelPai_update);

            if (empty($nivel_update)) {

                $nivel = 1;
            } else {

                $nivel = $nivel_update;
            }

            // SELECT Tabela GESORG_descricao
            foreach (select_GESORG_descricao($id_emp_default, $descricao) as $linha) {

                $countDescricao = $linha['conta'];
            }

            // SELECT Tabela GESORG_pai
            foreach (select_GESORG_pai($id_emp_default, $nivelPai) as $linha2) {

                $pai = $linha2['descricao'];
            }

            /*
            // Exibe Valiráveis
            echo 'Descrição: ' . $descricao . '<br>';
            echo 'Nivel Pai: ' . $nivelPai . '<br>';
            echo 'Pai: ' . $pai . '<br>';
            echo 'ID Emp: ' . $id_emp_default . '<br>';
            echo 'Nivel: ' . $nivel . '<br>';
            echo 'Datinc: ' . $datinc . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            */

            if (empty($countDescricao)) {

                // INSERT Tabela GESORG
                insertGESORG(
                    $descricao,
                    $pai,
                    $id_emp_default,
                    $nivel,
                    $datinc,
                    $datatu,
                    $id_usa_default,
                    $id_usa_default
                );

                echo 1;
            } else {

                echo 2;
            }
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// SUBMIT EDITAR
if (isset($_POST['btn_atualizar'])) {

    try {

        $descricaoValido = validarValor('VALID', $_POST['updateDescricao'], 2);

        if ($descricaoValido) {

            // Valor Variáveis
            $descricao_update = $_POST['updateDescricao'];
            $id_org = $_POST['updateID'];

            // Formata Variáveis
            $descricao = formatarValor('UPPER', $descricao_update);

            /*
            // Exibe Variáveis
            echo 'ID Org: ' . $id_org . '<br>';
            echo 'Descrição: ' . $descricao . '<br>';
            echo 'Datatu: ' . $datatu . '<br>';
            echo 'ID Usa: ' . $id_usa_default . '<br>';
            */

            foreach (select_GESORG_descricao($id_emp_default, $descricao) as $linha) {

                $countDescricao = $linha['conta'];
            }

            if (empty($countDescricao)) {

                updateGESORG(
                    $descricao,
                    $datatu,
                    $id_usa_default,
                    $id_org
                );

                echo 1;
            } else {

                echo 2;
            }


        } else {

            echo 0;
        }

    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}