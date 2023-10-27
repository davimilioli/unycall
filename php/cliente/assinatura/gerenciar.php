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
$nomeUsuario = $verificarPerm['usuario']['nome'];
$cpfUsuario = $verificarPerm['usuario']['cpf'];

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
                <?php

                $consultarAssinatura = $gerenciador->assinaturas();
                $consultarPagamentos = $gerenciador->pagamentos();
                function verificarAssinaturaAtiva($consultarAssinatura, $consultarPagamentos)
                {

                    foreach ($consultarAssinatura as $assinatura) {
                        if ($assinatura->pegarIdAssUsuario() == $_GET['id']) {
                            foreach ($consultarPagamentos as $pagamento) {
                                if ($assinatura->pegarIdAssTransacao() == $pagamento->pegarPgtoIdTransacao()) {;

                                    return array(
                                        'ativo' => true,
                                        'servico_assinado' => $pagamento->pegarServicoAssinado(),
                                        'preco_servico' => $pagamento->pegarServicoPreco(),
                                        'data' => $pagamento->pegarDataPagamento()
                                    );
                                }
                            }
                        }
                    }
                }

                $assinaturaAtiva = verificarAssinaturaAtiva($consultarAssinatura, $consultarPagamentos);
                if (isset($assinaturaAtiva['ativo'])) {

                    $servicoAssinado = verificarAssinaturaAtiva($consultarAssinatura, $consultarPagamentos)['servico_assinado'];
                    $precoServico = verificarAssinaturaAtiva($consultarAssinatura, $consultarPagamentos)['preco_servico'];
                    $data = verificarAssinaturaAtiva($consultarAssinatura, $consultarPagamentos)['data'];
                    $dataFormatada = date("d/m/Y", strtotime($data));
                }
                ?>

                <?php if (isset($assinaturaAtiva['ativo'])) : ?>
                    <div class="card-signature-active">
                        <div class="signature-active-header">
                            <h2><?= $servicoAssinado ?></h2>
                        </div>
                        <div class="signature-active-body">
                            <div class="signature-active-body-price">
                                Preço: <?= str_replace('.', ',', $precoServico) ?>
                            </div>
                            <div class="signature-active-body-date">
                                Assinado em: <?= $dataFormatada  ?>
                            </div>
                        </div>
                        <div class="signature-active-footer">
                            <a href="#" class="btn secondary">
                                <img src="/assets/img/icons/trash.svg">
                                Excluir
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="form-content">
                        <form method="POST" action="gerenciar_action.php?id=<?= $_GET['id'] ?>" class="form">
                            <input type="hidden" name="idUsuario" value="<?= $_GET['id'] ?>">
                            <input type="hidden" name="nomeUsuario" value="<?= $nomeUsuario ?>">
                            <input type="hidden" name="cpfUsuario" value="<?= $cpfUsuario ?>">
                            <input type="hidden" name="dataHoje" value="<?= date('d/m/Y') ?>">
                            <div class="form-container">
                                <div class="form-category">
                                    <h2>Serviços disponíveis</h2>
                                    <div class="form-group">
                                        <div class="signature-list-header">
                                            <div class="signature-list-header-item">
                                                &nbsp
                                            </div>
                                            <div class="signature-list-header-item">
                                                Tipo
                                            </div>
                                            <div class="signature-list-header-item">
                                                Nome
                                            </div>
                                            <div class="signature-list-header-item">
                                                Disp. de Região
                                            </div>
                                            <div class="signature-list-header-item">
                                                Custo
                                            </div>
                                        </div>
                                        <div class="signature-list-content">
                                            <?php foreach ($servicosDisponiveis as $item) : ?>

                                                <label class="signature-list-options-content" for="<?= $item->pegarServicoNome() ?>">
                                                    <input type="radio" name="servico" id="<?= $item->pegarServicoNome() ?>" value="<?= $item->pegarServicoNome() ?>" required <?= count($servicosDisponiveis) == 1 ? 'checked' : '' ?>>
                                                    <input type="hidden" name="preco" value="<?= $item->pegarServicoCusto(); ?>">
                                                    <input type="hidden" name="idServico" value="<?= $item->pegarServicoId(); ?>">
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
                                                        <?= str_replace('.', ',', $item->pegarServicoCusto()) ?>
                                                    </div>

                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-category">
                                    <h2>Pagamento</h2>
                                    <div class="form-group">
                                        <label for="numCartao">Número do Cartão <span>*</span></label>
                                        <input type="text" name="numCartao" id="numCartao" minlength="16" maxlength="16" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV <span>*</span></label>
                                        <input type="text" name="cvv" id="cvv" maxlength="3" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validade">Validade <span>*</span></label>
                                        <input type="text" name="validade" id="validade" maxlength="5" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="titular">Titular <span>*</span></label>
                                        <input type="text" name="titular" id="titular" minlength="8" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpfTitular">Cpf do titular <span>*</span></label>
                                        <input type="text" name="cpfTitular" id="cpfTitular" minlength="11" maxlength="14" required>
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
                <?php endif ?>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/cadastro-form.js"></script>
</body>

</html>