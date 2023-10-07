<?php

class Endereco
{
    private int $id;
    private int $id_usuario;
    private string $cep;
    private string $endereco;
    private int $numero;
    private string $bairro;
    private string $cidade;
    private string $estado;
    private ?string $complemento;

    public function __construct(int $id = 0, int $id_usuario = 0)
    {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
    }

    public function setarIdEndereco(int $id)
    {
        $this->id = trim($id);
    }

    public function pegarIdEndereco(): int
    {
        return $this->id;
    }

    public function setarIdUsuarioEndereco(int $id_usuario)
    {
        $this->id_usuario = trim($id_usuario);
    }

    public function pegarIdUsuarioEndereco(): int
    {
        return $this->id_usuario;
    }

    public function setarCepEndereco(string $cep)
    {
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $this->cep = trim($cep);
    }

    public function pegarCepEndereco(): string
    {
        return $this->cep;
    }

    public function setarLogradouroEndereco(string $endereco)
    {
        $this->endereco = trim($endereco);
    }

    public function pegarLogradouroEndereco(): string
    {
        return $this->endereco;
    }

    public function setarNumeroEndereco(int $numero)
    {
        $this->numero = trim($numero);
    }

    public function pegarNumeroEndereco(): int
    {
        return $this->numero;
    }

    public function setarBairroEndereco(string $bairro)
    {
        $this->bairro = ucwords(trim($bairro));
    }

    public function pegarBairroEndereco(): string
    {
        return $this->bairro;
    }

    public function setarCidadeEndereco(string $cidade)
    {
        $this->cidade = ucwords(trim($cidade));
    }

    public function pegarCidadeEndereco(): string
    {
        return $this->cidade;
    }

    public function setarEstadoEndereco(string $estado)
    {
        $this->estado = strtoupper(strtoupper(trim($estado)));
    }

    public function pegarEstadoEndereco(): string
    {
        return $this->estado;
    }

    public function setarComplementoEndereco(?string $complemento)
    {
        $this->complemento = $complemento;
    }

    public function pegarComplementoEndereco(): ?string
    {
        return $this->complemento;
    }
}

interface EnderedoSqlInterface
{
    public function criarEndereco(Endereco $endereco);
}
/* $endereco = new Endereco();
$endereco->setarCepEndereco('21765-370');
echo $endereco->pegarCepEndereco(); */
