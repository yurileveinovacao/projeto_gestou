<?php

$time = 2 * 60 * 60; // Defini 2 horas

session_set_cookie_params($time);
require_once __DIR__."/../config/session.php"; session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Master - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <br>
                                <img src="../img/logo_gestou.png" height="250"></img><br><img
                                    src="../img/texto_gestou_azul.png" style="width: 40%; margin-top: -40px"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">MASTER LOGIN!</h1>
                                    </div>
                                    <form class="user" action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Usuário">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="senha" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Senha">
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                        <button type="submit" name="logar" class="btn btn-brave btn-user btn-block">
                                            <h6 class="mb-0"><span class="fonte-texto-gestou">ENTRAR</span></h6>
                                        </button>
                                        <!-- <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="esqueci_senha.php">Esqueceu sua senha?</a>
                                    </div>
                                    <!-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php

    //abre conexao
    require_once __DIR__.'/../config/database.php';

    try {
        // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
        if (isset($_REQUEST['logar'])) {
            $email = $_REQUEST['email'];
            $senha = $_REQUEST['senha'];
            $email = "'".$email."'";

            // $conn = pg_connect($servername, $username, $password, $database);
            $sql = 'SELECT * from public."GESMAS" where email ='.$email;
            $res = pg_exec($conn, $sql);
            $row = pg_fetch_assoc($res);

            $senhabanco = $row['senha'];

            // echo "situac".$row["situac"];
            // echo "email".$row["email"];
            // echo "nome".$row["nome"];


            //  if ($sql->rowCount() > 0) {
            if ($row['situac'] == 0) {
                echo "<script language=javascript>
			alert('Usuário inativo!');
			location.href = 'login';
			</script>";
                exit;
            }

            if (password_verify($senha, $senhabanco)) {
                if ($row['situac_senha'] == 0) {
                    echo "<script language=javascript>
                    alert('Altere sua senha para realizar o login!');
                    location.href = 'esqueci_senha';
                    </script>";
                    exit;
                }

                $_SESSION['id_mas'] = $row['id_mas'];
                $_SESSION['email_master'] = $row['email'];

                //  echo $_SESSION["id_usa"]."<br>";
                //  echo $_SESSION["email"]."<br>";

                //header("location:index.html");
                echo "<script>window.open('/master/index','_self')</script>";
            } else {
                echo "<script language=javascript>
			alert('Usuário ou Senha incorretos!');
			 location.href = 'login';
			</script>";
            }
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }

    ?>