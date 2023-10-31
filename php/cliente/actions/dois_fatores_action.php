<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDados();
$sistema = new Sistema($banco->pegarPdo());

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
        header('location: /php/cliente/cliente.php');
        exit;
    } else {
        header('location: ../dois_fatores.php?erro=true');
        exit;
    }
}
