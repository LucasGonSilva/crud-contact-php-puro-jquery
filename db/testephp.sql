CREATE DATABASE `testephp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

-- testephp.contatos definition

CREATE TABLE `contatos` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_nome` varchar(255) DEFAULT NULL,
  `con_telefone` varchar(15) NOT NULL,
  `con_cpf` varchar(14) NOT NULL,
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB CHARSET=utf8;