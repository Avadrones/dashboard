<?php

include("../verificar-autenticidade.php");
include("../conexao-pdo.php");

// VERIFICA SE ESTÁ VINDO INFORMAÇÕES VIA POST
if ($_POST) {
    // VERIFICA CAMPOS OBRIGATóRIOS
    if (empty(($_POST["servico"]))) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios.';
        header("Location: ./");
        exit;
    } else {
        // RECUPERA INFORMAÇÕES PREENCHIDAS PELO USUARÍO
        $pk_servico = trim($_POST["pk_servico"]);
        $servico = trim($_POST["servico"]);

        try {
            if (empty($pk_servico)) {
                $sql = "
            INSERT INTO servicos (servico) VALUES
            (:servico)
            ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':servico', $servico);
            } else {
                $sql = "
            UPDATE servicos SET
            servico = :servico
            WHERE pk_servico = :pk_servico
            ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':pk_servico', $pk_servico);
                $stmt->bindParam(':servico', $servico);
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
            $_SESSION["msg"] = $ex;
            header("Location: ./");
            exit;
        }
    }
}
