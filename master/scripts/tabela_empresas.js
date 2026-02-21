/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------- AÇÕES NO CHECKBOX ----------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// #todos_check - CLIQUE NO CHECKBOX GERAL
// Este trecho de código lida com o clique no checkbox geral, que marca ou desmarca todos os checkboxes individuais.
$(function () {
    $(document).on('click', '#todos_check', function () {

        var checked = $(this).prop('checked');

        // Seleciona todos os checkboxes que não estão desabilitados e define seu estado de marcação conforme o checkbox geral.
        $('input:checkbox').not(':disabled').prop('checked', checked);
    });
});

// Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
// Este trecho de código verifica se todos os checkboxes individuais estão marcados e marca o checkbox geral, ou o desmarca se pelo menos um checkbox individual estiver desmarcado.
$(function () {
    $(document).on('click', 'input:checkbox', function () {

        // Conta quantos checkboxes individuais estão marcados e quantos existem no total.
        var cont = $(".checkbox_main:not(:disabled):checked").length;
        var cont_total = $(".checkbox_main:not(:disabled)").length;
        // Verifica se todos os checkboxes individuais estão marcados.
        var check_todos = cont == cont_total;

        // Define o estado do checkbox geral conforme a verificação anterior.
        $("#todos_check").prop("checked", check_todos);
    });
});

// Habilita o botão excluir se tiver um checkbox marcado
// Este trecho de código habilita o botão de exclusão se pelo menos um checkbox individual estiver marcado.
$(function () {
    // Adiciona um manipulador de evento de clique para todos os checkboxes no documento
    $(document).on('click', 'input:checkbox', function () {

        // Conta quantos checkboxes individuais com a classe 'checkbox_main' estão marcados e não desabilitados
        var cont = $(".checkbox_main:not(:disabled):checked").length;

        // Se exatamente um checkbox estiver marcado, habilita os botões 'btn-grupo' e 'btn-filial'
        // Caso contrário, desabilita esses botões
        $("#btn-grupo").prop("disabled", cont == 1 ? false : true);
        $("#btn-filial").prop("disabled", cont == 1 ? false : true);
    });
});

