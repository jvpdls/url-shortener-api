-- Creates the database --
CREATE DATABASE IF NOT EXISTS `urls` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Creates the shortlinks table --
USE `urls`;

CREATE TABLE IF NOT EXISTS `shortlinks` (
    `ID` INT AUTO_INCREMENT PRIMARY KEY,
    `longUrl` TINYTEXT,
    `slug` TINYTEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;