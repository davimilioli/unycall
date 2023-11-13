<?php
require_once('../autoload.php');
require_once('../lib/tcpdf/tcpdf.php');

$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$lista = $sistema->consultarDadosUsuario();

$pdf = new TCPDF();
$pdf->SetTitle('Lista de Usuários');
$pdf->AddPage();

$pdf->Image(__DIR__ . '/assets/img/logo.png', 10, 10, 50, 50);

$html = '<h1 style="text-align: center;">Lista de Usuários</h1>';
$html .= '<table style="width: 100%; border-collapse: collapse;">';
$html .= '<thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 30px">#</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">Nome</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">CPF</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">Email</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 90px;">Celular</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 90px;">Telefone</th>
                <th style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">Permissao</th>

            </tr>
        </thead>';

$html .= '<tbody>';
foreach ($lista as $usuario) {
    $html .= '<tr>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 30px;">' . $usuario['id'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">' . $usuario['nome'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">' . $usuario['cpf'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px;">' . $usuario['email'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 90px;">' . $usuario['celular'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 90px;">' . $usuario['telefone'] . '</td>
                <td style="border: 1px solid #ddd; font-size: 10px; text-align: center; width: 80px; ">' . $usuario['permissao'] . '</td>
                
            </tr>';
}
$html .= '</tbody>';

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

header('Content-Disposition: attachment; filename="lista.pdf"');

$pdf->Output('lista.pdf', 'I');
