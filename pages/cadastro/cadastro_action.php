<?php
// Verifica se a solicitação é um POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe os dados enviados via POST
    $data = json_decode(file_get_contents("php://input"));
    echo $data;

    // Processa os dados (por exemplo, insere no banco de dados)
    // ...

    // Verifica se o processamento foi bem-sucedido
    $sucesso = true; // Defina como true se for bem-sucedido, caso contrário, defina como false

    // Prepara a resposta
    $resposta = ['sucesso' => $sucesso];

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    echo json_encode($resposta);
} else {
    // Responde com erro se não for uma solicitação POST
    http_response_code(405); // Método não permitido
    echo "Método não permitido";
}
