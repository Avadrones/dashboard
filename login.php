<?php
//VERIFICA SE EXISTE COOKIE CRIADO PARA PREENCHIMENTO DOS DADOS DE ACESSO
if(empty($_COOKIE["email"]) || empty($_COOKIE["senha"])) {
  $checked = "";
  $email = "";
  $senha = "";
} else {
  $checked = "checked ";
  $email = $_COOKIE["email"];
  $senha = $_COOKIE["senha"];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SSS Senac System Service</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dist/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="dist/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="dist/dist/index2.html" class="h4"><b>SSS</b>Senac System Service</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Informe seus dados para login</p>

      <form action="validar-login.php" method="post">
        <div class="input-group mb-3">
          <input value="<?php echo $email;?>" required type="email" class="form-control" placeholder="E-mail" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input value="<?php echo $senha;?>" required type="password" class="form-control" placeholder="Senha" name="senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input <?php echo $checked;?> type="checkbox" id="remember" name="remember">
              <label for="remember">
                Lembrar-me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Entrar com  Google
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="esqueceu-senha.php">Esqueceu a senha?</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="dist/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="dist/plugins/SweetAlert2/SweetAlert2.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<?php include ("sweet-alert-2.php"); ?>

</body>

</html>
