<?php
if (isset($_GET['type']) && $_GET['type'] == 'usuario') {
    session_name('usuario');
}

session_start();

require_once(__DIR__ . '/Sistema.php');
$sistema = new Sistema($pdo);
$pegarPergunta = $sistema->pegarPergunta();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Dois Fatores</title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
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
                <form method="POST" action="./actions/dois_fatores_action.php?id=<?= $_GET['id'] ?>" class="form">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
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
                    <?php if (isset($_GET['erro'])) :  ?>
                        <div class="message_error">
                            <p>
                                <img src="/assets/img/icons/danger.svg">Resposta errada, tente novamente!
                            </p>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </main>
</body>

</html>