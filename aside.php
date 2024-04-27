<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo caminhoURL; ?>" class="brand-link">
      <img src="<?php echo caminhoURL;?>dist/img/AdminLTELogo.png" alt="Senac SS" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Senac SS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo caminhoURL;?>/imagens/IMG_20230730_132219_183.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["nome_usuario"];?></a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="<?php echo caminhoURL; ?>" class="nav-link <?php echo $pagina_ativa == 'home' ? 'active': '';?> ">
              <i class="nav-icon bi bi-house"></i>
              <p>
                Pagina Inicial
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo caminhoURL;?>ordens-servico" class="nav-link <?php echo $pagina_ativa == 'ordens_servico' ? 'active': '';?>">
              <i class="bi bi-cash-coin"></i>
              <p>
                Ordens de Serviço
                <span class="right badge badge-danger">15</span>
              </p>
            </a>
          </li>
          <li class="nav-header"> CONFIGURAÇÕES</li>
            <a href="nav-item">
            <li class="nav-item">
            <a href="<?php echo caminhoURL;?>/clientes" class="nav-link <?php echo $pagina_ativa == 'clientes' ? 'active': '';?>">
              <i class="nav-icon bi bi-person"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo caminhoURL;?>/servicos" class="nav-link <?php echo $pagina_ativa == 'servicos' ? 'active': '';?>">
              <i class="nav-icon bi bi-tools"></i>
              <p>
                Serviços
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>