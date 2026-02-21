<?php

session_start();

//abre conexao
require_once 'conexao_pdo.php';
require_once 'util.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.ico" rel="icon">
    <title>Gestou - APP</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
    <link href="css/ruang-admin.css" rel="stylesheet" type="text/css">
    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</head>

<body id="page-top">

</body>

</html>

<?php

try {
    // ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
    if (isset($_REQUEST['logar'])) {

        $senha = $_POST['senha'];

        $opcao = $_POST["opcao"];
        $cpf = $_POST['CPF'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $cpf = str_replace('.', '', str_replace('-', '', $cpf));
        $telefone = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $telefone))));

        if (($opcao == "CPF") and (!empty($cpf))) {

            $result = $cpf;
            cpf();
            exit;
        }
        if (($opcao == "email") and (!empty($email))) {

            $result = $email;
            email();
            exit;
        }
        if (($opcao == "telefone") and (!empty($telefone))) {

            $result = $telefone;
            telefone();
            exit;
        }

        // $conn = pg_connect($servername, $username, $password, $database);

        // foreach (login($result) as $login) {

        //     $senhabanco = $login['senha'];

        //     //  if ($sql->rowCount() > 0) {
        //     if ($login['situac'] == 0) {
        //         echo "<script language=javascript>
        //         alert('Usuário inativo!');
        //         location.href = 'login';
        //         </script>";
        //         exit;
        //     }

        //     if (password_verify($senha, $senhabanco)) {

        //         if ($login['situac_senha'] == 0) {
        //             echo "<script language=javascript>
        //             alert('Altere sua senha para realizar o login!');
        //             location.href = 'esqueci_senha';
        //             </script>";
        //             exit;
        //         }

        //         $_SESSION['id_usu_app'] = $login['id_usu'];
        //         $_SESSION['email_app'] = $login['email'];

        //         $id_usu = $_SESSION['id_usu_app'];

        //         // echo $_SESSION['id_usa'].'<br>';
        //         // echo $_SESSION['email'].'<br>';

        //         //header("location:index.html");

        //         foreach(select_GESACE($id_usu) as $aceite_politicas){

        //             $status = $aceite_politicas["status"];

        //         }

        //         if($status == "Pendente"){

        //             //DIRECIONA PARA ACEITE POLITICAS
        //             echo ("<script>window.open('https://www.gestou.com.br/app/aceite_politicas.php','_self')</script>");

        //         }else{

        //             //DIRECIONA PARA INDEX
        //             echo ("<script>window.open('https://www.gestou.com.br/app/index.php','_self')</script>");

        //         }

        //         // echo "<script language=javascript>
        //         //  location.href = 'index.php';
        //         // </script>";

        //         // header('Location: https://www.gestou.com.br/novo/app/index.php');
        //         // echo "if";
        //         exit;
        //     } else {
        //         echo "<script language=javascript>
        // 	alert('Usuário ou Senha incorretos!');
        // 	 location.href = 'login.php';
        // 	</script>";
        //         // echo "else";
        //         exit;
        //     }
        // }
    }
} catch (PDOException $erro) {
    echo $erro->getMessage();
}

function cpf()
{

    global $result;
    global $senha;

    foreach (login_cpf($result) as $login) {

        if ($login == 0) {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                title: 'Atenção!',
                text: 'O CPF informado não pertence a nenhum de nossos usuários!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='login';
                }
              });
            </script>";
        } else {

            $senhabanco = $login['senha'];

            if ($login['bloqueado'] == 1) {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    title: 'Atenção!',
                    text: 'Usuário sem acesso ao sistema!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
                </script>";
                exit;
            }

            if (password_verify($senha, $senhabanco)) {

                if ($login['situac_senha'] == 0) {
                    echo "<script language=javascript>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        title: 'Atenção!',
                        text: 'Altere sua senha para realizar o login!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                          location.href='esqueci_senha';
                        }
                      });
                    </script>";
                    exit;
                }

                $_SESSION['id_usu_app'] = $login['id_usu'];
                $_SESSION['email_app'] = $login['email'];

                $id_usu = $login['id_usu'];
                $id_emp = $login['id_emp'];

                $id_emp = $id_emp;

                require_once "acesso.php";

                foreach (select_GESACE($id_usu) as $aceite_politicas) {

                    $status = $aceite_politicas["status"];
                }

                if ($status == "Pendente") {

                    //DIRECIONA PARA ACEITE POLITICAS
                    echo ("<script>window.open('https://www.gestou.com.br/app/aceite_politicas','_self')</script>");
                } else {

                    //DIRECIONA PARA INDEX
                    echo ("<script>window.open('https://www.gestou.com.br/app/index','_self')</script>");
                }

                exit;
            } else {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    title: 'Atenção!',
                    text: 'Usuário ou Senha incorretos!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
			</script>";

                exit;
            }
        }
    }
}

