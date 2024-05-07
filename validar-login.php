<?php
// CRIAR SESSAO PARA VARIAVEL GLOBAL
session_start();


// VERIFICAR SE ESTÁ VINDO INFORMAÇÕES
// PARA VALIDAÇÃO DE E-MAIL E SENHA
if ($_POST) {
    // VERIFICAR SE FOI ENVIADO OS CAMPOS OBRIGATÓRIOS
    if (empty($_POST["email"]) || empty($_POST["senha"])) {
        $_SESSION["msg"] = "Por favor, preencha os campos obrigatórios!";
        $_SESSION["tipo"] = "warning";
        $_SESSION["title"] = "Ops!";
        
      header("Location: login.php");
        exit;
    } else {

         // RECUPERAR INFORMAÇÕES DO FORMULÁRIO LOGIN
         $email = trim($_POST["email"]);
         $senha = trim($_POST["senha"]);
         $remember = ($_POST["remember"]) ?? "off";
 
        include('./conexao-pdo.php');

        $sql = "
        SELECT 
        pk_usuario , nome, foto
    FROM 
        usuarios
    WHERE 
        email LIKE :email
        AND senha LIKE :senha
    ";
       

        // MONTAR SINTAXE SQL PARA CONSULTAR NO BANCO DE DADOS
        $stmt = $conn->prepare("$sql");
       
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':senha',$senha);

        $stmt->execute();

         // VERIFICAR SE ENCONTROU ALGUM REGISTRO NA TABELA
        if ($stmt->rowcount() > 0) {
            // VERIFICA SE O BOTÃO LEMBRAR DE MIN ESTA ATIVADO
            if($remember == "on"){
                // CRIA UM COOKIE NO NAVEGADOR SALVANDO OS DADOS DE ACESSO
                setcookie("email", $email);
                setcookie("senha", $senha);
            }else {
                // EXCLUIR COM DADOS DE ACESSO
                setcookie("email");
                setcookie("senha");
            }


         // ORGANIZA OS DADOS DO BANCO COMO OBJETOS NA VARIÁVEL $ROW
         $row = $stmt->fetch(PDO::FETCH_OBJ);

         // DECLARO VARIÁVEL GLOBAL INFORMANDO QUE USUÁRIO
            // ESTÁ AUTENTICADO CORRETAMENTE
            $_SESSION["autenticado"] = true;
            $_SESSION["pk_usuario"] = $row->pk_usuario;
            $_SESSION["nome_usuario"] = $row->nome;
            $_SESSION["foto_usuario"] = $row->foto;
            $_SESSION["tempo_login"] = time();

            // TRANFORMA STRING EM ARRAY, AONDE TIVER ESPAÇO
            $nome_usuario = explode(" ", $row->nome);
            // CONCATENA O PRIMEIRO NOME COM O SOBRENOME DO USUARIO
            $_SESSION["nome_usuario"] = $nome_usuario[0] ." " . end($nome_usuario);
            $_SESSION["tempo_login"] = time();

            header('Location: ./');
            exit;
        } else {
            $_SESSION["title"] = 'Ops!';
            $_SESSION["msg"] = 'E-mail e/ou senha inválidos!';
            $_SESSION["tipo"] = 'error';
            
            header('Location: ./login.php');
            exit;        
        }

    }
} else {
    header('Location: ./login.php');
    exit;
}
