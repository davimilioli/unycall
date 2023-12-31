<?php
require_once('Gerenciador.php');

class GerenciadorMySql
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function criarServico(Servico $servico)
    {
        $sql = $this->pdo->prepare("INSERT INTO servicos (tipo, nome, disp_regiao, custo, status) VALUES (:tipo, :nome, :disp_regiao, :custo, :status)");
        $sql->bindValue(':tipo', $servico->pegarServicoTipo());
        $sql->bindValue(':nome', $servico->pegarServicoNome());
        $sql->bindValue(':disp_regiao', $servico->pegarDispRegiao());
        $sql->bindValue(':custo', $servico->pegarServicoCusto());
        $sql->bindValue(':status', $servico->pegarServicoStatus());
        $sql->execute();

        $servico->setarServicoId($this->pdo->lastInsertId());

        return true;
    }

    public function excluirServico($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM servicos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return true;
    }

    public function atualizarServico(Servico $servico)
    {
        $sql = $this->pdo->prepare("UPDATE servicos SET tipo = :tipo, nome = :nome, disp_regiao = :disp_regiao, custo = :custo, status = :status WHERE id = :id");
        $sql->bindValue(':tipo', $servico->pegarServicoTipo());
        $sql->bindValue(':nome', $servico->pegarServicoNome());
        $sql->bindValue(':disp_regiao', $servico->pegarDispRegiao());
        $sql->bindValue(':custo', $servico->pegarServicoCusto());
        $sql->bindValue(':status', $servico->pegarServicoStatus());
        $sql->bindValue(':id', $servico->pegarServicoId());
        $sql->execute();

        return true;
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
                $servico->setarServicoStatus($item['status']);
                $array[] = $servico;
            }
        }

        return $array;
    }

    public function cadastrarPagamento(Pagamento $pagamento)
    {
        $sql = $this->pdo->prepare("INSERT INTO pagamentos (id_transacao, nome, cpf, servico_assinado, preco_servico, total, data_pagamento) VALUES (:id_transacao, :nome, :cpf, :servico_assinado, :preco_servico, :total, :data_pagamento)");
        $sql->bindValue(':id_transacao', $pagamento->pegarPgtoIdTransacao());
        $sql->bindValue(':nome', $pagamento->pegarPgtoNome());
        $sql->bindValue(':cpf', $pagamento->pegarPgtoCpf());
        $sql->bindValue(':servico_assinado', $pagamento->pegarServicoAssinado());
        $sql->bindValue(':preco_servico', $pagamento->pegarServicoPreco());
        $sql->bindValue(':total', $pagamento->pegarServicoPreco());
        $sql->bindValue(':data_pagamento', $pagamento->pegarDataPagamento());
        $sql->execute();
        $pagamento->setarPgtoId($this->pdo->lastInsertId());

        return $pagamento;
    }

    public function cadastrarAssinatura(Assinatura $assinatura)
    {
        $sql = $this->pdo->prepare(
            "INSERT INTO assinaturas (id_usuario, id_transacao, id_servico ,data_inicio ,data_expiracao) VALUES (:id_usuario, :id_transacao, :id_servico, :data_inicio, :data_expiracao)"
        );
        $sql->bindValue(':id_usuario', $assinatura->pegarIdAssUsuario());
        $sql->bindValue(':id_transacao', $assinatura->pegarIdAssTransacao());
        $sql->bindValue(':id_servico', $assinatura->pegaridAssServico());
        $sql->bindValue(':data_inicio', $assinatura->pegarAssDataInicio());
        $sql->bindValue(':data_expiracao', $assinatura->pegarAssDataExpiracao());

        $sql->execute();

        $assinatura->setarIdAss($this->pdo->lastInsertId());

        return $assinatura;
    }

    public function consultarPagamentos()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM pagamentos");

        if ($sql->rowCount() > 0) {

            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $item) {
                $pagamento = new Pagamento();
                $pagamento->setarPgtoId($item['id']);
                $pagamento->setarPgtoIdTransacao($item['id_transacao']);
                $pagamento->setarPgtoNome($item['nome']);
                $pagamento->setarPgtoCpf($item['cpf']);
                $pagamento->setarServicoAssinado($item['servico_assinado']);
                $pagamento->setarServicoPreco($item['preco_servico']);
                $pagamento->setarTotal($item['total']);
                $pagamento->setarDataPagamento($item['data_pagamento']);

                $array[] = $pagamento;
            }
        }

        return $array;
    }

    public function consultarAssinaturas()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM assinaturas");

        if ($sql->rowCount() > 0) {

            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $item) {
                $assinatura = new Assinatura();
                $assinatura->setarIdAss($item['id']);
                $assinatura->setarIdAssUsuario($item['id_usuario']);
                $assinatura->setarIdAssTransacao($item['id_transacao']);
                $assinatura->setaridAssServico($item['id_servico']);
                $assinatura->setarAssDataInicio($item['data_inicio']);
                $assinatura->setarAssDataExpiracao($item['data_expiracao']);

                $array[] = $assinatura;
            }
        }

        return $array;
    }

    public function excluirAssinatura($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM assinaturas WHERE id_usuario = :id_usuario");
        $sql->bindValue(':id_usuario', $id);
        $sql->execute();
        return true;
    }
}
