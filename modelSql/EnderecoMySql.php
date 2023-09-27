<?php
require_once(__DIR__ . '/../entidade/Endereco.php');
require_once(__DIR__ . '/../entidade/Usuario.php');

class EnderecoMySql implements EnderedoSqlInterface
{
    private $pdo;

    // IMPLEMENTAÇÃO QUE USA O DRIVER DO PDO
    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function criarEndereco(Endereco $endereco)
    {
        $sql = $this->pdo->prepare("INSERT INTO endereco (id_usuario, cep, logradouro, numero, bairro, cidade, estado, complemento) VALUES (:id_usuario, :cep, :logradouro, :numero, :bairro, :cidade, :estado, :complemento)");
        $sql->bindValue(':cep', $endereco->pegarCepEndereco());
        $sql->bindValue(':id_usuario', $this->pdo->lastInsertId());
        $sql->bindValue(':logradouro', $endereco->pegarLogradouroEndereco());
        $sql->bindValue(':numero', $endereco->pegarNumeroEndereco());
        $sql->bindValue(':bairro', $endereco->pegarBairroEndereco());
        $sql->bindValue(':cidade', $endereco->pegarCidadeEndereco());
        $sql->bindValue(':estado', $endereco->pegarEstadoEndereco());
        $sql->bindValue(':complemento', $endereco->pegarComplementoEndereco() ?? null);
        $sql->execute();

        $endereco->setarIdEndereco($this->pdo->lastInsertId());
        return $endereco;
    }

    public function atualizarEndereco(Endereco $endereco)
    {
        $sql = $this->pdo->prepare(
            "UPDATE endereco SET cep = :cep, logradouro = :logradouro, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, complemento = :complemento WHERE id_usuario = :id_usuario"
        );
        $sql->bindValue(':cep', $endereco->pegarCepEndereco());
        $sql->bindValue(':logradouro', $endereco->pegarLogradouroEndereco());
        $sql->bindValue(':numero', $endereco->pegarNumeroEndereco());
        $sql->bindValue(':bairro', $endereco->pegarBairroEndereco());
        $sql->bindValue(':cidade', $endereco->pegarCidadeEndereco());
        $sql->bindValue(':estado', $endereco->pegarEstadoEndereco());
        $sql->bindValue(':complemento', $endereco->pegarComplementoEndereco());
        $sql->bindValue(':id_usuario', $endereco->pegarIdUsuarioEndereco());
        $sql->execute();

        return true;
    }
}
