<?php
require_once('../autoload.php');
$banco = new BancoDados();
$sistema = new Sistema($banco->pegarPdo());

session_name('usuario');
session_start();

$urlDados = !empty($_GET['dados']);
$urlSucesso = !empty($_GET['success']);
$senhaAprovada = !empty($_GET['password']);
$usuarioId = isset($_GET['id']) ? $_GET['id'] : '';
$urlPergunta = !empty($_GET['question']);
$urlResposta = !empty($_GET['response']);
$urlSenhasIguais = !empty($_GET['samePasswords']);
$pegarPergunta = $sistema->pegarPergunta();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Recuperar Conta</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body style="overflow: hidden;">
    <main class="page-dois-fatores">
        <div class="cadastro-content">
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content">
                        <div class="spinner-one">
                            <div class="spinner-two"></div>
                        </div>
                        <p class="loading-message"></p>
                    </div>
                </div>
                <form method="POST" action="./esqueceu_senha_action.php" class="form" style="display: <?= $urlPergunta == true || $senhaAprovada == true  || $urlSenhasIguais == true ? 'none' : 'block' ?>">
                    <input type="hidden" name="tipo" value="dados">
                    <h2>Preencha os campos abaixo</h2>
                    <div class="form-group">
                        <label for="usuario">Login <span>*</span></label>
                        <input type="text" name="usuario" required>
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
                    <?php if ($urlDados) :  ?>
                        <div class="message_error">
                            <p>
                                <img src="/assets/img/icons/danger.svg">Usuário ou Email inválidos
                            </p>
                        </div>
                    <?php endif ?>
                </form>
                <form method="POST" action="./esqueceu_senha_action.php?id=<?= $usuarioId ?>" class="form" style="display: <?= $urlPergunta == true ? 'block' : 'none' ?>">
                    <input type="hidden" name="id" value="<?= $usuarioId ?>">
                    <input type="hidden" name="tipo" value="resposta">
                    <input type="hidden" name="slug" value="<?= $pegarPergunta['slug'] ?>">
                    <h2><?= $pegarPergunta['pergunta'] ?></h2>
                    <div class="form-group">
                        <input type="text" name="resposta" required>
                    </div>

                    <div class="form-buttons">
                        <div class="form-actions">
                            <input type="submit" value="Enviar" class="btn" id="cadastrar">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        </div>
                    </div>
                    <?php if ($urlResposta) :  ?>
                        <div class="message_error">
                            <p>
                                <img src="/assets/img/icons/danger.svg">Resposta errada, tente novamente
                            </p>
                        </div>
                    <?php endif ?>
                </form>
                <form method="POST" action="./esqueceu_senha_action.php" class="form" style="display: <?= $urlSucesso == false && $senhaAprovada == true || $urlSenhasIguais == true ?  'block' : 'none' ?>">
                    <input type="hidden" name="id" value="<?= $usuarioId ?>">
                    <input type="hidden" name="tipo" value="dados">
                    <h2>Preencha os campos abaixo</h2>
                    <div class="form-group">
                        <label for="senha">Senha <span>*</span></label>
                        <input type="text" name="senha" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmarSenha">Confimar senha <span>*</span></label>
                        <input type="text" name="confirmarSenha" required>
                    </div>

                    <div class="form-buttons">
                        <div class="form-actions">
                            <input type="submit" value="Enviar" class="btn" id="cadastrar">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        </div>
                    </div>
                    <?php if ($urlSenhasIguais) :  ?>
                        <div class="message_error">
                            <p>
                                <img src="/assets/img/icons/danger.svg">Senhas não iguais
                            </p>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </main>
</body>

</html>