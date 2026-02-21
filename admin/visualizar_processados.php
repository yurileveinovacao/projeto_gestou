<?php
if(isset($_POST["id_proc_recebido"])){
    
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_proc_recebido = $_POST["id_proc_recebido"];
    $id_emp_default = $_SESSION['id_emp_default'];

    $retorno = '';

    $retorno .= '<table class="table">';
    $retorno .= '<thead>';
    $retorno .= '<tr>';
    $retorno .= '<th scope="col">Nome</th>';
    $retorno .= '<th scope="col">Descrição</th>';
    $retorno .= '<th scope="col">Valor vencimento</th>';
    $retorno .= '<th scope="col">Valor desconto</th>';
    $retorno .= '<th scope="col">Valor liquido</th>';
    $retorno .= '<th scope="col">Base salário</th>';
    $retorno .= '<th scope="col">Base INSS</th>';
    $retorno .= '<th scope="col">Base FGTS</th>';
    $retorno .= '</tr>';
    $retorno .= '</thead>';
    $retorno .= '<tbody>';
    
    foreach (selectGESIM1_proc_detalhado($raiz_cnpj,$id_emp_default,$id_proc_recebido) as $resultados ){
    
    $retorno .= '<tr>';
    $retorno .= '<td>' . $resultados['nome'] . '</td>';
    $retorno .= '<td>' . $resultados['descricao'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_vencimento'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_desconto'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_liquido'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_basesalario'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_baseinss'] . '</td>';
    $retorno .= '<td>' . $resultados['vlr_basefgts'] . '</td>';
    $retorno .= '</tr>';    

    }

    $retorno .= '</tbody>';
    $retorno .= '</table>';
    
    echo $retorno;
}
?>