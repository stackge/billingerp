


<?php
// modules/product/controllers/update.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';

ProductModel::setDb($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $data = [
        'name'   => trim($_POST['name']),
        'group'  => trim($_POST['group']),
        'type'   => trim($_POST['type']),
        'url'    => trim($_POST['url']),
        'module' => trim($_POST['module']),
        'hidden' => isset($_POST['hidden']) ? 1 : 0,
    ];

    $success = ProductModel::updateProduct($id, $data);

    if ($success) {
        header("Location: dashboard.php?module=product&action=edit&id=$id&updated=1");
    } else {
        header("Location: dashboard.php?module=product&action=edit&id=$id&updated=0");
    }
    exit;
} else {
    header("Location: dashboard.php?module=product&action=list");
    exit;
}
