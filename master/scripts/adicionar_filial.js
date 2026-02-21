// // Quando o documento HTML estiver totalmente carregado, executa esta função
// $(document).ready(function () {
//     // Variáveis para manipulação da imagem
//     var $uploadCrop, tempFilename, rawImg, imageId;

//     // Função para ler o arquivo de imagem selecionado pelo usuário
//     function readFile(input) {
//         if (input.files && input.files[0]) {
//             // Verificar se o arquivo é uma imagem
//             if (!input.files[0].type.match('image.*')) {
//                 // Alerta de erro se o arquivo não for uma imagem
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Erro',
//                     text: 'Por favor, selecione um arquivo de imagem válido.'
//                 });
//                 return;
//             }

//             // Verificar o tamanho máximo da imagem (2MB)
//             var maxSize = 2 * 1024 * 1024;
//             if (input.files[0].size > maxSize) {
//                 // Alerta de erro se o arquivo for muito grande
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Erro',
//                     text: 'O arquivo é muito grande. O tamanho máximo é de 2MB.'
//                 });
//                 return;
//             }

//             var reader = new FileReader();
//             reader.onload = function (e) {
//                 // Mostrar a imagem no modal de recorte
//                 $('.upload-demo').addClass('ready');
//                 $('#cropImagePop').modal('show');
//                 rawImg = e.target.result;
//             }
//             reader.readAsDataURL(input.files[0]);
//         } else {
//             // Alerta de erro se o navegador não suportar o FileReader API
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Erro',
//                 text: 'Desculpe, seu navegador não suporta o FileReader API.'
//             });
//         }
//     }

//     // Inicializar o croppie para permitir o recorte da imagem
//     $uploadCrop = $('#upload-demo').croppie({
//         enableExif: true,
//         viewport: {
//             width: 140,
//             height: 140,
//             type: 'circle'
//         },
//         boundary: {
//             width: 300,
//             height: 300
//         },
//         enableOrientation: true,
//         mouseWheelZoom: 'ctrl'
//     });

//     // Evento quando o modal de recorte é mostrado
//     $('#cropImagePop').on('shown.bs.modal', function () {
//         // Vincular a imagem ao croppie
//         $uploadCrop.croppie('bind', {
//             url: rawImg
//         }).then(function () {
//             console.log('jQuery bind complete');
//         });
//     });

//     // Evento quando o arquivo de imagem é alterado
//     $('.item-img').on('change', function () {
//         imageId = $(this).data('id');
//         tempFilename = $(this).val();
//         $('#cancelCropBtn').data('id', imageId);
//         readFile(this);
//     });

//     // Evento quando o botão de recortar imagem é clicado
//     $('#cropImageBtn').on('click', function (ev) {
//         // Exibir alerta de processamento
//         Swal.fire({
//             title: 'Processando...',
//             text: 'Por favor, aguarde enquanto a imagem é processada.',
//             allowOutsideClick: false,
//             didOpen: () => {
//                 Swal.showLoading();
//             }
//         });

//         // Obter o resultado do recorte da imagem
//         $uploadCrop.croppie('result', {
//             type: 'base64',
//             format: 'png',
//             size: {
//                 width: 270,
//                 height: 270
//             }
//         }).then(function (resp) {
//             // Enviar a imagem recortada para o servidor via AJAX
//             $.ajax({
//                 url: "adicionar_filial_post.php",
//                 type: "POST",
//                 dataType: 'json',
//                 data: {
//                     "image": resp
//                 },
//                 success: function (response) {
//                     // Manipular a resposta do servidor
//                     switch (response.status) {
//                         case 'sucesso':
//                             // Se o upload for bem-sucedido, exibir a imagem recortada e recarregar a página
//                             var html = '<img src="' + resp + '" />';
//                             $("#upload-image-i").html(html);
//                             $('#cropImagePop').modal('hide');
//                             Swal.fire({
//                                 icon: 'success',
//                                 title: 'Sucesso',
//                                 text: response.mensagem,
//                                 allowOutsideClick: false
//                             }).then((result) => {
//                                 if (result.isConfirmed) {
//                                     window.location.reload();
//                                 }
//                             });
//                             break;
//                         case 'erro':
//                             // Se houver um erro, exibir uma mensagem de erro
//                             Swal.fire({
//                                 icon: 'error',
//                                 title: 'Erro',
//                                 text: response.mensagem
//                             });
//                             break;
//                         default:
//                             // Resposta inválida do servidor
//                             Swal.fire({
//                                 icon: 'error',
//                                 title: 'Erro',
//                                 text: 'Resposta inválida do servidor.'
//                             });
//                     }
//                 },
//                 error: function (err) {
//                     // Se houver um erro durante a requisição AJAX, exibir uma mensagem de erro
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Erro',
//                         text: 'Houve um problema ao enviar a imagem. Por favor, tente novamente.'
//                     });
//                 }
//             }).always(() => {
//                 // Fechar o alerta de processamento após a conclusão da requisição AJAX
//                 Swal.close();
//             });
//             // Fechar o modal de recorte
//             $('#cropImagePop').modal('hide');
//         });
//     });
// });

