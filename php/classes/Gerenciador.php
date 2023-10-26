<?php

require_once('Assinatura.php');
require_once('Pagamento.php');
require_once('Servico.php');
require_once('GerenciadorMySql.php');
require_once('../../config/config_db.php');


class Gerenciador
{

    private $GerenciadorMySql;

    public function __construct($pdo)
    {
        $this->GerenciadorMySql = new GerenciadorMySql($pdo);
    }

    public function servicosDisponiveis()
    {
        return $this->GerenciadorMySql->consultarServicos();
    }
}
