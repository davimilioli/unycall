<?php
require_once(__DIR__ . '/Sistema.php');

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">
    <title>Administração</title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-editar">
            <div class="category-title">
                <h4>Editar Usuario</h4>
            </div>
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content">
                        <div class="spinner-one">
                            <div class="spinner-two"></div>
                        </div>
                        <p class="loading-message">aaaa</p>
                    </div>
                </div>
                <form method="POST" action="cadastro_action.php" class="form">
                    <div class="form-container">
                        <div class="form-category">
                            <h2>Dados pessoais</h2>
                            <div class="form-group">
                                <label for="nome">Nome </label>
                                <input type="text" name="nome" id="nome">
                            </div>
                            <div class="form-group">
                                <label for="data-nascimento">Data de Nascimento </label>
                                <input type="text" name="nascimento" id="data-nascimento">
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF </label>
                                <input type="text" name="cpf" id="cpf">
                            </div>
                            <div class="form-group">
                                <label for="nomeMaterno">Nome Materno </label>
                                <input type="text" name="nomeMaterno" id="nomeMaterno">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="sexo">Sexo </label>
                                <input type="text" name="sexo" id="sexo">
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="celular">Celular </label>
                                    <input type="text" name="celular" id="celular">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone </label>
                                    <input type="text" name="telefone" id="telefone">
                                </div>
                            </div>
                        </div>
                        <div class="form-category endereco">
                            <h2>Endereço</h2>
                            <div class="form-group">
                                <label for="cep">Cep </label>
                                <input type="text" name="cep" id="cep">
                            </div>
                            <div class="inputs-group endereco">
                                <div class="form-group">
                                    <label for="endereco">Endereço </label>
                                    <input type="text" name="endereco" id="endereco">
                                </div>
                                <div class="form-group numero">
                                    <label for="numend">N° </label>
                                    <input type="text" name="numend" id="numend">
                                </div>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="bairro">Bairro </label>
                                    <input type="text" name="bairro" id="bairro">
                                </div>
                                <div class="form-group">
                                    <label for="cidade">Cidade </label>
                                    <input type="text" name="cidade" id="cidade">
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado </label>
                                    <input type="text" id="estado" name="estado">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" id="complemento">
                            </div>
                        </div>
                        <div class="form-category">
                            <h2>Login</h2>
                            <div class="form-group">
                                <label for="login">Usuario </label>
                                <input type="text" name="login" id="login">
                            </div>
                        </div>
                    </div>
                    <div class=" form-buttons">
                        <input type="submit" value="Atualizar" class="btn" class="atualizarDados">
                        <input type="reset" value="Excluir" id="excluirDados" class="btn secondary">
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>