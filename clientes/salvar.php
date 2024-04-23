<?php

include("../verificar-autenticidade.php");
include("../conexao-pdo.php");

// VERIFICA SE ESTÁ VINDO INFORMAÇÕES VIA POST
if ($_POST) {
    // VERIFICA CAMPOS OBRIGATóRIOS
    if (empty(($_POST["nome"]))) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios.';
        header("Location: ./");
        exit;
    } else {
        // RECUPERA INFORMAÇÕES PREENCHIDAS PELO USUARÍO
        $pk_cliente = trim($_POST["pk_cliente"]);
        $nome = trim($_POST["nome"]);
        $CPF = trim($_POST["CPF"]);
        $whatsapp = trim($_POST["whatsapp"]);
        $email = trim($_POST["email"]);

        try {
            if (empty($pk_cliente)) {
                $sql = "
                INSERT INTO clientes (nome, CPF, whatsapp, email) VALUES
                (:nome, :CPF, :whatsapp, :email)
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':CPF', $CPF);
                $stmt->bindParam(':whatsapp', $whatsapp);
                $stmt->bindParam(':email', $email);
            } else {
                $sql = "
                UPDATE clientes SET
                nome = :nome,
                CPF = :CPF,
                whatsapp = :whatsapp,
                email = :email
                WHERE pk_cliente = :pk_cliente
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':pk_cliente', $pk_cliente);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':CPF', $CPF);
                $stmt->bindParam(':whatsapp', $whatsapp);
                $stmt->bindParam(':email', $email);
            }
            
            // EXECUTA O INSERT OU UPDATE ACIMA
            $stmt->execute();

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
