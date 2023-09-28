<?php

$id = filter_input(INPUT_GET, 'id');
require_once(__DIR__ . '../../Sistema.php');
$sistema = new Sistema($pdo);

if ($id) {
    $sistema->deletarDados($id);
    header('location: ../lista_usuarios.php');
    exit;
}
