<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/css/style.css">
    <title>Login</title>
</head>

<body style="overflow: hidden;">
    <?php require_once(__DIR__ . '../../includes/header.php'); ?>
    <section class="page-form">
        <div class="cadastro-content">
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
                    <p>Preencha os campos abaixo para ter acesso ao nosso sistema</p>
                    <p>Não possui cadastro? <a href="../cadastro/cadastro.php" class="form-link">Acesse aqui</a></p>
                </div>
                <form method="POST" class="form">
                    <input type="hidden" name="tipoLogin" value="normal">
                    <div class="form-category">
                        <h2>Fazer login como?</h2>
                        <div class="type-login">
                            <button type="button" id="usuario-normal" class="btn button-type">Usuario comum</button>
                            <button type="button" id="usuario-adm" class="btn secondary button-type">Administrador</button>
                        </div>
                        <div class="form-group">
                            <label for="login">Nome <span>*</span></label>
                            <input type="text" name="login" id="login" minlength="6" maxlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha <span>*</span></label>
                            <input type="text" name="senha" id="senha" required>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <div class="form-actions">
                            <input type="submit" value="Entrar" class="btn" class="enviarForm" id="entrar">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        </div>
                        <?php if (isset($_GET['erroLogin'])) :  ?>
                            <div class="message_error">
                                <p>
                                    <img src="/assets/img/icons/danger.svg">Usuario ou senha incorretos
                                </p>
                            </div>
                        <?php elseif (isset($_GET['erroSistema'])) :  ?>
                            <div class="message_error">
                                <p>
                                    <img src="/assets/img/icons/danger.svg">É necessário logar
                                </p>
                            </div>
                        <?php elseif (isset($_GET['erroPermissao'])) :  ?>
                            <div class="message_error">
                                <p>
                                    <img src="/assets/img/icons/danger.svg">Você não tem permissão
                                </p>
                            </div>
                        <?php endif ?>
                    </div>
                </form>
            </div>
            <div class="cadastro-description">
                <div class="cadastro-description-content">
                    <h1>Lorem ipsum dolor, sit amet consectetur adipisicx! Ipsa a ratione mollitia.</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicx! Ipsa a ratione mollitia.</p>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script src="../../assets/js/login-form.js"></script>
</body>

</html>