$(document).ready(function () {

    // Função para lidar com a entrada de dados nos campos de entrada
    function inputHandler(masks, max, event) {
        var input = event.target;
        var value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        var maskIndex = input.value.length > max ? 1 : 0; // Determina qual máscara aplicar com base no tamanho máximo
        VMasker(input).unMask(); // Remove a máscara atual
        VMasker(input).maskPattern(masks[maskIndex]); // Aplica a máscara correta
        input.value = VMasker.toPattern(value, masks[maskIndex]); // Formata o valor de acordo com a máscara
    }

    // Seleciona o atributo 'attrname' do input de telefone (telefone / celular)
    var telefoneName = $('input#telefone').attr('attrname');

    // Verifica se o atributo 'attrname' é 'telefone' ou 'celular' e define a máscara correta
    if (telefoneName == 'telefone') {
        // Máscaras para telefone
        var telMasks = ['(999) 9999-99999', '(999) 9 9999-9999'];
        var telInput = document.querySelector('input[attrname=telefone]');
        VMasker(telInput).maskPattern(telMasks[0]); // Aplica a máscara inicial
        telInput.addEventListener('input', inputHandler.bind(undefined, telMasks, 15), false); // Adiciona um ouvinte de evento de entrada
    } else {
        // Máscaras para celular
        var celMasks = ['(999) 9999-9999', '(999) 9 9999-9999'];
        var celInput = document.querySelector('input[attrname=celular]');
        VMasker(celInput).maskPattern(celMasks[1]); // Aplica a máscara inicial
        celInput.addEventListener('input', inputHandler.bind(undefined, celMasks, 15), false); // Adiciona um ouvinte de evento de entrada
    }

    // Máscara para CEP
    var cepMasks = ['99999-9999', '99999-999'];
    var cepInput = document.querySelector('input[attrname=cep]');
    VMasker(cepInput).maskPattern(cepMasks[0]); // Aplica a máscara inicial
    cepInput.addEventListener('input', inputHandler.bind(undefined, cepMasks, 8), false); // Adiciona um ouvinte de evento de entrada

    // Máscara para CEP
    var cnpjMasks = ['9999-99', '9999-99'];
    var cnpjInput = document.querySelector('input[attrname=cnpjfinal]');
    VMasker(cnpjInput).maskPattern(cnpjMasks[0]); // Aplica a máscara inicial
    cnpjInput.addEventListener('input', inputHandler.bind(undefined, cnpjMasks, 6), false); // Adiciona um ouvinte de evento de entrada
});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------- VALIDAÇÃO E ENVIO DO FORM ---------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

