<?php
require_once './db.php';
global $pdo;

/**
 * მიგრაცია: add_users_table
 * თარიღი: 2025_04_06_030206
 */

// მაგალითი:
// 

/**
 * მიგრაცია: მაგ. add_vat_column_to_clients
 * თარიღი: YYYY_MM_DD_HHMMSS
 */

// ✅ ველის დამატება
// ("ALTER TABLE clients ADD COLUMN vat_number VARCHAR(150)");

// ✅ ველის წაშლა
// ("ALTER TABLE clients DROP COLUMN vat_number");

// ✅ ველის ცვლილება (გახანგრძლივება)
// ("ALTER TABLE clients MODIFY COLUMN email VARCHAR(255)");

// ✅ default მნიშვნელობის დამატება
// ("ALTER TABLE clients ALTER COLUMN currency SET DEFAULT 'USD'");

// ✅ ENUM ველის დამატება
// ("ALTER TABLE clients ADD COLUMN status ENUM('active','inactive') DEFAULT 'active'");

// ✅ ინდექსის დამატება
// ("CREATE INDEX idx_email ON clients(email)");

// ✅ უნიკალური ინდექსი
// ("CREATE UNIQUE INDEX unique_email ON clients(email)");

// ✅ ცხრილის შექმნა
/*
("CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    total DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
*/

// ✅ ცხრილის წაშლა
// ("DROP TABLE invoices");

$pdo->query("CREATE TABLE IF NOT EXISTS users (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");