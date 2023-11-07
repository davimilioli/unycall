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
    function gerarNumeroAleatorio()
    {
        $numerosAleatorios = [];
        for ($i = 0; $i < 11; $i++) {
            $gerarNumero = rand(10000000000, 99999999999);
            $numerosAleatorios[] = $gerarNumero;
        }

        $numero = array_rand($numerosAleatorios);
        return $numerosAleatorios[$numero];
    }


    for ($i = 0; $i < $_GET['numero']; $i++) {
        $dados = new Usuario();
        $endereco = new Endereco();

        $dados->setarNome("Nome" . $i);
        $dados->setarNascimento("1990-01-01");
        $dados->setarEmail("email" . $i . "@exemplo.com");

        $dados->setarCpf(gerarNumeroAleatorio() . $i);
        $dados->setarNomeMaterno("Mãe" . $i);
        $dados->setarSexo("Masculino");
        $dados->setarCelular("123456789" . $i);
        $dados->setarTelefone("555987654321" . $i);
        $dados->setarLogin("usuario" . $i);
        $dados->setarSenha("senha" . $i);

        $endereco->setarCepEndereco("11111-370" . $i);
        $endereco->setarLogradouroEndereco("Rua Exemplo " . $i);
        $endereco->setarNumeroEndereco("123");
        $endereco->setarBairroEndereco("Bairro " . $i);
        $endereco->setarCidadeEndereco("Cidade " . $i);
        $endereco->setarEstadoEndereco("UF");
        $endereco->setarComplementoEndereco("Complemento " . $i);

        $usuarioSql->criarUsuario($dados);
        $enderecoSql->criarEndereco($endereco);
    }

    echo 'Usuarios gerados com sucesso!!';
}
