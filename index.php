<?php
require_once(__DIR__ . '/config/config_db.php');
require_once(__DIR__ . '/modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);

/* $senha = 'admin';
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash; */
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Inicial</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/includes/header.php'); ?>

</body>

</html>