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
$assinaturaAtivo = $gerenciador->assinaturaAtiva($id);
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

    $gerenciador->enviarDadosPagamento($arrayPagamento);
    $gerenciador->enviarDadosAssinatura($arrayAssinatura);

    header('location: gerenciar.php');
    exit;
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
                    $data =    $assinaturaAtivo['data'];
                    $dataFormatada = date("d/m/Y", strtotime($data));
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