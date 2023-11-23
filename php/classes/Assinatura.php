<?php

class Assinatura
{
    private int $id;
    private int $id_usuario;
    private string $id_transacao;
    private int $id_servico;
    private string $data_inicio;
    private string $data_expiracao;

    public function setarIdAss(int $id)
    {
        $this->id = trim($id);
    }

    public function pegarIdAss(): int
    {
        return $this->id;
    }

    public function setarIdAssUsuario(int $id_usuario)
    {
        $this->id_usuario = trim($id_usuario);
    }

    public function pegarIdAssUsuario(): int
    {
        return $this->id_usuario;
    }

    public function setarIdAssTransacao(string $id_transacao)
    {
        $this->id_transacao = trim($id_transacao);
    }

    public function pegarIdAssTransacao(): string
    {
        return $this->id_transacao;
    }

    public function setaridAssServico(int $id_servico)
    {
        $this->id_servico = trim($id_servico);
    }

    public function pegaridAssServico(): int
    {
        return $this->id_servico;
    }

    public function setarAssDataInicio(string $data_inicio)
    {
        $this->data_inicio = $data_inicio;
    }

    public function pegarAssDataInicio(): string
    {
        return $this->data_inicio;
    }

    public function setarAssDataExpiracao(string $data_expiracao)
    {
        $this->data_expiracao = $data_expiracao;
    }

    public function pegarAssDataExpiracao(): string
    {
        return $this->data_expiracao;
    }
}
