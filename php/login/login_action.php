<?php
require_once('../autoload.php');
$banco = new BancoDados();
$sistema = new Sistema($banco->pegarPdo());
$usuarioSql = new UsuarioMySql($banco->pegarPdo());

session_start();

$tipoLogin = filter_input(INPUT_POST, 'tipoLogin');
$login = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');
if ($login && $senha && $tipoLogin) {
    $consultarDados = $usuarioSql->consultarDadosLogin($login, $senha, $tipoLogin);
    if (isset($consultarDados['resposta']) && $consultarDados['resposta']) {

        if ($tipoLogin == 'administrador') {
            if ($consultarDados['permissao'] == 'administrador') {

                header('Location: ../cliente/cliente.php?id=' . $consultarDados['id']);
                exit;
            } else {
                header('Location: login.php?erroPermissao=true');
                exit;
            }
        } elseif ($tipoLogin == 'normal') {

            if ($consultarDados['permissao'] == null) {
                echo 'usuariozinho logado';
                header('Location: ../cliente/dois_fatores.php?id=' . $consultarDados['id']);
                exit;
            } else {
                header('Location: login.php?avisoAdm=true');
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
} else {
    echo 'dados invalidos';
    header('location: login.php?erroLogin=true');
    exit;
}
