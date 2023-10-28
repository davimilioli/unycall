<?php

class BancoDados
{
    private $pdo;

    public function __construct()
    {
        $db_host = "localhost";
        $db_name = "db_site";
        $db_charset = "utf8";
        $db_user = "root";

        try {
            $this->pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function pegarPdo()
    {
        return $this->pdo;
    }

    public function desconectar()
    {
        $this->pdo = null;
    }

    public function verificarTabelas()
    {

        $tabelas = array('usuarios', 'endereco', 'pagamentos', 'servicos', 'assinaturas');

        foreach ($tabelas as $tabela) {

            if ($tabela == 'usuarios') {
                $comandoSql = "CREATE TABLE IF NOT EXISTS `usuarios` (
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
                    `permissao` varchar(255) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
            } else if ($tabela == 'endereco') {
                $comandoSql = "CREATE TABLE IF NOT EXISTS `endereco` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_usuario` int(11) NOT NULL,
                    `cep` varchar(9) NOT NULL,
                    `logradouro` varchar(255) NOT NULL,
                    `numero` varchar(10) NOT NULL,
                    `bairro` varchar(100) NOT NULL,
                    `cidade` varchar(100) NOT NULL,
                    `estado` char(2) NOT NULL,
                    `complemento` varchar(255) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    KEY `id_usuario` (`id_usuario`),
                    CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ";
            } else if ($tabela == 'pagamentos') {
                $comandoSql = "CREATE TABLE IF NOT EXISTS `pagamentos` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_transacao` varchar(255) NOT NULL,
                    `nome` varchar(255) NOT NULL,
                    `cpf` varchar(50) NOT NULL DEFAULT '',
                    `servico_assinado` varchar(255) NOT NULL,
                    `preco_servico` varchar(255) NOT NULL,
                    `total` float NOT NULL,
                    `data_pagamento` date NOT NULL,
                    PRIMARY KEY (`id`) USING BTREE,
                    UNIQUE KEY `UNIQUE` (`id_transacao`) USING BTREE
                  ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
            } else if ($tabela == 'servicos') {
                $comandoSql = "CREATE TABLE IF NOT EXISTS `servicos` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `tipo` varchar(255) NOT NULL,
                    `nome` varchar(255) NOT NULL,
                    `disp_regiao` varchar(255) NOT NULL,
                    `custo` float DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ";
            } else if ($tabela == 'assinaturas') {
                $comandoSql = "CREATE TABLE IF NOT EXISTS `assinaturas` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_usuario` int(11) NOT NULL,
                    `id_transacao` varchar(255) NOT NULL,
                    `id_servico` int(11) NOT NULL,
                    PRIMARY KEY (`id`) USING BTREE,
                    KEY `id_usuario` (`id_usuario`),
                    KEY `id_servico` (`id_servico`),
                    KEY `id_pagamento` (`id_transacao`) USING BTREE,
                    CONSTRAINT `assinaturas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
                    CONSTRAINT `assinaturas_ibfk_2` FOREIGN KEY (`id_transacao`) REFERENCES `pagamentos` (`id_transacao`),
                    CONSTRAINT `assinaturas_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
            }

            try {
                $this->pdo->exec($comandoSql);
            } catch (PDOException $e) {
                die("Erro ao criar $tabela " . $e->getMessage());
            }
        }
    }
}
