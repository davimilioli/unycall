<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];
$permissao = $_SESSION['permissao'];

if ($permissao != 'administrador') {
    header('location: /php/cliente/cliente.php?erroPermissao=true');
    exit;
}

$lista = $sistema->consultarDadosUsuario();

require_once(__DIR__ . '../modulos/modulos.php');

if (isset($_POST['exclude'])) {
    $idExclude = $_POST['exclude'];
    $sistema->deletarDados($idExclude);
    header('location: /php/cliente/lista_usuarios.php');
    exit;
}

$qtdUsuarios = 10;
$totalPaginas = ceil(count($lista) / $qtdUsuarios);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Lista de Usuários</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
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
                            </div>
                            <?php if(count($lista) > 2) : ?>
                                <a href="gerar_pdf.php" target="_blank" class="btn pdf">
                                    <img src="/assets/img/icons/list.svg">
                                    Importar Lista
                                </a>
                            <?php endif ?>
                            <a href="adicionar_usuario.php" class="btn">
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
                            <tbody data-qtd-usuarios="<?= $qtdUsuarios ?>">
                                <?php foreach ($lista as $item) : ?>
                                    <tr>
                                        <td class="table-id"><?= $item->pegarId() ?></td>
                                        <td><?= $item->pegarNome() ?></td>
                                        <td><?= formatarCpf($item->pegarCpf()) ?></td>
                                        <td><?= $item->pegarEmail() ?></td>
                                        <td><?= formatarNumero($item->pegarCelular()) ?></td>
                                        <td><?= formatarNumero($item->pegarTelefone()) ?></td>
                                        <td class="table-permissao" id="<?= $item->pegarPermissao() == '' ? 'comum' : $item->pegarPermissao() ?>">
                                            <p><?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?></p>
                                        </td>
                                        <td class="table-buttons">
                                            <a class="btn" title="editar <?= $item->pegarNome() ?>" href="/php/cliente/editar_usuario.php?edit=<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/edit.svg">
                                            </a>
                                            <a class="btn secondary" title="excluir <?= $item->pegarNome() ?>" id="excluirUsuario" data-id="<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/trash.svg">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="result-null">
                        Nenhum usuário encontrado
                    </div>
                    <?php if (count($lista) > $qtdUsuarios) : ?>
                        <div class="list-users-pagination">
                            <ul>
                                <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                    <li>
                                        <button type="button" class="page-link <?= $i == 1 ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </button>
                                    </li>
                                <?php endfor ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <div class="modal-exclude"></div>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/busca-usuario-db.js"></script>
    <script src="/assets/js/lista-usuarios.js"></script>
</body>

</html>

<style>

</style>