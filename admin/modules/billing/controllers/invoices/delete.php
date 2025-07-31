<?php
// კონტროლერი: ინვოისის წაშლა

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\Config;

// ბაზასთან დაკავშირება
InvoicesModel::setDb($pdo);

// GET ID გადამოწმება
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit('არასწორი ID.');
}

$id = (int)$_GET['id'];

// წაშლა
InvoicesModel::deleteInvoice($id);

// გადამისამართება ინვოისების სიაზე

require_once __DIR__ . '/../../views/invoices/list.php';