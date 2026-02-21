$(document).ready(function () {
    $("#btn-submit").click(function () {
        var fd = new FormData();
        var files = $('#input-b1')[0].files[0];
        fd.append('btn_add', 1);
        fd.append('file', files);

        Swal.fire({
            icon: 'info',
            title: 'Info',
            title: 'Aguarde!',
            text: 'O arquivo está sendo importado...',
            buttons: false,
            closeOnClickOutside: false,
            allowOutsideClick: false,
            timer: 10000,
            onOpen: () => {
                swal.showLoading();
            }
            //icon: "success"
        });


        $.ajax({
            url: 'controller/importar_colaboradores_post.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                // Processa a resposta da requisição
                switch (response.status) {
                    case 'sucesso':
                        // Exibe uma mensagem de sucesso usando a biblioteca SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            title: 'Sucesso!',
                            html: response.mensagem,
                            closeOnClickOutside: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "colaboradores";
                            }
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            title: 'Erro!',
                            html: response.mensagem,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        break;
                }
            },
        });
    });
});