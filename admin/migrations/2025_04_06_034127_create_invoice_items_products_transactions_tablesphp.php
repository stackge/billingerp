<?php
require_once './db.php';
global $pdo;

// 💳 invoice_items ცხრილის შექმნა
$pdo->query("
CREATE TABLE IF NOT EXISTS `invoice_items` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `invoice_id` INT(11) NOT NULL,
    `product_id` INT(11) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    PRIMARY KEY (`id`),
    INDEX `invoice_id` (`invoice_id`),
    CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");

// 📋 migration_log ცხრილის შექმნა (თუ არ გაქვს უკვე)
$pdo->query("
CREATE TABLE IF NOT EXISTS `migration_log` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) DEFAULT NULL,
    `executed_at` DATETIME DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");

// 📦 products ცხრილის შექმნა
$pdo->query("
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `group` VARCHAR(255) NOT NULL,
    `type` VARCHAR(100) DEFAULT NULL,
    `pay_type` VARCHAR(100) DEFAULT NULL,
    `auto_setup` VARCHAR(100) DEFAULT NULL,
    `url` TEXT DEFAULT NULL,
    `module` VARCHAR(100) DEFAULT NULL,
    `hidden` TINYINT(1) DEFAULT '0',
    `created_at` DATETIME DEFAULT current_timestamp(),
    `updated_at` DATETIME DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");

// 💰 transactions ცხრილის შექმნა
$pdo->query("
CREATE TABLE IF NOT EXISTS `transactions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `invoice_id` INT(11) NOT NULL,
    `client_id` INT(11) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `method` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('success','failed','pending') NOT NULL DEFAULT 'pending',
    `notes` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    INDEX `invoice_id` (`invoice_id`),
    INDEX `client_id` (`client_id`),
    CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE,
    CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");
