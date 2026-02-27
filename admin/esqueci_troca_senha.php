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
										<h1 class="h4 text-gray-900 mb-4">Trocar Senha!</h1>
									</div>
									<form class="user" action="esqueci_troca_senha" method="POST">
										<div class="form-group">
											<input type="password" name="senha" class="form-control form-control-user" id="senha" placeholder="Digite sua Senha" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();"></input><span style="text-align: right !important;"></span><i id="exibe" class="fas fa-eye-slash lnr-eye" onclick="mostrarSenha(); document.getElementById('exibe').style.display = 'none'; document.getElementById('oculta').style.display = 'inline';"></i>
											<i id="oculta" class="fas fa-eye lnr-eye" style="display: none;" onclick="mostrarSenha();document.getElementById('oculta').style.display = 'none'; document.getElementById('exibe').style.display = 'inline';"></i>
										</div>
										<div class="form-group">
											<input type="password" name="confirm_senha" class="form-control form-control-user" id="confirm_senha" placeholder="Digite sua Senha Novamente" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();"></input><span style="text-align: right !important;"></span><i id="confirm_exibe" class="fas fa-eye-slash lnr-eye1" onclick="confirmSenha(); document.getElementById('confirm_exibe').style.display = 'none'; document.getElementById('confirm_oculta').style.display = 'inline';"></i>
											<i id="confirm_oculta" class="fas fa-eye lnr-eye1" style="display: none;" onclick="confirmSenha();document.getElementById('confirm_oculta').style.display = 'none'; document.getElementById('confirm_exibe').style.display = 'inline';"></i>
										</div>
										<div class="form-group">
											<button type="submit" name="troca-senha" class="btn btn-brave btn-user btn-block">
												<h6 class="mb-0"><span class="fonte-texto-gestou">AVANÇAR</span></h6>
											</button>
										</div>
										<div class="form-group">
											<a href="esqueci_valida_codigo" style="text-decoration: none;"><button type="button" class="btn btn-voltar btn-user btn-block">
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
<script>
	//MOSTRA E OCULTA A SENHA
	function mostrarSenha() {
		var tipo = document.getElementById("senha");
		if (tipo.type == "password") {
			tipo.type = "text";
		} else {
			tipo.type = "password";
		}
	}

	function confirmSenha() {
		var tipo = document.getElementById("confirm_senha");
		if (tipo.type == "password") {
			tipo.type = "text";
		} else {
			tipo.type = "password";
		}
	}
</script>

<?php

require_once 'iuds_pdo.php';

try {
	// ********AÇÃO EXECUTADA APENAS QUANDO CLICAR NO BOTÃO
	if (isset($_REQUEST['troca-senha'])) {

		session_name("senha_admin");
		require_once __DIR__."/../config/session.php"; session_start();

		$senha = $_POST['senha'];
		$confirm_senha = $_POST['confirm_senha'];
		$email = $_SESSION["senha_admin_email"];

		if ($senha == $confirm_senha) {

			foreach(select_consulta_email($email) as $consulta_email){

				$nome = $consulta_email['nome'];
				$email = $consulta_email['email'];

			}

			$nova_senha = password_hash($senha, PASSWORD_DEFAULT);

			update_senha_GESUSU($nova_senha, $email);

			require "esqueci_email_senha_alterada.php";

			unset($_SESSION["senha_admin_email"]);

			echo "<script>
			alert('Sua senha foi alterada com sucesso!');
			location.href='login';
			</script>";
		} else {

			echo "<script>
			alert('As senhas inseridas não coincidem!');
			location.href='esqueci_troca_senha';
			</script>";
		}
	}
} catch (PDOException $erro) {
	echo $erro->getMessage();
}


?>