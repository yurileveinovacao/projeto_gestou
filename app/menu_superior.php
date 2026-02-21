<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">

        <!-- INÍCIO MENU SUPERIOR FUNCIONARIO ATIVO -->

        <?php if ($situac_default == 1) { ?>

            <!-- LI REFERENTE A NOTIFICAÇÕES -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>

                    <!-- SELECT QUANTIDADE DE NOTIFICAÇÕES -->
                    <?php foreach (select_count_NOTIFICACOES($raiz_cnpj, $id_usu_default) as $contagem) {

                        $contagem = $contagem['contagem'];

                        if (!empty($contagem)) { ?>

                            <span class="badge badge-danger badge-counter">
                                <?php echo $contagem; ?>
                            </span>
                    <?php }
                    } ?>

                </a>

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        NOTIFICAÇÕES
                    </h6>
                    <div style="max-height: 40vh; overflow-y: auto;">

                        <!-- SELECT DE NOTIFICACOES -->
                        <?php foreach (select_NOTIFICACOES($raiz_cnpj, $id_usu_default) as $notificacoes) {

                            $tipo = $notificacoes['tipo'];

                            if (!empty($notificacoes)) {

                                switch ($tipo) {

                                    case 'H': ?>
                                        <a class="dropdown-item d-flex align-items-center" href="holerite_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-donate text-white"></i>
                                                <?php break;

                                            case 'I': ?>
                                                    <a class="dropdown-item d-flex align-items-center" href="informe_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                                        <div class="mr-3">
                                                            <div class="icon-circle bg-warning">
                                                                <i class="fas fa-clock text-white"></i>
                                                            <?php break;

                                                        case 'P': ?>
                                                                <a class="dropdown-item d-flex align-items-center" href="espelho_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                                                    <div class="mr-3">
                                                                        <div class="icon-circle bg-success">
                                                                            <i class="fas fa-file-alt text-white"></i>
                                                                        <?php break;

                                                                    case 'D': ?>
                                                                            <a class="dropdown-item d-flex align-items-center" href="documentos_diversos_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                                                                <div class="mr-3">
                                                                                    <div class="icon-circle bg-success">
                                                                                        <i class="fas fa-file text-white"></i>
                                                                                <?php break;
                                                                        } ?>

                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="small text-gray-500">
                                                                                        <?php $data = new DateTime($notificacoes['datinc']);
                                                                                        echo $data->format('d/m/Y'); ?>
                                                                                    </div>
                                                                                    <?php echo $notificacoes['mensagem']; ?>
                                                                                </div>
                                                                            </a>

                                                                        <?php } else { ?>

                                                                            <a class="dropdown-item d-flex align-items-center">
                                                                                <div class="mr-3">
                                                                                    <img src="img/notification.png" height="30"></img>
                                                                                </div>
                                                                                <div str>
                                                                                    Sem novas notificações!
                                                                                </div>
                                                                            </a>
                                                                    <?php }
                                                                } ?>

                                                                        </div>
                                                                    </div>


            </li>

            <!-- LI REFERENTE A MENSAGENS -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>

                    <!-- SELECT QUANTIDADE DE MENSAGENS -->
                    <?php foreach (select_count_MENSAGENS($id_usu_default) as $contagem_mensagens) {

                        $cont_mensagens = $contagem_mensagens['contagem'];

                        if (!empty($cont_mensagens)) { ?>

                            <span class="badge badge-danger badge-counter">
                                <?php echo $cont_mensagens; ?>
                            </span>
                    <?php }
                    } ?>
                </a>

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        MENSAGENS
                    </h6>
                    <div style="max-height: 40vh; overflow-y: auto;">

                        <!-- SELECT DE MENSAGENS -->
                        <?php foreach (select_MENSAGENS($id_usu_default) as $mensagens) {

                            $tipo = $mensagens['tipo'];

                            if (!empty($mensagens)) {

                                switch ($tipo) {

                                    case 'M': ?>
                                        <a class="dropdown-item d-flex align-items-center" href="mural_avisos">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-danger">
                                                    <i class="fas fa-window-maximize text-white"></i>
                                                <?php break;

                                            case 'N': ?>
                                                    <a class="dropdown-item d-flex align-items-center" href="notificacoes">
                                                        <div class="mr-3">
                                                            <div class="icon-circle bg-danger">
                                                                <i class="fas fa-bell text-white"></i>
                                                            <?php break;

                                                        case 'O': ?>
                                                                <a class="dropdown-item d-flex align-items-center" href="ouvidoria_item?vw=<?php echo $mensagens['id_validador']; ?>">
                                                                    <div class="mr-3">
                                                                        <div class="icon-circle bg-danger">
                                                                            <i class="fas fa-podcast text-white"></i>
                                                                        <?php break;

                                                                    case 'S': ?>
                                                                            <a class="dropdown-item d-flex align-items-center" href="minhas_solicitacoes">
                                                                                <div class="mr-3">
                                                                                    <div class="icon-circle bg-danger">
                                                                                        <i class="fas fa-list-alt text-white"></i>
                                                                                    <?php break;

                                                                                case 'T': ?>
                                                                                        <a class="dropdown-item d-flex align-items-center" href="treinamentos_manuais">
                                                                                            <div class="mr-3">
                                                                                                <div class="icon-circle bg-danger">
                                                                                                    <i class="fas fa-book-reader text-white"></i>
                                                                                                <?php break;

                                                                                            case 'P': ?>
                                                                                                    <a class="dropdown-item d-flex align-items-center" href="empresa_politica_codconduta">
                                                                                                        <div class="mr-3">
                                                                                                            <div class="icon-circle bg-danger">
                                                                                                                <i class="fas fa-book text-white"></i>
                                                                                                        <?php break;
                                                                                                } ?>

                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <div class="small text-gray-500">
                                                                                                                <?php $data = new DateTime($mensagens['datinc']);
                                                                                                                echo $data->format('d/m/Y'); ?>
                                                                                                            </div>
                                                                                                            <?php echo $mensagens['mensagem']; ?>
                                                                                                        </div>

                                                                                                    </a>
                                                                                                <?php } else { ?>

                                                                                                    <a class="dropdown-item d-flex align-items-center">
                                                                                                        <div class="mr-3">
                                                                                                            <!-- <div class="icon-circle bg-primary"> -->
                                                                                                            <img src="img/notification.png" height="30"></img>
                                                                                                            <!-- </div> -->
                                                                                                        </div>
                                                                                                        <div str>
                                                                                                            Sem novas mensagens!
                                                                                                        </div>
                                                                                                    </a>
                                                                                            <?php }
                                                                                        } ?>

                                                                                                </div>

                                                                                            </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <?php try {

                $id_usu = $_SESSION['id_usu_app'];

                foreach (VW_APP_EMPACESS($id_usu) as $linha) {

                    $imagem = $linha['imagem'];
                    $nome = $linha['nome'];
                } ?>

                <!-- Nav Item - Empresa Selection -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-100 small"><?php echo $nome; ?></span>

                        <div class="rounded-circle" style="background-color: #fff;">
                            <img class="img-profile rounded-circle" src="../upload/empresa/<?php echo $imagem; ?>">
                        </div>

                    </a>

                    <!-- Dropdown - Empresa Selection -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                        <?php
                        foreach (VW_APP_EMPACESS($id_usu) as $row) {
                        ?>

                            <!-- <a class="dropdown-item" href="?alterar=<php echo $row['id_emp']; ?>"> -->
                            <a class="dropdown-item">
                                <i class="fas fa-building mr-2 text-gray-400"></i>
                                <?php echo $row['nome']; ?>
                            </a>
                            <!-- </a> -->

                        <?php
                        } ?>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Sair
                        </a>
                    </div>
                </li>

            <?php
            } catch (PDOException $erro) {
                echo $erro->getMessage();
            }

            ?>

            <!-- FIM MENU SUPERIOR FUNCIONARIO ATIVO -->

        <?php } else { ?>

            <!-- MENU SUPERIOR FUNCIONARIO BLOQUEADO -->

            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - Empresa Selection -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-100 small">GESTOU</span>

                    <div class="rounded-circle" style="background-color: #fff;">
                        <img class="img-profile rounded-circle" src="img/logo/logo_gestou_fundo_amarelo.png">
                    </div>

                </a>

                <!-- Dropdown - Empresa Selection -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                    <a class="dropdown-item">
                        <i class="fas fa-building mr-2 text-gray-400"></i>
                        GESTOU
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Sair
                    </a>
                </div>
            </li>

        <?php } ?>

        <!-- FIM MENU SUPERIOR FUNCIONARIO BLOQUEADO -->

    </ul>
</nav>
<!-- Topbar -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja realmente sair?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecione "Sair" abaixo se você estiver pronto para encerrar sua sessão
                atual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                <a href="sair"><button type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i>
                        Sair</button></a>

            </div>
        </div>
    </div>
</div>