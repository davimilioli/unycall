<?php
require_once(__DIR__ . '/Sistema.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    header('location: cliente.php?' . $_GET['id'] . 'erroPermissao=true');
    exit;
}

session_start();

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
    <title>Unycall - Lista de Usuários</title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-usuarios">
            <div class="category-title">
                <h4>Lista Usuarios</h4>
            </div>
            <section class="list-users">
                <div class="list-users-content">
                    <div class="list-users-title">
                        <h2 class="list-users-count">Total de registros (<?= count($lista) ?>)</h2>
                        <div class="list-users-actions">
                            <div class="form-content">
                                <form action="" class="form">
                                    <div class="form-group">
                                        <input type="text" name="buscarNome" id="buscarNome" placeholder="Digite o nome de usuário">
                                    </div>
                                </form>
                                <div class="resultado-busca">
                                    <ul class="resultado-busca-content">
                                    </ul>
                                </div>
                            </div>
                            <a href="gerar_pdf.php" target="_blank" class="btn pdf">
                                <img src="/assets/img/icons/list.svg">
                                Importar Lista
                            </a>
                            <a href="adicionar_usuario.php?id=<?= $_GET['id'] ?>" class="btn">
                                <img src="/assets/img/icons/plus.svg">
                                Adicionar Usuario
                            </a>
                        </div>
                    </div>
                    <div class="list-users-table-content">
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
                                        <td class="table-permissao" title="<?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?>" id="<?= $item->pegarPermissao() == null ? 'comum' : $item->pegarPermissao() ?>">
                                            <p><?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?></p>
                                        </td>
                                        <td class="table-buttons">
                                            <a class="btn" title="editar <?= $item->pegarNome() ?>" href="editar_usuario.php?id=<?= $_GET['id'] ?>&edit=<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/edit.svg">
                                            </a>
                                            <a class="btn secondary" title="excluir <?= $item->pegarNome() ?>" id="excluirUsuario" data-id-adm="<?= $_GET['id'] ?>" data-permissao="<?= $verificarPerm['usuario']['permissao'] ?>" data-id="<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/trash.svg">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <div class="modal-exclude"></div>
                </div>
            </section>
        </main>
    </div>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/cliente.js"></script>
    <script src="../../assets/js/lista-usuarios.js"></script>
</body>

</html>

<style>

</style>