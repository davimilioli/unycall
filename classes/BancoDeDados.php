<?php
require_once(__DIR__ . '/../config.php');

class BancoDeDados
{
    private $pdo;

    public function __construct()
    {
        $this->conexao();
    }

    public function conexao()
    {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_charset = DB_CHARSET;
        $db_user = DB_USER;

        try {
            $this->pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Cria o banco
            $this->criarBanco();

            // Faz mais uma conexão
            try {
                $this->pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $mensagemErro) {
                die("Erro de conexão com o banco de dados: <br/>" . $mensagemErro->getMessage());
            }
        }
    }

    public function criarBanco()
    {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_charset = DB_CHARSET;
        $db_user = DB_USER;

        try {
            $pdoTemp = new PDO("mysql:host=$db_host;charset=$db_charset", $db_user);
            $pdoTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
            $pdoTemp->exec($sql);
        } catch (PDOException $e) {
            die("Erro ao criar banco de dados: <br/>" . $e->getMessage());
        }
    }


    public function pegarPdo()
    {
        return $this->pdo;
    }

    public function verificarUsuarioExiste()
    {
        $criarTabelas = true;

        if ($criarTabelas) {
            $sql = $this->pdo->query("SHOW TABLES LIKE 'usuarios'");
            if ($sql->rowCount() == 0) {
                $this->criarBanco();
                $this->criarTabelas();
            }
        }

        return $criarTabelas;
    }

