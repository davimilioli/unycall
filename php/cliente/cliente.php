<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$id = $_SESSION['id'];
$dados = $sistema->procurarIdUsuario($id);
$gerenciador = new Gerenciador($banco->pegarPdo());
$assinaturaAtivo = $gerenciador->assinaturaAtiva($id);


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Dashboard</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-main">
            <div class="page-cliente-main-content">
                <div class="page-cliente-main-header">
                    <h2>Olá, <?= $dados['usuario']['nome'] ?></h2>
                </div>
                <div class="page-cliente-main-body">
                    <div class="tab">
                        <?php if (isset($assinaturaAtivo['ativo']) && $assinaturaAtivo['ativo']) : ?>
                            <div class="tab-header">
                                <h3>
                                    Gerencie sua Assinatura
                                </h3>
                            </div>
                            <div class="tab-content">
                                <div class="tab-content-description">
                                    <img src="/assets/img/icons/dynamic-form.svg">
                                    <div>
                                        <h4><?= $assinaturaAtivo['servico_assinado'] ?></h4>
                                        <p>--- </p>
                                    </div>
                                </div>
                                <a href="./assinatura/gerenciar.php" class="btn">
                                    Gerenciar
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="tab-header">
                                <h3>
                                    Você não possui nenhuma assinatura
                                </h3>
                            </div>
                            <div class="tab-content">
                                <div class="tab-content-description">
                                    <img src="/assets/img/icons/dynamic-form.svg">
                                    <div>
                                        <h4> --- </h4>
                                        <p> --- </p>
                                    </div>
                                </div>
                                <a href="./assinatura/gerenciar.php" class="btn">
                                    Assinar
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                    <!--                     <div class="tab">
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
                    </div> -->
                </div>

            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
</body>

</html>