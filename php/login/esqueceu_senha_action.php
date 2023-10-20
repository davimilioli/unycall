<?php
require_once('../config/config_db.php');
require_once('../autoload.php');
$sistema = new Sistema($pdo);

$usuario = filter_input(INPUT_POST, 'usuario');
$email = filter_input(INPUT_POST, 'email');
echo $usuario;
echo $email;

if ($usuario && $email) {
    $consulta = $sistema->esqueceuSenha($usuario, $email);

    if ($consulta) {
        header('location: ./esqueceu_senha.php?id=' . $consulta . '&success=true');
        exit;
    }
}

$slug = filter_input(INPUT_POST, 'slug');
$resposta = filter_input(INPUT_POST, 'resposta');

if ($slug && $resposta) {
    $id = filter_input(INPUT_POST, 'id');
    echo '<hr>';
    echo $slug;
    echo $resposta;
    echo '<hr>';
    echo $id;
    $sistema->consultarResposta($slug, $resposta);

    if ($sistema->consultarResposta($slug, $resposta)) {
        header('location: ./esqueceu_senha.php?id=' . $id . '&password=true');
        exit;
        echo 'resposta correta';
    } /* else {
        header('location: ../dois_fatores.php?id=' . $id . '&erro=true');
        exit;
    } */
}


$senha = filter_input(INPUT_POST, 'senha');
$confirmarSenha = filter_input(INPUT_POST, 'confirmarSenha');

if ($senha == $confirmarSenha) {
    $id = filter_input(INPUT_POST, 'id');
    $sistema->receberSenha($id, $senha);
} else {
}
