<?php

require_once __DIR__.'/../config/database.php';

?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <!-- <form
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <!-- <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a> -->
        <!-- Dropdown - Messages -->
        <!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li> -->

        <!-- Nav Item - Alerts -->
        <!-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

            </a> -->
        <!-- Dropdown - Alerts -->
        <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                Alerts Center
            </h6>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                </div>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-donate text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                </div>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                </div>
            </a>
            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        </div> -->
        <!-- </li> -->

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>

                <?php

                //SELECT QUANTIDADE DE MENSAGENS
                foreach (select_count_MENSAGENS_ADMIN($id_usa_default, $id_emp_default) as $contagem_mensagens) {
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
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" style="overflow-x: hidden;overflow-y: auto;height: auto !important;max-height: 750%;" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    MENSAGENS
                </h6>

                <?php
                //SELECT DE MENSAGENS
                foreach (select_MENSAGENS_ADMIN($id_usa_default, $id_emp_default) as $mensagens) {
                    $tipo = $mensagens['tipo'];
                    if ($mensagens > 0) { ?>

                        <?php if ($tipo == 'S') { ?>
                            <a class="dropdown-item d-flex align-items-center" href="solicitacoes">
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-envelope text-white"></i>

                                    <?php } elseif ($tipo == 'O') { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="feedback_sugestoes">
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
                                                <img src="../app/img/notification.png" height="30"></img>
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

        <div class="topbar-divider d-none d-sm-block"></div>


        <?php

        try {
            $id_usa = $_SESSION['id_usa'];

            // $conn = pg_connect($servername, $username, $password, $database);
            $sql = 'SELECT nomefantasia as nome, id_emp,imagem from public."VW_ADMIN_EMPACESS" where id_emp_default=id_emp and id_usa=' . $id_usa . '';
            $res = pg_exec($conn, $sql);
            $linha = pg_fetch_assoc($res);

            $_SESSION['id_emp_default'] = $linha['id_emp'];

            $imagem = $linha['imagem']; ?>

            <!-- Nav Item - Empresa Selection -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $linha['nome']; ?></span>

                    <?php if (empty($imagem)) { ?>
                        <img class="img-profile rounded-circle" style="background-color: #fff;border: 1px solid #dddfeb;" src="../upload/empresa/avatar_empresa_default.png">
                    <?php } else { ?>
                        <img class="img-profile rounded-circle" style="background-color: #fff;border: 1px solid #dddfeb;" src="../upload/empresa/<?php echo $imagem; ?>">
                    <?php } ?>

                </a>

                <!-- Dropdown - Empresa Selection -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                    <div style="max-height: 50vh; overflow-y: auto;">

                        <?php

                        $sql = 'SELECT nomefantasia as empresa2, id_emp as id2 from public."VW_ADMIN_EMPACESS" where id_usa=' . $id_usa . ' ORDER BY id_emp_grupo,cnpj,nomefantasia asc';
                        $res = pg_exec($conn, $sql);

                        while ($row = pg_fetch_assoc($res)) {

                        ?>

                            <?php

                            if ($id_emp_default == $row["id2"]) {

                            ?>

                                <a class="dropdown-item bg-primary-lighter font-weight-bold" href="?alterar=<?php echo $row['id2']; ?>">
                                    <i class="fas fa-building mr-2 text-primary"></i>
                                    <?php echo $row['empresa2']; ?>
                                </a>

                            <?php

                            } else {

                            ?>

                                <a class="dropdown-item" href="?alterar=<?php echo $row['id2']; ?>">
                                    <i class="fas fa-building mr-2 text-gray-400"></i>
                                    <?php echo $row['empresa2']; ?>
                                </a>

                            <?php

                            }

                            ?>

                        <?php

                        }

                        ?>
                    </div>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>


            <?php
            if (isset($_REQUEST['alterar'])) {
                try {
                    require_once __DIR__.'/../config/database.php';
                    $id_emp2 = $_REQUEST['alterar'];
                    $_SESSION['id_emp_default'] = $id_emp2;

                    $query = 'UPDATE public."GESUSA"  SET id_emp_acess =  ' . $id_emp2 . ' WHERE id_usa= ' . $id_usa;

                    pg_query($conn, $query)
                        or die('Encountered an error when executing given sql statement: ' . pg_last_error() . '<br/>');

                    echo "<script language=javascript>
                        alert('Empresa alterada com sucesso!');
                        window.location.href = 'https://www.gestou.com.br/admin/index';
                        </script>";
                } catch (PDOException $erro) {
                    echo $erro->getMessage();
                }
            } ?>


        <?php
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }

        ?>


    </ul>

</nav>
<!-- End of Topbar -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px !important;" role="document">
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
                <a href="sair.php"><button type="button" name="btn-submit" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Sair</button></a>

            </div>
        </div>
    </div>
</div>