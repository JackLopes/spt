-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01-Set-2018 às 22:51
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsaveis`
--

CREATE TABLE `responsaveis` (
  `id_resp` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `area` varchar(80) DEFAULT NULL,
  `funcao` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `telefone` varchar(40) NOT NULL,
  `id_local` int(11) DEFAULT NULL,
  `responsabilidade` varchar(255) DEFAULT NULL,
  `id_contrato` int(11) NOT NULL,
  `atualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `responsaveis`
--

INSERT INTO `responsaveis` (`id_resp`, `nome`, `area`, `funcao`, `email`, `matricula`, `telefone`, `id_local`, `responsabilidade`, `id_contrato`, `atualizacao`) VALUES
(140, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 217, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(143, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 227, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(144, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 227, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(148, 'Alvaro Esperanceta', 'DIOPE/SUPOP/OPCTA/OPSR1', '', 'alvaro.esperanceta@serpro.gov.br', '09057692', '413593-8366', 229, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(206, 'Antonio Carlos de Oliveira', 'DIRAD/SUPGA/GACCD/GACAD', 'ANALISTA', 'antonio-carlos.oliveira@serpro.gov.br', '21088284', '612021-9865', 230, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(212, 'Antonio Carlos De Oliveira', 'DIRAD/SUPGA/GACCD/GACAD', 'Analista', 'antonio-carlos.oliveira@serpro.gov.br', '21088284', '612021-9865', 231, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(213, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 231, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(215, 'Antonio Carlos De Oliveira', 'DIRAD/SUPGA/GACCD/GACAD', 'Analista', 'antonio-carlos.oliveira@serpro.gov.br', '21088284', '612021-9865', 232, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(221, 'Antonio Carlos De Oliveira', 'DIRAD/SUPGA/GACCD/GACAD', 'Analista', 'antonio-carlos.oliveira@serpro.gov.br', '21088284', '612021-9865', 234, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(252, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 219, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(253, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 219, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(254, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 219, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(255, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 232, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(256, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 232, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(264, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 227, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(265, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 227, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(266, 'Diogo Lucas de Souza', 'DIRAD/SUPGA/GACCD/GACAD', 'TÃ‰CNICO', 'diogo.souza@serpro.gov.br', '21102252', '413593-8292', 227, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(272, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 229, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(273, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 229, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(284, 'Cintia Aparecida Duarte de Lima', ' DIOPE/SUPCD/CDINF/CDARS', 'CHEFE DE DIVISAO', 'cintia-aparecida.lima@serpro.gov.br', '11011726', '112173-1412', 219, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(285, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 218, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(286, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 218, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(287, 'Cintia Aparecida Duarte de Lima', ' DIOPE/SUPCD/CDINF/CDARS', 'CHEFE DE DIVISAO', 'cintia-aparecida.lima@serpro.gov.br', '11011726', '112173-1412', 218, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(299, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 217, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(300, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 217, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(301, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 217, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(307, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 213, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(308, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 213, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(309, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 213, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(310, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 213, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(312, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 212, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(313, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 212, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(314, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 212, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(315, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 212, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(316, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 228, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(317, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 228, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(318, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 228, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(319, 'Antonio Carlos De Oliveira', 'DIRAD/SUPGA/GACCD/GACAD', 'Analista', 'antonio-carlos.oliveira@serpro.gov.br', '21088284', '612021-9865', 228, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(320, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 216, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(321, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 216, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(322, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 216, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(323, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 216, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(324, 'Luciana Dos Santos De Almeida', 'DIOPE/SUPCD/CDINF/CDINR', 'Chefe De Divisao', 'luciana.almeida@serpro.gov.br', '21065691', '2121593336', 216, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(325, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 215, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(326, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 215, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(327, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 215, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(328, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 215, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(334, 'Renato Cesar Barducco Junior', 'DIOPE/SUPCD/CDINF/CDINS', 'Chefe De Divisao', 'renato.barducco@serpro.gov.br', '21080526', '1121731494', 212, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(335, 'Julio Eustaquio Goncalves', 'DIOPE/SUPCD/CDINF/CDINB', 'Chefe De Divisao', 'julio.goncalves@serpro.gov.br', '21063150', '6120219371', 213, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(336, 'Alvaro Esperanceta', 'DIOPE/SUPOP/OPCTA/OPSR1', '', 'alvaro.esperanceta@serpro.gov.br', '09057692', '413593-8366', 215, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(337, 'Christian Patrick Rotava', 'DIOPE/SUPOP/OPCTA/OPSR1', 'SUPERVISOR', 'christian.rotava@serpro.gov.br', '21045631', '413593-8405', 215, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(338, 'Julio Eustaquio Goncalves', 'DIOPE/SUPCD/CDINF/CDINB', 'Chefe De Divisao', 'julio.goncalves@serpro.gov.br', '21063150', '6120219371', 217, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(339, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 221, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(340, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 221, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(342, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 221, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(343, 'Cintia Aparecida Duarte De Lima', ' DIOPE/SUPCD/CDINF/CDARS', 'Chefe De Divisao', 'cintia-aparecida.lima@serpro.gov.br', '11011726', '112173-1412', 221, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(344, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 236, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(345, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 236, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(346, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 236, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(347, 'Leonardo Figueiredo De Souza', 'DIOPE/SUPCD/CDINF/CDINR', '', 'leonardo.figueiredo-souza@serpro.gov.br', '21052743', '2121593571', 236, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(348, 'Marcio Lopes Da Silva', 'DIOPE/SUPCD/CDINF/CDINR', '', 'marcio.silva@serpro.gov.br', '21090238', '2121593710', 236, 'Fiscal Tecnico', 0, '2018-08-16 14:13:32'),
(349, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 236, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(350, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 220, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(351, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 220, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(354, 'Jose Edson Marinho De Sousa', ' DIOPE/SUPCD/CDSPA', 'Gerente  De Departamento', 'jose-edson.sousa@serpro.gov.br', '11013893', '112173-3742', 220, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(355, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 237, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(356, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 237, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(358, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 238, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(359, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 238, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(360, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 238, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(362, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 247, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(363, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 247, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(364, 'Leila Ribeiro Ferreira', 'DIOPE/SUPCD/CDINF/CDARB', 'Chefe De Divisao', 'leila.ferreira@serpro.gov.br', '21058342', '6120217560', 247, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(365, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 247, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(366, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 248, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(367, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 248, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(368, 'Leila Ribeiro Ferreira', 'DIOPE/SUPCD/CDINF/CDARB', 'Chefe De Divisao', 'leila.ferreira@serpro.gov.br', '21058342', '6120217560', 248, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(369, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 248, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(370, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 247, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(371, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 248, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(375, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 249, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(376, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 249, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(377, 'Glauco George Santos Mendes', 'DIOPE/SUPES/ESTAD/ESTIA', '', 'glauco.mendes@serpro.gov.br', '21090815', '6120217874', 249, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(378, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 249, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(379, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 250, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(380, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 250, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(381, 'Glauco George Santos Mendes', 'DIOPE/SUPES/ESTAD/ESTIA', '', 'glauco.mendes@serpro.gov.br', '21090815', '6120217874', 250, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(382, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 250, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(383, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 251, 'Gestora De Contratos', 0, '2018-08-16 14:13:32'),
(384, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 251, 'Fiscal Administrativo Gerencial', 0, '2018-08-16 14:13:32'),
(385, 'Glauco George Santos Mendes', 'DIOPE/SUPES/ESTAD/ESTIA', '', 'glauco.mendes@serpro.gov.br', '21090815', '6120217874', 251, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(386, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 251, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(387, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 249, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(388, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 250, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(389, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 251, 'Fiscal Administrativo', 0, '2018-08-16 14:13:32'),
(392, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 221, 'Gestor Tecnico', 0, '2018-08-16 14:13:32'),
(395, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 252, 'Gestora De Contratos', 0, '2018-08-17 11:24:58'),
(396, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 252, 'Fiscal Administrativo Gerencial', 0, '2018-08-17 11:24:58'),
(397, 'Lourival Fidelis Junior', 'DIOPE/SUPCD/CDINF', 'Gerente De Departamento', 'lourival.fidelis@serpro.gov.br', '21014906', '6120219089', 252, 'Gestor Tecnico', 0, '2018-08-17 11:24:58'),
(398, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 252, 'Fiscal Administrativo', 0, '2018-08-17 11:24:58'),
(399, 'Eduardo Francelino', 'DIRAD/SUPGA/GACCD/GACAD', 'Auxiliar ', 'eduardo.francelino@serpro.gov.br', '21023867', '112173-1166', 217, 'Fiscal Administrativo', 0, '2018-08-17 12:18:14'),
(400, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 241, 'Gestora De Contratos', 0, '2018-08-17 13:14:41'),
(401, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 241, 'Fiscal Administrativo Gerencial', 0, '2018-08-17 13:14:41'),
(402, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 241, 'Gestor Tecnico', 0, '2018-08-17 13:14:41'),
(403, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 241, 'Fiscal Administrativo', 0, '2018-08-17 13:15:47'),
(404, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 242, 'Gestora De Contratos', 0, '2018-08-17 13:18:04'),
(405, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 242, 'Fiscal Administrativo Gerencial', 0, '2018-08-17 13:18:04'),
(406, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 242, 'Gestor Tecnico', 0, '2018-08-17 13:18:04'),
(407, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 242, 'Fiscal Administrativo', 0, '2018-08-17 13:18:04'),
(409, 'Leila Ribeiro Ferreira', 'DIOPE/SUPCD/CDINF/CDARB', 'Chefe De Divisao', 'leila.ferreira@serpro.gov.br', '21058342', '6120217560', 241, 'Fiscal Tecnico', 0, '2018-08-17 13:38:08'),
(411, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 244, 'Gestora De Contratos', 0, '2018-08-20 12:52:57'),
(412, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 244, 'Fiscal Administrativo Gerencial', 0, '2018-08-20 12:52:57'),
(414, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 244, 'Gestor Tecnico', 0, '2018-08-20 13:07:45'),
(415, 'Dario Barbosa Pinheiro Gabriel', 'DIOPE/SUPCD/CDINF/CDINB', '', 'dario.gabriel@serpro.gov.br', '21065187', '612021-95500', 244, 'Fiscal Tecnico', 0, '2018-08-20 13:09:40'),
(416, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 237, 'Gestor Tecnico', 0, '2018-08-20 13:30:49'),
(417, 'Renato Cesar Barducco Junior', 'DIOPE/SUPCD/CDINF/CDINS', 'Chefe De Divisao', 'renato.barducco@serpro.gov.br', '21080526', '1121731494', 237, 'Fiscal Tecnico', 0, '2018-08-20 13:37:24'),
(418, 'Firmino Jose Marinho', 'DIOPE/SUPCD/CDINF/CDINB', '', 'firmino-jose.marinho@serpro.gov.br', '00016527', '612021-9281', 244, 'Fiscal Tecnico', 0, '2018-08-20 13:59:24'),
(419, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 237, 'Fiscal Administrativo', 0, '2018-08-20 17:08:44'),
(421, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 244, 'Fiscal Administrativo', 0, '2018-08-20 17:36:32'),
(422, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 218, 'Fiscal Administrativo', 0, '2018-08-20 20:42:11'),
(423, 'Jackson silva Lopes', 'GACCD/GACAD', 'Tecnico Administrativo', 'jackson.lopes@serpro.gov.br', '21102244', '1158741859+', 220, 'Fiscal Administrativo', 0, '2018-08-21 11:25:35'),
(433, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 255, 'Gestora De Contratos', 0, '2018-08-21 14:12:02'),
(434, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 255, 'Fiscal Administrativo Gerencial', 0, '2018-08-21 14:12:02'),
(435, 'Cintia Aparecida Duarte De Lima', ' DIOPE/SUPCD/CDINF/CDARS', 'Chefe De Divisao', 'cintia-aparecida.lima@serpro.gov.br', '11011726', '112173-1412', 255, 'Gestor Tecnico', 0, '2018-08-21 14:12:03'),
(436, 'Alvaro Esperanceta', 'DIOPE/SUPOP/OPCTA/OPSR1', '', 'alvaro.esperanceta@serpro.gov.br', '09057692', '413593-8366', 255, 'Fiscal Tecnico', 0, '2018-08-21 14:18:40'),
(437, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 253, 'Gestora De Contratos', 0, '2018-08-23 12:33:00'),
(438, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 253, 'Fiscal Administrativo Gerencial', 0, '2018-08-23 12:33:00'),
(439, 'Antonio Celso Xavier Filho', 'DIOPE/SUPCD/CDSPA/CDSRB', '', 'antonio-celso.xavier@serpro.gov.br', '01062468', '612021-9220', 253, 'Gestor Tecnico', 0, '2018-08-23 12:33:00'),
(440, 'Luiz Antonio Honorio', 'DIOPE/SUPCD/CDCTP/CDCPS', 'Chefe De Divisao', 'luiz-antonio.honorio@serpro.gov.br', '11008768', '1121731165', 253, 'Fiscal Tecnico', 0, '2018-08-23 12:58:49'),
(441, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 253, 'Fiscal Administrativo', 0, '2018-08-23 14:22:32'),
(442, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 256, 'Gestora De Contratos', 0, '2018-08-23 15:28:17'),
(443, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 256, 'Fiscal Administrativo Gerencial', 0, '2018-08-23 15:28:17'),
(444, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 256, 'Gestor Tecnico', 0, '2018-08-23 15:28:17'),
(445, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 256, 'Fiscal Administrativo', 0, '2018-08-23 15:28:17'),
(446, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 236, 'Gestor Tecnico', 0, '2018-08-23 19:06:07'),
(447, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 259, 'Gestora De Contratos', 0, '2018-08-27 13:26:43'),
(448, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 259, 'Fiscal Administrativo Gerencial', 0, '2018-08-27 13:26:44'),
(449, 'Ricardo Pchevuzinske Katz', 'DIOPE/SUPCD/CDENA', 'Gerente De Departamento', 'ricardo.katz@serpro.gov.b', '21080429', '11021731794', 259, 'Gestor Tecnico', 0, '2018-08-27 13:26:44'),
(450, 'Jackson Ziemer Carneiro', 'DIRAD/SUPGA/GACCD/GACAD', '', 'jackson.carneiro@serpro.gov.br', '21103682', '4135933139', 259, 'Fiscal Administrativo', 0, '2018-08-27 13:26:44'),
(451, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 257, 'Gestora De Contratos', 0, '2018-08-28 19:31:13'),
(452, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 257, 'Fiscal Administrativo Gerencial', 0, '2018-08-28 19:31:13'),
(453, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 257, 'Gestor Tecnico', 0, '2018-08-28 19:31:13'),
(454, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 258, 'Gestora De Contratos', 0, '2018-08-28 19:34:02'),
(455, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 258, 'Fiscal Administrativo Gerencial', 0, '2018-08-28 19:34:02'),
(456, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 258, 'Gestor Tecnico', 0, '2018-08-28 19:34:02'),
(457, 'Renato Cesar Barducco Junior', 'DIOPE/SUPCD/CDINF/CDINS', 'Chefe De Divisao', 'renato.barducco@serpro.gov.br', '21080526', '1121731494', 218, 'Fiscal Tecnico', 0, '2018-08-30 13:32:57'),
(458, 'Dario Barbosa Pinheiro Gabriel', 'DIOPE/SUPCD/CDINF/CDINB', '', 'dario.gabriel@serpro.gov.br', '21065187', '612021-95500', 219, 'Fiscal Tecnico', 0, '2018-08-30 13:33:27'),
(459, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 261, 'Gestora De Contratos', 0, '2018-08-31 18:57:20'),
(460, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 261, 'Fiscal Administrativo Gerencial', 0, '2018-08-31 18:57:20'),
(461, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 261, 'Gestor Tecnico', 0, '2018-08-31 18:57:20'),
(462, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 261, 'Fiscal Administrativo', 0, '2018-08-31 18:57:20'),
(463, 'Julio Eustaquio Goncalves', 'DIOPE/SUPCD/CDINF/CDINB', 'Chefe De Divisao', 'julio.goncalves@serpro.gov.br', '21063150', '6120219371', 261, 'Fiscal Tecnico', 0, '2018-08-31 18:58:02'),
(464, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 262, 'Gestora De Contratos', 0, '2018-08-31 18:58:14'),
(465, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 262, 'Fiscal Administrativo Gerencial', 0, '2018-08-31 18:58:14'),
(466, 'Plinio Nogueira De Arruda Sampaio', 'DIOPE/SUPCD/CDSAM', 'Gerente De Departamento', 'plinio.sampaio@serpro.gov.br', '21068607', '112173-1594', 262, 'Gestor Tecnico', 0, '2018-08-31 18:58:14'),
(467, 'Nilton  De Jesus', 'DIRAD/SUPGA/GACCD/GACAD', '', 'nilton.jesus@serpro.gov.br', '08178445', '1121731376', 262, 'Fiscal Administrativo', 0, '2018-08-31 18:58:14'),
(468, 'Renato Cesar Barducco Junior', 'DIOPE/SUPCD/CDINF/CDINS', 'Chefe De Divisao', 'renato.barducco@serpro.gov.br', '21080526', '1121731494', 262, 'Fiscal Tecnico', 0, '2018-08-31 18:58:31'),
(483, 'Fernanda Pereira Da Rosa Gomes', 'DIRAD/SUPGA/GACCD', 'Gerente De Departamento', 'fernanda-rosa.gomes@serpro.gov.br', '21063230', '61202178516', 263, 'Gestora De Contratos', 0, '2018-09-01 19:44:02'),
(484, 'Everton Valmir Oliveira Telles', 'DIRAD/SUPGA/GACCD/GACAD', 'Chefe De Divisao', 'everton.telles@serpro.gov.br', '21088268', '1121731415', 263, 'Fiscal Administrativo Gerencial', 0, '2018-09-01 19:44:02'),
(486, 'Christian Patrick Rotava', 'DIOPE/SUPOP/OPCTA/OPSR1', 'Supervisor', 'christian.rotava@serpro.gov.br', '21045631', '413593-8405', 263, 'Fiscal Tecnico', 0, '2018-09-01 19:47:10'),
(505, 'Alvaro Esperanceta', 'DIOPE/SUPOP/OPCTA/OPSR1', '', 'alvaro.esperanceta@serpro.gov.br', '09057692', '413593-8366', 263, 'Fiscal Tecnico', 0, '2018-09-01 20:44:11'),
(507, 'Emerson Luis Rossi', 'DIOPE/SUPCD/CDSAB', 'Gerente De Departamento', 'emerson.rossi@serpro.gov.br', '21027900', '6120217346', 263, 'Fiscal Tecnico', 0, '2018-09-01 20:46:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD PRIMARY KEY (`id_resp`),
  ADD KEY `id_local` (`id_local`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `responsaveis`
--
ALTER TABLE `responsaveis`
  MODIFY `id_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=509;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `responsaveis`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
