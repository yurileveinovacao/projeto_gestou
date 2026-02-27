<?php

require 'util.php';
require_once __DIR__.'/../config/database.php';

$id_emp_default = $_SESSION['id_emp_default'];
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
        <div class="sidebar-brand-icon">
            <img src="https://www.gestou.com.br/img/logo_gestou.png" height="40"></img>
        </div>
        <div class="sidebar-brand-text mx-3"><img src="https://www.gestou.com.br/img/texto_gestou.png" height="15"></img><sup>Portal Master</sup></div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="https://www.gestou.com.br/master">
            <i class="fas fa-home fa-1x"></i>
            <span>Menu</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menus
    </div>

    <?php

    foreach (selectMENUS_master($id_mas_default) as $menu) {

        $descri = $menu["descri"];
        $icone = $menu["icone"];
        $link = $menu["link"];
        $target = $menu["target"];
        $nivel = $menu["nivel"];
        $ordem = $menu["ordem"];
        $estagio = $menu["estagio"];

    ?>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $target; ?>" aria-expanded="true" aria-controls="<?php echo $target; ?>">
                <i class="<?php echo $icone; ?>"></i>
                <span><?php echo $descri; ?></span>
            </a>
            <div id="<?php echo $target; ?>" class="collapse" aria-labelledby="headingEmpresa" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <?php

                    $nivel = $nivel . ".%";

                    foreach (selectITENS_MENUS_master($id_mas_default, $nivel) as $itens) {

                        $descri_item = $itens["descri"];
                        $link = $itens["link"];

                    ?>
                        <a class="collapse-item" href="<?php echo $link; ?>"><?php echo $descri_item; ?></a>

                    <?php

                    }

                    ?>

                </div>
            </div>
        </li>

    <?php

    }

    ?>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////   -->
    <!-- Nav Item - Duvidas Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDuvidas"
            aria-expanded="true" aria-controls="collapseDuvidas">
            <i class="fas fa-question"></i>
            <span>Dúvidas?</span>
        </a>
        <div id="collapseDuvidas" class="collapse" aria-labelledby="headingDuvidas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="minha_conta">Documentação</a>
                <a class="collapse-item" href="#">Ajuda</a>
            </div>
        </div>
    </li> -->
    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////   -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Outros
    </div> -->

    <!-- Nav Item - Dúvidas Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDúvidas"
            aria-expanded="true" aria-controls="collapseDúvidas">
            <i class="fas fa-question"></i>
            <span>Dúvidas?</span>
        </a>
        <div id="collapseDúvidas" class="collapse" aria-labelledby="headingDúvidas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
    <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span></a>
</li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
    <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div> -->

</ul>
<!-- End of Sidebar -->