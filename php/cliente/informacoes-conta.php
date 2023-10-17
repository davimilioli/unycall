<?php
require_once('../config/config_db.php');
require_once('../autoload.php');
require_once(__DIR__ . '../modulos/modulos.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    session_name('usuario');
}

session_start();

$dados = $sistema->procurarIdUsuario($_GET['id']);
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

<body>
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
                            <div><?= formatarCpf($usuario['cpf']) ?></div>
                        </div>
                        <div class="info-block">
                            <p>Email</p>
                            <div><?= $usuario['email'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Telefone para contato</p>
                            <div><?= formatarNumero($usuario['celular']) ?></div>
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
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/lista-usuarios.js"></script>
</body>

</html>