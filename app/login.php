<?php

require_once __DIR__."/../config/session.php"; session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>GESTOU APP</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
	<meta name="description" content="Acesse seu holerite, espelho de ponto, recibos e demais documentos do DP pelo app Gestou.">

	<!-- Open Graph (WhatsApp, Facebook, LinkedIn) -->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Gestou">
	<meta property="og:title" content="Gestou — App do Colaborador">
	<meta property="og:description" content="Acesse seu holerite, espelho de ponto, recibos e demais documentos do DP pelo app Gestou.">
	<meta property="og:image" content="https://www.gestou.com.br/img/logo_gestou.png">
	<meta property="og:image:width" content="499">
	<meta property="og:image:height" content="498">
	<meta property="og:image:type" content="image/png">
	<meta property="og:url" content="https://www.gestou.com.br/app/login">
	<meta property="og:locale" content="pt_BR">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Gestou — App do Colaborador">
	<meta name="twitter:description" content="Acesse seu holerite, espelho de ponto, recibos e demais documentos do DP pelo app Gestou.">
	<meta name="twitter:image" content="https://www.gestou.com.br/img/logo_gestou.png">

	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="/img/favicon.png">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor_login/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts_login/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts_login/Linearicons-Free-v1.0.0/icon-font.min.css">
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

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<?php include __DIR__.'/pwa_head.php'; ?>
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-20 p-b-10">
				<span class="login100-form-title">
					<img src="../img/logo_gestou.png" style="width: 75%;"></img>
					<!-- <span class="txt1">Selecione a forma de identificação</span> -->
				</span>
				<!-- <span class="login100-form-title p-b-20" style="margin-top: -40px; font-size: 32px;"><img src="img/logo/texto_gestou_azul.png" style="width: 50%;"></img></span><br> -->
				<form class="login100-form flex-sb flex-w" action="validar_login" method="POST">

					<div class="container-opcoes m-t-17 m-b-15 justify-content-center">

						<label id="labelcpf" for="CPF" class="label-opcoes1" style="color: #FFF;" onclick="
							// JAVASCRIPT DO LABEL
							document.getElementById('labelcpf').style.color = '#FFF';document.getElementById('labelemail').style.color = '#003099';document.getElementById('labelcelular').style.color = '#003099';
							document.getElementById('cpf').style.display = 'inline';document.getElementById('email').style.display = 'none'; document.getElementById('celular').style.display = 'none';
							document.getElementById('inputcpf').required = true;document.getElementById('inputemail').required = false;document.getElementById('telefone').required = false;
							document.getElementById('inputemail').value = '';document.getElementById('telefone').value = '';
							// FIM JAVASCRIPT LABEL
							">CPF</label>

						<label id="labelemail" for="E-Mail" class="label-opcoes2" style="color: #003099;" onclick="
							// JAVASCRIPT DO LABEL
							document.getElementById('labelemail').style.color = '#FFF';document.getElementById('labelcpf').style.color = '#003099';document.getElementById('labelcelular').style.color = '#003099';
							document.getElementById('email').style.display = 'inline'; document.getElementById('cpf').style.display = 'none'; document.getElementById('celular').style.display = 'none';
							document.getElementById('inputemail').required = true;document.getElementById('inputcpf').required = false;document.getElementById('telefone').required = false;
							document.getElementById('inputcpf').value = '';document.getElementById('telefone').value = '';
							// FIM JAVASCRIPT LABEL
							">E&minus;MAIL</label>
						<label id="labelcelular" for="Celular" class="label-opcoes3" style="color: #003099;" onclick="
							// JAVASCRIPT DO LABEL
							document.getElementById('labelcelular').style.color = '#FFF';document.getElementById('labelcpf').style.color = '#003099';document.getElementById('labelemail').style.color = '#003099';
							document.getElementById('celular').style.display = 'inline'; document.getElementById('cpf').style.display = 'none'; document.getElementById('email').style.display = 'none';
							document.getElementById('telefone').required = true;document.getElementById('inputcpf').required = false;document.getElementById('inputemail').required = false;
							document.getElementById('inputcpf').value = '';document.getElementById('inputemail').value = '';
							// FIM JAVASCRIPT LABEL
							">CELULAR</label>

					</div>

					<div class="container-nome-form-btn m-t-17 m-b-15 justify-content-center">

						<input type="radio" id="CPF" name="opcao" value="CPF" class="nome-form-btn" checked>

						</input>
						<input type="radio" id="E-Mail" name="opcao" value="email" namespace="email" class="email-form-btn">

						</input>
						<input type="radio" id="Celular" name="opcao" value="telefone" namespace="telefone" class="celular-form-btn">

						</input>
					</div>

					<div id="cpf" class="wrap-input100 m-b-16">
						<input id="inputcpf" class="input100" attrname="CPF" type="tel" name="CPF" required placeholder="Digite seu CPF" minlength="14">
						<span class="focus-input100"></span>
					</div>

					<div id="email" style="display: none;" class="wrap-input100 m-b-16">
						<input id="inputemail" class="input100" type="email" name="email" placeholder="Digite seu E-Mail">
						<span class="focus-input100"></span>
					</div>

					<div id="celular" style="display: none;" class="wrap-input100 m-b-16">
						<input class="input100" type="tel" name="telefone" id="telefone" maxlength="16" attrname="celular" placeholder="Digite seu Celular">
						<span class="focus-input100"></span>
					</div>


					<div class="wrap-input100 m-b-16">
						<input id="senha" class="input100" onfocus="document.getElementById('icone').style.display = 'inline';" onclick="mostrarIcone();" type="password" name="senha" placeholder="Digite sua Senha" required></input>
						<span class="focus-input100"></span><i id="exibe" class="fas fa-eye-slash lnr-eye" onclick="mostrarSenha(); document.getElementById('exibe').style.display = 'none'; document.getElementById('oculta').style.display = 'inline';"></i>
						<i id="oculta" class="fas fa-eye lnr-eye" style="display: none;" onclick="mostrarSenha();document.getElementById('oculta').style.display = 'none'; document.getElementById('exibe').style.display = 'inline';"></i>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="contact100-form-checkbox">
							<div>
								<a href="esqueci_senha" class="txt1">
									Esqueceu sua senha?
								</a>
							</div>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" name="logar" class="login100-form-btn">
							ENTRAR
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="vendor_login/jquery/jquery-3.2.1.min.js"></script>
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
	<script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
	<script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

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

		// FUNÇÃO MÁSCARAS
		function inputHandler(masks, max, event) {
			var c = event.target;
			var v = c.value.replace(/\D/g, '');
			var m = c.value.length > max ? 1 : 0;
			VMasker(c).unMask();
			VMasker(c).maskPattern(masks[m]);
			c.value = VMasker.toPattern(v, masks[m]);
		}

		// MÁSCARA CPF
		var cpfMask = ['999.999.999-99', '999.999.999-99'];
		var cpf = document.querySelector('input[attrname=CPF]');
		VMasker(cpf).maskPattern(cpfMask[0]);
		cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false);

		// MÁSCARA CEL
		var celMask = ['(999) 99999-9999', '(999) 99999-9999'];
		var cel = document.querySelector('input[attrname=celular]');
		VMasker(cel).maskPattern(celMask[0]);
		cel.addEventListener('input', inputHandler.bind(undefined, celMask, 16), false);
	</script>

<?php include __DIR__.'/pwa_register.php'; ?>
</body>

</html>