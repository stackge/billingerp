<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Config;

// ბაზასთან დაკავშირება
InvoicesModel::setDb($pdo);

// ID შემოწმება
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "არასწორი ID.";
    exit;
}

$id = (int) $_GET['id'];
$showAlert = isset($_GET['sent']) && $_GET['sent'] == 1;

// ინვოისის წამოღება
$invoice = InvoicesModel::getInvoiceWithClient($id);

if (!$invoice) {
    echo "ინვოისი ვერ მოიძებნა.";
    exit;
}

// პროდუქტის items
$productItems = InvoicesModel::getInvoiceItems($id);

// ვიუ ფაილის ჩატვირთვა
require_once __DIR__ . '/../../views/invoices/view.php';
