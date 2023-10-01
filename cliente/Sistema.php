<?php

require_once(__DIR__ . '/../config/config_db.php');
require_once(__DIR__ . '/../modelSql/UsuarioMySql.php');
require_once(__DIR__ . '/../modelSql/EnderecoMySql.php');
require_once(__DIR__ . '/../entidade/Usuario.php');
require_once(__DIR__ . '/../entidade/Endereco.php');


class Sistema
{
    private $usuarioSql;
    private $enderecoSql;

    public function __construct($pdo)
    {
        $this->usuarioSql = new UsuarioMySql($pdo);
        $this->enderecoSql = new EnderecoMySql($pdo);
    }

    public function consultarDadosUsuario()
    {
        return $this->usuarioSql->consultaUsuario();
    }

    public function procurarIdUsuario($id)
    {
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
                        'permissao' => $item->pegarPermissao()
                    );
                }
            }

            $dadosEndereco = [];
            foreach ($enderecoDados as $item) {

                if ($id == $item->pegarIdUsuarioEndereco()) {
                    $dadosEndereco  = array(
                        'id_usuario' => $item->pegarIdUsuarioEndereco(),
                        'cep' => $item->pegarCepEndereco(),
                        'logradouro' => $item->pegarLogradouroEndereco(),
                        'numero' => $item->pegarNumeroEndereco(),
                        'bairro' => $item->pegarBairroEndereco(),
                        'cidade' => $item->pegarCidadeEndereco(),
                        'estado' => $item->pegarEstadoEndereco(),
                        'complemento' => $item->pegarComplementoEndereco() ?? null
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
        $usuario->setarCpf(formatarCpf($dadosUsuario['cpf']));
        $usuario->setarNomeMaterno($dadosUsuario['nomematerno']);
        $usuario->setarSexo($dadosUsuario['sexo']);
        $usuario->setarCelular(formatarNumero($dadosUsuario['celular']));
        $usuario->setarTelefone(formatarNumero($dadosUsuario['telefone']));
        $usuario->setarLogin($dadosUsuario['login']);
        $usuario->setarPermissao($dadosUsuario['permissao']);
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
        $endereco->setarComplementoEndereco($dadosEndereco['complemento']);
        $this->enderecoSql->atualizarEndereco($endereco);
    }

    public function deletarDados($id)
    {
        $this->enderecoSql->deletarEndereco($id);
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
        $consultaId = $procurarDados['usuario']['id'];
        if ($consultaId) {

            if ($slug == 'qual-o-nome-da-sua-mae') {
                $nomeMaterno = $procurarDados['usuario']['nomematerno'];
                echo $nomeMaterno;
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
                $cepFormatado = str_replace("-", "", $resposta);
                if ($cep == $cepFormatado) {
                    return true;
                } else {
                    return false;
                }
            } else {
                echo 'Consulta indisponivel';
            }
        }

        return false;
    }
}
