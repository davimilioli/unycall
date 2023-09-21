<?php
require_once(__DIR__ . '/../model/Usuario.php');

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
        $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, nascimento, cpf, nomematerno, email, sexo, celular, telefone, login, senha) VALUES (:nome, :nascimento, :cpf, :nomematerno, :email, :sexo, :celular, :telefone, :login, :senha)");
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
        $sql->execute();

        $usuario->setarId($this->pdo->lastInsertId());

        return $usuario;
    }

    // CONSULTAR EMAIL
    public function consultarEmail($email)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $email);
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

    public function consultarDadosLogin($login, $senha)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
        $sql->bindValue(':login', $login);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        if ($data && isset($data['senha'])) {
            if (password_verify($senha, $data['senha'])) {
                $usuario = new Usuario();
                $usuario->setarId($data['id']);
                return array(
                    'resposta' => true,
                    'id' => $usuario->pegarId()
                );
            }
        }

        return false;
    }

    public function doisFatores($id, $resposta, $categoria)
    {
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $nomeMaterno = $data['nomematerno'];
            $nascimento = date("Y-m-d", strtotime(str_replace("-", "/", $data['nascimento'])));
            echo $nascimento;
            /* echo $nascimento; */

            if ($categoria == 'nascimento') {
                echo "CATEGORIA: $categoria <br>";

                if ($resposta == $nascimento) {
                    echo "RESPOSTA: $nascimento <br>";
                    return array(
                        'resposta' => true,
                        'nascimento' => $nascimento,
                    );
                }
            } else if ($categoria == 'nomeMaterno') {
                echo "CATEGORIA: $categoria <br>";
                if ($resposta === $nomeMaterno) {
                    echo "RESPOSTA: $nomeMaterno <br>";
                    return array(
                        'resposta' => true,
                        'nomeMaterno' => $nomeMaterno,
                    );
                }
            }
        }
    }
}
