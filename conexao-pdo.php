<?php


define('username', 'root');
define('password','');

try{
$conn = new PDO('mysql: host=localhost; dbname=ordem_servico',
username,
password

);
}catch(PDOException $e) {
    $_SESSION["tipo"] = 'error';
    $_SESSION["title"] = 'ops';
    $_SESSION["title"] = $e->getMessage();

    header("Location: ./");
    exit;
}