/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/** -----------------------------------------------------------------------  ----------------------------------------------------------------------------------------------------- */
/** ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

// Quando o documento HTML estiver totalmente carregado, executa esta função
$(document).ready(function () {
    // Define uma função para ser acionada quando o botão com id 'btn-edit' for clicado
    $(document).on('click', '#btn-edit', function () {
        // Encontra a linha pai do botão clicado
        var row = $(this).closest('tr');

        // Obtém o token (ID da empresa) da linha
        var token = row.data("token");

        // Verifica se o token é válido
        if (token !== undefined && token !== '') {
            // Define os dados a serem enviados via POST
            var dados = {
                token: token,
                btn_edit: 1
            };
            // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
            $.post('controller/tabela_empresas_post.php', dados, function (retorna) {
                // Manipula a resposta do servidor
                switch (retorna.status) {
                    // Se a resposta for "sucesso"
                    case "sucesso":
                        // Redireciona para a página de edição da empresa
                        window.location.href = "alterar_empresa.php";
                        break;
                        // Se a resposta for diferente de "sucesso"
                    default:
                        // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            html: 'Ocorreu um erro ao editar a empresa!',
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
    });
});

// Realiza o POST do alterar situac no clique do botão situac
$(document).ready(function () {
    // Quando o documento estiver pronto, define uma função para o evento de clique no botão com id 'btn-situac'
    $(document).on('click', '#btn-situac', function () {

        // Encontre a linha pai do botão clicado
        var row = $(this).closest('tr');

        // Obtenha o ID da empresa da linha
        var token = row.data("token");

        // Valor da situac
        var situac = $(this).data("situac");
        situac_status = situac ? 0 : 1;

        // Verifica se o token é válido
        if (token !== undefined && token !== '') {
            // Define os dados a serem enviados via POST
            var dados = {
                token: token,
                situac_status: situac_status,
                btn_situac: 1
            };
            // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
            $.post('controller/tabela_empresas_post.php', dados, function (retorna) {
                // Manipula a resposta do servidor
                switch (retorna.status) {
                    // Se a resposta for "sucesso"
                    case "sucesso":
                        // Redireciona para a mesma página alterando a situac
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            html: retorna.mensagem,
                            allowOutsideClick: false
                        }).then((result) => {
                            // Recarrega a página quando o usuário confirmar o sucesso
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        break;
                        // Se a resposta for diferente de "sucesso"
                    default:
                        // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            html: retorna.mensagem,
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

    });
});

// Realiza o POST da exclusão no clique do botão grupo
$(document).ready(function () {
    // Quando o documento estiver pronto, define uma função para o evento de clique no botão com id 'btn-grupo'
    $(document).on('click', '#btn-grupo', function () {

        var token = $('.checkbox_main:checked').not(':disabled').closest('tr').map(function () {
            return $(this).data('token');
        }).get();

        console.log(JSON.stringify(token));

        // Verifica se o token é válido
        if (token !== undefined && token !== '') {

            // Utilizando switch para verificar a quantidade de token selecionados
            switch (token.length) {
                case 0:
                    // Se nenhum token estiver selecionado, exibe uma mensagem informando isso
                    Swal.fire({
                        icon: 'info',
                        title: 'Nenhum token selecionado',
                        html: 'Por favor, selecione uma empresa para adicionar a grupo.',
                    });
                    break;
                case 1:
                    // Se apenas um token estiver selecionado, continua com a adição de grupo
                    // Define os dados a serem enviados via POST
                    var dados = {
                        token: token,
                        btn_grupo: 1
                    };

                    // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
                    $.post('controller/tabela_empresas_post.php', dados, function (retorna) {
                        // Manipula a resposta do servidor
                        switch (retorna.status) {
                            // Se a resposta for "sucesso"
                            case "sucesso":

                                window.location.href = "adicionar_grupo.php";

                                break;

                            default:
                                // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    html: retorna.mensagem,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    // Recarrega a página quando o usuário confirmar o erro
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                                break;

                        }
                    }, 'json');

                    break;
                default:
                    // Se mais de um token estiver selecionado, exibe um SweetAlert2 informando o usuário
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: 'Você só pode adicionar uma grupo por empresa por vez.',
                    });
            }

        }

    });
});

// Realiza o POST da exclusão no clique do botão filial
$(document).ready(function () {
    // Quando o documento estiver pronto, define uma função para o evento de clique no botão com id 'btn-filial'
    $(document).on('click', '#btn-filial', function () {

        var token = $('.checkbox_main:checked').not(':disabled').closest('tr').map(function () {
            return $(this).data('token');
        }).get();

        console.log(JSON.stringify(token));

        // Verifica se o token é válido
        if (token !== undefined && token !== '') {

            // Utilizando switch para verificar a quantidade de token selecionados
            switch (token.length) {
                case 0:
                    // Se nenhum token estiver selecionado, exibe uma mensagem informando isso
                    Swal.fire({
                        icon: 'info',
                        title: 'Nenhum token selecionado',
                        html: 'Por favor, selecione uma empresa para adicionar a filial.',
                    });
                    break;
                case 1:
                    // Se apenas um token estiver selecionado, continua com a adição de filial
                    // Define os dados a serem enviados via POST
                    var dados = {
                        token: token,
                        btn_filial: 1
                    };

                    // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
                    $.post('controller/tabela_empresas_post.php', dados, function (retorna) {
                        // Manipula a resposta do servidor
                        switch (retorna.status) {
                            // Se a resposta for "sucesso"
                            case "sucesso":

                                window.location.href = "adicionar_filial.php";

                                break;

                            default:
                                // Exibe uma mensagem de erro usando a biblioteca SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    html: retorna.mensagem,
                                    allowOutsideClick: false
                                }).then((result) => {
                                    // Recarrega a página quando o usuário confirmar o erro
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                                break;

                        }
                    }, 'json');

                    break;
                default:
                    // Se mais de um token estiver selecionado, exibe um SweetAlert2 informando o usuário
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: 'Você só pode adicionar uma filial por empresa por vez.',
                    });
            }

        }

    });
});


// // Realiza o POST da exclusão no clique do botão excluir
// $(document).ready(function () {
//     // Quando o documento estiver pronto, define uma função para o evento de clique no botão com id 'btn-excluir'
//     $(document).on('click', '#btn-excluir', function () {

//         var token = $('.checkbox_main:checked').not(':disabled').closest('tr').map(function () {
//             return $(this).data('token');
//         }).get();

//         // console.log(JSON.stringify(token));

//         // Verifica se o token é válido
//         if (token !== undefined && token !== '') {
//             // Define os dados a serem enviados via POST
//             var dados = {
//                 token: token,
//                 btn_excluir: 1
//             };
//             // Envia uma requisição POST para o arquivo PHP especificado, com os dados definidos
//             $.post('controller/tabela_empresas_post.php', dados, function (retorna) {
//                 // Manipula a resposta do servidor
//                 switch (retorna.status) {
//                     // Se a resposta for "sucesso"
//                     case "sucesso":
//                         // Redireciona para a mesma página alterando a situac
//                         Swal.fire({
//                             icon: 'success',
//                             title: 'Sucesso',
//                             html: retorna.mensagem,
//                             allowOutsideClick: false
//                         }).then((result) => {
//                             // Recarrega a página quando o usuário confirmar o sucesso
//                             if (result.isConfirmed) {
//                                 window.location.reload();
//                             }
//                         });
//                         break;
//                         // Se a resposta for diferente de "sucesso"
//                     default:
//                         // Exibe uma mensagem de erro usando a biblioteca SweetAlert
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Erro',
//                             html: 'Ocorreu um erro ao excluir a empresa!',
//                             allowOutsideClick: false
//                         }).then((result) => {
//                             // Recarrega a página quando o usuário confirmar o erro
//                             if (result.isConfirmed) {
//                                 window.location.reload();
//                             }
//                         });
//                         break;
//                 }
//             }, 'json'); // Especifica o tipo de dados esperados na resposta do servidor
//         }

//     });
// });