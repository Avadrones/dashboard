<?php
include('../verificar-autenticidade.php');
include('../conexao-pdo.php');
$pagina_ativa = "ordens_servico";

$sql = "
SELECT pk_servico, servico
FROM servicos
ORDER BY servico
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

    $options = '<option value=""> -- Selecione -- </option>;'; 

    foreach ($dados as $key => $row) {
        $options .= '<option value="' . $row->pk_servico . '">' . $row->servico . '</option>';
    }
} catch (Exception $ex) {
    $_SESSION["tipo"] = "error";
    $_SESSION["title"] = "ops!";
    $_SESSION["msg"] = $ex->getMessage();

    header("Location: ./");
    exit;
}

if (empty($_GET["ref"])) {
    $pk_ordem_servico = "";
    $cpf = "";
    $nome = "";
    $data_ordem_servico = "";
    $data_inicio = "";
    $data_fim = "";
} else {
    $pk_ordem_servico = base64_decode(trim($_GET["ref"]));
    $sql = "
        SELECT  pk_ordem_servico, data_ordem_servico, data_inicio, data_fim,
        cpf, nome
        FROM ordens_servicos
        JOIN clientes ON pk_cliente = fk_cliente
        WHERE pk_ordem_servico = :pk_ordem_servico
        ";
    // PREPARA A SINTAXE
    $stmt = $conn->prepare($sql);
    // SUBSTITUI A STRING PK_SERVIÇO PELA VARIAVEL PK_SERVIÇO
    $stmt->bindParam(':pk_ordem_servico', $pk_ordem_servico);
    // EXECUTA A SINTAXE FINAL MYSQL 
    $stmt->execute();
    // VERIFICA SE ENCONTROU ALGUM REGISTRO NO BANCO DE DADOS
    if ($stmt->rowCount() > 0) {
        $dado = $stmt->fetch(PDO::FETCH_OBJ);
        $data_ordem_servico = $dado->data_ordem_servico;
        $data_inicio = $dado->data_inicio;
        $data_fim = $dado->data_fim;
        $cpf = $dado->cpf;
        $nome = $dado->nome;
    } else {
        $_SESSION["tipo"] = 'error';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Registro não encontrado';
        header("Location: ./");
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
    <link rel="stylesheet" href="../dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                                            <div class="col-2">
                                                <label for="pk_ordem_servico" class="form-label">Cód</label>
                                                <input readonly type="text" class="form-control" id="pk_ordem_servico" name="pk_ordem_servico" value="<?php echo $pk_ordem_servico; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nome" class="form-label">CPF</label>
                                                <div class="input-group">
                                                <input required type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $cpf; ?>" data-mask="000.000.000-00">
                                                <span class="input-group-append">
                                                    <button id="btn-search" type="button" class="btn btn-default btn-flat">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="nome" class="form-label">NOME</label>
                                                <input required readonly type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="nome" class="form-label">Data O.S.</label>
                                                <input required readonly type="date" class="form-control" id="data_ordem_servico" name="data_ordem_servico" value="<?php echo $data_ordem_servico; ?>">
                                            </div>
                                            <div class="col-4">
                                                <label for="nome" class="form-label">Data Inicial</label>
                                                <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="<?php echo $data_inicio; ?>">
                                            </div>
                                            <div class="col-4">
                                                <label for="nome" class="form-label">Data Final</label>
                                                <input  type="date" class="form-control" id="data_fim" name="data_fim" value="<?php echo $data_fim; ?>">
                                            </div>
                                        </div>
                                        <div class=" mt-5 card card-warning card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">Lista de serviços</h3>
                                                <button type="button" class="btn btn-sm btn-primary float-right rounded-circle" id="btn-add">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <table class="table" id="table_servico">
                                                    <thead>
                                                        <tr>
                                                            <th>SERVIÇO</th>
                                                            <th>VALOR</th>
                                                            <th>OPÇÕES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (empty($pk_ordem_servico)) {
                                                            echo'
                                                            <tr>
                                                            <td>
                                                                <select required class="form-control" name="fk_servico[]">
                                                                    '. $options .'
                                                                </select>
                                                            </td>
                                                            <td >
                                                                <input class="form-control" type="number" name="valor[]">
                                                            </td>
                                                            <td> </td>
                                                                
                                                            
                                                        </tr>
                                                        ';
                                                        } else {
                                                            $sql ="
                                                            SELECT s.pk_servico, s.servico, rl.valor
                                                            FROM servicos AS s
                                                            JOIN rl_servicos_os AS rl ON rl.fk_servico = s.pk_servico
                                                            WHERE rl.fk_ordem_servico = :pk_ordem_servico
                                                            ";

                                                            try {
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->bindParam(':pk_ordem_servico', $pk_ordem_servico);
                                                                $stmt->execute();

                                                                $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                                foreach ($dados as $key => $row) {
                                                                    echo'
                                                                    <tr>
                                                                    <td>
                                                                        <select required class="form-control" name="fk_servico[]">
                                                                        <option selected value="'.$row->pk_servico.'">'.$row->servico.'</option>
                                                                            '. $options .'
                                                                            </select>
                                                                            </td>
                                                                            <td >
                                                                                <input value="'.$row->valor.'" required class="form-control" type="number" name="valor[]">
                                                                            </td>
                                                                            <td> </td>
                                                                            </tr>
                                                                            ';                                                                                
                                                                }
                                                            }  catch (Exception $ex) {
                                                                $_SESSION["tipo"] = "error";
                                                                $_SESSION["title"] = "ops!";
                                                                $_SESSION["msg"] = $ex->getMessage();                                                            
                                                        } 
                                                    }
                                                    ?>                                                    
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- /.card-body -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(function() {

            $("#cpf").keyup(function() {
             // // LIMPAR INPUT DE NOME
             $('#nome').val("");
            })

            $("#btn-search").click(function() {
                // LIMPAR INPUT DE NOME
                $('#nome').val("");
                // FAZ A REQUISIÇÂO PARA O ARQUIVO CONSULTAR_CPF.PHP
                $.getJSON(
                    'consultar_cpf.php', {
                     cpf: $("#cpf").val()
                    },
                    function(data) {
                        if (data['success'] == true) {
                            $("#nome").val(data['dado']['nome']);
                        } else {
                            alert(data['dado']);
                            $("#cpf").focus("")
                        }
                    }
                )
            });

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

            $("#btn-add").click(function() {
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td>';
            cols += '<select class="form-control" name="fk_servico[]">';
            cols += ' <?php echo $options; ?>';
            cols += '</select>';
            cols += '</td>';
            cols += '<td><input type="number" class="form-control" name="valor[]"></td>';
            cols += '<td>';
            cols += '<button class="btn btn-danger btn-sm" onclick="RemoveRow(this)" type="button"><i class="fas fa-trash"></button>';
            cols += '</td>';
            newRow.append(cols);
            $("#table_servico").append(newRow);
            });
            
            
            RemoveRow= function (item) {
             var tr = $(item).closest('tr');
             tr.fadeOut(400, function() {
                tr.remove();
             });
             return false;

            }

        })
    </script>

</body>

</html>