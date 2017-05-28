-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Pon 29. kvě 2017, 00:02
-- Verze serveru: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- Verze PHP: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `netteweb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prefix_tree_menu`
--

CREATE TABLE `prefix_tree_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT 'nazev',
  `id_parent` int(11) DEFAULT NULL COMMENT 'vazba na rodice',
  `position` int(11) DEFAULT '0' COMMENT 'poradi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stromove menu';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_tree_menu`
--
ALTER TABLE `prefix_tree_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tree_menu_idx` (`id_parent`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_tree_menu`
--
ALTER TABLE `prefix_tree_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_tree_menu`
--
ALTER TABLE `prefix_tree_menu`
  ADD CONSTRAINT `fk_tree_menu` FOREIGN KEY (`id_parent`) REFERENCES `prefix_tree_menu` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
