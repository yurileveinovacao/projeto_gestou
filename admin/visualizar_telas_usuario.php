<?php
if (isset($_POST["id_recebido"])) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST["id_recebido"];
    $id_emp_default = $_SESSION['id_emp_default'];
    $id_usa_default = $_SESSION['id_usa_default'];

    foreach (selectCOUNT_GESMNU($id_recebido, $id_emp_default) as $count_gesmnu) {

        $contagem = $count_gesmnu["contagem"];
    }

    if ($contagem != 0) {

        foreach (select_TELAS_INSERT($id_recebido, $id_emp_default) as $telas_insert) {

            // echo "id_recebido".var_dump($id_recebido)."<br>";
            // echo "id_emp_default".var_dump($id_emp_default)."<br>";
            // echo "telas_insert".var_dump($telas_insert["id_mnu"])."<br>";
            // echo "datatu".var_dump($datatu)."<br>";
            // echo "-------------";

            insertGESMNU($id_recebido, $id_emp_default, $telas_insert["id_mnu"], $datatu);
        }
    }

    $retorno = '';

    // //Consulta para retornar dados do funcionário
    // foreach (selectRECIBO_DADOS($raiz_cnpj, $id_recebido) as $resultado) {

    //     //Declarar div para dados do funcionário
    //     $retorno .= '<div class="form-row">';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '<span>' . 'Nome: ' . $resultado['nome'] . '</span>';
    //     $retorno .= '</div>';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '<span>' . 'Cargo: ' . $resultado['cargo'] . '</span>';
    //     $retorno .= '</div>';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '<span>' . 'Data crédito: ' . $resultado['data_credito'] . '</span>';
    //     $retorno .= '</div>';

    //     $retorno .= '</div>';
    // }

    //Declarar cabeçalho tabela
    $retorno .= '<table class="table">';
    $retorno .= '<thead>';
    $retorno .= '<tr>';
    $retorno .= '<th scope="col" style="text-align: center">Liberado</th>';
    $retorno .= '<th scope="col">Nome</th>';
    // $retorno .= '<th scope="col">Quantidade</th>';
    // $retorno .= '<th scope="col">Vencimentos</th>';
    // $retorno .= '<th scope="col">Descontos</th>';
    $retorno .= '</tr>';
    $retorno .= '</thead>';
    $retorno .= '<tbody>';


    //Consulta para retornar itens do holerite
    foreach (selectTELAS_USUARIO($id_recebido, $id_emp_default) as $resultados) {

        $retorno .= '<tr>';
        if ($resultados["situac"] == 1) {
            $retorno .= '<td style="text-align: center"><input type="checkbox" class="teste" id="' . $resultados['id_mpr'] . '" id_mpr="' . $resultados['id_mpr'] . '" name="checkbox[]" checked></td>';
        } else {
            $retorno .= '<td style="text-align: center"><input type="checkbox" class="teste" id="' . $resultados['id_mpr'] . '" id_mpr="' . $resultados['id_mpr'] . '" name="checkbox[]" ></td>';
        }
        $retorno .= '<td>' . $resultados['caminho'] . '</td>';
        $retorno .= '</tr>';
    }

    // //Montar linhas tabela para venvimentos
    // $retorno .= '<tr>';
    // if($resultados['vencimentos_val'] > 0){
    //     $retorno .= '<td style="color: #3C0BA9;">' . $resultados['codevento'] . '</td>';
    //     $retorno .= '<td style="color: #3C0BA9;">' . $resultados['nome'] . '</td>';
    //     $retorno .= '<td style="color: #3C0BA9;">' . $resultados['quantidade'] . '</td>';
    //     $retorno .= '<td style="color: #3C0BA9;">' . $resultados['vencimentos'] . '</td>';
    //     $retorno .= '<td style="color: #3C0BA9;">' . $resultados['descontos'] . '</td>';
    // }
    // //Montar linhas tabela para descontos
    // if($resultados['descontos_val'] < 0){
    //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['codevento'] . '</td>';
    //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['nome'] . '</td>';
    //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['quantidade'] . '</td>';
    //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['vencimentos'] . '</td>';
    //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['descontos'] . '</td>';
    // }

    //fechar tags
    $retorno .= '</tbody>';
    $retorno .= '</table>';

    //retorno da função
    echo $retorno;
}
