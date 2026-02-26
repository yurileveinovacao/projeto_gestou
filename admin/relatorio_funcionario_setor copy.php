<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once __DIR__.'/../config/database.php';

?>


<html>

<head>

    <style>
        @page {

            margin: 115px 20px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 9pt;
        }

        .header {
            position: fixed;
            top: -115px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            background: transparent;
            padding: 5px 10px;
        }

        .header img {

            width: 100px;

        }

        .footer {

            position: fixed;
            bottom: -71px;
            left: 0;
            width: 100%;
            padding: 5px 10px 10px 10px;
            text-align: center;
            background: transparent;
            color: #000;
            text-align: right !important;

        }

        .footer .page::after {
            content: counter(page);
        }

        table {
            width: 100%;
            border: 1px solid #555555;
            margin: 0;
            padding: 0;
        }

        th {
            text-transform: uppercase;
        }

        table,
        th,
        td {
            border: 1px solid #555555;
            border-collapse: collapse;
            text-align: center;
            padding: 10px;

        }

        tr:nth-child(2n+0) {
            background: #eeeeee;
        }

        .header>table,
        .header>table th,
        .header>table td {
            border: none !important;
            padding: 0px;

        }
    </style>

</head>

<body>

    <?php

    $situac_filtro = $_SESSION["situac_filtro"];

    $id_rel = $_SESSION["codigo_rel"];

    foreach (select_GRELAT_id_rel($id_rel) as $grelat) :

        $nome_relatorio = $grelat["nome"];

    endforeach;

    foreach (select_VW_REL_FUNCIONARIO_DADOS_EMPRESA($id_emp_default) as $dados_empresa) :
        $nome_empresa = $dados_empresa["empresa"];
        $imagem_empresa = $dados_empresa["imagem_empresa"];

    endforeach;


    ?>

    <div class="header">
        <table>

            <tr>

                <td><img src="https://www.gestou.com.br/upload/empresa/<?= $imagem_empresa; ?>" alt="logo_empresa"></img></td>
                <td><?= $nome_relatorio; ?><br><?= $nome_empresa; ?></td>
                <td>DATA: <?= date("d/m/Y"); ?><br>HORA: <?= date("H:m:s"); ?></td>

            </tr>

        </table>
    </div>

    <div class="footer">
        <hr>
        <span class="page">Página </span>
    </div>

    <div class="content">

        <table>
            <tr id="top">
                <th>NOME:</th>
                <th width="15%">CPF:</th>
                <th width="15%">DEPARTAMENTO:</th>
                <th width="25%">FUNÇÃO:</th>
                <th width="10%">SITUAÇÃO:</th>
            </tr>

            <?php

            foreach (select_VW_REL_FUNCIONARIO_DADOS_FUNCIONARIO_DEPARTAMENTO($id_emp_default, $situac_filtro) as $departamento) :

            ?>

                <tr>

                    <td><?= $departamento["nome"]; ?></td>
                    <td><?= Mask("###.###.###-##", $departamento["cpf"]); ?></td>
                    <td><?= $departamento["departamento"]; ?></td>
                    <td><?= $departamento["funcao"]; ?></td>
                    <td><?= $departamento["situac_funcionario"]; ?></td>

                </tr>

            <?php

            endforeach;

            ?>

        </table>

    </div>

</body>

</html>

<?php

function Mask($mask, $str)
{

    $str = str_replace(" ", "", $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
}

?>