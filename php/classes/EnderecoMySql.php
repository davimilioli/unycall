<?php
require_once('Endereco.php');
require_once('Usuario.php');

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

    public function consultarIdUsuarioEndereco($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM endereco WHERE id_usuario = :id_usuario");
        $sql->bindValue(':id_usuario', $id);
        $sql->execute();

        return true;
    }

    public function consultaEndereco()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM endereco");

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $item) {

                $endereco = new Endereco();
                $endereco->setarIdUsuarioEndereco($item['id_usuario']);
                $endereco->setarCepEndereco($item['cep']);
                $endereco->setarLogradouroEndereco($item['logradouro']);
                $endereco->setarNumeroEndereco($item['numero']);
                $endereco->setarBairroEndereco($item['bairro']);
                $endereco->setarCidadeEndereco($item['cidade']);
                $endereco->setarEstadoEndereco($item['estado']);
                $endereco->setarComplementoEndereco($item['complemento'] ?? null);


                $array[] = $endereco;
            }
        }

        return $array;
    }

    public function deletarEndereco($id)
    {
        echo $id;
        $sql = $this->pdo->prepare("DELETE FROM endereco WHERE id_usuario = :id_usuario");
        $sql->bindValue(':id_usuario', $id);
        $sql->execute();
        return true;
    }
}
