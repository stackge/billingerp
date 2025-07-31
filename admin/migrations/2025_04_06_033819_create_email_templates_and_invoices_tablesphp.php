<?php
require_once './db.php';
global $pdo;

// 📨 email_templates ცხრილის შექმნა
$pdo->query("
CREATE TABLE IF NOT EXISTS `email_templates` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `created_at` DATETIME NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");

// 🧾 invoices ცხრილის შექმნა
$pdo->query("
CREATE TABLE IF NOT EXISTS `invoices` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `invoice_number` VARCHAR(100) DEFAULT NULL,
    `client_id` INT(11) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `payment_method` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('დრაფტი','გადაუხდელი','გადასახდელი','გადახდილი','გაუქმებული') NOT NULL DEFAULT 'დრაფტი',
    `total_amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `is_recurring` TINYINT(1) DEFAULT '0',
    `issue_date` DATE NOT NULL,
    `due_date` DATE NOT NULL,
    `payment_date` DATE DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT current_timestamp(),
    `recurring` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `invoice_number` (`invoice_number`),
    INDEX `client_id` (`client_id`),
    CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");
