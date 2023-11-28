<?php
require_once('UsuarioMySql.php');
require_once('EnderecoMySql.php');
require_once('Usuario.php');
require_once('Endereco.php');
require_once('Modulos.php');

class Sistema
{
    private $usuarioSql;
    private $enderecoSql;

    public function __construct($pdo)
    {
        $this->usuarioSql = new UsuarioMySql($pdo);
        $this->enderecoSql = new EnderecoMySql($pdo);
    }

    public function verificarPermissao()
    {
        $permissao = $_SESSION['permissao'];
        if ($permissao == 'administrador') {
            return true;
        }

        return false;
    }

    public function consultarDadosUsuario()
    {
        $dados = [];
        $modulos = new Modulos();

        $consultaUsuarios = $this->usuarioSql->consultaUsuario();
        foreach ($consultaUsuarios as $usuarios) {

            $dados[] = array(
                'id' => $usuarios->pegarId(),
                'nome' => $usuarios->pegarNome(),
                'cpf' => $modulos->formatarCpf($usuarios->pegarCpf()),
                'email' => $usuarios->pegarEmail(),
                'celular' => $modulos->formatarNumero($usuarios->pegarCelular()),
                'telefone' => $modulos->formatarNumero($usuarios->pegarTelefone()),
                'permissao' => $usuarios->pegarPermissao() == 'administrador' ? 'Administrador' : 'Não Possui',
                'login' => $usuarios->pegarLogin()
            );
        }

        return $dados;
    }

    public function procurarIdUsuario($id)
    {
        $modulos = new Modulos();
        $consultaId = $this->usuarioSql->consultarId($id);
        $consultaIdUsuarioEndereco = $this->enderecoSql->consultarIdUsuarioEndereco($id);

        $usuarioDados = $this->usuarioSql->consultaUsuario();
        $enderecoDados = $this->enderecoSql->consultaEndereco();

        if ($consultaId && $consultaIdUsuarioEndereco) {

            $dadosUsuario = [];
            foreach ($usuarioDados as $item) {

                if ($id == $item->pegarId()) {
                    $dadosUsuario = array(
                        'id' => $item->pegarId(),
                        'nome' => $item->pegarNome(),
                        'nascimento' => $item->pegarNascimento(),
                        'cpf' => $item->pegarCpf(),
                        'email' => $item->pegarEmail(),
                        'sexo' => $item->pegarSexo(),
                        'nomematerno' => $item->pegarNomeMaterno(),
                        'celular' => $item->pegarCelular(),
                        'telefone' => $item->pegarTelefone(),
                        'login' => $item->pegarLogin(),
                        'permissao' => $item->pegarPermissao(),
                        'imagem' => $item->pegarImagem()
                    );
                }
            }

            $dadosEndereco = [];
            foreach ($enderecoDados as $item) {

                if ($id == $item->pegarIdUsuarioEndereco()) {
                    $dadosEndereco  = array(
                        'id_usuario' => $item->pegarIdUsuarioEndereco(),
                        'cep' => $modulos->formatarCep($item->pegarCepEndereco()),
                        'logradouro' => $item->pegarLogradouroEndereco(),
                        'numero' => $item->pegarNumeroEndereco(),
                        'bairro' => $item->pegarBairroEndereco(),
                        'cidade' => $item->pegarCidadeEndereco(),
                        'estado' => $item->pegarEstadoEndereco(),
                        'complemento' => $item->pegarComplementoEndereco() ?? ''
                    );
                }
            }

            return array(
                'usuario' => $dadosUsuario,
                'endereco' => $dadosEndereco
            );
        }
    }

    public function atualizarDadosUsuario($dadosUsuario)
    {
        $usuario = new Usuario();
        $usuario->setarId($dadosUsuario['id']);
        $usuario->setarNome($dadosUsuario['nome']);
        $usuario->setarNascimento($dadosUsuario['nascimento']);
        $usuario->setarEmail($dadosUsuario['email']);
        $usuario->setarCpf($dadosUsuario['cpf']);
        $usuario->setarNomeMaterno($dadosUsuario['nomematerno']);
        $usuario->setarSexo($dadosUsuario['sexo']);
        $usuario->setarCelular($dadosUsuario['celular']);
        $usuario->setarTelefone($dadosUsuario['telefone']);
        $usuario->setarLogin($dadosUsuario['login']);
        $usuario->setarPermissao($dadosUsuario['permissao'] ?? '');
        $this->usuarioSql->atualizarUsuario($usuario);
    }

