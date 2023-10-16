<?php
require_once('../../config/config_db.php');
require '../../autoload.php';
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    /*   header('location: cliente.php?' . $_GET['id'] . 'erroPermissao=true');
    exit; */
}

session_start();

$idExclude = filter_input(INPUT_GET, 'exclude');

if ($idExclude) {
    $sistema->deletarDados($idExclude);
    header('location: ../lista_usuarios.php?id=' . $_GET['id']);
    exit;
}
