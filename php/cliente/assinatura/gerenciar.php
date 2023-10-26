<?php
require_once('../../config/config_db.php');
require_once('../../autoload.php');
$sistema = new Sistema($pdo);
$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    session_name('usuario');
}
session_start();

$gerenciador = new Gerenciador($pdo);
$servicosDisponiveis = $gerenciador->servicosDisponiveis();

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
    <?php require_once('../layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once('../layout/includes/aside.php'); ?>
        <main class="page-cliente-signature">
            <div class="category-title">
                <h4>Gerenciar Assinatura</h4>
            </div>
            <div class="signature-content">
                <div class="form-content">
                    <form method="POST" action="../cadastro/cadastro_action.php" class="form">
                        <div class="form-container">
                            <div class="form-category">
                                <h2>Serviços disponíveis</h2>
                                <div class="form-group">
                                    <div class="signature-list-header">
                                        <div class="signature-list-header-item">
                                            #
                                        </div>
                                        <div class="signature-list-header-item">
                                            Tipo
                                        </div>
                                        <div class="signature-list-header-item">
                                            Nome
                                        </div>
                                        <div class="signature-list-header-item">
                                            Disponibilidade de Região
                                        </div>
                                        <div class="signature-list-header-item">
                                            Custo
                                        </div>
                                    </div>
                                    <div class="signature-list-content">
                                        <?php foreach ($servicosDisponiveis as $item) : ?>
                                            <label class="signature-list-options-content" for="<?= $item->pegarServicoId(); ?>">
                                                <input type="checkbox" name="<?= $item->pegarServicoId(); ?>" id="<?= $item->pegarServicoId(); ?>">
                                                <div class="signature-list-option-item">
                                                    <?= $item->pegarServicoTipo(); ?>
                                                </div>
                                                <div class="signature-list-option-item">
                                                    <?= $item->pegarServicoNome(); ?>
                                                </div>
                                                <div class="signature-list-option-item">
                                                    <?= $item->pegarDispRegiao(); ?>
                                                </div>
                                                <div class="signature-list-option-item">
                                                    <?= $item->pegarServicoCusto(); ?>
                                                </div>

                                            </label>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-category">
                                <h2>Pagamento</h2>
                                <div class="form-group">
                                    <label for="nome">Número do Cartão <span>*</span></label>
                                    <input type="text" name="nome" id="nome">
                                </div>
                                <div class="form-group">
                                    <label for="data-nascimento">CVV <span>*</span></label>
                                    <input type="text" name="nascimento" id="data-nascimento">
                                </div>
                                <div class="form-group">
                                    <label for="data-nascimento">Validade <span>*</span></label>
                                    <input type="text" name="nascimento" id="data-nascimento">
                                </div>
                                <div class="form-group">
                                    <label for="data-nascimento">Titular <span>*</span></label>
                                    <input type="text" name="nascimento" id="data-nascimento">
                                </div>
                                <div class="form-group">
                                    <label for="data-nascimento">Cpf do titular <span>*</span></label>
                                    <input type="text" name="nascimento" id="data-nascimento">
                                </div>
                            </div>
                        </div>
                        <div class="form-buttons">
                            <div class="form-actions">
                                <?php if (isset($_GET['erro'])) :  ?>
                                    <div class="message_error">
                                        <p>
                                            <img src="/assets/img/icons/danger.svg">E-mail já cadastrado
                                        </p>
                                    </div>
                                <?php endif ?>
                                <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                                <input type="submit" value="Assinar" class="btn" id="cadastrar">
                            </div>
                        </div>
                    </form>
                    <div class="modal-exclude"></div>
                </div>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/cadastro-form.js"></script>
</body>

</html>