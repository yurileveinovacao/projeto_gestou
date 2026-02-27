<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sair</title>
</head>

<body>

    <?php

require_once __DIR__."/../config/session.php"; session_start();
session_destroy();

header("location:login");

unset($_SESSION["id_usu_app"]);
unset($_SESSION["email_app"]);

?>

</body>

</html>