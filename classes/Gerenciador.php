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
        $pagamento->setarServicoPreco($this->precoServico($arrayPagamento['servico_assinado']));
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

    private function precoServico($servico_assinado)
    {
        $resultado = '';
        $servicos = $this->servicosDisponiveis();

        foreach ($servicos as $item) {
            if ($item['nome'] == $servico_assinado) {
                $resultado = str_replace(',', '.', $item['custo']);
            }
        }

        return $resultado;
    }

    public function pagamentos()
    {
        $pagamentos = [];
        $consultarPagamentos = $this->GerenciadorMySql->consultarPagamentos();
        $modulos = new Modulos();
        foreach ($consultarPagamentos as $pagamento) {
            $pagamentos[] = array(
                'id_transacao' => $pagamento->pegarPgtoIdTransacao(),
                'nome' => $pagamento->pegarPgtoNome(),
                'cpf' => $modulos->formatarCpf($pagamento->pegarPgtoCpf()),
                'servico_assinado' => $pagamento->pegarServicoAssinado(),
                'preco_servico' => str_replace('.', ',', $pagamento->pegarServicoPreco()),
                'total' => str_replace('.', ',', $pagamento->pegarTotal()),
                'data' => date("d/m/Y", strtotime($pagamento->pegarDataPagamento()))
            );
        }

        return $pagamentos ?? [];
    }

    public function assinaturas()
    {
        $assinaturasAtivas = [];
        $consultarAssinaturas = $this->GerenciadorMySql->consultarAssinaturas();
        foreach ($consultarAssinaturas as $assinatura) {
            $assinaturasAtivas[] = array(
                'id_usuario' => $assinatura->pegarIdAssUsuario(),
                'id_transacao' => $assinatura->pegarIdAssTransacao(),
                'id_servico' => $assinatura->pegaridAssServico(),
                'data_inicio' => $assinatura->pegarAssDataInicio(),
                'data_expiracao' => $assinatura->pegarAssDataExpiracao()
            );
        }

        return $assinaturasAtivas ?? [];
    }

    public function assinaturaAtiva($id)
    {

        $consultarAssinatura = $this->assinaturas();
        $consultarPagamentos = $this->pagamentos();
        foreach ($consultarAssinatura as $assinatura) {
            if ($assinatura['id_usuario'] == $id) {
                foreach ($consultarPagamentos as $pagamento) {
                    if ($assinatura['id_transacao'] == $pagamento['id_transacao']) {
                        $comprovantePgto = array(
                            'id_transacao' => $pagamento['id_transacao'],
                            'nome' => $pagamento['nome'],
                            'cpf' => $pagamento['cpf'],
                            'servico_assinado' => $pagamento['servico_assinado'],
                            'preco_servico' => $pagamento['preco_servico'],
                            'total' => $pagamento['total'],
                            'data' => $pagamento['data']
                        );

                        $servico = array(
                            'ativo' => true,
                            'servico_assinado' => $pagamento['servico_assinado'],
                            'preco_servico' => $pagamento['preco_servico'],
                            'data_inicio' => date("d/m/Y", strtotime($assinatura['data_inicio'])),
                            'data_expiracao' => date("d/m/Y", strtotime($assinatura['data_expiracao'])),
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
