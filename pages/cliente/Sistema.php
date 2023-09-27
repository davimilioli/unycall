<?php

require_once(__DIR__ . '/../../config/config_db.php');
require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
require_once(__DIR__ . '/../../modelSql/EnderecoMySql.php');
require_once(__DIR__ . '/../../entidade/Usuario.php');
require_once(__DIR__ . '/../../entidade/Endereco.php');


class Sistema
{

    /*  private $pdo; */
    private $usuarioSql;
    private $enderecoSql;


    // IMPLEMENTAÇÃO QUE USA O DRIVER DO PDO
    /*     public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    } */

    public function __construct($pdo)
    {
        $this->usuarioSql = new UsuarioMySql($pdo);
        $this->enderecoSql = new EnderecoMySql($pdo);
    }

    public function consultarDadosUsuario()
    {
        return $this->usuarioSql->consultarDados();
    }

    /* PAREI AQUI */
    /*     public function procurarId($id)
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
    } */

    public function atualizarDadosUsuario($dadosUsuario)
    {

        $usuario = new Usuario();
        $usuario->setarId($dadosUsuario['id']);
        $usuario->setarNome($dadosUsuario['nome']);
        $usuario->setarNascimento($dadosUsuario['nascimento']);
        $usuario->setarEmail($dadosUsuario['email']);
        $usuario->setarCpf(formatarCpf($dadosUsuario['cpf']));
        $usuario->setarNomeMaterno($dadosUsuario['nomematerno']);
        $usuario->setarSexo($dadosUsuario['sexo']);
        $usuario->setarCelular(formatarNumero($dadosUsuario['celular']));
        $usuario->setarTelefone(formatarNumero($dadosUsuario['telefone']));
        $usuario->setarLogin($dadosUsuario['login']);
        $this->usuarioSql->atualizarUsuario($usuario);
    }


    public function atualizarDadosEndereco($dadosEndereco)
    {
        $endereco = new Endereco();
        $endereco->setarIdUsuarioEndereco($dadosEndereco['id_usuario']);
        $endereco->setarCepEndereco($dadosEndereco['cep']);
        $endereco->setarLogradouroEndereco($dadosEndereco['logradouro']);
        $endereco->setarNumeroEndereco($dadosEndereco['numero']);
        $endereco->setarBairroEndereco($dadosEndereco['bairro']);
        $endereco->setarCidadeEndereco($dadosEndereco['cidade']);
        $endereco->setarEstadoEndereco($dadosEndereco['estado']);
        $endereco->setarComplementoEndereco($dadosEndereco['complemento']);
        $this->enderecoSql->atualizarEndereco($endereco);
    }

    /*     public function deletarUsuario($id)
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
    } */
}
