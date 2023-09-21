<?php

session_start();

require_once(__DIR__ . '/../../config/config_db.php');
require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);
$id = filter_input(INPUT_POST, 'id');
$categoria = filter_input(INPUT_POST, 'categoria');
$resposta = filter_input(INPUT_POST, 'resposta');

if ($id && $categoria && $resposta) {
    $resultado = $usuarioSql->doisFatores($id, $resposta, $categoria);
    if ($resultado == true) {
        echo 'verificado';
    } else {
        echo 'não verificado';
    }
}
