<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$id = $_SESSION['id'];

$dados = $sistema->procurarIdUsuario($id);

$gerenciador = new Gerenciador($banco->pegarPdo());
$servicosDisponiveis = $gerenciador->servicosDisponiveis();
$assinaturaAtivaInfo = $gerenciador->assinaturaAtiva($id);


if ($assinaturaAtivaInfo && is_array($assinaturaAtivaInfo)) {
    $assinaturaAtivo = isset($assinaturaAtivaInfo['servico']) ? $assinaturaAtivaInfo['servico'] : null;
    $comprovante = isset($assinaturaAtivaInfo['comprovante']) ? $assinaturaAtivaInfo['comprovante'] : null;
} else {
    $assinaturaAtivo = null;
    $comprovante = null;
}

/* Fomulário */
if (isset($_POST['servico'], $_POST['numCartao'], $_POST['cvv'],  $_POST['validade'], $_POST['titular'], $_POST['cpfTitular'])) {
    $idServico = $_POST['idServico'];
    $servicoEscolhido = $_POST['servico'];

    $entrada = $dados['usuario']['nome'] . date('d/m/Y') . rand(1, 50);
    $idTransacao = md5($entrada);

    $arrayPagamento = array(
        'id_transacao' => $idTransacao,
        'nome' => $dados['usuario']['nome'],
        'cpf' => $dados['usuario']['cpf'],
        'servico_assinado' => $servicoEscolhido
    );

    $arrayAssinatura = array(
        'id_usuario' => $id,
        'id_servico' => $idServico,
        'id_transacao' => $idTransacao
    );

    $dadosPagamento = $gerenciador->enviarDadosPagamento($arrayPagamento);
    $dadosAssinatura = $gerenciador->enviarDadosAssinatura($arrayAssinatura);

    if ($dadosPagamento === true && $dadosAssinatura === true) {
        header('location: gerenciar.php');
        exit;
    } else {
        echo 'erro ao fazer pagamento, tente novamente mais tarde';
    }
}

if (isset($_POST['excluirAssinatura'])) {
    $id = $_POST['excluirAssinatura'];
    $gerenciador->enviarExclusao($id);
    header('location: /php/cliente/assinatura/gerenciar.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Gerenciar Assinatura</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once('../layout/header.php'); ?>
    <div class="page-cliente">
        <?php require_once('../layout/aside.php'); ?>
        <main class="page-cliente-signature">
            <div class="category-title">
                <h4>Gerenciar Assinatura</h4>
            </div>
            <div class="signature-content">
                <?php if (isset($assinaturaAtivo['ativo'])) : ?>
                    <div class="card-signature-active">
                        <div class="signature-active-header">
                            <h2><?= $assinaturaAtivo['servico_assinado'] ?></h2>
                        </div>
                        <div class="signature-active-body">
                            <div class="signature-active-body-price">
                                Preço: R$ <?= $assinaturaAtivo['preco_servico'] ?>
                            </div>
                            <div class="signature-active-body-date">
                                Assinado em: <?= $assinaturaAtivo['data_inicio'] ?>
                            </div>
                            <div class="signature-active-body-date">
                                Expira em: <?= $assinaturaAtivo['data_expiracao'] ?>
                            </div>
                        </div>
                        <div class="signature-active-footer">
                            <button class="btn" id="view-signature">
                                Ver assinatura
                            </button>
                        </div>
                    </div>
                    <div class="view-signature-modal">
                        <div class="view-signature-modal-content">
                            <div class="signature-modal-header">
                                <h2>Assinatura</h2>
                                <button id="closeModalSignature">X</button>
                            </div>
                            <div class="signature-modal-body">
                                <div class="modal-body-content">
                                    <div class="body-content-card">
                                        <div class="content-card-title">
                                            <h2>Serviço</h2>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Serviço assinado</h3>
                                            <span><?= $assinaturaAtivo['servico_assinado'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Preço</h3>
                                            <span>R$ <?= $assinaturaAtivo['preco_servico'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Assinado em: </h3>
                                            <span>
                                                <?= $assinaturaAtivo['data_inicio'] ?>
                                            </span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Expira em: </h3>
                                            <span>
                                                Expira em <?= $assinaturaAtivo['data_expiracao'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="body-content-card">
                                        <div class="content-card-title">
                                            <h2>Comprovante de Pagamento</h2>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>ID de Transação</h3>
                                            <span><?= $comprovante['id_transacao'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Nome</h3>
                                            <span><?= $comprovante['nome'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>CPF</h3>
                                            <span><?= $comprovante['cpf'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Preço do Serviço:</h3>
                                            <span> R$ <?= $comprovante['preco_servico'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Total:</h3>
                                            <span> R$ <?= $comprovante['total'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Assinado em: </h3>
                                            <span><?= $comprovante['data'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="signature-modal-footer">
                                <a class="btn" href="comprovante_pdf.php?id=<?= $id ?>" target="_blank">Importar Comprovante</a>
                                <button class="btn secondary" type="button" data-id="<?= $id ?>">Cancelar Assinatura</button>
                            </div>
                            <div class="modal-exclude"></div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="form-content active" id="formSignature">
                        <form method="POST" class="form">
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
                                            <?php foreach ($servicosDisponiveis as $key => $item) : ?>
                                                <label class="signature-list-options-content" for="<?= $item['nome'] ?>">
                                                    <input type="hidden" name="preco" value="<?= $item['custo'] ?>">
                                                    <input type="radio" name="servico" id="<?= $item['nome'] ?>" value="<?= $item['nome'] ?>" required <?= $key == 0 ? 'checked' : '' ?>>
                                                    <input type="hidden" name="idServico" value="<?= $item['id'] ?>">
                                                    <div class="signature-list-option-item">
                                                        <?= $item['tipo']; ?>
                                                    </div>
                                                    <div class="signature-list-option-item">
                                                        <?= $item['nome'] ?>
                                                    </div>
                                                    <div class="signature-list-option-item">
                                                        <?= $item['disp_regiao'] ?>
                                                    </div>
                                                    <div class="signature-list-option-item">
                                                        R$ <?= $item['custo'] ?>
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
                                        <input type="text" name="numCartao" id="numCartao" minlength="16">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV <span>*</span></label>
                                        <input type="text" name="cvv" id="cvv">
                                    </div>
                                    <div class="form-group">
                                        <label for="validade">Validade <span>*</span></label>
                                        <input type="text" name="validade" id="validade" maxlength="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="titular">Titular <span>*</span></label>
                                        <input type="text" name="titular" id="titular">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpfTitular">Cpf do titular <span>*</span></label>
                                        <input type="text" name="cpfTitular" id="cpfTitular" minlength="11" maxlength="14">
                                    </div>
                                </div>
                            </div>
                            <div class="form-buttons">
                                <div class="form-actions">
                                    <?php if (isset($_GET['erro'])) :  ?>
                                        <div class="message error">
                                            <p>
                                                <img src="/assets/img/icons/danger.svg"><?= $erro ?>
                                            </p>
                                        </div>
                                    <?php endif ?>
                                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                                    <button class="btn" id="assinar">Assinar<button>
                                </div>
                            </div>
                        </form>
                        <div class="modal-exclude"></div>
                    </div>
                    <div class="signature-screen-hidden">
                        <p class="signature-screen-hidden-description">Você não possui nenhuma assinatura</p>
                        <button type="button" class="btn" id="buttonSignature">Assinar</button>
                    </div>
                <?php endif ?>
            </div>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script src="/assets/js/assinatura.js"></script>
</body>

</html>