<?php
session_start();
require_once('../../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];
$permissao = $_SESSION['permissao'];
$dados = $sistema->procurarIdUsuario($id);

$gerenciador = new Gerenciador($banco->pegarPdo());
$servicosDisponiveis = $gerenciador->servicosDisponiveis();
$assinaturaAtivo = $gerenciador->assinaturaAtiva($id)['servico'];
$comprovante = $gerenciador->assinaturaAtiva($id)['comprovante'];
$nomeUsuario = $dados['usuario']['nome'];
$cpfUsuario = $dados['usuario']['cpf'];


/* Fomulário */
if (isset($_POST['servico'], $_POST['numCartao'], $_POST['cvv'],  $_POST['validade'], $_POST['titular'], $_POST['cpfTitular'])) {
    $idUsuario = $_POST['idUsuario'];
    $idServico = $_POST['idServico'];
    $servicoEscolhido = $_POST['servico'];
    $nomeUsuario = $_POST['nomeUsuario'];
    $cpfUsuario = $_POST['cpfUsuario'];
    $numCartao = $_POST['numCartao'];
    $cvv = $_POST['cvv'];
    $validade = $_POST['validade'];
    $titular = $_POST['titular'];
    $cpfTitular = $_POST['cpfTitular'];
    $dataHoje = $_POST['dataHoje'];
    $preco = $_POST['preco'];

    $entrada = $nomeUsuario . $dataHoje . rand(1, 50);
    $idTransacao = md5($entrada);

    $arrayPagamento = array(
        'id_transacao' => $idTransacao,
        'nome' => $nomeUsuario,
        'cpf' => $cpfUsuario,
        'servico_assinado' => $servicoEscolhido,
        'preco' => $preco,
        'data' => $dataHoje,
    );

    $arrayAssinatura = array(
        'id_usuario' => $idUsuario,
        'id_servico' => $idServico,
        'id_transacao' => $idTransacao,
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
    <?php require_once('../layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once('../layout/includes/aside.php'); ?>
        <main class="page-cliente-signature">
            <div class="category-title">
                <h4>Gerenciar Assinatura</h4>
            </div>
            <div class="signature-content">
                <?php

                if (isset($assinaturaAtivo['ativo'])) {

                    $servicoAssinado =  $assinaturaAtivo['servico_assinado'];
                    $precoServico =  $assinaturaAtivo['preco_servico'];
                    $data = $assinaturaAtivo['data'];
                }
                ?>

                <?php if (isset($assinaturaAtivo['ativo'])) : ?>
                    <div class="card-signature-active">
                        <div class="signature-active-header">
                            <h2><?= $servicoAssinado ?></h2>
                        </div>
                        <div class="signature-active-body">
                            <div class="signature-active-body-price">
                                Preço: <?= str_replace('.', ',', $precoServico) ?>
                            </div>
                            <div class="signature-active-body-date">
                                Assinado em: <?= $data  ?>
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
                                            <span><?= $servicoAssinado ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Preço</h3>
                                            <span><?= $precoServico ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Assinado em </h3>
                                            <span>
                                                <?= $data ?>
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
                                            <span><?= $comprovante['preco_servico'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Total:</h3>
                                            <span><?= $comprovante['total'] ?></span>
                                        </div>
                                        <div class="content-card-block">
                                            <h3>Data de Pagamento</h3>
                                            <span><?= $comprovante['data'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="signature-modal-footer">
                                <button class="btn">Importar Comprovante</button>
                                <button class="btn secondary" type="button" data-id="<?= $id ?>">Cancelar Assinatura</button>
                            </div>
                            <div class="modal-exclude"></div>
                        </div>

                    </div>
                <?php else : ?>
                    <div class="form-content" id="formSignature">
                        <form method="POST" class="form">
                            <input type="hidden" name="idUsuario" value="<?= $id ?>">
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
                                                <?php if ($item->pegarServicoStatus() != 0) : ?>
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
                                                <?php endif ?>
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
                                        <input type="text" name="titular" id="titular" minlength="8">
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
                                        <div class="message_error">
                                            <p>
                                                <img src="/assets/img/icons/danger.svg">E-mail já cadastrado
                                            </p>
                                        </div>
                                    <?php endif ?>
                                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                                    <input type="submit" value="Assinar" class="btn" id="assinar">
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