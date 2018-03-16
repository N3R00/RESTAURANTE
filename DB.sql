-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.28-MariaDB - Source distribution
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela food.cdcai000
CREATE TABLE IF NOT EXISTS `cdcai000` (
  `caicod` int(11) NOT NULL AUTO_INCREMENT,
  `caival` double(10,2) NOT NULL DEFAULT '0.00',
  `caidatab` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `caidatfc` datetime NOT NULL,
  `caist` int(1) NOT NULL DEFAULT '0' COMMENT '0 = aberto | 1 = fechado',
  `caiusu` int(11) NOT NULL DEFAULT '0',
  `cailoja` int(11) NOT NULL,
  PRIMARY KEY (`caicod`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COMMENT='Caixa';

-- Copiando dados para a tabela food.cdcai000: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cdcai000` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdcai000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdcom000
CREATE TABLE IF NOT EXISTS `cdcom000` (
  `com_cod` int(11) NOT NULL AUTO_INCREMENT,
  `com_vnd` int(11) NOT NULL DEFAULT '0',
  `com_usu` int(11) DEFAULT NULL,
  `com_prod_nome` varchar(50) DEFAULT NULL,
  `com_prod` int(11) DEFAULT NULL,
  `com_qnt` int(11) DEFAULT NULL,
  `com_val_unit` double(10,2) DEFAULT NULL,
  `com_data` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`com_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pré cadastro dos produtos na mesa';

-- Copiando dados para a tabela food.cdcom000: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cdcom000` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdcom000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdloj000
CREATE TABLE IF NOT EXISTS `cdloj000` (
  `loj_cod` int(11) NOT NULL AUTO_INCREMENT,
  `loj_nome` varchar(50) DEFAULT '0',
  PRIMARY KEY (`loj_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela food.cdloj000: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cdloj000` DISABLE KEYS */;
INSERT INTO `cdloj000` (`loj_cod`, `loj_nome`) VALUES
	(1, 'RESTAURANTE'),
	(2, 'QUIOSQUE'),
	(3, 'BARZINHO');
/*!40000 ALTER TABLE `cdloj000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdmesa000
CREATE TABLE IF NOT EXISTS `cdmesa000` (
  `mesa_cod` int(11) NOT NULL,
  `mesa_status` int(11) DEFAULT '1',
  `mesa_loja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='MEsas';

-- Copiando dados para a tabela food.cdmesa000: ~23 rows (aproximadamente)
/*!40000 ALTER TABLE `cdmesa000` DISABLE KEYS */;
INSERT INTO `cdmesa000` (`mesa_cod`, `mesa_status`, `mesa_loja`) VALUES
	(1, 1, 1),
	(2, 1, 1),
	(3, 1, 1),
	(4, 1, 1),
	(5, 1, 1),
	(6, 1, 1),
	(7, 1, 1),
	(8, 1, 1),
	(9, 1, 1),
	(10, 1, 1),
	(11, 1, 1),
	(12, 1, 1),
	(13, 1, 1),
	(14, 1, 1),
	(15, 1, 1),
	(16, 1, 1),
	(17, 1, 1),
	(18, 1, 1),
	(19, 1, 1),
	(1, 1, 2),
	(2, 1, 2),
	(3, 1, 2),
	(1, 1, 3),
	(2, 1, 3);
/*!40000 ALTER TABLE `cdmesa000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdprod000
CREATE TABLE IF NOT EXISTS `cdprod000` (
  `prod_cod` int(11) NOT NULL AUTO_INCREMENT,
  `prod_nome` varchar(50) NOT NULL,
  `prod_qnt` varchar(50) NOT NULL,
  `prod_valor_unit` double(10,2) NOT NULL DEFAULT '0.00',
  `prod_loja` int(11) NOT NULL,
  PRIMARY KEY (`prod_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Produtos';

-- Copiando dados para a tabela food.cdprod000: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `cdprod000` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdprod000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdstat000
CREATE TABLE IF NOT EXISTS `cdstat000` (
  `status_cod` int(11) NOT NULL AUTO_INCREMENT,
  `status_nome` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`status_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Status';

-- Copiando dados para a tabela food.cdstat000: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `cdstat000` DISABLE KEYS */;
INSERT INTO `cdstat000` (`status_cod`, `status_nome`) VALUES
	(1, 'LIVRE'),
	(2, 'OCUPADA'),
	(3, 'EM FECHAMENTO');
/*!40000 ALTER TABLE `cdstat000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdusu000
CREATE TABLE IF NOT EXISTS `cdusu000` (
  `usucod` int(11) NOT NULL AUTO_INCREMENT,
  `usunom` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `usuusu` varchar(50) NOT NULL DEFAULT '0',
  `ususen` varchar(50) NOT NULL DEFAULT '0',
  `usuniv` int(11) NOT NULL DEFAULT '0' COMMENT '1 = GARÇON | 2 = CAIXA',
  `usuloja` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usucod`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='USuarios';

-- Copiando dados para a tabela food.cdusu000: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `cdusu000` DISABLE KEYS */;
INSERT INTO `cdusu000` (`usucod`, `usunom`, `usuusu`, `ususen`, `usuniv`, `usuloja`) VALUES
	(1, 'CAIXA 1', 'cx1', 'cx1', 2, 1),
	(2, 'GARÇON 1', 'g1', 'g1', 1, 1),
	(3, 'CAIXA 2', 'cx2', 'cx2', 2, 2),
	(4, 'GARÇON 2', 'g2', 'g2', 1, 2),
	(5, 'GARÇON 3', 'g3', 'g3', 1, 3),
	(6, 'CAIXA 1', 'cx3', 'cx3', 2, 3);
/*!40000 ALTER TABLE `cdusu000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdvnd000
CREATE TABLE IF NOT EXISTS `cdvnd000` (
  `vnd_cod` int(11) NOT NULL AUTO_INCREMENT,
  `vnd_mesa` int(11) NOT NULL,
  `vnd_usu` int(11) NOT NULL,
  `vnd_total` double(10,2) NOT NULL,
  `vnd_caixa` int(11) NOT NULL,
  `vnd_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vnd_loja` int(11) NOT NULL,
  `vnd_enc` char(1) DEFAULT NULL,
  PRIMARY KEY (`vnd_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COMMENT='Venda e abertura de mesa';

-- Copiando dados para a tabela food.cdvnd000: ~18 rows (aproximadamente)
/*!40000 ALTER TABLE `cdvnd000` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdvnd000` ENABLE KEYS */;

-- Copiando estrutura para tabela food.cdvnd00p
CREATE TABLE IF NOT EXISTS `cdvnd00p` (
  `vnd_cod` int(11) NOT NULL,
  `vnd_recno` int(11) NOT NULL AUTO_INCREMENT,
  `vnd_prod_nome` varchar(50) NOT NULL DEFAULT '0',
  `vnd_prod` int(11) NOT NULL DEFAULT '0',
  `vnd_qnt` int(11) NOT NULL DEFAULT '0',
  `vnd_val_unit` double(10,2) NOT NULL DEFAULT '0.00',
  `vnd_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vnd_recno`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=latin1 COMMENT='Produtos da venda';

-- Copiando dados para a tabela food.cdvnd00p: ~39 rows (aproximadamente)
/*!40000 ALTER TABLE `cdvnd00p` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdvnd00p` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
