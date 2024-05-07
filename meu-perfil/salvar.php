<?php

include("../verificar-autenticidade.php");
include("../conexao-pdo.php");

// VERIFICA SE ESTÁ VINDO INFORMAÇÕES VIA POST
if ($_POST) {
    // VERIFICA CAMPOS OBRIGATóRIOS
    if (empty($_POST["nome"]) || empty($_POST["email"])) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios.';
        header("Location: ./");
        exit;
    } else {
        // RECUPERA INFORMAÇÕES PREENCHIDAS PELO USUARÍO
        $pk_usuario = $_SESSION["pk_usuario"];
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $senha = trim($_POST["senha"]);
        $foto = $_FILES["foto"];

        // VERIFICA SE EXISTE UMA FOTO A SER SALVA
        if ($foto["error"] != 4) {
            $ext_permitidos = array(
                "bmp",
                "jpg",
                "jpeg",
                "png",
                "jfif",
                "tiff"
            );
            // $ext_permitidos = ["bmp", "jpg", "jpeg", "png", "jfif", "tiff"];
            $extensao = pathinfo($foto["name"], PATHINFO_EXTENSION);
            // VERIFICA SE A EXTENSAO DO ARQUIVO
            // CONTEM NO ARRAY EXT_PERMITIDOS
            if(in_array($extensao, $ext_permitidos)) {
                // GERAR NOME UNICO PARA O ARQUIVO
                $novo_nome = hash("sha256", uniqid() . rand() . $foto["tmp_name"]). "." . $extensao;

                // MOVER ARQUIVO PARA A PASTA "FOTOS"
                // COM O NOVO NOME
                move_uploaded_file($foto["tmp_name"], "fotos/$novo_nome");
                $update_foto = "foto = '$novo_nome'";

                $_SESSION["foto_usuario"]=$novo_nome;
               
            } else {
                $_SESSION["tipo"] = "error";
                $_SESSION["title"] = "ops!";
                $_SESSION["msg"] = "arquivo de imagem NÃO permitido";
                header("Location: ./");
                exit;
            }
        } else {
            $update_foto = "foto=foto";
        }

        try {
            if (empty($senha)) {
                $sql="
                UPDATE usuarios  SET
                 nome = :nome,
                email = :email,
                $update_foto 
                WHERE pk_usuario = :pk_usuario
            ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pk_usuario', $pk_usuario);
            } else {
                $sql = "
                UPDATE usuarios  SET
                nome = :nome,
               email = :email,
               senha = :senha,
               $update_foto 
               WHERE pk_usuario = :pk_usuario
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':pk_usuario', $pk_usuario);
            }
            
            // EXECUTA O INSERT OU UPDATE ACIMA
            $stmt->execute();

              $nome_usuario = explode(" ", $nome);
              // CONCATENA O PRIMEIRO NOME COM O SOBRENOME DO USUARIO
              $_SESSION["nome_usuario"] = $nome_usuario[0] ." " . end($nome_usuario);


            $_SESSION["tipo"] = 'success';
            $_SESSION["title"] = 'Oba!';
            $_SESSION["msg"] = 'Registro salvo com sucesso!';

            header("Location: ./");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["tipo"] = 'error';
            $_SESSION["title"] = 'ops';
            $_SESSION["msg"] = $ex->getMessage();
            header("Location: ./");
            exit;
        }
    }
}
