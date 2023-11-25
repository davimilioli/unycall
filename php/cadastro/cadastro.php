<?php
require_once('../autoload.php');
$banco = new BancoDeDados();
$verificar = $banco->verificarUsuarioExiste();
if ($verificar == false) {
    unset($verificar);
}

$sistema = new Sistema($banco->pegarPdo());
$erro = '';

if (isset($_POST['nome'], $_POST['nascimento'], $_POST['cpf'], $_POST['nomeMaterno'], $_POST['email'], $_POST['sexo'], $_POST['celular'], $_POST['telefone'], $_POST['loginCadastro'], $_POST['senhaCadastro'], $_POST['cep'], $_POST['endereco'], $_POST['numend'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'])) {

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
    $complemento = $_POST['complemento'];

    $cadastro = array(
        'nome' => $nome,
        'nascimento' => $nascimento,
        'cpf' => $cpf,
        'nomematerno' => $nomeMaterno,
        'email' => $email,
        'sexo' => $sexo,
        'celular' => $celular,
        'telefone' => $telefone,
        'login' => $login,
        'senha' => $senha,
        'cep' => $cep,
        'logradouro' => $logradouro,
        'numero' => $numero,
        'bairro' => $bairro,
        'cidade' => $cidade,
        'estado' => $estado,
        'complemento' => $complemento,
        'permissao' => '',
    );

    $validarCadastro = $sistema->validarCadastro($cadastro);

    if ($validarCadastro === true) {
        header('location: /php/login/login.php');
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
    <title>Unycall - Cadastro</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="/index.html"><img src="/assets/img/logo.png" alt="Logo UnyCall"></a>
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <!-- <li class="menu-list-item"><a href="#">Sobre</a></li> -->
                <li class="menu-list-item"><a href="../../servicos.html">Serviços</a></li>
                <li class="menu-list-item"><a href="../../contato.html">Contato</a></li>
            </ul>
            <div class="header-actions">
                <a class="btn secondary" href="/php/cadastro/cadastro.php">Cadastrar-se</a>
                <a class="btn" href="/php/login/login.php">Login</a>
            </div>
        </nav>
        <button type="button" class="menu-mobile">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
    <section class="page-form cadastro">
        <div class="form-panel">
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content"></div>
                </div>
                <div class="form-title">
                    <h1>Cadastro</h1>
                    <p>Preencha para ter acesso ao nosso sistema</p>
                    <p>Já possui cadastro? <a href="../login/login.php" class="form-link">Acesse aqui</a></p>
                </div>
                <form method="POST" class="form">
                    <div class="form-category">
                        <h2>Dados pessoais</h2>
                        <div class="form-group">
                            <label for="nome">Nome Completo <span>*</span></label>
                            <input type="text" name="nome" id="nome" minlength="15" maxlength="80" required>
                        </div>
                        <div class="form-group">
                            <label for="data-nascimento">Data de Nascimento <span>*</span></label>
                            <input type="text" name="nascimento" id="data-nascimento" required>
                        </div>
                        <div class="form-group">
                            <label for="">Sexo <span>*</span></label>
                            <select name="sexo" required id="sexo">
                                <option value="" selected>Sexo</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                                <option value="outros">Outros</option>
                            </select>
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
                            <span class="message_notice nomematerno" style="display: none;">
                                <img src="/assets/img/icons/danger-notice.svg" alt="">
                                Nome Completo não pode ser igual ao Nome Materno
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required>
                            <span class="message_notice email" style="display: none;">
                                <img src="/assets/img/icons/danger-notice.svg" alt="">
                                Email já existente
                            </span>
                        </div>
                        <div class="inputs-group">
                            <div class="form-group">
                                <label for="celular">Celular <span>*</span></label>
                                <input type="text" name="celular" id="celular" placeholder="(+55) XX-XXXXXXXXX" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone <span>*</span></label>
                                <input type="text" name="telefone" id="telefone" placeholder="(+55) XX-XXXXXXXX" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-category endereco">
                        <h2>Endereço</h2>
                        <div class="form-group">
                            <label for="cep">Cep <span>*</span></label>
                            <input type="text" name="cep" id="cep" data-input-address required placeholder="00000-000">
                        </div>
                        <div class="inputs-group endereco">
                            <div class="form-group">
                                <label for="endereco">Endereço <span>*</span></label>
                                <input type="text" name="endereco" id="endereco" data-input-address required>
                            </div>
                            <div class="form-group numero">
                                <label for="numend">N° <span>*</span></label>
                                <input type="text" name="numend" id="numend" data-input-address required>
                            </div>
                        </div>
                        <div class="inputs-group">
                            <div class="form-group">
                                <label for="bairro">Bairro <span>*</span></label>
                                <input type="text" name="bairro" id="bairro" data-input-address required>
                            </div>
                            <div class="form-group">
                                <label for="cidade">Cidade <span>*</span></label>
                                <input type="text" name="cidade" id="cidade" data-input-address required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado <span>*</span></label>
                                <select id="estado" name="estado" data-input-address required>
                                    <option selected>Estado</option>
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
                            <input type="text" name="complemento" id="complemento" data-input-address>
                        </div>
                        <span class="message_notice cep" style="display: none;">
                            <img src="/assets/img/icons/danger-notice.svg" alt="">
                            Cep Inválido
                        </span>
                    </div>
                    <div class="form-category">
                        <h2>Login</h2>
                        <div class="form-group">
                            <label for="login">Login <span>*</span></label>
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
                </form>
                <div class="form-buttons">
                    <div class="form-actions">
                        <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                        <button type="submit" class="btn" id="cadastrar">
                            Cadastrar
                        </button>
                    </div>
                    <?php if (isset($erro) && $erro != null) :  ?>
                        <div class="message error">
                            <p>
                                <img src="/assets/img/icons/danger.svg"><?= $erro ?>
                            </p>
                        </div>
                    <?php endif ?>
                    <div class="message error validacao" style="display: none;">
                        <p>
                            <img src="/assets/img/icons/danger.svg">Cpf ou Email ou Login já existentes
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/assets/js/cadastro-form.js"></script>
</body>

</html>