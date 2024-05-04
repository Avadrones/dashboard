<?php
include('../verificar-autenticidade.php');
include('../conexao-pdo.php');

$pagina_ativa = 'meu-perfil';

$pk_usuario = $_SESSION["pk_usuario"];


// MONTA A SINTAXE FINAL NO MYSQL
$sql = "
SELECT  nome, email, foto
FROM  usuarios  
WHERE pk_usuario = :pk_usuario
   ";

// PREPARA A SINTAXE
$stmt = $conn->prepare($sql);
// SUBSTITUI A STRING PK_SERVIÇO PELA VARIAVEL PK_SERVIÇO
$stmt->bindParam(':pk_usuario', $pk_usuario);
// EXECUTA A SINTAXE FINAL MYSQL 
$stmt->execute();
// VERIFICA SE ENCONTROU ALGUM REGISTRO NO BANCO DE DADOS
if ($stmt->rowCount() > 0) {
    $dado = $stmt->fetch(PDO::FETCH_OBJ);
    $nome = $dado->nome;
    $email = $dado->email;
    $foto = $dado->foto;
} else {
    $_SESSION["tipo"] = 'error';
    $_SESSION["title"] = 'ops';
    $_SESSION["msg"] = 'Registro não encontrado';
    header("lLocation: ./");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SSS | Pàgina Inicial</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../dist/plugins/fontawesome-free/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("../nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("../aside.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col">
                            <form method="post" action="salvar.php" enctype="multipart/form-data">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Meu Perfil</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <img class="img-fluid rounded-circle" src="<?php echo caminhoURL?>/imagens/618.jpeg" width="300" height="300">
                                            </div>
                                            <div class="col-md">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="servico" class="form-label">Nome</label>
                                                        <input required type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="servico" class="form-label">Email</label>
                                                        <input required type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                                    </div>
                                                    <div class="col ">
                                                        <label for="servico" class="form-label">Senha</label>
                                                        <input required type="text" class="form-control" id="senha" name="senha" value="">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="servico" class="form-label">Foto</label>
                                                        <div class="custom-file">
                                                            <input type="file" for="custom-file-input" name="foto" id="foto">
                                                            <label class="custom-file-label" for="foto">Selecionar foto</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-right">
                                        <a href="./" class="btn btn-outline-danger rounded-circle">
                                            <i class="bi bi-arrow-left"></i>
                                        </a>
                                        <button type="submit" class="btn btn-primary rounded-circle">
                                            <i class="bi bi-floppy"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card -->

                            </form>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /. Footer -->
        <?php include("../footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../dist/plugins/jquery/jquery.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="../dist/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- Bootstrap 4 -->
    <script src="../dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../dist/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>
    <script src="../dist/plugins/SweetAlert2/SweetAlert2.min.js"></script>
<?php include ("../sweet-alert-2.php"); ?>
    <script>
        $(function() {

            $("#theme-mode").click(function() {
                var classMode = $("#theme-mode").attr("class")
                if (classMode == "fas fa-sun") {
                    $("body").removeClass("dark-mode");
                    $("#theme-mode").attr("class", "fas fa-moon");
                    $("#navTopo").attr("Class", "main-header navbar navbar-expand navbar-white navbar-light");
                    $("#asideMenu").attr("Class", "main-sidebar sidebar-light-primary elevation-4");
                } else {
                    $("body").addClass("dark-mode");
                    $("#theme-mode").attr("class", "fas fa-sun");
                    $("#navTopo").attr("Class", "main-header navbar navbar-expand navbar-black navbar-dark");
                    $("#asideMenu").attr("Class", "main-sidebar sidebar-dark-primary elevation-4");
                }
            });

        })
    </script>

</body>

</html>