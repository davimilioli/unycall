<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$sistema->verificarPermissao();
$gerenciador = new Gerenciador($banco->pegarPdo());
$id = $_SESSION['id'];

$lista = $gerenciador->servicosDisponiveis();

if (isset($_POST['exclude'])) {
    $idExclude = $_POST['exclude'];
    $gerenciador->enviarExclusaoServico($idExclude);

    header('location:' . CAMINHO_PADRAO . '/sistema/assinatura/lista-servicos.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Lista de Serviços</title>
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '../../layout/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '../../layout/aside.php'); ?>
        <main class="page-cliente-usuarios">
            <div class="category-title">
                <h4>Lista de Serviços</h4>
            </div>
            <section class="list-users">
                <div class="list-users-content">
                    <div class="list-users-title">
                        <h2 class="list-users-count">Total de registros (<?= count($lista) ?>)</h2>
                        <div class="list-users-actions">
                            <a href="adicionar-servico.php" class="btn">
                                <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/plus.svg">
                                Adicionar Serviço
                            </a>
                        </div>
                    </div>
                    <div class="list-users-table-content">
                        <table class="list-users-table">
                            <thead>
                                <tr>
                                    <th class="table-id">#</th>
                                    <th>Tipo</th>
                                    <th>Nome</th>
                                    <th>Disp. de Região</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista as $servico) : ?>
                                    <tr>
                                        <td class="table-id"><?= $servico['id'] ?></td>
                                        <td><?= $servico['tipo'] ?></td>
                                        <td><?= $servico['nome'] ?></td>
                                        <td><?= $servico['disp_regiao'] ?></td>
                                        <td>R$ <?= $servico['custo'] ?></td>
                                        <td class="table-permissao" id="<?= $servico['status'] == 1 ? 'administrador' : 'comum' ?>">
                                            <p><?= $servico['status'] == 1 ? 'Ativo' : 'Inativo' ?></p>
                                        </td>
                                        <td class="table-buttons">
                                            <a class="btn" href="<?= CAMINHO_PADRAO ?>/sistema/assinatura/editar-servico.php?edit=<?= $servico['id'] ?>">
                                                <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/edit.svg">
                                            </a>
                                            <a class="btn secondary" id="excluirServico" data-id="<?= $servico['id'] ?>">
                                                <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/trash.svg">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-exclude"></div>
                </div>
            </section>
        </main>
    </div>
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/servico.js"></script>
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/cliente.js"></script>
</body>

</html>

<style>

</style>