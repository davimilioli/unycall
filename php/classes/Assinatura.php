<?php

class Assinatura
{
    private int $id;
    private int $id_usuario;
    private int $id_pagamento;
    private int $id_servico;

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

    public function setarIdAssPgto(int $id_pagamento)
    {
        $this->id_pagamento = trim($id_pagamento);
    }

    public function pegarIdAssPgto(): int
    {
        return $this->id_pagamento;
    }

    public function setaridAssServico(int $id_servico)
    {
        $this->id_servico = trim($id_servico);
    }

    public function pegaridAssServico(): int
    {
        return $this->id_servico;
    }
}
