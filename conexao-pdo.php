<?php


define('username', 'root');
define('password','');

try{
$conn = new PDO('mysql: host=localhost; dbname=ordem_servico',
username,
password

);
}catch(PDOException $e) {
    echo "ERROR: " .$e->getMessage();
    exit;
}