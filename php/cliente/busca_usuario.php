<?php
require_once(__DIR__ . '/Sistema.php');
$sistema = new Sistema($pdo);

$nome = isset($_POST['buscarNome']) ? ucwords($_POST['buscarNome']) : null;
$usuariosEncontrados = array();
$nenhumUsuarioEncontrado = true;

$consulta = $sistema->consultarDadosUsuario();
foreach ($consulta as $dados) {
    if ($nome == $dados->pegarNome()) {

        $return = array(
            'id' => $dados->pegarId(),
            'nome' => $dados->pegarNome(),
            'nascimento' => $dados->pegarNascimento(),
            'cpf' => $dados->pegarCpf(),
            'email' => $dados->pegarEmail(),
            'sexo' => $dados->pegarSexo(),
            'nomematerno' => $dados->pegarNomeMaterno(),
            'celular' => $dados->pegarCelular(),
            'telefone' => $dados->pegarTelefone(),
            'login' => $dados->pegarLogin(),
            'permissao' => $dados->pegarPermissao()
        );
        $usuariosEncontrados[] = $return;
        $nenhumUsuarioEncontrado = false;
    }
}

if ($nenhumUsuarioEncontrado) {
    echo json_encode(['resposta' => 'Nenhum usuário encontrado']);
} else {
    echo json_encode($usuariosEncontrados);
}
