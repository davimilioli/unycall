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
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Painel <?= $verificarPerm['usuario']['permissao'] == 'administrador' ? 'Administrativo' : 'do Cliente' ?></title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-main">
            <div class="page-cliente-main-content container">
                <div class="page-cliente-main-header">
                    <h2>Olá, Davi Jacuru Milioli</h2>
                </div>
                <div class="page-cliente-main-body">
                    <div class="tab">
                        <div class="tab-header">
                            <h3>Gerencie seus planos</h3>
                        </div>
                        <div class="tab-content">
                            <div class="tab-content-description">
                                <img src="/assets/img/icons/dynamic-form.svg">
                                <div>
                                    <h4>Plano Premium</h4>
                                    <p>Expira em 2024/02/10</p>
                                </div>
                            </div>
                            <a href="#" class="btn">Gerenciar</a>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="tab-header">
                            <h3>Faturas</h3>
                        </div>
                        <div class="tab-content">
                            <div class="tab-content-description">
                                <img src="/assets/img/icons/dynamic-form.svg">
                                <div>
                                    <h4>Fatura de Outubro</h4>
                                    <p>Expira em 2024/02/10</p>
                                </div>
                            </div>
                            <a href="#" class="btn">Gerenciar</a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/cliente.js"></script>
</body>

</html>