<?php
require_once('../../autoload.php');
require_once('../../lib/tcpdf/tcpdf.php');

$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$gerenciador = new Gerenciador($banco->pegarPdo());
$id = $_GET['id'];
$assinaturaAtivaInfo = $gerenciador->assinaturaAtiva($id)['comprovante'];
$dados = $sistema->procurarIdUsuario($id);

$pdf = new TCPDF();
$pdf->SetTitle('Comprovante');
$pdf->AddPage();

$pdf->Image(__DIR__ . '/assets/img/logo.png', 10, 10, 50, 50);


$html = '
  <style>
    h2{
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      border: 1px solid #000;
      text-align: center;
      padding: 8px;
    }

    thead {
      background-color: #f2f2f2;
    }

    tfoot {
      font-weight: bold;
    }

    .info {
      margin-bottom: 20px;
    }

    img{
      width: 50px;
    }
  </style>
  <div style="text-align: center;">
    <img src="/assets/img/logo.png">
  </div>
  <h2>Comprovante de Pagamento</h2>

  <div class="info">
    <p><strong>ID Transação:</strong> ' . $assinaturaAtivaInfo['id_transacao'] . '</p>
    <p><strong>Cliente:</strong> ' . $assinaturaAtivaInfo['nome'] . '</p>
    <p><strong>CPF:</strong> ' . $assinaturaAtivaInfo['cpf'] . '</p>
    <p><strong>Serviço Assinado:</strong> ' . $assinaturaAtivaInfo['servico_assinado'] . '</p>
    <p><strong>Data:</strong> ' . $assinaturaAtivaInfo['data'] . '</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>Item</th>
        <th>Descrição</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>' . $assinaturaAtivaInfo['servico_assinado'] .  '</td>
        <td>1</td>
        <td> R$ ' . $assinaturaAtivaInfo['total'] . '</td>
        <td> R$ ' . $assinaturaAtivaInfo['total'] . '</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4">Total:</td>
        <td>R$ ' . $assinaturaAtivaInfo['total'] . '</td>
      </tr>
    </tfoot>
  </table>';

$pdf->writeHTML($html, true, false, true, false, '');
header('Content-Disposition: attachment; filename="comprovante-' . $assinaturaAtivaInfo['id_transacao'] . '.pdf"');
$pdf->Output('comprovante-' . $assinaturaAtivaInfo['id_transacao'] . '.pdf', 'I');
