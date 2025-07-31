<?php
require_once './db.php';
global $pdo;

$pdo->query("CREATE TABLE IF NOT EXISTS `email_logs` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `client_id` INT(11) NOT NULL,
    `subject` VARCHAR(255) NULL DEFAULT NULL,
    `message` TEXT NULL DEFAULT NULL,
    `sent_at` DATETIME NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `client_id` (`client_id`) USING BTREE,
    CONSTRAINT `email_logs_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");