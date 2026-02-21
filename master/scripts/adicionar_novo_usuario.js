/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------- MÁSCARAS JS ---------------------------------------------------------------------------------------------- */
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

    // Configurações da máscara para CPF
    var cpfMask = ['999.999.999-99', '999.999.999-99']; // Define a máscara para CPF
    var cpf = document.querySelector('input[attrname=CPF]'); // Seleciona o campo de entrada de CPF
    VMasker(cpf).maskPattern(cpfMask[0]); // Aplica a máscara inicial para CPF
    cpf.addEventListener('input', inputHandler.bind(undefined, cpfMask, 14), false); // Adiciona um evento de input para aplicar a máscara conforme o usuário digita

    // Configurações da máscara para telefone
    var telMask = ['(999) 9999-9999', '(999) 9 9999-9999']; // Define duas máscaras possíveis para telefone
    var tel = document.querySelector('input[attrname=telefone]'); // Seleciona o campo de entrada de telefone
    VMasker(tel).maskPattern(telMask[0]); // Aplica a máscara inicial para telefone
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 15), false); // Adiciona um evento de input para aplicar a máscara conforme o usuário digita

    // Configurações da máscara para CEP
    var cepMask = ['99999-9999', '99999-999']; // Define duas máscaras possíveis para CEP
    var cep = document.querySelector('input[attrname=cep]'); // Seleciona o campo de entrada de CEP
    VMasker(cep).maskPattern(cepMask[0]); // Aplica a máscara inicial para CEP
    cep.addEventListener('input', inputHandler.bind(undefined, cepMask, 8), false); // Adiciona um evento de input para aplicar a máscara conforme o usuário digita

});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------- CONSULTA EXTERNA CIDADE E ESTADO ---------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

$(function () {
    // Quando o valor do select de estado mudar
    $('#estado').change(function () {
        // Verifica se um estado foi selecionado
        if ($(this).val()) {
            // Esconde o select de cidade e mostra o indicador de carregamento
            $('#cidade').hide();
            $('.carregando').show();
            // Faz uma requisição AJAX para obter as cidades do estado selecionado
            $.getJSON('select_cidade.php?search=', {
                estado: $(this).val(),
                ajax: 'true'
            }, function (j) {
                // Monta as opções para o select de cidade
                var options = '<option value="" selected disabled>Escolha a Cidade</option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].id_mun + '" namespace="' + j[i].cep_mun + '">' + j[i].nome_mun + '</option>';
                }
                // Atualiza o select de cidade com as novas opções e esconde o indicador de carregamento
                $('#cidade').html(options).show();
                $('.carregando').hide();
            });
        } else {
            // Se nenhum estado foi selecionado, limpa o select de cidade e mostra uma opção padrão
            $('#cidade').html('<option value="">– Escolha Subcategoria –</option>');
        }
    });
});

// Aguarde até que o DOM esteja totalmente carregado
document.addEventListener("DOMContentLoaded", function () {
    // Quando o valor do select de estado mudar
    document.getElementById("estado").onchange = function () {
        // Limpa o valor do campo de CEP quando o estado é alterado
        document.querySelector("[name='cep']").value = '';
    }

    // Quando o valor do select de cidade mudar
    document.getElementById("cidade").onchange = function () {
        var select = document.getElementById("cidade");
        var selectedOption = select.options[select.selectedIndex];

        // Verifique se há uma opção selecionada e se ela não é undefined
        if (selectedOption) {
            var cep = selectedOption.getAttribute("namespace");
            // Define o valor do campo de CEP com o valor obtido do atributo "namespace"
            document.querySelector("[name='cep']").value = cep || ''; // Define para vazio se não houver atributo
        } else {
            // Se não houver uma opção selecionada, limpe o campo de CEP
            document.querySelector("[name='cep']").value = '';
        }
    }
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
                        text: 'Preencha os campos requeridos em todas as abas!'
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
    $('#cpf').on('input', function () {
        var cpfField = $(this);
        cpfField.removeClass('is-invalid');
        cpfField[0].setCustomValidity('');
    });
});

// #form-add-usuario - AÇÃO NO SUBMIT DO FORM #form-add-usuario
$(function () {
    $(document).on('submit', '#form-add-usuario', function (event) {

        event.preventDefault();

        var dados = {

            // Menu Geral
            nome: $('#nome').val(),
            cpf: $('#cpf').val(),
            email: $('#email').val(),
            telefone: $('#telefone').val(),
            tus: $('#tus').val(),

            // Menu Endereço
            endereco: $('#endereco').val(),
            bairro: $('#bairro').val(),
            complemento: $('#complemento').val(),
            numero: $('#numero').val(),
            cidade: $('#cidade').val(),
            cep: $('#cep').val(),

            btn_add: 1
        };

        $.post('controller/adicionar_novo_usuario_post.php', dados, function (retorna) {
            var cpfField = $('#cpf');
            // Processa a resposta da requisição
            switch (retorna.status) {
                case "sucesso":
                    // Exibe uma mensagem de sucesso usando a biblioteca SweetAlert
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
                case "verifica_cpf":
                    // Marcar o campo como inválido
                    cpfField.addClass('is-invalid');
                    cpfField[0].setCustomValidity('invalid');
                    cpfField.next('.invalid-feedback').show();

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
                        text: retorna.mensagem
                    });
                    break;
            }
        }, 'json');

    })
});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------- AÇÃO DE VOLTAR ---------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando o botão com id 'btn-voltar' for clicado
    $(document).on('click', '#btn-voltar', function () {

        // Em caso de sucesso, redireciona o usuário para a página 'adicionar_usuario'
        location.href = "adicionar_usuario";

    });
});