<form method="GET">
    <input type="text" name="numero">
    <input type="submit" value="Gerar">
</form>
<?php


require_once('../autoload.php');

$banco = new BancoDeDados();
$usuarioSql = new UsuarioMySql($banco->pegarPdo());
$enderecoSql = new EnderecoMySql($banco->pegarPdo());
if (isset($_GET['numero'])) {
    for ($i = 0; $i < $_GET['numero']; $i++) {
        $dados = new Usuario();
        $endereco = new Endereco();
    
        $dados->setarNome(gerarNomeAleatorio());
        $dados->setarNascimento("1990-01-01");
        $dados->setarEmail(gerarEmailAleatorio());
    
        $dados->setarCpf(gerarCpfAleatorio());
        $dados->setarNomeMaterno(gerarNomeAleatorio());
        $dados->setarSexo("Masculino");
        $dados->setarCelular(gerarTelefoneAleatorio());
        $dados->setarTelefone(gerarTelefoneAleatorio());
        $dados->setarLogin("usuario" . $i);
        $dados->setarSenha("senha" . $i);
        $dados->setarPermissao("");
    
        $endereco->setarCepEndereco(gerarCepAleatorio());
        $endereco->setarLogradouroEndereco(gerarLogradouroAleatorio());
        $endereco->setarNumeroEndereco("123");
        $endereco->setarBairroEndereco(gerarBairroAleatorio());
        $endereco->setarCidadeEndereco(gerarCidadeAleatoria());
        $endereco->setarEstadoEndereco("UF");
        $endereco->setarComplementoEndereco("Complemento " . $i);
    
        $usuarioSql->criarUsuario($dados);
        $enderecoSql->criarEndereco($endereco);
    }

    echo 'Usuários gerados com sucesso!!';
}

function gerarNomeAleatorio() {
    $nomes = ['Neymar', 'Messi', 'Cristiano', 'Ronaldo', 'Lionel', 'Davi', 'Arrascaeta', 'Rafael', 'Gabigol', 'Camila'];
    $sobrenomes = ['Milioli', 'Ronaldinho', 'Junior', 'Pereira', 'Souza', 'Ornelas', 'Alves', 'Carvalho', 'Gomes', 'Rodrigues'];

    $nome = $nomes[array_rand($nomes)] . ' ' . $sobrenomes[array_rand($sobrenomes)];
    return $nome;
}

function gerarEmailAleatorio() {
    $dominios = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com'];
    $nome = str_replace(' ', '', gerarNomeAleatorio());
    $email = preg_replace('/[^A-Za-z0-9]/', '', strtolower($nome)) . '@' . 'gmail.com';
    return $email;
}

function gerarCpfAleatorio() {
    $cpf = rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99);
    return $cpf;
}

function gerarTelefoneAleatorio() {
    $ddd = rand(11, 99);
    $numero = rand(900000000, 999999999);
    $telefone = "$ddd$numero";
    return $telefone;
}

function gerarCepAleatorio() {
    $cep = rand(10000000, 99999999);
    return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
}

function gerarLogradouroAleatorio() {
    $logradouros = ['Rua A', 'Avenida B', 'Travessa C', 'Alameda D', 'Praça E'];
    return $logradouros[array_rand($logradouros)];
}

function gerarBairroAleatorio() {
    $bairros = ['Centro', 'Jardim', 'Vila', 'Bela Vista', 'Liberdade'];
    return $bairros[array_rand($bairros)];
}

function gerarCidadeAleatoria() {
    $cidades = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 'Porto Alegre'];
    return $cidades[array_rand($cidades)];
}