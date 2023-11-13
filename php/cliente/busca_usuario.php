<?php
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

function listaBusca($sistema)
{
    $lista = $sistema->consultarDadosUsuario();
    $dados = array();
    foreach ($lista as $usuario) {
        $dados[] =  array(
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'cpf' => $usuario['cpf'],
            'celular' => $usuario['celular'],
            'telefone' => $usuario['telefone'],
            'login' => $usuario['login'],
            'permissao' => $usuario['permissao']

        );
    }

    return $dados;
}

$dados = listaBusca($sistema);
if ($dados) {
    echo json_encode($dados);
} else {
    echo $dados = [];
}
