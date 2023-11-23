<?php
require_once('Assinatura.php');
require_once('Pagamento.php');
require_once('Servico.php');
require_once('GerenciadorMySql.php');
require_once('Modulos.php');

class Gerenciador
{
    private $GerenciadorMySql;

    public function __construct($pdo)
    {
        $this->GerenciadorMySql = new GerenciadorMySql($pdo);
    }

    public function servicosDisponiveis()
    {
        $servicosDisponiveis = [];
        $servicos = $this->GerenciadorMySql->consultarServicos();

        foreach ($servicos as $item) {
            if ($item->pegarServicoStatus() != 0) {

                $servicosDisponiveis[] = array(
                    'id' => $item->pegarServicoId(),
                    'nome' => $item->pegarServicoNome(),
                    'custo' => str_replace('.', ',', $item->pegarServicoCusto()),
                    'tipo' => $item->pegarServicoTipo(),
                    'disp_regiao' => $item->pegarDispRegiao()
                );
            }
        }

        return $servicosDisponiveis;
    }

    public function enviarDadosPagamento(array $arrayPagamento)
    {
        $cpfFormatado = str_replace(['.', '-'], '', $arrayPagamento['cpf']);
        $pagamento = new Pagamento();
        $pagamento->setarPgtoIdTransacao($arrayPagamento['id_transacao']);
        $pagamento->setarPgtoNome($arrayPagamento['nome']);
        $pagamento->setarPgtoCpf($cpfFormatado);
        $pagamento->setarServicoAssinado($arrayPagamento['servico_assinado']);
        $pagamento->setarServicoPreco($arrayPagamento['preco']);
        $pagamento->setarDataPagamento(date("Y-m-d"));

        $this->GerenciadorMySql->cadastrarPagamento($pagamento);

        return true;
    }

    public function enviarDadosAssinatura(array $arrayAssinatura)
    {
        $dataAtual = new DateTime();
        $dataExpiracao = $dataAtual->add(new DateInterval('P30D'));
        $dataExpiracaoFormatada = $dataExpiracao->format('Y-m-d');

        $assinatura = new Assinatura();
        $assinatura->setarIdAssUsuario($arrayAssinatura['id_usuario']);
        $assinatura->setaridAssServico($arrayAssinatura['id_servico']);
        $assinatura->setarIdAssTransacao($arrayAssinatura['id_transacao']);
        $assinatura->setarAssDataInicio(date("Y-m-d"));
        $assinatura->setarAssDataExpiracao($dataExpiracaoFormatada);
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
        $modulos = new Modulos();

        foreach ($consultarAssinatura as $assinatura) {
            if ($assinatura->pegarIdAssUsuario() == $id) {
                foreach ($consultarPagamentos as $pagamento) {
                    if ($assinatura->pegarIdAssTransacao() == $pagamento->pegarPgtoIdTransacao()) {
                        $comprovantePgto = array(
                            'id_transacao' => $pagamento->pegarPgtoIdTransacao(),
                            'nome' => $pagamento->pegarPgtoNome(),
                            'cpf' => $modulos->formatarCpf($pagamento->pegarPgtoCpf()),
                            'servico_assinado' => $pagamento->pegarServicoAssinado(),
                            'preco_servico' => str_replace('.', ',', $pagamento->pegarServicoPreco()),
                            'total' => $pagamento->pegarTotal(),
                            'data' => date("d/m/Y", strtotime($pagamento->pegarDataPagamento()))
                        );

                        $servico = array(
                            'ativo' => true,
                            'servico_assinado' => $pagamento->pegarServicoAssinado(),
                            'preco_servico' => $pagamento->pegarServicoPreco(),
                            'data_inicio' => date("d/m/Y", strtotime($assinatura->pegarAssDataInicio())),
                            'data_expiracao' => date("d/m/Y", strtotime($assinatura->pegarAssDataExpiracao()))
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
        return true;
    }
}
