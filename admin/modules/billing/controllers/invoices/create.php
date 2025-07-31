<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';



InvoicesModel::setDb($pdo);

// ინვოისის ნომრის გენერაცია
$generatedInvoiceNumber = InvoicesModel::generateNextInvoiceNumber();

// კლიენტების სია dropdown-სთვის
$clients = InvoicesModel::getClientsList();

// პროდუქტების სია
$products = InvoicesModel::getProductList();

require_once __DIR__ . '/../../views/invoices/create.php';

?>