function email()
{

    global $result;
    global $senha;

    foreach (login_email($result) as $login) {

        if ($login == 0) {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                title: 'Atenção!',
                text: 'O e-mail informado não pertence a nenhum de nossos usuários!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='login';
                }
              });
            </script>";
        } else {

            $senhabanco = $login['senha'];

            if ($login['bloqueado'] == 1) {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    title: 'Atenção!',
                    text: 'Usuário sem acesso ao sistema!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
                </script>";
                exit;
            }

            if (password_verify($senha, $senhabanco)) {

                if ($login['situac_senha'] == 0) {
                    echo "<script language=javascript>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        title: 'Atenção!',
                        text: 'Altere sua senha para realizar o login!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                          location.href='esqueci_senha';
                        }
                      });
                    </script>";
                    exit;
                }

                $_SESSION['id_usu_app'] = $login['id_usu'];
                $_SESSION['email_app'] = $login['email'];

                $id_usu = $login['id_usu'];
                $id_emp = $login['id_emp'];

                $id_emp = $id_emp;

                require_once "acesso.php";

                foreach (select_GESACE($id_usu) as $aceite_politicas) {

                    $status = $aceite_politicas["status"];
                }

                if ($status == "Pendente") {

                    //DIRECIONA PARA ACEITE POLITICAS
                    echo ("<script>window.open('https://www.gestou.com.br/app/aceite_politicas','_self')</script>");
                } else {

                    //DIRECIONA PARA INDEX
                    echo ("<script>window.open('https://www.gestou.com.br/app/index','_self')</script>");
                }

                exit;
            } else {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    title: 'Atenção!',
                    text: 'Usuário ou Senha incorretos!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
			</script>";

                exit;
            }
        }
    }
}

function telefone()
{

    global $result;
    global $senha;

    foreach (login_telefone($result) as $login) {

        if ($login == 0) {

            echo "<script language=javascript>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                title: 'Atenção!',
                text: 'O telefone informado não pertence a nenhum de nossos usuários!'
            }).then((result) => {
                if (result.isConfirmed) {
                  location.href='login';
                }
              });
            </script>";
        } else {

            $senhabanco = $login['senha'];

            if ($login['bloqueado'] == 1) {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    title: 'Atenção!',
                    text: 'Usuário sem acesso ao sistema!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
                </script>";
                exit;
            }

            if (password_verify($senha, $senhabanco)) {

                if ($login['situac_senha'] == 0) {
                    echo "<script language=javascript>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        title: 'Atenção!',
                        text: 'Altere sua senha para realizar o login!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                          location.href='esqueci_senha';
                        }
                      });
                    </script>";
                    exit;
                }

                $_SESSION['id_usu_app'] = $login['id_usu'];
                $_SESSION['email_app'] = $login['email'];

                $id_usu = $login['id_usu'];
                $id_emp = $login['id_emp'];

                $id_emp = $id_emp;

                require_once "acesso.php";

                foreach (select_GESACE($id_usu) as $aceite_politicas) {

                    $status = $aceite_politicas["status"];
                }

                if ($status == "Pendente") {

                    //DIRECIONA PARA ACEITE POLITICAS
                    echo ("<script>window.open('https://www.gestou.com.br/app/aceite_politicas','_self')</script>");
                } else {

                    //DIRECIONA PARA INDEX
                    echo ("<script>window.open('https://www.gestou.com.br/app/index','_self')</script>");
                }

                exit;
            } else {
                echo "<script language=javascript>
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    title: 'Atenção!',
                    text: 'Usuário ou Senha incorretos!'
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.href='login';
                    }
                  });
			</script>";

                exit;
            }
        }
    }
}
