<?php

require 'util.php';
require 'conexao.php';

?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
        <div class="sidebar-brand-icon">
            <img src="../img/logo_gestou_branco_amarelo.png" height="40"></img>
        </div>
        <div class="sidebar-brand-text mx-3">
            <div class="fonte-texto-gestou" style="font-size: 20px;">GESTOU</div><sup>Portal Admin</sup>
        </div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index">
            <i class="fas fa-home fa-1x"></i>
            <span>Principal</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <?php

    foreach (selectMENUS_USUARIO($id_usa_default, $id_emp_default) as $menu) {

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

                    foreach (selectITENS_MENUS_USUARIO($id_usa_default, $id_emp_default, $nivel) as $itens) {

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
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->