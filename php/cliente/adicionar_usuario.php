<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];
$permissao = $_SESSION['permissao'];

if ($permissao != 'administrador') {
    header('location: /php/cliente/cliente.php?erroPermissao=true');
    exit;
}

$sistema = new Sistema($banco->pegarPdo());
$erro = '';

if (isset($_POST['nome'], $_POST['nascimento'], $_POST['cpf'], $_POST['nomeMaterno'], $_POST['email'], $_POST['sexo'], $_POST['celular'], $_POST['telefone'], $_POST['loginCadastro'], $_POST['senhaCadastro'], $_POST['cep'], $_POST['endereco'], $_POST['numend'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'])) {
    $usuarioSql = new UsuarioMySql($banco->pegarPdo());
    $enderecoSql = new EnderecoMySql($banco->pegarPdo());

    $nome = $_POST['nome'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['cpf'];
    $nomeMaterno = $_POST['nomeMaterno'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'];
    $login = $_POST['loginCadastro'];
    $senha = $_POST['senhaCadastro'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['endereco'];
    $numero = $_POST['numend'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $complemento = $_POST['complemento'] ?? '';
    $permissao = $_POST['permissao'] ?? '';

    $validarCadastro = $sistema->validarCadastro(
        $nome, $nascimento, $cpf, $nomeMaterno, $email, $sexo, $celular, $telefone, $login, $senha,
        $cep, $logradouro, $numero, $bairro, $cidade, $estado, $complemento, $permissao
    );

    if ($validarCadastro === true) {
        header('location: /php/cliente/lista_usuarios.php');
        exit;
    } else {
        $erro = $validarCadastro;
    }
    

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Adicionar Usuário</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-editar">
            <div class="category-title">
                <h4>Adicionar Usuario</h4>
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
                <form method="POST" class="form">
                    <input type="hidden" name="adm" value="<?= $id ?>">
                    <div class="form-container">
                        <div class="form-category">
                            <h2>Dados pessoais</h2>
                            <div class="form-group">
                                <label for="nome">Nome <span>*</span></label>
                                <input type="text" name="nome" id="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="data-nascimento">Data de Nascimento <span>*</span></label>
                                <input type="text" name="nascimento" id="data-nascimento" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF <span>*</span></label>
                                <input type="text" name="cpf" id="cpf" maxlength="14" required>
                                <span class="message_notice cpf" style="display: none;">
                                    <img src="/assets/img/icons/danger-notice.svg" alt="">
                                    Cpf já existente
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="nomeMaterno">Nome Materno <span>*</span></label>
                                <input type="text" name="nomeMaterno" id="nomeMaterno" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="">Sexo <span>*</span></label>
                                <select name="sexo" required>
                                    <option value="" selected>Sexo</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="celular">Celular <span>*</span></label>
                                    <input type="text" name="celular" id="celular" required maxlength="17">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone <span>*</span></label>
                                    <input type="text" name="telefone" id="telefone" required maxlength="16">
                                </div>
                            </div>
                        </div>
                        <div class="form-category endereco">
                            <h2>Endereço</h2>
                            <div class="form-group">
                                <label for="cep">Cep <span>*</span></label>
                                <input type="text" name="cep" id="cep" required>
                            </div>
                            <div class="inputs-group endereco">
                                <div class="form-group">
                                    <label for="endereco">Endereço <span>*</span></label>
                                    <input type="text" name="endereco" id="endereco" required>
                                </div>
                                <div class="form-group numero">
                                    <label for="numend">N° <span>*</span></label>
                                    <input type="text" name="numend" id="numend" required>
                                </div>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="bairro">Bairro <span>*</span></label>
                                    <input type="text" name="bairro" id="bairro" required>
                                </div>
                                <div class="form-group">
                                    <label for="cidade">Cidade <span>*</span></label>
                                    <input type="text" name="cidade" id="cidade" required>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado <span>*</span></label>
                                    <select id="estado" name="estado" data-input-address required>
                                        <option selected value="">Estado</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
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
                                <label for="login">Usuario <span>*</span></label>
                                <input type="text" name="loginCadastro" id="login" minlength="6" maxlength="6" required>
                                <span class="message_notice login" style="display: none;">
                                    <img src="/assets/img/icons/danger-notice.svg" alt="">
                                    Login já existente
                                </span>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="senha">Senha <span>*</span></label>
                                    <input type="password" name="senhaCadastro" id="senha" minlength="8" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmar-senha">Confirmar senha <span>*</span></label>
                                    <input type="password" name="confirmar-senha" id="confirmar-senha" minlength="8" required>
                                </div>
                            </div>
                            <span class="message_notice senha" style="display: none;">
                                <img src="/assets/img/icons/danger-notice.svg" alt="">
                                Senhas não iguais
                            </span>
                        </div>
                        <div class="form-category">
                            <h2>Permissão</h2>
                            <div class="form-group">
                                <label for="permissao">Permissão </label>
                                <select name="permissao" id="permissao">
                                    <option value="" selected>Nenhuma</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <div class="form-actions">
                            <?php if (isset($erro) && $erro != null) :  ?>
                                <div class="message_error">
                                    <p>
                                        <img src="/assets/img/icons/danger.svg"><?= $erro ?>
                                    </p>
                                </div>
                            <?php endif ?>
                            <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                            <input type="submit" value="Cadastrar" class="btn" id="cadastrar">
                        </div>
                    </div>
                </form>
                <div class="modal-exclude"></div>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/cadastro-form.js"></script>
</body>

</html>