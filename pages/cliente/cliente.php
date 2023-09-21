<?php
session_start();

$sessao = $_SESSION['usuario'];
if (!isset($sessao)) {
    header('location: ../login/login.php?erroSistema=true');
    exit;
}

echo 'entrou!!';
?>

<a href="sair.php">Sair</a>