<?php
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

function listaBusca($sistema)
{
    $lista = $sistema->consultarDadosUsuario();
    $dados = array();
    foreach ($lista as $item) {
        $dados[] =  array(
            'id' => $item->pegarId(),
            'nome' => $item->pegarNome(),
            'email' => $item->pegarEmail(),
            'cpf' => $item->pegarCpf(),
            'celular' => $item->pegarCelular(),
            'telefone' => $item->pegarTelefone(),
            'permissao' => $item->pegarPermissao()

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
