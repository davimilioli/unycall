<?php
require_once(__DIR__ . '/../../config/config_db.php');

require_once(__DIR__ . '/../../modelSql/UsuarioMySql.php');
$usuarioSql = new UsuarioMySql($pdo);



var_dump($_POST);
$nome = filter_input(INPUT_POST, 'nome');
$nascimento = filter_input(INPUT_POST, 'nascimento');
$cpf = filter_input(INPUT_POST, 'cpf');
$nomeMaterno = filter_input(INPUT_POST, 'nomeMaterno');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$sexo = filter_input(INPUT_POST, 'sexo');
$celular = filter_input(INPUT_POST, 'celular');
$telefone = filter_input(INPUT_POST, 'telefone');
$login  = filter_input(INPUT_POST, 'login');
$senha = filter_input(INPUT_POST, 'senha');
/* ------------------------------------------------ */
/* $cep = filter_input(INPUT_POST, 'cep');
$endereco = filter_input(INPUT_POST, 'endereco');
$numero = filter_input(INPUT_POST, 'numend', FILTER_VALIDATE_INT);
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$complemento = filter_input(INPUT_POST, 'complemento'); */

if ($nome && $nascimento && $cpf && $nomeMaterno && $email && $sexo && $celular && $telefone && $login && $senha) {

    if ($usuarioSql->consultarEmail($email) === false) {
        $dados = new Usuario();
        $dados->setarNome($nome);
        $dados->setarNascimento($nascimento);
        $dados->setarEmail($email);
        $dados->setarCpf($cpf);
        $dados->setarNomeMaterno($nomeMaterno);
        $dados->setarSexo($sexo);
        $dados->setarCelular($celular);
        $dados->setarTelefone($telefone);
        $dados->setarLogin($login);
        $dados->setarSenha($senha);
        $usuarioSql->criarUsuario($dados);
        header('location: ../login/login.php');
        exit;
    } else {
        header('location: cadastro.php?msgSistema=email');
        exit;
    }
} else {
    header('location: cadastro.php?msgSistema=campos');
    exit;
}


/* if ($cep && $endereco && $numero && $bairro && $cidade && $estado) {
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
 */