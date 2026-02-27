<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>Troca Senha</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../img/logo.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css_login/util.css">
	<link rel="stylesheet" type="text/css" href="css_login/main.css">
	<!--===============================================================================================-->
	<!-- SWEET ALERT -->
	<link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
	<!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
	<script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
	<!--===============================================================================================-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-35 p-b-50">

				<?php
				session_name("troca_senha");
				require_once __DIR__."/../config/session.php"; session_start();

				if (!isset($_SESSION['troca_senha_cpf'])) {

					echo "
					<script>
					Swal.fire({
						icon: 'info',
						title: 'Info',
						title: 'Atenção!',
						text: 'Favor preencher o CPF!'
					}).then((result) => {
							location.href='esqueci_senha';
					});
					</script>
				";
				} else if (!isset($_SESSION['cod_liberado'])) {

					echo "
						<script>
						Swal.fire({
							icon: 'info',
							title: 'Info',
							title: 'Atenção!',
							text: 'Código não confirmado!'
						}).then((result) => {
								location.href='esqueci_valida_codigo';
						});
						</script>
					";
				}

				?>

				<span class="login100-form-title">
					<img src="../img/logo_gestou.png" style="width: 75%;"></img>
				</span>
				<span class="login100-form-title p-b-20" style="margin-top: -40px; font-size: 32px;"><img src="img/logo/texto_gestou_azul.png" style="width: 50%;"></img></span><br>

				<form id="form" class="login100-form flex-sb flex-w">

					<div class="wrap-input100 m-b-16">
						<input id="senha" class="input100" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();" type="password" name="senha" placeholder="Digite sua Senha" required></input>
						<span class="focus-input100"></span><i id="exibe" class="fas fa-eye-slash lnr-eye" onclick="mostrarSenha(); document.getElementById('exibe').style.display = 'none'; document.getElementById('oculta').style.display = 'inline';"></i>
						<i id="oculta" class="fas fa-eye lnr-eye" style="display: none;" onclick="mostrarSenha();document.getElementById('oculta').style.display = 'none'; document.getElementById('exibe').style.display = 'inline';"></i>
					</div>

					<div class="wrap-input100 m-b-16">
						<input id="confirm" class="input100" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();" type="password" name="confirm_senha" placeholder="Digite sua Senha Novamente" required></input>
						<span class="focus-input100"></span><i id="confirm_exibe" class="fas fa-eye-slash lnr-eye" onclick="confirmSenha(); document.getElementById('confirm_exibe').style.display = 'none'; document.getElementById('confirm_oculta').style.display = 'inline';"></i>
						<i id="confirm_oculta" class="fas fa-eye lnr-eye" style="display: none;" onclick="confirmSenha();document.getElementById('confirm_oculta').style.display = 'none'; document.getElementById('confirm_exibe').style.display = 'inline';"></i>
					</div>

					<div class="container-login100-form-btn m-b-16">
						<button type="submit" class="login100-form-btn">
							AVANÇAR
						</button>
					</div>

					<div class="container-voltar-btn">
						<button type="button" class="voltar-btn">
							VOLTAR
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<!-- <script src="vendor_login/jquery/jquery-3.2.1.min.js"></script> -->
	<!--===============================================================================================-->
	<script src="vendor_login/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor_login/bootstrap/js/popper.js"></script>
	<script src="vendor_login/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor_login/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor_login/daterangepicker/moment.min.js"></script>
	<script src="vendor_login/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor_login/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js_login/main.js"></script>

	<!-- REQUISITOS MÁSCARAS JS -->
	<!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
	<script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

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
		var tipo = document.getElementById("confirm");
		if (tipo.type == "password") {
			tipo.type = "text";
		} else {
			tipo.type = "password";
		}
	}
</script>

<!-- AÇÕES NO CLICK -->
<script>
	// BTN VOLTAR
	$(function() {
		$(document).on('click', '.voltar-btn', function() {

			location.href = 'esqueci_valida_codigo';
		});
	});


	// QUANDO O FORMULÁRIO É SUBMETIDO
	$(document).ready(function() {
		$("#form").submit(function(event) {
			// Previne o comportamento padrão do formulário (recarregar a página)
			event.preventDefault();

			// Valor que define que o formulário foi submetido
			var btn_submit = 1;

			// Obtém os valores do formulário
			var dados_form = {

				senha: $('#senha').val(),
				confirm: $('#confirm').val(),

				btn_submit: btn_submit
			};
			$.post('controller/esqueci_troca_senha_post.php', dados_form, function(retorno) {

				switch (retorno) {
					// Senhas não coincidem
					case '0':
						Swal.fire({
							icon: 'warning',
							title: 'Attention',
							title: 'Atenção!',
							text: 'As senhas inseridas não coincidem.',
							allowEscapeKey: false,
							closeOnClickOutside: false,
							allowOutsideClick: false
						}).then((result) => {
							if (result.isConfirmed) {

								swal.close();
							}
						});
						break;

						// Senha atualizada
					case '1':
						Swal.fire({
							icon: 'success',
							title: 'Success!',
							title: 'Sucesso!',
							text: 'Sua senha foi alterada com sucesso!',
							allowEscapeKey: false,
							closeOnClickOutside: false,
							allowOutsideClick: false
						}).then((result) => {
							if (result.isConfirmed) {

								location.href = 'login';
							}
						});
						break;

						// Erro no Try
					default:
						Swal.fire({
							icon: 'info',
							title: 'Please contact support!',
							title: 'Favor entrar em contato com o suporte!',
							html: retorno,
							allowEscapeKey: false,
							closeOnClickOutside: false,
							allowOutsideClick: false
						}).then((result) => {
							if (result.isConfirmed) {

								location.reload();
							}
						});
						break;

				}
			});
		});
	});
</script>