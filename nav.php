<?php
$sql = "
SELECT COUNT(pk_ordem_servico) total_os,
(
FROM ordens_servicos
) total_clientes,
(
  SELECT COUNT(pk_cliente)
  FROM servicos
) total_servicos,
(
  SELECT COUNT(pk_servico)
  FROM ordens_servicos
  WHERE data_fim <> '0000-00-00'
) total_os_fechados
FROM ordens_servicos
";
try{
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

  $total_os_abertas = $dados->total_os - $dados->$total_os_fechadas;
  $porcentagem_os_concluida = $dados->total_os_fechadas / $dados->total_os * 100;
  
} catch (PDOException $ex) {
  $_SESSION["tipo"] = "error";
  $_SESSION["title"] = "ops";
  $_SESSION["tipo"] = $ex->getMessage();
}
?>
<nav id="navTopo" class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo caminhoURL; ?>/index3.html" class="nav-link">Pagina Inicial</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo caminhoURL; ?>/contato" class="nav-link">Contato</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link">
        <i class="fas fa-moon" id="theme-mode"></i> 
      </a>
    </li>
    <!-- Navbar Search -->

    <!-- Messages Dropdown Menu -->

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>

      </a>
    </li>
    <li class="nav-item">
     <a href="<?php echo caminhoURL; ?>/logout.php" class="nav-link">
      <i class="fas fa-sign-out-alt"></i>
     </a>
</li>
  </ul>
</nav>