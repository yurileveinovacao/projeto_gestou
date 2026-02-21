<?php
if(isset($_POST["id_recebido"])){
    
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST["id_recebido"];
    $id_emp_default = $_SESSION['id_emp_default'];
    
    $retorno = '';

    //Consulta para retornar dados do funcionário
    foreach (selectRECIBO_DADOS($raiz_cnpj, $id_recebido) as $resultado ) {

        //Declarar div para dados do funcionário
        $retorno .= '<div class="form-row">';
            
            $retorno .= '<div class="col-md-4">';
                $retorno .= '<span>' . 'Nome: ' . $resultado['nome'] . '</span>';
            $retorno .= '</div>';
            
            $retorno .= '<div class="col-md-4">';
                $retorno .= '<span>' . 'Cargo: ' . $resultado['cargo'] . '</span>';
            $retorno .= '</div>';
            
            $retorno .= '<div class="col-md-4">';
                $retorno .= '<span>' . 'Data crédito: ' . $resultado['data_credito'] . '</span>';
            $retorno .= '</div>';

        $retorno .= '</div>';
    }

    //Declarar cabeçalho tabela
    $retorno .= '<table class="table">';
    $retorno .= '<thead>';
    $retorno .= '<tr>';
    $retorno .= '<th scope="col">Cód. Evento</th>';
    $retorno .= '<th scope="col">Nome</th>';
    $retorno .= '<th scope="col">Quantidade</th>';
    $retorno .= '<th scope="col">Vencimentos</th>';
    $retorno .= '<th scope="col">Descontos</th>';
    $retorno .= '</tr>';
    $retorno .= '</thead>';
    $retorno .= '<tbody>';


    //Consulta para retornar itens do holerite
    foreach (selectRECIBO_PAGAMENTO_ITENS($raiz_cnpj, $id_recebido) as $resultados ){
    
        //Montar linhas tabela para venvimentos
        $retorno .= '<tr>';
        if($resultados['vencimentos_val'] > 0){
            $retorno .= '<td style="color: #3C0BA9;">' . $resultados['codevento'] . '</td>';
            $retorno .= '<td style="color: #3C0BA9;">' . $resultados['nome'] . '</td>';
            $retorno .= '<td style="color: #3C0BA9;">' . $resultados['quantidade'] . '</td>';
            $retorno .= '<td style="color: #3C0BA9;">' . $resultados['vencimentos'] . '</td>';
            $retorno .= '<td style="color: #3C0BA9;">' . $resultados['descontos'] . '</td>';
        }
        //Montar linhas tabela para descontos
        if($resultados['descontos_val'] < 0){
            $retorno .= '<td style="color: #D81F2D;">' . $resultados['codevento'] . '</td>';
            $retorno .= '<td style="color: #D81F2D;">' . $resultados['nome'] . '</td>';
            $retorno .= '<td style="color: #D81F2D;">' . $resultados['quantidade'] . '</td>';
            $retorno .= '<td style="color: #D81F2D;">' . $resultados['vencimentos'] . '</td>';
            $retorno .= '<td style="color: #D81F2D;">' . $resultados['descontos'] . '</td>';
        }
    }
    
    //fechar tags
    $retorno .= '</tr>';
    $retorno .= '</tbody>';
    $retorno .= '</table>';

    //retorno da função
    echo $retorno;
}
?>