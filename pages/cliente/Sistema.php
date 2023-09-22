<?php

require_once(__DIR__ . '/../../config/config_db.php');
require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
require_once(__DIR__ . '/../../entidade/Usuario.php');
require_once(__DIR__ . '/../../entidade/Endereco.php');

class Sistema
{

    private $pdo;

    // IMPLEMENTAÇÃO QUE USA O DRIVER DO PDO
    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function consultarDados()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM usuarios, endereco");

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $item) {
                $usuario = new Usuario();
                $usuario->setarId($item['id']);
                $usuario->setarNome($item['nome']);
                $usuario->setarNascimento($item['nascimento']);
                $usuario->setarCpf($item['cpf']);
                $usuario->setarNomeMaterno($item['nomematerno']);
                $usuario->setarEmail($item['email']);
                $usuario->setarSexo($item['sexo']);
                $usuario->setarCelular($item['celular']);
                $usuario->setarTelefone($item['telefone']);
                $usuario->setarLogin($item['login']);

                $endereco = new Endereco();
                $endereco->setarIdUsuarioEndereco($item['id_usuario']);
                $endereco->setarCepEndereco($item['cep']);
                $endereco->setarLogradouroEndereco($item['logradouro']);
                $endereco->setarNumeroEndereco($item['numero']);
                $endereco->setarBairroEndereco($item['bairro']);
                $endereco->setarCidadeEndereco($item['cidade']);
                $endereco->setarEstadoEndereco($item['estado']);
                $endereco->setarComplementoEndereco($item['complemento']);

                $array[] = [
                    'usuario' => $usuario,
                    'endereco' => $endereco
                ];
            }
        }

        return $array;
    }
}
