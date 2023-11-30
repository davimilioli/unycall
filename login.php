<?php
session_start();
require_once('autoload.php');
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
    if (!empty($validarLogin)) {
        $erro = $validarLogin;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
    <title>Unycall - Login</title>
</head>

<body>
    <?php require_once(__DIR__ . '/layout/header.php'); ?>
    <section class="page-form">
        <div class="form-panel">
            <div class="form-content">
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
                            <button type="submit" class="btn login" class="enviarForm" id="entrar">
                                Entrar
                            </button>
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary login">
                        </div>
                    </div>
                </form>
                <a href="esqueceu-senha.php" class="text-password">Esqueci minha senha</a></p>
                <?php if (isset($erro) && $erro != null) :  ?>
                    <div class="message error">
                        <p>
                            <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"> <?= $erro ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if (isset($_GET['erroSistema'])) :  ?>
                    <div class="message error">
                        <p>
                            <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
                        </p>
                    </div>
                <?php endif ?>
            </div>
        </div>
        </div>
    </section>
    <?php require_once(__DIR__ . '/layout/footer.php'); ?>
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/login-form.js"></script>
</body>

</html>