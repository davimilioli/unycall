<?php
session_start();

$sessao = $_SESSION['usuario'];
if (!isset($sessao)) {
    header('location: ../login/login.php?erroSistema=true');
    exit;
}

require_once(__DIR__ . '/Sistema.php');

$sistema = new Sistema($pdo);
$lista = $sistema->consultarDados();

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
    <header class="header">
        <div class="logo">
            <a href="/index.php"><img src="/assets/img/logo.png" alt="Logo UnyCall"></a>
        </div>
        <nav class="menu">
            <ul class="menu-list">
                <li class="menu-list-item"><a href="#">Página Inicial</a></li>
                <li class="menu-list-item"><a href="#">Sobre</a></li>
                <li class="menu-list-item"><a href="#">Serviços</a></li>
                <li class="menu-list-item"><a href="#">Contato</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <a class="btn" href="sair.php">Sair</a>
        </div>
        <button type="button" class="menu-mobile">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
    <main class="page-cliente">
        <section class="table-usuarios container">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>EMAIL</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $item) : ?>
                        <tr>
                            <td><?php echo $item['usuario']->pegarId() ?></td>
                            <td><?php echo $item['usuario']->pegarNome() ?></td>
                            <td><?php echo $item['usuario']->pegarEmail() ?></td>
                            <td>
                                <a class="btn secondary" href="informacoes.php?id=<?php echo $item['usuario']->pegarId() ?>">Ver informações</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="modal-table">
                <div class="form-content">
                    <div class="loading hide">
                        <div class="loading-content">
                            <div class="spinner-one">
                                <div class="spinner-two"></div>
                            </div>
                            <p class="loading-message">aaaa</p>
                        </div>
                    </div>
                    <div class="header-modal">
                        <h2>Editar Usuario</h2>
                        <button type="button" id="closeModal">X</button>
                    </div>
                    <form method="POST" action="cadastro_action.php" class="form">
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
                                <label for="">Sexo </label>
                                <select name="sexo" required>
                                    <option value="" selected>Sexo</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="outros">Outros</option>
                                </select>
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
                        <div class=" form-buttons">
                            <input type="submit" value="Atualizar" class="btn" class="atualizarDados">
                            <input type="reset" value="Excluir" id="excluirDados" class="btn secondary">
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </main>
    <script>
        const openModal = document.querySelector('#openModal');
        const modal = document.querySelector('.modal-table');
        const closeModal = document.querySelector('#closeModal');
        openModal.addEventListener('click', () => {
            modal.classList.add('active');
        })

        closeModal.addEventListener('click', () => {
            modal.classList.remove('active');
        })
    </script>
</body>

</html>