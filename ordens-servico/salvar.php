<?php

include("../verificar-autenticidade.php");
include("../conexao-pdo.php");

// VERIFICA SE ESTÁ VINDO INFORMAÇÕES VIA POST
if ($_POST) {
    // VERIFICA CAMPOS OBRIGATóRIOS
    if (empty($_POST["nome"])|| empty($_POST["cpf"] || strlen($_POST["cpf"] !=14))) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'ops';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios.';
        header("Location: ./");
        exit;
    } else {
        // RECUPERA INFORMAÇÕES PREENCHIDAS PELO USUARÍO
        $pk_servico = trim($_POST["pk_ordem_servico"]);
        $cpf = trim($_POST["CPF"]);
        $whatsapp = trim($_POST["data_inicio"]);
        $email = trim($_POST["data_fim"]);

        try {
            if (empty($pk_cliente)) {
                $sql = "
                INSERT INTO ordem_servico (data_ordem_servico, data_inicio,
                 data_fim, fk_cliente ) VALUES
                (CURDATE(), :data_inicio, :data_fim, (
                    SELECT pk_cliente
                    FROM clientes
                    WHERE cpf LIKE :cpf
                )
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':data_inicio', $data_inicio);
                $stmt->bindParam(':data_fim', $data_fim);
                $stmt->bindParam(':cpf', $cpf);
               
            } else {
                $sql = "
                UPDATE ordem_servico SET
                fk_cliente = (
                    SELECT pk_cliente
                    FROM clientes
                    WHERE cpf LIKE :cpf
                ),
                data_inicio = :data_inicio,
                data_fim = :data_fim
                WHERE pk_ordem_servico = :pk_ordem_servico
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':pk_ordem_servico', $pk_ordem_servico);
                $stmt->bindParam(':data_inicio', $data_inicio);
                $stmt->bindParam(':data_fim', $data_fim);
                $stmt->bindParam(':cpf', $cpf);
            }
            
            // EXECUTA O INSERT OU UPDATE ACIMA
            $stmt->execute();

            // PEGAR PK_ORDEM_SERVICO CASO SEJA INSERT
            if (empty($pk_ordem_servico)) {
                $pk_ordem_servico = $conn->lastInsertId();
            } 

            // MONTAR DADOS DA TABELA RL_SERVICOS_OS
            $sql = "
            DELETE FROM rl_servicos_os
            WHERE fk_ordem_servico = :fk_ordem_servico
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fk_ordem_servico', $fk_ordem_servico);
            $stmt->bindParam(':data_inicio', $data_inicio);
            $stmt->execute();

            $sql = "
            INSERT INTO rl_servicos_os VALUES
            ";

            $servicos = $_POST["fk_servico"];
            $valores = $_POST["valor"];

            foreach ($servicos as $key => $servico) {
                $sql = "(:fk_servico_$key, :fk_ordem_servico, :valor_$key),";
            }
            $sql = substr($sql, 0, -1);
            $stmt = $conn->prepare($sql);

            foreach ($servicos as $key => $servico) {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":fk_servico_$key", $servico[$key]);
                $stmt->bindParam(":fk_ordem_servico", $fk_ordem_servico);
                $stmt->bindParam(":valor_$key", $valores[$key]);
            }

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
