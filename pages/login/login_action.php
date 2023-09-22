<?php

session_start();

require_once(__DIR__ . '/../../config/config_db.php');
require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);

$login = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');

if ($login && $senha) {
    $consultarDados = $usuarioSql->consultarDadosLogin($login, $senha);
    if ($consultarDados['resposta'] === true) {
        $_SESSION['usuario'] = $login;
        echo 'fununciou';

        header('location: ../cliente/cliente.php?id=' . $consultarDados['id']);
        exit;
    } else {
        header('location: login.php?erroLogin=true');
        exit;
    }
}
