<?php
session_start();

$sessao = $_SESSION['usuario'];
if (!isset($sessao)) {
    header('location: ../login/login.php?erroSistema=true');
    exit;
}

require_once(__DIR__ . '/Sistema.php');

$sistema = new Sistema($pdo);
$lista = $sistema->consultarDados();
require_once(__DIR__ . '../modulos/modulos.php');
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
        <main class="page-cliente-usuarios">
            <div class="category-title">
                <h4>Lista Usuarios</h4>
                <div>
                    <p>Usuarios encontrados: <?= count($lista) ?></p>
                </div>
            </div>
            <section class="list-users">
                <?php foreach ($lista as $item) : ?>
                    <div class="card-user">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="card-info">
                                <h2>Nome</h2>
                                <p><?= $item['usuario']->pegarNome() ?></p>
                            </div>
                            <div class="card-body-content">
                                <div class="card-info">
                                    <h3>ID</h3>
                                    <p><?= $item['usuario']->pegarId() ?></p>
                                </div>
                                <div class="card-info">
                                    <h3>CPF</h3>
                                    <p><?= formatarCpf($item['usuario']->pegarCpf()) ?></p>
                                </div>
                                <div class="card-info">
                                    <h3>Email</h3>
                                    <p><?= strlen($item['usuario']->pegarEmail()) > 20 ? substr($item['usuario']->pegarEmail(), 1, 20) . '...' : $item['usuario']->pegarEmail(); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn" href="editar_usuario.php?id=<?= $item['usuario']->pegarId() ?>">Editar</a>
                            <a class="btn secondary" id="excluirUsuario" data-id="<?= $item['usuario']->pegarId() ?>">Excluir</a>
                        </div>
                        <div class="modal-exclude"></div>
                    </div>
                <?php endforeach ?>
            </section>
        </main>
    </div>
    <script src="../../assets/js/lista-usuarios.js"></script>
</body>

</html>