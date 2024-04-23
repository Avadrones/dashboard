<?php
include('../verificar-autenticidade.php');
include('../conexao-pdo.php');

if (empty($_GET["ref"])) {
    $pk_cliente = "";
    $nome = "";
    $CPF = "";
    $whatsapp = "";
    $email = "";
} else {
    $pk_cliente = base64_decode(trim($_GET["ref"]));
    $sql = "
        SELECT pk_cliente, nome, CPF, whatsapp, email
        FROM clientes
        WHERE pk_cliente = :pk_cliente
        ";
    // PREPARA A SINTAXE
    $stmt = $conn->prepare($sql);
    // SUBSTITUI A STRING PK_SERVIÇO PELA VARIAVEL PK_SERVIÇO
    $stmt->bindParam(':pk_cliente', $pk_cliente);
    // EXECUTA A SINTAXE FINAL MYSQL 
    $stmt->execute();
    // VERIFICA SE ENCONTROU ALGUM REGISTRO NO BANCO DE DADOS
    if ($stmt->rowCount() > 0) {
        $dado = $stmt->fetch(PDO::FETCH_OBJ);
        $nome = $dado->nome;
        $CPF = $dado->CPF;
        $whatsapp = $dado->whatsapp;
        $email = $dado->email;
    } else {
        $_SESSION["tipo"] = 'error';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Registro não encontrado';
        header("lLocation: ./");
        exit;
    }
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
                            <form method="post" action="salvar.php">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Lista de Clientes</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-1">
                                                <label for="pk_cliente" class="form-label">Cód</label>
                                                <input readonly type="text" class="form-control" id="pk_cliente" name="pk_cliente" value="<?php echo
                                                                                                                                            $pk_cliente; ?>">
                                            </div>
                                            <div class="col-4">
                                                <label for="nome" class="form-label">NOME</label>
                                                <input required type="text" class="form-control" id="nome" name="nome" value="<?php echo
                                                                                                                                $nome; ?>">
                                            </div>
                                            <div class="col-2">
                                                <label for="nome" class="form-label">CPF</label>
                                                <input required type="text" class="form-control" id="CPF" name="CPF" value="<?php echo
                                                                                                                            $CPF; ?>">
                                            </div>
                                            <div class="col-2">
                                                <label for="nome" class="form-label">WHATSAPP</label>
                                                <input required type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo
                                                                                                                                        $whatsapp; ?>">
                                            </div>
                                            <div class="col-3">
                                                <label for="nome" class="form-label">EMAIL</label>
                                                <input required type="text" class="form-control" id="email" name="email" value="<?php echo
                                                                                                                                $email; ?>">
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