<?php

require_once 'conexao.php';

?>

<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <h6 id="ola" class="text-white fonte-texto-gestou">Olá,
        <?php
        $nomeusu = explode(' ', $nome_usuario_default)[0];
        $nomeusu = strtolower($nomeusu);
        $nomeusu = ucfirst($nomeusu);
        echo $nomeusu;

        ?>
    </h6>


    <ul class="navbar-nav ml-auto">
        <!-- <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li> -->

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                <?php

                //SELECT QUANTIDADE DE NOTIFICAÇÕES
                foreach (select_count_NOTIFICACOES($raiz_cnpj, $id_usu_default) as $contagem) {
                    $contagem = $contagem['contagem'];
                    if ($contagem <= 0) {
                        //SE FOR IGUAL A 0 NÃO EXIBE
                    } else {
                ?>
                        <span class="badge badge-danger badge-counter">
                            <?php echo $contagem; ?>
                        </span>
                <?php
                    }
                }

                ?>

            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    NOTIFICAÇÕES
                </h6>
                <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a> -->

                <?php
                //SELECT DE NOTIFICACOES
                foreach (select_NOTIFICACOES($raiz_cnpj, $id_usu_default) as $notificacoes) {
                    $tipo = $notificacoes['tipo'];
                    if ($notificacoes > 0) { ?>

                        <?php if ($tipo == 'H') { ?>
                            <a class="dropdown-item d-flex align-items-center" href="recibo_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>

                                    <?php } elseif ($tipo == 'I') { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="imposto_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-clock text-white"></i>

                                                <?php } elseif ($tipo == 'P') { ?>
                                                    <a class="dropdown-item d-flex align-items-center" href="espelho_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                                        <div class="mr-3">
                                                            <div class="icon-circle bg-success">
                                                                <i class="fas fa-file-alt text-white"></i>

                                                            <?php } elseif ($tipo == 'D') { ?>
                                                                <a class="dropdown-item d-flex align-items-center" href="recibo_diverso_item?vw=<?php echo $notificacoes['id_validador']; ?>">
                                                                    <div class="mr-3">
                                                                        <div class="icon-circle bg-success">
                                                                            <i class="fas fa-file text-white"></i>

                                                                        <?php } ?>

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

                                                            <?php
                                                        } else {
                                                            ?>
                                                                <a class="dropdown-item d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <!-- <div class="icon-circle bg-primary"> -->
                                                                        <img src="img/notification.png" height="30"></img>
                                                                        <!-- </div> -->
                                                                    </div>
                                                                    <div str>
                                                                        Sem novas notificações!
                                                                    </div>
                                                                </a>
                                                        <?php
                                                        }
                                                    }

                                                        ?>

                                                        <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a> -->
                                                        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
                                                            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>

                <?php

                //SELECT QUANTIDADE DE MENSAGENS
                foreach (select_count_MENSAGENS($id_usu_default) as $contagem_mensagens) {
                    $cont_mensagens = $contagem_mensagens['contagem'];
                    if ($cont_mensagens <= 0) {
                        //SE FOR IGUAL A 0 NÃO EXIBE
                    } else {
                ?>
                        <span class="badge badge-danger badge-counter">
                            <?php echo $cont_mensagens; ?>
                        </span>
                <?php
                    }
                }

                ?>

            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    MENSAGENS
                </h6>

                <?php
                //SELECT DE MENSAGENS
                foreach (select_MENSAGENS($id_usu_default) as $mensagens) {
                    $tipo = $mensagens['tipo'];
                    if ($mensagens > 0) { ?>

                        <?php if ($tipo == 'M') { ?>
                            <a class="dropdown-item d-flex align-items-center" href="mural_item?vw=<?php echo $mensagens['id_validador']; ?>">
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-window-maximize text-white"></i>

                                    <?php } elseif ($tipo == 'N') { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="notificacoes_item?vw=<?php echo $mensagens['id_validador']; ?>">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-danger">
                                                    <i class="fas fa-bell text-white"></i>

                                                <?php } elseif ($tipo == 'O') { ?>
                                                    <a class="dropdown-item d-flex align-items-center" href="ouvidoria_item?vw=<?php echo $mensagens['id_validador']; ?>">
                                                        <div class="mr-3">
                                                            <div class="icon-circle bg-danger">
                                                                <i class="fas fa-podcast text-white"></i>

                                                            <?php } ?>

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

                                                <?php
                                            } else {
                                                ?>
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
                                            <?php
                                            }
                                        }

                                            ?>

                                                </div>
        </li>
        <!-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Design Button
                            <div class="small float-right"><b>50%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Make Beautiful Transitions
                            <div class="small float-right"><b>30%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Create Pie Chart
                            <div class="small float-right"><b>75%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
            </div>
        </li> -->
        <div class="topbar-divider d-none d-sm-block"></div>
        <?php

        try {
            $id_usu = $_SESSION['id_usu_app'];
            foreach (selectGESUSU_FOTO($id_usu) as $linha) {
                $imagem = $linha['imagem'];
                $nome = $linha['nome'];
                $nome_empresa = $linha['nome_empresa'];
            } ?>


            <!-- Nav Item - Empresa Selection -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <span class="d-none d-lg-inline text-gray-100 small mr-2"><?php echo $nome; ?></span>

                    <div class="rounded-circle" style="background-color: #fff;">
                        <img class="img-profile rounded-circle" style="border: #FFF 1px solid;" src="../upload/cadastro/<?php echo $imagem; ?>">
                    </div>

                </a>

                <!-- Dropdown - Empresa Selection -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                    <a class="dropdown-item">
                        <i class="fas fa-building mr-2 text-gray-400"></i>
                        <?php echo $nome_empresa; ?>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="seus_dados" class="dropdown-item">
                        <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                        Seus Dados
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        <?php
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }

        ?>
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