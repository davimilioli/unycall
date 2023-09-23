<?php

// Tudo que for relacionado ao usuario, irá mexer nessa classe
class Usuario
{
    private $id;
    private $nome;
    private $nascimento;
    private $cpf;
    private $nomeMaterno;
    private $email;
    private $sexo;
    private $celular;
    private $telefone;
    private $login;
    private $senha;

    public function setarId($id)
    {
        $this->id = trim($id);
    }

    public function pegarId()
    {
        return $this->id;
    }

    public function setarNome($nome)
    {

        $this->nome = ucwords(trim($nome));
    }

    public function pegarNome()
    {
        return $this->nome;
    }

    public function setarNascimento($nascimento)
    {
        $dataFormatada = date("Y-m-d", strtotime(str_replace("/", "-", $nascimento)));
        $this->nascimento = trim($dataFormatada);
    }

    public function pegarNascimento()
    {
        return $this->nascimento;
    }

    public function setarCpf($cpf)
    {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $this->cpf = $cpf;
    }

    public function pegarCpf()
    {
        return $this->cpf;
    }

    public function setarNomeMaterno($nomeMaterno)
    {
        $this->nomeMaterno = $nomeMaterno;
    }

    public function pegarNomeMaterno()
    {
        return $this->nomeMaterno;
    }

    public function setarEmail($email)
    {
        $this->email = trim($email);
    }

    public function pegarEmail()
    {
        return $this->email;
    }

    public function setarSexo($sexo)
    {

        $this->sexo = ucfirst($sexo);
    }

    public function pegarSexo()
    {
        return $this->sexo;
    }

    public function setarCelular($celular)
    {
        $celular = preg_replace('/[^0-9]/', '', $celular);
        $this->celular = $celular;
    }

    public function pegarCelular()
    {
        return $this->celular;
    }

    public function setarTelefone($telefone)
    {
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        $this->telefone = $telefone;
    }

    public function pegarTelefone()
    {
        return $this->telefone;
    }

    public function setarLogin($login)
    {
        $this->login = trim($login);
    }

    public function pegarLogin()
    {
        return $this->login;
    }

    public function setarSenha($senha)
    {
        $this->senha = password_hash(trim($senha), PASSWORD_DEFAULT);
    }

    public function pegarSenha()
    {
        return $this->senha;
    }
}

interface UsuarioSqlInterface
{
    public function criarUsuario(Usuario $usuario);
    public function consultarEmail($email);
    public function consultarDadosLogin($login, $senha);
}

/* $login = new Login;
$login->setarSexo('masculino');
echo $login->pegarSexo(); */
