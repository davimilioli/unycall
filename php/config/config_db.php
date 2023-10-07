<?php
// CONFIG DB
$db_host = 'localhost';
$db_name = 'db_site';
$db_charset = 'utf8';
$db_user = 'root';
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

function inserirUsuario($pdo)
{
    $nomes = ["João Dos Santos", "Maria Souza", "Pedro Cabral", "Ana", "Carlos"];
    $sobrenomes = ["Silva", "Santos", "Oliveira", "Pereira", "Ferreira"];

    $nome = $nomes[array_rand($nomes)];
    $sobrenome = $sobrenomes[array_rand($sobrenomes)];
    $nascimento = date('Y-m-d', mt_rand(strtotime('1970-01-01'), strtotime('2000-12-31')));
    $cpf = rand(10000000000, 99999999999);
    $email = strtolower($nome . "." . $sobrenome . "@exemplo.com");
    $sexo = rand(0, 1) ? "Masculino" : "Feminino";
    $celular = "9" . rand(100000000, 999999999);
    $telefone = "3" . rand(10000000, 99999999);
    $login = strtolower($nome[0] . $sobrenome);
    $senha = password_hash($login, PASSWORD_DEFAULT);

    $emailSemEspacos = str_replace(' ', '', $email);
    $sql = "INSERT INTO usuarios (nome, nascimento, cpf, email, nomematerno, sexo, celular, telefone, login, senha) 
            VALUES (:nome, :nascimento, :cpf, :email, :nomematerno, :sexo, :celular, :telefone, :login, :senha)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':nascimento', $nascimento);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $emailSemEspacos);
    $stmt->bindParam(':nomematerno', $sobrenome);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    $lastUserId = $pdo->lastInsertId();

    return $lastUserId;
}


/* for ($i = 0; $i < 10; $i++) {
    $lastUserId = inserirUsuario($pdo);
    inserirEndereco($pdo, $lastUserId);
}

echo "Foi!"; */


function inserirEndereco($pdo, $id_usuario)
{
    $ceps = ["12345678", "98765432", "54321876", "87654321"];
    $logradouros = ["Rua A", "Avenida B", "Praça C", "Estrada D"];
    $numeros = ["123", "456", "789", "1011"];
    $bairros = ["Bairro X", "Bairro Y", "Bairro Z"];
    $cidades = ["Cidade 1", "Cidade 2", "Cidade 3"];
    $estados = ["SP", "RJ", "MG"];
    $complementos = ["Apto 101", "Casa 202", "Bloco B"];

    $cep = $ceps[array_rand($ceps)];
    $logradouro = $logradouros[array_rand($logradouros)];
    $numero = $numeros[array_rand($numeros)];
    $bairro = $bairros[array_rand($bairros)];
    $cidade = $cidades[array_rand($cidades)];
    $estado = $estados[array_rand($estados)];
    $complemento = $complementos[array_rand($complementos)];

    $sql = "INSERT INTO endereco (id_usuario, cep, logradouro, numero, bairro, cidade, estado, complemento)
            VALUES (:id_usuario, :cep, :logradouro, :numero, :bairro, :cidade, :estado, :complemento)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':complemento', $complemento);

    $stmt->execute();
}
