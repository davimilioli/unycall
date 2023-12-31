<?php
session_start();
require_once('autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];

$pegarPergunta = $sistema->pegarPergunta();
$erro = '';
if (isset($_POST['id'], $_POST['slug'], $_POST['resposta'])) {
    $id = $_POST['id'];
    $slug = $_POST['slug'];
    $resposta = $_POST['resposta'];
    $sistema = new Sistema($banco->pegarPdo());

    $sistema->consultarResposta($id, $slug, $resposta);
    if ($sistema->consultarResposta($id, $slug, $resposta)) {
        header('location:' . CAMINHO_PADRAO . '/sistema/sistema.php');
        exit;
    } else {
        $erro = 'Resposta incorreta, tente novamente!';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Dois Fatores</title>
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/header.php'); ?>
    <section class="page-dois-fatores">
        <div class="form-panel">
            <div class="form-content">
                <form method="POST" class="form">
                    <input type="hidden" name="id" value="<?= $id ?>">
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
                    <?php if (isset($erro) && $erro != null) :  ?>
                        <div class="message error">
                            <p>
                                <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
                            </p>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </section>
    <?php require_once(__DIR__ . '/layout/footer.php'); ?>
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/dois-fatores.js"></script>
</body>

</html>