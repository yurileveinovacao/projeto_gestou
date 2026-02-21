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

if (isset($_POST['btn_modal'])) {

    try {

        // Variavel de sessao
        $valores = $_SESSION["valores"];
        $valores_explode = explode("|", $valores);

        // Resultado do explode
        $id_processamento = $valores_explode[0];

        if (!empty($id_processamento)) {

            $registros = select_GESIM_LOG($id_processamento, $id_emp_default);
            $count_registros = count($registros);

            if ($registros[0] !== 0) {

                foreach ($registros as $key => $linha) {

                    if ($key === ($count_registros - 1)) {

                        // se o item atual é o último, use a classe sem o traço
                        $retorno .= '<div style="padding: 16px;">';
                    } else {

                        // caso contrário, use a classe com o traço
                        $retorno .= '<div style="border-bottom: 1px solid #e3e6f0; padding: 16px;">';
                    }

                    // $retorno .= 'Na página nº <span class="text-primary font-weight-bolder">' . $linha['pagina'] . '</span> foi encontrado a seguinte inconsistência:<br>';
                    // $retorno .= $linha['tipo'] . ': ';
                    // $retorno .= $linha['identificador'] . ' não localizado<br>';
                    // $retorno .= '</div>';

                    $retorno .= 'Revisar cadastro colaborador: ' . $linha['tipo'] . ' <span class="text-primary font-weight-bolder">' . $linha['identificador'] . '</span> ';
                    $retorno .= 'na página nº <span class="text-primary font-weight-bolder">' . $linha['pagina'] . '</span> do arquivo importado.<br>';
                    $retorno .= 'Após revisão, refazer importação.<br>';
                    $retorno .= '</div>';
                }
            } else {

                $retorno = 0;
            }

            echo $retorno;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}
