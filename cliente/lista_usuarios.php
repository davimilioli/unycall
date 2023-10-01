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
                    <a href="adicionar_usuario.php" class="btn">
                        <img src="/assets/img/icons/plus.svg">Adicionar Usuario
                    </a>
                </div>
            </div>
            <section class="list-users">
                <div class="list-users-content">
                    <h2 class="list-users-count">Total de registros (<?= count($lista) ?>)</h2>
                    <table class="list-users-table">
                        <thead>
                            <tr>
                                <th class="table-id">#</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th>Telefone</th>
                                <th>Permissão</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <?php foreach ($lista as $item) : ?>
                            <tbody>
                                <tr>
                                    <td class="table-id" title="<?= $item->pegarId() ?>"><?= $item->pegarId() ?></td>
                                    <td title="<?= $item->pegarNome() ?>"><?= $item->pegarNome() ?></td>
                                    <td title="<?= formatarCpf($item->pegarCpf()) ?>"><?= formatarCpf($item->pegarCpf()) ?></td>
                                    <td title="<?= $item->pegarEmail() ?>"><?= $item->pegarEmail() ?></td>
                                    <td title="<?= formatarNumero($item->pegarCelular()) ?>"><?= formatarNumero($item->pegarCelular()) ?></td>
                                    <td title="<?= formatarNumero($item->pegarTelefone()) ?>"><?= formatarNumero($item->pegarTelefone()) ?></td>
                                    <td title="<?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?>" id="<?= $item->pegarPermissao() == null ? 'comum' : $item->pegarPermissao() ?>">
                                        <p><?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?></p>
                                    </td>
                                    <td class="table-buttons">
                                        <a class="btn" title="editar <?= $item->pegarNome() ?>" href="editar_usuario.php?id=<?= $item->pegarId() ?>">
                                            <img src="/assets/img/icons/edit.svg">
                                        </a>
                                        <a class="btn secondary" title="excluir <?= $item->pegarNome() ?>" id="excluirUsuario" data-id="<?= $item->pegarId() ?>">
                                            <img src="/assets/img/icons/trash.svg">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach ?>
                    </table>
                    <div class="modal-exclude"></div>
                </div>
            </section>
        </main>
    </div>
    <script src="../../assets/js/lista-usuarios.js"></script>
</body>

</html>