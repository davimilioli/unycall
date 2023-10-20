<?php
require_once('../../config/config_db.php');
require_once('../../autoload.php');
$sistema = new Sistema($pdo);

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
    $sistema->consultarResposta($slug, $resposta, $id);

    if ($sistema->consultarResposta($slug, $resposta, $id)) {
        header('location: ../cliente.php?id=' . $id);
    } else {
        header('location: ../dois_fatores.php?id=' . $id . '&erro=true');
        exit;
    }
}
