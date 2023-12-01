<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$gerenciador = new Gerenciador($banco->pegarPdo());
$id = $_SESSION['id'];
$sistema->verificarPermissao();

if (isset($_POST['tipo'], $_POST['nome'], $_POST['disp_regiao'], $_POST['preco'], $_POST['status'])) {

    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];
    $dis_regiao = $_POST['disp_regiao'];
    $preco = $_POST['preco'];
    $status = $_POST['status'];

    $cadastrarServico = array(
        'tipo' => $tipo,
        'nome' => $nome,
        'disp_regiao' => $dis_regiao,
        'preco' => $preco,
        'status' => $status
    );

    $gerenciador->cadastroServico($cadastrarServico);

    header('location:' . CAMINHO_PADRAO . '/sistema/assinatura/lista-servicos.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= CAMINHO_PADRAO ?>/assets/img/favicon.ico" type="image/x-icon">
    <title><?= APP_NAME ?> - Adicionar Serviço</title>
    <link rel="stylesheet" href="<?= CAMINHO_PADRAO ?>/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '../../layout/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '../../layout/aside.php'); ?>
        <main class="page-cliente-editar">
            <div class="category-title">
                <h4>Adicionar Serviço</h4>
            </div>
            <div class="form-content">
                <form method="POST" class="form">
                    <div class="form-container register-user">
                        <div class="form-category">
                            <h2>Serviço</h2>
                            <div class="form-group">
                                <label for="tipo">Tipo <span>*</span></label>
                                <input type="text" name="tipo" id="tipo" required>
                            </div>
                            <div class="form-group">
                                <label for="nome">Nome <span>*</span></label>
                                <input type="text" name="nome" id="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="disp_regiao">Disponibilidade de região <span>*</span></label>
                                <input type="text" name="disp_regiao" id="disp_regiao" required>
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço em R$ <span>*</span></label>
                                <input type="text" name="preco" id="preco" required placeholder="ex: 550,88">
                            </div>
                        </div>
                        <div class="form-category">
                            <h2>Status</h2>
                            <div class="form-group">
                                <label for="">Status <span>*</span></label>
                                <select name="status" required>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <div class="form-actions">
                            <?php if (isset($erro) && $erro != null) :  ?>
                                <div class="message error">
                                    <p>
                                        <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/danger.svg"><?= $erro ?>
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
    <script src="<?= CAMINHO_PADRAO ?>/assets/js/cliente.js"></script>
</body>

</html>