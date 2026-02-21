<?php

require '../util.php';
require '../conexao.php';

$id_emp_default = $_SESSION['id_emp_default'];
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index">
        <div class="sidebar-brand-icon">
            <img src="../../img/logo_gestou.png" height="40"></img>
        </div>
        <div class="sidebar-brand-text mx-3"><img src="../../img/texto_gestou.png" height="15"></img><sup>Portal Master</sup></div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="../index">
            <i class="fas fa-home fa-1x"></i>
            <span>Menu</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menus
    </div>

    <!-- Nav Item - Servicos Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="servicos">
            <i class="fas fa-cog"></i>
            <span>Serviços</span></a>
    </li>


    <!-- Nav Item - Tabelas Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTabelas" aria-expanded="true" aria-controls="collapseTabelas">
            <i class="fas fa-table"></i>
            <span>Tabelas</span>
        </a>
        <div id="collapseTabelas" class="collapse" aria-labelledby="headingTabelas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="../tabela_empresas">Empresas</a>
                <a class="collapse-item" href="../tabela_usuarios">Usuários</a>
                <a class="collapse-item" href="../tabela_permissao">Permissão de Tela</a>
                <a class="collapse-item" href="../tabela_menus">Menus</a>
                <a class="collapse-item" href="../tabela_documentacao">Documentação</a>
                <a class="collapse-item" href="../aniversario_tabela">Tabela Aniversário</a>
                <a class="collapse-item" href="../chamado">Chamados</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Cadastro Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCadastro" aria-expanded="true" aria-controls="collapseCadastro">
            <i class="fas fa-id-card"></i>
            <span>Cadastro</span>
        </a>
        <div id="collapseCadastro" class="collapse" aria-labelledby="headingCadastro" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="../tabela_menus">Menus</a>
                <a class="collapse-item" href="../tabela_documentacao">Documentação</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Utilidades Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilidades" aria-expanded="true" aria-controls="collapseUtilidades">
            <i class="fas fa-info-circle"></i>
            <span>Utilidades</span>
        </a>
        <div id="collapseUtilidades" class="collapse" aria-labelledby="headingUtilidades" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Treinamentos e Manuais</a>
                <a class="collapse-item" href="contatos_uteis">Contatos Úteis</a>
                <a class="collapse-item" href="log_acesso">Log Acesso Funcionários</a>

            </div>
        </div>
    </li> -->

    <!-- Nav Item - Mensagens Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMensagens" aria-expanded="true" aria-controls="collapseMensagens">
            <i class="fas fa-envelope"></i>
            <span>Mensagens</span>
        </a>
        <div id="collapseMensagens" class="collapse" aria-labelledby="headingMensagens" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Notificações</a>
                <a class="collapse-item" href="#">Mural de Avisos</a>
            </div>
        </div>
    </li> -->

    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////   -->
    <!-- Nav Item - Financeiro Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinanceiro" aria-expanded="true" aria-controls="collapseFinanceiro">
            <i class="fas fa-dollar-sign"></i>
            <span>Financeiro</span>
        </a>
        <div id="collapseFinanceiro" class="collapse" aria-labelledby="headingFinanceiro" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="minha_conta">Minha Conta</a>
                <a class="collapse-item" href="#">Meus Pagamentos</a>
            </div>
        </div>
    </li> -->
    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////   -->

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