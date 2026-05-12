<?php

require 'restrito.php';
require_once "iuds_pdo.php";
require_once "util.php";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GESTOU PORTAL - Templates de Documentos</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="js/sorttable.js"></script>

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>
</head>

<style>
    .table>:not(:last-child)>:last-child>* { border-bottom-color: #E3E6F0 !important; }
    #tabela-colaboradores th, #tabela-colaboradores td { padding: 6px 10px; font-size: 14px; }
    #tabela-colaboradores tbody { display: block; max-height: 380px; overflow-y: auto; }
    #tabela-colaboradores thead, #tabela-colaboradores tbody tr { display: table; width: 100%; table-layout: fixed; }
</style>

<body id="page-top">

    <div id="wrapper">

        <?php include_once "menu_lateral.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php
                include_once "barra_superior.php";
                include_once "pagina_restrita.php";
                ?>

                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Templates de Documentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                <thead style="text-align: center;">
                                    <div class="col-sm-12 button-tabela">
                                        <a href="templates_documentos_editar"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus-circle"></i> Novo Template</button></a>
                                    </div>

                                    <tr>
                                        <th data-orderable="false">Nome interno</th>
                                        <th data-orderable="false">Título do documento</th>
                                        <th data-orderable="false">Última edição</th>
                                        <th data-orderable="false" class="sorttable_nosort nao_click" width="22%">Ações</th>
                                    </tr>
                                </thead>

                                <tbody class="texto-table-body">
                                    <?php
                                    foreach (selectGESDOCTPL_lista($id_emp_default) as $linha) {
                                        if ($linha !== 0 && is_array($linha)) {
                                            $ultima_edicao = !empty($linha['datatu']) ? $linha['datatu'] : $linha['datinc'];
                                    ?>
                                            <tr class="align-middle">
                                                <td><span class="m-0 text-primary tamanho-text"><?php echo htmlspecialchars($linha['nome']); ?></span></td>
                                                <td><span class="m-0 tamanho-text"><?php echo htmlspecialchars($linha['titulo_documento']); ?></span></td>
                                                <td><span class="m-0 tamanho-text"><?php echo date('d/m/Y H:i', strtotime($ultima_edicao)); ?></span></td>
                                                <td class="content-xy-center">

                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-success btn-icones btn-enviar" id-tpl="<?php echo (int)$linha['id_tpl']; ?>" titulo-tpl="<?php echo htmlspecialchars($linha['titulo_documento'], ENT_QUOTES); ?>" title="Enviar">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </div>

                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-primary btn-icones btn-editar" id-tpl="<?php echo (int)$linha['id_tpl']; ?>" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    </div>

                                                    <div class="div-acoes">
                                                        <button type="button" class="btn btn-danger btn-icones btn-excluir-tpl" id-tpl="<?php echo (int)$linha['id_tpl']; ?>" title="Excluir">
                                                            <i class="fas fa-trash-alt"></i>
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
                    </div>
                </div>

            </div>

        </div>

        <!-- Modal Enviar Template -->
        <div class="modal fade" id="modal-enviar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enviar template: <span id="modal-titulo-tpl"></span></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="envio-id-tpl">

                        <div class="form-row mb-3">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="filtro-colaboradores" placeholder="🔍 Buscar por nome, CPF, cargo ou setor...">
                            </div>
                        </div>

                        <table id="tabela-colaboradores" class="table table-bordered table-hover">
                            <thead style="text-align: center;">
                                <tr>
                                    <th width="6%"><input type="checkbox" id="check-todos-colab"></th>
                                    <th>Nome</th>
                                    <th width="18%">CPF</th>
                                    <th width="18%">Cargo</th>
                                    <th width="18%">Setor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach (selectGESUSU_ativos_envio($id_emp_default) as $colab) {
                                    if ($colab !== 0 && is_array($colab)) {
                                ?>
                                        <tr>
                                            <td style="text-align: center;"><input type="checkbox" class="check-colab" value="<?php echo (int)$colab['id_usu']; ?>"></td>
                                            <td><?php echo htmlspecialchars($colab['nome']); ?></td>
                                            <td><?php echo htmlspecialchars($colab['cpf']); ?></td>
                                            <td><?php echo htmlspecialchars($colab['funcao']); ?></td>
                                            <td><?php echo htmlspecialchars($colab['depto_nome']); ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="mt-2"><small class="text-muted"><span id="contador-selecionados">0</span> colaborador(es) selecionado(s) — limite por envio: 100</small></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmar-envio" class="btn btn-organograma btn-icon-split-organograma" disabled><i class="fas fa-paper-plane"></i> Enviar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once "footer.php"; ?>

        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>
</html>

<script>
    // EDITAR — envia id_tpl pra controller e abre a tela de edição
    $(document).on('click', '.btn-editar', function() {
        var id_tpl = $(this).attr('id-tpl');
        $.post('controller/templates_documentos_post.php', { editar_id_tpl: id_tpl }, function() {
            location.href = "templates_documentos_editar";
        });
    });

    // EXCLUIR — confirma e dispara soft delete
    $(document).on('click', '.btn-excluir-tpl', function() {
        var id_tpl = $(this).attr('id-tpl');
        Swal.fire({
            icon: 'warning',
            title: 'Atenção!',
            text: 'Deseja realmente excluir este template?',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Não!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('controller/templates_documentos_post.php', { btn_delete: 1, id_tpl: id_tpl }, function(retorno) {
                    if (retorno == 1) {
                        Swal.fire({ icon: 'success', title: 'Template excluído!', allowOutsideClick: false }).then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro ao excluir', html: retorno });
                    }
                });
            }
        });
    });

    // ENVIAR — abre modal
    $(document).on('click', '.btn-enviar', function() {
        var id_tpl = $(this).attr('id-tpl');
        var titulo = $(this).attr('titulo-tpl');
        $('#envio-id-tpl').val(id_tpl);
        $('#modal-titulo-tpl').text(titulo);
        $('#check-todos-colab').prop('checked', false);
        $('.check-colab').prop('checked', false);
        $('#filtro-colaboradores').val('');
        $('#tabela-colaboradores tbody tr').show();
        atualizarContador();
        $('#modal-enviar').modal('show');
    });

    // FILTRO de colaboradores
    $('#filtro-colaboradores').on('input', function() {
        var q = $(this).val().toLowerCase();
        $('#tabela-colaboradores tbody tr').each(function() {
            var txt = $(this).text().toLowerCase();
            $(this).toggle(txt.indexOf(q) > -1);
        });
    });

    // CHECK TODOS (apenas os visíveis após filtro)
    $('#check-todos-colab').on('change', function() {
        var marcar = this.checked;
        $('#tabela-colaboradores tbody tr:visible .check-colab').prop('checked', marcar);
        atualizarContador();
    });

    $(document).on('change', '.check-colab', atualizarContador);

    function atualizarContador() {
        var n = $('.check-colab:checked').length;
        $('#contador-selecionados').text(n);
        $('#btn-confirmar-envio').prop('disabled', n === 0 || n > 100);
    }

    // CONFIRMAR ENVIO
    $('#btn-confirmar-envio').on('click', function() {
        var id_tpl = $('#envio-id-tpl').val();
        var ids = $('.check-colab:checked').map(function() { return $(this).val(); }).get();

        if (ids.length === 0) return;
        if (ids.length > 100) {
            Swal.fire({ icon: 'warning', title: 'Atenção', text: 'Máximo 100 colaboradores por envio.' });
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Confirmar envio?',
            text: 'O template será enviado para ' + ids.length + ' colaborador(es).',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Sim, enviar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;

            Swal.fire({ title: 'Enviando...', html: 'Gerando PDFs e disparando emails.', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.post('controller/templates_documentos_enviar_post.php', { btn_enviar: 1, id_tpl: id_tpl, ids_usu: ids }, function(retorno) {
                try {
                    var r = typeof retorno === 'string' ? JSON.parse(retorno) : retorno;
                    if (r && r.ok) {
                        Swal.fire({ icon: 'success', title: 'Enviado!', text: r.enviados + ' documento(s) gerado(s).' }).then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro', html: r && r.erro ? r.erro : 'Falha no envio.' });
                    }
                } catch (e) {
                    Swal.fire({ icon: 'error', title: 'Erro inesperado', html: retorno });
                }
            }).fail(function(xhr) {
                Swal.fire({ icon: 'error', title: 'Erro de comunicação', text: 'Status ' + xhr.status });
            });
        });
    });
</script>
