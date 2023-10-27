<?php
require_once('../../autoload.php');
$banco = new BancoDados();
$sistema = new Sistema($banco->pegarPdo());

session_name('usuario');
session_start();

$id = filter_input(INPUT_POST, 'id');
$slug = filter_input(INPUT_POST, 'slug');
$resposta = filter_input(INPUT_POST, 'resposta');
/* echo 'ID: ' . $id;
echo '<hr>';
echo 'Slug: ' . $slug;
echo '<hr>';
echo 'RESPOSTA: ' . $resposta; */

if ($id && $slug && $resposta) {
    $sistema->consultarResposta($id, $slug, $respost);

    if ($sistema->consultarResposta($id, $slug, $resposta)) {
        header('location: ../cliente.php?id=' . $id);
        exit;
    } else {
        header('location: ../dois_fatores.php?id=' . $id . '&erro=true');
        exit;
    }
}
