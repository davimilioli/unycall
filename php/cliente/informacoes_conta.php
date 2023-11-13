<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$sistema->verificarPermissao();
$id = $_SESSION['id'];

$dados = $sistema->procurarIdUsuario($id);
$usuario = $dados['usuario'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Editor de Usuário</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-info">
            <div class="page-cliente-info-content">
                <div class="content-title">
                    <h2 class="page-cliente-info-title">Informações de conta</h2>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Informações pessoais</h3>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block-sub-header">
                            <p>As informações fornecidas abaixo são seus dados resumidos</p>
                        </div>
                        <div class="info-block">
                            <p>Nome</p>
                            <div><?= $usuario['nome'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Cpf</p>
                            <div><?= $usuario['cpf'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Email</p>
                            <div><?= $usuario['email'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Telefone para contato</p>
                            <div><?= $usuario['celular'] ?></div>
                        </div>
                        <div class="info-block action">
                            <a href="#" class="btn">Editar</a>
                        </div>
                    </div>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Configurações da conta</h3>
                    </div>
                    <div class="info-block-sub-header">
                        <p>A Unycall não tem acesso ao seus dados de usuário</p>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block">
                            <p>Login</p>
                            <div><?= $usuario['login'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Senha</p>
                            <div>******</div>
                        </div>
                        <div class="info-block action">
                            <a href="#" class="btn">Editar</a>
                        </div>
                    </div>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Excluir conta</h3>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block action">
                            <a href="#" class="btn">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/lista-usuarios.js"></script>
</body>

</html>