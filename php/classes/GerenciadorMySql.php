<?php

require_once(__DIR__ . '../../config/config_db.php');
require_once('Gerenciador.php');


class GerenciadorMySql
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function consultarServicos()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM servicos");

        if ($sql->rowCount() > 0) {
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dados as $item) {

                $servico = new Servico();
                $servico->setarServicoId($item['id']);
                $servico->setarServicoTipo($item['tipo']);
                $servico->setarServicoNome($item['nome']);
                $servico->setarDispRegiao($item['disp_regiao']);
                $servico->setarServicoCusto($item['custo']);
                $array[] = $servico;
            }
        }

        return $array;
    }
}
