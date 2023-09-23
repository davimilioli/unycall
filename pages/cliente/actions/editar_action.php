<?php

require_once(__DIR__ . '../../Sistema.php');
$sistema = new Sistema($pdo);

$id = filter_input(INPUT_POST, 'id');
$nome = filter_input(INPUT_POST, 'nome');
$nascimento = filter_input(INPUT_POST, 'nascimento');
$cpf = filter_input(INPUT_POST, 'cpf');
$nomeMaterno = filter_input(INPUT_POST, 'nomeMaterno');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$sexo = filter_input(INPUT_POST, 'sexo');
$celular = filter_input(INPUT_POST, 'celular');
$telefone = filter_input(INPUT_POST, 'telefone');
$login  = filter_input(INPUT_POST, 'login');

$id_usuario = filter_input(INPUT_POST, 'idUsuario');
$cep = filter_input(INPUT_POST, 'cep');
$logradouro = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento');

function formatarNascimento($nascimento)
{
    $nascimentoFormatado = date("Y-m-d", strtotime(str_replace("/", "-", $nascimento)));
    return $nascimentoFormatado;
}

function formatarCpf($cpf)
{
    $cpfFormatado = str_replace(['.', '-'], '', $cpf);
    return $cpfFormatado;
}

function formatarNumero($numero)
{
    $numeroFormatado = preg_replace("/[^0-9]/", "", $numero);
    return $numeroFormatado;
}

function formatarCep($cep)
{
    $cepFormatado = str_replace('-', '', $cep);
    return $cepFormatado;
}

if ($id && $nome && $nascimento && $cpf && $nomeMaterno && $email && $sexo && $celular && $telefone && $login) {
    $usuario = new Usuario();
    $usuario->setarId($id);
    $usuario->setarNome($nome);
    $usuario->setarNascimento(formatarNascimento($nascimento));
    $usuario->setarEmail($email);
    $usuario->setarCpf(formatarCpf($cpf));
    $usuario->setarNomeMaterno($nomeMaterno);
    $usuario->setarSexo($sexo);
    $usuario->setarCelular(formatarNumero($celular));
    $usuario->setarTelefone(formatarNumero($celular));
    $usuario->setarLogin($login);
    $sistema->atualizarUsuario($usuario);

    if ($id_usuario && $cep && $logradouro && $numero && $bairro && $cidade && $estado) {
        $endereco = new Endereco();
        $endereco->setarIdUsuarioEndereco($id_usuario);
        $endereco->setarCepEndereco(formatarCep($cep));
        $endereco->setarLogradouroEndereco($logradouro);
        $endereco->setarNumeroEndereco($numero);
        $endereco->setarBairroEndereco($bairro);
        $endereco->setarCidadeEndereco($cidade);
        $endereco->setarEstadoEndereco($estado);
        $endereco->setarComplementoEndereco($complemento);
        $sistema->atualizarEndereco($endereco);
    }

    header('location: ../lista_usuarios.php');
    exit;
} else {
    echo 'falso';
}
