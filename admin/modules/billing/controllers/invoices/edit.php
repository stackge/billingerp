<?php
// 📄 რედაქტირება
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

InvoicesModel::setDb($pdo);

// ID შემოწმება
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit('არასწორი ID.');
}

$id = (int)$_GET['id'];

// ინვოისის წამოღება
$invoice = InvoicesModel::getInvoiceById($id);
if (!$invoice) {
    exit('ინვოისი ვერ მოიძებნა.');
}

// სელექტისთვის საჭირო მონაცემები
$clients = InvoicesModel::getClientsList();
$products = InvoicesModel::getProductList();

// ვიუ ჩატვირთვა
require_once __DIR__ . '/../../views/invoices/edit.php';
