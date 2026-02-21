<?php

if ((isset($_POST['id_recebido'])) and (isset($_POST['opcao']))) {
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST['id_recebido'];
    $opcao = $_POST['opcao'];
    $id_emp_default = $_SESSION['id_emp_default'];

    $retorno = '';

    // //Consulta para retornar dados do funcionário
    // foreach (selectRECIBO_DIVERSOS_DADOS($raiz_cnpj, $id_recebido) as $resultado) {
    //     //Declarar div para dados do funcionário
    //     $retorno .= '<div class="form-row">';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '<span style="line-height: 3.00;">' . 'Nome: ' . $resultado['nome'] . '</span>';
    //     $retorno .= '</div>';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '</div>';

    //     $retorno .= '<div class="col-md-4">';
    //     $retorno .= '<span style="line-height: 3.00;">' . 'Periodo: ' . $resultado['periodo_inicio'] . '&nbsp; até &nbsp;' . $resultado['periodo_final'] . '</span>';
    //     $retorno .= '</div>';

    //     $retorno .= '</div>';
    // }

    //Consulta para retornar itens do holerite
    foreach (selectRECIBO_DIVERSOS_ITENS($raiz_cnpj, $id_recebido) as $resultados) {
        //Montar linhas tabela para venvimentos
        $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/recibos_diversos/' . $raiz_cnpj . '/' . $resultados["arquivo"] . '"></iframe>';
    }

    //retorno da função
    echo $retorno;
}
