<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$sistema->verificarPermissao();
$id = $_SESSION['id'];

$tabelas = $banco->pegarPdo()->query("SHOW TABLES");

function tipoDado($tipo)
{
    $limparTipo = preg_replace('/\(\d+\)/', '', $tipo);
    $resultado = '';
    if ($limparTipo == 'int') {
        $resultado =  'Inteiro';
    } elseif ($limparTipo == 'varchar') {
        $resultado = 'Varchar';
    } elseif ($limparTipo == 'char') {
        $resultado = 'Char';
    } else if ($limparTipo == 'date') {
        $resultado = 'Data';
    } else {
        $resultado = 'Outro';
    }

    return $resultado;
}

function tamanhoDado($dado)
{
    $abertura = strpos($dado, '(');
    $fechadura = strpos($dado, ')');
    if ($abertura !== false && $fechadura !== false) {
        $tamanho = substr($dado, $abertura + 1, $fechadura - $abertura - 1);
    } else {
        $tamanho = '';
    }

    return $tamanho;
}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Modelo Banco de Dados</title>
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once('../layout/header.php'); ?>
    <div class="page-cliente">
        <?php require_once('../layout/aside.php'); ?>
        <main class="page-cliente-model-db">
            <div class="category-title">
                <h4>Banco de Dados</h4>
            </div>
            <div class="model-db-content">
                <?php foreach ($tabelas as $tabela) : ?>
                    <div class="table-db">
                        <?php $tabelaNome = $tabela['Tables_in_db_site']; ?>
                        <div class="table-db-title">
                            <h2><?= ucfirst($tabelaNome) ?></h2>
                        </div>
                        <table class="table-db-content">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Tamanho/Itens</th>
                                    <th>Permitir Nulo</th>
                                    <th>Chave</th>
                                    <th>Padrão</th>
                                    <th>Extras</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($banco->pegarPdo()->query("SHOW COLUMNS FROM $tabelaNome") as $coluna) : ?>
                                    <tr>
                                        <td><?= $coluna['Field'] ?></td>
                                        <td><?= tipoDado($coluna['Type']) ?></td>
                                        <td>
                                            <?php if (tamanhoDado($coluna['Type']) == '') : ?>
                                                Não possui
                                            <?php else : ?>
                                                <?= tamanhoDado($coluna['Type']) ?>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $coluna['Null'] == 'NO' ? 'Não' : 'Sim' ?></td>
                                        <td><?= $coluna['Key'] == 'PRI' ? 'Primária' : 'Não possui' ?></td>
                                        <td><?= $coluna['Default'] == '' ? 'Não Possui' : $coluna['Default'] ?></td>
                                        <td>
                                            <?php if ($coluna['Extra'] == '') : ?>
                                                Não possui
                                            <?php elseif ($coluna['Extra'] == 'auto_increment') : ?>
                                                Auto Increment
                                            <?php else : ?>
                                                <?= $coluna['Extra'] ?>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach ?>
            </div>
        </main>
    </div>
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/cliente.js"></script>
</body>