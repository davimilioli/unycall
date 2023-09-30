<?php

require_once(__DIR__ . '../../Sistema.php');

$sistema = new Sistema($pdo);

$id = filter_input(INPUT_POST, 'id');
$slug = filter_input(INPUT_POST, 'slug');
$resposta = filter_input(INPUT_POST, 'resposta');

/* echo 'ID: ' . $id;
echo '<hr>';
echo 'Slug: ' . $slug;
echo '<hr>';
echo 'RESPOSTA: ' . $resposta; */

if ($id && $slug && $resposta) {
    $sistema->consultarResposta($id, $slug, $resposta);

    if ($sistema->consultarResposta($id, $slug, $resposta)) {
        header('location: ../cliente.php');
        exit;
    } else {
        header('location: dois_fatores.php?id=' . $id . '&erro=true');
        exit;
    }
}
