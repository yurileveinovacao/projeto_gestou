<!DOCTYPE html>
<html lang="pt-BR">

<head>

	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../img/logo.ico" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Admin - Esqueci Senha</title>

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
								<img src="../img/logo_gestou.png" height="250"></img><br><img src="../img/texto_gestou_azul.png" style="width: 40%; margin-top: -40px">
							</div>
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Esqueci Senha!</h1>
									</div>
									<form class="user" action="esqueci_senha.php" method="POST">
										<div class="form-group">
											<input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Digite seu E-mail">
										</div>
										<div class="form-group">
											<button type="submit" name="consulta-email" class="btn btn-brave btn-user btn-block">
												<h6 class="mb-0"><span class="fonte-texto-gestou">AVANÇAR</span></h6>
											</button>
										</div>
										<div class="form-group">
											<a href="login" style="text-decoration: none;"><button type="button" class="btn btn-voltar btn-user btn-block">
													<h6 class="mb-0"><span class="fonte-texto-gestou">VOLTAR</span></h6>
												</button></a>
										</div>
									</form>
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

require_once 'iuds_pdo.php';

try {
	// ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
	if (isset($_REQUEST['consulta-email'])) {
		$email = $_POST['email'];

		// echo $cpf;

		foreach (consulta_email($email) as $consulta_email) {

			if ($consulta_email == 0) {

				echo "<script language=javascript>
                alert('Email não encontrado ou não registrado na base de dados!');
                location.href = 'esqueci_senha';
                </script>";
			} else {

				$nome = $consulta_email['nome'];
				$id_usa = $consulta_email['id_usa'];
				$email = $consulta_email['email'];

				session_name("senha_admin");
				session_start();

				$_SESSION["senha_admin_email"] = $email;

				for ($i = 0, $z = strlen($a = '1234567890') - 1, $s = $a{
					rand(0, $z)}, $i = 1; $i != 6; $x = rand(0, $z), $s .= $a{
					$x}, $s = ($s{
					$i} == $s{
					$i - 1} ? substr($s, 0, -1) : $s), $i = strlen($s));

				$codigo = $s;

				$contrasenha = password_hash($codigo, PASSWORD_DEFAULT);

				update_contrasenha_GESUSU($id_usa, $contrasenha);

				require "esqueci_email.php";

				echo "<script language=javascript>
					alert('Enviamos um código de validação para seu e-mail!');
					location.href = 'esqueci_valida_codigo';
					</script>";
			}
		}
	}
} catch (PDOException $erro) {
	echo $erro->getMessage();
}


function Mask($mask, $str)
{

	$str = str_replace(" ", "", $str);

	for ($i = 0; $i < strlen($str); $i++) {
		$mask[strpos($mask, "#")] = $str[$i];
	}

	return $mask;
}

?>