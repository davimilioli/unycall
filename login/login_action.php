<?php

session_start();

require_once(__DIR__ . '/../config/config_db.php');
require_once(__DIR__ . '/../modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);

$tipoLogin = filter_input(INPUT_POST, 'tipoLogin');
$login = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');

if ($login && $senha && $tipoLogin) {
    $consultarDados = $usuarioSql->consultarDadosLogin($login, $senha, $tipoLogin);
    if (isset($consultarDados['resposta']) && $consultarDados['resposta']) {

        if ($tipoLogin == 'administrador') {

            if ($consultarDados['permissao'] == 'administrador') {
                $_SESSION['administrador'] = $login;
                echo 'ademar logado';

                header('Location: ../cliente/cliente.php?id=' . $consultarDados['id']);
                exit;
            } else {
                echo 'usuariozinho comum tentou entrar!!!';
                header('Location: login.php?erroPermissao=true');
                exit;
            }
        } elseif ($tipoLogin == 'normal') {

            if ($consultarDados['permissao'] == null) {
                $_SESSION['usuario'] = $login;
                echo 'usuariozinho logado';
                header('Location: ../cliente/dois_fatores.php?id=' . $consultarDados['id']);
                exit;
            }
        } else {
            echo 'login ou senha falsos';
            header('location: login.php?erroLogin=true');
            exit;
        }
    } else {
        echo 'dados invalidos';
        header('location: login.php?erroLogin=true');
        exit;
    }
}else {
    echo 'dados invalidos';
    header('location: login.php?erroLogin=true');
    exit;
}
