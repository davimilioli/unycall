<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDados();
$usuarioSql = new UsuarioMySql($banco->pegarPdo());

$tipoLogin = filter_input(INPUT_POST, 'tipoLogin');
$login = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');

if ($login && $senha && $tipoLogin) {
    $consultarDados = $usuarioSql->consultarDadosLogin($login, $senha, $tipoLogin);

    if ($consultarDados && $consultarDados['resposta']) {
        $_SESSION['id'] = $consultarDados['id'];
        $_SESSION['permissao'] = $consultarDados['permissao'];

        $permissao = $consultarDados['permissao'];

        if ($tipoLogin == 'administrador' && $permissao == 'administrador') {
            header('Location: /php/cliente/cliente.php');
            exit;
        } elseif ($tipoLogin == 'administrador' && $permissao != 'administrador') {
            header('Location: login.php?erroPermissao=true');
            exit;
        } elseif ($tipoLogin == 'normal' && is_null($permissao)) {
            header('Location: /php/cliente/dois_fatores.php');
            exit;
        } elseif ($tipoLogin == 'normal' && !is_null($permissao)) {
            header('Location: login.php?avisoAdm=true');
            exit;
        }
    } else {
        header('Location: login.php?erroLogin=true');
        exit;
    }
}
