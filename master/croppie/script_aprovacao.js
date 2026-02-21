// Start upload preview image
// Função para ler o arquivo de imagem selecionado
function readFile(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('.upload-demo').addClass('ready');
			$('#cropImagePop').modal('show');
			rawImg = e.target.result;
		};
		reader.readAsDataURL(input.files[0]);
	} else {
		swal("Desculpe, seu navegador não suporta o FileReader API.");
	}
}

// Inicialização do plugin de recorte de imagem
$uploadCrop = $('#upload-demo').croppie({
	enableExif: true,
	viewport: {
		width: 140,
		height: 140,
		type: 'circle'
	},
	boundary: {
		width: 300,
		height: 300
	},
	enableOrientation: true,
	mouseWheelZoom: 'ctrl'
});

// Função executada quando o modal de recorte de imagem é exibido
$('#cropImagePop').on('shown.bs.modal', function () {
	$uploadCrop.croppie('bind', {
		url: rawImg
	}).then(function () {
		console.log('jQuery bind complete');
	});
});

// Função executada quando um novo arquivo de imagem é selecionado
$('.item-img').on('change', function () {
	imageId = $(this).data('id');
	tempFilename = $(this).val();
	$('#cancelCropBtn').data('id', imageId);
	readFile(this);
});

// Função executada quando o botão de recorte de imagem é clicado
$('#cropImageBtn').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'base64',
		format: 'png',
		size: {
			width: 270,
			height: 270
		}
	}).then(function (resp) {
		$.ajax({
			url: "croppie_aprovacao.php",
			type: "POST",
			data: {
				"image": resp
			},
			success: function (data) {
				html = '<img src="' + resp + '" />';
				$("#upload-image-i").html(html);
				$('#cropImagePop').modal('hide');
				Swal.fire({
					icon: 'success',
					title: 'Sucesso!',
					text: 'Foto alterada com sucesso!'
				}).then((result) => {
					location.href = "alterar_aprovacao";
				});
			}
		});
		$('#cropImagePop').modal('hide');
	});
});
// End upload preview image