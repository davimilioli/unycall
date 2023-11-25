<?php
require_once(__DIR__ . '/../../config.php');
session_start();
session_destroy();
header('location:' . CAMINHO_PADRAO . '/php/login/login.php');
exit;
