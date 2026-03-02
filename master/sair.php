<?php require_once __DIR__."/../config/session.php"; session_start(); session_destroy(); header("Location: /master/login"); exit; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sair</title>
</head>

<body>

    <?php

session_destroy();

header('location:login');

unset($_SESSION['id_mas']);
unset($_SESSION['email_master']);

?>

</body>

</html>