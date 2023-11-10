<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$verificar = $banco->verificarUsuarioExiste();
if ($verificar == false) {
    unset($verificar);
}

$sistema = new Sistema($banco->pegarPdo());
$erro = '';
if (isset($_POST['tipoLogin'], $_POST['login'], $_POST['senha'])) {

    $tipoLogin = $_POST['tipoLogin'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $validarLogin = $sistema->validarLogin($login, $senha, $tipoLogin);
    if(!empty($validarLogin)){
        $erro = $validarLogin;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/css/style.css">
    <title>Unycall - Login</title>
</head>

<body style="overflow: hidden;">
    <header class="header">
        <div class="logo">
            <a href="/index.html"><img src="/assets/img/logo.png" alt="Logo UnyCall"></a>
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <!-- <li class="menu-list-item"><a href="#">Sobre</a></li> -->
                <li class="menu-list-item"><a href="../../servicos.html">Serviços</a></li>
                <li class="menu-list-item"><a href="../../contato.html">Contato</a></li>
            </ul>
            <div class="header-actions">
                <a class="btn secondary" href="/php/cadastro/cadastro.php">Cadastrar-se</a>
                <a class="btn" href="/php/login/login.php">Login</a>
            </div>
        </nav>
        <button type="button" class="menu-mobile">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
    <section class="page-form">
        <div class="form-panel">
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content">
                        <div class="spinner-one">
                            <div class="spinner-two"></div>
                        </div>
                        <p class="loading-message">Validando Usuario</p>
                    </div>
                </div>
                <div class="form-title">
                    <h1>Login</h1>
                </div>
                <form method="POST" class="form">
                    <input type="hidden" name="tipoLogin" value="normal">
                    <div class="form-category">
                        <div class="type-login">
                            <button type="button" class="btn secondary button-type">Usuario comum</button>
                            <button type="button" class="btn secondary button-type">Administrador</button>
                        </div>
                        <div class="form-group">
                            <label for="login">Login <span>*</span></label>
                            <input type="text" name="login" id="login" minlength="2" maxlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha <span>*</span></label>
                            <input type="password" name="senha" id="senha" required>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <div class="form-actions">
                            <input type="submit" value="Entrar" class="btn" class="enviarForm" id="entrar">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        </div>
                    </div>
                </form>
                <a href="./esqueceu_senha.php" class="text-password">Esqueci minha senha</a></p>
                <?php if (isset($erro) && $erro != null) :  ?>
                    <div class="message_error">
                        <p>
                            <img src="/assets/img/icons/danger.svg"> <?= $erro ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if (isset($_GET['erroSistema'])) :  ?>
                    <div class="message_error">
                        <p>
                            <img src="/assets/img/icons/danger.svg">É necessário logar
                        </p>
                    </div>
                <?php endif ?>
            </div>
        </div>
        </div>
    </section>
    <script src="/assets/js/login-form.js"></script>
</body>

</html>