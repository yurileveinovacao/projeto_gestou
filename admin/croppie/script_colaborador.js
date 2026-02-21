// Start upload preview image
// $(".gambar").attr("src", "http://erssolucoes.com.br/profile_male.jpg");

var nome_div = document.getElementById("div_teste");
var id_fun = nome_div.getAttribute("namespace");
var $uploadCrop,
tempFilename,
rawImg,
imageId;
function readFile(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('.upload-demo').addClass('ready');
			$('#cropImagePop').modal('show');
			rawImg = e.target.result;
		}
		reader.readAsDataURL(input.files[0]);
	}
	else {
		swal("Desculpe, seu navegador não suporta o FileReader API.");
	}
}

$uploadCrop = $('#upload-demo').croppie({
	enableExif: true,
            viewport: { width: 140, height: 140, type: 'circle' },
            boundary: { width: 300, height: 300 },
            enableOrientation: true,
            mouseWheelZoom: 'ctrl',
});
$('#cropImagePop').on('shown.bs.modal', function(){
							// alert('Shown pop');
							$uploadCrop.croppie('bind', {
								url: rawImg
							}).then(function(){
								console.log('jQuery bind complete');
							});
						});

$('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
	$('#cancelCropBtn').data('id', imageId); readFile(this); });
$('#cropImageBtn').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'base64',
		format: 'png',
		size: {width: 270, height: 270}
	}).then(function (resp) {
		// $('#item-img-output').attr('src', resp);
//		$('#cropImagePop').modal('hide');

$.ajax({
	url: "croppie_colaborador.php",
	type: "POST",
	data: {"image":resp},
	success: function (data) {
		html = '<img src="' + resp + '" />';
		$("#upload-image-i").html(html);
		$('#cropImagePop').modal('hide');
		// alert('Foto alterada com sucesso!');
		Swal.fire({
			icon: 'success',
			title: 'Success',
			title: 'Sucesso!',
			text: 'Foto alterada com sucesso!'
		}).then((result) => {
		location.href = "alterar_colaborador";

		});
	}
});
$('#cropImagePop').modal('hide');
// $("#div_teste").load(" #div_teste > *");
});
});
				// End upload preview image