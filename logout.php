<?php

include('./verificar-autenticidade.php');

session_start();
// DESTRUIR QUALQUER SESSÃO EXISTENTE
session_destroy();

header("Location:". caminhoURL. "/login.php");
exit;