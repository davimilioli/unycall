<?php
require_once(__DIR__ . '/Sistema.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    session_name('usuario');
}

session_start();

$lista = $sistema->consultarDadosUsuario();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Painel <?= $verificarPerm['usuario']['permissao'] == 'administrador' ? 'Administrativo' : 'do Cliente' ?></title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-main">

        </main>
    </div>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/cliente.js"></script>
</body>

</html>