<?php

require_once '../restrito.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Erro</title>
    <link rel="stylesheet" href="./style.css">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <title>Unexpected Error</title>
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed:100,200,300,400" rel="stylesheet">
        <link href="/500.css" rel="stylesheet" type="text/css" />
        <!-- <link href="/assets/org/css/selecthealth.css" rel="stylesheet" type="text/css" media="screen, projection" /> -->

    </head>

    <body class="loading">
        <div class="error-502__container">
            <div class="error-502">
                <div class="error-502__text">
                    <div class="row justify-content-center">
                        <h2>Foi encontrado um erro <b>:(</b></h2>
                    </div>
                    <div class="row justify-content-center">
                        <p style="font-size: 1.25rem;">Favor entrar em contato com o suporte.</p>
                    </div>
                    <div class="row justify-content-center" style="padding: 0 20em;">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-10">
                            <textarea id="erro" style="user-select: none; width: 100%; resize: none; text-align: center; outline: 0;border:none;color: #7f8084;line-height: 1.429;margin-top: 0;font-weight: 300;font-size: 1rem;" readonly><?php echo $_SESSION["erro_importação"]; ?></textarea>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <h2>
                                <p>
                                    <span id="execCopy" style="cursor: pointer;"><i class="far fa-copy"></i></span>
                                </p>
                            </h2>
                        </div>
                    </div>
                    <div class="row justify-content-center">

                        <div style="margin-left: 2em;">
                            <a href="../index">
                                <button class="btn btn-brave" style="margin-bottom: 50px;">VOLTAR</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="gears">
            <div class="gear one">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="gear two">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="gear three">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script>
            $(function() {
                setTimeout(function() {
                    $('body').removeClass('loading');
                }, 1000);
            });

            // // Type 1
            // document.getElementById('execCopy').addEventListener('click', execCopy);

            // function execCopy() {
            //     document.getElementById('erro').select();
            //     document.execCommand("copy");
            // }

            //Clique do botão execCopy
            $(document).ready(function() {
                $(document).on('click', '#execCopy', function() {

                    document.getElementById('erro').select();
                    document.execCommand("copy");

                });

            });
        </script>
    </body>

    </html>
    <!-- partial -->

</body>

</html>