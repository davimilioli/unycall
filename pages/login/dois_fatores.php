<?php
/* session_start(); */
if (isset($_GET['id'])) {
    $id =  $_GET['id'];

    function gerarFrase()
    {
        $frases = array(
            'nomeMaterno' => 'Qual o nome da sua mãe?',
            'nascimento' => 'Qual a data do seu nascimento?'
        );

        $chaveAleatoria = array_rand($frases);
        $fraseAleatoria = $frases[$chaveAleatoria];

        return array(
            'chave' => $chaveAleatoria,
            'frase' => $fraseAleatoria
        );
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/css/style.css">
    <title>Login</title>
</head>

<body>
    <section class="page-form">
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
                    <h1>Autenticação de 2 fatores</h1>
                </div>
                <form method="POST" action="dois_fatores_action.php" class="form">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="categoria" value="<?php echo gerarFrase()['frase'] == 'Qual o nome da sua mãe?' ? 'nomeMaterno' : 'nascimento' ?>">
                    <div class="form-category">
                        <h2><?php echo gerarFrase()['frase']; ?></h2>
                        <div class="form-group">
                            <input type="text" name="resposta" id="resposta" required>
                        </div>
                    </div>
                    <input type="submit" value="Entrar" class="btn" class="enviarForm">
                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                </form>
                <?php if (isset($_GET['erroSistema'])) :  ?>
                    <div class="message_error">
                        <p>É necessario logar</p>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>
</body>

</html>