    public function atualizarDadosEndereco($dadosEndereco)
    {
        $endereco = new Endereco();
        $endereco->setarIdUsuarioEndereco($dadosEndereco['id_usuario']);
        $endereco->setarCepEndereco($dadosEndereco['cep']);
        $endereco->setarLogradouroEndereco($dadosEndereco['logradouro']);
        $endereco->setarNumeroEndereco($dadosEndereco['numero']);
        $endereco->setarBairroEndereco($dadosEndereco['bairro']);
        $endereco->setarCidadeEndereco($dadosEndereco['cidade']);
        $endereco->setarEstadoEndereco($dadosEndereco['estado']);
        $endereco->setarComplementoEndereco($dadosEndereco['complemento'] ?? '');
        $this->enderecoSql->atualizarEndereco($endereco);
    }

    public function deletarDados($id)
    {
        if ($this->enderecoSql->deletarEndereco($id)) {
            $this->usuarioSql->deletarUsuario($id);
        }
    }

    public function pegarPergunta()
    {
        $perguntas = array(
            'qual-o-nome-da-sua-mae' => 'Qual o nome da sua mae?',
            'qual-a-data-do-seu-nascimento' => 'Qual a data do seu nascimento?',
            'qual-o-cep-do-seu-endereco' => 'Qual o CEP do seu endereço'
        );

        $slugAleatoria = array_rand($perguntas);
        $perguntaAleatoria = $perguntas[$slugAleatoria];
        return array(
            'pergunta' => $perguntaAleatoria,
            'slug' => $slugAleatoria
        );
    }

