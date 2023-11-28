<?php
require_once('../../autoload.php');
require_once('../../lib/tcpdf/tcpdf.php');

$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());
$lista = $sistema->consultarDadosUsuario();

$pdf = new TCPDF();
$pdf->SetTitle('Lista de Usuários');
$pdf->AddPage();

$pdf->Image(__DIR__ . '/assets/img/logo.png', 10, 10, 50, 50);

$html = '
    <style>
        h1{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }
        tr{
            background-color: #f2f2f2;
        }

        th,td{
            border: 1px solid #ddd;
        }

        tr, th, td{
            border: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            width: 76px;
        }  

        img{
            width: 50px;
        }
    </style>

    <div style="text-align: center;">
        <img src="/assets/img/logo.png">
    </div>

<h1>Lista de Usuários</h1>';

$html .= '<table>';
$html .= '<thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Telefone</th>
                <th>Permissao</th>
            </tr>
        </thead>';

$html .= '<tbody>';
foreach ($lista as $usuario) {
    $html .= '<tr>
                <td>' . $usuario['id'] . '</td>
                <td>' . $usuario['nome'] . '</td>
                <td>' . $usuario['cpf'] . '</td>
                <td>' . $usuario['email'] . '</td>
                <td>' . $usuario['celular'] . '</td>
                <td>' . $usuario['telefone'] . '</td>
                <td>' . $usuario['permissao'] . '</td>
                
            </tr>';
}
$html .= '</tbody>';

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

header('Content-Disposition: attachment; filename="lista.pdf"');

$pdf->Output('lista.pdf', 'I');
