<?php

require_once(__DIR__ . '/includes/header.php');
require_once(__DIR__ . '/config/config_db.php');
require_once(__DIR__ . '/modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);
