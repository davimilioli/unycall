<?php
require_once('Assinatura.php');
require_once('Pagamento.php');
require_once('Servico.php');
require_once('GerenciadorMySql.php');

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

    public function enviarDadosPagamento(array $arrayPagamento)
    {
        echo 'Enviar dados pagamento: ' . $arrayPagamento['id_transacao'];
        $cpfFormatado = str_replace(['.', '-'], '', $arrayPagamento['cpf']);
        $dataFormatada = date("Y-m-d", strtotime(str_replace("/", "-", $arrayPagamento['data'])));
        $pagamento = new Pagamento();
        $pagamento->setarPgtoIdTransacao($arrayPagamento['id_transacao']);
        $pagamento->setarPgtoNome($arrayPagamento['nome']);
        $pagamento->setarPgtoCpf($cpfFormatado);
        $pagamento->setarServicoAssinado($arrayPagamento['servico_assinado']);
        $pagamento->setarServicoPreco($arrayPagamento['preco']);
        $pagamento->setarDataPagamento($dataFormatada);

        $this->GerenciadorMySql->cadastrarPagamento($pagamento);

        return true;
    }

    public function enviarDadosAssinatura(array $arrayAssinatura)
    {
        $assinatura = new Assinatura();
        $assinatura->setarIdAssUsuario($arrayAssinatura['id_usuario']);
        $assinatura->setaridAssServico($arrayAssinatura['id_servico']);
        $assinatura->setarIdAssTransacao($arrayAssinatura['id_transacao']);

        $this->GerenciadorMySql->cadastrarAssinatura($assinatura);

        return true;
    }

    public function pagamentos()
    {
        return $this->GerenciadorMySql->consultarPagamentos();
    }

    public function assinaturas()
    {
        return $this->GerenciadorMySql->consultarAssinaturas();
    }

    public function assinaturaAtiva($id)
    {
        $consultarAssinatura = $this->assinaturas();
        $consultarPagamentos = $this->pagamentos();

        foreach ($consultarAssinatura as $assinatura) {
            if ($assinatura->pegarIdAssUsuario() == $id) {
                foreach ($consultarPagamentos as $pagamento) {
                    if ($assinatura->pegarIdAssTransacao() == $pagamento->pegarPgtoIdTransacao()) {
                        $comprovantePgto = array(
                            'id_transacao' => $pagamento->pegarPgtoIdTransacao(),
                            'nome' => $pagamento->pegarPgtoNome(),
                            'cpf' => $pagamento->pegarPgtoCpf(),
                            'servico_assinado' => $pagamento->pegarServicoAssinado(),
                            'preco_servico' => $pagamento->pegarServicoPreco(),
                            'total' => $pagamento->pegarTotal(),
                            'data' => date("d/m/Y", strtotime($pagamento->pegarDataPagamento()))
                        );

                        $servico = array(
                            'ativo' => true,
                            'servico_assinado' => $pagamento->pegarServicoAssinado(),
                            'preco_servico' => $pagamento->pegarServicoPreco(),
                            'data' => date("d/m/Y", strtotime($pagamento->pegarDataPagamento()))

                        );
                        return array(
                            'comprovante' => $comprovantePgto,
                            'servico' => $servico,
                        );
                    }
                }
            }
        }
    }

    public function enviarExclusao($id)
    {
        $this->GerenciadorMySql->excluirAssinatura($id);
        header('location: /php/cliente/assinatura/gerenciar.php');
        exit;
    }
}
