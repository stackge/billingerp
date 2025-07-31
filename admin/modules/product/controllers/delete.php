<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';

ProductModel::setDb($pdo);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    ProductModel::deleteProductById($id);
}

header("Location: dashboard.php?module=product&action=list&deleted=1");
exit;
