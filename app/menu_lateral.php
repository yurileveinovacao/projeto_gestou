<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
    <div class="sidebar-brand-icon">
      <img src="img/logo/logo_gestou_branco_amarelo.png">
    </div>
    <div class="sidebar-brand-text mx-3"><img src="img/logo/texto_gestou.png" height="20"></div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item active">
    <a class="nav-link" href="index">
      <i class="fas fa-home -alt"></i>
      <span>Principal</span></a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Menus
  </div>

  <!-- MENU FUNCIONARIO ATIVO -->
  <?php if ($situac_default == 1) { ?>

    <li class="nav-item">
      <a class="nav-link" href="empresa">
        <i class="fas fa-building"></i>
        <span>Empresa</span>
      </a>
      <!-- <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Bootstrap UI</h6>
            <a class="collapse-item" href="alerts.html">Alerts</a>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="dropdowns.html">Dropdowns</a>
            <a class="collapse-item" href="modals.html">Modals</a>
            <a class="collapse-item" href="popovers.html">Popovers</a>
            <a class="collapse-item" href="progress-bar.html">Progress Bars</a>
          </div>
        </div> -->
    </li>
    <li class="nav-item">
      <a class="nav-link" href="documentos">
        <i class="fas fa-hand-holding-usd"></i>
        <span>Meus Documentos</span>
      </a>
      <!-- <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="form_basics.html">Form Basics</a>
            <a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
          </div>
        </div> -->
    </li>
    <li class="nav-item">
      <a class="nav-link" href="fale_rh">
        <i class="fas fa-headset"></i>
        <span>Fale com RH</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="meus_dados">
        <i class="fas fa-user-circle"></i>
        <span>Meus Dados</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Outros
    </div>
    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt"></i>
        <span>Sair</span>
      </a>
      <!-- <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Example Pages</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div> -->
    </li>

  <?php } else { ?>

    <!-- MENU FUNCIONARIO BLOQUEADO -->

    <li class="nav-item">
      <a class="nav-link" href="beneficios">
        <i class="fas fa-hand-holding-usd"></i>
        <span>Benefícios</span>
      </a>
      <!-- <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="form_basics.html">Form Basics</a>
            <a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
          </div>
        </div> -->
    </li>

  <?php } ?>

  <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span>
        </a>
      </li> -->
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->