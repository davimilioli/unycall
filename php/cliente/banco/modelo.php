<?php
require_once('../../config/config_db.php');
require_once('../../autoload.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    session_name('usuario');
}

session_start();


$tabelas = $pdo->query("SHOW TABLES");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Modelo Banco de Dados</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once('../layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once('../layout/includes/aside.php'); ?>
        <main class="page-cliente-model-db">
            <div class="model-db-content">
                <?php foreach ($tabelas as $tabela) : ?>
                    <?php $tabelaNome = $tabela['Tables_in_db_site']; ?>
                    <div class="card-db">
                        <div class="card-db-header">
                            <?= $tabela['Tables_in_db_site']; ?>
                        </div>
                        <div class="card-db-body">
                            <ul>
                                <?php foreach ($pdo->query("SHOW COLUMNS FROM $tabelaNome") as $coluna) : ?>
                                    <li><?= $coluna['Field'] ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
</body>