<?php

require_once(__DIR__ . '../../Sistema.php');
$sistema = new Sistema($pdo);

$id = filter_input(INPUT_POST, 'id');
echo '<hr>';
echo "ID: $id";
echo '<hr>';
$nome = filter_input(INPUT_POST, 'nome');
echo '<hr>';
echo "NOME: $nome";
echo '<hr>';
$nascimento = filter_input(INPUT_POST, 'nascimento');
echo '<hr>';
echo "NASCIMENTO: $nascimento";
echo '<hr>';

$cpf = filter_input(INPUT_POST, 'cpf');
echo '<hr>';
echo "CPF: $cpf";
echo '<hr>';
$nomeMaterno = filter_input(INPUT_POST, 'nomeMaterno');
echo '<hr>';
echo "MATERNO: $nomeMaterno";
echo '<hr>';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
echo '<hr>';
echo "EMAIL: $email";
echo '<hr>';

$sexo = filter_input(INPUT_POST, 'sexo');
echo '<hr>';
echo "SEXO: $sexo";
echo '<hr>';

$celular = filter_input(INPUT_POST, 'celular');
echo '<hr>';
echo "CELULAR: $celular";
echo '<hr>';
$telefone = filter_input(INPUT_POST, 'telefone');
echo '<hr>';
echo "TELEFONE: $telefone";
echo '<hr>';
$login = filter_input(INPUT_POST, 'login');
echo '<hr>';
echo "LOGIN: $login";
echo '<hr>';

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

    if ($cep && $logradouro && $numero && $bairro && $cidade && $estado) {
        $endereco = new Endereco();
        $endereco->setarIdUsuarioEndereco($id);
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
    header('location: ../editar_usuario.php?id=' . $id);
    exit;
}
