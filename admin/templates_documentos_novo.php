<?php

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

// Limpa qualquer id de edição persistente pra entrar num novo template "limpo"
unset($_SESSION['editar_id_tpl']);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Novo Template</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<style>
    .opcao-tipo {
        display: block;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 30px 25px;
        height: 100%;
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .opcao-tipo:hover {
        border-color: #4e73df;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.15);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }
    .opcao-tipo .icone {
        font-size: 64px;
        margin-bottom: 16px;
        color: #4e73df;
    }
    .opcao-tipo .titulo {
        font-size: 18px;
        font-weight: bold;
        color: #5a5c69;
        margin-bottom: 10px;
    }
    .opcao-tipo .descricao {
        font-size: 13px;
        color: #858796;
        line-height: 1.45;
        text-align: left;
        padding: 0 6px;
    }
    .opcao-tipo .descricao ul { margin: 8px 0 0 18px; padding: 0; }
    .opcao-tipo .descricao li { margin-bottom: 4px; }
</style>

<body id="page-top">

    <div id="wrapper">

        <?php include_once "menu_lateral.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php
                include_once "barra_superior.php";
                include_once "pagina_restrita.php";
                ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Novo Template — escolha o tipo</h6>
                    </div>
                    <div class="card-body">

                        <p class="text-muted mb-4">Como você prefere criar este template?</p>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <a href="templates_documentos_editar?novo=1" class="opcao-tipo">
                                    <div class="icone"><i class="fas fa-edit"></i></div>
                                    <div class="titulo">Criar no editor</div>
                                    <div class="descricao">
                                        Compor o conteúdo direto no editor de texto do sistema (parecido com escrever um e-mail rico).
                                        <ul>
                                            <li>Formatação básica: negrito, itálico, listas, alinhamento</li>
                                            <li>Inserção de variáveis pelos botões</li>
                                            <li>Ideal para avisos curtos, comunicados, alertas</li>
                                            <li>Pode editar depois quando quiser</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="templates_documentos_upload" class="opcao-tipo">
                                    <div class="icone"><i class="fas fa-file-word"></i></div>
                                    <div class="titulo">Importar arquivo Word (.docx)</div>
                                    <div class="descricao">
                                        Subir um documento Word pronto, já formatado, com variáveis escritas no próprio arquivo.
                                        <ul>
                                            <li>Preserva 100% da formatação do Word</li>
                                            <li>Variáveis tipo <code>{nome_colaborador}</code> dentro do .docx</li>
                                            <li>Ideal para documentos formais, contratos, acordos</li>
                                            <li>Pra editar depois: baixa o .docx, ajusta no Word e sobe nova versão</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <div class="text-right mt-3">
                            <a href="templates_documentos" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <?php include_once "footer.php"; ?>

        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    </div>

</body>
</html>
