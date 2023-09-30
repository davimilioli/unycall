<?php
session_start();

$sessao = $_SESSION['usuario'];
if (!isset($sessao)) {
    header('location: ../login/login.php?erroSistema=true');
    exit;
}

require_once(__DIR__ . '/Sistema.php');

$sistema = new Sistema($pdo);
$lista = $sistema->consultarDadosUsuario();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Administração</title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-main">

        </main>
    </div>
</body>

</html>