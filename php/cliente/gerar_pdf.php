<?php
require_once('../autoload.php');
require_once('./modulos/modulos.php');
require_once('../lib/tcpdf/tcpdf.php');

$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$lista = $sistema->consultarDadosUsuario();

$pdf = new TCPDF();
$pdf->SetTitle('Lista de Usuários');
$pdf->AddPage();

$html = '<h1 style="text-align: center;">Lista de Usuários</h1>';
$html .= '<table style="width: 100%; border-collapse: collapse;">';
$html .= '<thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">#</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">Nome</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">CPF</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">Email</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">Celular</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">Telefone</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center;">Permissão</th>
            </tr>
        </thead>';

foreach ($lista as $item) {
    $html .= '<tbody>
                <tr>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . $item->pegarId() . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . $item->pegarNome() . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . formatarCpf($item->pegarCpf()) . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . $item->pegarEmail() . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . formatarNumero($item->pegarCelular()) . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center;">' . formatarNumero($item->pegarTelefone()) . '</td>
                    <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; background-color: ' . ($item->pegarPermissao() == null ? '#f2f2f2' : '#FFF') . ';" id="' . ($item->pegarPermissao() == null ? 'comum' : $item->pegarPermissao()) . '">
                        <p>' . ($item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao())) . '</p>
                    </td>
                </tr>
            </tbody>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Defina o cabeçalho Content-Disposition para indicar que o arquivo é um anexo para download
header('Content-Disposition: attachment; filename="lista.pdf.pdf"');

// Saída do PDF para o navegador
$pdf->Output('lista.pdf', 'I');