    public function consultarResposta($id, $slug, $resposta)
    {
        $procurarDados = $this->procurarIdUsuario($id);
        if ($slug == 'qual-o-nome-da-sua-mae') {
            $nomeMaterno = $procurarDados['usuario']['nomematerno'];
            if ($nomeMaterno == $resposta) {
                return true;
            } else {
                return false;
            }
        } elseif ($slug == 'qual-a-data-do-seu-nascimento') {
            $nascimento = $procurarDados['usuario']['nascimento'];
            $respostaFormatada = date("Y-m-d", strtotime(str_replace("/", "-", $resposta)));
            if ($nascimento == $respostaFormatada) {
                return true;
            } else {
                return false;
            }
        } elseif ($slug == 'qual-o-cep-do-seu-endereco') {
            $cep = $procurarDados['endereco']['cep'];
            if ($cep == $resposta) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function esqueceuSenha($login, $email)
    {
        $consultarLogin = $this->usuarioSql->consultaUnicaUsuario('login', $login);
        $consultarEmail = $this->usuarioSql->consultaUnicaUsuario('email', $email);

        if ($consultarLogin['resposta'] && $consultarEmail['resposta']) {
            return $consultarLogin['id']->pegarId();
        } else {
            return false;
        }
    }

    public function verificarSenhaConta(array $senha)
    {
        if ($this->usuarioSql->verificarSenha($senha['senhaAtual'], $senha['id'])) {
            $usuario = new Usuario();
            $usuario->setarSenha($senha['senhaNova']);
            $usuario->setarId($senha['id']);
            $this->usuarioSql->alterarSenha($usuario);
            return true;
        } else {
            return false;
        }
    }

    public function enviarAlteracaoLogin($login, $id)
    {
        $this->usuarioSql->alterarLogin($login, $id);
    }

    public function receberSenha($id, $senha)
    {
        $usuario = new Usuario();
        $usuario->setarId($id);
        $usuario->setarSenha($senha);

        $this->usuarioSql->alterarSenha($usuario);
        return true;
    }

    public function validarCadastro(array $cadastro)
    {
        $erro = '';
        if ($this->usuarioSql->consultarCpf($cadastro['cpf']) === false) {
            $dados = new Usuario();
            $dados->setarNome($cadastro['nome']);
            $dados->setarNascimento($cadastro['nascimento']);
            $dados->setarEmail($cadastro['email']);
            $dados->setarCpf($cadastro['cpf']);
            $dados->setarNomeMaterno($cadastro['nomematerno']);
            $dados->setarSexo($cadastro['sexo']);
            $dados->setarCelular($cadastro['celular']);
            $dados->setarTelefone($cadastro['telefone']);
            $dados->setarLogin($cadastro['login']);
            $dados->setarSenha($cadastro['senha']);
            $dados->setarPermissao($cadastro['permissao'] ?? '');
            $dados->setarImagem($cadastro['imagem'] ?? '');
            $this->usuarioSql->criarUsuario($dados);

            $endereco = new Endereco();
            $endereco->setarCepEndereco($cadastro['cep']);
            $endereco->setarLogradouroEndereco($cadastro['logradouro']);
            $endereco->setarNumeroEndereco($cadastro['numero']);
            $endereco->setarBairroEndereco($cadastro['bairro']);
            $endereco->setarCidadeEndereco($cadastro['cidade']);
            $endereco->setarEstadoEndereco($cadastro['estado']);
            $endereco->setarComplementoEndereco($cadastro['complemento'] ?? '');
            $this->enderecoSql->criarEndereco($endereco);

            return true;
        } else {
            $erro = 'CPF já existe!';
        }

        return $erro;
    }

    public function validarLogin($login, $senha, $tipoLogin)
    {
        $consultarDados = $this->usuarioSql->consultarDadosLogin($login, $senha, $tipoLogin);
        $erro = '';
        if ($consultarDados && $consultarDados['resposta']) {
            $_SESSION['id'] = $consultarDados['id'];
            $_SESSION['permissao'] = $consultarDados['permissao'];

            $permissao = $consultarDados['permissao'];

            if ($tipoLogin == 'administrador' && $permissao == 'administrador') {
                header('location:' . CAMINHO_PADRAO . '/cliente/cliente.php');
                exit;
            } elseif ($tipoLogin == 'administrador' && $permissao != 'administrador') {
                $erro = 'Você não tem permissão';
            } elseif ($tipoLogin == 'normal' && $permissao == '') {
                header('location:' . CAMINHO_PADRAO . '/cliente/dois_fatores.php');
                exit;
            } elseif ($tipoLogin == 'normal' && $permissao == 'administrador') {
                $erro = 'Você precisa entrar como administrador';
            }
        } else {
            $erro = 'Usuario ou senha incorretos';
        }

        return $erro;
    }

    public function fazerUpload($id, $imagem)
    {
        $erroImagem = '';

        if ($imagem['name'] == '') {
            $erroImagem = 'É necessário anexar uma imagem';
            return $erroImagem;
        }

        $tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png'];
        $verificarTipo = array_search($imagem['type'], $tiposPermitidos, true);

        if ($verificarTipo === false) {
            $erroImagem = 'Tipo de arquivo não permitido';
            return $erroImagem;
        }

        $nomeImagem = md5(time() . rand(0, 100)) . '.' . str_replace('image/', '', $imagem['type']);
        $caminhoPastaImagem = __DIR__ . '../../assets/perfil/';

        if (!file_exists($caminhoPastaImagem)) {
            if (!mkdir($caminhoPastaImagem, 0777, true) && !is_dir($caminhoPastaImagem)) {
                $erroImagem = 'Erro ao criar pasta';
                return $erroImagem;
            }
        }

        if (move_uploaded_file($imagem['tmp_name'], $caminhoPastaImagem . $nomeImagem)) {
            $usuario = new Usuario();
            $usuario->setarId($id);
            $usuario->setarImagem($nomeImagem);
            $this->usuarioSql->salvarImagem($usuario);

            header('location:' . CAMINHO_PADRAO . '/cliente/informacoes_conta.php');
            exit;
            return true;
        } else {
            $erroImagem = 'Erro ao anexar imagem';
            return $erroImagem;
        }
    }

    public function enviarExclusaoImagem($id, $imagem)
    {
        $this->usuarioSql->excluirImagem($id);
        $caminhoPastaImagem = __DIR__ . '../../assets/perfil/';
        unlink($caminhoPastaImagem . $imagem);
        header('location:' . CAMINHO_PADRAO . '/cliente/informacoes_conta.php');
        exit;
    }
}
