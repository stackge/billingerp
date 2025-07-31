<?php
require_once './db.php';
global $pdo;

$pdo->query("CREATE TABLE IF NOT EXISTS clients (
    id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    company_name VARCHAR(150) DEFAULT NULL,
    vat_number VARCHAR(150) DEFAULT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address1 VARCHAR(255) DEFAULT NULL,
    address2 VARCHAR(255) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    postcode VARCHAR(20) DEFAULT NULL,
    country VARCHAR(2) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    payment_method VARCHAR(50) DEFAULT NULL,
    billing_contact VARCHAR(100) DEFAULT NULL,
    currency VARCHAR(10) DEFAULT 'USD',
    language VARCHAR(10) DEFAULT 'default',
    status ENUM('active','inactive') DEFAULT 'active',
    client_group VARCHAR(50) DEFAULT 'none',
    created_at TIMESTAMP NULL DEFAULT current_timestamp(),
    admin_notes TEXT DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
