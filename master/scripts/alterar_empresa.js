$(document).ready(function () {
    var $uploadCrop, tempFilename, rawImg, imageId;

    function readFile(input) {
        if (input.files && input.files[0]) {
            if (!input.files[0].type.match('image.*')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Por favor, selecione um arquivo de imagem válido.'
                });
                return;
            }

            var maxSize = 2 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'O arquivo é muito grande. O tamanho máximo é de 2MB.'
                });
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Desculpe, seu navegador não suporta o FileReader API.'
            });
        }
    }

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

    $('#cropImagePop').on('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });

    $('#cropImageBtn').on('click', function (ev) {
        Swal.fire({
            title: 'Processando...',
            text: 'Por favor, aguarde enquanto a imagem é processada.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'png',
            size: {
                width: 270,
                height: 270
            }
        }).then(function (resp) {
            $.ajax({
                url: "controller/alterar_empresa_post.php",
                type: "POST",
                dataType: 'json',
                data: {
                    "image": resp
                },
                success: function (response) {
                    console.log(response); // Adicionado para verificar a resposta
                    Swal.close();
                    switch (response.status) {
                        case 'sucesso':
                            var html = '<img src="' + resp + '" />';
                            $("#upload-image-i").html(html);
                            $('#cropImagePop').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: response.mensagem,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = 'alterar_empresa';
                                }
                            });
                            break;
                        case 'erro':
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: response.mensagem
                            });
                            break;
                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Resposta inválida do servidor.'
                            });
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Houve um problema ao enviar a imagem. Por favor, tente novamente.'
                    });
                }
            }).always(() => {
                // Fechar o alerta de processamento removido daqui
            });
            $('#cropImagePop').modal('hide');
        });
    });
});
$(document).ready(function () {
    $(document).on('click', '#remover_foto', function (e) {
        e.preventDefault(); // Evita o comportamento padrão
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você realmente deseja remover esta foto?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, remover!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var dados = {
                    remover_foto: 1,
                };

                $.post('controller/alterar_empresa_post.php', dados, function (retorna) {
                    switch (retorna.status) {
                        case "sucesso":
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Foto removida com sucesso!'
                            }).then(function () {
                                location.href = 'alterar_empresa';
                            });
                            break;
                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: retorna.mensagem
                            });
                            break;
                    }
                }, 'json');
            }
        });
    });
});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------- MÁSCARAS E FUNÇÕES ---------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

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
});

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

/* Manter a aba ao realizar as alterações */
// Realiza a verificação da sessão
$(document).ready(function () {
    $.post('verificar_sessao.php', function (retorna) {
        if (retorna == 1) {
            // variável de sessão está definida
            $('#nav-gestor-tab').addClass('active');
            $('#nav-gestor').addClass('show active');
        } else {
            // variável de sessão não está definida
            $('#nav-identificacao-tab').addClass('active');
            $('#nav-identificacao').addClass('show active');
        }
    });
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

// #form_editar_empresa - AÇÃO NO SUBMIT DO FORM #form_editar_empresa
$(function () {
    $(document).on('submit', '#form_editar_empresa', function (event) {

        event.preventDefault();

        var dados = {

            nome: $('#nome').val(),
            nomefantasia: $('#nomefantasia').val(),
            email: $('#email').val(),
            contato: $('#contato').val(),
            telefone: $('#telefone').val(),
            resp_financeiro: $('#resp_financeiro').val(),
            email_financeiro: $('#email_financeiro').val(),
            endereco: $('#endereco').val(),
            bairro: $('#bairro').val(),
            numero: $('#numero').val(),
            complemento: $('#complemento').val(),
            cidade: $('#cidade').val(),
            cep: $('#cep').val(),
            id_emp_h: $('#id_emp_h').val(),
            id_emp_p: $('#id_emp_p').val(),
            id_emp_i: $('#id_emp_i').val(),
            lay_folha: $('#lay_folha').val(),
            lay_ponto: $('#lay_ponto').val(),
            lay_irrf: $('#lay_irrf').val(),
            descricao_layout: $('#descricao_layout').val(),
            id_per_imp: $('#id_per_imp').val(),
            id_per_ace: $('#id_per_ace').val(),
            id_usa_rh: $('#id_usa_rh').val(),
            id_usa_ouv: $('#id_usa_ouv').val(),
            id_emp_grupo: $('#id_emp_grupo').val(),
            lay_h: $('#lay_h').val(),
            lay_p: $('#lay_p').val(),
            lay_i: $('#lay_i').val(),
            tipo_h: $('#tipo_h').val(),
            tipo_p: $('#tipo_p').val(),
            tipo_i: $('#tipo_i').val(),
            validacao_gestor: $('#validacao_gestor').val(),

            // FEA-010 — Líder RH
            limite_lideres: $('#limite_lideres').val(),
            limite_admins_ativos: $('#limite_admins_ativos').val(),

            btn_adicionar: 1
        };

        $.post('controller/alterar_empresa_post.php', dados, function (retorna) {
            // Processa a resposta da requisição
            switch (retorna.status) {
                case "sucesso":
                    // Em caso de sucesso, redireciona o usuário para a página 'alterar_empresa'
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Dados alterados com sucesso!'
                    }).then(function () {
                        location.href = "alterar_empresa";
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

// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando o botão com id 'btn-voltar' for clicado
    $(document).on('click', '#btn-voltar', function () {
        // Cria um objeto com os dados a serem enviados na requisição POST
        var dados = {
            btn_voltar: 1
        };

        // Faz uma requisição POST para o script PHP especificado com os dados fornecidos
        $.post('controller/alterar_empresa_post.php', dados, function (retorna) {
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

$(document).ready(function () {
    // Função para destacar a linha selecionada e guardar o ID do item
    $('.list-gestor').click(function () {
        var id = $(this).attr("id");

        // Limpa outras seleções
        $('.list-gestor').css({
            backgroundColor: "white"
        });

        // Destaca item selecionado
        $('#' + id).css({
            backgroundColor: "#eaecf4"
        });

        // Define o valor do botão com o ID do item selecionado
        $('.button-emp').val(id);
    });

    // Listener do botão de inclusão
    $('#btn-inc').click(function () {
        var selectedId = $(this).val(); // Obtém o valor do botão

        if (selectedId !== '') { // Verifica se o valor não está vazio
            var data = {
                btn_inc: selectedId
            };

            if (!selectedId.match(/\D/)) { // Verifica se o valor contém apenas dígitos
                $.post('controller/alterar_empresa_post.php', data, function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Gestor cadastrado com sucesso!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'alterar_empresa'; // Redireciona após confirmação
                        }
                    });
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione um usuário da tabela Usuários!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.close(); // Fecha o alerta após confirmação
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Selecione um Usuário da tabela Usuários!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.close(); // Fecha o alerta após confirmação
                }
            });
        }
    });

    // Listener do botão de exclusão
    $('#btn-exc').click(function () {
        var selectedId = $(this).val(); // Obtém o valor do botão

        if (selectedId !== '') { // Verifica se o valor não está vazio
            var data = {
                btn_exc: selectedId
            };

            if (selectedId.match(/\D/)) { // Verifica se o valor contém dígitos
                $.post('controller/alterar_empresa_post.php', data, function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Gestor removido com sucesso!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = 'alterar_empresa'; // Redireciona após confirmação
                        }
                    });
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione um Gestor da tabela Gestores!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.close(); // Fecha o alerta após confirmação
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Selecione um Gestor da tabela Gestores!'
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.close(); // Fecha o alerta após confirmação
                }
            });
        }
    });
});