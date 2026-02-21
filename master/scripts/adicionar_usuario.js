// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando um elemento com a classe 'list-gestor' for clicado
    $(document).on('click', '.list-gestor', function () {
        // Remove a classe 'active' e restaura a cor de fundo de todas as linhas
        $('.list-gestor').removeClass('active').css({
            backgroundColor: ""
        });

        // Adiciona a classe 'active' e muda a cor de fundo para a linha clicada
        $(this).addClass('active').css({
            backgroundColor: "#eaecf4"
        });

        // Verifica se a linha clicada agora tem a classe 'active'
        if ($(this).hasClass('active')) {
            // Se tiver, ativa o botão
            $('#btn-add-usuario').prop('disabled', false);
        } else {
            // Se não tiver, desativa o botão
            $('#btn-add-usuario').prop('disabled', true);
        }
    });

    // Inicialmente desativa o botão
    $('#btn-add-usuario').prop('disabled', true);
});


// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando um elemento com a classe 'btn-add-usuario' for clicado
    $(document).on('click', '#btn-add-usuario', function () {

        // Encontra a linha pai do botão clicado
        var row = $('#tabela-usuarios').find('tr.active');

        // Verifica se a linha com a classe .active existe
        if (row.length) {
            // Obtém o token da linha
            var token = row.data("token");

            // Verifica se o token é válido
            if (token !== undefined && token !== '') {
                // Define os dados a serem enviados via POST
                var dados = {
                    token: token,
                    btn_add: 1
                };

                // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
                $.post('controller/adicionar_usuario_post.php', dados, function (retorna) {
                    // Manipula a resposta do servidor
                    switch (retorna.status) {
                        // Se a resposta for "sucesso"
                        case "sucesso":
                            // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                html: 'Usuário adicionado com sucesso!',
                                allowOutsideClick: false
                            }).then((result) => {
                                // Recarrega a página quando o usuário confirmar o erro
                                if (result.isConfirmed) {
                                    window.location.href = "tabela_empresas.php";
                                }
                            });
                            break;
                            // Se a resposta for diferente de "sucesso"
                        default:
                            // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                html: 'Ocorreu um erro ao adicionar o usuário!',
                                allowOutsideClick: false
                            }).then((result) => {
                                // Recarrega a página quando o usuário confirmar o erro
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                            break;
                    }
                }, 'json'); // Especifica o tipo de dados esperados na resposta do servidor
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                html: 'Não foi selecionado nenhum usuário!',
                allowOutsideClick: false
            });
        }

    });
});

// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando um elemento com a classe 'btn-new-usuario' for clicado
    $(document).on('click', '#btn-new-usuario', function () {

        window.location.href = "adicionar_novo_usuario";

    });
});