<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="././assets/img/favicon.ico" type="image/x-icon">
    <title><?= APP_NAME ?> - Contato</title>
    <link rel="stylesheet" href="./assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/header.php'); ?>
    <main class="page-contato">
        <section class="contato-header">
            <div class="contato-header-content container">
                <div class="contato-header-description">
                    <h1>Menos ligações, mais suporte</h1>
                    <p> Na Unycall, você não fica na linha ouvindo aquela musiquinha chata esperando seu atendimento.
                        Isso porque acreditamos que chat e outros meios de comunicação na internet podem resolver
                        problemas de forma mais eficaz. </p>
                </div>
                <div class="contato-header-image">
                    <img src="./assets/img/undraw_personal_information_re_vw8a.svg" alt="">
                </div>
            </div>
        </section>
        <section class="cards">
            <div class="cards-content container">
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Escritório no Brasil</h3>
                    </div>
                    <div class="cards-item-body">
                        <ul class="list-content">
                            <li>
                                <a href="tel:+5521999999999"><img src="./assets/img/icons/phone.svg">+55 (21)
                                    99473-4975</a>
                            </li>
                            <li>
                                <a href="tel:+5521999999999"><img src="./assets/img/icons/phone.svg">+55 (21)
                                    2478-9773</a>
                            </li>
                            <li>
                                <a href="tel:+5521999999999">Rua Oswaldo Santos, 277 - Rio de Janeiro, Rj -
                                    21444-333</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Escritório no Canadá</h3>
                    </div>
                    <div class="cards-item-body">
                        <div class="cards-item-body">
                            <ul class="list-content">
                                <li>
                                    <a href="tel:+5521999999999"><img src="./assets/img/icons/phone.svg">+1 (438)
                                        558-7918</a>
                                </li>
                                <li>
                                    <a href="tel:+5521999999999"><img src="./assets/img/icons/phone.svg">+1 (438)
                                        738-2482</a>
                                </li>
                                <li>
                                    <a href="tel:+5521999999999">Vancouver, Colúmbia Britânica, 277 </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Nossas Redes Socias</h3>
                    </div>
                    <div class="cards-item-body">
                        <ul class="list-content contact">
                            <li>
                                <a href="#"><img src="./assets/img/icons/linkedin.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="./assets/img/icons/instagram.png" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="./assets/img/icons/facebook.png" alt=""></a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </section>
        <section class="page-contato-form container">
            <div class="form-content">
                <form method="POST" class="form">
                    <div class="form-category">
                        <h2>Preencha os campos abaixo</h2>
                        <p>Preencha o formulário abaixo que um de nossos especialistas entrará em contato com você.</p>
                        <div class="form-group">
                            <label for="nome">Nome <span>*</span></label>
                            <input type="text" name="nome" id="nome" minlength="15" maxlength="80" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF <span>*</span></label>
                            <input type="text" name="cpf" id="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <textarea name="mensagem" id="mensagem" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <p>Ao enviar o formulario, aceito a <a href="#">Política de Privacidade</a></p>
                        <div class="form-actions">
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                            <input type="submit" value="Enviar" class="btn" id="cadastrar">
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </main>
    <?php require_once(__DIR__ . '/layout/footer.php'); ?>
    <script src="/unycall/assets/js/home.js"></script>
</body>

</html>