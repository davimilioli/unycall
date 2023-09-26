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

        $sql = $this->pdo->query("SELECT * FROM usuarios");

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

                $array[] = [
                    'usuario' => $usuario,
                    'quantidade' => count($data)
                ];
            }
        }

        return $array;
    }

    public function procurarId($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios, endereco WHERE usuarios.id = :id AND endereco.id_usuario = :id_usuario");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_usuario', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $usuario = new Usuario();
            $usuario->setarId($data['id']);
            $usuario->setarNome($data['nome']);
            $usuario->setarNascimento($data['nascimento']);
            $usuario->setarCpf($data['cpf']);
            $usuario->setarNomeMaterno($data['nomematerno']);
            $usuario->setarEmail($data['email']);
            $usuario->setarSexo($data['sexo']);
            $usuario->setarCelular($data['celular']);
            $usuario->setarTelefone($data['telefone']);
            $usuario->setarLogin($data['login']);

            $endereco = new Endereco();
            $endereco->setarIdUsuarioEndereco($data['id_usuario']);
            $endereco->setarCepEndereco($data['cep']);
            $endereco->setarLogradouroEndereco($data['logradouro']);
            $endereco->setarNumeroEndereco($data['numero']);
            $endereco->setarBairroEndereco($data['bairro']);
            $endereco->setarCidadeEndereco($data['cidade']);
            $endereco->setarEstadoEndereco($data['estado']);
            $endereco->setarComplementoEndereco($data['complemento'] ?? null);

            return [
                'usuario' => $usuario,
                'endereco' => $endereco
            ];
        }
    }

    public function atualizarUsuario(Usuario $usuario)
    {
        $sql = $this->pdo->prepare(
            "UPDATE usuarios SET nome = :nome, nascimento = :nascimento, cpf = :cpf, email = :email, nomematerno = :nomematerno, celular = :celular, telefone = :telefone, login = :login WHERE id = :id"
        );
        $sql->bindValue(':nome', $usuario->pegarNome());
        $sql->bindValue(':nascimento', $usuario->pegarNascimento());
        $sql->bindValue(':cpf', $usuario->pegarCpf());
        $sql->bindValue(':email', $usuario->pegarEmail());
        $sql->bindValue(':nomematerno', $usuario->pegarNomeMaterno());
        $sql->bindValue(':celular', $usuario->pegarCelular());
        $sql->bindValue(':telefone', $usuario->pegarTelefone());
        $sql->bindValue(':login', $usuario->pegarLogin());
        $sql->bindValue(':id', $usuario->pegarId());
        $sql->execute();

        return true;
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

    public function deletarUsuario($id)
    {
        $this->pdo->beginTransaction();

        $sql1 = $this->pdo->prepare("DELETE FROM endereco WHERE id_usuario = :id");
        $sql1->bindValue(':id', $id);
        $sql1->execute();

        $sql2 = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql2->bindValue(':id', $id);
        $sql2->execute();

        $this->pdo->commit();
        return true;
    }
}
