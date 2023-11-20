<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$modulos = new Modulos();

$idAdm = $_SESSION['id'];
$permissao = $_SESSION['permissao'];

if ($permissao != 'administrador') {
    header('location: /php/cliente/cliente.php?erroPermissao=true');
    exit;
}

$id = filter_input(INPUT_GET, 'edit');

if ($id) {
    $dados = $sistema->procurarIdUsuario($id);
    $usuario = $dados['usuario'];
    $endereco = $dados['endereco'];
}

if (isset($id, $_POST['nome'], $_POST['nascimento'], $_POST['cpf'], $_POST['nomeMaterno'], $_POST['email'], $_POST['sexo'], $_POST['celular'], $_POST['telefone'], $_POST['login'])) {
    $nome = $_POST['nome'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['cpf'];
    $nomeMaterno = $_POST['nomeMaterno'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'];
    $login = $_POST['login'];
    $permissao = $_POST['permissao'];

    $dadosUsuario = array(
        'id' => $id,
        'nome' => $nome,
        'nascimento' => $nascimento,
        'cpf' => $cpf,
        'nomematerno' => $nomeMaterno,
        'email' => $email,
        'sexo' => $sexo,
        'celular' => $celular,
        'telefone' => $telefone,
        'login' => $login,
        'permissao' => $permissao ?? null
    );

    $sistema->atualizarDadosUsuario($dadosUsuario, $usuarioSql = null);

    if (isset($_POST['cep'], $_POST['endereco'], $_POST['numend'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'])) {

        $cep = $_POST['cep'];
        $logradouro = $_POST['endereco'];
        $numero = $_POST['numend'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $complemento = $_POST['complemento'];

        $dadosEndereco = array(
            'id_usuario' => $id,
            'cep' => str_replace('-', '', $cep),
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'complemento' => $complemento ?? null
        );
        $sistema->atualizarDadosEndereco($dadosEndereco, $usuarioSql);
    }

    header('location: /php/cliente/lista_usuarios.php');
    exit;
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

<body class="system">
    <?php require_once(__DIR__ . '/layout/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/aside.php'); ?>
        <main class="page-cliente-editar">
            <div class="category-title">
                <h4>Editar Usuario</h4>
                <p>ID: <?= $usuario['id'] ?></p>
            </div>
            <div class="form-content">
                <form method="POST" class="form">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <input type="hidden" name="nome" value="<?= $usuario['nome'] ?>">
                    <input type="hidden" name="nascimento" value="<?= $usuario['nascimento'] ?>">
                    <input type="hidden" name="cpf" value="<?= $usuario['cpf'] ?>">
                    <input type="hidden" name="sexo" value="<?= $usuario['sexo'] ?>">
                    <input type="hidden" name="nomeMaterno" value="<?= $usuario['nomematerno'] ?>">

                    <div class="form-container">
                        <div class="form-category">
                            <h2>Dados pessoais</h2>
                            <div class="form-group">
                                <label for="nome">Nome </label>
                                <input type="text" id="nome" value="<?= $usuario['nome'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="data-nascimento">Data de Nascimento </label>
                                <input type="text" id="data-nascimento" value="<?= $modulos->formatarNascimento($usuario['nascimento']) ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF </label>
                                <input type="text" id="cpf" value="<?= $modulos->formatarCpf($usuario['cpf']) ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nomeMaterno">Nome Materno </label>
                                <input type="text" id="nomeMaterno" value="<?= $usuario['nomematerno'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="<?= $usuario['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="sexo">Sexo </label>
                                <input type="text" value="<?= $usuario['sexo'] ?>" disabled>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="celular">Celular </label>
                                    <input type="text" name="celular" id="celular" value="<?= $modulos->formatarNumero($usuario['celular']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone </label>
                                    <input type="text" name="telefone" id="telefone" value="<?= $modulos->formatarNumero($usuario['telefone']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-category endereco">
                            <h2>Endereço</h2>
                            <div class="form-group">
                                <label for="cep">Cep </label>
                                <input type="text" name="cep" id="cep" value="<?= $endereco['cep'] ?>">
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
                                <label for="login">Login </label>
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
                        <a class="btn secondary" id="excluirUsuario" data-id-adm="<?= $idAdm ?>" data-id="<?= $usuario['id'] ?>">Excluir</a>
                    </div>
                </form>
                <div class="modal-exclude"></div>
            </div>
        </main>
    </div>
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/lista-usuarios.js"></script>
    <script src="/assets/js/cadastro-form.js"></script>
</body>

</html>