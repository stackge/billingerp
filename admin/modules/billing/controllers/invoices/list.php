<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Config;

// ვუკავშირებთ ბაზას მოდელს
InvoicesModel::setDb($pdo);

// ინვოისების წამოღება
$invoices = InvoicesModel::getAllInvoices();

// ვიუს ჩატვირთვა
require_once __DIR__ . '/../../views/invoices/list.php';
