<?php
session_start();
require_once('../autoload.php');
$banco = new BancoDeDados();
$sistema = new Sistema($banco->pegarPdo());

$id = $_SESSION['id'];
$permissao = $_SESSION['permissao'];

if ($permissao != 'administrador') {
    header('location: /php/cliente/cliente.php?erroPermissao=true');
    exit;
}

$lista = $sistema->consultarDadosUsuario();

require_once(__DIR__ . '../modulos/modulos.php');

if (isset($_POST['exclude'])) {
    $idExclude = $_POST['exclude'];
    $sistema->deletarDados($idExclude);
    header('location: /php/cliente/lista_usuarios.php');
    exit;
}

/* function listaBusca()
{
    $banco = new BancoDeDados();
    $sistema = new Sistema($banco->pegarPdo());
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

$listaBusca = json_encode(listaBusca()); */

$qtdUsuarios = 10;
$totalPaginas = ceil(count($lista) / $qtdUsuarios);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <title>Unycall - Lista de Usuários</title>
    <link rel="stylesheet" href="/assets/css/css/style.css">
</head>

<body class="system">
    <?php require_once(__DIR__ . '/layout/includes/header.php'); ?>
    <div class="page-cliente">
        <?php require_once(__DIR__ . '/layout/includes/aside.php'); ?>
        <main class="page-cliente-usuarios">
            <div class="category-title">
                <h4>Lista Usuarios</h4>
            </div>
            <section class="list-users">
                <div class="list-users-content">
                    <div class="list-users-title">
                        <h2 class="list-users-count">Total de registros (<?= count($lista) ?>)</h2>
                        <div class="list-users-actions">
                            <div class="form-content">
                                <form action="" class="form">
                                    <div class="form-group">
                                        <input type="text" name="buscarNome" id="buscarNome" placeholder="Digite o nome de usuário">
                                    </div>
                                </form>
                            </div>
                            <a href="gerar_pdf.php" target="_blank" class="btn pdf">
                                <img src="/assets/img/icons/list.svg">
                                Importar Lista
                            </a>
                            <a href="adicionar_usuario.php" class="btn">
                                <img src="/assets/img/icons/plus.svg">
                                Adicionar Usuario
                            </a>
                        </div>
                    </div>
                    <div class="list-users-table-content">
                        <table class="list-users-table">
                            <thead>
                                <tr>
                                    <th class="table-id">#</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Email</th>
                                    <th>Celular</th>
                                    <th>Telefone</th>
                                    <th>Permissão</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody data-qtd-usuarios="<?= $qtdUsuarios ?>">
                                <?php foreach ($lista as $item) : ?>
                                    <tr>
                                        <td class="table-id" title="<?= $item->pegarId() ?>"><?= $item->pegarId() ?></td>
                                        <td title="<?= $item->pegarNome() ?>"><?= $item->pegarNome() ?></td>
                                        <td title="<?= formatarCpf($item->pegarCpf()) ?>"><?= formatarCpf($item->pegarCpf()) ?></td>
                                        <td title="<?= $item->pegarEmail() ?>"><?= $item->pegarEmail() ?></td>
                                        <td title="<?= formatarNumero($item->pegarCelular()) ?>"><?= formatarNumero($item->pegarCelular()) ?></td>
                                        <td title="<?= formatarNumero($item->pegarTelefone()) ?>"><?= formatarNumero($item->pegarTelefone()) ?></td>
                                        <td class="table-permissao" title="<?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?>" id="<?= $item->pegarPermissao() == null ? 'comum' : $item->pegarPermissao() ?>">
                                            <p><?= $item->pegarPermissao() == null ? 'Não Possui' : ucfirst($item->pegarPermissao()) ?></p>
                                        </td>
                                        <td class="table-buttons">
                                            <a class="btn" title="editar <?= $item->pegarNome() ?>" href="/php/cliente/editar_usuario.php?edit=<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/edit.svg">
                                            </a>
                                            <a class="btn secondary" title="excluir <?= $item->pegarNome() ?>" id="excluirUsuario" data-id="<?= $item->pegarId() ?>">
                                                <img src="/assets/img/icons/trash.svg">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($lista) > $qtdUsuarios) : ?>
                        <div class="list-users-pagination">
                            <ul>
                                <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                    <li>
                                        <button type="button" class="page-link <?= $i == 1 ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </button>
                                    </li>
                                <?php endfor ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <div class="modal-exclude"></div>
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/js/cliente.js"></script>
    <script>
        // variavel sendo manipulada no arquivo lista-usuarios.js
        /* const listaUsuariosBd = <?= $listaBusca ?> */
    </script>
    <script src="/assets/js/lista-usuarios.js"></script>
</body>

</html>

<style>

</style>

<?php
function gerarUsuarios()
{
    $banco = new BancoDeDados();
    $usuarioSql = new UsuarioMySql($banco->pegarPdo());
    $enderecoSql = new EnderecoMySql($banco->pegarPdo());
    function gerarNumeroAleatorio()
    {
        $numerosAleatorios = [];
        for ($i = 0; $i < 11; $i++) {
            $gerarNumero = rand(10000000000, 99999999999);
            $numerosAleatorios[] = $gerarNumero;
        }

        $numero = array_rand($numerosAleatorios);
        return $numerosAleatorios[$numero];
    }

    for ($i = 0; $i < 2; $i++) {
        $dados = new Usuario();
        $endereco = new Endereco();

        $dados->setarNome("Nome" . $i);
        $dados->setarNascimento("1990-01-01");
        $dados->setarEmail("email" . $i . "@exemplo.com");

        $dados->setarCpf(gerarNumeroAleatorio() . $i);
        $dados->setarNomeMaterno("Mãe" . $i);
        $dados->setarSexo("Masculino");
        $dados->setarCelular("123456789" . $i);
        $dados->setarTelefone("555987654321" . $i);
        $dados->setarLogin("usuario" . $i);
        $dados->setarSenha("senha" . $i);

        $endereco->setarCepEndereco("11111-370" . $i);
        $endereco->setarLogradouroEndereco("Rua Exemplo " . $i);
        $endereco->setarNumeroEndereco("123");
        $endereco->setarBairroEndereco("Bairro " . $i);
        $endereco->setarCidadeEndereco("Cidade " . $i);
        $endereco->setarEstadoEndereco("UF");
        $endereco->setarComplementoEndereco("Complemento " . $i);

        $usuarioSql->criarUsuario($dados);
        $enderecoSql->criarEndereco($endereco);
    }
}

/* gerarUsuarios(); */

?>