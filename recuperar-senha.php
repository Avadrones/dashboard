<?php
session_start();
include('./conexao-pdo.php');

// ARQUIVOS PARA RECUPERAR SENHA
require_once('dist/plugins/php-mailer/src/PHPMailer.php');
require_once('dist/plugins/php-mailer/src/SMTP.php');
require_once('dist/plugins/php-mailer/src/Exception.php');

// BIBLIOTECAS PARA RECUPERAR SENHA
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
    $email = trim($_POST["email"]);

    $sql = "
    SELECT pk_usuario, nome
    FROM usuarios
    WHERE email LIKE :email
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dado = $stmt->fetch(PDO::FETCH_OBJ);

            // GERAR UMA NOVA SENHA ALEATORIA
            $nova_senha = substr(hash('sha256', uniqid()), 6, 6);

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host         = "mail.g1a.com.br";
            $mail->Username     = "alunos@g1a.com.br";
            $mail->Password     = "Senac@2024";
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth     = true;
            $mail->Port         = 465;

            // REMETENTE
            $mail->setFrom("alunos@g1a.com.br", "Sistema Dashboard - OS");

            // DESTINATARIO
            $mail->addAddress($email, $dado->nome);
            // DESTINATARIO EM COPIA
            // $mail->addBCC("email","nome");
            // DESTINATARIO EM COPIA OCULTA
            //  $mail->addBCC ("email","nome");
            // ANEXAR ARQUIVO
            //  $mail->addAttacchament("caminho do arquivo");
            $mail->isHTML(true);
            $mail->Subject  = "Recuperação de senha";
            $mail->CharSet  = "UTF-8";
            $mail->Body     = "
            <h2>RECUPERAÇÃO DE SENHA</h2>
            <p>Você solicitou uma alteração de senha em nosso painel dashboard.<p>
            <p>
            Segue abaixo dados do seu novo acesso:<br>
            <strong>E-mail:</strong> http://localhost/caetano/dashboard<br>
            <strong>E-mail:</strong> $email <br>
            <strong>senha:</strong> $nova_senha <br>
            </p>
            <p>Enviado em " . date("d/m/y - H:i") . "</p>
            ";
            $mail->send();

            $sql = "
            
            UPDATE usuarios SET
            senha = :senha
            WHERE pk_usuario = :pk_usuario
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':senha', $nova_senha);
            $stmt->bindParam(':pk_usuario', $dado->pk_usuario);
            $stmt->execute();

            $_SESSION["tipo"] = "warning";
            $_SESSION["title"] = "Ops";
            $_SESSION["MSG"] = "Uma nova senha foi enviada para o seu e-mail.";
        } else {
            $_SESSION["tipo"] = "warning";
            $_SESSION["title"] = "Ops";
            $_SESSION["MSG"] = "Este e-mail não consta em nossa base de dados.";
        }
    } catch (PDOException $e) {
        $_SESSION["tipo"] = "warning";
        $_SESSION["title"] = "Ops";
        $_SESSION["MSG"] = $e->getMessage();
    }
}
header("Location: ./login.php");
exit;
