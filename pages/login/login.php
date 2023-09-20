<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/css/style.css">
    <title>Login</title>
</head>

<body>
    <section class="page-cadastro">
        <div class="cadastro-content">
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content">
                        <div class="spinner-one">
                            <div class="spinner-two"></div>
                        </div>
                        <p class="loading-message">aaaa</p>
                    </div>
                </div>
                <div class="logo">
                    <div class="logo-content"></div>
                </div>
                <div class="form-title">
                    <h1>Login</h1>
                    <p>Preencha os campos abaixo para ter acesso ao nosso sistema</p>
                </div>
                <form method="POST" action="login.php" class="form">
                    <div class="form-category">
                        <h2>Fazer login</h2>
                        <div class="form-group">
                            <label for="login">Nome <span>*</span></label>
                            <input type="text" name="login" id="login" minlength="6" maxlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha <span>*</span></label>
                            <input type="text" name="senha" id="senha" required>
                        </div>
                    </div>
                    <input type="submit" value="Entrar" class="btn" class="enviarForm">
                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
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
    <!--     <section class="page-login">
        <div class="form-content">
            <form class="form">
                <div class="form-group">
                    <label>Login</label>
                    <input type="text" name="login" id="">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="text" name="senha" id="">
                </div>
                <div class="buttons-form">
                    <input type="submit" value="Cadastrar" class="btn" class="enviarForm">
                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                </div>
            </form>
        </div>
    </section> -->
</body>

</html>