    public function criarTabelas()
    {
        /* USUARIOS */
        $tabelaUsuarios = "CREATE TABLE `usuarios` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nome` varchar(255) NOT NULL,
            `nascimento` date NOT NULL,
            `cpf` varchar(14) NOT NULL,
            `email` varchar(255) NOT NULL,
            `nomematerno` varchar(255) NOT NULL,
            `sexo` char(10) NOT NULL,
            `celular` varchar(15) NOT NULL,
            `telefone` varchar(15) NOT NULL,
            `login` varchar(50) NOT NULL,
            `senha` varchar(255) NOT NULL,
            `permissao` varchar(255),
            `imagem` varchar(255),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $this->pdo->exec($tabelaUsuarios);

        /* ENDEREÇO */
        $tabelaEndereco = "CREATE TABLE `endereco` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_usuario` int(11) NOT NULL,
            `cep` varchar(9) NOT NULL,
            `logradouro` varchar(255) NOT NULL,
            `numero` varchar(10) NOT NULL,
            `bairro` varchar(100) NOT NULL,
            `cidade` varchar(100) NOT NULL,
            `estado` char(2) NOT NULL,
            `complemento` varchar(255),
            PRIMARY KEY (`id`),
            KEY `id_usuario` (`id_usuario`),
            CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->pdo->exec($tabelaEndereco);

        /* PAGAMENTOS */
        $tabelaPagamentos = "CREATE TABLE `pagamentos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_transacao` varchar(255) NOT NULL,
            `nome` varchar(255) NOT NULL,
            `cpf` varchar(50) NOT NULL DEFAULT '',
            `servico_assinado` varchar(255) NOT NULL,
            `preco_servico` float NOT NULL,
            `total` float NOT NULL,
            `data_pagamento` date NOT NULL,
            PRIMARY KEY (`id`) USING BTREE,
            UNIQUE KEY `UNIQUE` (`id_transacao`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->pdo->exec($tabelaPagamentos);

        /* SERVIÇOS */
        $tabelaServicos = "CREATE TABLE `servicos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `tipo` varchar(255) NOT NULL,
            `nome` varchar(255) NOT NULL,
            `disp_regiao` varchar(255) NOT NULL,
            `custo` float NOT NULL,
            `status` INT(1) DEFAULT 0,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->pdo->exec($tabelaServicos);

        /* ASSINATURAS */
        $tabelaAssinaturas = "CREATE TABLE `assinaturas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_usuario` int(11) NOT NULL,
            `id_transacao` varchar(255) NOT NULL,
            `id_servico` int(11) NOT NULL,
            `data_inicio` date NOT NULL,
            `data_expiracao` date NOT NULL,
            PRIMARY KEY (`id`) USING BTREE,
            KEY `id_usuario` (`id_usuario`),
            KEY `id_servico` (`id_servico`),
            KEY `id_pagamento` (`id_transacao`) USING BTREE,
            CONSTRAINT `assinaturas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
            CONSTRAINT `assinaturas_ibfk_2` FOREIGN KEY (`id_transacao`) REFERENCES `pagamentos` (`id_transacao`),
            CONSTRAINT `assinaturas_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $this->pdo->exec($tabelaAssinaturas);

        /* CRIAÇÃO DO USUARIO MASTER */
        $senha = password_hash('admin', PASSWORD_DEFAULT);
        $criarUsuarioMaster = "INSERT INTO usuarios (nome, nascimento, cpf, nomematerno, email, sexo, celular, telefone, login, senha, permissao, imagem) VALUES ('admin','2002-11-28', '21977880448', 'admin', 'admin@gmail.com', 'Masculino', '9378699813', '338018469', 'admin', :senha, 'administrador', '')";
        $sql = $this->pdo->prepare($criarUsuarioMaster);
        $sql->bindParam(':senha', $senha);
        $sql->execute();

        $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE nome = 'admin'");
        $sql->execute();
        $usuarioAdmin = $sql->fetch(PDO::FETCH_ASSOC);

        $criarEndMaster = "INSERT INTO endereco (id_usuario, cep, logradouro, numero, bairro, cidade, estado, complemento) VALUES (:idUsuario, '97601740', 'Rua Alfredo Lima', '42', 'Capixaba', 'Rio De Janeiro', 'casa', 'casa')";
        $sql = $this->pdo->prepare($criarEndMaster);
        $sql->bindValue(':idUsuario', $usuarioAdmin['id']);
        $sql->execute();

        /* CRIAÇÃO DO USUARIO COMUM */
        $senha = password_hash('user', PASSWORD_DEFAULT);
        $criarUsuarioComum = "INSERT INTO usuarios (nome, nascimento, cpf, nomematerno, email, sexo, celular, telefone, login, senha, permissao, imagem) VALUES ('Davi Rafael','2002-08-21', '22222222222', 'Rafael', 'davi@gmail.com', 'Masculino', '5521999999999', '5521888888888', 'user', :senha, '', '')";
        $sql = $this->pdo->prepare($criarUsuarioComum);
        $sql->bindParam(':senha', $senha);
        $sql->execute();

        $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE nome = 'Davi Rafael'");
        $sql->execute();
        $usuarioComum = $sql->fetch(PDO::FETCH_ASSOC);

        $criarEndComum = "INSERT INTO endereco (id_usuario, cep, logradouro, numero, bairro, cidade, estado, complemento) VALUES (:idUsuario, '97601740', 'Rua Alfredo Lima', '42', 'Capixaba', 'Rio De Janeiro', 'casa', 'casa')";
        $sql = $this->pdo->prepare($criarEndComum);
        $sql->bindValue(':idUsuario', $usuarioComum['id']);
        $sql->execute();

        /* CRIAÇÃO DE SERVIÇO PADRÃO */
        $criarServicoPremium = "INSERT INTO `servicos` (`tipo`, `nome`, `disp_regiao`, `custo`, `status`) VALUES
        ('Internet', 'Premium', 'Rio de Janeiro', 155.88, 1)";

        $criarServicoBusiness = "INSERT INTO `servicos` (`tipo`, `nome`, `disp_regiao`, `custo`, `status`) VALUES
        ('Internet', 'Business', 'Rio de Janeiro', 215.88, 1)";

        $criarServicoOpStartup = "INSERT INTO `servicos` (`tipo`, `nome`, `disp_regiao`, `custo`, `status`) VALUES
        ('Internet', 'Optimization Startup', 'Rio de Janeiro', 599.88, 1)";

        $this->pdo->exec($criarServicoPremium);
        $this->pdo->exec($criarServicoBusiness);
        $this->pdo->exec($criarServicoOpStartup);
    }
}
