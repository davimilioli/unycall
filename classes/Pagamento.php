<?php

class Pagamento
{
    private int $id;
    private string $id_transacao;
    private string $nome;
    private string $cpf;
    private string $servico_assinado;
    private string $preco_servico;
    private float $total;
    private string $data_pagamento;

    public function setarPgtoId(int $id)
    {
        $this->id = trim($id);
    }

    public function pegarPgtoId(): int
    {
        return $this->id;
    }

    public function setarPgtoIdTransacao(string $id_transacao)
    {
        $this->id_transacao = trim($id_transacao);
    }

    public function pegarPgtoIdTransacao(): string
    {
        return $this->id_transacao;
    }

    public function setarPgtoNome(string $nome)
    {
        $this->nome = ucwords(trim($nome));
    }

    public function pegarPgtoNome(): string
    {
        return $this->nome;
    }

    public function setarPgtoCpf(int $cpf)
    {
        $this->cpf = $cpf;
    }

    public function pegarPgtoCpf(): int
    {
        return $this->cpf;
    }

    public function setarServicoAssinado(string $servico_assinado)
    {
        $this->servico_assinado = $servico_assinado;
    }

    public function pegarServicoAssinado(): string
    {
        return $this->servico_assinado;
    }

    public function setarServicoPreco(string $preco_servico)
    {
        $this->preco_servico = $preco_servico;
    }

    public function pegarServicoPreco(): string
    {
        return $this->preco_servico;
    }

    public function setarTotal(float $total)
    {
        $this->total = $total;
    }

    public function pegarTotal(): float
    {
        return $this->total;
    }

    public function setarDataPagamento(string $data_pagamento)
    {
        $this->data_pagamento = $data_pagamento;
    }

    public function pegarDataPagamento(): string
    {
        return $this->data_pagamento;
    }
}
