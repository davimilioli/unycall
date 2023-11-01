<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];
$permissao = $_SESSION['permissao'];

if ($permissao  != 'administrador') {
    header('location: /php/cliente/cliente.php?erroPermissao=true');
    exit;
}

$idExclude = filter_input(INPUT_GET, 'exclude');

if ($idExclude) {
    $sistema->deletarDados($idExclude);
    header('location: /php/cliente/lista_usuarios.php');
    exit;
}
