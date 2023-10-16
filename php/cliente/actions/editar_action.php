<?php
require_once('../../config/config_db.php');
require_once('../../autoload.php');
$sistema = new Sistema($pdo);

$verificarPerm = $sistema->procurarIdUsuario($_GET['id']);
if ($verificarPerm['usuario']['permissao'] == 'administrador') {
    session_name('administrador');
} else {
    header('location: cliente.php?' . $_GET['id'] . 'erroPermissao=true');
    exit;
}

session_start();


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

$permissao = filter_input(INPUT_POST, 'permissao');
echo '<hr>';
echo "PERMISSÃO: $permissao";
echo '<hr>';

$cep = filter_input(INPUT_POST, 'cep');
$logradouro = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento');

echo '<hr>';
echo "CEP: $cep";
echo '<hr>';

echo '<hr>';
echo "LOGRADOURO: $logradouro";
echo '<hr>';

echo '<hr>';
echo "NUMERO: $numero";
echo '<hr>';

echo '<hr>';
echo "BAIRRO: $bairro";
echo '<hr>';

echo '<hr>';
echo "CIDADE: $cidade";
echo '<hr>';

echo '<hr>';
echo "ESTADO: $estado";
echo '<hr>';

echo '<hr>';
echo "COMPLEMENTO: $complemento";
echo '<hr>';

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
    $dadosUsuario = array(
        'id' => $id,
        'nome' => $nome,
        'nascimento' => $nascimento,
        'cpf' => $cpf,
        'nomematerno' => $nomeMaterno,
        'email' => $email,
        'sexo' => $sexo,
        'celular' => $celular,
        'telefone' => $telefone,
        'login' => $login,
        'permissao' => $permissao ?? null
    );

    $sistema->atualizarDadosUsuario($dadosUsuario, $usuarioSql = null);

    if ($cep && $logradouro && $numero && $bairro && $cidade && $estado) {
        $dadosEndereco = array(
            'id_usuario' => $id,
            'cep' => formatarCep($cep),
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'complemento' => $complemento ?? null
        );
        $sistema->atualizarDadosEndereco($dadosEndereco, $usuarioSql);
    }
    header('location: ../lista_usuarios.php?id=' . $_GET['id']);
    exit;
} /* else {
    header('location: ../editar_usuario.php?id=' . $_GET['id'] . '&edit=' . $id);
    exit;
} */
