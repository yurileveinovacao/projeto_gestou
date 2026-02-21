<?php

if (isset($_POST['id_recebido'])) {
    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_recebido = $_POST['id_recebido'];

    //Consulta para retornar itens do holerite
    foreach (selectMENSAGENS_RECIBO_DIVERSOS($raiz_cnpj, $id_recebido) as $informacao) {

        $motrep_banco = $informacao["motrep"];
        $resprep_banco = $informacao["resprep"];
        $id_usu_banco = $informacao["id_usu"];
    }

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

    $retorno .= '<div class="row">';
    $retorno .= '<div class="col-md-12">';

    //Consulta para retornar itens do holerite
    foreach (selectMENSAGENS_RECIBO_DIVERSOS($raiz_cnpj, $id_recebido) as $resultados) {
        //Montar linhas tabela para venvimentos

        if ($resultados["motrep"]) {

            $retorno .= '<div class="row">';


            $retorno .= '<div class="col-md-1">';

            $retorno .= '<div>';
            $retorno .= '<div class="w-100 d-flex"><img src="../upload/cadastro/' . $resultados["imagem"] . '" class="img-responsive img-thumbnail content-xy-center"></img></div>';
            $retorno .= '</div>';

            $retorno .= '</div>';

            $retorno .= '<div class="col-md-5 mr-auto d-flex">';

            $retorno .= '<div class="content-xy-center">';
            $retorno .= '<div class="w-100 balao-secondary">' . $resultados["motrep"] . '</div>';
            $retorno .= '</div>';

            $retorno .= '</div>';


            $retorno .= '</div>';
        }

        if ($resultados["resprep"]) {

            $retorno .= '<div class="row">';

            $retorno .= '<div class="col-md-5 ml-auto d-flex">';

            $retorno .= '<div class="content-xy-center ml-auto">';
            $retorno .= '<div class="w-100 balao-success">' . $resultados["resprep"] . '</div>';
            $retorno .= '</div>';

            $retorno .= '</div>';


            $retorno .= '<div class="col-md-1">';

            $retorno .= '<div>';
            $retorno .= '<div class="w-100 d-flex"><img src="../upload/empresa/' . $resultados["logo"] . '" class="img-responsive img-thumbnail content-xy-center"></img></div>';
            $retorno .= '</div>';

            $retorno .= '</div>';



            $retorno .= '</div>';
        }
    }

    $retorno .= '</div>';
    $retorno .= '</div>';

    // VERIFICAÇAO SE A VAR RESPREP ESTA VAZIA, PERMITINDO O ADMIN RESPONDER O MOTREP
    if (empty($resprep_banco)) {

        $retorno .= '<div class="footer-inpt-resp p-3">';

        // PARTE DO INPUT DO ADMIN
        $retorno .= '<div class="row">';
        $retorno .= '<div class="col-md-12">';


        $retorno .= '<div class="row">';
        $retorno .= '<div class="col-md-12">';


        $retorno .= '<div class="d-flex">';

        $retorno .= '<input type="text" id="resprep" name="resprep" class="form-control" maxlength="255">';

        $retorno .= '<div class="pl-1">';

        $retorno .= '<button type="button" name="btn-resprep" id_usu="' . $id_usu_banco . '" id_rec="' . $id_recebido . '" class="btn btn-primary ml-auto btn-resprep">';
        $retorno .= '<i class="far fa-arrow-alt-circle-right"></i>';
        $retorno .= '</button>';

        $retorno .= '</div>';

        $retorno .= '</div>';


        $retorno .= '</div>';
        $retorno .= '</div>';


        $retorno .= '</div>';
        $retorno .= '</div>';


        $retorno .= '</div>';
    }

    //retorno da função
    echo $retorno;
}
