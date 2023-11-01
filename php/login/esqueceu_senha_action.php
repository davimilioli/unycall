<?php
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$usuario = filter_input(INPUT_POST, 'usuario');
$email = filter_input(INPUT_POST, 'email');

if ($usuario && $email) {
    $consulta = $sistema->esqueceuSenha($usuario, $email);

    if ($consulta) {
        header('location: ./esqueceu_senha.php?id=' . $consulta . '&question=true');
        exit;
    } else {
        header('location: ./esqueceu_senha.php?dados=false');
        exit;
    }
}

$slug = filter_input(INPUT_POST, 'slug');
$resposta = filter_input(INPUT_POST, 'resposta');
$id = filter_input(INPUT_POST, 'id');

if ($slug && $resposta) {
    $consultarResposta = $sistema->consultarResposta($id, $slug, $resposta);
    if ($consultarResposta) {
        var_dump($consultarResposta);
        header('location: ./esqueceu_senha.php?id=' . $id . '&password=true');
        exit;
    } else {
        header('location: ./esqueceu_senha.php?id=' . $id . '&question=true&response=false');
        exit;
    }
}

$senha = filter_input(INPUT_POST, 'senha');
$confirmarSenha = filter_input(INPUT_POST, 'confirmarSenha');

if ($senha == $confirmarSenha) {
    $sistema->receberSenha($id, $senha);
    header('location: ./login.php');
    exit;
} else {
    header('location: ./esqueceu_senha.php?id=' . $id . '&samePasswords=false');
    exit;
}
