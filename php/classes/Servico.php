<?php

class Servico
{
    private int $id;
    private string $tipo;
    private string $nome;
    private string $disp_regiao;
    private float $custo;

    public function setarServicoId(int $id)
    {
        $this->id = $id;
    }

    public function pegarServicoId(): int
    {
        return $this->id;
    }

    public function setarServicoTipo(string $tipo)
    {
        $this->tipo = $tipo;
    }

    public function pegarServicoTipo(): string
    {
        return $this->tipo;
    }
    public function setarServicoNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function pegarServicoNome(): string
    {
        return $this->nome;
    }

    public function setarDispRegiao(string $disp_regiao)
    {
        $this->disp_regiao = $disp_regiao;
    }

    public function pegarDispRegiao(): string
    {
        return $this->disp_regiao;
    }

    public function setarServicoCusto(float $custo)
    {
        $this->custo = $custo;
    }

    public function pegarServicoCusto(): float
    {
        return $this->custo;
    }
}
