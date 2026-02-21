<?php

//Faz a requisição da Sessão

require 'restrito.php';
require 'util.php';

?>

<?php

//abre conexao
require_once 'conexao.php';

?>


<html>

<head>

    <style>
        @page {

            margin: 120px 20px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 9pt;
        }

        .header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            background: transparent;
            padding: 10px 10px;
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

    switch ($_SESSION["situac_filtro"]) {

        case NULL;
            $situac_filtro = 3;
            break;
        case 3;
            $situac_filtro = 3;
            break;
        case 1;
            $situac_filtro = 1;
            break;
        case 0;
            $situac_filtro = 0;
            break;
    }

    $id_rel = $_SESSION["codigo_rel"];

    foreach (select_GRELAT_id_rel($id_rel) as $grelat) :

        $nome_relatorio = $grelat["nome"];

    endforeach;

    foreach (select_VW_REL_DEPARTAMENTO_DADOS_EMPRESA($id_emp_default) as $dados_empresa) :
        $nome_empresa = $dados_empresa["empresa"];
        $imagem_empresa = $dados_empresa["imagem"];

    endforeach;


    ?>

    <div class="header">
        <table>

            <tr>

                <td style="text-align: left;" width="33.33%"><img src="https://www.gestou.com.br/upload/empresa/<?= $imagem_empresa; ?>" alt="logo_empresa"></img></td>
                <td style="text-align: center;" width="33.33%"><?= $nome_relatorio; ?><br><?= $nome_empresa; ?></td>
                <td style="text-align: right;" width="33.33%">DATA: <?= date("d/m/Y"); ?><br>HORA: <?= date("H:m:s"); ?></td>

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
                <th>ID DEPARTAMENTO:</th>
                <th>NOME:</th>
                <th>SITUAÇÃO:</th>
            </tr>

            <?php

            foreach (select_VW_REL_DEPARTAMENTO_DADOS_DEPARTAMENTO($id_emp_default, $situac_filtro) as $departamento) :

                if ($departamento != 0) {

            ?>

                    <tr>

                        <td style="text-align: left;"><?= $departamento["id_dep"]; ?></td>
                        <td style="text-align: left;"><?= $departamento["nome"]; ?></td>
                        <td><?= $departamento["situac_departamento"]; ?></td>

                    </tr>

                <?php

                } else {
                ?>

                    <tr>
                        <td style="text-align: center;" colspan="3">Não há dados disponíveis</td>
                    </tr>

            <?php
                }

            endforeach;

            ?>

        </table>

    </div>

</body>

</html>