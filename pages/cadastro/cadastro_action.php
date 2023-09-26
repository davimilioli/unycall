<?php
require_once(__DIR__ . '/../../config/config_db.php');

require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
require_once(__DIR__ . '/../../modelSql/EnderecoMySql.php');
$usuarioSql = new UsuarioMySql($pdo);
$enderecoSql = new EnderecoMySql($pdo);

$nome = filter_input(INPUT_POST, 'nome');
$nascimento = filter_input(INPUT_POST, 'nascimento');
$cpf = filter_input(INPUT_POST, 'cpf');
$nomeMaterno = filter_input(INPUT_POST, 'nomeMaterno');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$sexo = filter_input(INPUT_POST, 'sexo');
$celular = filter_input(INPUT_POST, 'celular');
$telefone = filter_input(INPUT_POST, 'telefone');
$login  = filter_input(INPUT_POST, 'loginCadastro');
$senha = filter_input(INPUT_POST, 'senhaCadastro');

$cep = filter_input(INPUT_POST, 'cep');
$logradouro = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento');

if ($nome && $nascimento && $cpf && $nomeMaterno && $email && $sexo && $celular && $telefone && $login && $senha) {

    if ($usuarioSql->consultarEmail($email) === false) {
        $dados = new Usuario();
        $dados->setarNome($nome);
        $dados->setarNascimento($nascimento);
        $dados->setarEmail($email);
        $dados->setarCpf($cpf);
        $dados->setarNomeMaterno($nomeMaterno);
        $dados->setarSexo($sexo);
        $dados->setarCelular($celular);
        $dados->setarTelefone($telefone);
        $dados->setarLogin($login);
        $dados->setarSenha($senha);
        $usuarioSql->criarUsuario($dados);

        if ($cep && $logradouro && $numero && $bairro && $cidade && $estado) {
            $endereco = new Endereco();
            $endereco->setarCepEndereco($cep);
            $endereco->setarLogradouroEndereco($logradouro);
            $endereco->setarNumeroEndereco($numero);
            $endereco->setarBairroEndereco($bairro);
            $endereco->setarCidadeEndereco($cidade);
            $endereco->setarEstadoEndereco($estado);
            $endereco->setarComplementoEndereco($complemento ?? null);
            $enderecoSql->criarEndereco($endereco);
        }
        header('location: ../login/login.php');
        exit;
    } else {
        header('location: cadastro.php?msgSistema=email');
        exit;
    }
} else {
    header('location: cadastro.php?msgSistema=campos');
    exit;
}
