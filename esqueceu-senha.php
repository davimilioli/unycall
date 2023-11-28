<?php
session_start();
require_once('autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$pegarPergunta = $sistema->pegarPergunta();
$erro = '';

$dadosUsuario = false;
if (isset($_POST['login'], $_POST['email'])) {
    $usuario = $_POST['login'];
    $email = $_POST['email'];
    $consulta = $sistema->esqueceuSenha($usuario, $email);
    if ($consulta) {
        $_SESSION['id'] = $consulta;
        $dadosUsuario = true;
    } else {
        $erro = 'Login ou Email inválidos';
    }
}

$respostaPergunta = false;
if (isset($_POST['slug'], $_POST['resposta'])) {
    $id = $_SESSION['id'];
    $slug = $_POST['slug'];
    $resposta =  $_POST['resposta'];
    $consultarResposta = $sistema->consultarResposta($id, $slug, $resposta);
    if ($consultarResposta) {
        $dadosUsuario = false;
        $respostaPergunta = true;
    } else {
        $dadosUsuario = true;
        $erro = 'Resposta errada, tente novamente';
    }
}

$respostaSenha = false;
if (isset($_POST['senha'], $_POST['confirmarSenha'])) {
    $confirmarSenha = $_POST['confirmarSenha'];
    $senha = $_POST['senha'];
    if ($senha == $confirmarSenha) {
        $id = $_SESSION['id'];
        $sistema->receberSenha($id, $senha);
        header('location:' . CAMINHO_PADRAO . '/login.php');
        exit;
    } else {
        $respostaPergunta = true;
        $erro = 'senha não iguais';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Recuperar Conta</title>
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
</head>

<body style="overflow: hidden;">
    <header class="header">
        <div class="logo">
            <a href="<?= CAMINHO_PADRAO ?>/"><img src="<?= CAMINHO_PADRAO ?>/assets/img/logo.png" alt="Logo UnyCall"></a>
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <!-- <li class="menu-list-item"><a href="#">Sobre</a></li> -->
                <li class="menu-list-item"><a href="../../servicos.html">Serviços</a></li>
                <li class="menu-list-item"><a href="../../contato.html">Contato</a></li>
            </ul>
            <div class="header-actions">
                <a class="btn secondary" href="<?= CAMINHO_PADRAO ?>/cadastro.php">Cadastrar-se</a>
                <a class="btn" href="<?= CAMINHO_PADRAO ?>/login.php">Login</a>
            </div>
        </nav>
        <button type="button" class="menu-mobile">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
    <main class="page-dois-fatores">
        <div class="form-panel">
            <div class="form-content">
                <form method="POST" class="form" style=" display: <?= $dadosUsuario == true || $respostaPergunta == true ? 'none' : 'block' ?>">
                    <input type="hidden" name="tipo" value="dados">
                    <h3>Preencha os campos abaixo</h3>
                    <div class="form-group">
                        <label for="login">Login <span>*</span></label>
                        <input type="text" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="form-buttons">
                        <div class="form-actions">
                            <input type="submit" value="Enviar" class="btn" id="cadastrar">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        </div>
                    </div>
                    <?php if (isset($erro) && $erro) :  ?>
                        <div class="message error">
                            <p>
                                <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
                            </p>
                        </div>
                    <?php endif ?>
                </form>

                <?php if ($dadosUsuario) : ?>
                    <form method="POST" class="form">
                        <input type="hidden" name="tipo" value="resposta">
                        <input type="hidden" name="slug" value="<?= $pegarPergunta['slug'] ?>">
                        <h3><?= $pegarPergunta['pergunta'] ?></h3>
                        <div class="form-group">
                            <input type="text" name="resposta" required>
                        </div>
                        <div class="form-buttons">
                            <div class="form-actions">
                                <input type="submit" value="Enviar" class="btn" id="cadastrar">
                                <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                            </div>
                        </div>
                        <?php if (isset($erro) && $erro) :  ?>
                            <div class="message error">
                                <p>
                                    <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
                                </p>
                            </div>
                        <?php endif ?>
                    </form>
                <?php endif ?>

                <?php if ($respostaPergunta) : ?>
                    <form method="POST" class="form">
                        <input type="hidden" name="tipo" value="dados">
                        <h3>Alterar senha</h3>
                        <div class="form-group">
                            <label for="senha">Senha <span>*</span></label>
                            <input type="password" name="senha" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmarSenha">Confimar senha <span>*</span></label>
                            <input type="password" name="confirmarSenha" required>
                        </div>

                        <div class="form-buttons">
                            <div class="form-actions">
                                <input type="submit" value="Enviar" class="btn" id="cadastrar">
                                <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                            </div>
                        </div>
                        <?php if (isset($erro) && $erro) :  ?>
                            <div class="message error">
                                <p>
                                    <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
                                </p>
                            </div>
                        <?php endif ?>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </main>
</body>

</html>