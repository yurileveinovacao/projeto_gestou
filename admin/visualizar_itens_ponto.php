<?php

if ((isset($_POST['id_recebido'])) and (isset($_POST['opcao']))) {
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST['id_recebido'];
    $opcao = $_POST['opcao'];
    $id_emp_default = $_SESSION['id_emp_default'];

    $retorno = '';

    //Consulta para retornar dados do funcionário
    foreach (selectPONTO_DADOS($raiz_cnpj, $id_recebido) as $resultado) {
        //Declarar div para dados do funcionário
        $retorno .= '<div class="form-row">';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Nome: ' . $resultado['nome'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Periodo: ' . $resultado['periodo'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '</div>';
    }

    //Consulta para retornar itens do holerite
    foreach (selectRECIBO_PONTO_ITENS($raiz_cnpj, $id_recebido) as $resultados) {
        //Montar linhas tabela para venvimentos
        $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/ponto/' . $raiz_cnpj . '/' . $resultados["arquivo"] . '"></iframe>';
    }

    //retorno da função
    echo $retorno;

    // COMECO ESTRUTURA
} elseif (isset($_POST['id_recebido'])) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST['id_recebido'];
    $id_emp_default = $_SESSION['id_emp_default'];

    $retorno = '';

    //Consulta para retornar dados do funcionário
    foreach (selectPONTO_DADOS($raiz_cnpj, $id_recebido) as $resultado) {
        //Declarar div para dados do funcionário
        $retorno .= '<div class="form-row">';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Nome: ' . $resultado['nome'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Periodo: ' . $resultado['periodo'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '</div>';
    }

    //Declarar cabeçalho tabela
    $retorno .= '<table class="table">';
    $retorno .= '<thead>';

    //Adicionar linha em branco
    //$retorno .= '<tr>';
    //$retorno .= '<th colspan="9"></th>';
    //$retorno .= '</tr>';

    $retorno .= '<tr>';

    $retorno .= '<th scope="col">Data</th>';
    $retorno .= '<th scope="col">Ent1</th>';
    $retorno .= '<th scope="col">Sai1</th>';
    $retorno .= '<th scope="col">Ent2</th>';
    $retorno .= '<th scope="col">Sai2</th>';
    $retorno .= '<th scope="col">Ent3</th>';
    $retorno .= '<th scope="col">Sai3</th>';
    $retorno .= '<th scope="col">BTotal</th>';
    $retorno .= '<th scope="col">BSaldo</th>';
    $retorno .= '</tr>';
    $retorno .= '</thead>';
    $retorno .= '<tbody>';

    //Consulta para retornar itens do holerite
    foreach (selectRECIBO_PONTO_ITENS($raiz_cnpj, $id_recebido) as $resultados) {
        //Montar linhas tabela para venvimentos
        $retorno .= '<tr>';
        // if($resultados['vencimentos_val'] > 0){
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['data'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['ent1'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['sai1'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['ent2'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['sai2'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['ent3'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['sai3'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['btotal'] . '</td>';
        $retorno .= '<td style="color: #3C0BA9;">' . $resultados['bsaldo'] . '</td>';
        // }
        //Montar linhas tabela para descontos
        // if($resultados['descontos_val'] < 0){
        //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['codevento'] . '</td>';
        //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['nome'] . '</td>';
        //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['quantidade'] . '</td>';
        //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['vencimentos'] . '</td>';
        //     $retorno .= '<td style="color: #D81F2D;">' . $resultados['descontos'] . '</td>';
        // }
    }

    //fechar tags
    $retorno .= '</tr>';
    $retorno .= '</tbody>';
    $retorno .= '</table>';

    //retorno da função
    echo $retorno;
}
