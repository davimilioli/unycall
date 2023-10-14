<?php
require_once(__DIR__ . '/Sistema.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    header('location: cliente.php?' . $_GET['id'] . 'erroPermissao=true');
    exit;
}

session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Adicionar Usuário</title>
    <link rel="stylesheet" href="./assets/css/css/style.css">
</head>

<body>
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
                <form method="POST" action="../cadastro/cadastro_action.php" class="form">
                    <div class="form-container">
                        <div class="form-category">
                            <h2>Dados pessoais</h2>
                            <div class="form-group">
                                <label for="nome">Nome <span>*</span></label>
                                <input type="text" name="nome" id="nome">
                            </div>
                            <div class="form-group">
                                <label for="data-nascimento">Data de Nascimento <span>*</span></label>
                                <input type="text" name="nascimento" id="data-nascimento">
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF <span>*</span></label>
                                <input type="text" name="cpf" id="cpf">
                            </div>
                            <div class="form-group">
                                <label for="nomeMaterno">Nome Materno <span>*</span></label>
                                <input type="text" name="nomeMaterno" id="nomeMaterno">
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span>*</span></label>
                                <input type="text" name="email" id="email">
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
                                    <input type="text" name="celular" id="celular">
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone <span>*</span></label>
                                    <input type="text" name="telefone" id="telefone">
                                </div>
                            </div>
                        </div>
                        <div class="form-category endereco">
                            <h2>Endereço</h2>
                            <div class="form-group">
                                <label for="cep">Cep <span>*</span></label>
                                <input type="text" name="cep" id="cep">
                            </div>
                            <div class="inputs-group endereco">
                                <div class="form-group">
                                    <label for="endereco">Endereço <span>*</span></label>
                                    <input type="text" name="endereco" id="endereco">
                                </div>
                                <div class="form-group numero">
                                    <label for="numend">N° <span>*</span></label>
                                    <input type="text" name="numend" id="numend">
                                </div>
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="bairro">Bairro <span>*</span></label>
                                    <input type="text" name="bairro" id="bairro">
                                </div>
                                <div class="form-group">
                                    <label for="cidade">Cidade <span>*</span></label>
                                    <input type="text" name="cidade" id="cidade">
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
                            </div>
                            <div class="inputs-group">
                                <div class="form-group">
                                    <label for="senha">Senha <span>*</span></label>
                                    <input type="text" name="senhaCadastro" id="senha" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmar-senha">Confirmar senha <span>*</span></label>
                                    <input type="text" name="confirmar-senha" id="confirmar-senha" required>
                                </div>
                            </div>
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
                            <?php if (isset($_GET['erro'])) :  ?>
                                <div class="message_error">
                                    <p>
                                        <img src="./assets/img/icons/danger.svg">E-mail já cadastrado
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
    <script src="./assets/js/header.js"></script>
    <script src="./assets/js/cliente.js"></script>
    <!--    <script src="./assets/js/cadastro-form.js"></script> -->
</body>

</html>