(function () {
    'use strict';

    // Espera o carregamento completo da página
    window.addEventListener('load', function () {
        // Seleciona todos os formulários que requerem validação
        var forms = document.querySelectorAll('.needs-validation');

        // Itera sobre os formulários e previne o envio caso a validação falhe
        Array.prototype.forEach.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                // Verifica se o formulário é válido
                if (!form.checkValidity()) {
                    // Se não for válido, previne o envio do formulário
                    event.preventDefault();
                    // Previne a propagação do evento
                    event.stopPropagation();
                    // Exibe um alerta para o usuário preencher os campos obrigatórios em todas as abas
                    // Resposta inválida do servidor
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        html: 'Preencha os campos requeridos em todas as abas!'
                    });
                }
                // Adiciona a classe 'was-validated' ao formulário para aplicar estilos de validação do Bootstrap
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$(function () {
    // Evento para remover a marca de invalidez quando o usuário começar a digitar novamente
    $('#cnpj-final').on('input', function () {
        var cnpjField = $(this);
        cnpjField.removeClass('is-invalid');
        cnpjField[0].setCustomValidity('');
    });
});

// #form_adicionar_filial - AÇÃO NO SUBMIT DO FORM #form_adicionar_filial
$(function () {
    $(document).on('submit', '#form_adicionar_filial', function (event) {

        event.preventDefault();

        var dados = {

            nome: $('#nome').val(),
            nomefantasia: $('#nomefantasia').val(),
            cnpj_raiz: $('#cnpj-raiz').val(),
            cnpj_final: $('#cnpj-final').val(),
            email: $('#email').val(),
            contato: $('#contato').val(),
            telefone: $('#telefone').val(),
            resp_financeiro: $('#resp_financeiro').val(),
            email_financeiro: $('#email_financeiro').val(),
            endereco: $('#endereco').val(),
            bairro: $('#bairro').val(),
            numero: $('#numero').val(),
            complemento: $('#complemento').val(),
            estado: $('#estado').val(),
            cidade: $('#cidade').val(),
            cep: $('#cep').val(),
            btn_adicionar: 1
        };

        $.post('controller/adicionar_filial_post.php', dados, function (retorna) {
            var cnpjField = $('#cnpj-final');
            // Processa a resposta da requisição
            switch (retorna.status) {
                case "sucesso":
                    // Em caso de sucesso, redireciona o usuário para a página 'adicionar_usuario'
                    location.href = "adicionar_usuario";
                    break;
                case "verifica_cnpj":

                    // Marcar o campo como inválido
                    cnpjField.addClass('is-invalid');
                    cnpjField[0].setCustomValidity('invalid');
                    cnpjField.next('.invalid-feedback').show();

                    // Em caso de erro, exibe um alerta com a mensagem de erro
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        html: retorna.mensagem
                    });
                    break;
                default:
                    // Em caso de erro, exibe um alerta com a mensagem de erro
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: retorna.mensagem
                    });
                    break;
            }
        }, 'json');

    })
});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** -----------------------------------------------------------------  ---------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// Recebe parametros da url
function getUrlVars() {
    var vars = [],
        hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(function () {
    $('#estado').change(function () {
        if ($(this).val()) {
            $('#cidade').hide();
            $('.carregando').show();
            $.getJSON('select_cidade.php?search=', {
                estado: $(this).val(),
                ajax: 'true'
            }, function (j) {
                var options =
                    '<option value="" selected disabled>Escolha a Cidade</option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].id_mun + '" namespace="' + j[i]
                        .cep_mun + '">' + j[i].nome_mun + '</option>';
                }
                $('#cidade').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
        }
    });
});

document.getElementById("estado").onchange = function () {
    // var select = document.getElementById("estado");
    // var cep = select.options[select.selectedIndex].getAttribute("namespace");
    document.querySelector("[name='cep']").value = '';
}

document.getElementById("cidade").onchange = function () {
    var select = document.getElementById("cidade");
    var cep = select.options[select.selectedIndex].getAttribute("namespace");
    document.querySelector("[name='cep']").value = cep;

}

// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando o botão com id 'btn-voltar' for clicado
    $(document).on('click', '#btn-voltar', function () {
        // Cria um objeto com os dados a serem enviados na requisição POST
        var dados = {
            btn_voltar: 1
        };

        // Faz uma requisição POST para o script PHP especificado com os dados fornecidos
        $.post('controller/adicionar_filial_post.php', dados, function (retorna) {
            // Processa a resposta da requisição
            switch (retorna.status) {
                case "sucesso":
                    // Em caso de sucesso, redireciona o usuário para a página 'adicionar_usuario'
                    location.href = "tabela_empresas";
                    break;
                default:
                    // Em caso de erro, exibe um alerta com a mensagem de erro
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: retorna.mensagem
                    });
                    break;
            }
        }, 'json');
    });
});