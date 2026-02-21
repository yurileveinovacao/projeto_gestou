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
    foreach (selectRECIBO_DADOS($raiz_cnpj, $id_recebido) as $resultado) {
        //Declarar div para dados do funcionário
        $retorno .= '<div class="form-row">';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Nome: ' . $resultado['nome'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '</div>';

        $retorno .= '<div class="col-md-4">';
        $retorno .= '<span style="line-height: 3.00;">' . 'Periodo: ' . $resultado['competencia'] . '</span>';
        $retorno .= '</div>';

        $retorno .= '</div>';
    }

    //Consulta para retornar itens do holerite
    foreach (selectRECIBO_PAGAMENTO_ITENS($raiz_cnpj, $id_recebido) as $resultados) {
        //Montar linhas tabela para venvimentos

        $retorno .= '<iframe style="width: 100%; height: 600px;" src="../upload/beneficios/holerite/' . $raiz_cnpj . '/' . $resultados["arquivo"] . '"></iframe>';
    }

    //retorno da função
    echo $retorno;

    // COMECO ESTRUTURA
} elseif ((isset($_POST["id_recebido"])) or (isset($_POST["motrep"]))) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST["id_recebido"];
    $motrep = $_POST["motrep"];
    $id_emp_default = $_SESSION['id_emp_default'];

    $retorno = '';

    //Consulta para retornar dados do funcionário
    foreach (selectRECIBO_DADOS($raiz_cnpj, $id_recebido) as $resultado) {

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


    // //Consulta para retornar itens do holerite
    // foreach (selectRECIBO_PAGAMENTO_ITENS($raiz_cnpj, $id_recebido) as $resultados) {

    //     //Montar linhas tabela para venvimentos
    //     $retorno .= '<tr>';
    //     if ($resultados['vencimentos_val'] > 0) {
    //         $retorno .= '<td style="color: #3C0BA9;">' . $resultados['codevento'] . '</td>';
    //         $retorno .= '<td style="color: #3C0BA9;">' . $resultados['nome'] . '</td>';
    //         $retorno .= '<td style="color: #3C0BA9;">' . $resultados['quantidade'] . '</td>';
    //         $retorno .= '<td style="color: #3C0BA9;">' . $resultados['vencimentos'] . '</td>';
    //         $retorno .= '<td style="color: #3C0BA9;">' . $resultados['descontos'] . '</td>';
    //     }
    //     //Montar linhas tabela para descontos
    //     if ($resultados['descontos_val'] < 0) {
    //         $retorno .= '<td style="color: #D81F2D;">' . $resultados['codevento'] . '</td>';
    //         $retorno .= '<td style="color: #D81F2D;">' . $resultados['nome'] . '</td>';
    //         $retorno .= '<td style="color: #D81F2D;">' . $resultados['quantidade'] . '</td>';
    //         $retorno .= '<td style="color: #D81F2D;">' . $resultados['vencimentos'] . '</td>';
    //         $retorno .= '<td style="color: #D81F2D;">' . $resultados['descontos'] . '</td>';
    //     }
    // }

    // //fechar tags
    // $retorno .= '</tr>';
    $retorno .= '</tbody>';
    $retorno .= '</table>';

    if (!empty($motrep)) {

        $retorno .= '<hr>';

        $retorno .= '<div class="form-row">';
        $retorno .= '<div class="col-md-12">';
        $retorno .= '<label for="observacao">Motivo reprovação:</label>';
        $retorno .= '<textarea id="observacao" class="form-control" style="max-height: 150px; min-height: 40px;" readonly>' . $motrep . '</textarea>';
        $retorno .= '</div>';
        $retorno .= '</div>';
    }

    //retorno da função
    echo $retorno;
}

if ((isset($_POST["ajuste_valor"])) && (isset($_POST["id_im1_valor"]))) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $ajuste_valor = $_POST['ajuste_valor'];
    $id_im1 = $_POST['id_im1_valor'];

    //Consulta para retornar itens do holerite
    foreach (selectAJUSTE_VALOR_HOLERITE($raiz_cnpj, $id_im1) as $informacao) {

        $vlr_liquido_banco = $informacao["vlr_liquido"];
        $id_usu_banco = $informacao["id_usu"];
        $nome_colaborador_banco = $informacao["nome_colaborador"];
    }

    $retorno = '';

    $retorno .= '<div class="row">';
    $retorno .= '<div class="col-md-12">';

    $retorno .= '<div class="text-sm text-primary mb-3" style="font-size: 0.8rem !important">';
    $retorno .= '' . $nome_colaborador_banco . '';
    $retorno .= '</div>';

    $retorno .= '<div>';
    $retorno .= '<input type="text" class="form-control text-right ajuste-salario" id="ajuste-salario" id_im1="' . $id_im1 . '" placeholder="R$" name="salario" maxlength="12" onKeyPress="return(moeda(this,\'.\',\',\',event))" value="R$ ' . number_format($vlr_liquido_banco, 2, ",", ".") . '">';
    $retorno .= '</div>';

    $retorno .= '</div>';
    $retorno .= '</div>';

    //retorno da função
    echo $retorno;
}

if ((isset($_POST['ajuste_salario'])) and (isset($_POST['id_im1_salario']))) {

    require_once 'restrito.php';
    require_once 'util2.php';
    require_once 'iuds_pdo.php';

    $ajuste_salario = $_POST['ajuste_salario'];
    $id_im1_salario = $_POST["id_im1_salario"];

    $ajuste_salario = formatarValor("VALOR_DECIMAL", $ajuste_salario);

    $tabela = 'public."GESIM1_' . $raiz_cnpj . '"';

    // echo "Ajuste:" . $_POST['ajuste_salario'];
    // echo "ID_im1:" . $id_im1_salario;
    // echo "Valor:" . $ajuste_salario;

    updateGESIM1_ajuste_salario($tabela, $ajuste_salario, $id_usa_default, $id_im1_salario);
}
