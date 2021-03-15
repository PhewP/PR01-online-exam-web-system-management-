-- Version del servidor: 8.0.17
-- Version de PHP: 7.3.10
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "Europe/Madrid";

-- --
-- Base de datos: `uca101`
-- --

-- CREATE DATABASE IF NOT EXISTS `uca101`
CREATE DATABASE `uca101`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;
USE `uca101`;

CREATE TABLE `Usuario` (
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_EstadoProyecto` INT NOT NULL,
     FOREIGN KEY (`id_EstadoProyecto`) REFERENCES EstadoProyecto(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT, 
	`id_Cientifico` INT NOT NULL,
	`id_Expediente` INT NOT NULL,
	`id_Instalacion` INT NOT NULL,
	`codigo` VARCHAR(20) NOT NULL,
	`fechaInicio` datetime NOT NULL DEFAULT NOW(),
	`fechaFin` datetime DEFAULT NULL,
	`horasTotales` FLOAT DEFAULT '0',
	`presupuesto` FLOAT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
