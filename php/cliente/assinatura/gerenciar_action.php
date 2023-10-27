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

$idUsuario = filter_input(INPUT_POST, 'idUsuario');
$idServico = filter_input(INPUT_POST, 'idServico');
$servicoEscolhido = filter_input(INPUT_POST, 'servico');
$nomeUsuario = filter_input(INPUT_POST, 'nomeUsuario');
$cpfUsuario = filter_input(INPUT_POST, 'cpfUsuario');
$numCartao = filter_input(INPUT_POST, 'numCartao');
$cvv = filter_input(INPUT_POST, 'cvv');
$validade = filter_input(INPUT_POST, 'validade');
$titular = filter_input(INPUT_POST, 'titular');
$cpfTitular = filter_input(INPUT_POST, 'cpfTitular');
$dataHoje = filter_input(INPUT_POST, 'dataHoje');
$preco = filter_input(INPUT_POST, 'preco');

if ($servicoEscolhido && $numCartao && $cvv && $validade && $titular && $cpfTitular) {
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

    header('location: gerenciar.php?id=' . $idUsuario);
    exit;
} else {
    header('location: gerenciar.php?id=' . $idUsuario . '&erroCompra');
    exit;
}
