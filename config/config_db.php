<?php
// CONFIG DB
$db_host = 'localhost';
$db_name = 'db_site';
$db_charset = 'utf8';
$db_user = 'root';
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
