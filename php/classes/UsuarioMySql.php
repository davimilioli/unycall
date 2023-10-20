<?php
require_once(__DIR__ . '../../config/config_db.php');
require_once('Usuario.php');

class UsuarioMySql implements UsuarioSqlInterface
{
    private $pdo;

    // IMPLEMENTAÇÃO QUE USA O DRIVER DO PDO
    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    // CRIAR USUARIO
    public function criarUsuario(Usuario $usuario)
    {
        $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, nascimento, cpf, nomematerno, email, sexo, celular, telefone, login, senha, permissao) VALUES (:nome, :nascimento, :cpf, :nomematerno, :email, :sexo, :celular, :telefone, :login, :senha, :permissao)");
        $sql->bindValue(':nome', $usuario->pegarNome());
        $sql->bindValue(':nascimento', $usuario->pegarNascimento());
        $sql->bindValue(':cpf', $usuario->pegarCpf());
        $sql->bindValue(':nomematerno', $usuario->pegarNomeMaterno());
        $sql->bindValue(':email', $usuario->pegarEmail());
        $sql->bindValue(':sexo', $usuario->pegarSexo());
        $sql->bindValue(':celular', $usuario->pegarCelular());
        $sql->bindValue(':telefone', $usuario->pegarTelefone());
        $sql->bindValue(':login', $usuario->pegarLogin());
        $sql->bindValue(':senha', $usuario->pegarSenha());
        $sql->bindValue(':permissao', $usuario->pegarPermissao());
        $sql->execute();
        $usuario->setarId($this->pdo->lastInsertId());

        return $usuario;
    }

    // CONSULTAR CPF
    public function consultarCpf($cpf)
    {
        $cpfFormatado = str_replace(['.', '-'], '', $cpf);

        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
        $sql->bindValue(':cpf', $cpfFormatado);
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
            $usuario->setarSenha($data['senha']);
            return $usuario;
        } else {
            return false;
        }
    }

    // CONSULTA PARA FAZER LOGIN
    public function consultarDadosLogin($login, $senha, $tipoLogin)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
        $sql->bindValue(':login', $login);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        if ($data && isset($data['senha'])) {
            if (password_verify($senha, $data['senha'])) {
                $usuario = new Usuario();
                $usuario->setarId($data['id']);
                $usuario->setarPermissao($data['permissao']);
                /* var_dump($usuario->setarPermissao($data['permissao'])); */
                return array(
                    'resposta' => true,
                    'id' => $usuario->pegarId(),
                    'permissao' => $usuario->pegarPermissao()
                );
            }
        }

        return false;
    }

    public function atualizarUsuario(Usuario $usuario)
    {
        $sql = $this->pdo->prepare(
            "UPDATE usuarios SET nome = :nome, nascimento = :nascimento, cpf = :cpf, email = :email, nomematerno = :nomematerno, celular = :celular, telefone = :telefone, login = :login, permissao = :permissao WHERE id = :id"
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
        $sql->bindValue(':permissao', $usuario->pegarPermissao());
        $sql->execute();

        return true;
    }

    public function consultarId($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }

    public function consultaUsuario()
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
                $usuario->setarPermissao($item['permissao']);
                $array[] = $usuario;
            }
        }

        return $array;
    }

    public function deletarUsuario($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return true;
    }
    public function consultaUnicaUsuario($coluna, $valor)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE $coluna = :valor");
        $sql->bindValue(':valor', $valor);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $usuario = new Usuario();
            $usuario->setarId($data['id']);

            return array(
                'id' => $usuario,
                'resposta' => true
            );
        } else {
            return array(
                'resposta' => false
            );
        }
    }

    public function alterarSenha($usuario)
    {
        $id = $usuario->pegarId();
        $novaSenha = $usuario->pegarSenha();

        $sql = $this->pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
        $sql->bindValue(':senha', $novaSenha);
        $sql->bindValue(':id', $id);

        if ($sql->execute()) {
            echo 'Senha atualizada com sucesso.';
        } else {
            echo 'Ocorreu um erro ao atualizar a senha.';
        }
    }
}
