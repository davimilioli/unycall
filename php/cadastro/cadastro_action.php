<?php
require_once('../autoload.php');
$banco = new BancoDeDados();
$banco->criarTabelas();
$sistema = new Sistema($banco->pegarPdo());
$usuarioSql = new UsuarioMySql($banco->pegarPdo());
$enderecoSql = new EnderecoMySql($banco->pegarPdo());

$referente = '';
$idAdm = filter_input(INPUT_POST, 'adm');
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
$permissao = filter_input(INPUT_POST, 'permissao');

$cep = filter_input(INPUT_POST, 'cep');
$logradouro = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento');

/* ECHO PARA DEBUG   */
/* echo "Nome: " . $nome . "<br>";
echo "<hr>";
echo "Data de Nascimento: " . $nascimento . "<br>";
echo "<hr>";
echo "CPF: " . $cpf . "<br>";
echo "<hr>";
echo "Nome da Mãe: " . $nomeMaterno . "<br>";
echo "<hr>";
echo "E-mail: " . $email . "<br>";
echo "<hr>";
echo "Sexo: " . $sexo . "<br>";
echo "<hr>";
echo "Celular: " . $celular . "<br>";
echo "<hr>";
echo "Telefone: " . $telefone . "<br>";
echo "<hr>";
echo "Login: " . $login . "<br>";
echo "<hr>";
echo "Senha: " . $senha . "<br>";
echo "<hr>";
echo "<hr>";
echo "Permissao: " . $permissao . "<br>";
echo "<hr>";

echo "CEP: " . $cep . "<br>";
echo "<hr>";
echo "Logradouro: " . $logradouro . "<br>";
echo "<hr>";
echo "Número: " . $numero . "<br>";
echo "<hr>";
echo "Bairro: " . $bairro . "<br>";
echo "<hr>";
echo "Cidade: " . $cidade . "<br>";
echo "<hr>";
echo "Estado: " . $estado . "<br>";
echo "<hr>";
echo "Complemento: " . $complemento . "<br>"; */

if ($nome && $nascimento && $cpf && $nomeMaterno && $email && $sexo && $celular && $telefone && $login && $senha && $cep && $logradouro && $numero && $bairro && $cidade && $estado) {
    $referente = $_SERVER['HTTP_REFERER'];

    if ($usuarioSql->consultarCpf($cpf) === false) {
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
        $dados->setarPermissao($permissao ?? null);
        $usuarioSql->criarUsuario($dados);

        $endereco = new Endereco();
        $endereco->setarCepEndereco($cep);
        $endereco->setarLogradouroEndereco($logradouro);
        $endereco->setarNumeroEndereco($numero);
        $endereco->setarBairroEndereco($bairro);
        $endereco->setarCidadeEndereco($cidade);
        $endereco->setarEstadoEndereco($estado);
        $endereco->setarComplementoEndereco($complemento ?? null);
        $enderecoSql->criarEndereco($endereco);

        if ($referente) {
            $refererParts = parse_url($referente);
            $caminho = pathinfo($refererParts['path']);
            $nomeArquivo = $caminho['filename'];

            if ($nomeArquivo == 'adicionar_usuario') {
                header('location: /php/cliente/lista_usuarios.php');
                exit;
            } elseif ($nomeArquivo == 'cadastro') {
                header('location: /php/login/login.php');
                exit;
            }
        }
    } else {
        if ($referente) {
            $refererParts = parse_url($referente);
            $caminho = pathinfo($refererParts['path']);
            $nomeArquivo = $caminho['filename'];

            if ($nomeArquivo == 'adicionar_usuario') {
                header('location: /php/cliente/adicionar_usuario.php?erro=cpf');
                exit;
            } else {
                header('location: cadastro.php?msgSistema=cpf');
                exit;
            }
        }
    }
} else {
    if ($referente) {
        $refererParts = parse_url($referente);
        $caminho = pathinfo($refererParts['path']);
        $nomeArquivo = $caminho['filename'];

        if ($nomeArquivo == 'adicionar_usuario') {
            header('location: /php/cliente/adicionar_usuario.php?msgSistema=campos');
            exit;
        } else {
            header('location: cadastro.php?msgSistema=campos');
            exit;
        }
    }
}
