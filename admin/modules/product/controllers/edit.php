<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

ProductModel::setDb($pdo);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container-xl mt-4'><div class='alert alert-danger'>ID არ არის სწორი.</div></div>";
    exit;
}

$id = (int) $_GET['id'];
$product = ProductModel::getProductById($id);

if (!$product) {
    echo "<div class='container-xl mt-4'><div class='alert alert-danger'>პროდუქტი ვერ მოიძებნა.</div></div>";
    exit;
}

$tab = $_GET['tab'] ?? 'details';

require_once __DIR__ . '/../views/edit.php';
