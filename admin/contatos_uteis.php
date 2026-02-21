<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Contatos úteis</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
     wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
     This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
     dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="vendor/kartik-v/bootstrap-fileinput/js/fileinputpdf.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="js/sorttable.js"></script>

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<!-- DEFINE A COR DAS BORDAS DA TABLE, SE REMOVER SERÁ DEFINIDA COMO PRETO -->
<style>
    .table>:not(:last-child)>:last-child>* {

        border-bottom-color: #E3E6F0 !important;
    }
</style>

<body id="page-top">

    <!-- INICIO WRAPPER -->
    <div id="wrapper">

        <!-- LEFTBAR -->
        <?php include_once "menu_lateral.php"; ?>

        <!-- INICIO CONTENT WRAPPER -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- INICIO MAIN CONTENT -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                // Verifica se o usuario tem acesso a pagina
                include_once "pagina_restrita.php"; ?>


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!-- <h1 class="h3 mb-0 text-gray-800">Empresa</h1> -->
                    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contatos úteis</h6>
                    </div>
                    <div class="card-body">
                        <form class="mb-5">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                    <thead style="text-align: center;">

                                        <div class="col-sm-12 button-tabela">

                                            <a href="#" data-toggle="modal" data-target="#modal-incluir"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Incluir</button></a>

                                            <button type="button" id="btn-excluir" name="btn-excluir" disabled class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-trash-alt"></i> Excluir</button>

                                        </div>

                                        <tr>
                                            <th data-orderable="false" class="sorttable_nosort nao_click coluna-checkbox"><input id="checkTodos" type="checkbox" name="checkbox[]"></input></th>
                                            <th data-orderable="false">Nome</th>
                                            <th data-orderable="false" class="sorttable_nosort nao_click" width="15%">Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot style="text-align: center;">
                                        <tr>
                                            <th></th>
                                            <th>Nome</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>

                                    <tbody class="texto-table-body">
                                        <?php

                                        foreach (selectGESCTO_id_emp($id_emp_default) as $linha) {

                                            if ($linha != 0) {

                                        ?>
                                                <tr class="align-middle">

                                                    <?php if ($linha['situac'] == 0) { ?>

                                                        <td class="coluna-checkbox"><input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $id_cto = $linha['id_cto']; ?>"></input></td>
                                                    <?php } else { ?>

                                                        <td class="coluna-checkbox"><input type="checkbox" disabled></input></td>
                                                    <?php } ?>

                                                    <td><span class="m-0 text-primary tamanho-text"><?php echo $linha['nome']; ?></span></td>

                                                    <td class="content-xy-center">
                                                        <!-- INICIO SITUACAO -->
                                                        <div class="div-acoes">
                                                            <?php

                                                            if ($linha['situac'] == 1) {
                                                            ?>
                                                                <span class="text-success cursor-pointer btn-situac" contato="<?php echo $linha['id_cto']; ?>" situac-contato="1"><i class='bx bxs-toggle-right bx-lg content-xy-center' title="Ativo"></i></span>
                                                            <?php
                                                            }
                                                            if ($linha['situac'] == 0) {
                                                            ?>
                                                                <span class="text-danger cursor-pointer btn-situac" contato="<?php echo $linha['id_cto']; ?>" situac-contato="0"><i class='bx bxs-toggle-left bx-lg content-xy-center' title="Inativo"></i></span>
                                                            <?php
                                                            } ?>
                                                        </div>
                                                        <!-- INICIO EDITAR -->
                                                        <div class="div-acoes">
                                                            <button type="button" id="btn-editar" class="btn btn-primary btn-icones" id-cto="<?php echo $linha['id_cto']; ?>" title="Editar">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>


                                        <?php
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <!-- FIM PAGE CONTENT -->

        </div>
        <!-- FIM MAIN CONTENT -->

        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- --------------------------------------------------- INICIO MODAIS -------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

        <!-- Modal Incluir Contato -->
        <div class="modal fade" id="modal-incluir" style="padding-right: none !important;" tabindex="-1" role="dialog" aria-labelledby="Incluir" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Incluir">Incluir Contato</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="modal-form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-row mb-2">
                                    <div class="col-md-12">
                                        <label for="nome">Nome:</label>
                                        <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" required>
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col-md-12">
                                        <label for="descricao">Descrição:</label>
                                        <textarea class="form-control" style="text-transform:uppercase; resize:none; max-height: 200px" id="descricao" name="descricao" minlength="3" maxlength="200" required></textarea>
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col-md-4">
                                        <label for="telefone1">Telefone 1:</label>
                                        <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone1" name="telefone1" attrname="telefone1">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="telefone2">Telefone 2:</label>
                                        <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone2" name="telefone2" attrname="telefone2">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="telefone3">Telefone 3:</label>
                                        <input type="tel" class="form-control" style="text-transform:uppercase" id="telefone3" name="telefone3" attrname="telefone3">
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col-md-6">
                                        <label for="email">E-mail:</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="website">Website:</label>
                                        <input type="url" class="form-control" id="website" name="website" minlength="3">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma">OK</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- ------------------------------------------------------ FIM MODAIS -------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------- -->


        <!-- FOOTER -->
        <?php include_once "footer.php" ?>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    </div>
    <!-- FIM CONTENT WRAPPER -->

    </div>
    <!-- FIM WRAPPER -->

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- REQUISITOS MÁSCARAS JS -->
    <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

</body>

</html>

<script>
    $("#checkTodos").click(function() {
        $('input:checkbox:not(:disabled)').not(this).prop('checked', this.checked);
    });

    $("[name='checkbox[]']").click(function() {
        var cont = $(".checkbox:checked").length;
        $("#btn-excluir").prop("disabled", cont ? false : true);
    });

    // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
    $("input:checkbox").click(function() {
        var cont = $(".checkbox:not(:disabled):checked").length;
        var cont_total = $(".checkbox:not(:disabled)").length;
        var check_todos = cont == cont_total;
        $("#checkTodos").prop("checked", check_todos ? true : false);
    });

    $(document).ready(function() {
        $('#modal-incluir').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
    });

    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA TEL
    var tel1Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
    var tel1 = document.querySelector('input[attrname=telefone1]');
    VMasker(tel1).maskPattern(tel1Mask[0]);
    tel1.addEventListener('input', inputHandler.bind(undefined, tel1Mask, 15), false);

    // MÁSCARA TEL
    var tel2Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
    var tel2 = document.querySelector('input[attrname=telefone2]');
    VMasker(tel2).maskPattern(tel2Mask[0]);
    tel2.addEventListener('input', inputHandler.bind(undefined, tel2Mask, 15), false);


    // MÁSCARA TEL
    var tel3Mask = ['(999) 9999-9999', '(999) 9 9999-9999'];
    var tel3 = document.querySelector('input[attrname=telefone3]');
    VMasker(tel3).maskPattern(tel3Mask[0]);
    tel3.addEventListener('input', inputHandler.bind(undefined, tel3Mask, 15), false);
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    // QUANDO O FORMULÁRIO É SUBMETIDO
    $(function() {
        $("#modal-form").submit(function(event) {
            // Previne o comportamento padrão do formulário (recarregar a página)
            event.preventDefault();

            // Se o usuario realmente quiser salvar o contato
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja cadastrar esse registro?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, cadastrar!',
                cancelButtonText: 'Não!'
            }).then((result) => {

                if (result.isConfirmed) {

                    // Valor que define que o formulário foi submetido
                    var btn_submit = 1;

                    // Obtém os valores do formulário
                    var dados_form = {
                        // Valor do formulario
                        nome_update: $('#nome').val(),
                        descricao_update: $('#descricao').val(),
                        tel1_update: $('#telefone1').val(),
                        tel2_update: $('#telefone2').val(),
                        tel3_update: $('#telefone3').val(),
                        email_update: $('#email').val(),
                        website_update: $('#website').val(),

                        // Valor que valida o envio do formulário
                        btn_submit: btn_submit
                    };

                    $.post('controller/contatos_uteis_post.php', dados_form, function(retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        if (retorno == 1) {

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Informação incluida com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })

                            // Se o retorno for igual a 0, os dados não foram preenchidos corretamente
                        } else if (retorno == 0) {

                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atenção',
                                text: 'Preencha todos os campos para concluir a ação!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            })

                            // Caso não for 0/1 houve erro no try e retorna um SweetAlert com o erro exibido pelo catch
                        } else {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Favor entrar em contato com o suporte.',
                                html: retorno,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            })
                        }
                    });

                }
            });
        });
    });

    // QUANDO A SITUAÇÃO É ALTERADA (ATIVO/INATIVO)
    $(function() {
        $(document).on('click', '.btn-situac', function() {

            // Valores recebidos no click
            var id_cto = $(this).attr('contato');
            var situac_cto = $(this).attr('situac-contato');

            // Obtém os valores do click
            if (id_cto !== '') {

                dados = {
                    id_cto: id_cto,
                    situac_cto: situac_cto
                };

                // Envia os dados do click para o arquivo PHP usando o método POST do jQuery
                $.post('controller/contatos_uteis_post.php', dados, function(retorno) {

                    // Se o retorno for igual a 1, os dados foram atualizados com sucesso
                    if (retorno == 1) {

                        location.reload();

                        // Caso não for houve erro no try e retorna um alerta com o erro exibido pelo catch
                    } else {

                        alert('erro');
                    }
                });
            }
        });
    });

    // QUANDO O BOTÃO EXCLUIR É CLICADO
    $(function() {
        $(document).on('click', '#btn-excluir', function() {

            // Se o usuario realmente quiser excluir o contato
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Tem certeza que deseja excluir esse registro?',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não!'
            }).then((result) => {

                if (result.isConfirmed) {

                    var btn_exc = 1;
                    var ids = [];

                    // Recebe os ids dos contatos marcados
                    $('.checkbox:not(:disabled):checked').each(function() {
                        ids.push($(this).val());
                    });

                    dados_exc = {

                        ids: ids,

                        btn_exc: btn_exc
                    };

                    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
                    $.post('controller/contatos_uteis_post.php', dados_exc, function(retorno) {

                        // Se o retorno for igual a 1, os dados foram inseridos com sucesso
                        if (retorno == 1) {

                            // Exibe uma mensagem de sucesso e recarrega a pagina
                            Swal.fire({
                                icon: 'success',
                                title: 'Contato(s) excluido(s) com sucesso!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                            // Caso o contrario, nenhum contato foi selecionado
                        } else {

                            // Exibe uma mensagem de falha
                            Swal.fire({
                                icon: 'warning',
                                title: 'Nenhum contato inativo selecionado!',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.close();
                                }
                            })
                        }

                    });
                }
            });
        });
    });

    // CLICK NO BOTÃO EDITAR
    $(function() {
        $(document).on('click', '#btn-editar', function() {

            var editar_id_cto = $(this).attr("id-cto");

            //verificar se há valor nas variaveis
            if (editar_id_cto !== '') {

                var dados = {
                    editar_id_cto: editar_id_cto
                };

                $.post('controller/contatos_uteis_post.php', dados, function(retorno) {

                    location.href = "alterar_contatos_uteis";
                });
            }
        });
    });
</script>