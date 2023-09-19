<?php
require_once '../../config/config_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /*     $array = ['nome', 'nascimento', 'cpf', 'email', 'celular', 'telefone', 'login', 'senha'];
    foreach ($array as $input) {
        $inputs = $_POST[$input];
        echo $inputs;
    } */
}
$nome = filter_input(INPUT_POST, 'nome');
$nascimento = filter_input(INPUT_POST, 'nascimento');
$dataFormatada = date_create_from_format('d/m/Y', $nascimento);

if ($dataFormatada !== false) {
    $nascimento = $dataFormatada->format('Y-m-d');
}

$cpf = filter_input(INPUT_POST, 'cpf', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$sexo = filter_input(INPUT_POST, 'sexo');
$celular = filter_input(INPUT_POST, 'celular', FILTER_VALIDATE_INT);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_VALIDATE_INT);
$login = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');
/* ------------------------------------------------ */
$cep = filter_input(INPUT_POST, 'cep');
$endereco = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend', FILTER_VALIDATE_INT);
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento');


var_dump($_POST);
if ($nome && $nascimento && $cpf && $email && $sexo && $celular && $telefone && $login && $senha) {
    $sql = $pdo->prepare("INSERT INTO usuarios (nome, nascimento, cpf, email, sexo, celular, telefone, login, senha) VALUES (:nome, :nascimento, :cpf, :email, :sexo, :celular, :telefone, :login, :senha)");
    $sql->bindParam(':nome', $nome);
    $sql->bindParam(':nascimento', $nascimento);
    $sql->bindParam(':cpf', $cpf);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':sexo', $sexo);
    $sql->bindParam(':celular', $celular);
    $sql->bindParam(':telefone', $telefone);
    $sql->bindParam(':login', $login);
    $sql->bindParam(':senha', $senha);
    $sql->execute();
}

if ($cep && $endereco && $numero && $bairro && $cidade && $estado) {
    $sql = $pdo->prepare("INSERT INTO endereco (id_usuario, cep, endereco, numero, bairro, cidade, estado, complemento) VALUES (:id_usuario, :cep, :endereco, :numero, :bairro, :cidade, :estado, :complemento)");
    $insertId = $pdo->lastInsertId();
    $sql->bindParam(':id_usuario', $insertId);
    $sql->bindParam(':cep', $cep);
    $sql->bindParam(':endereco', $endereco);
    $sql->bindParam(':numero', $numero);
    $sql->bindParam(':bairro', $bairro);
    $sql->bindParam(':cidade', $cidade);
    $sql->bindParam(':estado', $estado);
    $sql->bindParam(':complemento', $complemento);

    $sql->execute();
}
