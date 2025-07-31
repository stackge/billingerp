<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/transactionsmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';


TransactionsModel::setDb($pdo);

$id = $_GET['id'] ?? null;

$transaction = TransactionsModel::getTransactionById($id);

if (!$transaction) {
    echo "ტრანზაქცია ვერ მოიძებნა.";
    exit;
}

// შენახვა
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'status' => $_POST['status'],
        'method' => $_POST['method'],
        'notes'  => $_POST['notes'],
    ];

    TransactionsModel::updateTransaction($id, $data);

    header("Location: dashboard.php?module=billing&submodule=transactions&action=list&updated=1");
    exit;
}

require_once __DIR__ . '/../../views/transactions/edit.php';