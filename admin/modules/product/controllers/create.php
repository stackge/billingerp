<?php
// controllers/create.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
// ბაზის კავშირის გადაცემა მოდელს
ProductModel::setDb($pdo);

// (დროებით არ გვჭირდება dropdown-ებისთვის ცალკე მონაცემები, მაგრამ თუ დაგჭირდება შემიძლია დავამატო)

// გადადი ფორმის ვიუ გვერდზე
require_once __DIR__ . '/../views/create.php';
