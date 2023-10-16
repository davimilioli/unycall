<?php
require_once('../config/config_db.php');
require_once('../autoload.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    header('location: cliente.php?' . $_GET['id'] . 'erroPermissao=true');
    exit;
}

session_start();

$id = filter_input(INPUT_GET, 'edit');

if ($id) {
    $dados = $sistema->procurarIdUsuario($id);
    $usuario = $dados['usuario'];
    $endereco = $dados['endereco'];
    require_once(__DIR__ . '../modulos/modulos.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Editor de Usuário</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-editar">
            <div class="category-title">
                <h4>Editar Usuario</h4>
                <p>ID: <?= $usuario['id'] ?></p>
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
                <form method="POST" action="./actions/editar_action.php?id=<?= $_GET['id'] ?>" class="form">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <input type="hidden" name="nome" value="<?= $usuario['nome'] ?>">
                    <input type="hidden" name="nascimento" value="<?= $usuario['nascimento'] ?>">
                    <input type="hidden" name="cpf" value="<?= $usuario['cpf'] ?>">
                    <input type="hidden" name="sexo" value="<?= $usuario['sexo'] ?>">

                    <div class="form-container">
                        <div class="form-category">
                            <h2>Dados pessoais</h2>
                            <div class="form-group">
                                <label for="nome">Nome </label>
                                <input type="text" id="nome" value="<?= $usuario['nome'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="data-nascimento">Data de Nascimento </label>
                                <input type="text" id="data-nascimento" value="<?= formatarNascimento($usuario['nascimento']) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF </label>
                                <input type="text" id="cpf" value="<?= formatarCpf($usuario['cpf']) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nomeMaterno">Nome Materno </label>
                                <input type="text" name="nomeMaterno" id="nomeMaterno" value="<?= $usuario['nomematerno'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="<?= $usuario['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="sexo">Sexo </label>
                                <input type="text" value="<?= $usuario['sexo'] ?>" readonly>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="celular">Celular </label>
                                    <input type="text" name="celular" id="celular" value="<?= formatarNumero($usuario['celular']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone </label>
                                    <input type="text" name="telefone" id="telefone" value="<?= formatarNumero($usuario['telefone']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-category endereco">
                            <h2>Endereço</h2>
                            <div class="form-group">
                                <label for="cep">Cep </label>
                                <input type="text" name="cep" id="cep" value="<?= formatarCep($endereco['cep']) ?>">
                            </div>
                            <div class="inputs-group endereco">
                                <div class="form-group">
                                    <label for="endereco">Endereço </label>
                                    <input type="text" name="endereco" id="endereco" value="<?= $endereco['logradouro'] ?>">
                                </div>
                                <div class="form-group numero">
                                    <label for="numend">N° </label>
                                    <input type="text" name="numend" id="numend" value="<?= $endereco['numero'] ?>">
                                </div>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="bairro">Bairro </label>
                                    <input type="text" name="bairro" id="bairro" value="<?= $endereco['bairro'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cidade">Cidade </label>
                                    <input type="text" name="cidade" id="cidade" value="<?= $endereco['cidade'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado </label>
                                    <input type="text" id="estado" name="estado" value="<?= $endereco['estado'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" id="complemento" value="<?= $endereco['complemento'] ?>">
                            </div>
                        </div>
                        <div class="form-category">
                            <h2>Login</h2>
                            <div class="form-group">
                                <label for="login">Usuario </label>
                                <input type="text" name="login" id="login" value="<?= $usuario['login'] ?>">
                            </div>
                        </div>
                        <div class="form-category">
                            <h2>Permissão</h2>
                            <div class="form-group">
                                <label for="permissao">Permissão </label>
                                <select name="permissao" id="permissao">
                                    <option value="" <?= $usuario['permissao'] == 'null' ? 'selected' : '' ?>>Nenhuma</option>
                                    <option value="administrador" <?= $usuario['permissao'] == 'administrador' ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <input type="submit" value="Atualizar" class="btn" class="atualizarDados">
                        <a class="btn secondary" id="excluirUsuario" data-id-adm="<?= $_GET['id'] ?>" data-id="<?= $usuario['id'] ?>">Excluir</a>
                    </div>
                </form>
                <div class="modal-exclude"></div>
            </div>
        </main>
    </div>
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/lista-usuarios.js"></script>
</body>

</html>