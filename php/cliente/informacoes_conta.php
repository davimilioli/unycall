<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$id = $_SESSION['id'];
$modulos = new Modulos();

$dados = $sistema->procurarIdUsuario($id);
$usuario = $dados['usuario'];
$endereco = $dados['endereco'];

if (isset($id, $_POST['nome'], $_POST['nascimento'], $_POST['cpf'], $_POST['nomeMaterno'], $_POST['email'], $_POST['sexo'], $_POST['celular'], $_POST['telefone'])) {
    $nome = $_POST['nome'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['cpf'];
    $nomeMaterno = $_POST['nomeMaterno'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'];
    $permissao = $usuario['permissao'] == 'administrador' ? $usuario['permissao'] : '';

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
        'login' => $usuario['login'],
        'permissao' => $permissao
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

    header('location: /php/cliente/informacoes_conta.php');
    exit;
}

$erro = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];

    $sistema->enviarAlteracaoLogin($login, $id);

    if (isset($_POST['senhaAtual'], $_POST['senhaNova'], /* $_POST['senhaConfirmar'] */)) {
        $senhaAtual = $_POST['senhaAtual'];
        $senhaNova = $_POST['senhaNova'];
        /*         $senhaConfirmar = $_POST['senhaConfirmar']; */
        $senha = array(
            'id' => $id,
            'senhaAtual' => $senhaAtual,
            'senhaNova' => $senhaNova,
            /* 'senhaConfirmar' => $senhaConfirmar */
        );
        if ($sistema->verificarSenhaConta($senha)) {
            $good = 'Senha atualizada';
        } else {
            $erro = 'Senha incorreta';
        }
    }
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
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-info">
            <div class="page-cliente-info-content">
                <div class="content-title">
                    <h2 class="page-cliente-info-title">Informações de conta</h2>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Informações pessoais</h3>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block-sub-header">
                            <p>As informações fornecidas abaixo são seus dados resumidos</p>
                        </div>
                        <div class="info-block">
                            <p>Nome</p>
                            <div><?= $usuario['nome'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Cpf</p>
                            <div><?= $modulos->formatarCpf($usuario['cpf']) ?></div>
                        </div>
                        <div class="info-block">
                            <p>Email</p>
                            <div><?= $usuario['email'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Telefone para contato</p>
                            <div><?= $modulos->formatarNumero($usuario['celular']) ?></div>
                        </div>
                        <div class="info-block action">
                            <button href="#" class="btn" id="abrirModalPessoal">Editar</button>
                        </div>
                    </div>
                    <div class="view-modal-personal">
                        <div class="view-modal-personal-content">
                            <div class="personal-modal-header">
                                <h2>Editar informações pessoais</h2>
                                <button id="fecharModalPessoal">X</button>
                            </div>
                            <div class="personal-modal-body">
                                <div class="modal-body-content">
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
                                            </div>
                                            <div class="personal-modal-footer">
                                                <button class="btn">Atualizar dados</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Configurações da conta</h3>
                    </div>
                    <div class="info-block-sub-header">
                        <p>A Unycall não tem acesso ao seus dados de usuário</p>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block">
                            <p>Login</p>
                            <div><?= $usuario['login'] ?></div>
                        </div>
                        <div class="info-block">
                            <p>Senha</p>
                            <div>******</div>
                        </div>
                        <div class="info-block action">
                            <button href="#" class="btn" id="abrirModalLogin">Editar</button>
                        </div>
                    </div>
                    <div class="view-modal-login <?= (isset($erro) && $erro != null) ? 'active' : '' ?>">
                        <div class=" view-modal-login-content">
                            <div class="login-modal-header">
                                <h2>Editar Configurações da conta</h2>
                                <button id="fecharModalLogin">X</button>
                            </div>
                            <div class="login-modal-body">
                                <div class="modal-body-content">
                                    <div class="form-content">
                                        <form method="POST" class="form">
                                            <div class="form-container">
                                                <div class="form-category">
                                                    <h2>Login</h2>
                                                    <div class="form-group">
                                                        <label for="login">Login </label>
                                                        <input type="text" id="login" name="login" value="<?= $usuario['login'] ?>">
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="senha">Senha atual</label>
                                                        <input type="password" name="senhaAtual" id="senhaAtual">
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="senha">Senha nova</label>
                                                        <input type="password" name="senhaNova" id="senhaNova">
                                                    </div>
                                                    <!--                                                     <div class=" form-group">
                                                        <label for="senha">Confirmar senha nova</label>
                                                        <input type="text" name="senhaConfirmar" id="senhaConfirmar">
                                                    </div> -->
                                                </div>
                                                <?php if (isset($erro) && $erro != null) :  ?>
                                                    <div class="message error">
                                                        <p>
                                                            <img src="/assets/img/icons/danger.svg"><?= $erro ?>
                                                        </p>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                            <div class="login-modal-footer">
                                                <button class="btn">Atualizar login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($good) && $good != null) :  ?>
                        <div class="message good active">
                            <p>
                                <img src="/assets/img/icons/danger.svg"><?= $good ?>
                            </p>
                        </div>
                    <?php endif ?>
                </div>
                <div class="page-cliente-info-block">
                    <div class="info-block-header">
                        <h3>Excluir conta</h3>
                    </div>
                    <div class="info-block-content">
                        <div class="info-block action">
                            <a href="#" class="btn">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/informacoes-conta.js"></script>
</body>

</html>