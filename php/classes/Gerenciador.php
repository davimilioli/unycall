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
    }

    public function enviarDadosAssinatura(array $arrayAssinatura)
    {
        $assinatura = new Assinatura();
        $assinatura->setarIdAssUsuario($arrayAssinatura['id_usuario']);
        $assinatura->setaridAssServico($arrayAssinatura['id_servico']);
        $assinatura->setarIdAssTransacao($arrayAssinatura['id_transacao']);

        $this->GerenciadorMySql->cadastrarAssinatura($assinatura);
    }

    public function pagamentos()
    {
        return $this->GerenciadorMySql->consultarPagamentos();
    }

    public function assinaturas()
    {
        return $this->GerenciadorMySql->consultarAssinaturas();
    }
}
